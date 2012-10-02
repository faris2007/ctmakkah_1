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
    }
    
    function index()
    {

    }
    
    function profile()
    {
        // Get User ID
        $user_id = $this->uri->segment(3, 0);
        
        $data['CONTENT'] = 'employee/profile';
        
        $this->core->load_template($data);
    }
    
}

?>
