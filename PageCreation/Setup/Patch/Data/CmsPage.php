<?php

declare (strict_types = 1);

namespace Codilar\PageCreation\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CmsPage implements DataPatchInterface
{
    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $pageData = [
            'title' => 'Simple Cms Page', // cms page title
            'page_layout' => '1column', // cms page layout
            'meta_keywords' => 'Codilar Cms Meta Keywords', // cms page meta keywords
            'meta_description' => 'Codilar Cms Meta Description', // cms page meta description
            'identifier' => 'cdcms', // cms page identifier
            'content_heading' => 'Codilar Custom CMS Page', // cms page content heading
            'content' => '<h1>Codilar Custom Cms Page Content</h1>', // cms page content
            'layout_update_xml' => '', // cms page layout xml
            'url_key' => 'cdcms', // cms page url key
            'is_active' => 1, // status enabled or disabled
            'stores' => [0, 1], // You can set store id single or multiple values in array.
            'sort_order' => 0, // cms page sort order
        ];

        $this->moduleDataSetup->startSetup();
        $this->pageFactory->create()->setData($pageData)->save();
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
