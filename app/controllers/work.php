<?php

/**
 * this class for add,edit and remove from work table
 * 
 * @author Faris Al-Otaibi
 */
class work extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->lang->load('global', $this->core->site_language);
        $this->load->model("works");
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
        if(@$this->core->checkPermissions("group","view","all","all")){
            $data['ADMIN'] = true;
            $data['days'] = $this->core->getGroupOfWorkByDay();
        }elseif(@$this->users->isLogin() && $this->users->checkIfUser()){
            $data['ADMIN'] = false;
            $userId = $this->users->get_info_user("id");
            $data['tables'] = $this->works->getTables($userId);
        }else
            show_404 ();
        
        $data['STEP'] = 'view';
        $data['TITLE'] = 'Show Table';
        $data['CONTENT'] = 'employee/work';
        $this->core->load_template($data);
    }
    
    function show(){
        if(!@$this->core->checkPermissions("group","show","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $workId = (isset($segments[3]))? $segments[3] : 0;
        $start = (isset($segments[4]))? $segments[4] : 0;
        $userId = (isset($segments[5]))? $segments[5] : 0;
        if($workId == 0)
            show_404 ();
        
        $workInfo = $this->works->getTable($workId);
        if(is_bool($workInfo))
            show_404 ();
        if(is_numeric($start)){
            if($_POST){
                $idns = explode("\n", $this->input->post("IDNS",true));
                $msg = array();
                foreach ($idns as $key => $value){
                    if(is_numeric($value) && strlen($value) == 10)
                    {
                        $userinfo = $this->users->get_info_user("all",$value);
                        $msg[$key]['idn'] = $value;
                        $msg[$key]['message'] = ($this->works->addTableToUser($userinfo['profile']->id,$workId)) ? "added successfully" : "there is problem";
                    }
                }
                $data['query'] = $msg;
                $data['STEP'] = "adduser";
                $data['WORKID'] = $workId;
            }else{
                $data['STEP'] = 'show';
                $data['NAME'] = $workInfo->name;
                $data['DAY'] = $workInfo->day;
                $data['ID'] = $workId;
                $data['LOCATION'] = $workInfo->location;
                $data['START'] = $workInfo->startTime;
                $data['END'] = $workInfo->endTime;
                $data['users'] = $this->works->getUsersByTable($workId,'work',30,$start);
                $per_url = 'work/show/' . $workId . '/';
                $total_results = $this->works->getTotalUsersByTable($workId);
                $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,30);
            }
        }elseif($start == "search"){
            if($userId !=0){
                $userinfo = $this->users->get_info_user("all",$userId);
                if(is_bool($userinfo['profile']))
                    die("this is user is not in database");
                
                if($this->works->checkIfUserHaveTable($userinfo['profile']->id,$workId))
                    die("he is here");
                else
                    die("he is not here");
            }else
                die("there is problem");
        }
        
        $data['TITLE'] = 'Show Group Of work';
        $data['CONTENT'] = 'employee/work';
        $this->core->load_template($data);
        
    }

    function add(){
        if(!@$this->core->checkPermissions("group","add","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $day = (isset($segments[3]))? $segments[3] : 0;
        if($day == 0)
            show_404 ();
        
        if($_POST){
            $startTime = $this->input->post("start_hour",true).':'.$this->input->post("start_min",true).' '.$this->input->post("start_am",true);
            $endTime = $this->input->post("end_hour",true).':'.$this->input->post("end_min",true).' '.$this->input->post("end_am",true);
            $store = array(
                'name'      => $this->input->post("name",true),
                'startTime' => $startTime,
                'endTime'   => $endTime,
                'location'  => $this->input->post("location",true),
                'day'       => $day
            );
            if($this->works->addNewTable("work",$store)){
                $data['STEP'] = "success";
                $data['MSG'] = "done add new group of work, we will transfer you automatically";
                $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'work', 'type' => 'equiv'));
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = true;
            }
            
        }else{
            $data['STEP'] = "add";
            $data['ERROR'] = false;
        }
        $data['TITLE'] = 'add new group of work';
        $data['CONTENT'] = 'employee/work';
        $this->core->load_template($data); 
    }
    
    function edit(){
        if(!@$this->core->checkPermissions("group","edit","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $workId = (isset($segments[3]))? $segments[3] : 0;
        if($workId == 0)
            show_404 ();
        $workInfo = $this->works->getTable($workId);
        if(is_bool($workInfo))
            show_404 ();
        
        if($_POST){
            $startTime = $this->input->post("start_hour",true).':'.$this->input->post("start_min",true).' '.$this->input->post("start_am",true);
            $endTime = $this->input->post("end_hour",true).':'.$this->input->post("end_min",true).' '.$this->input->post("end_am",true);
            $store = array(
                'name'      => $this->input->post("name",true),
                'startTime' => $startTime,
                'endTime'   => $endTime,
                'location'  => $this->input->post("location",true)
            );
            if($this->works->updateTable($workId,$store)){
                $data['STEP'] = "success";
                $data['MSG'] = "done edit group of work, we will transfer you automatically";
                $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '2;url='.  base_url().'work', 'type' => 'equiv'));
            }else{
                $data['NAME'] = $workInfo->name;
                $startTime = $this->core->getTimeAsArray($workInfo->startTime);
                $endTime = $this->core->getTimeAsArray($workInfo->endTime);
                $data['START_HOUR'] = $startTime['hour'];
                $data['START_MIN'] = $startTime['min'];
                $data['START_AM'] = $startTime['am'];
                $data['END_HOUR'] = $endTime['hour'];
                $data['END_MIN'] = $endTime['min'];
                $data['END_AM'] = $endTime['am'];
                $data['LOCATION'] = $workInfo->location;
                $data['STEP'] = "edit";
                $data['ERROR'] = true;
            }
        }else{
            $data['NAME'] = $workInfo->name;
            $startTime = $this->core->getTimeAsArray($workInfo->startTime);
            $endTime = $this->core->getTimeAsArray($workInfo->endTime);
            $data['START_HOUR'] = $startTime['hour'];
            $data['START_MIN'] = $startTime['min'];
            $data['START_AM'] = $startTime['am'];
            $data['END_HOUR'] = $endTime['hour'];
            $data['END_MIN'] = $endTime['min'];
            $data['END_AM'] = $endTime['am'];
            $data['STEP'] = "edit";
            $data['ERROR'] = false;
        }
        
        $data['TITLE'] = 'edit group of work';
        $data['CONTENT'] = 'employee/work';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("group","delete","all","all"))
            die("there is problem");
        
        $segments = $this->uri->segment_array();
        $workId = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : 'table';
        $userid = (isset($segments[5]))? $segments[5] : NULL;
        if($workId == 0)
            die("there is problem");
        if($type == "table"){
            $workInfo = $this->works->getTable($workId);
            if(is_bool($workInfo))
                die("there is problem");
            
            if($this->works->deleteTable($workId))
                die("Delete successfully");
            else
                die("wrong in delete");
        }else if($type == "users"){
            if($userid != null){
                if($this->works->deleteUsersTable($userid,$workId))
                    die("Delete successfully");
                else
                    die("wrong in delete");
            }else
                die("wrong in delete");
        }
    }
    
}

?>
