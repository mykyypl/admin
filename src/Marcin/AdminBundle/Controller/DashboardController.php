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

use Marcin\AdminBundle\Entity\Zamowienia;
use Marcin\AdminBundle\Form\Type\TestType;

class DashboardController extends Controller {
    /**
     * @Route(
     *       "/",
     *       name="marcin_admin_dashboard"
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request)
    {
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
        $em = $this->getDoctrine()
                ->getManager();

        $articles = $em->getRepository('MarcinAdminBundle:Zamowienia')
                ->getStatistics();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $articles,
        $Request->query->get('page', 1)/*page number*/,
        10/*limit per page*/
    );
        
        return $this->render('MarcinAdminBundle:Admin:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel',
            'articles' => $articles,
           'pagination' => $pagination,
                )
        );
    }
}