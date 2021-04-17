<?
if(!isset($_SESSION['journal']['from_date'])){ $_SESSION['journal']['from_date'] = date("Y-m-1"); }
if(!isset($_SESSION['journal']['to_date'])){ $_SESSION['journal']['to_date'] = date("Y-m-t"); }
if($_REQUEST['staff_id']!=""){ $_SESSION['journal']['staff_id'] = $_REQUEST['staff_id']; }
 
  $_SESSION['journal']['stafftype']  = $_GET['stafftype'];
 
$stafftype = $_GET['stafftype'];

?>

<div class="nav_form_main">
    <ul class="dispatch_top_ul dispatch_top_ul2 dispatch5">
        <li>
            
            <label>From Date</label>
            <input class="date_class" type="text" name="from_date" id="from_date" value="<?php echo $_SESSION['journal']['from_date']?>" onChange="javascript:refresh_journal_report('from_date');">
        </li>
        <li>
            
            <label>To Date</label>
            <input class="date_class" type="text" name="to_date" id="to_date" value="<?php echo $_SESSION['journal']['to_date']?>" onChange="javascript:refresh_journal_report('to_date');">
        </li>   
        
      <!--  <li>
            
            <label>Lead Type</label>
            <span><?php echo create_dd("stafftype","system_dd","id","name","type =157","onchange=\"javascript:refresh_journal_report('stafftype');\"", $_SESSION['journal']);?></span>
        </li>   -->
        
    </ul>
	<div class="right_staff_box">
      <input onclick="javascript:window.location='/admin/index.php?task=7&amp;action=add';" type="button" class="staff_button" value="+&nbsp;Journal">
      <input onclick="javascript:scrollWindow('email_journal.php?emailtype=1&stafftype=2&staff_id=<?php echo $_SESSION['journal']['staff_id'];?>','1200','850')" type="button" class="staff_button" value="&nbsp;BCIC Email">
      <input onclick="javascript:scrollWindow('email_journal.php?emailtype=2&stafftype=2&staff_id=<?php echo $_SESSION['journal']['staff_id'];?>','1200','850')" type="button" class="staff_button" value="&nbsp;BBC Email">
    </div>	
</div>

<style>

 .staff_button{
     margin-left: 10px;
 }
</style>


<br>
<div id="journal_view">
	
  <? include("xjax/view_journal_new.php"); ?>
</div>
