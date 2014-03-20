<h1> Receipt </h1>

<?php
		echo "<script src='http://code.jquery.com/jquery-latest.js'></script>";
		echo "<script src='" . base_url() . "js/receipt.js'></script>";

    	//$items = $cart_items;




		//echo "<p><input onclick='writeToWindow(\"" . $receipt . "\")'></input></p>";
		//echo "<script>writeToWindow(\"" . $receipt . "\")';</script>";
		//echo "<p><input onclick='writeReceipt(\"" . $first . "\", \"" . $last . "\", 4)'></input></p>";

		echo $receipt;


		// echo form_open("PRINTRECEIPT");
		// echo form_submit('submit', 'Print');
		// echo form_close();

?> 
