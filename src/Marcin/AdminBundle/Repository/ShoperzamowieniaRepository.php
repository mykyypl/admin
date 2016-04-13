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

          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.idzam LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getKlinarBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Klinar')
              ->addOrderBy('s.id', 'DESC');

          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.idzam LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
        public function getKlinarBuildertest(){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.zaznaczono = :realizacja')
                ->setParameter('realizacja', '1')
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
     
    
}