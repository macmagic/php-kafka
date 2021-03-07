<?php

declare(strict_types=1);

namespace App\Music\Application\Exception;

use App\Common\Application\Exception\AppException;

class FileException extends \DomainException implements AppException
{
    private const APP_CODE = 'FILE_ERROR';

    private const EXCEPTION_CODE = 500;

    public function __construct(string $message)
    {
        parent::__construct($message, self::EXCEPTION_CODE);
    }

    public function getExceptionCode(): int
    {
        return self::EXCEPTION_CODE;
    }

    public function getAppCode(): string
    {
        return self::APP_CODE;
    }
}
