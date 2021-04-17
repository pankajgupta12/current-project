<div id="auot_list_div">
<link href="/management/css/general.css" rel="stylesheet" type="text/css" />
<? include("search.php"); ?>
<?
		$r=0;
		
		if($t=="36" && $a=="list"){
			
			if ($_POST['search_form']==1){ 
				$arg = "select * from $table where status=2 and ". $_POST['search_field_name'] ." like '%".$_POST['search_keyword'] ."%'";
			}else{
				$arg = "select * from $table  where status=2  ";
			}
		}else{
			if ($_POST['search_form']==1){ 
				$arg = "select * from $table where ". $_POST['search_field_name'] ." like '%".$_POST['search_keyword'] ."%'";
			}else{
				$arg = "select * from $table";
			}
		}
		
		
		if($_GET['offset']!=""){
			$arg=$_SESSION['search_arg'];
		}else{
			$_SESSION['search_arg']=$arg;
		}
		//echo $arg;
		if ($listopt=="order"){ $colspan=3; }else{ $colspan=2; }
		//$row = mysql_fetch_array(mysql_query($arg ));
		$data = mysql_query( $arg);
		$listings = mysql_num_rows($data);
		
		if(!isset($_GET['limit'])){	$limit=25; }

		if(!isset($_GET['offset'])){ $offset = 0;}else{ $offset= $_GET['offset']; }

		if ($offset==""){ $offset=0; }
		
		if($limit > $listings){ $limit = $listings; }

		$back = $offset-$limit;
		$forth = $offset+$limit;
		$pages = @ceil($listings / $limit);
		$current_page = @($offset / $limit)+1;
		if($current_page>10){
			$lastpage=$current_page+10;
			$firstpage=$current_page-0;
		}else{
			$lastpage=10;
			$firstpage=1;
		}
		if($lastpage>=$pages){$lastpage=$pages;}
		//echo $firstpage ."--".$lastpage;
		if ($listopt=="order"){  $arg.= " order by order_id "; }else{ $arg.= " order by id desc "; }
		$arg .= " LIMIT $offset, $limit";
		//echome($arg);
		$data = mysql_query($arg);
?>

<form name="form1" method="post" action="<? echo $_SERVER['SCRIPT_NAME']?>" onSubmit="return valid_form(this);">
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="<? echo $table_bgcolor;?>">
<tr>

<td colspan="<? echo (count($listheading)+$colspan)?>">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<? echo $table_bgcolor;?>">
          <tr > 
            <td valign="middle" class="text11" bgcolor="<? echo $td_bgcolor;?>"><font color="<? echo $table_fontcolor;?>">Page</font>
              <? 
					$xoffset=($firstpage-1)*$limit;
					for ($i=$firstpage;$i<=$lastpage;$i++)
					{ 
						if($xoffset==$offset){	
							echo "<font color=\"".$table_fontcolor."\">&nbsp; $i &nbsp;</font>";
						}else{ 
							?>
              &nbsp;<a href="<? echo $_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$xoffset; ?>"><font color="<? echo $table_fontcolor;?>"><? echo $i;?></font></a>&nbsp; 
              <?
						}
						$xoffset = $xoffset+$limit;
					} ?>
              &gt; &gt; <? echo $pages;?></td>
            <td align="right" class="text11" bgcolor="<? echo $td_bgcolor;?>"> 
              <? if ($current_page!=1){?>
              <strong><a href="<? echo "".$_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$back; ?>"><font color="<? echo $table_fontcolor;?>">&lt; 
              Back</font></a></strong> 
              <? } ?>
              <? if ($current_page<$pages && $current_page!=1){?>
              | 
              <? } ?>
              <? if ($current_page!=$pages){?>
              <strong><a href="<? echo "".$_SERVER['SCRIPT_NAME']."?task=".$t."&action=".$a."&offset=".$forth; ?>"><font color="<? echo $table_fontcolor;?>">Next 
              &gt;</font></a></strong> 
              <? } ?>
            </td>
          </tr>
        </table>
</td></tr>
  <tr class="boldtext"> 
    <td colspan="<? echo (count($listheading)+$colspan)?>"><font color="<? echo $table_fontcolor;?>"><h2>List <? echo $title?></h2></font></td>
  </tr>
  <tr bgcolor="<? echo $td_bgcolor;?>" class="boldtext"> 
   <? 
   if (strpos($listopt,"|")>0){
	   $listopt_arr = explode("|",$listopt);
	   $listoptionscode = $listopt_arr[0];
   }else{
		$listoptionscode = $listopt;
   }
   
	   if ($listoptionscode=="order"){  ?>
	<td width="40">Order</td>
	<? }else if($listoptionscode=="open_close"){ ?>
	<td width="40">Open/Close</td>
	<? } ?>
   
    <? foreach ($listheading as $valuex) { ?>
    <td> <div align="center"><font color="<? echo $td_fontcolor?>"><? echo $valuex?></font></div></td>
    <? }?>
    <td width="10%"><div align="center"><font color="<? echo $td_fontcolor?>">Modify</font></div></td>
    <td width="5%"> <input name="checkall" type="checkbox" id="checkall" value="checkbox" onClick="clickcheck();"></td>
  </tr>
  <? 		
  if (mysql_num_rows($data)>0){ 
  
		  while($r < (mysql_num_rows($data))){
				$j=0;
				foreach($listname as $value) { 
				
							$id=mysql_result($data,$r,"id");
							$details = mysql_fetch_array($data);
				
							if ($listtype[$j]=="fdate"){
								$new[$value]=rotatedate(mysql_result($data,$r,$value));
							}else if ($listtype[$j]=="xjax_dd_div"){
								if(strpos($dd_values,",")>0){ 
									$dd_values = explode(",",$listtypevalue[$j]);
									//$new[$value]= get_rs_value($dd_values[1],$dd_values[3],mysql_result($data,$r,$value));
									if($dd_values[2]=="id"){
										if($dd_values[4]!=""){
											//$new[$value]= get_sql($dd_values[1],$dd_values[3],"where id=".mysql_result($data,$r,$value)." and ".$dd_values[4]);	
											// eg : state = state;
											$q1=explode("=",$dd_values[4]);
											$q1field_val = mysql_result($data,$r,$q1[1]);
											$new_query= $q1[0]."='".$q1field_val."'";
											//echo "<br>".$new_query."<br>";
											$new[$value]= get_sql($dd_values[1],$dd_values[3],"where ".$new_query);	
										}else{
											$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
										}
									}else{
										$new[$value]=mysql_result($data,$r,$value);
									}
								}else{
									$new[$value]=mysql_result($data,$r,$value);
								}
							}else if($listtype[$j]=="dd"){
								//$dd_values = explode(",",$listtypevalue[$j]);
								//$new[$value]= get_rs_value($dd_values[1],$dd_values[3],mysql_result($data,$r,$value));
								$dd_values = explode(",",$listtypevalue[$j]);
								//print_r($dd_values);
								
								if (strpos($dd_values[4],"{")>0){
									$cond = $dd_values[4] ; // course_id={course_id}
									$pos1= strpos($cond,"{");
									$pos2 = strpos($cond,"}");
									$word_length = $pos2 - ($pos1+1);
									//echo $pos1."-".$pos2."-".$pos3."-".$cond;
									$cond_field = substr($dd_values[4],$pos1+1,$word_length);
									//echo "<br>".$cond_field;
									$new_cond = substr($dd_values[4],0,$pos1)."'".$details[$cond_field]."'";
									//echo "<br>".$new_cond."<br>";
									$dd_values[4] = $new_cond;
									$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
								}else{ 
								
									if($dd_values[4]!=""){
										$new[$value]= get_sql($dd_values[1],$dd_values[3],"where id=".mysql_result($data,$r,$value)." and ".$dd_values[4]);	
									}else{
										$new[$value]= get_sql($dd_values[1],$dd_values[3]," where ".$dd_values[2]."='".mysql_result($data,$r,$value)."'");
									}
								}
							}else if (strpos($value,"email")>-1){
								$new[$value]="<a href=\"mailto:".mysql_result($data,$r,$value)."\">".mysql_result($data,$r,$value)."</a>";
							}else if ($listtype[$j]=="doc"){
								$new[$value]="<a href=\"javascript:scrollWindow('".mysql_result($data,$r,$value)."','300','350')\">View Document</a>";
							}else if($listtype[$j]=="file"){
								$new[$value]="<a href=\"javascript:scrollWindow('details.php?img=".mysql_result($data,$r,$value)."','300','350')\">
								<img src=\"".mysql_result($data,$r,$value)."\" width=\"100\" border=\"0\"></a>";
							}else{
								
									if(($value=="user_id") || ($value=="broker_id") || ($value=="to_user_id")){ 
										$new[$value]=$new[$value]="<a href=\"javascript:scrollWindow('summary.php?t=users&f=id&k=".mysql_result($data,$r,$value)."','600','650')\" class=\"text12\">".mysql_result($data,$r,$value)."</a>";
									}else if(($value=="buyer_id") || ($value=="from_buyer_id")){ 
										$new[$value]=$new[$value]="<a href=\"javascript:scrollWindow('summary.php?t=buyers&f=id&k=".mysql_result($data,$r,$value)."','600','650')\" class=\"text12\">".mysql_result($data,$r,$value)."</a>";
									}else if($value=="listing_id"){ 
										if(mysql_result($data,$r,$value)!=""){ 
											$geturl = get_rs_value("listings","page_url",mysql_result($data,$r,$value));
											$new[$value]=$new[$value]="<a href=\"".Site_url.$geturl."\" class=\"text12\" target=\"_blank\">".mysql_result($data,$r,$value)."</a>";
										}else{
											$new[$value]=mysql_result($data,$r,$value);
										}
									}else if($value=="page_url"){ 
										if(mysql_result($data,$r,$value)!=""){ 
											
											$new[$value]=$new[$value]="<a href=\"".Site_url.mysql_result($data,$r,$value)."\" class=\"text12\" target=\"_blank\">View</a>";
										}else{
											$new[$value]=mysql_result($data,$r,$value);
										}
									}else{
										//echo $value;
										$new[$value]=mysql_result($data,$r,$value);
									}
								
							}
							
							
							$j++;
				}
				if ($cc=="#cccccc") { $cc="#ebebeb"; }else{ $cc="#cccccc"; }
		  ?>
		  <tr bgcolor="<? echo $cc;?>"> 
         	<!-- first rows for order, open_close div etc starts here -->
			<? if ($listoptionscode=="order"){ ?>
            <td ><a href="javascript:send_data('<? echo $id?>',13,'auot_list_div')">
            <img src="/management/images/up.gif" width="18" height="16" border="0"/></a>
            <a href="javascript:send_data('<? echo $id?>',14,'auot_list_div')"><img src="/management/images/down.gif" width="18" height="16" border="0"/></td>
            <? }else if ($listoptionscode=="open_close"){ 
			
			?>
            <td ><a href="javascript:change_image_op(<?=$id;?>,<? echo $listopt_arr[1]?>);">
            <img src="/management/images/open.bmp" width="18" height="16" border="0" id="opimg_<?=$id;?>"/></a>
           	</td>
            <? } ?>
            
            <!-- data rows start here -->
			<? 
			foreach ($new as $valuen) { 
			?>
			<td> <div align="center" class="text12"><font color="<? echo $text_color;?>"><? echo "$valuen";?> 
				</font></div></td>
			  <? } ?>
              
              
			<td align="center">
            <? if(rw("task")=="61"){ ?>
            	<a href="javascript:scrollWindow('/management/invoice.php?id=<? echo $id;?>','750','600')" class="text12">Invoice Details</a>
             <? }else if(rw("task")=="8"){ 
				//print_r($details);
				//print_r($new);
				//echo $details['type']."<br>";
				if($new['type']=="Private Seller"){ 
					$license_act = get_sql("listing_license","license_type"," where user_id=".$id." and ((status=1) or (status=0 and listing_id is null))");
					if($license_act!=""){ 
						$license_name = get_rs_value("license_type","name", $license_act);
						echo "<span class=\"text12\">PAID : ".$license_name."</span><br>";
					}
				}
                if($new['type']=="Franchise"){ ?>
					<div id="div_ffl<?=$id;?>"><a href="javascript:send_data(<? echo $id;?>,35,'div_ffl<?=$id;?>');" class="text12">Fix Franchise Listings</a></div>
				<? } ?>
            	<a href="javascript:scrollWindow('/management/user_tracking.php?user_id=<? echo $id;?>','750','600')" class="text12">Tracking Details</a>
                 <a href="<? $_SERVER['SCRIPT_NAME'];?>?task=<? echo "$t";?>&action=modify&id=<? echo "$id";?>"><img src="../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a>
            <? }else if(rw("task")=="72"){ ?>
            	<a href="<? $_SERVER['SCRIPT_NAME'];?>?task=9&action=modify&id=<? echo "$id";?>"><img src="../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a>
             
              <? }else if(rw("task")=="94"){ ?>
            	<a href="<? $_SERVER['SCRIPT_NAME'];?>?task=90&action=modify&id=<? echo "$id";?>"><img src="../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a>
                 <? }else if(rw("task")=="95"){ ?>
            	<a href="<? $_SERVER['SCRIPT_NAME'];?>?task=91&action=modify&id=<? echo "$id";?>"><img src="../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a>
                
            <? }else{ ?>
           	 <a href="<? $_SERVER['SCRIPT_NAME'];?>?task=<? echo "$t";?>&action=modify&id=<? echo "$id";?>"><img src="../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a>
            <? } ?>
		  	</td>
			<td align="center"> 
			<div align="center"> 
				  <input type="checkbox" name="c<? echo $id?>" value="checkbox"></div></td>
		  </tr>
		  <? 
		   if ($listoptionscode=="open_close"){ 
		   	echo "<tr><td colspan=\"". (count($listheading)+2)."\"><div id=\"opdiv_". $id."\" style=\"display:none\"></div></td></tr>";
		   }
		  $r++; 
		  }
	}else{?>
	 <tr class="boldtext"> 
        <td colspan="<? echo (count($listheading)+2)?>" height="50" align="center"><font color="<? echo $table_fontcolor;?>">No Rows Found</font></td>
      </tr>
	<? } ?>
  </table>

<? if (mysql_num_rows($data)>0){  ?>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr bgcolor="<? echo $td_bgcolor; ?>" class="text12"> 
    <td> <div align="right"> 
        <input name="Submit" type="submit" class="formbuttons" value="Delete">
        <input type="hidden" name="task" value="<? echo $t?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="step" value="1">
      </div></td>
  </tr>
</table>
<? } ?>
</form>
<p>&nbsp;</p>
</div>