<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url', 'form', 'general', 'file', 'html', 'asset', 'email'));
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'files_model'));
		$this->load->library(array('session', 'encrypt', 'cart', 'form_validation', 'grocery_CRUD', 'email'));
		$this->load->library('template', array('name' => 'admin_template1', 'setting' => array('data_output' => '')));
        $this->load->library('template', array('name' => 'web_template1', 'setting' => array('data_output' => '')));
	}

	public function index() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

		redirect('product/order_management', 'refresh');
	}





	/*
     *      Public function
     */

    public function fill_grocery_dropdown($tableName, $fieldKey, $fieldName) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $row = $this->common_model->getTable($tableName);
        if (count($row) <= 0)
        	return array('' => '');
        else {
	        $custom_array = array();
	        foreach ($row as $key => $value) {
	            $custom_array[$value[$fieldKey]] = $value[$fieldName];
	        }
	        return $custom_array;
	    }
    }

    public function bank_delete($table, $href, $fieldKey, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldCondition) { 
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $this->common_model->update(
            $table, 
            array(
                $fieldAllow     => '3',
                $userUpdate     => get_session('M_ID'),
                $datetimeUpdate => date('Y-m-d H:i:s')
            ), 
            array($fieldCondition => $fieldKey)
        );
        header('Location: '.base_url($href));
        exit();
    }





    public function bank_management() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->bank_delete('bank', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow', 'B_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('bank/bank_management', 'refresh');

        $title = 'ธนาคาร';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('bank');
        $crud->where("bank.B_Allow != ", "3");
        $crud->order_by("B_Order", "asc");

        // $crud->set_relation('B_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('B_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('B_ID',               'ไอดี');
        $crud->display_as('B_Code',             'รหัสธนาคาร');
        $crud->display_as('B_Name',             'ชื่อธนาคาร');
        $crud->display_as('B_Order',            'ลำดับที่');
        $crud->display_as('B_UserAdd',          'ผู้เพิ่ม');
        $crud->display_as('B_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('B_UserUpdate',       'ผู้อัพเดท');
        $crud->display_as('B_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('B_Allow',            'สถานะ');

        $crud->required_fields('B_Name', 'B_Order');
    
        $crud->columns('B_Order', 'B_Code', 'B_Name', 'B_Allow');
    
        $crud->add_fields('B_Code', 'B_Name', 'B_Order', 'B_UserAdd', 'B_DateTimeAdd', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');
        $crud->edit_fields('B_Code', 'B_Name', 'B_Order', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');

        $crud->field_type('B_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('B_Allow',            'hidden', '1');
            $crud->field_type('B_UserAdd',          'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'bank/bank_management/del');
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }    


	


	/*
     *      Output
     */

	public function _example_output($output = null, $title = null) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array(
            'title'     => $title,
            'content'   => $output
        );
        $this->template->load('index_page', $data);
    }

}