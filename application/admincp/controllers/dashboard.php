<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	 public $paging;
         public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            
        }
	 
	public function index()
	{
            $this->data['feedbackcount'] = $this->common->get_count_of_table('feedback');
            $this->data['userscount'] = $this->common->get_count_of_table('users');
            $this->data['hotelcount'] = $this->common->get_count_of_hotel();
            $this->data['avgrequestcount'] = $this->common->get_avg_request();
//            echo '<pre>';
//            print_r($this->data['avgrequestcount']);
//            die();
            
           $this->load->view('dashboard/index',$this->data);
	}
	
	//  chage password
	public function changepassword()
	{
		$this->load->view('dashboard/changepassword',$this->data);
	}
	
	// chage password request
	public function passwordchangerequest()
	{
		$loginid = $this->session->userdata['media_session'][0];	
		$result = $this->common->get_user_passowrd($loginid);
		
		$match_pwd = $result[0]['password'];
	
		$oldpassword = $this->input->post('old_password');
		$new_password = $this->input->post('new_password');
		$conf_password = $this->input->post('conf_password');
			
		 if($match_pwd != $oldpassword)
		 {
			 $this->session->set_flashdata('error', 'old password does not match.');
			redirect('dashboard/changepassword', 'refresh');
		 }
		 else
		 {
			$this->form_validation->set_rules('new_password', 'Password', 'required|matches[conf_password]');
			$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>'); 
			// check for validation 
			if ($this->form_validation->run() == FALSE) 
			{ 
				$this->load->view('dashboard/changepassword'); 
			}
			else
			{
				if($this->common->update_passowrd($loginid,$new_password))
				{
					$this->session->set_flashdata('success', 'password successfully updated.');
					redirect('dashboard', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', 'something want wrong please try again.');
					redirect('dashboard/changepassword', 'refresh');
				}
			}
		 }
	}
        
        // Edit User Profile
        public function editprofile()
        {
            $userid = $this->session->userdata['media_session'][0];
            $this->data['profile'] = $this->common->get_profile__by_seesion_id($userid);
            $this->load->view('dashboard/editprofile',  $this->data);
        }
        
        // check username
	public function checkuserdetail()
	{
            if( $this->input->is_ajax_request())
            {
                $userid = $this->session->userdata['media_session'][0];
                $username = $this->input->post('username');
		$result = $this->common->check_user_name($username,$userid);
		echo $result;
            }
	}
	
	// check user email
	public function checkuseremail()
	{
            if( $this->input->is_ajax_request())
            {
                $userid = $this->session->userdata['media_session'][0];
		$useremail = $this->input->post('useremail');
		$result = $this->common->check_user_email($useremail,$userid);
		echo $result;
            }
	}
        public function updateprofile()
        {
            $userid = $this->session->userdata['media_session'][0];
            $username = $this->input->post('username');
            $useremail = $this->input->post('useremail');
            if($this->common->update_userprofile_by_seesionid($userid,$username,$useremail))
            {
               $this->session->set_flashdata("success","Profie Successfully Updated"); 
               redirect('dashboard/editprofile','refresh');
            }
            else
            {
               $this->session->set_flashdata('error',"Something went wrong for profile update please try again"); 
               redirect('dashboard/editprofile','refresh');
            }
             
        }
        // search data 
        function searchdata()
        {
            $searchdata = $this->input->post('searchdata');
            if($searchdata != "")
            {
               if($this->session->userdata['media_session']['1'] == "Super Admin")
               {
                  // $this->data['result1'] = $this->common->get_
               }
               else
               {
                   
               }
            }
            else
            {
                $this->session->set_flashdata("<b style='color:red'>Please Enter value</b>");
                redirect('dashboard','redirect');
            }
        }
        
        // Change Language Status 
        public function changelang()
        {
            $lang = $this->input->post('lang_sel');
            $this->session->set_userdata('go_lang', $lang);
            
            redirect($_SERVER['HTTP_REFERER'],'refresh');
        }




        // Logout 
	public function logout()
	{
		if( isset($this->session->userdata['goguest_session']) )
		{
                   
			$this->session->unset_userdata('goguest_session');
			//$this->session->sess_destroy();
		  	$this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged out.</b>');
			redirect('login', 'refresh');
		}
		else
		{
                  
			redirect('login', 'refresh');
		}
	}
           
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */