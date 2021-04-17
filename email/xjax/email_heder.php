
  <div class="row">

			
		<div class="col-md-7">	
		<button type="button" class="btn btn-default" data-toggle="tooltip" onclick="reloadPage();" title="Refresh">
				&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;</button>
		<div class="btn-group">
		    <span class="email_dd">
			  <?php  echo create_dd_select("priority","system_dd","id","name","type=53","Onchange=\"search_email(this.value,'priority');\"",$_SESSION['bcic_email'],'Priority');?>    
			</span>
			<span class="email_dd">
			  <?php  echo create_dd_select("email_assign","system_dd","id","name","type=51","Onchange=\"search_email(this.value,'email_assign');\"",$_SESSION['bcic_email'],'Status');?>    
			</span>

			<span class="email_dd ">
			  <?php echo create_dd_select("email_category","system_dd","id","name","type=50","Onchange=\"search_email(this.value,'email_category');\"",$_SESSION['bcic_email'],'Folder', ' order by name ASC');?>    
			</span>
			<span class="email_dd ">
			<?php echo create_dd_select("admin_id","admin","id","name","is_call_allow = 1 AND status = 1","Onchange=\"search_email(this.value,'admin_id');\"", $_SESSION['bcic_email'],'Admin', ' order by name ASC');?>
			</span>
			
			<!--<span class="email_dd"><?php  echo create_dd("email_status","system_dd","id","name","type=1","Onchange=\"check_fields_dropdown(this.value,'".$_SESSION['mail_details']."','Select Status');\"",$getValue);?></span>-->
			
		   <!--<input type="Reset" value="Reset" class="resetBtn" onClick="send_data('',4,'quote_view');">-->
		</div>
		</div>
		<div class="col-md-4">
				<div class="input-group">
				  <input type="text" class="form-control searchInput" id="email_search_id" value="<?php if($_SESSION['email_search_value'] != '') { echo $_SESSION['email_search_value']; } ?>" placeholder="Search for...">
				  <span class="input-group-btn">
					<button class="btn btn-default searchInputBtn" type="button" onClick="send_data(document.getElementById('email_search_id').value, 20,'quote_view');"><span class="glyphicon glyphicon-search"></span></button>
				  </span>
				  <span>
					 <input type="Reset" value="Reset" class="resetBtn" onClick="send_data('',4,'quote_view');">
				  </span>
				</div><!-- /input-group -->
			</div>
			
			
			<!--<div class="pull-right right_tet">
					<span class="text-muted"><b><?php echo $_SESSION['page_initial'] + 1; ?></b>–<b><?php echo $pagelimit; ?></b> of <b><?php echo $totalcount; ?></b></span>
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-default"  <?php if($_SESSION['page_initial'] > 0) { ?> onclick="prev_page('prev_page');"  <?php  }else { ?> id="prev_disabled_class" <?php  } ?> > 
							<span class="glyphicon glyphicon-chevron-left"  ></span>
						</button>
						
						<button type="button" class="btn btn-default" <?php if($_SESSION['page_limit'] > 0 && $_SESSION['page_initial'] < $totalcount) { ?> onclick="prev_page('next_page');" <?php  } if($_SESSION['page_initial'] > $totalcount) { ?> id="next_disabled_class" <?php  } ?>>
							<span class="glyphicon glyphicon-chevron-right"   ></span>
						</button>
					</div>
			</div>-->
    </div>

	
	