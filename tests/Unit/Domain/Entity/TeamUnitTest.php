<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Team;

class TeamUnitTest extends TestCase
{
    public function testShouldHaveAttributes()
    {
        $team = new Team(
            description: 'Internacional',
            isActive: true,
        );

        $this->assertEquals('Internacional', $team->description);
        $this->assertTrue($team->isActive);
    }
}