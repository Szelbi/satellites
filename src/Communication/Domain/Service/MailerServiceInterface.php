<?php
declare(strict_types=1);

namespace App\Communication\Domain\Service;

use App\Communication\Application\Dto\EmailDto;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

interface MailerServiceInterface
{
    /**
     * @throws TransportExceptionInterface
     */
    public function send(EmailDto $emailDto): void;
}