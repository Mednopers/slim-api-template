<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

use Api\Model\OAuth\Entity\AccessTokenEntity;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    use EntityRepositoryTrait;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(AccessTokenEntity::class);
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): AccessTokenEntityInterface
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        if ($this->exists($accessTokenEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->em->persist($accessTokenEntity);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId): void
    {
        if ($token = $this->repository->find($tokenId)) {
            $this->em->remove($token);
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId): bool
    {
        return !$this->exists($tokenId);
    }
}
