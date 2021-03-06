<?php

/**
 * this class for add,edit and remove from login table
 * 
 * @author Ahmad S AlGhamdi
 */
class Employee extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->lang->load('login', $this->core->site_language);
        $this->lang->load('global', $this->core->site_language);
        $this->load->model("groups");
        $this->load->model("jobs");
        $this->load->model("employees");
        $this->load->model("testaments");
        $this->load->model("attachments");
    }
    
    function index()
    {
        $this->profile(); 
    }
    
    function getCertificate() {
        if(!$this->users->isLogin())
                show_404 ();
        
        $user_id = $this->users->get_info_user("id");
        $userProfile = $this->users->getProfileUser($user_id);
        if(is_bool($userProfile))
            show_404 ();

        $this->load->library('pdf_certificate');
     
        // set document information
        $this->pdf_certificate->SetAuthor('Asfar Website');
        $this->pdf_certificate->SetTitle('Certificate');
        $this->pdf_certificate->SetSubject('Certificate');
        $this->pdf_certificate->SetKeywords('');
        
        $this->pdf_certificate->SetMargins(15, 27, 15);
        $this->pdf_certificate->SetHeaderMargin(0);
        $this->pdf_certificate->SetFooterMargin(0);

        //set auto page breaks
        $this->pdf_certificate->SetAutoPageBreak(TRUE, 25);
        
        $this->pdf_certificate->setFontSubsetting(false); 
        //set image scale factor
        $this->pdf_certificate->setImageScale(1.25);
        
        #---------------------- create file ----
        // set font
        $this->pdf_certificate->SetFont('times', 'b', 16);
        
        // add a page
        $this->pdf_certificate->AddPage();
        
        
       
        $this->pdf_certificate->setRTL(true);
        
        $this->pdf_certificate->SetY(99);
        $this->pdf_certificate->SetX(52);
        $this->pdf_certificate->Write(20, $userProfile->en_name);
        
        $this->pdf_certificate->SetFont('times', 'b', 16);
        $this->pdf_certificate->SetY(111);
        $this->pdf_certificate->SetX(100);
        $this->pdf_certificate->Write(20, $userProfile->name);
        $this->pdf_certificate->SetY(99);
        $this->pdf_certificate->SetX(195);
        $this->pdf_certificate->Write(20, $userProfile->idn);
        $this->pdf_certificate->SetY(84);
        $this->pdf_certificate->SetX(134);
        $this->pdf_certificate->Write(20, '1433'); 
        $this->pdf_certificate->SetY(124);
        $this->pdf_certificate->SetX(228);
        $this->pdf_certificate->Write(20, '1433'); 
        
        $this->pdf_certificate->setRTL(false);
        
        $this->pdf_certificate->Output(md5($user_id.rand(0, 1000000)).'.pdf', 'I');
        //$this->pdf_certificate->Output('./uploads/file.pdf', 'F');
    }
    
    function getPayment() {
        if(!$this->users->isLogin())
                show_404 ();
        
        $this->load->model("penalties");
        $userProfile = $this->users->get_info_user("all");
        $user_id = $this->users->get_info_user("id");
        /*$penaltiesData = $this->penalties->getPenaltys($user_id);
        $SALARY = $userProfile->{"mony"};
        $BOUNCE = $userProfile->{"date"};
        $penaltyTotal = $this->core->computePenaltyAmount($penaltiesData);
        $penalty = ($penaltyTotal != -1)? $penaltyTotal : $SALARY + $data['BOUNCE'];*/
        $data = array(
            'SALARY'    => '________________',//($SALARY + $BOUNCE)- $penalty,
            'NAME_AR'   => (empty($userProfile->ar_name))? "_________________" :$userProfile->ar_name,
            'NAME_EN'   => $userProfile->en_name,
            'IDN'       => $userProfile->idn,
            'MOBILE'    => $userProfile->mobile,
        );
        $this->load->library('pdf');

        // set document information
        $this->pdf->SetAuthor('Asfar Website');
        $this->pdf->SetTitle('Payment');
        $this->pdf->SetSubject('Payment');
        $this->pdf->SetKeywords('');
        
        $this->pdf->setRTL(true);
        #---------------------- create file ----
        // set font
        $this->pdf->SetFont('almohanad', '', 14);

        // add a page
        $this->pdf->AddPage();
        
        $data['LNG'] = "ar";
        $tbl = $this->load->view("employee/payment",$data,true);
        $this->pdf->SetY(45);
        // write html on PDF
        $this->pdf->writeHTML($tbl, true, false, false, false, '');
        
        $this->pdf->setRTL(false);
        // add second page
        $this->pdf->AddPage();
        $this->pdf->SetFont('times', '', 14);
        $this->pdf->SetY(45);
        $data['LNG'] = "en";
        $tbl = $this->load->view("employee/payment",$data,true);

        // write html on PDF
        $this->pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        $this->pdf->Output(md5($user_id).rand(0, 1000000).'.pdf', 'I');
    }
    
    function change_password(){
        $segments = $this->uri->segment_array();
        if(@$this->core->checkPermissions("employee","edit","all","all"))
            $user_id = (isset($segments[3]))? $segments[3] : $this->users->get_info_user("id");
        else if($this->users->isLogin())
            $user_id = $this->users->get_info_user("id");
        else 
            show_404 ();
        
        if($_POST){
            $oldPass = (@$this->core->checkPermissions("employee","edit","all","all") && ($this->input->post("oldpass",true) == ""))? "dfg" : $this->input->post("oldpass",true);
            $newPass = $this->input->post("newpass",true);
            $renewPass = $this->input->post("renewpass",true);
            if($newPass == $renewPass){
                if($this->users->change_password($user_id,$oldPass,$newPass,@$this->core->checkPermissions("employee","edit","all","all"))){
                    $data['STEP'] = "success";
                    $data['MSG'] = $this->lang->line('profile_edit_success');
                    $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$user_id, 'type' => 'equiv'));
                }else
                    $this->core->message("the old password is wrong",  base_url ()."employee/profile/".$user_id,"upload Problem",2); 
            }else
                $this->core->message("the new pass and retype new pass not same",  base_url ()."employee/profile/".$user_id,"upload Problem",2);
        }else
            show_404 ();
        
        $data['CONTENT'] = 'employee/profile';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }


    function uploadusers(){
        if(!$this->core->checkPermissions("employee","add","all","all"))
            show_404();
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3]: NULL;
        if($type != NULL){
            $string = read_file('./uploads/'.$_POST['filename']);
            $col = array();
            $line = explode("\n",$string);
            if(count($line) >= 100){
                foreach ($line as $value)
                    $col[] = explode (";", $value);
            }else
                $this->core->message("we can't read file maybe there is problem",  base_url ()."employee/uploadusers","upload Problem",2); 
            $headFile = $this->core->getHeadFile($col[0]);
            for($i=($type*100)+1;$i<=(($type*100)+100) && $i<count($col);$i++){
                if(!empty($col[$i][$headFile['id']])){
                    $user = $this->users->get_info_user("all",$col[$i][$headFile['id']]);
                    if(is_bool($user['profile'])){
                        $data = array(
                            'idn'           => isset($col[$i][$headFile['id']]) ? $col[$i][$headFile['id']] : NULL,
                            'password'      => $col[$i][$headFile['id']],
                            'en_name'       => isset($col[$i][$headFile['name']]) ? $col[$i][$headFile['name']] : NULL,
                            'mobile'        => isset($col[$i][$headFile['mobile']]) ? $col[$i][$headFile['mobile']] : NULL,
                            'is_old'        => $_POST['is_old']
                        );
                        if($this->users->register($data)){
                            $userid = $this->db->insert_id();
                            $store = array(
                                'year'        => ($_POST['is_old']=="n")? date("Y") : date("Y")-1,
                                'isAccept'    => "A" ,
                                'grade'       => $col[$i][$headFile['position']] ,
                                'users_id'    => $userid ,
                            );
                            if(@ereg("ROVING",  strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 1;
                            elseif(@ereg("TRAIN",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 2;
                            elseif(@ereg("PSD",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 3;
                            elseif(@ereg("PLATFORM",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 4;
                            elseif(@ereg("LIFT",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 5;
                            elseif(@ereg("RAMP",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 6;
                            elseif(@ereg("FOOTBRIDGE",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 7;
                            elseif(@ereg("WAITING",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 9;
                            elseif(@ereg("ESCALATOR",strtoupper($col[$i][$headFile['position']])))
                                    $store['jobs_id'] = 9;
                            else
                                    $store['jobs_id'] = NULL;

                            if($this->employees->addNewEmployee($store))
                                $result[$i]['doing'] = 'y';
                            else
                                $result[$i]['doing'] = 'n';
                            }else {
                                $result[$i]['doing'] = 'n'; 
                            }

                        }else {
                            $userid = $user['profile']->id;
                            $this->db->where("year",date("Y"));
                            $emp = $this->employees->getEmployees($userid);
                            if(is_bool($emp)){
                                $store = array(
                                    'year'        => date("Y") ,
                                    'isAccept'    => "A" ,
                                    'grade'       => $col[$i][$headFile['position']] ,
                                    'users_id'    => $userid ,
                                );
                                if(@ereg("ROVING",  strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 1;
                                elseif(@ereg("TRAIN",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 2;
                                elseif(@ereg("PSD",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 3;
                                elseif(@ereg("PLATFORM",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 4;
                                elseif(@ereg("LIFT",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 5;
                                elseif(@ereg("RAMP",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 6;
                                elseif(@ereg("FOOTBRIDGE",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 7;
                                elseif(@ereg("WAITING",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 9;
                                elseif(@ereg("ESCALATOR",strtoupper($col[$i][$headFile['position']])))
                                        $store['jobs_id'] = 9;
                                else
                                        $store['jobs_id'] = NULL;

                                if($this->employees->addNewEmployee($store))
                                    $result[$i]['doing'] = 'y';
                                else
                                    $result[$i]['doing'] = 'n';
                            }else
                                 $result[$i]['doing'] = 'n';
                        }

                }else
                    $result[$i]['doing'] = 'n';

                $result[$i]['name'] = isset($col[$i][$headFile['name']]) ? $col[$i][$headFile['name']] : NULL;
            }

            $data['STEP'] = "last";
            $data['NUMBER'] = floor(count($line)/100);
            $data['isOld'] = $_POST['is_old'];
            $data['FILENAME'] = $_POST['filename'];
            $data['CURRENT'] = $type;
            $data['users'] = $result;
            if($type == $data['NUMBER']){
                $data['button'] = "Finish";
                $data['START'] = "";
            }else
            {
                $data['button'] = "Next >";
                $data['START'] = $type+1;
            }
        }else{
           if($_FILES){
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '4096';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                if($this->upload->do_upload()){
                    $file = $this->upload->data();
                    $string = read_file('./uploads/'.$file['file_name']);
                    $col = array();
                    $line = explode("\n",$string);
                    if(count($line) >= 100){
                        foreach ($line as $value)
                            $col[] = explode (";", $value);
                    }else
                        $this->core->message("we can't read file maybe there is problem",  base_url ()."employee/uploadusers","upload Problem",2); 
                    $data['STEP'] = "second";
                    $data['NUMBER'] = floor(count($line)/100);
                    $data['isOld'] = $_POST['is_old'];
                    $data['FILENAME'] = $file['file_name'];
                }else {
                    $this->core->message("we can't upload file maybe there is problem(".$this->upload->display_errors().")",  base_url ()."employee/uploadusers","upload Problem",2); 
            }
           }else{
               $data['STEP'] = "upload";
           } 
        }
        
        $data['CONTENT'] = 'employee/upload_users';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }

    function uploadpictures(){
        if(!$this->core->checkPermissions("employee","edit","all","all"))
            show_404();
        
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3]: NULL;
        if($type != NULL){
            $zip = new ZipArchive;
            if ($zip->open('./uploads/'.$this->input->post("filename",true)) === TRUE) {
                if($zip->extractTo('./store/personal_img/')){
                    $zip->close();
                    $data['STEP'] = "success";
                    $data['MSG'] = "extract file done, we will transfer you automatically";
                }else {
                    $zip->close();
                    $this->core->message("Unable to extract the file.",  base_url ()."employee/uploadpictures","upload Problem",2); 
                }
            } else {
                $this->core->message("Unable to read the file.",  base_url ()."employee/uploadpictures","upload Problem",2); 
            }
            $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/uploadpictures', 'type' => 'equiv'));
        }else{
            if($_FILES){
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'zip';
                $config['max_size'] = '25600';
                $config['encrypt_name'] = true;
                
                $this->load->library('upload', $config);
                if($this->upload->do_upload()){
                    $data['STEP'] = "extract";
                    $file = $this->upload->data();
                    $data['FILENAME'] = $file['file_name'];
                }else {
                    $this->core->message("we can't upload file <br />".$this->upload->display_errors(),  base_url ()."employee/uploadpictures","upload Problem",2); 
                }
            }else{
                $data['STEP'] = "upload";
            }
                
        }
        $data['CONTENT'] = 'employee/upload_pictures';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }
    
    
    function uploadPicture(){
        /*if(!$this->core->checkPermissions("employee","edit","all","all"))
            show_404();*/
        
        $segments = $this->uri->segment_array();
        $idn = (isset($segments[3]))? $segments[3]: 0;
        if($idn == 0 || !$_FILES)
            show_404 ();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx';
        //$config['max_size'] = '2048';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        $uploadFile = array(
            'picture'       => "Personal Picture",
            'identity'      => "Identity Card"
            );
        foreach ( $_FILES as $key => $value){
            if (!$this->upload->do_upload($key))
            {
                $this->core->message("we can't upload file maybe there is problem",  base_url ()."employee/profile/".$idn,"upload Problem",2);
                break;
            }
            else
            {
                $uploadData = $this->upload->data();
                $store = array(
                    'name'      => $uploadFile[$key],
                    'file_url'  => base_url()."uploads/".$uploadData['file_name'],
                    'users_id'  => $this->input->post("ID",true)
                );
                $this->db->where('name',$uploadFile[$key]);
                $attachment = $this->attachments->getAttachments($store['users_id']);
                if(is_bool($attachment)){
                    $this->attachments->addNewAttachment($store);
                }else{
                    $attachId = $attachment[0]->id;
                    $this->attachments->updateAttachment($attachId,$store);
                }
            }
            $data['STEP'] = "success";
            $data['MSG'] = $this->lang->line('profile_edit_success');
            $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$idn, 'type' => 'equiv'));
        }
        /*$segments = $this->uri->segment_array();
        $idn = (isset($segments[3]))? $segments[3]: 0;
        if($_FILES){
            $folder = 'store/personal_img/';
            if(file_exists($folder.$idn.".jpg"))
                @unlink($folder.$idn.".jpg");
            elseif(file_exists($folder.$idn.".jpeg"))
                @unlink($folder.$idn.".jpeg");
            elseif(file_exists($folder.$idn.".png"))
                @unlink($folder.$idn.".png");
            elseif(file_exists($folder.$idn." .png"))
                @unlink($folder.$idn." .png");
            elseif(file_exists($folder.$idn." .jpg"))
                @unlink($folder.$idn." .jpg");
            elseif(file_exists($folder.$idn.".PNG"))
                @unlink($folder.$idn.".PNG");
            elseif(file_exists($folder.$idn.".JPG"))
                @unlink($folder.$idn.".JPG");
            $config['upload_path'] = './store/personal_img/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '10240';
            $config['file_name'] = $idn;
            $config['overwrite'] = true;
            
            $this->load->library('upload', $config);
            if($this->upload->do_upload()){
                $data['STEP'] = "success";
                $data['MSG'] = $this->lang->line('profile_edit_success');
                $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$idn, 'type' => 'equiv'));
            }else {
                $this->core->message("we can't upload file maybe there is problem",  base_url ()."employee/profile/".$idn,"upload Problem",2); 
            }
        }else
            show_404();*/
        $data['CONTENT'] = 'employee/profile';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }

    
    function contract()
    {
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            show_404 ();
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        
        if($type == NULL){
            if($_POST){
                $idns = explode("\n", $this->input->post("IDNS",true));
                $msg = array();
                $store['isContract'] = $this->input->post('contract',true);
                foreach ($idns as $key => $value){
                    if(is_numeric($value) && strlen($value) == 10)
                    {
                        $userinfo = $this->users->get_info_user("all",$value);
                        $emp = $this->employees->getEmployees($userinfo['profile']->id);
                        $msg[$key]['idn'] = $value;
                        $msg[$key]['message'] = ($this->employees->updateEmployee($emp[0]->id,$store)) ? "added successfully" : "there is problem";
                    }
                }
                $data['query'] = $msg;
                $data['STEP'] = "contract";
            }else{
            
                $data['STEP'] = "list";
                $per_url = 'employee/contract/';
                $total_results = $this->users->get_total_info_users();
                $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,1000);
                $this->db->where('isAccept','A');
                $data['users'] = $this->users->getAllInfoUser(1000,$start);
            }
            $data['CONTENT'] = 'employee/contract';
            $data['TITLE'] = "Profile";
            $this->core->load_template($data);
        }else if($type == "search"){
            if($userID != 0){
                $info = $this->users->get_info_user("all",$userID);
                $userInfo = $this->employees->getEmployees($info['profile']->id);
                if(is_bool($userInfo))
                    die("There is problem");
                else{
                    if($userInfo[0]->isContract == "Y"){
                        echo "he is Contract if you wnat go to profile <a href=\"".base_url()."employee/profile/".$userInfo[0]->users_id."\">Click here</a>";
                    }else
                        echo "he is not Contract <button onclick=\"Search('".base_url()."employee/contract/0/Contract/".$userID."','contract');\">Contract</button>";
                }
            }else
                echo "there is problem";
        }else if($type == "Contract"){
            if($userID != 0){
                $info = $this->users->get_info_user("all",$userID);
                $userInfo = $this->employees->getEmployees($info['profile']->id);
                if(is_bool($userInfo))
                    die("There is problem");
                else{
                    $store['isContract'] = "Y";
                    if($this->employees->updateEmployee($userInfo[0]->id,$store)){
                        echo "contract successfully";
                    }else
                        echo "contract wrong";
                }
            }else
                echo "there is problem";
        }
        
    }

    function contract_view()
    {
        if(!$this->users->isLogin())
            show_404 ();
        $userInfo = $this->users->get_info_user("all");
        $userProfile = $this->users->getProfileUser($userInfo->id);
        $this->db->where("year",  date("Y"));
        $EmployeeInfo = $this->employees->getEmployees($userInfo->id);
        $EmployeeId = $EmployeeInfo[0]->id;
        $data['CONTRACT']['2ND']['AR']['NAME'] = $userInfo->ar_name;
        $data['CONTRACT']['2ND']['EN']['NAME'] = $userInfo->en_name;
        $data['CONTRACT']['2ND']['ID'] = $userInfo->idn;
        $data['CONTRACT']['2ND']['MOBILE'] = $userInfo->mobile;
        $data['CONTRACT']['2ND']['SIGNATURE'] = $this->employees->signature($EmployeeId);
        $data['CONTRACT']['2ND']['JOB'] = $userProfile->name;
        $data['CONTRACT']['DAY'] = '';
        $data['CONTRACT']['DATE'] = '';


        $data['CONTENT'] = 'employee/contract_view';
        $this->load->view("employee/contract_view",$data);
        /*$data['TITLE'] = "Contract";
        $this->core->load_template($data); */       
    }
    
    function salary(){
        if(!$this->users->isLogin())
                show_404 ();
        
        $this->load->model("penalties");
        $segments = $this->uri->segment_array();
        $type = (isset($segments[3]))? $segments[3] : NULL;
        if(is_null($type)){
            $userInfo = $this->users->get_info_user('all');
            $userProfile = $this->users->getProfileUser($userInfo->id);
            $penaltiesData = $this->penalties->getPenaltys($userInfo->id);
            if($userInfo->mony == 1 || @$this->core->checkPermissions("employee","add","all","all")){
                $data['CANTAKESALARY'] = true;
                $data['SALARY'] = $userProfile->{"mony"};
                $data['BOUNCE'] = $userProfile->{"date"};
                $penaltyTotal = $this->core->computePenaltyAmount($penaltiesData);
                $data['PENALTY'] = ($penaltyTotal != -1)? $penaltyTotal : $data['SALARY']+$data['BOUNCE'];
                $data['penalties'] = $penaltiesData;
            }else{
                $data['MSG'] = "Sorry, now you can't see your salary";
                $data['CANTAKESALARY'] = false;
            }
            $data['ADMIN'] = false;
        }elseif($type == "add"){
            if($_POST){
                $idns = explode("\n", $this->input->post("IDNS",true));
                $msg = array();
                $store['mony'] = '1';
                foreach ($idns as $key => $value){
                    if(is_numeric($value) && strlen($value) == 10)
                    {
                        $userinfo = $this->users->get_info_user("all",$value);
                        $msg[$key]['idn'] = $value;
                        if(!is_bool($userinfo['profile']))
                            $msg[$key]['message'] = ($this->users->updateUser($userinfo['profile']->id,$store)) ? "added successfully" : "there is problem";
                        else
                            $msg[$key]['message'] = "this isn't not found in database";
                    }
                }
                $data['query'] = $msg;
                $data['STEP'] = "success";
            }else{
                $data['STEP'] = "add";
            }
            $data['ADMIN'] = true;
        }else
            show_404 ();
        
        $data['CONTENT'] = 'employee/salary';
        $data['TITLE'] = "Profile";
        $this->core->load_template($data);
    }


    function profile()
    {
        // Get User ID
        $segments = $this->uri->segment_array();
        if(@$this->core->checkPermissions("employee","edit","all","all"))
            $user_id = (isset($segments[3]))? $segments[3] : $this->users->get_info_user("id");
        else if($this->users->isLogin())
            $user_id = $this->users->get_info_user("id");
        else 
            show_404 ();
            
        $prev = (isset($segments[4]))? $segments[4] : NULL;
        
        $query1 = $this->users->get_info_user("all",$user_id);
        $userID = ($query1['profile'])? $query1['profile']->id :NULL;
        if(is_bool($query1['profile']))
        {    
            if(is_null($prev))
                show_404 ();
            else
                $this->core->message("This user Not Found In Database",  base_url ()."employee/users","user Not Found",1); 
        }
        else{
            $this->db->where("year",'2013');
            $emp = $this->employees->getEmployees($userID);
            if($emp[0]->jobs_id != NULL){
                $query = $this->users->getProfileUser($userID);
            }else {
                $query = $query1['profile'];
            }
            if($_POST){
                if(@$this->core->checkPermissions("employee","profile","all","all")){
                    $store = array(
                        'gender'        => $this->input->post("gender",true),
                        'email'         => $this->input->post("email",true),
                        'mobile'        => $this->input->post("mobile",true),
                        'nationality'   => $this->input->post("nationality",true),
                        'group_id'      => ($this->input->post("group",true)==0)?NULL :$this->input->post("group",true) ,
                        'idn'           => $this->input->post("national_id",true),
                        'ar_name'       => $this->input->post("arName",true),
                        'en_name'       => $this->input->post("enName",true),
                        'blood'         => $this->input->post("blood",true),
                        'bankName'      => $this->input->post("bankName",true),
                        'cardName'      => $this->input->post("cardName",true),
                        'iban'          => $this->input->post("iban",true)
                    );
                    if($this->users->updateUser($userID,$store)){
                        $this->db->where("year",date("Y"));
                        $emps = $this->employees->getEmployees($userID);
                        if(!is_bool($emps)){
                            $this->employees->updateEmployee($emps[0]->id,array(
                                "jobs_id"   => ($this->input->post("job",true)==0)? NULL : $this->input->post("job",true)
                                ));
                            $data['STEP'] = "success";
                            $data['MSG'] = $this->lang->line('profile_edit_success');
                            $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '1;url='.  base_url().'employee/profile/'.$user_id, 'type' => 'equiv'));
                        }else {
                            $data['STEP'] = "success";
                            $data['MSG'] = "This user isn't accepted this year";
                            $data['HEAD'] =  meta(array('name' => 'refresh', 'content' => '5;url='.  base_url().'employee/profile/'.$user_id, 'type' => 'equiv'));
                        }
                    }else{
                        $data['STEP'] = "view";
                        $data['ERROR'] = true;
                    }
                }else{
                    $store = array(
                        'gender'        => $this->input->post("gender",true),
                        'email'         => $this->input->post("email",true),
                        'mobile'        => $this->input->post("mobile",true),
                        'nationality'   => $this->input->post("nationality",true),
                        'ar_name'       => $this->input->post("arName",true),
                        'en_name'       => $this->input->post("enName",true),
                        'blood'         => $this->input->post("blood",true),
                        'bankName'      => $this->input->post("bankName",true),
                        'cardName'      => $this->input->post("cardName",true),
                        'iban'          => $this->input->post("iban",true)
                    );
                    if($this->users->updateUser($userID,$store)){
                        $data['STEP'] = "success";
                        $data['MSG'] = $this->lang->line('profile_edit_success');
                    }else{
                        $data['STEP'] = "view";
                        $data['ERROR'] = true;
                    }
                }
            }else{
                $data['profile'] = $query;
                $data['ID'] = $userID;
                if($this->core->checkPermissions("employee","profile","all","all")){
                    $data['group'] = $this->groups->getGroups("all");
                    $data['jobs'] = $this->jobs->getJobs("all");
                    $data['ADMIN'] = TRUE;
                }else {
                    $data['group'] = false;
                    $data['jobs'] = false;
                    $data['ADMIN'] = false;
                }
                $data['attachments'] = $this->attachments->getAttachments($userID);
                $data['STEP'] = "view";
                $data['ERROR'] = FALSE;
            }
            $data['CONTENT'] = 'employee/profile';
            $data['TITLE'] = "Profile";
            $this->core->load_template($data);
        }
    }
    
    function candidate(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getCandidate();
           $per_url = 'employee/candidate/';
           $total_results = count($query);
           $data['pagination'] = false;
           $data['users'] = $this->users->getCandidate();
           $data['CONTENT'] = 'employee/candidate';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployee($userID);
                if(is_bool($userInfo))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function accepted(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           if($_POST){
                $idns = explode("\n", $this->input->post("IDNS",true));
                $msg = array();
                if($this->input->post("jobs",true) != 0)
                        $store['jobs_id'] = $this->input->post("jobs",true);
                $store['isAccept'] = "A";
                $store['year'] = date("Y");
                $action = $this->input->post("action",true);
                if(@$_POST['add']){
                    if($action == 'change')
                        $this->employees->updateALLAcceptedEmployee(array('isAccept'=>'R'));
                    foreach ($idns as $key => $value){
                        if(is_numeric($value) && strlen($value) == 10)
                        {
                            $userinfo = $this->users->get_info_user("all",$value);
                            if(!is_bool($userinfo['profile'])){
                                $this->db->where("year",date("Y"));
                                $this->db->where("isAccept !=",'A');
                                $emp = $this->employees->getEmployees($userinfo['profile']->id);
                                $msg[$key]['idn'] = $value;
                                if(!is_bool($emp))
                                    $msg[$key]['message'] = ($this->employees->updateEmployee($emp[0]->id,$store)) ? "added successfully" : "there is problem";
                                else
                                    $msg[$key]['message'] = "This user is added before";
                            }else{
                                $msg[$key]['idn'] = $value;
                                $msg[$key]['message'] = "this user isn't add before in database";
                            }
                        }
                    }
                
                }elseif($_POST['check']){
                    foreach ($idns as $key => $value){
                        if(is_numeric($value) && strlen($value) == 10)
                        {
                            $info = $this->users->get_info_user("all",$value);
                            if(!is_bool($info['profile'])){
                                $this->db->where("year",date("Y"));
                                $userInfo = $this->employees->getEmployees($info['profile']->id);
                                if(!is_bool($userInfo)){
                                    if($userInfo[0]->isAccept == "A"){
                                        $msg[$key]['idn'] = $value;
                                        $msg[$key]['message'] = "he is accept" ;
                                    }else{
                                        $msg[$key]['idn'] = $value;
                                        $msg[$key]['message'] = "he isn't accept";    
                                    }
                                }else{
                                    $msg[$key]['idn'] = $value;
                                    $msg[$key]['message'] = "he isn't accept this year";
                                }
                            }else{
                                $msg[$key]['idn'] = $value;
                                $msg[$key]['message'] = "he isn't exist in database";
                            }
                        }
                    }
                }
                $error = $this->core->retypeContractNumber();
                $data['query'] = $msg;
                $data['STEP'] = "accept";
                $data['CONTENT'] = 'employee/accepted';
                $data['TITLE'] = "Accepted new Employees";
                $this->core->load_template($data);
           }else {
                $data['pagination'] = false;
                $data['users'] = $this->users->getAllInfoUser(10,0);
                $data['jobs'] = $this->jobs->getJobs("all");
                $data['CONTENT'] = 'employee/accepted';
                $data['TITLE'] = "List Of Accepted";
                $data['STEP'] = "list";
                $data['NAV'][base_url()."employee/accepted"] = "Accepted";
                $this->core->load_template($data);
           }
        }elseif($type == "candidate"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                $data['isAccept'] = "C";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Candidate successfully";
                else
                    echo "Candidate wrong";
                $error = $this->core->retypeContractNumber();
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $this->db->where("year","2013");
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }else if($type == "search"){
            if($userID != 0){
                $info = $this->users->get_info_user("all",$userID);
                $this->db->where("year",date("Y"));
                $userInfo = $this->employees->getEmployees($info['profile']->id);
                if(is_bool($userInfo))
                    die("There is problem");
                else{
                    if($userInfo[0]->isAccept == "A" ){
                        echo "he is accepted if you wnat go to profile <a href=\"".base_url()."employee/profile/".$userInfo[0]->users_id."\">Click here</a>";
                    }else
                        echo "he is not accepted";
                }
            }else
                echo "there is problem";
        }
    }
    
    function rejected(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getRejectedUsers();
           $per_url = 'employee/rejected/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,1000);
           $data['users'] = $this->users->getRejectedUsers(1000,$start);
           $data['CONTENT'] = 'employee/rejected';
           $data['TITLE'] = "List Of Rejected";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
                $error = $this->core->retypeContractNumber();
                print_r($error);
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function precaution(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL){
           $query = $this->users->getPrecautionUsers();
           $per_url = 'employee/precaution/';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$start,1000);
           $data['users'] = $this->users->getPrecautionUsers(1000,$start);;
           $data['CONTENT'] = 'employee/precaution';
           $data['TITLE'] = "List Of Precaution";
           $this->core->load_template($data);
        }elseif($type == "accept"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                $data['isAccept'] = "A";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Accepted successfully";
                else
                    echo "Accepted wrong";
            }else
                echo "there is problem";
        }elseif($type == "reject"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "R";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Rejected successfully";
                else
                    echo "Rejected wrong";
            }else
                echo "there is problem";
        }else if($type == "precau"){
            if($userID != 0){
                $userInfo = $this->employees->getEmployees($userID);
                if(is_bool($userInfo[0]))
                    die("There is problem");
                
                $data['isAccept'] = "P";
                if($this->employees->updateEmployee($userInfo[0]->id,$data))
                    echo "Precaution successfully";
                else
                    echo "Precaution wrong";
            }else
                echo "there is problem";
        }
    }
    
    function users(){
        if(!@$this->core->checkPermissions("employee","edit","all","all"))
            redirect ("");    
        $segments = $this->uri->segment_array();
        $start = (isset($segments[3]))? $segments[3] : 0;
        $type = (isset($segments[4]))? $segments[4] : NULL;
        $userID = (isset($segments[5]))? $segments[5] : 0;
        if($type == NULL && is_numeric($start)){
           $query = $this->users->getUsers(1000,$start);
           $per_url = 'employee/users/';
           $total_results = $this->users->get_total_users();
           $data['pagination'] = false;
           $data['users'] = $query;
           $data['STEP'] = "users";
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }else  if($type == "del" && is_numeric($start)){
            if($userID != 0){
                $userInfo = $this->users->get_info_user("all",$userID);
                if(is_bool($userInfo['profile']))
                    echo "The user is Not Found";
                
                if(@$this->users->deleteUser($userID))
                    echo "Delete successfully";
                else
                    echo "Delete Wrong!";
            }else
                echo "There is problem";
        }else if($start == "no_pic"){
           $type = ($type == NULL)? 0 : $type;
           $query = $this->users->getAllUserByPictures("no");
           if($type == 0)
               $this->core->createCSV($query);
           $per_url = 'employee/users/no_pic';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$type,1000);
           $data['users'] = $query;
           $data['START'] = $type;
           $data['STEP'] = "list_no";
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }else if($start == "pic"){
           $type = ($type == NULL)? 0 : $type;
           $query = $this->users->getAllUserByPictures("yes");
           if($type == 0)
               $this->core->createCSV($query,"pictures.csv",true);
           $per_url = 'employee/users/pic';
           $total_results = count($query);
           $data['pagination'] = $this->core->perpage($per_url,$total_results,$type,1000);
           $data['users'] = $query;
           $data['START'] = $type;
           $data['STEP'] = "list";
           $data['CONTENT'] = 'employee/users';
           $data['TITLE'] = "List Of Candidates";
           $this->core->load_template($data);
        }
    }


    public function signatures()
    {
        if(!(@$this->users->isLogin() && !@$this->users->checkIfUser()))
            redirect ("");
        
        $EmployeeId = is_numeric($this->uri->segment(3, 0)) ? $this->uri->segment(3, 0) : 0;
        if ($this->input->post('signature',TRUE))
        {
            $this->employees->signature($this->input->post('employee_id',TRUE),$this->input->post('signature',TRUE));
        }
        
        $data['EMPLOYEE_ID'] = $EmployeeId;
        $data['SIGNATURE'] = $this->employees->signature($EmployeeId);
        $employee = $this->employees->getEmployee($EmployeeId);
        $userInfo = $this->users->get_info_user("all",$employee->users_id);
        $data['EMPNAME'] = $userInfo['profile']->ar_name;
        $this->load->view('signature',$data);
    }
    
    public function cards()
    {
        if(!(@$this->users->isLogin() && !@$this->users->checkIfUser()))
            redirect ("");
        
        $action = (in_array($this->input->post('do',TRUE),array('main','print'))) ? $this->input->post('do',TRUE) : 'main';
        
        $data['TYPE'] = $action;
            
        if ($action == 'print'){
           $employee_id = ($this->input->post('employee_id',TRUE) != '') ? $this->input->post('employee_id',TRUE) : '0';
           $emp_data = $this->users->get_card_data($employee_id);
           if ($emp_data)
           {
               $this->db->where("id","12");
               $checkTestament = $this->testaments->getTestaments($emp_data->users_id);
               if(is_bool($checkTestament)){
                    $data['idn'] = $emp_data->idn;
                    $name = explode(" ", $emp_data->en_name);
                    $emp_name = (count($name) > 2)? $name[0].' '.$name[count($name)-1]:$emp_data->en_name;
                    $data['name'] = $emp_name;
                    $data['job'] = $emp_data->name;
                    die($this->load->view('employee/card',$data,TRUE));
               }else{
                   $data['MSG'] = 'print card before for this user';
                   $data['TYPE'] = 'main';
               }
           }else{
               $data['MSG'] = 'ID Error';
               $data['TYPE'] = 'main';
           }
        }
		$this->db->where("Testament_id","12");
                $this->core->createCSV($this->testaments->getUsersHasNotTestaments(),"users_has_not_card.csv");
                $this->db->where("Testament_id","12");
                $this->core->createCSV($this->testaments->getUsersHasTestaments(),"users_has_card.csv");
                $data['CONTENT'] = 'employee/card';
                $data['TITLE'] = "Cards";
		$this->core->load_template($data);
		
    }
    
}

?>
