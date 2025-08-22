<?php

namespace App\Entity;

use App\Repository\DbCandidatesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DbCandidatesRepository::class)]
class DbCandidates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'Veuillez saisir une adresse mail valide pas ça : {{ value }}',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 13,
    )]
    #[Assert\Regex(
        pattern: '/^(?:\+243|00243|0)[89][0-9]{8}$/',
        message: 'Le numéro doit être un numéro valide en RDC, ex: +243812345678, 00243812345678 ou 0812345678'
    )]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $placeBirth = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateBirth = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DbResidences $residence = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?DbMaritalStatus $maritalStatus = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?DbSectors $fistChoice = null;

    #[ORM\ManyToOne(inversedBy: 'studentsSecond')]
    private ?DbSectors $secondChoice = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $urgName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $urgRelation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(
        message: 'Veuillez saisir une adresse mail valide pas ça : {{ value }}',
    )]
    private ?string $urgMail = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 14,
    )]
    #[Assert\Regex(
        pattern: '/^(?:\+243|00243|0)[89][0-9]{8}$/',
        message: 'Le numéro doit être un numéro valide en RDC, ex: +243812345678, 00243812345678 ou 0812345678'
    )]
    private ?string $urgPhone = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $scName = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $scSection = null;

    #[ORM\Column(length: 255)]
    private ?string $scCountry = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 3,
    )]
    private ?string $scPercentage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $fatherName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $fatherMail = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 14,
    )]
    #[Assert\Regex(
        pattern: '/^(?:\+243|00243|0)[89][0-9]{8}$/',
        message: 'Le numéro doit être un numéro valide en RDC, ex: +243812345678, 00243812345678 ou 0812345678'
    )]
    private ?string $fatherPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $fatherOccupation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $motherName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $motherMail = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 14,
    )]
    #[Assert\Regex(
        pattern: '/^(?:\+243|00243|0)[89][0-9]{8}$/',
        message: 'Le numéro doit être un numéro valide en RDC, ex: +243812345678, 00243812345678 ou 0812345678'
    )]
    private ?string $motherPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 50,
    )]
    private ?string $motherOccupation = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?DbSexes $sexe = null;

    #[ORM\Column(type: Types::INTEGER, unique: true, nullable: true)]
    private ?int $code = null;

    #[ORM\Column]
    private ?bool $isVerified = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Assert\Length(
        min: 4,
        max: 4,
    )]
    private ?int $scYear = null;

    #[ORM\Column(length: 255)]
    private ?string $fistName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\Column (nullable: true)]
    private ?int $addNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addAvenue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addQuarter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addMunicipality = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addCity = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $slipAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slipRef = null;

    #[ORM\ManyToOne(inversedBy: 'regOne')]
    private ?DbFaculties $facOne = null;

    #[ORM\ManyToOne(inversedBy: 'regTwo')]
    #[Assert\NotIdenticalTo(
        propertyPath: "facOne",
        message: "Le deuxième choix doit être différent du premier..."
    )]
    private ?DbFaculties $factTwo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $provinceOrigin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $territoryOrigin = null;

    #[ORM\Column(length: 255)]
    private ?string $scDiplomaType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scDiplomaNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scOption = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scDiplomaPlace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?\DateTimeImmutable $scDiplomaDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scProvince = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instOrigin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facultyOrigin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $promRequest = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSpecial = null;

    public function __toString()
    {
        return 'Candidats';
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPlaceBirth(): ?string
    {
        return $this->placeBirth;
    }

    public function setPlaceBirth(string $placeBirth): static
    {
        $this->placeBirth = $placeBirth;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeImmutable
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeImmutable $dateBirth): static
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getResidence(): ?DbResidences
    {
        return $this->residence;
    }

    public function setResidence(?DbResidences $residence): static
    {
        $this->residence = $residence;

        return $this;
    }

    public function getMaritalStatus(): ?DbMaritalStatus
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(?DbMaritalStatus $maritalStatus): static
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getFistChoice(): ?DbSectors
    {
        return $this->fistChoice;
    }

    public function setFistChoice(?DbSectors $fistChoice): static
    {
        $this->fistChoice = $fistChoice;

        return $this;
    }

    public function getSecondChoice(): ?DbSectors
    {
        return $this->secondChoice;
    }

    public function setSecondChoice(?DbSectors $secondChoice): static
    {
        $this->secondChoice = $secondChoice;

        return $this;
    }

    public function getUrgName(): ?string
    {
        return $this->urgName;
    }

    public function setUrgName(string $urgName): static
    {
        $this->urgName = $urgName;

        return $this;
    }

    public function getUrgRelation(): ?string
    {
        return $this->urgRelation;
    }

    public function setUrgRelation(string $urgRelation): static
    {
        $this->urgRelation = $urgRelation;

        return $this;
    }

    public function getUrgMail(): ?string
    {
        return $this->urgMail;
    }

    public function setUrgMail(?string $urgMail): static
    {
        $this->urgMail = $urgMail;

        return $this;
    }

    public function getUrgPhone(): ?string
    {
        return $this->urgPhone;
    }

    public function setUrgPhone(string $urgPhone): static
    {
        $this->urgPhone = $urgPhone;

        return $this;
    }

    public function getScName(): ?string
    {
        return $this->scName;
    }

    public function setScName(string $scName): static
    {
        $this->scName = $scName;

        return $this;
    }

    public function getScSection(): ?string
    {
        return $this->scSection;
    }

    public function setScSection(string $scSection): static
    {
        $this->scSection = $scSection;

        return $this;
    }

    public function getScCountry(): ?string
    {
        return $this->scCountry;
    }

    public function setScCountry(string $scCountry): static
    {
        $this->scCountry = $scCountry;

        return $this;
    }

    public function getScPercentage(): ?string
    {
        return $this->scPercentage;
    }

    public function setScPercentage(string $scPercentage): static
    {
        $this->scPercentage = $scPercentage;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(string $fatherName): static
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getFatherMail(): ?string
    {
        return $this->fatherMail;
    }

    public function setFatherMail(?string $fatherMail): static
    {
        $this->fatherMail = $fatherMail;

        return $this;
    }

    public function getFatherPhone(): ?string
    {
        return $this->fatherPhone;
    }

    public function setFatherPhone(string $fatherPhone): static
    {
        $this->fatherPhone = $fatherPhone;

        return $this;
    }

    public function getFatherOccupation(): ?string
    {
        return $this->fatherOccupation;
    }

    public function setFatherOccupation(string $fatherOccupation): static
    {
        $this->fatherOccupation = $fatherOccupation;

        return $this;
    }

    public function getMotherName(): ?string
    {
        return $this->motherName;
    }

    public function setMotherName(string $motherName): static
    {
        $this->motherName = $motherName;

        return $this;
    }

    public function getMotherMail(): ?string
    {
        return $this->motherMail;
    }

    public function setMotherMail(string $motherMail): static
    {
        $this->motherMail = $motherMail;

        return $this;
    }

    public function getMotherPhone(): ?string
    {
        return $this->motherPhone;
    }

    public function setMotherPhone(string $motherPhone): static
    {
        $this->motherPhone = $motherPhone;

        return $this;
    }

    public function getMotherOccupation(): ?string
    {
        return $this->motherOccupation;
    }

    public function setMotherOccupation(string $motherOccupation): static
    {
        $this->motherOccupation = $motherOccupation;

        return $this;
    }

    public function getSexe(): ?DbSexes
    {
        return $this->sexe;
    }

    public function setSexe(?DbSexes $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getScYear(): ?int
    {
        return $this->scYear;
    }

    public function setScYear(int $scYear): static
    {
        $this->scYear = $scYear;

        return $this;
    }

    public function toArray(): array {
        return get_object_vars($this);
    }

    public function getFistName(): ?string
    {
        return $this->fistName;
    }

    public function setFistName(string $fistName): static
    {
        $this->fistName = $fistName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getAddNumber(): ?int
    {
        return $this->addNumber;
    }

    public function setAddNumber(int $addNumber): static
    {
        $this->addNumber = $addNumber;

        return $this;
    }

    public function getAddAvenue(): ?string
    {
        return $this->addAvenue;
    }

    public function setAddAvenue(?string $addAvenue): static
    {
        $this->addAvenue = $addAvenue;

        return $this;
    }

    public function getAddQuarter(): ?string
    {
        return $this->addQuarter;
    }

    public function setAddQuarter(?string $addQuarter): static
    {
        $this->addQuarter = $addQuarter;

        return $this;
    }

    public function getAddMunicipality(): ?string
    {
        return $this->addMunicipality;
    }

    public function setAddMunicipality(?string $addMunicipality): static
    {
        $this->addMunicipality = $addMunicipality;

        return $this;
    }

    public function getAddCity(): ?string
    {
        return $this->addCity;
    }

    public function setAddCity(?string $addCity): static
    {
        $this->addCity = $addCity;

        return $this;
    }
    public function getSlipAt(): ?\DateTimeImmutable
    {
        return $this->slipAt;
    }

    public function setSlipAt(?\DateTimeImmutable $slipAt): static
    {
        $this->slipAt = $slipAt;

        return $this;
    }

    public function getSlipRef(): ?string
    {
        return $this->slipRef;
    }

    public function setSlipRef(?string $slipRef): static
    {
        $this->slipRef = $slipRef;

        return $this;
    }

    public function getFacOne(): ?DbFaculties
    {
        return $this->facOne;
    }

    public function setFacOne(?DbFaculties $facOne): static
    {
        $this->facOne = $facOne;

        return $this;
    }

    public function getFactTwo(): ?DbFaculties
    {
        return $this->factTwo;
    }

    public function setFactTwo(?DbFaculties $factTwo): static
    {
        $this->factTwo = $factTwo;

        return $this;
    }

    public function getProvinceOrigin(): ?string
    {
        return $this->provinceOrigin;
    }

    public function setProvinceOrigin(?string $provinceOrigin): static
    {
        $this->provinceOrigin = $provinceOrigin;

        return $this;
    }

    public function getTerritoryOrigin(): ?string
    {
        return $this->territoryOrigin;
    }

    public function setTerritoryOrigin(?string $territoryOrigin): static
    {
        $this->territoryOrigin = $territoryOrigin;

        return $this;
    }

    public function getScDiplomaType(): ?string
    {
        return $this->scDiplomaType;
    }

    public function setScDiplomaType(string $scDiplomaType): static
    {
        $this->scDiplomaType = $scDiplomaType;

        return $this;
    }

    public function getScDiplomaNumber(): ?string
    {
        return $this->scDiplomaNumber;
    }

    public function setScDiplomaNumber(?string $scDiplomaNumber): static
    {
        $this->scDiplomaNumber = $scDiplomaNumber;

        return $this;
    }

    public function getScOption(): ?string
    {
        return $this->scOption;
    }

    public function setScOption(?string $scOption): static
    {
        $this->scOption = $scOption;

        return $this;
    }

    public function getScDiplomaPlace(): ?string
    {
        return $this->scDiplomaPlace;
    }

    public function setScDiplomaPlace(?string $scDiplomaPlace): static
    {
        $this->scDiplomaPlace = $scDiplomaPlace;

        return $this;
    }

    public function getScDiplomaDate(): ?\DateTimeImmutable
    {
        return $this->scDiplomaDate;
    }

    public function setScDiplomaDate(?\DateTimeImmutable $scDiplomaDate): static
    {
        $this->scDiplomaDate = $scDiplomaDate;

        return $this;
    }

    public function getScCode(): ?string
    {
        return $this->scCode;
    }

    public function setScCode(?string $scCode): static
    {
        $this->scCode = $scCode;

        return $this;
    }

    public function getScProvince(): ?string
    {
        return $this->scProvince;
    }

    public function setScProvince(?string $scProvince): static
    {
        $this->scProvince = $scProvince;

        return $this;
    }

    public function getInstOrigin(): ?string
    {
        return $this->instOrigin;
    }

    public function setInstOrigin(?string $instOrigin): static
    {
        $this->instOrigin = $instOrigin;

        return $this;
    }

    public function getFacultyOrigin(): ?string
    {
        return $this->facultyOrigin;
    }

    public function setFacultyOrigin(?string $facultyOrigin): static
    {
        $this->facultyOrigin = $facultyOrigin;

        return $this;
    }

    public function getPromRequest(): ?string
    {
        return $this->promRequest;
    }

    public function setPromRequest(?string $promRequest): static
    {
        $this->promRequest = $promRequest;

        return $this;
    }

    public function isSpecial(): ?bool
    {
        return $this->isSpecial;
    }

    public function setIsSpecial(?bool $isSpecial): static
    {
        $this->isSpecial = $isSpecial;

        return $this;
    }
}
