<?php

/**
 * this class for add,edit and remove from test table
 * 
 * @author Faris Al-Otaibi
 */
class test extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->load->model("employees");
        $string = read_file('./uploads/accepted.csv');
        $col = array();
        $line = explode('
', $string);
        foreach ($line as $value)
            $col[] = explode (";", $value);
        
        //echo highlight_string(print_r($line));
        //echo "<br />";
        //print_r($col[0]);
        //print_r($col[1]);
        //echo count($col);697
        $idl = array(1,697,1394,2091);
        $idu = array(697,1394,2091,count($col));
        for($i=$idl[3];$i<$idu[3];$i++){
            if(($i%100) == 0)
            {
                echo "sleep | ";
                sleep(1);
            }
            $user = $this->users->get_info_user("all",$col[$i][1]);
            if(!$user['profile']){
                $data = array(
                    'idn'           => isset($col[$i][1]) ? $col[$i][1] : NULL,
                    'password'      => sha1($col[$i][1]),
                    'en_name'       => isset($col[$i][0]) ? $col[$i][0] : NULL,
                    'mobile'        => isset($col[$i][2]) ? $col[$i][2] : NULL
                 );
                if($this->users->register($data)){
                   $userid = $this->db->insert_id();
                   $store = array(
                      'year'        => date("Y"),
                      'isAccept'    => "A" ,
                      'grade'       => $col[$i][3] ,
                      'users_id'    => $userid ,
                   );
                   if(@ereg("ROVING",$col[$i][3]))
                           $store['jobs_id'] = 1;
                   elseif(@ereg("TRAIN",$col[$i][3]))
                           $store['jobs_id'] = 2;
                   elseif(@ereg("PSD",$col[$i][3]))
                           $store['jobs_id'] = 3;
                   elseif(@ereg("PLATFORM",$col[$i][3]))
                           $store['jobs_id'] = 4;
                   elseif(@ereg("LIFT",$col[$i][3]))
                           $store['jobs_id'] = 5;
                   elseif(@ereg("RAMP",$col[$i][3]))
                           $store['jobs_id'] = 6;
                   elseif(@ereg("FOOTBRIDGE",$col[$i][3]))
                           $store['jobs_id'] = 7;
                   elseif(@ereg("ESCALATOR",$col[$i][3]))
                           $store['jobs_id'] = 11;
                   else
                           $store['jobs_id'] = 4;
                       
                   if($this->employees->addNewEmployee($store))
                       echo "Add in users and Employee";
                   else
                       echo "there is problem"; 
                }else {
                   echo "there is problem"; 
                }
                  
            }else
            {
                $userid = $user['profile']->id;
                $store = array(
                    'year'        => date("Y"),
                    'isAccept'    => "A" ,
                    'grade'       => $col[$i][3] ,
                    'users_id'    => $userid ,
                );
                if(@ereg("ROVING",$col[$i][3]))
                        $store['jobs_id'] = 1;
                elseif(@ereg("TRAIN",$col[$i][3]))
                        $store['jobs_id'] = 2;
                elseif(@ereg("PSD",$col[$i][3]))
                        $store['jobs_id'] = 3;
                elseif(@ereg("PLATFORM",$col[$i][3]))
                        $store['jobs_id'] = 4;
                elseif(@ereg("LIFT",$col[$i][3]))
                        $store['jobs_id'] = 5;
                elseif(@ereg("RAMP",$col[$i][3]))
                        $store['jobs_id'] = 6;
                elseif(@ereg("FOOTBRIDGE",$col[$i][3]))
                        $store['jobs_id'] = 7;
                elseif(@ereg("ESCALATOR",$col[$i][3]))
                        $store['jobs_id'] = 11;
                else
                        $store['jobs_id'] = 4;

                if($this->employees->addNewEmployee($store))
                    echo "Add in Employee";
                else
                    echo "there is problem";
            }
            echo ($i % 15 == 0)? "<br />": " | ";
        }  
        /*echo "<table>";
        $i = 0;
        foreach($col as $row){
            echo "<tr>";
            foreach ($row as $value){
                if($i == 100)
                {
                    $i = 0;
                    sleep(10);
                }else
                    $i++;
                echo "<td>".$value."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";*/
        
    }
}

?>
