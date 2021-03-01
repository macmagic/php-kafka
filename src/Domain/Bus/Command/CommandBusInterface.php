<?php

declare(strict_types=1);

namespace App\Domain\Bus\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): void;
}
