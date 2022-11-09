<?php
Class Logins extends CI_Model
{
	function logincheck($user_email,$password)
 	{
		$this->db->select('*');
		$this->db->where('hotelemail',$user_email);
		$this->db->where('hotelpassword',$password);
                $query = $this->db->get('hotel_admin');
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			if(($user_email ==  $result[0]['hotelemail'] ) && ($password ==  $result[0]['hotelpassword']) )
			{
				return $query->result_array();
			}
			else
			{
				return array();
			}
		}
		else
		{
			return array();
		}
 	}
        function userlogincheck($user_email,$password,$type)
 	{
		$this->db->select('*');
		$this->db->where('useremail',$user_email);
		$this->db->where('userpassword',$password);
                if($type=='aadmin')
                {
                    $this->db->where('type','admin');
                }
                else
                {
                    $this->db->where('type','manager');
                }
                $query = $this->db->get('hotel_user');
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			if(($user_email ==  $result[0]['useremail'] ) && ($password ==  $result[0]['userpassword']) )
			{
				return $query->result_array();
			}
			else
			{
				return array();
			}
		}
		else
		{
			return array();
		}
 	}
        
         function get_verify_data($hotelid)
         {
            $this->db->where('hoteluniqid',  base64_decode($hotelid));
            $query = $this->db->get('hotel_admin');
            //echo $this->db->last_query();
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
