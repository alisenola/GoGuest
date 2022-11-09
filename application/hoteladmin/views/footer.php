
<footer class="main-footer">
    <!--        <div class="pull-right hidden-xs">
              <b>Version</b> 2.0
            </div>-->
    <strong>Copyright.</strong> All rights reserved.
</footer>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url('plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url('bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('plugins/slimScroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?php echo base_url('plugins/fastclick/fastclick.min.js'); ?>'></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('dist/js/app.min.js'); ?>" type="text/javascript"></script>

<!-- Demo -->
<script src="<?php echo base_url('dist/js/demo.js'); ?>" type="text/javascript"></script>
<?php if(($this->uri->segment(1)!='feedback')){ ?>
<script src="<?php echo base_url('plugins/datatables/jquery.dataTables.min.js'); ?>" type="text/javascript"></script>
<?php } ?>
<script src="<?php echo base_url('plugins/datatables/dataTables.bootstrap.min.js'); ?>" type="text/javascript"></script>




<script type="text/javascript">
    $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": false,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
    $(document).ready()
    {
        var classname = '<?php echo $this->uri->segment(1); ?>';
        if (classname == "")
        {
            classname = 'dashboard';
        }
        $("." + classname).addClass('active');

    }
</script>
</body>
</html>