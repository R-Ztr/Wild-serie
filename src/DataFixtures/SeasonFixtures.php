<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    const SEASONS = [ 
        ['number' => 1, 'Year' => '2009', 'Description' => 'série avocat', 'Program' => 'program_Murder'],
        ['number' => 2, 'Year' => '2009', 'Description' => 'série sur les vikings', 'Program' => 'program_Vikings'],
        ['number' => 3, 'Year' => '2009', 'Description' => 'série drogue', 'Program' => 'program_BreakingBad'],
        ['number' => 4, 'Year' => '2009', 'Description' => 'série paranormal', 'Program' => 'program_StrangerThings'],
    ];

    public function load(ObjectManager $manager)
{ 
    foreach (self::SEASONS as $seasonData) {
        $season = new Season();
        $season->setNumber($seasonData['number']);
        $season->setYear($seasonData['year']);
        $season->setDescription($seasonData['description']);
        $season->setProgramId($this->getReference($seasonData['program']));
        $manager->persist($season);

        $this->addReference('season_' . $seasonData['number'],  $season->getProgramId()->getTitle(), $season);

        $manager->flush();
        }
}

public function getDependencies()
{
    return [
        SeasonFixtures::class,
    ];
}

}