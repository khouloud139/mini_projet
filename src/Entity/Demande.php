<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Distination = null;

    #[ORM\Column(length: 255)]
    private ?string $lieudepart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datesortie = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heuredepart = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $nombreplaces = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\ManyToOne(inversedBy: 'demande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistination(): ?string
    {
        return $this->Distination;
    }

    public function setDistination(string $Distination): self
    {
        $this->Distination = $Distination;

        return $this;
    }

    public function getLieuDepart(): ?string
    {
        return $this->lieudepart;
    }

    public function setLieuDepart(string $lieudepart): self
    {
        $this->lieudepart = $lieudepart;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->datesortie;
    }

    public function setDateSortie(\DateTimeInterface $datesortie): self
    {
        $this->datesortie = $datesortie;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heuredepart;
    }

    public function setHeureDepart(\DateTimeInterface $heuredepart): self
    {
        $this->heuredepart = $heuredepart;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNombrePlaces(): ?int
    {
        return $this->nombreplaces;
    }

    public function setNombrePlaces(int $nombreplaces): self
    {
        $this->nombreplaces = $nombreplaces;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
