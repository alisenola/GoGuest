<?php

Class Webservices extends CI_Model {

//login user
    function check_login($useremail, $userpassword) {
        $this->db->select("*");
        $this->db->where("useremail", "$useremail");
        $this->db->where("userpassword", "$userpassword");
        $this->db->from("users");
        $this->db->limit(1);

        $query = $this->db->get();
//echo $this->db->last_query();die();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// check email id
    function chkemail($id, $email) {
        if ($id != 0) {
            $option = array('userid !=' => $id, 'useremail' => $email);
        } else {
            $option = array('useremail' => $email);
        }
        $query = $this->db->get_where('users', $option);
        if ($query->num_rows() > 0) {
            return 'old';
        } else {
            return 'new';
        }
    }

//This function get all records from table by name
    function getallrecordbytablename($tablename, $data, $conditionarray = '', $limit = '', $offset = '', $sortby = '', $orderby = '') {

//$this->db->order_by($sortby, $orderby);
//Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

//Executing Query
        $this->db->select($data);
        $this->db->from($tablename);
        if ($conditionarray != '') {
            $this->db->where($conditionarray);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
//This function get all open record count
    
    function get_open_request_count($condition)
    {
        $this->db->select('COUNT(requestid) as count,maincategoryuniqid');
        $this->db->where($condition);
        $this->db->from('request');
        $this->db->group_by('maincategoryuniqid');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// insert database
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

// insert database return id
    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

// update database
    function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

// select data using colum id
    function select_database_id($tablename, $columnname, $columnid, $data = '*', $condition_array = array()) {
        $this->db->select($data);
        $this->db->where($columnname, $columnid);
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// delete data
    function delete_data($tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

// change status
    function change_status($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

//get all record 
    function get_all_record($tablename, $data = '*', $sortby = '', $orderby = '') {
        $this->db->select($data);
        $this->db->from($tablename);
//$this->db->where('status','Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
     function get_hotel_rank($hoteluniqid) {
        $query = $this->db->query("SELECT (sum(`propertyrate`)/count(`feedbackid`)+sum(`apprate`)/count(`feedbackid`)+sum(`triptype`)/count(`feedbackid`)+sum(`servicerate`)/count(`feedbackid`)+sum(`cleaninessrate`)/count(`feedbackid`)+sum(`valuerate`)/count(`feedbackid`)+sum(`locationrate`)/count(`feedbackid`)+sum(`sleeprate`)/count(`feedbackid`)+sum(`roomrate`)/count(`feedbackid`))/8 as rating FROM `gog_feedback` WHERE `hoteluniqid` ='$hoteluniqid' group by `hoteluniqid` ");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

// get feedbackdata by hoteluniqid

    function get_feedback_average($hoteluniqid) {
        $this->db->select_avg('propertyrate');
        $this->db->select_avg('apprate');
        $this->db->select_avg('servicerate');
        $this->db->select_avg('cleaninessrate');
        $this->db->select_avg('valuerate');
        $this->db->select_avg('locationrate');
        $this->db->select_avg('sleeprate');
        $this->db->select_avg('roomrate');
        $this->db->where('hoteluniqid', $hoteluniqid);
        $query = $this->db->get('feedback');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_manager_service_by_status($managerid, $status, $hoteluniqid) {
        $this->db->select('r.*');
        $this->db->from('hotel_user hu');
        $this->db->join('request r', 'hu.categoryuniqid = r.categoryuniqid');
        $this->db->where('hu.hoteluniqid', "$hoteluniqid");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

//login user
    function check_login_hotel_user($useremail, $userpassword) {
        $this->db->select("*");
        $this->db->where("useremail", "$useremail");
        $this->db->where("userpassword", "$userpassword");
        $this->db->from("hotel_user");
        $this->db->limit(1);

        $query = $this->db->get();
//echo $this->db->last_query();die();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_user_history($userid) {
        $this->db->select('r.*,c1.categoryuniqid as cid');
        $this->db->from('request r');
        $this->db->join('category c', 'r.categoryuniqid = c.categoryuniqid');
        $this->db->join('category c1', 'c.categoryparentid = c1.categoryid');
        $this->db->where('c1.language', "en");
        $this->db->order_by("c1.categoryid", "asc");
        $this->db->where('r.userid', "$userid");
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_manager_by_categoryuniqid($categoryuniqid, $hoteluniqid) {
        $query = $this->db->query("SELECT c2.categoryuniqid  from gog_category c1 LEFT OUTER JOIN gog_category c2 ON c1.categoryparentid = c2.categoryid where c1.categoryuniqid='$categoryuniqid' ");
        if (($query->num_rows()) > 0) {
            $data = $query->result_array();
            $categoryuniqid1 = $data[0]['categoryuniqid'];
            return $this->getallrecordbytablename('hotel_user', '*', array('categoryuniqid' => $categoryuniqid1, 'hoteluniqid' => $hoteluniqid));
        } else {
            return array();
        }
    }

    function get_graph($type, $hoteluniqid,$managerid) {
        if ($type == 'day') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open,gr.maincategoryuniqid as categoryuniqid, ROUND(gr1.cnt * 100/COUNT(requestid))  AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" AND requesttime < curdate() + 1) gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1) gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '" and  huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1) gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1) gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1) gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) and gr.hoteluniqid="' . $hoteluniqid . '" AND  gr.requesttime < curdate() + 1 GROUP BY gr.hoteluniqid');
        } else if ($type == 'week') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open,gr.maincategoryuniqid as categoryuniqid, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" AND requesttime < curdate() + 1) gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1) gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1) gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '"  and huid="' . $managerid . '"and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1) gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '"  and huid="' . $managerid . '"and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1) gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) and gr.hoteluniqid="' . $hoteluniqid . '"  AND gr.requesttime < curdate() + 1 GROUP BY gr.hoteluniqid');
        } else if ($type == 'month') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open,gr.maincategoryuniqid as categoryuniqid, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" AND  requesttime < curdate() + 1) gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1) gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1) gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1) gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1) gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) and gr.hoteluniqid="' . $hoteluniqid . '" AND gr.requesttime < curdate() + 1 GROUP BY gr.hoteluniqid');
        } else if ($type == 'year') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open,gr.maincategoryuniqid as categoryuniqid, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" AND  requesttime < curdate() + 1) gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1) gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1) gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1) gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1) gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) and gr.hoteluniqid="' . $hoteluniqid . '"  AND gr.requesttime < curdate() + 1 GROUP BY gr.hoteluniqid');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_basic_evolution($hoteluniqid,$managerid) {
        $year = date('Y');
        $query = $this->db->query('SELECT count(`requestid`) as count , MONTH(`requesttime`) AS month FROM gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and YEAR(`requesttime`)>="' . $year . '" group by month');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_call_controll($hoteluniqid,$type) {
        
        if ($type == 'day') {
       $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) group by `gr`.`maincategoryuniqid`');
        }
        else if ($type == 'week') {
        $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) group by `gr`.`maincategoryuniqid`');
        }
        else if ($type == 'month') {
        $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) group by `gr`.`maincategoryuniqid`');
        }
        else if ($type == 'year') {
        $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) group by `gr`.`maincategoryuniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_speedtime($hoteluniqid,$type,$managerid) {
        $year = date('Y');
        if ($type == 'day') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) GROUP BY `hoteluniqid`');
        }
        else if ($type == 'week') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK )  GROUP BY `hoteluniqid`');
        }
        else if ($type == 'month') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) GROUP BY `hoteluniqid`');
        }
        else if ($type == 'year') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )  GROUP BY `hoteluniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_servicetime($hoteluniqid,$type,$managerid) {
        $year = date('Y');
        if ($type == 'day') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and closedatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY )  GROUP BY `hoteluniqid`');
         }
        else if ($type == 'week') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF(`closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and closedatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK )  GROUP BY `hoteluniqid`');
         }
        else if ($type == 'month') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and closedatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH )  GROUP BY `hoteluniqid`');
         }
        else if ($type == 'year') {
        $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and closedatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )  GROUP BY `hoteluniqid`');
         }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_quelitypro($hoteluniqid,$type,$managerid) {
        $year = date('Y');
        if ($type == 'day') {
        $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and gr.huid="' . $managerid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) group by `gr`.`hoteluniqid`');
        }
        if ($type == 'week') {
        $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and gr.huid="' . $managerid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) group by `gr`.`hoteluniqid`');
        }
        if ($type == 'month') {
        $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and gr.huid="' . $managerid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) group by `gr`.`hoteluniqid`');
        }
        if ($type == 'year') {
        $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '" and huid="' . $managerid . '" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) ) gr1  where gr.hoteluniqid="' . $hoteluniqid . '" and gr.huid="' . $managerid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )group by `gr`.`hoteluniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    function get_request($condition)
    {
        $this->db->select('r.*,hu.username,u.userfirstname,u.userid,ucc.roomno');
        $this->db->from('request r');
        $this->db->join('hotel_user hu', 'hu.huid = r.huid');
        $this->db->join('users u', 'u.userid = r.userid');
        $this->db->join('user_checkin_checkout ucc', 'ucc.checkinid = r.roomid');
        $this->db->where($condition);
        $this->db->order_by('r.requestid','asc');
        //$this->db->limit(5);
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }

    }
    function getroomno($userid,$hoteluniqid)
    {
        $this->db->select('roomno');
        $this->db->where('hoteluniqid',$hoteluniqid);
        $this->db->where('userid',$userid);
        $this->db->limit(1);
        $this->db->order_by('checkinid','desc');
        $query = $this->db->get('user_checkin_checkout');
         if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }

    }
    function get_feedback_average_triptype($hoteluniqid) {
        $query = $this->db->query('SELECT ROUND(gf1.cnt * 100/gf.cnt) AS `business` , ROUND(gf2.cnt * 100/gf.cnt) AS `couples` , ROUND(gf3.cnt * 100/gf.cnt) AS `family` , ROUND(gf4.cnt * 100/gf.cnt) AS `friends` , ROUND(gf5.cnt * 100/gf.cnt) AS `solo` FROM gog_feedback gf_main
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . ' "  ) gf
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . ' " and triptype="business"   ) gf1
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . '" and triptype="couples" ) gf2
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . '" and triptype="family" ) gf3
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . '" and triptype="friends" ) gf4
                CROSS JOIN (SELECT count(feedbackid) AS cnt FROM gog_feedback where hoteluniqid="' . $hoteluniqid . '" and triptype="solo" ) gf5
                 where gf_main.hoteluniqid="' . $hoteluniqid . '" ');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

}
