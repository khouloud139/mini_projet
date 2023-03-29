<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Admin;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
         $useradmin = new Admin();
         $useradmin->setEmail('admin11@gmail.com');
         $useradmin-> setRoles(['ROLE_ADMIN']);
         $password = $this->hasher->hashPassword($useradmin, 'admin_123');
        
         $useradmin->setPassword($password);
        

         $manager->persist($useradmin);

        $manager->flush();
    }
}
