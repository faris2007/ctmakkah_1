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
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
        if($this->users->checkIfUser()){
            $userid = $this->users->get_info_user("id");
            $data['query'] = $this->testaments->getTestaments($userid);
            $data['CONTROL'] = False;
            $data['STEP'] = "view";
        }else if($this->core->checkPermissions("testament","view")){
            $data['query'] = $this->testaments->getTestaments("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('testament_view');
        $data['CONTENT'] = 'employee/testament';
        $this->core->load_template($data);
    }
    
    function add(){
        if($this->core->checkPermissions("testament","add","all","all")){
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
    
    function edit(){
        $testamentID = $this->uri->segment(3, 0);
        if($this->core->checkPermissions("testament","add")){
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
}

?>
