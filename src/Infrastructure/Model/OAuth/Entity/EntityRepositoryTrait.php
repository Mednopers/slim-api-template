<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

trait EntityRepositoryTrait
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    private function exists($id): bool
    {
        return $this->repository->createQueryBuilder('t')
                ->select('COUNT(t.identifier)')
                ->andWhere('t.identifier = :identifier')
                ->setParameter('identifier', $id)
                ->getQuery()->getSingleScalarResult() > 0;
    }
}
