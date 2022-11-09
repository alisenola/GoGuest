<?php echo $header; ?>
<style>
    label{float: left !important}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $lang->language["hotel_user_add"]; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() . "hoteladmin"; ?>"><?php echo $lang->language["hotel_user"]; ?></a></li>
            <li class="active"><?php echo $lang->language["add"]; ?></li>
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
                    <form role="form" action="<?php echo base_url() . "hoteladmin/update" ?>" method="post" enctype="multipart/form-data" onsubmit="return checkalldata();" >
                        <div class="box-body">
                            <div class="alert alert-danger" id="error_div" style="display: none;"></div>
                            <div class="form-group">
                                <label for=""><?php echo $lang->language["hotel_user_type"]; ?></label>
                                <select class="form-control" name="type" id="type" onchange="showcat()">
                                    <option value="admin"><?php echo $lang->language["hotel_user_type_admin"]; ?></option>
                                    <option value="manager"><?php echo $lang->language["hotel_user_type_manager"]; ?></option>

                                </select>                                

                            </div>
                            <div class="form-group" id="categoryuniqiddiv" style="display: none">
                                <label for=""><?php echo $lang->language["hotel_name"]; ?></label>
                                <?php if (count($category) > 0) { ?>
                                    <select class="form-control" name="categoryuniqid" id="categoryuniqid">
                                        <?php for ($i = 0; $i < count($category); $i++) {
                                            ?>
                                            <option value="<?php echo $category[$i]['categoryuniqid']; ?>"><?php echo $category[$i]['categoryname']; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                <?php
                                } else {
                                    echo 'Please first enter hotel';
                                }
                                ?>

                            </div>

                            <div class="form-group">
                                <label for=""><?php echo $lang->language["hotel_user_name"]; ?></label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for=""><?php echo $lang->language["hotel_email"]; ?></label>
                                <input type="text" class="form-control" id="hotelemail" name="hotelemail">
                            </div>
                            <div class="form-group">
                                <label for=""><?php echo $lang->language["hotel_password"]; ?></label>
                                <input type="password" class="form-control" id="hotelpassword" name="hotelpassword">
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><?php echo $lang->language["submit"]; ?></button>
                        </div>
                    </form>
                </div><!-- /.box -->



            </div><!--/.col (left) -->

        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php echo $footer; ?>  

<script type="text/javascript">
    function showcat()
    {
        var type = $("#type").val();
        if (type == 'manager')
        {
            $("#categoryuniqiddiv").show();
        }
        else
        {
            $("#categoryuniqiddiv").hide();
        }
    }
    function checkalldata()
    {
        var hotelemail = $("#hotelemail").val();
        var hotelpassword = $("#hotelpassword").val();
        var email_validation = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        ;
        if (hotelemail == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_email"] . ' ' . $lang->language["required"] ?>');
            return false;
        }
        if (!email_validation.test(hotelemail))
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["email_validation"]; ?>');
            return false;
        }
        if (hotelpassword == "")
        {
            $("#error_div").show();
            $("#error_div").html('<?php echo $lang->language["hotel_password"] . ' ' . $lang->language["required"] ?>');
            return false;
        }

    }

</script>

