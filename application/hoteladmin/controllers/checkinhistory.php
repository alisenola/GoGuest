<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkinhistory extends CI_Controller {

	 public $paging;
     public $data;
	
	public function __construct()
  	{
            parent::__construct();
            include('include.php');
            $this->load->model('checkinhistorys');
            
        }
	 
	public function index()
	{
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['checkinhistorys'] = $this->checkinhistorys->get_all_checkinhistory($limit, $offset);
            //echo $this->db->last_query();
            //echo '<pre>'; print_r($this->data['checkinhistorys']); die();
            $this->paging['base_url'] = site_url() . "checkinhistory/index";
            $this->paging['uri_segment'] = 3;
            $this->paging['total_rows'] = count($this->checkinhistorys->get_all_checkinhistory());
            $this->pagination->initialize($this->paging);
            // call view
            $this->load->view('checkinhistory/index',$this->data);
	}
	
        //sorting record
        public function sort($sortby = '', $orderby = '') 
        {
            if ($sortby == '' || $orderby == '') {
                redirect('checkinhistory', 'refresh');
            }
            if ($sortby != '' && !in_array($sortby, array('checkinhistoryname','status'))) {
                redirect('checkinhistory', 'refresh');
            }
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $this->data['checkinhistorys'] = $this->checkinhistorys->get_all_checkinhistory($limit, $offset, $sortby, $orderby);

            $this->paging['base_url'] = site_url() . "checkinhistory/sort/".$this->uri->segment(3)."/".$this->uri->segment(4);
            $this->paging['uri_segment'] = 5;
            $this->paging['total_rows'] = count($this->checkinhistorys->get_all_checkinhistory());
            $this->pagination->initialize($this->paging);

            $this->data['keyword'] = '';
            //Loading View File
            $this->load->view('checkinhistory/index', $this->data);
        }
         function changestatus()
        {
            $checkinid = $this->input->post('requestid');
            $status = $this->input->post('status');
            if($status == "checkout")
            {
                $data = array(
                            'status'=>$status,
                            'checkoutdatetime'=>date("Y-m-d H:i:s"),
                            );
            }
          
            if($this->common->update_data($data,$tablename='user_checkin_checkout',$columnname='checkinid',$checkinid))
            {
                $this->session->set_flashdata('success','Request successfully updated');
                redirect('checkinhistory','refresh');
            }
            else
            {
                $this->session->set_flashdata('error','Request not updated. plese try again');
                redirect('checkinhistory','refresh');
            }
               
        }
      
        
   
       

           
	
}

/* End of file checkinhistory.php */
/* Location: ./application/controllers/checkinhistory.php */