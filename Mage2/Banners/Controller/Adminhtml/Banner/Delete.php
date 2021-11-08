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

use Mage2\Banners\Api\BannerRepositoryInterface;
use Mage2\Banners\Controller\Adminhtml\Banner;
use Mage2\Banners\Helper\ImageHelper;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Registry;

/**
 * Class Delete
 */
class Delete extends Banner implements HttpPostActionInterface
{
    /**
     * Admin resource for Delete banner
     */
    const ADMIN_RESOURCE = 'Mage2_Banners::delete';

    /**
     * @var BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @var string
     */
    protected $imagePath;

    /**
     * @var File
     */
    protected $file;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param BannerRepositoryInterface $bannerRepository
     * @param ImageHelper $imageHelper
     * @param File $file
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        BannerRepositoryInterface $bannerRepository,
        ImageHelper $imageHelper,
        File $file
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->imagePath        = $imageHelper->getBannerUrl();
        $this->file             = $file;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id             = $this->getRequest()->getParam('banners_id');
        if ($id) {
            try {
                $model        = $this->bannerRepository->getById($id);
                $oldImagePath = $this->imagePath . $model->getImage();
                if ($this->file->isExists($oldImagePath)) {
                    $this->file->deleteFile($oldImagePath);
                }
                $this->bannerRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the banner.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['banners_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
