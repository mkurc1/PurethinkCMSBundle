<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LanguageRepository extends EntityRepository
{
    public function getLastPosition()
    {
        return (int)$this->createQueryBuilder('a')
            ->select('MAX(a.position)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getPublicLanguages()
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('m')
            ->leftJoin('a.media', 'm')
            ->where('a.enabled = true')
            ->orderBy('a.position');

        return $qb->getQuery()->getResult();
    }
}
