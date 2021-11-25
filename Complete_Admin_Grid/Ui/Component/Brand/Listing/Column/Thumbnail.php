<?php

namespace Codilar\Demo\Ui\Component\Brand\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    private $url;
    private $storeManagerInterface;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $url,
        StoreManagerInterface $storeManagerInterface,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->url = $url;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    public function prepareDataSource(array $dataSource)
    {

        $mediaUrl = $this->storeManagerInterface
            ->getStore()
            ->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );

        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_src'] = $mediaUrl . '/' . $item['image'];
                $item[$fieldName . '_alt'] = $item['image'];
                $item[$fieldName . '_orig_src'] = $mediaUrl . '/' . $item['image'];
            }
        }
        return $dataSource;
    }
}
