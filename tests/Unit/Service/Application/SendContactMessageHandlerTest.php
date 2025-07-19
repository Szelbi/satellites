<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\Application;

use App\Communication\Application\Service\EmailBuilder;
use App\Communication\Application\Service\SendContactMessageHandler;
use App\Tests\Unit\Service\Infrastructure\InMemory\InMemoryMailerService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * @covers \App\Communication\Application\Service\SendContactMessageHandler
 */
class SendContactMessageHandlerTest extends TestCase
{
    private InMemoryMailerService $mailerService;
    private EmailBuilder $emailBuilder;
    private SendContactMessageHandler $handler;

    protected function setUp(): void
    {
        $this->mailerService = new InMemoryMailerService();
        
        $twig = $this->createMock(Environment::class);
        $twig->method('render')->willReturn('<html>Contact email content</html>');
        
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('trans')->willReturnMap([
            ['email.contact.subject', [], null, null, 'New Contact Form Submission']
        ]);
        
        $this->emailBuilder = new EmailBuilder($twig, $translator);
        $this->handler = new SendContactMessageHandler($this->mailerService, $this->emailBuilder);
    }

    public function testProcessContactFormSendsEmail(): void
    {
        $email = 'user@example.com';
        $message = 'Hello, this is a test message.';

        $this->handler->processContactForm($email, $message);

        $this->assertSame(1, $this->mailerService->getSentEmailsCount());
        $this->assertTrue($this->mailerService->hasSentEmailTo('dawidgos25@gmail.com'));
        $this->assertTrue($this->mailerService->hasSentEmailWithSubject('New Contact Form Submission'));
    }

    public function testProcessContactFormBuildsCorrectEmail(): void
    {
        $email = 'sender@test.com';
        $message = 'Test message content';

        $this->handler->processContactForm($email, $message);

        $sentEmail = $this->mailerService->getLastSentEmail();

        $this->assertNotNull($sentEmail);
        $this->assertSame($email, $sentEmail->from);
        $this->assertSame('dawidgos25@gmail.com', $sentEmail->to);
        $this->assertSame('New Contact Form Submission', $sentEmail->subject);
        $this->assertStringContainsString('Contact email content', $sentEmail->htmlContent);
    }

    public function testProcessContactFormWithMultipleMessages(): void
    {
        $this->handler->processContactForm('user1@test.com', 'Message 1');
        $this->handler->processContactForm('user2@test.com', 'Message 2');
        $this->handler->processContactForm('user3@test.com', 'Message 3');

        $this->assertSame(3, $this->mailerService->getSentEmailsCount());
        
        $sentEmails = $this->mailerService->getSentEmails();
        $this->assertSame('user1@test.com', $sentEmails[0]->from);
        $this->assertSame('user2@test.com', $sentEmails[1]->from);
        $this->assertSame('user3@test.com', $sentEmails[2]->from);
    }
}