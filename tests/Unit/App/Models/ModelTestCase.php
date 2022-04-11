<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function getModel(): Model;
    abstract protected function getExpectedTraits(): array;
    abstract protected function getExpectedFillables(): array;
    abstract protected function getExpectedCasts(): array;

    public function testMustModelUseTraitsLikeExpected()
    {
        $traitsExpected = $this->getExpectedTraits();
        $teamModelTraits = class_uses($this->getModel());

        $this->assertEqualsCanonicalizing($traitsExpected, $teamModelTraits);
    }

    public function testMustModelHaveAImplementingPropertyFalse()
    {
        $teamModelIncrementingProperty = $this->getModel()->incrementing;

        $this->assertFalse($teamModelIncrementingProperty);
    }

    public function testMustModelHaveFillablePropertyLikeExpected()
    {
        $fillablesExpected = $this->getExpectedFillables();
        $teamModelFillables = $this->getModel()->getFillable();

        $this->assertEquals($fillablesExpected, $teamModelFillables);
    }

    public function testMustModelHaveCastsLikeExpected()
    {
        $castsExpected = $this->getExpectedCasts();
        $teamModelCasts = $this->getModel()->getCasts();

        $this->assertEquals($castsExpected, $teamModelCasts);
    }
}
