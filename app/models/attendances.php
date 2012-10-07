<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this class for add Attendance or edit or remove it
 *
 * @author Faris Al-Otaibi
 */
class attendances extends CI_Model {
   
    private $_tables = array(
        'attend'    => "attend",
        'today'     => "attend_today",
        'sheet'     => "attend_sheet"
    );
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     *
     * @param int $superviser
     * @return boolean 
     */
    function addNewAttendance($data)
    {
        if(!is_array($data)) return false;
        
        return $this->db->insert($this->_tables['attend'], $data); 
    }
    
    /**
     *
     * @param int $attendid
     * @return boolean 
     */
    function startAttendance($attendid,$groupId)
    {
        if(empty($attendid)) return false;
        
        $data = array(
            'date'      => date("y-m-d"),
            'time'      => date("h:i"),
            'attend_id' => $attendid,
            'group_id'  => $groupId
        );
        return $this->db->insert($this->_tables['today'], $data); 
    }
    
    /**
     *
     * @param int $attendTodayId
     * @param int $userid
     * @return boolean 
     */
    function takeAttendance($attendTodayId,$userid)
    {
        if(empty($userid) || empty($attendTodayId)) return false;
        
        $data = array(
            'users_id'          => $userid,
            'time'              => date("h:i"),
            'attend_today_id'   => $attendTodayId
        );
        return $this->db->insert($this->_tables['sheet'], $data); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function getAttendance($id)
    {
        if(empty($id)) return false;
        
        if(is_numeric($id))
        {
            $this->db->where('id',$id);
        }
        $query = $this->db->get($this->_tables['attend']);
        return ($query->num_rows() > 0)? $query->result() : false; 
    }
    
    /**
     *
     * @param mixd $id
     * @return boolean 
     */
    function getAttendanceToday($id)
    {
        if(empty($id)) return false;
        
        if(is_numeric($id))
        {
            $this->db->where('id',$id);
        }
        $this->db->order_by("id"); 
        $query = $this->db->get($this->_tables['today']);
        return ($query->num_rows() > 0)? $query->result() : false;
    }
    
    /**
     *
     * @param mixd $id
     * @return boolean 
     */
    function getAttendanceSheet($userid,$attendTodayId = "all")
    {
        if(empty($userid) || empty($attendTodayId)) return false;
        if($attendTodayId == "all"){
            if(is_numeric($userid))
            {
                $this->db->where('users_id',$userid);
            }
            $this->db->order_by("id"); 
            $query = $this->db->get($this->_tables['sheet']);
            return ($query->num_rows() > 0)? $query->result() : false;
        }else{
            if(is_numeric($userid))
            {
                $this->db->where('users_id',$userid);
            }
            $this->db->where('attend_today_id',$attendTodayId);
            $this->db->order_by("id"); 
            $query = $this->db->get($this->_tables['sheet']);
            return ($query->num_rows() > 0)? $query->result() : false;
        }
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deleteAttendanceSheet($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['sheet']); 
    }
    
    /**
     *
     * @param int $id
     * @return boolean 
     */
    function deleteAttendance($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_tables['attend']); 
    }
    
    /**
     *
     * @param int $id
     * @param array $data
     * @return boolean 
     */
    function updateAttendance($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_tables['attend'],$data); 
    }
    
}

?>
