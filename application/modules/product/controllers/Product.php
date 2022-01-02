<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller {

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
		$this->load->helper(array('url', 'form', 'general', 'file', 'html', 'asset'));
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'files_model', 'billing_model'));
		$this->load->library(array('session', 'encrypt', 'cart', 'grocery_CRUD'));
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

		redirect('product/product_management', 'refresh');
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

    public function product_size_get() {
        // $PSI_Length = $this->input->post('PSI_Length');
        // $size = rowArray($this->common_model->get_where_custom('product_size', 'PSI_ID', $PSI_Length));
        // echo $size['PSI_Length'];
    }

    public function product_stock() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array(
            'P_ID'              => $this->db->escape_str(uri_seg(4)),
            'PS_Price_amount'   => $this->db->escape_str(uri_seg(3))
        );
        $this->load->view('back-end/stock_change', $data);
    }

    public function stock_get() {
        // if (get_session('M_ID') == '')
        //     redirect('login', 'refresh');
        // else {
        //     $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
        //     if (count($row) <= 0) redirect('login', 'refresh');
        // }

        // $P_ID   = $this->input->post('P_ID');
        // $PSI_ID = $this->input->post('PSI_ID');
        // $PC_ID  = $this->input->post('PC_ID');
        // $rows = $this->common_model->custom_query(
        //     " SELECT * 
        //     FROM product_stock_list 
        //     WHERE   P_ID        = '$P_ID' 
        //         AND PSI_ID      = '$PSI_ID' 
        //         AND PC_ID       = '$PC_ID' 
        //         AND PSL_Allow   = '1' 
        //     ORDER BY PSL_DateTimeUpdate DESC 
        //     LIMIT 1 "
        // );
        // if (count($rows) > 0) {
        //     $product_stock_list     = rowArray($rows);
        //     $product_stock_output   = array(
        //         'PSL_FullSumPrice'  => $product_stock_list['PSL_FullSumPrice'], 
        //         'PSL_Amount'        => $product_stock_list['PSL_Amount']
        //     );
        //     echo json_encode($product_stock_output);
        // }
        // else
        //     echo json_encode(array('PSL_FullSumPrice' => 0, 'PSL_Amount' => 0));
    }

    public function stock_changed() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $P_ID               = $this->input->post('P_ID');
        $PS_Price           = $this->input->post('PS_Price');
        $PS_Amount          = $this->input->post('PS_Amount');
        // $PSL_Price          = $this->input->post('PSL_Price');
        // $PSL_Amount         = $this->input->post('PSL_Amount');
        // $PSI_ID             = $this->input->post('PSI_ID');
        // $PC_ID              = $this->input->post('PC_ID');
        // $PS_Price_amount    = $this->input->post('PS_Price_amount');

        // $PS_Price           = 0;
        // $PS_Amount          = 0;

        // $stock_list_data = array(
        //     'P_ID'                  => $P_ID,
        //     'PSL_Price'             => $PSL_Price,
        //     'PSL_Amount'            => $PSL_Amount,
        //     'PSL_SumPrice'          => $PSL_Price,
        //     'PSL_FullSumPrice'      => $PSL_Price,
        //     'PSL_UserUpdate'        => get_session('M_ID'),
        //     'PSL_DateTimeUpdate'    => date('Y-m-d H:i:s'),
        //     'PSI_ID'                => $PSI_ID,
        //     'PC_ID'                 => $PC_ID,
        //     'PSL_Allow'             => '1'
        // );
        // $this->common_model->insert('product_stock_list', $stock_list_data);
        // $this->db->query(" UPDATE product_stock_list SET PSL_Allow = '3' WHERE P_ID = '$P_ID' AND PSI_ID = '$PSI_ID' AND PC_ID = '$PC_ID' ");
        // $this->db->query(" UPDATE product_stock_list SET PSL_Allow = '1' WHERE P_ID = '$P_ID' AND PSI_ID = '$PSI_ID' AND PC_ID = '$PC_ID' ORDER BY PSL_ID DESC LIMIT 1 ");

        // $product_stock_list = rowArray($this->common_model->custom_query(
        //     " SELECT SUM(PSL_FullSumPrice) AS PSL_FullSumPrice, SUM(PSL_Amount) AS PSL_Amount FROM product_stock_list WHERE P_ID = '$P_ID' AND PSL_Allow = '1' "
        // ));
        // $PSL_Amount = rowArray($this->common_model->custom_query(
        //     " SELECT SUM(PSL_Amount) AS PSL_Amount FROM product_stock_list WHERE P_ID = '$P_ID' AND PSL_Allow = '1' "
        // ));
        // $PSL_FullSumPrice = rowArray($this->common_model->custom_query(
        //     " SELECT PSL_FullSumPrice FROM product_stock_list WHERE P_ID = '$P_ID' AND PSL_Allow = '1' ORDER BY PSL_ID DESC LIMIT 1 "
        // ));
        $stock_data = array(
            'P_ID'                  => $P_ID,
            // 'PS_Price'              => $PSL_FullSumPrice['PSL_FullSumPrice'],
            'PS_Price'              => $PS_Price,
            // 'PS_Amount'             => $PSL_Amount['PSL_Amount'],
            'PS_Amount'             => $PS_Amount,
            // 'PS_SumPrice'           => $PSL_FullSumPrice['PSL_FullSumPrice'],
            'PS_SumPrice'           => $PS_Price,
            // 'PS_FullSumPrice'       => $PSL_FullSumPrice['PSL_FullSumPrice'],
            'PS_FullSumPrice'       => $PS_Price,
            'PS_UserUpdate'         => get_session('M_ID'),
            'PS_DateTimeUpdate'     => date('Y-m-d H:i:s'),
            'PS_Allow'              => '1'
        );
        $this->common_model->insert('product_stock', $stock_data);
        $this->db->query(" UPDATE product_stock SET PS_Allow = '3' WHERE P_ID = '$P_ID' ");
        $this->db->query(" UPDATE product_stock SET PS_Allow = '1' WHERE P_ID = '$P_ID' ORDER BY PS_ID DESC LIMIT 1 ");
    }

    public function product_delete($table, $href, $fieldKey, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldCondition) { 
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





	/*
	 * 		Product
	 */

	public function product_management() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

       	if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow', 'P_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_management', 'refresh');

        $title = 'สินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product');
        $crud->where("product.P_Allow != ", "3");
        $crud->order_by("C_ID");
        $crud->set_theme('datatables');

        $crud->set_relation('C_ID',         'category',     'C_Name');
        $crud->set_relation('PT_ID',        'product_type', 'PT_Name');
        $crud->set_relation('PU_ID',        'product_unit', 'PU_Name');
        // $crud->set_relation('P_UserAdd',    'admin',        'M_flName');
        // $crud->set_relation('P_UserUpdate', 'admin',        'M_flName');

        $crud->display_as('P_ID',           	'ไอดี');
        $crud->display_as('P_Img',          	'รูปภาพขนาดจริง');
        $crud->display_as('P_Name',     		'ชื่อสินค้า');
        $crud->display_as('P_IDCode',        	'รหัสสินค้า');
        $crud->display_as('C_ID',       		'หมวดหมู่หลัก');
        $crud->display_as('PT_ID',       		'ชนิด');
        $crud->display_as('PU_ID',          	'หน่วยนับ');
        $crud->display_as('P_Size',         	'ไซต์');
        $crud->display_as('P_Title',         	'ไตเติ้ล / เรื่องย่อ');
        $crud->display_as('P_Detail',         	'รายละเอียด');
        $crud->display_as('P_UserAdd',          'ผู้เพิ่ม');
        $crud->display_as('P_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('P_UserUpdate',     	'ผู้อัพเดท');
        $crud->display_as('P_DateTimeUpdate',	'วันเวลาที่อัพเดท');
        $crud->display_as('P_Allow',        	'สถานะ');

        $crud->display_as('PS_Price',        	'ราคา (ล่าสุด)');
        $crud->display_as('PS_Amount',        	'จำนวน');

        $crud->required_fields('P_Name', 'P_IDCode', 'C_ID');

        $crud->set_rules('P_Name', 'ชื่อสินค้า', 'required');
        $crud->set_rules('P_IDCode', 'รหัสสินค้า', 'required');
        $crud->set_rules('C_ID', 'หมวดหมู่หลัก', 'required');

		// $crud->columns('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'PT_ID', 'PU_ID', 'P_Allow', 'PS_Price', 'PS_Amount');
        $crud->columns('P_Img', 'P_IDCode', 'P_Name', 'PS_Price', 'PS_Amount', 'C_ID', 'PT_ID');

        $crud->callback_column('PS_Price', array($this, '_callback_PS_Price'));
        $crud->callback_column('PS_Amount', array($this, '_callback_PS_Amount'));

		$crud->add_fields('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'PT_ID', 'PU_ID', 'P_Size', 'P_Title', 'P_Detail', 'P_UserAdd', 'P_DateTimeAdd', 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow');
        $crud->edit_fields('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'PT_ID', 'PU_ID', 'P_Size', 'P_Title', 'P_Detail', 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow');

		// $cts = $this->fill_grocery_dropdown('category',    	'C_ID',		'C_Name');
		// $pts = $this->fill_grocery_dropdown('product_type', 'PT_ID',  	'PT_Name');
		// $pus = $this->fill_grocery_dropdown('product_unit',	'PU_ID',	'PU_Name');

		// $crud->field_type('C_ID', 	'dropdown', $cts);
		// $crud->field_type('PT_ID', 	'dropdown', $pts);
		// $crud->field_type('PU_ID', 	'dropdown', $pus);

		$crud->field_type('P_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

		if ($crud->getState() == 'add') {
            $crud->field_type('P_Allow',        	'hidden', '1');
            $crud->field_type('P_UserAdd',      	'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeAdd',  	'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('P_UserUpdate',   	'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('P_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export')
            $crud->unset_columns('P_Img');

        $crud->set_field_upload('P_Img', 		'assets/uploads/user_uploads_img');

        // $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_management/del');
        $crud->add_action('ลบ', base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_management/del');
        $crud->unset_delete();

        $crud->unset_texteditor('P_Title');
        $crud->unset_texteditor('P_Detail');

        $crud->unset_read_fields('P_ThumbImg');

        $output = $crud->render();
        $this->_example_output($output, $title);
    }

    public function _callback_PS_Price($value, $row) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        // $prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_FullSumPrice != '0' ORDER BY PS_ID DESC LIMIT 1 ");
        $prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' ORDER BY PS_ID DESC LIMIT 1 ");
        if (count($prices) > 0) {
            $price = rowArray($prices);
            return number_format($price['PS_FullSumPrice'], 2, '.', ',').' <a style="display:inline-block" href="'.base_url('product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
        }
        else
            return number_format(0, 2, '.', ',').' <a style="display:inline-block" href="'.base_url('product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
        // return number_format($value).' <a style="display:inline-block" href="product_stock/price/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
    }

    public function _callback_PS_Amount($value, $row) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        $amounts = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_Allow = '1' ");
        if (count($amounts) > 0) {
            $amount = rowArray($amounts);
            return number_format($amount['PS_Amount']).' <a style="display:inline-block" href="'.base_url('product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขจำนวนสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขจำนวนสินค้า"></a>';
        }
        else
            return '0 <a style="display:inline-block" href="'.base_url('product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขจำนวนสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขจำนวนสินค้า"></a>';
        // return number_format($value).' <a style="display:inline-block" href="product_stock/amount/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขจำนวนสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขจำนวนสินค้า"></a>';
    }





	/*
	 * 		Category
	 */

	public function category_management() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

       	if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('category', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow', 'C_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/category_management', 'refresh');

        $title = 'หมวดหมู่สินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('category');
        $crud->where("category.C_Allow != ", "3");
        $crud->order_by("C_Order", "asc");

        // $crud->set_relation('C_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('C_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('C_ID',           	'ไอดี');
        $crud->display_as('C_Name',          	'ชื่อหมวดหมู่');
        $crud->display_as('C_Descrip',     		'คำอธิบาย / รายละเอียด');
        $crud->display_as('C_Order',     		'ลำดับที่');
        $crud->display_as('C_UserAdd',          'ผู้เพิ่ม');
        $crud->display_as('C_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('C_UserUpdate',     	'ผู้อัพเดท');
        $crud->display_as('C_DateTimeUpdate',	'วันเวลาที่อัพเดท');
        $crud->display_as('C_Allow',        	'สถานะ');

        $crud->required_fields('C_Name', 'C_Order');
	
		$crud->columns('C_Order', 'C_Name', 'C_Descrip');
    
		$crud->add_fields('C_Name', 'C_Order', 'C_Descrip', 'C_UserAdd', 'C_DateTimeAdd', 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow');
		$crud->edit_fields('C_Name', 'C_Order', 'C_Descrip', 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow');

		$crud->field_type('C_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

		if ($crud->getState() == 'add') {
            $crud->field_type('C_Allow',        	'hidden', '1');
            $crud->field_type('C_UserAdd',      	'hidden', get_session('M_ID'));
            $crud->field_type('C_DateTimeAdd',  	'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('C_UserUpdate',   	'hidden', get_session('M_ID'));
            $crud->field_type('C_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('C_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('C_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/category_management/del');
        $crud->unset_delete();

        $crud->unset_texteditor('C_Descrip');

        $output = $crud->render();
        $this->_example_output($output, $title);
	}





    /*
     *      Product Size
     */

    public function product_size_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product_size', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow', 'PSI_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_size_manage', 'refresh');

        $title = 'ขนาด / รูปทรงสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_size');
        $crud->where("product_size.PSI_Allow != ", "3");
        $crud->order_by("PSI_Order", "asc");

        // $crud->set_relation('PSI_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('PSI_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('PSI_ID',              'ไอดี');
        $crud->display_as('PSI_Name',            'ชื่อขนาด');
        $crud->display_as('PSI_Note',            'หมายเหตุ รูปทรง (เพิ่มเติม)');
        $crud->display_as('PSI_Order',           'ลำดับที่');
        $crud->display_as('PSI_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PSI_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PSI_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PSI_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PSI_Allow',           'สถานะ');

        $crud->required_fields('PSI_Name', 'PSI_Order');
    
        $crud->columns('PSI_Order', 'PSI_Name', 'PSI_Note', 'PSI_Allow');
    
        $crud->add_fields('PSI_Name', 'PSI_Order', 'PSI_Note', 'PSI_UserAdd', 'PSI_DateTimeAdd', 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow');
        $crud->edit_fields('PSI_Name', 'PSI_Order', 'PSI_Note', 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow');

        $crud->field_type('PSI_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PSI_Allow',           'hidden', '1');
            $crud->field_type('PSI_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PSI_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PSI_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_size_manage/del');
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }





    /*
     *      Product Type
     */

    public function product_type_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product_type', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow', 'PT_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_type_manage', 'refresh');

        $title = 'ชนิดสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_type');
        $crud->where("product_type.PT_Allow != ", "3");
        $crud->order_by("PT_Order", "asc");

        // $crud->set_relation('PT_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('PT_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('PT_ID',              'ไอดี');
        $crud->display_as('PT_Name',            'ชื่อชนิด');
        $crud->display_as('PT_Order',           'ลำดับที่');
        $crud->display_as('PT_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PT_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PT_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PT_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PT_Allow',           'สถานะ');

        $crud->required_fields('PT_Name', 'PT_Order');
    
        $crud->columns('PT_Order', 'PT_Name', 'PT_Allow');
    
        $crud->add_fields('PT_Name', 'PT_Order', 'PT_UserAdd', 'PT_DateTimeAdd', 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow');
        $crud->edit_fields('PT_Name', 'PT_Order', 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow');

        $crud->field_type('PT_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PT_Allow',           'hidden', '1');
            $crud->field_type('PT_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PT_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PT_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PT_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PT_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PT_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_type_manage/del');
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }





	/*
	 * 		Product Unit
	 */

	public function product_unit_manage() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

       	if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product_unit', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow', 'PU_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_unit_manage', 'refresh');

        $title = 'หน่วยนับสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_unit');
        $crud->where("product_unit.PU_Allow != ", "3");
        $crud->order_by("PU_Order", "asc");

        // $crud->set_relation('PU_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('PU_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('PU_ID',           	'ไอดี');
        $crud->display_as('PU_Name',          	'ชื่อหน่วยนับ');
        $crud->display_as('PU_Order',     		'ลำดับที่');
        $crud->display_as('PU_UserAdd',     	'ผู้เพิ่ม');
        $crud->display_as('PU_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PU_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PU_DateTimeUpdate',	'วันเวลาที่อัพเดท');
        $crud->display_as('PU_Allow',			'สถานะ');

        $crud->required_fields('PU_Name', 'PU_Order');
	
		$crud->columns('PU_Order', 'PU_Name', 'PU_Allow');
    
		$crud->add_fields('PU_Name', 'PU_Order', 'PU_UserAdd', 'PU_DateTimeAdd', 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow');
		$crud->edit_fields('PU_Name', 'PU_Order', 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow');

		$crud->field_type('PU_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

		if ($crud->getState() == 'add') {
            $crud->field_type('PU_Allow',        	'hidden', '1');
            $crud->field_type('PU_UserAdd',      	'hidden', get_session('M_ID'));
            $crud->field_type('PU_DateTimeAdd',  	'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PU_UserUpdate',   	'hidden', get_session('M_ID'));
            $crud->field_type('PU_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PU_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PU_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_unit_manage/del');
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
	}





    /*
     *      Product Color
     */

    public function product_color_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product_color', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow', 'PC_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_color_manage', 'refresh');

        $title = 'สีของสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_color');
        $crud->where("product_color.PC_Allow != ", "3");
        $crud->order_by("PC_Order", "asc");

        // $crud->set_relation('PC_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('PC_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('PC_ID',              'ไอดี');
        $crud->display_as('PC_Name',            'ชื่อสี');
        $crud->display_as('PC_Order',           'ลำดับที่');
        $crud->display_as('PC_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PC_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PC_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PC_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PC_Allow',           'สถานะ');

        $crud->required_fields('PC_Name', 'PC_Order');
    
        $crud->columns('PC_Order', 'PC_Name', 'PC_Allow');
    
        $crud->add_fields('PC_Name', 'PC_Order', 'PC_UserAdd', 'PC_DateTimeAdd', 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow');
        $crud->edit_fields('PC_Name', 'PC_Order', 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow');

        $crud->field_type('PC_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PC_Allow',           'hidden', '1');
            $crud->field_type('PC_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PC_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PC_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_color_manage/del');
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }




	
	/*
	 * 		Product Gallery
	 */

	public function product_gallery_manage() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->product_delete('product_gallery', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow', 'PG_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('product/product_gallery_manage', 'refresh');

        $title = 'แกลเลอรี่รูปสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_gallery');
        $crud->where("product_gallery.PG_Allow != ", "3");
        $crud->order_by("PG_Order", "asc");

        $crud->set_relation('P_ID',             'product',  'P_Name');
        // $crud->set_relation('PG_UserAdd',       'admin',    'M_flName');
        // $crud->set_relation('PG_UserUpdate',    'admin',    'M_flName');

        $crud->display_as('PG_ID',           	'ไอดี');
        $crud->display_as('PG_Name',          	'ชื่อรูปภาพ');
        $crud->display_as('P_ID',     			'ชื่อสินค้า');
        $crud->display_as('PG_Img',     		'รูปภาพขนาดจริง');
        $crud->display_as('PG_ThumbImg',        'รูปภาพ Thumbnail');
        $crud->display_as('PG_Order',       	'ลำดับที่');
        $crud->display_as('PG_UserAdd',       	'ผู้เพิ่ม');
        $crud->display_as('PG_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PG_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PG_DateTimeUpdate',	'วันเวลาที่อัพเดท');
        $crud->display_as('PG_Allow',         	'สถานะ');

        $crud->required_fields('PG_Name', 'P_ID', 'PG_Img', 'PG_Order');
	
		// $crud->columns('PG_Order', 'PG_Img', 'PG_ThumbImg', 'PG_Name', 'PG_Allow');
		$crud->columns('PG_Order', 'PG_Img', 'PG_Name', 'PG_Allow');
    
		// $crud->add_fields('PG_Img', 'PG_ThumbImg', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserAdd', 'PG_DateTimeAdd', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
		// $crud->edit_fields('PG_Img', 'PG_ThumbImg', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
		$crud->add_fields('PG_Img', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserAdd', 'PG_DateTimeAdd', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
		$crud->edit_fields('PG_Img', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
	
		// $pds = $this->fill_grocery_dropdown('product', 'P_ID', 'P_Name');
		// $crud->field_type('P_ID', 		'dropdown', $pds);
		$crud->field_type('PG_Allow',	'dropdown', array('1' => 'เผยแพร่', '2' => 'ไม่เผยแพร่', '3' => 'ลบ / บล็อค'));

		if ($crud->getState() == 'add') {
            $crud->field_type('PG_Allow',        	'hidden', '1');
            $crud->field_type('PG_UserAdd',      	'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeAdd',  	'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PG_UserUpdate',   	'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PG_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') {
            $crud->unset_columns('PG_Img');
            $crud->unset_columns('PG_ThumbImg');
        }

        $crud->set_field_upload('PG_Img', 		'assets/uploads/user_uploads_img');
        // $crud->set_field_upload('PG_ThumbImg', 	'assets/uploads/user_uploads_img');

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/product_gallery_manage/del');
        $crud->unset_delete();

        // $crud->unset_read_fields('PG_ThumbImg');

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





    public function add_cart() {
        $options = array(
            'code'      => $this->input->post('code'),
            // 'size'      => $this->input->post('size'),
            // 'length'    => $this->input->post('length'),
            // 'color'     => $this->input->post('color'),
            'note'      => $this->input->post('note')
        );
        $data = array(
            'id'        => $this->input->post('id'),
            'name'      => $this->input->post('name'),
            'price'     => $this->input->post('price'),
            'qty'       => $this->input->post('qty'),
            'options'   => $options
        );
        $this->cart->insert($data);
        $grand_quantity = 0;
        if ($cartQty = $this->cart->contents()) {
            foreach ($cartQty as $itemQty) {
                $grand_quantity = $grand_quantity + $itemQty['qty'];
            }
        }
        echo $grand_quantity;
        // redirect('main', 'refresh');
    }

    public function update_cart() {
        $cart_info = $_POST['cart'];
        foreach($cart_info as $key => $cart) {  
            $data = array(
                'rowid'     => $cart['rowid'],
                'price'     => $cart['price'],
                'amount'    => $cart['price'] * $cart['qty'],
                'qty'       => $cart['qty']
            );
            $this->cart->update($data);
        }
        // redirect('main/cart_view', 'refresh'); 
    }  

    public function remove_cart($rowid) {
        if ($rowid === "all")
            $this->cart->destroy();
        else {
            $data = array(
                'rowid' => $rowid,
                'qty'   => 0
            );
            $this->cart->update($data);
        }
        echo $rowid;
        // redirect('main', 'refresh');
    }

     

    public function billing_view() {
        $this->load->view('billing_view');
    }

    public function save_order() {
        // This will store all values which inserted from user.
        $customer = array(
            'name'      => $this->input->post('name'),
            'email'     => $this->input->post('email'),
            'address'   => $this->input->post('address'),
            'phone'     => $this->input->post('phone')
        );      
        // And store user imformation in database.
        $cust_id = $this->billing_model->insert_orderaddress($customer);
        $order = array(
            'date'          => date('Y-m-d'),
            'customerid'    => $cust_id
        );      
        $ord_id = $this->billing_model->insert_order($order);
        if ($cart = $this->cart->contents()) {
            foreach ($cart as $item) {
                $order_detail = array(
                    'orderid'       => $ord_id,
                    'productid'     => $item['id'],
                    'quantity'      => $item['qty'],
                    'price'         => $item['price']
                );      
                // Insert product imformation with order detail, store in cart also store in database. 
                $cust_id = $this->billing_model->insert_order_detail($order_detail);
            }
        }
        // After storing all imformation in database load "billing_success".
        $this->load->view('billing_success');
    }
}