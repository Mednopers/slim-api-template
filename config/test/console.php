<?php

declare(strict_types=1);

use Api\Console\Command;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    Command\FixtureCommand::class => function (ContainerInterface $container) {
        return new Command\FixtureCommand(
            $container->get(EntityManagerInterface::class),
            $container->get('config')['fixtures_dir']
        );
    },

    'config' => [
        'console' => [
            'commands' => [
                Command\FixtureCommand::class,
            ],
        ],
    ],
];
