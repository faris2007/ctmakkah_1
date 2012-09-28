<?php

/**
 * this class for add,edit and remove from attachments table
 * 
 * @author Faris Al-Otaibi
 */
class attachments extends CI_Model {
   
    private $_table = "attachments";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewAttachment($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_table, $data); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function getAttachment($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_table);
        return ($query->num_rows() > 0)? $query->row() : false; 
    }
    
    /**
     *
     * @param mixd $userid
     * @return boolean 
     */
    function getAttachments($userid)
    {
        if(empty($userid)) return false;
        
        if(is_numeric($userid))
        {
            $this->db->where('users_id',$userid);
        }
        $this->db->order_by("id"); 
        $query = $this->db->get($this->_table);
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deleteAttachment($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_table); 
    }
    
    /**
     *
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    function updateAttachment($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
}

?>
