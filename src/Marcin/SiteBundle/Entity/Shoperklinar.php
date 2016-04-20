<?php

/*
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//use Marcin\AdminBundle\Entity\Shoperzamowienia;
//use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\SiteBundle\Repository\ShoperklinarRepository")
 * @ORM\Table(name="klinar_zamowienia")
 * @ORM\HasLifecycleCallbacks() 
 *
 */
class Shoperklinar {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $idzam;

    /**
     * @ORM\Column(type="string")
     */
    private $imie;

    /**
     * @ORM\Column(type="string")
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string")
     */
    private $adres1;

    /**
     * @ORM\Column(type="string")
     */
    private $adres2;

    /**
     * @ORM\Column(type="string")
     */
    private $telefon;

    /**
     * @ORM\Column(type="string")
     */
    private $firma;

    /**
     * @ORM\Column(type="string")
     */
    private $kodpocztowy;

    /**
     * @ORM\Column(type="string")
     */
    private $miejscowosc;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $uwagi = null;

    /**
     * @ORM\Column(name="datawyslania", type="datetime", nullable=true)
     */
    private $datawyslania = null;

    /**
     * @ORM\Column(name="datawygenerowania", type="datetime", nullable=true)
     */
    private $datawygenerowania = null;

    /**
     * @ORM\Column(name="datamaxdo", type="datetime")
     */
    private $datamaxdo;

    /**
     * @ORM\Column(name="dataodczytania", type="datetime", nullable=true)
     */
    private $dataodczytania = null;

    /**
     * @ORM\ManyToMany(
     *      targetEntity="Marcin\SiteBundle\Entity\Shoperzamowienia", 
     *      inversedBy = "shoperklinar",
     *      cascade={"persist"}
     * )
     * @ORM\JoinTable(name="shoperklinar_shoperzamowienia",
     *  joinColumns={
     *      @ORM\JoinColumn(name="Shoperklinar", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="Shoperzamowienia", referencedColumnName="id")
     *  }
     * 
     * )
     */
    protected $shoper1;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set idzam
     *
     * @param string $idzam
     * @return Shoperklinar
     */
    public function setIdzam($idzam) {
        $this->idzam = $idzam;

        return $this;
    }

    /**
     * Get idzam
     *
     * @return string 
     */
    public function getIdzam() {
        return $this->idzam;
    }

    /**
     * Set imie
     *
     * @param string $imie
     * @return Shoperklinar
     */
    public function setImie($imie) {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie() {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Shoperklinar
     */
    public function setNazwisko($nazwisko) {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko() {
        return $this->nazwisko;
    }

    /**
     * Set adres1
     *
     * @param string $adres1
     * @return Shoperklinar
     */
    public function setAdres1($adres1) {
        $this->adres1 = $adres1;

        return $this;
    }

    /**
     * Get adres1
     *
     * @return string 
     */
    public function getAdres1() {
        return $this->adres1;
    }

    /**
     * Set adres2
     *
     * @param string $adres2
     * @return Shoperklinar
     */
    public function setAdres2($adres2) {
        $this->adres2 = $adres2;

        return $this;
    }

    /**
     * Get adres2
     *
     * @return string 
     */
    public function getAdres2() {
        return $this->adres2;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     * @return Shoperklinar
     */
    public function setTelefon($telefon) {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string 
     */
    public function getTelefon() {
        return $this->telefon;
    }

    /**
     * Set firma
     *
     * @param string $firma
     * @return Shoperklinar
     */
    public function setFirma($firma) {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string 
     */
    public function getFirma() {
        return $this->firma;
    }

    /**
     * Set kodpocztowy
     *
     * @param string $kodpocztowy
     * @return Shoperklinar
     */
    public function setKodpocztowy($kodpocztowy) {
        $this->kodpocztowy = $kodpocztowy;

        return $this;
    }

    /**
     * Get kodpocztowy
     *
     * @return string 
     */
    public function getKodpocztowy() {
        return $this->kodpocztowy;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     * @return Shoperklinar
     */
    public function setMiejscowosc($miejscowosc) {
        $this->miejscowosc = $miejscowosc;

        return $this;
    }

    /**
     * Get miejscowosc
     *
     * @return string 
     */
    public function getMiejscowosc() {
        return $this->miejscowosc;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return Shoperklinar
     */
    public function setUwagi($uwagi) {
        $this->uwagi = $uwagi;

        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string 
     */
    public function getUwagi() {
        return $this->uwagi;
    }

    /**
     * Set datawyslania
     *
     * @param \DateTime $datawyslania
     * @return Shoperklinar
     */
    public function setDatawyslania($datawyslania) {
        $this->datawyslania = $datawyslania;

        return $this;
    }

    /**
     * Get datawyslania
     *
     * @return \DateTime 
     */
    public function getDatawyslania() {
        return $this->datawyslania;
    }

    /**
     * Set datawygenerowania
     *
     * @param \DateTime $datawygenerowania
     * @return Shoperklinar
     */
    public function setDatawygenerowania($datawygenerowania) {
        $this->datawygenerowania = $datawygenerowania;

        return $this;
    }

    /**
     * Get datawygenerowania
     *
     * @return \DateTime 
     */
    public function getDatawygenerowania() {
        return $this->datawygenerowania;
    }

    /**
     * Set datamaxdo
     *
     * @param \DateTime $datamaxdo
     * @return Shoperklinar
     */
    public function setDatamaxdo($datamaxdo) {
        $this->datamaxdo = $datamaxdo;

        return $this;
    }

    /**
     * Get datamaxdo
     *
     * @return \DateTime 
     */
    public function getDatamaxdo() {
        return $this->datamaxdo;
    }

    /**
     * Set dataodczytania
     *
     * @param \DateTime $dataodczytania
     * @return Shoperklinar
     */
    public function setDataodczytania($dataodczytania) {
        $this->dataodczytania = $dataodczytania;

        return $this;
    }

    /**
     * Get dataodczytania
     *
     * @return \DateTime 
     */
    public function getDataodczytania() {
        return $this->dataodczytania;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->date = new \DateTime();
        $this->shoper1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shoper1
     *
     * @param \Marcin\SiteBundle\Entity\Shoperzamowienia $shoper1
     * @return Shoperklinar
     */
    public function addShoper1(\Marcin\SiteBundle\Entity\Shoperzamowienia $shoper1) {
        $this->shoper1[] = $shoper1;
        //$this->shoper1->add($shoper1);
        return $this;
    }

    /**
     * Remove shoper1
     *
     * @param \Marcin\SiteBundle\Entity\Shoperzamowienia $shoper1
     */
    public function removeShoper1(\Marcin\SiteBundle\Entity\Shoperzamowienia $shoper1) {
        $this->shoper1->removeElement($shoper1);
    }

    /**
     * Get shoper1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShoper1() {
        return $this->shoper1;
    }
    
    /**
     * Set shoper1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setShoper1($shoper1)
    {
        $this->shoper1 = $shoper1;
    }

}
