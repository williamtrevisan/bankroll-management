<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Teste;

class TesteUnitTest extends TestCase
{
    public function testShouldBeAbleCallMethodFoo()
    {
        $teste = new Teste();
        $response = $teste->foo();

        $this->assertEquals('123', $response);
    }
}
