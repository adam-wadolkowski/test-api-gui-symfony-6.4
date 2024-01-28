<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObject\EmailSettingsVO;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /** @throws TransportExceptionInterface */
    public function send(EmailSettingsVO $emailSettings): void
    {
        $email = (new Email())
            ->from($emailSettings->from)
            ->to($emailSettings->to)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($emailSettings->subject)
            ->text($emailSettings->text)
            ->html($emailSettings->html);

        //try {
            $this->mailer->send($email);
        //} catch (TransportExceptionInterface) {
        // @TODO Save errors in logs this place use e.g. Monolog or save other place use FailedMessageEvent. Try resend email when use sending messages async to use messenger or other massage broker.
        //}
    }
}
