<?php

namespace Unit\Domain\Entities;

use Core\Domain\Exceptions\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entities\Team;
use InvalidArgumentException;
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
    }

    public function testShouldBeAbleInstantiateTeamClassWithIsActiveTrueByDefault()
    {
        $team = new Team(
            description: 'Internacional',
        );

        $this->assertTrue($team->isActive);
    }

    public function testShouldNotBeAbleInstantiateTeamClassWithIsActiveFalse()
    {
        try {
            new Team(
                description: 'Internacional',
                isActive: false,
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(
                InvalidArgumentException::class,
                $th,
                'Cannot create a team with isActive property false, just update it.'
            );
        }
    }
    
    public function testMustReturnExceptionIfLengthDescriptionIsLowerThan2()
    {
        try {
            new Team(
                description: 'I',
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

    public function testMustReturnExceptionIfLengthDescriptionIsLowerThan255()
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
        $team = new Team(
            description: 'Internacional',
        );

        $team->update('Palmeiras');

        $this->assertEquals('Palmeiras', $team->description);
    }
}