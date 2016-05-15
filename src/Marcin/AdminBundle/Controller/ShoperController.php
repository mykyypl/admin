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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ShoperController extends Controller {
    
    private $deleteTokenName = 'delete-zam-%d';
    
    /**
     * @Route("/kk/form/update-complete", 
     *       name="marcin_admin_shoper_ajax",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_ZAM')")
     *
     */
    public function updateZamAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'status' => $Request->request->get('status'),
            'idzamid' => $Request->request->get('idzamid')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
      
        $em = $this->getDoctrine()->getManager();
        //$Zamowienie->setStatus($result['status']);
        $Zamowienie->setProducent($result['status']);
        $em->flush();

        return new JsonResponse(true);
    }
    
//    /**
//     * @Route("/form/klinar/update-complete", 
//     *       name="marcin_admin_shoper_update_podglad",
//     *       requirements={
//     *          "_format": "json",
//     *          "methods": "POST"
//     *      }
//     * )
//     *
//     */
//    public function updateKlinarpodAction(Request $Request) {
//
//        $result = array(
//            'id' => $Request->request->get('id'),
//            'uwagi' => $Request->request->get('uwagi'),
//            'idzam' => $Request->request->get('idzam'),
//            'nazwa' => $Request->request->get('nazwa')
//        );
//
//        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
//        $Zamowienie = $RepoZamowienia->find($result['id']);
//
//        if (NULL === $Zamowienie) {
//            return new JsonResponse(false);
//        }
//        
//       if ($result['uwagi'] == null)
//       {
//            $em = $this->getDoctrine()->getManager();
//            $Zamowienie->setNazwa($result['nazwa']);
//            $em->flush();
//       } else {
//            $em = $this->getDoctrine()->getManager();
//            $Zamowienie->setUwagi($result['uwagi']);
//            $em->flush();
//       }
//        return new JsonResponse(true);
//    }
    
    /**
     * @Route("/form/klinar/update-complete_zam", 
     *       name="marcin_admin_shoper_update_podglad_zam",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_ZAM')")
     *
     */
    public function updateKlinarpodzamAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'uwagi' => $Request->request->get('uwagi'),
            'idzam' => $Request->request->get('idzam')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
       if ($result['uwagi'] == null)
       {
//            $em = $this->getDoctrine()->getManager();
//            $Zamowienie->setNazwa($result['nazwa']);
//            $em->flush();
       } else {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setUwagi($result['uwagi']);
            $em->flush();
       }
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/kk/form/send", 
     *       name="marcin_admin_shoper_send",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_ZAM')")
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
          /////////////////////////////////////// WYSYŁANIE WIADOMOŚCI EMAIL
           // try {
//                $userE = $result['login'];
//                 //$em = $this->getDoctrine()->getManager();
//        
//        $userEmail = $em->createQueryBuilder()
//                ->select('a.email')
//                ->from('MarcinAdminBundle:Username', 'a')
//                 ->where('a.login = :identifier')
//                 ->setParameter('identifier', $userE)
//                ->setMaxResults(1)
//                ->getQuery()
//                ->getOneOrNullResult();

              //  $userEmail = 'marcin@grupamagnum.eu';
              //  $userManager = $this->get('user_manager');
              //  $userManager->registerUsername($userEmail);
           // }
          //  catch (UserException $exc) {
           //         $this->addFlash('error', $exc->getMessage());
            //    }
            /////////////////////////////////////// KONIEC WYSYŁANIA WIADOMOŚCI EMAIL
        return new JsonResponse(true);
    }
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_shoper_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_ZAM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Shoperzamowienia $Shoper = NULL) {
        if (null == $Shoper) {
            $Shoper = new Shoperzamowienia();
            $newShoperyForm = TRUE;
        }
        $em = $this->getDoctrine()->getManager();
        $qb_klinar = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 //->where('a.zaznaczono = :identifier AND a.producent = :Klinar')
                 //->andWhere('a.producent = Klinar' )
               // ->setParameter('idzam', $idzam)
                ->orderBy('a.id', 'DESC')
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();

        $form = $this->createForm(new ShoperType(), $Shoper);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $Shoper->setIdzam($qb_klinar[0]->getIdzam());
            $Shoper->setSuma('0');
            $Shoper->setDate($qb_klinar[0]->getDate());
            //$Shoper->setKod($qb_klinar[0]->getKod());
            $em->persist($Shoper);
            $em->flush();
            $message = (isset($newShoperyForm)) ? 'Poprawnie dodano.' : 'Dane zostały zaaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_shoper', array(
                                'id' => $Shoper->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Shoper:form.html.twig', array(
                    'pageTitle' => (isset($newShoperyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'zamowienia' => $Shoper,
                        )
        );
    }
    
    
    /**
     * @Route(
     *       "/kk/dodawanie-zamowien",
     *       name="marcin_admin_shoper-dodawanie"
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
    public function dodawanieAction() {

        
        $em = $this->getDoctrine()->getManager(); 
        $zamowienia_zapytanie = $em->createQuery('
            SELECT q.idzam FROM MarcinSiteBundle:Shoperzamowienia q          
            ORDER BY q.idzam DESC
            ')
            ->setMaxResults(1)
            ->getSingleScalarResult();
        
        $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'https://sklep.grupamagnum.eu/webapi/json/');
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

    $params = Array(
            "method" => "login",
            "params" => Array("marcin", "Marcin_sklep98")
    );
    //
    //// zakodowanie parametrów dla metody POST
    $postParams = "json=" . json_encode($params);
    curl_setopt($c, CURLOPT_POSTFIELDS, $postParams);

    // dekodowanie rezultatu w formacie JSON do tablicy result
    $data = curl_exec($c);
    $result = (Array)json_decode($data);

    // sprawdzenie, czy wystąpił błąd
    if (isset($result['error'])){
         $this->addFlash('error', 'Błąd logowania do shoper!.');
            //echo "Wystąpił błąd: " . $result['error'] . ", kod: " . $result['code'];
    } else {
            // wyświetlenie wyniku
            $session = $result[0];
            //$this->addFlash('success', 'Zalogowano w SHOPER. Identyfikator sesji: '.$session.'.');
            //echo "Identyfikator sesji użytkownika: " . $session;
    }

    if ($session != null) {
        $params = Array(
            "method" => "call",
            "params" => Array($session, "order.new.list", //zwwrócenie wszystkich nowszych zamówień niż idzam $zamowienia
                    Array(true, true, 
                            $zamowienia_zapytanie // id zamówienia ostatniego
                        )
                )
        );

    // zakodowanie parametrów dla metody POST
    $postParams = "json=" . json_encode($params);
    curl_setopt($c, CURLOPT_POSTFIELDS, $postParams);

    // dekodowanie rezultatu w formacie JSON do tablicy result
    $data = curl_exec($c);
    $result = (Array)json_decode($data);

    // sprawdzenie, czy wystąpił błąd
    if (isset($result['error'])) {
        $this->addFlash('error', 'Wystąpił błąd logowania '. $result['error'] .', kod: '. $result['code']);
    } else {
        foreach ($result as $item) {
            $order = (Array)$item;
            //echo "Id zamówienia: " . $order['order_id'] . "<br>";

            $numer_zamowienia = $order['order_id'];
            $suma_zamowienia = $order['sum'];
            $data_zamowienia = $order['date'];
            
            $deliveryAddress = (Array)$order['deliveryAddress'];
            $firma_zamowienia = $deliveryAddress['company'];
            $nip_zamowienia = $deliveryAddress['tax_id'];
            $imie_zamowienia = $deliveryAddress['firstname'];
            $nazwisko_zamowienia = $deliveryAddress['lastname'];
            $kod_zamowienia = $deliveryAddress['postcode'];
            $miejscowosc_zamowienia = $deliveryAddress['city'];
            $adres1_zamowienia = $deliveryAddress['street1'];
            $adres2_zamowienia = $deliveryAddress['street2'];
            $telefon_zamowienia = $deliveryAddress['phone'];
            $wojewodztwo_zamowienia = $deliveryAddress['state'];
            
            $products = (Array)$order['products'];
            foreach ($products as $p) {
                $product = (Array)$p;
                $zamowienia = new Shoperzamowienia();
                $zamowienia->setIdzam($numer_zamowienia);
                $zamowienia->setSuma($suma_zamowienia);
                $zamowienia->setDate($data_zamowienia);
                
                $zamowienia->setFirma($firma_zamowienia);
                $zamowienia->setNip($nip_zamowienia);
                $zamowienia->setImie($imie_zamowienia);
                $zamowienia->setNazwisko($nazwisko_zamowienia);
                $zamowienia->setKodpocztowy($kod_zamowienia);
                $zamowienia->setMiejscowosc($miejscowosc_zamowienia);
                $zamowienia->setAdres1($adres1_zamowienia);
                $zamowienia->setAdres2($adres2_zamowienia);
                $zamowienia->setTelefon($telefon_zamowienia);
                $zamowienia->setWojewodztwo($wojewodztwo_zamowienia);
                
                $zamowienia->setNazwa($product['name']);
                $zamowienia->setKod($product['code']);
                $zamowienia->setWariant($product['option']);
                $zamowienia->setIlosc($product['quantity']);
                $zamowienia->setJednostka($product['unit']);
                $em->persist($zamowienia);
                $em->flush();   
            }

            //$em = $this->getDoctrine()->getManager();
 
        }
        if ($result == null)
        {
          $this->addFlash('success', 'Poprawnie wykonano polecenie. Brak nowych zamówień! Identyfikator sesji: '.$session); 
        } else {
         $this->addFlash('success', 'Poprawnie wykonano polecenie. Zamówienia zostały pobrane! Identyfikator sesji: '.$session); 
        }
    }
} else {
    $this->addFlash('error', 'Wystąpił błąd logowania.');
}

        //return $this->render('MarcinAdminBundle:Shoper:index.html.twig');
        return $this->redirect($this->generateUrl('marcin_admin_shoper'));
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_shoper",
     *       requirements={"page"="\d+"},
     *       defaults={"status"="nowe", "page"=1}
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page) {
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),
            'status' => $status
        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
        $statistics = $StatZam->getStatisticsShoperprodukty();
        
        $qb = $StatZam->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            'Nowe' => 'nowe',
            'Przypisane' => 'przypisane',
        );
        
        return $this->render('MarcinAdminBundle:Shoper:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'pagination' => $pagination
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *       "/kk/klinar/{status}/{page}",
     *       name="marcin_admin_shoper_klinar",
     *       requirements={"page"="\d+"},
     *      defaults={"status"="nowe", "page"=1}
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
    public function klinarAction(Request $Request,$status ,$page) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike'),
            'status' => $status

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperzamowienia');
        $statistics = $StatZam->getStatistics();
        
        $qb = $StatZam->getKlinarBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            'Nowe' => 'nowe',
            'Do wysłania' => 'dowyslania',
            'Wysłane' => 'wyslane',
            'Zrealizowane' => 'zrealizowane',
            'Wszystkie' => 'all'
        );
        
        return $this->render('MarcinAdminBundle:Shoper:klinar.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia klinar',
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
     * @Route("/kk/form/send_klinar/{id}/{idzam}", 
     *       name="marcin_admin_shoper_send_klinar"
     * )
     * @Security("has_role('ROLE_ZAM')")
     *
     */
    public function sendklinarAction($id, $idzam) {
        
//        $request = $this->getRequest();
//         //$request = array(
//        $id->query->get('id'),
//         //'id' => query->get('id'),
//       // $idzam->query->get('idzam')
//                 
//    );
          /////////////////////////////////////// WYSYŁANIE WIADOMOŚCI EMAIL
            try {
//                $userE = $result['login'];
//                 //$em = $this->getDoctrine()->getManager();
//        
//        $userEmail = $em->createQueryBuilder()
//                ->select('a.email')
//                ->from('MarcinAdminBundle:Username', 'a')
//                 ->where('a.login = :identifier')
//                 ->setParameter('identifier', $userE)
//                ->setMaxResults(1)
//                ->getQuery()
//                ->getOneOrNullResult();

               // $userEmail = 'marcin@grupamagnum.eu';
                $userManager = $this->get('user_manager');
                $userManager->registerUsername($id, $idzam);
                $this->addFlash('success', 'Poprawnie wysłano wiadomość!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
            /////////////////////////////////////// KONIEC WYSYŁANIA WIADOMOŚCI EMAIL
       return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar'));
    }
    
    /**
     * @Route(
     *      "/kk/klinar/show/zamowienie/{idzam}", 
     *      name="marcin_admin_shoper_klinar_show",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_ZAM')")
     * 
     * @Template()
     */
    public function klinarshowAction(Request $Request, $idzam) {
//        if (null == $Uzytkownicy) {
//            $Uzytkownicy = new Username();
//            $newUzytkownicyForm = TRUE;
//        }
            
        $zamowienia_klinar = new Shoperklinar();
        
       $em = $this->getDoctrine()->getManager();


        $qb_klinar = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.zaznaczono = :identifier AND a.producent = :Klinar AND a.idzam = :idzam')
                 //->andWhere('a.producent = Klinar' )
                 ->setParameter('identifier', '1')
                ->setParameter('Klinar', 'Klinar')
                ->setParameter('idzam', $idzam)
                
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        if ($qb_klinar == null) {
             $this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
             return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar'));
        } else {
        
        $firma = $qb_klinar[0]->getFirma();
        $imie = $qb_klinar[0]->getImie();
        $nazwisko = $qb_klinar[0]->getNazwisko();
        $miejscowosc = $qb_klinar[0]->getMiejscowosc();
        $kodpocztowy = $qb_klinar[0]->getKodpocztowy();
        $adres1 = $qb_klinar[0]->getAdres1();
        $adres2 = $qb_klinar[0]->getAdres2();
        $telefon = $qb_klinar[0]->getTelefon();
       // $id = $qb_klinar[0]->getId();
        
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
        $zamowienia_klinar->setKategoria("Klinar");
        $zamowienia_klinar->setNrlistu(NULL);
        
        $em->persist($zamowienia_klinar);
        $em->flush();
            
            $sprwadzam = $zamowienia_klinar->getId();
            
             foreach($qb_klinar as $posrednik)
             {
                $posrednik->setIdposrednik($sprwadzam);
                $posrednik->setZaznaczono('66');
                //$id = $posrednik->getId();
                $zamowienia_klinar->addShoper1($posrednik);
                $posrednik->addShoperklinar($zamowienia_klinar);
               // $em->persist($posrednik);
               // $em->persist($zamowienia_klinar);
                // klinar -> 66
                $em->flush();
             }
            
       // print_r($Request);
//        $form = $this->createForm(new UzytkownicyType(), $Uzytkownicy);
//
//        $form->handleRequest($Request);
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($Uzytkownicy);
//            $em->flush();
//            $message = (isset($newUzytkownicyForm)) ? 'Poprawnie dodano.' : 'Użytkownik został zaaktualizowany.';
//            $this->addFlash('success', $message);
//            return $this->redirect($this->generateUrl('marcin_admin_username', array(
//                                'id' => $Uzytkownicy->getId()
//            )));
//        }

//        return $this->render('MarcinAdminBundle:Shoper:klinar_posrednik.html.twig'//, array(
////                    'pageTitle' => (isset($newUzytkownicyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja użytkownika</small>'),
////                    'currPage' => 'uzytkownicy',
////                    'form' => $form->createView(),
////                    'uzytkownicy' => $Uzytkownicy,
////                        )
//        );
             $this->addFlash('success', 'Poprawnie wygenerowano nowy formularz!');
             return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar_podglad', array('id' => $sprwadzam)));
    }
    }
    
    /**
     * @Route(
     *       "/kk/klinar/b/pokaz/{status}/{page}",
     *       name="marcin_admin_shoper_klinar_pokaz",
     *       requirements={"page"="\d+"},
     *       defaults={"status"="dowyslania", "page"=1}
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
    public function klinarpokazAction(Request $Request, $status, $page) {
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),
            'status' => $status
        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinSiteBundle:Shoperklinar');
        $statistics = $StatZam->getStatisticsKlinarPanel();
        
        $qb = $StatZam->getKlinarPanelBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            //'Nowe' => 'nowe',
            'Do wysłania' => 'dowyslania',
            'Wysłane' => 'wyslane',
            'Zrealizowane' => 'zrealizowane',
            'Wszystkie' => 'all'
        );
        
        return $this->render('MarcinAdminBundle:Shoper:klinar_posrednik.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia klinar',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'pagination' => $pagination,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'currStatus' => $status,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider')
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
//    /**
//     * @Route(
//     *       "/kk/klinar/b/odczytanie/obrazek/{id}.png",
//     *       name="marcin_admin_shoper_klinar_odczytanie",
//     *       requirements={"id"="\d+"},
//     * )
//     *    
//     * @Template()
//     */
//    public function odczytanieklinarAction(Request $Request, $id) {
//        
//        if(null !== $id)
//        {
//            $em = $this->getDoctrine()->getManager();
//
//
//        $qb_klinar = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinSiteBundle:Shoperklinar', 'a')
//                 ->where('a.id = :identifier')
////                 //->andWhere('a.producent = Klinar' )
//                 ->setParameter('identifier', $id)
//                
//                 ->setMaxResults(1)
//                 ->getQuery()
//                 ->getResult();
//        if ($qb_klinar == null) {
//             $this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
//             return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar'));
//        } else {
//                
//                $qb_klinar[0]->setDataodczytania(new \DateTime());
//                //$posrednik->setZaznaczono('66');
//                // klinar -> 66
//                $em->flush();
//                $filepath = "https://grupamagnum.eu/images/logo.png";
//
//
//                $response = new Response();
//                //$disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
//                $response->headers->set('Content-Disposition' , 'attachment; filename="'.$filepath.'"');
//                $response->headers->set('Content-Type', 'image/png');
//                $response->setContent(file_get_contents($filepath));
//
//                return $response;
//           //return $this->render('MarcinAdminBundle:Shoper:zdjecie.html.php');
//        }
//        }
//        else 
//        {
//            return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar_pokaz'));
//        }
//    }
    
    /**
     * @Route(
     *       "/kk/klinar/b/podglad/{id}",
     *       name="marcin_admin_shoper_klinar_podglad",
     *       requirements={"id"="\d+"}
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
//    public function kpodgladAction(Request $Request, $id) {
//
//          $em = $this->getDoctrine()->getManager();
//        
//        $qb = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinSiteBundle:Shoperklinar', 'a')
//                ->where('a.id = :identifier')
//                ->setParameter('identifier', $id)
//                ->addOrderBy('a.id','DESC')
//                ->getQuery()
//                ->getResult();
//        
//        $qb_products = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
//                ->where('a.idposrednik = :identifier')
//                ->setParameter('identifier', $id)
//                ->addOrderBy('a.id','DESC')
//                ->getQuery()
//                ->getResult();
//     
////        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Shoperklinar');
////        //$statistics = $StatUser->getStatistics();
////        
////        $qb = $StatZam->getKlinarBuilder();
//        
////        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
////        $limits = array(2, 5, 10, 15);
////        
////        $limit = $Request->query->get('limit', $paginationLimit);
////        
////        $paginator = $this->get('knp_paginator');
////        $pagination = $paginator->paginate($qb, $page, $limit);
//        
//        
//        return $this->render('MarcinAdminBundle:Shoper:klinar_podglad.html.twig',
//            array(
//            'pageTitle'            => 'GM Panel Shoper zamówienia klinar',
//            //'queryParams' => $queryParams,
//            //'limits' => $limits,
//            //'currLimit' => $limit,
//            'dane' => $qb,
//            'produkty' => $qb_products
//            //'updateTokenName' => $this->updateTokenName,
//            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
//            //'csrfProvider' => $this->get('form.csrf_provider')
//                )
//        );
//    }
    
    public function kpodgladAction(Request $Request, $id, Shoperklinar $Shoper = NULL) {
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
            return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar_pokaz', array(
                                'id' => $Shoper->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Shoper:klinar_podglad.html.twig', array(
                    'pageTitle' => (isset($newShoperyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'zamowienia' => $Shoper,
                        )
        );
    }
    
    /**
     * @Route(
     *      "/kk/klinar/b/pokaz/usun/{id}/{token}", 
     *      name="marcin_admin_shoper_klinar_pokaz_delete",
     *      requirements={"id"="\d+"}
     * )
     * @Security("has_role('ROLE_ZAM')")
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
                ->setParameter('Klinar', 'Klinar')
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

        return $this->redirect($this->generateUrl('marcin_admin_shoper_klinar'));
    }
}