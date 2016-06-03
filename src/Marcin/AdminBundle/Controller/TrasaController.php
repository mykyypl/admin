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
use Marcin\AdminBundle\Entity\Nrlistu;

use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class TrasaController extends Controller {
    
    private $pon;
    private $wto;
    private $sro;
    private $czw;
    private $pia;
    private $tar;
    private $tad;
    private $odb;
    private $sal;
    private $tuch;
    private $mon;
    private $wys;
    
    /**
     * @Route("/trasa/gen/update-complete", 
     *       name="marcin_admin_trasa_update",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updatetrasaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'zaznaczono' => $Request->request->get('zaznaczono')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        } else {
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setTrasaok($result['zaznaczono']);

        $em->flush();
        }
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_trasa_update_trasa",
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

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
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
     * @Route("/wys/wysylka/update-complete-wys", 
     *       name="marcin_admin_trasa_update_wysylka",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updatewysylkaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'nrlistu' => $Request->request->get('nrlistu')
        );

         if (NULL === $result['nrlistu']) {
               return new JsonResponse(false);
         } else {
            $em = $this->getDoctrine()->getManager();
            $nr = new Nrlistu();
            $nr->setNr($result['nrlistu']);
            $nr->setIdzam($result['id']);
            $em->persist($nr);
            $em->flush();
         }
        
       // $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $Zamowienie = $RepoZamowienia->find($result['id']);

//        if (NULL === $Zamowienie) {
//            return new JsonResponse(false);
//        } else {
//        $em = $this->getDoctrine()->getManager();
//        $Zamowienie->setTrasaok($result['zaznaczono']);
//
//        $em->flush();
//        }
        return new JsonResponse(true);
    }
        
    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_trasa",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        if (!isset($this->pon)) {
            $this->pon = $StatZam->getPon();
        }
        if (!isset($this->wto)) {
            $this->wto = $StatZam->getWto();
        }if (!isset($this->sro)) {
            $this->sro = $StatZam->getSro();
        }if (!isset($this->czw)) {
            $this->czw = $StatZam->getCzw();
        }if (!isset($this->pia)) {
            $this->pia = $StatZam->getPia();
        }if (!isset($this->tar)) {
            $this->tar = $StatZam->getTar();
        }if (!isset($this->tad)) {
            $this->tad = $StatZam->getTad();
        }if (!isset($this->odb)) {
            $this->odb = $StatZam->getOdb();
        }if (!isset($this->sal)) {
            $this->sal = $StatZam->getSal();
        }if (!isset($this->tuch)) {
            $this->tuch = $StatZam->getTuch();
        }if (!isset($this->mon)) {
            $this->mon = $StatZam->getMon();
        }if (!isset($this->wys)) {
            $this->wys = $StatZam->getWys();
        }
        
        return $this->render('MarcinAdminBundle:Trasa:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                'pon' => array(
                        'count' => $this->pon
                    ),
                'wto' => array(
                        'count' => $this->wto
                    ),
                'sro' => array(
                        'count' => $this->sro
                    ),
                'czw' => array(
                        'count' => $this->czw
                    ),
                'pia' => array(
                        'count' => $this->pia
                    ),
                'tar' => array(
                        'count' => $this->tar
                    ),
                'tad' => array(
                        'count' => $this->tad
                    ),
                'odb' => array(
                        'count' => $this->odb
                    ),
                'sal' => array(
                        'count' => $this->sal
                    ),
                'tuch' => array(
                        'count' => $this->tuch
                    ),
                'mon' => array(
                        'count' => $this->mon
                    ),
                'wys' => array(
                        'count' => $this->wys
                    )
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "poniedzialek/trasa/{page}",
     *       name="marcin_admin_trasa_poniedzialek",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function poniedzialekAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaPoniedzialekBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "poniedzialek"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "wtorek/trasawtorek/{page}",
     *       name="marcin_admin_trasa_wtorek",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function wtorekAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaWtorekBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "wtorek"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "sroda/trasasroda/{page}",
     *       name="marcin_admin_trasa_sroda",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function srodaAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaSrodaBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "sroda"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "czwartek/trasaczwartek/{page}",
     *       name="marcin_admin_trasa_czwartek",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function czwartekAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaCzwartekBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                'trasastat' => "czwartek"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "piatek/trasapiatek/{page}",
     *       name="marcin_admin_trasa_piatek",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function piatekAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaPiatekBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "piatek"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "tarnow/trasatarnow/{page}",
     *       name="marcin_admin_trasa_tarnow",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function tarnowkAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaTarnowBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "tarnow"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "tadeusz/trasatadeusz/{page}",
     *       name="marcin_admin_trasa_tadeusz",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function tadeuszAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaTadeuszBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "tadeusz"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "odbior/trasaodbior/{page}",
     *       name="marcin_admin_trasa_odbior",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function odbiorAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaOdbiorBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "odbior"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "salon/trasasalon/{page}",
     *       name="marcin_admin_trasa_salon",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function salonAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaSalonBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "salon"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "tuchowska/trasatuchowska/{page}",
     *       name="marcin_admin_trasa_tuchowska",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function tuchowskaAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaTuchowskaBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "tuchowska"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "montaz/trasamontaz/{page}",
     *       name="marcin_admin_trasa_montaz",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function montazAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaMontazBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "montaz"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "wysylka/trasawysylka/{page}",
     *       name="marcin_admin_trasa_wysylka",
     *       requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function wysylkaAction(Request $Request ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaWysylkaBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        return $this->render('MarcinAdminBundle:Trasa:poniedzialek.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statusesList' => $statusesList,
            //'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                 'trasastat' => "wysylka"
            //'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "generowanie/trasy/{trasastat}",
     *       name="marcin_admin_trasa_generowanie"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function generowanieAction(Request $Request, $trasastat) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getTrasaPoniedzialekBuilder($queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();

        $zamowienia_query = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.trasa = :identifier')
                 ->setParameter('identifier', $trasastat)
                 ->andwhere('a.status = :status OR a.status = :przyjete')
                 ->setParameter('status', 'wyprodukowane')
                 ->setParameter('przyjete', 'przyjęte')
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                  ->addOrderBy('a.nrprodukcji', 'ASC')
                 ->getQuery()
                 ->getResult();
        
         if ($zamowienia_query == null) {
             $this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
              return $this->redirect($this->generateUrl('marcin_admin_trasa'));
           
        } else {
        //$sprwadzam = array();
         $a = 0;$b = 0;$c = 0;$d = 0;$e = 0;$f = 0;$g = 0;$h = 0;
         $a1 = 0;$b1 = 0;$c1 = 0;$d1 = 0;$e1 = 0;$f1 = 0;$g1 = 0;$h1 = 0;
         $aa = 0;$bb = 0; $cc = 0;$dd = 0;$ee = 0;$ff = 0;
         $aaa = 0; $bbb = 0; $ccc = 0; $ddd = 0; $eee = 0; $fff = 0; $ggg = 0;
        foreach ($zamowienia_query as $zamowienia)
        {
             $dostawa = $zamowienia->getIddost();
            $query_zliczanie1 = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Adresdostawa p
            WHERE p.id = :poniedzialek'
        )->setParameter('poniedzialek', $dostawa);
        $trasa_zliczanie1 = $query_zliczanie1->getResult();
        $uzytkonik = $trasa_zliczanie1[0]->GetUser();
        $dane[$a++]['user'] = $trasa_zliczanie1[0]->GetUser();
        $dane[$b++]['ulica'] = $trasa_zliczanie1[0]->GetUlica();
        $dane[$c++]['kod'] = $trasa_zliczanie1[0]->GetKodpocztowy();
        $dane[$d++]['miejscowosc'] = $trasa_zliczanie1[0]->GetMiejscowowsc();
        $dane[$e++]['telefon'] = $trasa_zliczanie1[0]->GetTelefon();
        $dane[$f++]['nazwa'] = $trasa_zliczanie1[0]->GetNazwafirmy();
       //s $dane[$h++]['trasa'] = $trasa_zliczanie1[0]->GetTrasa();
        $dane[$g++]['id'] = $dostawa;
        
        $produkty[$a1++]['nruser'] = $zamowienia->GetNr_user_zam();
        $produkty[$b1++]['dostawa'] = $zamowienia->GetIddost();
        $produkty[$c1++]['platnosc'] = $zamowienia->GetPlatnosc();
        $produkty[$d1++]['nrprodukcji'] = $zamowienia->GetNrprodukcji();
        $produkty[$e1++]['dozaplaty'] = $zamowienia->GetDozaplaty();
        $produkty[$f1++]['jakiezam'] = $zamowienia->GetJakie_zam();
        $produkty[$h1++]['zaplacono'] = $zamowienia->GetZaplacono();
        $produkty[$g1++]['id'] = $zamowienia->GetId();
        $id_zam = $zamowienia->GetId();
        
        $query_zliczanie2 = $em->createQuery(
            'SELECT a
            FROM MarcinAdminBundle:Produkty a
            WHERE a.id_zam = :idzam'
        )->setParameter('idzam', $id_zam);
        $trasa_zliczanie2 = $query_zliczanie2->getResult();
            foreach ($trasa_zliczanie2 as $lista)
            {
                $lista_prod[$aa++]['idzam'] = $lista->GetIdzam();
                $lista_prod[$bb++]['typ'] = $lista->GetTyp();
                $lista_prod[$cc++]['kolor'] = $lista->GetKolor();
                $lista_prod[$dd++]['szera'] = $lista->GetSzerokosca();
                $lista_prod[$ee++]['szerb'] = $lista->GetSzerokoscb();
                $lista_prod[$ff++]['wysh'] = $lista->GetWysokosch();
            }
            $query_zliczanie3 = $em->createQuery(
            'SELECT a
            FROM MarcinAdminBundle:Faktura a
            WHERE a.user = :idzam'
        )->setParameter('idzam', $uzytkonik);
        $trasa_zliczanie3 = $query_zliczanie3->getResult();
       foreach ($trasa_zliczanie3 as $fakturaa)
            {
                $faktura[$aaa++]['nazwafirmy'] = $fakturaa->GetNazwafirmy();
                $faktura[$bbb++]['telefon'] = $fakturaa->GetTelefon();
                $faktura[$ccc++]['miasto'] = $fakturaa->GetMiasto();
                $faktura[$ddd++]['ulica'] = $fakturaa->GetUlica();
                $faktura[$eee++]['kodpocztowy'] = $fakturaa->GetKodpocztowy();
                $faktura[$fff++]['nip'] = $fakturaa->GetNip();
                $faktura[$ggg++]['user'] = $fakturaa->GetUser();
            }
        
       
        //$produkty[$g1++]['id'] = $dostawa;
        }
        $dane = array_map("unserialize", array_unique(array_map("serialize", $dane)));
        $faktura = array_map("unserialize", array_unique(array_map("serialize", $faktura)));
        //echo "testttttttttttt";
        //print_r($lista_prod);
        }
        return $this->render('MarcinAdminBundle:Trasa:generowanie.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
                'trasa' => $trasa,
                'dane'=> $dane,
                'produkty' => $produkty,
                'lista' => $lista_prod,
                'status' => $trasastat,
                'faktura' => $faktura
                )
        );
    }
    
//    
//        /**
//     * @Route(
//     *       "generowanie/trasy",
//     *       name="marcin_admin_trasa_generowanie"
//     * )
//     * @Security("has_role('ROLE_ZAM')")
//     *    
//     * @Template()
//     */
//    public function generowanieAction(Request $Request) {
//        $queryParams = array(
//            'idzamLike' => $Request->query->get('idzamLike')
//
//        ); 
//     
//        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
//       // $statistics = $StatZam->getStatisticszygmar();
//        
//        $qb = $StatZam->getTrasaPoniedzialekBuilder($queryParams);
//        
//        $em = $this->getDoctrine()->getManager();
//        $query = $em->createQuery(
//            'SELECT p
//            FROM MarcinAdminBundle:Trasa p'
//        );
//
//        $trasa = $query->getResult();
//
//        $zamowienia_query = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinAdminBundle:Zamowienia', 'a')
//                 ->where('a.trasa = :identifier')
//                 ->setParameter('identifier', 'poniedzialek')
//                 ->getQuery()
//                 ->getResult();
//        
//         if ($zamowienia_query == null) {
//             $this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
//           
//        } else {
//        //$sprwadzam = array();
//         $a = 0;$b = 0;$c = 0;$d = 0;$e = 0;$f = 0;$g = 0;
//         $a1 = 0;$b1 = 0;$c1 = 0;$d1 = 0;$e1 = 0;$f1 = 0;$g1 = 0;
//        foreach ($zamowienia_query as $zamowienia)
//        {
//             $dostawa = $zamowienia->getIddost();
//            $query_zliczanie1 = $em->createQuery(
//            'SELECT p
//            FROM MarcinAdminBundle:Adresdostawa p
//            WHERE p.id = :poniedzialek'
//        )->setParameter('poniedzialek', $dostawa);
//        $trasa_zliczanie1 = $query_zliczanie1->getResult();
//        $dane[$a++]['user'] = $trasa_zliczanie1[0]->GetUser();
//        $dane[$b++]['ulica'] = $trasa_zliczanie1[0]->GetUlica();
//        $dane[$c++]['kod'] = $trasa_zliczanie1[0]->GetKodpocztowy();
//        $dane[$d++]['miejscowosc'] = $trasa_zliczanie1[0]->GetMiejscowowsc();
//        $dane[$e++]['telefon'] = $trasa_zliczanie1[0]->GetTelefon();
//        $dane[$f++]['nazwa'] = $trasa_zliczanie1[0]->GetNazwafirmy();
//        $dane[$g++]['id'] = $dostawa;
//        
//        $produkty[$a1++]['nruser'] = $zamowienia->GetNr_user_zam();
//        $produkty[$b1++]['dostawa'] = $zamowienia->GetIddost();
//        $produkty[$c1++]['platnosc'] = $zamowienia->GetPlatnosc();
//        $produkty[$d1++]['nrprodukcji'] = $zamowienia->GetNrprodukcji();
//        $produkty[$e1++]['dozaplaty'] = $zamowienia->GetDozaplaty();
//        $produkty[$f1++]['jakiezam'] = $zamowienia->GetJakie_zam();
//       
//        //$produkty[$g1++]['id'] = $dostawa;
//        }
//        $dane = array_map("unserialize", array_unique(array_map("serialize", $dane)));
//        //echo "testttttttttttt";
//        //print_r($sprwadzam);
//        }
//        return $this->render('MarcinAdminBundle:Trasa:generowanie.html.twig',
//            array(
//            'pageTitle'            => 'GM Panel Trasa',
//            'queryParams' => $queryParams,
//                'trasa' => $trasa,
//                'dane'=> $dane,
//                'produkty' => $produkty
//                )
//        );
//    }
    
    /**
     * @Route(
     *       "przesylanie/informacji/{trasastat}/{user}/{idzam}",
     *       name="marcin_admin_trasa_przesylanie"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function przesylanieAction(Request $Request, $trasastat, $user, $idzam) {
        
         try {
                $userManager = $this->get('user_manager');
                $userManager->sendEmail($trasastat, $user, $idzam);
                $this->addFlash('success', 'Poprawnie wykonano polecenie!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
//        return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar'),
//            array(
//                'trasastat' => $trasastat
//            ));
        return $this->redirect($this->generateUrl('marcin_admin_trasa_generowanie', array(
                                'trasastat' => $trasastat
            )));
    }
    
    /**
     * @Route(
     *       "przesylanie/informacjio/{trasastat}/{user}/{idzam}",
     *       name="marcin_admin_trasa_przesylanie_odbior"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function przesylanieoAction(Request $Request, $trasastat, $user, $idzam) {
        
         try {
                $userManager = $this->get('user_manager');
                $userManager->sendEmailo($trasastat, $user, $idzam);
                $this->addFlash('success', 'Poprawnie wykonano polecenie!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
        return $this->redirect($this->generateUrl('marcin_admin_trasa_generowanie', array(
                                'trasastat' => $trasastat
            )));
    }
    
    /**
     * @Route(
     *       "przesylanie/informacjiw/{trasastat}/{user}/{idzam}",
     *       name="marcin_admin_trasa_przesylanie_wysylka"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function przesylaniewAction(Request $Request, $trasastat, $user, $idzam) {
        
         try {
                $userManager = $this->get('user_manager');
                $userManager->sendEmailw($trasastat, $user, $idzam);
                $this->addFlash('success', 'Poprawnie wykonano polecenie!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
        return $this->redirect($this->generateUrl('marcin_admin_trasa_generowanie', array(
                                'trasastat' => $trasastat
            )));
    }
    
}