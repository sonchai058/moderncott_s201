<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','form','general','file','html','asset'));
		$this->load->model(array('admin_model','common_model','useful_model','webinfo_model','files_model'));
		$this->load->library(array('session', 'encrypt', 'cart', 'grocery_CRUD', 'form_validation', 'email'));
		// $this->load->library('template', array('name' => 'admin_template1', 'setting' 	=> array('data_output' 	=> '')));
		$this->load->library('template', array('name' => 'web_template1', 'setting' 	=> array('data_output' 		=> '')));
	}

	public function index(){
		$data = array(
			'content_view' 	=> 'content/main',
			'title'			=> 'Index'
		);

		set_js_asset_head('jquery_header1.js');
		set_js_asset_head('jquery_header2.js','news');
		set_js_asset_head('jquery_header3.js');
		set_js_asset_head('jquery_header4.js');

		set_js_asset_head(array('jquery_header5.js','jquery_header6.js'));
		set_js_asset_head(array('jquery_header7.js','jquery_header8.js'),'news');

		set_js_asset_footer('jquery_footer1.js');
		set_js_asset_footer('jquery_footer2.js');
		set_js_asset_footer('jquery_footer3.js','login');
		set_js_asset_footer('jquery_footer4.js');


		set_css_asset_head('css_header1.css','news');
		set_css_asset_head('css_header2.css');
		set_css_asset_head('css_header3.css');
		set_css_asset_head('css_header4.css');

		set_css_asset_footer('css_footer1.css','login');
		set_css_asset_footer('css_footer2.css');
		set_css_asset_footer('css_footer3.css');
		set_css_asset_footer('css_footer4.css');                                                                                                                                                      

		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

        $this->template->load('index_page',$data);
		//$this->load->view('admin/index_admin',$data);
	}

	public function cart_view() {
		$data = array(
			'content_view' 	=> 'content/cart_view',
			'title'			=> 'Cart View'
		);

		set_js_asset_head('jquery_header1.js');
		set_js_asset_head('jquery_header2.js','news');
		set_js_asset_head('jquery_header3.js');
		set_js_asset_head('jquery_header4.js');

		set_js_asset_head(array('jquery_header5.js','jquery_header6.js'));
		set_js_asset_head(array('jquery_header7.js','jquery_header8.js'),'news');

		set_js_asset_footer('jquery_footer1.js');
		set_js_asset_footer('jquery_footer2.js');
		set_js_asset_footer('jquery_footer3.js','login');
		set_js_asset_footer('jquery_footer4.js');


		set_css_asset_head('css_header1.css','news');
		set_css_asset_head('css_header2.css');
		set_css_asset_head('css_header3.css');
		set_css_asset_head('css_header4.css');

		set_css_asset_footer('css_footer1.css','login');
		set_css_asset_footer('css_footer2.css');
		set_css_asset_footer('css_footer3.css');
		set_css_asset_footer('css_footer4.css');                                                                                                                                                      

		$this->template->load('index_page',$data);
	}

	public function cart_popup() {
		$this->template->load('content/cart_view');
	}

	public function after_addtocart_popup() {
		$this->template->load('content/after_addtocart_view');
	}

	public function amphurs_selection() {
		$row = $this->common_model->get_where_custom('amphures', 'Province_ID', $this->input->post('Province_ID'));
        if (count($row) <= 0)
            return array('' => '');
        else {
            $custom_array = array();
            foreach ($row as $key => $value) {
                $custom_array[$value['Amphur_ID']] = trim($value['Amphur_Name']);
            }
            echo json_encode($custom_array);
        }
	}

	public function districts_selection() {
		$row = $this->common_model->get_where_custom('districts', 'Amphur_ID', $this->input->post('Amphur_ID'));
        if (count($row) <= 0)
            return array('' => '');
        else {
            $custom_array = array();
            foreach ($row as $key => $value) {
                $custom_array[$value['District_ID']] = trim($value['District_Name']);
            }
            echo json_encode($custom_array);
        }
	}

	public function zipcodes_selection() {
		$row = $this->common_model->get_where_custom('districts', 'District_ID', $this->input->post('District_ID'));
        if (count($row) <= 0)
            return array('' => '');
        else {
        	$custom_string = '';
            foreach ($row as $key => $value) {
                $custom_string = trim($value['District_Code']);
            }
            $row = $this->common_model->get_where_custom('zipcodes', 'District_Code', $custom_string);
	        if (count($row) <= 0)
	            return '';
	        else {
	        	$custom_string = '';
	            foreach ($row as $key => $value) {
	                $custom_string = trim($value['Zipcode_Code']);
	            }
	            echo $custom_string;
	        }
        }
	}

	public function fill_grocery_dropdown($tableName, $fieldKey, $fieldName) {
        $row = $this->common_model->getTable($tableName);
        if (count($row) <= 0)
            return array('' => '');
        else {
            $custom_array = array();
            foreach ($row as $key => $value) {
                $custom_array[$value[$fieldKey]] = trim($value[$fieldName]);
            }
            return $custom_array;
        }
    }

	public function order_view() {
		$pvs = $this->fill_grocery_dropdown('provinces', 'Province_ID', 'Province_Name');
        $data = array(
			'content_view' 	=> 'content/order_view',
			'title'			=> 'Order View',
			'provinces'		=> $pvs
		);
		$this->template->load('index_page', $data);

		// $title = 'ตะกร้าสินค้า';
  //       $crud = new grocery_CRUD();
  //       $crud->set_language('thai');
  //       $crud->set_subject($title);
  //       $crud->set_table('order_address');
  //       $crud->where("OD_Allow != ", "1");

  //       $crud->display_as('OA_ID',           	'ไอดี');
  //       $crud->display_as('OD_ID',          	'รหัสรายการ');
  //       $crud->display_as('OD_Descript',     	'หมายเหตุ/รายละเอียด');
  //       $crud->display_as('OD_Tel',         	'โทรศัพท์');
  //       $crud->display_as('OD_hrNumber',     	'เลขที่/ห้อง');
  //       $crud->display_as('OD_VilBuild',     	'หมู่บ้าน/อาคาร/คอนโด');
  //       $crud->display_as('OD_VilNo',        	'หมู่ที่');
  //       $crud->display_as('OD_LaneRoad',     	'ตรอก/ซอย');
  //       $crud->display_as('OD_Street',       	'ถนน');
  //       $crud->display_as('Amphur_ID',      	'อำเภอ/เขต');
  //       $crud->display_as('District_ID',    	'ตำบล/แขวง');
  //       $crud->display_as('Province_ID',    	'จังหวัด');
  //       $crud->display_as('Zipcode_Code',   	'รหัสไปรษณีย์');
  //       $crud->display_as('OD_UserAdd',        	'ผู้เพิ่มข้อมูล');
  //       $crud->display_as('OD_DateTimeAdd',     'วันเวลาที่เพิ่ม');
  //       $crud->display_as('OD_UserUpdate',      'ผู้อัพเดท');
  //       $crud->display_as('OD_DateTimeUpdate',  'วันเวลาที่อัพเดท');
  //       $crud->display_as('OD_Allow',    		'สถานะ'); 

  //       $crud->required_fields('OD_ID', 'OD_Tel', 'OD_hrNumber', 'Amphur_ID', 'District_ID', 'Province_ID', 'Zipcode_Code', 'OD_Allow');

  //       $crud->columns('OA_ID', 'OD_ID', 'OD_Tel', 'OD_hrNumber', 'Amphur_ID', 'District_ID', 'Province_ID', 'Zipcode_Code', 'OD_Allow');
        
  //       $crud->add_fields('OD_ID', 'OD_Descript', 'OD_Tel', 'OD_hrNumber', 'OD_VilBuild', 'OD_VilNo', 'OD_LaneRoad', 'OD_Street', 'Province_ID', 'Amphur_ID', 'District_ID', 'Zipcode_Code', 'OD_UserAdd', 'OD_DateTimeAdd', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow');

  //       $dts = $this->fill_grocery_dropdown('districts',    'District_ID',  'District_Name');
  //       $aps = $this->fill_grocery_dropdown('amphures',     'Amphur_ID',    'Amphur_Name');
  //       $pvs = $this->fill_grocery_dropdown('provinces',    'Province_ID',  'Province_Name');
  //       $zcs = $this->fill_grocery_dropdown('zipcodes',     'Zipcode_Code', 'Zipcode_Code');

  //       $crud->field_type('District_ID',    'dropdown', $dts);
  //       $crud->field_type('Amphur_ID',      'dropdown', $aps);
  //       $crud->field_type('Province_ID',    'dropdown', $pvs);
  //       $crud->field_type('Zipcode_Code',   'dropdown', $zcs);

  //       if ($crud->getState() == 'add') {
  //           $crud->field_type('OD_Allow',        	'hidden', '1');
  //           $crud->field_type('OD_UserAdd',      	'hidden', '');
  //           $crud->field_type('OD_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
  //           $crud->field_type('OD_UserUpdate',      'hidden', '');
  //           $crud->field_type('OD_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
  //       }

  //       $crud->unset_back_to_list();
  //       $crud->unset_delete();
  //       $crud->unset_edit();
  //       $crud->unset_export();
  //       $crud->unset_list();
  //       $crud->unset_print();
  //       $crud->unset_read();
  //       $crud->unset_texteditor('OD_Descript');

  //       $output = $crud->render();
  //       $this->_example_output($output, $title);
	}

	public function category($C_ID = null) {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		$row = rowArray($this->common_model->get_where_custom('category', 'C_ID', $C_ID));
		$data = array(
			'content_view' 	=> 'content/category_view',
			'title'			=> 'Category',
			'C_ID'			=> $row['C_ID'],
			'C_Name'		=> $row['C_Name']
		);
		$this->template->load('index_page', $data);
	}

	public function products_view() {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		$data = array(
			'content_view' 	=> 'content/products_view',
			'title'			=> 'Products'
		);
		$this->template->load('index_page', $data);
	}

	public function product_details($P_ID = null) {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		if ($P_ID !== null && $P_ID !== '') {
			$row = $this->common_model->get_where_custom('product', 'P_ID', $P_ID); 
			if (count($row) > 0) {
				$data = array(
					'content_view' 	=> 'content/product_details',
					'title'			=> 'Product Details',
					'P_ID' 			=> $P_ID
				);
				$this->template->load('index_page', $data);
			}
			else echo '<script>window.history.back();</script>';
		}
		else echo '<script>window.history.back();</script>';
	}

	public function how_to() {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		$data = array(
			'content_view' 	=> 'content/how_to',
			'title'			=> 'How To'
		);
		$this->template->load('index_page', $data);
	}

	public function product_galleries() {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		$data = array(
			'content_view' 	=> 'content/product_galleries',
			'title'			=> 'Product Galleries'
		);
		$this->template->load('index_page', $data);
	}

	public function contact_us() {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}

		$data = array(
			'content_view' 	=> 'content/contact_us',
			'title'			=> 'Contact Us'
		);
		$this->template->load('index_page', $data);
	}

	public function contact_send() {
		$this->form_validation->set_rules('send[]', 'send', 'required');
		if ($this->form_validation->run() == false) 
            echo 'ข้อมูลไม่ถูกต้อง โปรดทำรายการใหม่อีกครั้ง';
		else {
			$row 	= rowArray($this->common_model->getTable('webconfig'));
			$post 	= get_inpost('send');
			foreach ($post as $key => $value) {
                $data[$key] = $value;
            }
            $data['CU_Date'] 		= date("Y-m-d H:i:s");
			$config['useragent'] 	= 'Moderncottondress';
			$config['mailtype'] 	= 'html';
			$this->email->initialize($config);
			$this->email->from($post['CU_Email'], $post['CU_Name']);
			$this->email->to($row['WD_Email']);  
			$this->email->subject($post['CU_Subject']);
			$this->email->message($this->load->view('web_template1/email/contact_us', $data, true));
			$this->email->send();
			echo 'บัทึกข้อมูลการติดต่อเรียบร้อยแล้ว';
		}
	}

	public function report_transferred() {
		if (!isset($_SESSION['visited'])) {
			$visit_data = array(
				'S_IP' 			=> $this->admin_model->kh_getUserIP(),
				'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
				'S_Type' 		=> '1',
				'ID' 			=> 0,
			);
			$this->common_model->insert('statistics', $visit_data);
			set_session('visited','visited');
		}
		
		$data = array(
			'content_view' 	=> 'content/report_transferred',
			'title'			=> 'Report Transferred'
		);
		$this->template->load('index_page', $data);
		
		// $title = 'รายการการโอนเงิน';
  //       $crud = new grocery_CRUD();
  //       $crud->set_language('thai');
  //       $crud->set_subject($title);
  //       $crud->set_table('order_transfer');
  //       $crud->where("OT_Allow != ", "3");

  //       $crud->display_as('OT_ID',              'ไอดี');
  //       $crud->display_as('OD_ID',              'เลขที่ใบสั่งซื้อ');
  //       $crud->display_as('B_ID',               'ธนาคาร');
  //       $crud->display_as('OT_Payment',         'ช่องทางชำระเงิน');
  //       $crud->display_as('OT_Descript',        'หมายเหตุ/รายละเอียด');
  //       $crud->display_as('OT_Price',           'จำนวนเงิน');
  //       $crud->display_as('OT_SumPrice',        'จำนวนเงินทั้งสิ้น');
  //       $crud->display_as('OT_FullSumPrice',    'จำนวนเงินสุทธิ');
  //       $crud->display_as('OT_ImgAttach',       'ภาพหลักฐานการโอนเงิน');
  //       $crud->display_as('OT_UserAdd',         'ผู้เพิ่ม');
  //       $crud->display_as('OT_DateTimeAdd',     'วันเวลาที่เพิ่ม');
  //       $crud->display_as('OT_UserUpdate',      'ผู้อัพเดท');
  //       $crud->display_as('OT_DateTimeUpdate',  'วันเวลาที่อัพเดท');
  //       $crud->display_as('OT_Allow',           'สถานะ');

  //       $crud->columns('OD_ID', 'B_ID', 'OT_Payment', 'OT_Descript', 'OT_Price', 'OT_SumPrice', 'OT_FullSumPrice', 'OD_Allow');

  //       $bnk = $this->fill_grocery_dropdown('bank', 'B_ID', 'B_Name');
  //       $crud->field_type('B_ID', 'dropdown', $bnk);

  //       $crud->field_type('OT_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

  //       $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_transfer_manage/del');
  //       $crud->unset_edit();
  //       $crud->unset_delete();

  //       $output = $crud->render();
  //       $this->_example_output($output, $title);
	}

	public function _example_output($output = null, $title = null) {
  //       $data = array(
		// 	'content_view' 	=> 'content/order_view',
		// 	'title'			=> $title,
		// 	'content'   	=> $output
		// );
		$data = array(
			'content'	=> $output,
            'title'		=> $title
        );
        $this->template->load('index_page', $data);
    }

}
