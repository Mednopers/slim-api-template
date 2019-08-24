<?php

declare(strict_types=1);

namespace Api\Model\User\UseCase\SignUp\Request;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Command
 *
 * @package Api\Model\User\UseCase\SignUp\Request
 *
 * @OA\Schema(
 *     schema="SignUp",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     example={
 *          "email":"signup@example.com",
 *          "password":"secret"
 *     }
 * )
 * @OA\Schema(
 *     schema="SignUpSuccess",
 *     @OA\Property(property="email", type="string"),
 *     example={
 *          "email":"signup@example.com"
 *     }
 * )
 */
class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6")
     */
    public $password;
}
