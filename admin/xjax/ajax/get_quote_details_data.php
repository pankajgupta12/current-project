<?php  

session_start();
include("../../source/functions/functions.php");
include("../../source/functions/config.php");

    if(isset($_POST)) { 
  
       $argsql1 = mysql_query("select id,name,email,phone from quote_new  where (id like '%".$_POST['qid']."%' OR name Like '%".$_POST['qid']."%') AND booking_id = 0 AND step != 10 AND  booking_date > '".date('Y-m-d')."' AND id not in (SELECT quote_id FROM `sales_system`)"); 
	   
	   $str = '';
	    $str .= '<ul>';
	    if(mysql_num_rows($argsql1) > 0) {
			
			
		    while($data = mysql_fetch_assoc($argsql1)) {

			 $qid = "'".$data['id']."'";
			 $name = "'".$data['name']."'";
			 $email = "'".$data['email']."'";
			 $phone = "'".$data['phone']."'";
			 $phone = "'".$data['phone']."'";
                 $str .= '<li onclick="getquoteid('.$qid.' ,'.$email.' , '.$phone.','.$name.')">Q#'.$data['id']. ' ( ' .$data['name'].')</li>';
            }
			
		}else{
			$str .= '<li>Not found</li>';
		}
		$str .= '</ul>';
		echo $str;
    }
  ?>
  <script>
    function getquoteid(id ,emails, phone,name) {
		//alert(id +'=='+emails+'=='+phone+'=='+name);
		 $('#get_name').text(name);
		 $('#get_emails').text(emails);
		 $('#get_mobile').text(phone);
		 $('#get_value').val(id);
		 $('#get_quote_details').html(''); 
		 $('#show_infodata').show();
		
	}
  </script>