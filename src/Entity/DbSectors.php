<?php

namespace App\Entity;

use App\Repository\DbSectorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DbSectorsRepository::class)]
class DbSectors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sectors')]
    private ?DbFaculties $faculty = null;

    public function __toString()
    {
        return 'Filières';
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

    public function getFaculty(): ?DbFaculties
    {
        return $this->faculty;
    }

    public function setFaculty(?DbFaculties $faculty): static
    {
        $this->faculty = $faculty;

        return $this;
    }
}
