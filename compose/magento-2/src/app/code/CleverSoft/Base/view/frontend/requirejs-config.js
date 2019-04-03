/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

var config = {
    map: {
        '*': {
            equalHeight : 'CleverSoft_Base/js/equalHeight',
            hoverHeight : 'CleverSoft_Base/js/hoverHeight',
            hoverPrevNext : 'CleverSoft_Base/js/hoverPrevNext',
            OwlCarousel : 'CleverSoft_Base/js/owl.carousel',
            jqueryLazyload : 'CleverSoft_Base/js/jquery.lazyload',
            cleverSwatchRenderer : 'CleverSoft_Base/js/clever-swatch-renderer',
            cleverInnerZoom : 'CleverSoft_Base/js/clever-inner-zoom',
            'magnifier/magnifier' : 'CleverSoft_Base/js/magnifier',
        },
        shim:{
            "OwlCarousel": ["jquery"],
            "jqueryLazyload": ["jquery"]
        }
    }

};