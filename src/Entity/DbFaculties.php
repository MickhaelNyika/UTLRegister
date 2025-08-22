<?php

namespace App\Entity;

use App\Repository\DbFacultiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DbFacultiesRepository::class)]
class DbFaculties
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, DbSectors>
     */
    #[ORM\OneToMany(targetEntity: DbSectors::class, mappedBy: 'faculty')]
    private Collection $sectors;

    /**
     * @var Collection<int, DbCandidates>
     */
    #[ORM\OneToMany(targetEntity: DbCandidates::class, mappedBy: 'facOne')]
    private Collection $regOne;

    /**
     * @var Collection<int, DbCandidates>
     */
    #[ORM\OneToMany(targetEntity: DbCandidates::class, mappedBy: 'factTwo')]
    private Collection $regTwo;

    public function __construct()
    {
        $this->sectors = new ArrayCollection();
        $this->regOne = new ArrayCollection();
        $this->regTwo = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Facultés';
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

    /**
     * @return Collection<int, DbSectors>
     */
    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function addSector(DbSectors $sector): static
    {
        if (!$this->sectors->contains($sector)) {
            $this->sectors->add($sector);
            $sector->setFaculty($this);
        }

        return $this;
    }

    public function removeSector(DbSectors $sector): static
    {
        if ($this->sectors->removeElement($sector)) {
            // set the owning side to null (unless already changed)
            if ($sector->getFaculty() === $this) {
                $sector->setFaculty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DbCandidates>
     */
    public function getRegOne(): Collection
    {
        return $this->regOne;
    }

    public function addRegOne(DbCandidates $regOne): static
    {
        if (!$this->regOne->contains($regOne)) {
            $this->regOne->add($regOne);
            $regOne->setFacOne($this);
        }

        return $this;
    }

    public function removeRegOne(DbCandidates $regOne): static
    {
        if ($this->regOne->removeElement($regOne)) {
            // set the owning side to null (unless already changed)
            if ($regOne->getFacOne() === $this) {
                $regOne->setFacOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DbCandidates>
     */
    public function getRegTwo(): Collection
    {
        return $this->regTwo;
    }

    public function addRegTwo(DbCandidates $regTwo): static
    {
        if (!$this->regTwo->contains($regTwo)) {
            $this->regTwo->add($regTwo);
            $regTwo->setFactTwo($this);
        }

        return $this;
    }

    public function removeRegTwo(DbCandidates $regTwo): static
    {
        if ($this->regTwo->removeElement($regTwo)) {
            // set the owning side to null (unless already changed)
            if ($regTwo->getFactTwo() === $this) {
                $regTwo->setFactTwo(null);
            }
        }

        return $this;
    }
}
