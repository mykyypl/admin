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
}