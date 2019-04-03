define([
    "jquery",
    "jquery/ui"
], function ($) {
    'use strict';
    /* set Height for element */

    $.widget('mage.hoverHeight', {
        options: {
            target: '.item'
        },
        _create: function(){
            var $_e = this.element;
            if($_e.length){
                var $listItems = $_e.find(this.options.target);
                var lenLi = $listItems.length;
                var startHeight = 0;
                if(lenLi>1){
                    for(var j=0;j<lenLi;j++){
                        startHeight = $listItems.eq(j).height();

                        $listItems.eq(j).on('mouseenter', function() {
                            var $this = $(this);
                            $this.css("height", "auto"); //Release height

                            var h3 = $this.height();
                            console.log('h3'+h3);
                            var diff = 0;
                            if (h3 < startHeight)
                            {
                                $this.height(startHeight);
                            }
                            else
                            {
                                $this.height(h3);
                                diff = h3 - startHeight;
                            }

                            $this.css("margin-bottom", "-" + diff + "px");

                        }).on('mouseleave', function() {
                            //Clean up
                            var $this = $(this);
                            $this.css("margin-bottom", "");
                            $this.height(startHeight);

                        });
                    }
                }
            }
        }
    });
});


