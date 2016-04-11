<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShoperzamowieniaRepository extends EntityRepository
{
    
    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.id', 'DESC');

        return $qb;
    }
    
     
    
}