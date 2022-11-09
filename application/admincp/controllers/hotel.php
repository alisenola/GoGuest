<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('hotels');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['hotels'] = $this->hotels->get_all_hotel($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['hotels']); die();
            $this->paging['base_url'] = site_url() . "hotel/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->hotels->get_all_hotel());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('hotel/index',$this->data);
	}
	
        // Add hotel
        function add()
        {
            $this->load->view('hotel/add',  $this->data);
        }
        // Edit hotel
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['hotel'] = $this->common->select_database_id($tablename='hotel',$columnname='hotelid',$catid);
               // echo "<pre>";print_r($this->data['hotel']);
                if(count($this->data['hotel'])>0)
                {
                    $this->load->view('hotel/edit',  $this->data);
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
            if($this->input->post('hotelid'))
            {
                //echo "<pre>";
                // print_r($_POST);
                //print_r($_FILES);die();
                $hotelname = $this->input->post('name');
                $description = $this->input->post('description');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $hotelid = $this->input->post('hotelid');
                $image1= $this->input->post('oldimage1');
                
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $this->load->library('image_lib');
                $this->load->library('upload');
                ###------ IMAGE 1 UPLOAD START --- ###
                if ($_FILES['image1']['name'] != '')
                {
                   
                    $config['upload_path'] = $this->config->item('hotel_main_image_path');
                    $config['allowed_types'] = $this->config->item('hotel_main_allowed_types');
                    $config['max_size'] = $this->config->item('hotel_main_max_size');
                    $config['remove_spaces'] = $this->config->item('hotel_main_remove_spaces');
                    $config['encrypt_name'] = $this->config->item('hotel_main_encrypt_name');

                    // Initialize the new config
                    $this->upload->initialize($config);
                    //Uploading Image
                    $this->upload->do_upload('image1');
                    //Getting Uploaded Image File Data
                    $imgdata = $this->upload->data();
                    $imgerror = $this->upload->display_errors();
                    if ($imgerror == '') 
                    {
                        //Configuring Thumbnail 
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $config['upload_path'].$imgdata['file_name'];
                        $config['new_image'] = $this->config->item('hotel_thumb_upload_path') . $imgdata['file_name'];
                        $config['create_thumb'] = $this->config->item('hotel_thumb_create_thumb');
                        $config['maintain_ratio'] = $this->config->item('hotel_thumb_maintain_ratio');
                        $config['thumb_marker'] = '';
                        $config['width'] = $this->config->item('hotel_thumb_width');
                        $config['height'] = $this->config->item('hotel_thumb_height');

                        $this->image_lib->initialize($config);
                        //Creating Thumbnail
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        $thumberror = $this->image_lib->display_errors();

                    } 
                    else 
                    {
                        $this->thumberror = '';       
                    }
                    $upload_data['data'] =  $this->upload->data();
                    $image1 = $imgdata['file_name'];
                }
                ###------ IMAGE 1 UPLOAD END --- ###
              
                
                   $data = array(
                    'hotelname'=>$hotelname,
                    'hoteldescription'=>$description,
                    'hotelimage'=>$image1,
                    'hotellatitude'=>$latitude,
                    'hotellongitude'=>$longitude,
                    'status'=>'Active',
                    'editdate'=>$date,
                    'editip'=>$ipaddress
                    );
                if($this->common->update_data($data,$tablename='hotel',$columnname='hotelid',$hotelid))
                {
                    $this->session->set_flashdata('success','Hotel successfully updated');
                    redirect('hotel','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Hotel not updated. plese try again');
                    redirect('hotel/edit/'.base64_encode($hotelid),'refresh');
                }
                
            }
            else
            {
               // echo "<pre>";print_r($_FILES);die();
                $hotelname = $this->input->post('name');
                $description = $this->input->post('description');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
               
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
               
                $image1= '';
                 $this->load->library('image_lib');
                $this->load->library('upload');
                ###------ IMAGE 1 UPLOAD START --- ###
                if ($_FILES['image1']['name'] != '')
                {
                    
                    $config['upload_path'] = $this->config->item('hotel_main_image_path');
                    $config['allowed_types'] = $this->config->item('hotel_main_allowed_types');
                    $config['max_size'] = $this->config->item('hotel_main_max_size');
                    $config['remove_spaces'] = $this->config->item('hotel_main_remove_spaces');
                    $config['encrypt_name'] = $this->config->item('hotel_main_encrypt_name');

                    // Initialize the new config
                    $this->upload->initialize($config);
                    //Uploading Image
                    $this->upload->do_upload('image1');
                    //Getting Uploaded Image File Data
                    $imgdata = $this->upload->data();
                    $imgerror = $this->upload->display_errors();
                    if ($imgerror == '') 
                    {
                        //Configuring Thumbnail 
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $config['upload_path'].$imgdata['file_name'];
                        $config['new_image'] = $this->config->item('hotel_thumb_upload_path') . $imgdata['file_name'];
                        $config['create_thumb'] = $this->config->item('hotel_thumb_create_thumb');
                        $config['maintain_ratio'] = $this->config->item('hotel_thumb_maintain_ratio');
                        $config['thumb_marker'] = '';
                        $config['width'] = $this->config->item('hotel_thumb_width');
                        $config['height'] = $this->config->item('hotel_thumb_height');

                        $this->image_lib->initialize($config);
                        //Creating Thumbnail
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                        $thumberror = $this->image_lib->display_errors();

                    } 
                    else 
                    {
                        $this->thumberror = '';       
                    }
                    $upload_data['data'] =  $this->upload->data();
                    $image1 = $imgdata['file_name'];
                }
                ###------ IMAGE 1 UPLOAD END --- ###

                $uniqid =  uniqid();
                
                $data = array(
                    'hotelname'=>$hotelname,
                    'hoteldescription'=>$description,
                    'hoteluniqid'=> $uniqid,
                    'hotelimage'=>$image1,
                    'hotellatitude'=>$latitude,
                    'hotellongitude'=>$longitude,
                    'status'=>'Active',
                    'language'=>'en',
                    'insertdate'=>$date,
                    'insertip'=>$ipaddress
                );
                if($this->common->insert_data($data,$tablename='hotel'))
                { 
                     $data = array(
                    'hotelname'=>$hotelname,
                    'hoteldescription'=>$description,
                    'hoteluniqid'=>$uniqid,
                    'hotelimage'=>$image1,
                    'hotellatitude'=>$latitude,
                    'hotellongitude'=>$longitude,
                    'status'=>'Active',
                    'language'=>'sp',
                    'insertdate'=>$date,
                    'insertip'=>$ipaddress
                    );
                     $this->common->insert_data($data,$tablename='hotel');
                    $this->session->set_flashdata('success','Hotel successfully inserted.');
                    redirect('hotel','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong to insert hotel');
                    redirect('hotel/add','refresh');
                }
               
                
           }
        }
        
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('hotel', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('hotelname','status'))) {
                redirect('hotel', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['hotels'] = $this->hotels->get_all_hotel($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "hotel/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->hotels->get_all_hotel());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('hotel/index', $this->data);
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
                $data = array('status'=>'In-Active','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='hotel',$columname='hotelid',$catid))
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
                $data = array('status'=>'Active','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='hotel',$columname='hotelid',$catid))
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
                if($this->common->delete_data($tablename='hotel',$columname='hoteluniqid',$catid))
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