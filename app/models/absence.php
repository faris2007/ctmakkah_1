<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this class for add absence or edit or remove it
 *
 * @author Faris Al-Otaibi
 */
class absence extends CI_Model {
   
    private $_table = "absence";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewAbsence($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_table, $data); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function getAbsence($id)
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
    function getAbsences($userid)
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
    function deleteAbsence($id)
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
    function updateAbsence($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
}

?>
