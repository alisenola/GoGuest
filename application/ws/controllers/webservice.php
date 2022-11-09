<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {

//define global variables
    function __construct() {
        parent::__construct();
//predefine variables
        $this->data['results'] = null;
        $this->data['message'] = 'code error';
        $this->data['status'] = 8;
    }

//cant access direct
    function index() {
        die();
    }

// Register User
    function register() {
        $firstname = $this->input->post('fname');
        $lastname = $this->input->post('lname');
        $gender = $this->input->post('gender');
        $dob = $this->input->post('dob');
        $nationality = $this->input->post('nationality');
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $type = $this->input->post('type');
        $date = date('Y-m-d H:i:s');
        $insertip = $_SERVER['REMOTE_ADDR'];

        if ($email == "" || $password == "") {
            $this->data['message'] = 'fail';
            $this->data['status'] = 2;
        } else {
            $result = $this->webservices->chkemail($id = '', $email);
            if ($result == "old") {
                $this->data['message'] = 'fail';
                $this->data['status'] = 6;
            } else {

                $userdata = array(
                    'userfirstname' => $firstname,
                    'userlastname' => $lastname,
                    'usergender' => $gender,
                    'userbirthday' => $dob,
                    'usernationality' => $nationality,
                    'useraddress' => $address,
                    'useremail' => $email,
                    'userpassword' => $password,
                    'status' => 'Active',
                    'type' => $type,
                    'insertdatetime' => $date,
                    'insertip' => $insertip
                );

// insert user's data
                $this->webservices->insert_data($userdata, 'users');
                $userid = $this->db->insert_id();
                if ($userid > 0) {
//$this->send_email('rushitbrahmbhatt@gmail.com', 'register', 'thank you for register');
                    $this->data['message'] = 'success';
                    $this->data['status'] = 0;
                } else {
                    $this->data['message'] = "fail";
                    $this->data['status'] = 4;
                }
            }
        }
//print output
        echo json_encode($this->data);
        die();
    }

// Edit  User
    function editprofile() {
        $userid = $this->input->post('userid');
        $firstname = $this->input->post('fname');
        $lastname = $this->input->post('lname');
        $gender = $this->input->post('gender');
        $dob = $this->input->post('dob');
        $nationality = $this->input->post('nationality');
        $password = $this->input->post('password');
        $address = $this->input->post('address');
        $date = date('Y-m-d H:i:s');
        $insertip = $_SERVER['REMOTE_ADDR'];
        $userdata = array(
            'userfirstname' => $firstname,
            'userlastname' => $lastname,
            'usergender' => $gender,
            'userbirthday' => $dob,
            'usernationality' => $nationality,
            'userpassword' => $password,
            'useraddress' => $address,
            'editdatetime' => $date,
            'editip' => $insertip
        );
// update user's data 
        if ($this->webservices->update_data($userdata, 'users', 'userid', $userid)) {
            $conditionarray = array('userid' => "$userid");
            $userdata = $this->webservices->getallrecordbytablename('users', '*', $conditionarray);
            $this->data['results'] = $userdata[0];
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }

//print output
        echo json_encode($this->data);
        die();
    }

//Login User
    function login() {

        if ($this->input->post('email') && $this->input->post('password')) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($email == '' || $password == '') {
                $this->data['message'] = 'fail';
                $this->data['status'] = 2;
            } else {
//Check User Is valid or not
                $uerinfo = $this->webservices->check_login($email, $password);
                if (count($uerinfo) > 0) {


                    if ($uerinfo[0]['status'] == "In-Active") {
                        $this->data['message'] = 'blocked.';
                        $this->data['status'] = 5;
                    } else {
                        $this->data['message'] = 'success';
                        $this->data['status'] = 0;
                        $this->data['results'] = $uerinfo[0];
                    }
                } else {
                    $this->data['message'] = 'fail';
                    $this->data['status'] = 1;
                }
            }
        } else {
            $this->data['message'] = 'fail';
            $this->data['status'] = 3;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//forgot password
    function forgotpassword() {
        $email = $this->input->post('email');
        $conditionarray = array('useremail' => "$email");
        $userdata = $this->webservices->getallrecordbytablename('users', 'userfirstname,userpassword', $conditionarray);
        if (count($userdata) > 0) {
            $this->load->library('email');
            $config['protocol'] = "mail";
            $this->email->from('no-replay@goguest.com', 'GoGuest');
            $this->email->to($email);
            $this->email->set_mailtype("html");
            $message = 'Dear <b>' . ucfirst($userdata[0]['userfirstname']) . '</b>';
            $message .= '<br/>';
            $message .= 'your password is  <b>' . $userdata[0]['userpassword'] . '</b>';
            $this->email->subject('Forgot Password');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->data['message'] = "success";
                $this->data['status'] = 0;
            } else {
                $this->data['message'] = "fail";
                $this->data['status'] = 4;
            }
        } else {
            $this->data['message'] = 'fail';
            $this->data['status'] = 1;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//Hotel list
    function list_all_hotels() {
        $language = $this->input->post('language');
        $condition = array("language" => "$language", 'status' => 'Active');
        $hotels_record = $this->webservices->getallrecordbytablename('hotel', '*', $condition);
        for ($i = 0; $i < count($hotels_record); $i++) {
            $hotels[$i] = $hotels_record[$i];
            $hotel_rating = $this->webservices->get_hotel_rank($hotels_record[$i]['hoteluniqid']);
            if (count($hotel_rating) > 0) {
                $rating = $hotel_rating[0]['rating'];
            } else {
                $rating = 0;
            }
            $hotels[$i]['rating'] = $rating;
        }
//print output
        if (count($hotels) > 0) {

            $this->data['results'] = $hotels;
            $this->data['main_image_path'] = base_url($this->config->item('hotel_main_image_path'));
            $this->data['thumb_image_path'] = base_url($this->config->item('hotel_thumb_image_path'));
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results'] = $hotels;
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//request to hotel
    function request_hotel() {
        $userid = $this->input->post('userid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $date = date('Y-m-d H:i:s');
        $hotelbookdata = array(
            'userid' => $userid,
            'hoteluniqid' => $hoteluniqid,
            'requestdatetime' => $date,
            'status' => 'request',
        );
// insert request data
        $this->webservices->insert_data($hotelbookdata, 'user_checkin_checkout');
        $requestid = $this->db->insert_id();
        if ($requestid > 0) {
            $this->data['result']['requestid'] = $requestid;
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//request to hotel
    function response_hotel() {
        $requestid = $this->input->post('requestid');
        $date = date('Y-m-d H:i:s');
        $response_data = $this->webservices->select_database_id('user_checkin_checkout', 'checkinid', $requestid, $data = '*');
        $this->data['result']['requestid'] = $response_data;
        $this->data['message'] = 'success';
        $this->data['status'] = 0;
//        $hotelbookdata = array(
//            'roomno' => '1',
//            'checkindatetime' => $date,
//            'status' => 'checkin',
//        );
// update request data
//        if ($this->webservices->update_data($hotelbookdata, 'user_checkin_checkout', 'checkinid', $requestid)) {
//            $response_data = $this->webservices->select_database_id('user_checkin_checkout', 'checkinid', $requestid, $data = '*');
//            $this->data['result']['requestid'] = $response_data;
//            $this->data['message'] = 'success';
//            $this->data['status'] = 0;
//        } else {
//            $this->data['message'] = "fail";
//            $this->data['status'] = 4;
//        }
//print output
        echo json_encode($this->data);
        die();
    }

// Add Feedback
    function feedback() {
        $userid = $this->input->post('userid');
        $roomid = $this->input->post('roomid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $propertyrate = $this->input->post('propertyrate');
        $propertyreview = $this->input->post('propertyreview');
        $apprate = $this->input->post('apprate');
        $appreview = $this->input->post('appreview');
        $triptype = $this->input->post('triptype');
        $travelmonth = date("Y-m-d", strtotime($this->input->post('travelmonth')));
        $servicerate = $this->input->post('servicerate');
        $cleaninessrate = $this->input->post('cleaninessrate');
        $valuerate = $this->input->post('valuerate');
        $locationrate = $this->input->post('locationrate');
        $sleeprate = $this->input->post('sleeprate');
        $roomrate = $this->input->post('roomrate');

        $feedbackdate = array(
            'userid' => $userid,
            'roomid' => $roomid,
            'hoteluniqid' => $hoteluniqid,
            'propertyrate' => $propertyrate,
            'propertyreview' => $propertyreview,
            'apprate' => $apprate,
            'appreview' => $appreview,
            'triptype' => $triptype,
            'travelmonth' => $travelmonth,
            'servicerate' => $servicerate,
            'cleaninessrate' => $cleaninessrate,
            'valuerate' => $valuerate,
            'locationrate' => $locationrate,
            'sleeprate' => $sleeprate,
            'roomrate' => $roomrate
        );
// insert feedback data
        $this->webservices->insert_data($feedbackdate, 'feedback');
        $feedbackid = $this->db->insert_id();
        if ($feedbackid > 0) {
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }
//print output
        echo json_encode($this->data);
        die();
    }

    function request() {

        $userid = $this->input->post('userid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $categoryuniqid = $this->input->post('categoryuniqid');
        $requestdescription = $this->input->post('requestdescription');
        $status = $this->input->post('status');
        $param = $this->input->post('param');
        $lang = $this->input->post('lang');
        $roomid = $this->input->post('roomid');
        $date = date('Y-m-d H:i:s');
        $insertip = $_SERVER['REMOTE_ADDR'];
        $condition = array('userid' => $userid, 'hoteluniqid' => $hoteluniqid, 'status' => 'checkin');
        $user_check_in = $this->webservices->getallrecordbytablename('user_checkin_checkout', '*', $condition);
        if (count($user_check_in) > 0) {
            $manager = $this->webservices->get_manager_by_categoryuniqid($categoryuniqid, $hoteluniqid);
            if (count($manager) > 0) {
                $huid = $manager[0]['huid'];
                $maincategoryuniqid = $manager[0]['categoryuniqid'];
                $devicetoken = $manager[0]['devicetoken'];
                if ($lang == '' || $lang == 'en') {
                    $msg = 'New service requested';
                } else {
                    $msg = 'Nuevo servicio solicitado';
                }

                $requestdate = array(
                    'userid' => $userid,
                    'hoteluniqid' => $hoteluniqid,
                    'roomid' => $roomid,
                    'categoryuniqid' => $categoryuniqid,
                    'maincategoryuniqid' => $maincategoryuniqid,
                    'huid' => $huid,
                    'requestdescription' => $requestdescription,
                    'opendatetime' => $date,
                    'status' => $status,
                    'requesttime' => $date,
                );
// insert request data
                $this->webservices->insert_data($requestdate, 'request');
                $requestid = $this->db->insert_id();
                if ($requestid > 0) {
                    if ($param != '') {
                        for ($p = 0; $p < count($param); $p++) {
                            $array = array(
                                'requestid' => $requestid,
                                'name' => $param[$p]['name'],
                                'value' => $param[$p]['value'],
                            );
                            $this->webservices->insert_data($array, 'request_category');
                        }
                    }
                    $gcm_status = $this->__send_gcm($msg, $devicetoken);
                    if ($gcm_status) {
                        $this->data['message'] = 'success';
                        $this->data['status'] = 0;
                    } else {
                        $this->data['message'] = "push error";
                        $this->data['status'] = 10;
                    }
                } else {
                    $this->data['message'] = "fail";
                    $this->data['status'] = 4;
                }
            } else {
                $this->data['message'] = "fail";
                $this->data['status'] = 4;
            }
        } else {
            $this->data['message'] = "checkout";
            $this->data['status'] = 9;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//Get User Request by category uniq id
    function get_request_by_cat() {
        $userid = $this->input->post('userid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $categoryuniqid = $this->input->post('categoryuniqid');
        if ($userid != '') {
            $condition = array('categoryuniqid' => "$categoryuniqid", 'userid' => "$userid", 'hoteluniqid' => "$hoteluniqid");
        } else {
            $condition = array('maincategoryuniqid' => "$categoryuniqid", 'hoteluniqid' => "$hoteluniqid");
        }
        $request = $this->webservices->getallrecordbytablename('request', '*', $condition);
//check result count
        if (count($request) > 0) {
            for ($i = 0; $i < count($request); $i++) {
                $this->data['results'][$i] = $request[$i];
                $requestid = $request[$i]['requestid'];
                $condition = array('requestid' => "$requestid");
                $params = $this->webservices->getallrecordbytablename('request_category', '*', $condition);
                $this->data['results'][$i]['param'] = $params;
            }
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results'] = array();
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//Get User's history
    function user_request_history() {
        $userid = $this->input->post('userid');
//        $condition = array('userid' => "$userid");
//        $request = $this->webservices->getallrecordbytablename('request', '*', $condition);
        $request = $this->webservices->get_user_history($userid);
//print_r($request);die();
//check result count
        if (count($request) > 0) {
            for ($i = 0; $i < count($request); $i++) {
                $categoryuniqid = $request[$i]['categoryuniqid'];
                $maincategoryuniqid = $request[$i]['cid'];
//$this->data['results'][$maincategoryuniqid][$categoryuniqid][$i]['data'] = $request[$i];
                $requestid = $request[$i]['requestid'];
                $condition = array('requestid' => "$requestid");
                $params = $this->webservices->getallrecordbytablename('request_category', '*', $condition);
                $data['param'] = $params;
                $result = array_merge($request[$i], $data);
                $this->data['results'][$maincategoryuniqid][$categoryuniqid][] = $result;
//$this->data['results'][$maincategoryuniqid][$categoryuniqid][$i]['param'] = $params;
            }
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results'] = array();
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }
//print output
        echo json_encode($this->data);
        die();
    }

//Get Service by status
    function get_services_by_status() {
        $managerid = $this->input->post('managerid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $status = $this->input->post('status');
        if ($managerid == '') {

            if ($status == 'all') {
                $condition = array('r.hoteluniqid' => $hoteluniqid);
            } else {
                $condition = array('r.status' => "$status", 'r.hoteluniqid' => $hoteluniqid);
            }
            $request = $this->webservices->get_request($condition);
            if (count($request) > 0) {
                for ($i = 0; $i < count($request); $i++) {
                    $this->data['results'][$i] = $request[$i];
                    $requestid = $request[$i]['requestid'];
                    $condition = array('requestid' => "$requestid");
                    $params = $this->webservices->getallrecordbytablename('request_category', '*', $condition);
                    $this->data['results'][$i]['param'] = $params;
                }
                $this->data['message'] = 'success';
                $this->data['status'] = 0;
            }
//check result count
            else {
                $this->data['results'] = array();
                $this->data['message'] = 'null';
                $this->data['status'] = 7;
            }
        } else {
            if ($status == 'all') {
                $condition = array('r.hoteluniqid' => $hoteluniqid, 'r.huid' => "$managerid");
            } else {
                $condition = array('r.status' => "$status", 'r.hoteluniqid' => $hoteluniqid, 'r.huid' => "$managerid");
            }
            //$request = $this->webservices->getallrecordbytablename('request', '*', $condition);
//$request = $this->webservices->get_manager_service_by_status($managerid, $status, $hoteluniqid);
            $request = $this->webservices->get_request($condition);
            if (count($request) > 0) {
                for ($i = 0; $i < count($request); $i++) {
                    $this->data['results'][$i] = $request[$i];
                    $requestid = $request[$i]['requestid'];
                    $condition = array('requestid' => "$requestid");
                    $params = $this->webservices->getallrecordbytablename('request_category', '*', $condition);
                    $this->data['results'][$i]['param'] = $params;
                }
                $this->data['message'] = 'success';
                $this->data['status'] = 0;
            } else {
                $this->data['results'] = array();
                $this->data['message'] = 'null';
                $this->data['status'] = 7;
            }
        }
//print output
        echo json_encode($this->data);
        die();
    }

//Get all open service
    function get_all_open_services() {
        $hoteluniqid = $this->input->post('hoteluniqid');
        $status = 'open';
        $condition = array('status' => "$status", 'hoteluniqid' => $hoteluniqid);
        $request = $this->webservices->get_open_request_count($condition);
//check result count
        if (count($request) > 0) {
            $this->data['results'] = $request;
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results'] = array();
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }

//print output
        echo json_encode($this->data);
        die();
    }

    //Get all open service
    function get_all_close_services() {
        $hoteluniqid = $this->input->post('hoteluniqid');
        $status = 'close';
        $condition = array('status' => "$status", 'hoteluniqid' => $hoteluniqid);
        $request = $this->webservices->get_open_request_count($condition);
//check result count
        if (count($request) > 0) {
            $this->data['results'] = $request;
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results'] = array();
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }

//print output
        echo json_encode($this->data);
        die();
    }

//Get feedback by hoteluniqid
    function get_feedback_by_hoteluniqid() {
        $hoteluniqid = $this->input->post('hoteluniqid');
        $feedbackdata = $this->webservices->get_feedback_average($hoteluniqid);
        $triptype_data = $this->webservices->get_feedback_average_triptype($hoteluniqid);

        if (count($feedbackdata) > 0) {
            $this->data['results']['feedback'] = $feedbackdata[0];
            $this->data['results']['sortoftrip'] = $triptype_data[0];
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['results']['feedback'] = new stdClass();
            $this->data['results']['sortoftrip'] = new stdClass();
            $this->data['message'] = 'null';
            $this->data['status'] = 7;
        }
//print output
        echo json_encode($this->data);
        die();
    }

// change request status
    function change_request_status() {
        $requestid = $this->input->post('requestid');
        $status = $this->input->post('status');
        $date = date('Y-m-d H:i:s');
        if ($status == 'open') {
            $requestdata = array(
                'status' => $status,
                'requesttime' => $date,
                'opendatetime' => $date,
            );
        } elseif ($status == 'close') {
            $requestdata = array(
                'status' => $status,
                'requetclosetime' => $date,
                'closedatetime' => $date,
            );
        } elseif ($status == 'cancel') {
            $requestdata = array(
                'status' => $status,
                'canceldatetime' => $date,
            );
        } elseif ($status == 'stand-up') {
            $requestdata = array(
                'status' => $status,
                'standupdatetime' => $date,
            );
        } elseif ($status == 'ongoing') {
            $requestdata = array(
                'status' => $status,
                'ongoingdatetime' => $date,
            );
        } elseif ($status == 'hands on') {
            $requestdata = array(
                'status' => $status,
                'handsondatetime' => $date,
            );
        } elseif ($status == 'concluded') {
            $requestdata = array(
                'status' => $status,
                'concludeddatetime' => $date,
            );
        } elseif ($status == 'standby') {
            $requestdata = array(
                'status' => $status,
                'standbydatetime' => $date,
            );
        } else {
            $requestdata = array(
                'status' => $status,
            );
        }

// update request status
        if ($this->webservices->update_data($requestdata, 'request', 'requestid', $requestid)) {
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }

//print output
        echo json_encode($this->data);
        die();
    }

//Login hotel user
    function hotel_login() {

        if ($this->input->post('email') && $this->input->post('password')) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $devicetoken = $this->input->post('devicetoken');

            if ($email == '' || $password == '') {
                $this->data['message'] = 'fail';
                $this->data['status'] = 2;
            } else {
//Check User Is valid or not
                $uerinfo = $this->webservices->check_login_hotel_user($email, $password);
                if (count($uerinfo) > 0) {
                    $tokendata = array(
                        'devicetoken' => $devicetoken,
                    );
                    if ($this->webservices->update_data($tokendata, 'hotel_user', 'huid', $uerinfo[0]['huid'])) {
                        $this->data['message'] = 'success';
                        $this->data['status'] = 0;
                        $this->data['results'] = $uerinfo[0];
                    } else {
                        $this->data['message'] = "fail";
                        $this->data['status'] = 4;
                    }
                } else {
                    $this->data['message'] = 'fail';
                    $this->data['status'] = 1;
                }
            }
        } else {
            $this->data['message'] = 'fail';
            $this->data['status'] = 3;
        }
//print output
        echo json_encode($this->data);
        die();
    }

    function logout() {
        $managerid = $this->input->post('managerid');
        $managerdata = array(
            'devicetoken' => '',
        );
        if ($this->webservices->update_data($managerdata, 'hotel_user', 'huid', $managerid)) {
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }
//print output
        echo json_encode($this->data);
        die();
    }

    function userlogout() {
        $roomid = $this->input->post('roomid');

        $condition = array('status' => 'checkout');

        if ($this->webservices->update_data($condition, 'user_checkin_checkout', 'checkinid', $roomid)) {
            $this->data['message'] = 'success';
            $this->data['status'] = 0;
        } else {
            $this->data['message'] = "fail";
            $this->data['status'] = 4;
        }
//print output
        echo json_encode($this->data);
        die();
    }
    
    function usercheckinstatus()
    {
        $userid = $this->input->post('userid');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $condition = array('userid' => $userid, 'hoteluniqid' => $hoteluniqid);
        $user_check_in = $this->webservices->getallrecordbytablename('user_checkin_checkout', '*', $condition);
        if (count($user_check_in) > 0) {
            $this->data['results'] = $user_check_in[0];
             $this->data['message'] = "checkin";
            $this->data['status'] = 0;
        }
        else {
            $this->data['results'] ='';
            $this->data['message'] = "fail";
            $this->data['status'] = 9;
        }
        
//print output
        echo json_encode($this->data);
        die();
    }

//forgot password
    function forgothotelpassword() {
        $email = $this->input->post('email');
        $conditionarray = array('useremail' => "$email");
        $userdata = $this->webservices->getallrecordbytablename('hotel_user', 'username,userpassword', $conditionarray);
        if (count($userdata) > 0) {
            $this->load->library('email');
            $config['protocol'] = "mail";
            $this->email->from('no-replay@goguest.com', 'GoGuest');
            $this->email->to($email);
            $this->email->set_mailtype("html");
            $message = 'Dear <b>' . ucfirst($userdata[0]['username']) . '</b>';
            $message .= '<br/>';
            $message .= 'your password is  <b>' . $userdata[0]['userpassword'] . '</b>';
            $this->email->subject('Forgot Password');
            $this->email->message($message);
            if ($this->email->send()) {
                $this->data['message'] = "success";
                $this->data['status'] = 0;
            } else {
                $this->data['message'] = "fail";
                $this->data['status'] = 4;
            }
        } else {
            $this->data['message'] = 'fail';
            $this->data['status'] = 1;
        }
//print output
        echo json_encode($this->data);
        die();
    }

    function graph() {
        $type = $this->input->post('type');
        $hoteluniqid = $this->input->post('hoteluniqid');
        $managerid = $this->input->post('managerid');
        if ($type != '') {
            $data = $this->webservices->get_graph($type, $hoteluniqid, $managerid);
            $evolutiondata = $this->webservices->get_basic_evolution($hoteluniqid, $managerid);
            $callcontrolldata = $this->webservices->get_call_controll($hoteluniqid, $type);
            $kpidata_speed_time = $this->webservices->get_kpi_speedtime($hoteluniqid, $type, $managerid);
            $kpidata_service_time = $this->webservices->get_kpi_servicetime($hoteluniqid, $type, $managerid);
            $kpidata_quelity_pro = $this->webservices->get_kpi_quelitypro($hoteluniqid, $type, $managerid);

            if (count($kpidata_speed_time) > 0) {
                $kpidata_speed_time[0]['speed'] = gmdate("H:i:s", $kpidata_speed_time[0]['speed']);
            } else {
                $kpidata_speed_time[0]['speed'] = gmdate("H:i:s", 0);
            }

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
            if (count($data) > 0) {
                $this->data['results']['category'] = $data;
                $this->data['results']['basic_evelotion'] = $evolutiondata;
                $this->data['results']['call_controll'] = $callcontrolldata;
                $this->data['results']['kpis'] = $kpidata;
                $this->data['message'] = 'success';
                $this->data['status'] = 0;
            } else {
                $this->data['results'] = '';
                $this->data['message'] = 'null';
                $this->data['status'] = 7;
            }
        } else {
            $this->data['results'] = '';
            $this->data['message'] = 'fail';
            $this->data['status'] = 1;
        }

//print output
        echo json_encode($this->data);
        die();
    }

    public function __send_gcm($msg, $devicetoken) {
        $this->load->library('gcm');
        $this->gcm->setMessage($msg);

// add recepient or few
        $this->gcm->addRecepient($devicetoken);
        $this->gcm->setTtl(500);
// then send
        if ($this->gcm->send())
            return true;
        else
            return false;
        die();
    }

}
