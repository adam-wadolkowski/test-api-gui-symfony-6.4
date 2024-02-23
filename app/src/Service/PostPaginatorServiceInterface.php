<?php

declare(strict_types=1);

namespace App\Service;

interface PostPaginatorServiceInterface
{
    public function getPaginatePosts(int $pageNumber): PaginatorServiceInterface;
}
