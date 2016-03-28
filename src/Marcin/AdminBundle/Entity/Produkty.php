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
    
}