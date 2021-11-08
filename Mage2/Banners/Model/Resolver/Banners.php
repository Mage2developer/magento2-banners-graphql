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

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Class Banners
 */
class Banners implements ResolverInterface
{
    /**
     * @var BannersDataprovider
     */
    protected $bannersDataprovider;

    /**
     * Banners constructor.
     *
     * @param BannersDataprovider $bannersDataprovider
     */
    public function __construct(
        BannersDataprovider $bannersDataprovider
    ) {
        $this->bannersDataprovider = $bannersDataprovider;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo
        $info,
        array $value = null,
        array $args = null
    ) {
        $this->checkArguments($args);
        return $this->bannersDataprovider->getBanners($args);
    }

    /**
     * Check resolver argument
     *
     * @param array $args
     * @return array
     * @throws GraphQlInputException
     */
    private function checkArguments(array $args): array
    {
        if (!isset($args['is_active'])) {
            throw new GraphQlInputException(__('"is_active should be specified'));
        }

        return $args;
    }
}
