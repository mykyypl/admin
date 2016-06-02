<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\KomunikatyzamowieniaRepository")
 * @ORM\Table(name="komunikatyzamowienia")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Komunikatyzamowienia {
        
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
    private $trasa;
    
    /**
     * @ORM\Column(type="text")
     * 
     * 
     */
    private $tresc;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    private $dzien;
    
    /**
     * @ORM\Column(type="boolean")
     * 
     * 
     */
    private $wlaczone;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $kolor;
    
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
     * Set trasa
     *
     * @param integer $trasa
     *
     * @return Komunikatyzamowienia
     */
    public function setTrasa($trasa)
    {
        $this->trasa = $trasa;
        return $this;
    }
    
    /**
     * Get trasa
     *
     * @return integer
     */
    public function getTrasa()
    {
        return $this->trasa;
    }
    
    /**
     * Set tresc
     *
     * @param string $tresc
     *
     * @return Komunikatyzamowienia
     */
    public function setTresc($tresc)
    {
        $this->tresc = $tresc;
        return $this;
    }
    /**
     * Get tresc
     *
     * @return string
     */
    public function getTresc()
    {
        return $this->tresc;
    }
    
    /**
     * Set dzien
     *
     * @param string $dzien
     *
     * @return Komunikatyzamowienia
     */
    public function setDzien($dzien)
    {
        $this->dzien = $dzien;
        return $this;
    }
    /**
     * Get dzien
     *
     * @return string
     */
    public function getDzien()
    {
        return $this->dzien;
    }
    
    /**
     * Set wlaczone
     *
     * @param string $wlaczone
     *
     * @return Komunikatyzamowienia
     */
    public function setWlaczone($wlaczone)
    {
        $this->wlaczone = $wlaczone;
        return $this;
    }
    /**
     * Get wlaczone
     *
     * @return string
     */
    public function getWlaczone()
    {
        return $this->wlaczone;
    }
    
    /**
     * Set kolor
     *
     * @param integer $kolor
     *
     * @return Komunikatyzamowienia
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;
        return $this;
    }
    
    /**
     * Get kolor
     *
     * @return integer
     */
    public function getKolor()
    {
        return $this->kolor;
    }
}