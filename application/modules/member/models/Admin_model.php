<?php
class admin_model extends CI_Model {

    public function __construct(){
        parent::__construct();
		// $this->load->driver('cache');
    }
    /*
    public function getLogin($user_id = '', $user_pass = '') {
        $row = $this->common_model->get_where_custom_and('admin', array('M_Username' => mysql_real_escape_string($user_id), 'M_Password' => mysql_real_escape_string($user_pass)));
        return $row;
    }

    public function getLoginMD5($user_id = '', $user_pass = '') {
        $row = $this->common_model->get_where_custom_and('admin', array('M_Username' => mysql_real_escape_string($user_id), 'M_Password' => md5(mysql_real_escape_string($user_pass))));
        return $row;
    }

    public function getLoginEncrypt($user_id = '', $user_pass = '') {
        $row = $this->common_model->get_where_custom('admin', 'M_Username', mysql_real_escape_string($user_id));
        if (count($row) > 0) {
            $pass = $this->encrypt->decode($row[0]['M_Password']);
            if (mysql_real_escape_string($user_pass) == $pass)
                return $row;
        }
        else
            return array();
    }
    */

    public function getLogin($user_id = '', $user_pass = '') {
        // $row = $this->common_model->get_where_custom_and('member', array('M_Username' => $this->db->escape_str($user_id), 'M_Password' => $this->db->escape_str($user_pass)));
        $row = $this->common_model->get_where_custom_and('admin', array('M_Username' => $this->db->escape_str($user_id), 'M_Password' => $this->db->escape_str($user_pass)));
        return $row;
    }
    public function getLoginMD5($user_id = '', $user_pass = '') {
        // $row = $this->common_model->get_where_custom_and('admin', array('M_Username' => $this->db->escape_str($user_id), 'M_Password' => md5($this->db->escape_str($user_pass))));
        $row = $this->common_model->get_where_custom_and('admin', array('M_Username' => $this->db->escape_str($user_id), 'M_Password' => md5($this->db->escape_str($user_pass))));
        return $row;
    }
    public function getLoginEncrypt($user_id = '', $user_pass = '') {
        // $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str($user_id));
        $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str($user_id));
        if (count($row) > 0) {
            $pass = $this->encrypt->decode($row[0]['M_Password']);
            if ($this->db->escape_str($user_pass) == $pass)
                return $row;
        }
        else
            return array();
    }

    public function AfterDelete_DeleteImage($table='',$field_name='',$value='',$field_delete='',$path=''){
        $rows=$this->common_model->get_where_custom_field($table,$field_name,$value,$field_delete);
        foreach($rows as $row){
            @unlink($path.$row[$field_delete]);
        }
    }

    public function BlockLevel($levels=array()){
        if(get_session('M_GroupUser')==''){
            redirect('login','refresh');
            exit();
        }
        else {
            foreach($levels as $level){
                if($level==get_session('M_GroupUser')){
                    redirect('login','refresh');
                    exit();
                }
            }
        }
    }

    //get user real ip
     public function kh_getUserIP(){
           $client  = @$_SERVER['HTTP_CLIENT_IP'];
           $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
           $remote  = $_SERVER['REMOTE_ADDR'];

           if(filter_var($client, FILTER_VALIDATE_IP)){
               $ip = $client;
           }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
               $ip = $forward;
           }else{
               $ip = $remote;
           }
           return $ip;
      }

      public function get_http_user_agent(){
        return $_SERVER['HTTP_USER_AGENT'];
      }

      public function getMac(){
        /*
        * Getting MAC Address using PHP
        * Md. Nazmul Basher
        */

        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom=ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer

        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac=substr($mycom,($pmac+36),17); // Get Physical Address

        return $mac;
      }
      public function getCoordinatesFromAddress( $sQuery, $sCountry = 'it' )
      {
          $sURL = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$sCountry.'&language='.$sCountry;
          $sData = file_get_contents($sURL);
          return json_decode($sData);
       }

      public function getAddressFromCoordinates( $dLatitude, $dLongitude, $sCountry = 'it' )
      {
        $sURL = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode("$dLatitude,$dLongitude").'&sensor=false&region='.$sCountry.'&language='.$sCountry;
        $sData = file_get_contents($sURL);
      	return json_decode($sData);
      }
      public function get_requesttime(){
        return $_SERVER['REQUEST_TIME'];
      }
      public function getDeviceType(){
        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
            $mobile_browser = 0;
            dieFont('windows');
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'mac') > 0) {
                $mobile_browser = 0;
                dieFont('mac');
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ios') > 0) {
                $mobile_browser = 1;
                dieFont('ios');
        }
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') > 0) {
                $mobile_browser = 1;
                dieFont('android');
        }

        if($mobile_browser == 0)
        {
            //its a mobile browser
        } else {
            //its not a mobile browser
        }
      }

      public function createCaptcha(){
    		$this->load->helper('captcha');
    		$vals = array(

    		        'img_path'      => './assets/captcha/',
    		        'img_url'       => base_url('assets/captcha/'),
    		        'img_width'     => '110',
    		        'img_height'    => 45,
    		        'expiration'    => 7200,
    		        'word_length'   => 5,
    		        'font_size'     => 25,
    		        'img_id'        => 'Imageid',
    		        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

    		        // White background and border, black text and red grid
    		        'colors'        => array(
    		                'background' => array(255, 255, 255),
    		                'border' => array(255, 255, 255),
    		                'text' => array(0, 0, 0),
    		                'grid' => array(255, 40, 40),
                            'font' => array(222,43,24)
    		        )
    		);

    		$cap = create_captcha($vals);
    		$data = array(
    		        'captcha_time'  => $cap['time'],
    		        'ip_address'    => $this->input->ip_address(),
    		        'word'          => $cap['word']
    		);

    		$query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);

    		/*
    		echo 'Submit the word you see below:';
    		echo $cap['image'];
    		echo '<input type="text" name="captcha" value="" />';
        */
        return $cap['image'];
    	}

      public function ConfirmCaptcha(){
        // First, delete old captchas
        $expiration = time() - 7200; // Two hour limit
        $this->db->where('captcha_time < ', $expiration)
                ->delete('captcha');

        // Then see if a captcha exists:
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array(get_inpost('captcha'), $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if($row->count == 0)
          return false;
        else
          return true;
      }
      
    public function cannot_access(){
        if(getUser()!='')
            dieFont("Cannot Access!");
        else
            redirect('login','refresh');
        exit();
    }
    /*
    public function accessBlock($M_GroupUser,$P_ID){
        $temp=$this->suborder_model->getOncePermission($M_GroupUser,$P_ID);
        if(!isset($temp['PM_ID']))
            $this->cannot_access();
        else return $temp;      
    } 
    */   
}

?>
