<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MX_Controller {

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
		$this->load->library(array('session', 'encryption', 'cart', 'form_validation', 'grocery_CRUD', 'email'));
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

		redirect('order/order_management', 'refresh');
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

    public function order_delete($table, $href, $fieldKey, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldCondition) { 
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

    public function order_status($fieldKey) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array('OD_ID' => $fieldKey);
        $this->load->view('back-end/order_status_change', $data);
    }

    public function order_status_changed() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array(
            'OD_UserUpdate'     => get_session('M_ID'),
            'OD_DateTimeUpdate' => date('Y-m-d H:i:s'),
            'OD_Allow'          => $this->input->post('OD_Allow')
        );
        // $this->common_model->update('order', $data, $this->input->post('OD_ID'));
        $this->db->where('OD_ID', $this->input->post('OD_ID'));
        $this->db->update('order', $data);

        if ($this->input->post('OD_Allow') == '5' || $this->input->post('OD_Allow') == '7' || $this->input->post('OD_Allow') == '9') {
            $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $this->input->post('OD_ID')));
            $edata = array(
                'OD_Allow'          => $order['OD_Allow'], 
                'OD_FullSumPrice'   => $order['OD_FullSumPrice'], 
                'OD_EmsCode'        => $order['OD_EmsCode'] 
            );
            $this->send_confirm_order_or_tracking_code($edata, $this->input->post('OD_ID'));
        }
    }

    public function send_confirm_order_or_tracking_code($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        $webconfig      = rowArray($this->common_model->getTable('webconfig'));
        $order          = rowArray($this->common_model->get_where_custom('order',           'OD_ID', $primary_key));
        $order_address  = rowArray($this->common_model->get_where_custom('order_address',   'OD_ID', $primary_key));
        $order_transfer = rowArray($this->common_model->custom_query(" SELECT * FROM order_transfer LEFT JOIN bank ON order_transfer.B_ID = bank.B_ID WHERE OD_ID = '$primary_key' "));

        if ($post_array['OD_Allow'] === '5') {
            if ($order['OD_Code'] != '' && $post_array['OD_FullSumPrice'] != '' && $order['OD_DateTimeAdd'] != '') {
                $data = array(
                    'OD_Code'           => $order['OD_Code'],
                    'OD_FullSumPrice'   => $post_array['OD_FullSumPrice'],
                    'OD_DateTimeAdd'    => $order['OD_DateTimeAdd'],
                    'OD_Allow'          => 'ยืนยันแล้ว'
                );

                $config['useragent']    = 'Kaihim';
                $config['mailtype']     = 'html';
                $this->email->initialize($config);

                $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
                $this->email->to($order_address['OD_Email']); 
                $this->email->subject('ยืนยันการสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/order_confirm', $data, true));  

                $this->email->send();
            }
        }
        if ($post_array['OD_Allow'] === '7') {
            if ($order['OD_Code'] != '' && $order_transfer['B_Name'] != '' && $order_transfer['OT_Payment'] != '' && $order_transfer['OT_DateTimeUpdate'] != '' && $order_transfer['OT_FullSumPrice'] != '') {
                $OT_Payment = array('1' => 'โอนเงินผ่านธนาคาร', '2' => 'ชำระเงินผ่านบัตรเครดิต', '3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส', '4' => 'อื่นๆ');
                $data = array(
                    'OD_Code'           => $order['OD_Code'],
                    'B_Name'            => $order_transfer['B_Name'],
                    'OT_Payment'        => $OT_Payment[$order_transfer['OT_Payment']],
                    'OT_DateTimeUpdate' => $order_transfer['OT_DateTimeUpdate'],
                    'OT_FullSumPrice'   => $order_transfer['OT_FullSumPrice'],
                    'OD_Allow'          => 'โอนเงินแล้ว'
                );
                $this->db->where('OT_ID', $order_transfer['OT_ID']);
                $this->db->update('order_transfer', array('OT_Allow' => '4'));

                $config['useragent']    = 'Kaihim';
                $config['mailtype']     = 'html';
                $this->email->initialize($config);

                $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
                $this->email->to($order_address['OD_Email']); 
                $this->email->subject('ยืนยันการโอนเงินไปยัง '.$webconfig['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/order_transfer', $data, true));  

                $this->email->send();
            }
        }
        if ($post_array['OD_Allow'] === '9') {
            if ($order['OD_Code'] != '' && $post_array['OD_EmsCode'] != '') {
                $data = array(
                    'OD_Code'           => $order['OD_Code'],
                    'OD_EmsCode'        => $post_array['OD_EmsCode'],
                    'OD_Allow'          => 'ส่งสินค้าแล้ว'
                );

                $config['useragent']    = 'Kaihim';
                $config['mailtype']     = 'html';
                $this->email->initialize($config);

                $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
                $this->email->to($order_address['OD_Email']); 
                $this->email->subject('หมายเลขสิ่งของฝากส่งทางไปรษณีย์ การสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/order_code', $data, true));  

                $this->email->send();
            }
        }
    }

    public function order_read($fieldKey) { 
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array(
            'content_view'  => 'back-end/order_detail_view',
            'title'         => 'รายละเอียดใบสั่งซื้อ',
            'OD_ID'         => $fieldKey
        );
        $this->template->load('index_page', $data);
    }

    public function order_print($fieldKey) { 
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $data = array('OD_ID' => $fieldKey);
        $pdfFilePath = 'filename.pdf';
        $html = $this->load->view('back-end/order_detail_print', $data, true);
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $pdf = new mPDF('tha');
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->SetDisplayMode('fullpage');
        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $pdf->WriteHTML(file_get_contents(base_url('assets/admin/css/main.css')), 1);
        $pdf->WriteHTML($html, 2);
        $pdf->Output($pdfFilePath, 'I');
    }





	/*
	 * 		Order
	 */

	public function order_management() {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(3) == 'add' && uri_seg(4) == '') 
            redirect('order/order_management', 'refresh');

       	if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->order_delete('order', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('order/order_management', 'refresh');

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'view' && uri_seg(4) != '') 
            // $this->order_read(uri_seg(4));
            redirect('order/order_read/'.uri_seg(4), 'refresh');
        else if (uri_seg(3) == 'view' && uri_seg(4) == '') 
            redirect('order/order_management', 'refresh');

        $title = 'ใบสั่งซื้อ';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order');
        $crud->where("order.OD_Allow != ", "3");
        $crud->set_theme('datatables');

        $crud->display_as('OD_ID',           	'เลขที่ใบสั่งซื้อ');
        $crud->display_as('OD_Code',            'รหัสใบสั่งซื้อ');
        $crud->display_as('M_ID',          	    'สมาชิก');
        $crud->display_as('OD_EmsCode',     	'รหัส EMS');
        $crud->display_as('OD_SumPrice',        'ราคารวม');
        $crud->display_as('OD_FullSumPrice',    'ราคาเต็มแบบไม่คิดส่วนลด');
        $crud->display_as('OD_UserAdd',       	'ผู้เพิ่ม');
        $crud->display_as('OD_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('OD_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('OD_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('OD_Status',         	'ประเภทการซื้อ/ขาย');
        $crud->display_as('OD_Allow',           'สถานะ');
        $crud->display_as('OD_Name',            'ชื่อ-นามสกุล');

        // $crud->display_as('OA_ID',              'ไอดี');
        // $crud->display_as('OD_Name',            'ชื่อ - นามสกุล');
        // $crud->display_as('OD_Descript',        'หมายเหตุ/รายละเอียด');
        // $crud->display_as('OD_Tel',             'เบอร์โทร');
        // $crud->display_as('OD_hrNumber',        'เลขที่/ห้อง');
        // $crud->display_as('OD_VilBuild',        'หมู่บ้าน/อาคาร/คอนโด');
        // $crud->display_as('OD_VilNo',           'หมู่ที่');
        // $crud->display_as('OD_LaneRoad',        'ตรอก/ซอย');
        // $crud->display_as('OD_Street',          'ถนน');
        // $crud->display_as('Amphur_ID',          'เขต/อำเภอ');
        // $crud->display_as('District_ID',        'แขวง/ตำบล');
        // $crud->display_as('Province_ID',        'จังหวัด');
        // $crud->display_as('Zipcode_Code',       'รหัสไปรษณีย์');

        $crud->required_fields('OD_SumPrice', 'OD_FullSumPrice', 'OD_Allow');

		// $crud->columns('OD_Code', 'OD_Name', 'OD_EmsCode', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_Status', 'OD_Allow');
        $crud->columns('OD_Code', 'OD_Name', 'OD_EmsCode', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_Status', 'OD_Allow');

		$crud->edit_fields('OD_Code', 'OD_EmsCode', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Status', 'OD_Allow');

        $crud->field_type('OD_Code', 'readonly');
        $crud->field_type('OD_Status', 'dropdown', array('1' => 'ปกติ', '2' => 'Pre-order'));
        $crud->field_type('OD_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค', '4' => 'รอตรวจสอบ', '5' => 'ยืนยันแล้ว', '6' => 'รอโอนเงิน', '7' => 'โอนเงินแล้ว', '8' => 'รอส่งสินค้า', '9' => 'ส่งสินค้าแล้ว', '10' => 'ได้รับสินค้าแล้ว'));

		if ($crud->getState() == 'edit') {
            $crud->field_type('OD_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate',	 'hidden', date("Y-m-d H:i:s"));
        }

        $crud->callback_column('OD_SumPrice',       array($this, 'number_format_OD_Price'));
        $crud->callback_column('OD_FullSumPrice',   array($this, 'number_format_OD_Price'));
        $crud->callback_column('OD_Allow',          array($this, 'editor_OD_Allow'));
        $crud->callback_after_update(array($this, 'send_email_to_confirm_order_after_update'));

        $crud->set_rules('OD_SumPrice', 'ราคารวม', 'numeric|required');
        $crud->set_rules('OD_FullSumPrice', 'ราคาเต็มแบบไม่คิดส่วนลด', 'numeric|required');
        $crud->set_rules('OD_Allow', 'สถานะ', 'required');

        // $crud->add_action('รายละเอียด '.$title, base_url('assets/admin/images/tools/magnifier.png'), 'order/order_management/view');
        // $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_management/del');

        $crud->add_action('View', base_url('assets/admin/images/tools/magnifier.png'), 'order/order_management/view');
        $crud->add_action('ลบ', base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_management/del');
        
        $crud->unset_add();
        $crud->unset_read();
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }

    public function editor_OD_Allow($value, $row) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        $OD_Allow = array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค', '4' => 'รอตรวจสอบ', '5' => 'ยืนยันแล้ว', '6' => 'รอโอนเงิน', '7' => 'โอนเงินแล้ว', '8' => 'รอส่งสินค้า', '9' => 'ส่งสินค้าแล้ว', '10' => 'ได้รับสินค้าแล้ว');
        return $OD_Allow[$value].' <a style="display:inline-block" href="'.base_url('order/order_status').'/'.$row->OD_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขสถานะใบสั่งซื้อ"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขสถานะใบสั่งซื้อ"></a>';
    }

    public function send_email_to_confirm_order_after_update($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        $webconfig      = rowArray($this->common_model->getTable('webconfig'));
        $order          = rowArray($this->common_model->get_where_custom('order',           'OD_ID', $primary_key));
        $order_address  = rowArray($this->common_model->get_where_custom('order_address',   'OD_ID', $primary_key));
        $order_transfer = rowArray($this->common_model->custom_query(" SELECT * FROM order_transfer LEFT JOIN bank ON order_transfer.B_ID = bank.B_ID WHERE OD_ID = '$primary_key' "));

        if ($post_array['OD_Allow'] === '5') {
            $data = array(
                'OD_Code'           => $order['OD_Code'],
                'OD_FullSumPrice'   => $post_array['OD_FullSumPrice'],
                'OD_DateTimeAdd'    => $order['OD_DateTimeAdd'],
                'OD_Allow'          => 'ยืนยันแล้ว'
            );

            $config['useragent']    = 'Kaihim';
            $config['mailtype']     = 'html';
            $this->email->initialize($config);

            $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
            $this->email->to($order_address['OD_Email']); 
            $this->email->subject('ยืนยันการสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
            $this->email->message($this->load->view('web_template1/email/order_confirm', $data, true));  

            $this->email->send();
        }
        if ($post_array['OD_Allow'] === '7') {
            $OT_Payment = array('1' => 'โอนเงินผ่านธนาคาร', '2' => 'ชำระเงินผ่านบัตรเครดิต', '3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส', '4' => 'อื่นๆ');
            $data = array(
                'OD_Code'           => $order['OD_Code'],
                'B_Name'            => $order_transfer['B_Name'],
                'OT_Payment'        => $OT_Payment[$order_transfer['OT_Payment']],
                'OT_DateTimeUpdate' => $order_transfer['OT_DateTimeUpdate'],
                'OT_FullSumPrice'   => $order_transfer['OT_FullSumPrice'],
                'OD_Allow'          => 'โอนเงินแล้ว'
            );
            $this->db->where('OT_ID', $order_transfer['OT_ID']);
            $this->db->update('order_transfer', array('OT_Allow' => '4'));

            $config['useragent']    = 'Kaihim';
            $config['mailtype']     = 'html';
            $this->email->initialize($config);

            $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
            $this->email->to($order_address['OD_Email']); 
            $this->email->subject('ยืนยันการโอนเงินไปยัง '.$webconfig['WD_Name']);
            $this->email->message($this->load->view('web_template1/email/order_transfer', $data, true));  

            $this->email->send();
        }
        if ($post_array['OD_Allow'] === '9') {
            $data = array(
                'OD_Code'           => $order['OD_Code'],
                'OD_EmsCode'        => $post_array['OD_EmsCode'],
                'OD_Allow'          => 'ส่งสินค้าแล้ว'
            );

            $config['useragent']    = 'Kaihim';
            $config['mailtype']     = 'html';
            $this->email->initialize($config);

            $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
            $this->email->to($order_address['OD_Email']); 
            $this->email->subject('หมายเลขสิ่งของฝากส่งทางไปรษณีย์ การสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
            $this->email->message($this->load->view('web_template1/email/order_code', $data, true));  

            $this->email->send();
        }
        return true;
    }



    

    /*
     *      Order List
     */

    public function order_list_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(3) == 'add' && uri_seg(4) == '') 
            redirect('order/order_list_manage', 'refresh');

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->order_delete('order_list', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'ODL_UserUpdate', 'ODL_DateTimeUpdate', 'ODL_Allow', 'ODL_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('order/order_list_manage', 'refresh');

        $title = 'รายการใบสั่งซื้อ';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order_list');
        $crud->where("order_list.ODL_Allow != ", "3");

        $crud->set_relation('OD_ID',    'order',    'OD_Code');
        $crud->set_relation('P_ID',     'product',  'P_Name');

        $crud->display_as('ODL_ID',             'เลขที่รายการ');
        $crud->display_as('OD_ID',              'เลขที่ใบสั่งซื้อ');
        $crud->display_as('P_ID',               'สินค้า');
        $crud->display_as('ODL_Amount',         'จำนวน');
        $crud->display_as('ODL_Price',          'ราคาต่อหน่วย');
        $crud->display_as('ODL_SumPrice',       'ราคารวม');
        $crud->display_as('ODL_FullSumPrice',   'ราคาเต็มแบบไม่คิดส่วนลด');
        $crud->display_as('ODL_UserAdd',        'ผู้เพิ่ม');
        $crud->display_as('ODL_DateTimeAdd',    'วันเวลาที่เพิ่ม');
        $crud->display_as('ODL_UserUpdate',     'ผู้อัพเดท');
        $crud->display_as('ODL_DateTimeUpdate', 'วันเวลาที่อัพเดท');
        $crud->display_as('ODL_Allow',          'สถานะ');

        $crud->required_fields('P_ID', 'ODL_Amount', 'ODL_Price', 'ODL_SumPrice', 'ODL_FullSumPrice', 'ODL_Allow');

        $crud->columns('ODL_ID', 'OD_ID', 'P_ID', 'ODL_Amount', 'ODL_Price', 'ODL_SumPrice', 'ODL_FullSumPrice', 'ODL_Allow');

        $crud->edit_fields('ODL_ID', 'OD_ID', 'P_ID', 'ODL_Amount', 'ODL_Price', 'ODL_SumPrice', 'ODL_FullSumPrice', 'ODL_UserUpdate', 'ODL_DateTimeUpdate', 'ODL_Allow');

        $pds = $this->fill_grocery_dropdown('product',  'P_ID',     'P_Name');

        $crud->field_type('P_ID',   'dropdown', $pds);

        $crud->field_type('ODL_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));
        // $crud->field_type('ODL_Allow', 'dropdown', array('1' => 'ยืนยันแล้ว', '2' => 'รอการยืนยัน', '3' => 'ยกเลิก'));

        if ($crud->getState() == 'edit') {
            $crud->field_type('ODL_UserUpdate',     'hidden', get_session('M_ID'));
            $crud->field_type('ODL_DateTimeUpdate', 'hidden', date("Y-m-d H:i:s"));
        }

        $crud->callback_edit_field('OD_ID',         array($this, 'disabled_OD_ID'));
        $crud->callback_edit_field('ODL_ID',        array($this, 'disabled_OD_ID'));
        $crud->callback_column('ODL_Amount',        array($this, 'number_format_OD_Amount'));
        $crud->callback_column('ODL_Price',         array($this, 'number_format_OD_Price'));
        $crud->callback_column('ODL_SumPrice',      array($this, 'number_format_OD_Price'));
        $crud->callback_column('ODL_FullSumPrice',  array($this, 'number_format_OD_Price'));

        $crud->set_rules('ODL_Amount',          'จำนวน', 'integer');
        $crud->set_rules('ODL_Price',           'ราคาต่อหน่วย', 'numeric');
        $crud->set_rules('ODL_SumPrice',        'ราคารวม', 'numeric');
        $crud->set_rules('ODL_FullSumPrice',    'ราคาเต็มแบบไม่คิดส่วนลด', 'numeric');

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_list_manage/del');
        $crud->unset_add();
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }

    public function number_format_OD_Price($value, $row) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        return '<span style="display:block;text-align:right">'.number_format($value, 2).'</span>';
    }

    public function number_format_OD_Amount($value, $row) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $rows = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($rows) <= 0) redirect('login', 'refresh');
        }

        return '<span style="display:block;text-align:right">'.number_format($value).'</span>';
    }





    /*
     *      Order Address
     */

    public function order_address_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(3) == 'add' && uri_seg(4) == '') 
            redirect('order/order_address_manage', 'refresh');

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->order_delete('order_address', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OA_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('order/order_address_manage', 'refresh');

        $title = 'ที่อยู่ใบสั่งซื้อ';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order_address');
        $crud->where("order_address.OD_Allow != ", "3");

        $crud->set_relation('OD_ID',            'order',        'OD_Code');
        $crud->set_relation('District_ID',      'districts',    'District_Name');
        $crud->set_relation('Amphur_ID',        'amphures',     'Amphur_Name');
        $crud->set_relation('Province_ID',      'provinces',    'Province_Name');

        $crud->display_as('OA_ID',              'ไอดี');
        $crud->display_as('OD_ID',              'รหัสใบสั่งซื้อ');
        $crud->display_as('OD_Name',            'ชื่อ - นามสกุล');
        $crud->display_as('OD_Descript',        'หมายเหตุ/รายละเอียด');
        $crud->display_as('OD_Tel',             'เบอร์โทร');
        $crud->display_as('OD_hrNumber',        'เลขที่/ห้อง');
        // $crud->display_as('OD_hrNumber',        'ที่อยู่');
        $crud->display_as('OD_VilBuild',        'หมู่บ้าน/อาคาร/คอนโด');
        $crud->display_as('OD_VilNo',           'หมู่ที่');
        $crud->display_as('OD_LaneRoad',        'ตรอก/ซอย');
        $crud->display_as('OD_Street',          'ถนน');
        $crud->display_as('Amphur_ID',          'เขต/อำเภอ');
        $crud->display_as('District_ID',        'แขวง/ตำบล');
        $crud->display_as('Province_ID',        'จังหวัด');
        $crud->display_as('Zipcode_Code',       'รหัสไปรษณีย์');
        $crud->display_as('OD_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('OD_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('OD_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('OD_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('OD_Allow',           'สถานะ');

        $crud->required_fields('OD_Name', 'OD_Tel', 'OD_hrNumber', 'Amphur_ID', 'District_ID', 'Province_ID', 'Zipcode_Code', 'OD_Allow');

        $crud->columns('OD_ID', 'OD_Name', 'OD_Tel', 'OD_hrNumber', 'OD_VilBuild', 'OD_VilNo', 'OD_LaneRoad', 'OD_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'OD_Allow');
        // $crud->columns('OD_ID', 'OD_Name', 'OD_Tel', 'OD_hrNumber', 'OD_Allow');

        $crud->edit_fields('OD_ID', 'OD_Name', 'OD_Tel', 'OD_hrNumber', 'OD_VilBuild', 'OD_VilNo', 'OD_LaneRoad', 'OD_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_Descript');

        // $dts = $this->fill_grocery_dropdown('districts',    'District_ID',  'District_Name');
        // $aps = $this->fill_grocery_dropdown('amphures',     'Amphur_ID',    'Amphur_Name');
        // $pvs = $this->fill_grocery_dropdown('provinces',    'Province_ID',  'Province_Name');
        $zcs = $this->fill_grocery_dropdown('zipcodes',     'Zipcode_Code', 'Zipcode_Code');

        // $crud->field_type('District_ID',    'dropdown', $dts);
        // $crud->field_type('Amphur_ID',      'dropdown', $aps);
        // $crud->field_type('Province_ID',    'dropdown', $pvs);
        $crud->field_type('Zipcode_Code',   'dropdown', $zcs);

        $crud->field_type('OD_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));
        // $crud->field_type('OD_Allow', 'dropdown', array('1' => 'ยืนยันแล้ว', '2' => 'รอการยืนยัน', '3' => 'ยกเลิก'));

        if ($crud->getState() == 'edit') {
            $crud->field_type('OD_UserUpdate',     'hidden', get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate', 'hidden', date("Y-m-d H:i:s"));
        }

        // $crud->callback_column('OD_hrNumber',       array($this, 'full_order_address'));
        $crud->callback_edit_field('OD_ID',         array($this, 'disabled_OD_ID'));

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_address_manage/del');
        $crud->unset_add();
        $crud->unset_delete();

        $crud->unset_texteditor('OD_Descript');

        $output = $crud->render();
        $this->_example_output($output, $title);
    }

    public function disabled_OD_ID($value, $row) {
        return '<input id="field-OD_ID" class="form-control" name="OD_ID" type="text" value="'.$value.'" maxlength="20" readonly style="color:#999">';
    }

    public function full_order_address($value, $row) {
        $district   = rowArray($this->common_model->get_where_custom('districts',   'District_ID',  $this->db->escape_str($row->District_ID)));
        $amphur     = rowArray($this->common_model->get_where_custom('amphures',    'Amphur_ID',    $this->db->escape_str($row->Amphur_ID)));
        $province   = rowArray($this->common_model->get_where_custom('provinces',   'Province_ID',  $this->db->escape_str($row->Province_ID)));
        
        return $value.' '.$row->OD_VilBuild.' '.$row->OD_VilNo.' '.$row->OD_LaneRoad.' '.$row->OD_Street.' '.$district['District_Name'].' '.$amphur['Amphur_Name'].' '.$province['Province_Name'].' '.$row->Zipcode_Code;
    }





    public function order_transfer_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(3) == 'add' && uri_seg(4) == '') 
            redirect('order/order_transfer_manage', 'refresh');

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->order_delete('order_address', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'OT_UserUpdate', 'OT_DateTimeUpdate', 'OT_Allow', 'OT_ID');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('order/order_transfer_manage', 'refresh');

        $title = 'รายการการโอนเงิน';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order_transfer');
        $crud->where("order_transfer.OT_Allow != ", "3");

        $crud->set_relation('OD_ID',            'order',    'OD_Code');
        $crud->set_relation('B_ID',             'bank',     'B_Name');
        $crud->set_relation('OT_UserAdd',       'admin',    'M_flName');
        $crud->set_relation('OT_UserUpdate',    'admin',    'M_flName');

        $crud->display_as('OT_ID',              'ไอดี');
        $crud->display_as('OD_ID',              'รหัสใบสั่งซื้อ');
        $crud->display_as('B_ID',               'ธนาคาร');
        $crud->display_as('OT_Payment',         'ช่องทางชำระเงิน');
        $crud->display_as('OT_Descript',        'หมายเหตุ/รายละเอียด');
        $crud->display_as('OT_Price',           'จำนวนเงิน');
        $crud->display_as('OT_SumPrice',        'จำนวนเงินทั้งสิ้น');
        $crud->display_as('OT_FullSumPrice',    'จำนวนเงินสุทธิ');
        $crud->display_as('OT_ImgAttach',       'ภาพหลักฐานการโอนเงิน');
        $crud->display_as('OT_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('OT_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('OT_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('OT_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('OT_Allow',           'สถานะ');

        $crud->columns('OD_ID', 'B_ID', 'OT_Payment', 'OT_Descript', 'OT_Price', 'OT_SumPrice', 'OT_FullSumPrice', 'OT_Allow');

        $bnk = $this->fill_grocery_dropdown('bank', 'B_ID', 'B_Name');
        $crud->field_type('B_ID', 'dropdown', $bnk);
        $crud->field_type('OT_Payment', 'dropdown', array('1' => 'โอนเงินผ่านธนาคาร', '2' => 'ชำระเงินผ่านบัตรเครดิต', '3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส', '4' => 'อื่นๆ'));

        // $crud->field_type('OT_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));
        $crud->field_type('OT_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค', '4' => 'โอนเงินแล้ว'));

        $crud->callback_column('OT_Price',          array($this, 'number_format_OD_Price'));
        $crud->callback_column('OT_SumPrice',       array($this, 'number_format_OD_Price'));
        $crud->callback_column('OT_FullSumPrice',   array($this, 'number_format_OD_Price'));

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/order_transfer_manage/del');
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();

        $output = $crud->render();
        $this->_example_output($output, $title);
    }    





    public function bank_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        redirect('order/order_management', 'refresh');

        // if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
        //     $this->order_delete('bank', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow', 'B_ID');
        // else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
        //     redirect('order/bank_manage', 'refresh');

        // $title = 'ธนาคาร';
        // $crud = new grocery_CRUD();
        // $crud->set_language('thai');
        // $crud->set_subject($title);
        // $crud->set_table('bank');
        // $crud->where("bank.B_Allow != ", "3");
        // $crud->order_by("B_Order", "asc");

        // $crud->set_relation('B_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('B_UserUpdate', 'admin', 'M_flName');

        // $crud->display_as('B_ID',               'ไอดี');
        // $crud->display_as('B_Code',             'รหัสธนาคาร');
        // $crud->display_as('B_Name',             'ชื่อธนาคาร');
        // $crud->display_as('B_Order',            'ลำดับที่');
        // $crud->display_as('B_UserAdd',          'ผู้เพิ่ม');
        // $crud->display_as('B_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        // $crud->display_as('B_UserUpdate',       'ผู้อัพเดท');
        // $crud->display_as('B_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        // $crud->display_as('B_Allow',            'สถานะ');

        // $crud->required_fields('B_Name', 'B_Order');
    
        // $crud->columns('B_Order', 'B_Code', 'B_Name', 'B_Allow');
    
        // $crud->add_fields('B_Code', 'B_Name', 'B_Order', 'B_UserAdd', 'B_DateTimeAdd', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');
        // $crud->edit_fields('B_Code', 'B_Name', 'B_Order', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');

        // $crud->field_type('B_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        // if ($crud->getState() == 'add') {
        //     $crud->field_type('B_Allow',            'hidden', '1');
        //     $crud->field_type('B_UserAdd',          'hidden', get_session('M_ID'));
        //     $crud->field_type('B_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
        //     $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
        //     $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        // }
        // if ($crud->getState() == 'edit') {
        //     $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
        //     $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        // }

        // $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'order/bank_manage/del');
        // $crud->unset_delete();

        // $output = $crud->render();
        // $this->_example_output($output, $title);
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





    public function order_save() {
        $order_state    = true;
        $order_msg      = '';
        $P_ID           = $this->input->post('P_ID');
        $ODL_Amount     = $this->input->post('ODL_Amount');
        for ($i = 0; $i < sizeof($this->input->post('P_ID')); ++$i) {
            $rows = $this->common_model->custom_query(" SELECT PS_Amount FROM product_stock WHERE P_ID = '".$P_ID[$i]."' AND PS_Allow = '1' ");
            if (count($rows) > 0) {
                $row = rowArray($rows);
                if ($ODL_Amount[$i] > $row['PS_Amount']) {
                    $order_state = false;
                    $P_Name = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID[$i]));
                    $order_msg = 'ขออภัยสินค้า '.$P_Name['P_Name'].' ขณะนี้มีจำนวนไม่พอ โปรดทำรายการใหม่อีกครั้ง';
                    $i = sizeof($this->input->post('P_ID'));
                }
                else
                    $order_state = true;
            }
            else {
                $order_state = false;
                $P_Name = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID[$i]));
                $order_msg = 'ขออภัยสินค้า '.$P_Name['P_Name'].' หมด โปรดทำรายการใหม่อีกครั้ง';
                $i = sizeof($this->input->post('P_ID'));
            }
        }

        if ($order_state === true) {
            $data = array(
                'M_ID'              => 0,
                'OD_SumPrice'       => number_format($this->input->post('OD_SumPrice'), 2, '.', ''),
                'OD_FullSumPrice'   => number_format($this->input->post('OD_FullSumPrice'), 2, '.', ''),
                'OD_UserAdd'        => '0',
                'OD_DateTimeAdd'    => date("Y-m-d H:i:s"),
                'OD_UserUpdate'     => '0',
                'OD_DateTimeUpdate' => date("Y-m-d H:i:s"),
                'OD_Status'         => '1',
                'OD_Allow'          => '1'
            );
            $this->common_model->insert('order', $data);

            $row = $this->common_model->custom_query(" SELECT * FROM `order` ORDER BY OD_ID DESC LIMIT 1 ");
            if (count($row) > 0) {
                $OD_ID = rowArray($row);
                $OD_Code = array('OD_Code' => 'PO'.str_pad($OD_ID['OD_ID'], 6, "0", STR_PAD_LEFT));
                $OD_Cond = "OD_ID = '".$OD_ID['OD_ID']."'";
                $this->common_model->update('order', $OD_Code, $OD_Cond);
                $address = array(
                    'OD_ID'             => $OD_ID['OD_ID'],
                    'OD_Name'           => $this->input->post('OD_Name'),
                    'OD_Descript'       => $this->input->post('OD_Descript'),
                    'OD_Tel'            => $this->input->post('OD_Tel'),
                    'OD_Email'          => $this->input->post('OD_Email'),
                    'OD_hrNumber'       => $this->input->post('OD_hrNumber'),
                    'OD_VilBuild'       => $this->input->post('OD_VilBuild'),
                    'OD_VilNo'          => $this->input->post('OD_VilNo'),
                    'OD_LaneRoad'       => $this->input->post('OD_LaneRoad'),
                    'OD_Street'         => $this->input->post('OD_Street'),
                    'Amphur_ID'         => $this->input->post('Amphur_ID'),
                    'District_ID'       => $this->input->post('District_ID'),
                    'Province_ID'       => $this->input->post('Province_ID'),
                    'Zipcode_Code'      => $this->input->post('Zipcode_Code'),
                    'OD_UserAdd'        => '0',
                    'OD_DateTimeAdd'    => date("Y-m-d H:i:s"),
                    'OD_UserUpdate'     => '0',
                    'OD_DateTimeUpdate' => date("Y-m-d H:i:s"),
                    'OD_Allow'          => '1'
                );
                $this->common_model->insert('order_address', $address);

                $lists              = array();
                $P_ID               = $this->input->post('P_ID');
                $ODL_Amount         = $this->input->post('ODL_Amount');
                $ODL_Price          = $this->input->post('ODL_Price');
                $ODL_SumPrice       = $this->input->post('ODL_SumPrice');
                $ODL_FullSumPrice   = $this->input->post('ODL_FullSumPrice');
                $ODL_Descript       = $this->input->post('ODL_Descript');
                for ($i = 0; $i < sizeof($this->input->post('P_ID')); ++$i) {
                    $datas = array(
                        'OD_ID'                 => $OD_ID['OD_ID'],
                        'P_ID'                  => $P_ID[$i],
                        'ODL_Amount'            => $ODL_Amount[$i],
                        'ODL_Price'             => $ODL_Price[$i],
                        'ODL_SumPrice'          => $ODL_SumPrice[$i],
                        'ODL_FullSumPrice'      => $ODL_FullSumPrice[$i],
                        'ODL_Descript'          => trim($ODL_Descript[$i]),
                        'ODL_UserAdd'           => '0',
                        'ODL_DateTimeAdd'       => date("Y-m-d H:i:s"),
                        'ODL_UserUpdate'        => '0',
                        'ODL_DateTimeUpdate'    => date("Y-m-d H:i:s"),
                        'ODL_Allow'             => '1'
                    );
                    array_push($lists, $datas);
                }
                $this->common_model->insert_batch('order_list', $lists);
                $this->cart->destroy();

                $this->send_order_result_to_email($OD_ID['OD_ID']);
                $order_msg = 'บันทึกใบสั่งซื้อเรียบร้อยแล้ว';
            }
        }
        echo $order_msg;
    }

    public function send_order_result_to_email($OD_ID = null) {
        $webconfig = rowArray($this->common_model->getTable('webconfig'));
        
        $order      = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
        $order_data = array(
            'OD_Code'           => $order['OD_Code'],
            'OD_Allow'          => 'รอตรวจสอบ',
            'OD_SumPrice'       => $order['OD_SumPrice'],
            'OD_FullSumPrice'   => $order['OD_FullSumPrice']
        );

        $order_list  = $this->common_model->custom_query(
            " SELECT * FROM order_list LEFT JOIN product ON order_list.P_ID = product.P_ID WHERE OD_ID = '$OD_ID' "
        );
        $order_list_data = array();
        foreach ($order_list as $list_order) {
            array_push($order_list_data, $list_order);
        }

        $order_address      = rowArray($this->common_model->get_where_custom('order_address',   'OD_ID',        $OD_ID));
        $district           = rowArray($this->common_model->get_where_custom('districts',       'District_ID',  $order_address['District_ID']));
        $amphur             = rowArray($this->common_model->get_where_custom('amphures',        'Amphur_ID',    $order_address['Amphur_ID']));
        $province           = rowArray($this->common_model->get_where_custom('provinces',       'Province_ID',  $order_address['Province_ID']));
        $OD_Address         = 'เลขที่/ห้อง '.$order_address['OD_hrNumber'];
        if ($order_address['OD_VilBuild']   != '') $OD_Address .= ' หมู่บ้าน/อาคาร/คอนโด '.$order_address['OD_VilBuild'];
        if ($order_address['OD_VilNo']      != '') $OD_Address .= ' หมู่ที่ '.$order_address['OD_VilNo'];
        if ($order_address['OD_LaneRoad']   != '') $OD_Address .= ' ตรอก/ซอย '.$order_address['OD_LaneRoad'];
        if ($order_address['OD_Street']     != '') $OD_Address .= ' ถนน'.$order_address['OD_Street'];
        if ($order_address['Province_ID'] != 1) {
            $OD_Address .= ' ตำบล'.$district['District_Name'];
            $OD_Address .= ' อำเภอ'.$amphur['Amphur_Name'];
            $OD_Address .= ' จังหวัด'.$province['Province_Name'];
        } 
        $OD_Address .= ' รหัสไปรษณีย์ '.$order_address['Zipcode_Code'];
        $order_address_data = array(
            'OD_Name'       => $order_address['OD_Name'],
            'OD_Tel'        => $order_address['OD_Tel'],
            'OD_Address'    => $OD_Address
        );

        $data = array(
            'order'         => $order_data,
            'order_list'    => $order_list_data,
            'order_address' => $order_address_data
        );

        $config['useragent']    = 'Kaihim';
        $config['mailtype']     = 'html';
        $this->email->initialize($config);

        $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
        $this->email->to($order_address['OD_Email']); 
        $this->email->subject('การสั่งซื้อสินค้ากับ '.$webconfig['WD_Name']);
        $this->email->message($this->load->view('web_template1/email/order', $data, true));  

        $this->email->send();
    }

    public function search_order_code() {
        $rows = $this->common_model->get_where_custom('order', 'OD_Code', $this->db->escape_str($this->input->post('OD_Code')));
        if (count($rows) > 0) {
            $row = rowArray($rows);
            echo $row['OD_ID'];
        }
    }

    public function order_transfer_submit() {
        $day    = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 0, 2);
        $month  = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 3, 2);
        $year   = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 6, 10);
        $year   = $year - 543;
        $OT_DateTime = date('Y-m-d H:i:s', strtotime($year.'-'.$month.'-'.$day.' '.$this->input->post('OT_HourAdd').':'.$this->input->post('OT_MinuteAdd').':00'));
        $data = array(
            'OD_ID'             => $this->input->post('OD_ID'),
            'B_ID'              => $this->input->post('B_ID'),
            'OT_Payment'        => $this->input->post('OT_Payment'),
            'OT_Descript'       => '',
            'OT_Price'          => $this->input->post('OT_Price'),
            'OT_SumPrice'       => $this->input->post('OT_Price'),
            'OT_FullSumPrice'   => $this->input->post('OT_Price'),
            // 'OT_ImgAttach'      => $this->input->post('OT_ImgAttach'),
            'OT_ImgAttach'      => '',
            'OT_UserAdd'        => 0,
            'OT_DateTimeAdd'    => $OT_DateTime,
            'OT_UserUpdate'     => 0,
            'OT_DateTimeUpdate' => $OT_DateTime,
            'OT_Allow'          => '1'
        );
        $this->common_model->insert('order_transfer', $data);
        redirect('main/report_transferred', 'refresh');
    }

}