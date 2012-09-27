<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    private $_tables = array(
        'users'         =>  "users",
        'group'         =>  "group",
        'permissions'   =>  "permissions",
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

                case 'all':
                default:
                    $this->db->where("id",$this->session->userdata('userid'));
                    $query = $this->db->get($this->_tables['users']);
                    return $query->row();
                    break;
            }
        }else
        {
            $this->db->where("id",$userid);
            $query = $this->db->get($this->_tables['users']);
            $data['profile'] = $query->row();
            if(!$this->checkIfCandidate($userid)){
                if($this->checkIfEmployee("accepted", $userid))
                    $data['status']  = 1;
                else if ($this->checkIfEmployee("rejected", $userid))
                    $data['status'] = 0;
                else
                    $data['status'] = 2;
            }
        }
    }
    
    function login($id,$password)
    {
        if(empty($id) || empty($password))
            return FALSE;
        
        $this->db->where("id",$id);
        $this->db->where("password",  md5($password));
        $query = $this->db->get($this->_tables['users']);
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $this->setSession($id, $row->group_id);
            return true;
        }else
            return FALSE;
            
    }
    
    function logout()
    {
        if(isset($this->session->userdata('userid')))
        {
            $this->unsetSession();
        }
        return true;
    }


    private function setSession($id,$groupId)
    {
        $data = $this->getPermissions($groupId);
        $data['userid'] = $id;
        $data['group'] = $groupId;
        $this->session->set_userdata($array);
    }
    
    private function unsetSession()
    {
        $data['premissions'] = '';
        $data['id'] = '';
        $data['group'] = '';
        $this->session->unset_userdata($array);
    }
    
    private function getPermissions($groupId)
    {
        if($this->checkIfNotUser($groupId))
        {
            $data = array();
            $first = true;
            $this->db->where("id",$groupId);
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
    
    public function isLogin()
    {
        return (isset($this->session->userdata('userid'))) ? true : false;
    }
    
    public function checkIfUser()
    {
        return ($this->session->userdata('groupType') == "user") ? true : false;
    }
    
    public function checkIfHavePremission($service_name = "admin",$function_name = "all",$value = "all",$otherValue = "all")
    {
        if(empty($service_name) || empty($function_name) || empty($value) || empty($otherValue))
            return FALSE;
        
        $premission = $this->session->userdata('premissions');
        $accessGrade = (isset($premission[$service_name]))?1:0;
        $accessAdmin = 1;
        
        
        if($function_name != "all"){
            $accessGrade++;
            if($value != "all") { 
                $accessGrade++;
                if($otherValue != "all") 
                    $accessGrade++;
            }
        }
        
        if(!is_bool($premission[$service_name])){
            $accessAdmin++;
            if(!is_bool($premission[$service_name][$function_name])) { 
                $accessAdmin++;
                if(!is_bool($premission[$service_name][$function_name][$value])) 
                    $accessAdmin++;
            }
        }
        
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
        $this->db->update($this->_tables['users'],$data);
    }
    
    function register($data)
    {
        if(!is_array($data))
            return false;
        
        return $this->db->insert($this->_tables['users'], $data); 
        
    }

}
