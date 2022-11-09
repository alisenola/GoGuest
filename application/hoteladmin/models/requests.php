<?php
Class Requests extends CI_Model
{
	// select all user
	function get_all_request($limit ='',$offset='',$sortby = 'r.requestid',$orderby = 'desc')
	{
		
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }                
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                $this->db->select('c.categoryname,u.userfirstname,ucc.roomno,r.requestdescription,r.status,r.requestid');
                $this->db->from('request as r');
                $this->db->join('users u', 'u.userid = r.userid');
                $this->db->join('user_checkin_checkout ucc', 'ucc.checkinid = r.roomid');
                $this->db->join('category as c','c.categoryuniqid = r.categoryuniqid','left');
                $this->db->where('c.language',$lanid);
                $this->db->where('r.hoteluniqid',$hoteluniqid);
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
	
        function get_all_new_request($last_id,$limit ='',$offset='',$sortby = 'r.requestid',$orderby = 'desc')
	{
		
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }                
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                 $this->db->select('c.categoryname,u.userfirstname,ucc.roomno,r.requestdescription,r.status,r.requestid');
                $this->db->from('request as r');
                $this->db->join('users u', 'u.userid = r.userid');
                $this->db->join('user_checkin_checkout ucc', 'ucc.checkinid = r.roomid');
                $this->db->join('category as c','c.categoryuniqid = r.categoryuniqid','left');
                $this->db->where('c.language',$lanid);
                $this->db->where('r.hoteluniqid',$hoteluniqid);
                $this->db->where('r.requestid >',$last_id);
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
	
	
}