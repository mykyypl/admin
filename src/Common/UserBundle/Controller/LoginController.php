<?php

/* 
 * Marcin Kukliński
 */

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Form\FormError;
use Common\UserBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Common\UserBundle\Entity\User;
use Common\UserBundle\Form\Type\LoginType;

/**
 * @Route("/")
 */
class LoginController extends Controller
{
   /**
    * @Route("/login", name="login")
    */
   public function loginAction(Request $Request)
   {
       
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
    {
        // redirect authenticated users to homepage
        return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
    }
//        $Session = $this->get('session');
//        $authenticationUtils = $this->get('security.authentication_utils');
//
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render(
//            'CommonUserBundle:Login:login.html.twig',
//            array(
//                // last username entered by the user
//                'last_username' => $lastUsername,
//                'error'         => $error,
//            )
//        );
       
       
        $Session = $this->get('session');
        
        if($Request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $loginError = $Request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $loginError = $Session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }
        
        if(isset($loginError)) {
            $this->addFlash('error', $loginError->getMessage());
        }
        
        $loginForm = $this->createForm(new LoginType(), array(
            'username' => $Session->get(SecurityContextInterface::LAST_USERNAME)
        ));
        
        return $this->render(
            'CommonUserBundle:Login:login.html.twig',
            array(
            'pageTitle'            => 'GM Panel',
            'loginForm'            => $loginForm->createView(),
                )
        );
   }
   
   /**
    * @Route("/", name="index")
    */
   public function indexAction()
   {
       return $this->redirectToRoute('login');
   }
   

}