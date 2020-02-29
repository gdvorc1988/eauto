// open modal form
$(".js-header-sign-b").on("click",function(e){
	e.preventDefault();
	$(".js-sign-modal-form").fadeIn(300);
	$(".overlay").fadeIn(300);
});

// button close modal
$(".js-sign-form-close").on("click",function(e){
	e.preventDefault();
	$(".js-sign-modal-form").hide();
	$(".overlay").hide();
});

// tabs on modal form
$(".js-sign-tabs a").on("click",function(e){
	e.preventDefault();
	var active_tab_id = $(this).attr('href');
	
	// switch tab ttl
	$(".js-sign-tabs a").removeClass('tab_nav_active');
	$(this).addClass('tab_nav_active');
	
	// switch tab
	$(".js-modal-tab").removeClass('js-acc-tab-active');
	$(active_tab_id).addClass('js-acc-tab-active');
});

// sign action
$("#js-modal-sign-btn").on("click", function(e){

	e.preventDefault();
	var err=0;
	//var emptyMsgTxt = 'Это поле обязательно для заполнения';
	$("#js-modal-sign-btn").addClass("js-in-process");
	$(".js-general-msg").remove();

	// login check
	if ($("#js-sign-login").val() != ''){
		userLogin = $("#js-sign-login").val();
		$("#js-sign-login").parents(".js-mod-inp").removeClass('js-has-error');
	} else {
		err++;
		$("#js-sign-login").parents(".js-mod-inp").addClass('js-has-error');
		//$("#js-sign-login").parents(".js-mod-inp").children(".js-help_block").text(emptyMsgTxt);
	}

	// password check
	if ($("#js-sign-password").val() != ''){
		userPassword = $("#js-sign-password").val();
		$("#js-sign-password").parents(".js-mod-inp").removeClass('js-has-error');
	} else {
		err++;
		$("#js-sign-password").parents(".js-mod-inp").addClass('js-has-error');
		//$("#js-sign-password").parents(".js-mod-inp").children(".js-help_block").text(emptyMsgTxt);
	}

	if (err == 0){
		$.ajax({
			type: 'POST',
			url: '/local/templates/eauto/ajax.account-sign.php',
			data: {
				login: userLogin,
				password: userPassword
			},
			dataType: "json",
			success: function(result){
				
				if (result.status == true){
					document.location.reload(true);
				} else {
					$("#js-modal-tab-sign").prepend('<div class="js-general-msg">'+result.msg[0]+'</div>');
				}
				$("#js-modal-sign-btn").removeClass("js-in-process");
			},
			error: function(result){
				$("#js-modal-tab-sign").prepend('<div class="js-general-msg">Ошибка отправки запроса.</div>');
				$("#js-modal-sign-btn").removeClass("js-in-process");
			}
		});
	} else {
		$("#js-modal-sign-btn").removeClass("js-in-process");
	}

});


// register action
$("#js-modal-register-btn").on("click", function(e){

	e.preventDefault();
	var err=0;
	//var emptyMsgTxt = 'Это поле обязательно для заполнения';
	//var emainIncorrectTxt = 'Вы указали некорректный Email';
	var agrementMsgTxt = 'Вы не согласились с пользовательским соглашением';

	$("#js-modal-register-btn").addClass("js-in-process");
	$(".js-general-msg").remove();

	// check user name
	if ($("#js-reg-name").val() != ''){
		userName = $("#js-reg-name").val();
		$("#js-reg-name").parents(".js-mod-inp").removeClass('js-has-error');
	} else {
		err++;
		$("#js-reg-name").parents(".js-mod-inp").addClass('js-has-error');
		//$("#js-reg-name").parents(".js-mod-inp").children(".js-help_block").text(emptyMsgTxt);
	}
	
	// check email
	if ($("#js-reg-email").val() != ''){
		emailValid = validateEmail( $("#js-reg-email").val() );
		if (emailValid == true){
			userEmail = $("#js-reg-email").val();
			$("#js-reg-email").parents(".js-mod-inp").removeClass('js-has-error');
		} else {
			err++;
			$("#js-reg-email").parents(".js-mod-inp").addClass('js-has-error');
			//$("#js-reg-email").parents(".js-mod-inp").children(".js-help_block").text(emainIncorrectTxt);	
		}
	} else {
		err++;
		$("#js-reg-email").parents(".js-mod-inp").addClass('js-has-error');
	}

	// password check
	if ($("#js-reg-password").val() != ''){
		userPassword = $("#js-reg-password").val();
		$("#js-reg-password").parents(".js-mod-inp").removeClass('js-has-error');
	} else {
		err++;
		$("#js-reg-password").parents(".js-mod-inp").addClass('js-has-error');
		//$("#js-reg-password").parents(".js-mod-inp").children(".js-help_block").text(emptyMsgTxt);
	}

	// user agrement
	if ($("#js-reg-agree").is(':checked')){
		$("#js-reg-agree").parents(".js-mod-inp").removeClass('js-has-error');
	} else {
		err++;
		$("#js-reg-agree").parents(".js-mod-inp").addClass('js-has-error');
		$("#js-reg-agree").parents(".js-mod-inp").children(".js-help_block").text(agrementMsgTxt);
	}

	if (err == 0){
		
		$.ajax({
			type: 'POST',
			url: '/local/templates/eauto/ajax.account-reg.php',
			data: {
				user_name: userName,
				email: userEmail,
				password: userPassword,
				token: $("#token").val(),
				action: $("#action").val()
			},
			dataType: "json",
			success: function(result){
				if (result.status == true){
					document.location.reload(true);
				} else {
					console.log(result)
					$("#js-modal-tab-reg").prepend('<div class="js-general-msg">'+result.msg[0]+'</div>');
				}
				$("#js-modal-register-btn").removeClass("js-in-process");
			},
			error: function(result){
				$("#js-modal-tab-reg").prepend('<div class="js-general-msg">Ошибка отправки запроса.</div>');
				$("#js-modal-register-btn").removeClass("js-in-process");
			}
		});
	} else {
		$("#js-modal-register-btn").removeClass("js-in-process");
	}

});

var captcha_action = 'user_registration';
     
grecaptcha.ready(function() {
    grecaptcha.execute('6LcOd90UAAAAAPzdpDR-wi50zXzU4XVkEZRQj_t4', {action: captcha_action})
        .then(function(token) {
			if (token) {
                document.getElementById('token').value = token;
            	document.getElementById('action').value = captcha_action;
            }
		});
});