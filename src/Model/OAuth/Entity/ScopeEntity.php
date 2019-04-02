<?php

declare(strict_types=1);

namespace Api\Model\OAuth\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeEntity implements ScopeEntityInterface
{
    use ScopeTrait, EntityTrait;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }
}
