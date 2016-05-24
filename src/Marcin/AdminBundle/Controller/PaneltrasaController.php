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

class PaneltrasaController extends Controller {
    
    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_paneltrasa_update",
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
            'zaplacono' => $Request->request->get('zaplacono')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setStatus('zrealizowane/odebrane');
        $Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_paneltrasa",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page) {
        
        $queryParams = array(
            'userLike' => $Request->query->get('userLike'),
            'status' => $status
            //'limit' => $Request->query->get('limit'),
        );
        $RepoZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $statistics = $RepoZam->getStatisticsPaneltrasa();

        $qb = $RepoZam->getQueryPaneltrasaBuilder($queryParams);

        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(15, 20, 30, 50, 100);

        $limit = $Request->query->get('limit', $paginationLimit);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);

        $statusesList = array(
            'Poniedziałek' => 'poniedzialek',
            'Wtorek' => 'wtorek',
            'Środa' => 'sroda',
            'Czwartek' =>'czwartek',
            'Piątek' =>'piatek',
            'Tarnów' =>'tarnow',
            'Tadeusz' =>'tadeusz',
            'Odbiór' =>'odbior',
            'Salon' =>'salon',
            'Tuchowska' =>'tuchowska',
            'Montaż' =>'montaz',
            'Wysyłka' =>'wysylka',
            'Wszystkie' => 'all'
        );
        return $this->render('MarcinAdminBundle:Paneltrasa:index.html.twig', array(
                    'pageTitle' => 'GM Panel trasy',
                    //'articles' => $articles,
                    //'pagination' => $pagination,
                    'queryParams' => $queryParams,
                    'limits' => $limits,
                    'currLimit' => $limit,
                    'statusesList' => $statusesList,
                    'currStatus' => $status,
                    'statistics' => $statistics,
                    'pagination' => $pagination,
                    'currStatus' => $status
                        )
        );
    }
    
}