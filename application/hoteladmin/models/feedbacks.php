<?php
Class Feedbacks extends CI_Model
{
	// select all user
	function get_all_feedbacks($limit ='',$offset='',$sortby = 'feedbackid',$orderby = 'desc')
	{
            $lanid = $this->session->userdata('go_lang');
            $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                if($lanid == "")
                {
                    $lanid = 'en';
                }
            $this->db->select('f.*,u.userfirstname,u.userid,ucc.roomno');
            $this->db->from('feedback as f');
            $this->db->join('users u', 'u.userid = f.userid');
            $this->db->join('user_checkin_checkout ucc', 'ucc.checkinid = f.roomid');
            $this->db->order_by($sortby,$orderby);
            $this->db->where('f.hoteluniqid',$hoteluniqid);
            //Setting Limit for Paging
            if( $limit != '' && $offset == 0)
            { 
                    $this->db->limit($limit); 
            }
            else if( $limit != '' && $offset != 0)
            {
                    $this->db->limit($limit, $offset);
            }

            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }		
	}
	
	
	
}