<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\PostRepository;

class PostPaginatorService
{
    public function __construct(
        private readonly PaginatorService $paginator,
        private PostRepository $post
    ) {
    }
    public function getPaginatePosts(int $pageNumber): PaginatorService
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}