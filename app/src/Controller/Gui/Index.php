<?php

declare(strict_types=1);

namespace App\Controller\Gui;

//use App\Entity\Image;
use App\Entity\Post;
use App\Form\PostBlogType;
use App\Service\PostService;
use Doctrine\DBAL\Exception;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

//use App\Form\ImageType;

class Index extends AbstractController
{
    #[Route('/', name: 'list_blog_posts', methods: ['GET'])]
    public function index(Request $request, PostService $postService): Response
    {
        return $this->render('index.html.twig', [
            'paginator' => $postService->getPaginatePosts($request->query->getInt('page', 1)),
        ]);
    }

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
