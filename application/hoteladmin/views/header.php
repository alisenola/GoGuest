<!DOCTYPE html>
<html>
    <noscript>
    <meta HTTP-EQUIV="REFRESH" content="0; url=<?php echo base_url();?>noscript.php"> 
</noscript>


<base href="<?php echo base_url();?>">
  <head>
    <meta charset="UTF-8">
    <title>Go guest | Dashboard</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo base_url('dist/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <!-- Ionicons -->
<!--    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
    <!-- Theme style -->
    <link href="<?php echo base_url('dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
    
    <!-- DATA TABLES -->
    <link href="<?php echo base_url('plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url('/dist/css/skins/skin-yellow.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
     <link href="<?php echo base_url('css/custom.css')?>" rel="stylesheet">
  </head>
  <body class="skin-yellow sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Go</b>-Guest</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Go</b>-Guest</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <?php if($this->uri->segment(1)=='dashboard' || $this->uri->segment(1)=='')
          { ?>
        	<h2 class="section-right-top-title">Graphic Charts</h2>
          <?php } ?>
          <div class="navbar-custom-menu">
             
            <ul class="nav navbar-nav">
             
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                
                  <span class="hidden-xs">
                      <?php if(isset($this->session->userdata['goguest_hotel_session'][5])){ ?>
                <?php echo 'Welcome '.$this->session->userdata['goguest_hotel_session'][5] ; ?>
                <?php } else { ?>
                <?php echo 'Welcome '.$this->session->userdata['goguest_hotel_session'][1]; ?></span>
                <?php } ?>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li >
                    
                    <p>
                    <form method="post" action="<?php echo base_url()."dashboard/changelang" ?>" role="form">
                  <select class="form-control input-sm" name="lang_sel" onchange="this.form.submit();">
                      <?php echo $lanid = $this->session->userdata('go_lang');
                      $temp1 = '';
                      $temp2 = '';
                        if($lanid == "" || $lanid == "en")
                        {
                            $temp1 = 'selected = "selected"';
                        }
                        if($lanid == "sp")
                        {
                            $temp2 = 'selected = "selected"';
                        }
                      ?>
                      <option value="en" <?php echo $temp1; ?>>English</option>
                      <option value="sp" <?php echo $temp2; ?>>Spanish</option>
              </select>
            </form>
                    
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
<!--                      <a href="#" class="btn btn-default btn-flat">Profile</a>-->
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo base_url('dashboard/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
<!--              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
         
          <ul class="sidebar-menu">
            
           
              <li class="dashboard">
                <a href="<?php echo base_url() ?>">
                <i class="fa fa-dashboard"></i> <span><?php echo $lang->language['dashbaord']; ?></span>
              </a>
            </li>
            <?php if(!(isset($this->session->userdata['goguest_hotel_session'][3] ))) { ?>
            <li class="request">
                <a href="<?php echo base_url('request') ?>">
                <i class="fa fa-briefcase"></i> <span><?php echo $lang->language['request']; ?></span>
              </a>
            </li>
            <li class="feedback">
                <a href="<?php echo base_url('feedback') ?>">
                <i class="fa fa-star"></i> <span><?php echo $lang->language['feedback']; ?></span>
              </a>
            </li>
            <li class="usercheckinrequest">
                <a href="<?php echo base_url('userchecking') ?>">
                <i class="fa fa-stack-exchange"></i> <span><?php echo $lang->language['user_checkin_request']; ?></span>
              </a>
            </li>
            <li class="userresponse">
                <a href="<?php echo base_url('checkinhistory') ?>">
                <i class="fa fa-stack-exchange"></i> <span><?php echo $lang->language['user_checkin_history']; ?></span>
              </a>
            </li>
            <li class="userresponse">
                <a href="<?php echo base_url('hoteladmin') ?>">
                <i class="fa fa-stack-exchange"></i> <span><?php echo $lang->language['hotel_user']; ?></span>
              </a>
            </li>    
            <?php } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

     