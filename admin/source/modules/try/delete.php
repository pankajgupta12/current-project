
<link href="../../../../../admin/css/general.css" rel="stylesheet" type="text/css">

<form name="thisform" action="<? $_SERVER['SCRIPT_NAME'];?>" method="post">
  <table width="400" border="0" cellspacing="1" cellpadding="5" align="center" class="text11" bgcolor="<? echo $table_bgcolor;?>">
    <tr>
      <td colspan="2"><b><font color="<? echo $table_fontcolor?>">Verify Delete</font></b></td>
    </tr>
    <tr> 
      <td bgcolor="<? echo $td_bgcolor; ?>" colspan="2" height="90"> 
<div align="center"><b><font color="<? $td_fontcolor;?>" class="tex14">Are 
          you sure you want to delete the following record ?</font><span class="text12"><br>
          <br>
          <br>
          <input type="hidden" name="task" value="<? echo "$t";?>">
          <input type="hidden" name="action" value="<? echo "$a";?>">
          <input type="hidden" name="step" value="1">
          <input type="hidden" name="id" value="<? echo "$id";?>">
          <a href="javascript:history.go(-1)" class="link_blue"><font color="<? $td_fontcolor;?>">[ 
          NO Go Back ]</font></a> <a href="javascript:document.thisform.submit();" class="link_blue"><font color="<? $td_fontcolor;?>">[ 
          YES Continue ] </font></a></span></b></div></td>
    </tr>
  </table>
</form>

