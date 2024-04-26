<?php

use PHPUnit\Framework\TestCase;

class CamelCaseProviderTest extends TestCase
{
    public function testSplitBasic(): void
    {
        $word = 'happy';

        $array = (new \App\Providers\CamelCaseProvider())->split($word);

        $this->assertSame(['happy'], $array);
    }

    public function testSplitCompoundCamelCase(): void
    {
        $word = 'bedRoom';

        $array = (new \App\Providers\CamelCaseProvider())->split($word);

        $this->assertSame(['bed', 'room'], $array);
    }

    public function testSplitCompoundPascalCase(): void
    {
        $word = 'BedRoom';

        $array = (new \App\Providers\CamelCaseProvider())->split($word);

        $this->assertSame(['bed', 'room'], $array);
    }

    public function testSplitCompoundCamelCaseWrongFormat(): void
    {
        $word = 'bedroom';

        $array = (new \App\Providers\CamelCaseProvider())->split($word);

        $this->assertSame(['bedroom'], $array);
    }
}