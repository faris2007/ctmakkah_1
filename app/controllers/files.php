<?php

/**
 * this class for add,edit and remove from login table
 * 
 * @author Ahmad AlGhamdi
 */

class Files extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        redirect();
    }
    
    public function show()
    {
        // Get Param
        $folder_id = $this->uri->segment(2, NULL);
        $file_id = $this->uri->segment(3, NULL);
        $full_path = 'store/' . $folder_id . '/' . $file_id . '.jpg';
        $folders = array('card','personal_img');
        
        if (in_array($folder_id,$folders) && file_exists($full_path))
        {
            $this->output->set_content_type('jpeg')->set_output(file_get_contents($full_path));
        }else{
            redirect();
        }   
    }
    
}

?>