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
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['hoteladmin'] = $this->hoteladmins->get_all_hotel_admin($limit, $offset);
            //echo $this->db->last_query();
           // echo '<pre>'; print_r($this->data['hoteladmin']); die();
            $this->paging['base_url'] = site_url() . "hotel/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->hoteladmins->get_all_hotel_admin());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('hoteladmin/index',$this->data);
	}
	
        // Add hotel
        function add()
        {
            $this->data['hotels'] = $this->hoteladmins->get_all_hotel();
            $this->load->view('hoteladmin/add',  $this->data);
        }
        // Edit hotel
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['hoteladmin'] = $this->common->select_database_id($tablename='hotel_admin',$columnname='hadminid',$catid);
               // echo "<pre>";print_r($this->data['hotel']);
                if(count($this->data['hoteladmin'])>0)
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
          // echo "<pre>";
          // print_r($_POST);
            if($this->input->post('hadminid'))
            {
                //echo "<pre>";
                // print_r($_POST);
                
                $hoteluniqid = $this->input->post('hoteluniqid');
                $hotelemail = $this->input->post('hotelemail');
                $hotelpassword = $this->input->post('hotelpassword');
                $hadminid = $this->input->post('hadminid');
           

                
                
                $data = array(
                    'hoteluniqid'=>$hoteluniqid,
                    'hotelemail'=>$hotelemail,
                    'hotelpassword'=>md5($hotelpassword),
                    
                );
             
                if($this->common->update_data($data,$tablename='hotel_admin',$columnname='hadminid',$hadminid))
                {
                    $this->session->set_flashdata('success','Hotel successfully updated');
                    redirect('hoteladmin','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Hotel not updated. plese try again');
                    redirect('hoteladmin/edit/'.base64_encode($hotelid),'refresh');
                }
                
            }
            else
            {
               // echo "<pre>";print_r($_FILES);die();
                $hoteluniqid = $this->input->post('hoteluniqid');
                $hotelemail = $this->input->post('hotelemail');
                $hotelpassword = $this->input->post('hotelpassword');
           

                
                
                $data = array(
                    'hoteluniqid'=>$hoteluniqid,
                    'hotelemail'=>$hotelemail,
                    'hotelpassword'=>md5($hotelpassword),
                    
                );
                if($this->common->insert_data($data,$tablename='hotel_admin'))
                { 
                    $this->session->set_flashdata('success','Hotel-admin successfully inserted.');
                    redirect('hoteladmin','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong to insert data');
                    redirect('hoteladmin/add','refresh');
                }
               
                
           }
        }
        
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('hotel', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('hotelname','hotelemail'))) {
                redirect('hotel', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['hoteladmin'] = $this->hoteladmins->get_all_hotel_admin($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "hoteladmin/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->hoteladmins->get_all_hotel_admin());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('hoteladmin/index', $this->data);
        }
        
        
        // Disable hotel
        function disable($catid='')
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
                $data = array('status'=>'Disable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='hotels',$columname='hotelid',$catid))
                { //echo $this->db->last_query();die();
                    $this->session->set_flashdata('success', 'Hotel successfully disable');
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
        
        // Enable hotel
        function enable($catid='')
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
                $data = array('status'=>'Enable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='hotels',$columname='hotelid',$catid))
                {
                    $this->session->set_flashdata('success', 'Hotel successfully enable');
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
               if($this->common->delete_data($tablename='hotel_admin',$columname='hadminid',$catid))
                {
                    $this->session->set_flashdata('success', 'Hotel successfully deleted');
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
        
        
        
        // check hotel name
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
                $result = $this->common->check_unique_avalibility($tablename='hotels',$columname1='hotelname',$catname,$columname2='hotelid',$catid);
                echo $result;
                    
            }
            else
            {
                echo "{error : Invalid request}";
            }
        }
       

           
	
}

/* End of file hotel.php */
/* Location: ./application/controllers/hotel.php */