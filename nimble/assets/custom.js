var wwidth,wheight,nimble;
	nimble = {
		size: function(){
			wwidth = $(window).width();
			var lLogo = $('.logo-align--left').outerWidth();
			$('.l-logo').css({'width': lLogo});
			$('.winw').css({'width': wwidth - lLogo });
			$('.product-slider-width').css({'width': wwidth - 245 });
		},
		ajaxform: function(){
			 ajaxMailChimpForm($("#subscribe-form"), $("#subscribe-result"));
				function ajaxMailChimpForm($form, $resultElement){
					$form.submit(function(e) {
						e.preventDefault();
						if (!isValidEmail($form)) {
							var error =  "A valid email address must be provided.";
							$resultElement.html(error);
							$resultElement.css("color", "red");
						} else {
							$resultElement.css("color", "white");
							$resultElement.html("Subscribing...");
							submitSubscribeForm($form, $resultElement);
						}
					});
				}
				function isValidEmail($form) {
					var email = $form.find("input[type='email']").val();
					if (!email || !email.length) {
						return false;
					} else if (email.indexOf("@") == -1) {
						return false;
					}
					return true;
				}
				 function submitSubscribeForm($form, $resultElement) {
					$.ajax({
						type: "GET",
						url: $form.attr("action"),
						data: $form.serialize(),
						cache: false,
						dataType: "jsonp",
						jsonp: "c",
						contentType: "application/json; charset=utf-8",
						success: function(data){
							if (data.result != "success") {
								var message = data.msg || "Sorry. Unable to subscribe. Please try again later.";
								$resultElement.css("color", "#f04e45");
								if (data.msg && data.msg.indexOf("already subscribed") >= 0) {
									message = "You're already subscribed. Thank you.";
									$resultElement.css("color", "white");
								}
								$resultElement.html(message);
							} else {
								
								$('#mc_embed_signup_scroll').fadeOut();
								$resultElement.css("color", "white");
								setTimeout(function(){
									$resultElement.html("Thank you! Please go to your inbox to confirm.");
								}, 800 );
									
							}
						}
					});
				}
			},
			instafeed: function(){
				var feed = new Instafeed({
				get: 'user',
				userId: '4011811056',
				limit: 5,
				resolution: 'standard_resolution',
				accessToken: '4011811056.3a81a9f.6c653b8cbfbf47a893dfee95a87e3b11',
				template: '<div class="col-one-fifth insta-feed"><a href="{{link}}"><img src="{{image}}" /></a><div class="insta-overlay"><div class="overlay-content"><p class="caption">{{caption}}</p><p class="likes">{{likes}} likes</p></div></div></div>'
			});
			feed.run();
			}
		}


	$(document).ready(function(){
		nimble.size();
		nimble.ajaxform();
		nimble.instafeed();
		$('.question-answer:nth-of-type(1) .question').find('span').addClass('minus');
		$('.question-answer:nth-of-type(1) .answer').addClass('first active');
		$('.question').click(function(){
			if($(this).find('span').hasClass('minus')){
				$(this).find('span').removeClass('minus');
				$(this).parent('.question-answer').find('.answer').removeClass('active').slideUp();
			}else{
				$(this).parent('.question-answer').siblings().find('span').removeClass('minus');
				$(this).parent('.question-answer').siblings().find('.answer').removeClass('active').slideUp();
				$(this).find('span').addClass('minus');
				$(this).parent('.question-answer').find('.answer').addClass('active').slideDown();
			}
		});
      
      // Collapsable menu
      $('.desc-container .description.active').slideDown();
      $('.desc-container h5').click(function(){
          var $this = $(this);
          var $par = $(this).parent();
          if($(this).parent().find('.description').hasClass('active')){
              $this.find('span').removeClass('minus');
              $par.find('.description').removeClass('active').slideUp();                                                            
          }else{
              $('.desc-container h5').parent().find('.description').removeClass('active').slideUp();
              $('.desc-container h5').find('span').removeClass('minus');
              $par.find('.description').addClass('active').slideDown();	
              $this.find('span').addClass('minus');
          }
      });
	  $('.switch-tabs li:nth-of-type(1)').addClass('active');
	  $('.switcher li:nth-of-type(1)').addClass('active');
	  $('.switcher-class:first').addClass('active');
	  $('.size-cm-inches:first').addClass('active');
      $('.switch-tabs li a').click(function(e){
		 e.preventDefault();
		var url = $(this).attr('href');
		var $url = $(url);
		console.log($url);
		$('.switch-tabs li').removeClass('active');
		$(this).parent().addClass('active');
		$('.switcher-class').removeClass('active');
		$url.addClass('active');
		  
	  });
	  $('.switcher li a').click(function(e){
		   e.preventDefault();
		var url = $(this).attr('href');
		var $url = $(url);
		$('.switcher li').removeClass('active');
		$(this).parent().addClass('active');
		$('.size-cm-inches').removeClass('active');
		$url.addClass('active');
	  });
      $(document).on('click','.product-size-guide', function(){
		  $('.size-popup-container').fadeIn();
       var  scrollTop      = $(document).scrollTop();
	   var viewportHeight = $(window).height();
	   var $myDialog      = $('.size-popup-container .size-popup');
        console.log("ScrollTop "+scrollTop+" viewportHeight "+viewportHeight +" $myDialog "+$myDialog);
		$myDialog.css('top',  (scrollTop  + (viewportHeight/2)) - ($myDialog.outerHeight()/2));

	  });
	   $(document).on('click','.size-chart', function(){
		  $('.size-popup-container').fadeIn();
       var  scrollTop      = $(document).scrollTop();
	   var viewportHeight = $(window).height();
	   var $myDialog      = $('.size-popup-container .size-popup');
        console.log("ScrollTop "+scrollTop+" viewportHeight "+viewportHeight +" $myDialog "+$myDialog);
		$myDialog.css('top',  (scrollTop  + (viewportHeight/2)) - ($myDialog.outerHeight()/2));

	  });
	   $('.close-size-popup').click(function(){
		  $('.size-popup-container').fadeOut();
	  });
      $('.minicart-close').click(function(){
       	$('#mini-cart').fadeOut();
      });
	  $('.arrow a').click(function(e){
		  e.preventDefault();
		  var url = $(this).attr('href');
		  var offset = $(url).offset().top;
		  var body = $("html, body");
			body.stop().animate({scrollTop: offset - 100}, '500', 'swing', function() { 
			});
		});
      
      // Scroll 
      $('.product-single__thumbnails li a').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$('.product-single__thumbnails li').removeClass('active');
		$(this).parent('li').addClass('active');
		var offset = $(url).offset().top;
		$('html,body').animate({
			scrollTop: offset
		},500);
	});
	  
	});
	$(window).resize(function(){
		nimble.size();
	});
	$(window).load(function(){
		nimble.size();
	});
	var thumb_org_width = $('#product-thumbnails-wrapper').outerWidth();
	var thumb_org_height = $('#product-thumbnails-wrapper').outerHeight();
	var srcollRightdiv;
	$(window).scroll(function(){
		var sTop = $(window).scrollTop();
		var wHeight = $(window).height();
		//console.log(sTop);
		
		if( sTop > 88){
			$('.fixed-header').addClass('active');
		}else{
			$('.fixed-header').removeClass('active');
		}
		$('.p-zoom').each(function(){
          var secId = $(this).attr('id');
          var hashId = '#'+secId;
          var secOffset = $(hashId).offset().top;
          if(sTop + 170 >=secOffset){
              $(".product-single__thumbnails li").removeClass('active');
              $(".product-single__thumbnails a[href='"+hashId+"']").parent().addClass('active');
          }
		});
        if($(window).width() > 1024){
        // Fixed on scroll
          var dheight = $(document).height();
		  console.log(dheight);
          var rpHeight = $('.simple-collection').height();
		  console.log(rpHeight);
          var footerHeight = $('#shopify-section-footer').height();
          var rightContentHeight = $('.product-right-content').height();
          var leftContentHeight = $('.thumbnails-wrapper').height();
		  //console.log(leftContentHeight);
          var footerTotal = parseInt(rpHeight) + parseInt(footerHeight);
          var scrollTotal = parseInt(sTop) + parseInt(wHeight);
          var heightTotal = parseInt(dheight) - parseInt(footerTotal);
          var heightTotalLeft = parseInt(dheight) - parseInt(footerTotal) - parseInt(leftContentHeight);
		  console.log("Total Height" + heightTotal);
          var absTop = parseInt(heightTotal) - parseInt(wHeight) - parseInt(rightContentHeight);
          var leftabsTop = parseInt(heightTotal) - parseInt(leftContentHeight);
          var totalTop = parseInt(sTop) + parseInt(rightContentHeight);
          var lefttotalTop = parseInt(sTop) + parseInt(leftContentHeight);
			$('.size-popup').css({'top':heightTotal - wHeight + 180 });
			
          if (/products/.test(window.location.href)==true) {
             var thOffset = $('.thumbnails-wrapper').position().top;
          }
          
			
          var totalOffset = parseInt(thOffset) - parseInt(sTop);
			console.log("Thumbnail Offset"+thOffset);
			console.log("Scroll Top" +sTop);
			console.log("Left Total" +lefttotalTop);
			console.log("Total Offset" +totalOffset);
			var headerHeight = $('.site-header').height();
            console.log("header height: "+headerHeight);
            var siteTopNav  = $('#SiteNavLabel-shop').height();
            console.log("Nav height: "+siteTopNav);
            var totalHeaderHeight = headerHeight + siteTopNav;
            console.log("total header height: "+totalHeaderHeight+ " right content height :"+rightContentHeight);
            var currwindowHeight = $(window).height();	
            var remainingWindowHeight = parseInt(currwindowHeight) - parseInt(totalHeaderHeight);
           	var bottomRightContent = parseInt(rightContentHeight) - parseInt(remainingWindowHeight);
          
          
         // console.log('right content height  :'+rightContentHeight);
          console.log('remaining window  :'+remainingWindowHeight);
          console.log("sTop "+sTop + " bottomRightContent "+ bottomRightContent);
          console.log('Total top ' + totalTop+' absTop :'+absTop);
          
          if( heightTotal > totalTop ){
            
           if(sTop < remainingWindowHeight+100){
	                  srcollRightdiv = 320 - sTop;
         
                     $('.product-right-content').css({'position': 'fixed','top': srcollRightdiv ,'width': 350});
               
           }
           else{
                 $('.product-right-content').css({'position': 'fixed','top':  srcollRightdiv-30,'width': 350}); 
           }
            
          }else{
               $('.product-right-content').css({'position': 'absolute','top': absTop+155,'width': 350});
          }
			if( heightTotal  > lefttotalTop+150 ){
				if(sTop < 170){
					$('.thumbnails-wrapper').css({'position': 'fixed','top': 330 - sTop  });
				}else{
					$('.thumbnails-wrapper').css({'position': 'fixed','top': 160  });
				}
			   //$('.thumbnails-wrapper').css({'position': 'fixed','top': headerHeight});
          }else{
               $('.thumbnails-wrapper').css({'position': 'absolute','top': leftabsTop - 230});
          }
		
		}
		
	});


