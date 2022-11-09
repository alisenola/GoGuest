<?php

Class Dashboards extends CI_Model {
    function __construct()
    {
        
        parent::__construct();
        // Call the Model constructor
        $this->where = '';
        $this->where1 = '';
         if((isset($this->session->userdata['goguest_hotel_session'][3] ))&& (isset($this->session->userdata['goguest_hotel_session'][4] ))) {
             if($this->session->userdata['goguest_hotel_session'][4]!='')
             {
                 $this->managerid = $this->session->userdata['goguest_hotel_session'][0];
                 $this->where = 'and huid="' . $this->managerid . '" ';
                 $this->where1 = 'and gr.huid="' . $this->managerid . '" ';
             }
             
         }
    }
    function get_graph($type, $hoteluniqid) {
        
        if ($type == 'day') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open, ROUND(gr1.cnt * 100/COUNT(requestid))  AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) and hoteluniqid="' . $hoteluniqid . '"  AND requesttime < curdate() + 1 ' . $this->where . ') gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1 ' . $this->where . ') gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1 ' . $this->where . ') gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1 ' . $this->where . ') gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) AND requesttime < curdate() + 1 ' . $this->where . ') gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY )  AND  gr.requesttime < curdate() + 1 ' . $this->where1 . ' GROUP BY gr.hoteluniqid');
        } else if ($type == 'week') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) and hoteluniqid="' . $hoteluniqid . '"  AND requesttime < curdate() + 1 ' . $this->where . ') gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1 ' . $this->where . ') gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1 ' . $this->where . ') gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1 ' . $this->where . ') gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) AND requesttime < curdate() + 1 ' . $this->where . ') gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK )   AND gr.requesttime < curdate() + 1 ' . $this->where1 . ' GROUP BY gr.hoteluniqid');
        } else if ($type == 'month') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) and hoteluniqid="' . $hoteluniqid . '"  AND  requesttime < curdate() + 1 ' . $this->where . ') gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1 ' . $this->where . ') gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1 ' . $this->where . ') gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1 ' . $this->where . ') gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) AND requesttime < curdate() + 1 ' . $this->where . ') gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH )  AND gr.requesttime < curdate() + 1 ' . $this->where1 . ' GROUP BY gr.hoteluniqid');
        } else if ($type == 'year') {
            $query = $this->db->query('SELECT gr2.close,gr3.ongoing,gr4.standup,gr5.open, ROUND(gr1.cnt * 100/COUNT(requestid)) AS `percentage` FROM gog_request gr 
                CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )and hoteluniqid="' . $hoteluniqid . '"  AND  requesttime < curdate() + 1 ' . $this->where . ') gr1
                CROSS JOIN (SELECT COUNT(requestid) AS close FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1 ' . $this->where . ') gr2
                CROSS JOIN (SELECT COUNT(requestid) AS ongoing FROM gog_request where status="hands on" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1 ' . $this->where . ') gr3
                CROSS JOIN (SELECT COUNT(requestid) AS standup FROM gog_request where status="standby" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1 ' . $this->where . ') gr4
                CROSS JOIN (SELECT COUNT(requestid) AS open FROM gog_request where status="open" and hoteluniqid="' . $hoteluniqid . '"  and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) AND requesttime < curdate() + 1 ' . $this->where . ') gr5
                where gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR )   AND gr.requesttime < curdate() + 1 ' . $this->where1 . ' GROUP BY gr.hoteluniqid');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_basic_evolution($hoteluniqid) {
        $year = date('Y');
        $query = $this->db->query('SELECT count(`requestid`) as count , MONTH(`requesttime`) AS month FROM gog_request where hoteluniqid="' . $hoteluniqid . '"  and YEAR(`requesttime`)>="' . $year . '" ' . $this->where . 'group by month');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_call_controll($hoteluniqid, $type) {

        if ($type == 'day') {
            $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) group by `gr`.`maincategoryuniqid`');
        } else if ($type == 'week') {
            $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) group by `gr`.`maincategoryuniqid`');
        } else if ($type == 'month') {
            $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) group by `gr`.`maincategoryuniqid`');
        } else if ($type == 'year') {
            $query = $this->db->query('SELECT gr.maincategoryuniqid as categoryuniqid, COUNT( requestid ) AS quantity, ROUND(COUNT(requestid) / gr1.cnt * 100) AS `percentage` FROM gog_request gr 
CROSS JOIN (SELECT COUNT(requestid) AS cnt FROM gog_request where  hoteluniqid="' . $hoteluniqid . '" and requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '" and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) group by `gr`.`maincategoryuniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_speedtime($hoteluniqid, $type) {
        $year = date('Y');
        if ($type == 'day') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '"  and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ' . $this->where . ' GROUP BY `hoteluniqid`');
        } else if ($type == 'week') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '"  and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK)  ' . $this->where . ' GROUP BY `hoteluniqid`');
        } else if ($type == 'month') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '"  and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH) ' . $this->where . ' GROUP BY `hoteluniqid`');
        } else if ($type == 'year') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF( `handsondatetime`,`opendatetime`))) as speed from gog_request where hoteluniqid="' . $hoteluniqid . '"  and handsondatetime!="0000-00-00 00:00:00" and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR)  ' . $this->where . ' GROUP BY `hoteluniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_servicetime($hoteluniqid, $type) {
        $year = date('Y');
        if ($type == 'day') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF(`closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '"  and closedatetime!="0000-00-00 00:00:00"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ' . $this->where . '   GROUP BY `hoteluniqid`');
        } else if ($type == 'week') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF(`closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '"  and closedatetime!="0000-00-00 00:00:00"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK )' . $this->where . '   GROUP BY `hoteluniqid`');
        } else if ($type == 'month') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF(`closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '"  and closedatetime!="0000-00-00 00:00:00"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH )' . $this->where . '   GROUP BY `hoteluniqid`');
        } else if ($type == 'year') {
            $query = $this->db->query('select AVG(TIME_TO_SEC(TIMEDIFF(`closedatetime`,`handsondatetime`))) as service from gog_request where hoteluniqid="' . $hoteluniqid . '"  and closedatetime!="0000-00-00 00:00:00"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) ' . $this->where . '  GROUP BY `hoteluniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_kpi_quelitypro($hoteluniqid, $type) {
        $year = date('Y');        
        if ($type == 'day') {
            $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 DAY )' . $this->where . '  group by `gr`.`hoteluniqid`');
        }
        if ($type == 'week') {
            $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 WEEK )' . $this->where . '  group by `gr`.`hoteluniqid`');
        }
        if ($type == 'month') {
            $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH ) ) gr1 where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 MONTH)' . $this->where . '  group by `gr`.`hoteluniqid`');
        }
        if ($type == 'year') {
            $query = $this->db->query('SELECT ROUND(gr1.concluded * 100/COUNT(requestid)) AS `quelity` FROM gog_request gr                 
                CROSS JOIN (SELECT COUNT(requestid) AS concluded FROM gog_request where status="close" and hoteluniqid="' . $hoteluniqid . '"  and  requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR ) ) gr1  where gr.hoteluniqid="' . $hoteluniqid . '"  and  gr.requesttime > DATE_SUB(NOW(), INTERVAL 1 YEAR)' . $this->where . ' group by `gr`.`hoteluniqid`');
        }
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    function get_hotel_rank($hoteluniqid) {
        $query = $this->db->query("SELECT (sum(`propertyrate`)/count(`feedbackid`)+sum(`apprate`)/count(`feedbackid`)+sum(`triptype`)/count(`feedbackid`)+sum(`servicerate`)/count(`feedbackid`)+sum(`cleaninessrate`)/count(`feedbackid`)+sum(`valuerate`)/count(`feedbackid`)+sum(`locationrate`)/count(`feedbackid`)+sum(`sleeprate`)/count(`feedbackid`)+sum(`roomrate`)/count(`feedbackid`))/8 as rating FROM `gog_feedback` WHERE `hoteluniqid` ='$hoteluniqid' group by `hoteluniqid` ");
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

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
    
    function get_request($condition)
    {
        $this->db->select('r.*,hu.username,u.userfirstname,u.userid,ucc.roomno');
        $this->db->from('request r');
        $this->db->join('hotel_user hu', 'hu.huid = r.huid');
        $this->db->join('users u', 'u.userid = r.userid');
        $this->db->join('user_checkin_checkout ucc', 'ucc.checkinid = r.roomid');
        $this->db->where($condition);
        if($this->where!='')
        {
            $this->db->where('r.huid',"$this->managerid");
        }
        $this->db->order_by('r.requestid','asc');
        $this->db->limit(10);
        $query = $this->db->get();
        
        //echo $this->db->last_query();die();
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

}
