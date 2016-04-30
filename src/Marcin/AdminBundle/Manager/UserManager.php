<?php

namespace Marcin\AdminBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Marcin\AdminBundle\Mailer\UserMailer;
use Marcin\AdminBundle\Mailer\OwnMailer;
use Marcin\AdminBundle\Mailer\InvestMailer;
use Marcin\SiteBundle\Entity\Shoperzamowienia;
use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserManager {
    
    /**
     * @var Doctrine
     */
    protected $doctrine;
        
    /**
     * @var Router
     */
    protected $router;
    
    /**
     * @var Templating 
     */
    protected $templating;
    
    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;
    
    /**
     * @var UserMailer
     */
    protected $userMailer;
    
    /**
     * @var ownMailer
     */
    protected $ownMailer;
    
    /**
     * @var investMailer
     */
    protected $investMailer;
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer, OwnMailer $ownMailer, InvestMailer $investMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
        $this->ownMailer = $ownMailer;
        $this->investMailer = $ownMailer;
    }
    
    public function registerUsername($id, $idzam) {
       
        $em = $this->doctrine->getManager();
        
        $qb = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.idposrednik = :identifier')
                 ->setParameter('identifier', $id)
               //->setMaxResults(1)
                ->getQuery()
                ->getResult();

        $qb_dane = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperklinar', 'a')
                 ->where('a.id = :identifier')
                 ->setParameter('identifier', $id)
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        
        foreach($qb_dane as $odznaczenie)
        {
                        $odznaczenie->setDatawyslania(new \DateTime());
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:pay.html.twig', array(
            'klinar' => $qb,
            'klinar_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->userMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->userMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
        public function checkKlinar($id) {
       
        $em = $this->doctrine->getManager();
        
        $qb = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.idposrednik = :identifier')
                 ->setParameter('identifier', $id)
               //->setMaxResults(1)
                ->getQuery()
                ->getResult();

        $qb_dane = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperklinar', 'a')
                 ->where('a.id = :identifier')
                 ->setParameter('identifier', $id)
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        
        foreach($qb_dane as $odznaczenie)
        {
                        $odznaczenie->setOstzmianapofaktura(new \DateTime());
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:own.html.twig', array(
            'klinar' => $qb,
            'klinar_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->ownMailer->send($userEmail, 'Zmiana w panelu Klinar '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->ownMailer->send($userEmail, 'Zmiana w panelu Klinar '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
//    public function activateAccount($actionToken){
//        $User = $this->doctrine->getRepository('CommonUserBundle:User')
//                        ->findOneByActionToken($actionToken);
//        
//        if(null === $User){
//            throw new UserException('Podano błędnę parametry akcji.');
//        }
//        
//        $User->setEnabled(true);
//        $User->setActionToken(null);
//        
//        $em = $this->doctrine->getManager();
//        $em->persist($User);
//        $em->flush();
//        
//        return true;
//    }
    
    public function sendInvest($id, $idzam) {
       
        $em = $this->doctrine->getManager();
        
        $qb = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperzamowienia', 'a')
                 ->where('a.idposrednik = :identifier')
                 ->setParameter('identifier', $id)
               //->setMaxResults(1)
                ->getQuery()
                ->getResult();

        $qb_dane = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinSiteBundle:Shoperklinar', 'a')
                 ->where('a.id = :identifier')
                 ->setParameter('identifier', $id)
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        
        foreach($qb_dane as $odznaczenie)
        {
                        $odznaczenie->setDatawyslania(new \DateTime());
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:pay.html.twig', array(
            'invest' => $qb,
            'invest_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->investMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->investMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
}