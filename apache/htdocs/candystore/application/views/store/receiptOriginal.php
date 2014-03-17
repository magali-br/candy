<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src='" . base_url() . "js/receipt.js'></script>

<?php

    	$items = $cart_items;

    	if (isset($_SESSION["first"])) {
            $first = $_SESSION["first"];
        } else {
            $first = "";
        }

        if (isset($_SESSION["last"])) {
            $last = $_SESSION["last"];
        } else {
            $last = "";
        }

		echo "<input onclick='writeReceipt(" . $first . ", " . $last . ", " 
			. count($products) . ")'></input>";

		echo "<table id='left'><tr>";
		echo "<tr><th>Customer First Name:</th> <td>$first</td></tr>";
		echo "<tr><th>Customer Last Name:</th> <td>$last</td></tr>";

		echo "<tr><th>First Name on Credit Card:</th> <td>$payer_first</td></tr>";

		echo "<tr><th>Last Name on Credit Card:</th> <td>$payer_last</td></tr>";

		echo "<tr><th>Credit Card:</th> <td>xxxx-xxxx-xxxx-$last_4_digits</td></tr>";

		echo "<tr><th>Order Number:</th> <td>$order_id</td></tr>";


		echo "<tr><th>Date:</th> <td>$date</td></tr>";
		echo "</td></tr>";
		echo "</table>";


		echo "<tr><td><hr></td></tr>";


		echo "<table>";
		echo "<tr><th id='productNameWidth'>Product</th>
				<th id='productOtherCellWidth'>Product Id</th>
				<th id='productNameWidth'>Unit Price x Quantity</th>
				<th id='productOtherCellWidth'>Total</th>";
		foreach ($items as $item) {
			echo "<tr>";
			echo "<td id='productNameWidth'>" . $item->product->name . "</td>";
			echo "<td id='productOtherCellWidth'>" . $item->product->id . "</td>";
			echo "<td id='productOtherCellWidth'>$" 
					. $item->product->price . " x " . $item->quantity . "</td>";

			$price = $item->product->price * $item->quantity;

			echo "<td id='productOtherCellWidth'>$" . $price  . "</td>";
			echo "</tr>";
		}

		echo "</table>";

		echo "<table><tr>";
		echo "<tr><th>Subtotal:</th> <td id='left'>$$subtotal</td></tr>";

		echo "<tr><th>HST:</th> <td id='left'>$$tax</td></tr>";
		echo "<tr><th>Shipping and Handling:</th> <td id='left'>$$shipping</td></tr>";

		echo "<tr><td><hr></td><td><hr></td></tr>";
		echo "<tr><th>Total:</th> <td id='left'>$$total</td></tr>";
		echo "</td></tr>";
		echo "</table>";

		echo form_open("PRINTRECEIPT");
		echo form_submit('submit', 'Print');
		echo form_close();

?> 
