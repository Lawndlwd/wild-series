<?php


namespace App\DataFixtures;

use App\Entity\Season;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        for ($i=0;$i< 60;$i++) {
            $faker = Faker\Factory::create('fr_FR');
            $season = new Season();
            $season->setNumber($faker->numberBetween(0,10));
            $season->setDescription($faker->paragraph);
            $season->setYear($faker->date('y'));

            $manager->persist($season);
            $this->setReference('season_'. $i, $season);

            $season->setProgram($this->getReference('program_'.rand(0,7)));
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}