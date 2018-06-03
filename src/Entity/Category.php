<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdOn = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_on", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $modifiedOn = null;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="agegap", type="string", length=255, nullable=true)
     */
    private $agegap;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Competition", mappedBy="category")
     */
    private $competition;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="category")
     */
    private $course;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->competition = new \Doctrine\Common\Collections\ArrayCollection();
        $this->course = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getModifiedOn(): ?\DateTimeInterface
    {
        return $this->modifiedOn;
    }

    public function setModifiedOn(\DateTimeInterface $modifiedOn): self
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
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

    public function getAgegap(): ?string
    {
        return $this->agegap;
    }

    public function setAgegap(?string $agegap): self
    {
        $this->agegap = $agegap;

        return $this;
    }

    /**
     * @return Collection|Competition[]
     */
    public function getCompetition(): Collection
    {
        return $this->competition;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competition->contains($competition)) {
            $this->competition[] = $competition;
            $competition->addCategory($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competition->contains($competition)) {
            $this->competition->removeElement($competition);
            $competition->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
            $course->addCategory($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->course->contains($course)) {
            $this->course->removeElement($course);
            $course->removeCategory($this);
        }

        return $this;
    }

}
