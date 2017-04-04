$(document).ready(function(){


	$('#login').click(function(){
			
		var email = $('input[name="email"]').val();
		var password = $('input[name="password"]').val();

		$.ajax({

			url:base_url+"login/login",
			type:'post',
			data:{submit:'submit',email:email,password:password},
			beforeSend:function() {
				$('input[type="submit"]').attr('disabled','disabled');
				$('input[type="submit"]').val('Wait..');
			},
			success :function(html){
 			var data = JSON.parse(html);
 			console.log(data);
			$('input[type="submit"]').removeAttr('disabled');
			$('input[type="submit"]').val('login');
			if (data.status=='false') {

				$('.login div.error-message').html(data.msg);
				$('.login div.error-message').slideDown();
				
			} else {

				$('.login div.error-message').slideUp();
				 window.location = base_url+'admin/dashboard';
			}

			}

		});

		return false;
	});




});


function send_notification() {


	$.ajax({

		url:base_url+"auth/send_notification",
		
		type:'post',
		
		data:{},
		
		beforeSend : function(){
			console.log('notification send !');
		},

		success: function(html) {

			console.log(html);
		},

	});



}

//setInterval(send_notification,1000);
