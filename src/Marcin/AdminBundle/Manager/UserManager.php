<?php

namespace Marcin\AdminBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Marcin\AdminBundle\Mailer\UserMailer;
use Marcin\AdminBundle\Entity\Shoperzamowienia;
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
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
    }
    
    public function registerUsername($userEmail) {
       
        $em = $this->doctrine->getManager();
        
        $qb = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Shoperzamowienia', 'a')
                 ->where('a.zaznaczono = :identifier')
                 ->setParameter('identifier', '1')
               //->setMaxResults(1)
                ->getQuery()
                ->getResult();

        $qb_dane = $em->createQueryBuilder()
                ->select('a')
                ->from('MarcinAdminBundle:Shoperzamowienia', 'a')
                 ->where('a.zaznaczono = :identifier')
                 ->setParameter('identifier', '1')
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
        
        foreach($qb as $odznaczenie)
        {
                        $odznaczenie->setZaznaczono('2');
            $em->flush();
        }
        $emaiBody = $this->templating->render('MarcinAdminBundle:Email:pay.html.twig', array(
            'klinar' => $qb,
            'klinar_dane' => $qb_dane
        ));
        $tytul = $qb_dane[0]->getFirma();
        $tytul_nazwisko = $qb_dane[0]->getNazwisko();
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
}