<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\Application;

use App\Communication\Application\Service\EmailBuilder;
use App\Communication\Application\Service\SendEmailVerificationHandler;
use App\Tests\Unit\Service\Infrastructure\InMemory\InMemoryMailerService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * @covers \App\Communication\Application\Service\SendEmailVerificationHandler
 */
class SendEmailVerificationHandlerTest extends TestCase
{
    private InMemoryMailerService $mailerService;
    private EmailBuilder $emailBuilder;
    private SendEmailVerificationHandler $handler;

    protected function setUp(): void
    {
        $this->mailerService = new InMemoryMailerService();
        
        $twig = $this->createMock(Environment::class);
        $twig->method('render')->willReturn('<html>Verification email content</html>');
        
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('trans')->willReturnMap([
            ['email.verification.subject', [], null, null, 'Potwierdź swój email']
        ]);
        
        $this->emailBuilder = new EmailBuilder($twig, $translator);
        $this->handler = new SendEmailVerificationHandler($this->mailerService, $this->emailBuilder);
    }

    public function testSendEmailVerificationSendsEmail(): void
    {
        $email = 'user@example.com';
        $token = 'verification-token-123';

        $this->handler->sendEmailVerification($email, $token);

        $this->assertSame(1, $this->mailerService->getSentEmailsCount());
        $this->assertTrue($this->mailerService->hasSentEmailTo($email));
        $this->assertTrue($this->mailerService->hasSentEmailWithSubject('Potwierdź swój email'));
    }

    public function testSendEmailVerificationBuildsCorrectEmail(): void
    {
        $email = 'user@test.com';
        $token = 'abc123token';

        $this->handler->sendEmailVerification($email, $token);

        $sentEmail = $this->mailerService->getLastSentEmail();

        $this->assertNotNull($sentEmail);
        $this->assertSame('dawid.sender@gmail.com', $sentEmail->from);
        $this->assertSame($email, $sentEmail->to);
        $this->assertSame('Potwierdź swój email', $sentEmail->subject);
        $this->assertStringContainsString('Verification email content', $sentEmail->htmlContent);
    }

    public function testSendEmailVerificationWithMultipleUsers(): void
    {
        $this->handler->sendEmailVerification('user1@test.com', 'token1');
        $this->handler->sendEmailVerification('user2@test.com', 'token2');

        $this->assertSame(2, $this->mailerService->getSentEmailsCount());
        
        $sentEmails = $this->mailerService->getSentEmails();
        $this->assertSame('user1@test.com', $sentEmails[0]->to);
        $this->assertSame('user2@test.com', $sentEmails[1]->to);
    }

    public function testClearEmailsResetsCount(): void
    {
        $this->handler->sendEmailVerification('user@test.com', 'token');
        $this->assertSame(1, $this->mailerService->getSentEmailsCount());

        $this->mailerService->clear();
        $this->assertSame(0, $this->mailerService->getSentEmailsCount());
    }
}