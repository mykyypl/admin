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
use Marcin\AdminBundle\Form\Type\TestType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PaneltrasaController extends Controller {
    
    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_paneltrasa_update",
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
            'zaplacono' => $Request->request->get('zaplacono')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        if($result['zaplacono'] == '1')
        {
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setStatus('zrealizowane/odebrane');
        $Zamowienie->setZaplacono($result['zaplacono']);
        $em->flush();
        }
        elseif ($result['zaplacono'] == '0')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w dostawie');
            $Zamowienie->setZaplacono($result['zaplacono']);
            $em->flush();
        }
        elseif ($result['zaplacono'] == '2')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('zrealizowane/odebrane');
            $em->flush();
        }
        elseif ($result['zaplacono'] == '3')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w dostawie');
            $em->flush();
        }elseif ($result['zaplacono'] == '4')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('przesłane do realizacji');
            $Zamowienie->setJakie_zam('wydanie zewnętrzne');
            $em->flush();
        }elseif ($result['zaplacono'] == '5')
        {
            $em = $this->getDoctrine()->getManager();
            $Zamowienie->setStatus('w dostawie');
            $Zamowienie->setJakie_zam('zgłoszenie do odbioru');
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
     /**
     * @Route("/form/update-complete/all/zam", 
     *       name="marcin_admin_paneltrasa_zaplacono_all",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_PROD')")
     *
     */
    public function allZamAction(Request $Request) {

        $result = array(
            'nazwa' => $Request->request->get('nazwa'),
            'warunek' => $Request->request->get('warunek')
        );

        //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        //$Zamowienie = $RepoZamowienia->find($result['id']);
        
        if($result['warunek'] == '1')
        {
             $em = $this->getDoctrine()->getManager();
             $zamowienia_pierwszy = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.status = :status OR a.status = :przyjete OR a.status =:dostawa')
                 ->setParameter('status', 'w dostawie')
                 ->setParameter('przyjete', 'wysłane')
                 ->setParameter('dostawa', 'gotowe do odbioru/montażu')
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                 ->andwhere('a.user = :uzytkownik')
                 ->setParameter('uzytkownik', $result['nazwa'])
                 ->getQuery()
                 ->getResult();
             
             
              foreach ($zamowienia_pierwszy as $pierwszy)
                {
                    $dane = $pierwszy->GetJakie_zam();
                    if ($dane == "zgłoszenie do odbioru")
                    {
                        
                    }
                     else {
                             $pierwszy->setStatus('zrealizowane/odebrane');
                             $pierwszy->setZaplacono('1');
                             $em->flush();
                     }
                }
        }
        elseif ($result['warunek'] == '3')
        {
             $em = $this->getDoctrine()->getManager();
             $zamowienia_pierwszy = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.status = :status OR a.status = :przyjete OR a.status =:dostawa')
                 ->setParameter('status', 'w dostawie')
                 ->setParameter('przyjete', 'wysłane')
                 ->setParameter('dostawa', 'gotowe do odbioru/montażu')
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                 ->andwhere('a.user = :uzytkownik')
                 ->setParameter('uzytkownik', $result['nazwa'])
                 ->getQuery()
                 ->getResult();
             
              foreach ($zamowienia_pierwszy as $pierwszy)
                {
                    $dane = $pierwszy->GetJakie_zam();
                    if ($dane == "zgłoszenie do odbioru")
                    {
                        $pierwszy->setStatus('przesłane do realizacji');
                        $pierwszy->setJakie_zam('wydanie zewnętrzne');
                        $em->flush();
                    }
                     else {
                             $pierwszy->setStatus('zrealizowane/odebrane');
                             $em->flush();
                     }
                }
        }
//        
//        if (NULL === $Zamowienie) {
//            return new JsonResponse(false);
//        }
//        
        
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_paneltrasa",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1}
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page) {
        
        $queryParams = array(
            'userLike' => $Request->query->get('userLike'),
            'status' => $status
            //'limit' => $Request->query->get('limit'),
        );
        $RepoZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $statistics = $RepoZam->getStatisticsPaneltrasa();

        $qb = $RepoZam->getQueryPaneltrasaBuilder($queryParams);

        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(15, 20, 30, 50, 100);

        $limit = $Request->query->get('limit', $paginationLimit);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);

        $statusesList = array(
            'Poniedziałek' => 'poniedzialek',
            'Wtorek' => 'wtorek',
            'Środa' => 'sroda',
            'Czwartek' =>'czwartek',
            'Piątek' =>'piatek',
            'Tarnów' =>'tarnow',
            'Tadeusz' =>'tadeusz',
            'Odbiór' =>'odbior',
            'Salon' =>'salon',
            'Tuchowska' =>'tuchowska',
            'Montaż' =>'montaz',
            'Wysyłka' =>'wysylka',
            'Wszystkie' => 'all'
        );
        
        if ($status == 'all')
        {
        
        $em = $this->getDoctrine()->getManager();
        $zamowienia_query = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.status = :status OR a.status = :przyjete OR a.status =:dostawa')
                 ->setParameter('status', 'w dostawie')
                 ->setParameter('przyjete', 'wysłane')
                 ->setParameter('dostawa', 'gotowe do odbioru/montażu')
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                  ->addOrderBy('a.nrprodukcji', 'ASC')
                 ->getQuery()
                 ->getResult();
        }
        else {
            $em = $this->getDoctrine()->getManager();
        $zamowienia_query = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.status = :status OR a.status = :przyjete OR a.status =:dostawa')
                 ->setParameter('status', 'w dostawie')
                 ->setParameter('przyjete', 'wysłane')
                 ->setParameter('dostawa', 'gotowe do odbioru/montażu')
                 ->andwhere('a.trasa = :identifier')
                 ->setParameter('identifier', $status)
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                  ->addOrderBy('a.nrprodukcji', 'ASC')
                 ->getQuery()
                 ->getResult();
            
        }
        
        $a = 0;
        if ($zamowienia_query == null)
        {
            $dane[1]['user'] = null;
        }
            else
        {
            foreach ($zamowienia_query as $zamowienia)
                {
                    $dane[$a++]['user'] = $zamowienia->GetUser();
                }
            $dane = array_map("unserialize", array_unique(array_map("serialize", $dane)));
        }
        return $this->render('MarcinAdminBundle:Paneltrasa:index.html.twig', array(
                    'pageTitle' => 'GM Panel trasy',
                    //'articles' => $articles,
                    //'pagination' => $pagination,
                    'queryParams' => $queryParams,
                    'dane' => $dane,
                    'limits' => $limits,
                    'currLimit' => $limit,
                    'statusesList' => $statusesList,
                    'currStatus' => $status,
                    'statistics' => $statistics,
                    'pagination' => $pagination,
                    'currStatus' => $status
                        )
        );
    }
    
    /**
     * @Route(
     *       "generowanie/trasy/{status}",
     *       name="marcin_admin_paneltrasa_generowanie"
     * )
     * @Security("has_role('ROLE_PROD')")
     *    
     * @Template()
     */
    public function generowanieAction(Request $Request, $status) {
        $queryParams = array(
            'idzamLike' => $Request->query->get('idzamLike')

        ); 
     
        $StatZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
       // $statistics = $StatZam->getStatisticszygmar();
        
       // $qb = $StatZam->getTrasaPoniedzialekBuilder($queryParams);
        
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
                 ->setParameter('identifier', $status)
                 ->andwhere('a.status = :status OR a.status = :przyjete OR a.status =:dostawa')
                 ->setParameter('status', 'w dostawie')
                 ->setParameter('przyjete', 'wysłane')
                 ->setParameter('dostawa', 'gotowe do odbioru/montażu')
                  ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
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
        //echo "testttttttttttt";
        //print_r($lista_prod);
        }
        return $this->render('MarcinAdminBundle:Paneltrasa:generowanie.html.twig',
            array(
            'pageTitle'            => 'GM Panel Trasa',
            'queryParams' => $queryParams,
                'trasa' => $trasa,
                'dane'=> $dane,
                'produkty' => $produkty,
                'lista' => $lista_prod,
                'status' => $status,
                'faktura' => $faktura
                )
        );
    }
    
}