<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{id}/show", name="user_profile")
     */
    public function index(PostRepository $postRepository, UserRepository $userRepository, User $user)
    {
        return $this->render('profile/index.html.twig', [
            'userProfile' => $userRepository->find($user),
            'posts' => $postRepository->findBy(['User' => $user])
        ]);
    }
}
