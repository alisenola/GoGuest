
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Go-guest | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url() ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url() ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
<!--    <link href="<?php echo base_url() ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<!--        <script src="<?php echo base_url() ?>js/jquery.min.js"></script> -->
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
               $("#user_email").attr("style","border-color:#FF0000 !important;box-shadow: 0 10px 10px rgba(0, 0, 0, 0.075) inset;");
               error[0] = false;
           }
           else
           {
               $("#user_email").attr("style","");
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
                var username = $("#user_email").val();
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
     <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a><b>Go</b>Guest</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
          <?php if( $this->session->flashdata('success') )
            { ?>
          <p class="login-box-msg text-success"><?php echo $this->session->flashdata('success'); ?></p>
          <?php } ?>
          <?php if( $this->session->flashdata('error') )
            { ?>
          <p class="login-box-msg text-danger"><?php echo $this->session->flashdata('error'); ?></p>
          <?php } ?>
        <form action="<?php echo base_url() ?>login/index" method="post" id="form-login" name="form-login" onsubmit="return logindetail();">
            <div class="form-group has-feedback">
                <select name="type" class="form-control">
                    <option value="hadmin">Hotel Admin</option>
                    <option value="aadmin">App Admin</option>
                    <option value="manger">Manager</option>
                </select>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" onblur="checkusername(this.value);"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass" onblur="checkpassword(this.value);"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            
            <div class="col-xs-4">
                <input type="hidden" name="hiddenlogin">
                     <?php echo form_input(array('type'=>'submit','name'=>'btnsubmit','id'=>'btnsubmit','class'=>'btn btn-primary btn-block btn-flat','value'=>'Sign In','title'=>'Sign In')); ?>
              
            </div><!-- /.col -->
          </div>
        </form>
        <a href="#">I forgot my password</a><br>
 

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    
  </body>
</html>

<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url() ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url() ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
<!--    <script src="<?php echo base_url() ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->
<!--    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>-->
<!-- jQuery UI 1.10.3 --> 
<!--<script src="<?php echo base_url() ?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script> 
 Bootstrap  
<script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script> 
 AdminLTE App  
<script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>-->

</script>
<?php if( $this->session->flashdata('success') ) { 

?>

<?php } if( $this->session->flashdata('error') ) { 

?>
     
<?php } ?>  
       
      