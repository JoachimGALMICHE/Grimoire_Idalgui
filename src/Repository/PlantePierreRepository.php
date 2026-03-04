<?php
namespace App\Repository;

use App\Entity\PlantePierre;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlantePierreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlantePierre::class);
    }

    public function findByProprietaireAndCategorie(User $user, string $categorie): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.proprietaire = :user')
            ->andWhere('p.categorie = :categorie')
            ->setParameter('user', $user)
            ->setParameter('categorie', $categorie)
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByProprietaireCategorieAndSearch(User $user, string $categorie, string $search): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.proprietaire = :user')
            ->andWhere('p.categorie = :categorie')
            ->andWhere('p.nom LIKE :search')
            ->setParameter('user', $user)
            ->setParameter('categorie', $categorie)
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
