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
            <h1><?php echo $lang->language['feedback']; ?></h1>
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> <?php echo $lang->language['home']; ?></a></li>
            <li class="active"><?php echo $lang->language['feedback']; ?></li>
          </ol>
           
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                
                <div class="box-body">
                 
                 <?php if(count($feedbacks)>0){ ?>
                    <table id="example2" class="table table-bordered table-hover col-xs-12">
                    <thead>
                      <tr>
                        <th><?php echo $lang->language["username"];  ?></th>
                        <th><?php echo $lang->language["roomno"];  ?></th>
                        <th><?php echo $lang->language["property_rate"];  ?></th>
                        <th><?php echo $lang->language["property_review"];  ?></th>
                        <th><?php echo $lang->language["app_rate"];  ?></th>
                        <th><?php echo $lang->language["app_review"];  ?></th>
                        <th><?php echo $lang->language["trip_type"];  ?></th>
                        <th><?php echo $lang->language["service_rate"];  ?></th>
                        <th><?php echo $lang->language["cleaniness_rate"];  ?></th>
                        <th><?php echo $lang->language["value_rate"];  ?></th>
                        <th><?php echo $lang->language["location_rate"];  ?></th>
                        <th><?php echo $lang->language["sleep_rate"];  ?></th>
                        <th><?php echo $lang->language["room_rate"];  ?></th>
                        <th><?php echo $lang->language["travel_month"];  ?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0;$i<count($feedbacks);$i++) { ?>
                      <tr>
                        <td><?php echo $feedbacks[$i]['userfirstname']; ?></td>
                        <td><?php echo $feedbacks[$i]['roomno']; ?></td>
                        <td><?php echo $feedbacks[$i]['propertyrate']; ?></td>
                        <td><?php echo $feedbacks[$i]['propertyreview']; ?></td>
                        <td><?php echo $feedbacks[$i]['apprate']; ?></td>
                        <td><?php echo $feedbacks[$i]['appreview']; ?></td>
                        <td><?php echo $feedbacks[$i]['triptype']; ?></td>
                        <td><?php echo $feedbacks[$i]['servicerate']; ?></td>
                        <td><?php echo $feedbacks[$i]['cleaninessrate']; ?></td>
                        <td><?php echo $feedbacks[$i]['valuerate']; ?></td>
                        <td><?php echo $feedbacks[$i]['locationrate']; ?></td>
                        <td><?php echo $feedbacks[$i]['sleeprate']; ?></td>
                        <td><?php echo $feedbacks[$i]['roomrate']; ?></td>
                        <td><?php echo date('M Y',  strtotime($feedbacks[$i]['travelmonth'])); ?></td>                   
                        
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


    
    
    
  