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
        $start = (isset($segments[3]))? $segments[3] : 1;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getCandidate(30,$start);
           $per_url = 'employee/condidate/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $query;
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
    
    function users(){
        
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
    
}

?>
