<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class zPostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        foreach (range(0, 100) as $_) {
            $post = new Post();
            $post->setTitre($faker->sentence(10));
            $post->setContenu($faker->text(100));
            $post->setCreatedAt($faker->dateTimeBetween("-6 month"));
            $post
                ->setUser($manager->getRepository(User::class)
                    ->find($faker->numberBetween(1,10)));
            $post
                ->setCategorie($manager->getRepository(Categorie::class)
                    ->find($faker->numberBetween(1,10))
                );
            $manager->persist($post);
        }
        $manager->flush();
    }
}