define([
    "jquery",
    "jquery/ui"
], function ($) {
    'use strict';
    /* set Height for element */
    $.widget('mage.hoverPrevNext', {
        options: {
        },
        _create: function(){
            var $_e = this.element;
            $_e.on('hover',function(){
                $_e.addClass('active');
                $_e.find('.nav-dropdown').show();
            });

            $_e.on('mouseout',function(){
                $_e.removeClass('active');
                $_e.find('.nav-dropdown').hide();
            });
        }


    });
    return $.mage.hoverPrevNext;
});


