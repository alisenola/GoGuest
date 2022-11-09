<?php 
    if(!isset($this->session->userdata['goguest_session']))
    {
        redirect('login','refresh');
    }
    $lanid = $this->session->userdata('go_lang');
    if($lanid == "" || $lanid == 'en')
    {
        $this->lang->load("goguest","english");
        $this->data['lang'] = $this->lang;
    }
    else if($lanid == 'sp')
    {
        $this->lang->load("goguest","spanish");
        $this->data['lang'] = $this->lang;
    }
   // print_r($lanid); die();
     //get permission id from session
//    $session_userid = $this->session->userdata['asia_session'];
//    if($session_userid[1] != "Superadmin")
//    {
//        // get group permission
//       $groupid = $session_userid[3];
//       $group_permission = $this->common->get_group_permission($groupid);
//       //echo "<pre>";print_r($group_permission);
//        if(count($group_permission)>0)
//        {
//            $permission_array = explode(",",$group_permission[0]['roleid']);
//            // get permission from url segment
//            $first_segment = $this->uri->segment(1);
//            $url_permission = $this->common->get_url_permission($first_segment);
//            //echo "<pre>";print_r($permission_array);print_r($url_permission);
//            //die();
//            if(count($url_permission)>0)
//            {
//              if(!in_array($url_permission[0]['id'],$permission_array))  
//              {
//                    $this->session->set_flashdata('error',"You dont't have permission to access this module.");
//                    redirect('dashboard','refresh');
//              }
//            }
//        }
//        else
//        {
//            $this->session->set_flashdata('error',"You dont't have permission to access any module.");
//            redirect('dashboard','refresh');
//        }
//        
//    }
    
    
    // form validation
    $this->load->library('form_validation');
  
    $title = 'Dashboard';
    if($this->uri->segment(1) != "")
    {
        $title = strtoupper($this->uri->segment(1))." Details";
    }
    if($this->uri->segment(2) != "")
    {
        $title = strtoupper($this->uri->segment(2))." ".strtoupper($this->uri->segment(1));
    }
    //Loadin Pagination Custome Config File
    $this->config->load('paging', TRUE);
    $this->paging = $this->config->item('paging');
    $this->data['title'] = 'Go-Guest'.' : '.$title;
    $this->data['section_title'] = 'Dashboard';
    //Load header and save in variable
    $this->data['header'] = $this->load->view('header',$this->data,true);
    //$this->data['left_menu'] = $this->load->view('left_menu',$this->data,true);
    $this->data['footer'] = $this->load->view('footer',$this->data,true);

?>