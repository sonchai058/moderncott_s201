<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MX_Controller {

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
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'files_model'));
		$this->load->library(array('session', 'encryption', 'cart', 'grocery_CRUD'));
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

		redirect('report/view_history', 'refresh');
	}

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

    public function view_history($mode = '1') {
        $between = '';
        if(get_inpost('bt_submit1') != null){
            $date_start = dateChange(get_inpost('date-start'),2);
            $date_end   = dateChange(get_inpost('date-end'),2);
            $between    = " WHERE DATE(S_DateTime) >= '".$date_start."' AND DATE(S_DateTime) <= '".$date_end."' ";
        }
        $data['get_date']   = $this->db->query(" SELECT DISTINCT DATE(S_DateTime) AS Date FROM statistics {$between} ORDER BY S_DateTime ASC ")->result_array();
        $data['total']      = 0;
        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(S_DateTime)', $row['Date'])->where('S_Type', $mode)->from('statistics')->count_all_results();
            $data['total'] += $data['get_date'][$i]['count'];
        }
        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "back-end/view_history";
        $data['title']          = "ประวัติการเข้าชม";
                                                                                                                                                     
        $this->template->load('index_page',$data);
    }

    // public function product_stock() {
    //     if (get_session('M_ID') == '')
    //         redirect('login', 'refresh');
    //     else {
    //         $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
    //         if (count($row) <= 0) redirect('login', 'refresh');
    //     }

    //     $title = 'สินค้า';
    //     $crud = new grocery_CRUD();
    //     $crud->set_language('thai');
    //     $crud->set_subject($title);
    //     $crud->set_table('product');
    //     // $crud->where("P_Allow != ", "3");

    //     $crud->display_as('P_ID',               'ไอดี');
    //     $crud->display_as('P_Img',              'รูปภาพขนาดจริง');
    //     $crud->display_as('P_Name',             'ชื่อสินค้า');
    //     $crud->display_as('P_IDCode',           'รหัสสินค้า');
    //     $crud->display_as('C_ID',               'หมวดหมู่หลัก');
    //     $crud->display_as('PT_ID',              'ชนิด');
    //     $crud->display_as('PU_ID',              'หน่วยนับ');
    //     $crud->display_as('P_Size',             'ไซต์');
    //     $crud->display_as('P_Title',            'ไตเติ้ล/เรื่องย่อ');
    //     $crud->display_as('P_Detail',           'รายละเอียด');
    //     $crud->display_as('P_UserAdd',          'ผู้เพิ่ม');
    //     $crud->display_as('P_DateTimeAdd',      'วันเวลาที่เพิ่ม');
    //     $crud->display_as('P_UserUpdate',       'ผู้อัพเดท');
    //     $crud->display_as('P_DateTimeUpdate',   'วันเวลาที่อัพเดท');
    //     $crud->display_as('P_Allow',            'สถานะ');
    //     $crud->display_as('PS_Price',           'ราคารวม');
    //     $crud->display_as('PS_Amount',          'จำนวน');

    //     $crud->columns('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'PT_ID', 'PS_Price', 'PS_Amount');

    //     $crud->callback_column('PS_Price', array($this,'_callback_PS_Price'));
    //     $crud->callback_column('PS_Amount', array($this,'_callback_PS_Amount'));

    //     $cts = $this->fill_grocery_dropdown('category',     'C_ID',     'C_Name');
    //     $pts = $this->fill_grocery_dropdown('product_type', 'PT_ID',    'PT_Name');

    //     $crud->field_type('C_ID',   'dropdown', $cts);
    //     $crud->field_type('PT_ID',  'dropdown', $pts);

    //     $crud->set_field_upload('P_Img', 'assets/uploads/user_uploads_img');

    //     $crud->unset_add();
    //     $crud->unset_edit();
    //     $crud->unset_delete();

    //     if ($crud->getState() == 'print' || $crud->getState() == 'export')
    //         $crud->unset_columns('P_Img');

    //     $crud->unset_read_fields('P_ThumbImg');

    //     $output = $crud->render();
    //     $this->_example_output($output, $title);
    // }

    // public function _callback_PS_Price($value, $row) {
    //     if (get_session('M_ID') == '')
    //         redirect('login', 'refresh');
    //     else {
    //         $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
    //         if (count($rows) <= 0) redirect('login', 'refresh');
    //     }

    //     $prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_FullSumPrice != '0' ORDER BY PS_ID DESC LIMIT 1 ");
    //     if (count($prices) > 0) {
    //         $price = rowArray($prices);
    //         return number_format($price['PS_FullSumPrice'], 2, '.', ',');
    //     }
    //     else
    //         return number_format(0, 2, '.', ',');
    // }

    // public function _callback_PS_Amount($value, $row) {
    //     if (get_session('M_ID') == '')
    //         redirect('login', 'refresh');
    //     else {
    //         $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
    //         if (count($rows) <= 0) redirect('login', 'refresh');
    //     }

    //     $amounts = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_Allow = '1' ");
    //     if (count($amounts) > 0) {
    //         $amount = rowArray($amounts);
    //         return number_format($amount['PS_Amount']);
    //     }
    //     else
    //         return '0';
    // }

    public function total_sales($mode = '1') {
        $between = '';
        $between = " WHERE OD_Allow IN ('7') ";
        if(get_inpost('bt_submit1') != null){
            $date_start = dateChange(get_inpost('date-start'),2);
            $date_end   = dateChange(get_inpost('date-end'),2);
            $between    = " WHERE DATE(OD_DateTimeUpdate) >= '".$date_start."' AND DATE(OD_DateTimeUpdate) <= '".$date_end."' AND OD_Allow IN ('7') ";
        }
        $data['get_date']   = $this->db->query(" SELECT DISTINCT DATE(OD_DateTimeUpdate) AS Date FROM `order` {$between} ORDER BY OD_DateTimeUpdate ASC ")->result_array();
        $data['total']      = 0;
        $data['price'][0]   = 0;
        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date'])->from('order')->count_all_results();
            $query  = $this->db->select_sum('OD_FullSumPrice');
            $query  = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date']);
            $query  = $this->db->get('order');
            $result = $query->result();
            $data['total'] += $result[0]->OD_FullSumPrice;
            $data['price'][$i] = $result[0]->OD_FullSumPrice;
        }
        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "back-end/total_sales";
        $data['title']          = "ยอดการขาย";
                                                                                                                                                     
        $this->template->load('index_page', $data);
    }

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