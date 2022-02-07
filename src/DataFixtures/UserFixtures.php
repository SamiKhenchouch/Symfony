<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
  private UserPasswordHasherInterface $hasher;

  public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $u = new User();
        $password = $this->hasher->hashPassword($u, '123456');
        $u->setEmail('admin@admin.fr')
          ->setPassword($password)
          ->setRoles(['ROLE_ADMIN'])
          ->setFirstName('Jean')
          ->setLastName('Luc');
        $manager->persist($u);

        $u2 = new User();
        $password2 = $this->hasher->hashPassword($u2, '123456');
        $u2->setEmail('user@user.fr')
          ->setPassword($password2)
          ->setRoles(['ROLE_USER'])
          ->setFirstName('John')
          ->setLastName('Doe');
        $manager->persist($u2);

        $manager->flush();
    }
}
