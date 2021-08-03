<?php


namespace Codilar\PushNotification\Ui\Component\Listing\Column;

use Codilar\PushNotification\Api\OrderTemplateStoreManagementInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class Thumbnail extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var array
     */
    private $data;
    /**
     * @var OrderTemplateStoreManagementInterface
     */
    private $orderTemplateStoreManagement;

    /**
     * Thumbnail constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param OrderTemplateStoreManagementInterface $orderTemplateStoreManagement
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        OrderTemplateStoreManagementInterface $orderTemplateStoreManagement,
        array $components = [],
        array $data = []
    ) {

        $this->context = $context;
        $this->uiComponentFactory = $uiComponentFactory;
        $this->components = $components;
        $this->urlBuilder = $urlBuilder;
        $this->data = $data;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->orderTemplateStoreManagement = $orderTemplateStoreManagement;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item['store_id'] = $this->orderTemplateStoreManagement
                                            ->getCollection()
                                            ->addFieldToFilter('template_id', $item["template_id"])
                                            ->getColumnValues('store_id');
                $item[$fieldName . '_src'] = $item['logo'];
                $item[$fieldName . '_alt'] = $item['logo'];
                $item[$fieldName . '_orig_src'] = $item['logo'];
            }
        }
        return $dataSource;
    }
}
