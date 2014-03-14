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

    function emptyCart() {
        $_SESSION["items"] = array();
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
            echo "<script type='text/javascript'>alert('Please log in before checking out!');</script>";
            redirect('customer_controller/loginForm', 'refresh');
        }

    }

    function pay() {
        $this->buildCart();
        if (count($this->cart_items) == 0) {
            echo "<script type='text/javascript'>alert('Your cart is empty!');</script>";
            redirect('cart_controller/cart', 'refresh');
        }
        // verify credit card info
        // 
        $order = new Order();
        $today = getdate();
        $time = $today["hours"] . ":" . $today["minutes"] . ":" . $today["seconds"];
        $order->order_time = $time;

        $date = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
        $order->order_date = $date;

        $total = $this->input->get_post('total');
        $order->total = $total;

        if (isset($_SESSION["id"])) {
            $order->customer_id = $_SESSION["id"];
        } else {
            //BAD, but this will not happen
        }
        $order->creditcard_number = $this->input->get_post('creditCard');
        $order->creditcard_month = $this->input->get_post('expiryMonth');
        $order->creditcard_year = $this->input->get_post('expiryYear');

        $this->load->model('order_model');
        $this->order_model->insert($order);
        $order_id = $this->db->insert_id();

        $this->load->model('order_item_model');
        foreach ($this->cart_items as $item) {
            $order_item = new Order_item();
            $order_item->order_id = $order_id;
            $order_item->product_id = $item->product_id;
            $order_item->quantity = $item->quantity;
            $this->order_item_model->insert($order_item);
        }

        echo count($this->cart_items);

        $this->emptyCart();
        //redirect('candystore/storefront', 'refresh');

        $data['title'] = 'Receipt';
        $data['main'] = 'store/receipt.php';
        $data['cart_items'] = $this->cart_items;
        $data['order_id'] = $order_id;
        $data['date'] = $date . " at " . $time;
        $data['last_4_digits'] = $order->creditcard_number % 10000;
        $data['payer_first'] = $this->input->get_post('first');
        $data['payer_last'] = $this->input->get_post('last');
        $data['subtotal'] = $this->input->get_post('subtotal');
        $data['tax'] = $this->input->get_post('tax');
        $data['shipping'] = $this->input->get_post('shipping');
        $data['total'] = $this->input->get_post('total');
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
