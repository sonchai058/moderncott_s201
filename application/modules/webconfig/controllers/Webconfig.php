<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webconfig extends MX_Controller {

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

	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('grocery_CRUD');
		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);
	}

	public function index()
	{
        if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }

        if (uri_seg(4) != '1') redirect('webconfig/index/edit/1', 'refresh');

        $title = 'ข้อมูลระบบ';
		$crud = new grocery_CRUD();
		$crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('webconfig');

        $crud->display_as('WD_ID',              'ไอดี');
        $crud->display_as('WD_Logo',            'โลโก้');
        $crud->display_as('WD_Icon',            'ไอคอน');
        $crud->display_as('WD_BGcolor',         'โค๊ดสี พื้นหลัง');
        $crud->display_as('WD_Themcolor',       'รูปแบบสี');
        $crud->display_as('WD_Background',      'รูปพื้นหลัง');
        $crud->display_as('WD_Name',            'ชื่อเว็บไซต์');
        $crud->display_as('WD_EnName',          'ชื่อเว็บไซต์ (อังกฤษ)');
        $crud->display_as('WD_Address',         'ที่อยู่');
        $crud->display_as('WD_Email',           'อีเมล');
        $crud->display_as('WD_Tel',             'เบอร์โทรศัพท์');
        $crud->display_as('WD_Fax',             'แฟกซ์');
        $crud->display_as('WD_Title',           'ไตเติ้ล/เรื่องย่อ');
        $crud->display_as('WD_Descrip',         'รายละเอียดเว็บไซต์');
        $crud->display_as('WD_Keyword',         'คีย์เวิร์ด');
        $crud->display_as('WD_Gglink',          'Google+ link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_Twlink',          'Twitter link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_Inlink',          'Linkedin link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_FbLink',          'Facebook link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_BG_BlockMain1',   'ภาพพื้นหลังบล็อกข่าวประกาศหน้าหลัก 1015x612');
        $crud->display_as('WD_BG_BlockMain2',   'ภาพพื้นหลังบล็อกกิจกรรมหน้าหลัก 983x574');
        $crud->display_as('WD_BG_BlockMain3',   'ภาพพื้นหลังบล็อกข้อมูลสถิติหน้าหลัก 1013x587');
        $crud->display_as('WD_BG_Footer',       'ภาพพื้นหลังบล็อกข้อมูลสถิติหน้าหลัก 1918x784');
        $crud->display_as('WD_BG_BlockSub',     'ภาพพื้นหลังบล็อกอ่านข่าวหน้าย่อย 1032x629');
        $crud->display_as('WD_Latitude',        'พิกัด (Latitude)');
        $crud->display_as('WD_Longjitude',      'พิกัด (Longitude)');
        $crud->display_as('WD_ImgMap',          'รูปหมุดในแผนที่');
        $crud->display_as('WD_SlideConfig',     'ค่า config ภาพสไลด์(ฆerialize)');
        $crud->display_as('WD_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('WD_DatetimeUpdate',  'วันเวลาที่อัพเดท');
        
        $crud->required_fields('WD_Name', 'WD_Address', 'WD_Tel', 'WD_Title', 'WD_Email');

        $crud->columns('WD_ID', 'WD_Logo', 'WD_Icon', 'WD_BGcolor', 'WD_Themcolor', 'WD_Background', 'WD_Name', 'WD_EnName', 'WD_Address', 'WD_Email', 'WD_Tel', 'WD_Fax', 'WD_Title', 'WD_Descrip', 'WD_Keyword', 'WD_Gglink', 'WD_Twlink', 'WD_Inlink', 'WD_FbLink', 'WD_BG_BlockMain1', 'WD_BG_BlockMain2', 'WD_BG_BlockMain3', 'WD_BG_Footer', 'WD_BG_BlockSub', 'WD_Latitude', 'WD_Longjitude', 'WD_ImgMap', 'WD_SlideConfig', 'WD_UserUpdate', 'WD_DatetimeUpdate');
        
        $crud->edit_fields('WD_Logo', 'WD_Icon', 'WD_Name', 'WD_EnName', 'WD_Address', 'WD_Email', 'WD_Tel', 'WD_Fax', 'WD_Title', 'WD_Descrip', 'WD_Keyword', 'WD_Gglink', 'WD_Twlink', 'WD_Inlink', 'WD_FbLink', 'WD_Latitude', 'WD_Longjitude', 'WD_ImgMap');
        
        $crud->set_rules('WD_Email', 'E-Email', 'required|valid_email');

        $crud->field_type('WD_UserUpdate',      'hidden', get_session('M_ID'));
        $crud->field_type('WD_DatetimeUpdate',  'hidden', date("Y-m-d H:i:s"));

        $crud->set_field_upload('WD_Logo',      'assets/images');
        $crud->set_field_upload('WD_Icon',      'assets/images');
        $crud->set_field_upload('WD_ImgMap',    'assets/images');

        $crud->unset_add();
        $crud->unset_list();
        $crud->unset_delete();
        $crud->unset_read();
        $crud->unset_back_to_list();

        $crud->unset_texteditor('WD_Address');
        $crud->unset_texteditor('WD_Title');
        $crud->unset_texteditor('WD_Descrip');
        $crud->unset_texteditor('WD_Keyword');
        $crud->unset_texteditor('WD_Gglink');
        $crud->unset_texteditor('WD_Twlink');
        $crud->unset_texteditor('WD_Inlink');
        $crud->unset_texteditor('WD_FbLink');

        $output = $crud->render();
        $this->_example_output($output, $title);
	}

	function _example_output($output = null, $title = null){
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

	// public function template_show(){
    //      set_js_asset_head('jquery_header1.js');
	// 	set_js_asset_head('jquery_header1.js','news');

	// 	$data=array(
	// 		'content_view'=>'welcome_message',
	// 		'title'=>'Template Convertor',
	// 		'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id illo excepturi, sint odio, adipisci saepe maiores minima in. Quo enim velit corporis illum 
	// 					sint accusamus esse nostrum eaque ullam, eligendi!',
	// 	);
	// 	$this->template->load('index_page',$data,'news');

	// }
}
