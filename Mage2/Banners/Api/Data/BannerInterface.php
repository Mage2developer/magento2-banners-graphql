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

namespace Mage2\Banners\Api\Data;

/**
 * Interface BannerInterface
 */
interface BannerInterface
{
    /**
     * Banners columns constants
     */
    const BANNERS_ID = 'banners_id';
    const TITLE = 'title';
    const IMAGE = 'image';
    const LINK = 'link';
    const SORT_ORDER = 'sort_order';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';

    /**
     * Get banner identifier
     *
     * @return int
     */
    public function getId();

    /**
     * Set banenr identifier
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get banner title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set banner title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get banner image
     *
     * @return string
     */
    public function getImage();

    /**
     * Set banner image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get a redirection url of banner
     *
     * @return string
     */
    public function getLink();

    /**
     * Set a redirection url on banner
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link);

    /**
     * Get banner sequence
     *
     * @return int
     */
    public function getSortOrder();

    /**
     * Set banner sequence
     *
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Get status of banner is active or not
     *
     * @return int
     */
    public function getIsActive();

    /**
     * Set banner status
     *
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get datetime of banner created
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set banner created datetime
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
