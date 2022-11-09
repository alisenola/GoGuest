<?php

Class Mailformats extends CI_Model {

    function get_all_mail($limit = '', $offset = '', $sortby = 'emailid', $orderby = 'ASC') {

        switch ($sortby) {
            case 'uniquename' : $sortby = 'uniquename';break;
            case 'vartitle' : $sortby = 'vartitle';break;
            case 'varsubject' : $sortby = 'varsubject';break;
            
            default : 
                $sortby = 'emailid';    break;
        }

        $this->db->order_by($sortby, $orderby);

        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get('email_format');
        if ($query->num_rows() > 0) 
        {
            return $query->result_array();
        } 
        else 
        {
            return array();
        }
    }
   
   //Get user Email Format by id
	function get_mail_byid($id)
 	{
	  
		 $this->db->select('*');
		 $this->db->from('email_format');
		 $this->db->where( array('emailid' => $id));
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

}?>