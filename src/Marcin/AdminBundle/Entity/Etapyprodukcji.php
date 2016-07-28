<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\EtapyprodukcjiRepository")
 * @ORM\Table(name="etapyprodukcji")
 * @ORM\HasLifecycleCallbacks() 
 *
 */
class Etapyprodukcji {
    
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
    private $user;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $okno;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $nrzamowienia;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $ilosc;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $kolor;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $typ;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $profil;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $stronawiercenia;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $rodzaj;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $szerokosc;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wysokosc;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wykonano1;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wykonano2;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wykonano3;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $trasa;
    
    /**
     * @ORM\Column(type="integer")
     *
     */
    private $priorytet;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wykonano4;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $nrprodukcji;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $nruserzam;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $uwagi;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $blad;
    
    /**
     * @ORM\Column(type="integer")
     *
     */
    private $online;
    
    /**
     * @ORM\Column(name="data", type="datetime")
     */
    private $sendDate;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $felc;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $oscieznica;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $skrzydlo;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $blaszkast;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $blaszkaex;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $stalaszer;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $stalawys;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $felcstala;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $oscieznicastala;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $skrzydlostala;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $kolorsiatki;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $cenna;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $m2;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $rabaty;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pilas;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pilah;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $poziomo;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pionowo;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $dowiercenia;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $po1;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $po2;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $po3;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $po4;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pi1;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pi2;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pi3;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pi4;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $pi5;
    
    /**
     * @ORM\Column(type="string")
     *
     */
    private $wydrukowane;
    
    /**
     * @ORM\Column(type="integer")
     *
     */
    private $zaznaczono;
    
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
     * @return Etapyprodukcji
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
     * Set okno
     *
     * @param integer $okno
     *
     * @return Etapyprodukcji
     */
    public function setOkno($okno)
    {
        $this->okno = $okno;
        return $this;
    }
    
    /**
     * Get okno
     *
     * @return integer
     */
    public function getOkno()
    {
        return $this->okno;
    }
    
    /**
     * Set nrzamowienia
     *
     * @param integer $nrzamowienia
     *
     * @return Etapyprodukcji
     */
    public function setNrzamowienia($nrzamowienia)
    {
        $this->nrzamowienia = $nrzamowienia;
        return $this;
    }
    
    /**
     * Get nrzamowienia
     *
     * @return integer
     */
    public function getNrzamowienia()
    {
        return $this->nrzamowienia;
    }
    
    /**
     * Set ilosc
     *
     * @param integer $ilosc
     *
     * @return Etapyprodukcji
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;
        return $this;
    }
    
    /**
     * Get ilosc
     *
     * @return integer
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }
    
    /**
     * Set kolor
     *
     * @param integer $kolor
     *
     * @return Etapyprodukcji
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;
        return $this;
    }
    
    /**
     * Get kolor
     *
     * @return integer
     */
    public function getKolor()
    {
        return $this->kolor;
    }
    
    /**
     * Set typ
     *
     * @param integer $typ
     *
     * @return Etapyprodukcji
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;
        return $this;
    }
    
    /**
     * Get typ
     *
     * @return integer
     */
    public function getTyp()
    {
        return $this->typ;
    }
    
    /**
     * Set profil
     *
     * @param integer $profil
     *
     * @return Etapyprodukcji
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;
        return $this;
    }
    
    /**
     * Get profil
     *
     * @return integer
     */
    public function getProfil()
    {
        return $this->profil;
    }
    
    /**
     * Set stronawiercenia
     *
     * @param integer $stronawiercenia
     *
     * @return Etapyprodukcji
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
     * Set rodzaj
     *
     * @param integer $rodzaj
     *
     * @return Etapyprodukcji
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
     * Set szerokosc
     *
     * @param integer $szerokosc
     *
     * @return Etapyprodukcji
     */
    public function setSzerokosc($szerokosc)
    {
        $this->szerokosc = $szerokosc;
        return $this;
    }
    
    /**
     * Get szerokosc
     *
     * @return integer
     */
    public function getSzerokosc()
    {
        return $this->szerokosc;
    }
    
    /**
     * Set wysokosc
     *
     * @param integer $wysokosc
     *
     * @return Etapyprodukcji
     */
    public function setWysokosc($wysokosc)
    {
        $this->wysokosc = $wysokosc;
        return $this;
    }
    
    /**
     * Get wysokosc
     *
     * @return integer
     */
    public function getWysokosc()
    {
        return $this->wysokosc;
    }
    
    /**
     * Set wykonano1
     *
     * @param integer $wykonano1
     *
     * @return Etapyprodukcji
     */
    public function setWykonano1($wykonano1)
    {
        $this->wykonano1 = $wykonano1;
        return $this;
    }
    
    /**
     * Get wykoanano1
     *
     * @return integer
     */
    public function getWykonano1()
    {
        return $this->wykonano1;
    }
    
    /**
     * Set wykonano2
     *
     * @param integer $wykonano2
     *
     * @return Etapyprodukcji
     */
    public function setWykonano2($wykonano2)
    {
        $this->wykonano2 = $wykonano2;
        return $this;
    }
    
    /**
     * Get wykoanano2
     *
     * @return integer
     */
    public function getWykonano2()
    {
        return $this->wykonano2;
    }
    
    /**
     * Set wykonano3
     *
     * @param integer $wykonano3
     *
     * @return Etapyprodukcji
     */
    public function setWykonano3($wykonano3)
    {
        $this->wykonano3 = $wykonano3;
        return $this;
    }
    
    /**
     * Get wykoanano3
     *
     * @return integer
     */
    public function getWykonano3()
    {
        return $this->wykonano3;
    }
    
    /**
     * Set trasa
     *
     * @param integer $trasa
     *
     * @return Etapyprodukcji
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
     * Set priorytet
     *
     * @param integer $priorytet
     *
     * @return Etapyprodukcji
     */
    public function setPriorytet($priorytet)
    {
        $this->priorytet = $priorytet;
        return $this;
    }
    
    /**
     * Get priorytet
     *
     * @return integer
     */
    public function getPriorytet()
    {
        return $this->priorytet;
    }
    
    /**
     * Set wykonano4
     *
     * @param integer $wykonano4
     *
     * @return Etapyprodukcji
     */
    public function setWykonano4($wykonano4)
    {
        $this->wykonano4 = $wykonano4;
        return $this;
    }
    
    /**
     * Get wykoanano4
     *
     * @return integer
     */
    public function getWykonano4()
    {
        return $this->wykonano4;
    }
    
    /**
     * Set nrprodukcji
     *
     * @param integer $nrprodukcji
     *
     * @return Etapyprodukcji
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
     * Set nruserzam
     *
     * @param integer $nruserzam
     *
     * @return Etapyprodukcji
     */
    public function setNruserzam($nruserzam)
    {
        $this->nruserzam = $nruserzam;
        return $this;
    }
    
    /**
     * Get nruserzam
     *
     * @return integer
     */
    public function getNruserzam()
    {
        return $this->nruserzam;
    }
    
    /**
     * Set uwagi
     *
     * @param integer $uwagi
     *
     * @return Etapyprodukcji
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
        return $this;
    }
    
    /**
     * Get uwagi
     *
     * @return integer
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }
    
    /**
     * Set blad
     *
     * @param integer $blad
     *
     * @return Etapyprodukcji
     */
    public function setBlad($blad)
    {
        $this->blad = $blad;
        return $this;
    }
    
    /**
     * Get blad
     *
     * @return integer
     */
    public function getBlad()
    {
        return $this->blad;
    }
    
    /**
     * Set online
     *
     * @param integer $online
     *
     * @return Etapyprodukcji
     */
    public function setOnline($online)
    {
        $this->online = $online;
        return $this;
    }
    
    /**
     * Get online
     *
     * @return integer
     */
    public function getOnline()
    {
        return $this->online;
    }
    
    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     *
     * @return Etapyprodukcji
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
        return $this;
    }
    /**
     * Get sendDate
     *
     * @return \DateTime
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }
    
    /**
     * Set felc
     *
     * @param integer $felc
     *
     * @return Etapyprodukcji
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
     * @return Etapyprodukcji
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
     * @return Etapyprodukcji
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
     * Set blaszkast
     *
     * @param integer $blaszkast
     *
     * @return Etapyprodukcji
     */
    public function setBlaszkast($blaszkast)
    {
        $this->blaszkast = $blaszkast;
        return $this;
    }
    
    /**
     * Get blaszkast
     *
     * @return integer
     */
    public function getBlaszkast()
    {
        return $this->blaszkast;
    }
    
    /**
     * Set blaszkaex
     *
     * @param integer $blaszkaex
     *
     * @return Etapyprodukcji
     */
    public function setBlaszkaex($blaszkaex)
    {
        $this->blaszkaex = $blaszkaex;
        return $this;
    }
    
    /**
     * Get blaszkaex
     *
     * @return integer
     */
    public function getBlaszkaex()
    {
        return $this->blaszkaex;
    }
    
    /**
     * Set stalaszer
     *
     * @param integer $stalaszer
     *
     * @return Etapyprodukcji
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
     * @return Etapyprodukcji
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
    
    /**
     * Set felcstala
     *
     * @param integer $felcstala
     *
     * @return Etapyprodukcji
     */
    public function setFelcstala($felcstala)
    {
        $this->felcstala = $felcstala;
        return $this;
    }
    
    /**
     * Get felcstala
     *
     * @return integer
     */
    public function getFelcstala()
    {
        return $this->felcstala;
    }
    
    /**
     * Set oscieznicastala
     *
     * @param integer $oscieznicastala
     *
     * @return Etapyprodukcji
     */
    public function setOscieznicastala($oscieznicastala)
    {
        $this->oscieznicastala = $oscieznicastala;
        return $this;
    }
    
    /**
     * Get oscieznicastala
     *
     * @return integer
     */
    public function getOscieznicastala()
    {
        return $this->oscieznicastala;
    }
    
    /**
     * Set skrzydlostala
     *
     * @param integer $skrzydlostala
     *
     * @return Etapyprodukcji
     */
    public function setSkrzydlostala($skrzydlostala)
    {
        $this->skrzydlostala = $skrzydlostala;
        return $this;
    }
    
    /**
     * Get skrzydlostala
     *
     * @return integer
     */
    public function getSkrzydlostala()
    {
        return $this->skrzydlostala;
    }
    
    /**
     * Set kolorsiatki
     *
     * @param integer $kolorsiatki
     *
     * @return Etapyprodukcji
     */
    public function setKolorsiatki($kolorsiatki)
    {
        $this->kolorsiatki = $kolorsiatki;
        return $this;
    }
    
    /**
     * Get kolorsiatki
     *
     * @return integer
     */
    public function getKolorsiatki()
    {
        return $this->kolorsiatki;
    }
    
    /**
     * Set cenna
     *
     * @param integer $cenna
     *
     * @return Etapyprodukcji
     */
    public function setCenna($cenna)
    {
        $this->cenna = $cenna;
        return $this;
    }
    
    /**
     * Get cenna
     *
     * @return integer
     */
    public function getCenna()
    {
        return $this->cenna;
    }
    
    /**
     * Set m2
     *
     * @param integer $m2
     *
     * @return Etapyprodukcji
     */
    public function setM2($m2)
    {
        $this->m2 = $m2;
        return $this;
    }
    
    /**
     * Get m2
     *
     * @return integer
     */
    public function getM2()
    {
        return $this->m2;
    }
    
    /**
     * Set rabaty
     *
     * @param integer $rabaty
     *
     * @return Etapyprodukcji
     */
    public function setRabaty($rabaty)
    {
        $this->rabaty = $rabaty;
        return $this;
    }
    
    /**
     * Get rabaty
     *
     * @return integer
     */
    public function getRabaty()
    {
        return $this->rabaty;
    }
    
    /**
     * Set pilas
     *
     * @param integer $pilas
     *
     * @return Etapyprodukcji
     */
    public function setPilas($pilas)
    {
        $this->pilas = $pilas;
        return $this;
    }
    
    /**
     * Get pilas
     *
     * @return integer
     */
    public function getPilas()
    {
        return $this->pilas;
    }
    
    /**
     * Set pilah
     *
     * @param integer $pilah
     *
     * @return Etapyprodukcji
     */
    public function setPilah($pilah)
    {
        $this->pilah = $pilah;
        return $this;
    }
    
    /**
     * Get pilah
     *
     * @return integer
     */
    public function getPilah()
    {
        return $this->pilah;
    }
    
    /**
     * Set poziomo
     *
     * @param integer $poziomo
     *
     * @return Etapyprodukcji
     */
    public function setPoziomo($poziomo)
    {
        $this->poziomo = $poziomo;
        return $this;
    }
    
    /**
     * Get poziomo
     *
     * @return integer
     */
    public function getPoziomo()
    {
        return $this->poziomo;
    }
    
    /**
     * Set pionowo
     *
     * @param integer $pionowo
     *
     * @return Etapyprodukcji
     */
    public function setPionowo($pionowo)
    {
        $this->pionowo = $pionowo;
        return $this;
    }
    
    /**
     * Get pionowo
     *
     * @return integer
     */
    public function getPionowo()
    {
        return $this->pionowo;
    }
    
    /**
     * Set dowiercenia
     *
     * @param integer $dowiercenia
     *
     * @return Etapyprodukcji
     */
    public function setDowiercenia($dowiercenia)
    {
        $this->dowiercenia = $dowiercenia;
        return $this;
    }
    
    /**
     * Get dowiercenia
     *
     * @return integer
     */
    public function getDowiercenia()
    {
        return $this->dowiercenia;
    }
    
    /**
     * Set po1
     *
     * @param integer $po1
     *
     * @return Etapyprodukcji
     */
    public function setPo1($po1)
    {
        $this->po1 = $po1;
        return $this;
    }
    
    /**
     * Get po1
     *
     * @return integer
     */
    public function getPo1()
    {
        return $this->po1;
    }
    
    /**
     * Set po2
     *
     * @param integer $po2
     *
     * @return Etapyprodukcji
     */
    public function setPo2($po2)
    {
        $this->po2 = $po2;
        return $this;
    }
    
    /**
     * Get po2
     *
     * @return integer
     */
    public function getPo2()
    {
        return $this->po2;
    }
    
    /**
     * Set po3
     *
     * @param integer $po3
     *
     * @return Etapyprodukcji
     */
    public function setPo3($po3)
    {
        $this->po3 = $po3;
        return $this;
    }
    
    /**
     * Get po3
     *
     * @return integer
     */
    public function getPo3()
    {
        return $this->po3;
    }
    
    /**
     * Set po4
     *
     * @param integer $po4
     *
     * @return Etapyprodukcji
     */
    public function setPo4($po4)
    {
        $this->po4 = $po4;
        return $this;
    }
    
    /**
     * Get po4
     *
     * @return integer
     */
    public function getPo4()
    {
        return $this->po4;
    }
    
    /**
     * Set pi1
     *
     * @param integer $pi1
     *
     * @return Etapyprodukcji
     */
    public function setPi1($pi1)
    {
        $this->pi1 = $pi1;
        return $this;
    }
    
    /**
     * Get pi1
     *
     * @return integer
     */
    public function getPi1()
    {
        return $this->pi1;
    }
    
    /**
     * Set pi2
     *
     * @param integer $pi2
     *
     * @return Etapyprodukcji
     */
    public function setPi2($pi2)
    {
        $this->pi2 = $pi2;
        return $this;
    }
    
    /**
     * Get pi2
     *
     * @return integer
     */
    public function getPi2()
    {
        return $this->pi2;
    }
    
    /**
     * Set pi3
     *
     * @param integer $pi3
     *
     * @return Etapyprodukcji
     */
    public function setPi3($pi3)
    {
        $this->pi3 = $pi3;
        return $this;
    }
    
    /**
     * Get pi3
     *
     * @return integer
     */
    public function getPi3()
    {
        return $this->pi3;
    }
    
    /**
     * Set pi4
     *
     * @param integer $pi4
     *
     * @return Etapyprodukcji
     */
    public function setPi4($pi4)
    {
        $this->pi4 = $pi4;
        return $this;
    }
    
    /**
     * Get pi4
     *
     * @return integer
     */
    public function getPi4()
    {
        return $this->pi4;
    }
    
    /**
     * Set pi5
     *
     * @param integer $pi5
     *
     * @return Etapyprodukcji
     */
    public function setPi5($pi5)
    {
        $this->pi5 = $pi5;
        return $this;
    }
    
    /**
     * Get pi5
     *
     * @return integer
     */
    public function getPi5()
    {
        return $this->pi5;
    }
    
    /**
     * Set wydrukowane
     *
     * @param integer $wydrukowane
     *
     * @return Etapyprodukcji
     */
    public function setWydrukowane($wydrukowane)
    {
        $this->wydrukowane = $wydrukowane;
        return $this;
    }
    
    /**
     * Get wydrukowane
     *
     * @return integer
     */
    public function getWydrukowane()
    {
        return $this->wydrukowane;
    }
    
    /**
     * Set zaznaczono
     *
     * @param integer $zaznaczono
     *
     * @return Etapyprodukcji
     */
    public function setZaznaczono($zaznaczono)
    {
        $this->zaznaczono = $zaznaczono;
        return $this;
    }
    
    /**
     * Get zaznaczono
     *
     * @return integer
     */
    public function getZaznaczono()
    {
        return $this->zaznaczono;
    }
}