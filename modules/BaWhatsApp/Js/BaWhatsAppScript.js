$(function(){
    var module = app.getModuleName();
    var view = app.getViewName();
    if(module == "Contacts" && view == "Detail" ){
        var baWhatsAppModal = '<div class="modal fade" id="ba_custom_whatsapp_modal" tabindex="-1" role="dialog" aria-labelledby="ba_custom_whatsapp_modal" aria-hidden="true">  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">      <div class="modal-content">            <div class="modal-header">      <h5 class="modal-title" id="ba_whatsapp_modal_header"> Message Box </h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close">    <span aria-hidden="true">&times;</span>         </button>      </div>     <div class="modal-body " id="ba_whatsapp_modal_body" >     </div>  </div> </div> </div>';
        $('body').append( baWhatsAppModal );
        $('.detailViewButtoncontainer .btn-group:first').prepend('<span id="ba-whatsapp-icon" class="btn btn-default markStar"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg> </span>');
    }
});

// Show modal with chat layout 
$(document).on('click' , '#ba-whatsapp-icon' , function(){
    var record = $('#recordId').val();
	app.helper.showProgress();
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        data: { 'record_id': record },
        url: 'index.php?module=BaWhatsApp&view=MessageBox',
        success: function(response){
            if(response.number != ''){
                $('#ba_custom_whatsapp_modal').modal('show');    
                $('#ba_whatsapp_modal_body').html(response.html);
            	loadMessages();
            	setTimeout(function(){
           			$('#ba-message-list').animate({scrollTop: $('#ba-message-list').prop('scrollHeight')},'fast');
                	
                },1000);
            	app.helper.hideProgress();
            } else {
                $('.detailViewButtoncontainer').prepend('<span id="ba_whatsapp_empty_number" style="float: left;color: red;position: fixed;width: 300px;"> Please add a mobile number for start the chat </span>');        
                setTimeout( function (){
                    $('#ba_whatsapp_empty_number').remove();
                }, 3000);
            }
        }

    });
});

// Send message
$(document).on('click', '#ba_send_message' , function(){
    var content = $('#message_content').val();
    var target = $('#ba_whatsapp_target_number').val();

    if( content == ''){
        return false;
    }

    app.helper.showProgress();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {
            'content': content,
            'target': target,
        },
        url: 'index.php?module=BaWhatsApp&action=SendMessage',
        success: function(response){
            var failedStyle = '';
            if(response.result){
                var monthArray=['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                var date = new Date();               
                var d = date.getDate();
                var day = (d <= 9 ? '0' + d : d)
                var month = monthArray[date.getMonth()];
                var year = date.getFullYear();
                var hour = date.getHours() <= 9 ? '0' + date.getHours() : date.getHours();
                var minute = date.getMinutes() <= 9 ? '0' + date.getMinutes() : date.getMinutes();
                var datestring = hour +':'+ minute +' | '+ month + ', ' + day ;
                
            } else {
                datestring = '<span title="Please check the configuration" style="cursor: pointer; color: red;" > Failed </span>'; 
            }
            $(".chat").append("<div class='chat-bubble me'><div class='my-mouth'></div><div class='content'>" + content + "</div><div class='time' >" + datestring + "</div></div>");
            $('#message_content').val('');
            app.helper.hideProgress();
        }

    });
});


// Save portal configuratoin
$(document).on('click' , '#save_portal_config' , function(){
    var token = $('#access_token').val();
    var url = $('#portal_url').val();
    var number = $('#phone_number').val();
    if(token != '' && url != '' && number != ''){
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                'token': token,
                'portal_url': url,
                'number': number,
            },
            url: 'index.php?module=BaWhatsApp&action=SavePortalConfig',
            success: function(response){
                if(response.result){
                    $('#ba_config_alert').removeClass('hide');
                    setTimeout(function(){
                        $('#ba_config_alert').addClass('hide');
                    }, 3000);
                }
            }
        });
    } else {
        if( token == ''){
            $('#access_token').after('<p  style="color: red;" class="small ba_empty_field_alert"> Please fill the input fields.</p>')
        }
        if(url == ''){
            $('#portal_url').after('<p  style="color: red;" class="small ba_empty_field_alert"> Please fill the input fields.</p>')
        }
        if(number == ''){
            $('#portal_url').after('<p  style="color: red;" class="small ba_empty_field_alert"> Please fill the input fields.</p>')
        }

        setTimeout(function(){
            $('.ba_empty_field_alert').remove();
        }, 2500);
        return false;
    }
});

// Get templates
$(document).on('click' , '#ba-fetch-templates' , function(){
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: 'index.php?module=BaWhatsApp&action=FetchTemplates',
        success: function(response){
            if(response){
                $('#response_result').html('<span style="color: green;position: absolute;padding: 5px;"> Template(s) saved successfully. </span>')
            } else {
                $('#response_result').html('<span style="color: red; position: absolute;padding: 5px;"> Please check the configuration. </span>')
            }
            setTimeout(function(){
                $('#response_result').fadeOut();
            }, 3000);
        }
    });
});

// Add field to the text area content
$(document).on('click', '#ba-add-ield' , function(){
    var field = $('#ba-contact-field').val();
    var content = $('#ba-message-content').val();
    if(field)
        $('#ba-message-content').val(content +' '+ '$contacts-'+ field + '$ ') ;
});

$(document).on('change' , '#ba_contact', function(){
    var number = $(this).val();
    $('#ba-recepients').val(number);
});


// Load messages after scroll
function loadMessages(){
	$('#ba-message-list').scroll(function() {
	  	if($(this).scrollTop() == 0 ) {	
		    var oldMessagePosition = this.scrollHeight;
			var target = $('#ba_whatsapp_target_number').val();
			var nextPage = $('#ba-current-page').val();
		    // Show Loading icon with messages 
			var progressIndicatorElement = jQuery.progressIndicator({
					'message' : 'Loading old messages',
					'position' : 'html',
					'blockInfo' : {
						'enabled' : true
						},
					});
		    $.ajax({
		        type: 'GET',
        		dataType: 'JSON',
		        data: { 'number': target, 'page': nextPage },
		        url: 'index.php?module=BaWhatsApp&view=MessageBox&operation=loadMessages',
        		success: function(response){
		        	nextPage ++ ;
		        	$('#ba-message-list').prepend(response.html);
        			var height = $('#ba-message-list').prop('scrollHeight')
					var currentPosition = height - oldMessagePosition ; 
		        	$('#ba-message-list').animate({scrollTop: currentPosition} , 'fast');
		        	$('#ba-current-page').val(nextPage);
	    		    app.helper.hideProgress();
		        }
    		});
		}
	});
}