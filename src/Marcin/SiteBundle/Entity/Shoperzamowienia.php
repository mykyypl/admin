<?php

/*
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Entity;

//use Marcin\AdminBundle\Entity\Shoperklinar;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Component\Validator\Constraints as Assert;
//use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\SiteBundle\Repository\ShoperzamowieniaRepository")
 * @ORM\Table(name="shoperzamowienia")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Shoperzamowienia {
    
    const UPLOAD_DIR = 'uploads/zalacznikiklinar';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $idzam;

    /**
     * @ORM\Column(type="string", nullable=true)
     * 
     * 
     */
    private $suma = null;

    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $nazwa;

    /**
     * @ORM\Column(type="string")
     */
    private $kod;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $wariant = null;

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
    private $miejscowosc;

    /**
     * @ORM\Column(type="string")
     */
    private $adres1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $adres2 = null;

    /**
     * @ORM\Column(type="string")
     */
    private $ilosc;

    /**
     * @ORM\Column(type="string")
     */
    private $jednostka;

    /**
     * @ORM\Column(type="string")
     */
    private $telefon;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firma = null;

    /**
     * @ORM\Column(type="string")
     */
    private $nip;

    /**
     * @ORM\Column(type="string")
     */
    private $kodpocztowy;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $wojewodztwo = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $producent = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     */
    private $zaznaczono = null;

    /**
     * 
     * @ORM\Column(type="integer", nullable=true)
     * 
     */
    private $idposrednik = null;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * 
     */
    private $zrealizowano = null;  
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * 
     */
    private $klinaryt = null;  

    /**
     * @ORM\Column(type="string", nullable=true)
     * 
     */
    private $uwagi = null;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zalacznik = null;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * 
     */
    private $zamok = null;  
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * 
     * 
     */
    private $wyslane = null;  
    
    /**
     * @Assert\File(
     *      maxSize = "5M",
     *      mimeTypes = {"application/pdf", "application/x-pdf", "application/msword", "application/acad", "image/vnd.dwg", "image/x-dwg", "image/jpeg", "image/pjpeg", "image/jpeg", "image/pjpeg", "image/png", "application/x-compressed", "application/x-zip-compressed", "application/zip", "multipart/x-zip", "application/x-acad", "application/autocad_dwg", "application/dwg", "application/x-dwg", "application/x-autocad", "drawing/dwg"},
     *      mimeTypesMessage = "Obsługiwany format plików: pdf,doc,dwg,jpg,jpeg,png,zip (MAX 5M)"
     * )
     */
    private $files;
    
    private $filesTemps;
    
    /**
     * 
     * @ORM\ManyToMany(
     *      targetEntity = "Marcin\SiteBundle\Entity\Shoperklinar",
     *      mappedBy = "shoper1"
     * )
     * 
     */
    protected $shoperklinar;

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
     * Set idzam
     *
     * @param string $idzam
     * @return Shoperzamowienia
     */
    public function setIdzam($idzam)
    {
        $this->idzam = $idzam;

        return $this;
    }

    /**
     * Get idzam
     *
     * @return string 
     */
    public function getIdzam()
    {
        return $this->idzam;
    }

    /**
     * Set suma
     *
     * @param string $suma
     * @return Shoperzamowienia
     */
    public function setSuma($suma)
    {
        $this->suma = $suma;

        return $this;
    }

    /**
     * Get suma
     *
     * @return string 
     */
    public function getSuma()
    {
        return $this->suma;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Shoperzamowienia
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return Shoperzamowienia
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
     * Set kod
     *
     * @param string $kod
     * @return Shoperzamowienia
     */
    public function setKod($kod)
    {
        $this->kod = $kod;

        return $this;
    }

    /**
     * Get kod
     *
     * @return string 
     */
    public function getKod()
    {
        return $this->kod;
    }

    /**
     * Set wariant
     *
     * @param string $wariant
     * @return Shoperzamowienia
     */
    public function setWariant($wariant)
    {
        $this->wariant = $wariant;

        return $this;
    }

    /**
     * Get wariant
     *
     * @return string 
     */
    public function getWariant()
    {
        return $this->wariant;
    }

    /**
     * Set imie
     *
     * @param string $imie
     * @return Shoperzamowienia
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Shoperzamowienia
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     * @return Shoperzamowienia
     */
    public function setMiejscowosc($miejscowosc)
    {
        $this->miejscowosc = $miejscowosc;

        return $this;
    }

    /**
     * Get miejscowosc
     *
     * @return string 
     */
    public function getMiejscowosc()
    {
        return $this->miejscowosc;
    }

    /**
     * Set adres1
     *
     * @param string $adres1
     * @return Shoperzamowienia
     */
    public function setAdres1($adres1)
    {
        $this->adres1 = $adres1;

        return $this;
    }

    /**
     * Get adres1
     *
     * @return string 
     */
    public function getAdres1()
    {
        return $this->adres1;
    }

    /**
     * Set adres2
     *
     * @param string $adres2
     * @return Shoperzamowienia
     */
    public function setAdres2($adres2)
    {
        $this->adres2 = $adres2;

        return $this;
    }

    /**
     * Get adres2
     *
     * @return string 
     */
    public function getAdres2()
    {
        return $this->adres2;
    }

    /**
     * Set ilosc
     *
     * @param string $ilosc
     * @return Shoperzamowienia
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return string 
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set jednostka
     *
     * @param string $jednostka
     * @return Shoperzamowienia
     */
    public function setJednostka($jednostka)
    {
        $this->jednostka = $jednostka;

        return $this;
    }

    /**
     * Get jednostka
     *
     * @return string 
     */
    public function getJednostka()
    {
        return $this->jednostka;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     * @return Shoperzamowienia
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string 
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set firma
     *
     * @param string $firma
     * @return Shoperzamowienia
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string 
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Shoperzamowienia
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set kodpocztowy
     *
     * @param string $kodpocztowy
     * @return Shoperzamowienia
     */
    public function setKodpocztowy($kodpocztowy)
    {
        $this->kodpocztowy = $kodpocztowy;

        return $this;
    }

    /**
     * Get kodpocztowy
     *
     * @return string 
     */
    public function getKodpocztowy()
    {
        return $this->kodpocztowy;
    }

    /**
     * Set wojewodztwo
     *
     * @param string $wojewodztwo
     * @return Shoperzamowienia
     */
    public function setWojewodztwo($wojewodztwo)
    {
        $this->wojewodztwo = $wojewodztwo;

        return $this;
    }

    /**
     * Get wojewodztwo
     *
     * @return string 
     */
    public function getWojewodztwo()
    {
        return $this->wojewodztwo;
    }

    /**
     * Set producent
     *
     * @param string $producent
     * @return Shoperzamowienia
     */
    public function setProducent($producent)
    {
        $this->producent = $producent;

        return $this;
    }

    /**
     * Get producent
     *
     * @return string 
     */
    public function getProducent()
    {
        return $this->producent;
    }

    /**
     * Set zaznaczono
     *
     * @param integer $zaznaczono
     * @return Shoperzamowienia
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

    /**
     * Set idposrednik
     *
     * @param integer $idposrednik
     * @return Shoperzamowienia
     */
    public function setIdposrednik($idposrednik)
    {
        $this->idposrednik = $idposrednik;

        return $this;
    }

    /**
     * Get idposrednik
     *
     * @return integer 
     */
    public function getIdposrednik()
    {
        return $this->idposrednik;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return Shoperzamowienia
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
     * Set zrealizowano
     *
     * @param string $zrealizowano
     *
     * @return Shoperzamowienia
     */
    public function setZrealizowano($zrealizowano)
    {
        $this->zrealizowano = $zrealizowano;
        return $this;
    }
    /**
     * Get zrealizowano
     *
     * @return string
     */
    public function getZrealizowano()
    {
        return $this->zrealizowano;
    }
    
    /**
     * Set klinaryt
     *
     * @param string $klinaryt
     *
     * @return Shoperzamowienia
     */
    public function setKlinaryt($klinaryt)
    {
        $this->klinaryt = $klinaryt;
        return $this;
    }
    
    /**
     * Get klinaryt
     *
     * @return string
     */
    public function getKlinaryt()
    {
        return $this->klinaryt;
    }
    
    /**
     * Set zamok
     *
     * @param string $zamok
     *
     * @return Shoperzamowienia
     */
    public function setZamok($zamok)
    {
        $this->zamok = $zamok;
        return $this;
    }
    
    /**
     * Get zamok
     *
     * @return string
     */
    public function getZamok()
    {
        return $this->zamok;
    }
    
    /**
     * Set wyslane
     *
     * @param string $wyslane
     *
     * @return Shoperzamowienia
     */
    public function setWyslane($wyslane)
    {
        $this->wyslane = $wyslane;
        return $this;
    }
    
    /**
     * Get wyslane
     *
     * @return string
     */
    public function getWyslane()
    {
        return $this->wyslane;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shoperklinar = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shoperklinar
     *
     * @param \Marcin\SiteBundle\Entity\Shoperklinar $shoperklinar
     * @return Shoperzamowienia
     */
    public function addShoperklinar(\Marcin\SiteBundle\Entity\Shoperklinar $shoperklinar)
    {
        $this->shoperklinar[] = $shoperklinar;

        return $this;
    }

    /**
     * Remove shoperklinar
     *
     * @param \Marcin\SiteBundle\Entity\Shoperklinar $shoperklinar
     */
    public function removeShoperklinar(\Marcin\SiteBundle\Entity\Shoperklinar $shoperklinar)
    {
        $this->shoperklinar->removeElement($shoperklinar);
    }

    /**
     * Get shoperklinar
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShoperklinar()
    {
        return $this->shoperklinar;
    }
    
    /**
     * Set shoperklinar
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setShoperklinar($shoperklinar)
    {
        $this->shoperklinar = $shoperklinar;
    }
    
    /**
     * Set zalacznik
     *
     * @param string $zalacznik
     * @return Shoperzamowienia
     */
    public function setZalacznik($zalacznik) {
        $this->zalacznik = $zalacznik;

        return $this;
    }

    /**
     * Get zalacznik
     *
     * @return string 
     */
    public function getZalacznik() {
        return $this->zalacznik;
    }
    
       public function getAbsolutePath()
    {
        return null === $this->zalacznik
            ? null
            : $this->getUploadRootDir().'/'.$this->zalacznik;
    }

    public function getWebPath()
    {
        return null === $this->zalacznik
            ? null
            : $this->getUploadDir().'/'.$this->zalacznik;
    }
    public function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.self::UPLOAD_DIR;
    }
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/zalacznikiklinar';
    }
    
    /**
     * Sets files.
     *
     * @param UploadedFile $files
     */
    public function setFiles(UploadedFile $files = null)
    {
        //$this->files = $files;
        $this->files = $files;
        // check if we have an old image path
        if (isset($this->zalacznik)) {
            // store the old name to delete after the update
            $this->filesTemps = $this->zalacznik;
            $this->zalacznik = null;
        } else {
            $this->zalacznik = 'initial';
        }
    }

    /**
     * Get files.
     *
     * @return UploadedFile
     */
    public function getFiles()
    {
        return $this->files;
    }
    
//    public function uploads()
//    {
//    // the file property can be empty if the field is not required
//    if (null === $this->getFiles()) {
//        return;
//    }
//
//    // use the original file name here but you should
//    // sanitize it at least to avoid any security issues
//
//    // move takes the target directory and then the
//    // target filename to move to
//    $this->getFiles()->move(
//        $this->getUploadRootDir(),
//        $this->getFiles()->getClientOriginalName()
//    );
//
//    // set the path property to the filename where you've saved the file
//    $this->zalacznik = $this->getFiles()->getClientOriginalName();
//
//    // clean up the file property as you won't need it anymore
//    $this->files = null;
//    }
    
        /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFiles()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->zalacznik = $filename.'.'.$this->getFiles()->guessExtension();
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $files = $this->getAbsolutePath();
        if ($files) {
            unlink($files);
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFiles()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFiles()->move($this->getUploadRootDir(), $this->zalacznik);

        // check if we have an old image
        if (isset($this->filesTemps)) {
            // delete the old image
           // unlink($this->getUploadRootDir().'/'.$this->zalacznik);
            // clear the temp image path
            
             if (file_exists($this->getUploadRootDir() .'/'. $this->filesTemps)) {    //////    /   bugfix
                unlink($this->getUploadRootDir() . '/' . $this->filesTemps);            ////    \   z oficjalnej dokumentacji symfony 2.8 !
            }
            
            $this->filesTemps = null;
        }
        $this->files = null;
    }

}
