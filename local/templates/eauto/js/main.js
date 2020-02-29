// search title
$(".js-search-form-submit").on("click",function(e){
	e.preventDefault();
	$("#header-search-form").submit();
});

// logout
$(".js-logout").on("click",function(e){
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: '/local/templates/eauto/ajax.account-sign.php?logout=true',
		data: {},
		dataType: "json",
		success: function(result){
			if (result.status == true){
				document.location.reload(true);
			}
		}
	});
});

// search page form
$(".js-sform-submit").on("click",function(){
	$(".search-page form").submit();
});

// email validate
function validateEmail(email) {
	var pattern  = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return pattern .test(email);
}

// phone validate
function validatePhone(phone) {
	var re = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
	return re.test(phone);
}

// Favorites
$(document).ready(function() {
    
    $('.favor').on('click', function(e) {
        var favorID = $(this).attr('data-item');
        if($(this).hasClass('active'))
            var doAction = 'delete';
        else
            var doAction = 'add';

        addFavorite(favorID, doAction);
    });
});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function addFavorite(id, action){
	var param = 'id='+id+"&action="+action;
	$.ajax({
		url:     '/local/templates/eauto/ajax.favorites.php',
		type:     "GET",
		dataType: "html",
		data: param,
		success: function(response) {
			var result = $.parseJSON(response);
			if(result.action == 1){
				 $('.favor[data-item="'+id+'"]').addClass('active');
				 var wishCount = parseInt($('#want .fv-count').html()) + 1;
					$('#want .fv-count').html(wishCount);
				if (wishCount > 0){
					$('#want .fv-count').addClass('fv-count-active');
				 }
			}
			if(result.action == 2){
				 $('.favor[data-item="'+id+'"]').removeClass('active');
				 var wishCount = parseInt($('#want .fv-count').html()) - 1;
				 $('#want .fv-count').html(wishCount);
				 if (wishCount == 0){
					$('#want .fv-count').removeClass('fv-count-active');
				 }
			}
			if (typeof result.favorites != 'undefined'){
				setCookie('favorites', result.favorites, 7);
			}
		},
		error: function(jqXHR, textStatus, errorThrown){
			console.log('Error: '+ errorThrown);
		}
	 });
}