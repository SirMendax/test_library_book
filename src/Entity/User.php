<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Serializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This email is already exist in database")
 * @UniqueEntity(fields="username", message="This username is already exist in database")
 */
class User implements UserInterface, Serializable
{
  const ROLE_USER = 'ROLE_USER';
  const ROLE_ADMIN = 'ROLE_ADMIN';
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(min=5, max=120)
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $password;

  /**
   * @Assert\NotBlank()
   * @Assert\Length(min=8, max=120)
   */
  private $plainPassword;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(min=5, max=120)
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(min=5, max=120)
   */
  private $name;

  /**
   * @ORM\Column(type="simple_array")
   */
  private $roles;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="user")
   */
  private $books;

  public function __construct()
  {
    $this->books = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

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

  public function getBooks() :ArrayCollection
  {
    return $this->books;
  }

  /**
   * @return mixed
   */
  public function getPlainPassword()
  {
    return $this->plainPassword;
  }

  /**
   * @param mixed $plainPassword
   */
  public function setPlainPassword($plainPassword): void
  {
    $this->plainPassword = $plainPassword;
  }

  public function getRoles()
  {
    return $this->roles;
  }

  public function setRoles(array $roles): void
  {
    $this->roles = $roles;
  }

  public function getSalt()
  {
    // TODO: Implement getSalt() method.
  }

  public function eraseCredentials()
  {
    // TODO: Implement eraseCredentials() method.
  }

  /**
   * @inheritDoc
   */
  public function serialize()
  {
    return serialize([
      $this->id,
      $this->username,
      $this->password
    ]);
  }

  /**
   * @inheritDoc
   */
  public function unserialize($serialized)
  {
    list($this->id, $this->username, $this->password) = unserialize($serialized);
  }
}
