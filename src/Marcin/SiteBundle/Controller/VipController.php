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
use Marcin\SiteBundle\Form\Type\KlinarType;
use Marcin\SiteBundle\Form\Type\KlinarpType;
use Marcin\SiteBundle\Form\Type\InvestType;
use Marcin\SiteBundle\Form\Type\InvestpType;
use Marcin\SiteBundle\Form\Type\VipType;
use Marcin\SiteBundle\Form\Type\VippType;

class VipController extends Controller {
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_site_vip_form",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Template()
     */
    public function formAction(Request $Request, $id, Shoperklinar $Shoper = NULL) {
        
         if (null == $Shoper) {
             $this->addFlash('error', 'Brak takiego zamówienia!');
             return $this->redirect($this->generateUrl('marcin_site_vip'));
        }
        $form = $this->createForm(new VipType(), $Shoper);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($Request);
        $qb_klinar = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperklinar', 'a')
                 ->where('a.id = :identifier')
//                 //->andWhere('a.producent = Klinar' )
                 ->setParameter('identifier', $id)
                
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
               $qb_sprawdzanie = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.producent = :Klinar AND a.idposrednik = :idzam')
                 //->andWhere('a.producent = Klinar' )
                 //->setParameter('identifier', '1')
                ->setParameter('Klinar', 'VIP')
                ->setParameter('idzam', $id)
                
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        if ( $qb_klinar[0]->getDataodczytania() == null )
        {
            $qb_klinar[0]->setDataodczytania(new \DateTime());
            $em->flush();
        }
        if ($form->isValid()) {
           
//            $file = $Shoper->getFile();
//            $fileName = md5(uniqid()).'.'.$file->guessExtension();
//            $dir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/faktury/';
//            $file->move($dir, $fileName);
//            $Shoper->setFile($fileName);
            $Shoper->upload();
            $Shoper->setModyfikacja(new \DateTime());
            $em->persist($Shoper);
            $em->flush();
            $PDF = $Shoper->getPdf();
            if (!empty($PDF))
            {
                 try {
                $userManager = $this->get('user_manager');
                $userManager->checkVip($id);
              //  $this->addFlash('success', 'Poprawnie wysłano wiadomość!!');
                foreach($qb_sprawdzanie as $posredniknew)
                 {
                  if ($posredniknew->getZrealizowano() == "1" ) {
                    $posredniknew->setZamok('1');
                     $em->flush();
                  }
                 }
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
            }
           
             foreach($qb_sprawdzanie as $posrednik)
             {
                 if ($posrednik->getZrealizowano() == "" || $posrednik->getZrealizowano() == "0")
                 {
                     $qb_klinar[0]->setCalosc(NULL);
                     $em->flush();
                     break;
                 }
                 else {
                     $qb_klinar[0]->setCalosc('1');
                     $em->flush();
                 }
                 
             }
            $message = 'Zamówienie zaaktualizowano.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_site_vip', array(
                                'id' => $Shoper->getId()
            )));
        }
        
        $KlinarZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
       // $qb = $em->getRepository('MarcinSiteBundle:Shoperklinar')->getKlinarSendBuilder();
        $qb = $KlinarZam->getZygmarSendBuilder($id);
        //$paginationLimit = $this->container->getParameter('admin.pagination_limit');
        //$limits = array(2, 5, 10, 15);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb);

        return $this->render('MarcinSiteBundle:Vip:form.html.twig',
            array(
            'pageTitle' => 'Zamówienie <small>edycja</small>',
            'currPage' => 'zamowienia',
            'form' => $form->createView(),
            'article' => $Shoper,
            'send' => $pagination
                )
            );
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_site_vip",
     *       requirements={"page"="\d+"},
     *       defaults={"status"="nowe", "page"=1}
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
        $statistics = $KlinarZam->getStatisticsVip();
        
        $qb = $KlinarZam->getVipBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        $statusesList = array(
            'Nowe' => 'nowe',
            //'Do uzupełnienia' => 'douzupelnienia',
            'Zrealizowane' => 'zrealizowane',
            'Wszystkie' => 'all'
        );
        
        return $this->render('MarcinSiteBundle:Vip:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Stolarka VIP',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'pagination' => $pagination,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status
                )
        );
        
    }
    
}