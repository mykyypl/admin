<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AktywnyRepository extends EntityRepository
{
    
    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.id', 'DESC');

        return $qb;
    }
    
     public function getAktualni(){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s');
              //->addOrderBy('s.id', 'DESC');

        $active = $qb->getQuery()->getArrayResult();
 return array(
            'aktualniu' => $active
        );
    }
    
    public function getUserlivecount() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)');
//                        ->where('u.new = :identifier')
//                        ->setParameter('identifier', '1');
        
        
        $active = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'active' => $active
        );
    }
    
}