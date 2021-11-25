<?php


namespace Codilar\Demo\Model\DataProvider\Brand;

use Codilar\Demo\Model\ResourceModel\BrandsInfo\Collection as Collection;
use Codilar\Demo\Model\ResourceModel\BrandsInfo\CollectionFactory as CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class InfoProvider extends AbstractDataProvider
{
    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Collection
     */
    private $collectionFactory;
    private $storeManagerInterface;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        StoreManagerInterface $storeManagerInterface,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
        $this->storeManagerInterface = $storeManagerInterface;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $id = $this->request->getParam('id');
        $items = $this->collectionFactory->create()->addFieldToFilter('id', $id)->getItems();
        foreach ($items as $item) {
            $brandData = $item->getData();
            $template_img = $brandData['image'];
            unset($brandData['image']);
            $mediaUrl = $this->storeManagerInterface
                ->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                );
            $brandData['image'][0]['name'] = $mediaUrl . '/' . $template_img;
            $brandData['image'][0]['url'] = $mediaUrl . '/' . $template_img;
            $this->loadedData[$item->getId()] = $brandData;
        }
        return $this->loadedData;
    }
}
