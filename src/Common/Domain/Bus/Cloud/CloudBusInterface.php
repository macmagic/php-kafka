<?php

declare(strict_types=1);

namespace App\Common\Domain\Bus\Cloud;

interface CloudBusInterface
{
    public function send(CloudMessageInterface $message): void;
}
