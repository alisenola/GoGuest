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
<?php for ($i = 0; $i < count($request); $i++) { ?>
    <!-- Service Box -->
    <div class="top-tab-services-box">
        <!-- Title Div -->	
        <div class="top-tab-services-box-title">
            <div class="squaredFour">
                <input type="checkbox" value="None" class="squaredFour-input" id="squaredFour" name="check" >
                <label for="squaredFour" class="squaredFour-labe2">Last Services <?php echo $i + 1 ?> </label>
            </div>
            <p><?php echo $request[$i]['requestdescription']; ?></p>
        </div><!-- Title Div -ends-->
        <!-- Content Div -->	
        <div class="top-tab-services-box-content">
            <ul>
                <li>
                    <font>Oping time <br>status</font>

                    <span><b><?php echo date('h:i a -  d M', strtotime($request[$i]['requesttime'])) ?> </b>
                        <br>
                        <ul class="nav navbar-nav top-opened"> 
                            <li id="fat-menu" class="dropdown">
                                <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?php if ($request[$i]['status'] == 'close') { ?>
                                        conclude
                                    <?php } ?>
                                    <?php if ($request[$i]['status'] == 'hands on') { ?>
                                        hands on
                                    <?php } ?>
                                    <?php if ($request[$i]['status'] == 'open') { ?>
                                        open
                                    <?php } ?>
                                    <?php if ($request[$i]['status'] == 'standby') { ?>
                                        standby
                                    <?php } ?>
                                </a> 
                                <?php if ($request[$i]['status'] == 'hands on') { ?>
                                    <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                        <li><a href="<?php echo base_url('dashboard/status/close/') .'/'. $request[$i]['requestid'] ?>">concluded</a></li> 
                                        <li><a href="<?php echo base_url('dashboard/status/standby/') .'/'. $request[$i]['requestid'] ?>">stand by</a></li> 
                                    </ul>
                                <?php } ?>
                                <?php if ($request[$i]['status'] == 'open') { ?>
                                    <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                        <li><a href="<?php echo base_url('dashboard/status/handson/') .'/'. $request[$i]['requestid'] ?>">hands on</a></li>  
                                        <li><a href="<?php echo base_url('dashboard/status/standby/') .'/'. $request[$i]['requestid'] ?>">stand by</a></li> 
                                    </ul>
                                <?php } ?>
                                <?php if ($request[$i]['status'] == 'standby') { ?>
                                    <ul class="dropdown-menu top-tab-drowpdwn" aria-labelledby="drop3">
                                        <li><a href="<?php echo base_url('dashboard/status/handson/') .'/'. $request[$i]['requestid'] ?>">hands on</a></li>  
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    </span>
                </li>
                <?php if ($request[$i]['status'] == 'close') { ?>
                    <li>
                        <font>Closing time</font>

                        <span><b><?php
                                echo date('h:i a -  d M', strtotime($request[$i]['requetclosetime']));
                                ;
                                ?></b></span>
                    </li>
                <?php } ?>

                <li>
                    <font>Responsible</font>

                    <span><b><?php echo $request[$i]['username']; ?></b></span>
                </li>

                <li>
                    <font>Host/room</font>

                    <span><b><?php echo $request[$i]['userfirstname']; ?>/<?php echo $request[$i]['roomno']; ?></b></span>
                </li>
            </ul>
        </div><!-- Content Div Ends-->	
    </div><!-- Service Box Ends-->
<?php } ?>