<?php 
	echo "<p>" . anchor('cart_controller/cart','Back to Cart') . "</p>";
	if (!isset($_SESSION["items"])) {
		echo "<p>You do not have any items in your cart.</p>";
		echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
    } else {

    	$total = 0;

    	$items = $cart_items;

		echo "<table>";
		echo "<tr><th id='productNameWidth'>Name</th>
				<th id='productOtherCellWidth'>Picture</th>
				<th id='productOtherCellWidth'>Unit Price</th>
				<th id='productOtherCellWidth'>Quantity</th>
				<th id='productOtherCellWidth'>Total</th>";
		foreach ($items as $item) {
			echo "<tr>";
			echo "<td id='productNameWidth'>" . $item->product->name . "</td>";
			echo "<td id='productOtherCellWidth'><a href='" . base_url() . 
					"candystore/candyDescription/" . $item->product->id . "'>
					<img src='" . base_url() . "images/product/" . $item->product->photo_url . 
					"' width='100px' /></td>";
			echo "<td id='productOtherCellWidth'>$" 
					. $item->product->price . "</td>";

			echo "<td id='productOtherCellWidth'>" . $item->quantity . "</td>";

			$price = $item->product->price * $item->quantity;
			$total += $price;

			echo "<td id='productOtherCellWidth'>$" . $price  . "</td>";

				
			echo "</tr>";
		}

		echo "</table>";

		echo "<table id='right'><tr>";
		echo "<tr><th>Subtotal:</th> <td id='left'>$$total</td></tr>";

		$tax = $total * 0.13;
		echo "<tr><th>HST:</th> <td id='left'>$$tax</td></tr>";

		$shipping = 5;
		echo "<tr><th>Shipping and Handling:</th> <td id='left'>$$shipping</td></tr>";

		echo "<tr><td><hr></td><td><hr></td></tr>";
		$grandTotal = $total + $tax + $shipping;
		echo "<tr><th>Total:</th> <td id='left'>$$grandTotal</td></tr>";
		echo "</td></tr>";
		echo "</table>";

		echo "<table><tr>";
		echo form_open("cart_controller/pay");

		echo form_label('First Name'); 
		echo form_error('first');
		echo form_input('first',set_value('first'), "required");
		echo "</tr><tr>";

		echo form_label('Last Name'); 
		echo form_error('last');
		echo form_input('last',set_value('last'), "required");
		echo "</tr><tr>";


		// DO MORE VALIDATION
		echo form_label('Credit Card Number'); 
		echo form_error('creditCard');
		echo form_input('creditCard', set_value('creditCard'), "required");
		echo "</tr><tr>";

		echo form_label('Expiry Date'); 
		echo form_error('expiryMonth');
		echo form_input('expiryMonth', "mm", "required id='mediumInput'") . 
				" / " . form_error('expiryYear') . 
				form_input('expiryYear', "yy", "required id='mediumInput'");
		echo "</tr></table>";

		echo form_hidden('subtotal', $total, "hidden");
		echo form_hidden('tax', $tax, "hidden");
		echo form_hidden('shipping', $shipping, "hidden");
		echo form_hidden('total', $grandTotal, "hidden");
		echo form_submit('submit', 'Complete Order');
		echo form_close();
	}
?>	
