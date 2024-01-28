<?php

declare(strict_types=1);

namespace App\Controller\Gui;

//use App\Entity\Image;
use App\Entity\Post;
//use App\Form\ImageType;
use App\Form\PostBlogType;
use App\Repository\PostRepository;
use App\Service\PostService;
use App\Utils\Paginator;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

class Index extends AbstractController
{
    /** @throws Exception */
//    #[Route('/test', name: 'list_blog_posts', methods: ['GET'])]
//    public function listing(PostRepository $post): Response
//    {
//        return $this->render('list.html.twig', [
//            'posts' => $post->getAll()
//        ]);
//    }

    #[Route('/', name: 'list_blog_posts', methods: ['GET'])]
    public function index(Request $request, Paginator $paginator, EntityManagerInterface $em): Response
    {
        $page = $request->query->getInt('page', 1);
        $query = $em->getRepository(Post::class)->createQueryBuilder('p');
        $paginator->paginate($query, $page);
//dd($paginator);
        return $this->render('list.html.twig', [
            'paginator' => $paginator,
        ]);
    }

//    #[Route('/{slug}', name: 'list_blog_posts_with_paginate', methods: ['GET'])]
//    public function browse(PostRepository $post, int $slug = null): Response
//    {
//        dd($post->getPaginatedPosts($slug));
//        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
//        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
//        $adapter = new QueryAdapter($queryBuilder);
//        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
//            $adapter,
//            1,
//            9
//        );
//        return $this->render('vinyl/browse.html.twig', [
//            'genre' => $genre,
//            'pager' => $pagerfanta,
//        ]);
//    }

    /** @throws TransportExceptionInterface */
    #[Route('/new', name: 'add_blog_post', methods: ['GET', 'POST'])]
    public function add(Request $request, PostService $postService): Response
    {
        $post = new Post();
        $form = $this->createForm(PostBlogType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faker = Factory::create();
            $post->setImage($faker->image(format: 'jpg'));

            $postService->save($post);
            $postService->sendEmail();

            return $this->redirectToRoute('list_blog_posts', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);

//        $image = new Image();
//        $form = $this->createForm(ImageType::class, $image);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em->persist($form->getData());
//            $em->flush();
//            return $this->redirectToRoute('list_blog_posts');
//        }
//        return $this->render('new.html.twig', [
//            'form' => $form->createView()
//        ]);
    }
}
