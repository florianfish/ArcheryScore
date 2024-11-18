<?php

namespace App\Entity;

use App\Repository\VoleeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoleeRepository::class)]
class Volee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cible = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\ManyToOne(inversedBy: 'volees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Depart $depart = null;

    #[ORM\ManyToOne(inversedBy: 'volees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Archer $archer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCible(): ?string
    {
        return $this->cible;
    }

    public function setCible(string $cible): static
    {
        $this->cible = $cible;

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

    public function getDepart(): ?Depart
    {
        return $this->depart;
    }

    public function setDepart(?Depart $depart): static
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArcher(): ?Archer
    {
        return $this->archer;
    }

    public function setArcher(?Archer $archer): static
    {
        $this->archer = $archer;

        return $this;
    }
}
