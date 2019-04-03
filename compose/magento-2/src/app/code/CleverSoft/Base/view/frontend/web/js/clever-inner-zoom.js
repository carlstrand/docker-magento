define([
    "jquery"
], function ($) {
    'use strict';
    /* set Height for element */
    $.widget('mage.cleverInnerZoom', {
        options: {
            target: '.product-item-details'
        },
        _create: function(){

            var subject = $(this.element); /* Get the subject element (AS canvas). */

            var image_obj = jQuery('img', subject);
            var image = image_obj.attr('src');

            $(image_obj).each(function() {

                var image_w = this.width;
                var image_h = this.height;

                /* Fit subject with the width and height of the default image. */
                subject.css('width', image_w).css('height', image_h).css('overflow', 'hidden');

                /* Position the default image. */
                image_obj.css('position', 'relative').css({ top: 0, left: 0 });

                jQuery('a', subject).bind('click onclick', function(event) {
                    event.preventDefault(); /* Disable clicking of a. */
                });

                var image_zoom = jQuery('a', subject).attr('href'); // Get the large image.
                var image_zoom_w = 0;
                var image_zoom_h = 0;

                var image_zoom_obj = new Image() ;
                jQuery(image_zoom_obj).one('load', function() {

                    image_zoom_w = this.width;
                    image_zoom_h = this.height;

                    image_obj.css('max-width', 'none').css('max-height', 'none');

                    /* Bind the subject element with these events. */
                    subject.bind('mousemove mouseout', function(event) {

                        if(event.type == 'mousemove') {
                            /* @start: Will position the mouse inside the canvas only. */
                            var mouse_x = event.pageX - subject.offset().left;
                            var mouse_y = event.pageY - subject.offset().top;
                            /* @end: Will position the mouse inside the canvas only. */

                            var goto_x = (Math.round((mouse_x / image_w) * 100) / 100) * (image_zoom_w - image_w);
                            var goto_y = (Math.round((mouse_y / image_h) * 100) / 100) * (image_zoom_h - image_h);

                            image_obj.css('cursor', 'default').attr('src', image_zoom).css({ left: -goto_x, top: -goto_y });

                        } else if(event.type == 'mouseout') {

                            image_obj.css('cursor', 'default').attr('src', image).css({ top: 0, left: 0 });
                        }
                    });
                });

                jQuery(image_zoom_obj).attr('src', image_zoom);
            });
        }

    });
    return $.mage.cleverInnerZoom;
});


