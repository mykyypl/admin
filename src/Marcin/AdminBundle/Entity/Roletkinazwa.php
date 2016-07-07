<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\RoletkinazwaRepository")
 * @ORM\Table(name="roletki_tekstylne_nazwa")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Roletkinazwa {
        
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
    private $roletki_nazwa;
    
    
    
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
     * Set $reletki_nazwa
     *
     * @param integer $reletki_nazwa
     *
     * @return Roletkinazwa
     */
    public function setRoletkinazwa($reletki_nazwa)
    {
        $this->roletki_nazwa = $reletki_nazwa;
        return $this;
    }
    
    /**
     * Get $reletki_nazwa
     *
     * @return integer
     */
    public function getRoletkinazwa()
    {
        return $this->roletki_nazwa;
    }
    
}