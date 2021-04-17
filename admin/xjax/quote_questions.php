<?php 
$question_ids = explode(',', get_rs_value('quote_new', 'question_id', $quote_id));

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
				<input type="checkbox" name="quote_quest[]" value="<?php echo $quote_quest_list['id'];?>" <?php echo $status_check;?>>
			</td>
			<td><?php echo $quote_quest_list['question'];?></td>
			<td><?php echo $quote_quest_list['question_2'];?></td>
		 </tr>
		<?php } ?>
		<tr>
			<td colspan="2" align="center">
				<a href="javascript:save_quote_question('<?php echo $quote_id;?>|1', 531, 'div_3');" class="btn_quote">Submit</a>
			</td>
		</tr>
	</table>
</div>
