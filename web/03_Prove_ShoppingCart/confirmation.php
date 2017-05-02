<?php require 'header1.php'; echo 'Confirmation'; require 'header2.php'; ?>
<script type="text/javascript" src="scripts/confirmation.js"></script>

<?php
if (!IsSet($_SESSION["cart"])) {
	echo "You have nothing in your cart.";
} else {
	echo "<h2>The following items will be shipped to you at " . htmlspecialchars($_POST["txtStreet"]) . ", " . htmlspecialchars($_POST["txtCity"]) . ", " . htmlspecialchars($_POST["txtState"]) . " " . htmlspecialchars($_POST["txtZip"]) . "</h2>";
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

	echo "<h2>Thank you!</h2>";
	echo "<a href='index.php'>Browse for more items</a>";
}
?>

<?php session_unset(); session_destroy(); require 'footer.php'; ?>
