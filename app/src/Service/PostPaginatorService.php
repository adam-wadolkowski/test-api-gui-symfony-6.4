<?php

namespace App\Service;

class PostPaginatorService
{
    public function __construct(
        private PaginatorService $paginator
    ) {
    }
    public function getPaginatePosts(int $pageNumber): PaginatorService
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}