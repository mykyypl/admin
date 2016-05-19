<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\TrasaRepository")
 * @ORM\Table(name="zam_trasa")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Trasa {
    
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
    private $nazwa;
    
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
     * Set nazwa
     *
     * @param integer $nazwa
     *
     * @return Trasa
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
        return $this;
    }
    
    /**
     * Get nazwa
     *
     * @return integer
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }
    
}