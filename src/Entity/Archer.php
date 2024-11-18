<?php

namespace App\Entity;

use App\Repository\ArcherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArcherRepository::class)]
class Archer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_licence = null;

    #[ORM\Column(length: 255)]
    private ?string $club = null;

    /**
     * @var Collection<int, Depart>
     */
    #[ORM\ManyToMany(targetEntity: Depart::class, mappedBy: 'archers')]
    private Collection $departs;

    /**
     * @var Collection<int, Volee>
     */
    #[ORM\OneToMany(targetEntity: Volee::class, mappedBy: 'archer')]
    private Collection $volees;

    public function __construct()
    {
        $this->departs = new ArrayCollection();
        $this->volees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumeroLicence(): ?string
    {
        return $this->numero_licence;
    }

    public function setNumeroLicence(string $numero_licence): static
    {
        $this->numero_licence = $numero_licence;

        return $this;
    }

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub(string $club): static
    {
        $this->club = $club;

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
            $depart->addArcher($this);
        }

        return $this;
    }

    public function removeDepart(Depart $depart): static
    {
        if ($this->departs->removeElement($depart)) {
            $depart->removeArcher($this);
        }

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
            $volee->setArcher($this);
        }

        return $this;
    }

    public function removeVolee(Volee $volee): static
    {
        if ($this->volees->removeElement($volee)) {
            // set the owning side to null (unless already changed)
            if ($volee->getArcher() === $this) {
                $volee->setArcher(null);
            }
        }

        return $this;
    }
}
