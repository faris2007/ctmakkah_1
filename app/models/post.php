<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of post
 *
 * @author faris2007
 */
class post extends CI_Model {
    
    private $_table = "post";
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function addNewPost($data)
    {
        if(!is_array($data)) return false;
        return $this->db->insert($this->_table, $data); 
    }
    
    function getPost($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        $query = $this->db->get($this->_table);
        return $query->row();
    }
    
    function getPosts($userid)
    {
        if(empty($userid)) return false;
        
        $this->db->where('from_users_id',$userid);
        $this->db->or_where('to_users_id',$userid);
        $this->db->order_by("id"); 
        $query = $this->db->get($this->_table);
        return $query->row();
    }
    
    function deletePost($id)
    {
        if(empty($id)) return false;
        
        $this->db->where('id',$id);
        return $this->db->delete($this->_table); 
    }
    
    function updatePost($id,$data)
    {
        if(empty($id) || !is_array($data)) return false;
        
        $this->db->where('id',$id);
        return $this->db->update($this->_table,$data); 
    }
    
    
}

?>
