<?php

/**
 * this class for add,edit and remove from post table
 * 
 * @author Faris Al-Otaibi
 */
class post extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("posts");
        $this->lang->load('post', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
        if(!$this->users->isLogin())
            show_404 ();
    }
    
    function index(){
        $this->view();
    }
    
    function view(){
        if($this->users->checkIfUser()){
            $userid = $this->users->get_info_user("id");
            $data['query'] = $this->posts->getPosts($userid);
            $data['CONTROL'] = False;
            $data['STEP'] = "view";
        }else if($this->core->checkPermissions("post","view")){
            $data['query'] = $this->posts->getPosts("All");
            $data['CONTROL'] = true;
            $data['STEP'] = "view";
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('post_view');
        $data['CONTENT'] = 'employee/post';
        $this->core->load_template($data);
    }
    
    function add(){
        if($this->users->checkIfUser() || $this->core->checkPermissions("post","add","all","all")){
            if($_POST){
                $store = array(
                    'title'         => $this->input->post("title",true),
                    'date'          => date("y-m-d h:i:s"),
                    'notemessage'   => $this->input->post("note",true),
                    'numberOfPost'  => $this->input->post("number",true),
                    'from_users_id' => $this->users->get_info_user("id")
                );
                if(!$this->posts->addNewPost($store)){
                    $data['STEP'] = "add";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('post_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'post/show/'.$this->db->insert_id(), 'type' => 'equiv'));
                }
            }else{
                $data['STEP'] = "add";
                $data['ERROR'] = false;
            }
                
        }else
            redirect ("");
        
        $data['TITLE'] = $this->lang->line('post_view');
        $data['CONTENT'] = 'employee/post';
        $this->core->load_template($data);
    }
    
    function delete(){
        if(!$this->core->checkPermissions("post","delete","all","all"))
            redirect ("");
        
        $segments = $this->uri->segment_array();
        $postID = (isset($segments[3]))? $segments[3] : 0;
        if($postID != 0){
            $row = $this->posts->getPost($postID);
            if(is_bool($row))
                echo $this->lang->line('post_delete_error');
            
           if($this->posts->deletePost($postID))
               echo $this->lang->line('post_delete_success');    
           else
               echo $this->lang->line('post_delete_error');  
               
        }else
            echo $this->lang->line('post_delete_error');
    }


    function edit(){
        $postID = $this->uri->segment(3, 0);
        if(empty($postID))
            show_404 ();
        
        $userid = $this->users->get_info_user("id");
        $row = $this->posts->getPost($postID);
        if(is_bool($row))
            show_404 ();
        else {
            if($row->from_users_id == $userid ){
                if($_POST){
                    $store = array(
                        'title'         => $this->input->post("title",true),
                        'notemessage'   => $this->input->post("note",true)
                    );
                    if(!$this->posts->updatePost($postID,$store)){
                        $data['STEP'] = "edit";
                        $data['ID'] = $postID;
                        $userid = $this->users->get_info_user("id");
                        if(!is_bool($row)){
                            $data['TITLEM'] = $row->title;
                            $data['NOTEM'] = $row->notemessage;
                        }else
                            show_404 ();
                        $data['ERROR'] = true;
                    }else
                    {
                        $data['STEP'] = "success";
                        $data['MSG'] = $this->lang->line('post_edit_success');
                        $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'post/show/'.((is_null($row->post_id))? $postID:$row->post_id), 'type' => 'equiv'));
                    }
                }else{
                    $data['STEP'] = "edit";
                    $data['ID'] = $postID;
                    $row = $this->posts->getPost($postID);
                    if(!is_bool($row)){
                        $data['TITLEM'] = $row->title;
                        $data['NOTEM'] = $row->notemessage;
                    }else
                        show_404 ();
                    $data['ERROR'] = false;
                }

            }else
                redirect ("post/show/".(is_null($row->post_id))? $row->id : $row->post_id);
        }
        
        $data['TITLE'] = $this->lang->line('post_view');
        $data['CONTENT'] = 'employee/post';
        $this->core->load_template($data);
    }
    
    function show(){
        $postID = $this->uri->segment(3, 0);
        $userid = $this->users->get_info_user("id");
        if(empty($postID))
            show_404 ();
        $row = $this->posts->getPost($postID);
        if(($userid == $row->from_users_id) || $this->core->checkPermissions("post","show","all","all")){
            if($_POST){
               $store = array(
                    'title'         => $this->input->post("title",true),
                    'date'          => date("y-m-d h:i:s"),
                    'notemessage'   => $this->input->post("note",true),
                    'numberOfPost'  => $this->input->post("number",true),
                    'from_users_id' => $this->users->get_info_user("id"),
                    'post_id'       => $postID
                );
                if(!$this->posts->addNewPost($store)){
                    $data['STEP'] = "show";
                    $data['ERROR'] = true;
                }else
                {
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('post_add_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'post/show/'.$postID, 'type' => 'equiv'));
                } 
            }else {
                $userInfo = $this->users->get_info_user("all",$row->from_users_id);
                $data['TITLEM'] = $row->title;
                $data['NOTEM'] = $row->notemessage;
                $data['DATE'] = $row->date;
                $data['FROM'] = $userInfo['profile']->en_name;
                $data['REPLAY'] = $this->posts->getReplays($postID);
                $data['TITLE'] = $row->title;
                $data['STEP'] = "show";
            }
        }else
            redirect ("");
        
        $data['CONTENT'] = 'employee/post';
        $this->core->load_template($data);
    }
}

?>
