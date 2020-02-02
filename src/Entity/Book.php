<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $yearOfPublished;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
   * @ORM\JoinColumn(nullable=false)
   */
    private $user;

  public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getYearOfPublished(): ?int
    {
        return $this->yearOfPublished;
    }

    public function setYearOfPublished(int $yearOfPublished): self
    {
        $this->yearOfPublished = $yearOfPublished;

        return $this;
    }

  /**
   * @return mixed
   */
  public function getUser()
  {
    return $this->user;
  }

  /**
   * @param mixed $user
   */
  public function setUser($user): void
  {
    $this->user = $user;
  }


}
