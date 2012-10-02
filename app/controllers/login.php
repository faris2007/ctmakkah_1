<?php

/**
 * this class for add,edit and remove from login table
 * 
 * @author Faris Al-Otaibi
 */

class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("users");
        $this->lang->load('login', $this->core->site_language);
    }
    
    function index(){
        $this->login();
    }
    
    function login(){
        
        if(!$this->users->isLogin())
        {
            if($_POST){
                $username = $this->input->post('loginID',TRUE);
                $password = sha1($this->input->post('password',TRUE));
                if($this->users->login($username,$password))
                {
                    $data['ERROR'] = FALSE;
                    $data['STEP'] = "success";
                }else
                {
                    $data['ERROR'] = true;
                    $data['STEP'] = "login";
                }
            }else{
                $data['ERROR'] = FALSE;
                $data['STEP'] = "login";
                
            }
            $data['TITLE'] = $this->lang->line('login_text');
            $data['CONTENT'] = 'employee/login';
            $data['LANGUAGE'] = 'arabic';
            $this->core->load_template($data);
        }else
            redirect ("");
    }
    
}

?>
