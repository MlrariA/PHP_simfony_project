<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\PostType;
use App\Model\CommentModel;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CommentRepository $commentRepository,
        private readonly CommentModel $commentModel
    )
    {
    }

    public function createPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('blog/blogForm.html.twig', [
            'form' => $form,
        ]);
    }

    public function editPost(Post $post, Request $request): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($post);
            $this->entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('blog/blogForm.html.twig', [
            'form' => $form,
        ]);
    }

    public function commentsToApprove(): Response
    {
        return $this->render('blog/commentsToApprove.html.twig', [
            'comments' => $this->commentRepository->findBy(['approved'=> false, 'deletedAt' => null])
        ]);
    }

    public function commentApprove(Comment $comment): Response
    {
        $this->commentModel->approve($comment);
        $this->addFlash('success','коментарий принят');
        return $this->redirectToRoute('comment_to_approve_list');
    }

    public function commentReject(Comment $comment): Response
    {
        $this->commentModel->reject($comment);
        $this->addFlash('success','коментарий удален');
        return $this->redirectToRoute('comment_to_approve_list');
    }

    public function commentDelete(Comment $comment): Response
    {
        $this->commentModel->delete($comment);
        $this->addFlash('success','коментарий удален');
        return $this->redirectToRoute('homepage');
    }
}