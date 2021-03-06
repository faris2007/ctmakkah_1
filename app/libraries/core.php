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
        $data = array("testament","employee","job","group","post","attendance","notification","work","penalty");
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
            "notification"  => array("all","view","show","add","edit","delete"),
            "work"          => array("all","view","show","add","edit","delete"),
            "penalty"       => array("all","view","show","add","edit","delete")
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
        $this->CI->db->where("year",date("Y"));
        $this->CI->db->where("isAccept",'A');
        $query = $this->CI->employees->getEmployees('all');
        if(!is_bool($query)){
            foreach ($query as $key =>$row){
                    $data['contract_id'] = str_pad($key+1,4,"0",STR_PAD_LEFT);
                
                if(!$this->CI->employees->updateEmployee($row->id,$data))
                    $error[$key] = "Can't update the user number (".$row->users_id.")";
            }
        }
        
        return $error;
    }
    
    public function createCSV($data,$fileName = "no_pictures.csv",$addPictures = false)
    {
        $string = "NO#;National ID;English Name;Arabic Name;Position;Mobile";
        $string .= ($addPictures)?";Picture Url\n":"\n";
        if($data){
            foreach ($data as $key => $value){
                $string .= $key.";".$value->idn.";".$value->en_name.";".$this->changeIfWindows(@$value->ar_name).";".$value->grade.";".$value->mobile;
                $string .= ($addPictures)?";".  base_url()."files/personal_img/".$value->idn."\n":"\n";
            }
        }
        $path = "./uploads/".$fileName;
        if(file_exists($path)){
            unlink($path);
        }
        if(write_file($path, $string))
            return true;
        else
            return false;
    }
    
    public function createCSVC($data,$fileName = "no_pictures.csv",$addPictures = true)
    {
        $string = "NO#;National ID;English Name;Arabic Name;Mobile;Position;Iban No.;Bank Name;Email";
        $string .= ($addPictures)?";Picture Url\n":"\n";
        if($data){
            foreach ($data as $key => $value){
                $string .= $key.";".$value->idn.";".$value->en_name.";".$this->changeIfWindows(@$value->ar_name).";".$value->mobile.";".$value->grade.";".$value->iban.";".$this->changeIfWindows($value->bankName).";".$value->email;
                $string .= ($addPictures)?";".$this->getPicture($value->id)."\n":"\n";
            }
        }
        $path = "./uploads/".$fileName;
        if(file_exists($path)){
            unlink($path);
        }
        if(write_file($path, $string))
            return true;
        else
            return false;
    }
    
    private function getPicture($userid){
        $this->CI->load->model('attachments');
        
        $this->CI->db->where('name','Personal Picture');
        $check = $this->CI->attachments->getAttachments($userid);
        if(is_bool($check)){
            return "";
        }else{
            return $check[0]->file_url;
        }
    }


    public function getNameOfContract($ext)
    {
        if(empty($ext))
            return "No";
        $data = array(
            'N' => "No",
            'R' => "Resignation",
            'T' => "Reject",
            'Y' => "Yes"
        );
        return (isset($data[$ext]))? $data[$ext] : $data['N'] ;
    }
    
    public function getNotification(){
        $this->CI->load->model("notifications");
        if($this->CI->users->isLogin()){
            $userInfo = $this->CI->users->get_info_user("all");
            $dataNotification = "";
            $first = true;
            $groupNotification = $this->CI->notifications->getNotifications("group",$userInfo->group_id);
            $personalNotification = $this->CI->notifications->getNotifications("users",$userInfo->idn);
            if(!is_bool($personalNotification)){
                foreach ($personalNotification as $value){
                    $dataNotification .= ($first)? $value->message : " || ".$value->message;
                    $first = false;
                }
            }

            if(!is_bool($groupNotification)){
                foreach ($groupNotification as $value){
                    $dataNotification .= ($first)? $value->message : " || ".$value->message;
                    $first = false;
                }
            }

            return $dataNotification;
        }else
            return "";
    }
    
    public function getGroupOfWorkByType(){
        $this->CI->load->model("works");
        $type = array('W','T','O','L');
        $data = array();
        foreach($type as $val){
            if($val != 'T'){
                $this->CI->db->where('date >',  $this->decreaseMonth(6));
                $this->CI->db->where('date <',  $this->increaseMonth(6));
            }
            $data[$val] = $this->CI->works->getTablesByType($val);
        }
        return $data;
    }
    
    public function getNameOfTableType($type){
        $data = array(
            'W'     => "Work",
            'T'     => "Training",
            'O'     => "Trail Operation",
            'L'     => "Live Exercise"
        );
        return (isset($data[$type]))? $data[$type] : "";
    }


    public function increaseMonth($val){
        $month = date('m');
        $year = date('Y');
        $dif = abs(12 - $val);
        $yearIncrease = ((($val-1)+$month)/12);
        if($dif == 0){
            $year++;
        }elseif($month > $dif){
            $month = 1 + ((($month + $val)-1) % 12);
            $year += $yearIncrease; 
        }else{
            $month += $val;
        }
        return mktime(0, 0, 0, $month, 1, $year);
    }
    
    public function decreaseMonth($val){
        $month = date('m');
        $year = date('Y');
        $yearDecrease = ((($val)-$month)/12);
        if($month < $val){
            $month = 1+(((($month - $val) + 12)-1) % 12);
            $year -= $yearDecrease; 
        }else{
            $month -= $val;
        }
        return mktime(0, 0, 0, $month, 1, $year);
    }


    public function getTimeAsArray($time){
        $timeH = explode(":", $time);
        $data['hour'] = $timeH[0];
        $timeM = explode(" ", $timeH[1]);
        $data['min'] = $timeM[0];
        $data['am'] = $timeM[1];
        return $data;
    }
    
    public function add_log($_service = '',$_function = '',$_action = '',$_parem = '')
    {
        /**
         * SERVICE => Controller Name
         * FUNCTION => Function Name
         * ACTION => Num Action ( Get Str from lang )
         * PAREM => Exp ( 1,ADD,LOGOUT )
         */        
        $data = array('USER_ID' => $this->CI->users->get_info_user("id"),
                      'SERVICE' => $_service,
                      'FUNCTION' => $_function,
                      'ACTION' => $_action,
                      'PAREM' => $_parem,
                      'TIMESTAMP' => time());
        $this->db->insert('logs', $data); 
    }
    
    public function computePenaltyAmount($penalties){
        if(!is_array($penalties))
            return 0;
        
        $total = 0;
        foreach ($penalties as $value){
            if(is_numeric($value->penaltyAmount))
                $total += $value->penaltyAmount;
            elseif(is_string($value->penaltyAmount) || $value->penaltyAmount == "Reject")
                return -1;
        }
        
        return $total;
        
    }
    
    function changeIfWindows($string){
        $this->CI->load->library('user_agent');
        if(empty($string))
            return "";
        if(@ereg('windows', strtolower($this->CI->agent->platform())))
            $newString = @iconv('UTF-8', 'Windows-1256', $string);
        else
            $newString = $string;
        return $newString;
    }
}

?>
