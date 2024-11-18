<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    /**
     * @var Collection<int, Depart>
     */
    #[ORM\OneToMany(targetEntity: Depart::class, mappedBy: 'competition', orphanRemoval: true)]
    private Collection $departs;

    public function __construct()
    {
        $this->departs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection<int, Depart>
     */
    public function getDeparts(): Collection
    {
        return $this->departs;
    }

    public function addDepart(Depart $depart): static
    {
        if (!$this->departs->contains($depart)) {
            $this->departs->add($depart);
            $depart->setCompetition($this);
        }

        return $this;
    }

    public function removeDepart(Depart $depart): static
    {
        if ($this->departs->removeElement($depart)) {
            // set the owning side to null (unless already changed)
            if ($depart->getCompetition() === $this) {
                $depart->setCompetition(null);
            }
        }

        return $this;
    }
}
