<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Bus\Command\CommandInterface;
use App\Ui\Action\Request\CreateMotorcycleRequest;

class CreateMotorcycleCommand implements CommandInterface
{
    private string $model;

    private string $brand;

    private string $engineHp;

    public function __construct(string $model, string $brand, string $engineHp)
    {
        $this->model = $model;
        $this->brand = $brand;
        $this->engineHp = $engineHp;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getEngineHp(): string
    {
        return $this->engineHp;
    }

    public static function createFromRequest(CreateMotorcycleRequest $request): self
    {
        return new self(
            $request->getModel(),
            $request->getBrand(),
            $request->getEngineHp()
        );
    }
}
