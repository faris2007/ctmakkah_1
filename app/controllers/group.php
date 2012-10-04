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
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
         if($this->core->checkPermissions("group","view","all","all")){
            $data['query'] = $this->groups->getGroups("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function add(){
        if($this->core->checkPermissions("group","add","all","all")){
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
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'group', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!$this->core->checkPermissions("group","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $groupID = (isset($segments[3]))? $segments[3] : 0;
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
    }


    function edit(){
        $groupID = $this->uri->segment(3, 0);
        if($this->core->checkPermissions("group","add")){
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
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'group', 'type' => 'equiv'));
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
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('group_view');
        $data['CONTENT'] = 'employee/group';
        $this->core->load_template($data);
    }
}

?>
