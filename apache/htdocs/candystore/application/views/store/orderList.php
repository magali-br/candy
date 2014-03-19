<h2>Completed Orders</h2>
<?php 
 	  
		echo "<table>";
		echo "<tr><th id='productOtherCellWidth'>Id</th>
			<th id='productOtherCellWidth'>Customer Id</th>
			<th id='productOtherCellWidth'>Order Date</th>
			<th id='productOtherCellWidth'>Total</th>
			<th id='productOtherCellWidth'>Credit Card Number</th>
			<th id='productOtherCellWidth'>Expiry Date</th></tr>";
		
		foreach ($orders as $order) {
			echo "<tr>";
			echo "<td>" . $order->id . "</td>";
			echo "<td>" . $order->customer_id . "</td>";
			echo "<td>" . $order->order_date . " at " . $order->order_time . "</td>";
			echo "<td>$" . $order->total . "</td>";
			echo "<td>" . $order->creditcard_number . "</td>";
			echo "<td>" . $order->creditcard_month . "/" . $order->creditcard_year . "</td>";
				
			echo "<td>" . anchor("cart_controller/deleteOrder/$order->id",'Delete',"onClick='return confirm(\"Do you really want to delete this order?\");'") . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

 
 
