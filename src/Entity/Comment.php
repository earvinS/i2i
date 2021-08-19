<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource(
 * normalizationContext={
 *    "groups"={"comments_read"}
 *   },
 * collectionOperations={"GET", "POST"},
 * itemOperations={"GET", "PUT", "DELETE"},
 * attributes={
 *    "pagination_enabled"=true,
 *    "pagination_items_per_page"=15,
 *    "pagination_client_enabled"=true,
 *    "pagination_client_items_per_page"=true,
 *    "pagination_items_per_page_parameter_name"="count",
 *   }
 * )
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"comments_read"})
     */
    private $rating;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments_read"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Ad::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comments_read"})
     */
    private $ad;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comments_read"})
     */
    private $author;

    /**
     * Permet de mettre en place la date de création.
     *
     * @ORM\PrePersist()
     *
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
