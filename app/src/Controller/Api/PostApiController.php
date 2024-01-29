<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Post;
use App\ValueObject\PostVO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class PostApiController extends AbstractController
{
    #[Route('/post/{id<\d+>}', name: 'get_post_by_id', methods: ['GET'])]
    public function getPost(Post $post): JsonResponse
    {
        return $this->json((new PostVO($post))->toArray());
    }

    #[Route('/post', name: 'add_post_by_id', methods: ['POST'])]
    public function addPost(Request $request): JsonResponse
    {
        dd($request->getContent());
    }
}
