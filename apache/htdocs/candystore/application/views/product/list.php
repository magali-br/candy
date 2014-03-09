<h2>Product Table</h2>
<?php 
		session_start();
		header("Cache-Control: no-cache, must-revalidate");
		echo "<p>" . anchor('candystore/newForm','Add New') . "</p>";

		// DOES NOT WORK
		///$this->load->controller('customer_controller');
		//$controller = new customer_controller();
		//$controller->welcome();
		//$customer_controller->welcome();
		
		if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
			
			if (isset($_SESSION["first"])) {
				echo "<p>Welcome to the Candy Store, " . $_SESSION["first"] . "!</p>";
			} else {
				echo "<p> Welcome Nameless One </p>";
			}
			echo "<p>" . anchor('customer_controller/logout','Log Out') . "</p>";
		} else {
			echo "<p>Welcome to the Candy Store, please log in!</p>";
			echo "<p>" . anchor('customer_controller/loginForm','Log In') . "</p>";
		}
 	  
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("candystore/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("candystore/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

