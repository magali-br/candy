<!DOCTYPE html>
<html>
<head>
	<script src='http://code.jquery.com/jquery-latest.js'></script>
	<script>
		function checkCreditCard() {
			var number = $("#creditCard");

			if (/^\d{16})$/.test(number.val())) {
				number.get(0).setCustomValidity("");
				return true;
			} else {
				number.get(0).setCustomValidity("The Credit Card Number is invalid.");
				return false;
			}
		}

		function checkExpiryDate() {
			var month = $("#expiryMonth");
			var year = $("#expiryYear");

			var monthVal = month.val();
			var yearVal = year.val();

			if (!/^\d{2})$/.test(monthVal)) {
				month.get(0).setCustomValidity("The Credit Card Expiry Month is invalid.");
				return false;
			}

			if (!/^\d{2})$/.test(yearVal)) {
				year.get(0).setCustomValidity("The Credit Card Expiry Year is invalid.");
				return false;
			}

			month = parseInt(monthVal);
			year = parseInt(yearVal);

			if (monthVal > 12 || monthVal < 1) {
				month.get(0).setCustomValidity("The Credit Card Expiry Month is invalid.");
				return false;
			}

			month.get(0).setCustomValidity("");
			year.get(0).setCustomValidity("");
			return true;

		}

	 </script>

</head>

<body>
<h1> Checkout </h1>

<?php 
	echo "<p>" . anchor('cart_controller/cart','Back to Cart') . "</p>";
	if (!isset($_SESSION["items"])) {
		echo "<p>You do not have any items in your cart.</p>";
		echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
    } else {

    	if (isset($errmsg)) {
			echo "<p id='errmsg'><strong>$errmsg</strong></p>";
    	} 

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

		$tax_unrounded = $total * 0.13;
		$tax = number_format((float)$tax_unrounded, 2, '.', '');
		echo "<tr><th>HST:</th> <td id='left'>$$tax</td></tr>";

		$shipping = 5;
		echo "<tr><th>Shipping and Handling:</th> <td id='left'>$$shipping</td></tr>";

		echo "<tr><td><hr></td><td><hr></td></tr>";
		$grandTotal = $total + $tax + $shipping;
		echo "<tr><th>Total:</th> <td id='left'>$$grandTotal</td></tr>";
		echo "</td></tr>";
		echo "</table>";

		echo validation_errors();
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

		echo "<div id='creditCardError'></div>";
		echo form_label('Credit Card Number'); 
		echo form_error('creditCard');
		echo form_input('creditCard', set_value('creditCard'), "required id='creditCard' oninput='checkCreditCard()'");
		echo "</tr><tr>";

		echo "<div id='expiryDateError'></div>";
		echo form_label('Expiry Date'); 
		echo form_error('expiryMonth');
		echo form_error('expiryYear');
		echo form_input('expiryMonth', set_value('expiryMonth') ? set_value('expiryMonth') : "mm", "required class='mediumInput' id='expiryMonth'");
		echo " / ";
		echo form_input('expiryYear', set_value('expiryYear') ? set_value('expiryYear') : "yy", "required class='mediumInput' id='expiryYear' oninput='checkExpiryDate()'");
		echo "</tr></table>";

		echo form_hidden('subtotal', $total, "hidden");
		echo form_hidden('tax', $tax, "hidden");
		echo form_hidden('shipping', $shipping, "hidden");
		echo form_hidden('total', $grandTotal, "hidden");
		echo form_submit('submit', 'Complete Order');
		echo form_close();
	}
?>	

</body>
</html>
