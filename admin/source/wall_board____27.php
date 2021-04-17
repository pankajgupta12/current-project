<div id="daily_view">

<h2 style="text-align: center;margin-bottom: -38px;">Wall Board</h2>
<style>
table, th, td {
  border: 1px solid black;
  text-align: center;
}
</style>

<br/>
<br/>
<br/>

<?php  

   $array_team = array(1=>'Sales', 2=> 'Operation');
   $data1 = getAdmindata();

   
   
?>

<table style="width:100%">

  <tr>
   <?php   foreach($array_team as $cid=>$cname) {  ?>
	<td colspan="2" style="text-align: center;"><h3 ><?php echo $cname; ?></h3>
  
 
	<table style="width:100%"><td>
	<?php
	    $i = 0; foreach($data1[$cid] as $key=>$value) { 
   ?>
      
	   <tr>
		<td><b><?php echo $value['name']; ?></b></td>
		<td>
			<table style="width: 100%;">
				<tr>
				  <td>Total </td>
				  <td>today </td>
				  <td>1 Hours </td>
				</tr>
				<tr>
				  <td>In </td>
				  <td>23 </td>
				  <td>12 </td>
				</tr>
				
				<tr>
				  <td>out </td>
				  <td>848 </td>
				  <td>22222 </td>
				</tr>
				
				<tr>
				  <td>overdue </td>
				  <td>Current </td>
				  <td>upcoming </td>
				</tr>
				<tr>
				  <td>34 </td>
				  <td>848 </td>
				  <td>22222 </td>
				</tr>
			</table>
		</td>
	   </tr>	
   <?php $i++; }?> </td></table>
   <?php    } ?>
   </td></tr>
</table>

 

</div>