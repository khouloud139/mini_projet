<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $discription = null;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'damande', targetEntity: Commentaire::class)]
    private Collection $commentaires;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription(string $discription): self
    {
        $this->discription = $discription;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setDemande($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getDemande() === $this) {
                $reservation->setDemande(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->id;
        
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setDamande($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getDamande() === $this) {
                $commentaire->setDamande(null);
            }
        }

        return $this;
    }
   
}
