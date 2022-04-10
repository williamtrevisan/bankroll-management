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

    public function testMustTeamModelUseHasFactoryAndSoftDeletesTraits()
    {
        $traitsExpected = $this->getExpectedTraits();
        $teamModelTraits = class_uses($this->getModel());

        $this->assertEqualsCanonicalizing($traitsExpected, $teamModelTraits);
    }

    public function testMustTeamModelHaveAImplementingPropertyLikeFalse()
    {
        $teamModelIncrementingProperty = $this->getModel()->incrementing;

        $this->assertFalse($teamModelIncrementingProperty);
    }

    public function testMustTeamModelHaveIdDescriptionAndIsActiveOnFillableProperty()
    {
        $fillablesExpected = $this->getExpectedFillables();
        $teamModelFillables = $this->getModel()->getFillable();

        $this->assertEquals($fillablesExpected, $teamModelFillables);
    }

    public function testMustTeamModelHaveCastsForIdIsActiveAndDeletedAt()
    {
        $castsExpected = $this->getExpectedCasts();
        $teamModelCasts = $this->getModel()->getCasts();

        $this->assertEquals($castsExpected, $teamModelCasts);
    }
}
