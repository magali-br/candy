<?php
class Order_item_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_item');
		return $query->result('Order_item');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order_item',array('id' => $id));
		
		return $query->row(0,'Order_item');
	}
	
	function delete($id) {
		return $this->db->delete("order_item",array('id' => $id ));
	}
	
	function insert($order_item) {
		return $this->db->insert("order_item", array('order_id' => $order_item->order_id,
				                                  'product_id' => $order_item->product_id,
											      'quantity' => $order_item->quantity));
	}
	
}
?> 
