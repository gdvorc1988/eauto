// add prod to basket
$(".js-add-to-basket").on("click", function (e) {
	e.preventDefault();

	var prodID = $(this).attr("data-prod-id");
	var qnt = $("#prod" + prodID + "-quantity").val();
	var curOb = $(this);

	if (qnt == 'undefined')
		qnt = 1;

	if (curOb.hasClass("js-in-process") == false) {
		curOb.addClass("js-in-process");

		$.ajax({
			type: 'POST',
			url: '/local/templates/eauto/add-to-basket.php',
			data: {
				PROD_ID: prodID,
				QUANTITY: qnt
			},
			dataType: "json",
			success: function (result) {
				$(".button-action-msg").html('');
				if (result.status == true) {

					// basket icon on header
					$(".js-basket-count").addClass('basket-c-view');
					$(".js-basket-count").text(result.count);

					// modal
					$(".add-prod-modal").fadeIn();
					$(".js-count-in-basket").text(result.count);

				} else {
					if (result.msg.length > 0) {
						$.each(result.msg, function (i, e) {
							$(".button-action-msg").append('<p>' + e.text + '</p>');
						});
					}
				}

				curOb.removeClass("js-in-process");
			},
			error: function (result) {
				curOb.removeClass("js-in-process");
			}
		});
	}
});

$(".js-prod-modal-close").on("click", function (e) {
	e.preventDefault();
	$(".add-prod-modal").hide();
});

// open mobile filter
$("#js_show_filters").on("click", function (e) {
	e.preventDefault();
	if ($(".js-filter-show ").is(":visible") == false) {
		$(".js-filter-show").fadeIn();
		$("body").addClass("blocked");
	} else {
		$(".js-filter-show").hide();
		$("body").removeClass("blocked");
	}
});

// close mobile filter
$(".js-close-filter").on("click", function (e) {
	$(".js-filter-show").hide();
	$("body").removeClass("blocked");
});

// clear filter
$(".js-clear-filter").on("click", function (e) {
	e.preventDefault();

	if ($(".min-price").val() != '') $(".min-price").val("");
	if ($(".max-price").val() != '') $(".max-price").val("");

	$(".option-checkbox").each(function (index, element) {
		if ($(this).prop("checked") == true) {
			$(this).prop("checked", false);
		}
	});
});

// prod count selector
$(".js-amount-plus").on("click", function (e) {
	e.preventDefault();
	var current = $(".js-prod-count-inp").val() * 1;
	current++;
	$(".js-prod-count-inp").val(current);
});

$(".js-amount-minus").on("click", function (e) {
	e.preventDefault();
	var current = $(".js-prod-count-inp").val() * 1;
	if (current > 1)
		current--;
	$(".js-prod-count-inp").val(current);
});

// order one click
$(".js-order-one-click").on("click", function (e) {
	e.preventDefault();
	var prodID = $(this).attr("data-prod-id");
	$(".js-ocl-confirm-order").attr("data-prod-id", prodID);
	$(".one-click-order").fadeIn();
	$(".overlay").fadeIn();
});

// close order one click form
$(".js-ocl-close").on("click", function (e) {
	e.preventDefault();
	$(".one-click-order").fadeOut();
	$(".overlay").fadeOut();
});

// check form inputs
$(".js-ocl-confirm-order").on("click", function (e) {
	e.preventDefault();
	var err_cnt = 0;
	var form_data = [];
	var prodID = $(this).attr("data-prod-id");

	$(".one-click-order form :input").each(function () {
		var input = $(this);
		if (input.attr('name') != 'one-click-order__close' &&
			input.attr('name') != 'confirm') {

			// if prop requied
			if (input.prevAll('label').attr("data-requied") == 'Y') {
				if (input.val() == '') { // if empty
					input.addClass('error');
					err_cnt++;
				} else {
					// check specific fields
					switch (input.attr('name')) {
						case 'ORDER_PROP_2': // email
							if (!validateEmail(input.val())) {
								input.addClass('error');
								err_cnt++;
							} else {
								input.removeClass('error');
								form_data[input.attr('name')] = input.val();
							}
							break;
						case 'ORDER_PROP_3': // phone
							if (!validatePhone(input.val())) {
								input.addClass('error');
								err_cnt++;
							} else {
								input.removeClass('error');
								form_data[input.attr('name')] = input.val();
							}
							break;
						default:
							input.removeClass('error');
							form_data[input.attr('name')] = input.val();
							break;
					}
				}
			}
		}
	});

	if (err_cnt == 0) {
		if ($(".js-ocl-confirm-order").hasClass("js-in-process") == false) {
			$(".js-ocl-confirm-order").addClass("js-in-process");

			$.ajax({
				type: 'POST',
				url: '/local/templates/eauto/ajax.order-one-click.php',
				data: {
					PROD_ID: prodID,
					QUANTITY: 1,
					PROP: $(".one-click-order form").serialize()
				},
				dataType: "json",
				success: function (result) {
					$(".one-click-order__msg").html('');
					if (result.status == true) {
						$(".one-click-order__msg").html('<p>Заказ №' + result.ORDER_ID + ' оформлен успешно!</p>');
						$(".one-click-order form :input").each(function () {
							$(this).parent().remove();
						});
					} else {
						if (result.msg.length > 0) {
							$.each(result.msg, function (i, e) {
								$(".one-click-order__msg").append('<p class="type-error">' + e.text + '</p>');
							});
						}
					}

					$(".js-ocl-confirm-order").removeClass("js-in-process");
				},
				error: function (result) {
					$(".js-ocl-confirm-order").removeClass("js-in-process");
				}
			});
		}
	}

});