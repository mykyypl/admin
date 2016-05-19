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
}