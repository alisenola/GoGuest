<?php echo $header; ?>
<link href="<?php echo base_url('plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .chart-legend ul li text {
        fill: white !important;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid main-section">
        <!-- Left -->
        <div class="col-lg-4 col-sm-12 col-md-4 col-xs-12 section-left">
            <!-- Top Tab Div -->
            <div class="top-tab-div">
                <!-- Tab Start -->
                <ul class="nav nav-tabs top-tab-menu" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab" aria-expanded="true">all</a></li>
                    <li role="presentation" class=""><a href="#new" aria-controls="new" role="tab" data-toggle="tab" aria-expanded="false">new</a></li>
                    <li role="presentation" class=""><a href="#handson" aria-controls="handson" role="tab" data-toggle="tab" aria-expanded="false">hands on</a></li>
                    <li role="presentation" class=""><a href="#conclued" aria-controls="conclued" role="tab" data-toggle="tab" aria-expanded="false">concluded</a></li>
                    <li role="presentation" class=""><a href="#standby" aria-controls="standby" role="tab" data-toggle="tab" aria-expanded="false">stand by</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content top-tab-content-div">
                    <div role="tabpanel" class="tab-pane active" id="all">
                        <?php if (isset($request['all'])) { ?>
                            <!-- Select all Services Div top -->
                            <div class="top-tab-inner">
                                <ul>
                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check"  onclick="toggle(this)">
                                            <label for="squaredFour" class="squaredFour-label">Select all Services</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Close all select services</label>
                                        </div>
                                    </li>
                                </ul>		
                            </div><!-- Select all Services Div top Ends-->
                            <?php for ($i = 0; $i < count($request['all']); $i++) { ?>
                                <!-- Service Box -->
                                <div class="top-tab-services-box">
                                    <!-- Title Div -->	
                                    <div class="top-tab-services-box-title">
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
                                        </div>
                                        <p><?php echo $request['all'][$i]['requestdescription']; ?></p>
                                    </div><!-- Title Div -ends-->
                                    <!-- Content Div -->	
                                    <div class="top-tab-services-box-content">
                                        <ul>
                                            <li>
                                                <font>Oping time <br>status</font>

                                                <span><b><?php echo date('h:i a -  d M', strtotime($request['all'][$i]['requesttime'])) ?> </b>
                                                    <br>
                                                    <ul class="nav navbar-nav top-opened"> 
                                                        <li id="fat-menu" class="dropdown">
                                                            <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                                                                <?php if ($request['all'][$i]['status'] == 'close') { ?>
                                                                    concluded
                                                                <?php } ?>
                                                                <?php if ($request['all'][$i]['status'] == 'hands on') { ?>
                                                                    hands on
                                                                <?php } ?>
                                                                <?php if ($request['all'][$i]['status'] == 'open') { ?>
                                                                    open
                                                                <?php } ?>
                                                                <?php if ($request['all'][$i]['status'] == 'standby') { ?>
                                                                    standby
                                                                <?php } ?>
                                                            </a> 
                                                            <?php if ($request['all'][$i]['status'] == 'hands on') { ?>
                                                                <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                                    <li><a href="<?php echo base_url('dashboard/status/close/') . '/' . $request['all'][$i]['requestid'] ?>">concluded</a></li> 
                                                                    <li><a href="<?php echo base_url('dashboard/status/standby/') . '/' . $request['all'][$i]['requestid'] ?>">stand by</a></li> 
                                                                </ul>
                                                            <?php } ?>
                                                            <?php if ($request['all'][$i]['status'] == 'open') { ?>
                                                                <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                                    <li><a href="<?php echo base_url('dashboard/status/handson/') . '/' . $request['all'][$i]['requestid'] ?>">hands on</a></li>  
                                                                    <li><a href="<?php echo base_url('dashboard/status/standby/') . '/' . $request['all'][$i]['requestid'] ?>">stand by</a></li> 
                                                                </ul>
                                                            <?php } ?>
                                                            <?php if ($request['all'][$i]['status'] == 'standby') { ?>
                                                                <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                                    <li><a href="<?php echo base_url('dashboard/status/handson/') . '/' . $request['all'][$i]['requestid'] ?>">hands on</a></li>  
                                                                </ul>
                                                            <?php } ?>
                                                        </li>
                                                    </ul>
                                                </span>
                                            </li>
                                            <?php if ($request['all'][$i]['status'] == 'close') { ?>
                                                <li>
                                                    <font>Closing time</font>

                                                    <span><b><?php
                                                            echo date('h:i a -  d M', strtotime($request['all'][$i]['requetclosetime']));
                                                            ;
                                                            ?></b></span>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <font>Responsible</font>

                                                <span><b><?php echo $request['all'][$i]['username']; ?></b></span>
                                            </li>

                                            <li>
                                                <font>Host/room</font>

                                                <span><b><?php echo $request['all'][$i]['userfirstname']; ?>/<?php echo $request['all'][$i]['roomno']; ?></b></span>
                                            </li>
                                        </ul>
                                    </div><!-- Content Div Ends-->	
                                </div><!-- Service Box Ends-->
                            <?php } ?>
                        <?php } ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="new">
                        <?php if (isset($request['open'])) { ?>
                            <!-- Select all Services Div top -->
                            <div class="top-tab-inner">
                                <ul>
                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Select all Services</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Closer all select services</label>
                                        </div>
                                    </li>
                                </ul>		
                            </div><!-- Select all Services Div top Ends-->
                            <?php for ($i = 0; $i < count($request['open']); $i++) { ?>
                                <!-- Service Box -->
                                <div class="top-tab-services-box">
                                    <!-- Title Div -->	
                                    <div class="top-tab-services-box-title">
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
                                        </div>
                                        <p><?php echo $request['open'][$i]['requestdescription']; ?></p>
                                    </div><!-- Title Div -ends-->
                                    <!-- Content Div -->	
                                    <div class="top-tab-services-box-content">
                                        <ul>
                                            <li>
                                                <font>Oping time <br>status</font>

                                                <span><b><?php echo date('h:i a -  d M', strtotime($request['open'][$i]['requesttime'])) ?> </b>
                                                    <br>
                                                    <ul class="nav navbar-nav top-opened"> 
                                                        <li id="fat-menu" class="dropdown">                                                            
                                                            <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                Open
                                                            </a> 
                                                            <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                                <li><a href="<?php echo base_url('dashboard/status/handson/') . '/' . $request['open'][$i]['requestid']; ?>">hands on</a></li> 
                                                                <li><a href="<?php echo base_url('dashboard/status/standby/') . '/' . $request['open'][$i]['requestid']; ?>">stand by</a></li> 
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </span>
                                            </li>
                                            <?php if ($request['open'][$i]['status'] == 'close') { ?>
                                                <li>
                                                    <font>Closing time</font>

                                                    <span><b><?php
                                                            echo date('h:i a -  d M', strtotime($request['open'][$i]['requetclosetime']));
                                                            ;
                                                            ?></b></span>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <font>Responsible</font>

                                                <span><b><?php echo $request['open'][$i]['username']; ?></b></span>
                                            </li>

                                            <li>
                                                <font>Host/room</font>

                                                <span><b><?php echo $request['open'][$i]['userfirstname']; ?>/<?php echo $request['open'][$i]['roomno']; ?></b></span>
                                            </li>
                                        </ul>
                                    </div><!-- Content Div Ends-->	
                                </div><!-- Service Box Ends-->
                            <?php } ?>
                        <?php } ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="handson">
                        <?php if (isset($request['hands on'])) { ?>
                            <!-- Select all Services Div top -->
                            <div class="top-tab-inner">
                                <ul>
                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Select all Services</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Closer all select services</label>
                                        </div>
                                    </li>
                                </ul>		
                            </div><!-- Select all Services Div top Ends-->

                            <?php for ($i = 0; $i < count($request['hands on']); $i++) { ?>
                                <!-- Service Box -->
                                <div class="top-tab-services-box">
                                    <!-- Title Div -->	
                                    <div class="top-tab-services-box-title">
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
                                        </div>
                                        <p><?php echo $request['hands on'][$i]['requestdescription']; ?></p>
                                    </div><!-- Title Div -ends-->
                                    <!-- Content Div -->	
                                    <div class="top-tab-services-box-content">
                                        <ul>
                                            <li>
                                                <font>Opning time <br>status</font>

                                                <span><b><?php echo date('h:i a -  d M', strtotime($request['hands on'][$i]['requesttime'])) ?> </b>
                                                    <br>
                                                    <ul class="nav navbar-nav top-opened"> 
                                                        <li id="fat-menu" class="dropdown">

                                                            <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                hands on
                                                            </a> 
                                                            <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3"> 
                                                                <li><a href="<?php echo base_url('dashboard/status/close/') . '/' . $request['hands on'][$i]['requestid']; ?>">concluded</a></li> 
                                                                <li><a href="<?php echo base_url('dashboard/status/standby/') . '/' . $request['hands on'][$i]['requestid']; ?>">stand by</a></li> 
                                                            </ul> 
                                                        </li>
                                                    </ul>
                                                </span>
                                            </li>
                                            <?php if ($request['hands on'][$i]['status'] == 'close') { ?>
                                                <li>
                                                    <font>Closing time</font>

                                                    <span><b><?php
                                                            echo date('h:i a -  d M', strtotime($request['hands on'][$i]['requetclosetime']));
                                                            ;
                                                            ?></b></span>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <font>Responsible</font>

                                                <span><b><?php echo $request['hands on'][$i]['username']; ?></b></span>
                                            </li>

                                            <li>
                                                <font>Host/room</font>

                                                <span><b><?php echo $request['hands on'][$i]['userfirstname']; ?>/<?php echo $request['hands on'][$i]['roomno']; ?></b></span>
                                            </li>
                                        </ul>
                                    </div><!-- Content Div Ends-->	
                                </div><!-- Service Box Ends-->
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="conclued">
                        <?php if (isset($request['close'])) { ?>
                            <!-- Select all Services Div top -->
                            <div class="top-tab-inner">
                                <ul>
                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Select all Services</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Closer all select services</label>
                                        </div>
                                    </li>
                                </ul>		
                            </div><!-- Select all Services Div top Ends-->

                            <?php for ($i = 0; $i < count($request['close']); $i++) { ?>
                                <!-- Service Box -->
                                <div class="top-tab-services-box">
                                    <!-- Title Div -->	
                                    <div class="top-tab-services-box-title">
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
                                        </div>
                                        <p><?php echo $request['close'][$i]['requestdescription']; ?></p>
                                    </div><!-- Title Div -ends-->
                                    <!-- Content Div -->	
                                    <div class="top-tab-services-box-content">
                                        <ul>
                                            <li>
                                                <font>Oping time <br>status</font>

                                                <span><b><?php echo date('h:i a -  d M', strtotime($request['close'][$i]['requesttime'])) ?> </b>
                                                    <br>
                                                    <ul class="nav navbar-nav top-opened"> 
                                                        <li id="fat-menu" class="dropdown">
                                                            <a id="drop3" href="#" class="dropdown-toggle">
                                                                <!--                                                    <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">-->

                                                                conclude

                                                            </a> 
                                                            <!--                                                    <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                            <li><a href="#">hands on</a></li> 
                                                            <li><a href="#">conclued</a></li> 
                                                            <li><a href="#">stand by</a></li> 
                                                            </ul> -->
                                                        </li>
                                                    </ul>
                                                </span>
                                            </li>
                                            <?php if ($request['close'][$i]['status'] == 'close') { ?>
                                                <li>
                                                    <font>Closing time</font>

                                                    <span><b><?php
                                                            echo date('h:i a -  d M', strtotime($request['close'][$i]['requetclosetime']));
                                                            ;
                                                            ?></b></span>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <font>Responsible</font>

                                                <span><b><?php echo $request['close'][$i]['username']; ?></b></span>
                                            </li>

                                            <li>
                                                <font>Host/room</font>

                                                <span><b><?php echo $request['close'][$i]['userfirstname']; ?>/<?php echo $request['close'][$i]['roomno']; ?></b></span>
                                            </li>
                                        </ul>
                                    </div><!-- Content Div Ends-->	
                                </div><!-- Service Box Ends-->
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="standby">
                        <?php if (isset($request['standby'])) { ?>
                            <!-- Select all Services Div top -->
                            <div class="top-tab-inner">
                                <ul>
                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Select all Services</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-label">Closer all select services</label>
                                        </div>
                                    </li>
                                </ul>		
                            </div><!-- Select all Services Div top Ends-->
                            <?php for ($i = 0; $i < count($request['standby']); $i++) { ?>
                                <!-- Service Box -->
                                <div class="top-tab-services-box">
                                    <!-- Title Div -->	
                                    <div class="top-tab-services-box-title">
                                        <div class="squaredFour">
                                            <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                                            <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
                                        </div>
                                        <p><?php echo $request['standby'][$i]['requestdescription']; ?></p>
                                    </div><!-- Title Div -ends-->
                                    <!-- Content Div -->	
                                    <div class="top-tab-services-box-content">
                                        <ul>
                                            <li>
                                                <font>Oping time <br>status</font>

                                                <span><b><?php echo date('h:i a -  d M', strtotime($request['standby'][$i]['requesttime'])) ?> </b>
                                                    <br>
                                                    <ul class="nav navbar-nav top-opened"> 
                                                        <li id="fat-menu" class="dropdown">
                                                            <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                                                                stand by

                                                            </a> 
                                                            <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                                                <li><a href="<?php echo base_url('dashboard/status/close/') . '/' . $request['standby'][$i]['requestid']; ?>">hands on</a></li> 
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </span>
                                            </li>
                                            <?php if ($request['standby'][$i]['status'] == 'close') { ?>
                                                <li>
                                                    <font>Closing time</font>

                                                    <span><b><?php
                                                            echo date('h:i a -  d M', strtotime($request['standby'][$i]['requetclosetime']));
                                                            ;
                                                            ?></b></span>
                                                </li>
                                            <?php } ?>

                                            <li>
                                                <font>Responsible</font>

                                                <span><b><?php echo $request['standby'][$i]['username']; ?></b></span>
                                            </li>

                                            <li>
                                                <font>Host/room</font>

                                                <span><b><?php echo $request['standby'][$i]['userfirstname']; ?>/<?php echo $request['standby'][$i]['roomno']; ?></b></span>
                                            </li>
                                        </ul>
                                    </div><!-- Content Div Ends-->	
                                </div><!-- Service Box Ends-->
                            <?php } ?>
                        <?php } ?>

                    </div>
                </div>

            </div>
            <!-- Tab Start Ends-->
        </div><!-- Top Tab Div Ends-->

        <!-- Right -->
        <div class="col-lg-8 col-sm-12 col-md-8 col-xs-12 section-right">
            <!-- Top Title-->
            <!--        <div class="section-right-top-title">
            <h2>Graphic Charts</h2>
            </div> Top Title Ends -->
            <!-- Small Title -->
            <div class="section-right-top-smalltitle">
                <?php if (isset($this->session->userdata['goguest_hotel_session'][5])) { ?>
                    <h3><?php echo $this->session->userdata['goguest_hotel_session'][5] . ' ' . $this->session->userdata['goguest_hotel_session'][4]; ?></h3>
                <?php } else { ?>
                    <h3>Admin Environment</h3>
                <?php } ?>
            </div><!-- Small Title Ends --> 
            <!-- Right side Tab -->
            <div class="section-right-tab-main">
                <!-- Tab Div -->
                <div class="section-right-tab">
                    <div id="exTab2">	
                        <div class="tab-padding">
                            <ul class="nav nav-tabs section-right-tab-nav">
                                <li class="active"><a href="#0" data-toggle="tab" aria-expanded="true">day</a></li>
                                <li class=""><a href="#1" data-toggle="tab" aria-expanded="false">week</a></li>
                                <li class=""><a href="#2" data-toggle="tab" aria-expanded="false">month</a></li>
                                <li class=""><a href="#3" data-toggle="tab" aria-expanded="false">YTD</a></li>
                            </ul>
                        </div>

                        <div class="tab-content right-tab-content">

                            <?php for ($g = 0; $g < count($graph); $g++) { ?>
                                <div class="tab-pane active" id="<?php echo $g ?>" >
                                    <div class="right-tab-content-inner" >

                                        <!-- Box Div -->
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 chart-left-main">	
                                            <!-- pie Chart Div-->
                                            <div class="right-pie-chart">
                                                <div class="box-body">
                                                    <h2>Call Control</h2>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="chart-responsive">
                                                                <canvas id="pieChart-<?php echo $g ?>" height="300"></canvas>
                                                            </div><!-- ./chart-responsive -->
                                                        </div><!-- /.col -->
                                                        <div class="col-md-4">
                                                            <ul class="chart-legend clearfix">
                                                                <li><i class="fa fa-circle fbcolor"></i> food & beverage</li>
                                                                <li><i class="fa fa-circle hkcolor"></i> housekeeping</li>
                                                                <li><i class="fa fa-circle fdcolor"></i> frontdesk</li>
                                                                <li><i class="fa fa-circle secolor"></i> security</li>
                                                                <li><i class="fa fa-circle encolor"></i> engineering</li>
                                                            </ul>
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->
                                                </div><!-- /.box-body -->

                                            </div><!-- pie Chart Div Ends-->

                                        </div><!-- Box Div Ends-->
                                        <!-- Box Div -->
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">	
                                            <!-- Food & Bervage Div -->
                                            <div class="food-div">
                                                <h2>all services</h2>
                                                <?php if (count($graph[$g]['category']) == 0) { ?>
                                                    <ul>
                                                        <li>open/new <span><font><i class="fa fa-circle"></i></font> # 0</span></li>
                                                        <li>ongoing/hands on <span><font><i class="fa fa-circle"></i></font> # 0</span></li>
                                                        <li>close/concluded <span><font><i class="fa fa-circle"></i></font> # 0</span></li>                                                       
                                                        <li>stand-by <span><font><i class="fa fa-circle"></i></font> # 0</span></li>
                                                    </ul>
                                                <?php } else { ?>
                                                    <ul>
                                                        <li>open/new<span><font><i class="fa fa-circle"></i></font> #<?php echo $graph[$g]['category'][0]['open'] ?></span></li>
                                                        <li>ongoing/hands on <span><font><i class="fa fa-circle"></i></font> #<?php echo $graph[$g]['category'][0]['ongoing'] ?></span></li>
                                                        <li>close/concluded <span><font><i class="fa fa-circle"></i></font> #<?php echo $graph[$g]['category'][0]['close'] ?></span></li>
                                                        <li>stand-by <span><font><i class="fa fa-circle"></i></font> #<?php echo $graph[$g]['category'][0]['standup'] ?></span></li>
                                                    </ul>
                                                <?php } ?>
                                            </div><!-- Food & Bervage Div -->
                                        </div><!-- Box Div Ends-->
                                        <!-- Top Title-->
                                    </div>

                                    <div class="right-tab-content-inner-2">
                                        <!-- Box Div -->
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 chart-left-main">
                                            <!-- Chart Div -->
                                            <div class="basis-chart">
                                                <div class="box-body chart-responsive">
                                                    <div class="chart">
                                                        <canvas id="barChart-<?php echo $g ?>" height="300"  class="barChart"></canvas>
                                                    </div>
                                                </div><!-- /.box-body -->
                                            </div><!-- Chart Div Ends-->
                                        </div><!-- Box Div -->
                                        <!-- Box Div -->
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">	
                                            <!-- Food & Bervage Div -->
                                            <div class="kpis-right">
                                                <h2>KPI's</h2>

                                                <ul>
                                                    <li>Answer time (avarage) <span><?php echo $graph[$g]['kpis'][2]['speed'] ?></span></li>
                                                    <li>Service time (average) <span><?php echo $graph[$g]['kpis'][1]['service'] ?></span></li>
                                                    <li>Effectiveness: <span><?php echo $graph[$g]['kpis'][0]['quelity'] ?></span></li>
                                                </ul>
                                            </div><!-- Food & Bervage Div -->
                                        </div><!-- Box Div Ends-->
                                    </div><!-- Tab Content 2 Div Ends-->
                                </div>
                            <?php } ?>
                            <!-- Tab Content Div Ends-->
                            <!-- Tab Content 2 Div-->

                            <div class="section-right-top-title">
                                <h2>FEEDBACK</h2>
                            </div><!-- Top Title Ends -->
                            <!-- Tab Content Div-->
                            <div class="right-tab-content-inner">
                                <!-- Box Div -->
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 chart-left-main">	
                                    <!-- Sort of trip -->
                                    <div class="sort-trip">
                                        <h2>% Sort of Trip</h2>
                                        <ul>
                                            <li>
                                                <span><i class="fa fa-briefcase"></i></span>
                                                <small>Business</small>
                                                <font><?php
                                                if (isset($triptype['business'])) {
                                                    echo $triptype['business'] . '%';
                                                } else {
                                                    echo '0%';
                                                }
                                                ?></font>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-heart"></i></span>
                                                <small>Couples</small>
                                                <font><?php
                                                if (isset($triptype['couples'])) {
                                                    echo $triptype['couples'] . '%';
                                                } else {
                                                    echo '0%';
                                                }
                                                ?></font>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-user"></i></span>
                                                <small>Family</small>
                                                <font><?php
                                                if (isset($triptype['family'])) {
                                                    echo $triptype['family'] . '%';
                                                } else {
                                                    echo '0%';
                                                }
                                                ?></font>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-users"></i></span>
                                                <small>Friends</small>
                                                <font><?php
                                                if (isset($triptype['friends'])) {
                                                    echo $triptype['friends'] . '%';
                                                } else {
                                                    echo '0%';
                                                }
                                                ?></font>
                                            </li>
                                            <li>
                                                <span><i class="fa fa-user"></i></span>
                                                <small>solo</small>
                                                <font><?php
                                                if (isset($triptype['solo'])) {
                                                    echo $triptype['solo'] . '%';
                                                } else {
                                                    echo '0%';
                                                }
                                                ?></font>
                                            </li>
                                        </ul>
                                    </div><!-- Sort of trip -->
                                </div><!-- Box Div -->
                                <!-- Box Div -->
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 chart-left-main">	
                                    <!-- Sort of trip -->
                                    <div class="average-proprety">
                                        <h2>Average overall rating proprety</h2>
                                        <ul>
                                            <?php $j = 0; ?>
                                            <?php for ($i = 0; $i < $rating; $i++) { ?>
                                                <li class="active"><i class="feedback-icon"></i></li>
                                                <?php
                                                $j++;
                                            }
                                            ?>
                                            <?php for ($k = $j; $k < 5; $k++) { ?>
                                                <li><i class="feedback-icon"></i></li>
                                            <?php } ?>
                                        </ul>

                                        <h2>Average overall rating GoGquest</h2>
                                        <ul>
                                            <?php $j = 0; ?>
                                            <?php for ($i = 0; $i < round($feedback['apprate']); $i++) { ?>
                                                <li class="active"><i class="feedback-icon"></i></li>
                                                <?php
                                                $j++;
                                            }
                                            ?>
                                            <?php for ($k = $j; $k < 5; $k++) { ?>
                                                <li><i class="feedback-icon"></i></li>
                                            <?php } ?>
                                        </ul>
                                    </div><!-- Sort of trip -->
                                </div><!-- Box Div -->


                            </div><!-- Tab Content Div-->

                            <!-- Tab Content Div-->
                            <div class="right-tab-content-inner-3">
                                <!-- Box Div -->
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 chart-left-main">	
                                    <!-- Average rating -->
                                    <div class="average-rating">
                                        <h2>Average rating</h2>
                                        <ul>
                                            <li>Service 
                                                <span >
                                                    <div class="rating ">


                                                        <?php $ser = 5 - round($feedback['servicerate']); ?> 

                                                        <?php for ($i = 0; $i < $ser; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>

                                                        <?php for ($i = 0; $i < round($feedback['servicerate']); $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon "></i></span>   
                                                        <?php } ?>         

                                                    </div>
                                                </span>
                                            </li>
                                            <li>Cleniness 
                                                <span>
                                                    <div class="rating">

                                                        <?php $cle = 5 - round($feedback['cleaninessrate']); ?>
                                                        <?php for ($i = 0; $i < $cle; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>

                                                        <?php for ($i = 0; $i < round($feedback['cleaninessrate']); $i++) { ?>                                                                                  
                                                            <span class="active"><i class="feedback-icon"></i></span>
                                                        <?php } ?>

                                                    </div>
                                                </span>
                                            </li>
                                            <li>Value 
                                                <span>
                                                    <div class="rating">

                                                        <?php $val = 5 - round($feedback['valuerate']); ?>                            

                                                        <?php for ($i = 0; $i < $val; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>                               

                                                        <?php for ($i = 0; $i < round($feedback['valuerate']); $i++) { ?>
                                                            <span class="active"><i class="feedback-icon"></i></span>
                                                        <?php } ?>
                                                    </div>
                                                </span>
                                            </li>
                                            <li>Location 
                                                <span>
                                                    <div class="rating">


                                                        <?php $loc = 5 - round($feedback['locationrate']); ?>                            

                                                        <?php for ($i = 0; $i < $loc; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>                                                               

                                                        <?php for ($i = 0; $i < round($feedback['locationrate']); $i++) { ?>
                                                            <span class="active"><i class="feedback-icon"></i></span>
                                                        <?php } ?>
                                                    </div>
                                                </span>
                                            </li>
                                            <li>Sleep 
                                                <span>
                                                    <div class="rating">

                                                        <?php $sle = 5 - round($feedback['sleeprate']); ?>                            

                                                        <?php for ($i = 0; $i < $sle; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>                                                               

                                                        <?php for ($i = 0; $i < round($feedback['sleeprate']); $i++) { ?>
                                                            <span class="active"><i class="feedback-icon"></i></span>
                                                        <?php } ?>
                                                    </div>
                                                </span>
                                            </li>                                               
                                            <li>Rooms 
                                                <span>
                                                    <div class="rating">

                                                        <?php $roo = 5 - round($feedback['roomrate']); ?>                            

                                                        <?php for ($i = 0; $i < $roo; $i++) { ?>
                                                            <span  class="active" ><i class="feedback-icon one "></i></span>   
                                                        <?php } ?>                                                                                           

                                                        <?php for ($i = 0; $i < round($feedback['roomrate']); $i++) { ?>
                                                            <span class="active"><i class="feedback-icon"></i></span>
                                                            <?php } ?>
                                                    </div>
                                                </span>
                                            </li>
                                        </ul>
                                    </div><!-- Sort of trip -->
                                </div><!-- Box Div -->

                            </div><!-- Right side Tab Ends -->
                        </div>

                    </div>
                </div><!-- Tab Div Ends-->

            </div><!-- Right -->
        </div><!-- Main Section Ends-->
    </div>
</div>
<?php echo $footer; ?>  
<script src="<?php echo base_url('plugins/chartjs/Chart.js') ?>" type="text/javascript"></script>
<script>
                                                        $(document).ready(function () {
                                                all_data();
                                                });
                                                        function all_data()
                                                        {
                                                        var areaChartData = {
                                                        labels: ["jan", "feb", "mar", "apr", "may", "june", "july", "aug", "sup", "oct", "nov", "dec"],
                                                                datasets: [
                                                                {
                                                                label: "Value",
                                                                        fillColor: "rgba(250, 162, 28, 1)",
                                                                        strokeColor: "rgba(250, 162, 28, 1)",
                                                                        pointColor: "rgba(210, 214, 222, 1)",
                                                                        pointStrokeColor: "#c1c7d1",
                                                                        pointHighlightFill: "#fff",
                                                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                                                        data: [
<?php for ($m = 1; $m < 13; $m++) { ?>
    <?php echo $basic_evelotion[$m] ?>
    <?php if ($m != 12) { ?>, <?php } ?>
<?php } ?>
                                                                        ]
                                                                }
                                                                ]
                                                        };
                                                        
<?php for ($i = 0; $i < count($graph); $i++) { ?>
                                                            //$("<?php //echo '#'.$i       ?>").addClass( "active" );

                                                            var pieChartCanvas = $("#pieChart-<?php echo $i ?>").get(0).getContext("2d");
                                                                    var pieChart = new Chart(pieChartCanvas);
                                                                    var PieData = [
    <?php for ($j = 0; $j < 5; $j++) { ?>
                                                                        {
                                                                        value: <?php echo $graph[$i]['call_controll'][$j]['value'] ?>,
                                                                                color: "<?php echo $graph[$i]['call_controll'][$j]['color'] ?>",
                                                                                highlight: "<?php echo $graph[$i]['call_controll'][$j]['highlight'] ?>",
                                                                                label: "<?php echo $graph[$i]['call_controll'][$j]['label'] ?>",
                                                                        },
    <?php } ?>

                                                                    ];
                                                                    //console.log(PieData);
                                                                    var pieOptions = {
                                                                    //Boolean - Whether we should show a stroke on each segment
                                                                    segmentShowStroke: true,
                                                                            //String - The colour of each segment stroke
                                                                            segmentStrokeColor: "#fff",
                                                                            //Number - The width of each segment stroke
                                                                            segmentStrokeWidth: 1,
                                                                            //Number - The percentage of the chart that we cut out of the middle
                                                                            percentageInnerCutout: 50, // This is 0 for Pie charts
                                                                            //Number - Amount of animation steps
                                                                            animationSteps: 100,
                                                                            //String - Animation easing effect
                                                                            animationEasing: "easeOutBounce",
                                                                            //Boolean - Whether we animate the rotation of the Doughnut
                                                                            animateRotate: true,
                                                                            //Boolean - Whether we animate scaling the Doughnut from the centre
                                                                            animateScale: false,
                                                                            //Boolean - whether to make the chart responsive to window resizing
                                                                            responsive: true,
                                                                            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                                                            maintainAspectRatio: false,
                                                                            //String - A tooltip template
                                                                            tooltipTemplate: "  <%= value %>(<%= label %>)",
                                                                            onAnimationComplete: function()
                                                                            {
                                                                            this.showTooltip(this.segments, true);
                                                                            },
                                                                            tooltipEvents: [],
                                                                            showTooltips: true
                                                                    };
                                                                    //Create pie or douhnut chart
                                                                    // You can switch between pie and douhnut using the method below.  
                                                                    pieChart.Doughnut(PieData, pieOptions);
                                                                    var barChartCanvas = $("#barChart-<?php echo $i ?>").get(0).getContext("2d");
                                                                    var barChart = new Chart(barChartCanvas);
                                                                    var barChartData = areaChartData;
                                                                    var barChartOptions = {
                                                                    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                                                                    scaleBeginAtZero: true,
                                                                            //Boolean - Whether grid lines are shown across the chart
                                                                            scaleShowGridLines: true,
                                                                            //String - Colour of the grid lines
                                                                            scaleGridLineColor: "rgba(0,0,0,.05)",
                                                                            //Number - Width of the grid lines
                                                                            scaleGridLineWidth: 1,
                                                                            //Boolean - Whether to show horizontal lines (except X axis)
                                                                            scaleShowHorizontalLines: true,
                                                                            //Boolean - Whether to show vertical lines (except Y axis)
                                                                            scaleShowVerticalLines: true,
                                                                            //Boolean - If there is a stroke on each bar
                                                                            barShowStroke: true,
                                                                            //Number - Pixel width of the bar stroke
                                                                            barStrokeWidth: 2,
                                                                            //Number - Spacing between each of the X value sets
                                                                            barValueSpacing: 5,
                                                                            //Number - Spacing between data sets within X values
                                                                            barDatasetSpacing: 1,
                                                                            //Boolean - whether to make the chart responsive
                                                                            responsive: true,
                                                                            maintainAspectRatio: false,
                                                                            //String - A legend template
                                                                            legendTemplate: ''
                                                                            
                                                                    };
                                                                    barChartOptions.datasetFill = false;
                                                                    barChart.Bar(barChartData, barChartOptions);
    <?php if ($i != 0) { ?>
                                                                //alert('hi');
                                                                $("<?php echo '#' . $i ?>").removeClass("active");
    <?php } ?>

<?php } ?>


                                                        }

                                                var ajax_call = function () {
                                                //alert('hi');
                                                $.ajax({
                                                url: '<?php echo base_url('dashboard/request') ?>',
                                                        dataType: 'json',
                                                        success: function (data) {
                                                        $("#all").empty();
                                                                $("#all").html(data.all);
                                                                $("#new").empty();
                                                                $("#new").html(data.open);
                                                                $("#handson").empty();
                                                                $("#handson").html(data.handson);
                                                                $("#conclued").empty();
                                                                $("#conclued").html(data.conclued);
                                                                $("#standby").empty();
                                                                $("#standby").html(data.standby);
                                                                //$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                                                                //$("[data-toggle='toggle']").bootstrapToggle();
                                                        }
                                                });
                                                        //alert(last_id);
                                                };
                                                        // var interval = 1000 * 60 * 0.12; // where X is your every X minutes
                                                        var interval = 5000; // where X is your every X minutes

                                                        setInterval(ajax_call, interval);
                                                        function toggle(source) {
//alert('hi');
                                                        checkboxes = document.getElementsByClassName('squaredFour-input');
                                                                for (var i = 0, n = checkboxes.length; i < n; i++) {
                                                        checkboxes[i].checked = source.checked;
                                                        }
                                                        }
</script>

