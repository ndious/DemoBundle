<?php
namespace BackBee\Bundle\DemoBundle\Tests;

/*
 * Copyright (c) 2011-2015 Lp digital system
 *
 * This file is part of BackBee.
 *
 * BackBee is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee. If not, see <http://www.gnu.org/licenses/>.
 */

use Symfony\Component\Yaml\Yaml;

/**
 * @author Mickaël Andrieu <mickael.andrieu@lp-digital.fr>
 */
class CheckTwigFilesTest extends \PHPUnit_Framework_TestCase
{

    public function testConfigFileIsWellFormed()
    {
        $configPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'config.yml';
        $config = Yaml::parse($configPath);
        $this->assertInternalType('array',$configBundle = $config['bundle']);
        $this->assertSame('DemoBundle', $configBundle['name']);
        $this->assertSame('DemoBundle provide content types for news websites', $configBundle['description']);
        $this->assertSame('e.chau <eric.chau@lp-digital.fr>', $configBundle['author']);
        $this->assertSame(1, $configBundle['version']);
        $this->assertTrue($configBundle['enable']);
        $this->assertFalse($configBundle['config_per_site']);
    }

    public function testClassContentFileIsWellFormed()
    {
        $classContentPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'ClassContent'.DIRECTORY_SEPARATOR.'block_demo.yml';
        $config = Yaml::parse($classContentPath);
        $this->assertInternalType('array', $configClassContent = $config['block_demo']);
        $this->assertInternalType('array', $configClassContent['properties']);
        $this->assertInternalType('array', $configClassContent['elements']);
    }
}

