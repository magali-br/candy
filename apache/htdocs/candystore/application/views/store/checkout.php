<?php 

		if (!isset($_SESSION["items"])) {
			echo "<p>You do not have any items in your cart.</p>";
			echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
        } else {
        	$items = $_SESSION["items"];
        
			foreach ($items as $item) {

				echo "<table id='candyCell'>";
				echo "<tr>";
				echo "<td>" . $product->name . "</td>";
				echo "</tr><tr>";
				echo "<td><a href='" . base_url() . "candystore/candyDescription/" . $product->id . "'>
						<img src='" . base_url() . "images/product/" . $product->photo_url . 
						"' width='100px' /></td>";
				echo "</tr><tr>";
				echo "<td>$" . $product->price . "</td>";

				echo "<td>Quantity: " . $item->quantity . "</td>";
					
				echo "</tr>";
				echo "</tr><td> </td><tr>";
				echo "</tr><td> </td><tr>";
				echo "</table>";
			}

			// should probably be a button
			// should be able to delete & update items
			echo "<p>" . anchor('cart_controller/checkout','Checkout') . "</p>";
		}
?>	 
