<?php 

	echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
	if (!isset($_SESSION["items"])) {
		echo "<p>You do not have any items in your cart.</p>";
    } else {

    	$total = 0;

    	$items = $cart_items;

		echo "<table>";
		echo "<tr><th id='productNameWidth'>Name</th>
				<th id='productOtherCellWidth'>Picture</th>
				<th id='productOtherCellWidth'>Unit Price</th>
				<th id='productOtherCellWidth'>Quantity</th>
				<th id='productOtherCellWidth'>Total</th>
				<th> </th>";
		foreach ($items as $item) {
			echo "<tr>";
			echo "<td id='productNameWidth'>" . $item->product->name . "</td>";
			echo "<td id='productOtherCellWidth'><a href='" . base_url() . 
					"candystore/candyDescription/" . $item->product->id . "'>
					<img src='" . base_url() . "images/product/" . $item->product->photo_url . 
					"' width='100px' /></td>";
			echo "<td id='productOtherCellWidth'>$" 
					. $item->product->price . "</td>";

			echo "<td id='productOtherCellWidth'>";
			echo form_open("cart_controller/updateQty");
			
			echo form_error('quantity');
			echo form_input('quantity', $item->quantity, "required id='smallInput'");

			echo form_hidden('id', $item->product_id, "hidden");
			echo form_submit('submit', 'Update quantity');
			echo form_close();
			echo "</td>";

			$price = $item->product->price * $item->quantity;
			$total += $price;

			echo "<td id='productOtherCellWidth'>$" . $price  . "</td>";

			echo "<td id='productOtherCellWidth'>";
			echo form_open("cart_controller/remove");
			echo form_hidden('id', $item->product_id, "hidden");
			echo form_submit('submit', 'Remove from Cart');
			echo form_close();
			echo "</td>";

				
			echo "</tr>";
		}

		echo "</table>";

		echo "<div>";
		echo "<strong>Subtotal:</strong> $$total";
		echo form_open("cart_controller/checkout");
		echo form_submit('submit', 'Checkout');
		echo form_close();
		echo "</div>";
	}
?>	 
