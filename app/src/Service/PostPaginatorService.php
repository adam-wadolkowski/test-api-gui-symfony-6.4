<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\PostRepository;

readonly class PostPaginatorService
{
    public function __construct(
        private PaginatorServiceInterface $paginator,
        private PostRepository $post
    ) {
    }
    public function getPaginatePosts(int $pageNumber): PaginatorServiceInterface
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}