<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

  /*  const SEASONS = [ 
        ['number' => 1, 'Year' => '2009', 'Description' => 'série avocat', 'Program' => 'program_Murder'],
        ['number' => 2, 'Year' => '2009', 'Description' => 'série sur les vikings', 'Program' => 'program_Vikings'],
        ['number' => 3, 'Year' => '2009', 'Description' => 'série drogue', 'Program' => 'program_BreakingBad'],
        ['number' => 4, 'Year' => '2009', 'Description' => 'série paranormal', 'Program' => 'program_StrangerThings'],
    ]; */

    public function load(ObjectManager $manager)
{

        $faker = Factory::create('Locale fr_FR'); 

        foreach (ProgramFixtures::PROGRAMS as $program)
        {
        for ($i = 1; $i < 5; $i++) {

        $season = new Season();
        $season->setNumber($i);
        $season->setYear($faker->year());
        $season->setDescription($faker->paragraph(3, true));
        $season->setProgramID($this->getReference('program_' . $program['title']));

        $manager->persist($season);

        $this->addReference('program_' . $program['title'] .'season_' . $i , $season);


    }
}
    $manager->flush();
}
    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }

}