<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, inversedBy="students")
     */
    private $Classroom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $NameStudent;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Email;

    /**
     * @ORM\Column(type="date")
     */
    private $Birthday;

    /**
     * @ORM\Column(type="float")
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    public function __construct()
    {
        $this->Classroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Classroom[]
     */
    public function getClassroom(): Collection
    {
        return $this->Classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->Classroom->contains($classroom)) {
            $this->Classroom[] = $classroom;
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        $this->Classroom->removeElement($classroom);

        return $this;
    }

    public function getNameStudent(): ?string
    {
        return $this->NameStudent;
    }

    public function setNameStudent(string $NameStudent): self
    {
        $this->NameStudent = $NameStudent;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->Birthday;
    }

    public function setBirthday(\DateTimeInterface $Birthday): self
    {
        $this->Birthday = $Birthday;

        return $this;
    }

    public function getPhoneNumber(): ?float
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(float $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo){
        $this->photo = $photo;

        return $this;
    }
}
