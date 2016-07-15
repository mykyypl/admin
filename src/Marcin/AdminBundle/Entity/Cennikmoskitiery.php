<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\CennikmoskitieryRepository")
 * @ORM\Table(name="cennikmoskitiery")
 * @ORM\HasLifecycleCallbacks() 
 *
 */
class Cennikmoskitiery {
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $przedzial;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $standard;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $exclusive;
    
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
     * Set przedzial
     *
     * @param integer $przedzial
     *
     * @return Etapyprodukcji
     */
    public function setPrzedzial($przedzial)
    {
        $this->przedzial = $przedzial;
        return $this;
    }
    
    /**
     * Get przedzial
     *
     * @return integer
     */
    public function getPrzedzial()
    {
        return $this->przedzial;
    }
    
    /**
     * Set standard
     *
     * @param integer $standard
     *
     * @return Etapyprodukcji
     */
    public function setStandard($standard)
    {
        $this->standard = $standard;
        return $this;
    }
    
    /**
     * Get standard
     *
     * @return integer
     */
    public function getStandard()
    {
        return $this->standard;
    }
    
    /**
     * Set exclusive
     *
     * @param integer $exclusive
     *
     * @return Etapyprodukcji
     */
    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;
        return $this;
    }
    
    /**
     * Get exclusive
     *
     * @return integer
     */
    public function getExclusive()
    {
        return $this->exclusive;
    }
}