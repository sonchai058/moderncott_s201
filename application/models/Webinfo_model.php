<?php
	class Webinfo_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

    public function getOnceWebMain(){
        return rowArray($this->common_model->custom_query("select * from webconfig"));
    }

}
?>


