<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CommonUserBundle:Default:index.html.twig');
    }
}
