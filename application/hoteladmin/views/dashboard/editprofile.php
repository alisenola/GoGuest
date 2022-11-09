<?php echo $header; ?>
<?php echo $left_menu; ?>
 

<!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
          <li><a href="<?php echo base_url()?>dashboard" title="Dashboard">Dashboard</a></li>
        <li class="active" title="Edit Profile">Edit Profile</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <h1> Edit Profile</h1>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12"> 
          <!-- small box -->
          <div class="box">
          	<div class="box-inner">
            	<div class="col-lg-10 col-md-10 col-sm-10 padng_rmv"> 
                	<div class="col-lg-12 col-md-12 col-sm-12 padng_rmv"> 
                    	<div class="col-lg-12 padng_rmv">
                	<div class="col-lg-12  padng_rmv">
                    	<div class="col-lg-10 copystructionpage">
                            <form role="form" class="form-horizontal"action="<?php echo base_url()."dashboard/updateprofile"; ?>" method="post" onSubmit="return checkallvalue();">
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4">User Name</label>
                                <div class="col-sm-6">
                                   <input type="text" class="form-control" name="username" id="username" maxlength="20" onBlur="checkusername();"  value="<?php echo $profile[0]['username']; ?>"  >
                              <span id="namespan" style="color:red;"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4">User Email</label>
                                <div class="col-sm-6">
                                   <input type="text"  class="form-control" name="useremail" id="useremail" maxlength="50" onBlur="checkemail();"  value="<?php echo $profile[0]['email']; ?>"  >
                              <span id="emailspan" style="color:red;"></span>
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4"></label>
                                <div class="col-sm-6">
                                  <input type="submit" name="Submit" value="Update" class="btn btn-primary">
                                </div>
                                
                              </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
                <div class="clearfix"></div>
               
                
                    </div>
                </div>
                
              </div>  
          </div>
        </div>
      </div>
      <!-- /.row --> 
      <!-- Main row -->
      
      <!-- /.row (main row) --> 
    </section>
    <!-- /.content -->
<?php echo $footer; ?>

    <script type="text/javascript">
	$(document).ready(function(){
  $('#mymodel').trigger('click');
	});
</script>
    
  <?php if( $this->session->flashdata('success') ) { 

?>    <button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
    <div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="modal-body">
                    <h3 style="color: green;"><?php echo $this->session->flashdata('success'); ?></h3>
                </div>
                <div class="modal-footer tp_mrgn2">
                    <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if( $this->session->flashdata('error') ) { 

?>
       <button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
    <div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="modal-body">
                    <h3 style="color: red;"><?php echo $this->session->flashdata('error'); ?></h3>
                </div>
                <div class="modal-footer tp_mrgn2">
                    <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>    
    
    
<script type="text/javascript">
		var error = new Array();
	  //  Username validation
 			function checkusername()
			{
				var name = $("#username").val();
				if(name == "")
				{
					$("#namespan").html("Enter user name");
					$("#username").focus();
					error[0] = false;
				}
				else
				{
					$.ajax({
					url:"dashboard/checkuserdetail",
					type:"post",
					data :"username="+name,
					success: function (data)
					{
						if(data == "old")
						{
							$("#namespan").html('<img src="images/error.gif">');
							error[0] = false;
							return false;		
						}
						else
						{
							$("#namespan").html("<img src='images/correct.gif' >");
							error[0] = true;
						}
					}
					});
				}
			}
			
			// Email validation
	function checkemail()
	{
		var email = $("#useremail").val();
	//	alert(email);
		var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if((email) == "" || (!filter.test(email)))
		{
			$("#emailspan").html("Enter valid Email");
			error[1] = false;
		}
		else
		{
			$.ajax({
					url:"dashboard/checkuseremail",
					type:"post",
					data :"useremail="+email,
					success: function (data)
					{
						if(data == "old")
						{
							$("#emailspan").html('<img src="images/error.gif">');
							error[1] = false;
							return false;		
						}
						else
						{
							$("#emailspan").html("<img src='images/correct.gif' >");
							error[1] = true;
						}
					}
					});
			}
		}
    // check all value
	function checkallvalue()
	{
            if(error[0] == false || error[1] == false)
            {
                return false;
            }
            else
            {
                var name = $("#username").val();
		var email = $("#useremail").val();
		if(name == "" || email == "")
		{
                    checkusername();
                    checkemail();
                    return false
                }
		else
		{
                    return true;
		}
            }
	}            
		
</script>