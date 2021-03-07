<?php

declare(strict_types=1);

namespace App\BasicExample\Domain\Cloud;

interface CloudServiceInterface
{
    public function sendMessage(string $message, string $topic): void;

    public function getMessage(string $topic): array;
}
