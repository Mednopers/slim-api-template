<?php

declare(strict_types=1);

namespace Api\Model\User\UseCase\SignUp\Request;

use Api\Model\Flusher;
use Api\Model\User\Entity\User\Email;
use Api\Model\User\Entity\User\User;
use Api\Model\User\Entity\User\UserId;
use Api\Model\User\Entity\User\UserRepository;
use Api\Model\User\Service\PasswordHasher;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var PasswordHasher
     */
    private $hasher;

    /**
     * @var Flusher
     */
    private $flusher;

    /**
     * Handler constructor.
     *
     * @param UserRepository $users
     * @param PasswordHasher $hasher
     * @param Flusher        $flusher
     */
    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     *
     * @throws \Exception
     */
    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('User with this email already exists.', 409);
        }

        $user = new User(
            UserId::next(),
            new \DateTimeImmutable(),
            $email,
            $this->hasher->hash($command->password)
        );

        $this->users->add($user);

        $this->flusher->flush($user);
    }
}
