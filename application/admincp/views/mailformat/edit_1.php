<?php echo $header;?><?php echo $top_menu;?><?php echo $left_menu;?>

<div class="content">
<div class="header">
<h1 class="page-title">Door Bell</h1>
</div>
<ul class="breadcrumb">
  <li><a href="<?php echo site_url('dashboard');?>">Dashboard</a> <span class="divider">/</span></li>
  <li><a href="<?php echo site_url('mailformat');?>">Mail-format</a> <span class="divider">/</span></li>
  <li>Edit</li>
</ul>
<script type="text/javascript" language="javascript">
	function trim(stringToTrim) {
		return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	$(document).ready(function() {		
		$(".spanerror").hide();
		$("#btnupdate").click(function () {
			
			if( trim($("#title").val()) == "" )
			{
				$("#titleerror").show();
				$("#subjecterror").hide();
				$("#title").val('').focus();
				return false;
			}
			else
			{
				$("#titleerror").hide();
				$("#subjecterror").hide();
			}
			
			if( trim($("#subject").val()) == "" )
			{
				$("#titleerror").hide();
				$("#subjecterror").show();
				$("#subject").val('').focus();
				return false;
			}
			else
			{
				$("#titleerror").hide();
				$("#subjecterror").hide();
			}
						
			if( $("#frmemail").submit() )
			{
				$("#error").attr('style','display:none;');
			}
		});
	});
</script>
<div class="container-fluid">

<div class="row-fluid">
  <div class="alert alert-error spanerror" id="titleerror">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Enter title</strong> </div>
</div>

<div class="row-fluid">
  <div class="alert alert-error spanerror" id="subjecterror">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Enter subject</strong> </div>
</div>z
<div class="row-fluid">


</div>
     <?php echo form_open('doorbell/update'); ?>
<!--<form id="frmemail" action="email/update" method="post">-->
 
  <div class="well">
    <div id="myTabContent" class="tab-content">
      
      <div class="tab-pane active in" id="home">
        <label>Title<span class="required"> *</span></label>
        <input type="text" value="<?php echo ($mailformat[0]['title']);?>" class="input-xlarge" name="title" id="title">
      </div>
      <div class="tab-pane active in" id="home">
        <label>Subject<span class="required"> *</span></label>
        <input type="text" class="input-xlarge" name="subject" id="subject" value="<?php echo ($mailformat[0]['subject']);?>">
        
      </div>
      <div class="tab-pane active in" id="home">
        <label>Variables</label>
        <div class="con" style="color:#CD0B1C; background:#E3E3E3; width:80%"> <span style="font-weight:bold;">You can use following variables in your mail which will be replaced with its actual value in mail.</span><br />
            <br />
            <p><span><?php     echo nl2br(stripslashes($mailformat[0]['variables'])); 
                          ?></span></p>
          </div>
        </div>
      
      <div class="tab-pane active in" id="home">
        <label>Mail Format<span class="required"> *</span></label>
        <textarea class="input-xlarge cleditor" name="mailformat" id="mailformat">
        <?php echo $mailformat[0]['mailformat'];?>
        </textarea>
        <input type="hidden" value="<?php echo base64_encode($mailformat[0]['id']);?>" name="intid">
		<?php echo display_ckeditor($ckeditor);?> </div>
        </div>
  </div>
        <div class="btn-toolbar">
                        <button class="btn btn-primary" name="btnsubmit" id="btnsubmit" type="submit"><i class="icon-save"></i> Update</button>
                        <input type="hidden" name="btnsubmit" value="btnsubmit" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo site_url('doorbell'); ?>" class="btn" style="margin-left:10px;">Cancel</a>
                        <div class="btn-group"> </div>
            </div>
      <script>

function scrollWin()
{
window.scrollTo(0,-1000);
}
</script>
      <a style="float: right; line-height: 1.25em; display: inline-block; padding: .75em 0em;cursor:pointer;" onclick="scrollWin();"><i class="icon-circle-arrow-up"></i> Top</a>
    
  
<?php echo form_close();?>
<!--</form>-->
 
<?php echo $footer;?>