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
        $this->assertInternalType('array',$config['bundle']);
        $this->assertSame('DemoBundle', $config['bundle']['name']);
        $this->assertSame('DemoBundle provide content types for news websites', $config['bundle']['description']);
    }
}

