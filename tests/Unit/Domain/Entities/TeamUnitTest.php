<?php

namespace Tests\Unit\Domain\Entities;

use Core\Domain\Exceptions\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entities\Team;
use Ramsey\Uuid\Uuid;
use Throwable;

class TeamUnitTest extends TestCase
{
    public function testMustHaveDescriptionAndIsActiveAttributes()
    {
        $team = new Team(
            description: 'Internacional',
            isActive: true,
        );

        $this->assertEquals('Internacional', $team->description);
        $this->assertTrue($team->isActive);
        $this->assertNotEmpty($team->id());
        $this->assertNotEmpty($team->createdAt());
    }

    public function testShouldBeAbleInstantiateTeamClassWithIsActiveTrueByDefault()
    {
        $team = new Team(
            description: 'Internacional',
        );

        $this->assertTrue($team->isActive);
    }

    public function testMustReturnExceptionIfLengthDescriptionIsLowerThan2()
    {
        try {
            new Team(
                description: random_bytes(1),
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'Description must greater than 255 or lower than 2.'
            );
        }
    }

    public function testMustReturnExceptionIfLengthDescriptionIsGreaterThan255()
    {
        try {
            new Team(
                description: random_bytes(256),
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                EntityValidationException::class,
                $th,
                'Description must greater than 255 or lower than 2.'
            );
        }
    }

    public function testShouldBeAbleToDisableATeam()
    {
        $team = new Team(
            description: 'Internacional',
            isActive: true,
        );

        $team->disable();

        $this->assertFalse($team->isActive);
    }

    public function testShouldBeAbleToEnableATeam()
    {
        $team = new Team(
            description: 'Internacional',
            isActive: true,
        );
        $team->disable();

        $team->enable();

        $this->assertTrue($team->isActive);
    }

    public function testShouldBeAbleToUpdateATeam()
    {
        $uuid = Uuid::uuid4()->toString();

        $team = new Team(
            description: 'Internacional',
            isActive: true,
            id: $uuid,
            createdAt: '2023-01-01 12:13:12'
        );

        $team->update('Palmeiras');

        $this->assertEquals($uuid, $team->id());
        $this->assertEquals('Palmeiras', $team->description);
    }
}
