<?php

/*
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Marcin\AdminBundle\Entity\Zamowienia;
use Marcin\AdminBundle\Entity\Username;
use Marcin\AdminBundle\Form\Type\TestType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DashboardController extends Controller {

    private $deleteTokenName = 'delete-zam-%d';

    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_dashboard_update",
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
            'status' => $Request->request->get('status'),
           // 'username' => $Request->request-get('username'),
            'zaplacono' => $Request->request->get('zaplacono'),
            'price' => $Request->request->get('price'),
            'login' => $Request->request->get('login'),
            'produkcja' =>$Request->request->get('produkcja')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['status'] == NULL && $result['price'] == NULL && $result['produkcja'] == NULL)
        {
        $em = $this->getDoctrine()->getManager();
        //$Zamowienie->setStatus($result['status']);
        $Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        }
        elseif ($result['status'] == NULL && $result['zaplacono'] == NULL && $result['produkcja'] == NULL) {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setDozaplaty($result['price']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
            $em->flush();
            /////////////////////////////////////// WYSYŁANIE WIADOMOŚCI EMAIL
//            try {
//                $userE = $result['login'];
//                 //$em = $this->getDoctrine()->getManager();
//        
//        $userEmail = $em->createQueryBuilder()
//                ->select('a.email')
//                ->from('MarcinAdminBundle:Username', 'a')
//                 ->where('a.login = :identifier')
//                 ->setParameter('identifier', $userE)
//                ->setMaxResults(1)
//                ->getQuery()
//                ->getOneOrNullResult();
//
//                $userManager = $this->get('user_manager');
//                $userManager->registerUsername($userEmail);
//            }
//            catch (UserException $exc) {
//                    $this->addFlash('error', $exc->getMessage());
//                }
            /////////////////////////////////////// KONIEC WYSYŁANIA WIADOMOŚCI EMAIL
        }
        elseif ($result['status'] == NULL && $result['zaplacono'] == NULL && $result['price'] == NULL) 
         {
             $em = $this->getDoctrine()->getManager();
            $Zamowienie->setNrprodukcji($result['produkcja']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
            $em->flush();
         }
        else
        {
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setStatus($result['status']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        if($result['status'] == "anulowane")
            {
            
            try {
                    $userE = $result['login'];
                     //$em = $this->getDoctrine()->getManager();

            $userEmail = $em->createQueryBuilder()
                    ->select('a.email')
                    ->from('MarcinAdminBundle:Username', 'a')
                     ->where('a.login = :identifier')
                     ->setParameter('identifier', $userE)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

                    $userManager = $this->get('user_manager');
                    $userManager->anulowanieZamowienia($userEmail);
                }
                catch (UserException $exc) {
                        $this->addFlash('error', $exc->getMessage());
                    }
            }
        }
        return new JsonResponse(true);


//        if (NULL === $Zamowienie) {
//            return new Response(false);
//        } else {
//
//            //                    'id' =>$entity->getId(),
////                    'zaplacono' => $entity->getZaplacono(),
////                    'status' => $entity->getStatus(),
//        }
//        $em = $this->getDoctrine()->getManager();
//        
//        $entity = $em->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
//        
//        if(!$entity) {
//            throw $this->createNotForundException('Nie można zrealizować żądania!');
//        }
//        
//        $editForm = $this->createForm(new UpdatezamType(), $entity);
//        $editForm->bind($Request);
//        
//        if($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//            
//            if($Request->isXmlHttpRequest()){
//                $json = json_encode(array(
//                    'id' =>$entity->getId(),
//                    'zaplacono' => $entity->getZaplacono(),
//                    'status' => $entity->getStatus(),
//                ));
//                
//                $response = new Response($json);
//                $response->headers->set('Content-Type', 'application/json');
//                return $response;
//            }
//            
//            return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
//        }
//        
//        return array(
//            'zamowienia' => $entity,
//            'form' =>$editForm->createView(),
//                        'csrfProvider' => $this->get('form.csrf_provider'),
//        );
    }
    
    /**
     * @Route("/form/update-complete/produkcja", 
     *       name="marcin_admin_dashboard_update_wykonano",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateWykoAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'wykonano' => $Request->request->get('wykonano')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['wykonano'] == '1')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('wyprodukowane');
            $em->flush();
        } else if($result['wykonano'] == '0')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w realizacji');
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/realizacja", 
     *       name="marcin_admin_dashboard_update_realizacja",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateRealizacjaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w realizacji');
            $em->flush();
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/lock/lock", 
     *       name="marcin_admin_dashboard_update_lock",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateLockAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'locknew' => $Request->request->get('locknew')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['locknew'] == "lock")
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZamowienie(null);
            $Zamowienie->setZakonczone(null);
            $em->persist($Zamowienie);
            $em->flush();
        }
        elseif ($result['locknew'] == "unlock")
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZamowienie('1');
            $Zamowienie->setZakonczone('1');
            $em->persist($Zamowienie);
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/realizacjadel", 
     *       name="marcin_admin_dashboard_update_realizacjadel",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateRealizacjadelAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('anulowane');
            $em->flush();
        
        return new JsonResponse(true);
    }

    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_dashboard_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * 
     * @Template()
     */
    public function formAction(Request $Request, Zamowienia $Zamowienia = NULL) {
        if (null == $Zamowienia) {
            $Zamowienia = new Zamowienia();
            $newZamowieniaForm = TRUE;
        }

        $form = $this->createForm(new TestType(), $Zamowienia);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Zamowienia);
            $em->flush();
            $message = (isset($newZamowieniaForm)) ? 'Poprawnie dodano.' : 'Zamowienie zostało zaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_dashboard', array(
                                'id' => $Zamowienia->getId()
            )));
        }
        
        return $this->render('MarcinAdminBundle:Admin:form.html.twig', array(
                    'pageTitle' => (isset($newZamowieniaForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja zamowienia</small>'),
                    'currPage' => 'zamowienia',
                    'form' => $form->createView(),
                    'zamowienia' => $Zamowienia,
                        )
        );
    }

    private $status_new_zam;
    private $status_send_zam;
    private $new_user_stat;
    private $new_many;
    private $zrelmany;
    private $suma;
    private $zrelsuma;
    private $suma_wyprodukowane;

    /**
     * @Route(
     *       "/{trasy}/{status}/{page}",
     *       name="marcin_admin_dashboard",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1, "trasy"="all"}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page, $trasy) {
//        $queryParams = array(
//            'userLike' => $Request->query->get('userLike')
//        );
//        
//        $RepoSlider = $this->getDoctrine()->getRepository('MarcinAdminBundle:Test');
//        $statistics = $RepoSlider->getStatistics();
//        
//        $qb = $RepoSlider->getQueryBuilder($queryParams);
//        $em = $this->getDoctrine()->getManager();
//        
//        $articles = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinAdminBundle:Zamowienia', 'a')
//                ->addOrderBy('a.createDate','DESC')
//                ->getQuery()
//                ->getResult();

//        $usr= $this->get('security.token_storage')->getToken()->getUser();
//        foreach ($usr->getRoles() as $test)
//            {
//                if($test == "ROLE_ZAM")
//                    {
//                       return $this->redirect($this->generateUrl('marcin_admin_allzam'));
//                    }
//            }

//        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_PROD', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN')) {
//             return $this->redirect($this->generateUrl('marcin_admin_allzam'));
//        }
                if (false === $this->get('security.authorization_checker')->isGranted('ROLE_PROD')) {
                 return $this->redirect($this->generateUrl('marcin_admin_allzam'));
         }
        
        $queryParams = array(
            'userLike' => $Request->query->get('userLike'),
            'status' => $status,
            'trasy' => $trasy,
            //'limit' => $Request->query->get('limit'),
        );

//        $em = $this->getDoctrine()
//                ->getManager();
//
//        $articles = $em->getRepository('MarcinAdminBundle:Zamowienia')
//                ->getStatistics();
//        
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//        $articles,
//        $Request->query->get('page', 1)/*page number*/,
//        10/*limit per page*/
//    );
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');
        $RepoZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $statistics = $RepoZam->getStatistics();

        $qb = $RepoZam->getQueryBuilder($queryParams);

        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(15, 20, 30, 50, 100);

        $limit = $Request->query->get('limit', $paginationLimit);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $em = $this->getDoctrine()->getManager();
        $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Produkty', 'a')
                ->addOrderBy('a.id', 'DESC')
                ->setMaxResults(800) //USTAWIENIE OPTYMALIZSUJE WYŚWIETLANIE ZAMOWIENIEŃ NA STRONIE GŁÓWNEJ PANELU!
                 ->getQuery()
                 ->getResult();     
         $a = 0;$b = 0;$c = 0; $d = 0; $e = 0;
         foreach ($produkty_query as $prod)
         {
             $daneprodukty[$a++]['idzam'] = $prod->GetIdzam();
             $daneprodukty[$b++]['typ'] = $prod->GetTyp();
             $daneprodukty[$c++]['kolor'] = $prod->GetKolor();
             $daneprodukty[$d++]['szer'] = $prod->GetSzerokosca();
             $daneprodukty[$e++]['wysokosc'] = $prod->GetWysokosch();
         }

        $statusesList = array(
            'Przesłane' => 'przeslane',
            'W realizacji' => 'realizacja',
            'Wyprodukowane' => 'wyprodukowane',
            'Zrealizowane' =>'zrealizowane',
            'Wszystkie' => 'all'
        );
        $trasyList = array(
            'Poniedziałek' => 'poniedzialek',
            'Wtorek' => 'wtorek',
            'Środa' => 'sroda',
            'Czwartek' =>'czwartek',
            'Piątek' => 'piatek',
            'Tarnów' => 'tarnow',
            'Tadeusz' => 'tadeusz',
            'Odbiór' => 'odbior',
            'Salon' => 'salon',
            'Tuchowska' => 'tuchowska',
            'Montaż' => 'montaz',
            'Wysyłka' => 'wysylka',
            'Wszystkie' => 'all'
        );
        if (!isset($this->status_new_zam)) {
            $this->status_new_zam = $RepoZam->getNewzam();
        }
        if (!isset($this->status_send_zam)) {
            $this->status_send_zam = $RepoZam->getSendzam();
        }
        if (!isset($this->new_user_stat)) {
            $this->new_user_stat = $StatUser->getUserstat();
        }
        if (!isset($this->new_many)) {
            $this->new_many = $RepoZam->getMany();
        }
        if (!isset($this->zrelmany)) {
            $this->zrelmany = $RepoZam->getZrelmany();
        }
        if (!isset($this->suma)) {
            $this->suma = $RepoZam->getSuma();
        }
        if (!isset($this->zrelsuma)) {
            $this->zrelsuma = $RepoZam->getZrelsuma();
        }
        if (!isset($this->suma_wyprodukowane)) {
            $this->suma_wyprodukowane = $RepoZam->getWyprodukowane();
        }
        
        //$data1 = new \DateTime('- 30 days');
        //echo $data1->format('Y-m-d');

        return $this->render('MarcinAdminBundle:Admin:index.html.twig', array(
                    'pageTitle' => 'GM Panel',
                    //'articles' => $articles,
                    //'pagination' => $pagination,
                    'queryParams' => $queryParams,
                    'limits' => $limits,
                    'currLimit' => $limit,
                    'statusesList' => $statusesList,
                    'trasyList' => $trasyList,
                    //'currStatus' => $status,
                    'statistics' => $statistics,
                    'pagination' => $pagination,
                    'currStatus' => $status,
                    'currTrasy' => $trasy,
                    'produkty' => $daneprodukty,
                    'deleteTokenName' => $this->deleteTokenName,
                    'csrfProvider' => $this->get('form.csrf_provider'),
                    'new_zam' => array(
                        'count' => $this->status_new_zam
                    ),
                    'new_user' => array(
                        'count' => $this->new_user_stat
                    ),
                    'new_many' => array(
                        'count' => $this->new_many
                    ),
                    'zrelmany' => array(
                        'count' => $this->zrelmany
                    ),
                    'suma' => array(
                        'count' => $this->suma
                    ),
                    'zrelsuma' => array(
                        'count' => $this->zrelsuma
                    ),
                    'suma_wyprodukowane' => array(
                        'count' => $this->suma_wyprodukowane
                    ),
                    'send_zam' => array(
                        'count' => $this->status_send_zam
                    )
                        )
        );
    }

    /**
     * @Route(
     *      "/usun/{id}/{token}", 
     *      name="marcin_admin_dashboard_delete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @Template()
     */
    public function deleteAction($id, $token) {

        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');

        if (!$csrfProvider->isCsrfTokenValid($tokenName, $token)) {
            $this->addFlash('error', 'Niepoprawny token akcji.');
        } else {

            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Zamid);
            $em->flush();

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
            $query = $em->createQuery("DELETE MarcinAdminBundle:Produkty c WHERE c.id_zam = '$id'");
            $query->execute();

            $this->addFlash('success', 'Poprawnie usunięto zamówienie.');
        }

        return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
    }

//        * @Template("MarcinAdminBundle:Admin:update.html.twig")
}
