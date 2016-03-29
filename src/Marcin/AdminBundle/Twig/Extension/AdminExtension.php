<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Twig\Extension;
class AdminExtension extends \Twig_Extension {
    
    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    /**
     *
     * @var \Twig_Environment
     */
    private $environment;
    
    function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine) {
        $this->doctrine = $doctrine;
    }
    public function initRuntime(\Twig_Environment $environment) {
        $this->environment = $environment;
    }
    public function getName() {
        return 'marcin_admin_extension';
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('print_navigation', 
                        array($this, 'navigation'), 
                        array('is_safe' => array('html'))
                    ),
        );
    }
    
    public function getFilters() {
        return array(
            'marcin_format_date' => new \Twig_Filter_Method($this, 'adminFormatDate')
        );
    }
    
    private $navigationZamowienia;
    private $navigationUser;
    //private $navigationPage;
   // private $navigationSlider;
   // private $navigationSugestion;
    public function navigation() {
        if(!isset($this->navigationZamowienia)) {
            $RepoZamowienia = $this->doctrine->getRepository('MarcinAdminBundle:Zamowienia');
            $this->navigationZamowienia = $RepoZamowienia->getStatistics();
        }
        if(!isset($this->navigationUser)) {
            $RepoUser = $this->doctrine->getRepository('MarcinAdminBundle:Username');
            $this->navigationUser = $RepoUser->getUsernamecount();
        }
//        if(!isset($this->navigationPage)) {
//            $RepoPage = $this->doctrine->getRepository('TomSiteBundle:Page');
//            $this->navigationPage = $RepoPage->getStatistics();
//        }
//        if(!isset($this->navigationSlider)) {
//            $RepoSlider = $this->doctrine->getRepository('TomSiteBundle:Slider');
//            $this->navigationSlider = $RepoSlider->getStatistics();
//        }
//        if(!isset($this->navigationSugestion)) {
//            $RepoSugestion = $this->doctrine->getRepository('TomSiteBundle:Sugestion');
//            $this->navigationSugestion = $RepoSugestion->getStatistics();
//        }
        
        return $this->environment->render('MarcinAdminBundle:Template:navigation.html.twig', array(
            'navigation' => array(
                'zamowienia' => array(
                    'count' => $this->navigationZamowienia
                ),
                'username' => array(
                    'count' => $this->navigationUser
                )
//                ,
//                'page' => array(
//                    'count' => $this->navigationPage
//                ),
//                'slider' => array(
//                    'count' => $this->navigationSlider
//                ),
//                'sugestion' => array(
//                    'count' => $this->navigationSugestion
//                )
            )
        ));
    }
    
        
    public function shorten($text, $length = 200, $wrapTag = 'p') {
        
        $text = html_entity_decode($text);
        $text = strip_tags($text);
        if(strlen($text) > $length) {
            $text = substr($text, 0, $length).'...';
        }
        $openTag = "<{$wrapTag}>";
        $closeTag = "</{$wrapTag}>";
        
        return $openTag.$text.$closeTag;
    }
    
    
    public function adminFormatDate(\DateTime $datetime) {
        return $datetime->format('d/m/Y, H:i:s');
    }
    
}