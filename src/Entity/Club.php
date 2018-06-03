<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club", indexes={@ORM\Index(name="FK_Club_Person", columns={"president"})})
 * @ORM\Entity
 */
class Club
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="foundationdate", type="date", nullable=true)
     */
    private $foundationdate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logoname", type="string", length=255, nullable=true)
     */
    private $logoname;

    /**
     * @var Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="president", referencedColumnName="id")
     * })
     */
    private $president;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="club")
     * @ORM\JoinTable(name="club_person",
     *   joinColumns={
     *     @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     *   }
     * )
     */
    private $person;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->person = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getFoundationdate(): ?\DateTimeInterface
    {
        return $this->foundationdate;
    }

    public function setFoundationdate(?\DateTimeInterface $foundationdate): self
    {
        $this->foundationdate = $foundationdate;

        return $this;
    }

    public function getLogoname(): ?string
    {
        return $this->logoname;
    }

    public function setLogoname(?string $logoname): self
    {
        $this->logoname = $logoname;

        return $this;
    }

    public function getPresident(): ?Person
    {
        return $this->president;
    }

    public function setPresident(?Person $president): self
    {
        $this->president = $president;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->person->contains($person)) {
            $this->person[] = $person;
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->person->contains($person)) {
            $this->person->removeElement($person);
        }

        return $this;
    }

}
