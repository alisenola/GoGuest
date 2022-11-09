<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public $data;
	
	public function __construct()
  	{
  	parent::__construct();
		// Your own constructor code
		if( $this->session->userdata('goguest_session') )
	  	{
		   redirect('hotel', 'refresh');
		}
			//Loads Adminlogin Model file
				$this->load->model('logins');
		//Setting Page Title and Comman Variable
		
		
	}
	
	public function index()
	{
		// LOAD LIBRARIES
    	$this->load->library(array('encrypt', 'form_validation', 'session'));
		
		// SET VALIDATION RULES
		$this->form_validation->set_rules('user_email','useremail', 'required');
		$this->form_validation->set_rules('user_pass', 'password', 'required');
		//$this->form_validation->set_error_delimiters('<em>','</em>');
		
		// has the form been submitted and with valid form info (not empty values)
		if( $this->input->post('hiddenlogin')|| $this->input->post('btnsubmit'))
		{
			
                    if($this->form_validation->run())
                    {
                        $user_email = $this->input->post('user_email');
                        $user_pass = md5($this->input->post('user_pass'));
                        //query the database
                        $result = $this->logins->logincheck($user_email, $user_pass);
                        //echo "<pre>";
                        //print_r($result);
                        //die();
                        if(count($result)>0)
                        {
                            $result1 = array();
                            $result1[] = $result[0]['iAdminId'];
                            $result1[] = $result[0]['vAdminEmail'];
                            $result1[] = $result[0]['vAdminName'];
                            /*echo "<pre>";
                            print_r($result1);
                            die();	*/	
                            $this->session->set_userdata('goguest_session', $result1);
                           // echo "<pre>";
                           // print_r($this->session->userdata['goguest_session']);
                           // die();
                            $this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged in.</b>');
                            // user has been logged in
                            
                            redirect('hotel', 'refresh');
                        }

                        else
                        {
                            $this->session->set_flashdata('error', '<b style="color:red">Invalid username or password</b>');
                            redirect('login', 'refresh');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('error', '<b style="color:red">Invalid username or password</b>');
                        redirect('login', 'refresh');
                    }
		}
		
		//Loads the Admin Login view
                else {
                    $this->load->view('login/index',$this->data);
                }
		
	}
		

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */