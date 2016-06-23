<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\TestRepository")
 * @ORM\Table(name="zam_produkty")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @UniqueEntity(fields={"nr_user_zam"})
 */
class Zamowienia {
    
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
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     */
    private $jakie_zam;
    
    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     */
    private $status;   

    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $nr_fakt; 

    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $nr_user_zam; 

    /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    private $kwota;  

    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $do_zaplaty;   

    /**
     * @ORM\Column(type="boolean")
     * 
     * 
     */
    private $zaplacono;  

    /**
     * @ORM\Column(name="data", type="datetime")
     */
    private $createDate;
            
    /**
     * @ORM\Column(name="data_wyslania", type="datetime")
     */
    private $sendDate;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $nrprodukcji;
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $trasa;
    
    /**
     * @ORM\Column(type="boolean")
     * 
     * 
     */
    private $trasaok; 
    
    /**
     * @ORM\Column(type="integer")
     * 
     * 
     */
    private $id_dost; 
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $platnosc; 
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * 
     * 
     */
    private $zamowienie = null;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * 
     * 
     */
    private $zakonczone = null; 

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
     * @return Zamowienia
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
     * Set jakie_zam
     *
     * @param string $jakie_zam
     *
     * @return Zamowienia
     */
    public function setJakie_zam($jakie_zam)
    {
        $this->jakie_zam = $jakie_zam;
        return $this;
    }
    /**
     * Get jakie_zam
     *
     * @return string
     */
    public function getJakie_zam()
    {
        return $this->jakie_zam;
    }
    
    /**
     * Get status
     *
     * 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set status
     *
     * @param string $status
     *
     * @return Zamowienia
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Zamowienia
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
        return $this;
    }
    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
    /**
     * Set createDate
     *
     * @param \DateTime $sendDate
     *
     * @return Zamowienia
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
        return $this;
    }
    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set nr_user_zam
     *
     * @param integer $nr_user_zam
     *
     * @return Zamowienia
     */
    public function setNr_user_zam($nr_user_zam)
    {
        $this->nr_user_zam = $nr_user_zam;
        return $this;
    }
    /**
     * Get nr_user_zam
     *
     * @return integer
     */
    public function getNr_user_zam()
    {
        return $this->nr_user_zam;
    }

    /**
     * Set nr_fakt
     *
     * @param integer $nr_fakt
     *
     * @return Zamowienia
     */
    public function setNr_fakt($nr_fakt)
    {
        $this->nr_fakt = $nr_fakt;
        return $this;
    }
    /**
     * Get nr_fakt
     *
     * @return integer
     */
    public function getNr_fakt()
    {
        return $this->nr_fakt;
    }

    /**
     * Set kwota
     *
     * @param string $kwota
     *
     * @return Zamowienia
     */
    public function setKwota($kwota)
    {
        $this->kwota = $kwota;
        return $this;
    }
    /**
     * Get kwota
     *
     * @return string
     */
    public function getKwota()
    {
        return $this->kwota;
    }

    /**
     * Set dozaplaty
     *
     * @param string $do_zaplaty
     *
     * @return Zamowienia
     */
    public function setDozaplaty($do_zaplaty)
    {
        $this->do_zaplaty = $do_zaplaty;
        return $this;
    }
    /**
     * Get dozaplaty
     *
     * @return string
     */
    public function getDozaplaty()
    {
        return $this->do_zaplaty;
    }

    /**
     * Set zaplacono
     *
     * @param string $zaplacono
     *
     * @return Zamowienia
     */
    public function setZaplacono($zaplacono)
    {
        $this->zaplacono = $zaplacono;
        return $this;
    }
    /**
     * Get zaplacono
     *
     * @return string
     */
    public function getZaplacono()
    {
        return $this->zaplacono;
    }
    
    /**
     * Set nrprodukcji
     *
     * @param integer $nrprodukcji
     *
     * @return Zamowienia
     */
    public function setNrprodukcji($nrprodukcji)
    {
        $this->nrprodukcji = $nrprodukcji;
        return $this;
    }
    /**
     * Get nrprodukcji
     *
     * @return integer
     */
    public function getNrprodukcji()
    {
        return $this->nrprodukcji;
    }
    
    /**
     * Set trasa
     *
     * @param integer $trasa
     *
     * @return Zamowienia
     */
    public function setTrasa($trasa)
    {
        $this->trasa = $trasa;
        return $this;
    }
    
    /**
     * Get trasa
     *
     * @return integer
     */
    public function getTrasa()
    {
        return $this->trasa;
    }
    
    /**
     * Set trasaok
     *
     * @param string $trasaok
     *
     * @return Zamowienia
     */
    public function setTrasaok($trasaok)
    {
        $this->trasaok = $trasaok;
        return $this;
    }
    
    /**
     * Get trasaok
     *
     * @return string
     */
    public function getTrasaok()
    {
        return $this->trasaok;
    }
    
    /**
     * Set iddost
     *
     * @param string $id_dost
     *
     * @return Zamowienia
     */
    public function setIddost($id_dost)
    {
        $this->id_dost = $id_dost;
        return $this;
    }
    
    /**
     * Get iddost
     *
     * @return string
     */
    public function getIddost()
    {
        return $this->id_dost;
    }
    
    /**
     * Set platnosc
     *
     * @param integer $platnosc
     *
     * @return Zamowienia
     */
    public function setPlatnosc($platnosc)
    {
        $this->platnosc = $platnosc;
        return $this;
    }
    /**
     * Get platnosc
     *
     * @return integer
     */
    public function getPlatnosc()
    {
        return $this->platnosc;
    }
    
    /**
     * Set zamowienie
     *
     * @param integer $zamowienie
     *
     * @return Zamowienia
     */
    public function setZamowienie($zamowienie)
    {
        $this->zamowienie = $zamowienie;
        return $this;
    }
    /**
     * Get zamowienie
     *
     * @return integer
     */
    public function getZamowienie()
    {
        return $this->zamowienie;
    }
    
    /**
     * Set zakonczone
     *
     * @param integer $zakonczone
     *
     * @return Zamowienia
     */
    public function setZakonczone($zakonczone)
    {
        $this->zakonczone = $zakonczone;
        return $this;
    }
    /**
     * Get zakonczone
     *
     * @return integer
     */
    public function getZakonczone()
    {
        return $this->zakonczone;
    }
    
}

