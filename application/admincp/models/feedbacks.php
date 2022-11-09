<?php
Class Feedbacks extends CI_Model
{
	// select all user
	function get_all_feedbacks($limit ='',$offset='',$sortby = 'feedbackid',$orderby = 'desc')
	{
            $lanid = $this->session->userdata('go_lang');
                if($lanid == "")
                {
                    $lanid = 'en';
                }
            $this->db->select('h.hotelname,f.*');
            $this->db->from('feedback as f');
            $this->db->join('hotel as h','h.hoteluniqid = f.hoteluniqid','left');
            $this->db->order_by($sortby,$orderby);
            $this->db->where('h.language',$lanid);
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