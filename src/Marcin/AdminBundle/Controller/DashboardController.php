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

use Marcin\AdminBundle\Entity\Zamowienia;
use Marcin\AdminBundle\Form\Type\TestType;

class DashboardController extends Controller {
    
    private $deleteTokenName = 'delete-zam-%d';
        
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="marcin_admin_dashboard_form",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * @Template()
     */
    public function formAction(Request $Request, Zamowienia $Zamowienia = NULL) {
        if(null == $Zamowienia){
            $Zamowienia = new Zamowienia();
            $newZamowieniaForm = TRUE;
        }
        
        $form = $this->createForm(new TestType(), $Zamowienia);
        
        $form->handleRequest($Request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Zamowienia);
            $em->flush();
            $message = (isset($newZamowieniaForm)) ? 'Poprawnie dodano.': 'Zamowienie zostało zaktualizowane.';
            $this->addFlash('success', $message);
            return $this->redirect($this->generateUrl('marcin_admin_dashboard_form', array(
                'id' => $Zamowienia->getId()
            )));
        }
        
        return $this->render('MarcinAdminBundle:Admin:form.html.twig',
            array(
            'pageTitle' => (isset($newZamowieniaForm) ? 'Zamowienia <small>utwórz nowy</small>' : 'Zamowienia <small>edycja zamowienia</small>'),
            'currPage' => 'zamowienia',
            'form' => $form->createView(),
            'zamowienia' => $Zamowienia,
                )
        );
    }
    
    private $status_new_zam;
    private $status_send_zam;
    /**
     * @Route(
     *       "/{status}/{page}",
     *       name="marcin_admin_dashboard",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1}
     * )
     *    
     * @Template()
     */
    public function indexAction(Request $Request, $status, $page)
    {
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
        
        $queryParams = array(
            'userLike' => $Request->query->get('userLike'),
            'status' => $status
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
        
        $RepoZam = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia');
        $statistics = $RepoZam->getStatistics();
        
        $qb = $RepoZam->getQueryBuilder($queryParams);
        
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
        if(!isset($this->status_new_zam)) {
            $this->status_new_zam = $RepoZam->getNewzam();
        }
        if(!isset($this->status_send_zam)) {
            $this->status_send_zam = $RepoZam->getSendzam();
        }
        
        return $this->render('MarcinAdminBundle:Admin:index.html.twig',
            array(
            'pageTitle'            => 'GM Panel',
            //'articles' => $articles,
           //'pagination' => $pagination,
            'queryParams' => $queryParams,
            'limits' => $limits,
            'currLimit' => $limit,
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            'pagination' => $pagination,
            'currStatus' => $status,
            'deleteTokenName' => $this->deleteTokenName,
            'csrfProvider' => $this->get('form.csrf_provider'),
             'new_zam' => array(
                    'count' => $this->status_new_zam
                ),
             'send_zam' => array(
                    'count' => $this->status_send_zam
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
     * @Template()
     */
    public function deleteAction($id, $token) {
        
        $tokenName = sprintf($this->deleteTokenName, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->addFlash('error', 'Niepoprawny token akcji.');
            
        }else{
            
//            $Zamid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Zamowienia')->find($id);
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($Zamid);
//            $em->flush();
            
            $Proid = $this->getDoctrine()->getRepository('MarcinAdminBundle:Produkty')->findByIdzam($id);
            $em1 = $this->getDoctrine()->getManager();
            if (!$Proid) {
             throw $this->createNotFoundException(
            'No product found for id '.$id
                );
            }
            //foreach ($Proid as $Proids) {
            //$em1->remove($Proids);
            //}
            $em1->remove($Proid);
            $em1->flush();
            
            $this->addFlash('success', 'Poprawnie usunięto slide.');
        }
        
        return $this->redirect($this->generateUrl('marcin_admin_dashboard'));
    }
}