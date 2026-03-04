<?php
namespace App\Entity;

use App\Repository\CreatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreatureRepository::class)]
class Creature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origine = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $pouvoirs = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $danger = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $affinites = null;

    #[ORM\Column(length: 20)]
    private ?string $voie = null; // 'solaire' ou 'lunaire'

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $proprietaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getType(): ?string { return $this->type; }
    public function setType(?string $type): static { $this->type = $type; return $this; }

    public function getOrigine(): ?string { return $this->origine; }
    public function setOrigine(?string $origine): static { $this->origine = $origine; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getPouvoirs(): ?string { return $this->pouvoirs; }
    public function setPouvoirs(?string $pouvoirs): static { $this->pouvoirs = $pouvoirs; return $this; }

    public function getDanger(): ?string { return $this->danger; }
    public function setDanger(?string $danger): static { $this->danger = $danger; return $this; }

    public function getAffinites(): ?string { return $this->affinites; }
    public function setAffinites(?string $affinites): static { $this->affinites = $affinites; return $this; }

    public function getVoie(): ?string { return $this->voie; }
    public function setVoie(string $voie): static { $this->voie = $voie; return $this; }

    public function getProprietaire(): ?User { return $this->proprietaire; }
    public function setProprietaire(?User $proprietaire): static { $this->proprietaire = $proprietaire; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
}
