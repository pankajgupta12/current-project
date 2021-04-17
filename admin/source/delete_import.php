<style>
 .dispatch_top_ul2_delete_import li {
    margin: 30px 11px;
}
</style>
	<link href="../admin/css/general.css" rel="stylesheet" type="text/css">
	<div class="body_container">
		<!--<ul class="dispatch_top_ul dispatch_top_ul2_delete_import dispatch5">
				<li>
					<label>Imports file</label>
					 <span><?php // echo create_dd("imports_name","c3cx_imports","id","org_file_name","","Onchange=\"get_call_recordsByID(this.value);\"",'');?></span> 
				</li>
				<li>
				<input type="submit" style="margin-top: 29px;" class="job_submit" onClick="return deleteimportfiles();" name="deleteimport" value="delete">
				</li>
		</ul>-->
		<ul class="dispatch_top_ul dispatch_top_ul2_delete_import dispatch5">
		   <li><h3>Call Import Details</h3></li>
		</ul>
		
		    <div id="quote_view">
			   <?php include( 'xjax/delete_import.php' ); ?>
		    </div>
		
	</div>		