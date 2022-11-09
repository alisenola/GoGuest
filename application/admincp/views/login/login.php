<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="Media System" name="description">
        <meta content="Media System" name="keywords">
        <meta name="robots" content="noindex" />
        <title>Asia Fashion</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css -->
        <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url() ?>js/jquery.min.js"></script> 
        <script type="text/javascript" language="javascript">
            var error = [];
            error[0] = true;
            error[1] = true;
    function trim(stringToTrim) {
		return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	
        function checkusername(str)
        {
           if(str == "" || str == null)
           {
               $("#user_name").attr("style","border-color:#FF0000 !important;box-shadow: 0 10px 10px rgba(0, 0, 0, 0.075) inset;");
               error[0] = false;
           }
           else
           {
               $("#user_name").attr("style","");
               error[0] = true;
           }
        }
        
        function checkpassword(str)
        {
            if(str == "" || str == null)
            {
                $("#user_pass").attr("style","border-color:#FF0000 !important;box-shadow: 0 10px 10px rgba(0, 0, 0, 0.075) inset;");
                error[1] = false;
            }
            else
           {
               $("#user_pass").attr("style","");
               error[1] = true;
           }
        }
        
        function logindetail()
        {
            if(error[0] == false || error[1] == false)
            {
                if(error[0] == false)
                {
                  checkusername();      
                }
                if(error[1] == false)
                {
                    checkpassword();
                }
                return false;
            }
            else
            {
                var username = $("#user_name").val();
                var userpassword = $("#user_pass").val();
                if(username == "")
                {
                    checkusername(username);
                    return false;
                }
                else if(userpassword == "")
                {
                    checkpassword(userpassword);
                    return false;
                }
                else
                {
                    return true;
                }
                
            }
        }
</script>
		<script type="text/javascript">
        function closediv()
        {
            $("#closediv").hide();
        }
        </script>
    </head>
    <body class="main_hmbg">
        <div class="container">
            <header class="header">
                <a href="<?php echo base_url(); ?>" title="Media System" class=""></a>
            </header>
            <div class="hom_login_wrp col-lg-7">
            	<h1>Login</h1>
                <form class="form-horizontal login_frm tp_mrgn4" role="form" action="<?php echo base_url() ?>login/index" method="post" id="form-login" name="form-login" onsubmit="return logindetail();">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Username" name="user_name" id="user_name" onblur="checkusername(this.value);">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass" onblur="checkpassword(this.value);">
                    </div>
                  </div>
<!--                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 frgt_lnk">
                        <a href="<?php echo base_url()."forgetpassword" ?>" title="Forget Password">Forgot password ?</a>
                    </div>
                  </div>-->
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                     <input type="hidden" name="hiddenlogin">
                     <?php echo form_input(array('type'=>'submit','name'=>'btnsubmit','id'=>'btnsubmit','class'=>'btn btn-login','value'=>'Login','title'=>'Login')); ?>
                      
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </body>
</html>

<!-- jQuery UI 1.10.3 --> 
<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script> 
<!-- Bootstrap --> 
<script src="js/bootstrap.min.js" type="text/javascript"></script> 
<!-- AdminLTE App --> 
<script src="js/app.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
  $('#mymodel').trigger('click');
	});
</script>
<?php if( $this->session->flashdata('success') ) { 

?>
<button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;" >Create</button>
    <div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="modal-body">
                    <h3><?php echo $this->session->flashdata('success'); ?></h3>
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
                    <h3><?php echo $this->session->flashdata('error'); ?></h3>
                </div>
                <div class="modal-footer tp_mrgn2">
                    <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>  
       
    