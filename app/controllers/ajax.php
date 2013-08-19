<?php

/**
 * this class for add,edit and remove from ajax table
 * 
 * @author Faris Al-Otaibi
 */
class ajax extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model("datatables");
    }
    
    function index(){
        show_404();
    }
    
    private function __dataeditUsers($data,$key = "mobile"){
        if(!is_array($data))
            return false;
        
        $editimg = img('style/icon/edit.png');
        $cardsimg = img('style/icon/cards.png');
        for($i = 0 ; $i<count($data);$i++){
            $idn = $data[$i]['idn'];
            $id = $data[$i]['id'];
            $url = anchor("employee/profile/".$idn,$editimg);
            $cards = anchor("penalty/add/penalty/".$id,$cardsimg);
            $data[$i][$key] = $url.$cards;
            $delimgdetail = array(
                'src'       => 'style/icon/del.png',
                'alt'       => 'delete users',
                'onClick'   => 'deleted(\''.  base_url().'employee/users/0/del/'.$id.'\',\'users'.$id.'\',\'Not Found\')'
            );
            $delimg = img($delimgdetail);
            $data[$i][$key] .= $delimg; 
        }
        return $data;
    }
    
    private function __dataeditUsers1($data,$key = "mobile"){
        if(!is_array($data))
            return false;
        
        $this->load->helper('form');
        $editimg = img('style/icon/edit.png');
        $cardsimg = img('style/icon/cards.png');
        for($i = 0 ; $i<count($data);$i++){
            $idn = $data[$i]['idn'];
            $id = $data[$i]['id'];
            $data1 = array(
                'name' => 'users'.$data[$i]['id']."accept",
                'id' => 'users'.$data[$i]['id']."accept",
                'onclick' => "candidate('".base_url()."employee/accepted/0/candidate/".$data[$i]['id']."','users".$data[$i]['id']."','accept')",
                'content' => 'Candidate'
            );

            $accept = form_button($data1);
            $data1 = array(
                'name' => 'users'.$data[$i]['id']."reject",
                'id' => 'users'.$data[$i]['id']."reject",
                'onclick' => "candidate('".base_url()."employee/accepted/0/reject/".$data[$i]['id']."','users".$data[$i]['id']."','reject')",
                'content' => 'Reject'
            );

            $reject = form_button($data1);
            $data1 = array(
                'name' => 'users'.$data[$i]['id']."precau",
                'id' => 'users'.$data[$i]['id']."precau",
                'onclick' => "candidate('".base_url()."employee/accepted/0/precau/".$data[$i]['id']."','users".$data[$i]['id']."','precau')",
                'content' => 'Precaution'
            );

            $precau = form_button($data1);
            $data[$i]['idn'] = anchor("employee/profile/".$idn,$idn);
            //$url = anchor("employee/profile/".$idn,$editimg);
            /*$cards = anchor("penalty/add/penalty/".$id,$cardsimg);
            $data[$i][$key] = $url.$cards;
            $delimgdetail = array(
                'src'       => 'style/icon/del.png',
                'alt'       => 'delete users',
                'onClick'   => 'deleted(\''.  base_url().'employee/users/0/del/'.$id.'\',\'users'.$id.'\',\'Not Found\')'
            );
            $delimg = img($delimgdetail);*/
            $data[$i][$key] = $accept.$reject.$precau; 
        }
        return $data;
    }


    function users(){
        
        $columns = array(
            "id",
            "idn",
            "en_name",
            "mobile"
            );
        $this->datatables->beforeQuery($columns);
        $query = $this->users->getUsers(NULL,NULL,true);
        $totalAfterfiltering = $this->datatables->getNumberOfRowForFilterData();
        $data['iTotalDisplayRecords'] = $totalAfterfiltering;
        $data['iTotalRecords'] = "".$this->users->get_total_users()."";
        echo $this->datatables->afterQuery($data,$this->__dataeditUsers($query));
    }
    
    function accepted(){
        
        $columns = array(
            "`Employee`.`contract_id`",
            "`users`.`idn`",
            "`users`.`en_name`",
            "`jobs`.`name`",
            "`users`.`mobile`",
            "`users`.`id`"
            );
        $this->datatables->beforeQuery($columns);
        $query = $this->users->getAllInfoUser(NULL,NULL,true);
        $totalAfterfiltering = $this->datatables->getNumberOfRowForFilterData();
        $data['iTotalDisplayRecords'] = $totalAfterfiltering;
        $data['iTotalRecords'] = "".$this->users->get_total_info_users()."";
        echo $this->datatables->afterQuery($data,$this->__dataeditUsers1($query,'id'));
    }
}

?>
