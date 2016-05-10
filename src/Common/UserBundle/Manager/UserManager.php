<?php
namespace Common\UserBundle\Manager;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Common\UserBundle\Entity\User;
use Common\UserBundle\Exception\UserException;
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
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
    }
//    
//    protected function getRandomPassword($length = 8){
//        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
//        $pass = array(); //remember to declare $pass as an array
//        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
//        for ($i = 0; $i < $length; $i++) {
//            $n = rand(0, $alphaLength);
//            $pass[] = $alphabet[$n];
//        }
//        return implode($pass); //turn the array into a string
//    }
//    
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