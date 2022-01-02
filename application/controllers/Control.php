<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		// $this->load->database();
		$this->load->helper(array('url','form', 'general', 'file', 'html', 'asset'));
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'files_model'));
		// $this->load->library('grocery_CRUD');
		$this->load->library(array('session', 'encrypt', 'email'));
		$this->load->library('template',
			array('name' => 'admin_template1', 'setting' => array('data_output' => ''))
		);

	}

	// public function index() {
	// 	if (get_session('M_ID') == '')
 //            redirect('login', 'refresh');
 //        else {
 //            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
 //            if (count($row) <= 0) redirect('login', 'refresh');
 //        }
		
	// 	$data = array(
	// 		'content_view' 	=> 'main',
	// 		'title' 		=> 'หน้าหลัก',
	// 		'content' 		=> '',
	// 	);                                                                                                                                                      
	// 	$this->template->load('index_page',$data);
	// }

	public function index($mode = '1') {
		if (get_session('M_ID') == '')
            redirect('login', 'refresh');
        else {
            $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
            if (count($row) <= 0) redirect('login', 'refresh');
        }
		
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
        $data['content_view']   = "report/back-end/total_sales";
        $data['title']          = "หน้าหลัก";
        $data['content']		= '';
                                                                                                                                                     
        $this->template->load('index_page', $data);
	}

}
