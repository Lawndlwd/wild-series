<?php


namespace App\DataFixtures;

use App\Service\Slugify;
use Faker;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();


        for ($i=0;$i< 50;$i++) {
            $actor = new Actor();
            $faker  =  Faker\Factory::create('fr_FR');
            $actor->setName($faker->unique()->name);
            $actor->setSlug($slugify->generate($actor->getName()));

            $manager->persist($actor);
            $this->addReference('walking'.$i,$actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}