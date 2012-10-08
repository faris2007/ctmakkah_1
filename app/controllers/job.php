<?php

/**
 * this class for add,edit and remove from job table
 * 
 * @author Faris Al-Otaibi
 */
class job extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("jobs");
        $this->lang->load('job', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
         if(@$this->core->checkPermissions("job","view","all","all")){
            $data['query'] = $this->jobs->getJobs("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('job_view');
        $data['CONTENT'] = 'employee/job';
        $this->core->load_template($data);
    }
    
    function add(){
        if(@$this->core->checkPermissions("job","add","all","all")){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'date'      => $this->input->post("date",true),
                    'mony'      => $this->input->post("mony",true),
                );
                if(!$this->jobs->addNewJob($store)){
                    $data['STEP'] = "add";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('job_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'job', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('job_view');
        $data['CONTENT'] = 'employee/job';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("job","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $jobID = (isset($segments[3]))? $segments[3] : 0;
        if($jobID != 0){
            $row = $this->jobs->getJobs($jobID);
            if(is_bool($row))
                echo $this->lang->line('job_delete_error');
            
           if($this->jobs->deleteJob($jobID))
               echo $this->lang->line('job_delete_success');    
           else
               echo $this->lang->line('job_delete_error');  
               
        }else
            echo $this->lang->line('job_delete_error');
    }


    function edit(){
        $jobID = $this->uri->segment(3, 0);
        if(@$this->core->checkPermissions("job","edit","all","all")){
            if($_POST){
                $store = array(
                    'name'      => $this->input->post("name",true),
                    'date'      => $this->input->post("date",true),
                    'mony'      => $this->input->post("mony",true),
                );
                if(!$this->jobs->updateJob($jobID,$store)){
                    $data['STEP'] = "edit";
                    $data['ID'] = $jobID;
                    $row = $this->jobs->getJobs($jobID);
                    if(!is_bool($row)){
                        $data['NAME'] = $row[0]->name;
                        $data['DATE'] = $row[0]->date;
                        $data['MONY'] = $row[0]->mony;
                    }else
                        show_404 ();
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('job_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'job', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "edit";
                $data['ID'] = $jobID;
                $row = $this->jobs->getJobs($jobID);
                if(!is_bool($row)){
                    $data['NAME'] = $row[0]->name;
                    $data['DATE'] = $row[0]->date;
                    $data['MONY'] = $row[0]->mony;
                }else
                    show_404 ();
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('job_view');
        $data['CONTENT'] = 'employee/job';
        $this->core->load_template($data);
    }
}

?>
