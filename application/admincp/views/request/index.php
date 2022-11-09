<?php echo $header; ?>
<style type="text/css">
.table th a {
	color:#FFF;
	}
</style>
<!-- Content Wrapper. Contains hotel content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php echo $lang->language['request']; ?></h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> <?php echo $lang->language['home']; ?></a></li>
            <li class="active"><?php echo $lang->language['request']; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                  
                <div class="box-body">
               
                 <?php if(count($requests)>0){ ?>
                    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><?php echo $lang->language["hotel_name"];  ?></th>
                        <th><?php echo $lang->language["category_name"];  ?></th>
                        <th><?php echo $lang->language["request_description"];  ?></th>
                        <th><?php echo $lang->language["status"];  ?></th>
                        
                      </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0;$i<count($requests);$i++) { ?>
                      <tr>
                        <td><?php echo $requests[$i]['hotelname']; ?></td>
                        <td><?php echo $requests[$i]['categoryname']; ?></td>
                        <td><?php echo $requests[$i]['requestdescription']; ?></td>
                        <td><?php echo $requests[$i]['status']; ?></td>
                       
                        
                      </tr>
              
                        <?php } ?>
                    </tbody>
                   
                  </table>
                 <?php } else { echo 'No record found.';} ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

           
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    
    
    
   <?php echo $footer; ?>    
   <script type="text/javascript">
	$(document).ready(function(){
  $('#mymodel').trigger('click');
	});
</script>

	<!-- Correct form message -->
<?php if( $this->session->flashdata('hotel_success') ) { 
?>
<button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
<div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="modal-body">
                <h3>New hotel <b><?php echo $this->session->flashdata('crete_hotel'); ?></b> had been created!</h3>
                    <div class="col-lg-12 col-md-12 col-sm-12 padng_rmv pop_tglinr">
                        <h6>An email has been sent to the hotel for the first time login step!</h6>
                        <span><?php echo $this->session->flashdata('create_hotel_email'); ?></span>
                    </div>
            </div>
            <div class="modal-footer tp_mrgn2">
                <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
            </div>
    </div>
  </div>
 </div>
<?php } ?>

<?php if( $this->session->flashdata('success') ) { 
?>
<button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
<div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="modal-body">
                 <div class="col-lg-12 col-md-12 col-sm-12 padng_rmv pop_tglinr">
                      <span><?php echo $this->session->flashdata('success'); ?></span>
                    </div>
            </div>
            <div class="modal-footer tp_mrgn2">
                <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
            </div>
    </div>
  </div>
 </div>
<?php } ?>

<?php if( $this->session->flashdata('error') ) { 
?>
<button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
<div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="modal-body">
                 <div class="col-lg-12 col-md-12 col-sm-12 padng_rmv pop_tglinr">
                      <span><?php echo $this->session->flashdata('error'); ?></span>
                    </div>
            </div>
            <div class="modal-footer tp_mrgn2">
                <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
            </div>
    </div>
  </div>
 </div>
<?php } ?>


    
    
    
  