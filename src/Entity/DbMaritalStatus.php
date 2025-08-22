<?php

namespace App\Entity;

use App\Repository\DbMaritalStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DbMaritalStatusRepository::class)]
class DbMaritalStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, DbCandidates>
     */
    #[ORM\OneToMany(targetEntity: DbCandidates::class, mappedBy: 'maritalStatus')]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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
     * @return Collection<int, DbCandidates>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(DbCandidates $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setMaritalStatus($this);
        }

        return $this;
    }

    public function removeStudent(DbCandidates $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getMaritalStatus() === $this) {
                $student->setMaritalStatus(null);
            }
        }

        return $this;
    }
}
