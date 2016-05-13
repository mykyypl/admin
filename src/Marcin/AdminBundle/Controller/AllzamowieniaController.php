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
use Marcin\SiteBundle\Entity\Shoperzamowienia;
use Marcin\SiteBundle\Entity\Shoperklinar;
use Marcin\AdminBundle\Form\Type\ShoperType;
use Marcin\AdminBundle\Form\Type\KlinarType;
use Marcin\AdminBundle\Form\Type\KlinarpType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class AllzamowieniaController extends Controller {
    
    private $klinar_stat;
    private $invest_stat;
    private $partner_stat;
    private $selena_stat;
    private $hanno_stat;
    private $awax_stat;
    private $zygmar_stat;
    private $vip_stat;

    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_allzam",
     *       requirements={"page"="\d+"},
     *      defaults={"status"="dowyslania", "page"=1}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request,$status ,$page) {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ZAM')) {
                 return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
         }
        
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),
            'status' => $status    
        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
        $statistics = $StatZam->getStatisticsAllzam();
        
        $qb = $StatZam->getAllzamBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            //'Nowe' => 'nowe',
            'Do wysłania' => 'dowyslania',
            'Wysłane' => 'wyslane',
            'Zrealizowane' => 'zrealizowane'
           // 'Wszystkie' => 'all'
        );
        
        if (!isset($this->klinar_stat)) {
            $this->klinar_stat = $StatZam->getKlinar_stat();
        }
        if (!isset($this->invest_stat)) {
            $this->invest_stat = $StatZam->getInvest_stat();
        }
        if (!isset($this->partner_stat)) {
            $this->partner_stat = $StatZam->getPartner_stat();
        }
        if (!isset($this->selena_stat)) {
            $this->selena_stat = $StatZam->getSelena_stat();
        }
        if (!isset($this->hanno_stat)) {
            $this->hanno_stat = $StatZam->getHanno_stat();
        }
        if (!isset($this->awax_stat)) {
            $this->awax_stat = $StatZam->getAwax_stat();
        }
        if (!isset($this->zygmar_stat)) {
            $this->zygmar_stat = $StatZam->getZygmar_stat();
        }
        if (!isset($this->vip_stat)) {
            $this->vip_stat = $StatZam->getVip_stat();
        }
        
        return $this->render('MarcinAdminBundle:Allzam:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia wszystkie',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status,
                    'klinar_stat' => array(
                        'count' => $this->klinar_stat
                    ),
                    'invest_stat' => array(
                        'count' => $this->invest_stat
                    ),
                    'partner_stat' => array(
                        'count' => $this->partner_stat
                    ),
                    'selena_stat' => array(
                        'count' => $this->selena_stat
                    ),
                    'hanno_stat' => array(
                        'count' => $this->hanno_stat
                    ),
                    'awax_stat' => array(
                        'count' => $this->awax_stat
                    ),
                    'zygmar_stat' => array(
                        'count' => $this->zygmar_stat
                    ),
                    'vip_stat' => array(
                        'count' => $this->vip_stat
                    )
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
}