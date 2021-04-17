<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 ?>
<div id="view_jobs">
<? include("xjax/view_jobs.php"); ?>
</div>


