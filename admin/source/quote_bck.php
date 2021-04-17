<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
 <? 
 if($_SESSION['query[error]'] == 1){ print error($_SESSION['query[txt]']); }Else If(!empty($_SESSION['query[txt]'])){ print notify($_SESSION['query[txt]']); }
 ?>
<script src="../../jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../../jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<link href="../../jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../../jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 <script>
        $(function() {
			  $("#booking_date").datepicker({dateFormat:'yy-mm-dd'});
        });
    </script>

<form method="post" id="form" onsubmit="return validate_quote();">
<table width="1400" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td width="75%">Create Quote</td>
    <td width="25%">&nbsp;</td>
    </tr>
  <tr>
    <td width="990" valign="top"><table width="990" border="0" align="center" cellpadding="5" cellspacing="5" class="table_bg">
  <tr>
    <td colspan="4" class="header_td">Create Quote</td>
  </tr>
  <tr>
    <td colspan="4" class="table_cells">May I know how many bedrooms and bathrooms are there in the property?</td>
  </tr>
  <tr>
    <td class="header_td">Site Id</td>
    <td colspan="3" class="table_cells"><?php echo create_dd("site_id","sites","id","name","","",$details);?></td>
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
        <td class="header_td">Address</td>
        <td colspan="3" class="table_cells"><textarea name="address" cols="45" rows="3" id="address"><? echo get_field_value($details,"address");?></textarea></td>
      </tr>
    <tr>
    <td class="header_td">Comments</td>
    <td colspan="3" class="table_cells"><textarea name="comments" cols="45" rows="3" id="comments"><? echo get_field_value($details,"comments");?></textarea></td>
  </tr>
  <tr class="table_cells">
    <td colspan="4" class="header_td"><table width="100%" border="0" cellpadding="5" cellspacing="5">
      <tr>
        <td width="25%" class="table_cells">Bed Rooms:</td>
        <td width="25%" class="table_cells"><input name="bed" type="text" id="bed" value="<? echo get_field_value($details,"bed");?>"></td>
        <td width="25%" class="table_cells">Bath Room: </td>
        <td width="25%" class="table_cells"><input name="bath" type="text" id="bath" value="<? echo get_field_value($details,"bath");?>"></td>
        </tr>
      <tr class="table_cells">
        <td>Job Date:          </td>
        <td><input name="booking_date" type="text" id="booking_date" value="<? echo get_field_value($details,"booking_date");?>"></td>
        <td>Inspection Date: </td>
        <td><input name="inspection_date" type="text" id="inspection_date" value="<? echo get_field_value($details,"inspection_date");?>"></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="5" cellspacing="5">
  <tr class="table_cells">
    <td width="16%" align="right">Furnished ?      </td>
    <td width="16%"><select name="furnished" id="furnished">
      <option <? if($_POST['furnished']=="No"){ echo "selected"; } ?> value="No">No</option>
      <option <? if($_POST['furnished']=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
    </select></td>
    <td width="16%" align="right">House Type: </td>
    <td width="16%"><select name="property_type" id="property_type">
      <option <? if($_POST['property_type']=="Unit"){ echo "selected"; } ?> value="Unit">Unit</option>
      <option <? if($_POST['property_type']=="House"){ echo "selected"; } ?> value="House"> House</option>
      <option <? if($_POST['property_type']=="Duplex"){ echo "selected"; } ?> value="Duplex">Duplex</option>
    </select></td>
    <td width="16%" align="right">Blinds: </td>
    <td width="16%"><select name="blinds_type" id="blinds_type">
      <option <? if($_POST['blinds_type']=="No Blinds"){ echo "selected"; } ?> value="No Blinds">No Blinds</option>
      <option <? if($_POST['blinds_type']=="Verticals"){ echo "selected"; } ?> value="Verticals">Verticals</option>
      <option <? if($_POST['blinds_type']=="Venetians"){ echo "selected"; } ?> value="Venetians">Venetians(wooden)</option>
    </select></td>
  </tr>
</table>

      </td>
    </tr>
  
  <tr>
    <td colspan="4" class="header_td">Carpet Area<br>
      <br>
      <span class="text12">If Yes, I can give you the best price for Carpet Cleaning in <em>Gold Coast</em>.. That will be only $20 / room. For lounge $30 and for stairs $2/step.</span></td>
    </tr>
  <tr>
    <td colspan="4" class="header_td"><table width="100%" border="0" cellpadding="5" cellspacing="5">
      <tr>
        <td width="25%" class="table_cells">Carpet:          </td>
        <td width="25%" class="table_cells"><select name="carpet" id="carpet">
          <option <? if($_POST['carpet']=="No"){ echo "selected"; } ?> value="No">No</option>
          <option <? if($_POST['carpet']=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
        </select></td>
        <td width="25%" class="table_cells">Bedroom: </td>
        <td width="25%" class="table_cells"><input name="c_bedroom" type="text" id="c_bedroom" value="<? echo get_field_value($details,"c_bedroom");?>"></td>
      </tr>
      <tr class="table_cells">
        <td>Capret in Lounge:          </td>
        <td><select name="c_lounge" id="c_lounge">
          <option <? if($_POST['c_lounge']=="No"){ echo "selected"; } ?> value="No">No</option>
          <option <? if($_POST['c_lounge']=="Yes"){ echo "selected"; } ?> value="Yes">Yes</option>
        </select></td>
        <td>Any Stairs, How many: </td>
        <td><input name="c_stairs" type="text" id="c_stairs" value="<? echo get_field_value($details,"c_stairs");?>"></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4" class="header_td">&nbsp;</td>
  </tr>
  
  <tr class="table_cells">
    <td colspan="4" align="center" class="table_cells">Please  allow me a moment to see if we have date available,( take 12 seconds on hold ) <br>
      <br>
      <input name="button2" type="button" class="fcontrol" id="button2" value="GET QUOTE" onClick="javascript:get_quote();">
     </td>
  </tr> 
</table></td>
<!--- Quote Section ---> 




    <td valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="5">
<td style="display:none" id="quote_div">
  </td>
  </tr>  
  <tr class="table_cells">
    <td  align="center" class="table_cells">Please  allow me a moment to see if we have date available,( take 12 seconds on hold ) <br>
      <br>      
    <input name="button" type="submit" class="fcontrol" id="button" value="Save QUOTE">
    <input type="hidden" name="step" id="step" value="1">
    <input type="hidden" name="task" id="task" value="quote">
    </td>
  </tr>
</table></td>
  </tr>
  </table>

</form>

<p>&nbsp;</p>
<script type="text/javascript">
$(function() {
			  $("#inspection_date").datepicker({dateFormat:'yy-mm-dd'});
        });
</script>
