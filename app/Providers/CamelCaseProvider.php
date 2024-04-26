<?php

namespace App\Providers;

use App\Interfaces\ProviderInterface;

class CamelCaseProvider implements ProviderInterface
{
    public function split(string $word): array
    {
        $parts = preg_split('/(?=[A-Z])/', $word, -1, PREG_SPLIT_NO_EMPTY);

        return array_map('strtolower', $parts);
    }
}