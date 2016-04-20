<?php

/*
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Marcin\SiteBundle\Entity\Shoperzamowienia;
use Marcin\SiteBundle\Entity\Shoperklinar;

class KlinarController extends Controller {
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_site_klinar_form",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Template()
     */
    public function formAction(Request $Request, Shoperzamowienia $Shoper = NULL) {
        
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_site_klinar",
     *       requirements={"page"="\d+"},
     *       defaults={"status"="all", "page"=1}
     * )
     *    
     * @Template()
     */
    
    public function indexAction(Request $Request,$status ,$page)
    {
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),
            'status' => $status
        ); 
     
        $KlinarZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
        //$statistics = $KlinarZam->getStatistics();
        
        $qb = $KlinarZam->getKlinarBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        $statusesList = array(
            'Nowe' => 'nowe',
            'Zrealizowane' => 'zrealizowane',
            'Wszystkie' => 'all'
        );
        
        return $this->render('MarcinSiteBundle:Klinar:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Klinar',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'pagination' => $pagination,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status
                )
        );
        
    }
    
}