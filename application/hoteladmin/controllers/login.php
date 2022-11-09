<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public $data;

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        
        //Loads Adminlogin Model file
        $this->load->model('logins');
        //Setting Page Title and Comman Variable
    }

    public function index($hotelid = '', $from = '') {
        if ($this->session->userdata('goguest_hotel_session')) {
            redirect('dashboard', 'refresh');
        }
        // LOAD LIBRARIES
        $this->load->library(array('encrypt', 'form_validation', 'session'));

        // SET VALIDATION RULES
        $this->form_validation->set_rules('user_email', 'useremail', 'required');
        $this->form_validation->set_rules('user_pass', 'password', 'required');
        if ($this->input->post('hiddenlogin') || $this->input->post('btnsubmit')) {

            if ($this->form_validation->run()) {
                $user_email = $this->input->post('user_email');
                $type = $this->input->post('type');
                $user_pass = md5($this->input->post('user_pass'));
                //query the database
                if ($type == 'hadmin') {
                    $result = $this->logins->logincheck($user_email, $user_pass);
                } else {
                    $result = $this->logins->userlogincheck($user_email, $this->input->post('user_pass'),$type);
                }
                if (count($result) > 0) {
                    if ($type == 'hadmin') {
                    $result1 = array();
                    $result1[] = $result[0]['hadminid'];                    
                    $result1[] = 'Admin';
                    $result1[] = $result[0]['hoteluniqid'];
                    $this->session->set_userdata('goguest_hotel_session', $result1);
                    $this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged in.</b>');
                    // user has been logged in                            
                    redirect('dashboard', 'refresh');
                    }
                    else
                    {
                        $result1 = array();
                    $result1[] = $result[0]['huid'];
                    $result1[] = $result[0]['useremail'];
                    $result1[] = $result[0]['hoteluniqid'];
                    $result1[] = $result[0]['type'];
                    $result1[] = $result[0]['categoryuniqid'];
                    $result1[] = $result[0]['username'];
                    $this->session->set_userdata('goguest_hotel_session', $result1);
                    $this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged in.</b>');
                    // user has been logged in                            
                    redirect('dashboard', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', '<b style="color:red">Invalid username or password</b>');
                    redirect('login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', '<b style="color:red">Invalid username or password</b>');
                redirect('login', 'refresh');
            }
        }

        //Loads the Admin Login view
        else {
            $this->load->view('login/index', $this->data);
        }
    }

    public function verify($hotelid = '', $from = '') {
        if ($hotelid != "" && $from != "" && $from == base64_encode("fromadmin")) {
            $result = $this->logins->get_verify_data($hotelid);
            //print_r($result);die;
            if (count($result) > 0) {
                $result1 = array();
                $result1[] = $result[0]['hadminid'];
                $result1[] = 'Admin';
                $result1[] = $result[0]['hoteluniqid'];
                $this->session->set_userdata('goguest_hotel_session', $result1);
                $this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged in.</b>');
                // user has been logged in

                redirect('dashboard', 'refresh');
            } else {
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        } else {
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */