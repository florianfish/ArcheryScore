<?php

namespace App\Entity;

use App\Repository\DepartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartRepository::class)]
class Depart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_depart = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\ManyToOne(inversedBy: 'departs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competition $competition = null;

    /**
     * @var Collection<int, Volee>
     */
    #[ORM\OneToMany(targetEntity: Volee::class, mappedBy: 'depart', orphanRemoval: true)]
    private Collection $volees;

    /**
     * @var Collection<int, Archer>
     */
    #[ORM\ManyToMany(targetEntity: Archer::class, inversedBy: 'departs')]
    private Collection $archers;

    public function __construct()
    {
        $this->volees = new ArrayCollection();
        $this->archers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepart(): ?\DateTimeImmutable
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeImmutable $date_depart): static
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * @return Collection<int, Volee>
     */
    public function getVolees(): Collection
    {
        return $this->volees;
    }

    public function addVolee(Volee $volee): static
    {
        if (!$this->volees->contains($volee)) {
            $this->volees->add($volee);
            $volee->setDepart($this);
        }

        return $this;
    }

    public function removeVolee(Volee $volee): static
    {
        if ($this->volees->removeElement($volee)) {
            // set the owning side to null (unless already changed)
            if ($volee->getDepart() === $this) {
                $volee->setDepart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Archer>
     */
    public function getArchers(): Collection
    {
        return $this->archers;
    }

    public function addArcher(Archer $archer): static
    {
        if (!$this->archers->contains($archer)) {
            $this->archers->add($archer);
        }

        return $this;
    }

    public function removeArcher(Archer $archer): static
    {
        $this->archers->removeElement($archer);

        return $this;
    }
}
