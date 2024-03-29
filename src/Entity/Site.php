<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[UniqueEntity(fields:['nom', 'nom'], message: 'Ce site existe déjà !', errorPath: 'number')]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message : 'Veuillez saisir un site')]
    #[Assert\Regex(
            pattern: "/^[A-ZÀ-ÖØ-öø-ÿ][a-zA-Z0-9À-ÖØ-öø-ÿ]*$/",
            message: "Le nom doit commencer par une majuscule et peut contenir des lettres, des chiffres et des accents par la suite."
    )]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: 'Site')]
    private Collection $participantsAffilies;

    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $sorties;

    public function __construct()
    {
        $this->participantsAffilies = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipantsAffilies(): Collection
    {
        return $this->participantsAffilies;
    }

    public function addParticipantsAffily(Participant $participantsAffily): static
    {
        if (!$this->participantsAffilies->contains($participantsAffily)) {
            $this->participantsAffilies->add($participantsAffily);
            $participantsAffily->setSite($this);
        }

        return $this;
    }

    public function removeParticipantsAffily(Participant $participantsAffily): static
    {
        if ($this->participantsAffilies->removeElement($participantsAffily)) {
            // set the owning side to null (unless already changed)
            if ($participantsAffily->getSite() === $this) {
                $participantsAffily->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): static
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setSite($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getSite() === $this) {
                $sorty->setSite(null);
            }
        }

        return $this;
    }
}
