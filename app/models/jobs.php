<?php

/**
 * this class for add,edit and remove from jobs table
 * 
 * @author Faris Al-Otaibi
 */
class jobs extends CI_Model {
   
    private $_table = "jobs";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewJob($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_table, $data); 
    }
    
    /**
     *
     * @param mixd $userid
     * @return boolean 
     */
    function getJobs($id)
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
    function deleteJob($id)
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
    function updateJob($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
    function job_name($job_id = 0)
    {
            $this->db->where('id',$job_id);
            $query = $this->db->get($this->_table);
            return ($query->num_rows() > 0)? $query->row()->name : '';             
    }
    
}

?>
