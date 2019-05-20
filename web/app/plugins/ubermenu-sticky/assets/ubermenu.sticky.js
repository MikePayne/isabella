/**
 * UberMenu Sticky
 *
 * Copyright 2012 - 2014 Chris Mavricos, SevenSpark
 */

jQuery( document ).ready(function( $ ){


	if( ubermenu_sticky_settings ){
		for( var config_id in ubermenu_sticky_settings ){
			if( ubermenu_sticky_settings.hasOwnProperty( config_id ) ){

				var is_sticky = ubermenu_sticky_settings[config_id]['is_sticky'] == 1 ? true : false;

				var $uber = $( '.ubermenu-'+config_id );
				var $toggle = $( '.ubermenu-responsive-toggle-'+config_id );
				var $inner = $uber.find( '> .ubermenu-nav' );
				var $tostick = $uber.add( $toggle );

				if( ubermenu_sticky_settings[config_id]['is_mobile'] == 1 ){
					$uber.addClass( 'ubermenu-is-mobile' );
				}

				if( is_sticky ){					

					var full_width = ubermenu_sticky_settings[config_id]['full_width_menu_bar'] == 'on' ? true : false;
					if( full_width ){
						$uber.addClass( 'ubermenu-sticky-full-width' );
						$toggle.addClass( 'ubermenu-sticky-full-width' );
					}

					//If an inner width isn't set, set it to keep things constant
					// if( !full_width && !ubermenu_sticky_settings[config_id]['center_inner_width'] ){
					// 	var inner_width = $inner.width();
					// 	$inner.css( 'width' , inner_width );
					// }

					//If not full width on sticky, but full width normally, 
					//set UberMenu width and toggle width
					if( !full_width ){
						var $fullUber = $uber.filter( '.ubermenu-bar-align-full' );

						$fullUber.each( function(){
							$(this).css( 'width' , $(this).parent().width() );
						});

						$toggle.each( function(){
							$(this).css( 'width' , $(this).parent().width() );
						});

						$(window).ubersmartresize( function(){
							$fullUber.each( function(){
								$(this).css( 'width' , $(this).parent().width() );
							});
							$toggle.each( function(){
								$(this).css( 'width' , $(this).parent().width() );
							});
						});
					}

					//Keep toggle height consistent
					$toggle.css( 'height' , $toggle.outerHeight() );

					
					if( ubermenu_sticky_settings[config_id]['permanent'] ){
						//$tostick.addClass( 'ubermenu-sticky' );
						/*
						$uber.each( function(){
							if( $(this).hasClass( 'ubermenu-bar-align-full' ) ){
								$(this).width( $(this).parent().width() );
							}
						});
						*/
					}
					else{
						var offset = ubermenu_sticky_settings[config_id]['sticky_offset'] ? ubermenu_sticky_settings[config_id]['sticky_offset'] : 0;

						$uber.sticky({
							topSpacing: offset,
							className: 'ubermenu-sticky',
							wrapperClassName: 'ubermenu-sticky-wrapper'
						});

						$uber.on( 'sticky-start sticky-end' , function(){
							setTimeout( function(){ $uber.ubermenu( 'positionSubmenus' ); } , 100 );
						});

						$toggle.sticky({
							topSpacing: offset,
							className: 'ubermenu-sticky',
							wrapperClassName: 'ubermenu-sticky-toggle-wrapper'
						});
					}

				}
				else{

				}
			}
		}
	}
});

// Sticky Plugin v1.0.0 for jQuery
// =============
// Author: Anthony Garand
// Improvements by German M. Bravo (Kronuz) and Ruud Kamphuis (ruudk)
// Improvements by Leonardo C. Daronco (daronco)
// Created: 2/14/2011
// Date: 2/12/2012
// Website: http://labs.anthonygarand.com/sticky
// Description: Makes an element on the page stick on the screen as you scroll
//       It will only set the 'top' and 'position' of your element, you
//       might need to adjust the width in some cases.

(function($) {
	var defaults = {
			topSpacing: 0,
			bottomSpacing: 0,
			className: 'is-sticky',
			wrapperClassName: 'sticky-wrapper',
			center: false,
			getWidthFrom: ''
		},
		$window = $(window),
		$document = $(document),
		sticked = [],
		windowHeight = $window.height(),
		scroller = function() {
			var scrollTop = $window.scrollTop(),
				documentHeight = $document.height(),
				dwh = documentHeight - windowHeight,
				extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

			for (var i = 0; i < sticked.length; i++) {
				var s = sticked[i],
					elementTop = s.stickyWrapper.offset().top,
					etse = elementTop - s.topSpacing - extra;

				if (scrollTop <= etse) {
					if (s.currentTop !== null) {
						s.stickyElement
							.css('position', '')
							.css('top', '');
						s.stickyElement.removeClass(s.className);
						s.stickyElement.trigger('sticky-end', [s]).parent().removeClass(s.className);
						//s.stickyElement.parent().removeClass(s.className);
						s.currentTop = null;
					}
				}
				else {
					var newTop = documentHeight - s.stickyElement.outerHeight() - s.topSpacing - s.bottomSpacing - scrollTop - extra;
					if (newTop < 0) {
						newTop = newTop + s.topSpacing;
					} else {
						newTop = s.topSpacing;
					}
					if (s.currentTop != newTop) {
						s.stickyElement
							.css('position', 'fixed')
							.css('top', newTop);

						// if (typeof s.getWidthFrom !== 'undefined') {			//CJM comment out
						//   s.stickyElement.css('width', $(s.getWidthFrom).width());
						// }

						s.stickyElement.trigger('sticky-start', [s]).parent().addClass(s.className);

						//s.stickyElement.parent().addClass(s.className);
						s.stickyElement.addClass(s.className);
						s.currentTop = newTop;
					}
				}
			}
		},
		resizer = function() {
			windowHeight = $window.height();
		},
		methods = {
			init: function(options) {
				var o = $.extend({}, defaults, options);
				return this.each(function() {
					var stickyElement = $(this);

					var stickyId = stickyElement.attr('id');
					if( !stickyId ) stickyId = stickyElement.data( 'ubermenu-target' )+'-toggle';	//CJM
					var wrapperId = stickyId ? stickyId + '-' + defaults.wrapperClassName : defaults.wrapperClassName;
					var wrapper = $('<div></div>')
						.attr('id', stickyId + '-sticky-wrapper')
						.addClass(o.wrapperClassName);
					stickyElement.wrapAll(wrapper);

					if (o.center) {
						stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
					}

					if (stickyElement.css("float") == "right") {
						stickyElement.css({"float":"none"}).parent().css({"float":"right"});
					}

					var stickyWrapper = stickyElement.parent();
					stickyWrapper.css('min-height', stickyElement.outerHeight());	//CJM height to min-height
					sticked.push({
						topSpacing: o.topSpacing,
						bottomSpacing: o.bottomSpacing,
						stickyElement: stickyElement,
						currentTop: null,
						stickyWrapper: stickyWrapper,
						className: o.className,
						getWidthFrom: o.getWidthFrom
					});
				});
			},
			update: scroller,
			unstick: function(options) {
				return this.each(function() {
					var unstickyElement = $(this);

					var removeIdx = -1;
					for (var i = 0; i < sticked.length; i++) 
					{
						if (sticked[i].stickyElement.get(0) == unstickyElement.get(0))
						{
								removeIdx = i;
						}
					}
					if(removeIdx != -1)
					{
						sticked.splice(removeIdx,1);
						unstickyElement.unwrap();
						unstickyElement.removeAttr('style');
					}
				});
			}
		};

	// should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
	if (window.addEventListener) {
		window.addEventListener('scroll', scroller, false);
		window.addEventListener('resize', resizer, false);
	} else if (window.attachEvent) {
		window.attachEvent('onscroll', scroller);
		window.attachEvent('onresize', resizer);
	}

	$.fn.sticky = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.sticky');
		}
	};

	$.fn.unstick = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method ) {
			return methods.unstick.apply( this, arguments );
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.sticky');
		}

	};
	$(function() {
		setTimeout(scroller, 0);
	});
})(jQuery);