<h2>Customers</h2>
<?php 
 	  
		echo "<table>";
		echo "<tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Login</th><th>Email</th></tr>";
		
		foreach ($customers as $customer) {
			echo "<tr>";
			echo "<td>" . $customer->id . "</td>";
			echo "<td>" . $customer->first . "</td>";
			echo "<td>" . $customer->last . "</td>";
			echo "<td>" . $customer->login . "</td>";
			echo "<td>" . $customer->email . "</td>";
				
			echo "<td>" . anchor("customer_controller/deleteCustomer/$customer->id",'Delete',"onClick='return confirm(\"Do you really want to delete this customer?\");'") . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

 
