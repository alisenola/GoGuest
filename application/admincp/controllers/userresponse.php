<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userresponse extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('userresponses');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['userresponses'] = $this->userresponses->get_all_userresponse($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['userresponses']); die();
            $this->paging['base_url'] = site_url() . "userresponse/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->userresponses->get_all_userresponse());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('userresponse/index',$this->data);
	}
	
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('userresponse', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('userresponsename','status'))) {
                redirect('userresponse', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['userresponses'] = $this->userresponses->get_all_userresponse($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "userresponse/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->userresponses->get_all_userresponse());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('userresponse/index', $this->data);
        }
        
      
        
        // Delete userresponse
        function delete($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "userresponse";
            } 
            if($catid !='')
            {
                $catid = base64_decode($catid);
                if($this->common->delete_data($tablename='userresponse',$columname='userresponseid',$catid))
                {
                    $this->session->set_flashdata('success', 'Feedback successfully deleted');
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

/* End of file userresponse.php */
/* Location: ./application/controllers/userresponse.php */