<?php
namespace App\Repository;

use App\Entity\Creature;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CreatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creature::class);
    }

    public function findByProprietaire(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.proprietaire = :user')
            ->setParameter('user', $user)
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByProprietaireAndNom(User $user, string $search): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.proprietaire = :user')
            ->andWhere('c.nom LIKE :search')
            ->setParameter('user', $user)
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
