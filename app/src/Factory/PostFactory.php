<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\PostDto;
use App\Entity\Post;

class PostFactory
{
    public static function create(PostDto $postDto): Post
    {
        $post = new Post();
        $post->setTitle($postDto->title);
        $post->setContent($postDto->content);
        return $post;
    }
}