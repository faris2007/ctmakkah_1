<?php

/**
 * this class for add,edit and remove from attendance table
 * 
 * @author Faris Al-Otaibi
 */
class attendance extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("attendances");
        $this->load->model("groups");
        $this->lang->load('attendance', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
        $this->lang->load('login', $this->core->site_language);
    }
    
    function index(){
        if(@$this->core->checkPermissions("attendance","view","all","all"))
            $this->view();
        else if($this->users->isLogin() && !$this->users->checkIfuser())
            $this->takeAttendance ();
        else
            redirect ("");
    }
    
    function takeattendance(){
        
        $segments = $this->uri->segment_array();
        $groupID = (isset($segments[3]))? $segments[3] : 0;
        $userInfo = $this->users->get_info_user("id");
        if($groupID == 0){
           $data['STEP'] = 'attend';
           $this->db->where("superviser",$userInfo);
           $query = $this->attendances->getAttendance("all");
           if($query){
                $this->db->where("attend_id",$query[0]->id);
                $data['query'] = $this->groups->getGroups("all");
           }else
               show_404 ();
        }else{
           $groupInfo = $this->groups->getGroups($groupID);
           $attendId = $groupInfo[0]->attend_id;
           $this->db->where("date",date("y-m-d"));
           $this->db->where("attend_id",$attendId);
           $this->db->where("group_id",$groupID);
           $check = $this->attendances->getAttendanceToday("all");
           if(is_bool($check)){
               if($this->attendances->startAttendance($attendId,$groupID)){
                   $attendTodayId = $this->db->insert_id();
                   $data['STEP'] = 'take';
                   $this->db->where("attend_id",$attendId);
                   $this->db->where("group_id",$groupID);
                   $data['attend'] = $this->attendances->getAttendanceToday("all");
                   $this->db->where("group_id",$groupID);
                   $data['users'] = $this->users->getUsers();
                   $data['attendTodayId'] = $attendTodayId;
                   $data['GROUPID'] = $groupID;
               }else {
                  $data['STEP'] = 'attend';
                  $this->db->where("superviser",$userInfo);
                  $query = $this->attendances->getAttendance("all");
                  $this->db->where("attend_id",$query[0]->id);
                  $data['query'] = $this->groups->getGroups("all");
               }
           }else{
               $attendTodayId = $check[0]->id;
               $data['STEP'] = 'take'; 
               $this->db->where("attend_id",$attendId);
               $this->db->where("group_id",$groupID);
               $data['attend'] = $this->attendances->getAttendanceToday("all");
               $this->db->where("group_id",$groupID);
               $data['users'] = $this->users->getUsers();
               $data['attendTodayId'] = $attendTodayId;
               $data['GROUPID'] = $groupID;
           }
        }
        $data['TITLE'] = $this->lang->line('attendance_view');
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }
    
    function report(){
        
        $segments = $this->uri->segment_array();
        $groupID = (isset($segments[3]))? $segments[3] : 0;
        if($groupID != 0){
            $groupInfo = $this->groups->getGroups($groupID);
            $attendId = $groupInfo[0]->attend_id;
            $data['STEP'] = 'report'; 
            $this->db->where("attend_id",$attendId);
            $this->db->where("group_id",$groupID);
            $data['attend'] = $this->attendances->getAttendanceToday("all");
            $this->db->where("group_id",$groupID);
            $data['users'] = $this->users->getUsers();
            $data['GROUPID'] = $groupID;
        }else
            show_404 ();
        
        $data['TITLE'] = $this->lang->line('attendance_view');
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }


    function view(){
         if(@$this->core->checkPermissions("attendance","view","all","all")){
            $data['query'] = $this->attendances->getAttendance("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('attendance_view');
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }
    
    function add(){
        if(@$this->core->checkPermissions("attendance","add","all","all")){
            if($_POST){
                $store = array(
                    'name'        => $this->input->post("name",true),
                    'superviser'  => ($this->input->post("superviser",true) == 0)? NULL : $this->input->post("superviser",true)
                );
                if(!$this->attendances->addNewAttendance($store)){
                    $where = "group_id IN (SELECT id FROM `group` where is_admin ='y')";
                    $this->db->where($where);
                    $data['query'] = $this->users->getUsers();
                    $data['STEP'] = "add";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('attendance_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'attendance', 'type' => 'equiv'));
                }
            }else{
                $where = "group_id IN (SELECT id FROM `group` where is_admin ='y')";
                $this->db->where($where);
                $data['query'] = $this->users->getUsers();
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('attendance_view');
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("attendance","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $attendanceID = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : "attendance";
        $userid = (isset($segments[5]))? $segments[5] : 0;
        if(is_numeric($type)){
            if($attendanceID != 0 && $type !=0){
                $row = $this->attendances->getAttendanceSheet($attendanceID,$type);
                if(is_bool($row))
                    echo $this->lang->line('attendance_delete_error');
                
                if($this->attendances->deleteAttendanceSheet($row[0]->id))
                    echo $this->lang->line('attendance_delete_success');    
                else
                    echo $this->lang->line('attendance_delete_error');  

                }else
                    echo $this->lang->line('attendance_delete_error');
        }elseif($type == "attendance"){
            if($attendanceID != 0){
                $row = $this->attendances->getAttendance($attendanceID);
                if(is_bool($row))
                    echo $this->lang->line('attendance_delete_error');

            if($this->attendances->deleteAttendance($attendanceID))
                echo $this->lang->line('attendance_delete_success');    
            else
                echo $this->lang->line('attendance_delete_error');  

            }else
                echo $this->lang->line('attendance_delete_error');
        }else if($type == "group"){
            if($attendanceID != 0){
                $row = $this->groups->getGroups($attendanceID);
                if(is_bool($row))
                    echo $this->lang->line('attendance_delete_error');
            
                $data['attend_id'] = NULL;
                if($this->groups->updateGroup($attendanceID,$data))
                    echo $this->lang->line('attendance_delete_success');    
                else
                    echo $this->lang->line('attendance_delete_error');  

                }else
                    echo $this->lang->line('attendance_delete_error');
        }
    }


    function edit(){
        $attendanceID = $this->uri->segment(3, 0);
        if(@$this->core->checkPermissions("attendance","edit","all","all")){
            if($_POST){
                $store = array(
                    'name'        => $this->input->post("name",true),
                    "superviser"  => ($this->input->post("superviser",true) == 0)? NULL : $this->input->post("superviser",true)
                );
                if(!$this->attendances->updateAttendance($attendanceID,$store)){
                    $data['STEP'] = "edit";
                    $data['ID'] = $attendanceID;
                    $row = $this->attendances->getAttendance($attendanceID);
                    if(!is_bool($row)){
                        $data['NAME'] = $row[0]->name;
                        $data['LOCATION'] = $row[0]->location;
                        $data['ISADMIN'] = $row[0]->is_admin;
                    }else
                        show_404 ();
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('attendance_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'attendance', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "edit";
                $data['ID'] = $attendanceID;
                $row = $this->attendances->getAttendance($attendanceID);
                if(!is_bool($row)){
                    $data['NAME'] = $row[0]->name;
                    $data['SUPERVISER'] = $row[0]->superviser;
                    $where = "group_id IN (SELECT id FROM `group` where is_admin ='y')";
                    $this->db->where($where);
                    $data['query'] = $this->users->getUsers();
                }else
                    show_404 ();
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('attendance_view');
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }
    
    function show($attendanceId,$start = 0){
        if(!@$this->core->checkPermissions("attendance","show","all","all"))
                redirect ("");
        if(empty($attendanceId))
            show_404 ();
        
        
        $attendanceInfo = $this->attendances->getAttendance($attendanceId);
        $data['STEP'] = "show";
        $data['NAME'] = $attendanceInfo[0]->name;
        if($attendanceInfo[0]->superviser != Null){
            $userinfo = $this->users->get_info_user("all",$attendanceInfo[0]->superviser);
            $data['SUPERVISER'] = $userinfo['profile']->en_name;
        }else
            $data['SUPERVISER'] = "Nothing";
        $data['ID'] = $attendanceId;
        $this->db->where("attend_id",$attendanceId);
        $data['groups'] = $this->groups->getGroups("all");
        $data['TITLE'] = "add users to attendance";
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }
    
    function addgrouptoattend(){
        $attendId = is_numeric($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : 0;
        $start = (is_numeric($this->uri->segment(4, 1))) ? $this->uri->segment(4, 1) : 1;

        if(!@$this->core->checkPermissions("attendance","add","all","all")) redirect ();
        
        
        $data['STEP'] = "addgroups";
        $data['ID'] = $attendId;
        $this->db->where("attend_id !=",$attendId);
        $data['query'] = $this->groups->getGroups("all");
        $data['TITLE'] = "add Group to Attend";
        $data['CONTENT'] = 'employee/attendance';
        $this->core->load_template($data);
    }

    function added($groupid,$attendanceid,$attendTodatId = 'group')
    {
        if(!@$this->core->checkPermissions("attendance","add","all","all"))
            redirect ("");
        if(empty($groupid) || empty($attendanceid))
            echo "You have errorin parmeters";
        
        if($attendTodatId == "group"){
            $data['attend_id'] = $attendanceid;
            if($this->groups->updateGroup($groupid,$data))
                echo "added successfully";
            else 
                echo "there is problem";
        }else if($attendTodatId == "attend"){
            if($this->attendances->takeAttendance($attendanceid,$groupid))
                echo "added successfully";
            else 
                echo "there is problem";
        }
            
    }
}

?>
