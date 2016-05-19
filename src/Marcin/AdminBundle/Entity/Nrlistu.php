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
 * @ORM\Table(name="nr_listu")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Nrlistu {
        
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
    private $nr;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $idzam;
    
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
     * Set nr
     *
     * @param string $nr
     *
     * @return Nrlistu
     */
    public function setNr($nr)
    {
        $this->nr = $nr;
        return $this;
    }
    /**
     * Get nr
     *
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }
    
    /**
     * Set idzam
     *
     * @param string $idzam
     *
     * @return Nrlistu
     */
    public function setIdzam($idzam)
    {
        $this->idzam = $idzam;
        return $this;
    }
    /**
     * Get idzam
     *
     * @return string
     */
    public function getIdzam()
    {
        return $this->idzam;
    }
}