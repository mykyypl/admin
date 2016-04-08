<?php

/* 
 * Marcin Kukliński
 */
namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TestRepository extends EntityRepository
{
    
    public function getQueryBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
              ->addOrderBy('s.sendDate', 'DESC');
        
        if(!empty($params['status'])){
            if('przeslane' == $params['status']){
                $qb->where('s.status = :przeslane')
                        ->setParameter('przeslane', 'przesłane do realizacji');
            }else if('realizacja' == $params['status']){
                $qb->where('s.status = :realizacja')
                        ->setParameter('realizacja', 'w realizacji');
            }else if('wyprodukowane' == $params['status']){
                $qb->where('s.status = :wyprodukowane')
                        ->setParameter('wyprodukowane', 'wyprodukowane');
            }else if('zrealizowane' == $params['status']){
                $qb->where('s.status = :zrealizowane')
                        ->setParameter('zrealizowane', 'zrealizowane/odebrane');
            }
        }
        
        
     if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['userLike'])){
            $jakie_zamLike = '%'.$params['userLike'].'%';
            $qb->andWhere('s.nr_user_zam LIKE :jakie_zamLike')
                    ->setParameter('jakie_zamLike', $jakie_zamLike);
        }
                
        return $qb;
    }
    
        public function getStatistics() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = (int) $qb->getQuery()->getSingleScalarResult();
        $przeslane = $qb->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'przesłane do realizacji')
                        ->getQuery()
                        ->getSingleScalarResult();
        $realizacja = $qb->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'w realizacji')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyprodukowane = $qb->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'wyprodukowane')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'zrealizowane/odebrane')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'przeslane' => $przeslane,
            'realizacja' => $realizacja,
            'wyprodukowane' => $wyprodukowane,
            'zrealizowane' => $zrealizowane
        );
    }
    
            public function getNewzam() {

                $qb = $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.status = :identifier')
                        ->setParameter('identifier', 'przesłane do realizacji');
        
        
        $all_new = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_new' => $all_new
        );
    }
    
                public function getSendzam() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.status = :identifier')
                        ->setParameter('identifier', 'w realizacji');
        
        
        $all_send = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_send' => $all_send
        );
    }
    
    public function getMany() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.status = :identifier')
                        ->setParameter('identifier', 'oczekiwanie na zapłatę');
        
        
        $all_many = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_many' => $all_many
        );
    }
    
    public function getSuma() {

                $qb = $this->createQueryBuilder('u')
                        ->select('SUM(u.do_zaplaty) AS do_zaplaty')
                        ->where('u.zaplacono = :status_zaplaty')
                        ->setParameter('status_zaplaty', '0');
        
        
        $all_suma = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_suma' => $all_suma
        );
    }
    
     public function getWyprodukowane() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.status = :identifier')
                        ->setParameter('identifier', 'wyprodukowane');
        
        
        $all_wyprodukowane = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_wyprodukowane' => $all_wyprodukowane
        );
    }
}