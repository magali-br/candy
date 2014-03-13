<?php 

	if (!isset($_SESSION["items"])) {
		echo "<p>You do not have any items in your cart.</p>";
		echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
    } else {
    	//$items = $_SESSION["items"];
    	$items = $cart_items;
		foreach ($items as $item) {

			echo "<table id='candyCell'>";
			echo "<tr>";
			echo "<td>" . $item->product->name . "</td>";
			echo "</tr><tr>";
			echo "<td><a href='" . base_url() . "candystore/candyDescription/" . $item->product->id . "'>
					<img src='" . base_url() . "images/product/" . $item->product->photo_url . 
					"' width='100px' /></td>";
			echo "</tr><tr>";
			echo "<td>$" . $item->product->price . "</td>";

			//get info from database

			echo form_open("cart_controller/update");
			
			echo form_label('Qty'); 
			echo form_error('quantity');
			echo form_input('quantity', $item->quantity, "required");

			echo form_hidden('id', $item->product_id, "hidden");
			echo form_submit('submit', 'Update quantity');

			echo form_open("cart_controller/remove");
			echo form_submit('submit', 'Remove from Cart');

			echo "<td>Quantity: " . $item->quantity . "</td>";
				
			echo "</tr>";
			echo "</tr><td> </td><tr>";
			echo "</tr><td> </td><tr>";
			echo "</table>";
		}

		// should probably be a button
		//echo "<p>" . anchor('cart_controller/pay','Submit') . "</p>";
	}
?>	 
