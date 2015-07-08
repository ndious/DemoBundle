<?php

/*
 * Copyright (c) 2011-2015 Lp digital system
 *
 * This file is part of BackBee Standard Edition.
 *
 * BackBee is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * BackBee Standard Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BackBee Standard Edition. If not, see <http://www.gnu.org/licenses/>.
 */

namespace BackBee\Bundle\DemoBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use BackBee\Console\AbstractCommand;

/**
 * Load demonstration website command.
 *
 * @author Mickaël Andrieu <mickael.andrieu@lp-digital.fr>
 */
class LoadDemoWebsiteCommand extends AbstractCommand
{
    /**
     * @var BackBee\Bundle\DemoBundle\Fixtures\DemoWebsiteLoader
     */
    private $fixtureLoader;

    /**
     * @var \BackBee\BBApplication
     */
    private $application;

    /**
     * @var string
     */
    private $dataRepository;

    protected function configure()
    {
        $this
            ->setName('demo:load-website')
            ->setDescription('Load ``THE MAG`` demo website')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command load a defaut website on a news media template model.
EOF
            )
        ;
    }

    /**
     * @{inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->application = $this->getApplication()->getApplication();
        $this->fixtureLoader = $this->getContainer()
            ->get('demo.website_loader');

        $this->dataRepository = $this
            ->getBundle()
            ->getBaseDirectory()
            .DIRECTORY_SEPARATOR
            .'Data'
            .DIRECTORY_SEPARATOR
        ;

        $output = new SymfonyStyle($input, $output);
        $output->title('BackBee Demonstration Website Importer');

        $output->progressStart(3);

        $lines = $this->loadFixtures();
        $output->progressAdvance();
        $output->note('✓ Updated BackBee Application');

        $website = $this->updateWebsite();
        $output->progressAdvance();

        $output->note(sprintf('✓ Updated Domain to <info>%s</info> with label </info>%s',
            $website['domain'],
            $website['label']
            )
        );

        $this->importAssets();
        $output->progressAdvance();
        $output->note('✓ Imported pictures assets');

        $output->newline();
        $output->success('Website loaded with success.');
    }

    /**
     * Load fixtures from and SQL dump file.
     *
     * @return int $lines Number of SQL queries executed
     */
    public function loadFixtures()
    {
        $filename = $this->dataRepository
            .'Fixtures'
            .DIRECTORY_SEPARATOR
            .'the_mag.sql'
        ;

        return $this->fixtureLoader->loadFixtures($filename);
    }

    /**
     * Update Website SQL entry according to the BackBee installation.
     *
     * @return array Returns domain and label set up in database
     */
    private function updateWebsite()
    {
        $sites = $this->application->getConfig()->getSection('sites');

        $configuration = [
            'domain' => $sites['blogbee']['domain'],
            'label' => 'backbee',
        ];

        return $this->fixtureLoader->updateWebsite($configuration);
    }

    /**
     * Import Assets into the BackBee application for the Demonstration Website.
     */
    private function importAssets()
    {
        $applicationMediaRepository = $this->application
            ->getDataDir()
            .DIRECTORY_SEPARATOR
            .'Media'
        ;

        $bundleMediaRepository = $this->dataRepository
            .DIRECTORY_SEPARATOR
            .'Media'
        ;

        $this->fixtureLoader->importAssets($applicationMediaRepository, $bundleMediaRepository);
    }
}
