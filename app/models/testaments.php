<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this class for add,remove or edit testament for any user
 *
 * @author Faris Al-Otaibi
 */
class testaments  extends CI_Model{
    
    private $_tables = array(
        'testament' => "Testament",
        'link'      => "Testament_has_users"
    );
    
    /**
     *
     * @param array $data 
     */
    function addNewTestament($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['testament'], $data); 
    }
    
    /**
     *
     * @param int $userid
     * @param int $workid
     * @return boolean 
     */
    function addTestamentToUser($data)
    {
        if(!is_array($data)) return false;
        
        
        return $this->db->insert($this->_tables['link'], $data); 
    }
    
    /**
     *
     * @param int $userid
     * @param int $workid
     * @return boolean 
     */
    function deleteTestamentFromUser($userid,$testamentid)
    {
        if(empty($userid) || empty($testamentid)) return false;
        
        $data = array(
            'users_id'      => $userid,
            'Testament_id'  => $testamentid
        );
        $this->db->where($data);
        return $this->db->delete($this->_tables['link']); 
    }
    
    function getTestament($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_tables['testament']);
        return ($query->num_rows() > 0)?$query->row():false;
    }
    
    /**
     *
     * @param mixd $userid if you send "admin" this meaning give me all tables
     */
    function getTestaments($userid)
    {
        if(empty($userid)) return false;
      
        if(is_numeric($userid))
        {
            $this->db->order_by($this->_tables['testament'].'.id',"DESC");
            $this->db->group_by($this->_tables['testament'].'.id');
            $this->db->where($this->_tables['link'].'.users_id',$userid);
            $this->db->where($this->_tables['testament'].'.id = '.$this->_tables['link'].'.Testament_id');
            $query = $this->db->get($this->_tables['testament'].",".$this->_tables['link']);
        }else
        {
            $this->db->order_by($this->_tables['testament'].'.id',"DESC");
            $query = $this->db->get($this->_tables['testament']);
        }
        return ($query->num_rows() > 0)?$query->result():false;
    }
    
    function getUsersHasTestaments()
    {
      
        $this->db->order_by('users.id',"DESC");
        $this->db->group_by('users.id');
        //$this->db->where($this->_tables['testament'].'.id = '.$this->_tables['link'].'.Testament_id');
        $this->db->where('users.id = '.$this->_tables['link'].'.users_id');
        $this->db->where('users.id = Employee.users_id');
        $this->db->select("users.idn as idn,users.en_name as en_name,Employee.grade as grade, users.mobile as mobile");
        $query = $this->db->get($this->_tables['link'].",users,Employee");//$this->_tables['testament'].",".
   
        return ($query->num_rows() > 0)?$query->result():false;
    }
    
    
    function getUsersHasNotTestaments()
    {
      
        $this->db->order_by('users.id',"DESC");
        $this->db->group_by('users.id');
        $this->db->where('users.id = '.$this->_tables['link'].'.users_id');
        $this->db->where('users.id = Employee.users_id');
        $this->db->where('Employee.isAccept',"A");
        $this->db->where("Employee.year","2012");
        $this->db->select($this->_tables['link'].'.users_id');
        $query1 = $this->db->get($this->_tables['link'].",users,Employee");
        $where = "users.id NOT IN (".$this->db->last_query().")";
        $this->db->where($where);
        $this->db->where('users.id = Employee.users_id');
        $this->db->where('Employee.isAccept',"A");
        $this->db->where("Employee.year","2012");
        $this->db->group_by("users.id");
        $this->db->select("users.idn as idn,users.en_name as en_name,Employee.grade as grade, users.mobile as mobile");
        $query = $this->db->get("users,Employee");
        return ($query->num_rows() > 0)?$query->result():false;
    }
    
    function deleteTestament($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['testament']); 
    }
    
    function updateTestament($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['testament'],$data); 
    }
}

?>
