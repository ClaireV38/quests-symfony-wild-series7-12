<?php


namespace App\DataFixtures;

use Faker;
use App\Entity\Season;
use Doctrine\Persistence\ObjectManager;
use \Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixture extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i=1; $i<50 ; $i++) {
            $season = new Season();
            $season->setnumber($i);
            $season->setYear($faker->year($max = 'now'));
            $season->setDescription($faker->text);
            $season->setProgram($this->getReference('program_'. ceil($i/10)));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $manager->flush();
    }
}