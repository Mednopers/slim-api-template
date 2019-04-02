<?php

declare(strict_types=1);

namespace Api\Infrastructure\Model\OAuth\Entity;

use Api\Model\OAuth\Entity\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @var ScopeEntityInterface[]
     */
    private $scopes;

    public function __construct()
    {
        $this->scopes = [
            'common' => new ScopeEntity('common'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($scopeIdentifier): ScopeEntityInterface
    {
        return $this->scopes[$scopeIdentifier] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null): array
    {
        return array_filter($scopes, function (ScopeEntityInterface $scope) {
            foreach ($this->scopes as $item) {
                if ($scope->getIdentifier() === $item->getIdentifier()) {
                    return true;
                }
            }

            return false;
        });
    }
}
