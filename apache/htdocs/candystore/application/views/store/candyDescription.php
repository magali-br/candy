<?php 

	echo "<p>" . anchor('candystore/storefront','Back') . "</p>";
	echo "<p> " . $product->name . "</p>";
	echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
	echo "<p> " . $product->description . "</p>";
	echo "<p> $" . $product->price . "</p>";

?>	 
