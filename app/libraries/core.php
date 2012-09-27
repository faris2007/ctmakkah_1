<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core {
	
    private $CI;
    private $Token,$Old_Token,$New_Token;

    public function __construct()
    {
            // Load Class CI
            $this->CI =& get_instance();
            $this->CI->load->model("user_model","users");
    }

    public function load_setting()
    {

    }

    public function generate_token()
    {
            // Token
            $this->Token = $this->session->userdata('New_Token');
            $this->New_Token = sha1(rand(1000,9999) * rand(1000,9999));
            $this->Token = ($this->Token != '') ? $this->Token : $this->New_Token;
    }

    public function token($generate = FALSE)
    {
            $generate = (is_bool($generate)) ? $generate : FALSE;

            if ($generate)
            {
                    return $this->New_Token;
            }else{
                    return $this->Token;
            }
    }

    public function load_template($temp_data = array(),$load_only = FALSE)
    {

            // Page Title
            $data['HEAD']['TITLE'] = (isset($temp_data['TITLE'])) ? $temp_data['TITLE'] : '';

            // Meta	
            $data['HEAD']['META']['ROBOTS'] = (isset($data['HEAD']['META']['ROBOTS'])) ? 'none' : 'all';
            $data['HEAD']['META']['DESC'] = (isset($data['HEAD']['META']['DESC'])) ? $data['HEAD']['META']['DESC'] : '';
            $data['HEAD']['META']['KW'] = (isset($data['HEAD']['META']['KW'])) ? $data['HEAD']['META']['KW'] : '';
            $data['HEAD']['META']['META'] = array(
                    array('name' => 'robots', 'content' => $data['HEAD']['META']['ROBOTS']),
                    array('name' => 'description', 'content' => $data['HEAD']['META']['DESC']),
                    array('name' => 'keywords', 'content' => $data['HEAD']['META']['KW'])
            );

            // Other Code ( HTML -> HEAD )
            $data['HEAD']['OTHER'] = (isset($temp_data['HEAD'])) ? $temp_data['HEAD'] : '';

			// Main Menu
			$data['MENU'] = (isset($temp_data['MENU'])) ? $temp_data['MENU'] : $this->CI->load->view('menu',NULL,TRUE);
			
            // Content
            $data['CONTENT'] = (isset($temp_data['CONTENT'])) ? $this->CI->load->view($temp_data['CONTENT'],$temp_data,TRUE) : '' ;

            // Main Template
            $load_only = (is_bool($load_only)) ? $load_only : FALSE;

            if ($load_only)
            {
                    return $this->CI->load->view('template',$data,TRUE);
            }else{
                    $this->CI->load->view('template',$data);
            }
    }
    
    public function checkPermissions($service_name = "admin",$function_name = "all",$value = "all",$otherValue = "all")
    {
        if(empty($service_name) || empty($function_name) || empty($value) || empty($otherValue))
            return false;
        
        if($this->users->isLogin())
            redirect ('login');
        
        if($this->users->checkifUser())
            return FALSE;
        
        if ($service_name == "admin")
        {
            if(!$this->users->checkifUser())
                return true;
            else 
                return false;
        }else
        {
            return $this->users->checkIfHavePremission($service_name,$function_name,$value,$otherValue);
        }
        
    }
    
}

?>