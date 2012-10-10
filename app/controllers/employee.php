<?php

/**
 * this class for add,edit and remove from login table
 * 
 * @author Ahmad S AlGhamdi
 */
class Employee extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('login', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
        $this->load->model("groups");
        $this->load->model("employees");
    }
    
    function index()
    {
        
    }
    
    function profile()
    {
        // Get User ID
        $segments = $this->uri->segment_array();
        $user_id = (isset($segments[3]))? $segments[3] : $this->users->get_info_user("id");
        
        if($_POST){
            if(@$this->core->checkPermissions("employee","profile","all","all")){
                $store = array(
                    'gender'        => $this->input->post("gender",true),
                    'email'         => $this->input->post("email",true),
                    'mobile'        => $this->input->post("mobile",true),
                    'nationality'   => $this->input->post("nationality",true),
                    'group_id'      => $this->input->post("group",true),
                    'idn'           => $this->input->post("national_id",true),
                    'ar_name'       => $this->input->post("arName",true),
                    'en_name'       => $this->input->post("enName",true),
                );
                if($this->users->updateUser($user_id,$store)){
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('profile_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'employee/profile/'.$user_id, 'type' => 'equiv'));
                }else{
                    $data['STEP'] = "view";
                    $data['ERROR'] = true;
                }
            }else{
                $store = array(
                    'gender'        => $this->input->post("gender",true),
                    'email'         => $this->input->post("email",true),
                    'mobile'        => $this->input->post("mobile",true),
                    'nationality'   => $this->input->post("nationality",true)
                );
                if($this->users->updateUser($user_id,$store)){
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('profile_edit_success');
                }else{
                    $data['STEP'] = "view";
                    $data['ERROR'] = true;
                }
            }
        }else{
            if(!@$this->core->checkPermissions("employee","profile","all","all"))
                redirect ("");
            $query = $this->users->get_info_user("all",$user_id);
            $data['profile'] = $query['profile'];
            if($this->core->checkPermissions("employee","profile","all","all")){
                $data['group'] = $this->groups->getGroups("all");
                $data['ADMIN'] = TRUE;
            }else {
                $data['group'] = false;
                $data['ADMIN'] = false;
            }
            $data['STEP'] = "view";
            $data['ERROR'] = FALSE;
        }
        $data['CONTENT'] = 'employee/profile';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }
    
    function candidate(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getCandidate();
           $per_url = 'employee/condidate/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $this->users->getCandidate(30,$start);;
           $data['CONTENT'] = 'employee/candidate';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function accepted(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getAccpetedUsers();
           $per_url = 'employee/accepted/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $this->users->getAccpetedUsers(30,$start);;
           $data['CONTENT'] = 'employee/accepted';
           $data['TITLE'] = "List Of Accepted";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function rejected(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getRejectedUsers();
           $per_url = 'employee/accepted/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $this->users->getRejectedUsers(30,$start);
           $data['CONTENT'] = 'employee/rejected';
           $data['TITLE'] = "List Of Rejected";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function precaution(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getPrecautionUsers();
           $per_url = 'employee/precaution/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $this->users->getPrecautionUsers(30,$start);;
           $data['CONTENT'] = 'employee/precaution';
           $data['TITLE'] = "List Of Precaution";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function users(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 1;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getUsers(30,$start);
           $per_url = 'employee/users/';
           $total_results = $this->users->get_total_users();
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $query;
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }else  if($type == "del"){
            if($userID != 0){
                $userInfo = $this->users->get_info_user("all",$userID);
                if(is_bool($userInfo['profile']))
                    echo "The user is Not Found";
                
                if(@$this->users->deleteUser($userID))
                    echo "Delete successfully";
                else
                    echo "Delete Wrong!";
            }else
                echo "There is problem";
        }
    }


    public function signatures()
    {
        if(@$this->users->isLogin() && !@$this->users->checkIfUser())
            redirect ("");
        $EmployeeId = is_numeric($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : 0;
        
        if ($this->input->post('signature',TRUE))
        {
            $this->employees->signature($this->input->post('employee_id',TRUE),$this->input->post('signature',TRUE));
        }
        
        $data['EMPLOYEE_ID'] = $EmployeeId;
        $data['SIGNATURE'] = $this->employees->signature($EmployeeId);
        $this->load->view('signature',$data);
    }
    
    public function cards()
    {

        $action = (in_array($this->input->post('do',TRUE),array('main','print'))) ? $this->input->post('do',TRUE) : 'main';
        
        $data['TYPE'] = $action;
            
        if ($action == 'print'){
           $employee_id = ($this->input->post('employee_id',TRUE) != '') ? $this->input->post('employee_id',TRUE) : '0';
           $emp_data = $this->users->get_card_data($employee_id);
           if ($emp_data)
           {
               $data['idn'] = $emp_data->idn;
               $data['name'] = $emp_data->en_name;
               $data['job'] = $this->jobs->job_name($emp_data->jobs_id);
			   die($this->load->view('employee/card',$data,TRUE));
           }else{
               $data['MSG'] = 'ID Error';
               $data['TYPE'] = 'main';
           }
        }
		$data['CONTENT'] = 'employee/card';
		$this->core->load_template($data);
		
    }
    
}

?>
