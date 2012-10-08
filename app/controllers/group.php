<?php

/**
 * this class for add,edit and remove from group table
 * 
 * @author Faris Al-Otaibi
 */
class group extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("groups");
        $this->lang->load('group', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
        $this->lang->load('login', $this->core->site_language);
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
         if(@$this->core->checkPermissions("group","view","all","all")){
            $data['query'] = $this->groups->getGroups("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            show_404();
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function add(){
        if(@$this->core->checkPermissions("group","add","all","all")){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'location'  => $this->input->post("location",true),
                    'is_admin'  => $this->input->post("isAdmin",true),
                );
                if(!$this->groups->addNewGroup($store)){
                    $data['STEP'] = "add";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('group_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'group', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            show_404();
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("group","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $groupID = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : "group";
        if($type == "group"){
            if($groupID != 0){
                $row = $this->groups->getGroups($groupID);
                if(is_bool($row))
                    echo $this->lang->line('group_delete_error');

            if($this->groups->deleteGroup($groupID))
                echo $this->lang->line('group_delete_success');    
            else
                echo $this->lang->line('group_delete_error');  

            }else
                echo $this->lang->line('group_delete_error');
        }else if($type == "users"){
            if($groupID != 0){
                $row = $this->users->get_info_user("all",$groupID);
                if(is_bool($row))
                    echo $this->lang->line('group_delete_error');
            
                $data['group_id'] = NULL;
                if($this->users->updateUser($groupID,$data))
                    echo $this->lang->line('group_delete_success');    
                else
                    echo $this->lang->line('group_delete_error');  

                }else
                    echo $this->lang->line('group_delete_error');
        }else if($type == "permissions"){
            if($groupID != 0){
                if($this->users->deletePermission($groupID))
                    echo $this->lang->line('group_delete_success');    
                else
                    echo $this->lang->line('group_delete_error');  

                }else
                    echo $this->lang->line('group_delete_error');
        }
    }


    function edit(){
        $groupID = $this->uri->segment(3, 0);
        if(@$this->core->checkPermissions("group","edit","all","all")){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'location'  => $this->input->post("location",true),
                    'is_admin'  => $this->input->post("isAdmin",true),
                );
                if(!$this->groups->updateGroup($groupID,$store)){
                    $data['STEP'] = "edit";
                    $data['ID'] = $groupID;
                    $row = $this->groups->getGroups($groupID);
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
                    $data['MSG'] = $this->lang->line('group_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'group', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "edit";
                $data['ID'] = $groupID;
                $row = $this->groups->getGroups($groupID);
                if(!is_bool($row)){
                    $data['NAME'] = $row[0]->name;
                    $data['LOCATION'] = $row[0]->location;
                    $data['ISADMIN'] = $row[0]->is_admin;
                }else
                    show_404 ();
                $data['ERROR'] = false;
            }
                
        }else
            show_404();
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function show($groupId,$start = 0){
        if(!@$this->core->checkPermissions("group","show","all","all"))
            show_404();
        if(empty($groupId))
            show_404 ();
        
        $groupInfo = $this->groups->getGroups($groupId);
        $data['STEP'] = "show";
        $data['NAME'] = $groupInfo[0]->name;
        $data['LOCATION'] = $groupInfo[0]->location;
        $data['ISADMIN'] = $groupInfo[0]->is_admin;
        $data['ID'] = $groupId;
        $data['services'] = $this->users->getAllPermissions($groupId);
        $this->db->where("group_id",$groupId);
        $data['users'] = $this->users->getUsers(30,$start);
        $per_url = 'group/adduserstogroup/' . $groupId . '/';
        $total_results = count($data['users']);
        $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
        $data['TITLE'] = "add users to Group";
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function addpermissontogroup($groupId){
        if(!@$this->core->checkPermissions("group","add","all","all"))
            show_404 ();
        
        if(empty($groupId))
            show_404 ();
        
        if($_POST){
            $ser = $this->core->getFunctionsName("all");
            foreach ($ser as $key => $value){
                foreach ($value as $permission){
                    if(isset($_POST[$key.'_'.$permission])){
                        $store = array(
                            'service_name'  => $key,
                            'function_name' => $permission,
                            'value'         => 'all',
                            'other_value'   => 'all',
                            'group_id'      => $groupId
                        );
                        $this->users->addNewPermission($store);    
                    }
                }
            }
            $data['STEP'] = 'success';
            $data['MSG'] = "added new permissions";
            $data['HEAD'] = meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'group/show/'.$groupId, 'type' => 'equiv'));
        }else {
            $data['GROUPID'] = $groupId;
            $data['services'] = $this->core->getFunctionsName("all");
            $data['STEP'] = "addpermission";
        }
        $data['TITLE'] = "add users to Group";
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    public function adduserstogroup()
    {
        // Permaters
        $groupId = is_numeric($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : 0;
        $start = (is_numeric($this->uri->segment(4, 1))) ? $this->uri->segment(4, 1) : 1;

        if(!@$this->core->checkPermissions("group","add","all","all")) show_404 ();
        
        if($_POST){
            $idns = explode("\n", $this->input->post("IDNS",true));
            $msg = array();
            $store['group_id'] = $groupId;
            foreach ($idns as $key => $value){
                if(is_numeric($value) && strlen($value) == 10)
                {
                    $userinfo = $this->users->get_info_user("all",$value);
                    $msg[$key]['idn'] = $value;
                    $msg[$key]['message'] = ($this->users->updateUser($userinfo['profile']->id,$store)) ? "added successfully" : "there is problem";
                }
            }
            $data['query'] = $msg;
            $data['GROUPID'] = $groupId;
            $data['TITLE'] = "add users to Group";
            $data['CONTENT'] = 'employee/groupUsers';
            $this->core->load_template($data);
        }else {
            // Per Page
            $per_url = 'group/adduserstogroup/' . $groupId . '/';
            $total_results = $this->users->get_total_users();
            $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
            $data['STEP'] = "addusers";
            $data['GROUPID'] = $groupId;
            $data['query'] = $this->users->getUsers(30,$start);
            $data['TITLE'] = "add users to Group";
            $data['CONTENT'] = 'employee/group';
            $this->core->load_template($data);
        }
    }
    
    function added($userid,$groupid)
    {
        if(!@$this->core->checkPermissions("group","add","all","all"))
            show_404 ();
        if(empty($userid) || empty($groupid))
            echo "You have errorin parmeters";
        
        $data['group_id'] = $groupid;
        if($this->users->updateUser($userid,$data))
            echo "added successfully";
        else 
            echo "there is problem";    
            
    }
}

?>
