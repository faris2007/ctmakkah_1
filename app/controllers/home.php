<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
      
    public function __construct() {
        parent::__construct();
        
    }
    public function index()
	{
            if($this->users->isLogin()){    
                $data['TITLE'] = 'Aswaq Est.';
                $data['CONTENT'] = 'home';
                $this->core->load_template($data);
            }  else {
                redirect("login");
            }
	}
}

/* End of file home.php */
/* Location: ./app/controllers/home.php */