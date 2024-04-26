<?php

namespace App\Services;

use App\Enums\Type;
use App\Interfaces\ProviderInterface;
use App\Interfaces\TranslatorInterface;
use App\Providers\AiCaseProvider;
use App\Providers\CamelCaseProvider;
use App\Providers\SnakeCaseProvider;

class Translator implements TranslatorInterface
{
    public const array VOWELS = ['a', 'e', 'i', 'o', 'u'];

    public const array PSEUDO_VOWELS = ['ch', 'qu', 'squ', 'thr', 'th', 'sch', 'yt', 'xr'];

    public const string SUFFIX = 'ay';

    protected array $providers = [];

    public function __construct()
    {
        $this->providers = [
            Type::SNAKE_CASE->value => new SnakeCaseProvider(),
            Type::CAMEL_CASE->value => new CamelCaseProvider(),
        ];

        try {
            $this->providers[Type::AI->value] = new AiCaseProvider();
        } catch (\Exception $exception) {
            // nothing to do
        }

    }

    public function translate(string $word, string $type): string
    {
        if (!array_key_exists($type, $this->providers)) {
            if ($type === Type::AI->value) {
                throw new \InvalidArgumentException(sprintf('Type "%s" not set! Check api-key config!', $type));
            }
            throw new \InvalidArgumentException(sprintf('Type "%s" not exists!', $type));
        }

        $provider = $this->providers[$type];

        if (!$provider instanceof ProviderInterface) {
            throw new \Exception('Invalid provider.');
        }

        $words = $provider->split($word);

        $translated = '';

        foreach ($words as $word) {
            $translated .= $this->translateWord($word);
        }

        return $translated;
    }

    protected function translateWord(string $word): string
    {
        foreach (self::VOWELS as $vowel) {
            if (substr($word, 0, strlen($vowel)) === $vowel) {
                return $word . self::SUFFIX;
            }
        }

        foreach (self::PSEUDO_VOWELS as $vowel) {
            if (substr($word, 0, strlen($vowel)) === $vowel) {
                return substr($word, strlen($vowel)) . $vowel . self::SUFFIX;
            }
        }

        return substr($word, 1) . substr($word, 0, 1) . self::SUFFIX;
    }

    protected function startsWithVowel(string $word): bool
    {
        return in_array(strtolower($word[0]), self::VOWELS);
    }

    protected function findFirstVowel(string $word): int|false
    {
        for ($i = 0; $i < strlen($word); $i++) {
            if (in_array(strtolower($word[$i]), self::VOWELS)) {
                return $i;
            }
        }
        return false;
    }
}