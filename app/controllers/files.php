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
        $full_path = 'store/' . $folder_id . '/' . $file_id ;
        $ext = array('.jpg','.JPG','.png','PNG','jpeg','JPEG','gif','GIF','bmp','BMP');
        $folders = array('card','personal_img');
        
        if (in_array($folder_id,$folders))
        {
            foreach ($ext as $value)
                if(file_exists($full_path.$value)){
                    $this->output->set_content_type($value)->set_output(file_get_contents($full_path.$value));
                }else if(file_exists($full_path." ".$value)){
                    $this->output->set_content_type($value)->set_output(file_get_contents($full_path." ".$value));
                }
        }else{
            redirect();
        }   
    }
    
}

?>