<?php
Class Subcategories extends CI_Model
{
	// select all user
	function get_all_subcategory($limit ='',$offset='',$sortby = 'c.categoryid',$orderby = 'desc')
	{
		switch($sortby)
		{
			case 'categoryname' : $sortby = 'c.categoryname';break;
			default             : $sortby = 'c.categoryid';break;
		}
                $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
                $this->db->select('c.categoryname,c.categoryid,p.categoryname as parentcatname');
                $this->db->from('category as c');
                $this->db->join('category as p','p.categoryid = c.categoryparentid','left');
                $this->db->where('c.language',$lanid);
                $this->db->where('c.categoryparentid !=',0);
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
	function get_all_category()
	{
		
            $lanid = $this->session->userdata('go_lang');
            if($lanid == "")
            {
                $lanid = 'en';
            }
            $this->db->select('c.categoryname,c.categoryid');
            $this->db->from('category as c');
            $this->db->where('c.language',$lanid);
            $this->db->where('c.categoryparentid',0);
            $this->db->order_by('c.categoryname','asc');
            //Setting Limit for Paging
            
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