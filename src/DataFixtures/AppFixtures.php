<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder)
  {
    $this->passwordEncoder = $passwordEncoder;
  }

  public function load(ObjectManager $manager)
  {
    $this->loadUsers($manager);
    $this->loadBooks($manager);
  }

  public function loadBooks(ObjectManager $manager)
  {
    $book = new Book();
    $book->setTitle('The outgoing horizon');
    $book->setAuthor('Alex Voloshin');
    $book->setYearOfPublished(2017);
    $book->setUser($this->getReference('admin'));
    $manager->persist($book);

    $book = new Book();
    $book->setTitle('The child of sun');
    $book->setAuthor('Alex Voloshin');
    $book->setYearOfPublished(2019);
    $book->setUser($this->getReference('admin'));

    $manager->persist($book);

    $book = new Book();
    $book->setTitle('The Brothers Karamazov');
    $book->setAuthor('Fyodor Dostoyevsky');
    $book->setYearOfPublished(1880);
    $book->setUser($this->getReference('admin'));

    $manager->persist($book);

    $book = new Book();
    $book->setTitle('Ulysses');
    $book->setAuthor('James Joyce');
    $book->setYearOfPublished(1920);
    $book->setUser($this->getReference('admin'));

    $manager->persist($book);

    $manager->flush();
  }

  public function loadUsers(ObjectManager $manager)
  {
    $user = new User();
    $user->setUsername('admin');
    $user->setName('Ivan Ivanovich');
    $user->setEmail('dev.arven@gmail.com');
    $user->setPassword(
      $this->passwordEncoder->encodePassword($user, 'qwerty')
    );
    $user->setRoles([User::ROLE_ADMIN]);
    $this->addReference('admin', $user);
    $manager->persist($user);
    $manager->flush();
  }
}
