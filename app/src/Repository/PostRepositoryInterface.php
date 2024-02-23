<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\Query;

interface PostRepositoryInterface
{
    public function getPostsQuery(): Query;
}
