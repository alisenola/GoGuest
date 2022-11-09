<?php
Class Hoteladmins extends CI_Model
{
    // select all user
	function get_all_hotel_admin($limit ='',$offset='',$sortby = 'ha.hadminid',$orderby = 'desc')
	{
		switch($sortby)
		{
			case 'hotelemail' : $sortby = 'ha.hotelemail';break;
			case 'hotelname' : $sortby = 'h.hotelname';break;
			default             : $sortby = 'ha.hadminid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->from('hotel_admin as ha');
                $this->db->join('hotel as h','ha.hoteluniqid = h.hoteluniqid','left');
                $this->db->where('h.language',$lanid);
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
	// select all user
	function get_all_hotel()
	{
		
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->where('language',$lanid);
		$this->db->order_by('hotelname','asc');
		
                $query = $this->db->get('hotel');
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