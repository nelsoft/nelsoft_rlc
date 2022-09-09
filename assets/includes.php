<?php
    $ci = &get_instance();      
    $ci->config->set_item('base_url',"http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/") ;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?=base_url()?>assets/JavaScript/js/jquery-1.8.0.min.js" ></script>
<script src="<?=base_url()?>assets/JavaScript/js/jquery-ui-1.8.23.custom.min.js" ></script>
<script src="<?=base_url()?>assets/JavaScript/js/my_js_lib_1.9.js" ></script>
<script src="<?=base_url()?>assets/JavaScript/js/my_js_tbl_1.1.js" ></script>
<script src="<?=base_url()?>assets/JavaScript/js/my_js_tblpaging.js" ></script>
<script src="<?=base_url()?>assets/JavaScript/js/popup.js" ></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/chosen/chosen.css"/>
<script type="text/javascript" src="assets/chosen/chosen.jquery.js"></script>
<!-- <script type="text/javascript" src="assets/JavaScript/js/jquery-1.8.0.min.js"></script>
 --><!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
<link rel="stylesheet" href="<?=base_url()?>/assets/css/style.css" />
<link rel="stylesheet" href="<?=base_url()?>/assets/css/font-awesome.css" />

<?php	

	require_once("assets/JavaScript/base_js.php");
    // require_once("assets/javascript/keypressval_js.php");

?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css" />

<?php
	$header = 'assets/template/header.php';
	$headerwide = 'assets/template/header_wide.php';
	$footer = 'assets/template/footer.php';
?>