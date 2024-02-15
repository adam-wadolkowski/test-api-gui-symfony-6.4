<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
readonly class PostService
{
    public function __construct(
        private EntityManagerInterface $em,
        private PostRepository $post,
        private PaginatorService $paginator
    ) {
    }

    public function save(Post $post): void
    {
        $this->em->persist($post);
        $this->em->flush();
    }

    public function getPaginatePosts(int $pageNumber): PaginatorService
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}
