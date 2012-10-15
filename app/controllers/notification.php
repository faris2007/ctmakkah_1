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
    }
    
    function index(){
        
    }
    
    function add(){
        
    }
    
    function view(){
        
    }
    
    function delete(){
        
    }
    
    function edit(){
        
    }
    
    function getTo(){
        if(!@$this->core->checkPermissions("notification","add","all","all"))
            show_404 ();
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3])) ? $segments[3] : NULL ;
        if($type == NULL)
            show_404 ();
        elseif($type == "group"){
            $query = $this->groups->getGroups("all");
            echo "<select name=\"to\">";
            if(!is_bool($query)){
                foreach ($query as $row){
                    echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                }
            }else{
                echo '<option disabled="disabled">No Group</option>';
            }
            echo '</select>';
        }elseif ($type == "users") {
            echo '<textarea name="to"></textarea>';
        }
    }
}

?>
