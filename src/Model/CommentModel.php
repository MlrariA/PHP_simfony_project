<?php

namespace App\Model;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class CommentModel
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function approve(Comment $comment): void
    {
        $comment->setApproved(true);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    public function reject(Comment $comment): void
    {
        $comment->setDeletedAt(new \DateTimeImmutable());
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    public function delete(Comment $comment): void
    {
        $comment->setDeletedAt(new \DateTimeImmutable());
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}