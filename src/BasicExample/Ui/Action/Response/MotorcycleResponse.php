<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class MotorcycleResponse implements ResponseInterface
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

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getEngineHp(): string
    {
        return $this->engineHp;
    }

    public function setEngineHp(string $engineHp): void
    {
        $this->engineHp = $engineHp;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}
