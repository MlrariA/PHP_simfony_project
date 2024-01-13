<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository
    )
    {

    }

    public function index(): Response
    {
        return $this->render('blog/blog.html.twig',[
            'posts'=> $this->postRepository->findAll()
        ]);
    }
}