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

namespace Mage2\Banners\Controller\Adminhtml\Banner;

use Mage2\Banners\Controller\Adminhtml\Banner;
use Mage2\Banners\Helper\ImageHelper;
use Mage2\Banners\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Registry;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 */
class MassDelete extends Banner implements HttpPostActionInterface
{
    /**
     * Admin resource for Delete banner
     */
    const ADMIN_RESOURCE = 'Mage2_Banners::delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var string
     */
    protected $imagePath;

    /**
     * @var File
     */
    protected $file;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ImageHelper $imageHelper
     * @param File $file
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ImageHelper $imageHelper,
        File $file
    ) {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->imagePath         = $imageHelper->getBannerUrl();
        $this->file              = $file;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $collection     = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $banner) {
            $oldImagePath = $this->imagePath . $banner->getImage();
            if ($this->file->isExists($oldImagePath)) {
                $this->file->deleteFile($oldImagePath);
            }
            $banner->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
