 <?php echo $header; ?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $lang->language["add"];  ?> <?php echo $lang->language["sub_category"];  ?>
            
          </h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url()."subcategory"; ?>">Sub Category</a></li>
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
                <form role="form" action="<?php echo base_url()."subcategory/update" ?>" method="post" enctype="multipart/form-data" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["category"];  ?></label>
                      <select class="form-control" name="cat_id">
                          <?php for($i=0;$i<count($category);$i++) { ?>
                          <option value="<?php echo $category[$i]['categoryid']; ?>"><?php echo $category[$i]['categoryname']; ?></option>
                        <?php } ?>
                      </select>
                      
                    </div>
                    <div class="form-group">
                      <label for=""><?php echo $lang->language["sub_category"];  ?></label>
                      <input type="text" class="form-control" id="subcat_name" name="subcat_name">
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
    