<?php

declare(strict_types=1);

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {
        $params = $container['config']['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $params['metadata_dirs'],
            $params['dev_mode'],
            $params['cache_dir'],
            new FilesystemCache(
                $params['cache_dir']
            ),
            false
        );

        foreach ($params['types'] as $type => $class) {
            if (!Type::hasType($type)) {
                Type::addType($type, $class);
            }
        }

        return EntityManager::create(
            $params['connection'],
            $config
        );
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => 'var/cache/doctrine',
            'metadata_dirs' => [
                // paths to entities
            ],
            'connection' => [
                'url' => getenv('API_DB_URL'),
            ],
            'types' => [

            ],
        ],
    ],
];
