<?php

namespace App\DataFixtures;

use App\Entity\Figures;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FiguresFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $figure = new Figures();

            $figure->setName($faker->words(4, true));
            $figure->setDescription($faker->sentences(3, true));
            $manager->persist($figure);
        }

        $manager->flush();
    }
}
