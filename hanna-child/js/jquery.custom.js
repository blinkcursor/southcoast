/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery

-----------------------------------------------------------------------------------*/

;(function($) {
	"use strict";

	$(document).ready(function($) {

		/* --------------------------------------- */
		/* Nav
		/* --------------------------------------- */
		var $window = $(window),
			$siteHeader = $('.site-header'),
			$siteContent = $('.site-content');

		positionHeader();

		$window.scroll(function() {
		    var $this = $(this),
		        pos   = $this.scrollTop();
		    if(pos > 20){
		        $siteHeader.addClass('shrinkit');
		    } else {
		        $siteHeader.removeClass('shrinkit');
		    }
		    positionHeader();
		});

		$window.on('resize', function() {
			positionHeader();
		});

		function positionHeader() {
			if( $window.width() > 768 ) {
				$siteHeader.css({position : 'fixed'});
				$siteContent.css({
					marginTop : $siteHeader.outerHeight() + 1
				});
			} else {
			  	$siteHeader.css({position : 'relative'});
		    	$siteContent.css({marginTop : 0});
			}
		}

		/* --------------------------------------- */
		/* Custom header
		/* --------------------------------------- */
		var $media = $('.portfolio-media-feature');

		$media.imagesLoaded( function() {
			if( $media.height() > $window.height() - $siteHeader.outerHeight() ) {
				$media.css({
					height: $window.height() - $siteHeader.outerHeight(),
					overflow: 'hidden'
				}).find('img').addClass('center-image');
			}
		});

		var $entryHeader = $('.single-post .format-standard .entry-thumbnail');

		$entryHeader.imagesLoaded( function() {
			if( $entryHeader.height() > $window.height() - $siteHeader.outerHeight() ) {
				$entryHeader.css({
					height: $window.height() - $siteHeader.outerHeight(),
					overflow: 'hidden'
				}).find('img').addClass('center-image');
			}
		});


		/* --------------------------------------- */
		/* ZillaMobileMenu & Superfish
		/* --------------------------------------- */
		$('#primary-menu,#kontiki-menu')
			.zillaMobileMenu({
				breakPoint: 768,
				hideNavParent: true,
				onInit: function( menu ) {
					$(menu).removeClass('zilla-sf-menu primary-menu');
				}
			})
			.superfish({
		    		delay: 0,
		    		animation: {opacity:'show'},
		    		animationOut:  {opacity:'hide'},
		    		speed: 100,
		    		cssArrows: false,
		    		disableHI: true
			});

		/* --------------------------------------- */
		/* Cycle - Slideshow media
		/* --------------------------------------- */
		if( $().cycle ) {
			var $sliders = $('.slideshow');
			$sliders.each(function() {
				var $this = $(this);

				$this.cycle({
					autoHeight: 0,
					slides: '> .slide',
					swipe: true,
					timeout: 4000,
					speed: 1000,
					updateView: 1
				});

				if( $('body').hasClass('single-post') ) {
					$this.on('cycle-update-view', function(e,o,sh,cs) {
						var $cs = $(cs);

						$(this).animate({
							height: $cs.height()
						}, 300);
					});
				}
			});
		}

		/* --------------------------------------- */
		/* Isotope
		/* --------------------------------------- */
		if( $().isotope ) {
			var $container = $('.isotope-container');
			if($container.length) {
				$container.imagesLoaded( function() {
					$container.isotope({
						itemSelector: '.post',
						layoutMode: 'masonry',
						stamp: '.archive-header'
					});
				});
			}

			var $portfolioContainer = $('.portfolio-feed');
			if($portfolioContainer.length) {
				$portfolioContainer.imagesLoaded( function() {
					$portfolioContainer.isotope({
						itemSelector: '.type-portfolio',
						layoutMode: 'fitRows',
						stamp: '.portfolio-hr',
						hiddenStyle: {
							opacity: 0
						},
						visibleStyle: {
							opacity: 1
						}
					});
				});

				$('.portfolio-type-nav a').on('click', function(e) {
					e.preventDefault();
					$portfolioContainer.isotope({
						filter: $(this).attr('data-filter')
					});
					$('.portfolio-type-nav a').removeClass('active');
					$(this).addClass('active');
				});
			}
		}

		var infinite_count = 0;

		$( document.body ).on( 'post-load', function () {
			// New posts have been added to the page.
			infinite_count = infinite_count + 1;

			var $elements = $('#infinite-view-' + infinite_count).find('.post');

			$elements.imagesLoaded( function() {
				$container.isotope('insert', $elements);
			});
		});

		/* --------------------------------------- */
		/* Responsive media - FitVids
		/* --------------------------------------- */
		if( $().fitVids ) {
			$('#content').fitVids();
		} /* FitVids --- */

		/* --------------------------------------- */
		/* Comment Form
		/* --------------------------------------- */
		var $commentform = $('#commentform');
		if ( $commentform.length ) {
			var commentformHeight = $commentform.height(),
				$cancelComment = $('#cancel-comment');

			$commentform.css({
				height : 55,
				overflow : 'hidden'
			}).on('click', function() {
				var $this = $(this);
				$this.animate({
					height : commentformHeight,
					overflow : 'visible'
				}, 500);

				$cancelComment.on('click', function(e) {
					e.preventDefault();

					$this.animate({
						height : 55,
						overflow : 'hidden'
					}, 500);

					return false;
				});
			});
		}

	});

})(window.jQuery);