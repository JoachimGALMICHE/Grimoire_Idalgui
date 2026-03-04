<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Utilisateur Solaire ☀️
        $soleil = new User();
        $soleil->setUsername('soleil');
        $soleil->setRoles(['ROLE_SOLAIRE']);
        $soleil->setPassword($this->hasher->hashPassword($soleil, 'cerf'));
        $manager->persist($soleil);

        // Utilisateur Lunaire 🌙
        $lune = new User();
        $lune->setUsername('lune');
        $lune->setRoles(['ROLE_LUNAIRE']);
        $lune->setPassword($this->hasher->hashPassword($lune, 'loup'));
        $manager->persist($lune);

        $manager->flush();
    }
}