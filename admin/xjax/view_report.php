<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<script type="text/javascript" src="js/jquery-min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#date" ).datepicker();
  } );
  
  </script>
<!-------Menu-------> 
<script>
$(document).ready(function(e) {
$('.menu').click(function(e) {
$('.main_menu').slideToggle(700);    
});

});
 
function check() {
	//document.getElementById("bc_click").checked = true;
	
}

function uncheck() {	
	  //document.getElementById("bc_click").checked = false;
	  $('.user-table tbody td').css('background-color',''); 
	  $( ".bc_click" ).prop( "checked" , false );
}

$(document).on('click','.loadmore',function () {
  $(this).text('Loading...');
 //   var ele = $(this).parent('td');
   // alert(ele);
        $.ajax({
      url: 'xjax/ajax/loadmore_viewquote.php',
      type: 'POST',
      datatype: 'html',
      data: {
              page:$(this).data('page'),
            },
      success: function(response){
           if(response){
              
              
              $('.load_more').remove();
              $( "tr.parent_tr:last" ).after( response );
              
              
                //$("#get_loadmoredata").html(response);
              }
            } 
             
   }); 
});

</script>


<?
/* echo "<pre>";
print_r($_SERVER); */
//echo $resultsPerPage;
$resultsPerPage = resultsPerPage;
$arg = "select * from quote_new where deleted=0 and status=0 ";
if(isset($_SESSION['view_quote_action']))
{ 
	if($_SESSION['view_quote_action']=="1")
	{
		if( (isset( $_SESSION['view_quote_keyword'] ) && $_SESSION['view_quote_keyword'] != '') && $_SESSION['view_quote_field'] == 'step' )
		{
			$arg.= " and amount ='' and step ={$_SESSION['view_quote_keyword']} ";	
		}
		else
		{
			$arg.= " and amount ='' and step ='1' ";	
		}
	}
	else if($_SESSION['view_quote_action'] =="2")
	{
		if( (isset( $_SESSION['view_quote_keyword'] ) && $_SESSION['view_quote_keyword'] != '') && $_SESSION['view_quote_field'] == 'step' )
		{
			$arg.= " and step ={$_SESSION['view_quote_keyword']} ";	
		}
		else		
		{
			$arg.= " and step ='2' ";
		}
	}
	else if($_SESSION['view_quote_action'] =="3")
	{
		$arg.= " and step = '3'";	
	}
	else if($_SESSION['view_quote_action'] =="4")
	{
		
		$arg.= " and step = '4'";	
	}
}
if(($_SESSION['view_quote_field']!="") && ($_SESSION['view_quote_keyword']!="")){
	$arg.= " and ".$_SESSION['view_quote_field']." like '%".$_SESSION['view_quote_keyword']."%'";
}

if($_SESSION['site_id']!=""){ 
	$arg.= " and site_id=".mysql_real_escape_string($_SESSION['site_id'])." ";
}

$arg.=" order by id desc limit 0,$resultsPerPage";

//echo $arg;
$data = mysql_query($arg);
 $countResult = mysql_num_rows($data);
if (mysql_num_rows($data)>0){ 
?>
<link href="../admin/css/general.css" rel="stylesheet" type="text/css">

<style>
  .bc_click_btn.alert-danger {
    background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;
}
</style>


<div class="usertable-overflow">
	<table class="user-table">
	  <thead>
	  <tr>
		<th>Id</td>
		<th>Site</td>
        <th>Ref</td>
		<th>Quote Date</td>
		<th>Quote Time</td>
		<th>Name</td>
		<th>Email</td>
		<th>Phone</td>
		<th>Suburb</td>
        <th>Job Type</td>
		<th>Job Date</td>
		<th>SMS Quote</td>
        <th>Email Date</td>
		<th>Amount</td>
		<th>Called</td>
        <th>Status</td>
		<th>Action</td>
	  </tr>
	  </thead>
	  <tbody id="get_loadmoredata">
	  <?php 
	  while($r=mysql_fetch_assoc($data)){ 
			$quote_details = mysql_query("select * from quote_details where quote_id=".$r['id']);
			   
			      //  $rQdetails = mysql_fetch_array(mysql_query("select * from quote_details where id=".$quote_details['id'].""));
                      //print_r($rQdetails);
                    //  $desc1 = create_memberquote_desc_str($rQdetails);
                     // mysql_query("update quote_details set description='".$desc1."' where id=".$quote_details['id']."");
			   
		$startDatehours  = date('Y-m-d H:i:s');
        $endDatehours = $r['createdOn'];
        $minutes = round((strtotime($startDatehours) - strtotime($endDatehours))/60, 2);
	  ?>
		<tr class="parent_tr">
			<td class="bc_click_btn pick_row"><? echo $r['id'];?></td>
			<td class="bc_click_btn"><? echo get_rs_value("sites","name",$r['site_id']);?></td>
			<td class="bc_click_btn"><? echo $r['job_ref'];?></td>
			<td class="bc_click_btn"><? echo $r['date'];?></td>
				<?php  if($r['step'] == 1) { $class = ' alert-danger';  if($minutes > 15) { $class = ' alert-danger';  if( $r['check_sms_initial'] == 0 )  { $msgstatus = ''; $class = ' alert-danger';    }else{$msgstatus = 'Sent'; $class = '';  }   ?>
		    	<td class="bc_click_btn <?php print $class; ?>"><? echo date('h:i:s',strtotime($r['createdOn'])).'</br>'. date('a',strtotime($r['createdOn'])) . '<br />' . $msgstatus; ?></td>
			<?php  }else { ?>
			    <td class="bc_click_btn"><? echo date('h:i:s',strtotime($r['createdOn'])).'<br/>'.date('a',strtotime($r['createdOn'])); ?></td>
			    <?php } }else { ?>
		    	<td class="bc_click_btn"><? echo date('h:i:s',strtotime($r['createdOn'])).'<br/>'.date('a',strtotime($r['createdOn'])); ?></td>
			<?php  } ?>
			<td class="bc_click_btn"><? echo $r['name'];?></td>
			<td class="bc_click_btn"><a href="mailto:<? echo $r['email'];?>"><? echo $r['email'];?></a></td>
			<td class="bc_click_btn"><a href="tel:<? echo $r['phone'];?>"><? echo $r['phone'];?></a></td>
			<td class="bc_click_btn"><a title="<?php echo $r['address']; ?>"><? echo $r['suburb'];?></a></td>
			<td class="bc_click_btn"><? while($qd = mysql_fetch_assoc($quote_details)){      
			      
			     /*  if($r['step'] == 2){
			         $rQdetails = mysql_fetch_array(mysql_query("select * from quote_details where id=".$qd['id'].""));
                     $desc1 = create_memberquote_desc_str($rQdetails);
                      mysql_query("update quote_details set description='".$desc1."' where id=".$qd['id']."");
			        }  */
			echo $qd['job_type']." "; }?></td>
			<td class="bc_click_btn"><? if($r['booking_date']!="0000-00-00"){ echo date("d-m-Y",strtotime($r['booking_date'])); } ?>
			</td>
			<td class="bc_click_btn" id="quote_sms_<?=$r['id']?>"><? if($r['sms_quote_date']!="0000-00-00"){ echo date("d-m-Y",strtotime($r['sms_quote_date'])); } ?></td>
			<td class="bc_click_btn" ><? if($r['emailed_client']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['emailed_client'])); }?></td>
			<td class="bc_click_btn" >$<? echo $r['amount'];?></td>
			<td class="bc_click_btn" id="quote_called_<?=$r['id']?>"><? if($r['called_date']!="0000-00-00 00:00:00"){ echo date("d/m H:i:s",strtotime($r['called_date'])); }?></td>
			<td id="getstatus">
			  <?php echo create_dd("step","system_dd","id","name","type=31","Onchange=\"view_quote_status_change(this.value,".$r['id'].");\"",$r);?>    
			</td>	      
			<td>
			
				<?php /*?><a href="javascript:scrollWindow('email_quote.php?quote_id=<?=$r['id']?>','1200','850')">[Email Quote]</a> <br> 
				<a href="javascript:send_data('<?=$r['id']?>',8,'quote_view');">[Convert to Job]</a><br><?php */?>
				
				<a title="DELETE" href="javascript:delete_quote('<?=$r['id']?>');" class="file_icon"><i class="fa fa-trash-o" aria-hidden="true"></i></a>		                           
				<?php /*?><a href="#" class="file_icon"><i class="fa fa-refresh" aria-hidden="true"></i></a><?php */?>
			</td>
		</tr>
	  <? }?>
	       <tr class="load_more">
	         <td colspan="18"><button class="loadmore" data-page="2" >Load More</button></td>
	      </tr>
	     
	</table>

    <?php }else{ ?> 
   <table class="user-table">
	  <tr><td colspan="20">No Quotes Found</td></tr>
	</table>
	<?php }?>
</div>
<style>
  #container{width: 80%;margin: auto auto;}
.news_list {
list-style: none;
}
.loadmore {
color: #FFF;
border-radius: 5px;
width: 15%;
height: 50px;
font-size: 20px;
background: #42B8DD;
outline: 0;
}
 .loadbutton{
    text-align: center;
}
</style>
