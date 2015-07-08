<?php

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

namespace BackBee\Bundle\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Nicolas Dufreche <nicolas.dufreche@lp-digital.fr>
 *
 * @ORM\Entity()
 * @ORM\Table(name="demo_item")
 * @ORM\HasLifecycleCallbacks
 */
class Item
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var String
     * @ORM\Column(type="string", name="value")
     */
    private $value;

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
