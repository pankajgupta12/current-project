<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(0);   

ob_start();
session_start(); 
include("../admin/source/functions/functions.php");
include("../admin/source/functions/config.php");
include("../mail/source/functions/bcic_mail_functions.php");

require $_SERVER['DOCUMENT_ROOT'].'/mail/classes/autoload/AutoLoad.php';

      
//require_once('../vendor/autoload.php'); 
  
	
/* 	if(isset($_POST['step'])){ $step=$_POST['step']; }else{ $step=0; }
	$task=rw("task"); $t=$task; 
	$action=rw("action"); $a=$action; */
		
	
if(!isset($_SESSION['admin'])){
	//include("../admin/source/login.php");
	header('Location: ../admin/index.php');
}else{
	$_SESSION['query[txt]']="";
	$_SESSION['query[error]']="";
	
	//echo "sdsdsd"; die;
	
	//include("../admin/source/task.php");    
	
	?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>BCIC ADMIN</title>




<link rel="stylesheet" href="../admin/css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="../admin/css/font-awesome.css" type="text/css">
<link rel="stylesheet" href="../admin/css/general.css"  type="text/css">
<link rel="stylesheet" href="css/mgmt_general.css"  type="text/css">
<link rel="stylesheet" href="css/mail_style.css"  type="text/css">

<link rel="stylesheet" href="../admin/css/style.css" type="text/css"> 

<script type="text/javascript" src="jscripts/base_encode.js"></script>

<!--<script language="JavaScript" src="../admin/jscripts/xjax.js"></script>
<script language="JavaScript" src="../admin/jscripts/funcs.js"></script>-->

<script language="JavaScript" src="jscripts/xjax.js"></script>
<script language="JavaScript" src="jscripts/funcs.js"></script>


<script language="JavaScript" src="jscripts/window.js"></script>
<script language="JavaScript" src="jscripts/validate.js"></script>
<?php echo "<script Language=\"JavaScript\">var sid='".session_id()."'; </script>"; ?>
<script type="text/javascript" src="js/jquery-min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>



				<link href="css/mail_css/css/plugins/iCheck/custom.css" rel="stylesheet" />
				<link href="css/mail_css/css/plugins/summernote/summernote.css" rel="stylesheet"/>
				<link href="css/mail_css/css/plugins/summernote/summernote-bs3.css" rel="stylesheet"/>



				<script src="js/mail_js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
				<script src="js/mail_js/plugins/iCheck/icheck.min.js"></script>
				<script src="js/mail_js/plugins/summernote/summernote.min.js"></script>
				<script>
				$(document).ready(function(){
				   $('.summernote').summernote();
				   
				   //global
				   var startQueue = 0;
				   
				});
				</script>	
<style>
 .note-editor  [class^="icon-"], [class*=" icon-"] {
    font-family: FontAwesome !important;
}
</style> 

</head>
<body class="full_loader">
<div id="loaderimage_1"><img src="../mail/images/loading1.gif"  style="height:150px; width:150px;"/></div>
  
<div class="black_screen" id="notification_refress"></div>
<?php  include("../admin/includes/header.php"); ?>

<?php  

//echo "dssd"; die;
include("source/general.php"); 
?>

<div class="black_screen2"></div>
<div id="notification_div"></div>

<div id="site_notification"></div>
<div id="message_borad_site"></div>

<?php include("../admin/includes/footer.php"); ?>
  
  <script>
	//scrolling script to add email into queue
	$(document).ready(function(){
		$(".tableResponsive").on('scroll' , function(){		
			//console.log('invoked');
		});
		
		$(".tableResponsive").on('scroll' , function(){
			
			console.log('test');
			var ref = $(".tableResponsive");
			clearTimeout($.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
			if( (ref.scrollTop() + ref.height()) > 0.25 * ref[0].scrollHeight )
			{
				//#### Append Next 25 records if are there !
				appendRows();
				
			}
			}, 100));		
		});
		
		//setInterval(()=>{console.log($('table.tableResponsive thead.all-mail-list tr').length);}, 1000);
		
	});
  </script>


</body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
</html>
<?php } ?>
