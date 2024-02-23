<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;

interface PostServiceInterface
{
    public function save(Post $post): void;
}
