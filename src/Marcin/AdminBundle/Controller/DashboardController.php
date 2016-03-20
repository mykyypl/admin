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

class DashboardController extends Controller {
    /**
     * @Route(
     *       "/",
     *       name="marcin_admin_dashboard"
     * )
     *    
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('MarcinAdminBundle:Admin:index.html.twig');
    }
}