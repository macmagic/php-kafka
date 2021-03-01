<?php

declare(strict_types=1);

namespace App\Ui\Action\Request;

class CreateMotorcycleRequest
{
    private string $model;

    private string $brand;

    private string $engineHp;

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getEngineHp(): string
    {
        return $this->engineHp;
    }

    public function setEngineHp(string $engineHp): void
    {
        $this->engineHp = $engineHp;
    }
}
