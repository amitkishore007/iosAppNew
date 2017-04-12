$(document).ready(function(){

	// toast initialisation

	toastr.options = {
		"closeButton": false,
		"debug": true,
		"newestOnTop": false,
		"progressBar": false,
		"rtl": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": 300,
		"hideDuration": 1000,
		"timeOut": 5000,
		"extendedTimeOut": 1000,
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

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


	$('.dtable .delete').click(function(){

		var user_id = parseInt($(this).attr('data-delete-user'));
		
		var row = 'row_'+user_id;
		
		var loader = '<img src='+base_url+'assets/images/ajax-loader.gif>';
		
		$.ajax({

				url: base_url+"admin/deleteUser",
				
				type:'post',
				
				data:{'submit':'delete',user_id:user_id},
				
				beforeSend: function() {
					$('tr[data-row='+row+']').addClass('deleteUserOpacity');
					$('span[data-user='+user_id+']').html(loader);
				},
				
				success: function(html) {

					if (html=='success') {

						toastr["success"]("user deleted successfuly !");
						$('tr[data-row='+row+']').fadeOut();

					} else {
					
						toastr["error"]("Could not delete user, try later !");

					}
					$('tr[data-row='+row+']').removeClass('deleteUserOpacity');
				}
		});

		return false;

	});



});


// function send_notification() {


// 	$.ajax({

// 		url:base_url+"auth/send_notification",
		
// 		type:'post',
		
// 		data:{},
		
// 		beforeSend : function(){
// 			console.log('notification send !');
// 		},

// 		success: function(html) {

// 			console.log(html);
// 		},

// 	});



// }

//setInterval(send_notification,1000);
