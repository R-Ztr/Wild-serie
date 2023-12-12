<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

   /* const EPISODES = [ 
        ['title' => 'murder', 'number' => 1, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_1'],
        ['title' => 'murder', 'number' => 2, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_2'],
        ['title' => 'murder', 'number' => 3, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_3'],
        ['title' => 'murder', 'number' => 4, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_3'],
    ]; */

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        foreach (ProgramFixtures::PROGRAMS as $program) {
            for ($j = 1; $j < 5; $j++) {
                for ($i = 1; $i < 5; $i++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->title());
                    $slug = $this->slugger->slug($episode->getTitle());
                    $episode->setSlug($slug);
                    $episode->setNumber($i);
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setDuration($faker->numberBetween(20, 160));
                    $episode->setSeasonId($this->getReference('program_' . $program['title'] . 'season_' . $j));

                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {

        return [
            SeasonFixtures::class,
        ];
    }
}
