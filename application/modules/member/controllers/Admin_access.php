<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_access extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);

	}
	public function index() {
		$this->isLogin();
	}

	public function isLogin() {
		if (get_session('M_ID') != '') {
			redirect('control', 'refresh');
		} 
		else {
			$row = $this->webinfo_model->getOnceWebMain();
			$data['title'] = $row['WD_Name'].' (Login)';
			$data['captcha'] = $this->admin_model->createCaptcha();
			$this->template->load('login', $data);
		}
	}

	public function login() {
		$row = rowArray($this->admin_model->getLoginEncrypt(get_inpost('user_id'), get_inpost('user_pass')));
		// $row = rowArray($this->admin_model->getLoginMD5(get_inpost('user_id'), get_inpost('user_pass')));
		if (isset($row['M_ID']) && $this->admin_model->ConfirmCaptcha()) {
			if ($row['M_Allow'] != '3') {
				set_session('M_ID', $row['M_ID']);
				set_session('M_Username', $row['M_Username']);
				$M_TName_arr = array(
					"1" => "นาง", 
					"2" => "นางสาว", 
					"3" => "นาย", 
					"4" => "ไม่ระบุ"
				);
				set_session('M_flName', $M_TName_arr[$row['M_TName']].$row['M_flName']);
				if ($row['M_Img'] != '')
					set_session('M_Img', $row['M_Img']);
				else
					set_session('M_Img', 'no_img.jpg');
				// set_session('M_GroupUser', $row['M_GroupUser']);
				// set_session('WD_ID', $row['WD_ID']);
				// $this->common_model->insert('statistics', array('S_IP' => $this->admin_model->kh_getUserIP(), 'S_UserAgent' => $this->admin_model->get_http_user_agent(), 'S_Type' => '2', 'ID' => $row['M_ID']));
			}
			else
				print("<script language='javascript'>alert('Please Contact Support!');</script>");
		}
		else
			print("<script language='javascript'>alert('Login Failed!');</script>");
			// print("<script language='javascript'>alert('');</script>");
		// redirect('admin_access', 'refresh');
		redirect('login', 'refresh');
		// die(print_r($this->session->all_userdata()));
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
