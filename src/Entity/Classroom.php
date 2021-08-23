<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 */
class Classroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ClassName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $NameTeacher;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\ManyToMany(targetEntity=Student::class, mappedBy="Classroom")
     */
    private $students;

    /**
     * @ORM\ManyToMany(targetEntity=Teacher::class, mappedBy="Classroom")
     */
    private $name_classroom;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->name_classroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?string
    {
        return $this->ClassName;
    }

    public function setClassName(string $ClassName): self
    {
        $this->ClassName = $ClassName;

        return $this;
    }

    public function getNameTeacher(): ?string
    {
        return $this->NameTeacher;
    }

    public function setNameTeacher(string $NameTeacher): self
    {
        $this->NameTeacher = $NameTeacher;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addClassroom($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            $student->removeClassroom($this);
        }

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getNameClassroom(): Collection
    {
        return $this->name_classroom;
    }

    public function addNameClassroom(Teacher $nameClassroom): self
    {
        if (!$this->name_classroom->contains($nameClassroom)) {
            $this->name_classroom[] = $nameClassroom;
            $nameClassroom->addClassroom($this);
        }

        return $this;
    }

    public function removeNameClassroom(Teacher $nameClassroom): self
    {
        if ($this->name_classroom->removeElement($nameClassroom)) {
            $nameClassroom->removeClassroom($this);
        }

        return $this;
    }
}
