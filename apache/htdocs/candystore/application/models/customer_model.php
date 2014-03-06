<?php
class Customer_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('customer');
		return $query->result('Customer');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('customer',array('id' => $id));
		
		return $query->row(0,'Customer');
	}
	
	function delete($id) {
		return $this->db->delete("customer",array('id' => $id ));
	}
	
	function insert($customer) {
		return $this->db->insert("customer", array(	'first' => $customer->first,
													'last' => $customer->last,
				                                  	'login' => $customer->login,
											      	'email' => $customer->email,
											      	'password' => $customer->password);
	}
	
	
}
?>