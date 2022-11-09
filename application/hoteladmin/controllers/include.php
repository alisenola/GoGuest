<?php 
    if(!isset($this->session->userdata['goguest_hotel_session']))
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