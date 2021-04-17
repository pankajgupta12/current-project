<style>
.btnGroup {
	display:flex !important;
}
.mybtn {
    min-width: 120px;
    width: 120px !important;
    margin:30px 5px 0 0;
    padding: 10px !important;
	
}
</style>    
		<ul class="dispatch_top_ul dispatch_top_ul2_delete_import dispatch5">
		  <li style="float: right;width:80px;" class="back_buttone"><a href="../admin/index.php?task=delete_import" style="color:#fff;">Back</a></li>
		   <li style="white-space: nowrap;margin-top: 24px;"> <h4 >Import file name : <?php echo get_rs_value("c3cx_imports","org_file_name",$_GET['import_id']);  ?></h4></li>
		</ul>
		
		<ul class="dispatch_top_ul view_import_search ">
	                <li>
						<label>Admin</label>
					
				         <span><?php echo create_dd("admin","c3cx_users","3cx_user_name","3cx_user_name","","",$_SESSION['view_report_list']);?></span> 
				    </li>

					
                    <li>
						<label>Job ID/Quote ID</label>
                        <input name="name" type="text" id="job_quote" size="45" value="<?php if($_SESSION['view_report_list']['quote_job_id'] != '') { echo $_SESSION['view_report_list']['quote_job_id']; } ?>" >
					</li>	
					 <li class="btnGroup">
						<input type="submit" name="submit"  class="mybtn staff_button" onclick="search_view_call_report('<?php echo $_GET['import_id']; ?>');" value="Search">
						<input type="reset" name="reset"  class="mybtn back_buttone" onclick="reset_view_call_report('<?php echo $_GET['import_id']; ?>');" value="Reset">
					</li>	
				</ul>       
	 
	<span id="message_append"></span>
		<div id="quote_view">
		  <?php include( 'xjax/view_import_list.php' );?>
		</div>
    <script>
        $(document).on('click', '.loadmore', function() {
            $(this).text('Loading...');
            $.ajax({
                url: 'xjax/ajax/loadmore_viewimport.php',
                type: 'POST',
                datatype: 'html',
                data: {
                    page: $(this).data('page'),
                },
                success: function(response) {
                    if (response) {
                        $('.load_more').remove();
                        $("tr.parent_tr:last").after(response);
                    }
                }
            });
        });
    </script>