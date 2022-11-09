 <?php echo $header; ?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $lang->language["add"];  ?> <?php echo $lang->language["hotels"];  ?>
            
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()."hoteladmin"; ?>">Hotel Admin</a></li>
            <li class="active"><?php echo $lang->language["add"];  ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
               
                <!-- form start -->
                <form role="form" action="<?php echo base_url()."hoteladmin/update" ?>" method="post" enctype="multipart/form-data" onsubmit="return checkalldata();" >
                  <div class="box-body">
                      <div class="alert alert-danger" id="error_div" style="display: none;"></div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_name"];  ?></label>
                      <?php if(count($hotels)>0) { ?>
                      <select class="form-control" name="hoteluniqid">
                          <?php for($i=0;$i<count($hotels);$i++)
                          {
                              $sel = '';
                              if($hotels[$i]['hoteluniqid'] == $hoteladmin[0]['hoteluniqid'])
                              {
                                  $sel = 'selected = "selected"';
                              }
                              else
                              {
                                  $sel = '';
                              }
                              ?>
                          <option <?php echo $sel; ?> value="<?php echo $hotels[$i]['hoteluniqid']; ?>"><?php echo $hotels[$i]['hotelname']; ?></option>
                         <?php }
                          ?>
                      </select>
                      <?php } else { echo 'Please first enter hotel';} ?>
                     
                    </div>
                    
                    
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_email"];  ?></label>
                      <input type="text" class="form-control" id="hotelemail" name="hotelemail" value="<?php echo $hoteladmin[0]['hotelemail']; ?>">
                    </div>
                    
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="hidden" name="hadminid" value="<?php echo $hoteladmin[0]['hadminid']; ?>">
                    <button type="submit" class="btn btn-primary"><?php echo $lang->language["submit"];  ?></button>
                  </div>
                </form>
              </div><!-- /.box -->

             

            </div><!--/.col (left) -->
            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
 <?php echo $footer; ?>  
      
    
 <script type="text/javascript">
    function checkalldata()
    {
        var hotelemail = $("#hotelemail").val();
        
        var email_validation = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;;
        if(hotelemail  == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_email"].' '.$lang->language["required"]  ?>');
            return false;
        }
        if(!email_validation.test(hotelemail))
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["email_validation"];  ?>');
            return false;
        }
       
        
    }
    
    </script>
    