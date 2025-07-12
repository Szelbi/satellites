<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service\Infrastructure\InMemory;

use App\Communication\Application\Dto\EmailDto;
use App\Communication\Domain\Service\MailerServiceInterface;

class InMemoryMailerService implements MailerServiceInterface
{
    /** @var EmailDto[] */
    private array $sentEmails = [];

    public function send(EmailDto $emailDto): void
    {
        $this->sentEmails[] = $emailDto;
    }

    /** @return EmailDto[] */
    public function getSentEmails(): array
    {
        return $this->sentEmails;
    }

    public function getLastSentEmail(): ?EmailDto
    {
        return end($this->sentEmails) ?: null;
    }

    public function getSentEmailsCount(): int
    {
        return count($this->sentEmails);
    }

    public function clear(): void
    {
        $this->sentEmails = [];
    }

    public function hasSentEmailTo(string $recipient): bool
    {
        return array_any($this->sentEmails, fn($email) => $email->to === $recipient);
    }

    public function hasSentEmailWithSubject(string $subject): bool
    {
        return array_any($this->sentEmails, fn($email) => $email->subject === $subject);
    }
}
