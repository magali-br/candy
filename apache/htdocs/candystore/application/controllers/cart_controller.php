<?php

class Cart_controller extends MY_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function cart() {
    	$data['title'] = 'Your Cart';
        $data['main'] = 'store/cart.php';
        // for each info in session items, fetch info from database? -- because might need to be updateD!!
        //and build equivalent array of cart_items and pass them as data?
        // if no items, redirect to "you have nothing"

        $this->load->view('utils/template.php',$data);
    }

    function add() {
    	$this->load->library('form_validation');
		$this->form_validation->set_rules('quantity','Quantity','required|is_natural_no_zero');
		$this->form_validation->set_rules('id','Id','required');
		
		 if ($this->form_validation->run() == true) {
			$order_item = new Order_item();
            $order_item->quantity = $this->input->get_post('quantity');
            $order_item->product_id = $this->input->get_post('id');

            if (!isset($_SESSION["items"])) {
            	$_SESSION["items"] = array();
            }

            $_SESSION["items"][] = $order_item;

            // if are adding more of the same kind of item, should add extra quantity to same order_item!

			redirect('candystore/storefront', 'refresh');
		} else {
			// Add errorrr handling code!!!!
		}

		redirect('candystore/storefront', 'refresh');

    }

    function checkout() {
        $data['title'] = 'Checkout';
        $data['main'] = 'store/checkout.php';
        $this->load->view('utils/template.php',$data);
    }

}
?> 
