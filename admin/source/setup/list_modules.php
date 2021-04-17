<?  
session_start(); 
include("../functions.php");
include("../config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<? include("header.php"); ?>
<?
					$r=0;
					$arg = "select * from module_details";
					//echo $arg;
					$data = mysql_query( $arg);
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
<tr> 
    <td><font color="<? echo $table_fontcolor;?>">List Module Details</font></td>
  </tr>
</table>

<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="<? echo $table_bgcolor;?>">
  
  <tr class="boldtext"> 
    <td width="11%" bgcolor="<? echo $td_bgcolor;?>"> <div align="center"><font color="<? echo $td_fontcolor;?>">Module
          ID</font></div></td>
    <td width="34%" bgcolor="<? echo $td_bgcolor;?>"><font color="<? echo $td_fontcolor;?>">Title</font></td>
    <td width="20%" bgcolor="<? echo $td_bgcolor;?>"> <div align="center"><font color="<? echo $td_fontcolor;?>"> Options</font></div></td>
  </tr>
  <? 		
  While($r < (mysql_num_rows($data))){
					$id=mysql_result($data,$r,"module_id");
					$title=mysql_result($data,$r,"title");
					//$date=mysql_result($data,$r,"date"); 
  ?>
  <tr> 
    <td bgcolor="<? echo $td_bgcolor;?>"> <div align="center" class="text11"><font color="<? echo $text_color;?>"><? echo "$id";?> </font>
      </div></td>
    <td bgcolor="<? echo $td_bgcolor;?>"> <div align="left" class="text11"><font color="<? echo $text_color;?>"><? echo "$title";?> </font>
      </div></td>
    <td align="center" bgcolor="<? echo $td_bgcolor;?>"> <table border="0" cellspacing="0" cellpadding="2">
        <tr class="formfields"> 
          <td> <div align="center"><a href="<? $_SERVER['SCRIPT_NAME'];?>?task=<? echo "$t";?>&action=modify&id=<? echo "$id";?>"><img src="../../../../images/management/buttons/modify.jpg" width="49" height="13" border="0"></a></div></td>
          <td> <div align="center"><a href="<? $SCRIPT_NAME;?>?task=<? echo "$t";?>&action=delete&id=<? echo "$id";?>"><img src="../../../../images/management/buttons/delete.jpg" width="49" height="13" border="0"></a></div></td>
        </tr>
      </table></td>
  </tr>
  <? 
  $r++; 
  }
  ?>
</table>

</body>
</html>
