<?php 

		if (isset($_SESSION["items"])) {
            $items = $_SESSION["items"];
        }
		foreach ($items as $item) {

			echo "<table id='candyCell'>";
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "</tr><tr>";
			echo "<td><a href='" . base_url() . "candystore/candyDescription/" . $product->id . "'>\
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
?>	 
