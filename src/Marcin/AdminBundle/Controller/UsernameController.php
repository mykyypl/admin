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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Marcin\AdminBundle\Entity\Username;
use Marcin\AdminBundle\Entity\Trasa;
use Marcin\AdminBundle\Entity\Zamowieniadmin;
use Marcin\AdminBundle\Entity\Produkty;
use Marcin\AdminBundle\Entity\Adresdostawa;
use Marcin\AdminBundle\Entity\Zamowienia;
use Marcin\AdminBundle\Entity\Rabaty;

use Marcin\AdminBundle\Form\Type\UzytkownicyType;

class UsernameController extends Controller {
    
    private $updateTokenName = 'update-user-%d';
    private $aktywacjaTokenName = 'aktywacja-user-%d';
    private $deleteTokenName = 'delete-user-%d';
    
        /**
     * @Route("/form/admin/admins", 
     *       name="marcin_admin_username_update_admins",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function adminAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'admin' => $Request->request->get('admin'),
            'zaznaczenie' => $Request->request->get('zaznaczenie'),
            'login' => $Request->request->get('login'),
            'aid' => $Request->request->get('aid')
        );

        if (NULL === $result['id']) {
               return new JsonResponse(false);
         }
        
        if ($result['zaznaczenie'] == '1')
        {
            $em = $this->getDoctrine()->getManager();
            $nr = new Zamowieniadmin();
            $nr->setUser($result['login']);
            $nr->setUserpo($result['admin']);
            $em->persist($nr);
            $em->flush();
        } else if($result['zaznaczenie'] == '0')
        {
            $em = $this->getDoctrine()->getManager();
            //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowieniadmin');
            //$Zamowienie = $RepoZamowienia->find($result['aid']);
              $delluser = $em->createQueryBuilder()
                    ->select('a')
                    ->from('MarcinAdminBundle:Zamowieniadmin', 'a')
                     ->where('a.user = :identifier')
                     ->setParameter('identifier', $result['login'])
                     ->andwhere('a.user_po = :identifier1')
                      ->setParameter('identifier1', $result['admin'])
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getResult();
              
            if (NULL === $delluser) {
            return new JsonResponse(false);
        } else {
            
        }
        foreach ($delluser as $usuwanie) {
            $em->remove($usuwanie);
            //$Zamowienie->setStatus('w realizacji');
            $em->flush();
        }
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/form/update-complete", 
     *       name="marcin_admin_username_update_trasa",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function updateZamAction(Request $Request) {

        $result = array(
            'id' => $Request->request->get('id'),
            'status' => $Request->request->get('status')
        );

        $RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');
        $Zamowienie = $RepoZamowienia->find($result['id']);

        if (NULL === $Zamowienie) {
            return new JsonResponse(false);
        }
        
        
        $em = $this->getDoctrine()->getManager();
        $Zamowienie->setTrasa($result['status']);
        $em->flush();
        
        return new JsonResponse(true);

    }
    
    /**
     * @Route("/form/update-complete/add", 
     *       name="marcin_admin_username_update_add",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function addRabatAction(Request $Request) {

        $result = array(
            'uzytkownik' => $Request->request->get('uzytkownik'),
            'typzam' => $Request->request->get('typzam'),
            'platnosc' => $Request->request->get('platnosc'),
            'rabat' => $Request->request->get('rabat')
        );

        //$RepoZamowienia = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');
        //$Zamowienie = $RepoZamowienia->find($result['id']);

        //if (NULL === $Zamowienie) {
         //   return new JsonResponse(false);
       // }
        $Rabaty = new Rabaty();
        $em = $this->getDoctrine()->getManager();
        $Rabaty->setUser($result['uzytkownik']);
        if($result['platnosc'] == '1')
        {
            $Rabaty->setPlatnosc('Przedpłata 100%');
        }
        elseif ($result['platnosc'] == '2') 
        {
            $Rabaty->setPlatnosc('Gotówka przy odbiorze');
        }
        elseif ($result['platnosc'] == '3')
        {
            $Rabaty->setPlatnosc('Przelew (mniejszy rabat)');
        }
        $Rabaty->setTypzamowienia($result['typzam']);
        $Rabaty->setRabat($result['rabat']);
        $em->persist($Rabaty);
        $em->flush();
        
        return new JsonResponse(true);

    }
    
    /**
     * @Route("/form/update-complete/edit", 
     *       name="marcin_admin_username_update_edit",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function editRabatAction(Request $Request) {

        $result = array(
            'uzytkownik' => $Request->request->get('uzytkownik'),
            'typzam' => $Request->request->get('typzam'),
            'platnosc' => $Request->request->get('platnosc'),
            'rabat' => $Request->request->get('rabat')
        );

        if($result['platnosc'] == '1')
        {
            $wartosc = 'Przedpłata 100%';
        }
        elseif ($result['platnosc'] == '2') 
        {
            $wartosc = 'Gotówka przy odbiorze';
        }
        elseif ($result['platnosc'] == '3')
        {
           $wartosc = 'Przelew (mniejszy rabat)';
        }
        
        $em = $this->getDoctrine()->getManager();
        $rabaty = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Rabaty', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $result['uzytkownik'])
                 ->andwhere('a.platnosc = :platnosc')
                 ->setParameter('platnosc', $wartosc)
                 ->andwhere('a.typ_zamowienia = :typ')
                 ->setParameter('typ', $result['typzam'])
                 ->getQuery()
                 ->getResult();
        
        if (NULL === $rabaty) {
            return new JsonResponse(false);
        }
        
        $rabaty[0]->setRabat($result['rabat']);
        $em->flush();
        
        return new JsonResponse(true);

    }
    
    /**
     * @Route("/form/update-complete/dell", 
     *       name="marcin_admin_username_update_dell",
     *       requirements={
     *          "_format": "json",
     *          "methods": "POST"
     *      }
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *
     */
    public function dellRabatAction(Request $Request) {

        $result = array(
            'uzytkownik' => $Request->request->get('uzytkownik'),
            'typzam' => $Request->request->get('typzam'),
            'platnosc' => $Request->request->get('platnosc'),
            'rabat' => $Request->request->get('rabat')
        );

        if($result['platnosc'] == '1')
        {
            $wartosc = 'Przedpłata 100%';
        }
        elseif ($result['platnosc'] == '2') 
        {
            $wartosc = 'Gotówka przy odbiorze';
        }
        elseif ($result['platnosc'] == '3')
        {
           $wartosc = 'Przelew (mniejszy rabat)';
        }
        
        $em = $this->getDoctrine()->getManager();
        $rabaty = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Rabaty', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $result['uzytkownik'])
                 ->andwhere('a.platnosc = :platnosc')
                 ->setParameter('platnosc', $wartosc)
                 ->andwhere('a.typ_zamowienia = :typ')
                 ->setParameter('typ', $result['typzam'])
                 ->getQuery()
                 ->getResult();
        
        if (NULL === $rabaty) {
            return new JsonResponse(false);
        }
        foreach ($rabaty as $usuwanie) {
           $em->remove($usuwanie);
           $em->flush();
        }
        
        return new JsonResponse(true);

    }
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_username_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Username $Uzytkownicy = NULL) {
        if (null == $Uzytkownicy) {
            $Uzytkownicy = new Username();
            $newUzytkownicyForm = TRUE;
        }
        
        $em = $this->getDoctrine()->getManager();
        
//        $query_user = $em->createQuery(
//            'SELECT p
//            FROM MarcinAdminBundle:Username p'
//        );
        
        $listuser = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Username', 'a')
                 ->addOrderBy('a.login', 'ASC')
                 ->getQuery()
                 ->getResult();
        
        $zamowienia_user = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Username', 'a')
                 ->where('a.id = :identifier')
                 ->setParameter('identifier', $Uzytkownicy)
                 ->getQuery()
                 ->getResult();
         foreach ($zamowienia_user as $zamas)
            {
                $uzytkownik = $zamas->GetLogin();
            }
            
        $admin = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowieniadmin', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $uzytkownik)
                 ->getQuery()
                 ->getResult();
        
        $dane_faktura = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Faktura', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $uzytkownik)
                 ->getQuery()
                 ->getResult();
        $a = 0; $b = 0; $c = 0; $d = 0; $e = 0; $f = 0;
         foreach ($dane_faktura as $faktura)
        {
             $fakt[$a++]['nip'] = $faktura->GetNip();
             $fakt[$b++]['ulica'] = $faktura->GetUlica();
             $fakt[$c++]['kodpocztowy'] = $faktura->GetKodpocztowy();
             $fakt[$d++]['miasto'] = $faktura->GetMiasto();
             $fakt[$e++]['telefon'] = $faktura->GetTelefon();
             $fakt[$f++]['nazwafirmy'] = $faktura->GetNazwafirmy();
         }
        $dane_dostawa = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Adresdostawa', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $uzytkownik)
                 ->getQuery()
                 ->getResult();
        $aa = 0; $bb = 0; $cc = 0; $dd = 0; $ee = 0; $ff = 0;
         foreach ($dane_dostawa as $dostawa)
        {
             $dost[$bb++]['ulica'] = $dostawa->GetUlica();
             $dost[$cc++]['kodpocztowy'] = $dostawa->GetKodpocztowy();
             $dost[$dd++]['miejscowosc'] = $dostawa->GetMiejscowowsc();
             $dost[$ee++]['telefon'] = $dostawa->GetTelefon();
             $dost[$ff++]['nazwafirmy'] = $dostawa->GetNazwafirmy();
         }
         
         $rabaty = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Rabaty', 'a')
                 ->where('a.user = :identifier')
                 ->setParameter('identifier', $uzytkownik)
                 ->getQuery()
                 ->getResult();
         
         if ($rabaty == null)
         {
            $rabat[0]['user'] = $uzytkownik;
            $rabat[0]['platnosc'] = null;
            $rabat[0]['typ'] = null;
            $rabat[0]['rabat'] = null;
         }
         else {
             $z = 0; $x = 0; $v = 0; $n = 0;
            foreach ($rabaty as $rabatybaza)
            {
                $rabat[$z++]['user'] = $rabatybaza->GetUser();
                $rabat[$x++]['platnosc'] = $rabatybaza->GetPlatnosc();
                $rabat[$v++]['typ'] = $rabatybaza->GetTypzamowienia();
                $rabat[$n++]['rabat'] = $rabatybaza->GetRabat();
            }
         }
        
        $form = $this->createForm(new UzytkownicyType(), $Uzytkownicy);

        $form->handleRequest($Request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Uzytkownicy);
            $em->flush();
            $message = (isset($newUzytkownicyForm)) ? 'Poprawnie dodano.' : 'Użytkownik został zaaktualizowany.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_username_form', array(
                                'id' => $Uzytkownicy->getId()
            )));
        }

        return $this->render('MarcinAdminBundle:Username:form.html.twig', array(
                    'pageTitle' => (isset($newUzytkownicyForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja użytkownika</small>'),
                    'currPage' => 'uzytkownicy',
                    'form' => $form->createView(),
                    'uzytkownicy' => $Uzytkownicy,
                    'admin' => $admin,
                    'user' => $zamowienia_user,
                    'listuser' => $listuser,
                    'faktura' => $fakt,
                    'dostawa' => $dost,
                    'rabat' => $rabat
                        )
        );
    }
    
    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_username",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * 
     * )
     * @Security("has_role('ROLE_MAGNUM')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $page)
    {
      
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),

        ); 
     
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Username');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM MarcinAdminBundle:Trasa p'
        );

        $trasa = $query->getResult();
        
        $qb = $StatUser->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(2, 5, 10, 15);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        $statusesList = array(
            'Opublikowane' => 'published',
            'Nieopublikowane' => 'unpublished',
            'Wszystkie' => 'all'
        );
        
        $nip_query = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Faktura', 'a')
                 ->getQuery()
                 ->getResult();
        $a = 0;$b = 0;
         foreach ($nip_query as $nip)
         {
             $dane[$a++]['nip'] = $nip->GetNip();
             $dane[$b++]['user'] = $nip->GetUser();
         }
        
        return $this->render('MarcinAdminBundle:Username:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel USER',
            //'articles' => $articles,
           //'pagination' => $pagination,
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
           // 'statistics' => $statistics,
            'pagination' => $pagination,
                'trasa' => $trasa,
                'dane' => $dane,
            'updateTokenName' => $this->updateTokenName,
            'aktywacjaTokenName' => $this->aktywacjaTokenName,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
    
    /**
     * @Route(
     *      "/update/{id}/{token}", 
     *      name="marcin_admin_username_update",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function updateAction($id, $token) {
        
        $tokenName = sprintf($this->updateTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->addFlash('error', 'Niepoprawny token akcji.');
            
        }else{
          
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("UPDATE MarcinAdminBundle:Username c SET c.new = '0' WHERE c.id = '$id'");
            $query->execute(); 
            
            $this->addFlash('success', 'Poprawnie odczytano.');
        }
        
        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
    
    /**
     * @Route(
     *      "/aktywacja/{id}/{token}", 
     *      name="marcin_admin_username_aktywacja",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_MAGNUM')")
     * 
     * @Template()
     */
    public function aktywacjaAction($id, $token) {
        
        $tokenName = sprintf($this->aktywacjaTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->addFlash('error', 'Niepoprawny token akcji.');
            
        }else{
          
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("UPDATE MarcinAdminBundle:Username c SET c.aktywacja = 'tak' WHERE c.id = '$id'");
            $query->execute(); 
            
            $this->addFlash('success', 'Poprawnie aktywowano konto.');
        }
        
        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
    
    /**
     * @Route(
     *      "/usun/{id}/{username}/{token}", 
     *      name="marcin_admin_username_delete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Security("has_role('ROLE_ADMIN')")
     * 
     * @Template()
     */
    public function deleteAction($id, $username, $token) {

        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');

        if (!$csrfProvider->isCsrfTokenValid($tokenName, $token)) {
            $this->addFlash('error', 'Niepoprawny token akcji.');
        } else {

//            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
            $em = $this->getDoctrine()->getManager();
//            $em->remove($Zamid);
//            $em->flush();

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
            $query = $em->createQuery("DELETE MarcinAdminBundle:Produkty c WHERE c.user = '$username'");
            $query->execute();
            $query_dane = $em->createQuery("DELETE MarcinAdminBundle:Adresdostawa c WHERE c.user = '$username'");
            $query_dane->execute();
            $query_faktura = $em->createQuery("DELETE MarcinAdminBundle:Faktura c WHERE c.user = '$username'");
            $query_faktura->execute();
            $query_zamowienia = $em->createQuery("DELETE MarcinAdminBundle:Zamowienia c WHERE c.user = '$username'");
            $query_zamowienia->execute();
            $query_username = $em->createQuery("DELETE MarcinAdminBundle:Username c WHERE c.login = '$username'");
            $query_username->execute();

            $this->addFlash('success', 'Poprawnie usunięto użytkownika z powiązaniami!.');
        }

        return $this->redirect($this->generateUrl('marcin_admin_username'));
    }
}