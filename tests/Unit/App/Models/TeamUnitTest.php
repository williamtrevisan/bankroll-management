<?php

namespace Tests\Unit\App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamUnitTest extends ModelTestCase
{
    protected function getModel(): Model
    {
        return new Team();
    }

    protected function getExpectedTraits(): array
    {
        return [
            HasFactory::class,
            SoftDeletes::class
        ];
    }

    protected function getExpectedFillables(): array
    {
        return [
            'id',
            'description',
            'is_active'
        ];
    }

    protected function getExpectedCasts(): array
    {
        return [
            'id' => 'string',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime'
        ];
    }
}
