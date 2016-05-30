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
use Marcin\AdminBundle\Entity\Newsletter;
use Marcin\AdminBundle\Form\Type\NewsletterType;
use Marcin\AdminBundle\Form\Type\UpdatezamType;
use Marcin\AdminBundle\Exception\UserException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NewsletterController extends Controller {
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_newsletter_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @Security("has_role('ROLE_ZAM')")
     * 
     * @Template()
     */
    public function formAction(Request $Request, Newsletter $news = NULL, $id) {
        if(null == $news){
            $news = new Newsletter();
            //$Article->setAuthor($this->getUser());
            $newNewsletterForm = TRUE;
        }
        
        $form = $this->createForm(new NewsletterType(), $news);
        
        $form->handleRequest($Request);
        if ($form->get('send')->isClicked()) {
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();
            }
                try {
                    $userManager = $this->get('user_manager');
                    $userManager->testNewsletter($id);
                }
                catch (UserException $exc) {
                        $this->addFlash('error', $exc->getMessage());
                }
                    $this->addFlash('success', 'Testowy email został wysłany');
            return $this->redirect($this->generateUrl('marcin_admin_newsletter_form', array(
                'id' => $news->getId()
            )));
        }
        if ($form->get('submit')->isClicked()) {
           // $this->addFlash('success', 'Kliknięcie w submit');
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $news->setWyslano(new \DateTime());
                $em->persist($news);
                $em->flush();
            }
//            $qb_newsletter = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinAdminBundle:Username', 'a')
//                 //->setMaxResults(1)
//                 ->getQuery()
//                 ->getResult();
            $qb_grupy = $em->createQueryBuilder()
                ->select('b')
                ->from('MarcinAdminBundle:Newsletter', 'b')
                 ->setMaxResults(1)
                 ->getQuery()
                 ->getResult();
            
            foreach ($qb_grupy as $grupy)
            {
                $grupy_array = $grupy->GetGrupy();
            }
            
            if($grupy_array == null)
            {
                 $this->addFlash('error', 'Proszę wybrać do jakich grup użytkowników ma zostać wysłany newsletter!');
                return $this->redirect($this->generateUrl('marcin_admin_newsletter_form', array(
                'id' => $news->getId()
            )));
            } else {
                foreach ($grupy_array as $tablica_tras)
                {
                    $qb_newsletter = $em->createQueryBuilder()
                    ->select('a')
                    ->from('MarcinAdminBundle:Username', 'a')
                     //->setMaxResults(1)
                    ->where('a.trasa = :trasa')
                    ->setParameter('trasa', $tablica_tras)
                    ->getQuery()
                    ->getResult();
                    
                    foreach ($qb_newsletter as $news)
                     {
                        // sleep(15);
                         $email_send = $news->GetEmail();
                            try {
                                $userManager = $this->get('user_manager');
                                $userManager->sendNewsletter($id,$email_send);
                            }
                            catch (UserException $exc) {
                                    $this->addFlash('error', $exc->getMessage());
                            }
                     }
                
                }
            }
//         foreach ($qb_newsletter as $news)
//         {
//            // sleep(15);
//             $email_send = $news->GetEmail();
//                try {
//                    $userManager = $this->get('user_manager');
//                    $userManager->sendNewsletter($id,$email_send);
//                }
//                catch (UserException $exc) {
//                        $this->addFlash('error', $exc->getMessage());
//                }
//         }
            $this->addFlash('success', 'Newsletter został wysłany');
            return $this->redirect($this->generateUrl('marcin_admin_newsletter_form', array(
                'id' => $id
            )));
        }
        if ($form->get('save')->isClicked()) {
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();
                $message = (isset($newNewsletterForm)) ? 'Poprawnie dodano nowy newsletter.': 'Newsletter został zaktualizowany.';
                $this->addFlash('success', $message);
                return $this->redirect($this->generateUrl('marcin_admin_newsletter_form', array(
                    'id' => $news->getId()
                )));
            }
        }
        
        return array(
            'pageTitle' => (isset($newNewsletterForm) ? 'Newsletter <small>utwórz nowy</small>' : 'Newsletter <small>edycja</small>'),
            'currPage' => 'newsletter',
            'form' => $form->createView(),
            'newsletter' => $news,
        );
    }
    
    /**
     * @Route(
     *       "/{page}",
     *       name="marcin_admin_newsletter",
     *      requirements={"page"="\d+"},
     *      defaults={"page"=1}
     * 
     * )
     * @Security("has_role('ROLE_ZAM')")
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $page)
    {
      
        $queryParams = array(
            'idLike' => $Request->query->get('idLike'),

        ); 
     
        $StatUser = $this->getDoctrine()->getRepository('MarcinAdminBundle:Newsletter');
        
        $qb = $StatUser->getQueryBuilder($queryParams);
        
        $paginationLimit = $this->container->getParameter('admin.pagination_limit');
        $limits = array(30, 50, 100);
        
        $limit = $Request->query->get('limit', $paginationLimit);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        
        
        return $this->render('MarcinAdminBundle:Newsletter:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel Newsletter',
            //'articles' => $articles,
           //'pagination' => $pagination,
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
           // 'statistics' => $statistics,
            'pagination' => $pagination
           // 'deleteTokenName' => $this->deleteTokenName,
           // 'csrfProvider' => $this->get('form.csrf_provider')
                )
        );
    }
}