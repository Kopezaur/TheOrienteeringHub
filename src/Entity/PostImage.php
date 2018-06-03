<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostImage
 *
 * @ORM\Table(name="post_image", indexes={@ORM\Index(name="FK_PostImage_Post", columns={"post"})})
 * @ORM\Entity
 */
class PostImage
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
     * @ORM\Column(name="imagename", type="string", length=255, nullable=false)
     */
    private $imagename;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post", referencedColumnName="id")
     * })
     */
    private $post;

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

    public function getImagename(): ?string
    {
        return $this->imagename;
    }

    public function setImagename(string $imagename): self
    {
        $this->imagename = $imagename;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }


}
