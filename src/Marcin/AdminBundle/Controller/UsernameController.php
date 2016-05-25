<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Marcin\AdminBundle\Entity\Username;
use Marcin\AdminBundle\Entity\Trasa;
use Marcin\AdminBundle\Entity\Faktura;
use Marcin\AdminBundle\Entity\Produkty;
use Marcin\AdminBundle\Entity\Adresdostawa;
use Marcin\AdminBundle\Entity\Zamowienia;

use Marcin\AdminBundle\Form\Type\UzytkownicyType;

class UsernameController extends Controller {
    
    private $updateTokenName = 'update-user-%d';
    private $aktywacjaTokenName = 'aktywacja-user-%d';
    private $deleteTokenName = 'delete-user-%d';
    
    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_username_update_trasa",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateZamAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'status' => $Request->request->get('status')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setTrasa($result['status']);
        $em->flush();
        
        return new JsonResponse(true);

    }
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_username_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Username $Uzytkownicy = NULL) {
        if (null == $Uzytkownicy) {
            $Uzytkownicy = new Username();
            $newUzytkownicyForm = TRUE;
        }

        $form = $this->createForm(new UzytkownicyType(), $Uzytkownicy);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Uzytkownicy);
            $em->flush();
            $message = (isset($newUzytkownicyForm)) ? 'Poprawnie dodano.' : 'Użytkownik został zaaktualizowany.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_username', array(
                                'id' => $Uzytkownicy->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Username:form.html.twig', array(
                    'pageTitle' => (isset($newUzytkownicyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja użytkownika</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'uzytkownicy' => $Uzytkownicy,
                        )
        );
    }
    
    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_username",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * 
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $page)
    {
      
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),

        ); 
     
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $qb = $StatUser->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            'Opublikowane' => 'published',
            'Nieopublikowane' => 'unpublished',
            'Wszystkie' => 'all'
        );
        
        $nip_query = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Faktura', 'a')
                 ->getQuery()
                 ->getResult();
        $a = 0;$b = 0;
         foreach ($nip_query as $nip)
         {
             $dane[$a++]['nip'] = $nip->GetNip();
             $dane[$b++]['user'] = $nip->GetUser();
         }
        
        return $this->render('MarcinAdminBundle:Username:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel USER',
            //'articles' => $articles,
           //'pagination' => $pagination,
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
           // 'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                'dane' => $dane,
            'updateTokenName' => $this->updateTokenName,
            'aktywacjaTokenName' => $this->aktywacjaTokenName,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *      "/update/{id}/{token}", 
     *      name="marcin_admin_username_update",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function updateAction($id, $token) {
        
        $tokenName = sprintf($this->updateTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->addFlash('error', 'Niepoprawny token akcji.');
            
        }else{
          
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("UPDATE MarcinAdminBundle:Username c SET c.new = '0' WHERE c.id = '$id'");
            $query->execute(); 
            
            $this->addFlash('success', 'Poprawnie odczytano.');
        }
        
        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
    
    /**
     * @Route(
     *      "/aktywacja/{id}/{token}", 
     *      name="marcin_admin_username_aktywacja",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function aktywacjaAction($id, $token) {
        
        $tokenName = sprintf($this->aktywacjaTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->addFlash('error', 'Niepoprawny token akcji.');
            
        }else{
          
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("UPDATE MarcinAdminBundle:Username c SET c.aktywacja = 'tak' WHERE c.id = '$id'");
            $query->execute(); 
            
            $this->addFlash('success', 'Poprawnie aktywowano konto.');
        }
        
        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
    
    /**
     * @Route(
     *      "/usun/{id}/{username}/{token}", 
     *      name="marcin_admin_username_delete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @Template()
     */
    public function deleteAction($id, $username, $token) {

        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');

        if (!$csrfProvider->isCsrfTokenValid($tokenName, $token)) {
            $this->addFlash('error', 'Niepoprawny token akcji.');
        } else {

//            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
            $em = $this->getDoctrine()->getManager();
//            $em->remove($Zamid);
//            $em->flush();

//            $Proid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Produkty')->findOneBy(array('id_zam' => $id));
//            $em1 = $this->getDoctrine()->getManager();
//            if (!$Proid) {
//             throw $this->createNotFoundException(
//            'No product found for id '.$id
//                );
//            }
//            foreach ($Proid as $Proids) {
//            $em1->remove($Proids);
//            }
//            $em1->remove($Proid);
//            $em1->flush();
            //$em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("DELETE MarcinAdminBundle:Produkty c WHERE c.user = '$username'");
            $query->execute();
            $query_dane = $em->createQuery("DELETE MarcinAdminBundle:Adresdostawa c WHERE c.user = '$username'");
            $query_dane->execute();
            $query_faktura = $em->createQuery("DELETE MarcinAdminBundle:Faktura c WHERE c.user = '$username'");
            $query_faktura->execute();
            $query_zamowienia = $em->createQuery("DELETE MarcinAdminBundle:Zamowienia c WHERE c.user = '$username'");
            $query_zamowienia->execute();
            $query_username = $em->createQuery("DELETE MarcinAdminBundle:Username c WHERE c.login = '$username'");
            $query_username->execute();

            $this->addFlash('success', 'Poprawnie usunięto użytkownika z powiązaniami!.');
        }

        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
}