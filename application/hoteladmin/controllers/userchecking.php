<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userchecking extends CI_Controller {

    public $paging;
    public $data;

    public function __construct() {
        parent::__construct();
        if($this->uri->segment(2)!='newrequest')
        {
        include('include.php');
        }
        $this->load->model('usercheckings');
    }

    public function index() {
        $limit = $this->paging['per_page'];
        $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
        $this->data['chekingrequest'] = $this->usercheckings->get_all_checking_request();
        //echo $this->db->last_query();
        //  echo '<pre>'; print_r($this->data['chekingrequest']); die();
        $this->paging['base_url'] = site_url() . "userchecking/index";
        $this->paging['uri_segment'] = 3;
        $this->paging['total_rows'] = count($this->usercheckings->get_all_checking_request());
        $this->pagination->initialize($this->paging);
        // call view
        $this->load->view('userchecking/index', $this->data);
    }

    // Add category
    function changestatus() {
        $checkinid = $this->input->post('requestid');
        $status = $this->input->post('status');
        $roomno = $this->input->post('roomno');
        if ($status == "reject") {
            $data = array(
                'status' => $status,
                'rejectdatetime' => date("Y-m-d H:i:s"),
            );
        }
        if ($status == "checkout") {
            $data = array(
                'status' => $status,
                'checkoutdatetime' => date("Y-m-d H:i:s"),
            );
        }
        if ($status == "checkin") {
            $data = array(
                'status' => $status,
                'roomno' => $roomno,
                'checkindatetime' => date("Y-m-d H:i:s"),
            );
        }

        if ($this->common->update_data($data, $tablename = 'user_checkin_checkout', $columnname = 'checkinid', $checkinid)) {
            $this->session->set_flashdata('success', 'Request successfully updated');
            redirect('userchecking', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Request not updated. plese try again');
            redirect('userchecking', 'refresh');
        }
    }

    public function newrequest() {
        if($this->input->is_ajax_request())
            {
        $last_id = $this->input->post('last_id');
       //$last_id = 1;
        $checkindata = $this->usercheckings->get_all_new_checking_request($last_id);
        $data['html'] = '';
        $data['id'] = $last_id ;
        if (count($checkindata) > 0) {
            $data['id'] =$checkindata[0]['checkinid'];
            for ($i = 0; $i < count($checkindata); $i++) {
                $data['html'] .= "<tr>
            <td>" . $checkindata[$i]['userfirstname'] . " </td>
            <td> " . $checkindata[$i]['hotelname'] . " </td>
            <td> " . date('F m Y h:i:s', strtotime($checkindata[$i]['requestdatetime'])) . "</td>
            <td>
                <a class='btn btn-primary' onclick='changestatus(".$checkindata[$i]['checkinid'].")' id='cur_" . $checkindata[$i]['checkinid'] . "'>
                    " . $checkindata[$i]['status'] . "
                </a>
            </td>
        </tr>";
            }
            
        }
        echo json_encode($data);
        die();
            }
            else
            {
                redirect('userchecking');
            }
    }

}

/* End of file category.php */
/* Location: ./application/controllers/category.php */