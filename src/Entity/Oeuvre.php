<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: false)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $date_sortie = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeOeuvre $typeOeuvre = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'oeuvres')]
    #[ORM\JoinTable(name:'oeuvre_categorie')]
    private Collection $categorie;

    /**
     * @var Collection<int, Auteur>
     */
    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'oeuvres')]
    #[ORM\JoinTable(name:'oeuvre_auteur')]
    private Collection $auteur;

    /**
     * @var Collection<int, Exemplaire>
     */
    #[ORM\OneToMany(targetEntity: Exemplaire::class, mappedBy: 'oeuvre')]
    private Collection $exemplaire;

    public function __construct()
    {
        $this->categorie = new ArrayCollection();
        $this->auteur = new ArrayCollection();
        $this->exemplaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeImmutable
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeImmutable $date_sortie): static
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getTypeOeuvre(): ?TypeOeuvre
    {
        return $this->typeOeuvre;
    }

    public function setTypeOeuvre(?TypeOeuvre $typeOeuvre): static
    {
        $this->typeOeuvre = $typeOeuvre;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): static
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): static
    {
        $this->categorie->removeElement($categorie);

        return $this;
    }

    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Auteur $auteur): static
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur->add($auteur);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): static
    {
        $this->auteur->removeElement($auteur);

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaire(): Collection
    {
        return $this->exemplaire;
    }

    public function addExemplaire(Exemplaire $exemplaire): static
    {
        if (!$this->exemplaire->contains($exemplaire)) {
            $this->exemplaire->add($exemplaire);
            $exemplaire->setOeuvre($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): static
    {
        if ($this->exemplaire->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getOeuvre() === $this) {
                $exemplaire->setOeuvre(null);
            }
        }

        return $this;
    }
}
