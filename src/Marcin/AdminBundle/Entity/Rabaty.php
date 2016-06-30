<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\RabatyRepository")
 * @ORM\Table(name="platnosc_rabaty")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Rabaty {
    
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
    private $user;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $platnosc;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $typ_zamowienia;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $rabat;
    
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
     * Set user
     *
     * @param integer $user
     *
     * @return Rabaty
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set platnosc
     *
     * @param integer $platnosc
     *
     * @return Rabaty
     */
    public function setPlatnosc($platnosc)
    {
        $this->platnosc = $platnosc;
        return $this;
    }
    
    /**
     * Get platnosc
     *
     * @return integer
     */
    public function getPlatnosc()
    {
        return $this->platnosc;
    }
    
    /**
     * Set typ_zamowienia
     *
     * @param integer $typ_zamowienia
     *
     * @return Rabaty
     */
    public function setTypzamowienia($typ_zamowienia)
    {
        $this->typ_zamowienia = $typ_zamowienia;
        return $this;
    }
    
    /**
     * Get typ_zamowienia
     *
     * @return integer
     */
    public function getTypzamowienia()
    {
        return $this->typ_zamowienia;
    }
    
    /**
     * Set rabat
     *
     * @param integer $rabat
     *
     * @return Rabaty
     */
    public function setRabat($rabat)
    {
        $this->rabat = $rabat;
        return $this;
    }
    
    /**
     * Get rabat
     *
     * @return integer
     */
    public function getRabat()
    {
        return $this->rabat;
    }
    
}