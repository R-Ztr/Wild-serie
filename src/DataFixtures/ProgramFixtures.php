<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM = [
        ['title'=>'Parker', 'synopsis'=>'Se faisant passer pour un riche Texan à la recherche d\'une luxueuse propriété, il rencontre la séduisante Leslie, un agent immobilier qui connaît les moindres ...', 'category'=>'category_Action'],
        ['title'=>'Les Trois Mousquetaires : D\'Artagnan', 'synopsis'=>'Les Trois Mousquetaires: D\'Artagnan est le premier volet du diptyque réalisé par Martin Bourboulon, à qui l\'on doit Papa ou maman et sa suite et Eiffel.', 'category'=>'category_Aventure'],
        ['title'=>'Leo', 'synopsis'=>'Leo, un lézard blasé de 74 ans, vit dans une salle de classe en Floride depuis des décennies, avec une tortue pour copain de terrarium.', 'category'=>'category_Animation'],
        ['title'=>'Donjons et Dragons : L\'Honneur des voleurs', 'synopsis'=>'Un voleur attachant et un groupe d\'aventuriers disparates entreprennent un raid risqué pour récupérer une relique perdue. ', 'category'=>'category_Fantastique'],
        ['title'=>'Nope', 'synopsis'=>'Les habitants d\'une vallée perdue du fin fond de la Californie sont témoins d\'une découverte terrifiante à caractère surnaturel qui affecte humains et animaux.', 'category'=>'category_Horreur'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $programList) {
        $program = new Program();
        $program->setTitle($programList['title']);
        $program->setSynopsis($programList['synopsis']);
        $program->setCategory($this->getReference($programList['category']));
        $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }

}
