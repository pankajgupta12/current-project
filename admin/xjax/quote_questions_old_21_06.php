<?php 
/* $question_ids = explode(',', get_rs_value('quote_new', 'question_id', $quote_id));
$question_ids = explode(',', get_rs_value('quote_new', 'question_id', $quote_id)); */

$quotedetails = mysql_fetch_assoc(mysql_query("SELECT question_id ,qus_ans , qus_key_id  FROM quote_new WHERE id = '".$quote_id."'"));

$question_ids = explode(',',$quotedetails['question_id']);

 $qus_key_id = explode(',',$quotedetails['qus_key_id']);
 $qus_ans = explode(',',$quotedetails['qus_ans']);

$arr_qus_ans = array_combine($qus_key_id , $qus_ans);

 //print_r($arr_qus_ans);
/*print_r($qus_key_id); */
//$qus_key_id = explode(',' ,$quotedetails['qus_key_id']);

$quote_details = mysql_fetch_assoc(mysql_query("SELECT job_type_id FROM quote_details WHERE quote_id = '".$quote_id."'"));

$cond = $quote_details['job_type_id'] == 11 ? 2 : 1;
$qry_quote_questions = mysql_query("SELECT * FROM quote_question WHERE status=1 AND quote_type='".$cond."'");	

?>
<div id="div_3"></div><br/>
<div style="margin-top: -17px;"><h3>Quote Questions For  : <?php echo ($quote_details['job_type_id'] == 11 ? 'Removal' : 'Cleaning');?></h3>
<div><h4>Quote ID : #<?php echo $quote_id;?></h4>
</div></br></br>
<div class="table_dispatch table-scroll" style="margin-top: -24px;">
	<table border="1px" id="quote_questions_list2" class="quote_que quote_questions" style="width:100%">
		<?php 
		while($quote_quest_list = mysql_fetch_assoc($qry_quote_questions)) { 
			if(!empty($question_ids)){
				if(in_array($quote_quest_list['id'], $question_ids)){
					$status_check = 'checked' ;
				}
				else{
					$status_check = '';
				}			

					
			}
		
		?>
		<tr>
			<td width="10%;">
				<input type="checkbox"  name="quote_quest[<?php echo $quote_quest_list['show_option'];?>]" id="quote_quest_<?php echo $quote_quest_list['id'];?>" value="<?php echo $quote_quest_list['id'];?>" <?php echo $status_check;?>>
			</td>
			 <td><?php echo $quote_quest_list['question'];?></td>
			  
			    <?php if($quote_quest_list['show_option'] == 2) { ?>
				 <td id="show_butt_<?php echo $quote_quest_list['id'];?>">
					 <!--<input type="radio" onclick="checkQuestion1('<?php echo $quote_quest_list['id'];?>');" id="show_option_<?php echo $quote_quest_list['id'];?>" name="show_option['<?php echo $quote_quest_list['id'];?>']" tabindex='1_<?php echo $quote_quest_list['id'];?>'  value="1" <?php if($arr_qus_ans[$quote_quest_list['id']] != '') {echo 'checked';} ?> >Yes
					 
					 <input type="radio" onclick="checkQuestion1('<?php echo $quote_quest_list['id'];?>');" id="show_option_<?php echo $quote_quest_list['id'];?>" name="show_option['<?php echo $quote_quest_list['id'];?>']" tabindex='2_<?php echo $quote_quest_list['id'];?>'  value="2" <?php if($arr_qus_ans[$quote_quest_list['id']] == '') {echo 'checked';} ?>> No
				 
					 <br/>-->
					 
					 <p><?php echo $quote_quest_list['question_2'] ?></p>
					 
					   <!--<input  <?php if($arr_qus_ans[$quote_quest_list['id']] != '') { ?>  <?php  }else { ?> style="display:none;" <?php  } ?> id="yeschek_<?php echo $quote_quest_list['id'];?>"  type="text" name="quote_ans[]" class="quote_ans" value="<?php echo $arr_qus_ans[$quote_quest_list['id']]; ?>" data-id="<?php echo $quote_quest_list['id'];?>" />-->
			   
			     </td>
			    <?php  } ?>
			 
		 </tr>
		 <!--<tr style="display:none;" id="yeschek_<?php echo $quote_quest_list['id'];?>" >
		   <td colspan="3" style="padding: 13px;"> 
		      <input type="text" name="quote_ans[]" id="quote_ans" class="input" value="" />
			
			</td>
		 </tr>-->
		 
		<?php } ?>
		<tr>
			<td colspan="3" align="center">
				<a href="javascript:save_quote_question('<?php echo $quote_id;?>|1', 531, 'div_3');" class="btn_quote">Submit</a>
			</td>
		</tr>
	</table>
</div>



