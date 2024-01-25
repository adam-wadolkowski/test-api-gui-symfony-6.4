<?php

declare(strict_types=1);

namespace App\Controller\Gui;

use App\Repository\PostRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Index extends AbstractController
{
    /** @throws Exception */
    #[Route('/', name: 'list_blog_posts', methods: ['GET'])]
    public function listing(PostRepository $post): Response
    {
        return $this->render('list.html.twig', [
            'posts' => $post->getAll(),
        ]);
    }

    #[Route('/new', name: 'add_blog_post', methods: ['GET'])]
    public function add(): Response
    {
//        if (count($errors) > 0) {
//            return $this->render('validation.html.twig', [
//                'errors' => $errors,
//            ]);
//        }
//
//        return $this->render('new.html.twig', [
//            'number' => random_int(0, 100),
//        ]);
    }
}