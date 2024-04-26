<?php

namespace Services;

use App\Enums\Type;
use App\Services\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
    public function testTranslateBasic(): void
    {
        $translator = new Translator();

        $this->assertEquals('appyhay', $translator->translate('happy', Type::CAMEL_CASE->value));
        $this->assertEquals('estionquay', $translator->translate('question', Type::CAMEL_CASE->value));
        $this->assertEquals('anotheray', $translator->translate('another', Type::CAMEL_CASE->value));
        $this->assertEquals('itay', $translator->translate('it', Type::CAMEL_CASE->value));
    }

    public function testTranslateCompound(): void
    {
        $translator = new Translator();

        $this->assertEquals('edbayoomray', $translator->translate('bedRoom', Type::CAMEL_CASE->value));
        $this->assertEquals('pacesayhipsay', $translator->translate('spaceShip', Type::CAMEL_CASE->value));
    }
}