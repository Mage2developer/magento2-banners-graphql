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

namespace Mage2\Banners\Model\Resolver;

use Mage2\Banners\Helper\ImageHelper;
use Mage2\Banners\Model\Config;
use Mage2\Banners\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class BannersDataprovider
 */
class BannersDataprovider
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var Config
     */
    protected $bannerConfig;

    /**
     * BannersDataprovider constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param ImageHelper $imageHelper
     * @param Config $bannerConfig
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ImageHelper $imageHelper,
        Config $bannerConfig
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->imageHelper       = $imageHelper;
        $this->bannerConfig      = $bannerConfig;
    }

    /**
     * Get active banners list
     *
     * @param $args
     * @return array
     * @throws NoSuchEntityException
     */
    public function getBanners($args)
    {
        $items = [];

        try {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('is_active', $args['is_active'])
                ->setOrder('sort_order', 'ASC');

            $totalCount = $collection->getSize();

            if ($totalCount > 0) {
                foreach ($collection as $banner) {
                    $data          = $banner->getData();
                    $data['image'] = $this->imageHelper->getBannerBaseUrl() . $data['image'];
                    array_push($items, $data);
                }
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__($e->getMessage()), $e);
        }

        $bannersData                = $this->getAdminConfiguration();
        $bannersData['total_count'] = $totalCount;
        $bannersData['items']       = $items;

        return $bannersData;
    }

    /**
     * Get banner admin configuration
     *
     * @return array
     */
    public function getAdminConfiguration()
    {
        return [
            'is_enabled'     => $this->bannerConfig->isEnabled(),
            'infinite_loop'  => $this->bannerConfig->isInfiniteLoop(),
            'show_buttons'   => $this->bannerConfig->isShowButtons(),
            'show_dots'      => $this->bannerConfig->isShowDots(),
            'autoplay'       => $this->bannerConfig->isAutoPlay(),
            'autoplay_speed' => $this->bannerConfig->getAutoPlaySpeed(),
            'pause_on_hover' => $this->bannerConfig->isPauseOnHover(),
        ];
    }
}
