<?php
class Product_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('product');
		return $query->result('Product');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('product',array('id' => $id));
		
		return $query->row(0,'Product');
	}
	
	function delete($id) {
		return $this->db->delete("product",array('id' => $id ));
	}
	
	function insert($product) {
		return $this->db->insert("product", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price,
												  'photo_url' => $product->photo_url));
	}
	 
	function update($product) {
		$this->db->where('id', $product->id);
		return $this->db->update("product", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price));
	}
	
	
}
?>