<?php


namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    const PROGRAMS = [

        'Walking Dead' => [

            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',

            'category' => 'categorie_10',

        ],

        'The Haunting Of Hill House' => [

            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',

            'category' => 'categorie_10',

        ],

        'American Horror Story' => [

            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',

            'category' => 'categorie_10',

        ],

        'Love Death And Robots' => [

            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',

            'category' => 'categorie_10',

        ],

        'Penny Dreadful' => [

            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',

            'category' => 'categorie_10',

        ],

        'Fear The Walking Dead' => [

            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',

            'category' => 'categorie_10',

        ],

        'Rick et Morty' =>  [

            'summary' => 'Un brillant inventeur et son petit fils un peu à l\'Ouest partent à l\'aventure...',

            'category' => 'category_13',

        ],

        'Chernobyl' => [

            'summary' => 'Une série sur Chernobyl',

            'category' => 'category_15',

        ],

        'Un si grand soleil' => [

            'summary' => 'Claire revient à Montpellier après dix sept ans d’absence, afin de faire découvrir à Théo, son fils adolescent, sa ville natale. Quelques heures plus tard, elle est en garde à vue, accusée du meurtre d’un ami d’enfance. Pour se disculper, Claire n’aura d’autre choix que de percer tous les secrets du passé, notamment celui de la mort de sa sœur Angèle…\r\n\r\nTout en se confrontant à Manu, chargé d’enquêter sur le meurtre dont elle est accusée, elle retrouvera également Julien, sa passion de jeunesse, qui a entre-temps fondé une famille. Assumera-t-elle les sentiments qu’elle ressent tour à tour pour les deux hommes ?',

            'category' => 'category_15',

        ],

        'Vikings' => [

            'summary' => 'Scandinavie, à la fin du 8ème siècle. Ragnar Lodbrok, un jeune guerrier viking, est avide d\'aventures et de nouvelles conquêtes. Lassé des pillages sur les terres de l\'Est, il se met en tête d\'explorer l\'Ouest par la mer. Malgré la réprobation de son chef, Haraldson, il se fie aux signes et à la volonté des dieux, en construisant une nouvelle génération de vaisseaux, plus légers et plus rapides...',

            'category' => 'category_16',

        ],

    ];


    public function load(ObjectManager $manager)
    {
        $i=0;

        foreach (self::PROGRAMS as $title => $data) {
            $faker = Faker\Factory::create('fr_FR');
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($faker->imageUrl(300,250));

            $manager->persist($program);
            $this->addReference('program_'.$i, $program);
            $program->setCategory($this->getReference('categorie_' .rand(0,7)));
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}