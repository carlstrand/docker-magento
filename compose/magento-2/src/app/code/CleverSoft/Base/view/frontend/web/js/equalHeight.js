define([
    "jquery",
    "jquery/ui"
], function ($) {
    'use strict';
    /* set Height for element */
    $.widget('mage.equalHeight', {
        options: {
            target: '.product-item-details'
        },
        _create: function(){
            var $_e = this.element;
            if($_e.length){
                var $_maxHeight= 0;
                var $listItems = $_e.find(this.options.target);
                var lenLi = $listItems.length;
                $listItems.css('height', '');
                if(lenLi>0){
                    for(var j=0;j<lenLi;j++){
                        $_maxHeight = Math.max($_maxHeight, $listItems.eq(j).outerHeight());
                    }
                }
                window._maxHeight = $_maxHeight;
                $listItems.css('height', $_maxHeight + 'px');
            }
        }


    });
    return $.mage.equalHeight;
});


