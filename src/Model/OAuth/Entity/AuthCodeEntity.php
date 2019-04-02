<?php

declare(strict_types=1);

namespace Api\Model\OAuth\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @ORM\Entity()
 * @ORM\Table(name="oauth_auth_codes")
 */
class AuthCodeEntity implements AuthCodeEntityInterface
{
    use EntityTrait, TokenEntityTrait, AuthCodeTrait;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=80)
     */
    protected $identifier;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $expiryDateTime;

    /**
     * @ORM\Column(type="guid")
     */
    protected $userIdentifier;

    /**
     * @var ClientEntityInterface
     * @ORM\Column(type="oauth_client")
     */
    protected $client;

    /**
     * @var ScopeEntityInterface[]
     * @ORM\Column(type="oauth_scopes")
     */
    protected $scopes = [];

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", nullable=true)
     */
    protected $redirectUri;
}
