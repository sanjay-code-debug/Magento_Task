<?php

namespace Codilar\Stroller\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\ImageFactory;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Phrase;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\StoreManager;
use Psr\Log\LoggerInterface;

/**
 * Class Data
 * @package Codilar\Common\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     *
     */
    CONST HOME_PAGE_ID = 'home';
    /**
     *
     */
    CONST HOME_PAGE_CAHCE_TAG = 'cms_p';
    /**
     * @var $_scopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * @var LoggerInterface
     */
    protected $_logger;
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \Magento\Checkout\Helper\Cart
     */
    protected $_cartHelper;
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollectionFactory;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var StoreManager
     */
    private $storeManager;
    /**
     * @var ImageFactory
     */
    private $imageFactory;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\PageCache\Model\Config
     */
    private $_config;
    /**
     * @var \Magento\CacheInvalidate\Model\PurgeCache
     */
    private $_purgeCache;
    /**
     * @var PageFactory
     */
    private $_pageFactory;

    CONST SEARCH_KEY = '{AWB}';
    /**
     * @var array
     */
    public $trackUrls = [
        'delhivery' => 'https://www.delhivery.com/track/package/{AWB}',
        'dhl' => 'https://app.starshipit.com/track.aspx?code={AWB}',
        'dhlecommerce' => 'https://app.starshipit.com/track.aspx?code={AWB}'
    ];
    /**
     * @var \Magento\Shipping\Helper\Data
     */
    protected $shippingHelper;

    /**
     * Data constructor.
     * @param \Magento\Shipping\Helper\Data $shippingHelper
     */


    /**
     * Data constructor.
     * @param Context                                                    $context
     * @param LoggerInterface                                            $loggerInterface
     * @param PriceCurrencyInterface                                     $priceCurrency
     * @param OrderRepositoryInterface                                   $orderRepository
     * @param ProductRepositoryInterface                                 $productRepository
     * @param StoreManager                                               $storeManager
     * @param ImageFactory                                               $imageFactory
     * @param \Magento\Checkout\Model\Session                            $checkoutSession
     * @param \Magento\Framework\App\Request\Http                        $request
     * @param \Magento\Checkout\Helper\Cart                              $cartHelper
     * @param \Magento\Customer\Model\Session                            $customerSession
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\PageCache\Model\Config                            $config
     * @param \Magento\CacheInvalidate\Model\PurgeCache                  $purgeCache
     * @param PageFactory                                                $pageFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        PriceCurrencyInterface $priceCurrency,
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        StoreManager $storeManager,
        ImageFactory $imageFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Checkout\Helper\Cart $cartHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\PageCache\Model\Config $config,
        \Magento\CacheInvalidate\Model\PurgeCache $purgeCache,
        PageFactory $pageFactory,
        \Magento\Shipping\Helper\Data $shippingHelper

    )
    {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_logger = $loggerInterface;
        $this->priceCurrency = $priceCurrency;
        parent::__construct($context);
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->imageFactory = $imageFactory;
        $this->checkoutSession = $checkoutSession;
        $this->request = $request;
        $this->_cartHelper = $cartHelper;
        $this->customerSession = $customerSession;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_config = $config;
        $this->_purgeCache = $purgeCache;
        $this->_pageFactory = $pageFactory;
        $this->shippingHelper = $shippingHelper;

    }

    /**
     * This function will return category id for home page best sellers
     * @param null
     * @return boolean
     */
    public function getBestSellerCategoryId()
    {
        return $this->_scopeConfig->getValue('feedback/best_sellers/category_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param       $product
     * @param array $excludeAttr
     * @return array
     */
    public function getProductAdditionalData($product, array $excludeAttr = [])
    {
        $data = [];
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = __('N/A');
                } elseif ((string)$value == '') {
                    $value = __('No');
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = $this->priceCurrency->convertAndFormat($value);
                }

                if ($value instanceof Phrase || (is_string($value) && strlen($value))) {
                    $data[$attribute->getAttributeCode()] = [
                        'label' => __($attribute->getStoreLabel()),
                        'value' => $value,
                        'code' => $attribute->getAttributeCode(),
                    ];
                }
            }
        }
        return $data;
    }

    /**
     * @param $orderId
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getOrderDetails($orderId)
    {
        $order = $this->orderRepository->get($orderId);
        return $order;
    }

    /**
     * @param $sku
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductBySku($sku)
    {
        $storeId = $this->getStoreId();
        $product = $this->productRepository->get($sku, false, $storeId);
        return $product;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * @param $id
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductById($id)
    {
        $storeId = $this->getStoreId();
        $product = $this->productRepository->getById($id, false, $storeId);
        return $product;
    }

    /**
     * @return mixed
     */
    public function getTrimmedWebsiteUrl()
    {
        $url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
        $parse = parse_url($url);
        return $parse['host'];
    }

    /**
     * @param $product
     * @return string
     */
    public function getProductThumbnailUrl($product)
    {
        $imageUrl = $this->imageFactory->create()
            ->init($product, 'product_thumbnail_image')->getUrl();
        return $imageUrl;
    }

    /**
     * @return mixed|string
     */
    public function getWebsiteCode()
    {
        return $this->storeManager->getWebsite()->getCode();
    }

    /**
     * @return mixed
     */
    public function getLastOrderId()
    {
        return $this->checkoutSession->getLastRealOrder()->getEntityId();
    }

    /**
     * @return mixed
     */
    public function getIdData()
    {
        return $this->request->getParam('d');
    }

    /**
     * @param $order
     * @return bool
     */
    public function isBankTransferOrder($order)
    {
        return $order->getPayment()->getMethod() == 'banktransfer';
    }

    /**
     * This function will return whether show_in_search product attribute filter is enabled/disabled in minisearch results
     * @param null
     * @return boolean
     */
    public function isFilterEnabledInMinisearch()
    {
        return $this->_scopeConfig->getValue('feedback/show_in_search/module_status_mini_search', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * This function will return whether show_in_search product attribute filter is enabled/disabled in catalogsearch results
     * @param null
     * @return boolean
     */
    public function isFilterEnabledInCatalogsearch()
    {
        return $this->_scopeConfig->getValue('feedback/show_in_search/module_status_catalog_search', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * This function will return whether max_purchase module is enabled/disabled
     * @param null
     * @return boolean
     */
    public function isMaxPurchaseModuleEnabled()
    {
        return $this->_scopeConfig->getValue('feedback/product_inventory/max_sale_qty_status', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * This function will return category id for home page best sellers
     * @param null
     * @return boolean
     */
    public function getProductSaveTriggeronCsvImport()
    {
        return $this->_scopeConfig->getValue('feedback/csv_uploader/category_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    /**
     * This function will return email id
     * @param null
     * @return string
     */
    public function getBankTransferPaymentMethodEmailId()
    {
        return $this->_scopeConfig->getValue('payment/banktransfer/banktransfer_emailid', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * This function will country list
     * @param null
     * @return boolean
     */
    /*public function getSelectedCountryList()
    {
        return $this->_scopeConfig->getValue('codilar_general/customer_registration/enabled_country_list', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }*/

    /**
     * @param $productId
     * @return int
     */
    public function getProductCountInCart($productId)
    {
        try {
            $quote = $this->_cartHelper->getQuote();
            $items = $quote->getAllItems();
            foreach ($items as $item) {
                $cartProductId = $item->getProduct()->getId();
                if ($productId == $cartProductId) {
                    return $item->getQty();
                }
            }
        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }

    /**
     * @param $itemId
     * @return int
     */
    public function getProductId($itemId)
    {
        try {
            $quote = $this->_cartHelper->getQuote();
            $items = $quote->getAllItems();
            foreach ($items as $item) {
                $cartItemId = $item->getId();
                if ($itemId == $cartItemId) {
                    return $item->getProduct()->getId();
                }
            }
        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }

    /**
     * @param $productId
     * @param $fromDate
     * @param $toDate
     * @return int
     */
    public function getProductCountInPreviousOrders($productId, $fromDate, $toDate)
    {
        try {
            if ($this->customerSession->isLoggedIn()) {
                $customerId = $this->customerSession->getCustomerId();
                $time = strtotime($toDate);
                if ($fromDate && $toDate) {
                    $toDate = date('Y-m-d 23:59:59', $time);
                    $orders = $this->_orderCollectionFactory->create()
                        ->addFieldToFilter('customer_id', $customerId)
                        ->addAttributeToFilter('created_at', ['from' => $fromDate, 'to' => $toDate]);
                    if (count($orders)) {
                        $itemCount = 0;
                        foreach ($orders as $order) {
                            $allItems = $order->getAllVisibleItems();
                            foreach ($allItems as $item) {
                                $itemProductId = $item->getProductId();
                                if ($itemProductId == $productId) {
                                    $qty = $item->getQtyOrdered();
                                    $itemCount = $itemCount + $qty;
                                }
                            }
                        }
                        return $itemCount;
                    }
                }
            } else {
                return 0;
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * @param bool $warmHomepage
     * @param null $tags
     */
    public function purgeVarnish($warmHomepage = false, $tags = null)
    {
        try {
            $tags = $this->getDefaultTags($tags);
            if ($this->_config->getType() == \Magento\PageCache\Model\Config::VARNISH && $this->_config->isEnabled()) {
                if (!empty($tags)) {
                    $this->_purgeCache->sendPurgeRequest(implode('|', array_unique($tags)));
                    if ($warmHomepage) {
                        $this->warmHomepagesCache();
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_logger->info("Error in " . __CLASS__ . " - " . $e->getMessage());
        }

    }

    /**
     * @param $tags
     * @return array
     */
    public function getDefaultTags($tags)
    {
        if (is_array($tags) && count($tags)) {
            return $tags;
        }
        /* Get Home page tag by default*/
        $tags = [];
        $homePage = $this->_pageFactory->create()->load(self::HOME_PAGE_ID, 'identifier');
        if ($homePage->getId()) {
            $tags[] = self::HOME_PAGE_CAHCE_TAG . '_' . $homePage->getId();
        }
        return $tags;
    }

    public function warmHomepagesCache()
    {
        $urls = $this->getAllStoreHomeUrls();
        if (count($urls)) {
            foreach ($urls as $url) {
                $this->checkUrl($url);
            }
        }
    }

    /**
     * @return array
     */
    public function getAllStoreHomeUrls()
    {
        $urls = [];
        foreach ($this->getAllStoreIds() as $storeId) {
            $urls[] = $this->scopeConfig->getValue('web/secure/base_url', 'store', $storeId);
            $urls[] = $this->scopeConfig->getValue('web/unsecure/base_url', 'store', $storeId);
        }
        return array_unique($urls);
    }

    /**
     * @return array
     */
    public function getAllStoreIds()
    {
        return array_keys($this->storeManager->getStores(true));
    }

    /**
     * Render the url.
     * @param $url
     */
    private function checkUrl($url)
    {
        $user_agent = 'Mozilla/4.0 (compatible;)';

        $options = array(

            CURLOPT_CUSTOMREQUEST => "GET",        //set request type post or get
            CURLOPT_POST => false,        //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_COOKIEFILE => "cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR => "cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING => "",       // handle all encodings
            CURLOPT_AUTOREFERER => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT => 120,      // timeout on response
            CURLOPT_MAXREDIRS => 4,       // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;

    }
    /**
     * @return bool
     */
    public function isSmkBankTransferPaymentGatewayEnabled()
    {
        $bankTransferEnabled = $this->getConfig('payment/banktransfer/active');
        return $bankTransferEnabled;
    }
    /**
     * @param $config_path
     * @return mixed
     */
    public function getConfig($config_path)
    {
        return $this->_scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * @param $model
     * @return mixed|string
     */
    public function getTrackingPopupUrlBySalesModel($model)
    {
        if (isset($this->trackUrls[$model->getCarrierCode()]) && $trackUrl = $this->trackUrls[$model->getCarrierCode()]) {
            return str_replace($this::SEARCH_KEY, $model->getTrackNumber(), $trackUrl);
        } elseif ($model instanceof \Magento\Sales\Model\Order\Shipment) {
            $track = $model->getTracksCollection()->getFirstItem();
            if (isset($this->trackUrls[$track->getCarrierCode()]) && $trackUrl = $this->trackUrls[$track->getCarrierCode()]) {
                return str_replace($this::SEARCH_KEY, $track->getTrackNumber(), $trackUrl);
            }
        } else {
            return $this->shippingHelper->getTrackingPopupUrlBySalesModel($model);
        }
    }
}

