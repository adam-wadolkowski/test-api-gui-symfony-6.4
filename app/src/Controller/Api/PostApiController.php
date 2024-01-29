<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Post;
use App\ValueObject\PostVO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class PostApiController extends AbstractController
{
/*    #[Route('/post/{$id}', name: 'get_post_by_id', requirements: ['id' => '\d+'], methods: ['get'], condition: "params['id'] > 0")]
    #[Route('/post/{id<\d+>}', name: 'get_post_by_id', methods: ['get'], condition: "params['id'] > 0")]
    public function index(int $id): JsonResponse
    {
        return $this->json(['id' => $id]);
    }*/

    #[Route('/post/{id<\d+>}', name: 'get_post_by_id', methods: ['get'])]
    public function post(Post $post): JsonResponse
    {
        return $this->json((new PostVO($post))->toArray());
    }
}
