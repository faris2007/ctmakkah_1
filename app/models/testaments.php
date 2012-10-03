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
    function addTestamentToUser($userid,$testamentid,$deadline)
    {
        if(empty($userid) || empty($testamentid)) return false;
        
        $data = array(
            'users_id'      => $userid,
            'Testament_id'  => $testamentid,
            'deadline'      => $deadline
        );
        return $this->db->insert($this->_tables['link'], $data); 
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
            $this->db->where($this->_tables['link'].'.users_id',$userid);
            $this->db->where($this->_tables['testament'].'.id',$this->_tables['link'].'.Testament_id');
            $query = $this->db->get($this->_tables['link'].",".$this->_tables['testament']);
        }else
        {
            $this->db->order_by($this->_tables['testament'].'.id',"DESC");
            $query = $this->db->get($this->_tables['testament']);
        }
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
