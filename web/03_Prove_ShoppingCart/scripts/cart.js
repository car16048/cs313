function AddItem(itemId) {
	var addUrl = 'addItem.php?v=2&single=yes&confirm=yes&itemId=' + itemId;

	$.getJSON(addUrl).done(function (data) {
		if (data < 0) {
			alert("An unknown error has occurred.  Please try your request later.");
		} else {
			UpdateItemQty(itemId, data);
		}
	}).fail(function() { alert("An unknown error has occurred.  Please try your request later."); });
}
function RemoveItem(itemId) {
	var addUrl = 'addItem.php?v=2&single=yes&confirm=yes&qty=-1&itemId=' + itemId;

	$.getJSON(addUrl).done(function (data) {
		if (data < 0) {
			alert("An unknown error has occurred.  Please try your request later.");
		} else {
			UpdateItemQty(itemId, data);
		}
	}).fail(function() { alert("An unknown error has occurred.  Please try your request later."); });
}

function UpdateItemQty(itemId, newQty) {
	if (newQty <= 0) {
		$("#cartItem" + itemId).remove();
		if ($("#cartList tr").length <= 1) {
			$("#cartContent").html("You have nothing in your cart.");
		}
	} else {
		$("#itemQty" + itemId).text(newQty + "");
	}
}
