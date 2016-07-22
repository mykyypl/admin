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
use Marcin\AdminBundle\Entity\Username;
use Marcin\AdminBundle\Entity\Etapyprodukcji;
use Marcin\AdminBundle\Entity\Cennikmoskitiery;
use Marcin\AdminBundle\Form\Type\TestType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DashboardController extends Controller {

    private $deleteTokenName = 'delete-zam-%d';

    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_dashboard_update",
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
            'status' => $Request->request->get('status'),
           // 'username' => $Request->request-get('username'),
            'zaplacono' => $Request->request->get('zaplacono'),
            'price' => $Request->request->get('price'),
            'login' => $Request->request->get('login'),
            'produkcja' =>$Request->request->get('produkcja')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['status'] == NULL && $result['price'] == NULL && $result['produkcja'] == NULL)
        {
        $em = $this->getDoctrine()->getManager();
        //$Zamowienie->setStatus($result['status']);
        $Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        }
        elseif ($result['status'] == NULL && $result['zaplacono'] == NULL && $result['produkcja'] == NULL) {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setDozaplaty($result['price']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
            $em->flush();
            /////////////////////////////////////// WYSYŁANIE WIADOMOŚCI EMAIL
//            try {
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
//
//                $userManager = $this->get('user_manager');
//                $userManager->registerUsername($userEmail);
//            }
//            catch (UserException $exc) {
//                    $this->addFlash('error', $exc->getMessage());
//                }
            /////////////////////////////////////// KONIEC WYSYŁANIA WIADOMOŚCI EMAIL
        }
        elseif ($result['status'] == NULL && $result['zaplacono'] == NULL && $result['price'] == NULL) 
         {
             $em = $this->getDoctrine()->getManager();
            $Zamowienie->setNrprodukcji($result['produkcja']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
            $em->flush();
         }
        else
        {
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setStatus($result['status']);
        //$Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        if($result['status'] == "anulowane")
            {
            
            try {
                    $userE = $result['login'];
                     //$em = $this->getDoctrine()->getManager();

            $userEmail = $em->createQueryBuilder()
                    ->select('a.email')
                    ->from('MarcinAdminBundle:Username', 'a')
                     ->where('a.login = :identifier')
                     ->setParameter('identifier', $userE)
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

                    $userManager = $this->get('user_manager');
                    $userManager->anulowanieZamowienia($userEmail);
                }
                catch (UserException $exc) {
                        $this->addFlash('error', $exc->getMessage());
                    }
            }
        }
        return new JsonResponse(true);


//        if (NULL === $Zamowienie) {
//            return new Response(false);
//        } else {
//
//            //                    'id' =>$entity->getId(),
////                    'zaplacono' => $entity->getZaplacono(),
////                    'status' => $entity->getStatus(),
//        }
//        $em = $this->getDoctrine()->getManager();
//        
//        $entity = $em->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
//        
//        if(!$entity) {
//            throw $this->createNotForundException('Nie można zrealizować żądania!');
//        }
//        
//        $editForm = $this->createForm(new UpdatezamType(), $entity);
//        $editForm->bind($Request);
//        
//        if($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//            
//            if($Request->isXmlHttpRequest()){
//                $json = json_encode(array(
//                    'id' =>$entity->getId(),
//                    'zaplacono' => $entity->getZaplacono(),
//                    'status' => $entity->getStatus(),
//                ));
//                
//                $response = new Response($json);
//                $response->headers->set('Content-Type', 'application/json');
//                return $response;
//            }
//            
//            return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
//        }
//        
//        return array(
//            'zamowienia' => $entity,
//            'form' =>$editForm->createView(),
//                        'csrfProvider' => $this->get('form.csrf_provider'),
//        );
    }
    
    /**
     * @Route("/form/update-complete/produkcja", 
     *       name="marcin_admin_dashboard_update_wykonano",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateWykoAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'wykonano' => $Request->request->get('wykonano')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['wykonano'] == '1')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('wyprodukowane');
            $em->flush();
        } else if($result['wykonano'] == '0')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w realizacji');
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/moskitiery/etapy", 
     *       name="marcin_admin_dashboard_moskitiery_edit_ajax",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function updateMoskiprodAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'stronawiercenia' => $Request->request->get('stronawiercenia'),
            'rodzaj' => $Request->request->get('rodzaj'),
            //'felcstala' => $Request->request->get('felcstala'),
            'blaszkast' => $Request->request->get('blaszkast'),
            'blaszkaex' => $Request->request->get('blaszkaex'),
            'stalawys' => $Request->request->get('stalawys'),
            'stalaszer' => $Request->request->get('stalaszer')
            //'oscieznicastala' => $Request->request->get('oscieznicastala'),
            //'skrzydlostala' => $Request->request->get('skrzydlostala')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStronawiercenia($result['stronawiercenia']);
            $Zamowienie->setRodzaj($result['rodzaj']);
            //$Zamowienie->setFelcstala($result['felcstala']);
            $Zamowienie->setBlaszkast($result['blaszkast']);
            $Zamowienie->setBlaszkaex($result['blaszkaex']);
            $Zamowienie->setStalawys($result['stalawys']);
            $Zamowienie->setStalaszer($result['stalaszer']);
            //$Zamowienie->setOscieznicastala($result['oscieznicastala']);
            //$Zamowienie->setSkrzydlostala($result['skrzydlostala']);
            $em->flush();
        
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/weryfikacjazamowienia", 
     *       name="marcin_admin_dashboard_weryfikacjazamowienia",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function weryfikacjazamAction(Request $Request) {
        $em = $this->getDoctrine()->getManager();
        $zamowienia_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.status = :status')
                 ->setParameter('status', 'przesłane do realizacji')
                ->andwhere('a.jakie_zam = :jakie')
                ->setParameter('jakie', 'zamówienie moskitier')
                ->andwhere('a.weryfikacjaprodukcji is NULL')
               // ->setParameter('wer', '')
                 ->getQuery()
                 ->getResult();
      
        
        if (NULL == $zamowienia_query)
        {
            $this->addFlash('warning', 'Brak nowych moskitier do weryfikacji.');
            return new JsonResponse(false);
        }
        
        $cennik_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Cennikmoskitiery', 'a')
                ->getQuery()
                ->getResult();
        
        if (NULL == $cennik_query)
        {
              $this->addFlash('danger', 'Błąd cennika! proszę skontaktować się z administratorem!');
              return new JsonResponse(false);
        } else {
        /// TWORZENIE TABLICY CENNIKA
        $ce=0;$ce1=0;
        foreach ($cennik_query as $cennikmo)
        {
            $cennik[$ce++]['standard'] = $cennikmo->getStandard();
            $cennik[$ce1++]['exclusive'] = $cennikmo->getExclusive();

//            1. (0.00-0.50) st: 43.00 ex: 55.00 
//            2. (0.51-0.75) st: 54.00 ex: 67.00
//            3. (0.76-1.00) st: 65.00 ex: 79.00
//            4. (1.01-1.25) st: 74.00 ex: 89.00
//            5. (1.26-1.50) st: 83.00 ex: 99.00
//            6. (1.51-1.75) st: 90.00 ex: 107.00
//            7. (1.76-2.00) st: 98.00 ex: 115.50
            
        }
        }

        $a = 0;$b = 0;$c = 0; $d = 0; $e = 0;
         foreach ($zamowienia_query as $zam)
         {
             //$daneprodukty[$a++]['idzam'] = $prod->GetIdzam();
             $idzamowienia = $zam->getId();
             $nrprodukcji = $zam->getNrprodukcji();
             $uzytkownik = $zam->getUser();
             $nruzytkownika = $zam->getNr_user_zam();
             $trasa = $zam->getTrasa();
             $weryfikacjaproduktu[0] = $zam->getWeryfikacjaprodukcji();
             $rabatki = $zam->getZamowienienr();
             
        $rabaty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Rabaty', 'a')
                ->where('a.user = :user')
                ->setParameter('user', $uzytkownik)
                ->andwhere('a.typ_zamowienia = :typ')
                ->setParameter('typ', $rabatki)
                ->andwhere('a.platnosc = :plat')
                ->setParameter('plat', $zam->getPlatnosc())
                 ->getQuery()
                 ->getResult();
        
        if (NULL == $rabaty_query)
        {
            $this->addFlash('danger', 'Brak rabatów dla zamówienia! id: '.$idzamowienia.'.');
            //return new JsonResponse(false);
            $rabaty = 0;
        } else {
            foreach ($rabaty_query as $rabat)
            {
                
                 $rabaty = $rabat->getRabat();
                
            }
            
        }
             
             $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Produkty', 'a')
                 ->where('a.id_zam = :idzam')
                 ->setParameter('idzam', $idzamowienia)
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
             $aa = 0; $bb = 0; $cc = 0; $dd = 0;
             $iloscProduktow = 0;
             foreach ($produkty_query as $prod)
             {
                 $tablica = $weryfikacjaproduktu[0];
                 $kolorokna = $prod->getKolor();
                 $uszerokosc = $prod->getSzerokosca();
                 $uwysokosc = $prod->getWysokosch();
                 $typ = $prod->getTyp();
                 $uwagi = $prod->getUwagi();
                 
                 $kolorsiatki = $prod->getKolorsiatki();
                 
                 $iloscProduktow = $iloscProduktow +1;
                 $oknookno = $prod->getNazwa();
                 $oknofelc = $prod->getGrubosc();
                 $oknooscieznica = $prod->getOscieznica();
                 $oknoskrzydlo = $prod->getSkrzydlo();
                 
                 
            // }
             //$okno = array_map("unserialize", array_unique(array_map("serialize", $okno)));   // usuwanie duplikatow w tablicy
            // foreach ($okno as $system)
            // {
                 $okna_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Zamokna', 'a')
                 ->where('a.name = :nazwa')
                 ->setParameter('nazwa', $oknookno)
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
                 //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Etapyprodukcji');
                 
                 //$RepoZamowienia = new Etapyprodukcji;
                 // $RepoZamowienia->setUser($system);
                 //  $em->persist($RepoZamowienia);
                 //$em->flush();
                 
                 // wyliczanie ceny moskitier
                 
                 $metrykwadratowe = ($uszerokosc/1000)*($uwysokosc/1000);
                 $metrykwadratowe = number_format($metrykwadratowe,2);
                 
                 if ($metrykwadratowe <= 0.50)
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[0]['standard']; //"43.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[0]['exclusive']; //"55.0";
                     }
                 } 
                    elseif ($metrykwadratowe >= 0.51 && $metrykwadratowe <= 0.75)
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[1]['standard']; //"54.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[1]['exclusive']; //"67.00";
                     }
                 } 
                    elseif ($metrykwadratowe >= 0.76 && $metrykwadratowe <= 1.00)
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[2]['standard']; //"65.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[2]['exclusive']; //"79.00";
                     }
                 } 
                    elseif ($metrykwadratowe >= 1.01 && $metrykwadratowe <= 1.25)
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[3]['standard']; //"74.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[3]['exclusive']; //"89.00";
                     }
                 } 
                    elseif ($metrykwadratowe >= 1.26 && $metrykwadratowe <= 1.50)
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[4]['standard']; //"83.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[4]['exclusive']; //"99.00";
                     }
                 } 
                    elseif ($metrykwadratowe >= 1.51 && $metrykwadratowe <= 1.75) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[5]['standard']; //"90.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[5]['exclusive']; //"107.00";
                     }
                 } 
                    elseif ($metrykwadratowe >= 1.76 && $metrykwadratowe <= 2.00) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[6]['standard']; //"98.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[6]['exclusive']; //"115.50";
                     }
                 }
                 elseif ($metrykwadratowe >= 2.01 && $metrykwadratowe <= 2.25) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[7]['standard']; //"108.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[7]['exclusive']; //"125.50";
                     }
                 } 
                 elseif ($metrykwadratowe >= 2.26 && $metrykwadratowe <= 2.50) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[8]['standard']; //"118.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[8]['exclusive']; //"135.50";
                     }
                 }
                 elseif ($metrykwadratowe >= 2.51 && $metrykwadratowe <= 2.75) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[9]['standard']; //"138.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[9]['exclusive']; //"155.50";
                     }
                 }
                 elseif ($metrykwadratowe >= 2.76 && $metrykwadratowe <= 3.00) 
                 {
                     if ($typ == 'Standard')
                     {
                         $cenamoskitierki = $cennik[10]['standard']; //"158.00";
                     }
                        else
                     {
                         $cenamoskitierki = $cennik[10]['exclusive']; //"175.50";
                     }
                 } 
                    else 
                 {
                     $cenamoskitierki = "00.00";
                 }
                 
             
                 
                 // koniec wyliczania
                 
                 if (NULL == $okna_query)
                 {
                     //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
                     $zam->setWeryfikacjaprodukcji('0');
                     
                     $RepoZamowienia = new Etapyprodukcji;
                         $RepoZamowienia->setBlad('okno');
                         $RepoZamowienia->setNrzamowienia($idzamowienia);
                                    $RepoZamowienia->setNrprodukcji($nrprodukcji);
                                    $RepoZamowienia->setNruserzam($nruzytkownika);
                                    $RepoZamowienia->setUser($uzytkownik);
                                    $RepoZamowienia->setTrasa($trasa);
                                    $RepoZamowienia->setIlosc($iloscProduktow);
                                    $RepoZamowienia->setOnline('0');
                                    $RepoZamowienia->setOkno($oknookno);
                                    $RepoZamowienia->setKolor($kolorokna);
                                    $RepoZamowienia->setSzerokosc($uszerokosc);
                                    $RepoZamowienia->setWysokosc($uwysokosc);
                                    $RepoZamowienia->setTyp($typ);
                                    $RepoZamowienia->setUwagi($uwagi);
                                    $RepoZamowienia->setOscieznica($oknooscieznica);
                                    $RepoZamowienia->setSkrzydlo($oknoskrzydlo);
                                    $RepoZamowienia->setFelc($oknofelc);
                                    $RepoZamowienia->setKolorsiatki($kolorsiatki);
                                    if ($kolorsiatki == 'Czarna')
                                    {
                                       $wyliczaniesitka = $cenamoskitierki * 0.05;
                                       $cenazczarnasitka = $cenamoskitierki + $wyliczaniesitka;
                                       $RepoZamowienia->setCenna($cenazczarnasitka);
                                    } else 
                                    {
                                        $RepoZamowienia->setCenna($cenamoskitierki);
                                    }
                                    $RepoZamowienia->setRabaty($rabaty);
                                    $RepoZamowienia->setM2($metrykwadratowe);
                         $em->persist($RepoZamowienia);
                     
                     $em->flush();
                     //return;  //if
                     //break;
                     //return new JsonResponse(false);
                 }
                 else {
                     $qq= 0; $ww=0; $ee=0;
                     foreach ($okna_query as $okienka)
                     {
                         $blaszkast = $okienka->getBlaszka();
                         $blaszkaex = $okienka->getBlaszkaex();
                         $stronawiercenia = $okienka->getStronawiercenia();
                         $stalaszer = $okienka->getStalaszer();
                         $stalawyst = $okienka->getStalawys();
                         $rodzaj = $okienka->getRodzaj();
                         
                         $porownanieFelc = $okienka->getFelc();
                         $porownanieOscieznica = $okienka->getOscieznica();
                         $porownanieSkrzydlo = $okienka->getSkrzydlo();
                     }
                     
                     if ($oknofelc == $porownanieFelc)
                     {
                         if ($oknooscieznica == $porownanieOscieznica)
                         {
                             if ($oknoskrzydlo == $porownanieSkrzydlo)
                             {
//                                 $spr = $zam->getWeryfikacjaprodukcji();
//                                 if($spr == NULL)
//                                 {
                                 $weryfikacja_query = $em->createQueryBuilder('a')
                                ->select('a')
                                ->from('MarcinAdminBundle:Zamowienia', 'a')
                                 ->where('a.id = :nrzam')
                                 ->setParameter('nrzam', $idzamowienia)
                                 ->andwhere('a.weryfikacjaprodukcji = :okno')
                                 ->setParameter('okno', '0')
                                 ->getQuery()
                                 ->getResult();
                                    if ($weryfikacja_query == NULL)
                                    {
                                         $zam->setWeryfikacjaprodukcji('1');
                                    }
                                    else {
                                         $zam->setWeryfikacjaprodukcji('0');
                                    }
                                    
                                    $RepoZamowienia = new Etapyprodukcji;
                                    $RepoZamowienia->setBlad(null);
                                    $RepoZamowienia->setNrzamowienia($idzamowienia);
                                    $RepoZamowienia->setNrprodukcji($nrprodukcji);
                                    $RepoZamowienia->setNruserzam($nruzytkownika);
                                    $RepoZamowienia->setUser($uzytkownik);
                                    $RepoZamowienia->setTrasa($trasa);
                                    $RepoZamowienia->setIlosc($iloscProduktow);
                                    $RepoZamowienia->setOnline('0');
                                    $RepoZamowienia->setOkno($oknookno);
                                    $RepoZamowienia->setKolor($kolorokna);
                                    $RepoZamowienia->setSzerokosc($uszerokosc);
                                    $RepoZamowienia->setWysokosc($uwysokosc);
                                    $RepoZamowienia->setTyp($typ);
                                    $RepoZamowienia->setUwagi($uwagi);
                                    $RepoZamowienia->setOscieznica($oknooscieznica);
                                    $RepoZamowienia->setSkrzydlo($oknoskrzydlo);
                                    $RepoZamowienia->setFelc($oknofelc);
                                    $RepoZamowienia->setBlaszkast($blaszkast);
                                    $RepoZamowienia->setBlaszkaex($blaszkaex);
                                    $RepoZamowienia->setStronawiercenia($stronawiercenia);
                                    $RepoZamowienia->setStalaszer($stalaszer);
                                    $RepoZamowienia->setStalawys($stalawyst);
                                    $RepoZamowienia->setRodzaj($rodzaj);
                                    $RepoZamowienia->setFelcstala($porownanieFelc);
                                    $RepoZamowienia->setOscieznicastala($porownanieOscieznica);
                                    $RepoZamowienia->setSkrzydlostala($porownanieSkrzydlo);
                                    $RepoZamowienia->setKolorsiatki($kolorsiatki);
                                    if ($kolorsiatki == 'Czarna')
                                    {
                                       $wyliczaniesitka = $cenamoskitierki * 0.05;
                                       $cenazczarnasitka = $cenamoskitierki + $wyliczaniesitka;
                                       $RepoZamowienia->setCenna($cenazczarnasitka);
                                    } else 
                                    {
                                        $RepoZamowienia->setCenna($cenamoskitierki);
                                    }
                                    $RepoZamowienia->setM2($metrykwadratowe);
                                    $RepoZamowienia->setRabaty($rabaty);
                                    $em->persist($RepoZamowienia);

                                     $em->flush();
                                     //break;
                               //  }
                             }
                             else {
                         $zam->setWeryfikacjaprodukcji('0');
                         
                         $RepoZamowienia = new Etapyprodukcji;
                         $RepoZamowienia->setBlad('skrzydlo');
                         $RepoZamowienia->setNrzamowienia($idzamowienia);
                                    $RepoZamowienia->setNrprodukcji($nrprodukcji);
                                    $RepoZamowienia->setNruserzam($nruzytkownika);
                                    $RepoZamowienia->setUser($uzytkownik);
                                    $RepoZamowienia->setTrasa($trasa);
                                    $RepoZamowienia->setIlosc($iloscProduktow);
                                    $RepoZamowienia->setOnline('0');
                                    $RepoZamowienia->setOkno($oknookno);
                                    $RepoZamowienia->setKolor($kolorokna);
                                    $RepoZamowienia->setSzerokosc($uszerokosc);
                                    $RepoZamowienia->setWysokosc($uwysokosc);
                                    $RepoZamowienia->setTyp($typ);
                                    $RepoZamowienia->setUwagi($uwagi);
                                    $RepoZamowienia->setOscieznica($oknooscieznica);
                                    $RepoZamowienia->setSkrzydlo($oknoskrzydlo);
                                    $RepoZamowienia->setFelc($oknofelc);
                                    $RepoZamowienia->setBlaszkast($blaszkast);
                                    $RepoZamowienia->setBlaszkaex($blaszkaex);
                                    $RepoZamowienia->setStronawiercenia($stronawiercenia);
                                    $RepoZamowienia->setStalaszer($stalaszer);
                                    $RepoZamowienia->setStalawys($stalawyst);
                                    $RepoZamowienia->setRodzaj($rodzaj);
                                    $RepoZamowienia->setFelcstala($porownanieFelc);
                                    $RepoZamowienia->setOscieznicastala($porownanieOscieznica);
                                    $RepoZamowienia->setSkrzydlostala($porownanieSkrzydlo);
                                    $RepoZamowienia->setKolorsiatki($kolorsiatki);
                                    if ($kolorsiatki == 'Czarna')
                                    {
                                       $wyliczaniesitka = $cenamoskitierki * 0.05;
                                       $cenazczarnasitka = $cenamoskitierki + $wyliczaniesitka;
                                       $RepoZamowienia->setCenna($cenazczarnasitka);
                                    } else 
                                    {
                                        $RepoZamowienia->setCenna($cenamoskitierki);
                                    }
                                    $RepoZamowienia->setM2($metrykwadratowe);
                                    $RepoZamowienia->setRabaty($rabaty);
                         $em->persist($RepoZamowienia);

                         $em->flush();
                         //break;
                         //return new JsonResponse(false);
                        }
                         }
                         else {
                         $zam->setWeryfikacjaprodukcji('0');
                         
                         $RepoZamowienia = new Etapyprodukcji;
                         $RepoZamowienia->setBlad('ościeżnica');
                         $RepoZamowienia->setNrzamowienia($idzamowienia);
                                    $RepoZamowienia->setNrprodukcji($nrprodukcji);
                                    $RepoZamowienia->setNruserzam($nruzytkownika);
                                    $RepoZamowienia->setUser($uzytkownik);
                                    $RepoZamowienia->setTrasa($trasa);
                                    $RepoZamowienia->setIlosc($iloscProduktow);
                                    $RepoZamowienia->setOnline('0');
                                    $RepoZamowienia->setOkno($oknookno);
                                    $RepoZamowienia->setKolor($kolorokna);
                                    $RepoZamowienia->setSzerokosc($uszerokosc);
                                    $RepoZamowienia->setWysokosc($uwysokosc);
                                    $RepoZamowienia->setTyp($typ);
                                    $RepoZamowienia->setUwagi($uwagi);
                                    $RepoZamowienia->setOscieznica($oknooscieznica);
                                    $RepoZamowienia->setSkrzydlo($oknoskrzydlo);
                                    $RepoZamowienia->setFelc($oknofelc);
                                    $RepoZamowienia->setBlaszkast($blaszkast);
                                    $RepoZamowienia->setBlaszkaex($blaszkaex);
                                    $RepoZamowienia->setStronawiercenia($stronawiercenia);
                                    $RepoZamowienia->setStalaszer($stalaszer);
                                    $RepoZamowienia->setStalawys($stalawyst);
                                    $RepoZamowienia->setRodzaj($rodzaj);
                                    $RepoZamowienia->setFelcstala($porownanieFelc);
                                    $RepoZamowienia->setOscieznicastala($porownanieOscieznica);
                                    $RepoZamowienia->setSkrzydlostala($porownanieSkrzydlo);
                                    $RepoZamowienia->setKolorsiatki($kolorsiatki);
                                    if ($kolorsiatki == 'Czarna')
                                    {
                                       $wyliczaniesitka = $cenamoskitierki * 0.05;
                                       $cenazczarnasitka = $cenamoskitierki + $wyliczaniesitka;
                                       $RepoZamowienia->setCenna($cenazczarnasitka);
                                    } else 
                                    {
                                        $RepoZamowienia->setCenna($cenamoskitierki);
                                    }
                                    $RepoZamowienia->setM2($metrykwadratowe);
                                    $RepoZamowienia->setRabaty($rabaty);
                         $em->persist($RepoZamowienia);
                         
                         $em->flush();
                         //break;
                         //return new JsonResponse(false);
                        }
                     }
                     else {
                         $zam->setWeryfikacjaprodukcji('0');
                         
                         $RepoZamowienia = new Etapyprodukcji;
                         $RepoZamowienia->setBlad('felc');
                         $RepoZamowienia->setNrzamowienia($idzamowienia);
                                    $RepoZamowienia->setNrprodukcji($nrprodukcji);
                                    $RepoZamowienia->setNruserzam($nruzytkownika);
                                    $RepoZamowienia->setUser($uzytkownik);
                                    $RepoZamowienia->setTrasa($trasa);
                                    $RepoZamowienia->setIlosc($iloscProduktow);
                                    $RepoZamowienia->setOnline('0');
                                    $RepoZamowienia->setOkno($oknookno);
                                    $RepoZamowienia->setKolor($kolorokna);
                                    $RepoZamowienia->setSzerokosc($uszerokosc);
                                    $RepoZamowienia->setWysokosc($uwysokosc);
                                    $RepoZamowienia->setTyp($typ);
                                    $RepoZamowienia->setUwagi($uwagi);
                                    $RepoZamowienia->setOscieznica($oknooscieznica);
                                    $RepoZamowienia->setSkrzydlo($oknoskrzydlo);
                                    $RepoZamowienia->setFelc($oknofelc);
                                    $RepoZamowienia->setBlaszkast($blaszkast);
                                    $RepoZamowienia->setBlaszkaex($blaszkaex);
                                    $RepoZamowienia->setStronawiercenia($stronawiercenia);
                                    $RepoZamowienia->setStalaszer($stalaszer);
                                    $RepoZamowienia->setStalawys($stalawyst);
                                    $RepoZamowienia->setRodzaj($rodzaj);
                                    $RepoZamowienia->setFelcstala($porownanieFelc);
                                    $RepoZamowienia->setOscieznicastala($porownanieOscieznica);
                                    $RepoZamowienia->setSkrzydlostala($porownanieSkrzydlo);
                                    $RepoZamowienia->setKolorsiatki($kolorsiatki);
                                    if ($kolorsiatki == 'Czarna')
                                    {
                                       $wyliczaniesitka = $cenamoskitierki * 0.05;
                                       $cenazczarnasitka = $cenamoskitierki + $wyliczaniesitka;
                                       $RepoZamowienia->setCenna($cenazczarnasitka);
                                    } else 
                                    {
                                        $RepoZamowienia->setCenna($cenamoskitierki);
                                    }
                                    $RepoZamowienia->setM2($metrykwadratowe);
                                    $RepoZamowienia->setRabaty($rabaty);
                         $em->persist($RepoZamowienia);
                         
                         $em->flush();
                         //break;
                         //return new JsonResponse(false);
                     }
                 }
             }
         }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/produkcja/email", 
     *       name="marcin_admin_dashboard_update_wykonano_email",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateWykoEmailAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'wykonano' => $Request->request->get('wykonano'),
            'trasa' => $Request->request->get('trasa'),
            'user' => $Request->request->get('user'),
            'dostawa' => $Request->request->get('dostawa')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['wykonano'] == '1')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('wyprodukowane');
            $Zamowienie->setTrasaok('1');
            $em->flush();
            $trasastat = $result['trasa'];
            $user = $result['user'];
            $idzam = $result['dostawa'];
                    
             try {
                $userManager = $this->get('user_manager');
                $userManager->sendEmailo($trasastat, $user, $idzam);
                $this->addFlash('success', 'Poprawnie wysłano email!!');
            }
            catch (UserException $exc) {
                    $this->addFlash('error', $exc->getMessage());
                }
        } else if($result['wykonano'] == '0')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w realizacji');
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/realizacja", 
     *       name="marcin_admin_dashboard_update_realizacja",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateRealizacjaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id')
        );

        $em = $this->getDoctrine()->getManager();
         
        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        $etapypro_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Etapyprodukcji', 'a')
                ->where('a.nrzamowienia = :nrzam')
                ->setParameter('nrzam', $result['id'])
                 ->getQuery()
                 ->getResult();
        
         foreach ($etapypro_query as $etapypro)
         {
               $szerokosc = $etapypro->getSzerokosc();
               $wysokosc = $etapypro->getWysokosc();
               $stalawysokosc = $etapypro->getStalawys();
               $stalaszerokosc = $etapypro->getStalaszer();
               
               ///// PROFIL STANDARD ////////
             if ($etapypro->getTyp() == 'Standard')
             {
                 /// OBLICZANIE SZEROKOSCI /// 
                 $wynikstandardsz = ($szerokosc - $stalaszerokosc)/10;
                 $wynikstandardw = ($wysokosc - $stalawysokosc)/10;
                 
                 /// OBLICZANIE POZIOMO /// DLA DREWNA /////
                 if ($etapypro->getRodzaj() == "DRE")
                 {
                     if ($szerokosc <= 600)
                     {
                         $dowiercenia = 'góra';
                         $iloscblasz = 2;
                     }
                     elseif ($szerokosc <= 1000 && $szerokosc >= 601)
                     {
                         $dowiercenia = 'góra';
                         $iloscblasz = 3;
                     }
                     else
                     {
                         $iloscblasz = 4;
                         $dowiercenia = 'góra';
                     }
                     
                     if ($wysokosc <= 500)
                     {
                         $iloscblaszwy = 1;
                     }
                     elseif ($wysokosc <= 1000 && $wysokosc >= 501)
                     {
                          $iloscblaszwy = 2;
                     }
                     elseif ($wysokosc <= 1500 && $wysokosc >= 1001) 
                    {
                        $iloscblaszwy = 3;
                    }
                    elseif ($wysokosc <= 1800 && $wysokosc >= 1501) 
                    {
                       $iloscblaszwy = 4;
                    }
                    else {
                         $iloscblaszwy = 5;
                    }
                 }
                  else {    /// OBLICZANIE POZIOMO /// DLA PCV/ALU /////
                      if ($szerokosc <= 600)
                     {
                          $iloscblasz = 2;
                         $dowiercenia = 'góra+dół';
                     }
                     elseif ($szerokosc <= 1000 && $szerokosc >= 601)
                     {
                         $iloscblasz = 3;
                         $dowiercenia = 'góra+dół';
                     }
                     else
                     {
                         $iloscblasz = 4;
                         $dowiercenia = 'góra+dół';
                     }
                     
                     if ($wysokosc <= 500)
                     {
                         $iloscblaszwy = 0;
                     }
                     elseif ($wysokosc <= 1000 && $wysokosc >= 501)
                     {
                          $iloscblaszwy = 1;
                     }
                     elseif ($wysokosc <= 1500 && $wysokosc >= 1001) 
                    {
                        $iloscblaszwy = 2;
                    }
                    elseif ($wysokosc <= 1800 && $wysokosc >= 1501) 
                    {
                       $iloscblaszwy = 3;
                    }
                    else {
                         $iloscblaszwy = 4;
                    }
                      
                  }
                  
                  ///// OBLICZANIE POZYCJI 1,2,3,4 POZIOMO ////////
                  // $wierceniePoziomo1 
                  // $wierceniePoziomo2 
                  // $wierceniePoziomo3 
                  // $wierceniePoziomo4 
                  if ($etapypro->getStronawiercenia() == 'S')
                  {
                      $wierceniePoziomo1 = 6.5;
                      if ($iloscblasz == 2)
                      {
                          $wierceniePoziomo2 = $wynikstandardsz - 5.5;
                          $wierceniePoziomo3 = '-';
                          $wierceniePoziomo4 = '-';
                      }
                      elseif ($iloscblasz == 3)
                      {
                          $wierceniePoziomo2 = number_format(($wynikstandardsz/2)+0.5,1);
                          $wierceniePoziomo3 = number_format($wynikstandardsz - 5.5,1);
                          $wierceniePoziomo4 = '-';
                      }
                      elseif ($iloscblasz == 4)
                      {
                          $wierceniePoziomo2 = number_format(($wynikstandardsz/3)+0.5,1);
                          $wierceniePoziomo3 = number_format((($wynikstandardsz/3)*2)+0.5,1);
                          if ($szerokosc < 1495)
                          {
                              $wierceniePoziomo4 = number_format($wynikstandardsz-5.5,1);
                          }
                          else 
                          {
                              $wierceniePoziomo4 = $wierceniePoziomo1;
                          }
                          
                      }
                      
                  }
                  else {
                      $wierceniePoziomo1 = 'NAR';
                      if ($iloscblasz == 2)
                      {
                          $wierceniePoziomo2 = 'NAR';
                          $wierceniePoziomo3 = '-';
                          $wierceniePoziomo4 = '-';
                      }
                      elseif ($iloscblasz == 3)
                      {
                          $wierceniePoziomo2 = number_format($wynikstandardsz/2,1);
                          $wierceniePoziomo3 = 'NAR';
                          $wierceniePoziomo4 = '-';
                      }
                      elseif ($iloscblasz == 4)
                      {
                          $wierceniePoziomo2 = number_format($wynikstandardsz/3,1);
                          $wierceniePoziomo3 = number_format(($wynikstandardsz/3)*2,1);
                          $wierceniePoziomo4 = 'NAR';
                      }
                      
                  }
                  
                  ///// OBLICZANIE POZYCJI 1,2,3,4,5 PIONOWO ////////
                  // $wierceniePionowo1 
                  // $wierceniePionowo2 
                  // $wierceniePionowo3 
                  // $wierceniePionowo4
                  // $wierceniePionowo5
                  
                  if ($etapypro->getStronawiercenia() == 'S')
                  {
                  if ($iloscblaszwy == 0)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = '-';
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                          $wierceniePionowo1 = '-';
                          $wierceniePionowo2 = '-';
                          if ($wysokosc < 2350)
                          {
                              $wierceniePionowo3 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo3 = $wierceniePionowo1;
                          }
                          if ($wysokosc < 1801)
                          {
                              $wierceniePionowo4 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo4 = $wierceniePionowo1;
                          }
                          $wierceniePionowo5 = '-';
                      }
                  }
                  elseif ($iloscblaszwy == 1)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 6.5;
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                         
                      }
                      else 
                      {
                          $wierceniePionowo1 = number_format(($wynikstandardw/2)+0.5,1);
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                      }
                  }
                  elseif ($iloscblaszwy == 2)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 6.5;
                          $wierceniePionowo2 = number_format($wynikstandardw/2,1);
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                      }
                      else 
                      {
                          $wierceniePionowo1 = number_format(($wynikstandardw/3)+0.5,1);
                          $wierceniePionowo2 = number_format((($wierceniePionowo1-0.5)*2)+0.5,1);
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                      }
                  }
                  elseif ($iloscblaszwy == 3)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 6.5;
                          $wierceniePionowo2 = number_format(($wynikstandardw/3)+0.5,1);
                          $wierceniePionowo3 = number_format((($wynikstandardw/3)*2)+0.5,1);
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                      }
                      else 
                      {
                          $wierceniePionowo1 = number_format(($wynikstandardw/4)+0.5,1);
                          $wierceniePionowo2 = number_format((($wierceniePionowo1-0.5)*2)+0.5,1);
                          $wierceniePionowo3 = number_format((($wierceniePionowo1-0.5)*3)+0.5,1);
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                      }
                  }
                  elseif ($iloscblaszwy == 4)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 6.5;
                          $wierceniePionowo2 = number_format(($wynikstandardw/4)+0.5,1);
                          $wierceniePionowo3 = number_format((($wynikstandardw/4)*2)+0.5,1);
                          $wierceniePionowo4 = number_format((($wynikstandardw/4)*3)+0.5,1);
                          $wierceniePionowo5 = '-';
                      }
                      else 
                      {
                          $wierceniePionowo1 = number_format(($wynikstandardw/5)+0.5,1);
                          $wierceniePionowo2 = number_format((($wierceniePionowo1-0.5)*2)+0.5,1);
                          if ($wysokosc < 2350)
                          {
                              $wierceniePionowo3 = number_format((($wierceniePionowo1-0.5)*3)+0.5,1);
                          }
                          else 
                          {
                              $wierceniePionowo3 = $wierceniePionowo2;
                          }
                          //$wierceniePionowo4 = number_format((($wierceniePionowo1-0.5)*4)+0.5,1);
                          $wierceniePionowo4 = $wierceniePionowo1;
                          $wierceniePionowo5 = '-';
                      }
                  }
                  elseif ($iloscblaszwy == 5)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 6.5;
                          $wierceniePionowo2 = number_format(($wynikstandardw/5)+0.5,1);
                          $wierceniePionowo3 = number_format((($wynikstandardw/5)*2)+0.5,1);
                          if ($wysokosc < 2350)
                          {
                              $wierceniePionowo4 = number_format((($wynikstandardw/5)*3)+0.5,1);
                              //$wierceniePionowo5 = number_format((($wynikstandardw-0.5)*4)+0.5,1);
                          }
                          else 
                          {
                              $wierceniePionowo4 = $wierceniePionowo3;
                              //$wierceniePionowo5 = $wierceniePionowo2;
                          }
                          $wierceniePionowo5 = $wierceniePionowo2;
                      }
                      else 
                      {
                          $wierceniePionowo1 = 'Błąd blaszka 5 PCV/ALU'; //number_format(($wynikstandardw/6)+0.5,2);
                          $wierceniePionowo2 = 'Błąd blaszka 5 PCV/ALU'; //number_format((($wierceniePionowo1-0.5)*2)+0.5,2);
                          if ($wysokosc < 2350)
                          {
                              $wierceniePionowo3 = 'Błąd blaszka 5 PCV/ALU'; //number_format((($wierceniePionowo1-0.5)*3)+0.5,2);
                          }
                          else 
                          {
                              $wierceniePionowo3 = 'Błąd blaszka 5 PCV/ALU'; //$wierceniePionowo1;
                          }
                          if ($wysokosc < 1801)
                          {
                              $wierceniePionowo4 = 'Błąd blaszka 5 PCV/ALU'; //number_format((($wierceniePionowo1-0.5)*5)+0.5,2);
                          }
                          else 
                          {
                              $wierceniePionowo4 = 'Błąd blaszka 5 PCV/ALU'; //$wierceniePionowo1;
                          }
                          $wierceniePionowo5 = 'Błąd blaszka 5 PCV/ALU'; //'-';
                      }
                  }
                  }
                  else
                  {
                      if ($iloscblaszwy == 0)
                      {
                              $wierceniePionowo1 = '-';
                              $wierceniePionowo2 = '-';
                              $wierceniePionowo3 = '-';
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          
                      }
                      elseif ($iloscblaszwy == 1)
                      {
                          if ($etapypro->getRodzaj() == "DRE")
                          {
                              $wierceniePionowo1 = 'NAR';
                              $wierceniePionowo2 = '-';
                              $wierceniePionowo3 = '-';
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo1 = number_format($wynikstandardw/2,1);
                              $wierceniePionowo2 = '-';
                              $wierceniePionowo3 = '-';
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                      }
                      elseif ($iloscblaszwy == 2)
                      {
                          if ($etapypro->getRodzaj() == "DRE")
                          {
                              $wierceniePionowo1 = 'NAR';
                              $wierceniePionowo2 = number_format($wynikstandardw/2,1);
                              $wierceniePionowo3 = '-';
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo1 = number_format($wynikstandardw/3,1);
                              $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                              $wierceniePionowo3 = '-';
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                      }
                      elseif ($iloscblaszwy == 3)
                      {
                          if ($etapypro->getRodzaj() == "DRE")
                          {
                              $wierceniePionowo1 = 'NAR';
                              $wierceniePionowo2 = number_format($wynikstandardw/3,1);
                              $wierceniePionowo3 = number_format(($wynikstandardw/3)*2,1);
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo1 = number_format($wynikstandardw/4,1);
                              $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                              $wierceniePionowo3 = number_format($wierceniePionowo1*3,1);
                              $wierceniePionowo4 = "-";
                              $wierceniePionowo5 = '-';
                          }
                      }
                      elseif ($iloscblaszwy == 4)
                      {
                          if ($etapypro->getRodzaj() == "DRE")
                          {
                              $wierceniePionowo1 = 'NAR';
                              $wierceniePionowo2 = number_format($wynikstandardw/4,1);
                              $wierceniePionowo3 = number_format(($wynikstandardw/4)*2,1);
                              $wierceniePionowo4 = number_format(($wynikstandardw/4)*3,1);
                              $wierceniePionowo5 = '-';
                          }
                          else 
                          {
                              $wierceniePionowo1 = number_format($wynikstandardw/5,1);
                              $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                              $wierceniePionowo3 = number_format($wierceniePionowo1*3,1);
                              $wierceniePionowo4 = number_format($wierceniePionowo1*4,1);
                              $wierceniePionowo5 = '-';
                          }
                      }
                      elseif ($iloscblaszwy == 5)
                      {
                          if ($etapypro->getRodzaj() == "DRE")
                          {
                              $wierceniePionowo1 = 'NAR';
                              $wierceniePionowo2 = number_format($wynikstandardw/5,1);
                              $wierceniePionowo3 = number_format(($wynikstandardw/5)*2,1);
                              $wierceniePionowo4 = number_format(($wynikstandardw/5)*3,1);
                              $wierceniePionowo5 = number_format(($wynikstandardw/5)*4,1);
                          }
                          else 
                          {
                              $wierceniePionowo1 = 'Błąd PCV blaszek 5';
                              $wierceniePionowo2 = 'Błąd PCV blaszek 5';
                              $wierceniePionowo3 = 'Błąd PCV blaszek 5';
                              $wierceniePionowo4 = 'Błąd PCV blaszek 5';
                              $wierceniePionowo5 = 'Błąd PCV blaszek 5';
                          }
                      }
                  }
                 
                   //////// WPISANIE DANYCH DO BAZY JEŻELI STANDARD ///////
                 $etapypro->setPilas($wynikstandardsz);
                 $etapypro->setPilah($wynikstandardw);
                 $etapypro->setPoziomo($iloscblasz);
                 $etapypro->setPionowo($iloscblaszwy);
                 $etapypro->setDowiercenia($dowiercenia);
                 $etapypro->setPo1($wierceniePoziomo1);
                 $etapypro->setPo2($wierceniePoziomo2);
                 $etapypro->setPo3($wierceniePoziomo3);
                 $etapypro->setPo4($wierceniePoziomo4);
                 $etapypro->setPi1($wierceniePionowo1);
                 $etapypro->setPi2($wierceniePionowo2);
                 $etapypro->setPi3($wierceniePionowo3);
                 $etapypro->setPi4($wierceniePionowo4);
                 $etapypro->setPi5($wierceniePionowo5);
                 $em->flush();
                 
             }   ///// PROFIL EXCLUSIVE ///////////
             elseif ($etapypro->getTyp() == 'Exclusive')
             {
                 /// OBLICZANIE WYSOKOSCI ///
                 $wynikstandardszy = (($szerokosc - $stalaszerokosc) - 6)/10;
                 $wynikstandardwy = (($wysokosc - $stalawysokosc) - 6)/10;
                 
                 /// OBLICZANIE PIONOWO /// DLA DREWNA /////
                 if ($etapypro->getRodzaj() == "DRE")
                 {
                     if ($szerokosc <= 600)
                     {
                         $dowiercenia = 'góra';
                         $iloscblasz = 2;
                     }
                     elseif ($szerokosc <= 1000 && $szerokosc >= 601)
                     {
                         $dowiercenia = 'góra';
                         $iloscblasz = 3;
                     }
                     else
                     {
                         $iloscblasz = 4;
                         $dowiercenia = 'góra';
                     }
                     
                     if ($wysokosc <= 500)
                     {
                         $iloscblaszwy = 1;
                     }
                     elseif ($wysokosc <= 1000 && $wysokosc >= 501)
                     {
                          $iloscblaszwy = 2;
                     }
                     elseif ($wysokosc <= 1500 && $wysokosc >= 1001) 
                    {
                        $iloscblaszwy = 3;
                    }
                    elseif ($wysokosc <= 1800 && $wysokosc >= 1501) 
                    {
                       $iloscblaszwy = 4;
                    }
                    else {
                         $iloscblaszwy = 5;
                    }
                 }
                  else {    /// OBLICZANIE PIONOWO /// DLA PCV/ALU /////
                      if ($szerokosc <= 600)
                     {
                          $iloscblasz = 2;
                         $dowiercenia = 'góra+dół';
                     }
                     elseif ($szerokosc <= 1000 && $szerokosc >= 601)
                     {
                         $iloscblasz = 3;
                         $dowiercenia = 'góra+dół';
                     }
                     else
                     {
                         $iloscblasz = 4;
                         $dowiercenia = 'góra+dół';
                     }
                     
                     if ($wysokosc <= 500)
                     {
                         $iloscblaszwy = 0;
                     }
                     elseif ($wysokosc <= 1000 && $wysokosc >= 501)
                     {
                          $iloscblaszwy = 1;
                     }
                     elseif ($wysokosc <= 1500 && $wysokosc >= 1001) 
                    {
                        $iloscblaszwy = 2;
                    }
                    elseif ($wysokosc <= 1800 && $wysokosc >= 1501) 
                    {
                       $iloscblaszwy = 3;
                    }
                    else {
                         $iloscblaszwy = 4;
                    }
                      
                  }
                  
                  ///// OBLICZANIE POZYCJI 1,2,3,4 POZIOMO ////////
                  // $wierceniePoziomo1 
                  // $wierceniePoziomo2 
                  // $wierceniePoziomo3 
                  // $wierceniePoziomo4
                
                  if ($iloscblasz == 2)
                  {
                      $wierceniePoziomo1 = 'NAR';
                      $wierceniePoziomo2 = 'NAR';
                      $wierceniePoziomo3 = '-';
                      $wierceniePoziomo4 = '-';
                  }
                  elseif ($iloscblasz == 3)
                  {
                      $wierceniePoziomo1 = 'NAR';
                      $wierceniePoziomo2 = number_format(($wynikstandardszy+7.8)/($iloscblasz - 1),1);
                      $wierceniePoziomo3 = 'NAR';
                      $wierceniePoziomo4 = '-';
                  }
                  elseif ($iloscblasz == 4)
                  {
                      $wierceniePoziomo1 = 'NAR';
                      $wierceniePoziomo2 = number_format(($wynikstandardszy+7.8)/($iloscblasz - 1),1);
                      $wierceniePoziomo3 = number_format((($wynikstandardszy+7.8)/3)*2,1);
                      $wierceniePoziomo4 = 'NAR';
                  }
                  
                  ///// OBLICZANIE POZYCJI 1,2,3,4,5 PIONOWO ////////
                  // $wierceniePionowo1 
                  // $wierceniePionowo2 
                  // $wierceniePionowo3 
                  // $wierceniePionowo4
                  // $wierceniePionowo5
                  
                  if ($iloscblaszwy == 0)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                          $wierceniePionowo1 = '-';
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                  }
                  elseif ($iloscblaszwy == 1)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                          $wierceniePionowo1 = number_format(($wynikstandardwy+7.8)/2,1);
                          $wierceniePionowo2 = '-';
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                  }
                  elseif ($iloscblaszwy == 2)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = number_format(($wynikstandardwy+7.8)/2,1);
                          $wierceniePionowo3 = '-';
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                           $wierceniePionowo1 = number_format(($wynikstandardwy+7.8)/3,1);
                           $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                           $wierceniePionowo3 = '-';
                           $wierceniePionowo4 = '-';
                           $wierceniePionowo5 = '-';
                           
                      }
                  }
                  elseif ($iloscblaszwy == 3)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = number_format(($wynikstandardwy+7.8)/3,1);
                          $wierceniePionowo3 = number_format((($wynikstandardwy+7.8)/3)*2,1);
                          $wierceniePionowo4 = '-';
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                           $wierceniePionowo1 = number_format(($wynikstandardwy+7.8)/4,1);
                           $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                           $wierceniePionowo3 = number_format($wierceniePionowo1*3,1);
                           $wierceniePionowo4 = '-';
                           $wierceniePionowo5 = '-';
                           
                      }
                  }
                  elseif ($iloscblaszwy == 4)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = number_format(($wynikstandardwy+7.8)/4,1);
                          $wierceniePionowo3 = number_format((($wynikstandardwy+7.8)/4)*2,1);
                          $wierceniePionowo4 = number_format((($wynikstandardwy+7.8)/4)*3,1);
                          $wierceniePionowo5 = '-';
                          
                      }
                      else 
                      {
                           $wierceniePionowo1 = number_format(($wynikstandardwy+7.8)/5,1);
                           $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                           $wierceniePionowo3 = number_format($wierceniePionowo1*3,1);
                           $wierceniePionowo4 = number_format($wierceniePionowo1*4,1);
                           $wierceniePionowo5 = '-';
                           
                      }
                  }
                  elseif ($iloscblaszwy == 5)
                  {
                      if ($etapypro->getRodzaj() == "DRE")
                      {
                          $wierceniePionowo1 = 'NAR';
                          $wierceniePionowo2 = number_format(($wynikstandardwy+7.8)/5,1);
                          $wierceniePionowo3 = number_format((($wynikstandardwy+7.8)/5)*2,1);
                          $wierceniePionowo4 = number_format((($wynikstandardwy+7.8)/5)*3,1);
                          $wierceniePionowo5 = number_format((($wynikstandardwy+7.8)/5)*4,1);
                          
                      }
                      else 
                      {
                           $wierceniePionowo1 = number_format(($wynikstandardwy+7.8)/6,1);
                           $wierceniePionowo2 = number_format($wierceniePionowo1*2,1);
                           $wierceniePionowo3 = number_format($wierceniePionowo1*3,1);
                           $wierceniePionowo4 = number_format($wierceniePionowo1*5,1);
                           $wierceniePionowo5 = '-';
                           
                      }
                  }
                 
                  //////// WPISANIE DANYCH DO BAZY JEŻELI EXCLUSIVE ///////
                 $etapypro->setPilas($wynikstandardszy);
                 $etapypro->setPilah($wynikstandardwy);
                 $etapypro->setPoziomo($iloscblasz);
                 $etapypro->setPionowo($iloscblaszwy);
                 $etapypro->setDowiercenia($dowiercenia);
                 $etapypro->setPo1($wierceniePoziomo1);
                 $etapypro->setPo2($wierceniePoziomo2);
                 $etapypro->setPo3($wierceniePoziomo3);
                 $etapypro->setPo4($wierceniePoziomo4);
                 $etapypro->setPi1($wierceniePionowo1);
                 $etapypro->setPi2($wierceniePionowo2);
                 $etapypro->setPi3($wierceniePionowo3);
                 $etapypro->setPi4($wierceniePionowo4);
                 $etapypro->setPi5($wierceniePionowo5);
                 $em->flush();
             }
             else {
                 //// JEZELI BLAD TO ZWROCENIE BELEDU!
                  return new JsonResponse(false);
             }
         }
        
        
        // ***************** ZAMIANA STATUSU *************************//
        
            $Zamowienie->setStatus('w realizacji');
            $em->flush();
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/faktura/add", 
     *       name="marcin_admin_dashboard_faktura_add",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function addFakturaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'nrfakt' => $Request->request->get('nrfakt')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        if($result['id'] != NULL)
        {
        
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setNr_fakt($result['nrfakt']);
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/faktura/edit", 
     *       name="marcin_admin_dashboard_faktura_edit",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function editFakturaAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'nrfakt' => $Request->request->get('nrfakt')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        if($result['id'] != NULL)
        {
        
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setNr_fakt($result['nrfakt']);
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/lock/lock", 
     *       name="marcin_admin_dashboard_update_lock",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateLockAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'locknew' => $Request->request->get('locknew')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if ($result['locknew'] == "lock")
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZamowienie(null);
            $Zamowienie->setZakonczone(null);
            $em->persist($Zamowienie);
            $em->flush();
            
            $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Produkty', 'a')
                 ->where('a.id_zam = :idzam')
                 ->setParameter('idzam', $result['id'])
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
             foreach ($produkty_query as $prod)
             {
                 $prod->setStatus('0');
                 $em->persist($Zamowienie);
                 $em->flush();
             }
        }
        elseif ($result['locknew'] == "unlock")
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setZamowienie('1');
            $Zamowienie->setZakonczone('1');
            $em->persist($Zamowienie);
            $em->flush();
            $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Produkty', 'a')
                 ->where('a.id_zam = :idzam')
                 ->setParameter('idzam', $result['id'])
                 //->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
             foreach ($produkty_query as $prod)
             {
                 $prod->setStatus('1');
                 $em->persist($Zamowienie);
                 $em->flush();
             }
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete/realizacjadel", 
     *       name="marcin_admin_dashboard_update_realizacjadel",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function updateRealizacjadelAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('anulowane');
            $em->flush();
        
        return new JsonResponse(true);
    }

    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_dashboard_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * 
     * @Template()
     */
    public function formAction(Request $Request, Zamowienia $Zamowienia = NULL) {
        if (null == $Zamowienia) {
            $Zamowienia = new Zamowienia();
            $newZamowieniaForm = TRUE;
        }

        $form = $this->createForm(new TestType(), $Zamowienia);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Zamowienia);
            $em->flush();
            $message = (isset($newZamowieniaForm)) ? 'Poprawnie dodano.' : 'Zamowienie zostało zaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_dashboard', array(
                                'id' => $Zamowienia->getId()
            )));
        }
        
        return $this->render('MarcinAdminBundle:Admin:form.html.twig', array(
                    'pageTitle' => (isset($newZamowieniaForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja zamowienia</small>'),
                    'currPage' => 'zamowienia',
                    'form' => $form->createView(),
                    'zamowienia' => $Zamowienia,
                        )
        );
    }

    private $status_new_zam;
    private $status_send_zam;
    private $new_user_stat;
    private $new_many;
    private $zrelmany;
    private $suma;
    private $zrelsuma;
    private $suma_wyprodukowane;
    private $dzien1;
    private $dzien2;
    private $dzien3;
    private $dzien4;
    private $dzien5;
    private $dzien6;
    private $dzien7;
    private $dzien8;
    private $dzien9;
    private $dzien10;
    private $dzien11;
    private $dzien12;
    private $dzien13;
    private $dzien14;



    /**
     * @Route(
     *       "/{trasy}/{status}/{page}",
     *       name="marcin_admin_dashboard",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1, "trasy"="all"}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page, $trasy) {
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

//        $usr= $this->get('security.token_storage')->getToken()->getUser();
//        foreach ($usr->getRoles() as $test)
//            {
//                if($test == "ROLE_ZAM")
//                    {
//                       return $this->redirect($this->generateUrl('marcin_admin_allzam'));
//                    }
//            }

//        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_PROD', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN')) {
//             return $this->redirect($this->generateUrl('marcin_admin_allzam'));
//        }
                if (false === $this->get('security.authorization_checker')->isGranted('ROLE_PROD')) {
                 return $this->redirect($this->generateUrl('marcin_admin_allzam'));
         }
        
        $queryParams = array(
            'userLike' => $Request->query->get('userLike'),
            'status' => $status,
            'trasy' => $trasy,
            //'limit' => $Request->query->get('limit'),
        );

//        $em = $this->getDoctrine()
//                ->getManager();
//
//        $articles = $em->getRepository('MarcinAdminBundle:Zamowienia')
//                ->getStatistics();
//        
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//        $articles,
//        $Request->query->get('page', 1)/*page number*/,
//        10/*limit per page*/
//    );
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');
        $RepoZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $statistics = $RepoZam->getStatistics();

        $qb = $RepoZam->getQueryBuilder($queryParams);

        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(15, 20, 30, 50, 100);

        $limit = $Request->query->get('limit', $paginationLimit);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $em = $this->getDoctrine()->getManager();
        $produkty_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Produkty', 'a')
                ->addOrderBy('a.id', 'DESC')
                ->setMaxResults(800) //USTAWIENIE OPTYMALIZSUJE WYŚWIETLANIE ZAMOWIENIEŃ NA STRONIE GŁÓWNEJ PANELU!
                 ->getQuery()
                 ->getResult();     
         $a = 0;$b = 0;$c = 0; $d = 0; $e = 0;
         foreach ($produkty_query as $prod)
         {
             $daneprodukty[$a++]['idzam'] = $prod->GetIdzam();
             $daneprodukty[$b++]['typ'] = $prod->GetTyp();
             $daneprodukty[$c++]['kolor'] = $prod->GetKolor();
             $daneprodukty[$d++]['szer'] = $prod->GetSzerokosca();
             $daneprodukty[$e++]['wysokosc'] = $prod->GetWysokosch();
         }
         
         $etapyprodukcji_query = $em->createQueryBuilder('a')
                ->select('a')
                ->from('MarcinAdminBundle:Etapyprodukcji', 'a')
                ->addOrderBy('a.id', 'ASC')
                ->setMaxResults(800) //USTAWIENIE OPTYMALIZSUJE WYŚWIETLANIE ZAMOWIENIEŃ NA STRONIE GŁÓWNEJ PANELU!
                 ->getQuery()
                 ->getResult();  
         
         if ($etapyprodukcji_query == NULL)
         {
             $produkcjaetap[0]['id'] = null;
             $produkcjaetap[0]['idzam'] = null;
             $produkcjaetap[0]['okno'] = null;
             $produkcjaetap[0]['kolor'] = null;
             $produkcjaetap[0]['typ'] = null;
             $produkcjaetap[0]['blad'] = null;
             
             $produkcjaetap[0]['felc'] = null;
             $produkcjaetap[0]['oscieznica'] = null;
             $produkcjaetap[0]['skrzydlo'] = null;
             $produkcjaetap[0]['uwagi'] = null;
             $produkcjaetap[0]['nrprodukcji'] = null;
             $produkcjaetap[0]['profil'] = null;
             $produkcjaetap[0]['stronawiercenia'] = null;
             $produkcjaetap[0]['rodzaj'] = null;
             $produkcjaetap[0]['szerokosc'] = null;
             $produkcjaetap[0]['wysokosc'] = null;
         }
         else
         {
             $aa=0; $bb=0;$cc=0;$dd=0;$ee=0;$ff=0;
         $gg=0;$hh=0;$ii=0;$jj=0;$kk=0;$ll=0;$mm=0;$nn=0;$oo=0;$pp=0;
         $g1=0;$h1=0;$i1=0;$j1=0;$k1=0;$l1=0;$m1=0;$n1=0;$o1=0;
         $z1=0;$y1=0; $x1= 0; $uu1=0;$uu2=0;$uu3=0;$uu4=0;$uu5=0;
         $xxx1=0; $xxx2=0; $xxx3=0; $xxx4=0; $xxx5=0; $xxx6=0; $xxx7=0; $xxx8=0; $xxx9=0;
         foreach ($etapyprodukcji_query as $etapy)
         {
             $produkcjaetap[$aa++]['id'] = $etapy->GetId();
             $produkcjaetap[$bb++]['idzam'] = $etapy->GetNrzamowienia();
             $produkcjaetap[$cc++]['okno'] = $etapy->GetOkno();
             $produkcjaetap[$dd++]['kolor'] = $etapy->GetKolor();
             $produkcjaetap[$ee++]['typ'] = $etapy->GetTyp();
             $produkcjaetap[$ff++]['blad'] = $etapy->GetBlad();
             
             $produkcjaetap[$gg++]['felc'] = $etapy->GetFelc();
             $produkcjaetap[$hh++]['oscieznica'] = $etapy->GetOscieznica();
             $produkcjaetap[$ii++]['skrzydlo'] = $etapy->GetSkrzydlo();
             $produkcjaetap[$jj++]['uwagi'] = $etapy->GetUwagi();
             $produkcjaetap[$kk++]['nrprodukcji'] = $etapy->GetNrprodukcji();
             $produkcjaetap[$ll++]['profil'] = $etapy->GetProfil();
             $produkcjaetap[$mm++]['stronawiercenia'] = $etapy->GetStronawiercenia();
             $produkcjaetap[$nn++]['rodzaj'] = $etapy->GetRodzaj();
             $produkcjaetap[$oo++]['szerokosc'] = $etapy->GetSzerokosc();
             $produkcjaetap[$pp++]['wysokosc'] = $etapy->GetWysokosc();
             
             $produkcjaetap[$g1++]['ilosc'] = $etapy->GetIlosc();
             $produkcjaetap[$h1++]['felcstala'] = $etapy->GetFelcstala();
             
             $produkcjaetap[$i1++]['blaszkast'] = $etapy->GetBlaszkast();
             $produkcjaetap[$j1++]['blaszkaex'] = $etapy->GetBlaszkaex();
             
             $produkcjaetap[$k1++]['stalawys'] = $etapy->GetStalawys();
             $produkcjaetap[$l1++]['stalaszer'] = $etapy->GetStalaszer();
             
             $produkcjaetap[$m1++]['oscieznicastala'] = $etapy->GetOscieznicastala();
             $produkcjaetap[$n1++]['skrzydlostala'] = $etapy->GetSkrzydlostala();
             
             $produkcjaetap[$o1++]['kolorsiatki'] = $etapy->GetKolorsiatki();
             
             $produkcjaetap[$z1++]['cenna'] = $etapy->GetCenna();
             $produkcjaetap[$y1++]['m2'] = $etapy->GetM2();
             
             $produkcjaetap[$x1++]['rabaty'] = $etapy->GetRabaty();
             
             $produkcjaetap[$uu1++]['pilas'] = $etapy->GetPilas();
             $produkcjaetap[$uu2++]['pilah'] = $etapy->GetPilah();
             
             $produkcjaetap[$uu3++]['poziomo'] = $etapy->GetPoziomo();
             $produkcjaetap[$uu4++]['pionowo'] = $etapy->GetPionowo();
             $produkcjaetap[$uu5++]['dowiercenia'] = $etapy->GetDowiercenia();
             
             $produkcjaetap[$xxx1++]['po1'] = $etapy->GetPo1();
             $produkcjaetap[$xxx2++]['po2'] = $etapy->GetPo2();
             $produkcjaetap[$xxx3++]['po3'] = $etapy->GetPo3();
             $produkcjaetap[$xxx4++]['po4'] = $etapy->GetPo4();
             $produkcjaetap[$xxx5++]['pi1'] = $etapy->GetPi1();
             $produkcjaetap[$xxx6++]['pi2'] = $etapy->GetPi2();
             $produkcjaetap[$xxx7++]['pi3'] = $etapy->GetPi3();
             $produkcjaetap[$xxx8++]['pi4'] = $etapy->GetPi4();
             $produkcjaetap[$xxx9++]['pi5'] = $etapy->GetPi5();
             
         }
         }
         
        $statusesList = array(
            'Przesłane' => 'przeslane',
            'W realizacji' => 'realizacja',
            'Wyprodukowane' => 'wyprodukowane',
            'Zrealizowane' =>'zrealizowane',
            'Wszystkie' => 'all'
        );
        $trasyList = array(
            'Poniedziałek' => 'poniedzialek',
            'Wtorek' => 'wtorek',
            'Środa' => 'sroda',
            'Czwartek' =>'czwartek',
            'Piątek' => 'piatek',
            'Tarnów' => 'tarnow',
            'Tadeusz' => 'tadeusz',
            'Odbiór' => 'odbior',
            'Salon' => 'salon',
            'Tuchowska' => 'tuchowska',
            'Montaż' => 'montaz',
            'Wysyłka' => 'wysylka',
            'Wszystkie' => 'all'
        );
        if (!isset($this->status_new_zam)) {
            $this->status_new_zam = $RepoZam->getNewzam();
        }
        if (!isset($this->status_send_zam)) {
            $this->status_send_zam = $RepoZam->getSendzam();
        }
        if (!isset($this->new_user_stat)) {
            $this->new_user_stat = $StatUser->getUserstat();
        }
        if (!isset($this->new_many)) {
            $this->new_many = $RepoZam->getMany();
        }
        if (!isset($this->zrelmany)) {
            $this->zrelmany = $RepoZam->getZrelmany();
        }
        if (!isset($this->suma)) {
            $this->suma = $RepoZam->getSuma();
        }
        if (!isset($this->zrelsuma)) {
            $this->zrelsuma = $RepoZam->getZrelsuma();
        }
        if (!isset($this->suma_wyprodukowane)) {
            $this->suma_wyprodukowane = $RepoZam->getWyprodukowane();
        }
        
         if (!isset($this->dzien1)) {
            $this->dzien1 = $RepoZam->getDzien1();
        }if (!isset($this->dzien2)) {
            $this->dzien2 = $RepoZam->getDzien2();
        }if (!isset($this->dzien3)) {
            $this->dzien3 = $RepoZam->getDzien3();
        }if (!isset($this->dzien4)) {
            $this->dzien4 = $RepoZam->getDzien4();
        }if (!isset($this->dzien5)) {
            $this->dzien5 = $RepoZam->getDzien5();
        }if (!isset($this->dzien6)) {
            $this->dzien6 = $RepoZam->getDzien6();
        }if (!isset($this->dzien7)) {
            $this->dzien7 = $RepoZam->getDzien7();
        }if (!isset($this->dzien8)) {
            $this->dzien8 = $RepoZam->getDzien8();
        }if (!isset($this->dzien9)) {
            $this->dzien9 = $RepoZam->getDzien9();
        }if (!isset($this->dzien11)) {
            $this->dzien11 = $RepoZam->getDzien11();
        }if (!isset($this->dzien10)) {
            $this->dzien10 = $RepoZam->getDzien10();
        }if (!isset($this->dzien12)) {
            $this->dzien12 = $RepoZam->getDzien12();
        }if (!isset($this->dzien13)) {
            $this->dzien13 = $RepoZam->getDzien13();
        }if (!isset($this->dzien14)) {
            $this->dzien14 = $RepoZam->getDzien14();
        }
        
        //$data1 = new \DateTime('- 30 days');
        //echo $data1->format('Y-m-d');

        return $this->render('MarcinAdminBundle:Admin:index.html.twig', array(
                    'pageTitle' => 'GM Panel',
                    //'articles' => $articles,
                    //'pagination' => $pagination,
                    'queryParams' => $queryParams,
                    'limits' => $limits,
                    'currLimit' => $limit,
                    'statusesList' => $statusesList,
                    'trasyList' => $trasyList,
                    //'currStatus' => $status,
                    'statistics' => $statistics,
                    'pagination' => $pagination,
                    'currStatus' => $status,
                    'currTrasy' => $trasy,
                    'produkty' => $daneprodukty,
                    'etapyprodukcji' => $produkcjaetap,
                    'deleteTokenName' => $this->deleteTokenName,
                    'csrfProvider' => $this->get('form.csrf_provider'),
                    'new_zam' => array(
                        'count' => $this->status_new_zam
                    ),
                    'new_user' => array(
                        'count' => $this->new_user_stat
                    ),
                    'new_many' => array(
                        'count' => $this->new_many
                    ),
                    'zrelmany' => array(
                        'count' => $this->zrelmany
                    ),
                    'suma' => array(
                        'count' => $this->suma
                    ),
                    'zrelsuma' => array(
                        'count' => $this->zrelsuma
                    ),
                    'suma_wyprodukowane' => array(
                        'count' => $this->suma_wyprodukowane
                    ),
                    'send_zam' => array(
                        'count' => $this->status_send_zam
                    ),
                    'czas1' => array(
                        'count' => $this->dzien1
                    ),
                    'czas2' => array(
                        'count' => $this->dzien2
                    ),
                    'czas3' => array(
                        'count' => $this->dzien3
                    ),
                    'czas4' => array(
                        'count' => $this->dzien4
                    ),
                    'czas5' => array(
                        'count' => $this->dzien5
                    ),
                    'czas6' => array(
                        'count' => $this->dzien6
                    ),
                    'czas7' => array(
                        'count' => $this->dzien7
                    ),
                    'czas8' => array(
                        'count' => $this->dzien8
                    ),
                    'czas9' => array(
                        'count' => $this->dzien9
                    ),
                    'czas10' => array(
                        'count' => $this->dzien10
                    ),
                    'czas11' => array(
                        'count' => $this->dzien11
                    ),
                    'czas12' => array(
                        'count' => $this->dzien12
                    ),
                    'czas13' => array(
                        'count' => $this->dzien13
                    ),
                    'czas14' => array(
                        'count' => $this->dzien14
                    )
                        )
        );
    }

    /**
     * @Route(
     *      "/usun/{id}/{token}", 
     *      name="marcin_admin_dashboard_delete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @Template()
     */
    public function deleteAction($id, $token) {

        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');

        if (!$csrfProvider->isCsrfTokenValid($tokenName, $token)) {
            $this->addFlash('error', 'Niepoprawny token akcji.');
        } else {

            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Zamid);
            $em->flush();

//            $Proid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Produkty')->findOneBy(array('id_zam' => $id));
//            $em1 = $this->getDoctrine()->getManager();
//            if (!$Proid) {
//             throw $this->createNotFoundException(
//            'No product found for id '.$id
//                );
//            }
//            foreach ($Proid as $Proids) {
//            $em1->remove($Proids);
//            }
//            $em1->remove($Proid);
//            $em1->flush();
            //$em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("DELETE MarcinAdminBundle:Produkty c WHERE c.id_zam = '$id'");
            $query->execute();

            $this->addFlash('success', 'Poprawnie usunięto zamówienie.');
        }

        return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
    }

//        * @Template("MarcinAdminBundle:Admin:update.html.twig")
}
