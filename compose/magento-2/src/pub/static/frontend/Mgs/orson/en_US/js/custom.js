require([
	'jquery'
], function(jQuery){
	(function($) {
		$.noConflict();
		$(document).ready(function(){
			var $width_mega_content;
			if($(window).width() >= 992 ){
				if($('header .header-menu .col-md-9').hasClass('width-menu')){
					$width_mega_content = $('.width-menu').width();
					$width_mega_content_1 = Math.round($width_mega_content + 20);
					$('.vertical-menu-home .mega-menu-fullwidth .mega-menu-content').css('width', $width_mega_content_1 + 'px');
					
				}else{
					$width_mega_content = $('.col-md-9').width();
					$width_mega_content_1 = Math.round($width_mega_content + 10);
					$('.vertical-menu-home .mega-menu-fullwidth .mega-menu-content').css('width',$width_mega_content_1 + 'px');
										
				}
				$width_mega_btn = $('.col-md-12').width();
				$width_mega_btn_content= Math.round($width_mega_btn - 270);
				$('.vertical-menu-home.vertical-menu-button .mega-menu-fullwidth .mega-menu-content').css('width',$width_mega_btn_content + 'px');
				
			}
			if($(window).width() < 992){
				$('.header-v2 .vertical-menu-home .menu-title').click(function(){
					if($('.header-v2 .vertical-menu-home .menu-content').hasClass('show-vertical')){
						$('.header-v2 .vertical-menu-home .menu-content').removeClass('show-vertical');
					}else{
						$('.header-v2 .vertical-menu-home .menu-content').addClass('show-vertical');
					}
				});
				$('.vertical-menu-home .menu-content .fa-times').click(function(){
					$('.vertical-menu-home .menu-content').removeClass('show-vertical');
				});
			}
			
			$('.vertical-menu-button .menu-vertical-btn').click(function(){
					if($('.vertical-menu-button .menu-content').hasClass('dropdown-vertical')){
						
						$('.vertical-menu-button .menu-content').removeClass('dropdown-vertical');
					}else{
						$('.vertical-menu-button .menu-content').addClass('dropdown-vertical');
					}
				});
			//
			if(!$('body').hasClass('cms-index-index')){
				$('.vertical-menu-home .menu-title').click(function(){
					if($('.vertical-menu-home .menu-content').hasClass('show-content')){
						$('.vertical-menu-home .menu-content').removeClass('show-content');
					}else{
						$('.vertical-menu-home .menu-content').addClass('show-content');
					}
					
				});
			}
			//
			
			//
			$(window).scroll(function(){
				if($(this).scrollTop() > 200 & $(this).width() > 991 ){	
					
					$('.header .sticky-menu .minicart-wrapper').addClass('sticky-element');
					$('.header .sticky-menu .header-sticky').addClass('sticky-content');					
					$('.header .sticky-menu .sticky-navigation').addClass('sticky-element');
					$('.header-v2.sticky-menu .logo').addClass('sticky-element');
					$('.header .sticky-menu .sticky-logo').addClass('sticky-element');
					
					
					var $container_width = $('.header .container').width();
					var $sticky_navigation = Math.round((75 * $container_width)/100);	
					var $width_col3 = Math.round((25 * $container_width)/100); 					
					$('.header-v1.sticky-menu .header-menu .sticky-navigation').css('width',$sticky_navigation + 'px');
					var $body_width = $('body').width();
					var $width_logo = $('.middle-header-content .logo').width();
					var $position_menuv1 = Math.round(($body_width - $container_width)/2 + $width_col3);
					$('.header-v1.sticky-menu .header-menu .sticky-navigation').css('left',$position_menuv1 + 'px');
					//$('.header-v1.sticky-menu .header-menu .sticky-navigation .main-menu').css('float','right');
					var $position_cart = Math.round(($body_width - $container_width)/2 - 35);
					$('.header .sticky-menu .minicart-wrapper').css('right',$position_cart + 'px');
					$('.header .sticky-menu .sticky-logo').css('width',$width_col3 + 'px');
				}else{									
					$('.header .sticky-menu .minicart-wrapper').removeClass('sticky-element');
					$('.header .sticky-menu .header-sticky').removeClass('sticky-content');
					$('.header .sticky-menu .sticky-navigation').removeClass('sticky-element');
					$('.header-v2.sticky-menu .logo').removeClass('sticky-element');
					$('.header .sticky-menu .sticky-logo').removeClass('sticky-element');
					
					$('.header-v1.sticky-menu .header-menu .sticky-navigation').css('width','');
					$('.header-v1.sticky-menu .header-menu .sticky-navigation').css('left','');
					$('.header .sticky-menu .minicart-wrapper').css('right','');
					//$('.header-v1.sticky-menu .header-menu .sticky-navigation .main-menu').css('float','');
					$('.header .sticky-menu .sticky-logo').css('width','');
					
				}
			});
			//
			$(".panel-group .panel .panel-heading").click(function(){
				$(".panel-group .panel .panel-heading").removeClass('active');
				if($(this).hasClass('active')){
					$(this).removeClass('active');
				}else {
					$(this).addClass('active');
				}
			});
			//
			$(".cms-index-index .tocart").click(function(){
				$(this).find('.fa').removeClass('fa-shopping-cart');
				$(this).find('.fa').addClass('fa-spinner fa-pulse');
                $(this).find('span.text').text('Adding...');
				$(this).addClass('btn-primary disabled');
			});
			
			//
			$('.mega-menu-item ul.dropdown-menu .level1 .toggle-menu .fa-plus,.vertical-menu .level1 .dropdown-submenu .toggle-menu .fa-plus,.mega-menu-fullwidth.static-menu .level1 .toggle-menu .fa-plus').click(function(){
				$(this).parent().siblings('ul').slideDown('fade');		
				$(this).addClass('hide-plus');
				$(this).siblings('.fa-minus').addClass('show-minus');
			});
			//
			$('.mega-menu-item ul.dropdown-menu .level1 .toggle-menu .fa-minus, .vertical-menu .level1 .dropdown-submenu .toggle-menu .fa-minus,.mega-menu-fullwidth.static-menu .level1 .toggle-menu .fa-minus').click(function(){
				$(this).parent().siblings('ul').slideUp('fade');
				$(this).siblings('.fa-plus').removeClass('hide-plus');
				$(this).removeClass('show-minus');
			});
			//
			$('.static-menu .dropdown-submenu .toggle-menu .fa-plus').click(function(){
				$(this).parent().siblings('ul').slideDown('fade');
				$(this).addClass('hide-plus');
				$(this).siblings('.fa-minus').addClass('show-minus');
			});
			
			$('.static-menu .dropdown-submenu .toggle-menu .fa-minus').click(function(){
				$(this).parent().siblings('ul').slideUp('fade');
				$(this).siblings('.fa-plus').removeClass('hide-plus');
				$(this).removeClass('show-minus');
			});
			$('.main-menu .fa-times').click(function(){
				$('.main-menu').removeClass('in');
			});
			
			
			//
			$(".desc-center .products-grid .product-content .product-desc").each(function( index ) {
				if(!$(this).find('.prar .product-reviews-summary').hasClass('empty')){
					$(this).find('.prar').addClass('has-rate');
				}
			});
			if($('.tabs_categories_portfolio_content').hasClass('portfolio-wide')){
				
				$('.portfolio-category-view').addClass('portfolio-layout-wide');
			}
		});
		$(window).load(function(){
			setTimeout(hiddenAlert, 4000);
		});
	})(jQuery);
});
function hiddenAlert() {
    require([
        'jquery'
    ], function (mgsjQuery) {
        (function () {
            mgsjQuery('.cms-index-index .page-main > .page.messages').slideUp();
        })(jQuery);
    });
}
function setLocation(url) {
    require([
        'jquery'
    ], function (jQuery) {
        (function () {
            window.location.href = url;
        })(jQuery);
    });
}
function sliderBanner(element) {
    require([
		'jquery',
		'mgs/owlcarousel'
	], function ($) {
		var owl = $(element);
		owl.owlCarousel({
			items: 1,
			autoPlay: false,
			stopOnHover: false,
			nav: true,
			navText: ["<i class='fa fa-arrow-left'></i>&nbsp;<span class='text'>BACK</span>","<span class='text'>NEXT</span>&nbsp;<i class='fa fa-arrow-right'></i>"],
			dots: false,
			responsive:{ 0 : {items: 1}, 480 : {items: 1}, 768 : {items: 1}, 991 : {items: 1}, 1200 : {items: 1} }
		});
	});
}
function countdown(yr, m, d, hr, min) {
    require([
        'jquery'
    ], function (jQuery) {
        (function () {
            var montharray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
			theyear = yr;
			themonth = m;
			theday = d;
			thehour = hr;
			theminute = min;
			var today = new Date();
			var todayy = today.getYear();
			if (todayy < 1000)
				todayy += 1900;
			var todaym = today.getMonth();
			var todayd = today.getDate();
			var todayh = today.getHours();
			var todaymin = today.getMinutes();
			var todaysec = today.getSeconds();
			var todaystring = montharray[todaym] + " " + todayd + ", " + todayy + " " + todayh + ":" + todaymin + ":" + todaysec;
			var futurestring = montharray[m - 1] + " " + d + ", " + yr + " " + hr + ":" + min + ":" + "00";
			var dd = Date.parse(futurestring) - Date.parse(todaystring);
			var dday = Math.floor(dd / (60 * 60 * 1000 * 24) * 1);
			var dhour = Math.floor((dd % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
			var dmin = Math.floor(((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
			var dsec = Math.floor((((dd % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);
			if (dday <= 0 && dhour <= 0 && dmin <= 0 && dsec <= 0) {
				document.getElementById('timer-text').style.display = "none";
				document.getElementById('timer-table').style.display = "none";
			}
			if (dday == 0 && dhour == 0 && dmin == 0 && dsec == 0) {
				
			} else {
				document.getElementById('count2').style.display = "none";
				document.getElementById('dday').innerHTML = dday;
				document.getElementById('dhour').innerHTML = dhour;
				document.getElementById('dmin').innerHTML = dmin;
				document.getElementById('dsec').innerHTML = dsec;
				setTimeout("countdown(theyear,themonth,theday,thehour,theminute)", 1000);
			}
        })(jQuery);
    });
}