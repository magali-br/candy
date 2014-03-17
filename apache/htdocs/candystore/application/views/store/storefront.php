<!DOCTYPE html>
<html>
<head>

<?php //$yo = $_SESSION["first"];
	// echo "<script src='" . base_url() . "js/receipt.js'></script>";
	// echo "</head><body>";
	// $last = "what";
	// $first= "yo";
	// echo "<p><input onclick='writeReceipt(\"" . $first . "\", \"" . $last . "\", " 
	// 		. count($products) . ")'></input></p>";
			


		foreach ($products as $product) {

			echo "<table id='candyCell'>";
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "</tr><tr>";
			echo "<td><a href='" . base_url() . "candystore/candyDescription/" . $product->id . "'>
					<img src='" . base_url() . "images/product/" . $product->photo_url . 
					"' width='100px' /></td>";
			echo "</tr><tr>";
			echo "<td>$" . $product->price . "</td>";
				
			echo "</tr>";
			echo "</tr><td> </td><tr>";
			echo "</tr><td> </td><tr>";
			echo "</table>";
		}

	echo "</body></html>";
?>	

