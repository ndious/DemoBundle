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
 *
 * @author Charles Rouillon <charles.rouillon@lp-digital.fr>
 */

namespace BackBee\Bundle\DemoBundle\Data\Fixtures;

use Doctrine\DBAL\Connection;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class used to create a demonstration website from fixtures
 *
 * @author      Mickaël Andrieu <mickael.andrieu@lp-digital.fr>
 */
class DemoWebsiteLoader
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Load fixtures from and SQL dump file.
     *
     * @param string $filename
     * @return void|RuntimeException
     */
    public function loadFixtures($filename)
    {
        $filePath = realpath($filename);

        if (false === $filePath) {
            $filePath = $filename;
        }
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException(
                sprintf("SQL file '<info>%s</info>' does not exist.", $filePath)
            );
        } elseif (!is_readable($filePath)) {
            throw new \InvalidArgumentException(
                sprintf("SQL file '<info>%s</info>' does not have read permissions.", $filePath)
            );
        }

        $sql = file_get_contents($filePath);

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    /**
     * Update Website SQL entry according to the BackBee installation.
     *
     * @param     array    Website configuration, must contains 'domain' and 'label' keys
     * @return    array|InvalidArgumentException  Returns domain and label set up in database or an Exception
     */
    public function updateWebsite($configuration)
    {
        if (!is_array($configuration)
            || !isset($configuration['domain']
            || !isset($configuration['label']
           ) {
                throw new \InvalidArgumentException('array expected with domain and label keyes');
            }
        $domain = $configuration['domain'];
        $label  = $configuration['label'];

        try {
            $stmt = $this->connection->executeUpdate('UPDATE site SET server_name = ? , label = ?', array($domain, $label));
        } catch (\PDOException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $configuration;
    }

    /**
     * Import Assets into the BackBee application for the Demonstration Website
     *
     * @param    $applicationMediaRepository    path to the application ``Media`` repository
     * @param    $bundleMediaRepository         path to the bundle ``Media`` repository
     * @return void
     */
    public function importAssets($applicationMediaRepository, $bundleMediaRepository)
    {
        // mirror Data/Media data to the Data/Media data of BackBee application
        $filesystem = new Filesystem();
        $filesystem->mirror($bundleMediaRepository, $applicationMediaRepository);
    }
}
