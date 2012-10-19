<?php

/**
 * this class for add,edit and remove from notification table
 * 
 * @author Faris Al-Otaibi
 */
class notification extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("groups");
        $this->load->model("notifications");
        $this->lang->load('global', $this->core->site_language);
    }
    
    function index(){
        $this->view();
    }
    
    function add(){
        if(!@$this->core->checkPermissions("notification","add","all","all"))
            show_404 ();
        
        if($_POST){
            if($this->input->post("type",true) != 'no'){
                $store = array(
                    'to_type'   => $this->input->post("type",true),
                    'to'        => $this->input->post("to",true),
                    'message'   => $this->input->post("message",true)
                );
                if($this->notifications->addNewNotification($store)){
                    $data['STEP'] = 'success';
                    $data['MSG'] = 'Added successfully , it will be transfer you automataclly';
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.base_url().'notification/view', 'type' => 'equiv'));
                }else{
                    $this->core->message("it cannot added in database",  base_url ()."notification/add","added Problem",2); 
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = true;
            }
        }else{
            $data['STEP'] = "add";
            $data['ERROR'] = false;
        }
        $data['CONTENT'] = 'employee/notification';
        $data['TITLE'] = "Add new Notification";
        $this->core->load_template($data);
    }
    
    function view(){
        if(!@$this->core->checkPermissions("notification","view","all","all"))
            show_404 ();
        
        $data['STEP'] = "view";
        $data['query'] = $this->notifications->getAllNotifications();
        $data['CONTENT'] = 'employee/notification';
        $data['TITLE'] = "Notification";
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!@$this->core->checkPermissions("notification","delete","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $notifcationID = (isset($segments[3])) ? $segments[3] : 0 ;
        
        if($notifcationID !=0){
            $notifcation = $this->notifications->getNotification($notifcationID);
            if(!is_bool($notifcation)){
                if($this->notifications->deleteNotification($notifcationID))
                    echo "Delete successfully";
                else
                    echo "cannot Delete this notification";
            }else
                echo "Notification Not Found";
        }else
            echo "Notification Not Found";
    }
    
    function edit(){
        if(!@$this->core->checkPermissions("notification","edit","all","all"))
            show_404 ();
        
        $segments = $this->uri->segment_array();
        $notifcationID = (isset($segments[3])) ? $segments[3] : 0 ;
        if($notifcationID != 0){
            $notifcation = $this->notifications->getNotification($notifcationID);
            if(!is_bool($notifcation)){
                if($_POST){
                    if($this->input->post("type",true) != "no"){
                        $store = array(
                            'to_type'   => $this->input->post("type",true),
                            'to'        => $this->input->post("to",true),
                            'message'   => $this->input->post("message",true)
                        );
                        if($this->notifications->updateNotification($notifcationID,$store)){
                            $data['STEP'] = 'success';
                            $data['MSG'] = 'Edit successfully , it will be transfer you automataclly';
                            $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.base_url().'notification/view', 'type' => 'equiv'));
                        }else{
                            $this->core->message("it cannot added in database",  base_url ()."notification/edit/".$notifcationID,"edit Problem",2); 
                        }
                    }else{
                        $data['ID'] = $notifcationID;
                        $data['TYPE'] = $notifcation->to_type;
                        $data['MESSAGE'] = $notifcation->message;
                        $data['STEP'] = "edit";
                        $data['ERROR'] = true;
                    }
                }else{
                    $data['ID'] = $notifcationID;
                    $data['TYPE'] = $notifcation->to_type;
                    $data['MESSAGE'] = $notifcation->message;
                    $data['STEP'] = "edit";
                    $data['ERROR'] = false;
                }
            }else
                show_404 ();
        }else
            show_404 ();
        
        $data['CONTENT'] = 'employee/notification';
        $data['TITLE'] = "Edit Notification";
        $this->core->load_template($data);
    }
    
    function getTo(){
        if(!@$this->core->checkPermissions("notification","add","all","all"))
            show_404 ();
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3])) ? $segments[3] : NULL ;
        $notificationID = (isset($segments[4])) ? $segments[4] : 0 ;
        $notification = ($notificationID !=0 )? $this->notifications->getNotification($notificationID): FALSE;
        if($type == NULL)
            show_404 ();
        elseif($type == "group"){
            $selectedID = ($notification)? $notification->to : 0;
            $query = $this->groups->getGroups("all");
            echo "<select name=\"to\">";
            if(!is_bool($query)){
                foreach ($query as $row){
                    if($selectedID == $row->id)
                        echo '<option selected="selected" value="'.$row->id.'">'.$row->name.'</option>';
                    else
                        echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                }
            }else{
                echo '<option disabled="disabled">No Group</option>';
            }
            echo '</select>';
        }elseif ($type == "users") {
            if(!$notification)
                echo '<textarea name="to"></textarea>';
            else 
                echo '<textarea name="to">'.$notification->to.'</textarea>';
        }elseif($type == "no"){
            echo 'Please Select any type';
        }
    }
}

?>
