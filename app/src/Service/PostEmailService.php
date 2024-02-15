<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\EmailSettingsVO;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

readonly class PostEmailService
{
    public function __construct(
        private EmailService $email,
    ) {
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
}