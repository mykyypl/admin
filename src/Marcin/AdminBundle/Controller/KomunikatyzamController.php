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
use Marcin\AdminBundle\Entity\Komunikatyzamowienia;
use Marcin\AdminBundle\Entity\Username;
use Marcin\AdminBundle\Form\Type\KomunikatyzamowieniaType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class KomunikatyzamController extends Controller {
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_komunikatyzam_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Komunikatyzamowienia $Uzytkownicy = NULL) {
        if (null == $Uzytkownicy) {
            $Uzytkownicy = new Komunikatyzamowienia();
            $newUzytkownicyForm = TRUE;
        }

        $form = $this->createForm(new KomunikatyzamowieniaType(), $Uzytkownicy);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Uzytkownicy);
            $em->flush();
            $message = (isset($newUzytkownicyForm)) ? 'Poprawnie dodano.' : 'Komunikat został zaaktualizowany.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_komunikatyzam_form', array(
                                'id' => $Uzytkownicy->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Komunikatyzamowienia:form.html.twig', array(
                    'pageTitle' => (isset($newUzytkownicyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja komunikatu</small>'),
                    'currPage' => 'komunikaty',
                    'form' => $form->createView(),
                    'uzytkownicy' => $Uzytkownicy,
                        )
        );
    }

    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_komunikatyzam",
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
     
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Komunikatyzamowienia');

        $qb = $StatUser->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        return $this->render('MarcinAdminBundle:Komunikatyzamowienia:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Komunikaty',
            //'articles' => $articles,
           //'pagination' => $pagination,
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statistics' => $statistics,
            'pagination' => $pagination
            //'updateTokenName' => $this->updateTokenName,
           // 'aktywacjaTokenName' => $this->aktywacjaTokenName,
           // 'deleteTokenName' => $this->deleteTokenName,
           // 'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
}