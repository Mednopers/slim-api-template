<?php

declare(strict_types=1);

use \Api\Model\User as UserModel;
use Psr\Container\ContainerInterface;

return [
    \Api\Model\EventDispatcher::class => function (ContainerInterface $container) {
        return new \Api\Infrastructure\Model\EventDispatcher\SyncEventDispatcher(
            $container,
            [
                UserModel\Entity\User\Event\UserCreated::class => [

                ],
            ]
        );
    },
];
