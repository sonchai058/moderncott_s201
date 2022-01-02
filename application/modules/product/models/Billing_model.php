<?php  
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Billing_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

	    // Insert address details in order_address
		public function insert_orderaddress($data) {
			$this->db->insert('order_address', $data);
			return (isset($id)) ? $id : FALSE;		
		}
		
	    // Insert order date with customer id in order
		public function insert_order($data) {
			$this->db->insert('order', $data);
			return (isset($id)) ? $id : FALSE;
		}
		
	    // Insert ordered product list in order_list
		public function insert_order_list($data) {
			$this->db->insert('order_list', $data);
		}
	}
?>