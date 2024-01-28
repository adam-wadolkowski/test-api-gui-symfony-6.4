<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;

class Paginator
{
    private int $total;
    private int $currentPage;
    private int $lastPage;
    private OrmPaginator $items;

    private const FIRST_PAGE_NUMBER = 1;
    private const DEFAULT_LIMIT_ITEMS_ON_PAGE = 5;

    public function paginate(QueryBuilder|Query $query, int $page, int $limit = self::DEFAULT_LIMIT_ITEMS_ON_PAGE): Paginator
    {
        $paginator = new OrmPaginator($query);

        $page = $this->getPossibleNumberPage($page, $paginator->count(), $limit);

        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $this->currentPage = $page;
        $this->total = $paginator->count();
        $this->lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->items = $paginator;

        return $this;
    }

    public function getPossibleNumberPage(int $currentPage, int $maxItems, int $pageLimit): int
    {
        if ($pageLimit <= 0) {
            $pageLimit = self::DEFAULT_LIMIT_ITEMS_ON_PAGE;
        }

        if ($currentPage <= 0) {
            return self::FIRST_PAGE_NUMBER;
        }

        $maxPage = (int) ceil($maxItems / $pageLimit);
        if ($currentPage > $maxPage) {
            return $maxPage;
        }

        return $currentPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems(): OrmPaginator
    {
        return $this->items;
    }
}
