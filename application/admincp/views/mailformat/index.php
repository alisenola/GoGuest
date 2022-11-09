<?php echo $header;?><?php echo $left_menu;?>
<style type="text/css">
.table th a {
	color:#FFF;
	}
</style>

<section class="content-header">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
        <li class="active">Mailformat</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <h1>Mailformat </h1>
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12"> 
          <!-- small box -->
          <div class="box">
            <div class="box-inner">
              <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
              <?php if(count($mailformat) > 0) { ?>
                <table class="table table-hover dataTable responsive" id="" aria-describedby="example2_info">
                  <thead>
                    <tr role="row">
                        <th>
                            <a href="<?php echo ( $this->uri->segment(3) == 'uniquename' && $this->uri->segment(4) == 'ASC') ? site_url('mailformat/sort/uniquename/DESC') : site_url('mailformat/sort/uniquename/ASC');?>" title="">Unique Name 
                        </a>
                        <?php echo ( $this->uri->segment(3) == 'uniquename' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'uniquename' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' );?> 
                             </th>
                        <th> 
                            <a href="<?php echo ( $this->uri->segment(3) == 'vartitle' && $this->uri->segment(4) == 'ASC') ? site_url('mailformat/sort/vartitle/DESC') : site_url('mailformat/sort/vartitle/ASC');?>" title="">Title
                        </a>
                        <?php echo ( $this->uri->segment(3) == 'vartitle' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'vartitle' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' );?> 
                             </th>
                        <th> 
                        <a href="<?php echo ( $this->uri->segment(3) == 'varsubject' && $this->uri->segment(4) == 'ASC') ? site_url('mailformat/sort/varsubject/DESC') : site_url('mailformat/sort/varsubject/ASC');?>" title="">Subject 
                        </a>
                        <?php echo ( $this->uri->segment(3) == 'varsubject' && $this->uri->segment(4) == 'ASC' ) ? '<i class="glyphicon glyphicon-arrow-up">' : (( $this->uri->segment(3) == 'varsubject' && $this->uri->segment(4) == 'DESC' ) ? '<i class="glyphicon glyphicon-arrow-down">' : '' );?> 
                        </th>
                        <th>Action</th>
                    </tr>
                  </thead>
                   			   			     		
                   <tbody role="alert" aria-live="polite" aria-relevant="all">
                     <?php for($i=0;$i<count($mailformat);$i++){?>
        <tr>
            <td><?php echo $mailformat[$i]['uniquename']; ?></td>
            <td><?php echo $mailformat[$i]['vartitle']; ?></td>
            <td><?php echo $mailformat[$i]['varsubject']; ?></td>
            
            <td class="  ">                
                <button title="" onclick="window.location.href='<?php echo site_url('mailformat/edit/'.base64_encode($mailformat[$i]['emailid']));?>'" data-placement="bottom" data-toggle="tooltip" class="btn btn-primary" data-original-title="Edit">
                    <i class="glyphicon glyphicon-edit"></i></button>
            </td>
        </tr>
        <?php } ?>  
                    
                  </tbody>
                </table>
                 <!-- /pagination -->
		  <?php  if($this->pagination->create_links()) { ?>
          <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
          <?php } ?>
          <!-- /pagination -->
            <?php } else { echo "No data found";} ?>
              </div>
              </div>
          </div>
        </div>
      </div>
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
    </section>
<?php echo $footer;?>
<script type="text/javascript">
    
        	$(document).ready(function(){
  $('#mymodel').trigger('click');
	});
               </script>