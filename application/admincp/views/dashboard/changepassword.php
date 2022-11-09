<?php echo $header; ?>
<?php echo $left_menu; ?>



<!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
          <li><a href="<?php echo base_url()?>dashboard" title="Dashboard">Dashboard</a></li>
        <li class="active" title="Change password">change Password</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <h1> Change Password </h1>
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
                            <form role="form" class="form-horizontal" name="passowrdchange" method="post" action="dashboard/passwordchangerequest" onSubmit="return checkallvalue();">
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4">Current Password</label>
                                <div class="col-sm-6">
                                  <input type="password" placeholder="Current Password" class="form-control"name="old_password" id="old_password"  onBlur="checkoldpass()">
                                    <span id="old_pass_span" style="color:red;"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4">New Password</label>
                                <div class="col-sm-6">
                                  <input type="password" placeholder="New Password" class="form-control"name="new_password" id="new_password" onBlur="checkpassword();">
                                    <span id="pwd1span" style="color:red;"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4">Re-type Password</label>
                                <div class="col-sm-6">
                                  <input type="password" placeholder="Enter Password"  class="form-control" name="conf_password" id="conf_password" onKeyUp="matchpassword()">
                                    <span id="pwd2span" style="color:red;"></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail4"></label>
                                <div class="col-sm-6">
                                  <input type="submit" name="changepassword" value="Change password" class="btn btn-primary">
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
	function checkoldpass()
	{
		var old_pass = $("#old_password").val();
		if(old_pass == "")
		{
			$("#old_pass_span").html("Enter old password");
			error[0] = false;
		}
		else
		{
			$("#old_pass_span").html('<img src="images/correct.gif">');
			error[0] = true;
		}
	}
	// password validtaiton
	
	function checkpassword()
	{
			var pwd1 = $("#new_password").val();
			if(pwd1 == "")
			{
				$("#pwd1span").html("Enter password");
				error[1] = false;
			}
			else
			{
				$("#pwd1span").html('<img src="images/correct.gif">');
				error[1] = true;
			}
		}
	
	// password match
	function matchpassword()
	{
			var pwd1 = $("#new_password").val();
			var pwd2 = $("#conf_password").val();
			
			if(pwd2 == "")
			{
				$("#pwd2span").html("Enter re-type password");
				error[2] = false;
			}
			else
			{
				if(pwd1 != pwd2)
				{
					$("#pwd2span").html('<img src="images/error.gif"> password does not match');
					error[2] = false;
				}
				else
				{
					$("#pwd2span").html('<img src="images/correct.gif">');
					error[2] = true;
				}
			}
		}
	
	// check all value
		function checkallvalue()
		{
			if(error[0] == false || error[1] == false || error[2] == false)
			{
				return false;
			}
			else
			{
				var old_pass = $("#old_password").val();
				var pwd1 = $("#new_password").val();
				var pwd2 = $("#conf_password").val();	
				if(old_pass == "" || pwd1 == "" || pwd2 == "")
				{
					checkoldpass();
					checkpassword();
					matchpassword();
					return false
				}
				else
				{
					return true;
				}
			}
		}
	
</script>