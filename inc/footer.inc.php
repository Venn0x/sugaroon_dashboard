			<div class="clearfix"></div>
        <?php if(Config::isLogged()){ ?>
			<footer class="footer hidden-xs-down" style="text-align: right;">

                <p><small>© 2020 Suragoon</p>

            </footer>

            

			</section>

		</main>	

        <?php } ?>

		<!-- END WRAPPER -->

		<!-- Javascript -->

		<script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jquery/dist/jquery.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/popper.js/dist/umd/popper.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jquery-scrollLock/jquery-scrollLock.min.js"></script>



        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/salvattore/dist/salvattore.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/flot/jquery.flot.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/flot/jquery.flot.resize.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/flot.curvedlines/curvedLines.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jqvmap/dist/jquery.vmap.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jqvmap/dist/maps/jquery.vmap.world.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/peity/jquery.peity.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/moment/min/moment.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/vendor/fullcalendar/dist/fullcalendar.min.js"></script>



        <!-- Charts and maps-->

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/flot-charts/curved-line.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/flot-charts/line.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/flot-charts/chart-tooltips.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/other-charts.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/jqvmap.js"></script>

		

		<script src="<?php echo Config::$_PAGE_URL; ?>assets/js/map.min.js"></script>

        <!-- App functions and actions -->

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/bootbox.min.js"></script>

        <script src="<?php echo Config::$_PAGE_URL ;?>assets/js/app.min.js"></script>

		

	<div style="left: -1000px; overflow: scroll; position: absolute; top: -1000px; border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"><div style="border: none; box-sizing: content-box; height: 200px; margin: 0px; padding: 0px; width: 200px;"></div></div></body>

</html>


<?php

ob_flush();

?>