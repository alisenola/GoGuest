<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcategory extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('subcategories');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['subcategories'] = $this->subcategories->get_all_subcategory($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['subcategories']); die();
            $this->paging['base_url'] = site_url() . "category/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->subcategories->get_all_subcategory());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('subcategory/index',$this->data);
	}
	
        // Add category
        function add()
        {
            $this->data['category'] = $this->subcategories->get_all_category();
            $this->load->view('subcategory/add',  $this->data);
        }
        // Edit category
        function edit($catid='')
        {
            if($catid !='')
            {
                $catid = base64_decode($catid);
                $this->data['sub_category'] = $this->common->select_database_id($tablename='category',$columnname='categoryid',$catid);
               // echo "<pre>";print_r($this->data['category']);
                if(count($this->data['sub_category'])>0)
                {
                    $this->data['category'] = $this->subcategories->get_all_category();
                    $this->load->view('subcategory/edit',  $this->data);
                }
                else
                {
                    $this->session->set_flashdata('error','Something went wrong.');
                    redirect('subcategory','refresh');
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
                $categoryid = $this->input->post('categoryid');
                $catid = $this->input->post('cat_id');
                $sub_catname = $this->input->post('sub_catname');
               
                $data = array(
                    'categoryname'=>$categoryname,
                    'categoryparentid'=>$catid,
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
                $catid = $this->input->post('cat_id');
                $sub_catname = $this->input->post('sub_catname');
               
                $uniqid =  uniqid();
                
                $data = array(
                    'categoryname'=>$categoryname,
                    'categoryuniqid'=>$uniqid,
                    'language'=>'en',
                    'categoryparentid'=>$catid,
                );
                if($this->common->insert_data($data,$tablename='category'))
                { 
                     $data = array(
                    'categoryname'=>$categoryname,
                    'categoryuniqid'=>$uniqid,
                    'language'=>'sp',
                    'categoryparentid'=>$catid,
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

            $this->data['subcategories'] = $this->subcategories->get_all_category($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "category/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->subcategories->get_all_category());
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
                if($this->common->change_status($data,$tablename='subcategories',$columname='categoryid',$catid))
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
                if($this->common->change_status($data,$tablename='subcategories',$columname='categoryid',$catid))
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
                if($this->common->delete_data($tablename='subcategories',$columname='categoryid',$catid))
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
                $result = $this->common->check_unique_avalibility($tablename='subcategories',$columname1='categoryname',$catname,$columname2='categoryid',$catid);
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