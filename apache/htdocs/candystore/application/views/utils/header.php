
<?php

	echo "<a href='" . base_url() . "candystore/storefront'>\
			<img src='" . base_url() . "images/icons/CandyStoreFont.png'/></a>";

	//session_start();
    header("Cache-Control: no-cache, must-revalidate");
    $loggedIn = false;
	if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
		$loggedIn = true;
		if (isset($_SESSION["first"])) {
            $first = $_SESSION["first"];
        } else {
            $first = "friend";
        }
    } 

    if (!$loggedIn) {
    	echo "<p>Welcome to the Candy Store, please log in!</p>";
		echo "<p><a href='" . base_url() . "customer_controller/loginForm'>\
				<img id='smallButton' src='" . base_url() . "images/icons/CandyLogin.png'/></a></p>";
	} else {
		echo "<p>Welcome to the Candy Store, $first!</p>";
		echo "<p><a href='" . base_url() . "customer_controller/logout'>\
				<img id='smallButton' src='" . base_url() . "images/icons/CandyLogout.png'/></a></p>";
	}


?>