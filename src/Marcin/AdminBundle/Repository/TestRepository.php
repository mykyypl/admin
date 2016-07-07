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
                $qb->where('s.status = :przeslane OR s.status = :oczekiwanie')
                        ->setParameter('przeslane', 'przesłane do realizacji')
                        ->setParameter('oczekiwanie', 'oczekiwanie na zapłatę');
            }else if('realizacja' == $params['status']){
                $qb->where('s.status = :realizacja')
                        ->setParameter('realizacja', 'w realizacji');
            }else if('wyprodukowane' == $params['status']){
                $qb->where('s.status = :wyprodukowane OR s.status = :przyjete')
                        ->setParameter('wyprodukowane', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte');
            }else if('zrealizowane' == $params['status']){
                $qb->where('s.status = :zrealizowane OR s.status = :anulowane OR s.status = :wyslane OR s.status = :wdostawie OR s.status = :gotowe')
                        ->setParameter('zrealizowane', 'zrealizowane/odebrane')
                        ->setParameter('anulowane', 'anulowane')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('wdostawie', 'w dostawie')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu');
            }else if('dozaplaty' == $params['status']){
                $qb->where('s.do_zaplaty IS NOT NULL AND s.do_zaplaty != :dozaplaty')
                        ->setParameter('dozaplaty', '0')
                        ->andwhere('s.zaplacono = :zaplacono')
                        ->setParameter('zaplacono', '0')
                        ->andWhere('s.status = :status OR s.status = :wyslane OR s.status = :wdostawie OR s.status = :gotowe')
                        ->setParameter('status', 'zrealizowane/odebrane')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('wdostawie', 'w dostawie')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu');
            }
        }
        
        if(!empty($params['trasy'])){
            if('czwartek' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'czwartek');
            }else if('poniedzialek' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'poniedzialek');
            }else if('wtorek' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'wtorek');
            }else if('sroda' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'sroda');
            }else if('piatek' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'piatek');
            }else if('tarnow' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tarnow');
            }else if('tadeusz' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tadeusz');
            }else if('odbior' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'odbior');
            }else if('salon' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'salon');
            }else if('tuchowska' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'tuchowska');
            }else if('montaz' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'montaz');
            }else if('wysylka' == $params['trasy']){
                 $qb->andwhere('s.trasa = :trasa')
                ->setParameter('trasa', 'wysylka');
            }
        }
        
        
     if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'], $orderDir);
        }

        if(!empty($params['userLike'])){
            $jakie_zamLike = '%'.$params['userLike'].'%';
            $qb->andWhere('s.nr_user_zam LIKE :jakie_zamLike')
                    ->setParameter('jakie_zamLike', $jakie_zamLike)
                    ->orWhere('s.nrprodukcji LIKE :nr')
                    ->setParameter('nr', $jakie_zamLike)
                    ->orWhere('s.nr_fakt LIKE :fakt')
                    ->setParameter('fakt', $jakie_zamLike);
        }
        
        
        if (!empty($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }
                
        return $qb;
    }
    
    public function getQueryPaneltrasaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->andwhere('s.status = :wdostawie OR s.status = :montaz OR s.status = :wyslane')
                ->setParameter('wdostawie', 'w dostawie')
                ->setParameter('montaz', 'gotowe do odbioru/montażu')
                ->setParameter('wyslane', 'wysłane')
                ->addOrderBy('s.nr_user_zam', 'DESC');

        if(!empty($params['status'])){
            if('poniedzialek' == $params['status']){
                $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'poniedzialek');
            }else if('wtorek' == $params['status']){
                $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'wtorek');
            }else if('sroda' == $params['status']){
                $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'sroda');
            }else if('czwartek' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'czwartek');
            }else if('piatek' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'piatek');
            }else if('tarnow' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tarnow');
            }else if('tadeusz' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tadeusz');
            }else if('odbior' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'odbior');
            }else if('salon' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'salon');
            }else if('tuchowska' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'tuchowska');
            }else if('montaz' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'montaz');
            }else if('wysylka' == $params['status']){
              $qb->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'wysylka');
            }else if('all' == $params['status']){
              $qb->andwhere('s.trasa IS NOT NULL');
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
        $przeslane = $qb->andWhere('a.status = :currDate OR a.status = :oczekiwanie')
                        ->setParameter('currDate', 'przesłane do realizacji')
                        ->setParameter('oczekiwanie', 'oczekiwanie na zapłatę')
                        ->getQuery()
                        ->getSingleScalarResult();
        $realizacja = $qb_real->andWhere('a.status = :currDate')
                        ->setParameter('currDate', 'w realizacji')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wyprodukowane = $qb_wyp->andWhere('a.status = :currDate OR a.status = :przyjete')
                        ->setParameter('currDate', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
    
    public function getStatisticsPaneltrasa() {
        $qb_pon = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wto = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_sro = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_czw = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_pia = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_tar = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_tad = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_odb = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_sal = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_tuch = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_mon = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_wys = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        $qb_all = $this->createQueryBuilder('a')
                ->select('COUNT(a)');
        
        $all = (int) $qb_all->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa IS NOT NULL')
                        ->getQuery()
                        ->getSingleScalarResult();
        $poniedzialek = $qb_pon->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'poniedzialek')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wtorek = $qb_wto->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'wtorek')
                        ->getQuery()
                        ->getSingleScalarResult();
        $sroda = $qb_sro->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'sroda')
                        ->getQuery()
                        ->getSingleScalarResult();
        $czwartek = $qb_czw->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'czwartek')
                        ->getQuery()
                        ->getSingleScalarResult();
        $piatek = $qb_pia->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'piatek')
                        ->getQuery()
                        ->getSingleScalarResult();
        $tarnow = $qb_tar->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'tarnow')
                        ->getQuery()
                        ->getSingleScalarResult();
        $tadeusz = $qb_tad->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'tadeusz')
                        ->getQuery()
                        ->getSingleScalarResult();
        $odbior = $qb_odb->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'odbior')
                        ->getQuery()
                        ->getSingleScalarResult();
        $salon = $qb_sal->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'salon')
                        ->getQuery()
                        ->getSingleScalarResult();
        $tuchowska = $qb_tuch->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'tuchowska')
                        ->getQuery()
                        ->getSingleScalarResult();
        $montaz = $qb_mon->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'montaz')
                        ->getQuery()
                        ->getSingleScalarResult();
        $wysylka = $qb_wys->andWhere('a.status = :currDate OR a.status = :wyslane OR a.status = :gotowe')
                        ->setParameter('currDate', 'w dostawie')
                        ->setParameter('wyslane', 'wysłane')
                        ->setParameter('gotowe', 'gotowe do odbioru/montażu')
                        ->andWhere('a.trasa = :trasa')
                        ->setParameter('trasa', 'wysylka')
                        ->getQuery()
                        ->getSingleScalarResult();
        return array(
            'all' => $all,
            'poniedzialek' => $poniedzialek,
            'wtorek' => $wtorek,
            'sroda' => $sroda,
            'czwartek' => $czwartek,
            'piatek' => $piatek,
            'tarnow' => $tarnow,
            'tadeusz' => $tadeusz,
            'odbior' => $odbior,
            'salon' => $salon,
            'tuchowska' => $tuchowska,
            'montaz' => $montaz,
            'wysylka' => $wysylka
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
    
        public function getZrelmany() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.do_zaplaty IS NOT NULL AND u.do_zaplaty != :dozaplaty')
                        ->setParameter('dozaplaty', '0')
                        ->andwhere('u.zaplacono = :zaplacono')
                        ->setParameter('zaplacono', '0')
                        ->andWhere('u.status = :status')
                        ->setParameter('status', 'zrealizowane/odebrane');
//                        ->where('u.status = :identifier')
//                        ->setParameter('identifier', 'oczekiwanie na zapłatę');
        
        
        $all_zrelmany = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_zrelmany' => $all_zrelmany
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
    
    public function getZrelsuma() {

                $qb = $this->createQueryBuilder('u')
                        ->select('SUM(u.do_zaplaty) AS do_zaplaty')
                        ->where('u.zaplacono = :status_zaplaty')
                        ->setParameter('status_zaplaty', '0')
                        ->andWhere('u.status = :status')
                        ->setParameter('status', 'zrealizowane/odebrane');
        
        
        $all_zrelsuma = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_zrelsuma' => $all_zrelsuma
        );
    }
    
     public function getWyprodukowane() {

                $qb = $this->createQueryBuilder('u')
                        ->select('COUNT(u)')
                        ->where('u.status = :identifier OR u.status = :przyjete')
                        ->setParameter('identifier', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte');
        
        
        $all_wyprodukowane = (int)$qb->getQuery()->getSingleScalarResult();
 return array(
            'all_wyprodukowane' => $all_wyprodukowane
        );
    }
    
    public function getTrasaBuilder(array $params = array()){
        
        $qb = $this->createQueryBuilder('s')
                ->select('s')
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                ->where('s.status = :status OR s.status = :przyjete')
                ->setParameter('status', 'wyprodukowane')
                ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
                        ->andwhere('s.trasa = :trasa OR s.trasa = :inne')
                        ->setParameter('trasa', 'Oczekiwanie na wybór trasy')
                        ->setParameter('inne', NULL);
        
        
         $all_tuch = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_tuch' => $all_tuch
        );
    }
    
    public function getMon() {

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
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
                        ->where('s.status = :status OR s.status = :przyjete')
                        ->setParameter('status', 'wyprodukowane')
                        ->setParameter('przyjete', 'przyjęte')
                        ->andwhere('s.trasa = :trasa')
                        ->setParameter('trasa', 'wysylka');
        
        
         $all_wys = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'all_wys' => $all_wys
        );
    }
    
    public function getDzien1() {
        
        //$data1 = new \DateTime('- 30 days');
        $data1 = new \DateTime();
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data1->format('Y-m-d').'%');
        
        
         $czas1 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas1' => $czas1
        );
    }
    
    public function getDzien2() {
        
        //$data1 = new \DateTime('- 30 days');
        $data2 = new \DateTime('- 1 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data2->format('Y-m-d').'%');
        
        
         $czas2 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas2' => $czas2
        );
    }
    
    public function getDzien3() {
        
        //$data1 = new \DateTime('- 30 days');
        $data3 = new \DateTime('- 2 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data3->format('Y-m-d').'%');
        
        
         $czas3 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas3' => $czas3
        );
    }
    
    public function getDzien4() {
        
        //$data1 = new \DateTime('- 30 days');
        $data4 = new \DateTime('- 3 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data4->format('Y-m-d').'%');
        
        
         $czas4 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas4' => $czas4
        );
    }
    
    public function getDzien5() {
        
        //$data1 = new \DateTime('- 30 days');
        $data5 = new \DateTime('- 4 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data5->format('Y-m-d').'%');
        
        
         $czas5 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas5' => $czas5
        );
    }
    
    public function getDzien6() {
        
        //$data1 = new \DateTime('- 30 days');
        $data6 = new \DateTime('- 5 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data6->format('Y-m-d').'%');
        
        
         $czas6 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas6' => $czas6
        );
    }
    
    public function getDzien7() {
        
        //$data1 = new \DateTime('- 30 days');
        $data7 = new \DateTime('- 6 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data7->format('Y-m-d').'%');
        
        
         $czas7 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas7' => $czas7
        );
    }
    
    public function getDzien8() {
        
        //$data1 = new \DateTime('- 30 days');
        $data8 = new \DateTime('- 7 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data8->format('Y-m-d').'%');
        
        
         $czas8 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas8' => $czas8
        );
    }
    
    public function getDzien9() {
        
        //$data1 = new \DateTime('- 30 days');
        $data9 = new \DateTime('- 8 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data9->format('Y-m-d').'%');
        
        
         $czas9 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas9' => $czas9
        );
    }
    
    public function getDzien10() {
        
        //$data1 = new \DateTime('- 30 days');
        $data10 = new \DateTime('- 9 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data10->format('Y-m-d').'%');
        
        
         $czas10 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas10' => $czas10
        );
    }
    
    public function getDzien11() {
        
        //$data1 = new \DateTime('- 30 days');
        $data11 = new \DateTime('- 10 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data11->format('Y-m-d').'%');
        
        
         $czas11 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas11' => $czas11
        );
    }
    
    public function getDzien12() {
        
        //$data1 = new \DateTime('- 30 days');
        $data12 = new \DateTime('- 11 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data12->format('Y-m-d').'%');
        
        
         $czas12 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas12' => $czas12
        );
    }
    
    public function getDzien13() {
        
        //$data1 = new \DateTime('- 30 days');
        $data13 = new \DateTime('- 12 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data13->format('Y-m-d').'%');
        
        
         $czas13 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas13' => $czas13
        );
    }
    
    public function getDzien14() {
        
        //$data1 = new \DateTime('- 30 days');
        $data14 = new \DateTime('- 13 days');
        

                $qb = $this->createQueryBuilder('s')
                        ->select('COUNT(s)')
                        ->where('s.sendDate LIKE :status')
                        ->setParameter('status', '%'.$data14->format('Y-m-d').'%');
        
        
         $czas14 = (int)$qb->getQuery()->getSingleScalarResult();
     return array(
            'czas14' => $czas14
        );
    }
}