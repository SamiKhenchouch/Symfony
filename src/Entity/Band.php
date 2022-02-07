<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandRepository::class)
 */
class Band
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creationYear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastAlbumName;

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="band", orphanRemoval=true)
     */
    private $members;

    /**
     * @ORM\ManyToMany(targetEntity=Concert::class, mappedBy="bands")
     */
    private $concerts;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->concerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreationYear(): ?\DateTimeInterface
    {
        return $this->creationYear;
    }

    public function setCreationYear(?\DateTimeInterface $creationYear): self
    {
        $this->creationYear = $creationYear;

        return $this;
    }

    public function getLastAlbumName(): ?string
    {
        return $this->lastAlbumName;
    }

    public function setLastAlbumName(?string $lastAlbumName): self
    {
        $this->lastAlbumName = $lastAlbumName;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setBand($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getBand() === $this) {
                $member->setBand(null);
            }
        }

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        // set the owning side of the relation if necessary
        if ($date->getBand() !== $this) {
            $date->setBand($this);
        }

        return $this;
    }

    /**
     * @return Collection|Concert[]
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts[] = $concert;
            $concert->addBand($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            $concert->removeBand($this);
        }

        return $this;
    }
}
