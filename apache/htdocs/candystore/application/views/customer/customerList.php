<h2>Customers</h2>
<?php 
 	  
		echo "<table>";
		echo "<tr><th id='productOtherCellWidth'>Id</th>
			<th id='productOtherCellWidth'>First Name</th>
			<th id='productOtherCellWidth'>Last Name</th>
			<th id='productOtherCellWidth'>Login</th>
			<th id='productOtherCellWidth'>Email</th></tr>";
		
		foreach ($customers as $customer) {
			echo "<tr>";
			echo "<td id='left'>" . $customer->id . "</td>";
			echo "<td id='left'>" . $customer->first . "</td>";
			echo "<td id='left'>" . $customer->last . "</td>";
			echo "<td id='left'>" . $customer->login . "</td>";
			echo "<td id='left'>" . $customer->email . "</td>";
				
			echo "<td>" . anchor("customer_controller/deleteCustomer/$customer->id",'Delete',"onClick='return confirm(\"Do you really want to delete this customer?\");'") . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

 
