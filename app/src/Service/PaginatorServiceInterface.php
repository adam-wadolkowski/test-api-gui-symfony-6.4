<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface PaginatorServiceInterface
{
    public const int FIRST_PAGE_NUMBER = 1;
    public const int ZERO_PAGE_NUMBER = 0;
    public const int DEFAULT_LIMIT_ITEMS_ON_PAGE = 5;

    public function paginate(QueryBuilder|Query $query, int $page, int $limit = self::DEFAULT_LIMIT_ITEMS_ON_PAGE): PaginatorServiceInterface;
}
