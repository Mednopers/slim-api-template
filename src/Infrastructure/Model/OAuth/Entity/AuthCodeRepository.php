<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

use Api\Model\OAuth\Entity\AuthCodeEntity;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    use EntityRepositoryTrait;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(AuthCodeEntity::class);
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCodeEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        if ($this->exists($authCodeEntity->getIdentifier())) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->em->persist($authCodeEntity);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId): void
    {
        if ($code = $this->repository->find($codeId)) {
            $this->em->remove($code);
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId): bool
    {
        return !$this->exists($codeId);
    }
}
