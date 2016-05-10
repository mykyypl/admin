<?php

/* 
 * Marcin Kukliński
 */

namespace Common\UserBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    public function getQueryBuilder(array $params = array()) {
        $qb = $this->createQueryBuilder('u');
        
        if(!empty($params['usernameLike'])){
            $usernameLike = '%'.$params['usernameLike'].'%';
            $qb->andWhere('u.username LIKE :usernameLike')
                    ->setParameter('usernameLike', $usernameLike);
        }
        
        return $qb;
    }
}