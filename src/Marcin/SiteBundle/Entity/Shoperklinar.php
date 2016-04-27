<?php

/*
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//use Marcin\AdminBundle\Entity\Shoperzamowienia;
//use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="Marcin\SiteBundle\Repository\ShoperklinarRepository")
 * @ORM\Table(name="klinar_zamowienia")
 * @ORM\HasLifecycleCallbacks() 
 *
 */
class Shoperklinar {
    
    const UPLOAD_DIR = 'uploads/faktury';

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
     * @ORM\Column(name="modyfikacja", type="datetime", nullable=true)
     */
    private $modyfikacja = null;

    /**
     * @ORM\Column(name="dataodczytania", type="datetime", nullable=true)
     */
    private $dataodczytania = null;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * 
     */
    private $uwagiklinar = null;

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
     * @ORM\Column(type="string")
     */
    private $nrlistu;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pdf = null;
    
    /**
     * @Assert\File(
     *      maxSize = "3M",
     *      mimeTypes = {"application/pdf", "application/x-pdf"},
     *      mimeTypesMessage = "Obsługiwany format plików: PDF"
     * )
     */
    private $file;
    
    private $fileTemp;

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
     * Set modyfikacja
     *
     * @param \DateTime $modyfikacja
     * @return Shoperklinar
     */
    public function setModyfikacja($modyfikacja) {
        $this->modyfikacja = $modyfikacja;

        return $this;
    }

    /**
     * Get modyfikacja
     *
     * @return \DateTime 
     */
    public function getModyfikacja() {
        return $this->modyfikacja;
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
    
    /**
     * Set pdf
     *
     * @param string $pdf
     * @return Shoperklinar
     */
    public function setPdf($pdf) {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string 
     */
    public function getPdf() {
        return $this->pdf;
    }
    
    /**
     * Set nrlistu
     *
     * @param string $nrlistu
     * @return Shoperklinar
     */
    public function setNrlistu($nrlistu) {
        $this->nrlistu = $nrlistu;

        return $this;
    }

    /**
     * Get nrlistu
     *
     * @return string 
     */
    public function getNrlistu() {
        return $this->nrlistu;
    }
    
    /**
     * Set uwagiklinar
     *
     * @param string $uwagiklinar
     *
     * @return Shoperklinar
     */
    public function setUwagiklinar($uwagiklinar)
    {
        $this->uwagiklinar = $uwagiklinar;
        return $this;
    }
    /**
     * Get uwagiklinar
     *
     * @return string
     */
    public function getUwagiklinar()
    {
        return $this->uwagiklinar;
    }
    
//    /**
//     * Set file
//     *
//     * @param string $file
//     * @return Shoperklinar
//     */
//    public function setFile(UploadedFile $file = null)
//    {
////        $this->file = $file;
////        return $this;
//                $this->file = $file;
//        // check if we have an old image path
//        if (isset($this->file)) {
//            // store the old name to delete after the update
//            $this->fileTemp = $this->file;
//            $this->file = null;
//        } else {
//            $this->file = 'initial';
//        }
//    }
//    
//    /**
//     * Get file
//     *
//     * @return string 
//     */
//    public function getFile()
//    {
//        return $this->file;
//    }
//    
//    
//    public function getFileFile() {
//        return $this->fileFile;
//    }
//    public function setFileFile(UploadedFile $fileFile) {
//        $this->fileFile = $fileFile;
//        //$this->updateDate = new \DateTime();
//        return $this;
//    }
//    
//    /**
//     * @ORM\PrePersist
//     * @ORM\PreUpdate
//     */
//    public function preSave(){
//        if(null !== $this->getFileFile()){
//            
//            if(null !== $this->file){
//                $this->fileTemp = $this->file;
//            }
//            
//            $fileName = sha1(uniqid(null, true));
//            $this->file = $fileName.'.'.$this->getFileFile()->guessExtension();
//        }
//        
////        if(null === $this->createDate){
////            $this->createDate = new \DateTime();
////        }
//    }
    
//    /**
//     * @ORM\PostPersist
//     * @ORM\PostUpdate
//     */
//    public function postSave(){
//        if(NULL !== $this->getFileFile()){
//            $this->getFileFile()->move($this->getUploadRootDir(), $this->file);
//           // $this->imageResize($this->getUploadRootDir(), $this->image);
//                        
//            unset($this->fileFile);
//            
//            if(isset($this->fileTemp)){
//                \Marcin\SiteBundle\Libs\Utils::removeFile($this->getUploadRootDir(), $this->fileTemp);
//                unset($this->fileTemp);
//            }
//        }
//    }
//    
//    /**
//     * @ORM\PostRemove
//     */
//    public function postRemove() {
//        if(null !== $this->file){
//            \Marcin\SiteBundle\Libs\Utils::removeFile($this->getUploadRootDir(), $this->fileTemp);
//        }
//    }
//    
//    /**
//     * @ORM\PrePersist()
//     * @ORM\PreUpdate()
//     */
//    public function preUpload()
//    {
//        if (null !== $this->getFile()) {
//            // do whatever you want to generate a unique name
//            $filename = sha1(uniqid(mt_rand(), true));
//            $this->file = $filename.'.'.$this->getFile()->guessExtension();
//        }
//    }
//
//    /**
//     * @ORM\PostPersist()
//     * @ORM\PostUpdate()
//     */
//    public function upload()
//    {
//        if (null === $this->getFile()) {
//            return;
//        }
//
//        // if there is an error when moving the file, an exception will
//        // be automatically thrown by move(). This will properly prevent
//        // the entity from being persisted to the database on error
//        $this->getFile()->move($this->getUploadRootDir(), $this->file);
//
//        // check if we have an old image
//        if (isset($this->fileTemp)) {
//            // delete the old image
//            unlink($this->getUploadRootDir().'/'.$this->fileTemp);
//            // clear the temp image path
//            $this->fileTemp = null;
//        }
//        $this->file = null;
//    }
//
//    /**
//     * @ORM\PostRemove()
//     */
//    public function removeUpload()
//    {
//        $file = $this->getAbsolutePath();
//        if ($file) {
//            unlink($file);
//        }
//    }
    public function getAbsolutePath()
    {
        return null === $this->pdf
            ? null
            : $this->getUploadRootDir().'/'.$this->pdf;
    }

    public function getWebPath()
    {
        return null === $this->pdf
            ? null
            : $this->getUploadDir().'/'.$this->pdf;
    }
    public function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.self::UPLOAD_DIR;
    }
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/faktury';
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function upload()
    {
    // the file property can be empty if the field is not required
    if (null === $this->getFile()) {
        return;
    }

    // use the original file name here but you should
    // sanitize it at least to avoid any security issues

    // move takes the target directory and then the
    // target filename to move to
    $this->getFile()->move(
        $this->getUploadRootDir(),
        $this->getFile()->getClientOriginalName()
    );

    // set the path property to the filename where you've saved the file
    $this->pdf = $this->getFile()->getClientOriginalName();

    // clean up the file property as you won't need it anymore
    $this->file = null;
    }
    

}
