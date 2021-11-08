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

namespace Mage2\Banners\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Config
 */
class Config
{
    /**
     * Admin configuration path constants
     */
    const CONFIG_PATH_ENABLED        = "mage2banner/banners/enabled";
    const CONFIG_PATH_INFINITE_LOOP  = "mage2banner/banners/infinite_loop";
    const CONFIG_PATH_SHOW_BUTTONS   = "mage2banner/banners/show_buttons";
    const CONFIG_PATH_SHOW_DOTS      = "mage2banner/banners/show_dots";
    const CONFIG_PATH_AUTOPLAY       = "mage2banner/banners/autoplay";
    const CONFIG_PATH_AUTOPLAY_SPEED = "mage2banner/banners/autoplay_speed";
    const CONFIG_PATH_PAUSE_ON_HOVER = "mage2banner/banners/pause_on_hover";

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Returns bool value of module enabled or not
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns current store id
     *
     * @return Int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentStoreId(): Int
    {
        return (int) $this->storeManager->getStore()->getId();
    }

    /**
     * Returns value of "infinite" param in slider options
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isInfiniteLoop()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_INFINITE_LOOP,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns value of "arrow" param in slider options
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isShowButtons()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_SHOW_BUTTONS,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns value of "dots" param in slider options
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isShowDots()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_SHOW_DOTS,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns value of "autoplay" param in slider options
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isAutoPlay()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_AUTOPLAY,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns value pf "autoplaySpeed" param in slider options
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAutoPlaySpeed()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_AUTOPLAY_SPEED,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }

    /**
     * Returns value of "pauseOnHover" param in slider options
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isPauseOnHover()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_PAUSE_ON_HOVER,
            ScopeInterface::SCOPE_STORE,
            $this->getCurrentStoreId()
        );
    }
}
