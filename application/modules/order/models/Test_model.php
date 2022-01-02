<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Test_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

    public function test1(){
        echo 'test_model module order<br>';
    }
}
?>
