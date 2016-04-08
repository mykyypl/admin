<?php

/* 
 * Marcin Kukliński
 */
namespace Marcin\AdminBundle\Twig\Extension;
class AdminliveExtension extends \Twig_Extension {
    
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
        return 'marcin_admin_extensionlive';
    }
    
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('print_live', 
                        array($this, 'live'), 
                        array('is_safe' => array('html'))
                    ),
        );
    }
    
    public function getFilters() {
        return array(
            'marcin_format_date' => new \Twig_Filter_Method($this, 'adminFormatDate')
        );
    }
    
    private $liveuser;
    private $userlist;
    //private $navigationPage;
   // private $navigationSlider;
   // private $navigationSugestion;
    public function live() {
        if(!isset($this->liveuser)) {
            $RepoLive = $this->doctrine->getRepository('MarcinAdminBundle:Aktywny');
            $this->liveuser = $RepoLive->getUserlivecount();
        }
         $LiveList = $this->doctrine->getRepository('MarcinAdminBundle:Aktywny');
         $this->userlist = $LiveList->getAktualni();
        
        return $this->environment->render('MarcinAdminBundle:Template:live.html.twig', array(
            'live' => array(
                'liveuser' => array(
                    'count' => $this->liveuser
                )
            ),
            'ulista' => $this->userlist
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