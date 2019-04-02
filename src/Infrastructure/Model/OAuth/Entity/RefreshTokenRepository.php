<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

use Api\Model\OAuth\Entity\RefreshTokenEntity;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    use EntityRepositoryTrait;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(RefreshTokenEntity::class);
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshTokenEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        if ($this->exists($refreshTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->em->persist($refreshTokenEntity);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId): void
    {
        if ($token = $this->repository->find($tokenId)) {
            $this->em->remove($token);
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        return !$this->exists($tokenId);
    }
}
