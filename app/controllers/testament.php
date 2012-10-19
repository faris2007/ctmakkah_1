<?php

/**
 * this class for add,edit and remove from testament table
 * 
 * @author Faris Al-Otaibi
 */
class testament extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("testaments");
        $this->lang->load('testament', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
    }
    
    function index(){
        if($this->users->isLogin())
            $this->view();
        else
            show_404 ();
    }
    
    function view(){
        if($this->users->checkIfUser()){
            $userid = $this->users->get_info_user("id");
            $data['query'] = $this->testaments->getTestaments($userid);
            $data['CONTROL'] = False;
            $data['STEP'] = "view";
        }else if(@$this->core->checkPermissions("testament","view")){
            $data['query'] = $this->testaments->getTestaments("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            show_404 ();
        
        $data['TITLE'] = $this->lang->line('testament_view');
        $data['CONTENT'] = 'employee/testament';
        $this->core->load_template($data);
    }
    
    function add(){
        if(@$this->core->checkPermissions("testament","add","all","all")){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'type'      => $this->input->post("type",true),
                    'mony'      => $this->input->post("mony",true),
                );
                if(!$this->testaments->addNewTestament($store)){
                    $data['STEP'] = "add";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('testament_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'testament', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('testament_view');
        $data['CONTENT'] = 'employee/testament';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("testament","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $testamentID = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : "testament";
        $userid = (isset($segments[5]))? $segments[5] : 0;
        if($type == "testament"){
            if($testamentID != 0){
                $row = $this->testaments->getTestament($testamentID);
                if(is_bool($row))
                    echo $this->lang->line('testament_delete_error');

            if($this->testaments->deleteTestament($testamentID))
                echo $this->lang->line('testament_delete_success');    
            else
                echo $this->lang->line('testament_delete_error');  

            }else
                echo $this->lang->line('testament_delete_error');
        }else if($type == "users"){
            if($testamentID != 0 && $userid != 0){
            if($this->testaments->deleteTestamentFromUser($userid,$testamentID))
                echo $this->lang->line('testament_delete_success');    
            else
                echo $this->lang->line('testament_delete_error');  

            }else
                echo $this->lang->line('testament_delete_error');
        }
    }

    function addtouser(){
        if(!@$this->core->checkPermissions("testament","add","all","all"))
            redirect ("");
        
        $this->load->model("employees");
        $segments = $this->uri->segment_array();
        $usersID = (isset($segments[3]))? $segments[3] : 0;
        if($usersID == 0){
            $data['STEP'] = "show";
            $data['TITLE'] = 'Delivery Testament for users';
            $data['CONTENT'] = 'employee/testament';
            $this->core->load_template($data);
        }else{
            $data['STEP'] = "adduser";
            $userinfo = $this->users->get_info_user("all",$usersID);
            $data['ID'] = $userinfo['profile']->id;
            $data['IDN'] = $userinfo['profile']->idn;
            $data['EN_NAME'] = $userinfo['profile']->en_name;
            $sign = $this->employees->signature($userinfo['profile']->id);
            $data['SIGNATURE'] = true  ;
            $where = "id NOT IN (SELECT Testament_id FROM Testament_has_users WHERE users_id=".$userinfo['profile']->id.")";
            $this->db->where($where);
            $data['queryA'] = $this->testaments->getTestaments("all");
            $data['queryR'] = $this->testaments->getTestaments($userinfo['profile']->id);
            $data['TITLE'] = 'Delivery Testament for users';
            $data['CONTENT'] = 'employee/testament';
            $this->core->load_template($data);
        }
    }

    function edit(){
        $testamentID = $this->uri->segment(3, 0);
        if(@$this->core->checkPermissions("testament","edit",'all','all')){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'type'      => $this->input->post("type",true),
                    'mony'      => $this->input->post("mony",true),
                );
                if(!$this->testaments->updateTestament($testamentID,$store)){
                    $data['STEP'] = "edit";
                    $data['ID'] = $testamentID;
                    $row = $this->testaments->getTestament($testamentID);
                    if(!is_bool($row)){
                        $data['NAME'] = $row->name;
                        $data['TYPE'] = $row->type;
                        $data['MONY'] = $row->mony;
                    }else
                        show_404 ();
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('testament_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'testament', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "edit";
                $data['ID'] = $testamentID;
                $row = $this->testaments->getTestament($testamentID);
                if(!is_bool($row)){
                    $data['NAME'] = $row->name;
                    $data['TYPE'] = $row->type;
                    $data['MONY'] = $row->mony;
                }else
                    show_404 ();
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('testament_view');
        $data['CONTENT'] = 'employee/testament';
        $this->core->load_template($data);
    }
    
    function added()
    {
        if(!@$this->core->checkPermissions("testament","add","all","all"))
            echo "there is problem";
        
        $segments = $this->uri->segment_array();
        $testamentID = (isset($segments[3]))? $segments[3] : 0;
        $userid = (isset($segments[4]))? $segments[4] : 0;
        $number = (isset($segments[5]))? $segments[5] : 1;
        $size = (isset($segments[6]))? $segments[6] : 'S';
        if($testamentID != 0 && $userid != 0 ){
            $data = array(
                'users_id'      => $userid,
                'Testament_id'  => $testamentID,
                'deadline'      => "15/12/1433",
                'number'        => $number,
                'size'          => $size
            );
            if($this->testaments->addTestamentToUser($data))
                echo "added successfully";
            else 
                echo "there is problem";   
        }else 
            echo "there is problem";
            
    }
    
    function download(){
        if(!@$this->core->checkPermissions("testament","add","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3] : 0;
        if($type == "users_has_not_testament.csv"){
            $this->core->createCSV($this->testaments->getUsersHasNotTestaments(),"users_has_not_testament.csv");
            $this->output->set_content_type("csv/text")->set_output(read_file("./uploads/users_has_not_testament.csv"));
        }elseif($type == "users_has_testament.csv"){
            $this->core->createCSV($this->testaments->getUsersHasTestaments(),"users_has_testament.csv");
            $this->output->set_content_type("csv/text")->set_output(read_file("./uploads/users_has_testament.csv"));
        }else
            show_404 ();
    }
}

?>
