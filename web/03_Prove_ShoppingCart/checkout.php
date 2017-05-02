<?php require 'header1.php'; echo 'Checkout'; require 'header2.php'; ?>
<script type="text/javascript" src="scripts/checkout.js"></script>

<h1>Checkout</h1>

<div id='cartContent'>
<?php
if (!IsSet($_SESSION["cart"])) {
	echo "You have nothing in your cart.";
} else {
	echo "<h2>These are the items currently in your cart.</h2>";
	echo "<table><tr><th>Item</th><th>Quantity</th></tr>";
	foreach ($_SESSION["cart"] as $itemId => $qty) {
		echo "<tr><td>";

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
		
		echo "</td><td>" . $qty . "</td></tr>";
	}

	echo "</table>";

	echo "<form action='confirmation.php' method='post'>";
	echo "Enter the address to ship to:<br />";
	echo "<label for='txtStreet'>Street Address</label><br/>";
	echo "<input type='text' id='txtStreet' name='txtStreet' /><br/>";
	echo "<label for='txtCity'>City</label><br/>";
	echo "<input type='text' id='txtCity' name='txtCity' /><br/>";
	echo "<label for='txtState'>State</label><br/>";
	echo "<input type='text' id='txtState' name='txtState' /><br/>";
	echo "<label for='txtZip'>ZIP Code</label><br/>";
	echo "<input type='text' id='txtZip' name='txtZip' /><br/>";
	echo "<div><input type='submit' value='Purchase Items'/></div></form>";
}
?>
</div>
<div><a href='cart.php'>Back to Cart</a></div>
<div><a href='index.php'>Back to Shopping</a></div>

<?php require 'footer.php' ?>
