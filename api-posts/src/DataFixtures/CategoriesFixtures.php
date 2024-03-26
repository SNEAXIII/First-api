<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        foreach (range(0, 20) as $_) {
            $cate = new Categorie();
            $cate->setLibelle($faker->word());
            $manager->persist($cate);
        }
        $manager->flush();
    }
}
