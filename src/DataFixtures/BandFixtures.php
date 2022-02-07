<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Band;

class BandFixtures extends Fixture implements DependentFixtureInterface
{

    public const BAND_1= 'band';

    public function load(ObjectManager $manager)
    {
        $b1 = new Band();
        $b1->setName('Korn')
            ->setStyle('Metal')
            ->setPicture('Korn.jpg')
            ->setCreationYear(new \DateTime(1993))
            ->setLastAlbumName('The Nothing')
            ->addMember($this->getReference(MemberFixtures::KORN_1))
            ->addMember($this->getReference(MemberFixtures::KORN_2))
            ->addMember($this->getReference(MemberFixtures::KORN_3))
            ->addMember($this->getReference(MemberFixtures::KORN_4))
            ->addMember($this->getReference(MemberFixtures::KORN_5));

        $manager->persist($b1);
        $this->addReference(self::BAND_1, $b1);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MemberFixtures::class,
        );
    }
}
