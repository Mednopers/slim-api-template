<?php

declare(strict_types=1);

namespace Api\Model\User\Entity\User;

use Api\Model\AggregateRoot;
use Api\Model\EventTrait;
use Api\Model\User\Entity\User\Event\UserCreated;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User implements AggregateRoot
{
    use EventTrait;

    /**
     * @ORM\Id()
     * @ORM\Column(type="user_id")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @ORM\Column(type="user_email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="password_hash")
     */
    private $passwordHash;

    public function __construct(
        UserId $id,
        \DateTimeImmutable $date,
        Email $email,
        string $hash
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $hash;
        $this->recordEvent(new UserCreated($this->id, $this->email));
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
