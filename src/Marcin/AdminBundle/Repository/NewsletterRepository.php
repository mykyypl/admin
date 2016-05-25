<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NewsletterRepository extends EntityRepository
{
     public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.id', 'DESC');

     if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['id_zamLike'])){
            $jakie_zamLike = '%'.$params['id_zamLike'].'%';
            $qb->andWhere('s.tytul LIKE :id_zamLike')
                    ->setParameter('id_zamLike', $jakie_zamLike);
        }
                
        return $qb;
    }
}