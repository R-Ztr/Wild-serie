<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    const EPISODES = [ 
        ['title' => 'murder', 'number' => 1, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_1'],
        ['title' => 'murder', 'number' => 2, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_2'],
        ['title' => 'murder', 'number' => 3, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_3'],
        ['title' => 'murder', 'number' => 4, 'synopsis' => 'Diagnosed with terminal lung cancer, chemistry teacher Walter White teams up with former student Jesse Pinkman to cook and sell crystal meth.', 'season' => 'season_3'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $episodeData) {
            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setNumber($episodeData['number']);
            $episode->setSynopsis($episodeData['synopsis']);

            $manager->persist($episode);

            $this->addReference('episode_' . $episodeData, $episode);
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
