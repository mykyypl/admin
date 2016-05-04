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


class ZygmarController extends Controller {
    
    private $deleteTokenName = 'delete-zam-%d';
    
    /**
     * @Route("/form/send", 
     *       name="marcin_admin_zygmar_send",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     *
     */
    public function sendAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'zaznaczono' => $Request->request->get('zaznaczono')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setZaznaczono($result['zaznaczono']);
        $em->flush();
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/send_zygmar/{id}/{idzam}", 
     *       name="marcin_admin_shoper_send_zygmar"
     * )
     *
     */
    public function sendzygmarAction($id, $idzam) {
        
          /////////////////////////////////////// WYSYŁANIE WIADOMOŚCI EMAIL
            try {
               // $userEmail = 'marcin@grupamagnum.eu';
                $userManager = $this->get('user_manager');
                $userManager->sendZygmar($id);
                $this->addFlash('success', 'Poprawnie wysłano wiadomość!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
            /////////////////////////////////////// KONIEC WYSYŁANIA WIADOMOŚCI EMAIL
       return $this->redirect($this->generateUrl('marcin_admin_zygmar'));
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_zygmar",
     *       requirements={"page"="\d+"},
     *      defaults={"status"="nowe", "page"=1}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request,$status ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike'),
            'status' => $status

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
        $statistics = $StatZam->getStatisticszygmar();
        
        $qb = $StatZam->getZygmarBuilder($queryParams);
        
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
        
        return $this->render('MarcinAdminBundle:Zygmar:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia Zygmar',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *      "/zygmar/show/zamowienie/{idzam}", 
     *      name="marcin_admin_shoper_zygmar_show",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * @Template()
     */
    public function zygmarshowAction(Request $Request, $idzam) {
            
        $zamowienia_klinar = new Shoperklinar();
        
       $em = $this->getDoctrine()->getManager();


        $qb_klinar = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.zaznaczono = :identifier AND a.producent = :Klinar')
                 //->andWhere('a.producent = Klinar' )
                 ->setParameter('identifier', '1')
                ->setParameter('Klinar', 'Zygmar')
               // ->setParameter('idzam', $idzam)
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        if ($qb_klinar == null) {
             $this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
             return $this->redirect($this->generateUrl('marcin_admin_shoper_zygmar'));
        } else {
        
        $firma = $qb_klinar[0]->getFirma();
        $imie = $qb_klinar[0]->getImie();
        $nazwisko = $qb_klinar[0]->getNazwisko();
        $miejscowosc = $qb_klinar[0]->getMiejscowosc();
        $kodpocztowy = $qb_klinar[0]->getKodpocztowy();
        $adres1 = $qb_klinar[0]->getAdres1();
        $adres2 = $qb_klinar[0]->getAdres2();
        $telefon = $qb_klinar[0]->getTelefon();
        
        $zamowienia_klinar->setIdzam($idzam);
        $zamowienia_klinar->setFirma($firma);
        $zamowienia_klinar->setImie($imie);
        $zamowienia_klinar->setNazwisko($nazwisko);
        $zamowienia_klinar->setAdres1($adres1);
        $zamowienia_klinar->setAdres2($adres2);
        $zamowienia_klinar->setKodpocztowy($kodpocztowy);
        $zamowienia_klinar->setMiejscowosc($miejscowosc);
        $zamowienia_klinar->setTelefon($telefon);
        $zamowienia_klinar->setDatawygenerowania(new \DateTime());
        $zamowienia_klinar->setDatamaxdo(new \DateTime('+ 2 days'));
        $zamowienia_klinar->setKategoria("Zygmar");
        
        $em->persist($zamowienia_klinar);
        $em->flush();
            
            $sprwadzam = $zamowienia_klinar->getId();
            
             foreach($qb_klinar as $posrednik)
             {
                $posrednik->setIdposrednik($sprwadzam);
                $posrednik->setZaznaczono('88');
                //$id = $posrednik->getId();
                $zamowienia_klinar->addShoper1($posrednik);
                $posrednik->addShoperklinar($zamowienia_klinar);
               // $em->persist($posrednik);
               // $em->persist($zamowienia_klinar);
                // Zygmar -> 88
                $em->flush();
             }
             $this->addFlash('success', 'Poprawnie wygenerowano nowy formularz!');
             return $this->redirect($this->generateUrl('marcin_admin_shoper_zygmar_podglad', array('id' => $sprwadzam)));
    }
    }
    
    /**
     * @Route(
     *       "/zygmar/b/podglad/{id}",
     *       name="marcin_admin_shoper_zygmar_podglad",
     *       requirements={"id"="\d+"}
     * )
     *    
     * @Template()
     */
    public function zpodgladAction(Request $Request, $id, Shoperklinar $Shoper = NULL) {
        if (null == $Shoper) {
            $Shoper = new Shoperklinar();
            $newShoperyForm = TRUE;
        }

        $form = $this->createForm(new KlinarType(), $Shoper);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Shoper);
            $em->flush();
            $message = (isset($newShoperyForm)) ? 'Poprawnie dodano.' : 'Dane zostały zaaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_zygmar_pokaz', array(
                                'id' => $Shoper->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Zygmar:zygmar_edit.html.twig', array(
                    'pageTitle' => (isset($newShoperyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'zamowienia' => $Shoper,
                        )
        );
    }
    
    /**
     * @Route(
     *       "/zygmar/b/pokaz/{page}",
     *       name="marcin_admin_zygmar_pokaz",
     *       requirements={"page"="\d+"},
     *       defaults={"page"=1}
     * )
     *    
     * @Template()
     */
    public function zygmarpokazAction(Request $Request, $page) {
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
        //$statistics = $StatUser->getStatistics();
        
        $qb = $StatZam->getZygmarBuilder($queryParams);
        
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
        
        return $this->render('MarcinAdminBundle:Zygmar:zygmar.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia Zygmar',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'pagination' => $pagination,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider')
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *      "/zygmar/b/pokaz/usun/{id}/{token}", 
     *      name="marcin_admin_shoper_zygmar_delete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Template()
     */
    public function deleteAction($id, $token) {

        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');

        if (!$csrfProvider->isCsrfTokenValid($tokenName, $token)) {
            $this->addFlash('error', 'Niepoprawny token akcji.');
        } else {

            $Zamid = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar')->find($id);
            //$Zamid = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia')
            $em = $this->getDoctrine()->getManager();
            $em->remove($Zamid);
            $qb_klinar = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                ->where('a.producent = :Klinar AND a.idposrednik = :idzam')
                 //->andWhere('a.producent = Klinar' )
                 //->setParameter('identifier', '1')
                ->setParameter('Klinar', 'Zygmar')
                ->setParameter('idzam', $id)
                
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
            
            foreach($qb_klinar as $posrednik)
             {
                $posrednik->setIdposrednik(null);
                $posrednik->setZaznaczono(null);
                $posrednik->setZrealizowano(null);
                $posrednik->setKlinaryt(null);
                $posrednik->setZalacznik(null);
                $em->flush();
             }
            $em->flush();
            $this->addFlash('success', 'Poprawnie usunięto.');
        }

        return $this->redirect($this->generateUrl('marcin_admin_zygmar'));
    }
    
}