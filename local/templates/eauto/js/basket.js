// clear basket
$("#clear_all_basket").on("click", function (e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: '/local/templates/eauto/ajax.clear.basket.php?type=all',
		data: {},
		dataType: "json",
		success: function (result) {
			if (result.deleted_count > 0) {
				document.location.reload(true);
			}
		}
	});
});

$("#basket-item-table").on("click", ".basket-item-actions-remove", function (e) {
	e.preventDefault();
	var basket_item_id = $(this).parent("tr").attr("data-id");
	$.ajax({
		type: 'POST',
		url: '/local/templates/eauto/ajax.clear.basket.php?type=single&basket_item_id=' + basket_item_id,
		data: {},
		dataType: "json",
		success: function (result) {
			if (result.deleted_count > 0) {
				$("table").remove("#basket-item-".basket_item_id);
				var n = $(".basket-items-list-item-container").length;
				if (n == 0) {
					document.location.reload(true);
				}
			}
		}
	});
});