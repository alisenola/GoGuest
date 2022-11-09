<?php
Class Common extends CI_Model
{
    // insert database
    function insert_data($data,$tablename)
    {
        if($this->db->insert($tablename,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
   
    // update database
    function update_data($data,$tablename,$columnname,$columnid)
    {
        $this->db->where($columnname,$columnid);
        if($this->db->update($tablename,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // Select All Data Without Pagination 
    function get_all_data($table,$data='*',$sortby='',$orderby='')
    {
        $this->db->select($data);
        if($sortby != "" && $orderby !="")
        {
            $this->db->order_by($sortby,$orderby);
        }
        $this->db->where('status','Enable');
        $query = $this->db->get($table);
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    
   // select data using colum id
    function select_database_id($tablename,$columnname,$columnid,$data='*',$whereclum='',$whereval='',$sortby='',$orderby='')
    {
        $this->db->select($data);
        $this->db->where($columnname,$columnid);
        if($whereclum != "" && $whereval !="" )
        {
            $this->db->where($whereclum,$whereval);
        }
        if($sortby != "" && $orderby != "")
        {
            $this->db->order_by($sortby,$orderby);
        }
        $query = $this->db->get($tablename);
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    
    // select data using array
    function get_select_byarray($tblname,$columname,$colval,$data='*',$sortby='',$orderby='')
    {
        $this->db->select($data);
        $this->db->where_in($columname,$colval);
        if($sortby != "" && $orderby != "")
        {
            $this->db->order_by($sortby,$orderby);
        }
        $query = $this->db->get($tblname);
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
   
    // delete data
    function delete_data($tablename,$columnname,$columnid)
    {
        $this->db->where($columnname,$columnid);
        if($this->db->delete($tablename))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // change status
    function change_status($data,$tablename,$columnname,$columnid)
    {
        $this->db->where($columnname,$columnid);
        if($this->db->update($tablename,$data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    // check unique avaliblity
    function check_unique_avalibility($tablename,$columname1,$columnid1_value,$columname2,$columnid2_value)
    {
        if($columnid2_value != '')
        {
            $this->db->where($columname2." !=",$columnid2_value);
        }
        $this->db->where($columname1,$columnid1_value);
        $this->db->where('isdelete','No');
        $query = $this->db->get($tablename);
        if($query->num_rows()>0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    //table records count
    function get_count_of_table($table)
    {
        $query = $this->db->count_all($table);
        return $query;
    }
    // get recent record
    function get_recent_record($tablename,$limit,$data='*',$sortby='',$orderby='')
    {
        $this->db->select($data);
        $this->db->limit($limit);
        if($sortby != '' && $orderby != "")
        {
            $this->db->order_by($sortby,$orderby);
        }
        $query = $this->db->get($tablename);
        if($query ->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
     //-----------------sending mail when status has been changed ---------------------//
    function mailForChangeStatus($mailformatid="",$status="",$data=array())
    {
        //data[0] for senders mail id
        //data[1] sender name
         // Mail For Spa Admin
        
        $mail = $this->get_email_byid($mailformatid);
        $subject = $mail[0]['varsubject'];
        $mailformat = $mail[0]['varmailformat'];

        $sitename = $this->common->get_setting_value(1);
        $siteurl = $this->common->get_setting_value(2);
        $site_email = $this->common->get_setting_value(5);
        $this->load->library('email');

        $this->email->from($site_email, $sitename);
        $this->email->to($data[0]);
        $this->email->subject($subject);
        $mail_body = str_replace("%firstname%", ucfirst($data[1]),
                     str_replace("%status%", $status, 
                     str_replace("%sitename%", $sitename, 
                     str_replace("%siteurl%", $siteurl,  
                     stripslashes($mailformat)))));
        $this->email->message($mail_body);  
//        echo "<pre>";
//        echo $data[0];
//        print_r($mail_body);
//        die();
       // if($this->email->send());
    }
    



    //------------------------ OLD FUNCTION ------------------------------//
	// get password
	function get_user_passowrd($loginid)
	{
		$this->db->select('password');
		$this->db->where('userid',$loginid);
		$query = $this->db->get('users');
		if($query ->num_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
	}
	
	// update password
	function update_passowrd($loginid,$new_password)
	{
		$date = date('Y-m-d H:i:s');
		$varipaddress = $_SERVER['REMOTE_ADDR'];
		$data = array(
								'password' => $new_password,
								'editip' => $varipaddress,
								'date_edit' => $date
								);

	 $this->db->where('userid', $loginid);
		if( $this->db->update('users', $data) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Getting setting value By id
	function get_setting_value($id)
 	{
		$query = $this->db->get_where('setting', array('settingid' => $id,));
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return nl2br(($result[0]['settingfieldvalue']));
		}
		else
		{
			return false;
		}
 	}
	
	//Getting Email value
	function get_email_byid($id)
 	{
		$query = $this->db->get_where('email_format', array('emailid' => $id));
		
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
 	}
        
       // get group permision
        function get_group_permission($groupid)
        {
            $this->db->select('roleid');
            $this->db->where('groupid',$groupid);
            $this->db->where('status','Enable');
            $query = $this->db->get('group');
            if($query->num_rows()>0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
        // get url permssion id
        function get_url_permission($first_segment)
        {
            $this->db->select('id');
            $this->db->where('modulename',$first_segment);
            $this->db->where('status','Enable');
            $query = $this->db->get('role');
            if($query->num_rows()>0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
    function get_count_of_total_reviews($tablename,$columnname,$columnid)
    {
        $this->db->select("*");
        $this->db->from($tablename);
        $this->db->where($columnname,$columnid);
        $this->db->where('review != ','');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_count_of_hotel()
    {
        $this->db->where('language','en');
        $query = $this->db->count_all_results('hotel');
        return $query;
    }
    function get_avg_request()
    {
        $query = $this->db->query('select ifnull(round(count(*) / count(distinct date(timestamp))),0) as count from gog_request');
        return $query->result_array();
    }
      
    
	
}