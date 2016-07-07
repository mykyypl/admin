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
use Marcin\AdminBundle\Entity\Roletkinazwa;
use Marcin\AdminBundle\Form\Type\RoletkinazwaType;
use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class RoletkinazwaController extends Controller {
    
    private $deleteTokenName = 'delete-okno-%d';
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_roletkinazwa_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Roletkinazwa $Uzytkownicy = NULL) {
        if (null == $Uzytkownicy) {
            $Uzytkownicy = new Roletkinazwa();
            $newUzytkownicyForm = TRUE;
        }
        
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RoletkinazwaType(), $Uzytkownicy);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Uzytkownicy);
            $em->flush();
            $message = (isset($newUzytkownicyForm)) ? 'Poprawnie dodano.' : 'Okno zostało zaaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_roletkinazwa', array(
                                'id' => $Uzytkownicy->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Roletki:form.html.twig', array(
                    'pageTitle' => (isset($newUzytkownicyForm) ? 'Okna <small>utwórz nowy</small>' : 'Okna <small>edycja roletek nazw</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'okna' => $Uzytkownicy
                        )
        );
    }
    
    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_roletkinazwa",
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
            'userLike' => $Request->query->get('userLike'),

        ); 
     
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Roletkinazwa');

        $qb = $StatUser->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);

        return $this->render('MarcinAdminBundle:Roletki:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Roletkinazwa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'pagination' => $pagination,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *      "/usun/{id}/{token}", 
     *      name="marcin_admin_roletkinazwa_delete",
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
            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Roletkinazwa')->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Zamid);
            $em->flush();

          //  $query = $em->createQuery("DELETE MarcinAdminBundle:Produkty c WHERE c.id_zam = '$id'");
          //  $query->execute();

            $this->addFlash('success', 'Poprawnie usunięto!');
        }

        return $this->redirect($this->generateUrl('marcin_admin_roletkinazwa'));
    }
    
}