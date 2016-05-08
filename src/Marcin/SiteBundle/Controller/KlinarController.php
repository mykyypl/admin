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
    public function formAction(Request $Request, $id, Shoperklinar $Shoper = NULL) {
        
         if (null == $Shoper) {
             $this->addFlash('error', 'Brak takiego zamówienia!');
             return $this->redirect($this->generateUrl('marcin_site_klinar'));
        }
        $form = $this->createForm(new KlinarType(), $Shoper);
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
                ->setParameter('Klinar', 'Klinar')
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
                $userManager->checkKlinar($id);
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
            return $this->redirect($this->generateUrl('marcin_site_klinar', array(
                                'id' => $Shoper->getId()
            )));
        }
        
        $KlinarZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
       // $qb = $em->getRepository('MarcinSiteBundle:Shoperklinar')->getKlinarSendBuilder();
        $qb = $KlinarZam->getKlinarSendBuilder($id);
        //$paginationLimit = $this->container->getParameter('admin.pagination_limit');
        //$limits = array(2, 5, 10, 15);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb);
        
                
                
//            $ilosc = 0;
//            $sprwadzam = 0;
//             foreach($qb_sprawdzanie as $posrednik)
//             {
////                $posrednik->setIdposrednik($sprwadzam);
////                $posrednik->setZaznaczono('66');
////                //$id = $posrednik->getId();
////                $zamowienia_klinar->addShoper1($posrednik);
////                $posrednik->addShoperklinar($zamowienia_klinar);
////               // $em->persist($posrednik);
////               // $em->persist($zamowienia_klinar);
////                // klinar -> 66
////                $em->flush();
//                // $ilosc = $ilosc + 1;
//                 //$sprwadzam = $sprwadzam + $posrednik->getZrealizowano();
//                 if ($posrednik->getZrealizowano() == "" || $posrednik->getZrealizowano() == "0")
//                 {
//                     $qb_klinar[0]->setCalosc('0');
//                     $em->flush();
//                     break;
//                 }
//                 else {
//                     $qb_klinar[0]->setCalosc('1');
//                     $em->flush();
//                 }
//                 
//             }
//             if ($ilosc == $posrednik)
//             {
//                 $qb_klinar->setCalosc('1');
//                 $em->flush();
//             }
//             else {
//                 $qb_klinar->setCalosc('0');
//                 $em->flush();
//             }

        return $this->render('MarcinSiteBundle:Klinar:form.html.twig',
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
     *       name="marcin_site_klinar",
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
        $statistics = $KlinarZam->getStatisticsKlinar();
        
        $qb = $KlinarZam->getKlinarBuilder($queryParams);
        
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
        
        return $this->render('MarcinSiteBundle:Klinar:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Klinar',
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