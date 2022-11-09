<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public $paging;
    public $data;

    public function __construct() {
        parent::__construct();
        include('include.php');
        $this->load->model('dashboards');
    }

    public function index() {
        $type_data = array('day', 'week', 'month', 'year');
        $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];

        $status_array = array('all', 'open', 'hands on', 'close', 'standby');
        for ($i = 0; $i < count($status_array); $i++) {
            $status = $status_array[$i];
            if ($status == 'all') {
                $condition = array('r.hoteluniqid' => $hoteluniqid);
            } else {
                $condition = array('r.status' => "$status", 'r.hoteluniqid' => $hoteluniqid);
            }
            $this->data['request'][$status] = $this->dashboards->get_request($condition);
        }
        $hotel_rating = $this->dashboards->get_hotel_rank($hoteluniqid);
        if (count($hotel_rating) > 0) {
            $rating = $hotel_rating[0]['rating'];
        } else {
            $rating = 0;
        }
        $this->data['rating'] = $rating;
        $feedback_data = $this->dashboards->get_feedback_average($hoteluniqid);
        if (count($feedback_data) > 0) {
            $feedback = $feedback_data[0];
        } else {
            $feedback = array();
        }
        $this->data['feedback'] = $feedback;
        $triptype_data = $this->dashboards->get_feedback_average_triptype($hoteluniqid);
        if (count($triptype_data) > 0) {
            $triptype = $triptype_data[0];
        } else {
            $triptype = array();
        }
        $this->data['triptype'] = $triptype;
        for ($i = 0; $i < count($type_data); $i++) {
            $type = $type_data[$i];
            $data = $this->dashboards->get_graph($type, $hoteluniqid);
            $evolutiondata = $this->dashboards->get_basic_evolution($hoteluniqid);
            for ($m = 1; $m < 13; $m++) {
                $temp = $this->__in_multiarray($m, $evolutiondata, "month");
                if (!$temp) {
                    // do something if the given value does not exist in the array
                    $evolutiondata_new[$m] = 0;
                } else {
                    $evolutiondata_new[$m] = $temp;
                }
            }
            $callcontrolldata = $this->dashboards->get_call_controll($hoteluniqid, $type);
            $cat = array();
            for ($j = 0; $j < count($callcontrolldata); $j++) {
                if ($callcontrolldata[$j]['categoryuniqid'] == 'fb') {
                    $cdata[$j]['value'] = $callcontrolldata[$j]['percentage'];
                    $cdata[$j]['color'] = '#50a3cd';
                    $cdata[$j]['highlight'] = '#50a3cd';
                    $cdata[$j]['label'] = $callcontrolldata[$j]['quantity'];
                    $cat[] = $callcontrolldata[$j]['categoryuniqid'];
                }
                if ($callcontrolldata[$j]['categoryuniqid'] == 'hk') {
                    $cdata[$j]['value'] = $callcontrolldata[$j]['percentage'];
                    $cdata[$j]['color'] = '#90b622';
                    $cdata[$j]['highlight'] = '#90b622';
                    $cdata[$j]['label'] = $callcontrolldata[$j]['quantity'];
                    $cat[] = $callcontrolldata[$j]['categoryuniqid'];
                }

                if ($callcontrolldata[$j]['categoryuniqid'] == 'fd') {
                    $cdata[$j]['value'] = $callcontrolldata[$j]['percentage'];
                    $cdata[$j]['color'] = '#d3ccc6';
                    $cdata[$j]['highlight'] = '#d3ccc6';
                    $cdata[$j]['label'] = $callcontrolldata[$j]['quantity'];
                    $cat[] = $callcontrolldata[$j]['categoryuniqid'];
                }

                if ($callcontrolldata[$j]['categoryuniqid'] == 'se') {
                    $cdata[$j]['value'] = $callcontrolldata[$j]['percentage'];
                    $cdata[$j]['color'] = '#6d7a83';
                    $cdata[$j]['highlight'] = '#6d7a83';
                    $cdata[$j]['label'] = $callcontrolldata[$j]['quantity'];
                    $cat[] = $callcontrolldata[$j]['categoryuniqid'];
                }

                if ($callcontrolldata[$j]['categoryuniqid'] == 'en') {
                    $cdata[$j]['value'] = $callcontrolldata[$j]['percentage'];
                    $cdata[$j]['color'] = '#df8701';
                    $cdata[$j]['highlight'] = '#df8701';
                    $cdata[$j]['label'] = $callcontrolldata[$j]['quantity'];
                    $cat[] = $callcontrolldata[$j]['categoryuniqid'];
                }
            }
            $cat_array = array('fb', 'en', 'se', 'fd', 'hk');
            $diff_array = array_values(array_diff($cat_array, $cat));

            for ($k = 0; $k < count($diff_array); $k++, $j++) {
                if ($diff_array[$k] == 'fb') {
                    $cdata[$j]['value'] = 0;
                    $cdata[$j]['color'] = '#50a3cd';
                    $cdata[$j]['highlight'] = '#50a3cd';
                    $cdata[$j]['label'] = 0;
                }
                if ($diff_array[$k] == 'hk') {
                    $cdata[$j]['value'] = 0;
                    $cdata[$j]['color'] = '#90b622';
                    $cdata[$j]['highlight'] = '#90b622';
                    $cdata[$j]['label'] = 0;
                }

                if ($diff_array[$k] == 'fd') {
                    $cdata[$j]['value'] = 0;
                    $cdata[$j]['color'] = '#d3ccc6';
                    $cdata[$j]['highlight'] = '#d3ccc6';
                    $cdata[$j]['label'] = 0;
                }

                if ($diff_array[$k] == 'se') {
                    $cdata[$j]['value'] = 0;
                    $cdata[$j]['color'] = '#6d7a83';
                    $cdata[$j]['highlight'] = '#6d7a83';
                    $cdata[$j]['label'] = 0;
                }

                if ($diff_array[$k] == 'en') {
                    $cdata[$j]['value'] = 0;
                    $cdata[$j]['color'] = '#df8701';
                    $cdata[$j]['highlight'] = '#df8701';
                    $cdata[$j]['label'] = 0;
                }
            }
//            echo '<pre>';
//            print_r($cdata);
//         die();
            $kpidata_speed_time = $this->dashboards->get_kpi_speedtime($hoteluniqid, $type);
            $kpidata_service_time = $this->dashboards->get_kpi_servicetime($hoteluniqid, $type);
            $kpidata_quelity_pro = $this->dashboards->get_kpi_quelitypro($hoteluniqid, $type);

            if (count($kpidata_speed_time) > 0) {
                $kpidata_speed_time[0]['speed'] = gmdate("H:i:s", $kpidata_speed_time[0]['speed']);
            } else {
                $kpidata_speed_time[0]['speed'] = gmdate("H:i:s", 0);
            }
//echo '<pre>';
//            print_r($kpidata_service_time);
//            die();
            if (count($kpidata_service_time) > 0) {
                $kpidata_service_time[0]['service'] = gmdate("H:i:s", $kpidata_service_time[0]['service']);
            } else {
                $kpidata_service_time[0]['service'] = gmdate("H:i:s", 0);
            }
            if (count($kpidata_quelity_pro) > 0) {
                $kpidata_quelity_pro[0]['quelity'] = round($kpidata_quelity_pro[0]['quelity']) . '%';
            } else {
                $kpidata_quelity_pro[0]['quelity'] = '0%';
            }

            $kpidata = array_merge($kpidata_quelity_pro, $kpidata_service_time, $kpidata_speed_time);
            $this->data['graph'][$i]['category'] = $data;
            $this->data['basic_evelotion'] = $evolutiondata_new;
            $this->data['graph'][$i]['call_controll'] = $cdata;
            $this->data['graph'][$i]['kpis'] = $kpidata;
        }
//        echo'<pre>';
//        print_r($this->data);
//        die();
        $this->load->view('dashboard/index', $this->data);
    }

    //  chage password
    public function changepassword() {
        $this->load->view('dashboard/changepassword', $this->data);
    }

    // chage password request
    public function passwordchangerequest() {
        $loginid = $this->session->userdata['media_session'][0];
        $result = $this->common->get_user_passowrd($loginid);

        $match_pwd = $result[0]['password'];

        $oldpassword = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $conf_password = $this->input->post('conf_password');

        if ($match_pwd != $oldpassword) {
            $this->session->set_flashdata('error', 'old password does not match.');
            redirect('dashboard/changepassword', 'refresh');
        } else {
            $this->form_validation->set_rules('new_password', 'Password', 'required|matches[conf_password]');
            $this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // check for validation 
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('dashboard/changepassword');
            } else {
                if ($this->common->update_passowrd($loginid, $new_password)) {
                    $this->session->set_flashdata('success', 'password successfully updated.');
                    redirect('dashboard', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'something want wrong please try again.');
                    redirect('dashboard/changepassword', 'refresh');
                }
            }
        }
    }

    // Edit User Profile
    public function editprofile() {
        $userid = $this->session->userdata['media_session'][0];
        $this->data['profile'] = $this->common->get_profile__by_seesion_id($userid);
        $this->load->view('dashboard/editprofile', $this->data);
    }

    // check username
    public function checkuserdetail() {
        if ($this->input->is_ajax_request()) {
            $userid = $this->session->userdata['media_session'][0];
            $username = $this->input->post('username');
            $result = $this->common->check_user_name($username, $userid);
            echo $result;
        }
    }

    // check user email
    public function checkuseremail() {
        if ($this->input->is_ajax_request()) {
            $userid = $this->session->userdata['media_session'][0];
            $useremail = $this->input->post('useremail');
            $result = $this->common->check_user_email($useremail, $userid);
            echo $result;
        }
    }

    public function updateprofile() {
        $userid = $this->session->userdata['media_session'][0];
        $username = $this->input->post('username');
        $useremail = $this->input->post('useremail');
        if ($this->common->update_userprofile_by_seesionid($userid, $username, $useremail)) {
            $this->session->set_flashdata("success", "Profie Successfully Updated");
            redirect('dashboard/editprofile', 'refresh');
        } else {
            $this->session->set_flashdata('error', "Something went wrong for profile update please try again");
            redirect('dashboard/editprofile', 'refresh');
        }
    }

    // search data 
    function searchdata() {
        $searchdata = $this->input->post('searchdata');
        if ($searchdata != "") {
            if ($this->session->userdata['media_session']['1'] == "Super Admin") {
                // $this->data['result1'] = $this->common->get_
            } else {
                
            }
        } else {
            $this->session->set_flashdata("<b style='color:red'>Please Enter value</b>");
            redirect('dashboard', 'redirect');
        }
    }

    public function changelang() {
        $lang = $this->input->post('lang_sel');
        $this->session->set_userdata('go_lang', $lang);

        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    // Logout 
    public function logout() {
        if (isset($this->session->userdata['goguest_hotel_session'])) {

            $this->session->unset_userdata('goguest_hotel_session');
            //$this->session->sess_destroy();
            $this->session->set_flashdata('success', '<b style="color:green">You have been successfully logged out.</b>');
            redirect('login', 'refresh');
        } else {

            redirect('login', 'refresh');
        }
    }

    function __in_multiarray($elem, $array, $field) {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while ($bottom <= $top) {
            if ($array[$bottom][$field] == $elem)
                return $array[$bottom]['count'];
            else
            if (is_array($array[$bottom][$field]))
                if (in_multiarray($elem, ($array[$bottom][$field])))
                    return $array[$bottom]['count'];

            $bottom++;
        }
        return false;
    }

    public function request() {
        if ($this->input->is_ajax_request()) {
            $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
            $status_array = array('all', 'open', 'hands on', 'close', 'standby');
            for ($i = 0; $i < count($status_array); $i++) {
                $status = $status_array[$i];
                if ($status == 'all') {
                    $condition = array('r.hoteluniqid' => $hoteluniqid);
                } else {
                    $condition = array('r.status' => "$status", 'r.hoteluniqid' => $hoteluniqid);
                }
                //$this->data['request'][$status] = $this->dashboards->get_request($condition);
                $this->data['request'] = $this->dashboards->get_request($condition);
                if ($status == 'hands on') {
                    $status = 'handson';
                }
                if ($status == 'close') {
                    $status = 'conclued';
                }
                $var[$status] = $this->load->view('dashboard/request', $this->data, TRUE);
                //$var[$status]= $this->set_output($temp); 
            }
            echo json_encode($var);
        } else {
            redirect('dashboard');
        }
    }
    function status($status='',$requestid='')
    {
        $date = date('Y-m-d H:i:s');
        if($status!='' && $requestid!='')
        {
             if ($status == 'handson') {
            $requestdata = array(
                'status' => 'hands on',
                'handsondatetime' => $date,
            );
        } elseif ($status == 'close') {
            $requestdata = array(
                'status' => 'close',
                'closedatetime' => $date,
            );
        } elseif ($status == 'standby') {
            $requestdata = array(
                'status' => 'standby',
                'standbydatetime' => $date,
            );
        } 

        if ($this->common->update_data($requestdata, $tablename = 'request', $columnname = 'requestid', $requestid)) {
            $this->session->set_flashdata('success', 'Request successfully updated');
            redirect('dashboard', 'refresh');
        }
        }
        else
        {
            redirect('dashboard');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */