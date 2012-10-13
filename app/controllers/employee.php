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
        $this->load->model("jobs");
        $this->load->model("employees");
    }
    
    function index()
    {
        
    }
    
    function uploadusers(){
        if(!$this->core->checkPermissions("employee","add","all","all"))
            show_404();
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3]: NULL;
        if($type != NULL){
            $string = read_file('./uploads/'.$_POST['filename']);
            $col = array();
            $line = explode("\n",$string);
            if(count($line) >= 100){
                foreach ($line as $value)
                    $col[] = explode (";", $value);
            }else
                $this->core->message("we can't read file maybe there is problem",  base_url ()."employee/uploadusers","upload Problem",2); 
            $headFile = $this->core->getHeadFile($col[0]);
            for($i=($type*100)+1;$i<=(($type*100)+100) && $i<count($col);$i++){
                if(!empty($col[$i][$headFile['id']])){
                    $user = $this->users->get_info_user("all",$col[$i][$headFile['id']]);
                    if(is_bool($user['profile'])){
                        $data = array(
                            'idn'           => isset($col[$i][$headFile['id']]) ? $col[$i][$headFile['id']] : NULL,
                            'password'      => sha1($col[$i][$headFile['id']]),
                            'en_name'       => isset($col[$i][$headFile['name']]) ? $col[$i][$headFile['name']] : NULL,
                            'mobile'        => isset($col[$i][$headFile['mobile']]) ? $col[$i][$headFile['mobile']] : NULL,
                            'is_old'        => $_POST['is_old']
                        );
                        if($this->users->register($data)){
                            $userid = $this->db->insert_id();
                            $store = array(
                                'year'        => date("Y"),
                                'isAccept'    => "A" ,
                                'grade'       => $col[$i][$headFile['position']] ,
                                'users_id'    => $userid ,
                            );
                            if(@ereg("ROVING",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 1;
                            elseif(@ereg("TRAIN",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 2;
                            elseif(@ereg("PSD",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 3;
                            elseif(@ereg("PLATFORM",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 4;
                            elseif(@ereg("LIFT",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 5;
                            elseif(@ereg("RAMP",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 6;
                            elseif(@ereg("FOOTBRIDGE",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 7;
                            elseif(@ereg("WAITING",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 9;
                            elseif(@ereg("ESCALATOR",$col[$i][$headFile['position']]))
                                    $store['jobs_id'] = 9;
                            else
                                    $store['jobs_id'] = NULL;

                            if($this->employees->addNewEmployee($store))
                                $result[$i]['doing'] = 'y';
                            else
                                $result[$i]['doing'] = 'n';
                            }else {
                                $result[$i]['doing'] = 'n'; 
                            }

                        }else
                            $result[$i]['doing'] = 'n';

                }else
                    $result[$i]['doing'] = 'n';

                $result[$i]['name'] = $col[$i][$headFile['name']];
            }

            $data['STEP'] = "last";
            $data['NUMBER'] = floor(count($line)/100);
            $data['isOld'] = $_POST['is_old'];
            $data['FILENAME'] = $_POST['filename'];
            $data['CURRENT'] = $type;
            $data['users'] = $result;
            if($type == $data['NUMBER']){
                $data['button'] = "Finish";
                $data['START'] = "";
            }else
            {
                $data['button'] = "Next >";
                $data['START'] = $type+1;
            }
        }else{
           if($_FILES){
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '4096';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if($this->upload->do_upload()){
                    $file = $this->upload->data();
                    $string = read_file('./uploads/'.$file['file_name']);
                    $col = array();
                    $line = explode("\n",$string);
                    if(count($line) >= 100){
                        foreach ($line as $value)
                            $col[] = explode (";", $value);
                    }else
                        $this->core->message("we can't read file maybe there is problem",  base_url ()."employee/uploadusers","upload Problem",2); 
                    $data['STEP'] = "second";
                    $data['NUMBER'] = floor(count($line)/100);
                    $data['isOld'] = $_POST['is_old'];
                    $data['FILENAME'] = $file['file_name'];
                }else {
                    $this->core->message("we can't upload file maybe there is problem(".$this->upload->display_errors().")",  base_url ()."employee/uploadusers","upload Problem",2); 
            }
           }else{
               $data['STEP'] = "upload";
           } 
        }
        
        $data['CONTENT'] = 'employee/upload_users';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }


    function uploadPicture(){
        if(!$this->core->checkPermissions("employee","edit","all","all"))
            show_404();
        
        $segments = $this->uri->segment_array();
        $idn = (isset($segments[3]))? $segments[3]: 0;
        if($_FILES){
            $config['upload_path'] = './store/personal_img/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['file_name'] = $idn;

            $this->load->library('upload', $config);
            if($this->upload->do_upload()){
                $data['STEP'] = "success";
                $data['MSG'] = $this->lang->line('profile_edit_success');
                $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$idn, 'type' => 'equiv'));
            }else {
                $this->core->message("we can't upload file maybe there is problem",  base_url ()."employee/profile/".$idn,"upload Problem",2); 
            }
        }else
            show_404();
        $data['CONTENT'] = 'employee/profile';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }


    function profile()
    {
        // Get User ID
        $segments = $this->uri->segment_array();
        if($this->users->isLogin() && $this->users->checkIfUser())
            $user_id = $this->users->get_info_user("id");
        else if(@$this->core->checkPermissions("employee","edit","all","all"))
            $user_id = (isset($segments[3]))? $segments[3] : $this->users->get_info_user("id");
        else
            show_404 ();
            
        $prev = (isset($segments[4]))? $segments[4] : NULL;
        
        $query1 = $this->users->get_info_user("all",$user_id);
        $userID = $query1['profile']->id;
        if(is_bool($query1['profile']))
        {    
            if(is_null($prev))
                show_404 ();
            else
                $this->core->message("This user Not Found In Database",  base_url ()."employee/users","user Not Found",1); 
        }
        else{
            $emp = $this->employees->getEmployees($userID);
            if($emp[0]->jobs_id != NULL){
                $query = $this->users->getProfileUser($userID);
            }else {
                $query = $query1['profile'];
            }
            if($_POST){
                if(@$this->core->checkPermissions("employee","profile","all","all")){
                    $store = array(
                        'gender'        => $this->input->post("gender",true),
                        'email'         => $this->input->post("email",true),
                        'mobile'        => $this->input->post("mobile",true),
                        'nationality'   => $this->input->post("nationality",true),
                        'group_id'      => ($this->input->post("group",true)==0)?NULL :$this->input->post("group",true) ,
                        'idn'           => $this->input->post("national_id",true),
                        'ar_name'       => $this->input->post("arName",true),
                        'en_name'       => $this->input->post("enName",true),
                    );
                    if($this->users->updateUser($userID,$store)){
                        $emps = $this->employees->getEmployees($userID);
                        $this->employees->updateEmployee($emps[0]->id,array(
                            "jobs_id"   => ($this->input->post("job",true)==0)? NULL : $this->input->post("job",true)
                            ));
                        $data['STEP'] = "success";
                        $data['MSG'] = $this->lang->line('profile_edit_success');
                        $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$user_id, 'type' => 'equiv'));
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
                    if($this->users->updateUser($query->id,$store)){
                        $data['STEP'] = "success";
                        $data['MSG'] = $this->lang->line('profile_edit_success');
                    }else{
                        $data['STEP'] = "view";
                        $data['ERROR'] = true;
                    }
                }
            }else{
                
                $data['profile'] = $query;
                if($this->core->checkPermissions("employee","profile","all","all")){
                    $data['group'] = $this->groups->getGroups("all");
                    $data['jobs'] = $this->jobs->getJobs("all");
                    $data['ADMIN'] = TRUE;
                }else {
                    $data['group'] = false;
                    $data['jobs'] = false;
                    $data['ADMIN'] = false;
                }
                $data['STEP'] = "view";
                $data['ERROR'] = FALSE;
            }
            $data['CONTENT'] = 'employee/profile';
            $data['TITLE'] = "Profile";
            $this->core->load_template($data);
        }
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
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL && is_numeric($start)){
           $query = $this->users->getUsers(30,$start);
           $per_url = 'employee/users/';
           $total_results = $this->users->get_total_users();
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
           $data['users'] = $query;
           $data['STEP'] = "users";
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }else  if($type == "del" && is_numeric($start)){
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
        }else if($start == "no_pic"){
           $query = $this->users->getAccpetedUsers(100,$type);
           $per_url = 'employee/users/no_pic';
           $total_results = $this->users->get_total_users();
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$type,100);
           $data['users'] = $query;
           $data['STEP'] = "list";
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }
    }


    public function signatures()
    {
        if(!(@$this->users->isLogin() && !@$this->users->checkIfUser()))
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
        if(!(@$this->users->isLogin() && !@$this->users->checkIfUser()))
            redirect ("");
        
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
