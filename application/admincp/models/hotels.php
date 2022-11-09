<?php
Class Hotels extends CI_Model
{
	// select all user
	function get_all_hotel($limit ='',$offset='',$sortby = 'hotelid',$orderby = 'desc')
	{
		switch($sortby)
		{
			case 'hotelname' : $sortby = 'hotelname';break;
			case 'status'       : $sortby = 'status';break;
			default             : $sortby = 'hotelid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->where('language',$lanid);
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