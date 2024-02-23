<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
//use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
readonly class PostService implements PostServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function save(Post $post): void
    {
        $this->em->persist($post);
        $this->em->flush();
    }
}
