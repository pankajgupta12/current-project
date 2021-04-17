<div class="view_quote_back_box">
	<div class="topbBarItems">
		  <ul class="bb_4tabs heading_view_quote">
				  <li><a href="/admin/index.php?task=active_staff">Cleaning</a></li>
				  <li><a href="/admin/index.php?task=active_staff&action=1">Carpet</a></li>
			</ul>
			
			<?php    if($_GTE['active_staff'] == '') { ?>
			     <button><a href="javascript:pdfdownload('cleaning_staff')">PDF</a> </button>
			<?php  } else {?>
			    <button><a href="javascript:pdfdownload('carpet_staff')">PDF</a> </button>
			<?php  } ?>
			
			</div>
</div>
<?php 
    
	 if($_GET['action'] == '') {
        $sql = "SELECT id , name , email , mobile , job_types FROM `staff` WHERE status = 1 AND FIND_IN_SET ('Cleaning' , job_types)";
	 }else {
		 $sql = "SELECT id , name , email , mobile , job_types FROM `staff` WHERE status = 1 AND !FIND_IN_SET ('Cleaning' , job_types)";
	 }
 $query = mysql_query($sql);
  
?>
 <br>
 <br>
	<div id="quote_view">
			<table class="user-table" border="1px">
					<thead >
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>job Type</th>
						</tr>
					</thead>
					  
					<tbody>
					
					<?php  if(mysql_num_rows($query) > 0) { 
					
					  while($getdata =  mysql_fetch_assoc($query)) {
					?>
					  <tr>
						 <td> <?php echo $getdata['id']; ?> </td>
						 <td> <?php echo $getdata['name']; ?> </td>
						 <td> <?php echo $getdata['email']; ?> </td>
						 <td> <?php echo $getdata['mobile']; ?> </td>
						 <td> <?php echo $getdata['job_types']; ?> </td>
					  </tr>
					  <?php   } } ?>
					
					</tbody>
					
			</table>		
    </div>
	
	  <script type="text/javascript">
		$(document).ready(function(){
			var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
			$('.heading_view_quote [href$="'+url+'"]').parent().css('background-color','#00b8d4');
		});

			function pdfdownload(name)
				{
					var prtContent = document.getElementById("quote_view");
					var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
					WinPrint.document.write(prtContent.innerHTML);
					WinPrint.document.close();
					WinPrint.document.title = name+'.pdf';
					WinPrint.focus();
					WinPrint.print();
					WinPrint.close();
				}
			</script>	