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
use Mage2\Banners\Model\Banner as BannerModel;
use Mage2\Banners\Model\BannerFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Class Save
 */
class Save extends Banner implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BannerFactory $bannerFactory
     * @param BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        BannerFactory $bannerFactory,
        BannerRepositoryInterface $bannerRepository
    ) {
        $this->dataPersistor    = $dataPersistor;
        $this->bannerFactory    = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data           = $this->getRequest()->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = BannerModel::STATUS_ENABLED;
            }
            if (empty($data['banners_id'])) {
                $data['banners_id'] = null;
            }
            if (isset($data['image']) && is_array($data['image'])) {
                if (!empty($data['image']['delete'])) {
                    $data['image'] = null;
                } else {
                    if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                        $data['image'] = $data['image'][0]['name'];
                    } else {
                        unset($data['image']);
                    }
                }
            }

            $model = $this->bannerFactory->create();

            $id = $this->getRequest()->getParam('banners_id');
            $imageName = "";
            if ($id) {
                try {
                    $model = $this->bannerRepository->getById($id);
                    $imageName = $model->getImage();
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);
            if (!isset($data['image'])) {
                $model->setImage($imageName);
            }

            try {
                $this->bannerRepository->save($model);
                $this->dataPersistor->clear('banners');
                return $this->processBannerReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('banners', $data);
            return $resultRedirect->setPath('*/*/edit', ['banners_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Redirect admin user according to parameter
     *
     * @param BannerRepositoryInterface $model
     * @param array $data
     * @param $resultRedirect
     * @return mixed
     */
    private function processBannerReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $this->messageManager->addSuccessMessage(__('You saved the banner.'));
            $resultRedirect->setPath('*/*/edit', ['banners_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $this->messageManager->addSuccessMessage(__('You saved the banner.'));
            $resultRedirect->setPath('*/*/');
        } elseif ($redirect === 'duplicate') {
            $duplicateModel = $this->bannerFactory->create(['data' => $model->getData()]);
            $duplicateModel->setId(null);
            $duplicateModel->setIsActive(BannerModel::STATUS_DISABLED);
            $this->bannerRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the banner.'));
            $this->dataPersistor->set('banners', $data);
            $resultRedirect->setPath('*/*/edit', ['banners_id' => $id]);
        }
        return $resultRedirect;
    }
}
