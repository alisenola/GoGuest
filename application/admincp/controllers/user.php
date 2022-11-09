<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('users');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['users'] = $this->users->get_all_users($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['users']); die();
            $this->paging['base_url'] = site_url() . "user/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->users->get_all_users());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('user/index',$this->data);
	}
	
        // Add user
        function add()
        {
            $this->load->view('user/add',  $this->data);
        }
        // Edit user
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['user'] = $this->common->select_database_id($tablename='users',$columnname='userid',$catid);
               // echo "<pre>";print_r($this->data['user']);
                if(count($this->data['user'])>0)
                {
                    $this->load->view('user/edit',  $this->data);
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong.');
                    redirect('user','refresh');
                }
            }
            else
            {
                $this->session->set_flashdata('error','Something went wrong.');
                redirect('user','refresh');
                
            }
        }
        
        // insert and update user
        function update()
        {
            if($this->input->post('userid'))
            {
                $userid = $this->input->post('userid');
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $gender = $this->input->post('gender');
                $email = $this->input->post('email');
                $birthday = date("Y-m-d",strtotime($this->input->post('birthday')));
                $nationality = $this->input->post('nationality');
                $address = $this->input->post('address');
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                
                $data = array(
                    'userfirstname'=>$firstname,
                    'userlastname'=>$lastname,
                    'usergender'=> $gender,
                    'useremail'=>$email,
                    'userbirthday'=>$birthday,
                    'usernationality'=>$nationality,
                    'useraddress'=>$address,
                    'status' =>'Active',
                    'editdatetime'=>$date,
                    'editip'=>$ipaddress
                );
                
                if($this->common->update_data($data,$tablename='users',$columnname='userid',$userid))
                {
                    $this->session->set_flashdata('success','User successfully updated');
                    redirect('user','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','User not updated. plese try again');
                    redirect('user/edit/'.base64_encode($userid),'refresh');
                }
                
            }
            else
            {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $gender = $this->input->post('gender');
                $email = $this->input->post('email');
                $birthday = date("Y-m-d",strtotime($this->input->post('birthday')));
                $nationality = $this->input->post('nationality');
                $address = $this->input->post('address');
                $password = $this->input->post('password');
                
               
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                
                $data = array(
                    'userfirstname'=>$firstname,
                    'userlastname'=>$lastname,
                    'usergender'=> $gender,
                    'useremail'=>$email,
                    'userbirthday'=>$birthday,
                    'usernationality'=>$nationality,
                    'useraddress'=>$address,
                    'userpassword'=>$password,
                    'status' =>'Active',
                    'type'=>'app',
                    'insertdatetime'=>$date,
                    'insertip'=>$ipaddress
                );
                if($this->common->insert_data($data,$tablename='users'))
                { 
                    $this->session->set_flashdata('success','User successfully inserted.');
                    redirect('user','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong to insert user');
                    redirect('user/add','refresh');
                }
           }
        }
        
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('user', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('userfirstname','userlastname','usergender','useremail','status'))) {
                redirect('user', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['users'] = $this->users->get_all_users($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "user/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->users->get_all_users());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('user/index', $this->data);
        }
        
        
        // Disable user
        function disable($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "user";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('status'=>'Disable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='users',$columname='userid',$catid))
                { //echo $this->db->last_query();die();
                    $this->session->set_flashdata('success', 'Category successfully disable');
                    redirect($urlredirect, 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('error', 'something went wrong please try again');
                    redirect($urlredirect, 'refresh');
                }
            }
            else
            {
               $this->session->set_flashdata('error', 'something went wrong please try again');
               redirect($urlredirect, 'refresh'); 
            }
        }
        
        // Enable user
        function enable($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "user";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('status'=>'Enable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='users',$columname='userid',$catid))
                {
                    $this->session->set_flashdata('success', 'Category successfully enable');
                    redirect($urlredirect, 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('error', 'something went wrong please try again');
                    redirect($urlredirect, 'refresh');
                }
            }
            else
            {
               $this->session->set_flashdata('error', 'something went wrong please try again');
               redirect($urlredirect, 'refresh'); 
            }
        }
        
        // Delete user
        function delete($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "user";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('isdelete'=>'Yes','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->delete_data($tablename='users',$columname='userid',$catid))
                {
                    $this->session->set_flashdata('success', 'Category successfully deleted');
                    redirect($urlredirect, 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('error', 'something went wrong please try again');
                    redirect($urlredirect, 'refresh');
                }
            }
            else
            {
               $this->session->set_flashdata('error', 'something went wrong please try again');
               redirect($urlredirect, 'refresh'); 
            }
        }
        
        
        
        // check user name
        function checkavaliblity()
        {
            if($this->input->is_ajax_request())
            {
                $catid = '';
                if($this->input->post('catid'))
                {
                    $catid = $this->input->post('catid');
                }
                $catname = $this->input->post('catname');
                $result = $this->common->check_unique_avalibility($tablename='users',$columname1='username',$catname,$columname2='userid',$catid);
                echo $result;
                    
            }
            else
            {
                echo "{error : Invalid request}";
            }
        }
       

           
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */