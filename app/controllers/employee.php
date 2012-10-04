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
            if($this->core->checkPermissions("employee","profile","all","all")){
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
    
    function Candidate(){
        
    }
    
}

?>
