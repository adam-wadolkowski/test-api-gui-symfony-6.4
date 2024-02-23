<?php

declare(strict_types=1);

namespace App\Controller\Gui;

//use App\Entity\Image;
use App\Entity\Post;
use App\Form\PostType;
use App\Service\FileUploaderService;
use App\Service\PostEmailService;
use App\Service\PostPaginatorServiceInterface;
use App\Service\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

//use App\Form\ImageType;

class PostIndexController extends AbstractController
{
    #[Route('/', name: 'list_blog_posts', methods: ['GET'])]
    public function index(Request $request, PostPaginatorServiceInterface $postPaginatorService): Response
    {
        return $this->render('index.html.twig', [
            'paginator' => $postPaginatorService->getPaginatePosts(
                $request->query->getInt('page', 1)
            )
        ]);
    }

    /** @throws TransportExceptionInterface */
    #[Route('/new', name: 'add_blog_post', methods: ['GET', 'POST'])]
    public function add(Request $request, PostServiceInterface $postService, FileUploaderService $fileUploaderService, PostEmailService $emailService): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploaderService->upload($imageFile);
                $post->setImage($imageFileName);
            }

            $postService->save($post);
            $emailService->sendEmail();

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
