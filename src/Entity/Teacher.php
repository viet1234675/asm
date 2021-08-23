<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, inversedBy="name_classroom")
     */
    private $Classroom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_teacher;

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

    public function getNameTeacher(): ?string
    {
        return $this->name_teacher;
    }

    public function setNameTeacher(string $name_teacher): self
    {
        $this->name_teacher = $name_teacher;

        return $this;
    }
}
