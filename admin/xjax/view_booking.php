<script language="javascript">

function select_team(objval,booking_id){
	var str = booking_id+"|"+document.getElementById(objval).value;
	//alert(str);
	send_data(str,3,'booking_view');
}

function edit_status(objval,booking_id){
	var str = booking_id+"|"+document.getElementById(objval).value;
	//alert(str);
	send_data(str,4,'booking_view');
}

function cancel_booking(booking_id){
	if(confirm("Are you sure you wish to cancel this booking")){ 
		var str = booking_id+"|2";
		send_data(str,4,'booking_view');
	}
}
</script>
<?
$arg = "select * from jobs where status=1 order by date desc limit 0,50";

$data = mysql_query($arg);
if (mysql_num_rows($data)>0){ 
?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">


<table width="100%" border="0" align="center" cellpadding="6" cellspacing="3" class="table_bg">  
  <tr class="header_td">
    <td width="5%"> Id</td>
    <td width="5%">Date</td>
    <td width="5%">Time</td>
    <td width="10%">Name</td>
    <td width="10%">Email</td>
    <td width="10%">Phone</td>
    <td width="10%">Address</td>
    <td width="5%">Bed</td>
    <td width="5%">Bath</td>
    <td width="10%">Team</td>
    <td width="5%">Total</td>
    <td width="5%">Payby</td>
    <td width="5%">Clean </td>
    <td width="5%">Hours</td>
    <td width="5%">Carpect</td>
    <td width="5%">Status</td>
    <td width="10%">Action</td>
  </tr>
  <?php 
  while($r=mysql_fetch_assoc($data)){ 
  ?>
  <tr class="table_cells" <? if($r['team_id']=="0"){ echo 'style="color:red"'; } ?>>
    <td><? echo $r['id'];?></td>
    <td><? echo $r['date'];?></td>
    <td><? echo $r['time'];?></td>
    <td><? echo $r['name'];?></td>
    <td><? echo $r['email'];?></td>
    <td><? echo $r['phone'];?></td>
    <td><? echo $r['address'];?></td>
    <td align="center"><? echo $r['bed'];?></td>
    <td align="center"><? echo $r['bath'];?></td>
    <td align="center"><? 
	$team_data = mysql_query("select * from team where status=1");
	echo '<select name="team_id_'.$r['id'].'" id="team_id_'.$r['id'].'" onChange="javascript:select_team(\'team_id_'.$r['id'].'\',\''.$r['id'].'\')">';
	echo '<option value="0">Select</option>';
	while($team = mysql_fetch_assoc($team_data)){
		if($r['team_id']==$team['id']){ 
			echo '<option value="'.$team['id'].'" selected>'.$team['name'].'</option>';
		}else{			
			echo '<option value="'.$team['id'].'">'.$team['name'].'</option>';
		}
	}
	echo '</select>';	
	?></td>
    <td align="center" class="text11_red"><? echo $r['amount'];?></td>
    <td align="center" class="text11_red"><? echo $r['payby'];?></td>
     <td align="center" class="text11_red"><? echo $r['cleaning_amount'];?></td>
      <td align="center" class="text11_red"><? echo $r['cleaning_hours'];?></td>
      <td align="center" class="text11_red"><? echo $r['carpet_amount'];?></td>
    <td>
	<?
    
	echo '<select name="b_status_'.$r['id'].'" id="b_status_'.$r['id'].'" onChange="javascript:edit_status(\'b_status_'.$r['id'].'\',\''.$r['id'].'\')">';
	echo '<option value="0">Select</option>';	
	if($r['b_status']=="0"){
		echo '<option value="0" selected>Open</option>';
		echo '<option value="1">Closed</option>';
	}else{			
		echo '<option value="0">Open</option>';
		echo '<option value="1" selected>Closed</option>';
	}
	echo '</select>';
	
	?>	
	</td>
    <td><a href="/admin/index.php?task=edit_booking&id=<?=$r['id']?>">[Edit]</a> | 
    <a href="javascript:cancel_booking('<?=$r['id']?>');">[Cancelled]</a>|<br>
	<a href="javascript:scrollWindow('/admin/notes.php?booking_id=<? echo $r['id']?>','750','600')" class="text12">Notes</a>
</td>
  </tr>
  <? } ?>

</table>
<? }else{  
	echo "No Records Found";
} 
?>