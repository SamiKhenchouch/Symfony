<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Concert;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $c = new Concert();
        $c->setDate(\DateTime::createFromFormat("d/m/Y",'15/02/2022'))
          ->setTourName('The Grand Tour')
          ->setHall($this->getReference(HallFixtures::ROOM_2))
          ->addBand($this->getReference(BandFixtures::BAND_1));

        $manager->persist($c);

        $manager->flush();

    
    }

    public function getDependencies()
    {
        return array(
            HallFixtures::class,
        );
    }
}
