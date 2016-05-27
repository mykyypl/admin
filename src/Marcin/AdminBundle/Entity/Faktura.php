<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\FakturaRepository")
 * @ORM\Table(name="dane_faktura")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Faktura {
        
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
    private $nip;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $user;
    
    /**
     * @ORM\Column(type="text")
     * 
     * 
     */
    private $ulica;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $kod_pocztowy;
    
    /**
     * @ORM\Column(type="text")
     * 
     * 
     */
    private $miasto;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $telefon;
    
    /**
     * @ORM\Column(type="text")
     * 
     * 
     */
    private $nazwa_firmy;
    
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
     * Set nip
     *
     * @param integer $nip
     *
     * @return Faktura
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
        return $this;
    }
    
    /**
     * Get nip
     *
     * @return integer
     */
    public function getNip()
    {
        return $this->nip;
    }
    
    /**
     * Set user
     *
     * @param string $user
     *
     * @return Faktura
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set kod_pocztowy
     *
     * @param integer $kod_pocztowy
     *
     * @return Faktura
     */
    public function setKodpocztowy($kod_pocztowy)
    {
        $this->kod_pocztowy = $kod_pocztowy;
        return $this;
    }
    
    /**
     * Get kod_pocztowy
     *
     * @return integer
     */
    public function getKodpocztowy()
    {
        return $this->kod_pocztowy;
    }
    
    /**
     * Set ulica
     *
     * @param string $ulica
     *
     * @return Faktura
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;
        return $this;
    }
    
    /**
     * Get ulica
     *
     * @return string
     */
    public function getUlica()
    {
        return $this->ulica;
    }
    
    /**
     * Set miasto
     *
     * @param string $miasto
     *
     * @return Faktura
     */
    public function setMiasto($miasto)
    {
        $this->miasto = $miasto;
        return $this;
    }
    
    /**
     * Get miasto
     *
     * @return string
     */
    public function getMiasto()
    {
        return $this->miasto;
    }
    
    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Faktura
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
        return $this;
    }
    
    /**
     * Get telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }
    
    /**
     * Set nazwa_firmy
     *
     * @param string $nazwa_firmy
     *
     * @return Faktura
     */
    public function setNazwafirmy($nazwa_firmy)
    {
        $this->nazwa_firmy = $nazwa_firmy;
        return $this;
    }
    
    /**
     * Get nazwa_firmy
     *
     * @return string
     */
    public function getNazwafirmy()
    {
        return $this->nazwa_firmy;
    }
   
}