<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hoteladmin extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('hoteladmins');
            
        }
	 
	public function index()
	{
            $this->data['hoteluser']=$this->hoteladmins->get_all_hotel_user();
            $this->load->view('hoteladmin/index',$this->data);
	}
	
        // Add hotel
        function add()
        {
            $this->data['category'] = $this->hoteladmins->get_all_category();
            $this->load->view('hoteladmin/add',  $this->data);
        }
        // Edit hotel
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['category'] = $this->hoteladmins->get_all_category();
                $this->data['hoteluser'] = $this->common->select_database_id($tablename='hotel_user',$columnname='huid',$catid);
               // echo "<pre>";print_r($this->data['hotel']);
                if(count($this->data['hoteluser'])>0)
                {
                    $this->data['hotels'] = $this->hoteladmins->get_all_hotel();
                    $this->load->view('hoteladmin/edit',  $this->data);
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong.');
                    redirect('hotel','refresh');
                }
            }
            else
            {
                $this->session->set_flashdata('error','Something went wrong.');
                redirect('hotel','refresh');
                
            }
        }
        
        // insert and update hotel
        function update()
        {
          
            if($this->input->post('huid'))
            {   
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                $hotelemail = $this->input->post('hotelemail');
                $huid = $this->input->post('huid');
                $hotelpassword = $this->input->post('hotelpassword');
                $username = $this->input->post('username');
                $categoryuniqid = $this->input->post('categoryuniqid');
                $type = $this->input->post('type');
                if($type=='admin')
                {
                   $categoryuniqid =''; 
                }
                $data = array(
                    'hoteluniqid'=>$hoteluniqid,
                    'useremail'=>$hotelemail,
                    'userpassword'=>$hotelpassword,
                    'username'=>$username,
                    'type'=>$type,
                    'categoryuniqid'=>$categoryuniqid,
                    
                );
             
                if($this->common->update_data($data,$tablename='hotel_user',$columnname='huid',$huid))
                {
                    $this->session->set_flashdata('success','Hotel user successfully updated');
                    redirect('hoteladmin','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Hotel user not updated. plese try again');
                    redirect('hoteladmin/edit/'.base64_encode($hotelid),'refresh');
                }
                
            }
            else
            {
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                $hotelemail = $this->input->post('hotelemail');
                $hotelpassword = $this->input->post('hotelpassword');
                $username = $this->input->post('username');
                $categoryuniqid = $this->input->post('categoryuniqid');
                $type = $this->input->post('type');
                if($type=='admin')
                {
                   $categoryuniqid =''; 
                }
                $data = array(
                    'hoteluniqid'=>$hoteluniqid,
                    'useremail'=>$hotelemail,
                    'userpassword'=>$hotelpassword,
                    'username'=>$username,
                    'type'=>$type,
                    'categoryuniqid'=>$categoryuniqid,
                    
                );
                if($this->common->insert_data($data,$tablename='hotel_user'))
                { 
                    $this->session->set_flashdata('success','Hotel User successfully inserted.');
                    redirect('hoteladmin','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong to insert data');
                    redirect('hoteladmin/add','refresh');
                }
               
                
           }
        }
        
        // Delete hotel
        function delete($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "hotel";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
               if($this->common->delete_data($tablename='hotel_user',$columname='huid',$catid))
                {
                    $this->session->set_flashdata('success', 'Hotel user successfully deleted');
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
        
       

           
	
}

/* End of file hotel.php */
/* Location: ./application/controllers/hotel.php */