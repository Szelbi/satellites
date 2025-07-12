<?php
declare(strict_types=1);

namespace App\Communication\Infrastructure\Service;

use App\Communication\Application\Dto\EmailDto;
use App\Communication\Domain\Service\MailerServiceInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class SymfonyMailerService implements MailerServiceInterface
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(EmailDto $emailDto): void
    {
        $email = new Email()
            ->from($emailDto->from)
            ->to($emailDto->to)
            ->subject($emailDto->subject)
            ->html($emailDto->htmlContent);

        $this->mailer->send($email);
    }
}