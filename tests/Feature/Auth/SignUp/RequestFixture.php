<?php

declare(strict_types=1);

namespace Api\Test\Feature\Auth\SignUp;

use Api\Model\User\Entity\User\Email;
use Api\Test\Builder\User\UserBuilder;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class RequestFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $user = (new UserBuilder())
            ->withDate($now = new \DateTimeImmutable())
            ->withEmail(new Email('test@example.com'))
            ->build();

        $manager->persist($user);
        $manager->flush();
    }
}
