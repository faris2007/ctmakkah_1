<?php

/**
 * this class for add,edit and remove from login table
 * 
 * @author Faris Al-Otaibi
 */

class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
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
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  $this->session->userdata('prePage'), 'type' => 'equiv'));
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
            $this->core->load_template($data);
        }else
            redirect ("");
    }
    
    
    function logout()
    {
        if($this->users->isLogin()){
            $this->users->logout();
            $this->session->set_userdata("prePage",  base_url());
            redirect("login");
        }else
            redirect("");
    }
    
    function register(){
        $this->load->model("employee");
        $this->load->model("attachments");
        if($_POST){
            $step = $this->input->post("step",true);
            if($step == 1){
                $idn = $this->input->post("ID",true);
                $expiry= $this->input->post("expiry",true);
                $check = $this->users->get_info_user("all",$idn);
                if(is_bool($check['profile'])){
                    $data['ERROR'] = False;
                    $data['STEP'] = 2;
                    $data['ID'] = $idn;
                    $data['expiry'] = $expiry;
                }else {
                    $this->db->where("year",date("Y"));
                    $this->db->where("users_id",$check['profile']->id);
                    $result = $this->employee->getEmployees("ALL");
                    if(!$result){
                        $data['ERROR'] = False;
                        $data['STEP'] = 4;
                        $data['MSG'] = $this->lang->line('register_employee_error');
                    }else {
                        $store = array(
                            'year'      => date("Y"),
                            'isAccept'  => "C",
                            'users_id'  => $check['profile']->id
                        );
                        if($this->employee->addNewEmployee($store))
                        {    
                            $data['ERROR'] = False;
                            $data['STEP'] = 4;
                        }else
                        {
                            $data['ERROR'] = true;
                            $data['STEP'] = 1;
                        }
                    }
                }
            }elseif ($step == 2) {
                $idn = $this->input->post("ID",true);
                $expiry= $this->input->post("expiry",true);
                $password = $this->input->post("password",true);
                $repassword = $this->input->post("repassword",true);
                if($password == $repassword){
                    $store = array(
                        'ar_name'           => $this->input->post("arName",true),
                        'en_name'           => $this->input->post("enName",true),
                        'idn'               => $idn,
                        'expiry_date'       => $expiry,
                        'birth_date'        => $this->input->post("birthDate",true),
                        'nationality'       => $this->input->post("nationality",true),
                        'mobile'            => $this->input->post("mobile",true),
                        'password'          => sha1($password),
                        'email'             => $this->input->post("email",true),
                        'certificate'       => $this->input->post("certificate",true),
                        'specialisatie'     => $this->input->post("specialization",true),
                        'gender'            => $this->input->post("gender",true),
                        'address'           => $this->input->post("address",true),
                        'city'              => $this->input->post("city",true)
                    );
                    if($this->users->register($store))
                    {
                        $check = $this->users->get_info_user("all",$idn);
                        $storeE = array(
                            'year'      => date("Y"),
                            'isAccept'  => "C",
                            'users_id'  => $check['profile']->id
                        );
                        $this->employee->addNewEmployee($storeE);
                        $data['ERROR'] = False;
                        $data['STEP'] = 3;
                        $data['ID'] = $check['profile']->id;
                    }else
                    {
                        $data['ERROR'] = true;
                        $data['STEP'] = 2;
                    }
                }else {
                    $data['ERROR'] = true;
                    $data['STEP'] = 2;
                    $data['ID'] = $idn;
                    $data['expiry'] = $expiry; 
                }
                
            }elseif ($step == 3) {
                if(!isset($_POST['skip'])) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
                    $config['max_size'] = '2048';
                    $config['encrypt_name'] = true;
                    $this->load->library('upload', $config);
                    $uploadFile = array(
                        'picture'       => "Personal Picture",
                        'identity'      => "Identity Card",
                        'certificate'   => "Academic certificate",
                        'training'      => "Metro training certificate"
                        );
                    foreach ( $uploadFile as $key => $value){
                        if (!$this->upload->do_upload($key))
                        {
                            $data['ERROR'] = true;
                            $data['STEP'] = 3;
                            break;
                        }
                        else
                        {
                            $uploadData = $this->upload->data();
                            $store = array(
                                'name'      => $value,
                                'file_url'  => $uploadData['full_path'],
                                'users_id'  => $this->input->post("ID",true)
                            );
                            $this->attachments->addNewAttachment($store);
                        }
                        $data['ERROR'] = (isset($data['ERROR']))? $data['ERROR'] : false;
                        $data['STEP'] = (isset($data['STEP']))? $data['STEP'] : 4;
                        $data['MSG'] = $this->lang->line('register_success');
                    }
                }else{
                    $data['ERROR'] = false;
                    $data['STEP'] = 4;
                    $data['MSG'] = $this->lang->line('register_success');
                }
                    
            }
            
        }else{
            $data['ERROR'] = False;
            $data['STEP'] = 1;
        }
        $data['TITLE'] = $this->lang->line('register_text');
        $data['CONTENT'] = 'employee/register';
        $this->core->load_template($data);
    }
    
}

?>
