<?php

namespace App\Interfaces;

interface ProviderInterface
{
    public function split(string $word): array;
}