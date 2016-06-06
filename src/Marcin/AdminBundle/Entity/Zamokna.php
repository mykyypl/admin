<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\ZamoknaRepository")
 * @ORM\Table(name="j1sr9_calcbuilder_field_multivalue")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Zamokna {
        
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
    private $name;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $value;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $felc;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $oscieznica;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $skrzydlo;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $blaszka;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $rodzaj;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $stronawiercenia;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $stalaszer;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $stalawys;
    
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
     * Set name
     *
     * @param integer $name
     *
     * @return Zamokna
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get name
     *
     * @return integer
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Zamokna
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Set felc
     *
     * @param integer $felc
     *
     * @return Zamokna
     */
    public function setFelc($felc)
    {
        $this->felc = $felc;
        return $this;
    }
    
    /**
     * Get felc
     *
     * @return integer
     */
    public function getFelc()
    {
        return $this->felc;
    }
    
    /**
     * Set oscieznica
     *
     * @param integer $oscieznica
     *
     * @return Zamokna
     */
    public function setOscieznica($oscieznica)
    {
        $this->oscieznica = $oscieznica;
        return $this;
    }
    
    /**
     * Get oscieznica
     *
     * @return integer
     */
    public function getOscieznica()
    {
        return $this->oscieznica;
    }
    
    /**
     * Set skrzydlo
     *
     * @param integer $skrzydlo
     *
     * @return Zamokna
     */
    public function setSkrzydlo($skrzydlo)
    {
        $this->skrzydlo = $skrzydlo;
        return $this;
    }
    
    /**
     * Get skrzydlo
     *
     * @return integer
     */
    public function getSkrzydlo()
    {
        return $this->skrzydlo;
    }
    
    /**
     * Set blaszka
     *
     * @param integer $blaszka
     *
     * @return Zamokna
     */
    public function setBlaszka($blaszka)
    {
        $this->blaszka = $blaszka;
        return $this;
    }
    
    /**
     * Get blaszka
     *
     * @return integer
     */
    public function getBlaszka()
    {
        return $this->blaszka;
    }
    
    /**
     * Set rodzaj
     *
     * @param integer $rodzaj
     *
     * @return Zamokna
     */
    public function setRodzaj($rodzaj)
    {
        $this->rodzaj = $rodzaj;
        return $this;
    }
    
    /**
     * Get rodzaj
     *
     * @return integer
     */
    public function getRodzaj()
    {
        return $this->rodzaj;
    }
    
    /**
     * Set stronawiercenia
     *
     * @param integer $stronawiercenia
     *
     * @return Zamokna
     */
    public function setStronawiercenia($stronawiercenia)
    {
        $this->stronawiercenia = $stronawiercenia;
        return $this;
    }
    
    /**
     * Get stronawiercenia
     *
     * @return integer
     */
    public function getStronawiercenia()
    {
        return $this->stronawiercenia;
    }
    
    /**
     * Set stalaszer
     *
     * @param integer $stalaszer
     *
     * @return Zamokna
     */
    public function setStalaszer($stalaszer)
    {
        $this->stalaszer = $stalaszer;
        return $this;
    }
    
    /**
     * Get stalaszer
     *
     * @return integer
     */
    public function getStalaszer()
    {
        return $this->stalaszer;
    }
    
    /**
     * Set stalawys
     *
     * @param integer $stalawys
     *
     * @return Zamokna
     */
    public function setStalawys($stalawys)
    {
        $this->stalawys = $stalawys;
        return $this;
    }
    
    /**
     * Get stalawys
     *
     * @return integer
     */
    public function getStalawys()
    {
        return $this->stalawys;
    }
    
}