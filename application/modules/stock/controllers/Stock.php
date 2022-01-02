<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MX_Controller {

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
	public function index()
	{
		test();
		$this->test_model->test1();
		$this->load->view('front-end/welcome_message');
	}
	public function display(){
		echo '<br>Stock Display<hr>';
	}

	public function display1($params){
		echo '<br>display1';
		var_dump($params);
		echo '<hr>';
	}

	public function add($params){
		return $params[0]+$params[1];
	}	

	public function display2(){
		$this->load->view('front-end/welcome_message1');
	}
}
