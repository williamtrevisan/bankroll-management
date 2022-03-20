<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Team;
use InvalidArgumentException;
use Throwable;

class TeamUnitTest extends TestCase
{
    public function testMustHaveDescriptionAndIsActiveProperties()
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
        } catch (Throwable $throwable) {
            $this->assertInstanceOf(
                InvalidArgumentException::class,
                $throwable, 
                'Sorry, it\'s not possible to create a team with the isActive property false, just update it.'
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