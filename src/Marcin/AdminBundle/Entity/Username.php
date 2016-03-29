<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\UsernameRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Username {
       
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\NotBlank
     * 
     */
    private $new;
    
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
     * Set new
     *
     * @param integer $new
     *
     * @return Username
     */
    public function setNew($new)
    {
        $this->new = $new;
        return $this;
    }
    /**
     * Get new
     *
     * @return integer
     */
    public function getNew()
    {
        return $this->new;
    }
}