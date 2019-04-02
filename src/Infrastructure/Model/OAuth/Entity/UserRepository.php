<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

use Api\Model\OAuth\Entity\UserEntity;
use Api\Model\User\Entity\User\User;
use Api\Model\User\Service\PasswordHasher;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $repository;

    private $hasher;

    public function __construct(EntityManagerInterface $em, PasswordHasher $hasher)
    {
        $this->repository = $em->getRepository(User::class);
        $this->hasher = $hasher;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        if ($user = $this->repository->findOneBy(['email' => $username])) {
            if (!$this->hasher->validate($password, $user->getPasswordHash())) {
                return null;
            }

            return new UserEntity($user->getId()->getId());
        }

        return null;
    }
}
