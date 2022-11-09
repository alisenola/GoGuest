<?php echo $header; ?>
<style type="text/css">
    .table th a {
        //color:#FFF;
    }
</style>
<!-- Content Wrapper. Contains hotel content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $lang->language['user_checkin_request']; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $lang->language['user_checkin_request']; ?></li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                                
                                 <?php if (count($chekingrequest) > 0) { ?>
<input type="hidden" name="last_id" id="last_id" value="<?php echo $chekingrequest[0]['checkinid'] ?>" >
                                 <?php } else { ?>
<input type="hidden" name="last_id" id="last_id" value="0" >
                                 <?php } ?>

                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $lang->language['username']; ?></th>
                                    <th><?php echo $lang->language['hotel_name']; ?></th>
                                    <th><?php echo $lang->language['request_date']; ?></th>
                                    <th><?php echo $lang->language['status']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($chekingrequest) > 0) { ?>
                                
                                <?php for ($i = 0; $i < count($chekingrequest); $i++) { ?>                                
                                    <tr>
                                        <td><?php echo $chekingrequest[$i]['userfirstname']; ?></td>
                                        <td><?php echo $chekingrequest[$i]['hotelname']; ?></td>
                                        <td><?php echo date("F m Y h:i:s", strtotime($chekingrequest[$i]['requestdatetime'])); ?></td>
                                        <td>
                                            <a class="btn btn-primary" onclick="changestatus('<?php echo $chekingrequest[$i]['checkinid']; ?>')" id="cur_<?php echo $chekingrequest[$i]['checkinid']; ?>">
                                                <?php echo $chekingrequest[$i]['status']; ?>
                                            </a>
                                        </td>

                                    </tr>

                                <?php } ?>
                            <?php } else { ?>

                                <tr>
                                    <td colspan="4">No record found.</td>                                            

                                </tr>
                            <?php } ?>
                            </tbody>

                        </table>

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

    function checkroomno(str)
    {
        if (str == "checkin")
        {
            $("#roomdiv").show();
        }
        else
        {
            $("#roomdiv").hide();
        }
    }

    function checkalldata()
    {
        var roomno = $("#roomno").val();
        var status_request = $("#status_request").val();
        if (status_request == "checkin")
        {
            
        if (roomno == "")
        {
            $("#error_div").show();
            $("#error_div").html('Enter Proper Data.');
            return false;
        }
        if (status_request == "")
        {
            $("#error_div").show();
            $("#error_div").html('Enter Proper Data.');
            return false;
        }
        }
        else
        {
            //$("#roomdiv").hide();
        }
    }
    var ajax_call = function () {
        var last_id = $("#last_id").val();
        $.ajax({
            url: '<?php echo base_url('userchecking/newrequest') ?>',
            data: {last_id: last_id},
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (data.html != '')
                {
                    if (last_id == 0)
                    {
                        $('#myTable tbody').empty();
                    }
                    $("#last_id").val(data.id);
                    $('#myTable tbody').append(data.html);
                }
            }
        });
        //alert(last_id);
    };

   // var interval = 1000 * 60 * 0.12; // where X is your every X minutes
    var interval = 5000; // where X is your every X minutes

    setInterval(ajax_call, interval);
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
                    <form  role="form" method="post" action="<?php echo base_url() . "userchecking/changestatus" ?>" onsubmit="return checkalldata()" >
                        <div class="form-group">
                            <label for=""><?php echo $lang->language["status"]; ?></label>
                            <select name="status" id="status_request" class="form-control" onchange="checkroomno(this.value)">
                                <option value="reject">Reject</option>
                                <option value="checkin">Check-in</option>
                            </select>
                        </div>
                        <div class="form-group" id="roomdiv" style="display: none;">
                            <label for=""><?php echo $lang->language["roomno"]; ?></label>
                            <input type="text" name="roomno" id="roomno" >
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





