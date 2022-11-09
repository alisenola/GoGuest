<?php
Class checkinhistorys extends CI_Model
{
	// select all user
	function get_all_checkinhistory($limit ='',$offset='',$sortby = 'checkinid',$orderby = 'desc')
	{
            $lanid = $this->session->userdata('go_lang');
            $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                if($lanid == "")
                {
                    $lanid = 'en';
                }
            $this->db->select('h.hotelname,u.userfirstname,c.*');
            $this->db->from('user_checkin_checkout as c');
            $this->db->join('hotel as h','h.hoteluniqid = c.hoteluniqid','left');
            $this->db->join('users as u','u.userid = c.userid','left');
            $this->db->order_by($sortby,$orderby);
            $this->db->where('h.language',$lanid);
            $this->db->where('c.status !=','request');
                $this->db->where('h.hoteluniqid',$hoteluniqid);
            
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