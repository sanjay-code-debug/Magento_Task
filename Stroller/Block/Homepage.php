<?php

namespace Codilar\Stroller\Block;

use Codilar\Stroller\Helper\Data as CommonHelper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Store\Model\ScopeInterface;
/**
 * Class Homepage
 * @package Codilar\Common\Block
 */
class Homepage extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $_resizeImage;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $_productRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $_currency;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;
    /**
     * @var CommonHelper
     */
    private $commonHelper;
    /**
     * @var FormKey
     */
    protected $_formKey;
    /**
     * @var ListProduct
     */
    protected $_listProduct;
    /**
     * @var Serialize
     */
    protected $serialize;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var ListProduct
     */
    private $listProduct;

    /**
     * Homepage constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param ObjectManagerInterface $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Directory\Model\Currency $currency
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param CommonHelper $commonHelper
     * @param \Magento\Catalog\Helper\Image $resizeImage
     * @param FormKey $formKey
     * @param ListProduct $listProduct
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        CommonHelper $commonHelper,
        \Magento\Catalog\Helper\Image $resizeImage,
        FormKey $formKey,
        ListProduct $listProduct,
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        $this->_storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
        $this->_currency = $currency;
        $this->_priceCurrency = $priceCurrency;
        $this->objectManager = $objectManager;
        $this->_productRepository = $productRepository;
        $this->_resizeImage = $resizeImage;
        parent::__construct($context, $data);
        $this->commonHelper = $commonHelper;
        $this->_formKey = $formKey;
        $this->listProduct = $listProduct;
        $this->serialize = $serialize;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $id
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed|null
     */
    public function getProductById($id)
    {
        try{
            $storeId = $this->getStoreId();
            return $this->_productRepository->getById($id,false,$storeId);
        }
        catch (\Exception $e){
            return null;
        }
    }

    /**
     * @param $id
     * @return \Magento\Catalog\Api\Data\ProductInterface|mixed|null
     */
    public function getProductDataById($id)
    {
        try{
            $storeId = $this->getStoreId();
            $product = $this->_productRepository->getById($id,false,$storeId);
            if($product->getStatus() == "1"){
                return $product;
            }
            return null;
        }
        catch (\Exception $e){
            return null;
        }
    }
//    /**
//     * @return mixed
//     */
//    public function getMediaUrl()
//    {
//
//        $media_dir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
//            ->getStore()
//            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
//
//        return $media_dir;
//    }

    /**
     * @param $price
     * @param $currency
     * @return float
     */
    public function getFormatedPrice($price, $currency)
    {
        $price = $this->_priceCurrency->convert($price, null, $currency); //it return price according to current store from base currency
        $precision = 0;
        return $this->_priceCurrency->format(
            $price,
            $includeContainer = true,
            $precision,
            null,
            $currency
        );
    }

    /**
     * @return mixed
     */
    public function getCurrentCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

//    /**
//     * @param $categoryId
//     * @return mixed
//     */
//    public function getCategoryProduct($categoryId)
//    {
//        $category = $this->categoryFactory->create()->load($categoryId)->getProductCollection()->addAttributeToSelect('*');
//        return $category;
//    }

//    /**
//     * @return int
//     */
//    public function getBestSellerCategoryId()
//    {
//        return $this->commonHelper->getBestSellerCategoryId();
//    }

//    /**
//     * @param     $product
//     * @param int $width
//     * @param int $height
//     * @return string
//     */
//    public function getResizeImage($product, $width = 200, $height = 200)
//    {
//        $image_url = $this->_resizeImage->init($product, 'product_page_image_small')->setImageFile($product->getFile())->resize($width, $height)->getUrl();
//        return $image_url;
//    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

//    /**
//     * @return string
//     */
//    public function getFormKey()
//    {
//        return $this->_formKey->getFormKey();
//    }

    public function getCurrencyCode(){
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }

    public function getPriceWithCurrencySymbol($price){
        $precision = 0;
        $currencyCode = $this->getCurrencyCode();
        $currencySymbol = $this->_currency->load($currencyCode)->getCurrencySymbol();
        $formattedPrice = $this->_currency->format($price, ['symbol' => $currencySymbol, 'precision'=> $precision], false, false);
        return $formattedPrice;
    }
//
//    public function getAddToCartUrl($product){
//        return $this->listProduct->getAddToCartUrl($product);
//    }
//
//    public function isProductAddedToCart($productId){
//        $count = $this->commonHelper->getProductCountInCart($productId);
//        if($count > 0){
//            return true;
//        }
//        return false;
//    }

    public function getSliderProducts()
    {
        $productconfig = $this->scopeConfig->getValue('feedback/home/products',ScopeInterface::SCOPE_STORE,$this->getStoreid());

        if($productconfig == '' || $productconfig == null)
            return;

        $unserializedata = $this->serialize->unserialize($productconfig);

        return $unserializedata;
    }

    public function getProductBySku($sku)
    {
        try {
            return $this->_productRepository->get($sku);
        }
        catch (\Exception $e){
            return null;
        }
    }
}
