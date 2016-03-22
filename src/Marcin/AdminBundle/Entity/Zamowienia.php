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
     * @ORM\Column(name="data", type="datetime")
     */
    private $createDate;
            
    /**
     * @ORM\Column(name="data_wyslania", type="datetime")
     */
    private $sendDate;

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
     * Set title
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
     * Get title
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set content
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
     * Get content
     *
     * @return string
     */
    public function getJakie_zam()
    {
        return $this->jakie_zam;
    }
    
    /**
     * Get category
     *
     * 
     */
    public function getStatus()
    {
        return $this->status;
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
}

