<?php

declare(strict_types=1);

namespace Api\Model\OAuth\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @ORM\Entity()
 * @ORM\Table(name="oauth_access_tokens")
 */
class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait, TokenEntityTrait, EntityTrait;

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
}

/**
 * @OA\Schema(
 *     schema="AccessTokenParameters",
 *     required={"grant_type", "username", "password", "client_id", "access_type"},
 *     @OA\Property(property="grant_type", type="string"),
 *     @OA\Property(property="username", type="string", description="The email for login"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="client_id", type="string"),
 *     @OA\Property(property="client_secret", type="string"),
 *     @OA\Property(property="access_type", type="string"),
 *     example={
 *          "grant_type":"password",
 *          "username":"oauth@example.com",
 *          "password":"password",
 *          "client_id":"app",
 *          "client_secret":"",
 *          "access_type":"offline"
 *     }
 * )
 * @OA\Schema(
 *     schema="RefreshTokenParameters",
 *     required={"grant_type", "refresh_token", "client_id"},
 *     @OA\Property(property="grant_type", type="string"),
 *     @OA\Property(property="refresh_token", type="string"),
 *     @OA\Property(property="client_id", type="string"),
 *     @OA\Property(property="client_secret", type="string"),
 *     example={
 *          "grant_type":"refresh_token",
 *          "refresh_token":"def502004916fa2700150c8f67c29a44477996a6afb70cc35c13c69e7d28eab642e4074fc0edc992e1d95e910b13c973cf04393fa66a53f6a951fe181273d4900ce94d5c7ff063756661c055a498f50e2879c8057b0e3e658631ca812a5c8828f09483a51ca47c5ad4bc8ccb86d948d6c2fbb0a48d2b7dceb1a26afca209a09286fb70a4ee6cccf6a460c0eeb02a885fd4ab983f7ef8a41228ebd18b5a46391f81d148d67160af4ff03aec20d6f529fb1bf6ceb14b2b54bdbd005b406d3863404604bc5db1906a74c220eae67e05ffbe10bc65e5e96045107dac63333402cd1c240d23ce9b0961a8240084572aeec298c6ade53e165ae146328c32ff57da80d0bfb3e8821bdf34d7d880412ae3684471a9428d35bab1f06c12af7a09e238e3dbb7993899edf5b08913933e321251a591b7099fa3d2086be1c5ed121b5a6d03a14da642604fe3fe748976a9d9b8be3cd392902899de6fdf9ea0990e36e0a50f67e00ed927c7dcd08187e798dd88682c7f235e4c81e9ad6861209cb6cf409feabde236a8f0cbdcc91a",
 *          "client_id":"app",
 *          "client_secret":""
 *     }
 * )
 * @OA\Schema(
 *     schema="AuthorizationSuccess",
 *     @OA\Property(property="token_type", type="string"),
 *     @OA\Property(property="expires_in", type="integer"),
 *     @OA\Property(property="access_token", type="string"),
 *     @OA\Property(property="refresh_token", type="string"),
 *     example={
 *          "token_type": "Bearer",
 *          "expires_in": 3600,
 *          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJiZTkzM2ViNWE4M2MzZTMwMDliZjRlZmNiY2E2MmEyOGQ5NTRlOTAwNWQ0ODE1ZWYyMWQ5MjNmYWIxMDQwOGZlODQ3Y2ZlYmI1YTU4MzJkIn0.eyJhdWQiOiJhcHAiLCJqdGkiOiIyYmU5MzNlYjVhODNjM2UzMDA5YmY0ZWZjYmNhNjJhMjhkOTU0ZTkwMDVkNDgxNWVmMjFkOTIzZmFiMTA0MDhmZTg0N2NmZWJiNWE1ODMyZCIsImlhdCI6MTU2NjQxMjg1OCwibmJmIjoxNTY2NDEyODU4LCJleHAiOjE1NjY0MTY0NTgsInN1YiI6IjExMWZlOThmLTU2NmEtNDI3MS1hMWQ5LTBlYzFjMmIyZDNkMCIsInNjb3BlcyI6W119.e6WGwkC4CRFb2sEl1IFWs_a4OkSol6h_5-p0hjFFJwZQq7X5JDn4oUCGLtAByC6CUglGquFZEqqWJeX0UElYWwK6eBF7XgN3VIh5OZGBi0ZFemXJ8XDvYs61sg8-AKlPYAtN97PprVC2hpq__yqFEfNBPErQElYuHH0U003AymcO_LhJSRZV6vYO4HuPXL--khGBGQ1czT9w866gSNJxc_f5gHCZntpQCAO8NpezIUcyiSFInLryjnsciLuj6cht-q95qvVVH8huu_qQjuK-U6q-oNGDS1mGPwVTZpnU68lcZD40pfYYC1KZmf43fCbwm2dH2PlsndSWhSqvhWUSZA",
 *          "refresh_token": "def502004916fa2700150c8f67c29a44477996a6afb70cc35c13c69e7d28eab642e4074fc0edc992e1d95e910b13c973cf04393fa66a53f6a951fe181273d4900ce94d5c7ff063756661c055a498f50e2879c8057b0e3e658631ca812a5c8828f09483a51ca47c5ad4bc8ccb86d948d6c2fbb0a48d2b7dceb1a26afca209a09286fb70a4ee6cccf6a460c0eeb02a885fd4ab983f7ef8a41228ebd18b5a46391f81d148d67160af4ff03aec20d6f529fb1bf6ceb14b2b54bdbd005b406d3863404604bc5db1906a74c220eae67e05ffbe10bc65e5e96045107dac63333402cd1c240d23ce9b0961a8240084572aeec298c6ade53e165ae146328c32ff57da80d0bfb3e8821bdf34d7d880412ae3684471a9428d35bab1f06c12af7a09e238e3dbb7993899edf5b08913933e321251a591b7099fa3d2086be1c5ed121b5a6d03a14da642604fe3fe748976a9d9b8be3cd392902899de6fdf9ea0990e36e0a50f67e00ed927c7dcd08187e798dd88682c7f235e4c81e9ad6861209cb6cf409feabde236a8f0cbdcc91a"
 *     }
 * )
 * @OA\Schema(
 *     schema="AuthorizationFailure",
 *     @OA\Property(property="error", type="string"),
 *     @OA\Property(property="message", type="string"),
 *     example={
 *          "error": "invalid_credentials",
 *          "message": "The user credentials were incorrect."
 *     }
 * )
 */
