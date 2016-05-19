<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Marcin\AdminBundle\Repository\UsernameRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * 
 * 
 */
class Username {
       
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\NotBlank
     * 
     */
    private $new;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $imie_nazw;
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     */
    private $aktywacja;
    
    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     */
    private $login; 
    
    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     */
    private $email; 
    
    /**
     * @ORM\Column(type="string")
     * 
     * 
     */
    private $trasa;
    
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
     * Set new
     *
     * @param integer $new
     *
     * @return Username
     */
    public function setNew($new)
    {
        $this->new = $new;
        return $this;
    }
    /**
     * Get new
     *
     * @return integer
     */
    public function getNew()
    {
        return $this->new;
    }
    
    /**
     * Set imienazw
     *
     * @param string $imie_nazw
     *
     * @return Seo
     */
    public function setImienazw($imie_nazw)
    {
        $this->imie_nazw = $imie_nazw;
        return $this;
    }
    /**
     * Get imienazw
     *
     * @return string
     */
    public function getImienazw()
    {
        return $this->imie_nazw;
    }
    
    /**
     * Get login
     *
     * 
     */
    public function getLogin()
    {
        return $this->login;
    }
    
    /**
     * Set login
     *
     * @param string $login
     *
     * @return Username
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }
    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Username
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set aktywacja
     *
     * @param string $aktywacja
     *
     * @return Username
     */
    public function setAktywacja($aktywacja)
    {
        $this->aktywacja = $aktywacja;
        return $this;
    }
    /**
     * Get aktywacja
     *
     * @return string
     */
    public function getAktywacja()
    {
        return $this->aktywacja;
    }
    
      function __construct() {
        //$this->registerDate = new \DateTime();
    }
    
    /**
     * Set trasa
     *
     * @param integer $trasa
     *
     * @return Username
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

    
}