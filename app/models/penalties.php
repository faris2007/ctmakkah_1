<?php

/**
 * this class for add,edit and remove from penalty table
 * 
 * @author Faris Al-Otaibi
 */
class penalties extends CI_Model {
   
    private $_tables = array( 
        'penalty' => "penalty",
        'type'    => "penaltyType"
        );
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewType($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['type'], $data); 
    }
    
    
    /**
     *
     * @param type $data
     * @return boolean 
     */
    function addNewPenalty($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['penalty'], $data); 
    }
    
    /**
     *
     * @param mixed $id
     * @return boolean 
     */
    function getTypes($id = "all")
    {
        if(empty($id)) return false;
        if(is_numeric($id))
            $this->db->where('id',$id);
        
        $query = $this->db->get($this->_tables['type']);
        return ($query->num_rows() > 0)? $query->result() : false; 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function getPenalty($id)
    {
        if(empty($id)) return false;
        
        $this->db->where($this->_tables['penalty'].'.id',$id);
        $this->db->where($this->_tables['penalty'].'.type = `'.$this->_tables['type'].'`.`id`');
        $this->db->group_by($this->_tables['penalty'].'.id');
        $query = $this->db->get($this->_tables['penalty'].",".$this->_tables['type']);
        return ($query->num_rows() > 0)? $query->row() : false; 
    }
    
    /**
     *
     * @param mixd $userid
     * @return boolean 
     */
    function getPenaltys($userid = "all")
    {
        if(empty($userid)) return false;
        
        if(is_numeric($userid))
        {
            $this->db->where('to_users_id',$userid);
        }
        $this->db->where($this->_tables['penalty'].'.type = `'.$this->_tables['type'].'`.`id`');
        $this->db->where($this->_tables['penalty'].'.to_users_id = `users`.`id`');
        $this->db->select($this->_tables['penalty'].'.id,'.$this->_tables['penalty'].'.date,'.$this->_tables['penalty'].'.time,'.$this->_tables['type'].'.name,users.en_name,'.$this->_tables['type'].'.penaltyAmount,'.$this->_tables['type'].'.length');
        $this->db->group_by($this->_tables['penalty'].'.id');
        $this->db->order_by("id"); 
        $query = $this->db->get($this->_tables['penalty'].",".$this->_tables['type'].",users");
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deleteType($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['type']); 
    }
    
    /**
     *
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    function updateType($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['type'],$data); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deletePenalty($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['penalty']); 
    }
    
    /**
     *
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    function updatePenalty($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['penalty'],$data); 
    }
    
}

?>
