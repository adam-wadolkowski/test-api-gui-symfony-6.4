<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\ValueObject\EmailSettingsVO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

readonly class PostService
{
    public function __construct(
        private EntityManagerInterface $em,
        private EmailService $email,
        private PostRepository $post,
        private Paginator $paginator
    ) {
    }

    public function save(Post $post): void
    {
        $this->em->persist($post);
        $this->em->flush();
    }

    /** @throws TransportExceptionInterface */
    public function sendEmail(): void
    {
        $postEmail = new EmailSettingsVO(
            new Address('notification@blog.com'),
            'user@example.com',
            'Blog post publication status.',
            'Sending emails is fun again!',
            '<p>The blog post was published successfully</p>'
        );

        $this->email->send($postEmail);
    }

    public function getPaginatePosts(int $pageNumber): Paginator
    {
        return $this->paginator->paginate($this->post->getPostsQuery(), $pageNumber);
    }
}
