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
class works extends CI_Model {

    private $_tables = array(
        "work"  =>"work",
        "link"  =>"users_has_work"
        );
    
    function __construct() {
        parent::__construct();
    }
    
    
    /**
     *
     * @param string $type "work" or "traning"
     * @param array $data 
     */
    function addNewTable($data)
    {
        if(!is_array($data)) return false;

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
    
    
    function checkIfUserHaveTable($userId,$tableId){
        if(empty($userId) || empty($tableId))
            return false;
        
        $this->db->where($this->_tables['link'].'.users_id',$userId);
        $this->db->where($this->_tables['link'].'.work_id',$tableId);
        $query = $this->db->get($this->_tables['link']);
        return ($query->num_rows() > 0)? true : false;
    }
    
    
    function getTable($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_tables['work']);
        return ($query->num_rows() > 0)? $query->row() : false;
    }
    
    /**
     *
     * @param mixd $userid if you send "admin" this meaning give me all tables
     */
    function getTables($userid,$type = "work")
    {
        if(empty($userid)) return false;
      
        if(is_numeric($userid))
        {
            $this->db->order_by($this->_tables['work'].'.date');
            $this->db->group_by($this->_tables['work'].'.id'); 
            $this->db->where($this->_tables['link'].'.users_id',$userid);
            $this->db->where($this->_tables['work'].'.id ='.$this->_tables['link'].'.work_id');
            if($type == "work")
                $this->db->where("isTraning",'n');
            else
                $this->db->where("isTraning",'y');
            $query = $this->db->get($this->_tables['link'].",".$this->_tables['work']);
        }else
        {
            $this->db->order_by($this->_tables['work'].'.id',"DESC");
            $query = $this->db->get($this->_tables['work']);
        }
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    function getTablesByType($type = "W")
    {
        if(empty($type)) return FALSE;
        $this->db->where("isTraning",$type);
        $query = $this->db->get($this->_tables['work']);
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    function getUsersByTable($tableID,$type = "work",$limit = NULL,$start = NULL){
        if(empty($tableID))
            return false;
        if (!is_null($limit) && !is_null($start)) $this->db->limit($limit, $start);
        $this->db->order_by('users.id');
        $this->db->group_by('users.id'); 
        $this->db->where("Employee.jobs_id = jobs.id");
        $this->db->where("users.id = Employee.users_id");
        $this->db->where("users.id =".$this->_tables['link'].'.users_id');
        $this->db->where($this->_tables['link'].'.work_id',$tableID);
        $this->db->where($this->_tables['work'].'.id ='.$this->_tables['link'].'.work_id');
        if($type == "work")
            $this->db->where("isTraning",'n');
        else
            $this->db->where("isTraning",'y');
        $this->db->select("users.id as id,users.idn as idn,users.en_name as en_name,jobs.name as grade,Employee.id as ide,users.mobile as mobile");
        $query = $this->db->get($this->_tables['link'].",".$this->_tables['work'].",users,Employee,jobs");
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    function getTotalUsersByTable($tableID,$type = "work"){
        if(empty($tableID))
            return false;
        
        $this->db->order_by('users.id');
        $this->db->group_by('users.id'); 
        $this->db->where("Employee.jobs_id = jobs.id");
        $this->db->where("users.id = Employee.users_id");
        $this->db->where("users.id =".$this->_tables['link'].'.users_id');
        $this->db->where($this->_tables['link'].'.work_id',$tableID);
        $this->db->where($this->_tables['work'].'.id ='.$this->_tables['link'].'.work_id');
        if($type == "work")
            $this->db->where("isTraning",'n');
        else
            $this->db->where("isTraning",'y');
        $query = $this->db->get($this->_tables['link'].",".$this->_tables['work'].",users,Employee,jobs");
        return $query->num_rows() ;
    }


    function deleteTable($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['work']); 
    }
    
    function deleteUsersTable($userid,$workid)
    {
        if(empty($userid) || empty($workid)) return false;
        
        $this->db->where('users_id',$userid);
        $this->db->where('work_id',$workid);
        return $this->db->delete($this->_tables['link']); 
    }
    
    function updateTable($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['work'],$data); 
    }
}

?>
