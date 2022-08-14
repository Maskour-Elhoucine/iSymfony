<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $person = new Person();
            $person->setName($faker->name);
            $person->setBirthday(new \DateTime($faker->dateTimeBetween('-30 years', '-20 years')->format('Y-m-d')));
            $person->setEmail($faker->email);
            $person->setPhone($faker->phoneNumber);

            $manager->persist($person);
        }

        $manager->flush();
    }
}
