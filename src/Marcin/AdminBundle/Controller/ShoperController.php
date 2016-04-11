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
use Marcin\AdminBundle\Entity\Shoperzamowienia;
use Marcin\AdminBundle\Form\Type\TestType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;

class ShoperController extends Controller {
    
    
    
    /**
     * @Route(
     *       "/dodawanie-zamowien",
     *       name="marcin_admin_shoper-dodawanie"
     * )
     *    
     * @Template()
     */
    public function dodawanieAction() {

        
        $em = $this->getDoctrine()->getManager(); 
        $zamowienia_zapytanie = $em->createQuery('
            SELECT q.idzam FROM MarcinAdminBundle:Shoperzamowienia q          
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
            
            $deliveryAddress = (Array)$order['billingAddress'];
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
     *       "/{page}",
     *       name="marcin_admin_shoper",
     *       requirements={"page"="\d+"},
     *       defaults={"page"=1}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $page) {
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Shoperzamowienia');
        //$statistics = $StatUser->getStatistics();
        
        $qb = $StatZam->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        return $this->render('MarcinAdminBundle:Shoper:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Shoper zamówienia',
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'pagination' => $pagination
            //'updateTokenName' => $this->updateTokenName,
            //'aktywacjaTokenName' => $this->aktywacjaTokenName,
            //'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
}