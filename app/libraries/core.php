<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core {
	
    private $CI;
    private $Token,$Old_Token,$New_Token,$Security_Key,$User_Agent;
    public  $site_language = 'english';

    public function __construct()
    {
            // Load Class CI
            $this->CI =& get_instance();
            $this->load_setting();
    }

    public function load_setting()
    {
            $this->generate_token();
    }

    public function generate_token()
    {
            // Token
            $this->Security_Key = sha1(rand(1000,9999) * rand(1000,9999));
            $this->Old_Token = $this->CI->encrypt->decode($this->CI->session->userdata('Token'));
            $this->Token = $this->CI->encrypt->decode($this->CI->session->userdata('New_Token'));
            $this->User_Agent = $this->CI->agent->agent_string();
            $this->New_Token = $this->CI->encrypt->encode($this->User_Agent . '|' . $this->Security_Key  . '|' . time());
            $this->Token = ($this->Token != '') ? $this->Token : $this->New_Token;
            
    }

    public function token($generate = FALSE)
    {
            $generate = (is_bool($generate)) ? $generate : FALSE;

            if ($generate)
            {
                    return $this->New_Token;
            }else{
                    return $this->Token;
            }
    }

    public function check_token($redirect = TRUE,$token = '')
    {
            $redirect = (is_bool($redirect)) ? $redirect : FALSE;
            $token = ($token == '') ? $this->CI->input->post('token', TRUE) : $token;
            if ($this->CI->input->post('token', TRUE) == $this->Token)
            {
                return TRUE;
            }else{
                if ($redirect)
                {
                    redirect();
                }else{
                    return FALSE;
                }
            }
    }
 
    public function load_template($temp_data = array(),$load_only = FALSE)
    {

            // Page Title
            $data['HEAD']['TITLE'] = (isset($temp_data['TITLE'])) ? $temp_data['TITLE'] : '';

            // Meta	
            $data['HEAD']['META']['ROBOTS'] = (isset($data['HEAD']['META']['ROBOTS'])) ? 'none' : 'all';
            $data['HEAD']['META']['DESC'] = (isset($data['HEAD']['META']['DESC'])) ? $data['HEAD']['META']['DESC'] : '';
            $data['HEAD']['META']['KW'] = (isset($data['HEAD']['META']['KW'])) ? $data['HEAD']['META']['KW'] : '';
            $data['HEAD']['META']['META'] = array(
                    array('name' => 'robots', 'content' => $data['HEAD']['META']['ROBOTS']),
                    array('name' => 'description', 'content' => $data['HEAD']['META']['DESC']),
                    array('name' => 'keywords', 'content' => $data['HEAD']['META']['KW'])
            );

            // Other Code ( HTML -> HEAD )
            $data['HEAD']['OTHER'] = (isset($temp_data['HEAD'])) ? $temp_data['HEAD'] : '';

            // Main Menu
            $data['MENU'] = (isset($temp_data['MENU'])) ? $temp_data['MENU'] : $this->CI->load->view('menu',NULL,TRUE);
			
            // Content
            $data['CONTENT'] = (isset($temp_data['CONTENT'])) ? $this->CI->load->view($temp_data['CONTENT'],$temp_data,TRUE) : '' ;

            // Main Template
            $load_only = (is_bool($load_only)) ? $load_only : FALSE;

            if ($load_only)
            {
                    return $this->CI->load->view('template',$data,TRUE);
            }else{
                    $this->CI->load->view('template',$data);
            }
    }
    
    public function checkPermissions($service_name = "admin",$function_name = "all",$value = "all",$otherValue = "all")
    {
        if(empty($service_name) || empty($function_name) || empty($value) || empty($otherValue))
            return false;
        $this->CI->load->model("users");
        if(!$this->CI->users->isLogin())
            return false;
        
        if($this->CI->users->checkifUser())
            return FALSE;
        
        if ($service_name == "admin")
        {
            if(!$this->CI->users->checkifUser())
                return true;
            else 
                return false;
        }else
        {
            return $this->CI->users->checkIfHavePremission($service_name,$function_name,$value,$otherValue);
        }
        
    }
    
    public function getServicesName(){
        $data = array("testament","employee","job","group","post","attendance","notification");
        return $data;
    }
    
    public function getFunctionsName($service_name ="all"){
        $data = array(
            "testament"     => array("all","view","show","add","edit","delete"),
            "employee"      => array("all","profile","view","add","edit","delete"),
            "job"           => array("all","view","show","add","edit","delete"),
            "group"         => array("all","view","show","add","edit","delete"),
            "post"          => array("all","view","show","add","edit","delete"),
            "attendance"    => array("all","view","show","add","edit","delete"),
            "notification"    => array("all","view","show","add","edit","delete")
            );
        return (isset($data[$service_name]))? $data[$service_name] : $data  ;
    }
    
    public function perpage($url = '',$total = 0,$cur_page = 0,$per_page = 30)
    {
        $this->CI->load->library('pagination');
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 6;
        $config['num_links'] = 3;
        $config['cur_page'] = $cur_page;
        $this->CI->pagination->initialize($config);
        return $this->CI->pagination->create_links();        
    }
    
    public function message($_message = '',$_url = '',$_title = '',$_time = 200)
    {
        $data['MSG']['TITLE'] = $_title;
        $data['MSG']['MESSAGE'] = $_message;
        $data['MSG']['URL'] = $_url;
        $data['MSG']['TIME'] = $_time;
        $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => $_time.';url='.$_url, 'type' => 'equiv'));
        $data['TITLE'] = 'MSG';
        $data['CONTENT'] = 'message';
        die($this->load_template($data,TRUE));
    }
    
    public function getHeadFile($data){
        
        $result = array();
        foreach ($data as $key => $value){
            if(@ereg("ID", strtoupper($value)))
                $result['id'] = $key;
            elseif(@ereg("NAME", strtoupper($value))){
                $result['name'] = $key;
            }elseif(@ereg("POSITION", strtoupper($value)))
                $result['position'] = $key;
            elseif(@ereg("MOPIL", strtoupper($value)))
                $result['mobile'] = $key;
            elseif(@ereg("MOBILE", strtoupper($value)))
                $result['mobile'] = $key;
            elseif(@ereg("PHONE", strtoupper($value)))
                $result['mobile'] = $key;
        }
        
        return $result;
    }
    
    public function getInfoNotification($type,$to){
        if(empty($type) || empty($to))
            return false;
        
        //$this->CI->load->model("notifications");
        if($type == "group"){
            $this->CI->load->model("groups");
            $data = $this->CI->groups->getGroups($to);
            return (!is_bool($data))? $data[0]->name : false;
        }elseif ($type == "users") {
            $data = $this->CI->users->get_info_user("all",$to);
            return (!is_bool($data['profile']))? $data['profile']->en_name : false;
        }else
            return false;
        
    }
    
    public function retypeContractNumber(){
        $this->CI->load->model("employees");
        $error = array();
        $query = $this->CI->users->getAllInfoUser();
        if(!is_bool($query)){
            foreach ($query as $key =>$row){
                if(($key+1) < 10)
                    $data['contract_id'] = "000".($key+1);
                elseif(($key+1) >= 10 && ($key+1)<100)
                    $data['contract_id'] = "00".($key+1);
                elseif (($key+1) >= 100 && ($key+1)<1000)
                    $data['contract_id'] = "0".($key+1);
                elseif (($key+1) >= 1000)
                    $data['contract_id'] = ($key+1);
                
                if(!$this->CI->employees->updateEmployee($row->ide,$data))
                    $error[$key] = "Can't update the user number (".$row->id.")";
            }
        }
        
        return $error;
    }
    
    public function createCSV($data)
    {
        $string = "NO#;National ID;Name;Position;Mobile\n";
        foreach ($data as $key => $value){
            $string .= $key.";".$value->idn.";".$value->en_name.";".$value->grade.";".$value->mobile."\n";
        }
        $path = "./uploads/no_pictures.csv";
        if(file_exists($path)){
            unlink($path);
        }
        if(write_file($path, $string))
            return true;
        else
            return false;
    }
    
}

?>
