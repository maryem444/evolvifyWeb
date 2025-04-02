<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();  // Récupère tous les utilisateurs
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/new', name: 'user_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }
}
