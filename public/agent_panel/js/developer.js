/*$(document).ready(function() {
	setTimeout(function() {
		$(".alert").alert('close');
	}, 2000);
});*/
$(document).ready(function(){
	//$('.alert').delay(10000).fadeOut(2000);
	//$('.overlay').delay(500).fadeOut(1000);
});
$(document).on('keyup','.numbercheck',function(){
	$(this).val($(this).val().replace(/[a-zA-Z!@#$%^&*()_+=]+/g, ''));
});

function validateMobile(str) {
	/*if (/^\+?([0-9]{2,3})\)?[- ]?([0-9]{5,10})$/.test(str)){return (true);}return (false);*/
	if (/^\+?([0-9]{2,3})\)?[- ]?([0-9]{5,10})$/.test(str)){return (true);}return (false);
}

function validateName(name){
	if (/^(?=.{1,85}$)([a-zA-Z]{1})+([a-zA-Z\s]{0,1})+([ a-zA-Z]{1,85})$/.test(name)){return (true);}return (false);
}

function validateText(text){
	if (/^[a-zA-Z\s]+$/.test(text)){return (true);}return (false);
}
function validateEmail(a) {
	if (/^(?=.{1,80}$)([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9])+$/.test(a)){return (true);}return (false);
}
function CheckStringExist(a) {
	if (a.match(/([a-zA-Z]{3,})+/i)){return (true);}return (false);
}
function validatePassword(password){
	if (/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/.test(password)){return (true);}return (false);
}
function stringMatch(string1,string2){
	if(string1 == string2){return true;}return false;
}
function validatePrice(price){
	if (/^(?=.*[1-9])[0-9]*[.,]?[0-9]{1,2}$/.test(price)){return (true);}return (false);
}
function validateOnlyNumber(number){
	if (/^[0-9]{3}$/gm.test(number)){return (true);}return (false);
}

function numberWithFourLimit(number){
	if (number.match(/^([1-9][0-9]{0,2}|1000)$/gm)){return (true);}return (false);
}

function getErrorText(errorType,field_value){
	error = '';
	field_value = field_value.trim();
	switch(errorType){
		case 'notNull':
		if(field_value == ''){
			error = "This Field is mandatory.";
		}
		break;
		case 'table_name':
		case 'item_name':
		case 'item_code':
		if(field_value == ''){
			error = 'Please enter '+ucwords(errorType.replace('_',' '));
		}
		break;
		case 'email':
		if(field_value == ''){
			error = 'Please enter e-mail address.';
		}else if(!validateEmail(field_value)){
			error = 'Please enter correct e-mail address eg. example@xyz.com.';
		}
		break;
		case 'username':
		case 'name':
		if(field_value == ''){
			error = 'Please enter '+ucwords(errorType.replace('_',' '));
		}else if(!validateName(field_value)){
			error = "Allow only character value max:85 characters.";
		}
		break;
		
		case 'mobile':
		if(field_value == ''){
			error = 'Please enter phone no.';
		}else if(!validateMobile(field_value)){
			error = "Number must be in 7-10 digits.";
		}
		break;

		case 'numberWithFourLimit':
		if(field_value == ''){
			error = "This Field is mandatory.";
		} else if (!numberWithFourLimit(field_value)){
			error = "Number should be in 1-1000 digits.";
		}
		break;

		case 'atleastCharacter':
		if(field_value == ''){
			error = 'This field is mandatory.';
		}else if(!CheckStringExist(field_value)){
			error = "Min. 3 characters is required";
		}
		break;
		
		case 'area':
		case 'category':
		if(field_value == ''){
			error = 'Please select '+ucwords(errorType.replace('_',' '));
		}
		break;	

		case 'price':
		if(field_value == ''){
			error = ucwords(errorType.replace('_',' '))+" is mandatory";
		}else if(!validatePrice(field_value)){
			error = ucwords(errorType.replace('_',' '))+" should be number eg: 1000.99 Or 999";
		}
		break;

		case 'dob':
		if(field_value == ''){
			error = "Date of birth is required";
		}else{
			if(!validateDob($('.'+errorType).val())){
				error = "You cannot select date in the future";
			}
		}
		break;
		
		case 'password':
		if(field_value == ''){
			error = 'Please enter password.';
		}else if(!validatePassword(field_value)){
			error = "Your password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.";
		}
		break;
		
		case 'confirm_password':
		if(field_value == ''){
			error = 'Please enter confirm password.';
		}else if(!stringMatch($('#password').val(),field_value)){
			error = "Password and confirm password should be same.";
		}
		break;
	}
	
	return error;
}
function formValidation(formId, submit){
	$('.error-field').remove();
	error_status = 0;
	$('#' + formId + ' SELECT, #' + formId + ' select, #'+ formId +' input,#'+formId+' input[type="checkbox"], #'+formId+' input[type="password"], #'+formId+' input[type="radio"], #'+formId+' textarea , #'+formId+' input[type="date"]').not('#'+ formId +' input[type=hidden]').each(function(index,value){
		var field = $(this);
		var type = '';
		if ($(this).is(":visible")) {
			$('.overlay').show();
			
			if(field.attr('data-type') != undefined){
				type = field.attr('data-type');
				if (value.tagName == 'SELECT' || value.tagName == 'select'){
					var returnError = getErrorText(type,field.val());
					if(returnError != ''){
						error_status = 1;
						field.addClass('error-highlight');
						field.after('<p class="error-field">'+returnError+'</p>');
						field.addClass('error-field');
					}else{
						field.removeClass('.error-field');
						field.removeClass('error-highlight');
					}
				}else if($(this).attr('type') == 'checkbox'){
					var returnError = getErrorText(type,field.val());
					if(returnError != ''){
						error_status = 1;
						field.parent().append('<p class="error-field">'+returnError+'</p>');
					}else{
						field.parent().find('.error-field').remove();
					}
				}else if($(this).attr('type') == 'radio'){
					field.closest('.gender_box').find('.error-field').remove();
					var returnError = getErrorText(type,field.val());
					if(returnError != ''){
						error_status = 1;
						field.closest('.gender_box').append('<p class="error-field">'+returnError+'</p>');
					}else{
						field.closest('.gender_box').find('.error-field').remove();
					}
				}else{
					type = field.attr('data-type');
					var returnError = getErrorText(type,field.val());
					if(returnError != ''){
						error_status = 1;
						field.addClass('error-highlight');
						field.parent('.form-group').append('<p class="error-field">'+returnError+'</p>');
					}else{
						field.removeClass('error-highlight');
						field.parent().find('.error-field').remove();
					}
				}
			}
		}
	});
	if (error_status == 0 && $("#" + formId + ".error-highlight").length == 0) {
		if (submit == 'submit') {
			$('#' + formId).submit();
		} else {
			return true;
		}
	} else {
		$('.overlay').hide(500);
		return false;
	}
}

$(document).on('input','form input[type="text"],form input[type="number"],form input[type="password"],form input[type="email"]',function(){
	form_type = $(this).closest('form').attr('data-validation');
	if(typeof(form_type) != 'undefined' && $(this).data('type') != 'undefined'){
		$(this).parents('.form-group').find('p').remove();
		returnError = getErrorText($(this).data('type'),$(this).val());
		if(returnError != ''){
			$(this).addClass('error-highlight');
			$(this).parent().append('<p class="error-field">'+returnError+'</p>');
			return false;
		}else{
			$(this).removeClass('error-highlight');
			$(this).parent().find('.error-field').remove();
			return false;
		}
	}
});
$(document).on('change','form select',function(){
	form_type = $(this).closest('form').attr('data-validation');
	if(typeof(form_type) != 'undefined' && $(this).data('type') != 'undefined'){
		$(this).parent().find('p').remove();
		returnError = getErrorText($(this).data('type'),$(this).find(':selected').val());
		if(returnError != ''){
			$(this).addClass('error-highlight');
			$(this).after('<p class="error-field">'+returnError+'</p>');
			return false;
		}else{
			$(this).removeClass('error-highlight');
			$(this).parent().find('.error-field').removeClass('error-field');
			return false;
		}
	}
});

function ucwords(str) {
	return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
		return $1.toUpperCase();
	});
}

function ajaxCall(url,data,beforeAjax,type,dataType){
	/*$(".ajaxlayout,.layout-loader").removeClass('hide-section');*/
	var result = '';
	if(!type){
		type = 'POST';
	}
	if(!dataType){
		dataType = 'json';
	}
	result = $.ajax({
		url:url,
		type:type,
		data:data,
		async: false,
		//enctype: 'multipart/form-data',
		cache : true,
		dataType: dataType,
		beforeSend:function(){
			beforeAjax,
			$('.loader').show()
		},
		success:function(res){
			//$('.search_list').html(res);
			result = res;
		},
		complete:function(){
			$('.loader').hide();
			$(".ajaxlayout,.layout-loader").addClass('hide-section');
		},
		error:function(jqXHR, exception){
			console.log(jqXHR.status)
			var result = '';
			if (jqXHR.status === 0) {
				result = 'Not connect.\n Verify Network.';
			}else if (jqXHR.status == 400) {
				location.reload();
				result = 'Your session has expired. Please login to continue.';
			} else if (jqXHR.status == 404) {
				result = 'Requested page not found. [404]';
			} else if (jqXHR.status == 500) {
				result = 'Internal Server Error [500].';
			} else if (exception == 419) {
				$(document).reload();
				result = 'Session Time Out ';
			} else if (exception == 302) {
				$(document).reload();
				result = 'Session Time Out ';
			} else if (exception === 'parsererror') {
				result = 'Requested JSON parse failed.';
			} else if (exception === 'timeout') {
				result = 'Time out error.';
			} else if (exception === 'abort') {
				result = 'Ajax request aborted.';
			} else {
				result = 'Uncaught Error.\n' + jqXHR.responseText;
			}
			$('.loader').hide();
		}
	}).responseText;
	$(".ajaxlayout,.layout-loader").addClass('hide-section');
	return result;
}

