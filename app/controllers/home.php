<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
      
	public function index()
	{
                $data['TITLE'] = 'Employee Profile';
                $data['CONTENT'] = 'employee/profile';
		$this->core->load_template($data);
	}
}

/* End of file home.php */
/* Location: ./app/controllers/home.php */