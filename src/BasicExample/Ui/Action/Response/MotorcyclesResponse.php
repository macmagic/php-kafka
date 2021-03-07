<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class MotorcyclesResponse implements ResponseInterface
{
    /** @var MotorcycleResponse[] */
    private array $motorcycles;

    public function __construct(array $motorcycles)
    {
        $this->motorcycles = $motorcycles;
    }

    public function setMotorcycles(array $motorcycles): void
    {
        $this->motorcycles = $motorcycles;
    }

    public function getMotorcycles(): array
    {
        return $this->motorcycles;
    }
}
