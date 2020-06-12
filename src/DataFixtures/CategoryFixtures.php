<?php


namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Horreur',
        'Dramatic',
        'Comique',
        'Action/Aventure',
        'SF',
        'Fantastique',
        'Animation',
        'Soap',
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $faker =Faker\Factory::create('fr_FR');
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('categorie_'. $key, $category);
        }
        $manager->flush();
    }
}