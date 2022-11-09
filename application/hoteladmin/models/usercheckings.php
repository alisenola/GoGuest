<?php
Class Usercheckings extends CI_Model
{
	// select all user
	function get_all_checking_request($limit ='',$offset='',$sortby = 'c.checkinid',$orderby = 'desc')
	{
		switch($sortby)
		{
		//	case 'categoryname' : $sortby = 'categoryname';break;
			default             : $sortby = 'c.checkinid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->select('c.*,u.userfirstname,h.hotelname');
                $this->db->from('user_checkin_checkout as c');
                $this->db->join('users as u','c.userid = u.userid');
                $this->db->join('hotel as h','h.hoteluniqid =c.hoteluniqid');
                $this->db->where('h.language',$lanid);
                $this->db->where('h.hoteluniqid',$hoteluniqid);
                $this->db->where('c.status','request');
                $this->db->order_by($sortby,$orderby);
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
        
        function get_all_new_checking_request($last_id,$sortby = 'c.checkinid',$orderby = 'desc')
	{
		switch($sortby)
		{
			default             : $sortby = 'c.checkinid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->select('c.*,u.userfirstname,h.hotelname');
                $this->db->from('user_checkin_checkout as c');
                $this->db->join('users as u','c.userid = u.userid');
                $this->db->join('hotel as h','h.hoteluniqid =c.hoteluniqid');
                $this->db->where('h.language',$lanid);
                $this->db->where('h.hoteluniqid',$hoteluniqid);
                $this->db->where('c.status','request');
                $this->db->where('c.checkinid >',$last_id);
                $this->db->order_by($sortby,$orderby);                
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