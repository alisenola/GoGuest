<?php
Class Logins extends CI_Model
{
	function logincheck($user_email,$password)
 	{
		$this->db->select('iAdminId,vAdminName,vAdminEmail,vAdminPassword');
		$this->db->where('vAdminEmail',$user_email);
		//$this->db->or_where('email',$username);
		$this->db->where('vAdminPassword',$password);
                $this->db->where('eStatus','Active');
		$query = $this->db->get('admin');
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			if(($user_email ==  $result[0]['vAdminEmail'] ) && ($password ==  $result[0]['vAdminPassword']) )
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
	
}
