<? 
if ($_POST['search_form']==1){ 
	$_SESSION['search_field_name']=$_POST['search_field_name'];
	$_SESSION['search_keyword']=$_POST['search_keyword'];
}
?>

<script language="javascript">
function intial(){
//alert(document.getElementById('search_field_name'));
check_search_values(document.getElementById('search_field_name'));
}

function check_search_values(obj){
<? 
	for ($i=0;$i<count($listheading);$i++) { 

			$str_n.="'".$listname[$i]."',"; 
			$str_t.="'".$listtype[$i]."',";
			
			$listtypevalue[$i] = str_replace("'","",$listtypevalue[$i]);
			if ($listtype[$i]=="dd"){
				$lxs = $listtypevalue[$i];
				$lxs1 = explode(",",$lxs);
				//print_r($lxs1);
				$lxs2= $lxs1[0].",".$lxs1[1].",".$lxs1[2].",".$lxs1[3].",".$lxs1[4].",".$lxs1[5].",".$_SESSION['search_keyword'];
				$str_v.="'".$lxs2."',";
			}else{
				$str_v.="'".$listtypevalue[$i]."',";
			}
	}
	$str_n=substr($str_n,0,strlen($str_n)-1);
	$str_t=substr($str_t,0,strlen($str_t)-1);	
	$str_v=substr($str_v,0,strlen($str_v)-1);
?>
var fields = new Array(<? print $str_n?>);
var type = new Array(<? print $str_t?>);
var vals = new Array(<? print $str_v?>);
var select_value = "<? echo $_SESSION['search_keyword']; ?>";
//alert(obj.value);
var flag = false;
	for(i=0;i<fields.length;i++){
		if (obj.value==fields[i]){
			//alert("obj val " + obj.value + " : field val " + fields[i] + " : type " + type[i] + " : Vals passed " + vals[i]);
			
			if (type[i]=="dd" || type[i]=="xjax_dd_div"){
				//alert(vals[i]);
				send_data("'" + vals[i] + "'",5,'keyword_div');
				flag = true;
			}else if (type[i]=="select"){
				//alert(vals[i]);
				send_data("'" + fields[i] + "|" + vals[i] + "|" + select_value +"'",6,'keyword_div');
				flag = true;
			}else{
				document.getElementById('keyword_div').innerHTML='<input type="text" name="search_keyword" id="search_keyword" value="'+select_value+'">';
				flag = true;
				
			}
		}else{
			if (flag == false){ 
			document.getElementById('keyword_div').innerHTML = 'Please Select a Field First';
			}
		}
	}

}
</script>

<form name="search_form" method="post" action="<? echo $_SERVER['SCRIPT_NAME']?>">
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="<? echo $table_bgcolor;?>">
  <tr>
    <td colspan="3" class="boldtext"><font color="<? echo $table_fontcolor;?>">Refine Your Search</font></td>
    </tr>
  <tr>
    <td class="boldtext" bgcolor="<? echo $td_bgcolor;?>"><font color="<? echo $td_fontcolor;?>">Select Field</font></td>
    <td class="boldtext" bgcolor="<? echo $td_bgcolor;?>"><font color="<? echo $td_fontcolor;?>">Search Keyword</font></td>
    <td class="boldtext" bgcolor="<? echo $td_bgcolor;?>">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="<? echo $td_bgcolor;?>">
      <select name="search_field_name" id="search_field_name" onchange="javascript:check_search_values(this)">
      <option value="0">Select All</option>
       <? 
	   $xi=0;
	   foreach ($listheading as $valuex) { 
	   	//$listtype_val = $listtype[$xi];
	   	if ($_SESSION['search_field_name']==$listname[$xi]){ $sel = "Selected"; }else{ $sel = ""; } 
	  	echo "<option value=\"".$listname[$xi]."\" ".$sel." >".$valuex."</option>";
		$xi = $xi +1;
		}?>
      </select>    </td>
    <td bgcolor="<? echo $td_bgcolor;?>"><div id="keyword_div" class="text11"><input type="text" name="search_keyword" id="search_keyword" value="<? echo $_SESSION['search_keyword'];?>"></div></td>
    <td bgcolor="<? echo $td_bgcolor;?>"><input type="submit" name="submit" id="submit" value="Search">
      <input name="search_form" type="hidden" id="search_form" value="1">
      <input name="task" type="hidden" value="<? echo $t;?>">
      <input name="action" type="hidden"  value="list">      </td>
  </tr>
</table>
</form>

