<?php

use PHPUnit\Framework\TestCase;

class SnakeCaseProviderTest extends TestCase
{
    public function testSplitBasic(): void
    {
        $word = 'happy';

        $array = (new \App\Providers\SnakeCaseProvider())->split($word);

        $this->assertSame(['happy'], $array);
    }

    public function testSplitCompoundSnakeCase(): void
    {
        $word = 'bed_room';

        $array = (new \App\Providers\SnakeCaseProvider())->split($word);

        $this->assertSame(['bed', 'room'], $array);
    }

    public function testSplitCompoundUpperSnakeCase(): void
    {
        $word = 'Bed_Room';

        $array = (new \App\Providers\SnakeCaseProvider())->split($word);

        $this->assertSame(['bed', 'room'], $array);
    }

    public function testSplitCompoundSnakeCaseWrongFormat(): void
    {
        $word = 'bedroom';

        $array = (new \App\Providers\SnakeCaseProvider())->split($word);

        $this->assertSame(['bedroom'], $array);
    }
}