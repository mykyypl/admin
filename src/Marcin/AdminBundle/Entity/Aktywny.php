<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\AktywnyRepository")
 * @ORM\Table(name="zalogowani")
 * @ORM\HasLifecycleCallbacks() 
 *
 */
class Aktywny {
    
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * 
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     * 
     *
     */
    private $nazwa;
    
    /**
     * @ORM\Column(type="text")
     * 
     */
    private $dane;
    
    
    /**
     * Get id
     *
     * 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set id
     *
     * @param string $id
     *
     * @return Aktywny
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Get nazwa
     *
     * 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }
    
    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Aktywny
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
        return $this;
    }
    
    /**
     * Set dane
     *
     * @param string $dane
     *
     * @return Aktywny
     */
    public function setDane($dane)
    {
        $this->dane = $dane;
        return $this;
    }
    /**
     * Get dane
     *
     * @return string
     */
    public function getDane()
    {
        return $this->dane;
    }
    
       
}