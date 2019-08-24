<?php

declare(strict_types=1);

use Api\Infrastructure\Model\User\Service\BCryptPasswordHasher;
use Psr\Container\ContainerInterface;

return [
    \Api\Model\Flusher::class => function (ContainerInterface $container) {
        return new \Api\Infrastructure\Model\Service\DoctrineFlusher(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class),
            $container->get(\Api\Model\EventDispatcher::class)
        );
    },

    \Api\Model\User\Service\PasswordHasher::class =>function () {
        return new BCryptPasswordHasher();
    },

    \Api\Model\User\Entity\User\UserRepository::class => function (ContainerInterface $container) {
        return new \Api\Infrastructure\Model\User\Entity\DoctrineUserRepository(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    },

    \Api\Model\User\UseCase\SignUp\Request\Handler::class => function (ContainerInterface $container) {
        return new Api\Model\User\UseCase\SignUp\Request\Handler(
            $container->get(\Api\Model\User\Entity\User\UserRepository::class),
            $container->get(\Api\Model\User\Service\PasswordHasher::class),
            $container->get(\Api\Model\Flusher::class)
        );
    },
];
