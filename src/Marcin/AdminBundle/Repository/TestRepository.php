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
                $qb->where('s.status = :zrealizowane OR s.status = :anulowane OR s.status = :wyslane OR s.status = :wdostawie OR s.status = :gotowe')
                        ->setParameter('zrealizowane', 'zrealizowane/odebrane')
                        ->setParameter('anulowane', 'anulowane')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('wdostawie', 'w dostawie')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu');
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
        
        
        if (!empty($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }
                
        return $qb;
    }
    
        public function getStatistics() {
        $qb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_zrel = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_real = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wyp = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $all = (int) $qb->getQuery()->getSingleScalarResult();
        $przeslane = $qb->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'przesłane do realizacji')
                        ->getQuery()
                        ->getSingleScalarResult();
        $realizacja = $qb_real->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'w realizacji')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyprodukowane = $qb_wyp->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'wyprodukowane')
                        ->getQuery()
                        ->getSingleScalarResult();
        $zrealizowane = $qb_zrel->andWhere('a.status = :currDate OR a.status = :anulowane OR a.status = :wyslane OR a.status = :wdostawie OR a.status = :gotowe')
                        ->setParameter('currDate', 'zrealizowane/odebrane')
                        ->setParameter('anulowane', 'anulowane')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('wdostawie', 'w dostawie')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
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
                        ->where('u.do_zaplaty IS NOT NULL AND u.do_zaplaty != :dozaplaty')
                        ->setParameter('dozaplaty', '0')
                        ->andwhere('u.zaplacono = :zaplacono')
                        ->setParameter('zaplacono', '0')
                        ->andWhere('u.status = :status OR u.status = :wyslane OR u.status = :wdostawie OR u.status = :gotowe')
                        ->setParameter('status', 'zrealizowane/odebrane')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('wdostawie', 'w dostawie')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu');
//                        ->where('u.status = :identifier')
//                        ->setParameter('identifier', 'oczekiwanie na zapłatę');
        
        
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
    
    public function getTrasaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaPoniedzialekBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'poniedzialek')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaWtorekBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'wtorek')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaSrodaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'sroda')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaCzwartekBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'czwartek')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaPiatekBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'piatek')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaTarnowBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tarnow')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaTadeuszBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tadeusz')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaOdbiorBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'odbior')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaSalonBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'salon')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaTuchowskaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tuchowska')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaMontazBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'montaz')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getTrasaWysylkaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status')
                ->setParameter('status', 'wyprodukowane')
                ->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'wysylka')
              ->addOrderBy('s.sendDate', 'DESC');
        
          if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['idzamLike'])){
            $jakie_zamLike = '%'.$params['idzamLike'].'%';
            $qb->andWhere('s.id LIKE :idzamLike')
                    ->setParameter('idzamLike', $jakie_zamLike);
        }
        
        return $qb;
    }
    
    public function getPon() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'poniedzialek');
        
        
         $all_pon = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_pon' => $all_pon
        );
    }
    
    public function getWto() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'wtorek');
        
        
         $all_wto = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_wto' => $all_wto
        );
    }
    
    public function getSro() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'sroda');
        
        
         $all_sro = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_sro' => $all_sro
        );
    }
    
    public function getCzw() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'czwartek');
        
        
         $all_czw = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_czw' => $all_czw
        );
    }
    
    public function getPia() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'piatek');
        
        
         $all_pia = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_pia' => $all_pia
        );
    }
    
    public function getTar() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tarnow');
        
        
         $all_tar = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_tar' => $all_tar
        );
    }
    
    public function getTad() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tadeusz');
        
        
         $all_tad = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_tad' => $all_tad
        );
    }
    
    public function getOdb() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'odbior');
        
        
         $all_odb = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_odb' => $all_odb
        );
    }
    
    public function getSal() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'salon');
        
        
         $all_sal = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_sal' => $all_sal
        );
    }
    
    public function getTuch() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tuchowska');
        
        
         $all_tuch = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_tuch' => $all_tuch
        );
    }
    
    public function getMon() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'montaz');
        
        
         $all_mon = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_mon' => $all_mon
        );
    }
    
    public function getWys() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status')
                        ->setParameter('status', 'wyprodukowane')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'wysylka');
        
        
         $all_wys = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_wys' => $all_wys
        );
    }
}