<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("user");
        $user->setPassword($this->hasher->hashPassword($user,"123"));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $manager->flush();


        $admin = new User();
        $admin->setUsername("admin");
        $admin->setPassword($this->hasher->hashPassword($admin,"123"));
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $manager->flush();
    }
}
