<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this class for add or remove or edit forms
 *
 * @author Faris Al-Otaibi
 */
class forms {
    
    private $_tables = array(
        'forms' => "forms",
        'link'  => "users_has_forms"
    );
    
    /**
     *
     * @param array $data 
     */
    function addNewForm($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['forms'], $data); 
    }
    
    /**
     *
     * @param int $userid
     * @param int $workid
     * @return boolean 
     */
    function addFormToUser($userid,$formid)
    {
        if(empty($userid) || empty($formid)) return false;
        
        $data = array(
            'users_id'  => $userid,
            'forms_id'   => $formid
        );
        return $this->db->insert($this->_tables['link'], $data); 
    }
    
    function getForm($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_tables['forms']);
        return $query->row();
    }
    
    /**
     *
     * @param mixd $userid if you send "admin" this meaning give me all tables
     */
    function getForms($userid)
    {
        if(empty($userid)) return false;
      
        if(is_numeric($userid))
        {
            $this->db->order_by($this->_tables['forms'].'.id',"DESC"); 
            $this->db->where($this->_tables['link'].'.user_id',$userid);
            $this->db->where($this->_tables['forms'].'.id',$this->_tables['link'].'.forms_id');
            $query = $this->db->get($this->_tables['link'].",".$this->_tables['forms']);
        }else
        {
            $this->db->order_by($this->_tables['forms'].'.id',"DESC");
            $query = $this->db->get($this->_tables['forms']);
        }
        return $query->result();
    }
    
    function deleteForm($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['forms']); 
    }
    
    function updateForm($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['forms'],$data); 
    }
}

?>
