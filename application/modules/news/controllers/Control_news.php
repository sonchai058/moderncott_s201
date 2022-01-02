<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_news extends MX_Controller {

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

		$this->load->library('template',
			array('name'=>'admin_template1',
				  'setting'=>array('data_output'=>''))
		);

	}

	public function index()
	{
		echo site_url().'<br>';
		echo 'test load model'.$this->admin_model->kh_getUserIP().'<hr><br>';

		$stock=$this->load->module('stock');
		$this->stock->display();

		$stock1=$this->load->module('stock/display');
		$stock1->stock->display();


		$this->stock->display1(array('000','333'));
		echo Modules::run('stock/display1', array('222','333'));
		
		echo Modules::run('stock/add', array(1,2)).'<hr>';

		echo Modules::run('stock/display2', array('222','333'));

		//echo '<br/>'.site_url();
		$this->load->view('back-end/welcome_message');


	}
	public function template_show(){

		set_js_asset_head('jquery_header1.js');
		set_js_asset_head('jquery_header1.js','news');


		$data=array(
			'content_view'=>'welcome_message',
			'title'=>'Template Convertor',
			'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id illo excepturi, sint odio, adipisci saepe maiores minima in. Quo enim velit corporis illum 
						sint accusamus esse nostrum eaque ullam, eligendi!',
		);
		$this->template->load('index_page',$data,'news');

	}
}
