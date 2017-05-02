function AddItem(itemId) {
	var addUrl = 'addItem.php?v=2&itemId=' + itemId;
	$('.addButton').prop('disabled', true);

	$.getJSON(addUrl).done(function (data) {
		try
		{
			if (data == -3) {
				if (confirm("This item has already been added to your cart.  Would you like an additional one?")) {
					$.getJSON(addUrl + '&confirm=yes').done(function (data) {
						if (data < 0) {
							alert("An unknown error has occurred.  Please try your request later.");
						} else {
							UpdateCartSize(data);
						}
					}).fail(function() { alert("An unknown error has occurred.  Please try your request later."); }).always(function() { $('.addButton').prop('disabled', false); });
				}
			} else if (data < 0) {
				alert("An unknown error has occurred.  Please try your request later.");
			} else {
				UpdateCartSize(data);
			}
		}
		finally
		{
			if (data != -3) $('.addButton').prop('disabled', false);
		}
	}).fail(function() { $('.addButton').prop('disabled', false); alert("An unknown error has occurred.  Please try your request later."); });
}

function UpdateCartSize(newCartSize) {
	$("#cartSize").html("" + newCartSize);
	$("#cartItemWord").html(newCartSize == 1 ? "item" : "items");
}
