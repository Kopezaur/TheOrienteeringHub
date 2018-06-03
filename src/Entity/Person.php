<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="FK_Person_Country", columns={"country"}), @ORM\Index(name="FK_Person_Role", columns={"role"}), @ORM\Index(name="FK_Person_Category", columns={"category"}), @ORM\Index(name="FK_Person_Club", columns={"activeclub"})})
 * @ORM\Entity
 */
class Person implements UserInterface, \Serializable
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
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;
    
    /**
     * @var string
     *
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean", nullable=false)
     */
    private $validated;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Club
     *
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activeclub", referencedColumnName="id")
     * })
     */
    private $activeclub;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role", referencedColumnName="id")
     * })
     */
    private $role;
    
    /**
     * @var string
     *
     * @ORM\Column(name="profilephoto", type="string", length=255, nullable=false)
     */
    private $profilephoto;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Club", mappedBy="person")
     */
    private $club;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->club = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getActiveclub(): ?Club
    {
        return $this->activeclub;
    }

    public function setActiveclub(?Club $activeclub): self
    {
        $this->activeclub = $activeclub;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    public function getProfilephoto(): ?string
    {
        return $this->profilephoto;
    }
    
    public function setProfilephoto(string $profilephoto): self
    {
        $this->profilephoto = $profilephoto;
        
        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClub(): Collection
    {
        return $this->club;
    }

    public function addClub(Club $club): self
    {
        if (!$this->club->contains($club)) {
            $this->club[] = $club;
            $club->addPerson($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->club->contains($club)) {
            $this->club->removeElement($club);
            $club->removePerson($this);
        }

        return $this;
    }
    public function eraseCredentials()
    {}

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->role->getName());
    }
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->role,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->role,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }



}
