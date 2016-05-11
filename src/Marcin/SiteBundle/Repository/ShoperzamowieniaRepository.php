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

        if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.producent IS NULL OR s.producent = :wartosc')
                ->setParameter('wartosc', '');
            }else if('przypisane' == $params['status']){
                $qb->andwhere('s.producent != :empty')
                        ->setParameter('empty', '');
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
    
    public function getStatisticsShoperprodukty() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Klinar')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
        $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.producent IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $przypisane = $qb_dowyslania->andwhere('a.producent IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();

        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'przypisane' => $przypisane
        );
    }
    
    public function getKlinarBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Klinar')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '66');
//            }
//        }
            if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '66')
                       // ->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '66')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '66')
                        ->andwhere('s.wyslane IS NOT NULL')
                        //->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Klinar')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
        $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Klinar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Klinar')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '66')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Klinar')
                 ->andwhere('a.wyslane IS NOT NULL')
                        //->andwhere('a.zrealizowano IS NULL')
                ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Klinar')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
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

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '55');
//                //55 INVEST
//            }
//        }
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '55')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '55')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '55')
                        ->andwhere('s.wyslane IS NOT NULL')
                       // ->andwhere('s.zrealizowano IS NULL OR s.zrealizowano =:zrealizowano')
                       // ->setParameter('zrealizowano', '0')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Invest')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Invest')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Invest')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '55')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Invest')
                 ->andwhere('a.wyslane IS NOT NULL')  
                        ->andwhere('a.zamok IS NULL')
                        //->andwhere('a.zrealizowano IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Invest')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                        ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getPartnerBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'PartnerPlast')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '44');
//                //44 Partner
//            }
//        }
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '44')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '44')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '44')
                        ->andwhere('s.wyslane IS NOT NULL')
                        //->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'PartnerPlast')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'PartnerPlast')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'PartnerPlast')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '44')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'PartnerPlast')
                 ->andwhere('a.wyslane IS NOT NULL')
                        //->andwhere('a.zrealizowano IS NULL')
                        ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'PartnerPlast')
                        ->andwhere('a.zamok IS NOT NULL')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getSelenaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Selena')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '33');
//                //33 Selena
//            }
//        }
        
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '33')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '33')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '33')
                        ->andwhere('s.wyslane IS NOT NULL')
                       // ->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Selena')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Selena')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Selena')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '33')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Selena')
                 ->andwhere('a.wyslane IS NOT NULL')
                        //->andwhere('a.zrealizowano IS NULL')
                            ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Selena')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                     ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getHannoBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Hanno')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '22');
//                //22 Hanno
//            }
//        }
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '22')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '22')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '22')
                        ->andwhere('s.wyslane IS NOT NULL')
                        //->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Hanno')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Hanno')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Hanno')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '22')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Hanno')
                 ->andwhere('a.wyslane IS NOT NULL')
                        //->andwhere('a.zrealizowano IS NULL')
                        ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Hanno')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getAwaxBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'AWAX')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '77');
//                //77 awax
//            }
//        }
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '77')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '77')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '77')
                        ->andwhere('s.wyslane IS NOT NULL')
                        //->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
    
    public function getStatisticsawax() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'AWAX')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'AWAX')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'AWAX')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '77')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'AWAX')
                 ->andwhere('a.wyslane IS NOT NULL')
                       // ->andwhere('a.zrealizowano IS NULL')
                ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'AWAX')
                      // ->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getZygmarBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'Zygmar')
              ->addOrderBy('s.id', 'DESC');

//        if(!empty($params['status'])){
//            if('nowe' == $params['status']){
//                $qb->andwhere('s.idposrednik IS NULL');
//            }else if('zrealizowane' == $params['status']){
//                $qb->andwhere('s.zaznaczono = :zaznaczono')
//                        ->setParameter('zaznaczono', '88');
//                //88 Zygmar
//            }
//        }
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '88')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '88')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '88')
                        ->andwhere('s.wyslane IS NOT NULL')
                       // ->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
    
    public function getStatisticszygmar() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
//        $all = $qb->andWhere('a.producent = :currDate')
//                        ->setParameter('currDate', 'Zygmar')
//                        ->getQuery()    
//                        ->getSingleScalarResult();
//        $nowe = $qb->andWhere('a.idposrednik IS NULL')
//                       // ->setParameter('currDate', NULL)
//                       //  ->andWhere('a.producent = :producent')
//                       // ->setParameter('producent', 'Klinar')
//                        ->getQuery()
//                        ->getSingleScalarResult();
////        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
////                        ->setParameter('currDate', '66')
////                        ->getQuery()
////                        ->getSingleScalarResult();
//        return array(
//            'all' => $all,
//            'nowe' => $nowe,
//            'zrealizowane' => ($all - $nowe)
//        );
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Zygmar')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Zygmar')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '88')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Zygmar')
                 ->andwhere('a.wyslane IS NOT NULL')
                       // ->andwhere('a.zrealizowano IS NULL')
                ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'Zygmar')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                    ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
    public function getVipBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.producent = :realizacja')
                ->setParameter('realizacja', 'VIP')
              ->addOrderBy('s.id', 'DESC');
                    if(!empty($params['status'])){
            if('nowe' == $params['status']){
                $qb->andwhere('s.idposrednik IS NULL');
            }else if('zrealizowane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '99')
                        //->andwhere('s.zrealizowano = :zrealizowano')
                        //->setParameter('zrealizowano', '1')
                        ->andwhere('s.zamok IS NOT NULL')
                ->andwhere('s.wyslane IS NOT NULL');
            }else if('dowyslania' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '99')
                        ->andwhere('s.wyslane IS NULL');
            }else if('wyslane' == $params['status']){
                $qb->andwhere('s.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '99')
                        ->andwhere('s.wyslane IS NOT NULL')
                       // ->andwhere('s.zrealizowano IS NULL')
                        ->andwhere('s.zamok IS NULL');
            }else if('all' == $params['status']){
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
    
    public function getStatisticsvip() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
                $qb_dowyslania = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyslane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrealizowane = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $nowe = $qb->andWhere('a.idposrednik IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'VIP')
                        ->getQuery()
                        ->getSingleScalarResult();
        $dowyslania = $qb_dowyslania->andwhere('a.wyslane IS NULL')
                ->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'VIP')
                ->andwhere('a.zaznaczono = :zaznaczono')
                        ->setParameter('zaznaczono', '99')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyslane = $qb_wyslane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'VIP')
                 ->andwhere('a.wyslane IS NOT NULL')
                       // ->andwhere('a.zrealizowano IS NULL')
                ->andwhere('a.zamok IS NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrealizowane->andWhere('a.producent = :currDate')
                        ->setParameter('currDate', 'VIP')
                       //->andwhere('a.zrealizowano = :zrealizowano')
                       // ->setParameter('zrealizowano', '1')
                    ->andwhere('a.zamok IS NOT NULL')
                        ->andwhere('a.wyslane IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
//        $zrealizowane = $qb->andWhere('a.zaznaczono = :currDate')
//                        ->setParameter('currDate', '66')
//                        ->getQuery()
//                        ->getSingleScalarResult();
        return array(
            //'all' => $all,
            'nowe' => $nowe,
            'dowyslania' => $dowyslania,
            'wyslane' => $wyslane,
            'zrealizowane' => $zrealizowane
        );
    }
    
}