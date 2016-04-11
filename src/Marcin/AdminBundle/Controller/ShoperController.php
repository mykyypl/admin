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
     *       "/",
     *       name="marcin_admin_shoper"
     * )
     *    
     * @Template()
     */
    public function indexAction() {

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
            $this->addFlash('success', 'Zalogowano w SHOPER. Identyfikator sesji: '.$session.'.');
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
            $zamowienia = new Shoperzamowienia();
            $zamowienia->setIdzam($order['order_id']);
            $zamowienia->setSuma($order['sum']);
            $zamowienia->setDate($order['date']);
            
            $deliveryAddress = (Array)$order['billingAddress'];
            $zamowienia->setFirma($deliveryAddress['company']);
            $zamowienia->setNip($deliveryAddress['tax_id']);
            $zamowienia->setImie($deliveryAddress['firstname']);
            $zamowienia->setNazwisko($deliveryAddress['lastname']);
            $zamowienia->setKodpocztowy($deliveryAddress['postcode']);
            $zamowienia->setMiejscowosc($deliveryAddress['city']);
            $zamowienia->setAdres1($deliveryAddress['street1']);
            $zamowienia->setAdres2($deliveryAddress['street2']);
            $zamowienia->setTelefon($deliveryAddress['phone']);
            $zamowienia->setWojewodztwo($deliveryAddress['state']);
            
            $products = (Array)$order['products'];
            foreach ($products as $p) {
                $product = (Array)$p;
                $zamowienia->setNazwa($product['name']);
                $zamowienia->setKod($product['code']);
                $zamowienia->setWariant($product['option']);
                $zamowienia->setIlosc($product['quantity']);
                $zamowienia->setJednostka($product['unit']);
            }
            
            //$em = $this->getDoctrine()->getManager();
            $em->persist($zamowienia);
            $em->flush();
        }
    }
} else {
    $this->addFlash('error', 'Wystąpił błąd logowania.');
}

        return $this->render('MarcinAdminBundle:Shoper:index.html.twig');
    }
}