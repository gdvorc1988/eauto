// clear basket
function selectDelivery() {
	var id = $('input[name="delivery_id"]:checked').val();
	if (id > 0) {
		$(".js-dlv-prop").removeClass("dlvp-active");
		$("#dlvp_" + id).addClass("dlvp-active");
	}
}

selectDelivery();

$(".js-dlv-checkbox").on("change", function (e) {
	e.preventDefault();
	selectDelivery();
});


// check form inputs
$(".js-confirm-order").on("click", function (e) {
	e.preventDefault();
	var err_cnt = 0;
	var form_data = {};
	var delivery_id = $('input[name="delivery_id"]:checked').val();
	var comments = '';
	var position = null;

	// person name
	if ($("#prop_1").val() != '') {
		$("#prop_1").removeClass('error');
		form_data[$("#prop_1").attr('name')] = $("#prop_1").val();
	} else {
		$("#prop_1").addClass('error');
		err_cnt++;
		position = (position == null ? $("#prop_1").position() : position);
	}


	// person email
	if ($("#prop_2").val() != '' && validateEmail($("#prop_2").val())) {
		$("#prop_2").removeClass('error');
		form_data[$("#prop_2").attr('name')] = $("#prop_2").val();
	} else {
		$("#prop_2").addClass('error');
		err_cnt++;
		position = (position == null ? $("#prop_2").position() : position);
	}

	// person phone
	if ($("#prop_3").val() != '' && validatePhone($("#prop_3").val())) {
		$("#prop_3").removeClass('error');
		form_data[$("#prop_3").attr('name')] = $("#prop_3").val();
	} else {
		$("#prop_3").addClass('error');
		err_cnt++;
		position = (position == null ? $("#prop_3").position() : position);
	}

	// comments
	if ($("#COMMENTS").val() != '') {
		comments = $("#COMMENTS").val();
	}

	// delivery
	if (delivery_id == 3) {

		// zip
		if ($("#prop_4").val() != '') {
			$("#prop_4").removeClass('error');
			form_data[$("#prop_4").attr('name')] = $("#prop_4").val();
		} else {
			$("#prop_4").addClass('error');
			err_cnt++;
			position = (position == null ? $("#prop_4").position() : position);
		}

		// location
		if ($('input[name="LOCATION"]').val() > 0) {
			form_data["ORDER_PROP_6"] = $('input[name="LOCATION"]').val();
			$(".bx-slst").removeClass('error');
		} else {
			err_cnt++;
			$(".bx-slst").addClass('error');
			position = (position == null ? $('input[name="LOCATION"]').position() : position);
		}

		// address
		if ($("#prop_7").val() != '') {
			$("#prop_7").removeClass('error');
			form_data[$("#prop_7").attr('name')] = $("#prop_7").val();
		} else {
			$("#prop_7").addClass('error');
			err_cnt++;
			position = (position == null ? $("#prop_7").position() : position);
		}

		// pickup
	} else {

		// requied props default value
		form_data[$("#prop_4").attr('name')] = '101000';
		form_data["ORDER_PROP_6"] = 220;
		form_data[$("#prop_7").attr('name')] = '-';

		// shop select
		if (typeof $('input[name="ORDER_PROP_24"]:checked').val() === 'undefined') {
			$(".ORDER_PROP_24_ttl").css('color', '#fb2222');
			err_cnt++;
			position = (position == null ? $(".ORDER_PROP_24_ttl").position() : position);
		} else {
			form_data["ORDER_PROP_24"] = $('input[name="ORDER_PROP_24"]:checked').val();
			$(".ORDER_PROP_24_ttl").css('color', '#000');
		}
	}

	// Installation service
	form_data[$("#prop_22").attr('name')] = $("#prop_22").val();

	if (err_cnt == 0) {

		if ($(".js-confirm-order").hasClass("js-in-process") == false) {
			$(".js-confirm-order").addClass("js-in-process");

			$.ajax({
				type: 'POST',
				url: '/local/templates/eauto/ajax.order.php',
				data: {
					PROP: form_data,
					COMMENTS: comments,
					DELIVERY_ID: delivery_id
				},
				dataType: "json",
				success: function (result) {
					$(".order__msg").html('');
					if (result.status == true) {
						window.location.href = result.url;
					} else {
						if (result.msg.length > 0) {
							$.each(result.msg, function (i, e) {
								$(".order__msg").append('<p class="type-error">' + e.text + '</p>');
							});
						}
					}

					$(".js-confirm-order").removeClass("js-in-process");
				},
				error: function (result) {
					$(".js-confirm-order").removeClass("js-in-process");
				}
			});
		}
	} else {
		if (position != null) {
			$('html, body').stop().animate({ scrollTop: position.top - 80 }, 500);
		}
	}

});

$("#prop_22").on("change", function () {
	if ($(this).prop("checked")) {
		$(this).val("Y");
	} else {
		$(this).val("N");
	}
});