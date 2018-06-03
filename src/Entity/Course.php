<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course", indexes={@ORM\Index(name="FK_Course_Competition", columns={"competition"})})
 * @ORM\Entity
 */
class Course
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
     * @var int|null
     *
     * @ORM\Column(name="courselength", type="integer", nullable=true)
     */
    private $courselength;

    /**
     * @var int|null
     *
     * @ORM\Column(name="climbing", type="integer", nullable=true)
     */
    private $climbing;

    /**
     * @var int|null
     *
     * @ORM\Column(name="estwintime", type="integer", nullable=true)
     */
    private $estwintime;

    /**
     * @var Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competition", referencedColumnName="id")
     * })
     */
    private $competition;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="course")
     * @ORM\JoinTable(name="course_category",
     *   joinColumns={
     *     @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getCourselength(): ?int
    {
        return $this->courselength;
    }

    public function setCourselength(?int $courselength): self
    {
        $this->courselength = $courselength;

        return $this;
    }

    public function getClimbing(): ?int
    {
        return $this->climbing;
    }

    public function setClimbing(?int $climbing): self
    {
        $this->climbing = $climbing;

        return $this;
    }

    public function getEstwintime(): ?int
    {
        return $this->estwintime;
    }

    public function setEstwintime(?int $estwintime): self
    {
        $this->estwintime = $estwintime;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }

}
