/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
jQuery(document).ready(function(){

	jQuery('.submit-question').on('click', function(){
		jQuery('#question-form-container').toggle('slow');
	})

	jQuery('#question-form-container #nickname_field').on('blur', function(){
		kuzValidateFaqFormNickName();
	});
	
	jQuery('#question-form-container #question_field').on('blur', function(){
		kuzValidateFaqFormQuestion();
	});
	
	jQuery("#submitButtonId").click(function() {
		if(kuzValidateFaqFormNickName() && kuzValidateFaqFormQuestion()){
		    var url = baseurl+"question/index/saveQuestion"; 
		    var nickname =jQuery("#nickname_field").val();
		    var question =jQuery("#question_field").val();
	        var product_id =jQuery("#product_id_field").val();
	        var product_name =jQuery("#product_name_field").val();
		    jQuery.ajax({
		           type: "POST",
		           url: url,
		           dataType: 'json',
		           async: false,
		           data: {isAjax:1, nickname:nickname, question:question, product_id:product_id, product_name:product_name},
		           error: function(data){
			        	jQuery('.productfaq_ajax_loader').hide();  
			        	alert(data.message);
               		},
		           success: function(data)
		           {	
		        	   jQuery('.productfaq_ajax_loader').hide();
		        	   alert(data.message);
		        	   jQuery('#question-form-container').hide('slow');
		           },
		           beforeSend: function(){
               		jQuery('.productfaq_ajax_loader').show();
               	}
		         });
	
		    return false;
		}
	});

	jQuery(function() {
		jQuery( "#accordion" ).accordion();
		 });

});

function kuzValidateFaqFormNickName(){
	var nickName = jQuery('#question-form-container #nickname_field').val();
	
	if(nickName == ''){
		jQuery('#question-form-container #nickname_field').addClass('validation-failed');
		jQuery('#question-form-container .input-box.nick').addClass('validation-error');
		if(!jQuery('#question-form-container .input-box.nick .validation-advice').length){
			jQuery('#question-form-container .input-box.nick').append('<div id="advice-required-entry-' + jQuery('#question-form-container #nickname_field').attr('id') + '" class="validation-advice">This is a required field.</div>');
		}
		return false;
	}else{
		jQuery('#question-form-container #nickname_field').parent().removeClass('validation-error');
		jQuery('#question-form-container #nickname_field').parent().addClass('validation-passed');
		jQuery('#question-form-container #nickname_field').parent().find('#advice-required-entry-' + jQuery('#question-form-container #nickname_field').attr('id')).remove();
		jQuery('#question-form-container #nickname_field').removeClass('validation-failed');
		jQuery('#question-form-container #nickname_field').addClass('validation-passed');
		
		return true;
	}
}
function kuzValidateFaqFormQuestion(){
	var question = jQuery('#question-form-container #question_field').val();
	
	if(question == ''){
		jQuery('#question-form-container #question_field').addClass('validation-failed');
		jQuery('#question-form-container .input-box.quest').addClass('validation-error');
		if(!jQuery('#question-form-container .input-box.quest .validation-advice').length){
			jQuery('#question-form-container .input-box.quest').append('<div id="advice-required-entry-' + jQuery('#question-form-container #question_field').attr('id') + '" class="validation-advice">This is a required field.</div>');
		}
		return false;
	}else{
		jQuery('#question-form-container #question_field').parent().removeClass('validation-error');
		jQuery('#question-form-container #question_field').parent().addClass('validation-passed');
		jQuery('#question-form-container #question_field').parent().find('#advice-required-entry-' + jQuery('#question-form-container #question_field').attr('id')).remove();
		jQuery('#question-form-container #question_field').removeClass('validation-failed');
		jQuery('#question-form-container #question_field').addClass('validation-passed');
		
		return true;
	}
}
