<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
//    public function __construct(
//        private EntityManagerInterface $entityManager
//    )
//    {
//
//    }

    public function index(): Response
    {
//        $user = new User();
//        $user->setEmail('kuzmin1914@gmail.com')
//             ->setPassword('$2y$13$/9S0Ac8JK0SsVbKt/as/vuBa/.cDguSaZ6BY9LOmu5qWRGOrMdDim');
//        $this->entityManager->persist($user);
//        $this->entityManager->flush();
        return $this->render('blog.html.twig');
    }
}