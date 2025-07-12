<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Handler\MailerHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

/**
 * @covers \App\Handler\MailerHandler
 */
class MailerServiceTest extends TestCase
{
    private MailerInterface $mailer;
    private Environment $twig;
    private MailerHandler $mailerService;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->twig = $this->createMock(Environment::class);
        $this->mailerService = new MailerHandler($this->mailer, $this->twig);
    }

    public function testSendContactMessage(): void
    {
        $fromEmail = 'test@example.com';
        $messageContent = 'Test message content';
        $renderedTemplate = '<h1>Contact Message</h1><p>Test message content</p>';

        $this->twig->expects($this->once())
            ->method('render')
            ->with('emails/contact.html.twig', [
                'email' => $fromEmail,
                'message' => $messageContent,
            ])
            ->willReturn($renderedTemplate);

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email): bool {
                return $email->getFrom()[0]->getAddress() === 'test@example.com'
                    && $email->getTo()[0]->getAddress() === 'example@mail.com'
                    && $email->getSubject() === 'New Contact Form Submission'
                    && $email->getHtmlBody() === '<h1>Contact Message</h1><p>Test message content</p>';
            }));

        $this->mailerService->sendContactMessage($fromEmail, $messageContent);
    }

    public function testSendEmailVerification(): void
    {
        $toEmail = 'user@example.com';
        $verificationToken = 'abc123token';
        $renderedTemplate = '<p>Please verify your email</p>';

        $_ENV['APP_URL'] = 'https://test.example.com';

        $this->twig->expects($this->once())
            ->method('render')
            ->with('emails/verification.html.twig', [
                'verification_url' => 'https://test.example.com/verify-email?token=abc123token',
            ])
            ->willReturn($renderedTemplate);

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email): bool {
                return $email->getFrom()[0]->getAddress() === 'dawid.sender@gmail.com'
                    && $email->getTo()[0]->getAddress() === 'user@example.com'
                    && $email->getSubject() === 'Potwierdź swój email'
                    && $email->getHtmlBody() === '<p>Please verify your email</p>';
            }));

        $this->mailerService->sendEmailVerification($toEmail, $verificationToken);
    }

    public function testSendEmailVerificationWithoutAppUrl(): void
    {
        $toEmail = 'user@example.com';
        $verificationToken = 'abc123token';
        $renderedTemplate = '<p>Please verify your email</p>';

        unset($_ENV['APP_URL']);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('emails/verification.html.twig', [
                'verification_url' => 'http://localhost:8001/verify-email?token=abc123token',
            ])
            ->willReturn($renderedTemplate);

        $this->mailer->expects($this->once())
            ->method('send');

        $this->mailerService->sendEmailVerification($toEmail, $verificationToken);
    }

    public function testSendContactMessageCallsTwigRenderWithCorrectParameters(): void
    {
        $fromEmail = 'sender@test.com';
        $messageContent = 'Hello world';

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('emails/contact.html.twig'),
                $this->equalTo([
                    'email' => $fromEmail,
                    'message' => $messageContent,
                ])
            )
            ->willReturn('<html>test</html>');

        $this->mailer->expects($this->once())
            ->method('send');

        $this->mailerService->sendContactMessage($fromEmail, $messageContent);
    }

    public function testSendEmailVerificationCallsTwigRenderWithCorrectParameters(): void
    {
        $toEmail = 'recipient@test.com';
        $token = 'verification-token-123';

        $_ENV['APP_URL'] = 'https://myapp.com';

        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('emails/verification.html.twig'),
                $this->equalTo([
                    'verification_url' => 'https://myapp.com/verify-email?token=verification-token-123',
                ])
            )
            ->willReturn('<html>verify</html>');

        $this->mailer->expects($this->once())
            ->method('send');

        $this->mailerService->sendEmailVerification($toEmail, $token);
    }
}
