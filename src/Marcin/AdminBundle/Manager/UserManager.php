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

use Marcin\AdminBundle\Mailer\AwaxcheckMailer;
use Marcin\AdminBundle\Mailer\VipcheckMailer;
use Marcin\AdminBundle\Mailer\InvestcheckMailer;
use Marcin\AdminBundle\Mailer\PartnercheckMailer;
use Marcin\AdminBundle\Mailer\SelenacheckMailer;
use Marcin\AdminBundle\Mailer\HannocheckMailer;
use Marcin\AdminBundle\Mailer\ZygmarcheckMailer;

use Marcin\AdminBundle\Mailer\ZamowieniaMailer;
use Marcin\AdminBundle\Mailer\AnulowanieMailer;

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
    
    /**
     * @var awaxcheckMailer
     */
    protected $awaxcheckMailer;
    
    /**
     * @var vipcheckMailer
     */
    protected $vipcheckMailer;
    
    /**
     * @var hannocheckMailer
     */
    protected $hannocheckMailer;
    
    /**
     * @var investcheckMailer
     */
    protected $investcheckMailer;
    
    /**
     * @var partnercheckMailer
     */
    protected $partnercheckMailer;
    
    /**
     * @var selenacheckMailer
     */
    protected $selenacheckMailer;
    
    /**
     * @var zygmarcheckMailer
     */
    protected $zygmarcheckMailer;
    
    /**
     * @var zamowieniaMailer
     */
    protected $zamowieniaMailer;
    
    /**
     * @var anulowanieMailer
     */
    protected $anulowanieMailer;
    
    
    function __construct(Doctrine $doctrine,
            Router $router,
            Templating $templating,
            EncoderFactory $encoderFactory,
            UserMailer $userMailer,
            OwnMailer $ownMailer,
            InvestMailer $investMailer,
            PartnerMailer $partnerMailer,
            SelenaMailer $selenaMailer,
            HannoMailer $hannoMailer,
            ZygmarMailer $zygmarMailer,
            AwaxMailer $awaxMailer,
            VipMailer $vipMailer,
            AwaxcheckMailer $awaxcheckMailer,
            VipcheckMailer $vipcheckMailer,
            InvestcheckMailer $investcheckMailer,
            PartnercheckMailer $partnercheckMailer,
            SelenacheckMailer $selenacheckMailer,
            HannocheckMailer $hannocheckMailer,
            ZygmarcheckMailer $zygmarcheckMailer,
            ZamowieniaMailer $zamowieniaMailer,
            AnulowanieMailer $anulowanieMailer
            )
            {
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
        $this->awaxcheckMailer = $awaxcheckMailer;
        $this->vipcheckMailer = $vipcheckMailer;
        $this->investcheckMailer = $investcheckMailer;
        $this->partnercheckMailer = $partnercheckMailer;
        $this->selenacheckMailer = $selenacheckMailer;
        $this->hannocheckMailer = $hannocheckMailer;
        $this->zygmarcheckMailer = $zygmarcheckMailer;
        $this->zamowieniaMailer = $zamowieniaMailer;
        $this->anulowanieMailer = $anulowanieMailer;
        
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
    
    public function checkPartner($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:partnercheck.html.twig', array(
            'partner' => $qb,
            'partner_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->partnercheckMailer->send($userEmail, 'Zmiana w panelu PartnerPlast '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->partnercheckMailer->send($userEmail, 'Zmiana w panelu PartnerPlast '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
        public function checkInvest($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:investcheck.html.twig', array(
            'invest' => $qb,
            'invest_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->investcheckMailer->send($userEmail, 'Zmiana w panelu Invest '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->investcheckMailer->send($userEmail, 'Zmiana w panelu Invest '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
        public function checkSelena($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:selenacheck.html.twig', array(
            'selena' => $qb,
            'selena_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->selenacheckMailer->send($userEmail, 'Zmiana w panelu Selena '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->selenacheckMailer->send($userEmail, 'Zmiana w panelu Selena '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function checkHanno($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:hannocheck.html.twig', array(
            'hanno' => $qb,
            'hanno_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->hannocheckMailer->send($userEmail, 'Zmiana w panelu Stier '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->hannocheckMailer->send($userEmail, 'Zmiana w panelu Stier '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function checkAwax($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:awaxcheck.html.twig', array(
            'awax' => $qb,
            'awax_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->awaxcheckMailer->send($userEmail, 'Zmiana w panelu Awax '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->awaxcheckMailer->send($userEmail, 'Zmiana w panelu Awax '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function checkZygmar($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:zygmarcheck.html.twig', array(
            'zygmar' => $qb,
            'zygmar_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->zygmarcheckMailer->send($userEmail, 'Zmiana w panelu Zygmar '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->zygmarcheckMailer->send($userEmail, 'Zmiana w panelu Zygmar '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function checkVip($id) {
       
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
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:vipcheck.html.twig', array(
            'vip' => $qb,
            'vip_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
        $userEmail = 'marcin@grupamagnum.eu';
        if (!$tytul == '')
        {
                    $tytul_email = substr($tytul, 0, 35);
                    $this->vipcheckMailer->send($userEmail, 'Zmiana w panelu VIP '.$tytul_email, $emaiBody);
        }
        else {
                    $tytul_email_nazwisko = substr($tytul_nazwisko, 0, 30);
                    $this->vipcheckMailer->send($userEmail, 'Zmiana w panelu VIP '.$tytul_email_nazwisko, $emaiBody);
        }
        
        return true;
    }
    
    public function sendEmail($trasastat, $user, $idzam) {
        $em = $this->doctrine->getManager();
        $qb_email = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Username', 'a')
                 ->where('a.login = :identifier')
                 ->setParameter('identifier', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        foreach ($qb_email as $email) {
            $daneEmail = $email->getEmail();
        }
        $qb_zamowienia = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.trasa = :identifier')
                 ->setParameter('identifier', $trasastat)
                ->andwhere('a.user = :user')
                 ->setParameter('user', $user)
                 ->andwhere('a.status = :status')
                 ->setParameter('status', 'wyprodukowane')
                ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                 ->andwhere('a.id_dost = :dost')
                 ->setParameter('dost', $idzam)
                //->setMaxResults(1)
                ->getQuery()
                ->getResult();
        if ($qb_zamowienia == null) {
             //$this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
              //return $this->redirect($this->generateUrl('marcin_admin_trasa'));
            echo "BŁĄD - brak danych";
           
        }
        $a = 0;$b= 0; $c = 0; $d = 0; $e = 0; $f = 0; $g = 0; $h = 0;$i = 0;
        $aa = 0;$bb = 0; $cc = 0;$dd = 0;$ee = 0;$ff = 0;
        foreach ($qb_zamowienia as $zamowienia)
        {
            $dane[$a++]['id'] = $zamowienia->getId();
            $dane[$b++]['nruser'] = $zamowienia->GetNr_user_zam();
            $dane[$c++]['dostawa'] = $zamowienia->GetIddost();
            $dane[$d++]['platnosc'] = $zamowienia->GetPlatnosc();
            $dane[$e++]['nrprodukcji'] = $zamowienia->GetNrprodukcji();
            $dane[$f++]['dozaplaty'] = $zamowienia->GetDozaplaty();
            $dane[$g++]['jakiezam'] = $zamowienia->GetJakie_zam();
            $dane[$i++]['zaplacono'] = $zamowienia->GetZaplacono();
            //$dane[$h++]['id'] = $zamowienia->GetId();
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
            $zamowienia->setStatus('w dostawie');
             $em->flush();
        }
        
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:sendzam.html.twig', array(
            'dane' => $dane,
            'lista' => $lista_prod
        ));
        
        $this->zamowieniaMailer->send($daneEmail, 'Dostawa zamówienia GrupaMAGNUM ', $emaiBody);
        
        return true;
    }
    
    public function sendEmailo($trasastat, $user, $idzam) {
        $em = $this->doctrine->getManager();
        $qb_email = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Username', 'a')
                 ->where('a.login = :identifier')
                 ->setParameter('identifier', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        foreach ($qb_email as $email) {
            $daneEmail = $email->getEmail();
        }
        $qb_zamowienia = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.trasa = :identifier')
                 ->setParameter('identifier', $trasastat)
                ->andwhere('a.user = :user')
                 ->setParameter('user', $user)
                 ->andwhere('a.status = :status')
                 ->setParameter('status', 'wyprodukowane')
                ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                 ->andwhere('a.id_dost = :dost')
                 ->setParameter('dost', $idzam)
                //->setMaxResults(1)
                ->getQuery()
                ->getResult();
        if ($qb_zamowienia == null) {
             //$this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
              //return $this->redirect($this->generateUrl('marcin_admin_trasa'));
            echo "BŁĄD - brak danych";
           
        }
        $a = 0;$b= 0; $c = 0; $d = 0; $e = 0; $f = 0; $g = 0; $h = 0;$i = 0;
        $aa = 0;$bb = 0; $cc = 0;$dd = 0;$ee = 0;$ff = 0;
        foreach ($qb_zamowienia as $zamowienia)
        {
            $dane[$a++]['id'] = $zamowienia->getId();
            $dane[$b++]['nruser'] = $zamowienia->GetNr_user_zam();
            $dane[$c++]['dostawa'] = $zamowienia->GetIddost();
            $dane[$d++]['platnosc'] = $zamowienia->GetPlatnosc();
            $dane[$e++]['nrprodukcji'] = $zamowienia->GetNrprodukcji();
            $dane[$f++]['dozaplaty'] = $zamowienia->GetDozaplaty();
            $dane[$g++]['jakiezam'] = $zamowienia->GetJakie_zam();
            $dane[$i++]['zaplacono'] = $zamowienia->GetZaplacono();
            //$dane[$h++]['id'] = $zamowienia->GetId();
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
            $zamowienia->setStatus('gotowe do odbioru/montażu');
             $em->flush();
        }
        
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:sendzamo.html.twig', array(
            'dane' => $dane,
            'lista' => $lista_prod
        ));
        
        $this->zamowieniaMailer->send($daneEmail, 'Dostawa zamówienia GrupaMAGNUM ', $emaiBody);
        
        return true;
    }
    
        public function sendEmailw($trasastat, $user, $idzam) {
        $em = $this->doctrine->getManager();
        $qb_email = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Username', 'a')
                 ->where('a.login = :identifier')
                 ->setParameter('identifier', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();
        foreach ($qb_email as $email) {
            $daneEmail = $email->getEmail();
        }
        $qb_zamowienia = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Zamowienia', 'a')
                 ->where('a.trasa = :identifier')
                 ->setParameter('identifier', $trasastat)
                ->andwhere('a.user = :user')
                 ->setParameter('user', $user)
                 ->andwhere('a.status = :status')
                 ->setParameter('status', 'wyprodukowane')
                ->andwhere('a.trasaok = :trasaok')
                 ->setParameter('trasaok', '1')
                 ->andwhere('a.id_dost = :dost')
                 ->setParameter('dost', $idzam)
                //->setMaxResults(1)
                ->getQuery()
                ->getResult();
        if ($qb_zamowienia == null) {
             //$this->addFlash('error', 'Błąd generowania formularza! sprawdź dane!');
              //return $this->redirect($this->generateUrl('marcin_admin_trasa'));
            echo "BŁĄD - brak danych";
           
        }
        $a = 0;$b= 0; $c = 0; $d = 0; $e = 0; $f = 0; $g = 0; $h = 0;$i = 0;
        $aa = 0;$bb = 0; $cc = 0;$dd = 0;$ee = 0;$ff = 0;
        $a1 = 0; $b1 = 0;
        foreach ($qb_zamowienia as $zamowienia)
        {
            $dane[$a++]['id'] = $zamowienia->getId();
            $dane[$b++]['nruser'] = $zamowienia->GetNr_user_zam();
            $dane[$c++]['dostawa'] = $zamowienia->GetIddost();
            $dane[$d++]['platnosc'] = $zamowienia->GetPlatnosc();
            $dane[$e++]['nrprodukcji'] = $zamowienia->GetNrprodukcji();
            $dane[$f++]['dozaplaty'] = $zamowienia->GetDozaplaty();
            $dane[$g++]['jakiezam'] = $zamowienia->GetJakie_zam();
            $dane[$i++]['zaplacono'] = $zamowienia->GetZaplacono();
            //$dane[$h++]['id'] = $zamowienia->GetId();
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
            $zamowienia->setStatus('wysłane');
             $em->flush();
             $qb_list = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Nrlistu', 'a')
                 ->where('a.idzam = :identifier')
                 ->setParameter('identifier', $id_zam)
                 ->orderBy('a.id', 'DESC')
                 ->setMaxResults(1)
                ->getQuery()
                ->getResult();
            foreach ($qb_list as $nr)
            {
                $numer[$a1++]['nr'] = $nr->GetNr();
                $numer[$b1++]['idzam'] = $nr->GetIdzam();
            }
        
        }
        
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:sendzamw.html.twig', array(
            'dane' => $dane,
            'lista' => $lista_prod,
            'numer' => $numer
        ));
        
        $this->zamowieniaMailer->send($daneEmail, 'Dostawa zamówienia GrupaMAGNUM ', $emaiBody);
        
        return true;
    }
    
    public function anulowanieZamowienia($userEmail)
    {
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:anulowanie.html.twig');
        
        $this->anulowanieMailer->send($userEmail, 'Anulowanie zamówienia GrupaMAGNUM ', $emaiBody);
        
        return true;
    }
}