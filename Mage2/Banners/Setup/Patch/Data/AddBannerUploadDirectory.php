<?php
/**
 * Mage2developer
 * Copyright (C) 2021 Mage2developer
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category Mage2developer
 * @package Mage2_Banners
 * @copyright Copyright (c) 2021 Mage2developer
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Mage2developer
 */

declare(strict_types=1);

namespace Mage2\Banners\Setup\Patch\Data;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

/**
 * Class AddBannerUploadDirectory
 */
class AddBannerUploadDirectory implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var File
     */
    protected $io;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * AddBannerUploadDirectory constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param File $io
     * @param DirectoryList $directoryList
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        File $io,
        DirectoryList $directoryList
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->io = $io;
        $this->directoryList = $directoryList;
    }

    /**
     * Get patch version
     *
     * @return string
     */
    public static function getVersion()
    {
        return '1.0.1';
    }

    /**
     * Get module dependencies
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Create "mage2/banners" directory for banners upload in "pub/media" directory
     *
     * @return AddBannerUploadDirectory|void
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->io->mkdir($this->directoryList->getPath('media') . '/mage2/banners', 0755);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get patch aliase
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
