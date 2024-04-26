<?php

namespace App\Providers;

use App\Interfaces\ProviderInterface;

class SnakeCaseProvider implements ProviderInterface
{
    public function split(string $word): array
    {
        $parts = explode('_', $word);

        return array_map('strtolower', $parts);
    }
}