<?php 

	echo "<p>" . anchor('candystore/storefront','Back to Store') . "</p>";
	echo "<p> " . $product->name . "</p>";
	echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
	echo "<p> " . $product->description . "</p>";
	echo "<p> $" . $product->price . "</p>";

	echo form_open("cart_controller/add");
	
	echo form_label('Qty'); 
	echo form_error('quantity');
	echo form_input('quantity',set_value('quantity') ? set_value('quantity') : 0, 
		"required id='smallInput'");

	echo form_hidden('id', $product->id, "hidden");
	
	echo form_submit('submit', 'Add to Cart');
	echo form_close();

?>	 
