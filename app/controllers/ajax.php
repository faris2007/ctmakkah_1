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
        for($i = 0 ; $i<count($data);$i++){
            $url = anchor("employee/profile/".$data[$i]['idn'],$editimg);
            $data[$i][$key] = $url;
            $delimgdetail = array(
                'src'       => 'style/icon/del.png',
                'alt'       => 'delete users',
                'onClick'   => 'deleted(\''.  base_url().'employee/users/0/del/'.$data[$i]['id'].'\',\'users'.$data[$i]['id'].'\',\'Not Found\')'
            );
            $delimg = img($delimgdetail);
            $data[$i][$key] .= $delimg; 
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
            "`users`.`id`",
            "`users`.`idn`",
            "`users`.`en_name`",
            "`jobs`.`name`",
            "`users`.`mobile`",
            "`Employee`.`contract_id`",
            );
        $this->datatables->beforeQuery($columns);
        $query = $this->users->getAllInfoUser(NULL,NULL,true);
        $totalAfterfiltering = $this->datatables->getNumberOfRowForFilterData();
        $data['iTotalDisplayRecords'] = $totalAfterfiltering;
        $data['iTotalRecords'] = "".$this->users->get_total_info_users()."";
        echo $this->datatables->afterQuery($data,$this->__dataeditUsers($query,'contract_id'));
    }
}

?>
