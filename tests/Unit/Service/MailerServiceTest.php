<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Communication\Application\Dto\EmailDto;
use App\Communication\Infrastructure\Service\SymfonyMailerService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @covers \App\Communication\Infrastructure\Service\SymfonyMailerService
 */
class MailerServiceTest extends TestCase
{
    private MailerInterface $mailer;
    private SymfonyMailerService $mailerService;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->mailerService = new SymfonyMailerService($this->mailer);
    }

    public function testSend(): void
    {
        $emailDto = new EmailDto(
            from: 'test@example.com',
            to: 'recipient@example.com',
            subject: 'Test Subject',
            htmlContent: '<h1>Test Content</h1>'
        );

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email): bool {
                return $email->getFrom()[0]->getAddress() === 'test@example.com'
                    && $email->getTo()[0]->getAddress() === 'recipient@example.com'
                    && $email->getSubject() === 'Test Subject'
                    && $email->getHtmlBody() === '<h1>Test Content</h1>';
            }));

        $this->mailerService->send($emailDto);
    }

    public function testSendWithMultipleRecipients(): void
    {
        $emailDto = new EmailDto(
            from: 'sender@example.com',
            to: 'user1@example.com,user2@example.com',
            subject: 'Multiple Recipients Test',
            htmlContent: '<p>Hello everyone!</p>'
        );

        $this->mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $email): bool {
                return $email->getFrom()[0]->getAddress() === 'sender@example.com'
                    && $email->getSubject() === 'Multiple Recipients Test'
                    && $email->getHtmlBody() === '<p>Hello everyone!</p>';
            }));

        $this->mailerService->send($emailDto);
    }
}
