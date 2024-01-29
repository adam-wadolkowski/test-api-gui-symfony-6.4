<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    //#[Route('/post/{$id}', name: 'get_post_by_id', requirements: ['id' => '\d+'], methods: ['get'], condition: "params['id'] > 0")]
    #[Route('/post/{id<\d+>}', name: 'get_post_by_id', methods: ['get'], condition: "params['id'] > 0")]
    public function index(int $idPost): JsonResponse
    {
        return $this->json(['id' => $idPost]);
    }
}
