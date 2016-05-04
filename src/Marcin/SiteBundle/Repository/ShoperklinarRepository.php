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
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Klinar')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
     
    public function getKlinarSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getStatistics() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.datawyslania IS NOT NULL')
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
    
    public function getInvestBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Invest')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getPartnerBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'PartnerPlast')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getSelenaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Selena')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getHannoBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Hanno')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getAwaxBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'AWAX')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getZygmarBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Zygmar')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
}