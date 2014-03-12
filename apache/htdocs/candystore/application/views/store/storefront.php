<?php 
 	  
		//echo "<table>";
		

		foreach ($products as $product) {

			echo "<table id=\"candyCell\">";
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "</tr><tr>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . 
					"' width='100px' /></td>";
			echo "</tr><tr>";
			echo "<td>$" . $product->price . "</td>";
			
			echo "</tr><tr>";
			echo "<td>" . anchor("candystore/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
			echo "</tr><td> </td><tr>";
			echo "</tr><td> </td><tr>";
			echo "</table>";
		}
?>	

