
<?php

	echo "<img src='" . base_url() . "images/icons/CandyStoreFont.png'/>";

	// if ((isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
 //            echo "<p>Welcome to the Candy Store, please log in!</p>";
 //        }
 //        echo "<p>Welcome to the Candy Store, YOU!</p>";
 //    }

	echo "<p>Welcome to the Candy Store, please log in!</p>";
	echo "<p>" . anchor('customer_controller/loginForm','Log In') . "</p>";


?>