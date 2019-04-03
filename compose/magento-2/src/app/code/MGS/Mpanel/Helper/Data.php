<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MGS\Mpanel\Helper;

/**
 * Contact base helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_scopeConfig;
	
	protected $_storeManager;
	
	protected $_date;
	
    protected $_catalogProductVisibility;
	
	protected $_url;

	
	public function __construct(
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Stdlib\DateTime\DateTime $date,
		\Magento\Framework\Url $url,
		\Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
		\Magento\Widget\Helper\Conditions $conditionsHelper,
		\Magento\CatalogWidget\Model\Rule $rule,
		\Magento\Catalog\Model\CategoryFactory $categoryFactory,
		\Magento\Catalog\Model\Design $catalogDesign,
		\Magento\Catalog\Model\Category $category,
		\Magento\Framework\ObjectManagerInterface $objectManager
	) {
		$this->_scopeConfig = $scopeConfig;
		$this->_storeManager = $storeManager;
		$this->_date = $date;
		$this->_url = $url;
		$this->_catalogProductVisibility = $catalogProductVisibility;
		$this->_categoryFactory = $categoryFactory;
		$this->_catalogProductVisibility = $catalogProductVisibility;
		$this->_catalogDesign = $catalogDesign;
		$this->conditionsHelper = $conditionsHelper;
		$this->_category = $category;
		$this->_objectManager = $objectManager;
	}
	
	public function getStore(){
		return $this->_storeManager->getStore();
	}
	
	public function getStoreConfig($node, $storeId = NULL){
		if($storeId != NULL){
			return $this->_scopeConfig->getValue($node, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
		}
		return $this->_scopeConfig->getValue($node, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->getStore()->getId());
	}
	
	public function getThemeSettings(){
		return [
			'catalog'=> 
			[
				'per_row' => $this->getStoreConfig('mpanel/catalog/product_per_row'),
				'featured' => $this->getStoreConfig('mpanel/catalog/featured'),
				'hot' => $this->getStoreConfig('mpanel/catalog/hot'),
				'ratio' => $this->getStoreConfig('mpanel/catalog/picture_ratio'),
				'new_label' => $this->getStoreConfig('mpanel/catalog/new_label'),
				'sale_label' => $this->getStoreConfig('mpanel/catalog/sale_label'),
				'preload' => $this->getStoreConfig('mpanel/catalog/preload'),
				'wishlist_button' => $this->getStoreConfig('mpanel/catalog/wishlist_button'),
				'compare_button' => $this->getStoreConfig('mpanel/catalog/compare_button')
			],
			'product_details'=> 
			[
				'sku' => $this->getStoreConfig('mpanel/product_details/sku'),
				'reviews_summary' => $this->getStoreConfig('mpanel/product_details/reviews_summary'),
				'wishlist' => $this->getStoreConfig('mpanel/product_details/wishlist'),
				'compare' => $this->getStoreConfig('mpanel/product_details/compare'),
				'preload' => $this->getStoreConfig('mpanel/product_details/preload'),
				'short_description' => $this->getStoreConfig('mpanel/product_details/short_description'),
				'upsell_products' => $this->getStoreConfig('mpanel/product_details/upsell_products')
			],
			'product_tabs'=> 
			[
				'show_description' => $this->getStoreConfig('mpanel/product_tabs/show_description'),
				'show_additional' => $this->getStoreConfig('mpanel/product_tabs/show_additional'),
				'show_reviews' => $this->getStoreConfig('mpanel/product_tabs/show_reviews'),
				'show_product_tag_list' => $this->getStoreConfig('mpanel/product_tabs/show_product_tag_list')
			],
			'contact_google_map'=> 
			[
				'display_google_map' => $this->getStoreConfig('mpanel/contact_google_map/display_google_map'),
				'address_google_map' => $this->getStoreConfig('mpanel/contact_google_map/address_google_map'),
				'html_google_map' => $this->getStoreConfig('mpanel/contact_google_map/html_google_map'),
				'pin_google_map' => $this->getStoreConfig('mpanel/contact_google_map/pin_google_map')
			],
			'banner_slider'=> 
			[
				'slider_tyle' => $this->getStoreConfig('mgstheme/banner_slider/slider_tyle'),
				'id_reslider' => $this->getStoreConfig('mgstheme/banner_slider/id_reslider'),
				'identifier_block' => $this->getStoreConfig('mgstheme/banner_slider/identifier_block'),
				'banner_owl_auto' => $this->getStoreConfig('mgstheme/banner_slider/banner_owl_auto'),
				'banner_owl_speed' => $this->getStoreConfig('mgstheme/banner_slider/banner_owl_speed'),
				'banner_owl_loop' => $this->getStoreConfig('mgstheme/banner_slider/banner_owl_loop'),
				'banner_owl_nav' => $this->getStoreConfig('mgstheme/banner_slider/banner_owl_nav'),
				'banner_owl_dot' => $this->getStoreConfig('mgstheme/banner_slider/banner_owl_dot')
			],
			'breadcrumbs_config'=> 
			[
				'breadcrumbs_type' => $this->getStoreConfig('mgstheme/breadcrumbs_config/breadcrumbs_type'),
				'breadcrumbs_color' => $this->getStoreConfig('mgstheme/breadcrumbs_config/breadcrumbs_color'),
				'breadcrumbs_bg' => $this->getStoreConfig('mgstheme/breadcrumbs_config/breadcrumbs_bg'),
				'breadcrumbs_bg_color' => $this->getStoreConfig('mgstheme/breadcrumbs_config/breadcrumbs_bg_color'),
				'breadcrumbs_bg_img' => $this->getStoreConfig('mgstheme/breadcrumbs_config/breadcrumbs_bg_img')
			],
			'blog_config'=>
			[
				'blog_column' => $this->getStoreConfig('mgstheme/blog_config/blog_layout'),
				'blog_img'	=> $this->getStoreConfig('mgstheme/blog_config/blog_img')
				
			],
			'portfolio_config'=>
			[
				'portfolio_layout'=>$this->getStoreConfig('mgstheme/portfolio_config/portfolio_layout'),
				'portfolio_title'=>$this->getStoreConfig('mgstheme/portfolio_config/portfolio_title'),
				'portfolio_column'=>$this->getStoreConfig('mgstheme/portfolio_config/portfolio_column')
			]
			
		];
	}
	
	/* Get col for responsive */
	public function getColClass($perrow = NULL){
		if(!$perrow){
			$settings = $this->getThemeSettings();
			$perrow = $settings['catalog']['per_row'];
		}
		
		switch($perrow){
			case 2:
				return 'col-lg-6 col-md-6 col-sm-6 col-xs-6';
				break;
			case 3:
				return 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
				break;
			case 4:
				return 'col-lg-3 col-md-3 col-sm-6 col-xs-6';
				break;
			case 6:
				return 'col-lg-2 col-md-2 col-sm-3 col-xs-6';
				break;
		}
		return;
	}
	/* Get class clear left */
	public function getClearClass($perrow = NULL, $nb_item){
		if(!$perrow){
			$settings = $this->getThemeSettings();
			$perrow = $settings['catalog']['per_row'];
		}
		$clearClass = '';
		switch($perrow){
			case 2:
				if($nb_item % 2 == 1){
					$clearClass.= " first-row-item row-sm-first row-xs-first";
				}
				return $clearClass;
				break;
			case 3:
				if($nb_item % 3 == 1){
					$clearClass.= " first-row-item row-sm-first";
				}
				if($nb_item % 2 == 1){
					$clearClass.= " row-xs-first";
				}
				return $clearClass;
				break;
			case 4:
				if($nb_item % 4 == 1){
					$clearClass.= " first-row-item";
				}
				if($nb_item % 2 == 1){
					$clearClass.= " row-sm-first row-xs-first";
				}
				return $clearClass;
				break;
			case 6:
				if($nb_item % 6 == 1){
					$clearClass.= " first-row-item";
				}
				if($nb_item % 4 == 1){
					$clearClass.= " row-sm-first";
				}
				if($nb_item % 2 == 1){
					$clearClass.= " row-xs-first";
				}
				return $clearClass;
				break;
		}
		return $clearClass;
	}
	
	/* Get product image size */
	public function getImageSize(){
		$ratio = $this->getStoreConfig('mpanel/catalog/picture_ratio');
		$maxWidth = $this->getStoreConfig('mpanel/catalog/max_width_image');
		$result = [];
        switch ($ratio) {
            // 1/1 Square
            case 1:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth));
                break;
            // 1/2 Portrait
            case 2:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth*2));
                break;
            // 2/3 Portrait
            case 3:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth * 1.5)));
                break;
            // 3/4 Portrait
            case 4:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth * 4) / 3));
                break;
            // 2/1 Landscape
            case 5:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth/2));
                break;
            // 3/2 Landscape
            case 6:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth*2) / 3));
                break;
            // 4/3 Landscape
            case 7:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth*3) / 4));
                break;
        }

        return $result;
	}
	
	/* Get product image size for product details page*/
	public function getImageSizeForDetails() {
		$ratio = $this->getStoreConfig('mpanel/catalog/picture_ratio');
		$maxWidth = $this->getStoreConfig('mpanel/catalog/max_width_image_detail');
        $result = [];
        switch ($ratio) {
            // 1/1 Square
            case 1:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth));
                break;
            // 1/2 Portrait
            case 2:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth*2));
                break;
            // 2/3 Portrait
            case 3:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth * 1.5)));
                break;
            // 3/4 Portrait
            case 4:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth * 4) / 3));
                break;
            // 2/1 Landscape
            case 5:
                $result = array('width' => round($maxWidth), 'height' => round($maxWidth/2));
                break;
            // 3/2 Landscape
            case 6:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth*2) / 3));
                break;
            // 4/3 Landscape
            case 7:
                $result = array('width' => round($maxWidth), 'height' => round(($maxWidth*3) / 4));
                break;
        }

        return $result;
    }
	
	public function getImageMinSize() {
        $ratio = $this->getStoreConfig('mpanel/catalog/picture_ratio');
        $result = [];
        switch ($ratio) {
            // 1/1 Square
            case 1:
                $result = array('width' => 80, 'height' => 80);
                break;
            // 1/2 Portrait
            case 2:
                $result = array('width' => 80, 'height' => 160);
                break;
            // 2/3 Portrait
            case 3:
                $result = array('width' => 80, 'height' => 120);
                break;
            // 3/4 Portrait
            case 4:
                $result = array('width' => 80, 'height' => 107);
                break;
            // 2/1 Landscape
            case 5:
                $result = array('width' => 80, 'height' => 40);
                break;
            // 3/2 Landscape
            case 6:
                $result = array('width' => 80, 'height' => 53);
                break;
            // 4/3 Landscape
            case 7:
                $result = array('width' => 80, 'height' => 60);
                break;
        }

        return $result;
    }
	
	public function getProductLabel($product){
		$html = '';
		$newLabel = $this->getStoreConfig('mpanel/catalog/new_label');
		$saleLabel = "";
		if($this->getStoreConfig('mpanel/catalog/sale_label') == 1){
			$saleLabel = 1;
		}
		// Sale label
		$price = $product->getPrice();
		$finalPrice = $product->getFinalPrice();
		$save = $price - $finalPrice;
		if(($finalPrice<$price) && ($saleLabel!='')){
			$percent = round(($save * 100) / $price);
			$html .= '<span class="product-label sale-label"><span>-'.$percent.'%</span></span>';
		}
		
		// New label
		$now = $this->_date->gmtDate();
		$dateTimeFormat = \Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT;
		$newFromDate1 = $product->getNewsFromDate();
        $newFromDate = date($dateTimeFormat, strtotime($newFromDate1));
        $newToDate1 = $product->getNewsToDate();
        $newToDate = date($dateTimeFormat, strtotime($newToDate1));
		if((!(empty($newToDate1) && empty($newFromDate1)) && ($newFromDate1 < $now) && ($newToDate1 > $now) && $newLabel != '') || ($newLabel != '' && empty($newToDate1) && (!empty($newFromDate1)) && ($newFromDate1 < $now))){
			$html.='<span class="product-label new-label"><span>'.$newLabel.'</span></span>';
		}
		return $html;
	}
	
	//Check if product is in wishlist
	public function getWishlistCount(){
		$wishlist = $this->_wishlistItem->getWishlistItems();
		if(count($wishlist) > 0){
			$ct = count($wishlist);
		}else {
			$ct = 0;
		}
		return $ct;
	}
	
	public function getUrlBuilder(){
		return $this->_url;
	}
	
	public function getCssUrl(){
		return $this->_url->getUrl('mpanel/index/css',['store'=>$this->getStore()->getId()]);
	}
	
	public function getFonts() {
        return [
            ['css-name' => 'Lato', 'font-name' => __('Lato')],
            ['css-name' => 'Open+Sans', 'font-name' => __('Open Sans')],
            ['css-name' => 'Roboto', 'font-name' => __('Roboto')],
            ['css-name' => 'Roboto Slab', 'font-name' => __('Roboto Slab')],
            ['css-name' => 'Oswald', 'font-name' => __('Oswald')],
            ['css-name' => 'Source+Sans+Pro', 'font-name' => __('Source Sans Pro')],
            ['css-name' => 'PT+Sans', 'font-name' => __('PT Sans')],
            ['css-name' => 'PT+Serif', 'font-name' => __('PT Serif')],
            ['css-name' => 'Droid+Serif', 'font-name' => __('Droid Serif')],
            ['css-name' => 'Josefin+Slab', 'font-name' => __('Josefin Slab')],
            ['css-name' => 'Montserrat', 'font-name' => __('Montserrat')],
            ['css-name' => 'Ubuntu', 'font-name' => __('Ubuntu')],
            ['css-name' => 'Titillium+Web', 'font-name' => __('Titillium Web')],
            ['css-name' => 'Noto+Sans', 'font-name' => __('Noto Sans')],
            ['css-name' => 'Lora', 'font-name' => __('Lora')],
            ['css-name' => 'Playfair+Display', 'font-name' => __('Playfair Display')],
            ['css-name' => 'Bree+Serif', 'font-name' => __('Bree Serif')],
            ['css-name' => 'Vollkorn', 'font-name' => __('Vollkorn')],
            ['css-name' => 'Alegreya', 'font-name' => __('Alegreya')],
            ['css-name' => 'Noto+Serif', 'font-name' => __('Noto Serif')]
        ];
    }
	
	public function getLinksFont() {
        $setting = [
			'default_font' => $this->getStoreConfig('mgstheme/fonts/default_font'),
			'h1' => $this->getStoreConfig('mgstheme/fonts/h1'),
			'h2' => $this->getStoreConfig('mgstheme/fonts/h2'),
			'h3' => $this->getStoreConfig('mgstheme/fonts/h3'),
			'h4' => $this->getStoreConfig('mgstheme/fonts/h4'),
			'h5' => $this->getStoreConfig('mgstheme/fonts/h5'),
			'h6' => $this->getStoreConfig('mgstheme/fonts/h6'),
			'price' => $this->getStoreConfig('mgstheme/fonts/price'),
			'menu' => $this->getStoreConfig('mgstheme/fonts/menu'),
		];
        $fonts = [];
        $fonts[] = $setting['default_font'];

        if (!in_array($setting['h1'], $fonts)) {
            $fonts[] = $setting['h1'];
        }

        if (!in_array($setting['h2'], $fonts)) {
            $fonts[] = $setting['h2'];
        }

        if (!in_array($setting['h3'], $fonts)) {
            $fonts[] = $setting['h3'];
        }

        if (!in_array($setting['price'], $fonts)) {
            $fonts[] = $setting['price'];
        }

        if (!in_array($setting['menu'], $fonts)) {
            $fonts[] = $setting['menu'];
        }

        $fonts = array_filter($fonts);
        $links = '';

        foreach ($fonts as $_font) {
			$links .= '<link href="//fonts.googleapis.com/css?family=' . $_font . ':400,300,300italic,400italic,500,600,700,700italic,900,900italic" rel="stylesheet" type="text/css"/>';
        }

        return $links;
    }
	
	// get theme color
    public function getThemecolorSetting($storeId) {
        $setting = [
			'.footer .footer-container .middle-footer .footer-box h4 span:after, .footer .footer-container .middle-footer .contact-box ul li .fa, .header .contact-header .fa, .vertical-menu-home .menu-title, .header .header-v2.sticky-menu .sticky-content .vertical-menu-home .menu-title .icon-vertical,.btn-default:hover, .btn-default:focus,.btn-primary,.btn-primary:hover,.btn-primary:focus,.btn-primary.disabled,
			.btn-primary[disabled],fieldset[disabled] .btn-primary,.btn-primary.disabled:hover,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary:hover,.btn-primary.disabled:focus,.btn-primary[disabled]:focus,fieldset[disabled] .btn-primary:focus,.btn-primary.disabled:active,.btn-primary[disabled]:active,fieldset[disabled] .btn-primary:active,.btn-primary.disabled.active,.btn-primary.active[disabled],fieldset[disabled] .btn-primary.active,.slider_mgs_carousel.owl-theme .owl-dots .owl-dot.active span,.slider_mgs_carousel.owl-theme .owl-dots .owl-dot:hover span,.title-content .title:after,.products-grid .product-content .product-top .icon-links li button:hover,.products-grid .product-content .product-desc .tocart:hover,.owl-carousel .owl-controls .owl-nav > [class*="owl-"]:hover,.custom-owl .brands-grid.owl-carousel .owl-controls .owl-nav > div:hover,.widget-latest .item .go-to-detail:hover,.product-info-main .product-add-form .btn-icon,.product-info-main .product-addto-links a:hover .icon,.product-info-main a.action.mailto.friend:hover .icon,.characters-filter li a:hover,.social-icons > span .stButton .stLarge:hover,.block-title .title > span:after,.pagination li a:hover,.pagination li a:focus,.pagination li.current a,.pagination li.current a:focus,.pagination li.current a:hover,.products-list-mode .product-item .icon-links li button.action:hover,.panel-group .panel .panel-heading:hover,.panel-group .panel .panel-heading.active,.ch-info .ch-info-back,.address-info li .icon,.social-login-options .dropdown-menu a:hover,.checkout-index-index button,.checkout-index-index .opc-progress-bar .opc-progress-bar-item._active > span:before,.checkout-index-index .opc-progress-bar .opc-progress-bar-item._active:before,.checkout-index-index .opc-wrapper .step-title:after,.checkout-index-index .methods-shipping .actions-toolbar button,.blog-post .tags > a:hover,.tab-menu.tabs_categories_portfolio li a.is-checked,.tab-menu.tabs_categories_portfolio li a:hover,.portfolio-content .portfolio-bottom-content.portfolio-box-title a.view:hover,.portfolio-details .title-portfolio span:after,.btn-cart-sm .products-grid .product-content .product-desc .controls .tocart:hover,.icon-horizontal .products-grid .product-content .product-top .icon-links li button:hover,.fotorama .fotorama__arr .fotorama__arr__arr:hover, button.btn-responsive-nav:hover, button.btn-responsive-nav:active, button.btn-responsive-nav:focus,.menu-scroll-block .title-menu, .header-v4 .vertical-menu-button .menu-vertical-btn,.menu-home .title-menu,.checkout-cart-index .shopping-cart-bottom .checkout-methods-items .action.primary.checkout,.desc-center .products-grid .product-content .product-desc .controls .tocart:hover,.promobanner.type1 .btn-default:hover,.promobanner.btn-white .btn-default:hover,.background-date .latest-post-carousel .item .post-info,.scroll-to-top,.footer .social-btn a:hover'=> [
				'background-color'=>  $this->getStoreConfig('color/general/theme_color', $storeId)
			],
			'.btn-default:hover, .btn-default:focus,.btn-primary,.btn-primary:hover,.btn-primary:focus,.btn-primary.disabled,
			.btn-primary[disabled],fieldset[disabled] .btn-primary,.btn-primary.disabled:hover,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary:hover,.btn-primary.disabled:focus,.btn-primary[disabled]:focus,fieldset[disabled] .btn-primary:focus,.btn-primary.disabled:active,.btn-primary[disabled]:active,fieldset[disabled] .btn-primary:active,.btn-primary.disabled.active,.btn-primary.active[disabled],fieldset[disabled] .btn-primary.active,.products-grid .product-content .product-top .icon-links li button:hover,.widget-latest .item .go-to-detail:hover,.brands-grid .brands .brand:hover,.pagination li a:hover,.pagination li a:focus,.pagination li.current a,.pagination li.current a:focus,.pagination li.current a:hover,.panel-group .panel .panel-heading:hover,.panel-group .panel .panel-heading.active,.checkout-index-index button,.checkout-index-index .methods-shipping .actions-toolbar button,.icon-horizontal .products-grid .product-content .product-top .icon-links li button:hover,.fotorama .fotorama__nav-wrap .fotorama__nav__frame.fotorama__active .fotorama__thumb, .search-form .form-search .search-select, .search-form .form-search .search-select #select-cat-dropdown,.mgs-brand-widget .item:hover,.checkout-cart-index .shopping-cart-bottom .checkout-methods-items .action.primary.checkout,.promobanner.type1 .btn-default:hover,.promobanner.btn-white .btn-default:hover,.background-date .latest-post-carousel .item .read-more,.search-form .form-search'=> [
				'border-color'=>  $this->getStoreConfig('color/general/theme_color', $storeId)
			],
			'.color-theme,a:hover, a:focus,.on-wishlist .fa:before,.widget-latest .item .read-more:hover,.widget-latest .item .read-more .fa,.product-info-main .product-info-price .price,.product-info-main .product-addto-links a:hover,.product-info-main a.action.mailto.friend:hover.product-info-main .product-info li a,.owl-top-text .owl-carousel .owl-controls .owl-nav > div:hover,.owl-bottom-text .owl-carousel .owl-controls .owl-nav > div:hover,.sidebar .block.related .block-actions .action.select,.toolbar .left .modes strong.modes-mode,.ch-item .icon,.button-link,.account-nav ul li.current,.testimo-sidebar .testimonial-item .info:after,.blog-post .post-tag .fa,.blog-post .post-tag a:hover,.portfolio-content .portfolio-top-content a.view:hover,.portfolio-content .portfolio-bottom-content.portfolio-box-title .portfolio-name a:hover,.portfolio-details .portfolio-table > tbody > tr > td a,.portfolio-details .portfolio-carousel.owl-carousel .owl-controls .owl-nav > div:hover .fa,.portfolio-details .portfolio-carousel.owl-carousel .owl-controls .owl-nav > div:hover .text, .main-menu ul.nav-main li.active a.level0, .main-menu ul.nav-main li:hover a.level0, .main-menu ul.nav-main li.dropdown a:hover, .main-menu ul.nav-main li.dropdown a:active, .header .top-header-content a:hover, .header .top-header-content .dropdown-menu a:hover, .vertical-menu-home .vertical-menu > li:hover > a, .vertical-menu-home .vertical-menu li.dropdown .dropdown-menu li ul li a:hover , .sidebar .block-blog-tags .tagcloud > span a:hover, .sidebar .block-blog-posts .post-list .item .post-name  a:hover, .main-menu ul.nav-main li a.level0:focus .icon-next, .main-menu ul.nav-main li a.level0:hover .icon-next, .header-v4 .minicart-wrapper .showcart:hover .icon-cart, .header .top-header-content .dropdown-menu li a:hover, .footer .footer-container .middle-footer .twitter_feed .tweet-container a,.product-tab-category .nav-tabs > li:hover a, .product-tab-category .nav-tabs > li.active a, .product-tab-category .nav-tabs > li:hover a::after, .product-tab-category .nav-tabs > li.active a::after,.coming-soon-event .countdown .timer > div > strong, .main-menu ul.nav-main li.active a.level0 .icon-next, .main-menu ul.nav-main li:hover a.level0 .icon-next,.hot-cate ul li > a:hover:after,.testimonials-center .testimonial-container .testimonial-item .info:after'=> [
				'color'=>  $this->getStoreConfig('color/general/theme_color', $storeId)
			],
			'.button-link' => [
				'border-bottom-color'=>  $this->getStoreConfig('color/general/theme_color', $storeId)
			],
			'.checkout-index-index .checkout-container .authentication-wrapper aside.authentication-dropdown' => [
				'border-top-color'=>  $this->getStoreConfig('color/general/theme_color', $storeId)
			],
		];
        $setting = array_filter($setting);
        return $setting;
    }
	
	// get header custom color
    public function getHeaderColorSetting($storeId) {
        $setting = [
            /* Header Top Section */
            '.header .top-header-content' => [
                'background-color' => $this->getStoreConfig('color/header/background_color', $storeId),
                'color' => $this->getStoreConfig('color/header/text_color', $storeId)
            ],
			'.header .top-header-content .dropdown .action' => [
                'color' => $this->getStoreConfig('color/header/text_color', $storeId)
            ],
			'.header .top-header-content a' => [
                'color' => $this->getStoreConfig('color/header/link_color', $storeId)
            ],
			'.header .top-header-content a:hover' => [
                'color' => $this->getStoreConfig('color/header/link_hover_color', $storeId)
            ],
			'.header .top-header-content .dropdown .ui-dialog' => [
                'background-color' => $this->getStoreConfig('color/header/dropdown_background', $storeId)
            ],
			'.header .top-header-content .switcher .switcher-options .ui-widget-content ul.switcher-dropdown li a' => [
                'color' => $this->getStoreConfig('color/header/dropdown_link_color', $storeId)
            ],
			'.header .top-header-content .switcher .switcher-options .ui-widget-content ul.switcher-dropdown li a:hover' => [
                'color' => $this->getStoreConfig('color/header/dropdown_link_hover_color', $storeId)
            ],
			/* Header Middle Section */
			'.middle-header-content' => [
                'background-color' => $this->getStoreConfig('color/header/middle_background', $storeId)
            ],
			/* Top Search Section */
			'#search_mini_form .input-text' => [
                'background-color' => $this->getStoreConfig('color/header/search_input_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_input_border', $storeId),
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId),
            ],
			'.search-form .form-search .search-select,.search-form .form-search .search-select #select-cat-dropdown, .search-form .form-search' => [ 
				'border-color' => $this->getStoreConfig('color/header/search_input_border', $storeId)
			
			],
	
			'#search_mini_form .input-text::-webkit-input-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text:-moz-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text::-moz-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text:-ms-input-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .btn-primary' => [
                'background-color' => $this->getStoreConfig('color/header/search_button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_button_background', $storeId),
                'color' => $this->getStoreConfig('color/header/search_button_text', $storeId)
            ],
			'#search_mini_form .btn-primary:hover' => [
                'background-color' => $this->getStoreConfig('color/header/search_button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_button_background_hover', $storeId),
                'color' => $this->getStoreConfig('color/header/search_button_text_hover', $storeId)
            ],
			/* Top Cart Section */
			'.minicart-wrapper .showcart .icon-cart,.minicart-wrapper .showcart .title-shopbag' => [
                'color' => $this->getStoreConfig('color/header/cart_icon', $storeId)
            ],
			'.minicart-wrapper .showcart .icon-cart .count .counter-number' => [
                'background-color' => $this->getStoreConfig('color/header/cart_number_background', $storeId),
                'color' => $this->getStoreConfig('color/header/cart_number', $storeId)
            ],
			'.minicart-wrapper > .ui-widget-content.dropdown-menu' => [
                'background-color' => $this->getStoreConfig('color/header/cart_dropdown_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/cart_dropdown_border', $storeId),
            ],
			'.minicart-wrapper .ui-widget-content .block-content, .minicart-wrapper .ui-widget-content .block-content .subtitle' => [
                'color' => $this->getStoreConfig('color/header/cart_dropdown_text', $storeId)
            ],
			'.minicart-wrapper .ui-widget-content .block-content a' => [
                'color' => $this->getStoreConfig('color/header/cart_dropdown_link', $storeId)
            ],
			'.minicart-wrapper .ui-widget-content .block-content a:hover' => [
                'color' => $this->getStoreConfig('color/header/cart_dropdown_link_hover', $storeId)
            ],
			'.minicart-wrapper .ui-widget-content .block-content .actions button, .minicart-wrapper .ui-widget-content .block-content .actions .btn' => [
                'background-color' => $this->getStoreConfig('color/header/cart_dropdown_button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/cart_dropdown_button_background', $storeId),
                'color' => $this->getStoreConfig('color/header/cart_dropdown_button_text', $storeId),
            ],
			'.minicart-wrapper .ui-widget-content .block-content .actions button:hover, .minicart-wrapper .ui-widget-content .block-content .actions .btn:hover,
			.minicart-wrapper .ui-widget-content .block-content .actions button:focus, .minicart-wrapper .ui-widget-content .block-content .actions .btn:focus' => [
                'background-color' => $this->getStoreConfig('color/header/cart_dropdown_button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/header/cart_dropdown_button_background_hover', $storeId),
                'color' => $this->getStoreConfig('color/header/cart_dropdown_button_text_hover', $storeId),
            ],
			/* Top Search Section */
			'.search-form .form-search' => [
                'background-color' => $this->getStoreConfig('color/header/search_input_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_input_border', $storeId),
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId),
            ],
			'#search_mini_form .input-text::-webkit-input-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text:-moz-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text::-moz-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'#search_mini_form .input-text:-ms-input-placeholder' => [
                'color' => $this->getStoreConfig('color/header/search_input_text', $storeId)
            ],
			'.search-form .form-search .btn' => [
                'background-color' => $this->getStoreConfig('color/header/search_button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_button_background', $storeId),
                'color' => $this->getStoreConfig('color/header/search_button_text', $storeId)
            ],
			'.search-form .form-search .btn:hover' => [
                'background-color' => $this->getStoreConfig('color/header/search_button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/header/search_button_background_hover', $storeId),
                'color' => $this->getStoreConfig('color/header/search_button_text_hover', $storeId)
            ],
			/* Menu Section */
			'.header .header-menu' => [
                'background-color' => $this->getStoreConfig('color/header/menu_background', $storeId)
            ],
			'nav.nav-main #mainMenu > .level0' => [
                'background-color' => $this->getStoreConfig('color/header/lv1_background', $storeId)
            ],
			'#mainMenu .level0 a.level0,.main-menu ul.nav-main li a.level0,.main-menu ul.nav-main li a.level0 .icon-next' => [
                'color' => $this->getStoreConfig('color/header/lv1_color', $storeId)
            ],
			'nav.nav-main #mainMenu > .level0:hover,.main-menu ul.nav-main li a.level0:hover,.main-menu ul.nav-main li.active a.level0' => [
                'background-color' => $this->getStoreConfig('color/header/lv1_background_hover', $storeId)
            ],
			'nav.nav-main #mainMenu .level0:hover > a, nav.nav-main #mainMenu .level0 > a.ui-state-focus,.main-menu ul.nav-main li a.level0:hover,.main-menu ul.nav-main li a.level0:focus,.main-menu ul.nav-main li.active a.level0,.main-menu ul.nav-main li a.level0:hover .icon-next,.main-menu ul.nav-main li a.level0:focus .icon-next,.main-menu ul.nav-main li.active a.level0 .icon-next' => [
                'color' => $this->getStoreConfig('color/header/lv1_color_hover', $storeId)
            ],
			'nav.nav-main li.level0 ul.dropdown-menu, nav.nav-main #mainMenu .level0 ul.level0, nav.nav-main #mainMenu .level0 ul.level0 li.level1 ul.level1' => [
                'background-color' => $this->getStoreConfig('color/header/menu_dropdown_background', $storeId)
            ],
			'nav.nav-main li.level0 ul.dropdown-menu li a' => [
                'color' => $this->getStoreConfig('color/header/menu_dropdown_link_color', $storeId)
            ],
			'nav.nav-main li.level0 ul.dropdown-menu:hover' => [
                'background-color' => $this->getStoreConfig('color/header/menu_dropdown_background_hover', $storeId)
            ],
			'nav.nav-main li.level0 ul.dropdown-menu > li:hover a' => [
                'color' => $this->getStoreConfig('color/header/menu_dropdown_link_color_hover', $storeId)
            ],
        ];
        $setting = array_filter($setting);
        return $setting;
    }
	
	// get main content custom color
    public function getMainColorSetting($storeId) {
        $setting = [
            /* Text & Link color */
            '.page-main' => [
                'color' => $this->getStoreConfig('color/main/text_color', $storeId)
            ],
			'.page-main a' => [
                'color' => $this->getStoreConfig('color/main/link_color', $storeId)
            ],
			'.page-main a:hover' => [
                'color' => $this->getStoreConfig('color/main/link_color_hover', $storeId)
            ],
			'.page-main .price, .page-main .price-box .price' => [
                'color' => $this->getStoreConfig('color/main/price_color', $storeId)
            ],
			/* Default button color */
            'button, button.btn, button.btn-default' => [
                'color' => $this->getStoreConfig('color/main/button_text', $storeId),
                'background-color' => $this->getStoreConfig('color/main/button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/main/button_border', $storeId)
            ],
			'button:hover, button.btn:hover, button.btn-default:hover' => [
                'color' => $this->getStoreConfig('color/main/button_text_hover', $storeId),
                'background-color' => $this->getStoreConfig('color/main/button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/main/button_border_hover', $storeId)
            ],
			/* Primary button color */
            'button.btn-primary' => [
                'color' => $this->getStoreConfig('color/main/primary_button_text'),
                'background-color' => $this->getStoreConfig('color/main/primary_button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/main/primary_button_border', $storeId)
            ],
			'button.btn-primary:hover' => [
                'color' => $this->getStoreConfig('color/main/primary_button_text_hover', $storeId),
                'background-color' => $this->getStoreConfig('color/main/primary_button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/main/primary_button_border_hover', $storeId)
            ],
			/* Secondary button color */
            'button.btn-secondary' => [
                'color' => $this->getStoreConfig('color/main/secondary_button_text', $storeId),
                'background-color' => $this->getStoreConfig('color/main/secondary_button_background', $storeId),
                'border-color' => $this->getStoreConfig('color/main/secondary_button_border', $storeId)
            ],
			'button.btn-secondary:hover' => [
                'color' => $this->getStoreConfig('color/main/secondary_button_text_hover', $storeId),
                'background-color' => $this->getStoreConfig('color/main/secondary_button_background_hover', $storeId),
                'border-color' => $this->getStoreConfig('color/main/secondary_button_border_hover', $storeId)
            ],
        ];
        $setting = array_filter($setting);
        return $setting;
    }
	
	// get main content custom color
    public function getFooterColorSetting($storeId) {
        $setting = [
            /* Top Footer Section */
            'footer .top-footer' => [
                'background-color' => $this->getStoreConfig('color/footer/top_background_color', $storeId),
                'color' => $this->getStoreConfig('color/footer/top_text_color', $storeId),
                'border-color' => $this->getStoreConfig('color/footer/top_border_color', $storeId)
            ],
			'footer .top-footer label' => [
                'color' => $this->getStoreConfig('color/footer/top_text_color', $storeId)
            ],
			'footer .top-footer h1,footer .top-footer h2,footer .top-footer h3,footer .top-footer h4,footer .top-footer h5,footer .top-footer h6' => [
                'color' => $this->getStoreConfig('color/footer/top_heading_color', $storeId),
            ],
			'footer .footer-container .top-footer a' => [
                'color' => $this->getStoreConfig('color/footer/top_link_color', $storeId),
            ],
			'footer .footer-container .top-footer a:hover' => [
                'color' => $this->getStoreConfig('color/footer/top_link_color_hover', $storeId),
            ],
			'footer .footer-container .top-footer .fa' => [
                'color' => $this->getStoreConfig('color/footer/top_icon_color', $storeId),
            ],
			/* Middle Footer Section */
            '.footer .footer-container .middle-footer' => [
                'background-color' => $this->getStoreConfig('color/footer/middle_background_color', $storeId),
                'color' => $this->getStoreConfig('color/footer/middle_text_color', $storeId),
                'border-color' => $this->getStoreConfig('color/footer/middle_border_color', $storeId)
            ],
			'.footer .footer-container .middle-footer label' => [
                'color' => $this->getStoreConfig('color/footer/middle_text_color', $storeId)
            ],
			'.footer .footer-container .middle-footer .footer-box h4, .footer .footer-container .middle-footer .footer-box h2, .footer .footer-container .middle-footer .footer-box h3, .footer .footer-container .middle-footer .footer-box h5, .footer .footer-container .middle-footer .footer-box h6' => [
                'color' => $this->getStoreConfig('color/footer/middle_heading_color', $storeId),
            ],
			'.footer .footer-container .middle-footer a' => [
                'color' => $this->getStoreConfig('color/footer/middle_link_color', $storeId),
            ],
			'.footer .footer-container .middle-footer a:hover' => [
                'color' => $this->getStoreConfig('color/footer/middle_link_color_hover', $storeId),
            ],
			'.footer .footer-container .middle-footer .fa' => [
                'color' => $this->getStoreConfig('color/footer/middle_icon_color', $storeId),
            ],
			/* Bottom Footer Section */
            '.footer .footer-container .bottom-footer' => [
                'background-color' => $this->getStoreConfig('color/footer/bottom_background_color', $storeId),
                'color' => $this->getStoreConfig('color/footer/bottom_text_color', $storeId),
                'border-color' => $this->getStoreConfig('color/footer/bottom_border_color', $storeId)
            ],
			'.footer .footer-container .bottom-footer label' => [
                'color' => $this->getStoreConfig('color/footer/bottom_text_color', $storeId)
            ],
			'.footer .footer-container .bottom-footer h1,.footer .footer-container .bottom-footer h2,.footer .footer-container .bottom-footer h3,.footer .footer-container .bottom-footer h4,.footer .footer-container .bottom-footer h5,.footer .footer-container .bottom-footer h6' => [
                'color' => $this->getStoreConfig('color/footer/bottom_heading_color', $storeId),
            ],
			'.footer .footer-container .bottom-footer a' => [
                'color' => $this->getStoreConfig('color/footer/bottom_link_color', $storeId),
            ],
			'.footer .footer-container .bottom-footer a:hover' => [
                'color' => $this->getStoreConfig('color/footer/bottom_link_color_hover', $storeId),
            ],
			'.footer .footer-container .bottom-footer .fa' => [
                'color' => $this->getStoreConfig('color/footer/bottom_icon_color', $storeId),
            ],
        ];
        $setting = array_filter($setting);
        return $setting;
    }
	public function getCountRelatedProduct($product) {
		$this->_itemCollection = $product->getRelatedProductCollection()->addAttributeToSelect(
            'required_options'
        )->setPositionOrder()->addStoreFilter();
		$this->_itemCollection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
		$this->_itemCollection->load();
		$countRelated = count($this->_itemCollection);
		return $countRelated;
	}
	public function checkLayoutPage($category) {
		$settings = $this->_catalogDesign->getDesignSettings($category);
		return $settings;
	}
	public function getConditions($conditions)
    {
        if ($conditions) {
            $conditions = $this->conditionsHelper->decode($conditions);
        }
        return $conditions;
    }
	public function getCategory($categoryId) 
	{
		$category = $this->_categoryFactory->create();
		$category->load($categoryId);
		return $category;
	}
	
	public function getCategoryProducts($categoryId) 
	{
		$products = $this->getCategory($categoryId)->getProductCollection();
		$products->addAttributeToSelect('*');
		return $products;
	}

	public function getModel($model)
	{
		return $this->_objectManager->create($model);
	}

	public function getCategories()
	{
		$rootCategoryId = $this->_storeManager->getStore()->getRootCategoryId();
		$categoriesArray = $this->_category
			->getCollection()
			->setStoreId($this->_storeManager->getStore()->getId())
			->addAttributeToSelect('*')
			->addAttributeToFilter('is_active', 1)
			->addAttributeToFilter('include_in_menu', 1)
			->addAttributeToFilter('path', array('like' => "1/{$rootCategoryId}/%"))
			->addAttributeToSort('path', 'asc')
			->load()
			->toArray();
		$categories = array();
		foreach ($categoriesArray as $categoryId => $category) {
			if (isset($category['name'])) {
				$categories[] = array(
					'label' => $category['name'],
					'level' => $category['level'],
					'value' => $categoryId
				);
			}
		}
		return $categories;
	}

	public function getCurrentlySelectedCategoryId()
	{
		$params = $this->getModel('Magento\Framework\App\Request\Http')->getParams();
		if (isset($params['cat'])) {
			return $params['cat'];
		}
		return '';
	}
	public function getClass($column){
		$class='';
		if($column !=''){			
			switch($column){
				case 1:
					$class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
					break;
				case 2:
					$class= 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
					break;
				case 3:
					$class = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
					break;
				case 4:
					$class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
			}
			
		}
		return $class;
	}
	
	public function getCategoryName($product,$baseName,$categories){
		if($categories != null){
			$_catName = $categories->getName();
		}else{
			$cats = $product->getCategoryIds();
			if(count($cats) > 0){
				$j=0; 
				foreach ($cats as $category_id){
					$j++;
					if($j == 2){
						break;
					}
					$category = $this->_categoryFactory->create();
					$category->load($category_id);
					$_catName = $category->getName();
				}
			}else{
				$_catName = $baseName;
			}
		}
		return $_catName;
	}
}