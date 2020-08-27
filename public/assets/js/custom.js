/*
 * This engine owned and produced by HyipLab studio.
 * Visit our website: https://hyiplab.net/
 */

(function($) {
    "use strict";

    var tpj = jQuery;
    var revapi24;
	
	
  // Preloader //
    jQuery(window).on('load', function() {
        jQuery("#status").fadeOut();
        jQuery("#preloader").delay(350).fadeOut("slow");
    });
	
	
	 // on ready function //
    jQuery(document).ready(function($) {

			function quick_search(){
				'use strict';
				/* Quik search in header on click function */
				var quikSearch = $("#quik-search-btn");
				var quikSearchRemove = $("#quik-search-remove");
				
				quikSearch.on('click',function() {
					$('.dez-quik-search').animate({'width': '100%' });
					$('.dez-quik-search').delay(500).css({'left': '0'  });
				});
				
				quikSearchRemove.on('click',function() {
					$('.dez-quik-search').animate({'width': '0%' ,  'right': '0'  });
					$('.dez-quik-search').css({'left': 'auto'  });
				});	
				/* Quik search in header on click function End*/
			}
			quick_search();
			
			
			
			// Main Slider Animation //

				(function($) {

            //Function to animate slider captions 
            function doAnimations(elems) {
                //Cache the animationend event in a variable
                var animEndEv = 'webkitAnimationEnd animationend';

                elems.each(function() {
                    var $this = $(this),
                        $animationType = $this.data('animation');
                    $this.addClass($animationType).one(animEndEv, function() {
                        $this.removeClass($animationType);
                    });
                });
            }

            //Variables on page load 
            var $myCarousel = $('#carousel-example-generic'),
                $firstAnimatingElems = $myCarousel.find('.carousel-item:first').find("[data-animation ^= 'animated']");

            //Initialize carousel 
            $myCarousel.carousel();

            //Animate captions in first slide on page load 
            doAnimations($firstAnimatingElems);

            //Pause carousel  
            $myCarousel.carousel('pause');


            //Other slides to be animated on carousel slide event 
            $myCarousel.on('click slide.bs.carousel', function(e) {
                var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
                doAnimations($animatingElems);
            });


        })(jQuery);
		
				
        // ===== Scroll to Top ==== // 
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 100) {
                $('#return-to-top').fadeIn(200);
            } else {
                $('#return-to-top').fadeOut(200);
            }
        });
        $('#return-to-top').on('click', function() {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
        });
		
			
			//----- Magnific popup-video -------//

	$('.test-popup-link').magnificPopup({ 
    type: 'iframe',
    iframe: {
        markup: '<div class="mfp-iframe-scaler">'+
            '<div class="mfp-close"></div>'+
            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            '<div class="mfp-title">Some caption</div>'+
            '</div>',
        patterns: {
            youtube: {
                index: 'youtube.com/', 
                id: 'v=',
                src: 'https://www.youtube.com/embed/wPD-UNfbdzc'
            }
        }
    }
    // other options
});


				// testimonial wrapper js //
			$(document).ready(function() {
              $('.testimonial_slider_wrapper .owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
				autoplay:false,
                responsiveClass: true,
				navText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 1,
                    nav: true
                  },
				  1000: {
                    items: 2,
                    nav: true,
					loop: true
                  },
                  1500: {
                    items: 2,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
	
				//----------- investors slider js -------------//
	
	$(document).ready(function() {
              $('.investors_slider_wrapper .owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
				autoplay:true,
				smartSpeed: 1200,
                responsiveClass: true,
				navText : ['<i class="flaticon-left-arrow"></i>','<i class="flaticon-arrow-pointing-to-right"></i>'],
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 2,
                    nav: true
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
			
			
			// --------- testimonial wrapper -------------//
			
		$(document).ready(function() {
              $('.saying_slider .owl-carousel').owlCarousel({
                loop: true,
                margin: 0,
				autoplay:true,
				center: true,
				smartSpeed: 1200,
                responsiveClass: true,
				navText : ['<i class="flaticon-left-arrow"></i>','<i class="flaticon-arrow-pointing-to-right"></i>'],
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 2,
                    nav: true
                  },
                  1000: {
                    items: 3,
                    nav: true,
                    loop: true
                  }
                }
              })
            })
			
			
			
	//----------- payments slider js -------------//
	
	$(document).ready(function() {
              $('.payment_slider_wrapper .owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
				autoplay:true,
				smartSpeed: 1200,
                responsiveClass: true,
				navText : ['<i class="flaticon-left-arrow"></i>','<i class="flaticon-arrow-pointing-to-right"></i>'],
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 2,
                    nav: true
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: true,
                    margin: 20
                  }
                }
              })
            })
	
		
		//-------------------------------------------------------
    // counter-section
    //-------------------------------------------------------
    $('.counter-section').on('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                var $this = $(this);
                $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).off('inview');
        }
    });
	
	
		//-------------------------------------------------------
    // counter-section
    //-------------------------------------------------------
    $('.counter-section2').on('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function () {
                var $this = $(this);
                $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).off('inview');
        }
    });
	
		
		
	//------- Contact Form Submition ---------//
	function checkRequire(formId , targetResp){
		targetResp.html('');
		var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		var url = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
		var image = /\.(jpe?g|gif|png|PNG|JPE?G)$/;
		var mobile = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/;
		var facebook = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
		var twitter = /^(https?:\/\/)?(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/;
		var google_plus = /^(https?:\/\/)?(www\.)?plus.google.com\/[a-zA-Z0-9(\.\?)?]/;
		var check = 0;
		$('#er_msg').remove();
		var target = (typeof formId == 'object')? $(formId):$('#'+formId);
		target.find('input , textarea , select').each(function(){
			if($(this).hasClass('require')){
				if($(this).val().trim() == ''){
					check = 1;
					$(this).focus();
					targetResp.html('You missed out some fields.');
					$(this).addClass('error');
					return false;
				}else{
					$(this).removeClass('error');
				}
			}
			if($(this).val().trim() != ''){
				var valid = $(this).attr('data-valid');
				if(typeof valid != 'undefined'){
					if(!eval(valid).test($(this).val().trim())){
						$(this).addClass('error');
						$(this).focus();
						check = 1;
						targetResp.html($(this).attr('data-error'));
						return false;
					}else{
						$(this).removeClass('error');
					}
				}
			}
		});
		return check;
	}
	$(".submitForm").on("click", function() {
		var _this = $(this);
		var targetForm = _this.closest('form');
		var errroTarget = targetForm.find('.response');
		var check = checkRequire(targetForm , errroTarget);
		if(check == 0){
			var formDetail = new FormData(targetForm[0]);
			formDetail.append('form_type' , _this.attr('form-type'));
			$.ajax({
				method : 'post',
				url : 'ajax.php',
				data:formDetail,
				cache:false,
				contentType: false,
				processData: false
			}).done(function(resp){
				if(resp == 1){
					targetForm.find('input').val('');
					targetForm.find('textarea').val('');
					errroTarget.html('<p style="color:green;">Mail has been sent successfully.</p>');
				}else{
					errroTarget.html('<p style="color:red;">Something went wrong please try again latter.</p>');
				}
			});
		}
	});


// sidebar submenu menu js Start //
		(function($){
	$(document).ready(function(){

	$('#mynavi li.active').addClass('open').children('ul').show();
		$('#mynavi li.has-sub>a').on('click', function(){
			$(this).removeAttr('href');
			var element = $(this).parent('li');
			if (element.hasClass('open')) {
				element.removeClass('open');
				element.find('li').removeClass('open');
				element.find('ul').slideUp(200);
			}
			else {
				element.addClass('open');
				element.children('ul').slideDown(200);
				element.siblings('li').children('ul').slideUp(200);
				element.siblings('li').removeClass('open');
				element.siblings('li').find('li').removeClass('open');
				element.siblings('li').find('ul').slideUp(200);
			}
		});

	});
	})(jQuery);
	
	// sidebar submenu menu js End //
	
	// nice select //
	// 	$('select').niceSelect();


		// ----- datables js -------//
			$(document).ready( function () {
				$('.myTable').DataTable();
			} );
	
	
	
	/*------ Dropify chart Start ------*/
			$(document).ready(function() {

            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('click dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('click dropify.afterClear', function(event, element) {
                alert('File deleted');
            });

            drEvent.on('click dropify.errors', function(event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });	
	/*------------------ Dropify chart End -------------*/


		// ------ cursor js ---------- //
		 var $circleCursor = $('.cursor');

        function moveCursor(e) {
            var t = e.clientX + "px",
                n = e.clientY + "px";

            TweenMax.to($circleCursor, .2, {
                left: t,
                top: n,
                ease: 'Power1.easeOut'
            });
        }
        $(window).on('mousemove', moveCursor);

        // simple zoom
        function zoomCursor(e) {
            TweenMax.to($circleCursor, .1, {
                scale: 3,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).removeClass('cursor-close');
        }
        $('a, .zoom-cursor').on('mouseenter', zoomCursor);

        // close
        function closeCursor(e) {
            TweenMax.to($circleCursor, .1, {
                scale: 3,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).addClass('cursor-close');
        }
        $('.trigger-close').on('mouseenter', closeCursor);

        // default
        function defaultCursor(e) {
            TweenLite.to($circleCursor, .1, {
                scale: 1,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).removeClass('cursor-close');
        }

        $('a, .zoom-cursor, .trigger-close, .trigger-plus').on('mouseleave', defaultCursor);



 });

})(jQuery);	