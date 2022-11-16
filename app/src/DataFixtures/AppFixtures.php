<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\{ User, Role };

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $roles = [
        //     [ "name" => "admin" ],
        //     [ "name" => "moderator" ];

        $roleAdmin = new Role;
        $roleAdmin->setName("ROLE_ADMIN");
        $manager->persist($roleAdmin);
        $manager->flush();

        $user = new User();
        $user->setUsername('admin');
        $password = $this->hasher->hashPassword($user, 'root');
        $user->setPassword($password);
        $user->addRole($roleAdmin);
        $manager->persist($user);
        $manager->flush();

        $roleModerator = new Role;
        $roleModerator->setName("ROLE_MODERATOR");
        $manager->persist($roleModerator);
        $manager->flush();

        $user = new User();
        $user->setUsername('moderator');
        $password = $this->hasher->hashPassword($user, 'moderator');
        $user->setPassword($password);
        $user->addRole($roleModerator);
        $manager->persist($user);
        $manager->flush();
    }
}
