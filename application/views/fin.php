	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/es.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jasny-bootstrap.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/jquery.table2excel.js"></script>

	<script>
		$(function () {
                $('#datetimepicker1').datetimepicker({
                    locale: 'es',
                    format: 'YYYY-MM-DD'
                });

                $('#datetimepicker2').datetimepicker({
                    locale: 'es',
                    format: 'YYYY-MM-DD'
                });

                $('#datetimepicker3').datetimepicker({
                    locale: 'es',
                    format: 'LT'
                });

                $('#datetimepicker4').datetimepicker({
                    locale: 'es',
                    format: 'YYYY-MM-DD'
                });
        });
	</script>
</body>	
</html>