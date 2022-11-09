<?php
Class Categories extends CI_Model
{
	// select all user
	function get_all_category($limit ='',$offset='',$sortby = 'categoryid',$orderby = 'desc')
	{
		switch($sortby)
		{
			case 'categoryname' : $sortby = 'categoryname';break;
			default             : $sortby = 'categoryid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->where('language',$lanid);
                $this->db->where('categoryparentid',0);
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