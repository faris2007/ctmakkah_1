<?php

/**
 * this class for add,edit and remove from transports table
 * 
 * @author Faris Al-Otaibi
 */
class transports extends CI_Model {
   
    private $_table = "transports";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewTransport($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_table, $data); 
    }
    
    
    /**
     *
     * @param mixd $userid
     * @return boolean 
     */
    function getTransports($id)
    {
        if(empty($id)) return false;
        
        if(is_numeric($id))
        {
            $this->db->where('id',$id);
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
    function deleteTransport($id)
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
    function updateTransport($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
}

?>
