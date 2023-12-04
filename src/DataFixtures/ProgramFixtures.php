<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['title'=>'Murder', 'synopsis'=>'Annalise Keating, brillante avocate et professeur de droit, se retrouve impliquée dans une affaire de meurtre avec cinq de ses étudiants.', 'category'=>'category_Action', 'country' => 'France', 'year' => '2009'],
        ['title'=>'Vikings', 'synopsis'=>'Scandinavie, à la fin du 8ème siècle. Ragnar Lodbrok, un jeune guerrier viking, est avide d\'aventures et de nouvelles conquêtes. Lassé des pillages sur les terres de l\'Est, il se met en tête d\'explorer l\'Ouest par la mer.', 'category'=>'category_Action', 'country' => 'France', 'year' => '2009'],
        ['title'=>'Breaking Bad', 'synopsis'=>'Walter White, 50 ans, est professeur de chimie dans un lycée du Nouveau-Mexique. Pour réunir de l\'argent afin de subvenir aux besoins de sa famille, Walter met ses connaissances en chimie à profit pour fabriquer et vendre du crystal meth.', 'category'=>'category_Action', 'country' => 'France', 'year' => '2009'],
        ['title'=>'Stranger Things', 'synopsis'=>'En 1983, à Hawkins dans l\'Indiana, Will Byers disparaît de son domicile. Ses amis se lancent alors dans une recherche semée d\'embûches pour le retrouver. Pendant leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite.', 'category'=>'category_Aventure', 'country' => 'France', 'year' => '2009'],
        ['title'=>'The Witcher', 'synopsis'=>'Le sorceleur Geralt, un chasseur de monstres, se bat pour trouver sa place dans un monde où les humains se révèlent plus vicieux que les bêtes. Il est alors happé dans une mystérieuse toile tissée par les forces luttant pour contrôler le monde', 'category'=>'category_Aventure', 'country' => 'USA', 'year' => '2019'],
        ['title'=>'Kingdom', 'synopsis'=>'Lorsqu\'une mystérieuse peste commence à se propager dans un royaume, d\'étranges rumeurs sur la mort imminente du souverain commencent à prendre racine. Le prince héritier doit faire face à de nouveaux ennemis pour sauver son peuple.', 'category'=>'category_Aventure', 'country' => 'USA', 'year' => '2019'],
        ['title'=>'Family Guy', 'synopsis'=>'Les aventures d\'une famille excentrique de la Nouvelle-Angleterre..', 'category'=>'category_Animation', 'country' => 'USA', 'year' => '2019'],
        ['title'=>'South Park', 'synopsis'=>'Ce dessin animé pour adultes suit les aventures décalées de Cartman, Stan, Kyle et Kenny, quatre écoliers au langage fleuri, habitant la petite ville de South Park, dans le Colorado.', 'category'=>'category_Animation', 'country' => 'USA', 'year' => '2019'],
        ['title'=>'Simpson', 'synopsis'=>'Elle met en scène les Simpson, stéréotype d\'une famille de classe moyenne. Leurs aventures servent une satire du mode de vie américain.', 'category'=>'category_Animation', 'country' => 'Espagne', 'year' => '2022'],
        ['title'=>'Lucifer', 'synopsis'=>'Lassé et mécontent de sa position de Seigneur des Enfers, Lucifer Morningstar démissionne et abandonne son royaume pour la bouillonnante Los Angeles. Dans la Cité des Anges, l\'ex maître diabolique est le patron d\'un nightclub baptisé Lux.', 'category'=>'category_Fantastique', 'country' => 'Espagne', 'year' => '2022'],
        ['title'=>'Alice in Borderland', 'synopsis'=>'Arisu, un obsédé de jeux vidéos, se retrouve soudainement dans une étrange version, totalement déserte, de Tokyo, et dans laquelle lui et ses amis doivent participer à des jeux dangereux pour survivre.', 'category'=>'category_Fantastique', 'country' => 'Espagne', 'year' => '2022'],
        ['title'=>'Squid Game', 'synopsis'=>'Des personnes en difficultés financières sont invitées à une mystérieuse compétition de survie. Participant à une série de jeux traditionnels pour enfants, mais avec des rebondissements mortels, elles risquent leur vie pour une grosse somme d\'argent.', 'category'=>'category_Fantastique', 'country' => 'Espagne', 'year' => '2022'],
        ['title'=>'Mercredi', 'synopsis'=>'A présent étudiante à la singulière Nevermore Academy, un pensionnat prestigieux pour parias, Wednesday Addams tente de s\'adapter auprès des autres élèves tout en enquêtant sur une série de meurtres qui terrorise la ville.', 'category'=>'category_Horreur', 'country' => 'Danemark', 'year' => '2012'],
        ['title'=>'Vampire Diaries', 'synopsis'=>'Prisonniers de leurs corps d\'adolescents, Stefan et Damon, deux frères vampires, se livrent bataille pour conquérir le coeur de la belle Elena, 17 ans, lycéenne à Mystic Falls High.', 'category'=>'category_Horreur', 'country' => 'Danemark', 'year' => '2012'],
        ['title'=>'Paranormal', 'synopsis'=>'Dans les années 1960, un hématologue est impliqué dans plusieurs événements inexplicables. Bien que sceptique de nature, il devient malgré lui un expert en phénomènes surnaturels et doit résoudre une série de cas mystérieux.', 'category'=>'category_Horreur', 'country' => 'Danemark', 'year' => '2012'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programList) {
            $program = new Program();
            $program->setTitle($programList['title']);
            $program->setSynopsis($programList['synopsis']);
            $program->setCountry($programList['country']);
            $program->setYear($programList['year']);
            $program->setCategory($this->getReference($programList['category']));
            $manager->persist($program);
            $this->addReference('program_' . $programList['title'], $program);
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
