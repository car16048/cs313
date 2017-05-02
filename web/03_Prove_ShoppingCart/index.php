<?php require 'header1.php'; echo 'Browse Items'; require 'header2.php'; ?>
<script type="text/javascript" src="scripts/index.js"></script>

<h1>Browse Items</h1>

<div class="cartSize right">You have <span id="cartSize"><?php
if (!IsSet($_SESSION["cart"])) {
	echo "0</span> <span id='cartItemWord'>items";
} else {
	$totalQty = 0;
	foreach ($_SESSION["cart"] as $qty) {
		$totalQty += $qty;
	}

	if ($totalQty == 1) {
		echo "1</span> <span id='cartItemWord'>item";
	} else {
		echo $totalQty . "</span> <span id='cartItemWord'>items";
	}
}
?></span>
</div>

<div class="itemList">
	<ul>
		<li>
			<div class="header3">Circular Saw</div>
			<div class="description">This circular saw spins round and round.  Very pretty.  Buy one today!!!</div>
			<button class="addButton" onclick="AddItem(1)">Add Item</button>
			<hr />
		</li>
		<li>
			<div class="header3">Hand Saw</div>
			<div class="description">This hand saw offers the user total control of the cutting process.</div>
			<button class="addButton" onclick="AddItem(2)">Add Item</button>
			<hr />
		</li>
		<li>
			<div class="header3">Miter Saw</div>
			<div class="description">Need to miter?  Why wait?  Get one while they last!</div>
			<button class="addButton" onclick="AddItem(3)">Add Item</button>
			<hr />
		</li>
	</ul>
</div>

<div class="viewCartLink">
	<a href="cart.php">View Cart</a>
</div>

<?php require 'footer.php' ?>
