<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
  /**
   * @Route("register", name="user_register")
   * @param Request $request
   * @param UserPasswordEncoderInterface $passwordEncoder
   * @return Response
   */
  public function register(
    Request $request,
    UserPasswordEncoderInterface $passwordEncoder)
  {
    $user = new User();
    $user->setRoles([User::ROLE_USER]);
    $form = $this->createForm(
      UserType::class,
      $user
    );
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
      $password = $passwordEncoder->encodePassword(
        $user,
        $user->getPlainPassword()
      );
      $user->setPassword($password);
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      $this->redirect('books');
    }
    return $this->render('register/register.html.twig', [
      'form' => $form->createView()
    ]);
  }
}
