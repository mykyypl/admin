<?php

namespace Marcin\AdminBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Marcin\AdminBundle\Mailer\UserMailer;
use Marcin\AdminBundle\Mailer\OwnMailer;
use Marcin\AdminBundle\Mailer\InvestMailer;
use Marcin\AdminBundle\Mailer\PartnerMailer;
use Marcin\AdminBundle\Mailer\SelenaMailer;
use Marcin\AdminBundle\Mailer\HannoMailer;
use Marcin\AdminBundle\Mailer\ZygmarMailer;
use Marcin\AdminBundle\Mailer\AwaxMailer;
use Marcin\AdminBundle\Mailer\VipMailer;
use Marcin\SiteBundle\Entity\Shoperzamowienia;
use Marcin\AdminBundle\Exception\UserException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Common\UserBundle\Entity\User;

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
    
    /**
     * @var partnerMailer
     */
    protected $partnerMailer;
    
    /**
     * @var selenaMailer
     */
    protected $selenaMailer;
    
    /**
     * @var hannoMailer
     */
    protected $hannoMailer;
    
    /**
     * @var zygmarMailer
     */
    protected $zygmarMailer;
    
    /**
     * @var awaxMailer
     */
    protected $awaxMailer;
    
    /**
     * @var vipMailer
     */
    protected $vipMailer;
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer, OwnMailer $ownMailer, InvestMailer $investMailer, PartnerMailer $partnerMailer, SelenaMailer $selenaMailer, HannoMailer $hannoMailer, ZygmarMailer $zygmarMailer, AwaxMailer $awaxMailer, VipMailer $vipMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
        $this->ownMailer = $ownMailer;
        $this->investMailer = $investMailer;
        $this->partnerMailer = $partnerMailer;
        $this->selenaMailer = $selenaMailer;
        $this->hannoMailer = $hannoMailer;
        $this->zygmarMailer = $zygmarMailer;
        $this->awaxMailer = $awaxMailer;
        $this->vipMailer = $vipMailer;
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
        foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
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
    
    public function sendInvest($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:invest.html.twig', array(
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
    
    public function sendPartner($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:partner.html.twig', array(
            'partner' => $qb,
            'partner_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->partnerMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->partnerMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function sendSelena($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:selena.html.twig', array(
            'selena' => $qb,
            'selena_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->selenaMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->selenaMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function sendHanno($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:hanno.html.twig', array(
            'hanno' => $qb,
            'hanno_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->hannoMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->hannoMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function sendZygmar($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:zygmar.html.twig', array(
            'zygmar' => $qb,
            'zygmar_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->zygmarMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->zygmarMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function sendAwax($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:awax.html.twig', array(
            'awax' => $qb,
            'awax_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->awaxMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->awaxMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
        public function sendVip($id) {
       
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
         foreach($qb as $wyslane)
        {
            $wyslane->setWyslane('1');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:vip.html.twig', array(
            'vip' => $qb,
            'vip_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 25);
                    $this->vipMailer->send($userEmail, 'Zamówienie '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 20);
                    $this->vipMailer->send($userEmail, 'Zamówienie '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function registerUser(User $User) {
        
        if(null !== $User->getId()){
            throw new UserException('Użytkownik jest już zarejestrowany');
        }
        
        $encoder = $this->encoderFactory->getEncoder($User);
        $encodedPasswd = $encoder->encodePassword($User->getPlainPassword(), $User->getSalt());
        
        $User->setPassword($encodedPasswd);
        $User->setEnabled(false);
        
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        
        return true;
    }
    
    public function changePassword(User $User){
        
        if(null == $User->getPlainPassword()){
            throw new UserException('Nie ustawiono nowego hasła!');
        }
        $encoder = $this->encoderFactory->getEncoder($User);
        $encoderPassword = $encoder->encodePassword($User->getPlainPassword(), $User->getSalt());
        $User->setPassword($encoderPassword);
        $em = $this->doctrine->getManager();
        $em->persist($User);
        $em->flush();
        return true;
    }
}