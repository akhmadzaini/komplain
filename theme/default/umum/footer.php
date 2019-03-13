<footer class="main-footer">
	<div class="pull-right hidden-xs">
	  <b>Version</b> 2.4.0
	</div>
	<strong>Copyright © 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
	reserved.
</footer>

</div>

<script src="<?=base_url()?>/theme/default/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>/theme/default/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>/theme/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>/theme/default/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?=base_url()?>/theme/default/dist/js/adminlte.min.js"></script>

<?php
if(!empty($add_views)){
  foreach ($add_views as $v) {
    $this->load->view($v);
  }
}
?>

</body>
</html>
