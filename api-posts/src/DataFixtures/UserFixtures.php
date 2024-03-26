<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this -> hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        foreach (range(0, 10) as $_) {
            $user = new User();
            $user->setEmail($faker->email());
            $motDePasse = $this->hasher->hashPassword($user,"lecaca");
            $user->setPassword($motDePasse);
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}