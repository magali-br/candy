<?php
class Order_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order');
		return $query->result('Order');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order',array('id' => $id));
		
		return $query->row(0,'Order');
	}
	
	function delete($id) {
		return $this->db->delete("order",array('id' => $id ));
	}
	
	function insert($order) {
		return $this->db->insert("order", array('customer_id' => $order->customer_id,
				                                  'order_date' => $order->order_date,
											      'order_time' => $order->order_time,
												  'total' => $order->total,
												  'creditcard_number' => $order->creditcard_number,
												  'creditcard_month' => $order->creditcard_month,
												  'creditcard_year' => $order->creditcard_year));
	}
	
}
?> 
