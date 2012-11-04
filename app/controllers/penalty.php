<?php

/**
 * this class for add,edit and remove from penalty table
 * 
 * @author Faris Al-Otaibi
 */
class penalty extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("penalties");
        $this->lang->load('global', $this->core->site_language);
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
        if(!@$this->core->checkPermissions("penalty","view","all","all"))
            show_404 ();
        
        $data['STEP'] = 'view';
        $data['types'] = $this->penalties->getTypes("all");
        $data['penalty'] = $this->penalties->getPenaltys("all");
        $data['TITLE'] = 'View penalty';
        $data['NAV'] = array(
            base_url().'penalty' => 'penalty'
        );
        $data['CONTENT'] = 'employee/penalty';
        $this->core->load_template($data);
    }


    function add(){
        if(!@$this->core->checkPermissions("penalty","add","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3] : NULL;
        $userId = (isset($segments[4]))? $segments[4] : 0;
        if(is_null($type))
            show_404 ();
        
        if($type == "penalty"){
            if($userId != 0){
                $userInfo = $this->users->get_info_user("all",$userId);
                if($_POST){
                    $store = array(
                        'type'          => $this->input->post("type",true),
                        'date'          => $this->input->post("date",true),
                        'time'          => $this->input->post("time_hour",true).":".$this->input->post("time_min",true)." ".$this->input->post("time_am",true),
                        'note'          => $this->input->post("note",true),
                        'to_users_id'   => $userId
                    );
                    if(!$this->penalties->addNewPenalty($store)){
                        $data['STEP'] = "addPenalty";
                        $data['types'] = $this->penalties->getTypes("all");
                        $data['USER_NAME'] = $userInfo['profile']->en_name;
                        $data['ERROR'] = true;
                    }else
                    {
                        $data['STEP'] = "success";
                        $data['MSG'] = "added successfully";
                        $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'penalty', 'type' => 'equiv'));
                    }
                }else{
                    $data['STEP'] = "addPenalty";
                    $data['types'] = $this->penalties->getTypes("all");
                    $data['USER_NAME'] = $userInfo['profile']->en_name;
                    $data['ERROR'] = false;
                }
            }else
                show_404 ();
        }elseif($type == "type"){
            if($_POST){
                $store = array(
                    'name'          => $this->input->post("name",true),
                    'length'        => $this->input->post("length",true),
                    'penaltyAmount' => $this->input->post("amount",true)
                    );
                if(!$this->penalties->addNewType($store)){
                    $data['STEP'] = "addType";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = "added successfully";
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'penalty', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "addType";
                $data['ERROR'] = false;
            }
        }else
            show_404 ();
        
        $data['NAV'] = array(
            base_url().'penalty'        => 'penalty',
            base_url().'penalty/add/'.$type    => 'Add new penalty',
        );
        $data['TITLE'] = 'Add new penalty';
        $data['CONTENT'] = 'employee/penalty';
        $this->core->load_template($data);
    }
    
    function edit(){
        if(!@$this->core->checkPermissions("penalty","edit","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3] : NULL;
        $Id = (isset($segments[4]))? $segments[4] : 0;
        if(is_null($type))
            show_404 ();
        
        if($Id == 0)
            show_404 ();
        
        if($type == "penalty"){
            $penaltyData = $this->penalties->getPenalty($Id);
            $userInfo = $this->users->get_info_user("all",$penaltyData->to_users_id);
            if($_POST){
                $store = array(
                    'type'          => $this->input->post("type",true),
                    'date'          => $this->input->post("date",true),
                    'time'          => $this->input->post("time_hour",true).":".$this->input->post("time_min",true)." ".$this->input->post("time_am",true),
                    'note'          => $this->input->post("note",true),
                    'to_users_id'   => $userId
                );
                if(!$this->penalties->updatePenalty($Id,$store)){
                    $data['STEP'] = "editPenalty";
                    $data['types'] = $this->penalties->getTypes("all");
                    $data['USER_NAME'] = $userInfo['profile']->en_name;
                    $data['TYPE'] = $penaltyData->type;
                    $data['DATE'] = $penaltyData->date;
                    $time = $this->core->getTimeAsArray($penaltyData->time);
                    $data['TIME_HOUR'] = $time['hour'];
                    $data['TIME_MIN'] = $time['min'];
                    $data['TIME_AM'] = $time['am'];
                    $data['NOTE'] = $penaltyData->note;
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = "edit successfully";
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'penalty', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "editPenalty";
                $data['types'] = $this->penalties->getTypes("all");
                $data['USER_NAME'] = $userInfo['profile']->en_name;
                $data['TYPE'] = $penaltyData->type;
                $data['DATE'] = $penaltyData->date;
                $time = $this->core->getTimeAsArray($penaltyData->time);
                $data['TIME_HOUR'] = $time['hour'];
                $data['TIME_MIN'] = $time['min'];
                $data['TIME_AM'] = $time['am'];
                $data['NOTE'] = $penaltyData->note;
                $data['ERROR'] = false;
            }
        }elseif($type == "type"){
            $typeData = $this->penalties->getTypes($Id);
            if($_POST){
                $store = array(
                    'name'          => $this->input->post("name",true),
                    'length'        => $this->input->post("length",true),
                    'penaltyAmount' => $this->input->post("amount",true)
                    );
                if(!$this->penalties->updateType($Id,$store)){
                    $data['STEP'] = "editType";
                    $data['NAME'] = $typeData[0]->name;
                    $data['LENGTH'] = $typeData[0]->length;
                    $data['AMOUNT'] = $typeData[0]->penaltyAmount;
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = "edit successfully";
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'penalty', 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "editType";
                $data['NAME'] = $typeData[0]->name;
                $data['LENGTH'] = $typeData[0]->length;
                $data['AMOUNT'] = $typeData[0]->penaltyAmount;
                $data['ERROR'] = false;
            }
        }else
            show_404 ();
        
        $data['NAV'] = array(
            base_url().'penalty'                        => 'penalty',
            base_url().'penalty/edit/'.$type.'/'.$Id    => 'Edit penalty',
        );
        $data['TITLE'] = 'Edit penalty';
        $data['CONTENT'] = 'employee/penalty';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("penalty","delete","all","all"))
            die("Wrong don't have Permissions");
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3])) ? $segments[3] : NULL ;
        $ID = (isset($segments[4])) ? $segments[4] : 0 ;
        
        if(is_null($type))
            die("Wrong in parameter");
        
        if($ID == 0)
            die("Wrong in parameter");
        
        if($type == 'penalty'){
            $penalty = $this->penalties->getPenalty($ID);
            if(!is_bool($penalty)){
                if($this->penalties->deletePenalty($ID))
                    die("Delete successfully");
                else
                    die("cannot Delete this penalty");
            }else
                die("penalty Not Found");
        }else if($type == 'type'){
            $penaltyT = $this->penalties->getTypes($ID);
            if(!is_bool($penaltyT)){
                if($this->penalties->deleteType($ID))
                    die("Delete successfully");
                else
                    die("cannot Delete this Type");
            }else
                die("This Type Not Found");
        }else
            die("Not Found");
    }
}

?>
