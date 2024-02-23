<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\PostRepositoryInterface;

readonly class PostPaginatorService implements PostPaginatorServiceInterface
{
    public function __construct(
        private PaginatorServiceInterface $paginator,
        private PostRepositoryInterface $post
    ) {
    }
    public function getPaginatePosts(int $pageNumber): PaginatorServiceInterface
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}
