<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Entity\Post;

final readonly class PostVO
{
    public function __construct(
        public Post $post,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->post->getId(),
            'title' => $this->post->getTitle(),
            'content' => $this->post->getContent(),
            'image' => $this->post->getImage()
        ];
    }

    public function toArrayId(): array
    {
        return [
            'id' => $this->post->getId()
        ];
    }
}
