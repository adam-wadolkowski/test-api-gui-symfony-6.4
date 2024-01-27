<?php

declare(strict_types=1);

namespace App\Controller\Gui;

use App\Entity\Image;
use App\Entity\Post;
use App\Form\ImageType;
use App\Form\PostBlogType;
use App\Repository\PostRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Index extends AbstractController
{
    /** @throws Exception */
    #[Route('/', name: 'list_blog_posts', methods: ['GET'])]
    public function listing(PostRepository $post): Response
    {
        return $this->render('list.html.twig', [
            'posts' => $post->getAll()
        ]);
    }

    #[Route('/new', name: 'add_blog_post', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $form = $this->createForm(PostBlogType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faker = Factory::create();
            $post->setImage($faker->image(format: 'jpg'));
            $em->persist($post);
            $em->flush();

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