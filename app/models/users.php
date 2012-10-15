<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Model {

    private $_tables = array(
        'users'         =>  "users",
        'group'         =>  "group",
        'permissions'   =>  "Permissios",
        'employee'      =>  "Employee",
        'jobs'          =>  "jobs"
    );
    
    function __construct()
    {
        parent::__construct();
    }
    
    /*function profile_data()
    {
        return '';
    }*/
    
    private function ecrypt_password($pass){
        return sha1($pass);
    } 


    public function change_password($userid,$oldPass,$newPass){
        if(empty($userid)||empty($oldPass)||empty($newPass))
            return false;
        
        $this->db->where("password",  $this->ecrypt_password($oldPass));
        $this->db->where("id",$userid);
        $query = $this->db->get($this->_tables['users']);
        if($query->num_rows() > 0){
            $data['password'] = $this->ecrypt_password($newPass);
            if($this->updateUser($userid, $data)){
                return true;
            }else
                return false;
        }else
            return false;
    } 


    function getCandidate($limit = NULL,$start = NULL){
         if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","C");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getAccpetedUsers($limit = NULL,$start = NULL){
         if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","A");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getProfileUser($userid){
        if(empty($userid))
            return false;
        
        $this->db->where($this->_tables['users'].".id",$userid);
        $this->db->where($this->_tables['employee'].".jobs_id =".$this->_tables['jobs'].".id");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee'].",".$this->_tables['jobs']);
        return ($query->num_rows() > 0) ? $query->row() : false;
    }
    
    function get_total_info_users(){
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","A");
        $this->db->where($this->_tables['employee'].".jobs_id =".$this->_tables['jobs'].".id");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee'].",".$this->_tables['jobs']);
        return $query->num_rows() ;
    }
    
    function getAllUserByPictures($type = "no"){
        if(empty($type))
            return false;
        
        $folder = 'store/personal_img/';
        $query = $this->getAllInfoUser();
        $data = array();
        $count = 0;
        if($type == "no"){
            foreach ($query as $row){
                if(!file_exists($folder.$row->idn.".jpg") && !file_exists($folder.$row->idn.".jpeg") && !file_exists($folder.$row->idn.".png")
                   && !file_exists($folder.$row->idn." .png") && !file_exists($folder.$row->idn." .jpg" ) && !file_exists($folder.$row->idn.".PNG") && !file_exists($folder.$row->idn.".JPG"))
                {
                    $data[$count] = $row;
                    $count++;
                }
            }
        }elseif($type == "yes"){
            
                    foreach ($query as $row){
                if(file_exists($folder.$row->idn.".jpg") || file_exists($folder.$row->idn.".jpeg") || file_exists($folder.$row->idn.".png")
                   || file_exists($folder.$row->idn." .png")  || file_exists($folder.$row->idn." .jpg" ) || file_exists($folder.$row->idn.".PNG") || file_exists($folder.$row->idn.".JPG"))
                {
                    $data[$count] = $row;
                    $count++;
                }
            }
        }
        return $data;
    }


    function getAllInfoUser($limit = NULL,$start = NULL){
        
        //$this->db->where($this->_tables['users'].".id",$userid);
        if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","A");
        $this->db->where($this->_tables['employee'].".jobs_id =".$this->_tables['jobs'].".id");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->select($this->_tables['users'].".id as id,".$this->_tables['users'].".idn as idn,".$this->_tables['users'].".en_name as en_name,".$this->_tables['employee'].".grade as grade,".$this->_tables['employee'].".id as ide,".$this->_tables['users'].".mobile as mobile");
        $this->db->group_by($this->_tables['users'].".id");
        $this->db->order_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee'].",".$this->_tables['jobs']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getRejectedUsers($limit = NULL,$start = NULL){
         if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","R");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    function getPrecautionUsers($limit = NULL,$start = NULL){
         if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        
        $this->db->where($this->_tables['employee'].".year",date("Y"));
        $this->db->where($this->_tables['employee'].".isAccept","P");
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }
    
    function getUsers($limit = NULL,$start = NULL){
        if ($limit && $start) $this->db->limit($limit, $start);
        $query = $this->db->get($this->_tables['users']);
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    function get_total_users()
    {
        return $this->db->count_all_results($this->_tables['users']);
    }


    function get_info_user($type = "all",$userid = "me")
    {
        if(empty($type) || empty($userid)) return false;
        
        if($userid == "me")
        {
            switch ($type)
            {
                case 'id':
                    return $this->session->userdata('userid');
                    break;

                case 'group':
                    return $this->session->userdata('group');
                    break;
                
                case 'groupType':
                    return $this->session->userdata('groupType');
                    break;

                case 'all':
                default:
                    $this->db->where("id",$this->session->userdata('userid'));
                    $query = $this->db->get($this->_tables['users']);
                    return $query->row();
                    break;
            }
        }else
        {
            if(strlen($userid) == 10)
                $this->db->where("idn",$userid);
            else
                $this->db->where("id",$userid);
            $query = $this->db->get($this->_tables['users']);
            $data['profile'] = ($query->num_rows() > 0)? $query->row():false;
            if(!$this->checkIfCandidate($userid) && !is_bool($data['profile'])){
                if($this->checkIfEmployee("accepted", $userid))
                    $data['status']  = 1;
                else if ($this->checkIfEmployee("rejected", $userid))
                    $data['status'] = 0;
                else
                    $data['status'] = 2;
            }
            return $data;
        }
    }
    
    function login($id = 0,$password = '')
    {
        if(empty($id) || empty($password))
            return FALSE;
        
        $this->db->where("idn",$id);
        $this->db->where("password", $this->ecrypt_password($password));
        $query = $this->db->get($this->_tables['users']);
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $this->setSession($row->id, $row->group_id);
            return true;
        }else
            return FALSE;
            
    }
    
    function logout()
    {
        $this->unsetSession();
        return true;
    }


    private function setSession($id,$groupId)
    {
        $data = $this->getPermissions($groupId);
        $data['userid'] = $id;
        $data['group'] = $groupId;
        $this->session->set_userdata($data);
    }
    
    private function unsetSession()
    {
        $data['premissions'] = '';
        $data['userid'] = '';
        $data['group'] = '';
        $this->session->unset_userdata($data);
    }
    
    function addNewPermission($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['permissions'], $data); 
    }
    
    function updatePermission($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['permissions'], $data); 
    }
    
    function deletePermission($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['permissions']); 
    }

    
    public function getAllPermissions($groupId){
        if(empty($groupId))
            return false;
        
        $this->db->where("group_id",$groupId);
        $query = $this->db->get($this->_tables['permissions']);
        return($query->num_rows() > 0)? $query->result():false;
    }


    private function getPermissions($groupId)
    {
        if($this->checkIfNotUser($groupId))
        {
            $data = array();
            $first = true;
            $this->db->where("group_id",$groupId);
            $this->db->group_by(array('service_name','function_name','value'));
            $query = $this->db->get($this->_tables['permissions']);
            foreach ($query->result() as $row)
            {
                if($row->function_name == "all")
                    $data['permissions'][$row->service_name] =  true;
                else
                {
                    if($row->value == "all")
                        $data['permissions'][$row->service_name][$row->function_name] = true;
                    else
                    {
                        if($row->other_value == "all")
                            $data['permissions'][$row->service_name][$row->function_name][$row->value] = true;
                        else
                            $data['permissions'][$row->service_name][$row->function_name][$row->value][$row->other_value] = true;
                    }
                }
                $first = FALSE;
            }
            $data['groupType'] = "admin";
            return $data;
        }else
            return array(
                'permissions' => false,
                'groupType'   => "user"
                );
    }
    
    public function isLogin($redirect = FALSE)
    {
        if ($this->session->userdata('userid'))
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
    
    public function checkIfUser()
    {
        return ($this->session->userdata('groupType') == "user") ? true : false;
    }
    
    public function checkIfHavePremission($service_name = "admin",$function_name = "all",$value = "all",$otherValue = "all")
    {
        if(empty($service_name) || empty($function_name) || empty($value) || empty($otherValue))
            return FALSE;
        
        $premission = $this->session->userdata('permissions');
        $accessGrade = (isset($premission[$service_name]))?1:0;
        $accessAdmin = (isset($premission[$service_name]))?1:4;
        
        if($function_name != "all"){
            $accessGrade++;
            if($value != "all") { 
                $accessGrade++;
                if($otherValue != "all") 
                    $accessGrade++;
            }
        } 
        if($accessAdmin == 1){
            if(!is_bool($premission[$service_name])){
                $accessAdmin++;
                if(!is_bool($premission[$service_name][$function_name])) { 
                    $accessAdmin++;
                    if(!is_bool($premission[$service_name][$function_name][$value])) 
                        $accessAdmin++;
                }
            }
        }
        $this->setSession($this->session->userdata('userid'),$this->session->userdata('group'));
        return ($accessGrade >= $accessAdmin)? true:false;
    }


    private function checkIfNotUser($groupId)
    {
        $this->db->where("id",$groupId);
        $this->db->where("is_admin","y");
        $query = $this->db->get($this->_tables['group']);
        return ($query->num_rows() > 0) ? true:false;
    }

    private function checkIfEmployee($type,$userid)
    {
        $this->db->where("users_id",$userid);
        $this->db->where("year",date('Y'));
        $value = ($type == "rejected") ? 0:(($type =="accepted")?1:2);
        $this->db->where("isAccept",$value);
        $query = $this->db->get($this->_tables['employee']);
        return ($query->num_rows() > 0)? true:false;
    }
    
    private function checkIfCandidate($userid)
    {
        $this->db->where("users_id",$userid);
        $this->db->where("year",date('Y'));
        $query = $this->db->get($this->_tables['employee']);
        if($query->num_rows() == 0)
            return true;
        else
            return false;
    }
    
    
    /**
     * هذه الفانكشن لعملية القبول
     * @param int $userid = id of user
     * @param int $stuta  0 rejected 1 accept 2 Precaution
     * 
     */
    public function changeCandidate($userid,$stuta,$grade,$job_id)
    {
        if(empty($userid) || empty($stuta) || empty($grade) || empty($job_id))
            return false;
        if($this->checkIfCandidate($userid))
        {
            $data = array(
                'year'      => date('Y'),
                'isAceept'  => $stuta,
                'grade'     => $grade,
                'users_id'  => $userid,
                'jobs_id'   => $job_id
            );
            return $this->db->insert($this->_tables['employee'],$data);
        }  
        else 
            return false;
        
    }

    
    
    function updateUser($userid,$data)
    {
        if(empty($userid) || !is_array($data))
            return false;
        $this->db->where("id",$userid);
        return $this->db->update($this->_tables['users'],$data);
    }
    
    function deleteUser($userid)
    {
        if(empty($userid))
            return false;
        $this->db->where("id",$userid);
        return $this->db->delete($this->_tables['users']);
    }
    
    function register($data)
    {
        if(!is_array($data))
            return false;
        
        $data['password'] = $this->ecrypt_password($data['password']);
        return $this->db->insert($this->_tables['users'], $data); 
        
    }
    
    function get_card_data($employee_id = 0)
    {
        $this->db->where($this->_tables['users'].".idn",$employee_id);
        $this->db->where($this->_tables['users'].".id =".$this->_tables['employee'].".users_id");
        $this->db->group_by($this->_tables['users'].".id");
        
        $query = $this->db->get($this->_tables['users'].",".$this->_tables['employee']);
        return ($query->num_rows() > 0) ? $query->row() : false;
        
    }

}
