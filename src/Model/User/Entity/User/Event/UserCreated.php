<?php

declare(strict_types=1);

namespace Api\Model\User\Entity\User\Event;

use Api\Model\User\Entity\User\Email;
use Api\Model\User\Entity\User\UserId;

class UserCreated
{
    public $id;

    public $email;

    public function __construct(UserId $id, Email $email)
    {
        $this->id = $id;
        $this->email = $email;
    }
}
