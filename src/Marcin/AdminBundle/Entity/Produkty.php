<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\ProduktyRepository")
 * @ORM\Table(name="lista_produktow")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Produkty {
    
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
    private $user;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\NotBlank
     * 
     */
    private $id_zam;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $szerokosc_a;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $nazwa;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $szerokosc_b;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $wysokosc_h;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $typ;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $kolor;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $grubosc;
    
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
    private $uwagi;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $kolor_siatki;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    private $status;
    
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
     * @param string $user
     *
     * @return Produkty
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
    
    /**
     * Set idzam,
     *
     * @param string $id_zam
     *
     * @return Produkty
     */
    public function setIdzam($id_zam)
    {
        $this->id_zam = $id_zam;
        return $this;
    }
    /**
     * Get idzam
     *
     * @return string
     */
    public function getIdzam()
    {
        return $this->id_zam;
    }
    
    public function getProduktyzam($id)
        {
           $qb = $this->createQueryBuilder('u')
             ->select('u')
             ->where('u =:id_zam')->setParameter('id_zam', $id)
             ->getQuery()
             ->getResult(Query::HYDRATE_ARRAY);

           return $qb;
        }   
        
    /**
     * Set typ
     *
     * @param string $typ
     *
     * @return Produkty
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;
        return $this;
    }
    /**
     * Get typ
     *
     * @return string
     */
    public function getTyp()
    {
        return $this->typ;
    }
    
    /**
     * Set kolor
     *
     * @param string $kolor
     *
     * @return Produkty
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;
        return $this;
    }
    /**
     * Get kolor
     *
     * @return string
     */
    public function getKolor()
    {
        return $this->kolor;
    }
    
    /**
     * Set szerokosc_a
     *
     * @param string $szerokosc_a
     *
     * @return Produkty
     */
    public function setSzerokosca($szerokosc_a)
    {
        $this->szerokosc_a = $szerokosc_a;
        return $this;
    }
    
    /**
     * Get szerokosc_a
     *
     * @return string
     */
    public function getSzerokosca()
    {
        return $this->szerokosc_a;
    }
    
    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Produkty
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
        return $this;
    }
    
    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }
    
    /**
     * Set szerokosc_b
     *
     * @param string $szerokosc_b
     *
     * @return Produkty
     */
    public function setSzerokoscb($szerokosc_b)
    {
        $this->szerokosc_b = $szerokosc_b;
        return $this;
    }
    
    /**
     * Get szerokosc_b
     *
     * @return string
     */
    public function getSzerokoscb()
    {
        return $this->szerokosc_b;
    }
    
    /**
     * Set wysokosc_h
     *
     * @param string $wysokosc_h
     *
     * @return Produkty
     */
    public function setWysokosch($wysokosc_h)
    {
        $this->wysokosc_h = $wysokosc_h;
        return $this;
    }
    
    /**
     * Get wysokosc_h
     *
     * @return string
     */
    public function getWysokosch()
    {
        return $this->wysokosc_h;
    }
    
    /**
     * Set grubosc
     *
     * @param string $grubosc
     *
     * @return Produkty
     */
    public function setGrubosc($grubosc)
    {
        $this->grubosc = $grubosc;
        return $this;
    }
    
    /**
     * Get grubosc
     *
     * @return string
     */
    public function getGrubosc()
    {
        return $this->grubosc;
    }
    
    /**
     * Set oscieznica
     *
     * @param string $oscieznica
     *
     * @return Produkty
     */
    public function setOscieznica($oscieznica)
    {
        $this->oscieznica = $oscieznica;
        return $this;
    }
    
    /**
     * Get oscieznica
     *
     * @return string
     */
    public function getOscieznica()
    {
        return $this->oscieznica;
    }
    
    /**
     * Set skrzydlo
     *
     * @param string $skrzydlo
     *
     * @return Produkty
     */
    public function setSkrzydlo($skrzydlo)
    {
        $this->skrzydlo = $skrzydlo;
        return $this;
    }
    
    /**
     * Get skrzydlo
     *
     * @return string
     */
    public function getSkrzydlo()
    {
        return $this->skrzydlo;
    }
    
    /**
     * Set uwagi
     *
     * @param string $uwagi
     *
     * @return Produkty
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
        return $this;
    }
    
    /**
     * Get uwagi
     *
     * @return string
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }
    
    /**
     * Set kolor_siatki
     *
     * @param string $kolor_siatki
     *
     * @return Produkty
     */
    public function setKolorsiatki($kolor_siatki)
    {
        $this->kolor_siatki = $kolor_siatki;
        return $this;
    }
    
    /**
     * Get kolor_siatki
     *
     * @return string
     */
    public function getKolorsiatki()
    {
        return $this->kolor_siatki;
    }
    
    /**
     * Set status
     *
     * @param string $status
     *
     * @return Produkty
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
}