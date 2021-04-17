<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
<p><a href="/admin/index.php?task=add_team">[ Add Staff ]</a></p>

<?
$data = mysql_query("select * from team where site_id=".mysql_real_escape_string($_SESSION['site_id'])." and status=1 order by id desc limit 0,50");
if (mysql_num_rows($data)>0){ 
?>

<table width="100%" border="0" align="center" cellpadding="6" cellspacing="3" class="table_bg"> 
  <tr class="header_td">
    <td width="5%">Id</td>
    <td width="10%">Name</td>
    <td width="10%">Email</td>
    <td width="10%">Phone</td>
    <td width="10%">Bank</td>
    <td width="10%">BSB</td>
    <td width="10%">Account</td>
    <td width="10%">Status</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <?php 
  while($r=mysql_fetch_assoc($data)){ 
  ?>
  <tr class="table_cells">
    <td><? echo $r['id'];?></td>
    <td><? echo $r['name'];?></td>
    <td><? echo $r['email'];?></td>
    <td><? echo $r['phone'];?></td>
    <td><? echo $r['bank_name'];?></td>
    <td><? echo $r['bsb'];?></td>
    <td><? echo $r['account_number'];?></td>
    <td><? if($r['status']=="1"){ echo "Active"; }else if($r['status']=="2"){ echo "Deactivated"; } ?></td>
    <td><a href="/admin/index.php?task=edit_team&id=<?=$r['id']?>">[Edit]</a> | <a href="javascrpt:send_data('<?=$r['id']?>',1,'quote_view');">[Delete]</a></td>
  </tr>
  <? } ?>

</table>
<? }else{  
	echo "No Records Found";
} 
?>


