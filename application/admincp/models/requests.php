<?php
Class Requests extends CI_Model
{
	// select all user
	function get_all_request($limit ='',$offset='',$sortby = 'r.requestid',$orderby = 'desc')
	{
		switch($sortby)
		{
			case 'categoryname' : $sortby = 'c.categoryname';break;
			case 'categoryname' : $sortby = 'h.hoteelname';break;
			default             : $sortby = 'categoryid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->select('c.categoryname,h.hotelname,r.requestdescription,r.status');
                $this->db->from('request as r');
                $this->db->join('hotel as h','h.hoteluniqid = r.hoteluniqid','left');
                $this->db->join('category as c','c.categoryuniqid = r.categoryuniqid','left');
                $this->db->where('c.language',$lanid);
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
	
	
	
}