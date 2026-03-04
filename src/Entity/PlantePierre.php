<?php
namespace App\Entity;

use App\Repository\PlantePierreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantePierreRepository::class)]
class PlantePierre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 10)]
    private ?string $categorie = null; // 'plante' ou 'pierre'

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origine = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $proprietesMagiques = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $proprietesMedicinales = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correspondances = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $danger = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $utilisationRituel = null;

    #[ORM\Column(length: 20)]
    private ?string $voie = null;

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

    public function getCategorie(): ?string { return $this->categorie; }
    public function setCategorie(string $categorie): static { $this->categorie = $categorie; return $this; }

    public function getOrigine(): ?string { return $this->origine; }
    public function setOrigine(?string $origine): static { $this->origine = $origine; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getProprietesMagiques(): ?string { return $this->proprietesMagiques; }
    public function setProprietesMagiques(?string $v): static { $this->proprietesMagiques = $v; return $this; }

    public function getProprietesMedicinales(): ?string { return $this->proprietesMedicinales; }
    public function setProprietesMedicinales(?string $v): static { $this->proprietesMedicinales = $v; return $this; }

    public function getCorrespondances(): ?string { return $this->correspondances; }
    public function setCorrespondances(?string $v): static { $this->correspondances = $v; return $this; }

    public function getDanger(): ?string { return $this->danger; }
    public function setDanger(?string $v): static { $this->danger = $v; return $this; }

    public function getUtilisationRituel(): ?string { return $this->utilisationRituel; }
    public function setUtilisationRituel(?string $v): static { $this->utilisationRituel = $v; return $this; }

    public function getVoie(): ?string { return $this->voie; }
    public function setVoie(string $voie): static { $this->voie = $voie; return $this; }

    public function getProprietaire(): ?User { return $this->proprietaire; }
    public function setProprietaire(?User $proprietaire): static { $this->proprietaire = $proprietaire; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
}
