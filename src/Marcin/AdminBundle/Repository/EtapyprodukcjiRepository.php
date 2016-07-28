<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EtapyprodukcjiRepository extends EntityRepository
{
    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.id', 'DESC');

        return $qb;
    }
    
    public function getEtykietyBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.online = :online')
                ->setParameter('online', '1')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.wydrukowane is NULL');
            }elseif('all' == $params['status']){
                $qb->andwhere('s.wydrukowane is NOT NULL');
            }
        }
        
        if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.nrzamowienia LIKE :id_zamLike')
                    ->setParameter('id_zamLike', $jakie_zamLike);
        }

        return $qb;
    }
    
    public function getEtykietyGenBuilder(){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                 ->where('s.online = :online')
                 ->setParameter('online', '1')
                // ->andwhere('s.wydrukowane is NULL')
                 ->andwhere('s.zaznaczono = :zaz')
                 ->setParameter('zaz', '1')
                 ->addOrderBy('s.id', 'ASC')
                 ->getQuery()
                 ->getResult();

        return $qb;
    }
    
}