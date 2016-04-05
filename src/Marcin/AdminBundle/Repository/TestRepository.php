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
              ->addOrderBy('s.createDate', 'DESC');

     if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['jakie_zamLike'])){
            $jakie_zamLike = '%'.$params['jakie_zamLike'].'%';
            $qb->andWhere('s.nr_user_zam LIKE :jakie_zamLike')
                    ->setParameter('jakie_zamLike', $jakie_zamLike);
        }
                
        return $qb;
    }
    
        public function getStatistics() {
        ////{
//       $em = $this->getDoctrine()->getManager();
//        
//        $articles = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinAdminBundle:Zamowienia', 'a')
//                ->addOrderBy('a.createDate','DESC')
//                ->getQuery()
//                ->getResult();
//    }
//                ($limit = null) {
//        $qp = $this->createQueryBuilder('p')
//                ->select('p')
//                ->addOrderBy('p.createDate', 'DESC');
//
//        if (false === is_null($limit)) {
//            $qp->setMaxResults($limit);
//        }
//
//
//        return $qp->getQuery()
//                        ->getResult();
//    }
        
                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)');
        
        
        $all = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all' => $all
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
}