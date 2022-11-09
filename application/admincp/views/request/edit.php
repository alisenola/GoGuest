 <?php echo $header; ?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $lang->language["edit"];  ?> <?php echo $lang->language["hotels"];  ?>
            
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()."hotel"; ?>">Hotels</a></li>
            <li class="active"><?php echo $lang->language["edit"];  ?></li>
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
                <form role="form" action="<?php echo base_url()."hotel/update" ?>" method="post" enctype="multipart/form-data" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_name"];  ?></label>
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $hotel[0]['hotelname']; ?>">
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_description"];  ?></label>
                       <textarea id="editor1" name="description" rows="10" cols="80"><?php echo $hotel[0]['hoteldescription']; ?></textarea>
                    
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_image"];  ?></label>
                      <input type="file" id="image1" name="image1">
                     
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_latitude"];  ?></label>
                      <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $hotel[0]['hotellatitude']; ?>">
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["hotel_longitude"];  ?></label>
                      <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $hotel[0]['hotellongitude']; ?>">
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="hidden" name="hotelid" value="<?php echo $hotel[0]['hotelid']; ?>" >
                      <input type="hidden" name="oldimage1" value="<?php echo $hotel[0]['hotelimage']; ?>" >
                      <input type="submit" class="btn btn-primary" value="<?php echo $lang->language["update"];  ?>">
                      <a class="btn btn-default" href="<?php echo base_url('hotel'); ?>"><?php echo $lang->language['cancel']; ?></a>
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
        function checkcat(str)
        {var field1 = '';
            if(trim(str) == "")
            {
                $("#error_data").show();
                $("#error_data").html("Category name is required");
                return false;
            }
            else
            {
                
                $.ajax({
                    url:"<?php echo base_url()."category/checkavaliblity" ?>",
                    type:"post",
                    data:{catname:str},
                    async: false,
                    success:function(data)
                    {
                        if(data=='1')
                        {// alert("aaa");
                            $("#error_data").show();
                            $("#error_data").html("Category name already inserted");
                            field1 = false;
                            return false;
                        }
                        else if(data== '0' )
                        {
                         //   alert("bbb");
                            field1 = true;
                            //alert(field1);

                        }
                      
                    }
                });
             return field1;
                
            }
        }
        
        // check image 
        function checkimage(str)
        {
            var field1 = '';
            if(str == "")
            {
                $("#error_data").show();
                $("#error_data").html("Please select image1");
                field1 = false; 
            }
            else
            {
                if (window.File && window.FileReader && window.FileList && window.Blob)
                {
                    //get the file size and file type from file input field
                    var fsize = $('#image1')[0].files[0].size;
                    var ftype = $('#image1')[0].files[0].type;
                    var sizeInMB = (fsize / (1024*1024)).toFixed(2);
                    var fname = $('#image1')[0].files[0].name;
                    if(sizeInMB>3) //do something if file size more than 1 mb (1048576)
                    {
                        $("#error_data").show();
                        $("#error_data").html("Select file less then 3Mb.");
                        field1 = false; 
                    }
                    else
                    {
                       var valid_extensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;
                       if(valid_extensions.test(str))
                       {
                           $("#error_data").hide();
                           field1 = true;
                       }
                       else
                       {
                            $("#error_data").show();
                            $("#error_data").html("Invalid image type.");
                            field1 = false;
                       }
                    }
                    
		}
		else
		{
                    alert("Please upgrade your browser, because your current browser lacks some new features we need!");
		}
            }
            return field1;
        }
        
       
        
        
        function checkalldata()
        {
            var field = false;
            var image1 = $("#image1").val();
            var catname = $("#catname1").val();
            if(trim(catname) == "")
            {
                $("#error_data").show();
                $("#error_data").html("Category name is required");
                return false;
            }
            else
            {
                if(checkcat(catname) == true)
                {
                    field = true;
                }
                else
                {
                    $("#error_data").show();
                    $("#error_data").html("Category name already inserted");
                    field = false;
                }
            }
            
            if(checkimage(image1) == false)
            {
                $("#error_data").show();
                $("#error_data").html("Invalid Image type.");
                return false;
            }
            if(field == false)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
     $(document).ready(function() {	
     $(".onlyno").on("keypress keyup blur",function (event) {
      if(event.which == 8 || event.which == 0){
        return true;
    }
    if(event.which < 46 || event.which > 59) {
        return false;
        //event.preventDefault();
    } // prevent if not number/dot
    if(event.which == 47) {
         event.preventDefault();
        return false;
        //event.preventDefault();
    } 
    
    if(event.which == 46 && $(this).val().indexOf('.') != -1) {
        return false;
        //event.preventDefault();
    } // prevent if already dot
});});   
    </script>
    