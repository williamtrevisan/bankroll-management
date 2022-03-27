<?php

namespace Tests\Unit\App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class TeamUnitTest extends TestCase
{
    public function testMustTeamModelUseHasFactoryAndSoftDeletesTraits()
    {
        $traitsExpected = [
            HasFactory::class,
            SoftDeletes::class
        ];
        $teamModelTraits = class_uses($this->teamModel());

        $this->assertEqualsCanonicalizing($traitsExpected, $teamModelTraits);
    }

    public function testMustTeamModelHaveAImplementingPropertyLikeFalse()
    {
        $teamModelIncrementingProperty = $this->teamModel()->incrementing;

        $this->assertFalse($teamModelIncrementingProperty);
    }

    public function testMustTeamModelHaveIdDescriptionAndIsActiveOnFillableProperty()
    {
        $fillablesExpected = [
            'id',
            'description',
            'is_active'
        ];
        $teamModelFillables = $this->teamModel()->getFillable();

        $this->assertEquals($fillablesExpected, $teamModelFillables);
    }

    public function testMustTeamModelHaveCastsForIdIsActiveAndDeletedAt()
    {
        $castsExpected = [
            'id' => 'string',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime'
        ];
        $teamModelCasts = $this->teamModel()->getCasts();

        $this->assertEquals($castsExpected, $teamModelCasts);
    }

    protected function teamModel(): Model
    {
        return new Team();
    }
}
