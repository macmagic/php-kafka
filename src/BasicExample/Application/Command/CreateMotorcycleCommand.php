<?php

declare(strict_types=1);

namespace App\BasicExample\Application\Command;

use App\BasicExample\Ui\Action\Request\CreateMotorcycleRequest;
use App\Common\Domain\Bus\Command\CommandInterface;

class CreateMotorcycleCommand implements CommandInterface
{
    private string $brand;

    private string $model;

    private string $engineHp;

    private int $year;

    public function __construct(string $brand, string $model, string $engineHp, int $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->engineHp = $engineHp;
        $this->year = $year;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getEngineHp(): string
    {
        return $this->engineHp;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public static function createFromRequest(CreateMotorcycleRequest $request): self
    {
        return new self(
            $request->getBrand(),
            $request->getModel(),
            $request->getEngineHp(),
            $request->getYear()
        );
    }
}
