<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\PostDto;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Service\PostServiceInterface;
use App\ValueObject\PostVO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
//use Swagger\Annotations as SWG;

#[Route('/api', name: 'api_')]
class PostApiController extends AbstractController
{
    #[Route('/post/{id<\d+>}', name: 'get_post_by_id', methods: ['GET'])]
//    #[SWG\Response(
//        response: 200,
//        description: "Returns the all posts",
//        #[SWG\Schema(
//            type: "array",
//            #[SWG\Items(ref=@Model(type=Reward::class, groups={"full"}))]
//        ]
//    )]
    public function getPost(Post $post): JsonResponse
    {
        return $this->json((new PostVO($post))->toArray());
    }

    #[Route('/post', name: 'add_post_by_id', methods: ['POST'])]
    public function addPost(#[MapRequestPayload] PostDto $postDto, PostServiceInterface $postService): JsonResponse
    {
        $post = PostFactory::create($postDto);
        $postService->save($post);

        return $this->json((new PostVO($post))->toArrayId());
    }
}
