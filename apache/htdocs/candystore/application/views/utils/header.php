
<?php

	echo "<a href='" . base_url() . "candystore/storefront'>
			<img src='" . base_url() . "images/icons/CandyStoreFont.png'/></a>";

    $loggedIn = false;
	if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
		$loggedIn = true;
		if (isset($_SESSION["first"])) {
            $first = $_SESSION["first"];
        } else {
            $first = "friend";
        }
    } 
    if (isset($_SESSION["items"])) {
            $itemCount = count($_SESSION["items"]);
        } else {
            $itemCount = 0;
        }
        if ($itemCount == 1) {
        	$itemMessage = "item";
        } else {
        	$itemMessage = "items";
        }

    if (!$loggedIn) {
    	echo "<p>Welcome to the Candy Store, please log in!</p>";
		echo "<p><a href='" . base_url() . "cart_controller/cart'>
				<img id='smallButton' src='" . base_url() . "images/icons/CandyCart.png'/></a>";
		echo "<a href='" . base_url() . "customer_controller/loginForm'>
				<img id='smallButton' src='" . base_url() . "images/icons/CandyLogin.png'/></a></p>";

	} else {
		echo "<p>Welcome to the Candy Store, $first!</p>";
		echo "<p><a href='" . base_url() . "cart_controller/cart'>
				<img id='smallButton' src='" . base_url() . "images/icons/CandyCart.png'/></a>";
		echo "<a href='" . base_url() . "customer_controller/logout'>
				<img id='smallButton' src='" . base_url() . "images/icons/CandyLogout.png'/></a></p>";

		if (isset($_SESSION["login"]) && (strcmp($_SESSION["login"], "admin") == 0)) {
			echo "<p>" . anchor('candystore/productList','List of Products') . "</p>";
		}

	}
	echo "<p>You have $itemCount $itemMessage in your cart.</p>";


?>