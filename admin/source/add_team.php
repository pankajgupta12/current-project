<link href="../admin/css/general.css" rel="stylesheet" type="text/css"><br>
<p></p>
<?
if(isset($_POST['step'])){ 
	$table="team";
	$_SESSION['query[txt]']="";
	$fields_name=array("site_id","name","email","phone","abn","status","login_id","bank_name","bsb","account_number");
	$fields_heading=array("Site Id","Name","Email","Phone","ABN","Status","login Id","Bank Name","BSB","Account Number");
	
	$fields_validation=array(0,1,1,1,1,1,0,1,1,1);
	$fields_dtype=array(0,1,1,1,1,1,0,1,1,1);
	$fields_add=array(1,1,1,1,1,1,1,1,1,1,1);
	
	$step = $_POST['step'];
	if ($step==1){
			$step=check_form($fields_name,$fields_validation,$fields_heading);
			/*if ($step==2){
				
				if(strtoupper($_POST['code']) != $_SESSION['captcha_phrase']){
					$_SESSION['query[txt]']= "Incorrect Verification Code.<br>";
					$_SESSION['query[error]'] = 1;
					$step=1;
				}				
			}*/
	}
	if ($step==2){ 
	 	//letscheckproxy();
		
		//$_POST['status']=0;
		// 0 = not active , 1 = active , 2 = pending
		$_POST['site_id']=$_SESSION['site_id'];
		//$_POST['date']=$mysql_tdate;
		$_POST['login_id']=mysql_real_escape_string($_SESSION['admin']);

		if($_REQUEST['task']=="add_team"){ 
			$insert1=insert_form($fields_name,$fields_dtype,$table,$fields_add);
			if($insert1==1){ $_SESSION['query[txt]']= "Your Team Member has been Added successfully.<br>"; }
		}else if ($_REQUEST['task']=="edit_team"){
			//$insert1=insert_form($fields_name,$fields_dtype,$table,$fields_add);
			$insert1=modify_form($fields_name,$fields_add,$fields_dtype,$table,$_REQUEST['id']);			
			if($insert1==1){ $_SESSION['query[txt]']= "Your Team Member has been Edited successfully.<br>"; }
		}
	}

}else if ($_REQUEST['task']=="edit_team"){
	$details = mysql_fetch_array(mysql_query("select * from team where id=".mysql_real_escape_string($_REQUEST['id']).""));	
}

?>

 <? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 ?>

<form method="post" id="form">
<table width="990" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg">
  <tr>
    <td colspan="4" class="header_td"><?php if($_REQUEST['task']=="add_team"){ echo "Add"; }else{ echo "Edit"; } ?>Team Details</td>
  </tr>
  <tr>
    <td colspan="4" class="table_cells">&nbsp;</td>
  </tr>
  <tr>
    <td width="362" class="header_td">Name</td>
    <td width="563" colspan="3" class="table_cells"><input name="name" type="text" id="name" size="45" value="<? echo get_field_value($details,"name");?>"></td>
  </tr>
  <tr>
    <td class="header_td">Phone</td>
    <td colspan="3" class="table_cells"><input name="phone" type="text" id="phone" value="<? echo get_field_value($details,"phone");?>" size="45"></td>
  </tr>
  <tr>
    <td class="header_td">Email</td>
    <td colspan="3" class="table_cells"><input name="email" type="text" id="email" value="<? echo get_field_value($details,"email");?>" size="55"></td>
  </tr>
  <tr>
    <td class="header_td">ABN</td>
    <td colspan="3" class="table_cells"><input name="abn" type="text" id="abn" value="<? echo get_field_value($details,"abn");?>"></td>
  </tr>
  <tr>
    <td width="362" class="header_td">Bank Name</td>
    <td width="563" colspan="3" class="table_cells"><input name="bank_name" type="text" id="bank_name" size="45" value="<? echo get_field_value($details,"bank_name");?>"></td>
  </tr>
  <tr>
    <td class="header_td">BSB</td>
    <td colspan="3" class="table_cells"><input name="bsb" type="text" id="bsb" value="<? echo get_field_value($details,"bsb");?>" size="15"></td>
  </tr>
  <tr>
    <td class="header_td">Account Number</td>
    <td colspan="3" class="table_cells"><input name="account_number" type="text" id="account_number" value="<? echo get_field_value($details,"account_number");?>" size="55"></td>
  </tr>
  <tr>
    <td class="header_td">Status</td>
    <td colspan="3" class="table_cells"><select name="status" id="status">
      <option <? if(get_field_value($details,"status")=="1"){ echo "selected"; } ?> value="1">Activated</option>
      <option <? if(get_field_value($details,"status")=="0"){ echo "selected"; } ?> value="0">Deactivated</option>
    </select></td>
  </tr>
  <tr class="table_cells">
    <td colspan="4" align="center" class="table_cells"><br>      
    <input name="button" type="submit" class="fcontrol" id="button" value="Add Team">
    <input type="hidden" name="step" id="step" value="1">
    </td>
  </tr>
</table>
</form>

<p>&nbsp;</p>
