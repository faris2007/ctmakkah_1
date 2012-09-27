<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of work
 *
 * @author Faris Al-Otaibi
 */
class work extends CI_Model {

    private $_tables = array(
        "work"  =>"work",
        "link"  =>"user_has_work"
        );
    
    function __construct() {
        parent::__construct();
    }
    
    
    /**
     *
     * @param string $type "work" or "traning"
     * @param array $data 
     */
    function addNewTable($type,$data)
    {
        if(empty($type) || !is_array($data)) return false;
        
        $data['isTraning'] = ($type == "traning")?"y":"n";
        return $this->db->insert($this->_tables['work'], $data); 
    }
    
    /**
    *
    * @param type $userid
    * @param type $workid
    * @return boolean 
    */
    function addTableToUser($userid,$workid)
    {
        if(empty($userid) || empty($workid)) return false;
        
        $data = array(
            'users_id'  => $userid,
            'work_id'   => $workid
        );
        return $this->db->insert($this->_tables['link'], $data); 
    }
    
    function getTable($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_tables['work']);
        return $query->row();
    }
    
    /**
     *
     * @param mixd $userid if you send "admin" this meaning give me all tables
     */
    function getTables($userid)
    {
        if(empty($userid)) return false;
      
        if(is_numeric($userid))
        {
            $this->db->order_by($this->_tables['work'].'.id',"DESC"); 
            $this->db->where($this->_tables['link'].'.user_id',$userid);
            $this->db->where($this->_tables['work'].'.id',$this->_tables['link'].'.work_id');
            $query = $this->db->get($this->_tables['link'].",".$this->_tables['work']);
        }else
        {
            $this->db->order_by($this->_tables['work'].'.id',"DESC");
            $query = $this->db->get($this->_tables['work']);
        }
        return $query->result();
    }
    
    function deleteTable($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['work']); 
    }
    
    function updateTable($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['work'],$data); 
    }
}

?>
