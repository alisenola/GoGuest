<?php
Class Pages extends CI_Model
{
	// select all user
	function get_all_page($limit ='',$offset='',$sortby = 'pageid',$orderby = 'desc')
	{
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
                $query = $this->db->get('pages');
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