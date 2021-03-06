<?php

class CandyStore extends MY_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	$this->load->library('upload', $config);
	    	
    }

    function index() {
    	// Load the list of products by default
    	$this->storefront();

    }

    function productList() {
    	if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}
		
    	$data['title'] = 'The Wonderful World of Candy';
    	$data['main'] = 'product/list.php';
    	$this->load->model('product_model');
    	$products = $this->product_model->getAll();
    	$data['products']=$products;
    	$this->load->view('utils/template.php',$data);
    }

    function storefront() {
    	$data['title'] = 'The Wonderful World of Candy';
    	$data['main'] = 'store/storefront.php';
    	$this->load->model('product_model');
    	$products = $this->product_model->getAll();
    	$data['products']=$products;
    	$this->load->view('utils/template.php',$data);
    }

    function candyDescription($id) {

		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;

		$data['title'] = 'View Product';
    	$data['main'] = 'store/candyDescription.php';
	    $this->load->view('utils/template.php',$data);
	}


    
    function newForm() {
    	if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

    	$data['title'] = 'New Product';
    	$data['main'] = 'product/newForm.php';
	    $this->load->view('utils/template.php',$data);
    }
    
	function create() {
		if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required|greater_than[0]');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$data['title'] = 'New Product';
    			$data['main'] = 'product/newForm.php';
	    		$this->load->view('utils/template.php',$data);
				return;
			}
			
			$this->newForm();
		}	
	}
	
	function read($id) {

		if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;

		$data['title'] = 'View Product';
    	$data['main'] = 'product/read.php';
	    $this->load->view('utils/template.php',$data);
	}
	
	function editForm($id) {
		if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;

		$data['title'] = 'Edit Product';
    	$data['main'] = 'product/editForm.php';
	    $this->load->view('utils/template.php',$data);
	}
	
	function update($id) {
		if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('candystore/storefront', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;

			$data['title'] = 'Edit Product';
    		$data['main'] = 'product/editForm.php';
		}
	}
    	
	function delete($id) {
		if (!($this->isAdmin())) {
			redirect('candystore/index', 'refresh');
			return;
		}

		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}
      
   
    
    
    
}

