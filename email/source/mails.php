<?php
//#Email Reader Class
use \Bcic\Outlook\Email\Sys;
?>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css"/>
<link rel="stylesheet" href="../mail/css/bootsnipp.min.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<style>
 .parentDisable {
    opacity: 0.8;
    display: block;
}
</style>	

<script>
    $(document).ready(function(){
      var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');
    });			
</script>
  
<div id="quote_view">
	<? 
	if(isset($_GET['action'])){ $_SESSION['email_action'] = mres($_GET['action']); }
	if(isset($_GET['type'])){ $_SESSION['email_type'] = mres($_GET['type']); }
	include("xjax/bcic_email.php"); ?>
</div>

<div id="myModal" class="modal">

</div>
