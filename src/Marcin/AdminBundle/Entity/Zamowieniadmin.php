<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\ZamowieniadminRepository")
 * @ORM\Table(name="admin_user")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Zamowieniadmin {
        
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
    private $user_po;
    
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
     * @return Zamowieniadmin
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
     * Set user_po
     *
     * @param integer $user_po
     *
     * @return Zamowieniadmin
     */
    public function setUserpo($user_po)
    {
        $this->user_po = $user_po;
        return $this;
    }
    
    /**
     * Get user_po
     *
     * @return integer
     */
    public function getUserpo()
    {
        return $this->user_po;
    }
}