<?php

declare(strict_types=1);

namespace App\Infrastructure;

class Test
{
    private string $content;

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
