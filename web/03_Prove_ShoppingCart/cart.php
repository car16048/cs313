<?php require 'header1.php'; echo 'View Cart'; require 'header2.php'; ?>
<script type="text/javascript" src="scripts/cart.js"></script>

<h1>View Cart</h1>

<div id='cartContent'>
<?php
if (!IsSet($_SESSION["cart"])) {
	echo "You have nothing in your cart.";
} else {
	$totalQty = 0;
	
	echo "<table id='cartList'><tr><th>Item</th><th>Remove</th><th>Quantity</th><th>Add</th></tr>";
	foreach ($_SESSION["cart"] as $itemId => $qty) {
		echo "<tr id='cartItem" . $itemId . "'><td>";

		switch($itemId) {
			case 1:
				echo "Circular Saw";
				break;
			case 2:
				echo "Hand Saw";
				break;
			case 3:
				echo "Miter Saw";
				break;
		}
		
		echo "</td><td><button onclick='RemoveItem(" . $itemId . ")'>-</button></td><td><span id='itemQty" . $itemId . "'>" . $qty . "</span></td><td><button onclick='AddItem(" . $itemId . ")'>+</button></td></tr>";
	}

	echo "</table>";

	echo "<div><a href='index.php'>Continue Shopping</a></div>";
	echo "<div><a href='checkout.php'>Proceed To Checkout</a></div>";
}
?>
</div>

<?php require 'footer.php'; ?>
