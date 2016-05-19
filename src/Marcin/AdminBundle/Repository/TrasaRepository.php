<?php

/* 
 * Marcin Kukliński
 */

namespace Marcin\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TrasaRepository extends EntityRepository
{
    public function getWarianty() {

                $trasa = $this->createQueryBuilder('s')
                ->select('s');
        
        
        return $trasa;
    }
}