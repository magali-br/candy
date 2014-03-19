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
        if (isset($_SESSION['errmsg'])) {
            $data['errmsg'] = $_SESSION['errmsg'];
            unset($_SESSION['errmsg']);
        }
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
		
		 if ($this->form_validation->run()) {

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
            // Add error

            // Reload current page
            $url = $_SERVER['HTTP_REFERER'];
            redirect($url);
		}

		redirect('candystore/storefront', 'refresh');

    }

    function checkout() {
        if ($this->loggedIn()) {
            $this->buildCart();
            if (count($this->cart_items) == 0) {
                $_SESSION["errmsg"] = "Your cart is empty!";
                redirect('cart_controller/cart', 'refresh');
            }

            $data['title'] = 'Checkout';
            $data['main'] = 'store/checkout.php';
            $data["cart_items"] = $this->cart_items;
            $this->load->view('utils/template.php',$data);
        } else {
            echo "<script type='text/javascript'>alert('Please log in before checking out!');</script>";
            redirect('customer_controller/loginForm', 'refresh');
        }

    }

    public function creditcard_check($creditcard_number) {
        if (preg_match("/\d{4}\d{4}\d{4}\d{4}/", $creditcard_number) == 0) {
            $this->form_validation->set_message('creditcard_check', "The Credit Card number is invalid.");
            return false;
        }
        return true;
    }

    function pay() {
        $this->buildCart();
        if (count($this->cart_items) == 0) {
            $_SESSION["errmsg"] = "Your cart is empty!";
            redirect('cart_controller/cart', 'refresh');
        }

        $this->load->library('form_validation');

        if (!($this->form_validation->run())) {
            $this->checkout();
            return;
        }

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

        // Get id of order just created
        $order_id = $this->db->insert_id();

        $this->load->model('order_item_model');
        foreach ($this->cart_items as $item) {
            $order_item = new Order_item();
            $order_item->order_id = $order_id;
            $order_item->product_id = $item->product_id;
            $order_item->quantity = $item->quantity;
            $this->order_item_model->insert($order_item);
        }


        $this->emptyCart();


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

        $receipt = new Receipt_model();
        $receipt->items = $this->cart_items;
        $receipt->order_id = $order_id;
        $receipt->date = $date . " at " . $time;
        $receipt->last_4_digits = $order->creditcard_number % 10000;
        $receipt->payer_first = $this->input->get_post('first');
        $receipt->payer_last = $this->input->get_post('last');
        $receipt->subtotal = $this->input->get_post('subtotal');
        $receipt->tax = $this->input->get_post('tax');
        $receipt->shipping = $this->input->get_post('shipping');
        $receipt->total = $this->input->get_post('total');


        $receipt_str = $this->buildReceiptString($receipt);
        $data['receipt'] = $receipt_str;

        $this->emailReceipt($receipt_str);

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

    function buildReceiptString($receipt) {
        if (isset($_SESSION["first"])) {
            $first = $_SESSION["first"];
        } else {
            $first = "";
        }

        if (isset($_SESSION["last"])) {
            $last = $_SESSION["last"];
        } else {
            $last = "";
        }

        $receipt_str = '<html><head><title>Candy Invoice</title></head>'
            .'<body onLoad="self.focus()">'
            .'<font color=red><b><i>To print,
             <a href=# onclick="window.print();return false;">click here</a> or press Ctrl+P</i></b></font>'
            .'<H3>Candy Invoice</H3>'
            .'<table border=0 cellspacing=3 cellpadding=3>'

            . "<table id='left'><tr>"
            . "<tr><th>Customer First Name:</th> <td>$first</td></tr>"
            . "<tr><th>Customer Last Name:</th> <td>$last</td></tr>"

            . "<tr><th>First Name on Credit Card:</th> <td>$receipt->payer_first</td></tr>"

            . "<tr><th>Last Name on Credit Card:</th> <td>$receipt->payer_last</td></tr>"

            . "<tr><th>Credit Card:</th> <td>xxxx-xxxx-xxxx-$receipt->last_4_digits</td></tr>"

            . "<tr><th>Order Number:</th> <td>$receipt->order_id</td></tr>"


            . "<tr><th>Date:</th> <td>$receipt->date</td></tr>"
            . "</td></tr>"
            . "</table>"


            . "<tr><td><hr></td></tr>"


            . "<table>"
            . "<tr><th id='productNameWidth'>Product</th>
                    <th id='productOtherCellWidth'>Product Id</th>
                    <th id='productNameWidth'>Unit Price x Quantity</th>
                    <th id='productOtherCellWidth'>Total</th>";

        foreach ($receipt->items as $item) {
            $receipt_str = $receipt_str . "<tr>"
            . "<td id='productNameWidth'>" . $item->product->name . "</td>"
            . "<td id='productOtherCellWidth'>" . $item->product->id . "</td>"
            . "<td id='productOtherCellWidth'>$" 
                    . $item->product->price . " x " . $item->quantity . "</td>";

            $price = $item->product->price * $item->quantity;

            $receipt_str = $receipt_str . "<td id='productOtherCellWidth'>$" . $price  . "</td>"
            . "</tr>";
        }

        $receipt_str = $receipt_str . "</table>"

        . "<table><tr>"
        . "<tr><th>Subtotal:</th> <td id='left'>$$receipt->subtotal</td></tr>"

        . "<tr><th>HST:</th> <td id='left'>$$receipt->tax</td></tr>"
        . "<tr><th>Shipping and Handling:</th> <td id='left'>$$receipt->shipping</td></tr>"

        . "<tr><td><hr></td><td><hr></td></tr>"
        . "<tr><th>Total:</th> <td id='left'>$$receipt->total</td></tr>"
        . "</td></tr>"
        . "</table>" . '</body></html>';

        return $receipt_str;
    }

    function emailReceipt($receipt_str) {
        $this->load->library('email');

        $this->email->from('the.wonderful.world.of.candy@gmail.com', 'The Wonderful World Of Candy');

        if (isset($_SESSION["email"])) {
            $this->email->to($_SESSION["email"]);
        }

        $this->email->subject('The Wonderful World Of Candy Purchase');
        // $this->email->message('<!DOCTYPE html><html><body><b>Testing</b> the email smtpppp.
        //     <table><tr><td>yo</td></tr><tr><td>wheee</td></tr></table></body></html>');
        $this->email->message($receipt_str);

        $this->email->send();

    }


    function orderList() {
        $data['title'] = 'Order List';
        $data['main'] = 'store/orderList.php';
        $this->load->model('order_model');
        $orders = $this->order_model->getAll();
        $data['orders']=$orders;
        $this->load->view('utils/template.php',$data);
    }

    function deleteOrder($id) {
        $this->load->model('order_model');
        
        if (isset($id)) 
            $this->order_model->delete($id);
        
        $this->orderList();
    }

}
?> 
