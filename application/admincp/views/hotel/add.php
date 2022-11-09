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
            <li><a href="<?php echo base_url()."hotel"; ?>">Hotels</a></li>
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
                <form role="form" action="<?php echo base_url()."hotel/update" ?>" method="post" enctype="multipart/form-data" onsubmit="return checkalldata();" >
                  <div class="box-body">
                      <div class="alert alert-danger" id="error_div" style="display: none;"></div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_name"];  ?></label>
                      <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_description"];  ?></label>
                       <textarea id="editor1" name="description" rows="10" cols="80"></textarea>
                    
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_image"];  ?></label>
                      <input type="file" id="image1" name="image1">
                     
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_latitude"];  ?></label>
                      <input type="text" class="form-control" id="latitude" name="latitude">
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_longitude"];  ?></label>
                      <input type="text" class="form-control" id="longitude" name="longitude">
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $lang->language["submit"];  ?></button>
                  </div>
                </form>
              </div><!-- /.box -->

             

            </div><!--/.col (left) -->
            
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
 <?php echo $footer; ?>  
      
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
     <script type="text/javascript">
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>
    <script type="text/javascript">
    function checkalldata()
    {
        var hotelname = $("#name").val();
        var editor1 = $("#editor1").val();
        var latitude = $("#latitude").val();
        var longitude = $("#longitude").val();
        
        if(hotelname  == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_name"].' '.$lang->language["required"]  ?>');
            return false;
        }
        if(editor1  == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_description"].' '.$lang->language["required"]  ?>');
            return false;
        }
        if(latitude  == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_latitude"].' '.$lang->language["required"]  ?>');
            return false;
        }
        if(longitude  == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_longitude"].' '.$lang->language["required"]  ?>');
            return false;
        }
    }
    
    </script>
    