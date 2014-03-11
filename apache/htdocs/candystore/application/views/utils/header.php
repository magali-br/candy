
 <h2>The Wonderful World of Candy</h2>

<?php

	/*echo "<img src=\"<?= base_url(); ?>images/icons/CandyStoreFront.png\" border=0>"; */

	echo '<img src="CandyStoreFront.png">';

	echo "<p>Welcome to the Candy Store, please log in!</p>";
	echo "<p>" . anchor('customer_controller/loginForm','Log In') . "</p>";


?>