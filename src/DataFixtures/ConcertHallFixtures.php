<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ConcertHall;
use App\Entity\Hall;

class ConcertHallFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $ch1 = new ConcertHall();
        $ch1->setName('PalomaStyle')
            ->setTotalCapacity(2000)
            ->setPresentation("Bonjour à tous et Bienvenue sur le site de la salle de PalomaStyle !")
            ->setCity('Nîmes')
            ->addHall($this->getReference(HallFixtures::ROOM_1))
            ->addHall($this->getReference(HallFixtures::ROOM_2))
            ->addHall($this->getReference(HallFixtures::ROOM_3));
        $manager->persist($ch1);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            HallFixtures::class,
        );
    }

}
