<?php

/**
 * this class for add,edit and remove from dataTables table
 * 
 * @author Faris Al-Otaibi
 */
class datatables extends CI_Model {
    
    private $data ;
    private $num_column;
    private $aColumns;


    function __construct() {
        parent::__construct();
    }
    
    private function _checkInput(){
        $this->data = array(
            'iDisplayStart'     => $this->input->post("iDisplayStart",true),
            'iDisplayLength'    => $this->input->post("iDisplayLength",true),
            'iSortCol_0'        => $this->input->post("iSortCol_0",true),
            'iSortingCols'      => $this->input->post("iSortingCols",true),
            'sSearch'           => $this->input->post("sSearch",true),
            'sEcho'             => $this->input->post("sEcho",true)
        );
        if ( $this->data['iSortCol_0'] )
	{
            for ( $i=0 ; $i<intval( $this->data['iSortingCols'] ) ; $i++ )
            {
                    $this->data['bSortable_'.intval($this->input->post('iSortCol_'.$i,true)) ] = $this->input->post('bSortable_'.intval($this->input->post('iSortCol_'.$i,true)),true);
                    $this->data['iSortCol_'.$i] = $this->input->post('iSortCol_'.$i,true);
                    $this->data['sSortDir_'.$i] = $this->input->post('sSortDir_'.$i,true);
                    
            }
        }
        
        for($i=0;$i<$this->num_column;$i++){
            $this->data['bSearchable_'.$i] = $this->input->post('bSearchable_'.$i,true);
            $this->data['sSearch_'.$i] = $this->input->post('sSearch_'.$i,true);
        }
    }
    
    private function checkIfAjaxRequest(){
        return $this->input->is_ajax_request();
    }
    
    private function fatal_error ( $sErrorMessage = '' )
    {
            header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
            die( $sErrorMessage );
    }
    
    private function paging(){
	if ( isset( $this->data['iDisplayStart'] ) && $this->data['iDisplayLength'] != '-1' )
	{
            $this->db->limit($this->data['iDisplayLength'],$this->data['iDisplayStart']);
	}
    }
    
    private function ordering(){
	if ( isset( $this->data['iSortCol_0'] ) )
	{
            for ( $i=0 ; $i<intval( $this->data['iSortingCols'] ) ; $i++ )
            {
                    if ( @$this->data[ 'bSortable_'.intval($this->data['iSortCol_'.$i]) ] == "true" )
                    {
                                $this->db->order_by($this->aColumns[intval($this->data['iSortCol_'.$i])],$this->data['sSortDir_'.$i]);
                    }
            }
	}
    }
    
    private function filtering(){
	if ( isset($this->data['sSearch']) && $this->data['sSearch'] != "" )
	{
		for ( $i=0 ; $i<$this->num_column ; $i++ )
		{
                        if($i == 0)
                            $this->db->like($this->aColumns[$i],$this->data['sSearch']);
                        else
                            $this->db->or_like($this->aColumns[$i],$this->data['sSearch']);
		}
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<$this->num_column ; $i++ )
	{
		if ( isset($this->data['bSearchable_'.$i]) && $this->data['bSearchable_'.$i] == "true" && $this->data['sSearch_'.$i] != '' )
		{
			$this->db->like($this->aColumns[$i],$this->data['sSearch_'.$i]);
		}
	}
    }
    
    private function Selecting(){
        $selectCommand = "SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $this->aColumns))."";
        $this->db->select($selectCommand,false);
    }
    
    public function getNumberOfRowForFilterData(){
        $query = $this->db->query("SELECT FOUND_ROWS() as total");
        $result = $query->result_array();
        return $result[0]['total'];
    }
    
    public function beforeQuery($columns){
        if(!is_array($columns))
            @$this->fatal_error("Not Found Columns");
        
        if(!$this->checkIfAjaxRequest())
            @$this->fatal_error ("this page use only by ajax");
        
        $this->aColumns = $columns;
        $this->num_column = count($columns);
        $this->_checkInput();
        
        $this->paging();
        $this->ordering();
        $this->filtering();
        $this->Selecting();
        
    }
    
    public function afterQuery($data,$result){
        if(!is_array($this->aColumns) || !is_array($data)|| !is_array($result))
            @$this->fatal_error("cannot use this function before query");
        
        
        $output = array(
            'sEcho'                 => $this->data['sEcho'],
            "iTotalRecords"         => $data['iTotalRecords'],
            "iTotalDisplayRecords"  => $data['iTotalDisplayRecords'],
            "aaData"                => array()
        );
        
        foreach ($result as $row){
            $rows = array();
            foreach ($row as  $column){
                $rows[] = $column;
            }
            $output['aaData'][] = $rows;
        }
        
        if(function_exists('json_encode'))
            return json_encode( $output );
        else
            return $this->json_encode($output);
    }
    
    private function json_encode($data){
        if(!is_array($data))
            @$this->fatal_error("There are problem in parameter which send it in json_encode function");
        
        $output = "{";
        foreach ($data as $key => $value){
            if(is_array($value)){
                $output .= '"'.$key .'": [';
                foreach ($value as $k=> $var){
                    $output .= '[';
                    if(is_array($var))
                    foreach ($var as $col)
                        $output .= '"'.$col .'",';
                    else
                        $output .= '"'.$k .'":"'.$var.'"';
                    $output = substr_replace( $output, "", -1 );
                    $output .= '],';
                }
                $output = substr_replace( $output, "", -1 );
                $output .= ']';
            }else{
                    $output .= '"'.$key .'":"'.$value.'"';
            }
            $output .= ',';
        }
        $output = substr_replace( $output, "", -1 );
        $output .= "}";
        return $output;
    }
}

?>
