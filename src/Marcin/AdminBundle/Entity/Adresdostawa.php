<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\AdresdostawaRepository")
 * @ORM\Table(name="adresy_zam")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Adresdostawa {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
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
     * @Assert\NotBlank
     * 
     */
    private $miejscowowsc;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $telefon;
    
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
     * Set kod_pocztowy
     *
     * @param integer $kod_pocztowy
     *
     * @return Adresdostawa
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
     * @return Adresdostawa
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
     * Set miejscowowsc
     *
     * @param string $miejscowowsc
     *
     * @return Adresdostawa
     */
    public function setMiejscowowsc($miejscowowsc)
    {
        $this->miejscowowsc = $miejscowowsc;
        return $this;
    }
    
    /**
     * Get miejscowowsc
     *
     * @return string
     */
    public function getMiejscowowsc()
    {
        return $this->miejscowowsc;
    }
    
    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Adresdostawa
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
     * Set user
     *
     * @param string $user
     *
     * @return Adresdostawa
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
     * Set nazwa_firmy
     *
     * @param string $nazwa_firmy
     *
     * @return Adresdostawa
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