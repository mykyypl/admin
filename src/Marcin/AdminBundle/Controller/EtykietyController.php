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
use Marcin\AdminBundle\Entity\Etapyprodukcji;
use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class EtykietyController extends Controller {
    
    /**
     * @Route("/form/update-complete/zaznaczenie/single", 
     *       name="marcin_admin_etykiety_single",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function singleCheckedAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'zaznaczono' => $Request->request->get('zaznaczono')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['zaznaczono'] == '1')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZaznaczono('1');
            $em->flush();
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZaznaczono('0');
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/zaznaczenie/print", 
     *       name="marcin_admin_etykiety_print",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function printAction(Request $Request) {

        $result = array(
            'wiadomosc' => $Request->request->get('wiadomosc')
        );
        $em = $this->getDoctrine()->getManager();
        
        
        if ($result['wiadomosc'] == '1')
        {
            $query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Etapyprodukcji', 'a')
                 ->where('a.zaznaczono = :idzam')
                 ->setParameter('idzam', '1')
                 //->andWhere('a.wydrukowane is NULL')
                 ->andWhere('a.online = :online')
                 ->setParameter('online', '1')
                 ->setMaxResults(16)
                 ->getQuery()
                 ->getResult();
            
            if (NULL === $query) {
            return new JsonResponse(false);
        }
            foreach ($query as $druk)
             {
                $druk->setWydrukowane('1');
                $druk->setZaznaczono('0');
                $em->flush();
             }
        }
        else {
            return new JsonResponse(false);
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/zaznaczenie/all", 
     *       name="marcin_admin_etykiety_all",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function allCheckedAction(Request $Request) {

        $result = array(
            'zaznaczono' => $Request->request->get('zaznaczono'),
            'szukanie' => $Request->request->get('szukanie')
        );

        //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
        //$Zamowienie = $RepoZamowienia->find($result['id']);
                    if ($result['zaznaczono'] == '1')
                    {
                        $zaznaczenie = '0';
                    }
                    else 
                    {
                        $zaznaczenie = '1';
                    }
            $em = $this->getDoctrine()->getManager();
            
            if ($result['szukanie'] == NULL)
            {
            $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Etapyprodukcji', 'a')
                 ->where('a.zaznaczono = :idzam')
                 ->setParameter('idzam', $zaznaczenie)
                 ->andWhere('a.wydrukowane is NULL')
                 ->andWhere('a.online = :online')
                 ->setParameter('online', '1')
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
            }
            else {
                $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Etapyprodukcji', 'a')
                 ->where('a.zaznaczono = :idzam')
                 ->setParameter('idzam', $zaznaczenie)
                 //->andWhere('a.wydrukowane is NULL')
                 ->andWhere('a.nrzamowienia = :nrzam')
                 ->setParameter('nrzam', $result['szukanie'])
                 ->andWhere('a.online = :online')
                 ->setParameter('online', '1')
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
            }
            if (NULL === $produkty_query) {
            return new JsonResponse(false);
            }
            
             foreach ($produkty_query as $prod)
             {
                 if ($result['zaznaczono'] == '1')
                {
                    $prod->setZaznaczono('1');
                    $em->flush();
                }
                else {
                    $prod->setZaznaczono('0');
                    $em->flush();
                }
                 
             }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_etykiety",
     *       requirements={"page"="\d+"},
     *      defaults={"status"="nowe", "page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request,$status ,$page) {
//        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ZAM')) {
//                 return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
//         }
        
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike'),
            'status' => $status

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
        //$statistics = $StatZam->getStatisticsinvest();
        
        $qb = $StatZam->getEtykietyBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            'Do druku' => 'nowe',
            'Wszystkie' => 'all'
        );
        
        return $this->render('MarcinAdminBundle:Etykiety:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel etykiety',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            //'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status
                )
        );
    }
    
    /**
     * @Route(
     *       "/etykiety/generowanie",
     *       name="marcin_admin_etykiety_generowanie"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function etykietyGenAction(Request $Request) {
//        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ZAM')) {
//                 return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
//         }
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
        //$statistics = $StatZam->getStatisticsinvest();
        
        $qb = $StatZam->getEtykietyGenBuilder();
        
//        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
//        $limits = array(2, 5, 10, 15);
//        
//        $limit = $Request->query->get('limit', $paginationLimit);
//        
//        $paginator = $this->get('knp_paginator');
//        $pagination = $paginator->paginate($qb, $page, $limit);
//        
//        $statusesList = array(
//            'Do druku' => 'nowe',
//            'Wszystkie' => 'all'
//        );
        
        //foreach ($qb as $wyliczanie)
          //  {
            //    $nazwa[] = $wyliczanie->getUser();
           // }
        
        return $this->render('MarcinAdminBundle:Etykiety:generowanie.html.twig',
            array(
            'pageTitle'            => 'GM Panel etykiety',
                'etykiety' => $qb
//            'limits' => $limits,
//            'currLimit' => $limit,
//            'statusesList' => $statusesList,
//            'currStatus' => $status,
//            //'statistics' => $statistics,
//            'pagination' => $pagination,
//            'currStatus' => $status
                )
        );
    }
    
}