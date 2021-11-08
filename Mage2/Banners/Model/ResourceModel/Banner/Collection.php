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

namespace Mage2\Banners\Model\ResourceModel\Banner;

use Magento\Cms\Model\ResourceModel\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'banners_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'banners_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'banners_collection';

    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_init(\Mage2\Banners\Model\Banner::class, \Mage2\Banners\Model\ResourceModel\Banner::class);
    }

    /**
     * Add store filter
     *
     * @param array|int|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this|Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);
        return $this;
    }
}
