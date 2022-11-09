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
        <h1><?php echo $lang->language['user_checkin_history']; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> <?php echo $lang->language['home']; ?></a></li>
            <li class="active"><?php echo $lang->language['user_checkin_history']; ?></li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                        <?php if (count($checkinhistorys) > 0) { ?>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang->language["userfirstname"]; ?></th>
                                        <th><?php echo $lang->language["hotel_name"]; ?></th>
                                        <th><?php echo $lang->language["roomno"]; ?></th>
                                        <th><?php echo $lang->language["requestdatetime"]; ?></th>
                                        <th><?php echo $lang->language["status"]; ?></th>
                                        <th><?php echo $lang->language["action"]; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i < count($checkinhistorys); $i++) { ?>
                                        <tr>
                                            <td><?php echo $checkinhistorys[$i]['userfirstname']; ?></td>
                                            <td><?php echo $checkinhistorys[$i]['hotelname']; ?></td>
                                            <td><?php echo $checkinhistorys[$i]['roomno']; ?></td>
                                            <td><?php echo $checkinhistorys[$i]['requestdatetime']; ?></td>
                                            <td><?php echo $checkinhistorys[$i]['status']; ?></td>
                                            <td>
                                                <?php if($checkinhistorys[$i]['status'] =='checkin' ){ ?>
                                                <a class="btn btn-primary" onclick="changestatus('<?php echo $checkinhistorys[$i]['checkinid']; ?>')" id="cur_<?php echo $checkinhistorys[$i]['checkinid']; ?>">
                                                    <?php echo $checkinhistorys[$i]['status']; ?>
                                                </a>
                                                <?php } else { ?>
                                                <a class="btn btn-primary">
                                                <?php echo $checkinhistorys[$i]['status']; ?>
                                                </a>
                                                <?php } ?>
                                            </td>

                                        </tr>

                                    <?php } ?>
                                </tbody>

                            </table>
                            <?php
                        } else {
                            echo 'No record found.';
                        }
                        ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->


            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>    
<script type="text/javascript">
    $(document).ready(function () {
        $('#mymodel').trigger('click');
    });

    function changestatus(str)
    {
        if (str != "")
        {
            var curr_status = $("#cur_" + str).text();
            // alert(curr_status);
            $('#changestatusmodel').trigger('click');
            //$("#status_request").val(curr_status);
            $("#requestid").val(str);
            // $("#MyChangeStatus").model('show');
        }
    }



</script>
<button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="changestatusmodel" title="Create" data-toggle="modal" data-target="#MyChangeStatus" style="display: none;">Create</button>
<div class="modal msg_pop fade" id="MyChangeStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close cls_icn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <div class="modal-body">
                <h3>Change Status</h3>
                <div class="col-lg-12 col-md-12 col-sm-12 padng_rmv pop_tglinr">
                    <p id="error_div" class="alert alert-danger" style="display: none;"></p>
                    <form  role="form" method="post" action="<?php echo base_url() . "checkinhistory/changestatus" ?>" onsubmit="return checkalldata()" >
                        <div class="form-group">
                            <label for=""><?php echo $lang->language["status"]; ?></label>
                            <select name="status" id="status_request" class="form-control" onchange="checkroomno(this.value)">
                                <option value="checkout">Check-out</option>
                            </select>
                            <input type="hidden" name="requestid" id="requestid"> 
                        </div>
                        <div class="modal-footer tp_mrgn2">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer tp_mrgn2">
                <button type="button" class="btn btn-primary col-lg-2" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php if ($this->session->flashdata('success')) {
    ?>
    <button type="button" class="btn btn-primary col-lg-3 mrgn-right1" id="mymodel" title="Create" data-toggle="modal" data-target="#myModal" style="display: none;">Create</button>
    <div class="modal msg_pop fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close cls_icn" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
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

<?php if ($this->session->flashdata('error')) {
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







