<?php
Class Hoteladmins extends CI_Model
{
    // select all user
	function get_all_hotel_user($limit ='',$offset='',$sortby = 'ha.huid',$orderby = 'desc')
	{
		
                $lanid = $this->session->userdata('go_lang');
                $hoteluniqid = $this->session->userdata['goguest_hotel_session'][2];
                if($lanid == "")
                {
                    $lanid = 'en';
                }
		$this->db->where('hoteluniqid',$hoteluniqid);
                $query = $this->db->get('hotel_user');
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
        function get_all_category()
	{
		
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->where('language',$lanid);
                $this->db->where('categoryparentid','0');
		$this->db->order_by('categoryid','asc');
		
                $query = $this->db->get('category');
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