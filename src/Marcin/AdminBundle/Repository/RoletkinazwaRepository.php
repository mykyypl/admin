<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoletkinazwaRepository extends EntityRepository
{
    
    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.id', 'DESC');

        if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['userLike'])){
            $jakie_zamLike = '%'.$params['userLike'].'%';
            $qb->andWhere('s.roletki_nazwa LIKE :jakie_zamLike')
                    ->setParameter('jakie_zamLike', $jakie_zamLike);
        }
        
        
        if (!empty($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }
                
        return $qb;
    }
}