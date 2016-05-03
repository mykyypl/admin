<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\SiteBundle\Repository;

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

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '66');
            }
        }
        
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
    
        public function getStatistics() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Klinar')
                        ->getQuery()    
                        ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                       // ->setParameter('currDate', NULL)
                       //  ->andWhere('a.producent = :producent')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'nowe' => $nowe,
            'zrealizowane' => ($all - $nowe)
        );
    }
    
//     public function getTagsListOcc(){
//        $qb = $this->createQueryBuilder('t')
//                        ->select('t.name, t.name, COUNT(p) as occ')
//                        ->leftJoin('t.articles', 'a')
//                        ->groupBy('t.name');
//        
//        return $qb->getQuery()->getArrayResult();
//    }
     
        public function getInvestBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Invest')
              ->addOrderBy('s.id', 'DESC');

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '55');
                //55 INVEST
            }
        }
        
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
    
    public function getStatisticsinvest() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Invest')
                        ->getQuery()    
                        ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                       // ->setParameter('currDate', NULL)
                       //  ->andWhere('a.producent = :producent')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'nowe' => $nowe,
            'zrealizowane' => ($all - $nowe)
        );
    }
    
    public function getPartnerBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'PartnerPlast')
              ->addOrderBy('s.id', 'DESC');

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '44');
                //44 Partner
            }
        }
        
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
    
    public function getStatisticspartner() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'PartnerPlast')
                        ->getQuery()    
                        ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                       // ->setParameter('currDate', NULL)
                       //  ->andWhere('a.producent = :producent')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'nowe' => $nowe,
            'zrealizowane' => ($all - $nowe)
        );
    }
    
    public function getSelenaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Selena')
              ->addOrderBy('s.id', 'DESC');

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '33');
                //33 Selena
            }
        }
        
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
    
    public function getStatisticsselena() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Selena')
                        ->getQuery()    
                        ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                       // ->setParameter('currDate', NULL)
                       //  ->andWhere('a.producent = :producent')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'nowe' => $nowe,
            'zrealizowane' => ($all - $nowe)
        );
    }
    
    public function getHannoBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Hanno')
              ->addOrderBy('s.id', 'DESC');

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '22');
                //22 Hanno
            }
        }
        
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
    
    public function getStatisticshanno() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Hanno')
                        ->getQuery()    
                        ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                       // ->setParameter('currDate', NULL)
                       //  ->andWhere('a.producent = :producent')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'nowe' => $nowe,
            'zrealizowane' => ($all - $nowe)
        );
    }
    
}