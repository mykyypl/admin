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
}