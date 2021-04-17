
  <link rel="stylesheet" href="../admin/sales_system/css/bootstrap.min.css">
  <link rel="stylesheet" href="../admin/sales_system/css/style.css">

  
  
   <p id="time" style="font-weight: 600;font-size: 13px;color: #333;position: absolute;top: 114px;z-index: 9;right: 300px;">Current AU Time : <?php echo date('dS M Y H:i:s A');?></p>
<div class="sales_noti">
   <!--<a onclick="showHRNotification11();" class="applic-btn"><i class="fa fa-bell" aria-hidden="true"></i>Show Notification</a>-->

  <a onKeyup="search_task_list(2);"class="serch-but"><input type="text" id="search_val" autocomplete="off" name="serch"></a>

</div>  
<div id="quote_view">
  <div class="main-div-scroll">
  <? 
   
   unset($_SESSION['task_sales']['value']);
   $_SESSION['task_sales']['value'] = '';
  include("xjax/view_sales_system.php"); ?>
</div>

