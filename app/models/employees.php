<?php

/**
 * this class for add,edit and remove from employee table
 * 
 * @author Faris Al-Otaibi
 */
class employees extends CI_Model {
   
    private $_table = "Employee";
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewEmployee($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_table, $data); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function getEmployee($id)
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
    function getEmployees($userid)
    {
        if(empty($userid)) return false;
        
        if(is_numeric($userid))
        {
            $this->db->where('users_id',$userid);
        }
        $this->db->order_by("id","DESC"); 
        $query = $this->db->get($this->_table);
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deleteEmployee($id)
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
    function updateEmployee($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
    /**
     *
     * @param array $data
     * @return boolean 
     */
    function updateALLAcceptedEmployee($data)
    {
        if(!is_array($data)) return false;
        
        $this->db->where('year',date("Y"));
        $this->db->where('isAccept','A');
        return $this->db->update($this->_table,$data); 
    }
    
    function signature($employee_id = 0,$signature_data = NULL)
    {
        if ($signature_data)
        {
            $this->db->where('id', $employee_id);
            return $this->db->update($this->_table, array('signature' => $signature_data));            
        }else{
            $this->db->where('id',$employee_id);
            $query = $this->db->get($this->_table);
            return ($query->num_rows() > 0)? $query->row()->signature : '';             
        }
    }
}

?>
