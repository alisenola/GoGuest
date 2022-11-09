<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('categories');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['categories'] = $this->categories->get_all_category($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['categories']); die();
            $this->paging['base_url'] = site_url() . "category/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->categories->get_all_category());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('category/index',$this->data);
	}
	
        // Add category
        function add()
        {
            $this->load->view('category/add',  $this->data);
        }
        // Edit category
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['category'] = $this->common->select_database_id($tablename='category',$columnname='categoryid',$catid);
               // echo "<pre>";print_r($this->data['category']);
                if(count($this->data['category'])>0)
                {
                    $this->load->view('category/edit',  $this->data);
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong.');
                    redirect('category','refresh');
                }
            }
            else
            {
                $this->session->set_flashdata('error','Something went wrong.');
                redirect('category','refresh');
                
            }
        }
        
        // insert and update category
        function update()
        {
          // echo "<pre>";
          // print_r($_POST);
            if($this->input->post('categoryid'))
            {
                //echo "<pre>";
                // print_r($_POST);
                //print_r($_FILES);die();
                $categoryname = $this->input->post('name');
                $categoryid = $this->input->post('categoryid');
               
              
                
                   $data = array(
                    'categoryname'=>$categoryname,
                    );
                if($this->common->update_data($data,$tablename='category',$columnname='categoryid',$categoryid))
                {
                    $this->session->set_flashdata('success','Category successfully updated');
                    redirect('category','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Category not updated. plese try again');
                    redirect('category/edit/'.base64_encode($categoryid),'refresh');
                }
                
            }
            else
            {
               // echo "<pre>";print_r($_FILES);die();
                $categoryname = $this->input->post('name');
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
                    
                    $config['upload_path'] = $this->config->item('category_main_image_path');
                    $config['allowed_types'] = $this->config->item('category_main_allowed_types');
                    $config['max_size'] = $this->config->item('category_main_max_size');
                    $config['remove_spaces'] = $this->config->item('category_main_remove_spaces');
                    $config['encrypt_name'] = $this->config->item('category_main_encrypt_name');

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
                        $config['new_image'] = $this->config->item('category_thumb_upload_path') . $imgdata['file_name'];
                        $config['create_thumb'] = $this->config->item('category_thumb_create_thumb');
                        $config['maintain_ratio'] = $this->config->item('category_thumb_maintain_ratio');
                        $config['thumb_marker'] = '';
                        $config['width'] = $this->config->item('category_thumb_width');
                        $config['height'] = $this->config->item('category_thumb_height');

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
                    'categoryname'=>$categoryname,
                    'categorydescription'=>$description,
                    'categoryuniqid'=> $uniqid,
                    'categoryimage'=>$image1,
                    'categorylatitude'=>$latitude,
                    'categorylongitude'=>$longitude,
                    'status'=>'Active',
                    'language'=>'en',
                    'insertdate'=>$date,
                    'insertip'=>$ipaddress
                );
                if($this->common->insert_data($data,$tablename='category'))
                { 
                     $data = array(
                    'categoryname'=>$categoryname,
                    'categorydescription'=>$description,
                    'categoryuniqid'=>$uniqid,
                    'categoryimage'=>$image1,
                    'categorylatitude'=>$latitude,
                    'categorylongitude'=>$longitude,
                    'status'=>'Active',
                    'language'=>'sp',
                    'insertdate'=>$date,
                    'insertip'=>$ipaddress
                    );
                     $this->common->insert_data($data,$tablename='category');
                    $this->session->set_flashdata('success','Category successfully inserted.');
                    redirect('category','refresh');
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong to insert category');
                    redirect('category/add','refresh');
                }
               
                
           }
        }
        
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('category', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('categoryname','status'))) {
                redirect('category', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['categories'] = $this->categories->get_all_category($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "category/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->categories->get_all_category());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('category/index', $this->data);
        }
        
        
        // Disable category
        function disable($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "category";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('status'=>'Disable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='categories',$columname='categoryid',$catid))
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
        
        // Enable category
        function enable($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "category";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('status'=>'Enable','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->change_status($data,$tablename='categories',$columname='categoryid',$catid))
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
        
        // Delete category
        function delete($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "category";
            } 
            if($catid !='')
            {
                $date = date("Y-m-d H:i:s");
                $ipaddress = $_SERVER['REMOTE_ADDR'];
                $catid = base64_decode($catid);
                $data = array('isdelete'=>'Yes','editdate'=>$date,'editip'=>$ipaddress);
                if($this->common->delete_data($tablename='categories',$columname='categoryid',$catid))
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
        
        
        
        // check category name
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
                $result = $this->common->check_unique_avalibility($tablename='categories',$columname1='categoryname',$catname,$columname2='categoryid',$catid);
                echo $result;
                    
            }
            else
            {
                echo "{error : Invalid request}";
            }
        }
       

           
	
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */