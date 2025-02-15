<?php

declare(strict_types=1);

namespace App\Common\Application\Exception;

interface AppException
{
    public function getExceptionCode(): int;

    public function getAppCode(): string;

    /**
     * @return string
     */
    public function getMessage();
}
