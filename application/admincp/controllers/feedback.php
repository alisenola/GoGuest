<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('feedbacks');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['feedbacks'] = $this->feedbacks->get_all_feedbacks($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['feedbacks']); die();
            $this->paging['base_url'] = site_url() . "feedback/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->feedbacks->get_all_feedbacks());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('feedback/index',$this->data);
	}
	
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('feedback', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('feedbackname','status'))) {
                redirect('feedback', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['feedbacks'] = $this->feedbacks->get_all_feedback($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "feedback/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->feedbacks->get_all_feedback());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('feedback/index', $this->data);
        }
        
      
        
        // Delete feedback
        function delete($catid='')
        {
            if(isset($_SERVER['HTTP_REFERER']))
            {
                $urlredirect = $_SERVER['HTTP_REFERER'];
            }
            else
            {
                $urlredirect = "feedback";
            } 
            if($catid !='')
            {
                $catid = base64_decode($catid);
                if($this->common->delete_data($tablename='feedback',$columname='feedbackid',$catid))
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

/* End of file feedback.php */
/* Location: ./application/controllers/feedback.php */