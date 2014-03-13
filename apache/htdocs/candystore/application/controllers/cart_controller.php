<?php

class Cart_controller extends MY_Controller {

    function __construct() {
        // Call the Controller constructor
        parent::__construct();
        $this->cart_items = array();
    }

    function productInArray($input_id) {
        if (!isset($_SESSION["items"])) {
            $_SESSION["items"] = array();
        }
        foreach ($_SESSION["items"] as $item) {
            if ($item->product_id == $input_id) {
                return $item;
            }
        }
    }

    function cart() {
    	$data['title'] = 'Your Cart';
        $data['main'] = 'store/cart.php';
        $this->buildCart();
        $data["cart_items"] = $this->cart_items;
        $this->load->view('utils/template.php',$data);

    }

    function buildCart() {

        $this->load->model('product_model');
        $this->cart_items = array();
        if (isset($_SESSION["items"])) {
            foreach ($_SESSION["items"] as $item) {
                $cart_item = new Cart_item();
                $cart_item->product_id = $item->product_id;
                $cart_item->quantity = $item->quantity;
                $cart_item->product = $this->product_model->get($item->product_id);
                $this->cart_items[] = $cart_item;
            }
        }
    }

    function add() {
    	$this->load->library('form_validation');
		$this->form_validation->set_rules('quantity','Quantity','required|is_natural_no_zero');
		$this->form_validation->set_rules('id','Id','required');
		
		 if ($this->form_validation->run() == true) {

            if (!isset($_SESSION["items"])) {
            	$_SESSION["items"] = array();
            }

            $input_id = $this->input->get_post('id');
            $quantity = $this->input->get_post('quantity');


            $item = $this->productInArray($input_id);
            if ($item) {
                $item->quantity += $quantity;
            } else {
                $order_item = new Cart_item();
                $order_item->quantity = $this->input->get_post('quantity');
                $order_item->product_id = $this->input->get_post('id');
                $_SESSION["items"][] = $order_item;
            }

            // if are adding more of the same kind of item, should add extra quantity to same order_item!

			//redirect('candystore/storefront', 'refresh');
		} else {
			// Add errorrr handling code!!!!
		}

		redirect('candystore/storefront', 'refresh');

    }

    function checkout() {
        if ($this->loggedIn()) {
            $data['title'] = 'Checkout';
            $data['main'] = 'store/checkout.php';
            $this->buildCart();
            $data["cart_items"] = $this->cart_items;
            $this->load->view('utils/template.php',$data);
        } else {
            echo "<script type='text/javascript'>alert('Please log in before checking out');</script>";
            redirect('customer_controller/loginForm', 'refresh');
        }

    }

    function pay() {
        // verify credit card info
        // 
        $data['title'] = 'Receipt';
        $data['main'] = 'store/receipt.php';
        $data["cart_items"] = $this->cart_items;
        $this->load->view('utils/template.php',$data);
    }

    function remove() {
        $id = $this->input->get_post('id');
        $item = $this->productInArray($id);
        if ($item) {
            $index = array_search($item, $_SESSION["items"]);

            array_splice($_SESSION["items"], $index, 1);
        }
        redirect('cart_controller/cart', 'refresh');
    }

    function updateQty() {
        $id = $this->input->get_post('id');
        $quantity = $this->input->get_post('quantity');
        $item = $this->productInArray($id);
        if ($item) {
            $item->quantity = $quantity;
        }
        redirect('cart_controller/cart', 'refresh');
    }

}
?> 
