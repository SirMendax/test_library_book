<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class BookController extends AbstractController
{
  private $bookRepository;
  private $flashBag;

  private $authorizationChecker;

  public function __construct(
    BookRepository $bookRepository,
    FlashBagInterface $flashBag)
  {
    $this->bookRepository = $bookRepository;
    $this->flashBag = $flashBag;
  }

  /**
   * @Route("/books", name="books")
   */
  public function index()
  {
    $books = $this->bookRepository->findAll();
    return $this->render('book/index.html.twig', [
      'books' => $books,
    ]);
  }

  /**
   * @Route("/books/{id}", name="book_show")
   * @Security("is_granted('ROLE_USER')")
   * @param Book $book
   * @return Response
   */
  public function show(Book $book)
  {
    return $this->render('book/show.html.twig', [
      'book' => $book,
    ]);
  }

  /**
   * @Route("/book_store", name="book_store")
   * @Security("is_granted('ROLE_ADMIN')")
   * @param Request $request
   * @param TokenStorageInterface $tokenStorage
   * @return Response
   */
  public function store(Request $request, TokenStorageInterface $tokenStorage)
  {
    $user = $tokenStorage->getToken()->getUser();
    $book = new Book();
    $book->setUser($user);

    $form = $this->getForm($request, $book);

    if($this->pushedData($book, $form)){
      return $this->redirect('/books');
    };

    return $this->render('book/store.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("books/{id}/edit", name="book_edit")
   * @Security("is_granted('ROLE_ADMIN')")
   * @param Book $book
   * @param Request $request
   * @return Response
   */
  public function edit(Book $book, Request $request)
  {
    $form = $this->getForm($request, $book);
    if($this->pushedData($book, $form)){
      return $this->redirect('/books');
    };
    return $this->render('book/store.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("books/{id}/delete", name="book_delete")
   * @Security("is_granted('ROLE_ADMIN')")
   * @param Book $book
   * @return RedirectResponse
   */
  public function delete(Book $book)
  {
    $this->getDoctrine()->getManager()->remove($book);
    $this->getDoctrine()->getManager()->flush();
    $this->flashBag->add('notice', 'Book was deleted');
    return $this->redirect('/books');
  }

  private function getForm(Request $request, Book $book)
  {
    $form = $this->createForm(
      BookType::class,
      $book
    );
    $form->handleRequest($request);

    return $form;
  }

  private function pushedData(Book $book, FormInterface $form)
  {
    if($form->isSubmitted() && $form->isValid()){
      $em = $this->getDoctrine()->getManager();
      $em->persist($book);
      $em->flush();
      return true;
    }else{
      return false;
    }
  }
}
