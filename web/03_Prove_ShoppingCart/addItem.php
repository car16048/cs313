<?php
	session_start();
	header('Content-type: application/json');

	$itemIdStr = $_GET["itemId"];
	if ($itemIdStr == null || !is_numeric($itemIdStr)) {
		echo "-1";
	} else {
		$itemId = (int)$itemIdStr;
		if ($itemId != 1 && $itemId != 2 && $itemId != 3) {
			echo "-2";
		} else {
			$cart = $_SESSION["cart"];
			if ($cart == null) {
				$cart = array();
			}

			if ($cart[$itemId] == null || $cart[$itemId] == 0 || $_GET["confirm"] == "yes") {
				if ($cart[$itemId] == null) {
					$cart[$itemId] = 0;
				}

				$qty = 1;
				if (is_numeric($_GET["qty"])) {
					$qty = (int)$_GET["qty"];
				}

				$cart[$itemId] += $qty;
				
				if ($_GET["single"] == "yes") {
					echo $cart[$itemId];
				} else {
					$totalQty = 0;
					foreach ($cart as $itemQty) {
						$totalQty += $itemQty;
					}

					echo $totalQty;
				}
				$_SESSION["cart"] = $cart;
			} else {
				echo "-3";
			}
		}
	}
?>