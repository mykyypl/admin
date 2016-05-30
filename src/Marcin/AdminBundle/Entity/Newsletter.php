<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\NewsletterRepository")
 * @ORM\Table(name="newsletter_zam")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Newsletter {
        
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $tytul;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $tekst;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * 
     */
    private $zalacznik = null;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * 
     */
    private $bootstrap = null;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * 
     * 
     */
    private $test = null;
    
    /**
     * @ORM\Column(name="wyslano", type="datetime", nullable=true)
     */
    private $wyslano = null;
    
    /**
     * @ORM\Column(type="array")
     */
    private $grupy;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set tytul
     *
     * @param string $tytul
     *
     * @return Newsletter
     */
    public function setTytul($tytul)
    {
        $this->tytul = $tytul;
        return $this;
    }
    
    /**
     * Get tytul
     *
     * @return string
     */
    public function getTytul()
    {
        return $this->tytul;
    }
    
    /**
     * Set tekst
     *
     * @param string $tekst
     *
     * @return Newsletter
     */
    public function setTekst($tekst)
    {
        $this->tekst = $tekst;
        return $this;
    }
    /**
     * Get tekst
     *
     * @return string
     */
    public function getTekst()
    {
        return $this->tekst;
    }
    
    /**
     * Set zalacznik
     *
     * @param string $zalacznik
     *
     * @return Newsletter
     */
    public function setZalacznik($zalacznik)
    {
        $this->zalacznik = $zalacznik;
        return $this;
    }
    /**
     * Get zalacznik
     *
     * @return string
     */
    public function getZalacznik()
    {
        return $this->zalacznik;
    }
    
    /**
     * Set bootstrap
     *
     * @param string $bootstrap
     *
     * @return Newsletter
     */
    public function setBootstrap($bootstrap)
    {
        $this->bootstrap = $bootstrap;
        return $this;
    }
    /**
     * Get newsletter
     *
     * @return string
     */
    public function getBootstrap()
    {
        return $this->bootstrap;
    }
    
    /**
     * Set test
     *
     * @param integer $test
     *
     * @return Newsletter
     */
    public function setTest($test)
    {
        $this->test = $test;
        return $this;
    }
    
    /**
     * Get test
     *
     * @return integer
     */
    public function getTest()
    {
        return $this->test;
    }
    
    /**
     * Set wyslano
     *
     * @param \DateTime $wyslano
     * @return Newsletter
     */
    public function setWyslano($wyslano) {
        $this->wyslano = $wyslano;

        return $this;
    }

    /**
     * Get wyslano
     *
     * @return \DateTime 
     */
    public function getWyslano() {
        return $this->wyslano;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->date = new \DateTime();
    }
    
    public function getGrupy() {
        
        return $this->grupy;
    }
    
    /**
     * Set grupy
     *
     * @param array $grupy
     * @return Newsletter
     */
    public function setGrupy($grupy)
    {
        $this->grupy = $grupy;

        return $this;
    }
}