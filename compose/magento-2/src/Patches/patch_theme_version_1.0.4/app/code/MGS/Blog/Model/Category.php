<?php

namespace MGS\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use MGS\Blog\Model\Resource\Category as CategoryResource;
use MGS\Blog\Model\Resource\Category\Collection;
use MGS\Blog\Helper\Data;

class Category extends AbstractModel
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    protected $storeManager;
    protected $blogHelper;

    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        CategoryResource $resource = null,
        Collection $resourceCollection = null,
        Data $blogHelper,
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->blogHelper = $blogHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_init('MGS\Blog\Model\Resource\Category');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    
    public function addPostFilter($postId)
    {
        $this->getSelect()
            ->join(
                ['category_table' => $this->getTable('mgs_portfolio_category')],
                'main_table.category_id = category_table.category_id',
                []
            )
            ->where('category_table.portfolio_id = ?', $postId);
        return $this;
    }
    
    public function getCategoryUrl()
    {
        $route = $this->blogHelper->getRoute();
        return $route . '/' . $this->getUrlKey();
    }
}
