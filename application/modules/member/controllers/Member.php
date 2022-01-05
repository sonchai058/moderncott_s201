<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

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
		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);
        $this->load->library('encryption');
	}

	public function index() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        redirect('member/member_management', 'refresh');

		// echo site_url().'<br>';
		// echo 'test load model'.$this->admin_model->kh_getUserIP().'<hr><br>';

		// $stock=$this->load->module('stock');
		// $this->stock->display();

		// $stock1=$this->load->module('stock/display');
		// $stock1->stock->display();


		// $this->stock->display1(array('000','333'));
		// echo Modules::run('stock/display1', array('222','333'));
		
		// echo Modules::run('stock/add', array(1,2)).'<hr>';

		// echo Modules::run('stock/display2', array('222','333'));

		// echo '<br/>'.site_url();
		// $this->load->view('front-end/welcome_message');
	}

	// public function template_show() {
	// 	set_js_asset_head('jquery_header1.js');
	// 	set_js_asset_head('jquery_header1.js','news');

	// 	$data=array(
	// 		'content_view'=>'welcome_message',
	// 		'title'=>'Template Convertor',
	// 		'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id illo excepturi, sint odio, adipisci saepe maiores minima in. Quo enim velit corporis illum 
	// 					sint accusamus esse nostrum eaque ullam, eligendi!',
	// 	);
	// 	$this->template->load('index_page',$data,'news');
	// }





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

    public function member_delete($table, $href, $M_ID, $userUpdate, $datetimeUpdate) { 
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $this->common_model->update(
            $table, 
            array(
                'M_Allow'       => '3',
                $userUpdate     => get_session('M_ID'),
                $datetimeUpdate => date('Y-m-d H:i:s')
            ), 
            array('M_ID' => $M_ID)
        );
        if ($M_ID == get_session('M_ID'))
            redirect('logout', 'refresh');
        else {
            header('Location: '.base_url($href));
            exit();
        }
    }





    /*
     *      Member
     */

    public function member_before_insert_datas($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function member_before_update_password($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $row = $this->common_model->get_where_custom_field('member', 'M_ID', $primary_key, 'M_Password');
        if ($post_array['M_Password'] == $row['M_Password'])
            $post_array['M_Password'] =  $row['M_Password'];
        else
            $post_array['M_Password'] =  $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function member_management() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        redirect('member/admin_management', 'refresh');

        // if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
        //     $this->member_delete('member', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'M_Update', 'M_KeyUpdate');
        // else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
        //     redirect('member/member_management', 'refresh');

        // $title = 'ผู้เข้าใช้งานระบบ';
        // $crud = new grocery_CRUD();
        // $crud->set_language('thai');
        // $crud->set_subject($title);
        // $crud->set_table('member');
        // $crud->where("member.M_Allow != ", "3");

        // $crud->set_relation('District_ID',  'districts',    'District_Name');
        // $crud->set_relation('Amphur_ID',    'amphures',     'Amphur_Name');
        // $crud->set_relation('Province_ID',  'provinces',    'Province_Name');
        // // $crud->set_relation('M_UserAdd',    'admin',        'M_flName');
        // // $crud->set_relation('M_Update',     'admin',        'M_flName');

        // $crud->display_as('M_ID',           'ไอดี');
        // $crud->display_as('M_Img',          'รูปประจำตัว');
        // $crud->display_as('M_Username',     'ชื่อผู้ใช้งาน');
        // $crud->display_as('M_Password',     'รหัสผ่าน');
        // $crud->display_as('M_TName',        'คำนำหน้าชื่อ');
        // $crud->display_as('M_flName',       'ชื่อ-นามสกุล');
        // $crud->display_as('M_ucName',       'Name & Lastname');
        // $crud->display_as('M_Sex',          'เพศ');
        // $crud->display_as('M_npID',         'เลขประจำตัวประชาชน');
        // $crud->display_as('M_HTel',         'โทรศัพท์บ้าน');
        // $crud->display_as('M_MTel',         'โทรศัพท์มือถือ');
        // $crud->display_as('M_Fax',          'โทรสาร');
        // $crud->display_as('M_Email',        'อีเมล');
        // $crud->display_as('M_hrNumber',     'เลขที่/ห้อง');
        // $crud->display_as('M_VilBuild',     'หมู่บ้าน/อาคาร/คอนโด');
        // $crud->display_as('M_VilNo',        'หมู่ที่');
        // $crud->display_as('M_LaneRoad',     'ตรอก/ซอย');
        // $crud->display_as('M_Street',       'ถนน');
        // $crud->display_as('Amphur_ID',      'อำเภอ/เขต');
        // $crud->display_as('District_ID',    'ตำบล/แขวง');
        // $crud->display_as('Province_ID',    'จังหวัด');
        // $crud->display_as('Zipcode_Code',   'รหัสไปรษณีย์ ');
        // $crud->display_as('M_Allow',        'สถานะ');
        // $crud->display_as('M_UserAdd',      'ผู้เพิ่มข้อมูล');
        // $crud->display_as('M_Regis',        'วันเวลาที่เพิ่ม/สมัคร');
        // $crud->display_as('M_Update',       'ผู้อัพเดท');
        // $crud->display_as('M_KeyUpdate',    'วันเวลาที่อัพเดท'); 

        // $crud->required_fields('M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_Sex', 'M_npID', 'M_MTel', 'M_Email', 'M_hrNumber', 'Amphur_ID', 'District_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow');

        // $crud->columns('M_ID', 'M_Img', 'M_flName', 'M_MTel', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code');
        
        // $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_UserAdd', 'M_Regis', 'M_Update', 'M_KeyUpdate');
        // $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_Update', 'M_KeyUpdate');
        
        // $crud->set_rules('M_Email', 'E-Email', 'required|valid_email');

        // $crud->field_type('M_Password', 'password');
        // $crud->field_type('M_TName', 'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        // $crud->field_type('M_Sex', 'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));

        // $dts = $this->fill_grocery_dropdown('districts',    'District_ID',  'District_Name');
        // $aps = $this->fill_grocery_dropdown('amphures',     'Amphur_ID',    'Amphur_Name');
        // $pvs = $this->fill_grocery_dropdown('provinces',    'Province_ID',  'Province_Name');
        // $zcs = $this->fill_grocery_dropdown('zipcodes',     'Zipcode_Code', 'Zipcode_Code');

        // $crud->field_type('District_ID',    'dropdown', $dts);
        // $crud->field_type('Amphur_ID',      'dropdown', $aps);
        // $crud->field_type('Province_ID',    'dropdown', $pvs);
        // $crud->field_type('Zipcode_Code',   'dropdown', $zcs);

        // $crud->field_type('M_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        // if ($crud->getState() == 'add') {
        //     $crud->field_type('M_Allow',        'hidden', '1');
        //     $crud->field_type('M_UserAdd',      'hidden', get_session('M_ID'));
        //     $crud->field_type('M_Regis',        'hidden', date("Y-m-d H:i:s"));
        //     $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
        //     $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        // }
        // if ($crud->getState() == 'edit') {
        //     $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
        //     $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        // }

        // $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        // $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        // $crud->callback_before_insert(array($this,  'member_before_insert_datas'));
        // $crud->callback_before_update(array($this,  'member_before_update_password'));
        
        // $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'member/member_management/del');
        // $crud->unset_delete();

        // $output = $crud->render();
        // $this->_example_output($output, $title);
    }

    public function member_profile_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        redirect('member/admin_management', 'refresh');

        // if ($this->uri->segment(4) == '' || get_session('M_ID') == '' || get_session('M_ID') != uri_seg(4)) {
        //     header('Location: '.base_url('member/member_profile_manage/edit/'.get_session('M_ID')));
        //     exit();
        // }

        // $title = 'ผู้เข้าใช้งานระบบ';
        // $crud = new grocery_CRUD();
        // $crud->set_language('thai');
        // $crud->set_subject($title);
        // $crud->set_table('member');
        // $crud->where("member.M_Allow != ", "3");

        // $crud->set_relation('District_ID',  'districts',    'District_Name');
        // $crud->set_relation('Amphur_ID',    'amphures',     'Amphur_Name');
        // $crud->set_relation('Province_ID',  'provinces',    'Province_Name');
        // $crud->set_relation('M_UserAdd',    'admin',        'M_flName');
        // $crud->set_relation('M_Update',     'admin',        'M_flName');

        // $crud->display_as('M_ID',           'ไอดี');
        // $crud->display_as('M_Img',          'รูปประจำตัว');
        // $crud->display_as('M_Username',     'ชื่อผู้ใช้งาน');
        // $crud->display_as('M_Password',     'รหัสผ่าน');
        // $crud->display_as('M_TName',        'คำนำหน้าชื่อ');
        // $crud->display_as('M_flName',       'ชื่อ-นามสกุล');
        // $crud->display_as('M_ucName',       'Name & Lastname');
        // $crud->display_as('M_Sex',          'เพศ');
        // $crud->display_as('M_npID',         'เลขประจำตัวประชาชน');
        // $crud->display_as('M_HTel',         'โทรศัพท์บ้าน');
        // $crud->display_as('M_MTel',         'โทรศัพท์มือถือ');
        // $crud->display_as('M_Fax',          'โทรสาร');
        // $crud->display_as('M_Email',        'อีเมล');
        // $crud->display_as('M_hrNumber',     'เลขที่/ห้อง');
        // $crud->display_as('M_VilBuild',     'หมู่บ้าน/อาคาร/คอนโด');
        // $crud->display_as('M_VilNo',        'หมู่ที่');
        // $crud->display_as('M_LaneRoad',     'ตรอก/ซอย');
        // $crud->display_as('M_Street',       'ถนน');
        // $crud->display_as('Amphur_ID',      'อำเภอ/เขต');
        // $crud->display_as('District_ID',    'ตำบล/แขวง');
        // $crud->display_as('Province_ID',    'จังหวัด');
        // $crud->display_as('Zipcode_Code',   'รหัสไปรษณีย์ ');
        // $crud->display_as('M_Allow',        'สถานะ');
        // $crud->display_as('M_UserAdd',      'ผู้เพิ่มข้อมูล');
        // $crud->display_as('M_Regis',        'วันเวลาที่เพิ่ม/สมัคร');
        // $crud->display_as('M_Update',       'ผู้อัพเดท');
        // $crud->display_as('M_KeyUpdate',    'วันเวลาที่อัพเดท'); 

        // $crud->required_fields('M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_Sex', 'M_npID', 'M_MTel', 'M_Email', 'M_hrNumber', 'Amphur_ID', 'District_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow');

        // $crud->columns('M_ID', 'M_Img', 'M_flName', 'M_MTel', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code');
        
        // $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_UserAdd', 'M_Regis', 'M_Update', 'M_KeyUpdate');
        // $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_Update', 'M_KeyUpdate');
        
        // $crud->set_rules('M_Email', 'E-Email', 'required|valid_email');

        // $crud->field_type('M_Password', 'password');
        // $crud->field_type('M_TName', 'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        // $crud->field_type('M_Sex', 'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));

        // $dts = $this->fill_grocery_dropdown('districts',    'District_ID',  'District_Name');
        // $aps = $this->fill_grocery_dropdown('amphures',     'Amphur_ID',    'Amphur_Name');
        // $pvs = $this->fill_grocery_dropdown('provinces',    'Province_ID',  'Province_Name');
        // $zcs = $this->fill_grocery_dropdown('zipcodes',     'Zipcode_Code', 'Zipcode_Code');

        // $crud->field_type('District_ID',    'dropdown', $dts);
        // $crud->field_type('Amphur_ID',      'dropdown', $aps);
        // $crud->field_type('Province_ID',    'dropdown', $pvs);
        // $crud->field_type('Zipcode_Code',   'dropdown', $zcs);

        // $crud->field_type('M_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        // if ($crud->getState() == 'add') {
        //     $crud->field_type('M_Allow',        'hidden', '1');
        //     $crud->field_type('M_UserAdd',      'hidden', get_session('M_ID'));
        //     $crud->field_type('M_Regis',        'hidden', date("Y-m-d H:i:s"));
        //     $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
        //     $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        // }
        // if ($crud->getState() == 'edit') {
        //     $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
        //     $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        // }

        // $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        // $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        // $crud->callback_before_update(array($this,  'member_before_update_password'));
        
        // $crud->unset_add();
        // $crud->unset_list();
        // $crud->unset_delete();
        // $crud->unset_read();
        // $crud->unset_back_to_list();

        // $output = $crud->render();
        // $this->_example_output($output, $title);
    }





    /*
     *      Admin
     */

    public function admin_before_insert_datas($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function admin_before_update_password($post_array, $primary_key) {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $row = $this->common_model->get_where_custom_field('admin', 'M_ID', $primary_key, 'M_Password');
        if ($post_array['M_Password'] == $row['M_Password'])
            $post_array['M_Password'] =  $row['M_Password'];
        else
            $post_array['M_Password'] =  $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function admin_management() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(1) != '' && uri_seg(2) != '' && uri_seg(3) == 'del' && uri_seg(4) != '') 
            $this->member_delete('admin', uri_seg(1).'/'.uri_seg(2), uri_seg(4), 'M_UserUpdate', 'M_DateTimeUpdate');
        else if (uri_seg(3) == 'del' && uri_seg(4) == '') 
            redirect('member/admin_management', 'refresh');

        $title = 'ผู้ดูแลระบบ';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('admin');
        $crud->where("admin.M_Allow != ", "3");

        // $crud->set_relation('M_UserAdd',    'admin', 'M_flName');
        // $crud->set_relation('M_UserUpdate', 'admin', 'M_flName');

        $crud->display_as('M_ID',               'ไอดี');
        $crud->display_as('M_Img',              'รูปประจำตัว');
        $crud->display_as('M_Username',         'ชื่อผู้ใช้งาน');
        $crud->display_as('M_Password',         'รหัสผ่าน');
        $crud->display_as('M_TName',            'คำนำหน้าชื่อ');
        $crud->display_as('M_flName',           'ชื่อ-นามสกุล');
        $crud->display_as('M_ucName',           'Name & Lastname');
        $crud->display_as('M_Sex',              'เพศ');
        $crud->display_as('M_Birthdate',        'วันเดือนปีเกิด');
        $crud->display_as('M_npID',             'เลขประจำตัวประชาชน');
        $crud->display_as('M_Tel',              'โทรศัพท์');
        $crud->display_as('M_Email',            'อีเมล');
        $crud->display_as('M_Address',          'ที่อยู่');
        $crud->display_as('M_Allow',            'สถานะ');
        $crud->display_as('M_UserAdd',          'ผู้เพิ่มข้อมูล');
        $crud->display_as('M_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('M_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('M_UserUpdate',       'ผู้อัพเดท'); 

        $crud->required_fields('M_Username', 'M_Password');

        $crud->columns('M_Img', 'M_flName', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow');
        
        $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow', 'M_UserAdd', 'M_DateTimeAdd', 'M_DateTimeUpdate', 'M_UserUpdate');
        $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow', 'M_DateTimeUpdate', 'M_UserUpdate');
        
        $crud->set_rules('M_Email', 'E-Email', 'required|valid_email');

        $crud->field_type('M_Password', 'password');
        $crud->field_type('M_TName', 'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex', 'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('M_Allow',            'hidden', '1');
            $crud->field_type('M_UserAdd',          'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        $crud->callback_before_insert(array($this,  'admin_before_insert_datas'));
        $crud->callback_before_update(array($this,  'admin_before_update_password'));
        
        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'member/admin_management/del');
        $crud->unset_delete();

        $crud->unset_texteditor('M_Address');

        $output = $crud->render();
        $this->_example_output($output, $title);
    }

    public function admin_profile_manage() {
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if ($this->uri->segment(4) == '' || get_session('M_ID') == '' || get_session('M_ID') != uri_seg(4)) {
            header('Location: '.base_url('member/admin_profile_manage/edit/'.get_session('M_ID')));
            exit();
        }

        $title = 'ข้อมูลส่วนตัว';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('admin');
        $crud->where("admin.M_Allow != ", "3");

        $crud->display_as('M_ID',               'ไอดี');
        $crud->display_as('M_Img',              'รูปประจำตัว');
        $crud->display_as('M_Username',         'ชื่อผู้ใช้งาน');
        $crud->display_as('M_Password',         'รหัสผ่าน');
        $crud->display_as('M_TName',            'คำนำหน้าชื่อ');
        $crud->display_as('M_flName',           'ชื่อ-นามสกุล');
        $crud->display_as('M_ucName',           'Name & Lastname');
        $crud->display_as('M_Sex',              'เพศ');
        $crud->display_as('M_Birthdate',        'วันเดือนปีเกิด');
        $crud->display_as('M_npID',             'เลขประจำตัวประชาชน');
        $crud->display_as('M_Tel',              'โทรศัพท์');
        $crud->display_as('M_Email',            'อีเมล');
        $crud->display_as('M_Address',          'ที่อยู่');
        $crud->display_as('M_Allow',            'สถานะ');
        $crud->display_as('M_UserAdd',          'ผู้เพิ่มข้อมูล');
        $crud->display_as('M_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('M_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('M_UserUpdate',       'ผู้อัพเดท'); 

        $crud->required_fields('M_Username', 'M_Password');

        $crud->columns('M_Img', 'M_flName', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow');
        
        $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow', 'M_UserAdd', 'M_DateTimeAdd', 'M_DateTimeUpdate', 'M_UserUpdate');
        $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Allow', 'M_DateTimeUpdate', 'M_UserUpdate');
        
        $crud->set_rules('M_Email', 'E-Email', 'required|valid_email');

        $crud->field_type('M_Password', 'password');
        $crud->field_type('M_TName', 'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex', 'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('M_Allow',            'hidden', '1');
            $crud->field_type('M_UserAdd',          'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        $crud->callback_before_update(array($this,  'admin_before_update_password'));
        
        $crud->unset_add();
        $crud->unset_list();
        $crud->unset_delete();
        $crud->unset_read();
        $crud->unset_back_to_list();

        $crud->unset_texteditor('M_Address');

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

    public function encrypt_M_Password_callback($post_array, $primary_key = null){
	    if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
	    return $post_array;
	}
 
	public function decrypt_M_Password_callback($value){
	    if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        $decrypted_password = $this->encrypt->decode($value);
	    return "<input type='password' name='M_Password' value='$decrypted_password'>";
	}
}