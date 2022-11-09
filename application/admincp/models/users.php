<?php
Class Users extends CI_Model
{
	// select all user
	function get_all_users($limit ='',$offset='',$sortby = 'userid',$orderby = 'desc')
	{
            switch($sortby)
            {
                case 'userfirstname' : $sortby = 'userfirstname';break;
                case 'userlastname' : $sortby = 'userlastname';break;
                case 'userbirthday' : $sortby = 'userbirthday';break;
                case 'useremail' : $sortby = 'useremail';break;
                default             : $sortby = 'userid';break;
            }
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

            $query = $this->db->get('users');
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