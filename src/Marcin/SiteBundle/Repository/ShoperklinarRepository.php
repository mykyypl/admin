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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
                       // ->setParameter('zaznaczono', 'IS NOT NULL');
            }
//            else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
//                        ->andWhere('s.datawyslania IS NOT NULL');
//                       // ->setParameter('zaznaczono', 'IS NOT NULL');
//            }
        }
        //TOOO
        
//         if(!empty($params['status'])){
//            if('dowyslania' == $params['status']){
//                $qb->andwhere('s.datawyslania IS NULL ');
//                        //->andWhere('s.datawyslania IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc IS NOT NULL ');
//                        //->andWhere('s.datawyslania IS NOT NULL');
//                       // ->setParameter('zaznaczono', 'IS NOT NULL');
//            }
//            else if('wyslane' == $params['status']){
//                $qb->andwhere('s.datawyslania IS NOT NULL AND s.calosc IS NULL');
//                       // ->andWhere('s.datawyslania IS NOT NULL');
//                       // ->setParameter('zaznaczono', 'IS NOT NULL');
//            }//else if('wyslane' == $params['status']){
////                $qb->andwhere('AND s.pdf IS NOT NULL AND s.nrlistu IS NOT NULL');
////                       // ->andWhere('s.datawyslania IS NOT NULL');
////                       // ->setParameter('zaznaczono', 'IS NOT NULL');
////            }
//        }
        
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getKlinarPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Klinar')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getAwaxPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'AWAX')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getInvestPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Invest')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getPartnerPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'PartnerPlast')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getSelenaPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Selena')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getHannoPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Hanno')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getZygmarPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'Zygmar')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }
        }
        if(!empty($params['idLike'])){
            $jakie_zamLike = '%'.$params['idLike'].'%';
            $qb->andWhere('s.id LIKE :idLike')
                    ->setParameter('idLike', $jakie_zamLike);
        }
        
        
        return $qb;
    }
    
    public function getVipPanelBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'VIP')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.nrlistu IS NULL AND s.pdf IS NULL AND s.datawyslania IS NULL');
//                        //->andWhere('s.datawyslania IS NULL');
//            } 
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
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
    
    public function getInvestSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getAwaxSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getPartnerplastSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getSelenaSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getStierSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getZygmarSendBuilder($id){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.id = :zaznaczono')
                ->setParameter('zaznaczono', $id)
              ->addOrderBy('s.id', 'DESC');
        
        return $qb;
    }
    
    public function getVipSendBuilder($id){
        
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
    
    public function getStatisticsKlinarPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Klinar')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Klinar')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Klinar')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsAwaxPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'AWAX')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'AWAX')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'AWAX')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsInvestPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Invest')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Invest')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Invest')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsPartnerPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'PartnerPlast')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'PartnerPlast')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'PartnerPlast')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsSelenaPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Selena')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Selena')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Selena')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsHannoPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Hanno')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Hanno')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Hanno')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
        public function getStatisticsZygmarPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Zygmar')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Zygmar')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'Zygmar')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getStatisticsVipPanel() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'VIP')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'VIP')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                       // ->setParameter('currDate', NULL)
                        ->setParameter('test', '1')
                                ->andWhere('a.kategoria = :kategoria')
                ->setParameter('kategoria', 'VIP')
                  // ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                       // ->setParameter('producent', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getStatisticsKlinar() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'Klinar');
        $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsInvest() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'Invest');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsAwax() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'AWAX');
        $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsPartnerplast() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'PartnerPlast');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsSelena() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'Selena');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsStier() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'Hanno');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsZygmar() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'Zygmar');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
    
    public function getStatisticsVip() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)')
                ->andWhere('a.kategoria = :producent')
                ->setParameter('producent', 'VIP');
         $all = $qb->andWhere('a.datawyslania IS NOT NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $nowe = $qb->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
    
    public function getVipBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
                ->where('s.kategoria = :zaznaczono')
                ->setParameter('zaznaczono', 'VIP')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
             if('nowe' == $params['status']){
                $qb->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL')
                        ->andWhere('s.datawyslania IS NOT NULL');
                        //->andWhere('s.datawyslania IS NULL');
            }
            else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL')
                        ->andWhere('s.datawyslania IS NOT NULL')
                        ->andwhere('s.calosc = :calosc')
                        ->setParameter('calosc', '1');
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
    
        public function getStatisticsAllzam() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $dowyslania = $qb->andWhere('a.datawyslania IS NULL AND a.calosc IS NULL')
                  ->getQuery()    
                  ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.datawyslania IS NOT NULL')
                   ->andWhere('a.nrlistu IS NULL OR a.pdf IS NULL OR a.calosc IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.nrlistu IS NOT NULL AND a.pdf IS NOT NULL AND a.calosc = :test AND a.datawyslania IS NOT NULL')
                        ->setParameter('test', '1')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getAllzamBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s, t')
                //->leftJoin('MarcinAdminBundle:Shoperzamowienia', 'ct', 'WITH', 'ct.idposrednik = s.id');
                ->leftJoin('s.shoper1', 't')
              ->addOrderBy('s.id', 'DESC');
        
        if(!empty($params['status'])){
            if('zrealizowane' == $params['status']){
                $qb->andwhere('s.nrlistu IS NOT NULL AND s.pdf IS NOT NULL AND s.calosc = :test AND s.datawyslania IS NOT NULL')
                       // ->andWhere('s.datawyslania IS NOT NULL');
                        ->setParameter('test', '1');
            } else if('wyslane' == $params['status']){
               $qb->andwhere('s.datawyslania IS NOT NULL')
                       ->andwhere('s.nrlistu IS NULL OR s.pdf IS NULL OR s.calosc IS NULL');
        } else if('dowyslania' == $params['status']){
               $qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
        }else if('all' == $params['status']){
               //$qb->andwhere('s.datawyslania IS NULL AND s.calosc IS NULL');
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