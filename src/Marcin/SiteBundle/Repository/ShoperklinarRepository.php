<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShoperklinarRepository extends EntityRepository
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
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
               // ->where('s.zaznaczono = :zaznaczono')
              //  ->setParameter('zaznaczono', '66')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
     
    
}