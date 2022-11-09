<?php echo $header;?><?php echo $left_menu;?>

<section class="content-header">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
        <li><a href="<?php echo site_url('mailformat');?>">Mail-format</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>
        <section class="content">
      <h1>Mail format</h1>
      <!-- Small boxes (Stat box) -->
      <div class="row">            
        <div class="col-lg-12 col-md-12 col-sm-12"> 
          <!-- small box -->
          <div class="box">
          	<div class="box-inner">
            	<div class="row">	
                	<div class="col-lg-8 col-md-8 col-sm-8">
                            <p class="text-info">All <span class="text-maroon"> (*) </span> fields are text-maroon.</p>
                            <p class="alert alert-danger error" style="display: none" id="error" ></p>
                            <form class="form-horizontal"  id="frmuser" action="<?php echo base_url('mailformat/update'); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                <label class="col-sm-4 control-label padng_rgtrmv">Title<span class="text-maroon"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control"  name="title" id="title" maxlength="100" value="<?php echo $mailformat[0]['vartitle'];?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label padng_rgtrmv">Subject<span class="text-maroon"> *</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control  " placeholder="" name="subject" id="subject" maxlength="50" value="<?php echo $mailformat[0]['varsubject']; ?>">
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="col-sm-4 control-label padng_rgtrmv">Variables</label>
                            <div  class="col-sm-8 pull-right alert-info"> 
                                <span style="font-weight:bold;">
                                    You can use following variables in your mail which will be replaced with its actual value in mail.
                                </span><br>
                                
                                <p><span class="text-info" ><?php     echo nl2br(stripslashes($mailformat[0]['variables'])); 
                          ?></span></p>
                              </div>
                            </div>
                                <div class="form-group">
        <label class="col-sm-4 control-label padng_rgtrmv">Mail Format<span class="text-maroon"> *</span></label>
        <div class="col-sm-12 padng_rgtrmv">
        <textarea class="input-xlarge cleditor" name="mailformat" id="mailformat">
        <?php echo $mailformat[0]['varmailformat'];?>
        </textarea>
        <input type="hidden" value="<?php echo base64_encode($mailformat[0]['emailid']);?>" name="intid">
		<?php echo display_ckeditor($ckeditor);?> </div>
                           <div class="form-group">
                            <label  class="col-sm-4 control-label padng_rgtrmv"> </label>
                            <div class="col-sm-8">
                              <button type="submit" class="btn btn-primary" name="btnsubmit" id="btnsubmit">Update</button>
                              <input type="hidden" name="btnsubmit" value="btnsubmit" />
                              <a href="<?php echo site_url('mailformat'); ?>"><button type="button" title="Cancel" class="btn btn-blck">Cancel</button></a>
                            </div>
                          </div>
                                 <input type="hidden" value="<?php echo $this->encrypt->encode($mailformat[0]['emailid']);?>" name="intid" id="intid">
                        </form>
                 </div>
                </div>
              </div>  
          </div>
        </div>
      </div>
    </section>
    <!-- /.content --> 
  </aside>
  <!-- /.right-side --> 
</div>
<?php echo $footer; ?>
<script type="text/javascript" language="javascript">
	function trim(stringToTrim) {
		return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	$(document).ready(function() {		
		$(".spanerror").hide();
		$("#btnsubmit").click(function () {
			
			if( trim($("#title").val()) == "" )
			{
				$(".error").show();
                
                                $(".error").html('Title is requierd');
				$("#title").val('').focus();
				return false;
			}
			else
			{
				$(".error").html('');
                                $(".error").hide();
			}
			
			if( trim($("#subject").val()) == "" )
			{
				$(".error").show();
                
                                $(".error").html('Subject is requierd');
				$("#subject").val('').focus();
				return false;
			}
			else
			{
				$(".error").html('');
                                $(".error").hide();
			}
			
		});
	});
</script>