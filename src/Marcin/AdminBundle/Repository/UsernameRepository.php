<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsernameRepository extends EntityRepository
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
            $qb->andWhere('s.id_zam LIKE :id_zamLike')
                    ->setParameter('id_zamLike', $jakie_zamLike);
        }
                
        return $qb;
    }
    
    public function getUserstat() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.new = :identifier')
                        ->setParameter('identifier', '1');
        
        
        $user = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'user' => $user
        );
    }
}