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
                        ->select('s, c')
                        ->leftJoin('s.jakie_zam', 'c');

        return $qb;
    }
    
        public function getStatistics//{
//       $em = $this->getDoctrine()->getManager();
//        
//        $articles = $em->createQueryBuilder()
//                ->select('a')
//                ->from('MarcinAdminBundle:Zamowienia', 'a')
//                ->addOrderBy('a.createDate','DESC')
//                ->getQuery()
//                ->getResult();
//    }
                ($limit = null) {
        $qp = $this->createQueryBuilder('p')
                ->select('p')
                ->addOrderBy('p.createDate', 'DESC');

        if (false === is_null($limit)) {
            $qp->setMaxResults($limit);
        }


        return $qp->getQuery()
                        ->getResult();
    }
 
}