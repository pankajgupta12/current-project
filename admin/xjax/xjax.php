<? session_start(); 
/* 
ini_set('display_errors', 'On');
    error_reporting(E_ALL); */
//echo $_GET['xt']; die;
include('googleShortUrl.php');
include($_SERVER['DOCUMENT_ROOT']."/admin/source/functions/functions.php");
include($_SERVER['DOCUMENT_ROOT']."/admin/source/functions/config.php") ;
include("../class/VoipCall.php");



   if($_SESSION['admin'] != '') 
    {
	 
		/*  $adminname = get_rs_value("admin","name",$_SESSION['admin']);
		 $log  = "User: ".$_SERVER['REMOTE_ADDR'].'__'.date("F j, Y, g:i a").PHP_EOL.
		 "Attempt: Click ".date("Y-m-d: H:i:s")." ".PHP_EOL.
		 "-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		 file_put_contents($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/logg/'.$adminname.'_log_'.date("j.n.Y").'.log', $log, FILE_APPEND); */


    

	 
	if($_GET['xt']!=""){
					
		if ($_GET['sid']!=""){
			if (session_id()==$_GET['sid']){
				switch ($_GET['xt'])
				{
					// userd in try folder 
					case "1": delete_quote($_GET['var']);  return false;
					case "2": get_quote($_GET['var']); return false;
					case "3": select_team($_GET['var']); return false;
					case "4": edit_b_status($_GET['var']); return false;
					case "5": edit_pay_status($_GET['var']); return false;
					case "6": edit_booking_table($_GET['var']); return false;
					case "7": add_job_types($_GET['var']); return false;
					
					// here we convert quotes to job from view quote
					case "8": list_quote_book_now($_GET['var']); return false;
					// here we convert quote to jobs from quote form 
					case "9": edit_quote_book_now($_GET['var']); return false;
					
					case "10": update_quote_payments($_GET['var']); return false;
					
					case "11": assign_staff_job($_GET['var']); return false;
					case "12": refresh_dispatch($_GET['var']); return false;
					case "13": refresh_dispatch_tab($_GET['var']); return false;
					// dispatch search 
					case "14": get_staff_by_site_id($_GET['var']); return false;
					case "15": get_staff_by_site_job_type($_GET['var']); return false;
					case "16": edit_dispatch_from_date($_GET['var']); return false;
					case "17": edit_dispatch_staff_id($_GET['var']); return false;
					// dispatch side
					case "18": keyword_search_dispatch_side($_GET['var']); return false;
					case "19": status_search_dispatch_side($_GET['var']); return false;
					case "20": refresh_dispatch_side($_GET['var']); return false;
					
					case "21": edit_field($_GET['var']); return false;
					case "22": delete_job_details($_GET['var']); return false;
					
					case "23": add_comments($_GET['var']); return false;
					
					case "24": send_job_emails($_GET['var']); return false;
					case "25": send_job_sms_new($_GET['var']); return false;
					
					case "26": job_email_template($_GET['var']); return false;
					case "27": email_quote($_GET['var']); return false;
					
					case "28": email_invoice_item($_GET['var']); return false;
					
					case "29": add_job_payment($_GET['var']); return false;
					case "30": delete_job_payment($_GET['var']); return false;
					
					case "31": get_staff_dd_job_type($_GET['var']); return false;			
					case "32": add_job_details($_GET['var']); return false;			
					case "33": delete_job($_GET['var']); return false;
					
					case "34": refresh_payment_report($_GET['var']); return false;
					case "35": refresh_tpayment_report($_GET['var']); return false;
					
					case "36": make_paid_team_payment($_GET['var']); return false;
					case "37": email_staff_team_payment($_GET['var']); return false;

					case "38": search_view_quote($_GET['var']); return false;
					
					case "39": refresh_payment_report_all($_GET['var']); return false;
					
					case "40": add_journal_entery($_GET['var']); return false;
					case "41": refresh_journal_report($_GET['var']); return false;			
					

					case "42": get_postcode($_GET['var']); return false;			
					case "43": refresh_daily_report($_GET['var']); return false;
					
					case "44": quote_called($_GET['var']); return false;
					case "445": sms_quote($_GET['var']); return false;
					
					
					//After sms_quote update desc
					case "450": updatespringdesc($_GET['var']); return false;
					//case "450": updatespringdesc($_GET['var']); return false;
					
					
					
					
					//for view quote (Pankaj added)
					case "446": quote_approved($_GET['var']); return false;
					case "447": quote_incomplete($_GET['var']); return false;
					case "448": view_quote_status_change($_GET['var']); return false;
					
					//for custom sms_code
					case "449": custom_sms($_GET['var']); return false;
					case "455": app_custom_sms($_GET['var']); return false;
					case "451": sms_accept_terms_agreement($_GET['var']); return false;
					
					
					case "452": paymentByToken($_GET['var']); return false;
					
					// new quote system is starting from here 						
					case "45": check_availability($_GET['var']); return false;			
					case "46": create_quote_object($_GET['var']); return false; 
					case "47": add_quote_object($_GET['var']); return false; 
					case "48": save_quote($_GET['var']); return false; 			
					case "49": edit_field_quote($_GET['var']); return false;			
					case "50": delete_quote_temp($_GET['var']); return false; 			
					case "51": recalc_quote_temp($_GET['var']); return false;
					
					case "52": add_quote_comments($_GET['var']); return false;
					case "53": view_quote_side($_GET['var']); return false;
					
					case "54": edit_quote_details($_GET['var']); return false;
					case "55": edit_quote_edit_field($_GET['var']); return false;
					case "56": add_edit_quote_item($_GET['var']); return false;
					case "57": delete_quote_details($_GET['var']); return false;
					
					case "58": refresh_edit_quote_str($_GET['var']); return false;
					case "59": remove_job_token($_GET['var']); return false;
					case "60": get_postcode_edit($_GET['var']); return false;
					case "61": delete_journal($_GET['var']); return false;
					case "62": staff_reatting_update($_GET['var']); return false;
					
					//For Header
					case "71": notification_data($_GET['var']); return false;
					case "72": quote_details_show($_GET['var']); return false;
					case "73": quote_details_show($_GET['var']); return false;
					case "74": refress_notification($_GET['var']); return false;
					case "75": refress_main_headr($_GET['var']); return false;
					case "76": refress_notification_icone($_GET['var']); return false;
					case "77": quote_details_show($_GET['var']); return false;
					case "78": asc_order_notification($_GET['var']); return false;
					case "79": memberdetailsShow($_GET['var']); return false;
					
					//Update Suberb in create Quote
					case "81": updateSiteid($_GET['var']); return false;
					case "82": create_bbc_job_type($_GET['var']); return false;
					case "83": create_br_job_type($_GET['var']); return false;
					
					
					//Application reports
					case "85": edit_fields_applications($_GET['var']); return false;	
					case "86": dispatch_report_quote_type($_GET['var']); return false;	
					
				    case "87": edit_app_status($_GET['var']); return false;	
					
					
					
					//Start Dispatch Report Function
					case "89": dispatch_report_team_id($_GET['var']); return false;
					case "90": dispatch_report_to_date($_GET['var']); return false;
					case "91": dispatch_report_from_date($_GET['var']); return false;
					case "92": check_dispatch_report_sms($_GET['var']); return false;
					case "93": dispatch_report_by_location($_GET['var']); return false;
					case "94": reset_dispatchreport($_GET['var']); return false;
					
					// End of Dispatch Report Function
					
					// Call 3cx Report
					
					case "95": update_call_import($_GET['var']); return false;
					case "96": get_call_records($_GET['var']); return false;
					case "97": get_call_records_by_fromdate($_GET['var']); return false;
					case "98": get_call_records_by_todate($_GET['var']); return false;
					case "99": get_call_records_by_Quote_job($_GET['var']); return false;
					case "100": get_call_records_reset($_GET['var']); return false;
					case "101": import_edit_quote($_GET['var']); return false;
					case "102": delete_call_import($_GET['var']); return false;
					case "103": delete_call_allimportfiles($_GET['var']); return false;
					case "104": get_call_recordsByID($_GET['var']); return false;
					case "105": get_staff_name($_GET['var']); return false;
					case "106": update_staffname($_GET['var']); return false;
					case "111": delete_call_allimportfilesByid($_GET['var']); return false;
					
					
						// Only Used For Staff Section
					case "112": get_staff_joblist($_GET['var']); return false;
					case "113": job_read_notification($_GET['var']); return false;
					
					case "114": recheckimportFile($_GET['var']); return false;
					case "115": adminrecheckimportFile($_GET['var']); return false;
					
					// Staff job type page Auto refress
					case "107": staff_assigned_job_page($_GET['var']); return false;
					case "121": staff_assigned_unassigned($_GET['var']); return false;
					case "122": jobStatuscheck_dispatchReport($_GET['var']); return false;
							
					// Quote Report System
					case "131": quote_report_by_location($_GET['var']); return false;
					case "132": quote_report_by_date($_GET['var']); return false;
					case "133": quote_report_reset($_GET['var']); return false;
					case "134": quote_report_status($_GET['var']); return false;
					
					//Booking Quote report System 
					case "135": booking_report_by_date($_GET['var']); return false;
					case "136": booking_report_by_location($_GET['var']); return false;
					case "137": booking_report_reset($_GET['var']); return false;
					
					
					//Call Report System  
					case "141": call_report_by_date($_GET['var']); return false;
					case "142": call_report_by_admin($_GET['var']); return false;
					case "143": reset_callreportsystem($_GET['var']); return false;
					case "144": get_from_to_callreport($_GET['var']); return false;
					
					// Call Report System dashboard
					case "146": call_report_dashboard($_GET['var']); return false;			
					case "147": reset_report_dashboard($_GET['var']); return false;

					case "148": quote_report_dashboard($_GET['var']); return false;			
					case "149": reset_quote_report_dashboard($_GET['var']); return false;			
					case "150": gethourlyReport($_GET['var']); return false;			
					
					//Staff note add staff_add_comments
					case "151": staff_add_comments($_GET['var']); return false;
					//Call Hourly report reset
					case "152": reset_call_hourly_report($_GET['var']); return false;
					
					
					// Daily Report System
					case "156": called_type_report($_GET['var']); return false;
					
					//View Quote 
					case "161": view_quote_response($_GET['var']); return false;
					case "162": view_quote_pending($_GET['var']); return false;
					case "163": view_quote_advance_searching($_GET['var']); return false;
					case "164": advance_searching_reset($_GET['var']); return false;
					case "165": view_quote_admin_denied($_GET['var']); return false;
					
					//Update Description in edit Quote 
					case "166": update_edit_desc($_GET['var']); return false;
					
					
					//Making  For version 5.3 Case
					//  For Reclean getstaff
					case "171": get_staff_reclean_details($_GET['var']); return false;
					case "172": add_reclean_jobs($_GET['var']); return false;
					case "173": delete_job_reclean_details($_GET['var']); return false;
					case "174": send_reclen_job_sms($_GET['var']); return false;
					case "175": send_reclen_email($_GET['var']); return false;
					case "176": check_reclean_report_sms($_GET['var']); return false;
					case "177": reclean_reportby_date($_GET['var']); return false;
					case "178": reclean_reportby_Site($_GET['var']); return false;
					case "179": reclean_reset($_GET['var']); return false;
					case "180": add_comment_reclean($_GET['var']); return false;
					
					//Quote with Status Report
					case "181": quote_with_status($_GET['var']); return false;
					case "182": reset_quote_with_status($_GET['var']); return false;
				   
					//Reclean report
					case "186": reclean_reportby_to($_GET['var']); return false;
					case "187": reclean_reportby_status($_GET['var']); return false;
					
					//Quote hourly reports
					case "190": gethourlyreportbydate($_GET['var']); return false;
					//Reclean report
					case "191": refress_reclean_notes($_GET['var']); return false;
					
					case "192": reset_hourlyreport($_GET['var']); return false;
					
					//Get Hourly Report by Site Name
					case "193": gethourlyreportBySite($_GET['var']); return false;
					case "194": gethourlyreporttodate($_GET['var']); return false;
					
					//Auto Logout check Session
					case "201": clearSessionOnDemand($_GET['var']); return false;
					
					// Google Address Update in edit Quote
					case "206": lat_long_update($_GET['var']); return false;
					
					//Theme Change
					case "211": theme_change($_GET['var']); return false;
					
					case "215": urgent_notification_data($_GET['var']); return false;
					case "216": refress_urgent_notification($_GET['var']); return false;
					
					//function case , when admin will press delete icon.
					case "217": refreshNotificationAfterDeleteMarked($_GET['var']); return false;
					case "218": urgentNotirefress($_GET['var']); return false;
					
					//For Specfic Re-Clean Notse	
					case "221": specfic_add_comment_reclean($_GET['var']); return false;
					case "222": checkquoteBookStatus($_GET['var']); return false;
					case "223": checkquotebooked($_GET['var']); return false;
					case "224": editcheckbooked($_GET['var']); return false;
					
					//	Search job UnAssigned		
					case "225": searching_job_unassigned($_GET['var']); return false;
					case "226": unassigned_reset($_GET['var']); return false;

					//postCode add in staff section
					case "230": show_add_task_list($_GET['var']); return false;
					case "231": add_primary_postcode($_GET['var']); return false;
					case "232": remove_postcode($_GET['var']); return false;
					case "233": message_borad($_GET['var']); return false;
					case "234": message_send($_GET['var']); return false;
					case "235": delete_message_board($_GET['var']); return false;
					case "236": get_staff_location($_GET['var']); return false;
					
					case "237": add_task_message_send($_GET['var']); return false;
					case "238": search_task_message($_GET['var']); return false;
					case "239": assigned_admin_task($_GET['var']); return false;
					case "240": update_message_status($_GET['var']); return false;
					
					
					//Job report Search
					case "241": get_allstaffname($_GET['var']); return false;		
					case "242": search_job_reports($_GET['var']); return false;		
					case "243": reset_job_reports($_GET['var']); return false;		
					
					case "244": get_chat_notification($_GET['var']); return false;		
					case "245": search_get_staff_name($_GET['var']); return false;		
					case "246": reset_dispatch_board($_GET['var']); return false;		
					case "247": universal_search_page($_GET['var']); return false;		
					case "248": search_all_details($_GET['var']); return false;		
					case "249": advance_search_payment_report($_GET['var']); return false;		
					case "250": reset_payment_report($_GET['var']); return false;		
					case "251": advance_search_payment_report_all($_GET['var']); return false;		
					case "252": reset_payment_report_all($_GET['var']); return false;		
					
					// Send SMS IN Dialy Report page
					case "253": sms_for_staff($_GET['var']); return false;		
					case "254": check_job_available($_GET['var']); return false;		
					case "255": send_email_agent($_GET['var']); return false;		
					case "256": send_email_reclean_agent($_GET['var']); return false;		
					case "257": search_quote_dashboard($_GET['var']); return false;		
					case "258": search_quote_status_report($_GET['var']); return false;		
					case "259": quote_dashboard_hourly_report($_GET['var']); return false;		
					case "260": quote_dashboard_daily_report_1($_GET['var']); return false;		
					case "261": add_client_info($_GET['var']); return false;		
					case "262": delete_client_info($_GET['var']); return false;		
					case "263": create_email_crons($_GET['var']); return false;		
					case "264": delete_terms_agreement($_GET['var']); return false;		
					case "265": terms_agreement_status($_GET['var']); return false;		
					case "266": send_agent_email($_GET['var']); return false;		
					case "267": send_invoice_attach($_GET['var']); return false;		
					case "268": delete_application($_GET['var']); return false;		
					case "269": application_emails($_GET['var']); return false;		
					case "270": application_search($_GET['var']); return false;		
					case "271": application_add_comment($_GET['var']); return false;		
					case "272": get_agent_message($_GET['var']); return false;		
					case "273": get_email_address($_GET['var']); return false;		
					case "274": get_job_avail_by_job_id($_GET['var']); return false;		
					case "275": review_client_email($_GET['var']); return false;		
					case "276": view_quote_oto_flag($_GET['var']); return false;		
					case "277": delete_sub_staff($_GET['var']); return false;		
					case "278": search_client_review($_GET['var']); return false;		
					case "279": search_sub_staff($_GET['var']); return false;		
					case "280": recheck_oto($_GET['var']); return false;		
					case "281": reclean_send_email($_GET['var']); return false;		
					case "282": search_sales_report($_GET['var']); return false;		
					
					case "300": search_view_call_report($_GET['var']); return false;
					case "301": job_deny_by_admin($_GET['var']); return false;
					case "302": application_job_type($_GET['var']); return false;
					case "303": view_quote_job_type($_GET['var']); return false;
					
					case "1081": referesh_quote_comments($_GET['var']); return false;
					case "1082": getSmsNotifcation($_GET['var']); return false;
					
					case "400": franchise_report_gererate($_GET['var']); return false;
					case "401": updateaddress($_GET['var']); return false;
					
					case "402": staff_invoice_report($_GET['var']); return false;
					case "403": send_staff_invoice($_GET['var']); return false;
					case "404": search_all_invoice_report($_GET['var']); return false;
					case "405": invoice_generate($_GET['var']); return false;
					case "406": send_monthly_invoice($_GET['var']); return false;
					case "407": calculate_moving_depot_time($_GET['var']); return false;
					case "408": get_real_estate_name($_GET['var']); return false;
					case "409": edit_get_real_estate_name($_GET['var']); return false;
					case "410": re_search_payment_report($_GET['var']); return false;
					case "411": search_real_agent_name($_GET['var']); return false;
				
					
					// BR Quote Case Start
					case "501": create_br_quote($_GET['var']); return false;
					case "502": save_br_quote($_GET['var']); return false;
					case "503": send_inventory_email($_GET['var']); return false;
					case "504": send_inventory_sms($_GET['var']); return false;
					
					
					case "506": save_moving_address($_GET['var']); return false;
					case "507": job_unassign_job_type($_GET['var']); return false;
					
					
					case "510": save_br_quote_data($_GET['var']); return false;
					case "511": get_dispatch_board($_GET['var']); return false;
					case "512": truck_assign($_GET['var']); return false;
					
					case "513": save_clener_notes($_GET['var']); return false;
					case "514": get_cleaner_report($_GET['var']); return false;
					
					
					
					
					
					//Real Estate Payement
					case "515": create_re_invoice($_GET['var']); return false;
					case "516": call_take($_GET['var']); return false;
					case "517": get_slot_page($_GET['var']); return false;
					case "518": reshedule_call($_GET['var']); return false;
					case "519": message_board_search($_GET['var']); return false;
					case "520": slot_booking_date($_GET['var']); return false;
					case "521": call_reverse($_GET['var']); return false;
					case "522": send_ng_email($_GET['var']); return false;
					case "523": quote_call_search($_GET['var']); return false;
					case "524": update_notes_id($_GET['var']); return false;
					case "525": send_full_info($_GET['var']); return false;
					case "526": job_sms_change($_GET['var']); return false;
					case "527": send_sms_for_job_accept($_GET['var']); return false;
					
					case "528": get_review_report($_GET['var']); return false;
					
					case "529": getReviewEmailDetails($_GET['var']); return false;
					case "530": getQuoteQuestionsList($_GET['var']); return false;
					case "531": saveQuoteQuestions($_GET['var']); return false;
					case "532": search_cleaning_amt_report($_GET['var']); return false;
					case "533": search_imagelink($_GET['var']); return false;
					case "534": get_staff_fixed_rates($_GET['var']); return false;
					case "535": getInvoiceDetails($_GET['var']); return false;
					case "536": get_sale_sms_report($_GET['var']); return false;
					case "537": stop_sales_sms($_GET['var']); return false;
					case "538": real_estate_report($_GET['var']); return false;
					case "539": get_report_dashboard($_GET['var']); return false;
					case "540": enquiry_send_to_cbd($_GET['var']); return false;
					case "541": send_frenchaie_report($_GET['var']); return false;
					case "543": getNotificationAll($_GET['var']); return false;
					case "544": amount_refund($_GET['var']); return false;
					case "545": refund_status_changes($_GET['var']); return false;
					case "546": delete_payment_refund($_GET['var']); return false;
					case "547": payment_refund_job_status($_GET['var']); return false;
					case "548": get_review_roport_notes($_GET['var']); return false;
					case "549": send_review_email_report($_GET['var']); return false;
					case "550": refund_payment($_GET['var']); return false;
					case "551": add_3pmcehck_notes($_GET['var']); return false;
					case "552": add_quote_cehck_notes_comment($_GET['var']); return false;
					case "553": cehck_3pm_report($_GET['var']); return false;
					case "554": cehck3pM($_GET['var']); return false;
					case "555": sales_stages($_GET['var']); return false;
					case "556": set_message_type($_GET['var']); return false;
					case "557": get_notification($_GET['var']); return false;
					case "558": send_refund_emails($_GET['var']); return false;
					case "559": searchEmailreport($_GET['var']); return false;
					case "560": dailyemailreport($_GET['var']); return false;
					case "561": check_adminlogin($_GET['var']); return false;
					case "562": search_tasklist($_GET['var']); return false;
					case "563": cehck_account_realestate($_GET['var']); return false;
					case "564": cehck_avail_sms($_GET['var']); return false;
					case "565": check_status($_GET['var']); return false;
					case "566": download_job_invoice($_GET['var']); return false;
					case "567": client_images_move($_GET['var']); return false;
					case "568": admin_admin_fault($_GET['var']); return false;
					case "569": select_email_template_data($_GET['var']); return false;
					case "570": getpersnal_noti($_GET['var']); return false;
					case "571": read_notification($_GET['var']); return false;
					case "572": sales_auto_fallow($_GET['var']); return false;
					case "573": lost_quote($_GET['var']); return false;
					case "574": search_fault_data($_GET['var']); return false;
					case "575": search_task_report($_GET['var']); return false;
					case "576": search_admin_task($_GET['var']); return false;
					case "577": search_track_report($_GET['var']); return false;
					case "578": movequoteto_anotherlogin($_GET['var']); return false;
					case "579": a_search_sales_search($_GET['var']); return false;
					case "580": search_quote_lilstdata($_GET['var']); return false;
					case "581": send_voucher_emails($_GET['var']); return false;
					case "582": admin_search_taskreport($_GET['var']); return false;
					case "583": total_task_show($_GET['var']); return false;
					case "584": add_cancelled_reason($_GET['var']); return false;
					case "585": payment_refund_page($_GET['var']); return false;
					case "586": save_checklist_data($_GET['var']); return false;
					case "587": save_checklist_ans_data($_GET['var']); return false;
					case "588": search_opration_admin_task($_GET['var']); return false;
					case "589": search_new_operation($_GET['var']); return false;
					case "590": call_cleaner_before_jobs($_GET['var']); return false;
					case "591": call_review_date($_GET['var']); return false;
					case "592": send_awatting_sms($_GET['var']); return false;
					case "593": get_bbc_weekly_job_report($_GET['var']); return false;
					case "594": get_stafftypedata($_GET['var']); return false;
					case "595": get_complaint_job($_GET['var']); return false;
					case "596": get_complaint_notes($_GET['var']); return false;
					case "597": add_complaite_cehck_notes_comment($_GET['var']); return false;
					case "598": show_job_list_comp($_GET['var']); return false;
					case "599": save_job_id_in_com($_GET['var']); return false;
					case "600": bbc_leads_quote($_GET['var']); return false;
					case "601": search_team_payment($_GET['var']); return false;
					case "602": get_business_qus($_GET['var']); return false;
					case "603": getcompany_details($_GET['var']); return false;
					case "604": get_realestatelist($_GET['var']); return false;
					case "605": realestateinfo($_GET['var']); return false;
					case "606": email_image_upload($_GET['var']); return false;
					case "607": getclenerdata($_GET['var']); return false;
					case "608": complantsendtoclener($_GET['var']); return false;
					case "609": save_complaintinfo($_GET['var']); return false;
					case "610": quote_compare($_GET['var']); return false;
					case "611": reset_quote_compare($_GET['var']); return false;
					case "612": send_new_sms_noti($_GET['var']); return false;
					case "613": send_sms_hr($_GET['var']); return false;
					case "614": refress_wall_board($_GET['var']); return false;
					case "615": s_invoice($_GET['var']); return false;
					case "616": search_re_quote($_GET['var']); return false;
					case "617": getRequoteInfo($_GET['var']); return false;
					case "618": addrequoteNotes($_GET['var']); return false;
					case "619": sendreQuotetext($_GET['var']); return false;
					case "620": removeNotification($_GET['var']); return false;
					case "621": searchUrgentNoti($_GET['var']); return false;
					case "622": changfeWallBoardDate($_GET['var']); return false;
					case "623": search_monthly_admin_roster($_GET['var']); return false;
					case "624": daily_call_get($_GET['var']); return false;
					case "625": task_add($_GET['var']); return false;
					case "626": check_noti_popup($_GET['var']); return false;
					case "627": reshuffle($_GET['var']); return false;
					case "631": trackReivew($_GET['var']); return false;
					case "632": hr_side_panel($_GET['var']); return false;
					case "633": add_comment_notes($_GET['var']); return false;
					case "634": search_application_track($_GET['var']); return false;
					
					case "635": application_status_track($_GET['var']); return false;
					case "636": review_side_panel($_GET['var']); return false;
					case "637": sendreviewSMS($_GET['var']); return false;
					case "638": review_track($_GET['var']); return false;
					
					case "639": sop_manual_email($_GET['var']); return false;
					
					case "640": search_bookedJobs($_GET['var']); return false;
					
				   case "641": cehck_call($_GET['var']); return false;
				   case "642": update_job_type($_GET['var']); return false;
				   
				   case "643": search_bbc_invoive($_GET['var']); return false;
				   
				   case "644": paidlead($_GET['var']); return false;
				
				   default : 
					 echo "xt not in list: ".$_GET['xt'];
			    }
			}else{
				echo "session id ".session_id(). " != ".$_GET['sid']."<br>";
			}
		}else{
			echo "sid is nothing ";
		}

		}else{
		echo "xt not found ";
		}
	}
	  else
	  {
		echo "Your session has been expired. Please login again"; 
	}	


function get_agent_message($var){
	
	// Jobid|type
	// 1=> Agent , 2=> Client
	$vars = explode('|', $var);
	$job_id = $vars[0];
	$type = $vars[1];
	
	if($type != 0 ){ 
		$quote = mysql_fetch_array(mysql_query("select id,name ,address  from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
		$jobDetails = mysql_fetch_array(mysql_query("select id, agent_name from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		$getJob_date = mysql_fetch_array(mysql_query("select reclean_date from job_reclean where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		if($type == 1) {
			$name = $jobDetails['agent_name'];
		}elseif($type == 2) {
			$name = $quote['name'];
		}
		
		  $eol = '<br>';
		
		$message = $eol.'Hello '.$name.','.$eol.$eol.' We had conducted the bond clean at  '.$quote['address'].' and would like to confirm that the reclean was completed by our cleaner on  '.changeDateFormate($getJob_date['reclean_date'], 'datetime').'.'.$eol.' Please confirm if the property has passed your inspection in order for us to close off this job. '.$eol.' Should we not hear back from you in the next 48 hours we will consider this job as closed.'; 
		
		echo ($message);
	}else{
		echo '';
	}
}

function get_email_address($var){
	$vars = explode('|', $var);
	$job_id = $vars[0];
	$type = $vars[1];
	
	if($type != 0 ){ 
		$quote = mysql_fetch_array(mysql_query("select email from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
		$jobDetails = mysql_fetch_array(mysql_query("select agent_email from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		$getJob_date = mysql_fetch_array(mysql_query("select reclean_date from job_reclean where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		if($type == 1) {
			$email = $jobDetails['agent_email'];
		}elseif($type == 2) {
			$email = $quote['email'];
		}
		echo '<input type="text" name="agent_email" id="agent_email" value="'.$email.'" placeholder="Enter agent email address" style="width: 225px;height: 25px;" />';
		//echo ($email);
	}else{
		echo '<input type="text" name="agent_email" id="agent_email" value="" placeholder="Enter agent email address" style="width: 225px;height: 25px;" />';
	}
}


function terms_agreement_status($str){
	
	//echo $str;
	
	 $vars = explode('|',$str);
	 $value = $vars[0];
	 $id = $vars[1];
	 $quote_type = $vars[2];
	 if($value == 1) {
	   $bool = mysql_query("update terms_agreement set status = 0 where quote_type = ".$quote_type."");
	 }
	 $bool = mysql_query("update terms_agreement set status = ".$value." where id = ".$id."");
	 
	 $getData1 = mysql_fetch_array(mysql_query("Select status from terms_agreement where id = ".$id.""));
	 
	 echo create_dd("status","system_dd","id","name","type=1","Onchange=\"terms_agreement_status(this.value,".$id." , ".$quote_type.");\"",$getData1);
	
}


function delete_terms_agreement($str){
	
	 if($str != '' && $str != 0) {
	    mysql_query("UPDATE `admin_terms_agreement` SET `is_deleted` = '0' WHERE  id = ".$str."");
	 }
}


function create_email_crons($str){
	
	
	$getDetails = mysql_fetch_assoc(mysql_query("Select * from email_config where id = ".$str.""));
	//print_r($getDetails);
	//Create_Crons($getDetails);
	 	 
	$path = '/usr/bin/wget -q -O --no-check-certificate ';
	$sitePath = PRE_SITE_NAME; //'https://www.beta.bcic.com.au';
	
	$cronType = $getDetails['email_type']; //$_POST['crontType'];
	
	$cronPath = '/admin/crons/mail/source/cron_bcic_email.php?all_params=' . strtolower($cronType) . '___Sent';
	
	$optional = '> /dev/null 2>&1';
	
	$command = $path . $sitePath . $cronPath . $optional;
	
	exec("crontab -l | { cat; echo '*/3    *    *    *    *    {$command}'; } |crontab -");
	
	$path = '/usr/bin/wget -q -O --no-check-certificate ';
	$sitePath = PRE_SITE_NAME; //'https://www.beta.bcic.com.au';
	
	$cronPath = '/admin/crons/mail/source/cron_bcic_email.php?all_params=' . strtolower($cronType) . '___INBOX';
	
	$optional = '> /dev/null 2>&1';
	
	$command = $path . $sitePath . $cronPath . $optional;
	
	shell_exec("crontab -l | { cat; echo '*/2    *    *    *    *    {$command}'; } |crontab -");

	//update into table
	$bool = mysql_query("Update email_config set is_cron_added = 1 where id  = ".$str."");	
	
	echo "cron created";
	
}


function universal_search_page($str){
	//echo "hello";
	include('universal_search_page.php');
}

function search_all_details($str){
	// echo $str;
	if($str != '') {
	    $_SESSION['search_popup']['key'] = $str;
	}
	include('universal_search_page.php');
}

function reset_dispatch_board($str){
	
	$_SESSION['dispatch']['from_date'] = date("Y-m-d");
	unset($_SESSION['dispatch']['quote_for']);
	unset($_SESSION['dispatch']['site_id']);
	unset($_SESSION['dispatch']['job_type']);
	unset($_SESSION['dispatch']['staff_id']);
	include('dispatch.php');
	
}

function search_get_staff_name($val){
	
			$str= '';
			$str.= "select * from staff where status=1";
			$str.= " AND  name like '%".mysql_real_escape_string($val)."%'";
			
		if(isset($_SESSION['dispatch']['site_id']) && $_SESSION['dispatch']['site_id']!="0"){
		    $str.= " AND (site_id=".$_SESSION['dispatch']['site_id']." or site_id2=".$_SESSION['dispatch']['site_id'].")";
		}
		
		if(isset($_SESSION['dispatch']['job_type']) && $_SESSION['dispatch']['job_type']!="0"){ 
			$str.=" AND job_types like '%".$_SESSION['dispatch']['job_type']."%'"; 
		}
		//echo $str; die;
		$data = mysql_query($str);
		$strx = "<ul class=\"post_list\">";
		$countResult = mysql_num_rows($data);
		if($countResult >  0) {
			while($r=mysql_fetch_assoc($data)){
				
				//print_r($r); 
				$strx.="<li><a href=\"javascript:select_staffname_dispatch('".$r['id']."','".$r['name']."')\">".$r['name']."</a></li>";
			}	
		}else {
          $strx.="<li>No staff Found</li>";
		}
		$strx.="</ul>";
		echo $strx;
}


function get_chat_notification($str){
	
	   $getChatCounter= ("Select * FROM `chat` WHERE receiver_read =  'no' AND chat_type = 'staff'"); 
	   
    $getnotification = mysql_query($getChatCounter);
    
                 $countnotef1 = mysql_num_rows($getnotification);
                 if($countnotef1 > 0){
                     $n_count1 = $countnotef1;
                     $flag = 1;
                 }else{
                     $n_count1 = '';
                 }
                  
                 $str =  ' <a href="../chat/index.php?task=admin" class="bc_slide_toggle">
		               <img class="bd_notifi" src="../admin/images/DAILY-RE.png" alt="Notification">';
                 if($flag == 1) {
                            $str .=   "<span class='bd_notification chat_notification'>".$n_count1."</span>";
                }
     $str .= 'Chat </a>';
    echo $str;
   //echo $countnotef1;
}



function get_allstaffname($var){
	
			$string = explode('|',$var);

			$str = $string[0];
			$stafftype = $string[1];
        if($str != '') {
			
				$data = mysql_query("select id, name  from staff where (name like '%".mysql_real_escape_string($str)."%' or id like '%".mysql_real_escape_string($str)."%') AND better_franchisee = '".$stafftype."'");
				$strx = "<ul class=\"post_list\">";

				$count  = mysql_num_rows($data);
				if($count > 0) {
				while($r=mysql_fetch_assoc($data)){
				$strx.="<li><a href=\"javascript:select_staff_in_fields('".$r['id']."','".trim($r['name'])."')\">".trim($r['name'])."</a></li>";
				}
				}else{
				$strx.="<li>Not found</li>";	  
				}	
				$strx.="</ul>";
				echo $strx;
		}
}


function reset_job_reports(){
	
	
	
	   $_SESSION['job_report'] = '';
		unset($_SESSION['job_report']); 
      //print_r($_SESSION['job_report']); 
		include("view_job_reports.php");
}
function get_staff_location($str){
  //  echo $str;
   $vars = explode('|',$str);
   
   $_SESSION['staff_location']['staff_location_date'] = $vars[0];
  echo  $staff_id  = $vars[1];
  // include('staff_location.php');
}

function show_add_task_list(){
	 include('task_message_board.php'); 
}

function message_borad($str){
    
   
	 include('message_board.php'); 
}

function delete_message_board($str)
{
   // $strvar = explode('|',$str);
	
	$message_read_user = get_sql("message_board","message_read_user","where id=".$str);
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$r_msg = '';
	
	$currentDate = date('Y-m-d H:i:s');
	if($message_read_user != '') { $r_msg = $message_read_user.','; }
    $messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
    
    $qryBool = mysql_query( "UPDATE message_board SET status = 1,message_read_user = '".$messageRead."' WHERE id = {$str}" );
    
    //mysql_query("UPDATE `message_board` SET `status` = '1' WHERE  `id` = ".$str);
    	 include('message_board.php'); 
}
 
function assigned_admin_task($str){

    $vars =  explode('|' ,$str); 
	 
	$value = $vars[0];
	$id = $vars[1];
	
	if($value > 0 ){
	   
	  // $adminname = get_rs_value("site_notifications","sales_id",$_SESSION['admin']);
	   
	  // echo  "Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where notification_id=".$id."";
	    $getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where notification_id=".$id.""));
	    //echo 'pankaj' .  $tracksalesid = get_sql("sales_task_track","id"," where notification_id='".$id."' AND track_type='4'");
		$salesid = $getsales_follow['id'];
		 $task_manager_id = $getsales_follow['task_manager_id'];
	   
	   add_task_manager($salesid, 0, 4, 0, 0, 27, $task_manager_id, 0, $value);
	   $qryBool = mysql_query( "UPDATE site_notifications SET login_id = '".$value."'  ,  notifications_status = 0 WHERE id = ".$id."" );
	    mysql_query("update sales_task_track set task_manage_id= ".$value." where id=".mysql_real_escape_string($salesid)."");	
	}
    include('task_message_board.php'); 

} 

function update_message_status($str){

			 $vars =  explode('|' ,$str); 
			 
			// print_r($vars);
			 
			$value = $vars[0];
			$id = $vars[1];
		
        $getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where notification_id=".$id.""));
		
		//print_r($getsales_follow); die;
		
	    if(!empty($getsales_follow)) {	
	 
				$salesid = $getsales_follow['id'];
				$task_manager_id = $getsales_follow['task_manager_id'];
			    
				$flag = 1;
				if($value == 1) {
				   $responcetype = 28;
				}elseif($value == 2) {
				  $responcetype = 29;
				}elseif($value == 3) {
				   $responcetype = 30;
				   $flag = 2;
				   
				}
				
	        add_task_manager($salesid, 0, 4, 0, 0, $responcetype, $task_manager_id, 0, 0);		
		}
		 
		$staff_id = get_rs_value("site_notifications","staff_id",$id);
		 
	  if($flag == 1 || $value != 3) {  
		   
		   $qryBool = mysql_query( "UPDATE site_notifications SET message_status = '".$value."'  WHERE id = ".$id."" );
		  // echo 'ook';
		   
		}else{
		
		   $qryBool = mysql_query( "UPDATE site_notifications SET message_status = '".$value."' , notifications_status = 1 ,  task_complete_date = '".date('Y-m-d H:i:s')."'  WHERE id = ".$id."" );
		   // echo 'mmmmmmmmmmm';
		   
		}
  
      //include('get_persnal_noti.php');
}
 
 function search_task_message($str){
    
	 $vars = explode('|',$str); 
	 
	 $loginid = $vars[0];
	 $type = $vars[1];
	 
	/*  if($type == 1) {
	    $loginid =  $str;
	 }else if($type == 2) {
	    $loginid =  $str;
	 } */
	 
	
	 //add_task_manager($task_id, $quote_id, $task_type, $fallow_date, $fallow_time, $response_type, $taskmanagerid, $job_id = 0)
	 include('task_message_board.php'); 
 }


function add_task_message_send($str){


          //  echo  $str; die;

		$vars = explode('|',$str); 
		$to = $vars[0];
		$subject = base64_decode($vars[1]);
		$message = base64_decode($vars[2]); 
		$is_urgent = $vars[3];
		$quote_job_id = $vars[4];
		$q_j_id = $vars[5];
		//$tasktype = $vars[4];
		
		
		$jobid = 0;
		$qid = 0;
		
		if($quote_job_id == 1) {
		  $jobid = $q_j_id;
		}elseif($quote_job_id == 2){
		  $qid = $q_j_id;
		}

		$adminname = get_rs_value("admin","name",$_SESSION['admin']);
		
		$toname = get_rs_value("admin","name",$to);
		
		
		$notificationArrayData = array(
				'notifications_type' => 8,
				'quote_id' => $qid,
				'job_id' => $jobid,
				'staff_id' => 0,
				'task_type' => 2,
				'task_from' => $_SESSION['admin'],
				'heading' => $subject,
				'comment' => $message,
				'notifications_status' => 0,
				'login_id' => $to,
				'is_urgent' => $is_urgent,
				'staff_name' => $adminname,
				'date' => date("Y-m-d H:i:s")
			);
		
        //print_r($notificationArrayData); die;		
			
		$getlastid = add_site_notifications($notificationArrayData , 1);
			
			
		   $call_she1  = mysql_query("insert into sales_task_track set quote_id='0', job_id = 0 , notification_id = '".$getlastid."' ,staff_name='".$adminname."', admin_id='".$_SESSION['admin']."',site_id=0, status=1, fallow_date='".date('Y-m-d H:i:s')."' ,fallow_created_date='".date('Y-m-d')."' ,task_manage_id='".$to."' , task_type='notification', track_type = '4' , createOn='".date('Y-m-d H:i:s')."'");
		   $sid1 = mysql_insert_id();
		   
		   if(isset($sid1)){
		      mysql_query("update site_notifications set sales_id= ".$sid1." where id=".mysql_real_escape_string($getlastid)."");	
		  }
		  
		  mysql_query("INSERT INTO `task_manager` (`completed_date`, `admin_id`, `job_id` , `task_type`, `quote_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('".date('Y-m-d H:i:s')."', '".$to."', 0 ,  '4', '0',  '26', '".$sid1."', '".date('Y-m-d H:i:s')."', '0');");
		
         $tasksid1 = mysql_insert_id();
		 if(isset($tasksid1)){
		   mysql_query("update sales_task_track set task_manager_id= ".$tasksid1." where id=".mysql_real_escape_string($sid1)."");	
		}
		
		 if($is_urgent == 1) {
		   $class = 'urgent';
		   $message_type = 'Urgent';
		 }else{
		   $class = 'info';
		   $message_type = 'Notification';
		 }
		
	     //pankaj you have received new message from nadia
			$datas['message'] = ucfirst($toname) . ' You have received a new notification from '.$adminname;
			$datas['class'] = $class;  
			$datas['message_type'] = $message_type;  
			$datas['class_name'] = 'task_add_notification';  
			$datas['to'] = $to;  
			
			AddTaskNotification($datas);
			
		echo 'Task added for '.$toname;	
			
			
		//include('task_message_board.php'); 
}


function message_send($str){
   
	$vars = explode('|',$str); 
	$to = $vars[0];
	$subject = base64_decode($vars[1]);
	$message = base64_decode($vars[2]); 
	$priority = $vars[3];
	//$tasktype = $vars[4];
	
	add_message_board($to,$subject,$message,$priority);
 
	 include('message_board.php'); 
	
}


function checkPostcodes($postcode , $string , $type) {
	 //echo $postcode.'='.$string; die; Ok11110
	    if($string != '') {
			if( count(explode(',',$string)) > 1 )
			{
				   if(in_array($postcode, explode(',',$string))){
					  // echo "Ok";
					  return 1;
					}else{
						//echo "Ok1111";
						 return 0;
					}
			}else
			{
				if( $postcode == $string)
				{
					return 1;
				}			
				else
				{
					return 0;
				}
			}
	    }else{
			return 0;
		}
		//die;
}

function add_primary_postcode($str){
	
	   $vars = explode('|',$str);
	    
		$postcode = '';
		$staffid = '';
		$field = ''; 
		$type = ''; 
		
		$postcode = $vars[0];
		$staffid = $vars[1];
		$type = $vars[2];
	
	if($vars[0] != '') {
	  $checkPostCode = mysql_fetch_array(mysql_query("SELECT primary_post_code,secondary_post_code from staff where id= '".$staffid."'"));
		
		$secondaryvalue = $checkPostCode['secondary_post_code'];
		$primaryvalue = $checkPostCode['primary_post_code'];
		
		$boolPostcodeOuter = 0;
		$boolPostcodeInner = 0;
		$boolPostcodeOuterinner = 0;
		
		if( $vars[2] == 'primary' )
		{
			$field = 'primary_post_code';

				//first check into secondary
				$boolPostcodeOuter = checkPostcodes( $postcode , $secondaryvalue , $type ); //secondary
				//echo $boolPostcodeOuter;
				//nothing found
				if( $boolPostcodeOuter == 0 )
				{	
					//check once into primary postcodes
					$boolPostcodeInner = checkPostcodes( $postcode , $primaryvalue , $type );	//primary
					
					//nothing found
					if( $boolPostcodeInner == 0 )
					{
						if($primaryvalue != '') {
						   $postcodelist = $primaryvalue.','.$postcode;
						}else{
							$boolPostcodeOuterinner = checkPostcodes( $postcode , $secondaryvalue , $type );
							if($boolPostcodeOuterinner == 0){
							 $postcodelist = $postcode;
							}
						}
					}
					
				}
		}
		else
		{
			$field = 'secondary_post_code';
			
				//first check into secondary
				$boolPostcodeOuter = checkPostcodes( $postcode , $primaryvalue , $type ); //primary
				//echo $boolPostcodeOuter;
				//nothing found
				if( $boolPostcodeOuter == 0 )
				{
					
					//check once into primary postcodes
					$boolPostcodeInner = checkPostcodes( $postcode , $secondaryvalue , $type ); //secondary
					
					//nothing found
					if( $boolPostcodeInner == 0 )
					{
						if($secondaryvalue != '') {
						   $postcodelist = $secondaryvalue.','.$postcode;
						}else{
							$boolPostcodeOuterinner = checkPostcodes( $postcode , $primaryvalue , $type );
							if($boolPostcodeOuterinner == 0){
							 $postcodelist = $postcode;
							}
						}
					}
				}
		}
		
		
		//unset all for once
		$boolPostcodeOuter = 0;
		$boolPostcodeInner = 0;
		$boolPostcodeOuterinner = 0;
		if($postcodelist != '') {
		      $postcodevalue = implode(',',array_unique(explode(',', $postcodelist)));  
	         $bool = mysql_query("update staff set $field = '".$postcodevalue."' where id = ".$staffid.""); 
		}
	}
	  include('get_postcode_data.php'); 
}

function remove_postcode($str){
		$postCode = '';
		$staffid = '';
		$fieldname = '';
	
	$vars = explode('|',$str);
	$postCode = $vars[0];
	$staffid = $vars[1];
	$fieldname = $vars[2];
	
	$checkPostCode = mysql_fetch_array(mysql_query("SELECT $fieldname FROM `staff`  WHERE FIND_IN_SET('".$postCode."',$fieldname) AND id = ".$staffid.""));
	 
	if($checkPostCode[$fieldname] != '') {
		
		$value = $checkPostCode[$fieldname];
		$valuelist = explode(',',$value);
		//print_r($valuelist);
		$value1 =  array_search($postCode, $valuelist);  
		unset($valuelist[$value1]);
		$allvalue = implode(',',$valuelist);
		//echo $allvalue;
		mysql_query("update staff set $fieldname = '".$allvalue."' where id = ".$staffid."");
	} 
	 include('get_postcode_data.php'); 
}

function lat_long_update($var){
	//echo $var; die;
	$vars = explode('|',$var);
	$latlog = explode('__',$vars[0]);
	$lat = $latlog[0];
	$long = $latlog[1];
	$quote_id = $vars[1];
	$bool  = mysql_query("update quote_new set latitude = '".$lat."',longitude = '".$long."'  where id = ".$quote_id."");
} 


function update_call_import( $str )
{
	$impName = $str;
	$adminId = $_SESSION['admin'];
	
	unset( $_SESSION['import_name'] );
	unset( $_SESSION['import_approved'] );
	
	$_SESSION['import_approved'] = 0;
	
	unset( $_SESSION['dup_count'] );
	unset( $_SESSION['cor_count'] );
	
	//update all data corresponding to importName
	if( mysql_query( 
	
		"UPDATE 3cx_calls
			SET
		approved_status = 1,
		approved_by	= {$adminId}
		WHERE
			import_name = '{$impName}'
			AND
			approved_status = 0
		"
	))
	{
		echo 'All Approved';		
	}
}


function updateSiteid($str){
   // echo $str; die;
   $strDetails = explode('|',$str);
   //print_r($strDetails); die;
    $checkSiteID = mysql_fetch_array(mysql_query("select postcode,site_id FROM `postcodes` WHERE `suburb` = '".$strDetails[1]."'")); 
     if($checkSiteID['site_id'] == 0) {
         mysql_query("update postcodes set site_id = '".$strDetails[0]."' where postcode=".mysql_real_escape_string($checkSiteID['postcode'])."");
     }
    
}



function delete_quote($id){	
	if($id!=""){ 
		$status_check = get_rs_value("quote_new","status",$id);
		if($status_check==0){ 		
			//$bool = mysql_query("update quote_new set deleted=1 where id=".mysql_real_escape_string($id)."");	
			$bool = mysql_query("update quote_new set deleted=1, is_deleted = ".$_SESSION['admin']." where id=".mysql_real_escape_string($id)."");	
			echo error("The Quote has been deleted");	
			$adminname = get_rs_value("admin","name",$_SESSION['admin']);
			$heading = "Quote Deleted By ".ucfirst($adminname);
			add_quote_notes($id,$heading,$heading);
		}else{ 
			echo error("Quote is already accpeted, It cannot be deleted");				
		}
	}	
	include("view_quote.php");	
}

function get_quote($var){
	$amount  = 0; $hours = 0; $carpet_amount = 0; $per_hour = 40;
	//echo $var."<br>";	
	$varx = explode("|",$var);
	$_POST['bed'] = $varx[0];
	$_POST['bath'] = $varx[1];
	$_POST['furnished'] = $varx[2];	
	$_POST['property_type']=$varx[3];
	$_POST['blinds_type']=$varx[4];
	$_POST['carpet']=$varx[5];
	$_POST['c_bedroom']=$varx[6];
	$_POST['c_lounge']=$varx[7]; 
	$_POST['c_stairs']=$varx[8];
	
	//print_r($_POST);
	
	if(($_POST['bed']=="1") && ($_POST['bath']=="1")){
		$amount = 250; $hours = 6;
	}else if(($_POST['bed']=="2") && ($_POST['bath']=="1")){
		$amount = 280; $hours = 7;
	}else if(($_POST['bed']=="2") && ($_POST['bath']=="2")){
		$amount = 320; $hours = 8;
	}else if(($_POST['bed']=="3") && (($_POST['bath']=="1") || ($_POST['bath']=="2"))){				
		$amount = 400; $hours = 10;
	}else if(($_POST['bed']=="3") && ($_POST['bath']=="3")){
		$amount = 440; $hours = 11;
	}else if(($_POST['bed']=="4") && ($_POST['bath']=="2")){
		$amount = 480; $hours = 12;
	}else if(($_POST['bed']=="5") && ($_POST['bath']=="2")){
		$amount = 640; $hours = 16;
	}else{
		if($_POST['bed']<5){ 
			$hours = (6+($_POST['bath']+$_POST['bed']));
			$amount = ($hours*$per_hour);
		}else{ 
			$hours = (8+($_POST['bath']+$_POST['bed']));
			$amount = ($hours*$per_hour);
		}
	}
	
	if($_POST['furnished']=="Yes"){ 
		$hours = $hours+1;
		$amount = ($amount+$per_hour);
	}
	
	if(($_POST['property_type']=="Duplex") || ($_POST['property_type']=="Two Story")){ 
		$hours = $hours+1;
		$amount = ($amount+$per_hour);
	}
	
	if($_POST['blinds_type']=="Venetians" || $_POST['blinds_type'] =="Shutters"){ 
		$hours = $hours+1;
		$amount = ($amount+$per_hour);		
	}
	
	$amount_item['cleaning_amount'] = $amount;
	
	if($_POST['carpet']=="Yes"){ 
		if($_POST['c_bedroom']!=""){ 
			$carpet_amount = ($_POST['c_bedroom']*20);
		}
		if($_POST['c_lounge']=="Yes"){ 
			$carpet_amount = ($carpet_amount+30);
		}
		if($_POST['c_stairs']!=""){ 
			$carpet_amount = ($carpet_amount+($_POST['c_stairs']*2));
		}
		$amount_item['carpet_amount'] = $carpet_amount;
	}
	
	$amount_item['total_amount'] = ($amount+$carpet_amount); 
	$total_amount = ($amount+$carpet_amount);
	
	?>
  
	<ul class="frm_rght_lst">
		<li>
			<label>Number of Hours</label>
			<input name="cleaning_hours" type="text" id="cleaning_hours" value="<? echo $hours;?>" onchange="javascript:recalc_quote('cleaning_hours');">
		</li>
		<li>
			<label>Per Hour</label>
			<input name="per_hour" type="text" id="per_hour" value="<?php echo $per_hour?>" onchange="javascript:recalc_quote('cleaning_hours');">
		</li>
	   <?php
	   $other_types = mysql_query("Select * from job_type");
	   while($r = mysql_fetch_assoc($other_types)){
		  echo '<li>
			<label>'.$r['name'].' Amount</label>
			<input name="'.strtolower($r['name']).'_amount" value="'.$amount_item[strtolower($r['name']).'_amount'].'"
			type="text" id="'.strtolower($r['name']).'_amount" onchange="javascript:recalc_quote(\'other_'.$r['id'].'_amount\');">
		  </li>';
	   }
	   ?>		
		<li>
			<label>Total Amount</label>
			<input name="amount" type="text" id="amount" value="<? echo $total_amount;?>">
		</li>
	</ul>
  <?   
}

function select_team($var){
	/*$varx = explode("|",$var);
	$bool = mysql_query("update bookings set team_id=".$varx[1]." where id=".$varx[0]."");
	include("view_booking.php");	*/
}

function edit_b_status($var){
	/*$varx = explode("|",$var);
	$bool = mysql_query("update bookings set b_status=".$varx[1]." where id=".$varx[0]."");
	if($varx[1]=="2"){ 
		$quote_id = get_rs_value("bookings","quote_id",$varx[0]);
		$bool2 = mysql_query("updae quote set status=0 where id=".$quote_id."");
	}else if($varx[1]=="2"){ 
		$quote_id = get_rs_value("bookings","quote_id",$varx[0]);
		$quote = mysql_fetch_assoc(mysql_query("select * from quote where id=".$quote_id.""));	
		$uarg = "update bookings set cleaners_amount=".($quote['cleaning_amount']*60/100).", profit=".($quote['cleaning_amount']*40/100).", customer_amount=".$quote['amount']." where id=".$r['id']." ";
		//echo $uarg."<br>";
		$bool2 = mysql_query($uarg);
	}
	include("view_booking.php");*/
}

function edit_pay_status($var){
	/*$varx = explode("|",$var);
	$bool = mysql_query("update bookings set status=".$varx[1]." where id=".$varx[0]."");
	$quote_id = get_rs_value("bookings","quote_id",$varx[0]);
	$quote = mysql_fetch_assoc(mysql_query("select * from quote where id=".$quote_id.""));
	
	$bool2 = mysql_query("update bookings set cleaners_amount=".$quote['cleaning_amount'].", customer_amount=".$quote['amount'].",carpet_amount=".$quote['carpet_amount']." where id=".$varx[0]." "); 
	*/
	//include("view_payment_new.php");
}

function edit_booking_table($var){
	/*$varx = explode("|",$var);
	$field = $varx[0];
	$value= $varx[1];
	$id=$varx[2];
	
	//echo "update bookings set ".$field."='".$value."' where id=".$id."";
	$bool = mysql_query("update bookings set ".$field."='".$value."' where id=".$id."");
	//include("view_payment.php");*/
}

function convert_quote_to_job($quote_id) {
	
	//echo "select * from quote where id=".$quote_id."<br>";
		
	$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".$quote_id.""));
	if($quote['booking_id']!="0"){
		echo "Job Is already Booked";
		return false;
	}
	if($quote['job_date']=="0000-00-00"){
		echo "Please select the Date First";
		return false;
	}
	//print_r($quote_details);
	
	
	
	$getadminid = array(12,57,34);
	$random_adminid=array_rand($getadminid);
	$taskmanager_adminid = $getadminid[$random_adminid];
	
	$ins_arg = "insert into jobs set ";
	$ins_arg.= "site_id='".$quote['site_id']."',";
	$ins_arg.= "quote_id='".$quote['id']."',";
	$ins_arg.= "job_date='".$quote['booking_date']."',";
	$ins_arg.= "date='".date("Y-m-d")."',";
	$ins_arg.= "status=1,";
	$ins_arg.= "task_manage_id=".$taskmanager_adminid.",";
	$ins_arg.= "customer_amount='".$quote['amount']."'";
	
	//echo $ins_arg;
	
	$ins = mysql_query($ins_arg);
	
	
	
	//echo $ins."<br>";
	if($ins){ 
		$booking_id = mysql_insert_id();
		
	//	$booking_id = mysql_insert_id();
		$arg = "update quote_new set booking_id=".$booking_id.", ";	
		   
		if($quote['job_ref'] == "Crm"){
			
			$arg .= " ";	
		}else {
		   // $arg .= " login_id='".$taskmanager_adminid."'  ,";	
		    $arg .= " login_id='".$_SESSION['admin']."'  ,";	
		}
		
			$arg .= " quote_to_job_date ='".date("Y-m-d")."' ,  status=1 where id=".$quote_id."";	
		
		$bool = mysql_query($arg);	
		
		
		
		 $agent_details = false;
		 $flag = 0;
		if($quote['real_estate_id'] > 0) {
			
			  $get_re_details =  mysql_fetch_assoc(mysql_query("SELECT * FROM `real_estate_agent` WHERE id  = '".$quote['real_estate_id']."'"));
			  
			  $real_estate_agency_name = $get_re_details['name'];
			  $agent_name = $get_re_details['name'];
			  $agent_number = $get_re_details['mobile'];
			  $agent_email = $get_re_details['email'];
			  $agent_landline_num = '';
			  $agent_address = '';
			  
			  $agent_details = true;
			  	$flag = 1;
			 // $flag = 1;
			 
		 }
		  
		  
		 $client_type =  $quote['client_type'];
		 
		// echo  $client_type;
	
		if($client_type == 2) {
			
				//echo $quote['agent_number'];
				$agent_details == true;
				$flag = 1;
				$real_estate_agency_name =  $quote['agency_name'];
				$agent_name =  $quote['agent_name'];
				$agent_number = $quote['agent_number'];
				$agent_email =  $quote['agent_email'];
				$agent_landline_num =  $quote['agent_landline_num'];
				$agent_address =  $quote['agent_address'];
				
		} 
		 
             /* echo $real_estate_agency_name .'=='.$agent_name .'=='.$agent_number .'=='.$agent_email.'=='.$agent_landline_num .'=='.$agent_address;
		  
		die; */
		  
		 $quote_details = mysql_query("Select * from quote_details where quote_id=".$quote_id);
		 
		 $jojbdesc = '';
		   while($r = mysql_fetch_assoc($quote_details)){
			  
			  /* if($r['job_type_id'] == '1') {
				  $jojbdesc = $quote_details['description'];
			  }
			   $inv = get_rs_value("job_type","inv",$r['job_type_id']); */
			  
			  	
				   $staff_amt =  0;
				   $profit_amt = 0;
				   
					$ins_arg2 = "insert into job_details set job_id=".$booking_id.",";
					$ins_arg2.= "quote_id=".$quote_id.",";
					$ins_arg2.= "site_id=".$quote['site_id'].",";
					$ins_arg2.= "job_type_id=".$r['job_type_id'].",";
					$ins_arg2.= "job_type='".$r['job_type']."',";
					$ins_arg2.= "quote_details_id='".$r['id']."',";
					$ins_arg2.= "staff_id=0,";
					$ins_arg2.= "amount_total='".$r['amount']."',";
					$ins_arg2.= "amount_staff='".$staff_amt."',";
					$ins_arg2.= "amount_profit='".$profit_amt."',";
					$ins_arg2.= "job_date='".$quote['booking_date']."',";
					
					if($flag == 1) {
						$ins_arg2.= "real_estate_agency_name='".$real_estate_agency_name."',";
						$ins_arg2.= "agent_name='".$agent_name."',";
						$ins_arg2.= "agent_number='".$agent_number."',";
						$ins_arg2.= "agent_email='".$agent_email."',";
						$ins_arg2.= "agent_landline_num='".$agent_landline_num."',";
						$ins_arg2.= "agent_address='".$agent_address."',";
					}
					
					$ins_arg2.= "job_time='8:00 AM'";
					
					$bool2 = mysql_query($ins_arg2);			  
		    }
		 
		 add_quote_notes($quote_id," Quote Converted to Job".$job_id,"");
	   	 add_job_notes($booking_id,"Job Booked","");
		  
		 $getquoteemail =  mysql_query("SELECT * FROM `quote_emails` where quote_id =".$quote_id.""); 
		 
    		if(mysql_num_rows($getquoteemail)>0) {
        		while($details = mysql_fetch_assoc($getquoteemail)) {
        		   //$quoteemail =  get_rs_value("quote_new","email",$quote_id);
        		 //  $job_id,$heading,$comment,$email
        		   $heading = $details['heading'];
        		   $comment = $details['comment'];
        		   $quote_email = $details['quote_email'];
        		   $createdOn = $details['createdOn'];
        		   $login_id = $details['login_id'];
        		   $staff_name = $details['heading'];
        	           add_job_emails($booking_id,$heading,$comment,$quote_email,$createdOn,$login_id,$staff_name);     
        		}
    		}
    	
        $re_quoteing  = 
		        mysql_query
				(
				 
				    "INSERT INTO `re_quoteing` 
				     
					(`job_id`, `quote_id`,   `site_id`, `admin_id`, `createdOn`) 
					 
		           VALUES 
				    (
				       '".$booking_id."', '".$quote_id."',  '".$quote['site_id']."', '".$_SESSION['admin']."', '".date('Y-m-d H:i:s')."'
					)"
				);	
			 
		$staffname = get_rs_value('admin' , 'name' , $_SESSION['admin']);
		$sql = mysql_query("SELECT id , quote_id FROM `sales_system` WHERE quote_id = ".$quote_id."");
		$countre = mysql_num_rows($sql);
		if($countre > 0) {
			
			$sadetails = mysql_fetch_assoc($sql);
			$sid = $sadetails['id'];
			mysql_query("update sales_system set job_id= ".$booking_id." where id=".mysql_real_escape_string($sid)."");	
			
		}else{
			
			 $call_she  = mysql_query("insert into sales_system set quote_id='".($quote_id)."', job_id = ".$booking_id." ,  staff_name='".$staffname."', admin_id='".$_SESSION['admin']."',site_id=".$quote['site_id'].", task_manage_id='".$taskmanager_adminid."' , status=1,  task_type='admin' ,  createOn='".date('Y-m-d H:i:s')."'");
				
				$sid = mysql_insert_id();
		}
		
		
				if(date('i') <= '30') {
				 $schedule_from =  date('H').':00'; 
				 $schedule_to = date('H').':30';
				}else{
				 $schedule_from = date('H').':30';
				 $schedule_to = date('H' ,strtotime('+1 hour')).':00';
				}
				$fallow_time = $schedule_from.'-'.$schedule_to;
				$fallow_date = date('Y-m-d H:i:s');
		
		
		$call_she1  = mysql_query("insert into sales_task_track set quote_id='".($quote_id)."', job_id = ".$booking_id." , staff_name='".$staffname."', admin_id='".$_SESSION['admin']."',site_id=".$quote['site_id'].",stages=3, status=1, fallow_date='".date('Y-m-d H:i:s')."' ,fallow_created_date='".date('Y-m-d')."' ,task_manage_id='".$taskmanager_adminid."' , task_type='admin' ,  fallow_time='".$fallow_time."' ,  task_status='2' , track_type = '2' , sales_task_id = '".$sid."' ,  createOn='".date('Y-m-d H:i:s')."'");
		$sid1 = mysql_insert_id();
		
		if(isset($sid1)){
		   mysql_query("update jobs set track_id= ".$sid1." where id=".mysql_real_escape_string($booking_id)."");	
		}
		
		mysql_query("INSERT INTO `task_manager` (`fallow_date`, `fallow_time`, `completed_date`, `admin_id`, `job_id` , `task_type`, `quote_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('".$fallow_date."', '".$fallow_time."','".date('Y-m-d H:i:s')."', '".$taskmanager_adminid."', ".$booking_id." ,  '2', '".$quote_id."',  '13', '".$sid1."', '".date('Y-m-d H:i:s')."', '0');");
		
         $tasksid1 = mysql_insert_id();
		 if(isset($tasksid1)){
		   mysql_query("update sales_task_track set task_manager_id= ".$tasksid1." where id=".mysql_real_escape_string($sid1)."");	
		}
		
    	   $getquotenotes =  mysql_query("SELECT * FROM `quote_notes` where quote_id =".$quote_id.""); 
		    if(mysql_num_rows($getquotenotes)>0) {
        		 while($qdetails = mysql_fetch_assoc($getquotenotes)) {
        		     
        		   $heading = $qdetails['heading'];
        		   $comment = $qdetails['comment'];
        		   $createdOn = $qdetails['date'];
        		   $login_id = $qdetails['login_id'];
        		   $staff_name = $qdetails['staff_name'];
        		   $cx_upload_id = $qdetails['3cx_upload_id'];
        	         add_job_notes($booking_id,$heading,$comment,$createdOn,$staff_name,$login_id,$cx_upload_id);   
        		 }
    		 }  
			 
		return $booking_id;
	}
}

function edit_quote_book_now($quote_id){
	$job_id = convert_quote_to_job($quote_id);
	//echo "Job is Created, Please Go to Dispatch Board";
	echo '<div class="btn_get_quot"><a href="javascript:scrollWindow(\'popup.php?task=payment&amp;job_id='.$job_id.'\',\'1200\',\'850\');">Make Payment</a></div>';
}

function list_quote_book_now($quote_id){
	$job_id =  convert_quote_to_job($quote_id);
	echo "Job Converted  #".$job_id;
}

function update_quote_payments($var){
	$varx = explode("|",$var);
	$value = $varx[0];
	$field= $varx[1];
	$id=$varx[2];
	//echo "update quote set ".$field."='".$value."' where id=".$id."";
	$bool = mysql_query("update quote_new set ".$field."='".$value."' where id=".$id."");
	
	$quote_data = mysql_query("select * from quote_new where id=".$id."");
	
	$other_types = mysql_query("Select * from job_type");
	$total = 0;
   	while($r = mysql_fetch_assoc($other_types)){
		$amt_field = strtolower($r['name']).'_amount';
	  	$amount_item[$amt_field] = $r[$amt_field];
		$total = $total + $r[$amt_field];		
   }
   
   $bool = mysql_query("update quote_new set amount='".$total."' where id=".$id."");
}
//job_sms address_sms job_sms_date address_sms_date
function assign_staff_job($var){
    
	$varx = explode("|",$var);
	$jd_id = $varx[0];
	$job_id= $varx[1];
	$staff_id=$varx[2];
	
	// print_r($varx);  die;
	
	  $jdetails =  mysql_fetch_array(mysql_query("select * from job_details where id=".$jd_id.""));
	
	   	   
	   $staff_truck_assign_date = '0000-00-00 00:00:00';
	   $staff_truck_id = 0;
	   $amount_status = 1;
	   $not_accepted_staff = 0;
	
		if($staff_id == 0) {
			
			
			//echo 'hllo';
			
			$staff_assign_date = '0000-00-00 00:00:00';
			$staff_assign_notification = '';
			$job_acc_deny = 'Null';
			$amount_staff = 0;
			$amount_profit = 0;
			$amt_share_type = '';
			$staff_work_status = '';
			$checklist_field = '';
			$auto_assign = 0;
			
		}else 
		{
			$auto_assign = 2;
			//$auto_assign = 1;
          
			$quotedetails =  mysql_fetch_array(mysql_query("SELECT *  FROM `quote_details` WHERE `quote_id` = ".$jdetails['quote_id']." AND `job_type_id` = ".$jdetails['job_type_id'].""));
	
				$staffDetails =  mysql_fetch_array(mysql_query("SELECT *  FROM `staff` WHERE `id` = ".$staff_id));
				
				if($jdetails['job_type_id'] == 1 && $staffDetails['payment_type'] == 2 && $staffDetails['price_match'] == 1 && $staffDetails['better_franchisee'] == 2) 
				{	
						$getamountSql = mysql_query("select * from staff_share_amount where job_type_id=".$jdetails['job_type_id']." AND staff_id ='".$staff_id."'");
						$getshareamount  = mysql_fetch_assoc($getamountSql);
						
						$bed = $quotedetails['bed'];
						$study = $quotedetails['study'];
						$bath  = $quotedetails['bath'];
						$living  = $quotedetails['living'];
				
					
						$sqlstaffrates = mysql_query("SELECT * FROM `staff_rates` WHERE staff_id = ".$staff_id." and bed = '".($bed + $study)."' AND bath = ".$bath." AND living = ".$living."");
							
							
							if(mysql_num_rows($sqlstaffrates)) 
							{
								$get_staff_amt = mysql_fetch_array($sqlstaffrates);
								
								$fixed_amount_staff = ($get_staff_amt['amount']);
								$amount_staff = ($jdetails['amount_total']*65)/100;
								$flag_check = 1;
								
							}else
							{
								
								$fixed_amount_staff = ($jdetails['amount_total']*65)/100;
								$amount_staff = $fixed_amount_staff;
								
								if($living>$rates['living_inc']) { 
									$extra_livings = ($living-$rates['living_inc']);  
									$staff_amount+=(40*$extra_livings);  
									$flag_check = 0;
							    }
							}
							
							
							$amount_profit =  ($jdetails['amount_total'] - $amount_staff);
							$amt_share_type = $getshareamount['value'].'(%)'; 
							
						if($flag_check == 1) {	
					 	    $checkAmtStatus = $fixed_amount_staff - $amount_staff;     // amount_status => 1 defult  , 2=> red;
							if($checkAmtStatus > 0) {
								 $amount_status = 2;
							}
						}
						
					
					    $staff_assign_date = date("Y-m-d H:i:s");
						$staff_assign_notification = 0;
						$job_acc_deny = 0;    // 0=>Assigne 1=> Accepted.. 

						$checkJobStatus =  mysql_fetch_assoc(mysql_query("SELECT count(id) as totalRecord FROM `staff_jobs_status`  WHERE job_id = ".$job_id." ANd staff_id = ".$staff_id." AND status in (1,5)"));

						//print_r($checkJobStatus); die;

						$staffwork = mysql_query("INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`, `job_type_id`, `created_at`,`total_amount`, `total_staff_amt`, `total_bcic_amt`, `current_rate_for_day`,`assign_type`) VALUES ('".$staff_id."', '".$job_id."', 5, ".$jdetails['job_type_id'].", '".date("Y-m-d H:i:s")."' , '".$jdetails['amount_total']."', ".$amount_staff.", '".$amount_profit."', '".$amt_share_type."',1)");
					
				}else {
					
					$getamountSql = mysql_query("select * from staff_share_amount where job_type_id=".$jdetails['job_type_id']." AND staff_id ='".$staff_id."'");
				    $getshareamount  = mysql_fetch_assoc($getamountSql);
			
					if(!empty($getshareamount)) {
						
						if($getshareamount['amount_share_type'] == 1) {
							// 1 For percentage   
							$amount_profit = ($jdetails['amount_total']*$getshareamount['value'])/100;
							$amount_staff = ($jdetails['amount_total'] - $amount_profit);
							$amt_share_type = $getshareamount['value'].'(%)';
							
						}else if($getshareamount['amount_share_type'] == 2){
							// 2 For fixed
							$amount_staff = ($jdetails['amount_total'] - $getshareamount['value']);
							$amount_profit =  ($jdetails['amount_total'] - $amount_staff);
							$amt_share_type = $getshareamount['value'].'(F)';
						}
						
						$staff_assign_date = date("Y-m-d H:i:s");
						$staff_assign_notification = 0;
						$job_acc_deny = 0;    // 0=>Assigne 1=> Accepted.. 
						
						/* $checkJobStatus =  mysql_fetch_assoc(mysql_query("SELECT count(id) as totalRecord FROM `staff_jobs_status`  WHERE job_id = ".$job_id." ANd staff_id = ".$staff_id." AND status in (1,5)")); */
						
						//print_r($checkJobStatus); die;
						
						/* echo "INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`, `job_type_id`, `created_at`) VALUES ('".$staff_id."', '".$job_id."', 5, ".$jdetails['job_type_id'].", '".date("Y-m-d H:i:s")."')"; */
						
						
					$staffwork = mysql_query("INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`, `job_type_id`, `created_at`,`total_amount`, `total_staff_amt`, `total_bcic_amt`, `current_rate_for_day`,`assign_type`) VALUES ('".$staff_id."', '".$job_id."', 5, ".$jdetails['job_type_id'].", '".date("Y-m-d H:i:s")."' , '".$jdetails['amount_total']."', ".$amount_staff.", '".$amount_profit."', '".$amt_share_type."',1)");
						
						
						
					}else {
						$staff_assign_date = '0000-00-00 00:00:00';
						$staff_assign_notification = '';
						$job_acc_deny = 'Null';
						$amount_staff = 0;
						$amount_profit = 0;
						$amt_share_type = '';
						$staff_work_status = '';
						$checklist_field = '';
					}
				}
		} 
		
			$sub_staff_id = 0;
			$checklist_status = 0;
			$sub_staff_assign_date = '0000-00-00 00:00:00';
			$job_notification_date ='0000-00-00 00:00:00';
			$add_notification_date = '0000-00-00 00:00:00';
		//die; start_time end_time
	   
	     $uarg = "update job_details set staff_id=".$staff_id." ,staff_truck_assign_date= '".$staff_truck_assign_date."' , checklist_status= '".$checklist_status."' ,staff_truck_id='".$staff_truck_id."' , job_notification_status = '0',job_notification_date = '".$job_notification_date."',add_notification_status = '0',add_notification_date = '".$add_notification_date."', job_sms = '', address_sms = '', job_sms_date='0000-00-00 00:00:00', start_time='0000-00-00 00:00:00', end_time='0000-00-00 00:00:00', address_sms_date = '0000-00-00 00:00:00',staff_assign_date = '".$staff_assign_date."',sub_staff_id = '".$sub_staff_id."',sub_staff_assign_date = '".$sub_staff_assign_date."',exact_work_time = '',total_hr_staff_work = '',staff_assign_notification = '".$staff_assign_notification."',job_acc_deny = ".$job_acc_deny.",amount_staff = '".$amount_staff."',amount_status = '".$amount_status."',staff_work_status = '".$staff_work_status."',checklist_field = '".$checklist_field."',amount_profit = '".$amount_profit."' ,not_accepted_staff = '".$not_accepted_staff."', amt_share_type ='".$amt_share_type."' where job_id=".$job_id." and id=".$jd_id."";  
		 
	
	$bool = mysql_query($uarg);

	$staff_name = get_rs_value("staff","name",$staff_id);

	
	
	$cond = " site_id=".$jdetails['site_id']." and job_types like '%".$jdetails['job_type']."%'";
	$onchng = "onchange=\"javascript:assing_jobs('".$jdetails['id']."','".$jdetails['job_id']."','staff_id_".$jdetails['id']."');\" ";
	
	$admin_name = get_rs_value("admin","name",$_SESSION['admin']);
	
		$notificationArrayData = array(
			'notifications_type' => 3,
			'quote_id' => 0,
			'job_id' => mysql_real_escape_string($job_id),
			'staff_id' => mysql_real_escape_string($staff_id),
			'heading' => 'job assigned to '.$staff_name,
			'comment' => 'job assigned to '.$staff_name,
			'notifications_status' => 1,
			'login_id' => $_SESSION['admin'],
			'staff_name' => $admin_name,
			'date' => date("Y-m-d H:i:s")
		);
		
	add_site_notifications($notificationArrayData);
	
		if($staff_id == 0) {
			$adminname =  get_rs_value("admin","name",$_SESSION['admin']);
		    add_job_notes($job_id," ".$jdetails['job_type']." Reset","");
		}else {
			 add_job_notes($job_id,"Assigned ".$jdetails['job_type']." Job to ".$staff_name,"");
		}
    echo create_dd_staff("staff_id_".$jdetails['id'],"staff","id","name",$cond,$onchng,$staff_id);		
}

function refresh_dispatch($nothing){
	include("dispatch.php");
}
function staff_assigned_job_page($jobid){
     $job_id= $jobid;
	include("view_job_details.php"); 
}

function staff_assigned_unassigned($jobid){
     $job_id= $jobid;
	include("job_unassinged.php"); 
}


function refresh_dispatch_tab($tab){
	if($tab=="prev_week"){
		$tdate = strtotime($_SESSION['dispatch']['from_date']);
		$ndate = ($tdate - 86400*7);
		//echo date("d-m-Y",$tdate)."-".date("d-m-Y",$ndate);
		$_SESSION['dispatch']['from_date'] = date("d-m-Y",$ndate);
	}else if($tab=="prev_day"){
		$tdate = strtotime($_SESSION['dispatch']['from_date']);
		$ndate = ($tdate - 86400*1);
		//echo date("d-m-Y",$tdate)."-".date("d-m-Y",$ndate);
		$_SESSION['dispatch']['from_date'] = date("d-m-Y",$ndate);
	}else if($tab=="next_day"){
		$tdate = strtotime($_SESSION['dispatch']['from_date']);
		$ndate = ($tdate + 86400*1);
		//echo date("d-m-Y",$tdate)."-".date("d-m-Y",$ndate);
		$_SESSION['dispatch']['from_date'] = date("d-m-Y",$ndate);
	}else if($tab=="next_week"){
		$tdate = strtotime($_SESSION['dispatch']['from_date']);
		$ndate = ($tdate + 86400*7);
		//echo date("d-m-Y",$tdate)."-".date("d-m-Y",$ndate);
		$_SESSION['dispatch']['from_date'] = date("d-m-Y",$ndate);
	}
	include("dispatch.php");
}

function get_staff_by_site_id($site_id){
	//echo "Site Id".$site_id;
	//unset($_SESSION['dispatch']['site_id']);
	if($site_id != 0){ 
	//onchange="javascript:show_data('staff_id',17,'dispatch_div');"
	
		$_SESSION['dispatch']['site_id']=$site_id;
		//echo create_dd("staff_id","staff","id","name","status=1 and site_id='".$site_id."'","onchange=\"javascript:show_data('staff_id',17,'dispatch_div');\"", $_SESSION['dispatch']); 
	}else{
		unset($_SESSION['dispatch']['site_id']);
		//echo create_dd("staff_id","staff","id","name","status=1","onchange=\"javascript:show_data('staff_id',17,'dispatch_div');\"", $_SESSION['dispatch']); 
	}

	include("dispatch.php");
}

function get_staff_by_site_job_type($job_type){
	
	if($job_type!="0"){
		
		$_SESSION['dispatch']['job_type']=$job_type;
		if($_SESSION['dispatch']['site_id']!="" && $_SESSION['dispatch']['site_id'] != '0' && $_SESSION['dispatch']['staff_id']!= "site_id"){ 
		
			$site_id = $_SESSION['dispatch']['site_id']; 
		}else{
		 
		}
	}else{
		unset($_SESSION['dispatch']['job_type']);
		
	}
	include("dispatch.php");
	
	
}

function edit_dispatch_from_date($from_date){
	$_SESSION['dispatch']['from_date']=$from_date;
        include("dispatch.php");
}

function edit_dispatch_staff_id($staff_id){
	//echo $staff_id; die;
	if($staff_id !="0"){ 
		$_SESSION['dispatch']['staff_id']=$staff_id;
	}else{
		unset($_SESSION['dispatch']['staff_id']);
	}	
	include("dispatch.php");
}

function keyword_search_dispatch_side($keyword){
	if($keyword!=""){ 
		$_SESSION['dispatch']['keyword']=$keyword;
	}else{
		unset($_SESSION['dispatch']['keyword']);
	}	
	include("dispatch_side.php");
}

function status_search_dispatch_side($status){
	if($status!=""){ 
		$_SESSION['dispatch']['status']=$status;
	}else{
		unset($_SESSION['dispatch']['status']);
	}	
	include("dispatch_side.php");
}

function refresh_dispatch_side($some){
	include("dispatch_side.php");
}

function edit_field($var){
	
	$varx = explode("|",$var);
	
	$flag_data = 0;
	
	// print_r($varx); die;  
	
	$value = mysql_real_escape_string($varx[0]);
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	$siteid=$varx[3];
	
	//echo $varx[1]; 
	
	
	if($varx[1] == 'admin.auto_role') {
	    
	    
	    
    	    $createddate = date('Y-m-d H:i:s');
    		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
    		$bool = mysql_query("update admin_role set status ='1' , assign_name = '".$_SESSION['admin']."' where  login_id = '".$id."' AND  DATE(createdOn) = '".date('Y-m-d')."'");
    		$sql = "INSERT INTO `admin_role` (`login_id`, `admin_role`, `assign_name`, `createdOn`) VALUES ('".$id."', '".$value."', '".$_SESSION['admin']."' , '".$createddate."')";
    		
    		$bool = mysql_query($sql);
    		
    	/*	$login_status = get_rs_value("admin","login_status",12);	
    		
    		if($login_status == 1) {
    		
            			$adminname = get_rs_value("admin","name",$_SESSION['admin']);
            		
            		if($value > 0) {
            		   $rolename = get_sql("system_dd","name"," where type='102' AND id='".$value."'");
            		}else{
            		    $rolename = 'Nothing';
            		}
            		
            		$heading = ucfirst($adminname) .' have changed the role in '.$rolename;
            		$notificationArrayData = array(
            			'notifications_type' => 8,
            			'quote_id' => 0,
            			'job_id' => 0,
            			'staff_id' => 0,
            			'heading' => $heading,
            			'comment' => $heading,
            			'notifications_status' => 0,
            			'task_manage_id' => 12,
            			'login_id' => 12,
            			'staff_name' => $adminname,
            			'date' => date("Y-m-d H:i:s")
            		);
            		
            	  add_site_notifications($notificationArrayData);
    	  
        }*/
    		
	}else if($varx[1] == 'quote_new.real_estate_id') {
	
		$bool = mysql_query("update quote_new set ".$field."='".$value."' where id=".$id."");
		$value = get_rs_value("real_estate_agent","name",$value);
		
	}else if($varx[1] == 're_quoteing.est_sqm' || $varx[1] == 're_quoteing.sqm') { 
	     
	    //echo "update ".$table." set ".$field."='".$value."' where id=".$id."";
	    
    	$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
	}else if($varx[1] == 'job_reclean.reclean_time'){
		//$varx[1] == 'job_reclean.reclean_time';
	    $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
	    if($field == 'reclean_time')	{ $field = 'Re-Clean Job Time'; $type = 'otherval'; }
		$comment = $field .' Change To '.$getname;
		$heading = $comment .' In 3PM Check';
		
		 $getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check FROM `job_reclean` where id = ".$id.""));
		
		add_3pm_notes($getjobdetails['job_id'] , $getjobdetails['quote_id'] , $id , 2 , $comment , $comment);
		add_job_notes($getjobdetails['job_id'],$heading,$heading);	
	
    }else if($varx[1] == 'job_details.called' || $varx[1] == 'job_details.called_status' || $varx[1] == 'job_details.job_time') {
	 
	   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");

	   $getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check FROM `job_details` where id = ".$id.""));
	    
		 if($field == 'called')	{ $field = 'Called'; $type = '65'; }elseif($field == 'called_status')	{ $field = 'Called Status'; $type = '100'; }elseif($field == 'job_time')	{ $field = 'Job Time'; $type = 'otherval'; }
	   
	    if($type == 'otherval') {
			$comment = $field .' Change To '.$value;
		}else {
	      $getname = get_sql("system_dd","name"," where type='".$type."' AND id='".$value."'");
		  $comment = $field .' Change To '.$getname;
		}
	   
	    $heading = $comment .' In 3PM Check';
		
		add_3pm_notes($getjobdetails['job_id'] , $getjobdetails['quote_id'] , $id , 2 , $comment , $comment);
		add_job_notes($getjobdetails['job_id'],$heading,$heading);	
		
	}elseif($varx[1] == 'bcic_review.fault_notes' || $varx[1] == 'bcic_review.fault_type') {
	
	    // if(trim($value) != '') {
		    //echo "update $table set ".$field." = '".mysql_real_escape_string($value)."' where id=".$id."";  die;
		        $value = trim($value);
				$bool = mysql_query("update $table set ".$field." = '".mysql_real_escape_string($value)."' where id=".$id."");
			
				if($varx[1] == 'bcic_review.fault_notes') {
					$bool = mysql_query("update $table set fault_notes_date ='".date("Y-m-d H:i:s")."' , admin_id = ".$_SESSION['admin']."  where id=".$id."");
				}
			
			$booking_id1 =  get_rs_value("bcic_review","job_id",$id);
			$adminname=get_rs_value("admin","name",$_SESSION['admin']);		
			
			$heading =  ucfirst(str_replace('_' , ' ' , $field)).' Added By '.$adminname;
			add_job_notes($booking_id1,$heading,$heading);	 
		//}
		
	}elseif($varx[1] == 'job_complaint.complaint_type' || $varx[1] == 'job_complaint.job_handling' || $varx[1] == 'job_complaint.job_type_id'  | $varx[1] == 'job_complaint.complaint_process_status' || $varx[1] == 'job_complaint.complaint_status' || $varx[1] == 'job_complaint.job_handling_by_clnr' || $varx[1] == 'job_complaint.admin_id'  || $varx[1] == 'job_complaint.complaint_resolve' || $varx[1] == 'job_complaint.move_from_contract') {
	
	           //print_r($varx); die;
		        $value = trim($value);
			
            if($varx[1] == 'job_complaint.job_type_id') {
                
                $job_id = get_rs_value("job_complaint","job_id",$id);
                
                 $staff_id = get_sql("job_details","staff_id"," where job_id ='".$job_id."' AND job_type_id='".$value."'");
				
				$bool = mysql_query("update $table set ".$field." = '".mysql_real_escape_string($value)."' , staff_id= '".$staff_id."' where id=".$id."");
				
				$jobjob_type_name = get_rs_value("job_type","name",$value);
				
				 $heading = $jobjob_type_name . ' job select in  Job Complaint';		
				add_complaint_notes($job_id,$id, $heading, $heading);
				add_job_notes($job_id,$heading,$heading);	
				
			}elseif($varx[1] == 'job_complaint.job_handling') {
				
				$bool = mysql_query("update $table set ".$field." = '".mysql_real_escape_string($value)."' , complaint_handling_date= '".date('Y-m-d H:i:s')."' where id=".$id."");
				
			}elseif($varx[1] == 'job_complaint.move_from_contract' && $value == 1) {
			  
			  $bool =  mysql_query("UPDATE job_complaint SET  ".$field." = '".mysql_real_escape_string($value)."' , complaint_sent_to_cleaner = '0000-00-00 00:00:00' , job_handling = 0 , complaint_handling_date = '0000-00-00 00:00:00', email_send_to_cleaner = '0000-00-00 00:00:00' , move_from_contract = 0, move_contact = '0000-00-00 00:00:00'  WHERE id = {$id}");
			
	        }else{			
				  $bool = mysql_query("update $table set ".$field." = '".mysql_real_escape_string($value)."' where id=".$id."");
			}
			
			//echo $value;
			
				$job_id =  get_rs_value("job_complaint","job_id",$id);
				if($field == 'complaint_type') {
				  $getname = get_sql("system_dd","name"," where type='125' AND id='".$value."'");
				}elseif($field == 'complaint_status') {
				  $getname = get_sql("system_dd","name"," where type='124' AND id='".$value."'");	
				}elseif($field == 'job_handling') {
				 $getname_1 = get_sql("system_dd","name"," where type='139' AND id='".$value."'");	
				}elseif($field == 'job_handling_by_clnr') {
				 $getname_1 = get_sql("system_dd","name"," where type='146' AND id='".$value."'");	
				}elseif($field == 'complaint_process_status') {
				  $getname = get_sql("system_dd","name"," where type='140' AND id='".$value."'");	
				}elseif($field == 'complaint_resolve') {
				  $getname = get_sql("system_dd","name"," where type='144' AND id='".$value."'");	
				}elseif($field == 'move_from_contract') {
				  $getname = get_sql("system_dd","name"," where type='146' AND id='".$value."'");	
				}elseif($field == 'admin_id') {
				 // $getname = get_sql("system_dd","name"," where type='124' AND id='".$value."'");	
				   $getname=get_rs_value("admin","name",$value);		
				}
			
			if($getname != '') {
                $heading = 'Complaint ' .ucfirst(str_replace('_' , ' ' , $field)).' Change  to '.	$getname;		
				add_complaint_notes($job_id,$id, $heading, $heading);
				add_job_notes($job_id,$heading,$heading);	
				//echo $value;
			}
		
	}elseif($varx[1] == 'quote_new.suburb') {
		
		$getPostCode = mysql_fetch_array(mysql_query("SELECT postcode  FROM `postcodes` WHERE `suburb` = '".$value."' AND `site_id` = ".$siteid.""));
		
		if(!empty($getPostCode)) {
		   $postcode = $getPostCode['postcode'];
		}else {
			$postcode = 0;
		}
		
		// $bool = mysql_query("update quote_new set postcode = '".$postcode."' where id=".$id.""); 
		 
		 $bool = mysql_query("update ".$table." set ".$field."='".$value."',postcode = '".$postcode."' , site_id = ".$siteid." where id=".$id."");
		
		  $booking_id1 =  get_rs_value("quote_new","booking_id",$id);
		 if($booking_id1 != '0') {
			$bool = mysql_query("update job_details set site_id= '".$siteid."'  where job_id=".$booking_id1." and quote_id='".$id."'");
			$bool1 = mysql_query("update jobs set site_id= '".$siteid."'  where id=".$booking_id1."");
		} 
		 
		 
	}elseif($varx[1]=="job_details.payment_check"){
		//echo "update job_details set payment_check='".$value."',payment_check_date='".date("Y-m-d")."' where id=".$id."";
		$bool = mysql_query("update job_details set payment_check='".$value."',payment_check_date='".date("Y-m-d")."' where id=".$id."");
		
	}elseif($varx[1]=="job_checklist.comment"){
		//echo "update job_details set payment_check='".$value."',payment_check_date='".date("Y-m-d")."' where id=".$id."";
		$bool = mysql_query("update job_checklist set comment='".$value."',createdOn='".date("Y-m-d H:i:S")."' where id=".$id."");
		
	}elseif($varx[1]=="sales_task_track.task_manage_id") { 
	    //SELECT id FROM `sales_task_track` WHERE job_id = 4762 and track_type = 2
	     $trackid = get_sql("sales_task_track","id"," where job_id = ".$id." and track_type = 2");
	    
	    $bool = mysql_query("update  jobs set task_manage_id='".$value."' , sales_track_id = '.$trackid.' where id='".$id."'");
		$bool = mysql_query("update sales_task_track set task_manage_id='".$value."' where job_id='".$id."' AND track_type = 2 ");
		
		 $adminname=get_rs_value("admin","name",$value);		
		 $staff=get_rs_value("admin","name",$_SESSION['admin']);		
		$heading = 'Opretion Task Assign to '.$adminname.' By '.$staff;
		
		mysql_query("INSERT INTO `task_manager` (`completed_date`, `admin_id`, `task_type`, `quote_id`, `job_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('".date('Y-m-d H:i:s')."', '".$_SESSION['admin']."', '2', '0', '".$id."', '14', '0', '".date('Y-m-d H:i:s')."', '0');");
		
		add_job_notes($id,$heading,$heading);	
		
	}elseif($varx[1]=="quote_new.login_id"){
		  $bool = mysql_query("update quote_new set login_id='".$value."'  where id=".$id."");
		  //$bool1 = mysql_query("update sales_system set task_manage_id='".$value."'  where quote_id=".$id."");
		  
		   $booking_id1 =  get_rs_value("quote_new","booking_id",$id);
		   if($booking_id1 == 0) {
		       $track_type = 1;
		       
		        $qname =  get_rs_value("admin","name",$value);
				$heading = "Quote  Assign to ".$qname."";
				add_quote_notes($id,$heading,$heading);	
		       
		   }else{
		        $track_type = 2;
		        
		         $qname =  get_rs_value("admin","name",$value);
				$heading = "Quote  Assign to ".$qname."";
				add_job_notes($booking_id1,$heading,$heading);	
		   }
		   
		  //echo "update sales_task_track set task_manage_id='".$value."'  where quote_id=".$id." AND track_type = ".$track_type.""; die; 
		  
		  
		  $bool1 = mysql_query("update sales_task_track set task_manage_id='".$value."'  where quote_id=".$id." AND track_type = ".$track_type."");
		  mysql_query("INSERT INTO `task_manager` (`completed_date`, `admin_id`, `task_type`, `quote_id`, `job_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('".date('Y-m-d H:i:s')."', '".$_SESSION['admin']."', '".$track_type."', '".$id."', '".$booking_id1."', '16', '0', '".date('Y-m-d H:i:s')."', '0');");
		     
		
	}elseif($varx[1]=="jobs.online_payment_status" || $varx[1]=="jobs.deposit"){
		//echo "update job_details set payment_check='".$value."',payment_check_date='".date("Y-m-d")."' where id=".$id."";
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		  if($field == 'online_payment_status'){
	   	    $getname = get_sql("system_dd","name"," where type='65' AND id='".$value."'");
			$heading = "Online Payment Status change ".$getname."";
		  }else{
			  $getname = get_sql("system_dd","name"," where type='40' AND id='".$value."'");
			  $heading = "Deposit Status change ".$getname."";
		  }
			add_job_notes($id,$heading,$heading);	
		
	}elseif($varx[1]=="job_details.real_estate_agency_name" || $varx[1]=="job_details.agent_name" || $varx[1]=="job_details.agent_number" || $varx[1]=="job_details.agent_email" || $varx[1]=="job_details.agent_landline_num" || $varx[1]=="job_details.agent_address"){
		
		// For Job Real Estate Agent
		//echo "update job_details set ".$field."='".$value."'  where job_id=".$id."";
		 $bool = mysql_query("update job_details set ".$field."='".$value."'  where job_id=".$id."");
		 
		  if($varx[1]=="job_details.real_estate_agency_name") {
			  $field = 'agency_name';
		  }else{
			  $field = $field;
		  }
		 $bool = mysql_query("update quote_new set ".$field."='".$value."'  where booking_id=".$id."");
		 
	}elseif($varx[1]=="job_reclean.real_estate_agency_name" || $varx[1]=="job_reclean.agent_name" || $varx[1]=="job_reclean.agent_number" || $varx[1]=="job_reclean.agent_email"){
		// For reclean Real Estate Agent
		 $bool = mysql_query("update job_reclean set ".$field."='".$value."'  where job_id=".$id."");
		 
	}elseif($varx[1]=="job_details.payment_completed" || $varx[1]=="job_details.pay_staff" || $varx[1]=="job_details.acc_payment_check" || $varx[1]=="job_details.payment_onhold"){
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id.""; die;
	   // $job_id =  get_rs_value("job_details","job_id",$id);
	   
	    $jobDetails = mysql_fetch_array(mysql_query("select job_id,job_type from job_details where id=".$id.""));
		
		if($field == 'payment_completed')	{ $field_heading = 'Admin Check'; $type = '18'; }elseif($field == 'pay_staff')	{ $field_heading = 'Pay Staff'; $type = '18'; }elseif($field == 'payment_onhold')	{ $field_heading = 'Payment Hold'; $type = '18'; }elseif($field == 'acc_payment_check')	{ $field_heading = 'Account Completed'; $type = '18'; }
		
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id."";  die;
		
		// For reclean Real Estate Agent
			$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");

			$getname = get_sql("system_dd","name"," where type='18' AND id='".$value."'");
			$heading = $field_heading . " change ".$getname." in (".$jobDetails['job_type'].")";
			add_job_notes($jobDetails['job_id'],$heading,$heading);	 
		 
	}else if($varx[1]=="jobs.acc_payment_check"){
		// check if all job_details are in journal_entry or not. if not add them
		if($value=="1"){				
		}
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
	}else if($varx[1]=="jobs.eway_token"){
		
		//echo "SELECT id , job_id , cc_num , token_id FROM `payment_gateway` WHERE id = ".$id.""; die;
		
		$cndetails = mysql_fetch_array(mysql_query("SELECT id , job_id , cc_num , token_id FROM `payment_gateway` WHERE id = ".$id.""));	
		//print_r($cndetails); die;
		if(!empty($cndetails)) {
			$bool = mysql_query("update jobs set eway_token ='".$cndetails['token_id']."' where id=".$cndetails['job_id']."");
			$adminname =  get_rs_value("admin","name",$_SESSION['admin']);
			$heading = $adminname . " Make ".$cndetails['cc_num']." Default Cart";
			add_job_notes($cndetails['job_id'],$heading,$heading);	 
		}
		
	}else if($varx[1]=="quote_new.client_type"){
		// check if all job_details are in journal_entry or not. if not add them
		if($value == 1) {
		  //	agency_name  agent_name agent_number agent_email agent_landline_num agent_address
		  //$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		  $bool = mysql_query("update ".$table." set ".$field."='".$value."' , agency_name = '', agent_name = '', agent_number = '', agent_email = '', agent_landline_num = '' , agent_address = '' where id=".$id."");
		}else if($value == 2) {
		  //	agency_name  agent_name agent_number agent_email agent_landline_num agent_address
		   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		   /*   $bool = mysql_query("update ".$table." set ".$field."='".$value."' , agency_name = '', agent_name = '', agent_number = '', agent_email = '', agent_landline_num = '' , agent_address = '' where id=".$id.""); */
		}
		
	}else if($varx[1]=="quote_new.job_ref"){
		// check if all job_details are in journal_entry or not. if not add them
		if($value != 'Staff'){
		  $bool = mysql_query("update ".$table." set ".$field."='".$value."', referral_staff_name = '0' where id=".$id."");
		}else {
			$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		}
		
	}else if($varx[1]=="quote_new.booking_date"){
	  
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		$GetJobID =  get_rs_value("quote_new","booking_id",$id);
		 $heading = 'Job Date Change '.$value;
		if($GetJobID != '0' && $GetJobID != '') {
			 $jobDetails = mysql_query("update job_details set job_date= '".$value."'  where job_id=".$GetJobID." and quote_id='".$id."'");
			 $bool1 = mysql_query("update jobs set job_date= '".$value."'  where id=".$GetJobID." AND quote_id='".$id."'");
			 
			 add_job_notes($GetJobID,$heading,$heading);
		}  
		 add_quote_notes($id,$heading,$heading); 
		 
	}else if($varx[1]=="job_details.amount_total"){
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		$job_id=get_rs_value("job_details","job_id",$id);
		recalc_job_total($job_id);
		$heading="Total Amount changed to $".$value;
		add_job_notes($job_id,$heading,$heading);
		
	}else if($varx[1]=="message_board.replay_text"){
		
		$adminname=get_rs_value("admin","name",$_SESSION['admin']);
		
		$bool = mysql_query("update ".$table." set ".$field."='".mysql_real_escape_string($value)."' , message_replay_user = '".$adminname."' , replay_date = '".date('Y-m-d H:i:s')."'  where id=".$id."");
		
	}else if($varx[1]=="jobs.team_id"){
		
		$adminname=get_rs_value("admin","name",$_SESSION['admin']);
		$teamname = get_sql("system_dd","name"," where type='87' AND id='".$value."'");
		$getadminname = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(name) as name  FROM `admin` WHERE team_id = ".$value." and status = 1 AND is_call_allow = 1"));
		
/* 		echo "update ".$table." set ".$field."='".mysql_real_escape_string($value)."' , team_name = '".$getadminname['name']."' , team_assign_id = '".$_SESSION['admin']."' where id=".$id.""; */
		
		$bool = mysql_query("update ".$table." set ".$field."='".mysql_real_escape_string($value)."' , team_name = '".$getadminname['name']."' , team_assign_id = '".$_SESSION['admin']."' where id=".$id."");
		$heading = $teamname.' ('.$getadminname['name'].') ' .' Assign by '.$adminname;
		add_job_notes($id,$heading,$heading);	 
		
	}else if($varx[1]=="job_reclean.reclean_status" || $varx[1]=="job_reclean.reclean_work"){
		//echo "Ok"; die; failed_reclean_time
		if($varx[1]=="job_reclean.reclean_work" && $value == 2) {
			  $bool = mysql_query("update ".$table." set ".$field."='".$value."' ,failed_reclean_time = '".date('Y-m-d H:i:s')."' where id=".$id."");
		}else{
		    $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		}
		
		$job_id=get_rs_value("job_reclean","job_id",$id);
		
		if($field == 'reclean_status') {
		  $getname = get_sql("system_dd","name"," where type='37' AND id='".$value."'");
		  $heading = "Re-clean status change ".$getname;
		}elseif($field == 'reclean_work') {
			$getname = get_sql("system_dd","name"," where type='86' AND id='".$value."'");
			$heading = "Re-clean Work status change ".$getname;
		}
		add_reclean_notes($job_id,$heading,$heading);
		add_job_notes($job_id,$heading,$heading);	 
	}else if($varx[1]=="job_payments.payment_card_status"){
		//echo "Ok"; die;
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id.""; die;
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		$job_id=get_rs_value("job_payments","job_id",$id);
		$getname = get_sql("system_dd","name"," where type='46' AND id='".$value."'");
		$heading = "Payment Status change ".$getname;
		add_job_notes($job_id,$heading,$heading);	 
		
	}else if($varx[1]=="quote_new.re_schedule"){
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		$getname = get_sql("system_dd","name"," where type='49' AND id='".$value."'");
		$heading = "Re Schedule Change  ".$getname;
		 add_quote_notes($id,$heading,$heading); 

	}else if($varx[1]=="quote_new.login_id.admin"){
	
	    $quotedetails = mysql_fetch_array(mysql_query("SELECT id , name, login_id, booking_id  FROM `quote_new` WHERE id = ".$id.""));	
		
		$adminfrom = get_rs_value("admin","name",$quotedetails['login_id']);
		$admintto=get_rs_value("admin","name",$value);
		
		$admin_name=get_rs_value("admin","name",$_SESSION['admin']);
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		$heading =  'Change Booking admin name '.$adminfrom.' to '.$admintto;
		
		add_quote_notes($id,$heading,$heading); 
		
		$notificationArrayData = array(
			'notifications_type' => 8,
			'quote_id' => 0,
			'job_id' => mysql_real_escape_string($quotedetails['booking_id']),
			'staff_id' => 0,
			'heading' => $heading,
			'comment' => $heading,
			'notifications_status' => 0,
			'task_manage_id' => 3,
			'login_id' => $_SESSION['admin'],
			'staff_name' => $admin_name,
			'date' => date("Y-m-d H:i:s")
		);
		
	add_site_notifications($notificationArrayData);
	
	$notificationArrayData1 = array(
			'notifications_type' => 8,
			'quote_id' => 0,
			'job_id' => mysql_real_escape_string($quotedetails['booking_id']),
			'staff_id' => 0,
			'heading' => $heading,
			'comment' => $heading,
			'notifications_status' => 0,
			'task_manage_id' => 12,
			'login_id' => $_SESSION['admin'],
			'staff_name' => $admin_name,
			'date' => date("Y-m-d H:i:s")
		);
		
	add_site_notifications($notificationArrayData1);
		

	}else if($varx[1]=="site_notifications.login_id"){
		
		
		//echo 'sfsdsd'; die;
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id.""; die;
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."',task_type = 2, task_from = '".$_SESSION['admin']."' , notifications_type = 8  where id=".$id."");
		
		$admim_name =  get_rs_value("admin","name",$_SESSION['admin']);	
		//$adminto =  get_rs_value("admin","name",$value);	
		//$getname = get_sql("system_dd","name"," where type='49' AND id='".$value."'");
		$heading = " Notification Task assign By ".$admim_name;
		$site_notification = mysql_fetch_assoc(mysql_query("select quote_id, heading , job_id  from site_notifications where id=".$id.""));
		
	//  print_r($site_notification); die;	
	   $adminto =  get_rs_value("admin","name",$value);	
		
		$comment = '(' .$site_notification['heading']. ') Assign to '. $adminto;
		
		if($site_notification['job_id'] > 0) {
		  add_job_notes($site_notification['job_id'],$heading,$comment); 
		}else if($site_notification['quote_id'] > 0){
			add_quote_notes($site_notification['quote_id'],$heading,$comment); 
		}

	}else if($varx[1]=="jobs.upsell_admin"){
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
		//$getname = get_sql("system_dd","name"," where type='49' AND id='".$value."'");
		$adminname=get_rs_value("admin","name",$value);
		//$heading = "Re Schedule Change  ".$getname;
		$heading = 'Upsell Admin name Change to '.$adminname;
		 add_job_notes($id,$heading,$heading); 

	}else if($varx[1]=="jobs.reclean_region_notes"){
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");

		$heading = 'Added region Notes for Solve Re-Clean Emails ';
		$comment = mysql_real_escape_string($value);
		 add_job_notes($id,$heading,$comment); 
		 
	}else if($varx[1]=="jobs.exit_awating_admin"){
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");

		$adminname=get_rs_value("admin","name",$value);
		$heading = 'Exit awating Aassigned  to '.$adminname;
		
		add_job_notes($id,$heading,$heading); 
		
	}else if($varx[1]=="jobs.reclean_received"){
	
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");

		//$adminname=get_rs_value("admin","name",$value);
		$getname11 = get_sql("system_dd","name"," where type='134' AND id='".$value."'");
		$heading = 'Re-Clean  Recived Changes to '.$getname11;
		add_job_notes($id,$heading,$heading); 
		
	}else if($varx[1]=="site_notifications.message_status"){
	   $currentDate = date('Y-m-d H:i:s');
	//	$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
	
	 if($value == 3) {
	     
	       	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);

       	 $currentDate = date('Y-m-d H:i:s');
         $messageRead = $staff_name.'_('.$currentDate.')';
    
	     
	     $qryBool = mysql_query( "UPDATE site_notifications SET notifications_status = 1, task_complete_date = '".$currentDate."' , notification_read_user = '".$messageRead."' , message_status = 3 WHERE id = {$id}" );
	     
	     //	$qryBool = mysql_query( "UPDATE site_notifications SET notifications_status = 1, task_complete_date = '".$currentDate."' , message_status = 3 WHERE id = {$id}" );
	 }else{
	     $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
	 }

		
	}else if($varx[1]=="jobs.new_re_clean"){
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		$getname11 = get_sql("system_dd","name"," where type='132' AND id='".$value."'");
		$heading = 'New email Re-clean status change to '.$getname11;
		add_job_notes($id,$heading,$heading); 
		
		if($value == 5) {
		  $bool = mysql_query("update jobs set awaiting_exit_receive = '".date('Y-m-d H:i:s')."' where id=".$id."");
		  $heading = 'Awaiting Exit Report Recived ';
		  add_job_notes($id,$heading,$heading); 
		  
		}
		
		if($value == 9) {
		  $bool = mysql_query("update ".$table." set status ='".$value."' , awaiting_exit_change_date = '".date('Y-m-d H:i:s')."' where id=".$id."");
		   $heading1  =  'Status  Change '.$getname11;
		  add_job_notes($id,$heading1,$heading1); 
		}
		
		
	}else if($varx[1]=="jobs.status"){ 
		
		$JcomplaintDetails = mysql_fetch_assoc(mysql_query("select job_id, complaint_status ,complaint_type from job_complaint where job_id=".$id." AND complaint_date = '0000-00-00 00:00:00'"));
		$updateStatua = 0;
		
		if(!empty($JcomplaintDetails)) {
		    if($JcomplaintDetails['complaint_date'] != '0000-00-00 00:00:00' && $value == 3) {
			 $flag_data = 1;
			 $status_1 =  get_rs_value("jobs","status",$JcomplaintDetails['job_id']);
			  echo $status_1.'_not';
			  $updateStatua = 1;
			}
		}
		 
		if($updateStatua == 0) {
			if($value == 4) {
				if($JcomplaintDetails['complaint_status'] == '' && $JcomplaintDetails['complaint_status'] == 0) {
					$site_id =  get_rs_value("jobs","site_id",$id);	
					$jobstatua =  get_rs_value("jobs","status",$id);
				    mysql_query("INSERT INTO `job_complaint` (`job_id`,  `admin_id`, `site_id`, `status`, `job_status`, `createdOn`) VALUES ('".$id."',  '".$_SESSION['admin']."', '".$site_id."', '1', '".$jobstatua."', '".date('Y-m-d H:i:s')."')");
				   $idcomp = mysql_insert_id();
				   $heading = 'Job Add In Complaint Status';
				   add_complaint_notes($id,$idcomp, $heading, $heading);
				  // add_job_notes($id,$heading,$heading);	
				    //echo $value;
				}
			}
			
			if($value == 9) {
			
						$bool = mysql_query("update ".$table." set status ='".$value."' , awaiting_exit_change_date = '".date('Y-m-d H:i:s')."' where id=".$id."");
						$getname11 = get_sql("system_dd","name"," where type='26' AND id='".$value."'");
						$heading11  =  'Status  Change '.$getname11;
						add_job_notes($id,$heading11,$heading11);	
			
			}elseif($value == 5) {
				  $bookingdate = mysql_fetch_assoc(mysql_query("select booking_date from quote_new where booking_id=".$id.""));
				
							$date1=date_create($bookingdate['booking_date']);
							$date2=date_create(date('Y-m-d'));
							$diff=date_diff($date1,$date2);
							$days =  $diff->format("%a"); 
							if($days > 7) {
								 echo 'erro';
								 $flag_data = 1;
							}else{
									$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
									$getname11 = get_sql("system_dd","name"," where type='26' AND id='".$value."'");
									$heading1  =  'Status  Change '.$getname11;
									add_job_notes($id,$heading1,$heading1);	
							}
				
				 
			}
			  else
			{
					
					$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
					$getname11 = get_sql("system_dd","name"," where type='26' AND id='".$value."'");
					$heading1  =  'Status  Change '.$getname11;
					add_job_notes($id,$heading1,$heading1);	
					
						if($value == 2) {
							sendCancelsmsDesc($id);
							$jobamt =  get_rs_value("jobs","customer_amount",$id);
							$bool = mysql_query("update jobs set cancelled_status = 1 , cancelled_amt = '".$jobamt."'  ,cancelled_login_id = ".$_SESSION['admin']." , cancelled_date = '".date('Y-m-d H:i:s')."' where id=".$id."");
						}
			}
	    }
		
	}else{
		
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id.""; die;
		
		$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		
	    if($field == 'start_time')	{ $field = 'Start Time:'; $type = 'job_detailspopup'; }elseif($field == 'get_entry')	{ $field = 'How Get Entry'; $type = 'job_detailspopup'; }elseif($field == 'cleaner_park')	{ $field = 'Cleaner Park '; $type = 'job_detailspopup'; }elseif($field == 'work_guarantee')	{ $field = 'Work Guarantee'; $type = '35'; }elseif($field == 'payment_agree_check')	{ $field = 'Payment Agree Check'; $type = '107'; }elseif($field == 'job_assign_status')	{ $field = 'Job Assign Status'; $type = '133'; }elseif($field == 'estimate_status')	{ $field = 'Estimate Status'; $type = '122'; }elseif($field == 'assigning_status')	{ $field = 'Assigning Status'; $type = '35'; }elseif($field == 'customer_experience')	{ $field = 'Customer experience'; $type = '36'; }elseif($field == 'staff_display_address')	{ $field = 'Staff Display Address'; $type = '29'; }elseif($field == 'work_guarantee_text'){ $field = 'Work Guarantee with Reason'; $type = 'job_detailspopup'; }elseif($field == 'status')	{ $field = 'Status'; $type = '26'; }elseif($field == 'customer_payment_method') { $field = 'Customer Payment method';  $type = 'job_detailspopup'; }elseif($field == 'invoice_status'){$field = 'Invoice Status'; $type = '21';  }elseif($field == 'customer_paid'){ $field = 'Customer paid'; $type = '18'; }elseif($field == 'customer_amount') { $field = 'Customer amount'; $type = 'job_detailspopup'; }elseif($field == 'customer_paid_date'){ $field = 'Customer paid date'; $type = 'job_detailspopup';}elseif($field == 'amount_staff'){ $field = 'Staff Amount'; $new_type = 'paymentSection';$crncy='$';}elseif($field == 'amount_profit'){ $field = 'Profit Amount'; $new_type = 'paymentSection';$crncy='$';}elseif($field == 'phone'){ $field = 'Client Phone Number'; $new_type = 'paymentSection';}elseif($field == 'upsell_denied'){ $field = 'Upsell Denied'; $type = '106'; }elseif($field == 'upsell_required'){ $field = 'Upsell Required'; $type = '127'; }
	     
		 //exit_awating_admin
		 
		if($type !='') {
			
			if($type == 'job_detailspopup'){
				 $heading = $field.' Change '.$value;
			     $comment = $field.' Change '.$value;
			}else{
	          $getname = get_sql("system_dd","name"," where type='".$type."' AND id='".$value."'");
			  $heading = $field.' Change '.$getname;
			  $comment = $field.' Change '.$getname;
			}
			
			add_job_notes($id,$heading,$comment); 
			
		}
				
		if($new_type !='' && $new_type == 'paymentSection'){ 
			$job_id=get_rs_value("job_details","job_id",$id);
			if($job_id==''){
				$job_id=get_rs_value("quote_new","booking_id",$id);
			}
			$heading = $field.' Changed to '.$crncy.$value;
			$comment = $field.' Changed to '.$crncy.$value;
			
			add_job_notes($job_id,$heading,$comment);
		}	
	}
	 
	  if($flag_data == 0) {
	    echo trim($value);
	  }
}

function sendCancelsmsDesc($job_id){
	
	$sql = mysql_query("select DISTINCT(staff_id) as staff_id1 , job_date from job_details where job_id=".$job_id." AND status != 2 AND staff_id != 0");
	if(mysql_num_rows($sql)>0) {
		
		while($data = mysql_fetch_assoc($sql)){
			
			//print_r($data); 
			
			 $staff_details = mysql_fetch_array(mysql_query("SELECT name, mobile FROM `staff` where id=".$data['staff_id1'].""));	
			
			$clientname = mysql_fetch_array(mysql_query("SELECT name FROM `quote_new` where booking_id=".$job_id.""));	
			
			$msg = "Hi ".$staff_details['name'].", J#".$job_id." for ".$clientname['name']." is cancelled for ".date("dS M Y",strtotime($data['job_date'])).". Thanks";
			
			$heading = "Send Cancelled SMS ".$staff_details['name']." on ".$staff_details['mobile']; 
			//$sms_code = send_sms(str_replace(" ","",$staff_details['mobile']),$msg);
			//sleep(5);
			echo $staff_details['mobile'];
			//$sms_code = send_sms(str_replace(" ","",11111111111),$msg); //04-03-2019
			$sms_code = send_sms(str_replace(" ","",$staff_details['mobile']),$msg);
			//echo $sms_code.'hih';
			if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";}
			  add_job_notes($job_id,$heading,$msg); 
				
			}
		}
	}
	
function delete_job_details($job_details_id){
	 
	$getjobdetails = mysql_fetch_array(mysql_query("SELECT job_id FROM `job_details` where id=".$job_details_id.""));	
	$bool = mysql_query("update job_details set status=2 where id=".$job_details_id."");
	echo '<td colspan="9">Deleted Successfully</td>';
	recalc_job_total($getjobdetails['job_id']);
}

function delete_job_reclean_details($job_details_id){	
	$bool = mysql_query("update job_reclean set status=2 where id=".$job_details_id."");
	
	$job_type = get_rs_value("job_reclean","job_type",$job_details_id);
	$job_id = get_rs_value("job_reclean","job_id",$job_details_id);
	$job_type_id = get_rs_value("job_reclean","job_type_id",$job_details_id);
	
	$bool = mysql_query("update job_details set reclean_job='1' where job_id=".$job_id." AND status != 2 AND  reclean_job = 2  AND job_type_id =".$job_type_id."");	
	
	$heading = "Remove ".$job_type." job form Re-Clean";
	add_reclean_notes($job_id,$heading,$heading);
	add_job_notes($job_id,$heading,$heading);
	echo '<td colspan="9">Deleted Successfully</td>';
 }

function add_comments($var){
	$varx = explode("|",$var);
	$comment = $varx[0];
	$job_id= $varx[1];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	if($comment!=""){
		add_job_notes($job_id,"Note Added By ".mysql_real_escape_string($staff_name),$comment);
	}
	include("job_notes.php");
	
}

function staff_add_comments($var){
	$varx = explode("|",$var);
	$comment = $varx[0];
	$job_id= $varx[1];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	if($comment!=""){

	   $heading = "Staff Note Added by ".mysql_real_escape_string($staff_name);
		
		 $staffid =  mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(staff_id) as staffid FROM `job_details` WHERE job_id = ".$job_id.""));
		
		$taffids = explode(',' ,$staffid['staffid']);
		
		if(!empty($taffids)) {
			foreach($taffids as $staffid) {
		       $getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id  = '".$staffid."'"));

				 $result['user_to'] = get_rs_value("staff","name",$staffid);	
				 $result['chatter'] = $staffid;
				 $result['admin_id'] = $_SESSION['admin'];
				 $result['admin'] = 'admin';
			  
			  
			    if(!empty($getlogin_device['deviceid'])) {
						 if($getlogin_device['deviceid'] != '') {
							 $heading.=" (Notification Delivered)"; 
							 $flag = 1; 
							 $result['deviceid'] = $getlogin_device['deviceid'];
						 }else{
							 $heading.="  <span style=\"color:red;\">(Notification Failed)</span>"; 
							 $flag = 2; 
							 $result['deviceid'] = $getlogin_device['deviceid'];
						 }
				   
			         sendNotiMessage($comment , $result);
				}
			}
		}
		
		add_staff_notes('0',$job_id,$heading,$comment);
		add_job_notes($job_id,$heading,$comment);
	}
	include("job_notes.php");
	
}

function add_comment_reclean($var){
	$varx = explode("|",$var);
	$comment = $varx[0];
	$job_id= $varx[1];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	if($comment!=""){
	
		add_reclean_notes($job_id,"Re-Clean Note Added by ".mysql_real_escape_string($staff_name),$comment);
		add_job_notes($job_id,"Re-Clean Note Added by ".mysql_real_escape_string($staff_name),$comment);
	}
	include("reclean_notes.php");
	
}

function specfic_add_comment_reclean($var){
	$varx = explode("|",$var);
	$comment = $varx[0];
	$job_id= $varx[1];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	if($comment!=""){
	
		add_reclean_notes($job_id,"Re-Clean Note  For Staff Added by ".mysql_real_escape_string($staff_name),$comment,'','','','','',1);
		add_job_notes($job_id,"Re-Clean Note For Staff Added by ".mysql_real_escape_string($staff_name),$comment);
	}
	include("reclean_notes.php");
	
}

function refress_reclean_notes($jobID){
		$job_id = $jobID;
    include("reclean_notes.php");
}



function refresh_comments(){
	
	include("job_notes.php");
	
}


function send_job_emails($var){
	//echo $var;
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$action= $varx[1];
	
	if($action=="email_client_booking_conf"){
		 
		 
		add_job_notes($job_id,"Sent Booking Confirmation Email","");
		send_email_conf($job_id);
		$bool = mysql_query("update jobs set email_client_booking_conf='".date("Y-m-d h:i:s")."' where id=".$job_id."");
		echo date("d M Y h:i:s");
		
	}else if ($action=="email_client_cleaner_details"){ 
	  
	        $job_type_id = get_sql("job_details","job_type_id"," where job_type_id='11' AND job_id='".$job_id."' AND status != 2");
			 if($job_type_id == 11){
				$heading =  "Sent Client Removal Details";
			 }else{
				 $heading =  "Sent Client Cleaner Details";
			 }
   
		add_job_notes($job_id,$heading,"");
		send_cleaner_details($job_id);
		$bool = mysql_query("update jobs set email_client_cleaner_details='".date("Y-m-d h:i:s")."' where id=".$job_id."");
		echo date("d M Y h:i:s");
	}else if ($action=="sms_client_cleaner_details"){ 
	
		send_cleaner_details_to_clients($job_id);
	}else if ($action=="email_client_invoice"){ 

	}
}


		function send_new_sms_noti($var) {
			   
				$varx = explode("|",$var);
				$job_id = $varx[0];
				$action= $varx[1];

				  
				if($action=="new_sms_to_client_date"){

				 $sql1 = mysql_query("select DISTINCT(staff_id) as staff_id1 , job_date from job_details where job_id=".$job_id." AND status != 2 AND staff_id != 0");
				 

				 if(mysql_num_rows($sql1) > 0){
                           
						   while($data_1 = mysql_fetch_assoc($sql1)) {
							    $getstaffid[] = $data_1['staff_id1'];
						   }
				 }
                    	 echo send_sms_to_clnt_staff($job_id , 1, $getstaffid);
						//add_job_notes($job_id,"Sent SMS to Client SMS","");
					
						//$bool = mysql_query("update jobs set new_sms_to_client_date='".date("Y-m-d h:i:s")."' where id=".$job_id."");
						//echo date("d M Y h:i:s");

				}elseif($action=="noti_to_cleaner"){

				        $sql = mysql_query("select DISTINCT(staff_id) as staff_id1 , job_date from job_details where job_id=".$job_id." AND status != 2 AND staff_id != 0");
						if(mysql_num_rows($sql) > 0){
                           
						   while($data = mysql_fetch_assoc($sql)) {
						       
							 echo   send_sms_to_clnt_staff($job_id, 2 ,  $data['staff_id1']);
							   
						   }
						    
						}
						//add_job_notes($job_id,"Sent Booking Confirmation Email","");
						
						//$bool = mysql_query("update jobs set noti_to_cleaner='".date("Y-m-d h:i:s")."' where id=".$job_id."");
						//echo date("d M Y h:i:s");

				}
			
		}
   

/* function send_job_sms_new($var){
	
	
	$varx = explode("|",$var);
	$action = $varx[0];
	$job_details_id = $varx[1];
	$pagetype = $varx[2];
	$smstype = $varx[3];
	$eol="";

	
	$job_details = mysql_fetch_array(mysql_query("select * from job_details where id=".$job_details_id." AND status != 2"));
	
	if($job_details['staff_id']!="0"){ 
		
		$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_details['job_id']).""));
		$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($job_details['quote_id']).""));
		$staff = mysql_fetch_array(mysql_query("select * from staff where id=".mysql_real_escape_string($job_details['staff_id']).""));
		$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." and job_type_id=".mysql_real_escape_string($job_details['job_type_id'])));
		$heading="";
		$comment="";
		if($action=="job"){ 
		
		  // Update job SMS
			if($smstype == 'smstype') {
				  
				$sms_type = 'job_notification_status';
				$sms_type_date = 'job_notification_date';
			}else {
				$sms_type = 'job_sms';
				$sms_type_date = 'job_sms_date';
			}
		
			$heading = "Send ".$job_details['job_type']." Job SMS ".$staff['name']." on ".$staff['mobile'];			
			
			$comment = "Hi ".$staff['name'].", ".$job_details['job_type']." job assigned to you on ".date("d M",strtotime($job_details['job_date'])).". (#".$job_details['job_id'].")";		
			
			
			if($job_details['job_type_id']=="1"){
				
				//Job Furnished or not
				$getFurnished = mysql_fetch_array(mysql_query("select furnished from quote_details where quote_id=".mysql_real_escape_string($job_details['quote_id']).""));	
					
				if(strtolower($getFurnished['furnished']) == 'yes')
				{
					$furnished = ',furnished';
				}
				else{
					$furnished = '';
				}
				$comment.= " ".$quote_details['bed']." bed ".$quote_details['bath']." bath..{$furnished} for Amount of $".$job_details['amount_total']." ";
				
			}else{
				$comment.= " for Amount of $".$job_details['amount_total']." ";
			}
			
			if($job_details['job_type_id']=="11"){
				$comment.= " This job is estimated at ".$quote_details['cubic_meter']." Cubic Metres.";
			}
			
			
			if($quote['suburb']!=""){ $comment.= " in ".$quote['suburb']; }
			$comment.= " Will text you further details on the eve of the job. ";

		}else{
			
			// Update Address SMS
			if($smstype == 'smstype') {
				 $sms_type = 'add_notification_status';
			     $sms_type_date = 'add_notification_date';
			}else{
			 $sms_type = 'address_sms';
			 $sms_type_date = 'address_sms_date';
			}
			
			$heading = "Send ".$job_details['job_type']." Address SMS to ".$staff['name']." on ".$staff['mobile'];			
		
			$comment ="Hi ".$staff['name'].", ".$eol.$job_details['job_type']." (#".$job_details['job_id'].") Job for ".$eol." ".mysql_real_escape_string($quote['name'])." ".$eol." ".$quote['phone']." ".$eol;
			$comment.=" at ".mysql_real_escape_string($quote['address']).", Job details are ";
			$comment.=$eol." ".$quote_details['description'];					
			
			if($job_details['job_type_id']=="2" || $job_details['job_type_id']=="3"){ 			
				
				$carpet_pending = '';
				  
				$comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
				
				
				$cleaning_staff_id = get_sql("job_details","staff_id"," where job_id=".mysql_real_escape_string($job_details['job_id'])." and (job_type_id=1 OR job_type_id= 8) and status!=2");
				
				if($cleaning_staff_id!="" && $cleaning_staff_id != 0  &&  $job_details['staff_id'] != $cleaning_staff_id){ 
					$cleaning_staff = mysql_fetch_array(mysql_query("select name , mobile from staff where id=".mysql_real_escape_string($cleaning_staff_id).""));					
					$comment.=". Please contact Cleaner ".$cleaning_staff['name']." on ".$cleaning_staff['mobile']." for the job timings. ";
				}
				
			 $comment.=$eol."Please invoice to ".$quote['email'].".";	
			 
			}elseif($job_details['job_type_id']=="1"){
				
				$carpet_pending = '';
				
			    $allstaffid = (mysql_query("select staff_id , job_type  from job_details where job_id=".mysql_real_escape_string($job_details['job_id'])."  AND staff_id != 0 AND job_type_id != 1 and status!=2 group by staff_id"));			
				
				 $comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
				 
				        if(mysql_num_rows($allstaffid) > 0) {
						
					
							$comment.=" Please contact ";
							$comment1 = '';
					
								while($getstaff = mysql_fetch_array($allstaffid)) {
								
								    if($getstaff['staff_id'] != $job_details['staff_id']) {
								
									   $staffdetails = mysql_fetch_assoc(mysql_query("select id, name , mobile from staff where id =".mysql_real_escape_string($getstaff['staff_id']).""));	
									   
										$comment1.= $getstaff['job_type']." Cleaner ".$staffdetails['name']." on ".$staffdetails['mobile']." & ";
										
									}
								}
							
						    $comment .= rtrim($comment1 , ' & ');
						    $comment.= " for the job timings. ";
						}
					
			}else{
				
				$comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";	
			}
			
			$comment.=$eol."Thanks .";
			
			if($job_details['job_type_id']=="11"){
				$comment.= " Please call client to confirm arrangement ";
			}
		}
		
		$comment = str_replace('\'' , '' , addslashes(trim($comment)));
		
		if($smstype == 'smstype') {
			 
				$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$job_details['staff_id']."'"));

				$result['user_to'] = get_rs_value("staff","name",$job_details['staff_id']);	
				$result['chatter'] = $job_details['staff_id'];
				$result['admin_id'] = $_SESSION['admin'];
				$result['admin'] = 'admin';
			  
			  
			    if(!empty($getlogin_device['deviceid'])) {
						if($getlogin_device['deviceid'] != '') {
							$heading.=" (Notification Delivered)"; 
							$flag = 1; 
							$result['deviceid'] = $getlogin_device['deviceid'];
						}else{
							$heading.="  <span style=\"color:red;\">(Notification Failed)</span>"; 
							$flag = 2; 
							$result['deviceid'] = $getlogin_device['deviceid'];
						}
				   
			        sendNotiMessage($comment , $result);
				}else{
					$flag = 3; 
					$heading.="  <span style=\"color:red;\">(Notification failed because is not using the app)</span>"; 
				}
			 
			 
		}else {
			
			$sms_code = send_sms(str_replace(" ","",$staff['mobile']),$comment);
			if($sms_code=="1"){ $heading.=" (Delivered)"; $flag = 1; } else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; $flag = 2; } 		
		}
			
			
			add_job_notes($job_details['job_id'],$heading,$comment);
			
			if($flag == '1') {
				
				
				 mysql_query("update job_details set $sms_type ='1',$sms_type_date ='".date('Y-m-d h:i:s')."' where id=".$job_details_id."");
				if($pagetype == 'report') {
					include('dispatch_report.php');
				}else{
				 echo date('Y-m-d h:i:s');
				}
			}elseif($flag == 3) {
				$staff_name = get_rs_value("staff","name",$job_details['staff_id']);	
				 echo $staff_name ." is not installed the app";
			}else {
				 if($pagetype == 'report') {
					 include('dispatch_report.php');
				 }else{
					 echo "Not sent";
				 }
			}
	}else{
		echo " Pls Select Staff ";	
	}
} */



    function send_job_sms_new($var){
		send_Job_add_sms($var);
    }

// Reclean Job & Address Email Send

	function send_reclen_job_sms($var){
		
		//job|7
		//echo $var; die;
		$varx = explode("|",$var);
		$action = $varx[0];
		$job_reclen_id = $varx[1];
		$pagetype = $varx[2];
		$smstype = $varx[3];
		$eol="\r\n";
		
		 $job_recleanDetails = mysql_fetch_array(mysql_query("select * from job_reclean where id=".$job_reclen_id));
		//print_r($job_recleanDetails); die;
		 if($job_recleanDetails['staff_id']!="0"){ 
			

			$staffname = get_rs_value("staff","name",mysql_real_escape_string($job_recleanDetails['staff_id']));	
			$staffmobile = get_rs_value("staff","mobile",mysql_real_escape_string($job_recleanDetails['staff_id']));
			
			$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($job_recleanDetails['quote_id']).""));
			
			$quoteid = $quote['id'];
			$quotesuburb = $quote['suburb'];
			
			
		 //echo $staffname."_".$staffmobile.'_'.$quoteid."_".$quotesuburb; die;
		     $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quoteid)." and job_type_id=".mysql_real_escape_string($job_recleanDetails['job_type_id']))); 
			
			
			  $job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id=".$job_recleanDetails['job_id']." and job_type_id=".mysql_real_escape_string($job_recleanDetails['job_type_id'])." AND reclean_job = 2 AND status != 2")); 
			 
			//print_r($job_details); die; 
			
			 $heading="";
			$comment="";
			
				if($action=="job"){ 
					 //$sms_type = 'job_sms';
					 //$sms_type_date = 'job_sms_date';
					if($smstype == 'smstype') {
						$sms_type = 'add_notification_status';
						$sms_type_date = 'add_notification_date';
					}else{
						$sms_type = 'address_sms';
						$sms_type_date = 'address_sms_date';
					}
					 
					$heading = "Send (Re-Clean) ".$job_recleanDetails['job_type']." Job SMS ".$staffname." on ".$staffmobile;	
				
				}else{  
					//$sms_type = 'address_sms';
					//$sms_type_date = 'address_sms_date';
					if($smstype == 'smstype') {
						$sms_type = 'add_notification_status';
						$sms_type_date = 'add_notification_date';
					}else {
						$sms_type = 'address_sms';
						$sms_type_date = 'address_sms_date';
					}
				
					$heading = "Send (Re-Clean) ".$job_recleanDetails['job_type']." Address SMS to ".$staffname." on ".$staffmobile;	
				}
			$comment = 'Job #'.$job_recleanDetails['job_id'].' We have just sent you reclean advise via email, please review and confirm within 4 hours via the APP reclean start date and time .  thank you';	
			
			//added to add reclean job notification
			$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$job_recleanDetails['staff_id']."'"));
			
			$result['user_to'] = get_rs_value("staff","name",$job_recleanDetails['staff_id']);	
			$result['chatter'] = $job_recleanDetails['staff_id'];
			$result['admin_id'] = $_SESSION['admin'];
			$result['admin'] = 'admin';
			$result['job_id'] = $job_recleanDetails['job_id'];
		   
			if($getlogin_device['deviceid'] != '') {

				   $heading.=" (Notification Delivered)"; 
				   $flag = 1; 
				   $result['deviceid'] = $getlogin_device['deviceid'];
				   sendNotiMessage($comment , $result);
			}else{
				//echo $comment;
				  $sms_code = send_sms(str_replace(" ","",$staffmobile),$comment);
				  if($sms_code=="1"){ $heading.=" (Delivered)"; $flag = 1; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; $flag = 2; } 				
			}
			
			
			
			//echo $comment; die;
			//$sms_code = send_sms(str_replace(" ","",$staffmobile),$comment); //commented on 28-02-2019
			 //$sms_code = send_sms(str_replace(" ","",'11111111'),$comment);
			
			//echo $pagetype; die;   
			 add_job_notes($job_recleanDetails['job_id'],$heading,$comment);
			 add_reclean_notes($job_recleanDetails['job_id'],$heading,$comment);
			if($flag == '1') {
				 mysql_query("update job_reclean set $sms_type ='1',$sms_type_date ='".date('Y-m-d h:i:s')."' where id=".$job_reclen_id."");
				if($pagetype == 'report') {
					include('reclean_report.php');
				}else {
				  echo date('Y-m-d h:i:s');
				}
				
			}else {
			   echo "Not sent";
			}  
		}else{
			echo " Pls Select Staff ";	
		} 
	} 


function send_job_sms($var){
	
	$varx = explode("|",$var);
	$job_id = $varx[1];
	$action= $varx[0];
	$staff_id= $varx[2];
	$job_type_id= $varx[3];
	$eol="\r\n";
	 
	if(($staff_id!="") || ($staff_id!="0")){ 
	
	//echo "select * from staff where id=".mysql_real_escape_string($staff_id).""."<br>";
		$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".mysql_real_escape_string($job_id).""));
		$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
		$staff = mysql_fetch_array(mysql_query("select * from staff where id=".mysql_real_escape_string($staff_id).""));
		$job_details = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." and staff_id='".$staff_id."' and job_type_id=".$job_type_id));
		
		
		if($staff['mobile']!=""){ 
			if($action=="send_job_sms"){ 
				//print_r($staff);
				$heading = "Send Job SMS ".$staff['name']." on ".$staff['mobile'];
				
				if($job_details['job_type_id']=="1"){ 				
					$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." and job_type_id=1"));
					
					$heading = "Send ".$job_details['job_type']." Address SMS to ".$staff['name']." on ".$staff['mobile'];
					
					$comment = "Hi ".$staff['name'].", ".$job_details['job_type']." job assigned to you on ".date("d M",strtotime($job_details['job_date'])).". (#".$job_id.")";
					$comment.= " ".$quote_details['bed']." bed ".$quote_details['bath']." bath.. for $".$quote_details['amount_total']." ";
					if($quote['suburb']!=""){ $comment.= " in ".$quote['suburb']; }
					$comment.= " Will text you further details on the eve of the job. ";
				}else if ($job_details['job_type_id']=="2"){ 				
					$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." and job_type_id=2"));
					
					$heading = "Send ".$job_details['job_type']." Address SMS to ".$staff['name']." on ".$staff['mobile'];			
						
					$comment = "Hi ".$staff['name'].", ".$job_details['job_type']." job assigned to you on ".date("d M",strtotime($job_details['job_date'])).". (#".$job_id.")";
					$comment.=$eol." ".$quote_details['description'];
					
					$comment.=" $".$job_details['amount_total']." ".$eol." ";
					if($quote['suburb']!=""){ $comment.= " in ".$quote['suburb']; }
					$comment.= " Will text you further details on the eve of the job. ";
				}
				
				$sms_code = send_sms(str_replace(" ","",$staff['mobile']),$comment);
				
				if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; } 				
				//echo $comment;
				add_job_notes($job_id,$heading,$comment);
			
			}else if ($action=="send_address_sms"){ 
				if($job_details['job_type_id']=="1"){ 
					$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." and job_type_id=1"));
					
					$heading = "Send ".$job_details['job_type']." Address SMS to ".$staff['name']." on ".$staff['mobile'];
				
					$comment ="Hi ".$staff['name'].", ".$eol.$job_details['job_type']." (#".$job_id.") Job for ".$eol." ".$quote['name']." ".$eol." ".$quote['phone']." ".$eol;
					$comment.=" add: ".$quote['address'].", ";
					
					
					$comment.=$eol." ".$quote_details['description'];					
					$comment.=" $".$job_details['amount_total']." ".$eol." ".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time']." ".$eol."Thanks";
					
					$sms_code = send_sms(str_replace(" ","",$staff['mobile']),$comment);				
					if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; } 					
					add_job_notes($job_id,$heading,$comment);					
					//send_sms(str_replace(" ","",$staff['mobile']),$comment);
				}else if ($job_details['job_type']=="Carpet"){ 				
					$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote['id'])." and job_type_id=2"));
					
					$cleaning_staff_id = get_sql("job_details","staff_id"," where job_id=".mysql_real_escape_string($job_id)." and job_type_id=1");
					$cleaning_staff = mysql_fetch_array(mysql_query("select * from staff where id=".mysql_real_escape_string($cleaning_staff_id).""));
					
					// total payment received
					$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".mysql_real_escape_string($job_id)." and deleted=0");
					$job_payment = mysql_fetch_array($job_payment_data);
					
					// total payment for the job
					$job_details_data = mysql_query("SELECT sum(amount_total) as total_amt FROM `job_details` WHERE job_id=".mysql_real_escape_string($job_id)." and status!=2");
					$job_details_amt = mysql_fetch_array($job_details_data);
					
					if($job_payment['total_amt']<$job_details_amt['total_amt']){
						$carpet_pending = "(Not Paid)";
					}else{
						$carpet_pending = "(Paid)";
					}
					
					$heading = "Send ".$job_details['job_type']." Address SMS to ".$staff['name']." on ".$staff['mobile']." .";				
					$comment ="Hi ".$staff['name'].", ".$eol.$job_details['job_type']." (#".$job_id.") Job for ".$eol." ".$quote['name']." ".$eol." ";
					$comment.= "".$quote['phone']." ".$eol.". address: ".$quote['address'].". ";
					$comment.=$eol." ".$quote_details['description'];
					/*$comment.=$eol." ".$quote_details['bed']." bed ";
					if($quote_details['living']!=""){ $comment.=$quote_details['living']." +Lounge "; }					
					if($quote_details['stairs']!=""){ $comment.=" +Stairs"; }*/
					$comment.=" $".$job_details['amount_total']." ".$carpet_pending." ".$eol." ".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time']." ";
					$comment.=". Please contact Cleaner ".$cleaning_staff['name']." on ".$cleaning_staff['mobile']." for the job timings. ";
					$comment.=$eol."Thanks";
					
					//echo $comment;

					$sms_code = send_sms(str_replace(" ","",$staff['mobile']),$comment);				
					if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; } 					
					add_job_notes($job_id,$heading,$comment);
					send_sms(str_replace(" ","",$staff['mobile']),$comment);
				}
				//send_sms("0421188972",$comment);
			}	
		}else{
			echo error("staff Mobile number is missing");
		}
	}else{
		echo error("Please Select Staff First");	
	}
}

function job_email_template($var){
	//echo $var;
	$varx = explode("|",$var);
	$job_id = $varx[1];
	$action= $varx[0];
	
	if($action=="confirmation"){ 
		echo send_email_conf_template($job_id);
	}else if ($action=="cleaner_details"){ 
		$str = send_cleaner_details_temp($job_id);
		$str = str_replace("<br>","\r",$str); 
		echo strip_tags($str);
		//echo str_replace("<br>","\r",);
	}else if ($action="cleaner_invoice"){ 

	}
}

function email_quote($quote_id){
	 
	$job_id = get_rs_value("quote_new","booking_id",$quote_id);	
	$ssecret = get_rs_value("quote_new","ssecret",$quote_id);	
	if($job_id == "0"){ 
	  add_quote_notes($quote_id,"Emailed Quote",'');
    }else {
	  add_job_notes($job_id,"Emailed Quote",''); 
	}
	
		if($ssecret == ""){ 
		  $secret = str_makerand ("15","25",true,false,true); 
		}else{ 
		   $secret = $ssecret;
		}
	
	$bool = mysql_query("update quote_new set emailed_client='".date("Y-m-d h:i:s")."',ssecret='".mres($secret)."' where id=".$quote_id."");
	
	echo quote_email($quote_id,true);
	echo '<a id="quote_approved_btn" href="javascript:send_data(\''.$quote_id.'\',445,\'quote_approved_btn\');">SMS Quote</a>';
   // echo "<a id='get_sms_quote_div' href='javascript:send_data($quote_id,'445','get_sms_quote_div')' style='color: #fff;text-decoration: none;'>SMS Quote</a>";
	
} 

function email_invoice_item($var){
	//echo $var; die;
	$varx = explode("|",$var);
	$quote_id = $varx[0];
	$staff_id= $varx[1];
	$sendmail= $varx[2];
	
	
	$job_id = get_rs_value("quote_new","booking_id",$quote_id);
	
	if($job_id!=""){ 
	//	$staff_name = get_rs_value("staff","name",$staff_id);
		$email = get_rs_value("quote_new","email",$quote_id);
		$heading = "Invoice Sent on ".$email;
		add_job_notes($job_id,$heading,'');
		$bool = mysql_query("update jobs set email_client_invoice='".date("Y-m-d h:i:s")."' where id=".$job_id."");
	}
	//echo $quote_id."-".$staff_id."-".$sendmail."<br>";
	echo invoice_email($quote_id,$staff_id,$sendmail);	
}

function add_job_payment($var){
	//echo $var;
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$date= $varx[1];
	$amount= $varx[2];
	$pmethod= $varx[3];
	$takenby= $varx[4];
		
	if($job_id!=""){ 		
		add_job_notes($job_id,"Payment of $".$amount." Payment method ( ".$pmethod." )  Taken By ".$takenby."  ",'');
		//echo "insert into job_payments set job_id=".$job_id.",payment_method='".$pmethod."', date='".$date."',amount='".$amount."', taken_by='".$takenby."'";
		$bool = mysql_query("insert into job_payments set job_id=".$job_id.",payment_method='".$pmethod."', date='".$date."',amount='".$amount."', taken_by='".$takenby."'");		
		
		//$job_amt = get_rs_value("jobs","customer_amount",$job_id);
		//if($amount==$job_amt){ $invoice_status=1; }else{ $invoice_status=2; }
		
		$job_payment_data = mysql_query("SELECT sum(amount) as total_amt FROM `job_payments` WHERE job_id=".mysql_real_escape_string($job_id)." and deleted=0");
		$job_payment = mysql_fetch_array($job_payment_data);
		
		// total payment for the job
		$job_details_data1 = mysql_query("SELECT sum(amount_total) as total_amt FROM `job_details` WHERE job_id=".mysql_real_escape_string($job_id)." and status!=2");
		$job_details_amt = mysql_fetch_array($job_details_data1);
		
		//echo $job_payment['total_amt'];
		//$payment_str="Payment Rec:".$job_payment['total_amt']." Total_Amt".$job_details_amt['total_amt']."<br>";
		if($job_payment['total_amt']==""){ 
			$invoice_status=0;
		}else if($job_payment['total_amt']<$job_details_amt['total_amt']){
			$invoice_status=2;
		}else if($job_payment['total_amt']>=$job_details_amt['total_amt']){
			$invoice_status=1;
		}
		
		$uarg = "update jobs set customer_paid_amount='".$amount."', customer_paid=1, customer_paid_date='".date("Y-m-d")."', invoice_status='".$invoice_status."',customer_payment_method='".$pmethod."' where id='".mres($job_id)."'";
		$bool = mysql_query($uarg);
	}
	
	include("view_job_payments.php");
}

function delete_job_payment($var){
	//echo $var;
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$job_payment_id= $varx[1];
		
	if($job_id!=""){ 		
		//add_job_notes($job_id,"Payment of ".$amount." Taken By ".$takenby."  ",'');
		$PaymentDetails = mysql_fetch_assoc(mysql_query("select * from job_payments where job_id=".$job_id." and id=".$job_payment_id.""));
		$heading = "Remove $".$PaymentDetails['amount']." Taken By ".$PaymentDetails['taken_by']."";
		$Comment  = "Remove $".$PaymentDetails['amount']." Payment method (".$PaymentDetails['payment_method'].") AND Taken By ".$PaymentDetails['taken_by']."";
		// print_r($PaymentDetails);
		$bool = mysql_query("delete from job_payments where job_id=".$job_id." and id=".$job_payment_id."");
		add_job_notes($job_id,$heading,$Comment); 
	}
	
	include("view_job_payments.php");
}

function get_staff_dd_job_type($var){
	//echo $var;
	$varx = explode("|",$var);
	$site_id = $varx[0];
	$job_type_id= $varx[1];
	
	$job_type = get_rs_value("job_type","name",$job_type_id);
	//$cond = " (site_id=".$site_id." or site_id2 = ".$site_id.") and status=1 and job_types like '%".$job_type."%'";
	 $cond = " (site_id=".$site_id." or site_id2=".$site_id." OR find_in_set( ".$site_id." , all_site_id)) and status=1 and find_in_set('".$job_type."' , job_types)";
	//echo $cond;
	echo create_dd_staff("a_staff_id","staff","id","name",$cond,"","");
}

function get_staff_reclean_details($var){
	//echo $var;
	//echo "ok"; die;
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$job_type_id= $varx[1];
	
	//$job_type = get_rs_value("job_type","name",$job_type_id);
	if($job_type_id == 0) {
		$cond = " job_id=".$job_id." and status != 2 AND staff_id NOT in (SELECT staff_id FROM `job_reclean` WHERE job_id=".$job_id." AND status != 2)";	
	}else {
	   $cond = " job_id=".$job_id." and status != 2 and job_type_id = '".$job_type_id."'";	
	}
   //echo  $cond; die;
	echo '<span>'.create_dd_staff("reclean_staff_id","job_details","staff_id","staff_id",$cond,"","").'</span>';
}

function add_job_details($var){
	//echo $var;
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$job_type_id= $varx[1];
	$staff_id= $varx[2];
	$job_date= $varx[3];
	$job_time= $varx[4];	
	$amount_total= $varx[5];
	$amount_staff= $varx[6];
	$amount_profit= $varx[7];
		
	if($job_id!=""){ 		
		//add_job_notes($job_id,"Payment of ".$amount." Taken By ".$takenby."  ",'');		
		//$quote_id = get_rs_value("jobs","quote_id",$job_id);
		$job_details = mysql_fetch_array(mysql_query("select * from jobs where id=".$job_id));
		$job_type = get_rs_value("job_type","name",$job_type_id);
		
		$ins_arg = "insert into job_details set 
		job_id=".$job_id.",
		quote_id='".$job_details['quote_id']."',
		site_id='".$job_details['site_id']."',
		job_type_id='".$job_type_id."',
		job_type='".$job_type."',
		staff_id='".$staff_id."',
		job_date='".$job_date."',
		job_time='".$job_time."',
		amount_total='".$amount_total."',
		amount_staff='".$amount_staff."',
		amount_profit='".$amount_profit."'";
		//echo $ins_arg;
		
		$bool = mysql_query($ins_arg);
				
		// recalc the ratio 
		
		// recalc the total 
		recalc_job_total($job_id);
		
		$heading = "Add  New Job ".$job_type."";
		add_job_notes($job_id,$heading,$heading);
	}
	
	include("view_job_details.php");
}

function add_reclean_jobs($var){
	$varx = explode("|",$var);
	$job_id = $varx[0];
	$job_type_id= $varx[1];
	$staff_id= $varx[2];
	$job_date= $varx[3];
	$job_time= $varx[4];	
	$createdOn = date('Y-m-d');	
	$reclean_assign_date = date('Y-m-d H:i:s');	
	if($job_id!=""){ 		
		//add_job_notes($job_id,"Payment of ".$amount." Taken By ".$takenby."  ",'');		
		//$quote_id = get_rs_value("jobs","quote_id",$job_id);
		$job_details = mysql_fetch_array(mysql_query("select * from jobs where id=".$job_id));
		$job_type = get_rs_value("job_type","name",$job_type_id);
		
		$ins_arg = "insert into job_reclean set 
		job_id=".$job_id.",
		quote_id='".$job_details['quote_id']."',
		site_id='".$job_details['site_id']."',
		job_type_id='".$job_type_id."',
		job_type='".$job_type."',
		staff_id='".$staff_id."',
		reclean_status='1',
		reclean_date='".$job_date."',
		createdOn='".$createdOn."',
		reclean_assign_date='".$reclean_assign_date."',
		reclean_time='".$job_time."'";
		//echo $ins_arg;  die;
		$bool = mysql_query($ins_arg);
		
		
	$bool = mysql_query("update job_details set reclean_job='2' where job_id=".$job_id." AND status != 2 AND job_type_id =".$job_type_id."");	
		// recalc the total 
		//recalc_job_total($job_id);
	$heading = "Add ".$job_type." job for Re-Clean";
	add_reclean_notes($job_id,$heading,$heading);
	add_job_notes($job_id,$heading,$heading);
	}
	
	include("view_reclean_job_details.php");
}

function delete_job($job_id){

	$quote_id = get_rs_value("jobs","quote_id",$job_id);
   //UPDATE `re_quoteing` SET `job_id` = '0' WHERE `re_quoteing`.`id` = 1;
	$bool = mysql_query("update quote_new set booking_id='0', quote_to_job_date= '0000-00-00' , status=0 where booking_id=".$job_id."");
	$bool = mysql_query("Delete from jobs where id=".$job_id."");
	$bool = mysql_query("Delete from job_details where job_id=".$job_id."");
	$bool = mysql_query("update re_quoteing set is_deleted= '1' where job_id=".$job_id."");
	
	$sql = mysql_query("INSERT INTO `job_delete_activity` ( `job_id`, `quote_id` , `login_id`, `createdOn`) VALUES ('".$job_id."',  '".$quote_id."' , '".$_SESSION['admin']."', '".date('Y-m-d:H:i:s')."')");
	
	include("dispatch_side.php");
}

function refresh_payment_report($var){
	//echo $var;
	$varx = explode("|",$var);
	$type = $varx[0];
	$value= $varx[1];
	
	$_SESSION['payment_report'][$type] = $value;
	include("view_payment_new.php");	
}

function refresh_payment_report_all($var){
	//echo $var;
	$varx = explode("|",$var);
	$type = $varx[0];
	$value= $varx[1];
	
	$_SESSION['payment_report_all'][$type] = $value;
	include("view_payment_all.php");	
}

function refresh_journal_report($var){
	//echo $var;
	$varx = explode("|",$var);
	$type = $varx[0];
	$value= $varx[1];
	
	$_SESSION['journal'][$type] = $value;
	include("view_journal_new.php");	
}

function refresh_tpayment_report($var){
	//echo $var;
	$varx = explode("|",$var);
	$type = $varx[0];
	$value= $varx[1];
	
	$_SESSION['tpayment_report'][$type] = $value;
	include("view_team_payments.php");	
}

    function refresh_daily_report($var){
    	//echo $var;
    	$varx = explode("|",$var);
    	$type = $varx[0];
    	$value= $varx[1];
    	
    	$_SESSION['daily_report'][$type] = $value;
    	include("daily_report.php");	
    }

    function make_paid_team_payment($jdetails_id){
    	
    	//echo  $jdetails_id; 
    	$vars = explode('__', $jdetails_id);
    	
    //	print_r($vars); 
    	
    	$id = $vars[0];
    	$type = $vars[1];
    	
    	 //lead_payment_status  lead_pay_date
    	
    	if($type == 1) {
    	    $uarg = "update quote_new set  booking_lead_payment = 2,  bbc_staff_paid_date='".date("Y-m-d")."' where id=".$id;
    	}else{
            $uarg = "update job_details set staff_paid=1,staff_paid_date='".date("Y-m-d")."' where id=".$id;
    	}
    	  //echo $uarg;
    	
    	$bool = mysql_query($uarg);
    	
    	echo date("d-m-Y");
    }

function email_staff_team_payment($staff_id){
	
}

function search_view_quote($var){
	//echo $var;
	unset($_SESSION['view_quote_aSearching']);
	
	$varx = explode("|",$var);
	$field = $varx[0];
	$keyword= $varx[1];
	$_SESSION['view_quote_field'] = $field;
	$_SESSION['view_quote_keyword'] = $keyword;
	
	include("view_quote.php"); 
}

function add_journal_entery($str){
    
       $vars = explode('__', $str);
       
        //print_r($vars); die; 
       
         $jdetails_id = $vars[0];
         $type = $vars[1];
	
	  if($type == 1) {
		$jdetails = mysql_fetch_array(mysql_query("select * from job_details where quote_id =".$jdetails_id."   limit 1"));
		$taken = 'BBC';
		$jdetails_id = $jdetails['id'];
		
	  }else {
	      $taken = 'BCIC';
	      $jdetails = mysql_fetch_array(mysql_query("select * from job_details where id=".$jdetails_id));
	      
	  }
		$staff['name'] = get_rs_value("staff","name",$jdetails['staff_id']);
		
		
		$jobs = mysql_fetch_array(mysql_query("select quote_id from jobs where id=".$jdetails['job_id']));	
		
		
		
		$quote = mysql_fetch_array(mysql_query("select id, booking_id ,lead_payment_status, lead_fee ,  name ,bbcapp_staff_id,lead_payment_status , bbc_fee,lead_pay_date,  amount from quote_new where id=".$jobs['quote_id']));
		$bcic_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='BCIC' and job_id=".$jdetails['job_id'].""));
		$staff_rec =mysql_fetch_array(mysql_query("select sum(amount) as tamount from job_payments where taken_by='".$staff['name']."' and job_id=".$jdetails['job_id'].""));
		
		$amt_total_row =mysql_fetch_array(mysql_query("select sum(amount_total) as amount_total , sum(amount_staff) as amount_staff , sum(amount_profit) as amount_profit  from job_details where staff_id='".$jdetails['staff_id']."' and job_id=".$jdetails['job_id']." and status!=2"));
	
	   	
	   //	$lead_fee = $quote['lead_fee'];
	   	$lead_fee = 0;
	   	if($type == 1) {
	   	    // BBC
	   	    $amount_profit = $quote['bbc_fee'] + $lead_fee;
            $amt_total_row['amount_staff'] = $amt_total_row['amount_total'] - $amount_profit;  
            $amt_total_row['amount_profit'] = $amount_profit;
            
            $paymenttype = 2;
            
		     
		}else {
		    // BCIC
		    $amt_total_row['amount_profit'] = $amt_total_row['amount_profit'];
		    $paymenttype = 1;
		    //$lead_fee = 0;
		}
	
	
	    //	$amt_staff_row =mysql_fetch_array(mysql_query("select sum(amount_staff) as amount_staff from job_details where staff_id='".$jdetails['staff_id']."' and job_id=".$jdetails['job_id']." and status!=2"));
    	//	$amt_profit_row =mysql_fetch_array(mysql_query("select sum(amount_profit) as amount_profit from job_details where staff_id='".$jdetails['staff_id']."' and job_id=".$jdetails['job_id']." and status!=2"));
		
		
	
		$ins = 	"insert into staff_journal_new set staff_id=".$jdetails['staff_id'].", job_id='".$jdetails['job_id']."', client_name='".($quote['name'])."', job_date='".$jdetails['job_date']."', journal_date='".date("Y-m-d")."', 
		total_amount='".$amt_total_row['amount_total']."', bcic_rec='".$bcic_rec['tamount']."', staff_rec='".$staff_rec['tamount']."',  quote_id='".$jobs['quote_id']."', 
		bcic_share='".$amt_total_row['amount_profit']."', staff_share='".$amt_total_row['amount_staff']."',lead_cost ='".$lead_fee."' ,  payment_type = ".$paymenttype." , job_details_id='".$jdetails_id."',
		comments='".mysql_real_escape_string($jdetails['job_type'])."'";
		//echo $ins."<br>";
		$ins1 = mysql_query($ins);	
		
		echo "Added";
		
		$bool = mysql_query("update job_details set acc_payment_check=1  where id=".$jdetails_id."");
}

function get_postcode($str){

	
	$data = mysql_query("select * from postcodes where postcode like '%".mysql_real_escape_string($str)."%' or suburb like '%".mysql_real_escape_string($str)."%'");
	$strx = "<ul class=\"post_list\">";
	while($r=mysql_fetch_assoc($data)){
		$strx.="<li><a href=\"javascript:select_suburb('".$r['suburb']."','".$r['site_id']."')\">".$r['postcode']." ".$r['suburb']." ".$r['state']."</a></li>";
	}	
	$strx.="</ul>";
	echo $strx;
}

function get_real_estate_name($var){
	
	$vars = explode('|', $var);
	$str = $vars[0];
	$site_id = $vars[1];
	
	$sql = "select * from real_estate_agent where 1 = 1 AND (name like '%".mysql_real_escape_string($str)."%' OR agent_company_name  like '%".mysql_real_escape_string($str)."%')";
	
	if($site_id != 0) {
	   $sql.= " AND site_id = ".$site_id."";
	}
	$data = mysql_query($sql);
	$strx = "<ul class=\"post_list\">";
	while($r=mysql_fetch_assoc($data)){
		$strx.="<li><a href=\"javascript:select_real_estate_name('".$r['name']."','".$r['id']."')\">".$r['name']."(".$r['agent_company_name'].")</a></li>";
	}	
	$strx.="</ul>";
	echo $strx;
	
}

function edit_get_real_estate_name($var){
	
	$vars = explode('|', $var);
	$str = $vars[0];
	$site_id = $vars[1];
	
	$sql = "select * from real_estate_agent where 1 = 1 AND (name like '%".mysql_real_escape_string($str)."%' OR agent_company_name  like '%".mysql_real_escape_string($str)."%')";
	
	if($site_id != 0) {
	   $sql.= " AND site_id = ".$site_id."";
	}
	
	//echo  $sql; die;
	$data = mysql_query($sql);
	
	$strx = "<ul class=\"post_list\">";
	while($r=mysql_fetch_assoc($data)){
		$strx.="<li><a href=\"javascript:select_real_estate_name_edit('".$r['name']."','".$r['id']."')\">".$r['name']."(".$r['agent_company_name'].")</a></li>";
	}	
	$strx.="</ul>";
	echo $strx;
}


function get_postcode_edit($str){
	$data = mysql_query("select * from postcodes where postcode like '%".mysql_real_escape_string($str)."%' or suburb like '%".mysql_real_escape_string($str)."%'");
	
	
	
	$strx = "<ul class=\"post_list\">";
	while($r=mysql_fetch_assoc($data)){
		$strx.="<li><a href=\"javascript:select_suburb_edit('".$r['suburb']."','".$r['site_id']."')\">".$r['postcode']." ".$r['suburb']." ".$r['state']."</a></li>";
	}	
	
	$strx.="</ul>";
	echo $strx;
}

function recalc_job_total($job_id){
	$job_details = mysql_query("select * from job_details where job_id=".$job_id." and status!=2");
	while($jdetails = mysql_fetch_assoc($job_details)){ 
		$tamount+=$jdetails['amount_total'];
	}
	//echo "update jobs set customer_amount='".$tamount."' where id=".$id;
	$bool1 = mysql_query("update jobs set customer_amount='".mres($tamount)."' where id=".mres($job_id));	
}

function quote_called($str){
    
	//today change
	//get admin name   
	$admin = $_SESSION['admin'];	
	$adminDetail = mysql_fetch_assoc(mysql_query( "select id,name from admin where id = {$admin}" ));
	$adminName = $adminDetail['name']; 
	
    $strdetails = explode('|',$str);
   // print_r($strdetails); die;
    $quote_id = $strdetails[0];
    $called_type = $strdetails[1];
    $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));
    $quotename = $quote['name'];
    if($called_type == 'called'){
         $called = 'called_date';
          $heading = $adminName . ' called to '.$quotename;
    }elseif($called_type == 'second_called'){
          $called = 'second_called_date';
           $heading = $adminName . ' 2nd called to '.$quotename; 
    }elseif($called_type == 'seven_called'){
          $called = 'seven_called_date';
          $heading = $adminName . ' 3rd called to '.$quotename;
    }
    
	       if($quote['login_id'] == 0) {
				$bool = mysql_query("update quote_new set login_id='".$admin."' where id=".$quote_id."");
			} 
	
    add_quote_notes($quote_id,$heading,$heading);
	$bool1 = mysql_query("update quote_new set $called ='".date("Y-m-d h:i:s")."' where id=".mres($quote_id));	
	//echo "<script>  </script>";
	echo date("d/m h:i:s");
}


function sms_quote($quote_id)
    {
       
    	if(($quote_id!="") || ($quote_id!="0")){ 
			$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));
			
			unset($_SESSION['quote_desc']);
			unset($_SESSION['quote_details_id']);
			unset($_SESSION['after_update']);
			
				$getdescdetails = mysql_query("SELECT description,id  FROM `quote_details` WHERE `quote_id` = ".mres($quote_id)."");
			   
				while($getData = mysql_fetch_array($getdescdetails)){
				  $_SESSION['quote_desc'][] = $getData['description'];
				  $_SESSION['quote_details_id'][] = $getData['id'];
				}
			
			$job_type_id = get_sql("quote_details","job_type_id"," where quote_id=".mysql_real_escape_string($quote_id)." and job_type_id=11");
			
			
			if($quote['phone']!=""){ 
				if($quote['ssecret']!=""){ 
					$secret = $quote['ssecret'];
				}else{ 
					$secret = str_makerand ("15","25",true,false,true); 
					$bool = mysql_query("update quote_new set ssecret='".mres($secret)."' where id=".mres($quote_id)."");
				}
				
				$protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
				
				
				$siteUrl = get_rs_value("siteprefs","site_url",1);		
				

				
			   // $url = $protocol.$_SERVER['SERVER_NAME'].'/members/quote/index.php?action=checkkey&secret='.$secret;
				$url = $siteUrl.'/members/quote/index.php?action=checkkey&secret='.$secret;
				
				$getURL = get_short_url($url);
				$link = '<a href='.$getURL.'>'.$getURL.'</a>';
			   
			   if($job_type_id == 11) {
					$quote_type = 'Removal';	
					$text_msg = 'We look forward in helping you with your move.Places are filling so book in fast.';				
			   }else{
					$quote_type = 'Cleaning';
					$text_msg = '';
			   }
			   
			  // print_r($quote);
			   
			   if($quote['quote_for'] == 2){
				   $smstext = 'Better Bond Cleaning';
				   $sitesphone = '1300 838 722';
			   }else{
				     $smstext = 'BCIC';
			        
			       if($job_type_id == 11) {
				     $sitesphone = '1300 766 422';
			       }else{
                        $sitesphone = get_rs_value("sites","site_phone_number",$quote['site_id']);	
			       }
			   }
			   
			   // $comment_note = "Hi ".$quote['name'].", Thanks for contacting us for Cleaning Quote,  Click here to view your quote ".$link."  Kind Regards - BCIC - 1300 599 644 ";
			   
			   $comment_msg = "Hi ".$quote['name'].", Thanks for contacting us for ".$quote_type." Quote, ".$text_msg." Click here to view your quote ".   $getURL."  Kind Regards - $smstext - $sitesphone ";
			   
			   
			   $comment_note = "Hi ".$quote['name'].", Thanks for contacting us for ".$quote_type." Quote,".$text_msg." Click here to view your quote ".$link."  Kind Regards - $smstext - $sitesphone ";
			   
			   
			  // echo $comment_msg;
				
				$sms_code = send_sms(str_replace(" ","",$quote['phone']),$comment_msg);
				$heading = "Send Quote SMS ".$quote['name']; 
				
				if($sms_code=="1"){ $flag = 1; $heading.=" (Delivered)";} else{ $flag = 2; $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
				
				
				//echo $comment_note; die;
				
				/* echo $quote_id .'=='.$heading.'=='.$comment_note;
				
				 die; */
				
				add_quote_notes($quote_id,$heading,$comment_note);
				
				if($flag == 1) {
				  $bool = mysql_query("update quote_new set sms_quote_date='".date("Y-m-d")."' where id=".mres($quote_id)."");
				}
				$_SESSION['after_update'] = $heading;
				echo $heading; 
				
				}else{
					echo error("Quote Mobile number is Empty");			
				}
			}else{
				echo error("Quote If Is Missing");	
			}	
    }

	function updatespringdesc(){
			foreach($_SESSION['quote_desc'] as $key=>$value) {
				 mysql_query("update quote_details set description='".$value."' WHERE `id` = '".$_SESSION['quote_details_id'][$key]."'"); 
			}
		 echo $_SESSION['after_update'];
		 exit;			 
	}			  

function custom_sms($data){
	
	$datar = explode('|', $data);
	$quote_id = $datar[0]; 
	$contact = $datar[1]; 
	$message = base64_decode($datar[2]); 
	
	if(($quote_id!="") || ($quote_id!="0")){
		
		$quote = mysql_fetch_array(mysql_query("select `name`, `phone` from `quote_new` where id=".mysql_real_escape_string($quote_id).""));
		
		if($quote['phone']!=""){
			
			$heading = "Send Custom SMS To ".$quote['name']; 
			$Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;

		    $comment_msg = strip_tags($message);
			
		    $comment_note = strip_tags($message);
		 
			$sms_code = send_sms(str_replace(" ","",$quote['phone']),$comment_msg);

			if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
			
			add_quote_notes($quote_id,$heading,$comment_note);
			
		    echo $heading;
		}else{
			echo error("User Mobile number is Empty");			
		}
	}else{
		echo error("SMS Is Missing");	
	}	
	
}

function app_custom_sms($data){
	
	//echo $data; die;
	$datar = explode('|', $data);
	
//	print_r($datar); 
	
	$app_id = $datar[0]; 
	$contact = $datar[1]; 
	$message = base64_decode($datar[2]); 
	$heading = $datar[3]; 
	
	if(($app_id!="") || ($app_id!="0")) {
		
		$appdata = mysql_fetch_array(mysql_query("select first_name , mobile  from `staff_applications` where id=".mysql_real_escape_string($app_id).""));
		
		
	//	print_r($appdata); die;
		
		if($appdata['mobile']!=""){
			
			//$heading = "Send Custom SMS To ".$appdata['first_name']; 
			$Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;

		    $comment_msg = strip_tags($message);
			
		     $comment_note = strip_tags($message);
		     $comment_note  = str_replace('$lb',PHP_EOL, $comment_note);
		 
			$sms_code = send_mysms(str_replace(" ","",$appdata['mobile']),$comment_msg);

			if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
			
			  //$heading = 'Send Custome SMS to '
			   add_application_notes($app_id,$heading,$comment_note ,'','','', 0);
			  
			  //add_quote_notes($app_id,$heading,$comment_note);
			
		    echo $heading;
		}else{
			echo error("User Mobile number is Empty");			
		}
	}else{
		echo error("SMS Is Missing");	
	}	
	
}

function check_availability($var){
	$varx = explode("|",$var);
	$suburb = $varx[0];
	$site_id= $varx[1];
	$booking_date= str_replace("'","",$varx[2]);
	$quote_for= $varx[3];
	$getjob_type_id= $varx[4];
	$get_quote_id= $varx[5];
	$quote_type= $varx[6];   
	
	 //print_r($var); die;
	
	include("check_avail.php");
}

function create_quote_object($type){
	include("create_quote_objects.php");
	
}

function create_bbc_job_type($type){
	//echo $type; die;
	include("create_bbc_quote_objects.php");
	
}

function create_br_job_type($type){
	
	include("create_br_quote_objects.php");
}

function add_quote_object($var){
	//echo $var; 
	
	$varx = explode("|",$var);
	$type = $varx[0];
	$SidQfor = explode('__',$varx[1]);
	
	$site_id = $SidQfor[0];
	$quotefor = $SidQfor[1];
	
	if(!isset($_SESSION['temp_quote_id'])){ 
		$ins_temp_quote	= "insert into temp_quote(session_id,site_id,date,quote_for) value('".session_id()."','".$site_id."','".date("Y-m-d")."','".$quotefor."');";
		//echo $ins_temp_quote."<br>";
		$ins = mysql_query($ins_temp_quote);
		 $id = mysql_insert_id();
		$_SESSION['temp_quote_id'] = $id;
	}
	
	
	if($type=="1")
	{ 
	
	  //print_r($varx); 
	 
		$bed= $varx[2]; $_SESSION['temp_quote']['cleaning']['bed'] = $bed;
		$study= $varx[3];
		$bath= $varx[4];
		$toilet= $varx[5];
		$living= $varx[6]; 	$_SESSION['temp_quote']['cleaning']['living'] = $living;
		$furnished= $varx[7];
		$property_type= $varx[8];
		$blinds = $varx[9];
		$blinds_numbers = $varx[10];

		//$booking_date = $varx[10];
		
		$job_type = get_rs_value("job_type","name",$type);
		$hours = 0;
		// find the quote for this 
		$cleaning_amt = 0;
			 $rates_sql = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=".$site_id; 
			$rates_data  = mysql_query($rates_sql);
		if(mysql_num_rows($rates_data)==0){
			 $rates_sql = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=0"; 
			$rates_data  = mysql_query($rates_sql);			
		}		
		
		$rates = mysql_fetch_array($rates_data);
		
		//die;
		
		$calc = "";
		$hours = $rates['hours'];
		// if property is furnished or not furnished decided the first charge 	
		if($furnished=="No"){ 
			$cleaning_amt = $rates['unfurnished']; $calc.= "unfurnished:".$rates['unfurnished']."+"; 
			$hours = $rates['hours'];
		}else{ 
			$cleaning_amt = $rates['furnished']; $calc.= "furnished:".$rates['furnished']."+";
			$hours = ($rates['hours']+$rates['f_extra_hours']);
		} 
		
		// if blinds are venetians then it get the extra price as mentioned in rates_clening.blinds fields
		if($blinds=="Venetians" || $blinds=="Shutters"){  $cleaning_amt+=$rates['blinds']; $calc.= "blinds:".$rates['blinds']."+"; $hours = ($hours+1); } 
		
		// number of living area are included in the price are here, if there is extra living spaces, each extra living space will stract $40
		
		if($living>$rates['living_inc']) { 
			$extra_livings = ($living-$rates['living_inc']);  
			$cleaning_amt+=(40*$extra_livings);  
			$hours = ($hours+$extra_livings); 
			$calc.= "etc living:".$extra_livings."+"; 
		}
		
		// if property type is two stories or multi story the price inceases according to dd_property_type.amount
		$property_amount  = get_sql("dd_property_type","amount","where name='".$property_type."'");
		
		/* echo $cleaning_amt;
		echo '<br/>'; */
		
		if($property_amount>0){ 
		  $cleaning_amt+=$property_amount; 
		  $calc.= "p_amt:".$property_amount."+";
		} 
		
		/* if($blinds_numbers != '' && $blinds_numbers != 0) {
		   $cleaning_amt = ($cleaning_amt + ($blinds_numbers *10));
		}   */
		//echo $cleaning_amt;
		
		$ins_arg  = "insert into temp_quote_details set temp_quote_id='".$_SESSION['temp_quote_id']."',amount=".$cleaning_amt.", 
		job_type_id=".$type.", job_type='".$job_type."', bed=".$bed." , study=".$study.", bath='".$bath."',
		toilet='".$toilet."', living='".$living."', furnished='".$furnished."', property_type='".$property_type."', blinds_type='".$blinds."', blinds_numbers='".$blinds_numbers."' , hours='".$hours."',rate='40' "; 
		//$ins_arg.=", description='".$calc."'";
		//echo $ins_arg."<br>"; 
		$ins = mysql_query($ins_arg);
		
		echo create_quote_str($_SESSION['temp_quote_id']); 
		
	}elseif($type=="11"){
		
		$bed= $varx[2]; 
		$lounge_hall= $varx[3];
		$kitchen= $varx[4];
		$dining_room= $varx[5];
		$office= $varx[6]; 	
		$garage= $varx[7];
		$laundry= $varx[8];
		$box_bags = $varx[9];
		$study = $varx[10];
		
		
	    $moving_from= $varx[11]; 
		$moving_to= $varx[12];
		$is_flour_from= $varx[13];
		$is_flour_to= $varx[14];
		$is_lift_from= $varx[15]; 	
		$is_lift_to= $varx[16]; 	
		$house_type_from= $varx[17];
		$house_type_to= $varx[18];
		$door_distance_from = $varx[19];
		$door_distance_to = $varx[20];
		$moving_from_lat_long = explode('__',$varx[21]);
		$moving_to_lat_long = explode('__',$varx[22]);
		//$booking_date = $varx[23];
		
		//$depot_to_job_time = $varx[24];
		$traveling = 1;
		$travel_time = $varx[23];
		$booking_date = $varx[24];
		$loading_time = '';
		
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$job_type = get_rs_value("job_type","name",$type);
		
		
		$update  = "update temp_quote set moving_from='".mres($moving_from)."', moving_to='".mres($moving_to)."' , is_flour_from='".$is_flour_from."',booking_date = '".$booking_date."' , is_flour_to = '".$is_flour_to."',is_lift_from = '".$is_lift_from."',is_lift_to = '".$is_lift_to."',house_type_from = '".$house_type_from."', house_type_to = '".$house_type_to."',door_distance_from = '".$door_distance_from."',door_distance_to = '".$door_distance_to."' ,lat_from = '".$moving_from_lat_long[0]."',long_from = '".$moving_from_lat_long[1]."' ,lat_to = '".$moving_to_lat_long[0]."',long_to = '".$moving_to_lat_long[1]."' where id=".$_SESSION['temp_quote_id'];		
		$boolu = mysql_query($update);
		
		
		$travelling_hr  = getdistanceTime($_SESSION['temp_quote_id']);
		
		$ins_arg  = "insert into temp_quote_details set temp_quote_id='".$_SESSION['temp_quote_id']."' , 
		job_type_id=".$type.", travelling_hr ='".$travelling_hr."' , job_type='".$job_type."', bed=".$bed.", study=".$study.", lounge_hall='".$lounge_hall."', traveling = '".$traveling."' ,travel_time = '".$travel_time."' ,
		kitchen='".$kitchen."', dining_room='".$dining_room."', office='".$office."', garage='".$garage."', laundry='".$laundry."', hours='3' ,  box_bags='".$box_bags."'";
		
		$boolI = mysql_query($ins_arg);
		
		
		echo create_quote_str($_SESSION['temp_quote_id']); 
		
		
	}else if ($type=="2"){ 
		// carpet 
		$bed= $varx[2]; 
		$living= $varx[3]; 
		$stairs = $varx[4];
		
		$quote_floor = $varx[5];
		$lift_property = $varx[6];
		$stains = $varx[7];
		//$booking_date = $varx[5];
		
		$carpet_amt = 0;
		if($stairs==0){ 
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=".$site_id; 
		}else{
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=".$site_id; 
		}
		
		$rates_data  = mysql_query($rates_sql_site);
		if(mysql_num_rows($rates_data)==0){
			if($stairs==0){ 
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=0"; 
			}else{
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=0"; 
			}
			//echo $rates_sql;
			$rates_data  = mysql_query($rates_sql);	
		}		
		
		$rates = mysql_fetch_array($rates_data);				
				
		$job_type = get_rs_value("job_type","name",$type);
		$ins_arg  = "insert into temp_quote_details set temp_quote_id='".$_SESSION['temp_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', bed=".$bed." , living='".$living."', carpet_stairs='".$stairs."',  
		quote_floor='".$quote_floor."', lift_property='".$lift_property."', stains='".$stains."',
		amount='".$rates['price']."' "; 

		$ins = mysql_query($ins_arg);
		//echo $ins_arg."<br>"; 
		echo create_quote_str($_SESSION['temp_quote_id']); 
		
	}else if ($type=="3"){
		
		// pest 
		$inside= $varx[2]; 
		$outside= $varx[3]; 
		$flee = $varx[4];	
        //$booking_date = $varx[5];		
		
		$pest_amt = 0;		
		$rates_sql_site = "select * from rates_pest where site_id=".$site_id; 		
		$rates_data  = mysql_query($rates_sql_site);
		
		if(mysql_num_rows($rates_data)==0){
			$rates_sql = "select * from rates_pest where site_id=0"; 	
			$rates_data  = mysql_query($rates_sql);	
		}			
		
		$rates = mysql_fetch_array($rates_data);
		
		//print_r($rates);				
		
		
		//echo  $inside . '==' . $outside; die;
		if($outside == '1' && $inside == '1') {
		    $pest_amt+= $rates['inside_outside'];
		}else {
			
			if($flee=="1"){ $pest_amt+= $rates['flea']; }
			if($outside=="1"){ $pest_amt+= $rates['outside']; }
			if($inside=="1"){ $pest_amt+= $rates['inside']; }
		}
		

				
		$job_type = get_rs_value("job_type","name",$type);
		$ins_arg  = "insert into temp_quote_details set temp_quote_id='".$_SESSION['temp_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', pest_inside=".$inside.", pest_outside='".$outside."', pest_flee='".$flee."' , amount='".$pest_amt."' "; 

		$ins = mysql_query($ins_arg);
		//echo $ins_arg."<br>"; 
		echo create_quote_str($_SESSION['temp_quote_id']); 
		
	}else{
		
		if($type == 8) {
			$jobText = get_rs_value("job_type","job_text",$type);
			$desc= $jobText; 
		}else {
		  $desc= $varx[2]; 
		}
		$amount= $varx[3]; 
        //$booking_date = $varx[4];		
						
		$job_type = get_rs_value("job_type","name",$type);
		$ins_arg  = "insert into temp_quote_details set temp_quote_id='".$_SESSION['temp_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', description='".$desc."' , amount='".$amount."' "; 

		$ins = mysql_query($ins_arg);
		//echo $ins_arg."<br>"; 
		echo create_quote_str($_SESSION['temp_quote_id']);
	}
	
	
}

function create_quote_desc_str($r){
	  
			$desc = "";
			if($r['job_type_id']=="1"){ 
			
				  if($r['bed']>0){ $desc.=' '.$r['bed'].' Beds,'; }
				  if($r['study']>0){ $desc.=' '.$r['study'].' Study,'; }
				  if($r['bath']>0){ $desc.=' '.$r['bath'].' Bath,'; }
				  if($r['toilet']>0){ $desc.=' '.$r['toilet'].' Toilet,'; }
				  if($r['living']>0){ $desc.=' '.$r['living'].' Living Areas,'; }
				  if($r['furnished']=="Yes"){ $desc.=' Furnished ,'; }
				  if($r['property_type'] != ""){ $desc.= ' '.$r['property_type'].',' ; }
				  
				   if($r['blinds_numbers'] != '' && $r['blinds_numbers'] != 0) {
					  $blinds_numbers = $r['blinds_numbers'];
				  }else{
					  $blinds_numbers = '';
				  } 
				  
				  if($r['blinds_type'] !=""){ $desc.= $blinds_numbers.' '.ucwords(str_replace("_"," ",$r['blinds_type'])).''; }
				  
			}else if ($r['job_type_id']=="2"){
			    
			     $checkproprty = array('1'=>'Yes','2'=>'No');
			     $islift = array('1'=>'Ground Floor','2'=>'1st Floor','3'=>'2nd Floor', '4'=>'Above');
			    
				 if($r['bed']>0){ $desc.=' '.$r['bed'].' Beds,'; }
				 if($r['living']>0){ $desc.=' '.$r['living'].' Living Areas,'; }
				 if($r['carpet_stairs']>0){ $desc.= $r['carpet_stairs'].' stairs , '; }
				 
				 if($r['quote_floor']>0){ $desc.= $islift[$r['quote_floor']].', '; }
				 if($r['lift_property']>0){ $desc.= ' Lift ' .$checkproprty[$r['lift_property']].' ,'; }
				 if($r['stains']>0){ $desc.=  ' stains '.$checkproprty[$r['stains']]; }
			
			}else if ($r['job_type_id']=="3"){
				 if($r['pest_inside']>0){ $desc.=' Inside'; }
				 if($r['pest_outside']>0){ $desc.=' Outside'; }
				 if($r['pest_flee']>0){ $desc.= ' & Flea and Tick '; }			
			}elseif($r['job_type_id']=="11"){ 
				  if($r['bed']>0){ $desc.=' '.$r['bed'].' Beds,'; }
				  if($r['study']>0){ $desc.=' '.$r['study'].' Study,'; }
				  if($r['lounge_hall']>0){ $desc.=' '.$r['lounge_hall'].' Living Areas,'; }
				  if($r['kitchen']>0){ $desc.=' '.$r['kitchen'].' kitchen,'; }
				  if($r['dining_room']>0){ $desc.=' '.$r['dining_room'].' Dining room,'; }
				  if($r['office'] >0){ $desc.=' '.$r['office'].' Office ,'; }
				  if($r['garage'] >0){ $desc.= ' '.$r['garage'].' Garage,' ; }
				  if($r['laundry'] >0){ $desc.= ' '.$r['laundry'].' Laundry,' ; }
			}	
			//echo $desc;
			
			return $desc;
}
function create_quote_str($temp_quote_id){
	
	$str ='<span class="main_head">Quote Section</span><div class="br_table">';
	
	$qdetails = mysql_query("select * from temp_quote_details where temp_quote_id=".$_SESSION['temp_quote_id']."");
	$total_amount = 0;
	while($r = mysql_fetch_assoc($qdetails)){ 
	
	
	// print_r($r); die;
	
		
		if ($r['description']==""){ 
		    //print_r($r); die;
			$desc = create_quote_desc_str($r);
			$bool = mysql_query("update temp_quote_details set description ='".$desc."' where id=".$r['id']);
		}else{
			$desc = $r['description'];
		}
		
		        
			if($r['job_type_id']==1){ 
			
			      if($r['quote_auto_custom'] == 2){
				      $style = 'background: #ecf1e9';
			       }else{
					$style = '';
				   } 
			   
				$str.='<table class="table table-bordered" style="'.$style.'"><thead><tr><th>'.$r['job_type'].'&nbsp;&nbsp;'.create_dd("quote_auto_custom","system_dd","id","name","type=49","onChange=\"javascript:edit_field_quote(this,'temp_quote_details.quote_auto_custom','".$r['id']."');\"",$r).'</th>';
				//$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'"><a href="javascript:send_data('.$r['id'].'|amount_'.$r['id'].',49,\'amount_'.$r['id'].'\');">$'.$r['amount'].'</a></th>';
				$str.='<th style="width:10%; text-align:center;" id="Hours_'.$r['id'].'">Hours: ';
				$str.='<input type="text" id="hours_'.$r['id'].'" name="hours_'.$r['id'].'" value="'.$r['hours'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.hours\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="discount_'.$r['id'].'">Discount: ';
				$str.='<input type="text" id="discount_'.$r['id'].'" name="discount_'.$r['id'].'" value="'.$r['discount'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.discount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="rate_'.$r['id'].'">Rate: ';
				$str.='<input type="text" id="rate_'.$r['id'].'" name="rate_'.$r['id'].'" value="'.$r['rate'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.rate\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'">';
				$str.='<input type="text" id="amt_'.$r['id'].'" name="amt_'.$r['id'].'" value="'.$r['amount'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.amount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='</tr></thead><tbody>';
				//$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
				$str.='<tr><td colspan="4" align="center">';
				$str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.description\',\''.$r['id'].'\');">'.$desc.'</textarea>';
				$str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',50,\'quote_div\');"><img src="images/cross.png"></a></span>';
				$str.='</td></tr></tbody></table>';
				
			}elseif($r['job_type_id']==11){
				
				
				$quotesql = mysql_query("select * from temp_quote where id=".$r['temp_quote_id'].""); 		
				$quote  = mysql_fetch_array($quotesql); 
			    
			
			       if($r['quote_auto_custom'] == 2){
				      $style = 'background: #ecf1e9';
			       }else{
					$style = '';
				   }  
			   
				
				$str.='<table class="table table-bordered" style="'.$style.'"><thead>';
				
				  
				if($quote['booking_date'] != '0000-00-00' && $quote['site_id'] !='0') {
					
					$str1 = $quote['suburb'].'|'.$quote['site_id'].'|'.$quote['booking_date'].'|'.$quote['quote_for'].'|11|'.$r['temp_quote_id'].'|1';
				      $onclick_loading_time  = "onClick=\"javascript:check_reclean_avail('".$str1."','45','quote_div3');\"";
					  $check_avail = '<input type="button" style="cursor: pointer;background-color: #1562a9;color:  #fff;padding: 2px;width: 90px;margin-top: 9px;" '.$onclick_loading_time.' value="Check Avail">'; 
					
				}else{
					  $check_avail = '';
				}
				
				    $truckamount = '';
				    if($r['truck_type_id'] != '' && $r['truck_type_id'] != 0) { 
				      $truckamount = '$'. get_rs_value("truck_list","amount",$r['truck_type_id']).' /hr';  
				    }
				
				
				$str.='<tr><th>'.$r['job_type'].' <br>'.create_dd("quote_auto_custom","system_dd","id","name","type=49","",$r).'<br>'.$check_avail.' <br/> Travel Time : '.$r['travelling_hr'].' Hr</th>';	
				
				$str.='<th style="width:10%; text-align:center;" id="Track_'.$r['id'].'">Truck List:';
				$str.=create_dd("truck_type_id","truck_list","id","truck_type_name","","onChange=\"javascript:edit_field_quote(this,'temp_quote_details.truck_type_id','".$r['id']."');\"",$r).'<br>';
				$str.= $truckamount;
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="Hours_'.$r['id'].'">Total Hr: ';
				
				$str.='<input type="text" id="hours_'.$r['id'].'" name="hours_'.$r['id'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.hours\',\''.$r['id'].'\');" value="'.$r['hours'].'"  calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'"> Amount';
				
				$str.='<input type="text" id="amt_'.$r['id'].'" name="amt_'.$r['id'].'" value="'.$r['amount'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.amount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				
				$str.='</tr></thead><tbody>';
				
				$str.='<tr><td colspan="5" align="center">';
				$str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.description\',\''.$r['id'].'\');">'.$desc.'</textarea>';
				$str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',50,\'quote_div\');"><img src="images/cross.png"></a></span>';
				$str.='</td></tr></tbody></table>';
				

				/* $quotesql = mysql_query("select * from temp_quote where id=".$r['temp_quote_id'].""); 		
				$quote  = mysql_fetch_array($quotesql); 
			    
			
			       if($r['quote_auto_custom'] == 2){
				      $style = 'background: #ecf1e9';
			       }else{
					$style = '';
				   }  
			   
				
				$str.='<table class="table table-bordered" style="'.$style.'"><thead>';
				
				$str.='<tr><th>'.$r['job_type'].'  Cumib M3 <br>'.create_dd("quote_auto_custom","system_dd","id","name","type=49","onChange=\"javascript:edit_field_quote(this,'temp_quote_details.quote_auto_custom','".$r['id']."');\"",$r).'   '.create_dd("truck_id","truck","id","cubic_meter","","onChange=\"javascript:edit_field_quote(this,'temp_quote_details.truck_id','".$r['id']."');\"",$r).'</th>';	
				$str.='<th style="width:10%; text-align:center;">Day Time :';
				$str.= ucfirst(getBRSystemDDname($r['travel_time'] , 5));
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;">Total Hr: ';
				$str.=$r['origanl_total_time'];
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center; background: #eacfcf;">Waiting M3: <br>';
				$str.=$r['origanl_cubic'];
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:right;" >Amount<br>';
				$str.=$r['origanl_total_amount'];
				
		          $str1 = $quote['suburb'].'|'.$quote['site_id'].'|'.$quote['booking_date'].'|'.$quote['quote_for'].'|11|'.$r['temp_quote_id'].'|1';
		          
				
				if($quote['booking_date'] != '0000-00-00' && $quote['site_id'] !='0') {
					
				      $onclick_loading_time  = "onClick=\"javascript:check_reclean_avail('".$str1."','45','quote_div3');\"";
					  $check_avail = '<input type="button" style="cursor: pointer;background-color: #1562a9;color:  #fff;padding: 2px;width: 90px;margin-top: 9px;" '.$onclick_loading_time.' value="Check Avail">'; 
					
				}else{
					  $check_avail = '';
				}
			   
				
				$str.='<tr><th>
				D.T.A :<input type="text" id="depot_to_job_time_'.$r['id'].'" name="depot_to_job_time_'.$r['id'].'" value="'.$r['depot_to_job_time'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.depot_to_job_time\',\''.$r['id'].'\');" calss="input_search" style="width:34px;"><br>
				
				Trvl : <input type="text" id="travelling_hr_'.$r['id'].'" name="travelling_hr_'.$r['id'].'" value="'.$r['travelling_hr'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.travelling_hr\',\''.$r['id'].'\');" calss="input_search" style="width:34px;"><br>
				
				Ldig : <input type="text" id="loading_time_'.$r['id'].'" name="loading_time_'.$r['id'].'" value="'.$r['loading_time'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.loading_time\',\''.$r['id'].'\');" calss="input_search" style="width:34px;"><br/>
				'.$check_avail.'
				</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="traveling_'.$r['id'].'">Travel Round: ';
				$str.='<input type="text" id="traveling_'.$r['id'].'" name="traveling_'.$r['id'].'" value="'.$r['traveling'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.traveling\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="Hours_'.$r['id'].'">Total Hr: ';
				$str.='<input type="text" id="hours_'.$r['id'].'" name="hours_'.$r['id'].'" value="'.$r['hours'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.hours\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="cubic_meter_'.$r['id'].'">M3: ';
				$str.='<input type="text" id="cubic_meter_'.$r['id'].'" name="cubic_meter_'.$r['id'].'" value="'.$r['cubic_meter'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.cubic_meter\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'">';
				$str.='<input type="text" id="amt_'.$r['id'].'" name="amt_'.$r['id'].'" value="'.$r['amount'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.amount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				$str.='</tr>';
				
				$str.='</thead><tbody>';
				$str.='<tr><td colspan="5" align="center">';
				$str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.description\',\''.$r['id'].'\');">'.$desc.'</textarea>';
				$str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',50,\'quote_div\');"><img src="images/cross.png"></a></span>';
				$str.='</td></tr></tbody></table>'; */
					
				
			}else{
				
				if($r['job_type_id'] == 2 || $r['job_type_id'] == 3){
				    $system_type = '&nbsp;&nbsp;'.create_dd("quote_auto_custom","system_dd","id","name","type=49","onChange=\"javascript:edit_field_quote(this,'temp_quote_details.quote_auto_custom','".$r['id']."');\"",$r);
					if($r['quote_auto_custom'] == 2 && $r['job_type_id'] == 2) {
					   $style = 'background: #ecf1e9';
					}elseif($r['quote_auto_custom'] == 2 && $r['job_type_id'] == 3){
						$style = 'background: #ecf1e9';
					}else{
						$style = '';
					}
				}else{
					$system_type = ''; 
						$style = '';
				}
				
				$str.='<table class="table table-bordered" style="'.$style.'"><thead><tr><th colspan="2">'.$r['job_type'].$system_type.'</th>';
				//$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'"><a href="javascript:send_data('.$r['id'].'|amount_'.$r['id'].',49,\'amount_'.$r['id'].'\');">$'.$r['amount'].'</a></th>';
				$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'">';
				$str.='<input type="text" id="amt_'.$r['id'].'" name="amt_'.$r['id'].'" value="'.$r['amount'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.amount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='</tr></thead><tbody>';
				//$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
				$str.='<tr><td colspan="3" align="center">';
				$str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_field_quote(this,\'temp_quote_details.description\',\''.$r['id'].'\');">'.$desc.'</textarea>';
				$str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',50,\'quote_div\');"><img src="images/cross.png"></a></span>';
				$str.='</td></tr></tbody></table>';
			}
			
			$total_amount = ($total_amount+$r['amount']); 
	}
	
	$str .= '</div>';
	
	//$str.='<div class="btn_get_quot" style="margin-left:196px; display:none;" id="create_quote_quest"><a href="javascript:void(0)" onClick="getQuoteQuestions(\''.$quote_id.'\',\'530\',\'quote_div3\');">Quote Questions</a></div>';
	
	$str.='<table class="table table-bordered"><tfoot><tr><td><b>Total</b></td><td id="total_amount_quote">$'.$total_amount.'</td></tr></tfoot></table>';
	$str.=' <a href="javascript:save_quote();" class="btn_quote">Save Quote</a>';
	
	$bool = mysql_query("update temp_quote set amount='".$total_amount."' where id=".$_SESSION['temp_quote_id']);				
	return $str;
	
}


function claculate_br_cubic($quote_id){
	

	$quote = mysql_fetch_array(mysql_query("SELECT *  FROM `temp_quote` WHERE `id` = '".$quote_id."'"));
	$quotedetails = mysql_fetch_array(mysql_query("SELECT *  FROM `temp_quote_details` WHERE `temp_quote_id` = '".$quote_id."' AND job_type_id = 11"));
	
	    if(!empty($quotedetails)) {
		 
			if($quotedetails['bed'] > 0) { $bed = $quotedetails['bed']; }else { $bed = 0; } 
			if($quotedetails['study'] > 0) { $study = $quotedetails['study']; }else { $study = 0; } 
			if($quotedetails['lounge_hall'] > 0) { $lounge_hall = $quotedetails['lounge_hall']; }else { $lounge_hall = 0; } 
			if($quotedetails['kitchen_dining'] > 0) { $kitchen_dining = $quotedetails['kitchen_dining']; }else { $kitchen_dining = 0; } 
			if($quotedetails['kitchen'] > 0) { $kitchen = $quotedetails['kitchen']; }else { $kitchen = 0; } 
			if($quotedetails['dining_room'] > 0) { $dining_room = $quotedetails['dining_room']; }else { $dining_room = 0; } 
			
			// Not added
			$office = $quotedetails['office'];	 
			$garage = $quotedetails['garage'];	 
			$laundry = $quotedetails['laundry'];	 
			$box_bags = $quotedetails['box_bags'];	 
			
			
			$total_bed_type_cubciMeter = 0;
			$total_study_type_cubciMeter = 0;
			$total_living_type_cubciMeter = 0;
			$total_dining_room_cubciMeter = 0;
			$total_kitchen_cubciMeter = 0; 
		
		
		  //echo  $kitchen; die;
		
		   // For bed
		       if($bed != 0) {
				   
				    $total_bed_type_cubciMeter = 0;
                    for($bed_item = 1; $bed_item <= $bed; $bed_item++) {					
						$bedroomsCubicMeter = CubicmeterInsertion($quote_id,  1 , 1 , $bed_item);
						$gettotalbed_cubic  = getitemcubicmeter($quote_id, 1 ,1 , $bed_item);
					   $total_bed_type_cubciMeter = $total_bed_type_cubciMeter + $gettotalbed_cubic; 
					}
		        }
				
				
			// For study	
				if($study != 0){
					
					$total_study_type_cubciMeter = 0;
					for($study_item = 1; $study_item <= $study; $study_item++) {
						
					   $bedroomsCubicMeter = CubicmeterInsertion($quote_id,  8 ,1 , $study_item);
					   $total_study_cubciMeter  = getitemcubicmeter($quote_id, 8 ,1 , $study_item);
					  $total_study_type_cubciMeter = $total_study_type_cubciMeter + $total_study_cubciMeter;
					}
				}
					//echo  '22<br>';
					
				if($lounge_hall != 0){
					$total_living_type_cubciMeter = 0;
					for($lounge_hall_item = 1; $lounge_hall_item <= $lounge_hall; $lounge_hall_item++) {	
					   $bedroomsCubicMeter = CubicmeterInsertion($quote_id, 2 ,1 , $lounge_hall_item);
					   $living_type_cubciMeter  = getitemcubicmeter($quote_id, 2 ,1 ,$lounge_hall_item);
					  $total_living_type_cubciMeter = $total_living_type_cubciMeter + $living_type_cubciMeter;
					}
					
				}
				
					//echo  '33<br>';
				
				if($dining_room != 0){
					
					$total_dining_room_cubciMeter = 0;
					for($dining_room_item = 1; $dining_room_item <= $dining_room; $dining_room_item++) {		
					  $bedroomsCubicMeter = CubicmeterInsertion($quote_id, 3 ,1 , $dining_room_item);
					  $dining_room_cubciMeter  = getitemcubicmeter($quote_id, 3 ,1 , $dining_room_item);
					  $total_dining_room_cubciMeter = $total_dining_room_cubciMeter + $dining_room_cubciMeter;
					}
					
				}
				
					//echo  '44<br>';
					
				if($kitchen != 0){
					
					$total_kitchen_cubciMeter = 0;
					for($kitchen_item = 1; $kitchen_item <= $kitchen; $kitchen_item++) {		
					  $bedroomsCubicMeter = CubicmeterInsertion($quote_id,3 ,2 , $kitchen_item);
					  $kitchen_cubciMeter  = getitemcubicmeter($quote_id, 3 ,2, $kitchen_item);
					  $total_kitchen_cubciMeter = $total_kitchen_cubciMeter + $kitchen_cubciMeter;
					}
					
				}
				
		    
			 	 
			// End of Calculation
			$totalcubic_meter = ($total_bed_type_cubciMeter + $total_study_type_cubciMeter + $total_living_type_cubciMeter + $total_dining_room_cubciMeter + $total_kitchen_cubciMeter);  	
			
			
			
				
			 $uarg = mysql_query("update  temp_quote_details set amount ='0',  cubic_meter='".$totalcubic_meter."' WHERE `temp_quote_id` = '".$quote_id."' AND job_type_id = 11 ");	
			
		   	$uarg1 = mysql_query("update  temp_quote set amount ='0'  cubic_meter='".$totalcubic_meter."' WHERE `id` = '".$quote_id."'"); 
			
	    }
    }


/* function claculate_br_cubic($quote_id){
	

	$quote = mysql_fetch_array(mysql_query("SELECT *  FROM `temp_quote` WHERE `id` = '".$quote_id."'"));
	$quotedetails = mysql_fetch_array(mysql_query("SELECT *  FROM `temp_quote_details` WHERE `temp_quote_id` = '".$quote_id."' AND job_type_id = 11"));
	
	    if(!empty($quotedetails)) {
		 
			if($quotedetails['bed'] > 0) { $bed = $quotedetails['bed']; }else { $bed = 0; } 
			if($quotedetails['study'] > 0) { $study = $quotedetails['study']; }else { $study = 0; } 
			if($quotedetails['lounge_hall'] > 0) { $lounge_hall = $quotedetails['lounge_hall']; }else { $lounge_hall = 0; } 
			if($quotedetails['kitchen_dining'] > 0) { $kitchen_dining = $quotedetails['kitchen_dining']; }else { $kitchen_dining = 0; } 
			if($quotedetails['kitchen'] > 0) { $kitchen = $quotedetails['kitchen']; }else { $kitchen = 0; } 
			if($quotedetails['dining_room'] > 0) { $dining_room = $quotedetails['dining_room']; }else { $dining_room = 0; } 
			
			// Not added
			$office = $quotedetails['office'];	 
			$garage = $quotedetails['garage'];	 
			$laundry = $quotedetails['laundry'];	 
			$box_bags = $quotedetails['box_bags'];	 
			
			
			$total_bed_type_cubciMeter = 0;
			$total_study_type_cubciMeter = 0;
			$total_living_type_cubciMeter = 0;
			$total_dining_room_cubciMeter = 0;
			$total_kitchen_cubciMeter = 0; 
		
		
		  //echo  $kitchen; die;
		
		   // For bed
		       if($bed != 0) {
				   
				    $total_bed_type_cubciMeter = 0;
                    for($bed_item = 1; $bed_item <= $bed; $bed_item++) {					
						$bedroomsCubicMeter = CubicmeterInsertion($quote_id,  1 , 1 , $bed_item);
						$gettotalbed_cubic  = getitemcubicmeter($quote_id, 1 ,1 , $bed_item);
					   $total_bed_type_cubciMeter = $total_bed_type_cubciMeter + $gettotalbed_cubic; 
					}
		        }
				
				
			// For study	
				if($study != 0){
					
					$total_study_type_cubciMeter = 0;
					for($study_item = 1; $study_item <= $study; $study_item++) {
						
					   $bedroomsCubicMeter = CubicmeterInsertion($quote_id,  8 ,1 , $study_item);
					   $total_study_cubciMeter  = getitemcubicmeter($quote_id, 8 ,1 , $study_item);
					  $total_study_type_cubciMeter = $total_study_type_cubciMeter + $total_study_cubciMeter;
					}
				}
					//echo  '22<br>';
					
				if($lounge_hall != 0){
					$total_living_type_cubciMeter = 0;
					for($lounge_hall_item = 1; $lounge_hall_item <= $lounge_hall; $lounge_hall_item++) {	
					   $bedroomsCubicMeter = CubicmeterInsertion($quote_id, 2 ,1 , $lounge_hall_item);
					   $living_type_cubciMeter  = getitemcubicmeter($quote_id, 2 ,1 ,$lounge_hall_item);
					  $total_living_type_cubciMeter = $total_living_type_cubciMeter + $living_type_cubciMeter;
					}
					
				}
				
					//echo  '33<br>';
				
				if($dining_room != 0){
					
					$total_dining_room_cubciMeter = 0;
					for($dining_room_item = 1; $dining_room_item <= $dining_room; $dining_room_item++) {		
					  $bedroomsCubicMeter = CubicmeterInsertion($quote_id, 3 ,1 , $dining_room_item);
					  $dining_room_cubciMeter  = getitemcubicmeter($quote_id, 3 ,1 , $dining_room_item);
					  $total_dining_room_cubciMeter = $total_dining_room_cubciMeter + $dining_room_cubciMeter;
					}
					
				}
				
					//echo  '44<br>';
					
				if($kitchen != 0){
					
					$total_kitchen_cubciMeter = 0;
					for($kitchen_item = 1; $kitchen_item <= $kitchen; $kitchen_item++) {		
					  $bedroomsCubicMeter = CubicmeterInsertion($quote_id,3 ,2 , $kitchen_item);
					  $kitchen_cubciMeter  = getitemcubicmeter($quote_id, 3 ,2, $kitchen_item);
					  $total_kitchen_cubciMeter = $total_kitchen_cubciMeter + $kitchen_cubciMeter;
					}
					
				}
				
		    
			 	 
			// End of Calculation
			$totalcubic_meter = ($total_bed_type_cubciMeter + $total_study_type_cubciMeter + $total_living_type_cubciMeter + $total_dining_room_cubciMeter + $total_kitchen_cubciMeter);  	
			
			
			$loadingtime = ($totalcubic_meter/4);
			$travelling_hr  = (getdistanceTime($quote_id));

			
			// ground Flour include and if Extra floor 1 hr Add
			if($quote['is_flour_from'] == 1) {
				$flourhr_from = 0;
			}else{
				$flourhr_from = ($quote['is_flour_from']-1)*1;
			}
			
			// ground Flour include and if Extra floor 1 hr Add
			if($quote['is_flour_to'] == 1) {
				$flourhr_to = 0;
			}else{
				$flourhr_to = ($quote['is_flour_to']-1)*1;
			}
			
			
			// Door Distance 20 mter Includes and if Extra 1 hr Add
			if($quote['door_distance_from'] == 1) {
				$door_distance_from = 0;
			}else{
				$door_distance_from = 1;
			}
			
			// Door Distance 20 mter Includes and if Extra 1 hr Add
			if($quote['door_distance_to'] == 1) {
				$door_distance_to = 0;
			}else{
				$door_distance_to = 1;
			}
			
			$depot_to_job_time = $quotedetails['depot_to_job_time'];
			$traveling = $quotedetails['traveling'];
			
			$loading_hr = ($door_distance_from + $flourhr_from + $door_distance_to + $flourhr_to + $loadingtime);
			
            $total_traval_workTIme = ($depot_to_job_time + ($travelling_hr*$traveling) +  $loading_hr);
			
			$bcic_amount =  check_cubic_meter_amount($totalcubic_meter); // Amount of BCIC 
			$amount = $total_traval_workTIme*$bcic_amount; 
			
				
			 $uarg = mysql_query("update  temp_quote_details set amount ='".$amount."', travelling_hr ='".$travelling_hr."' , hours ='".$total_traval_workTIme."' , cubic_meter='".$totalcubic_meter."', origanl_total_time ='".$total_traval_workTIme."' , origanl_cubic='".$totalcubic_meter."', origanl_total_amount ='".$amount."' , loading_time = '".$loading_hr."' , working_hr ='".$loading_hr."'  WHERE `temp_quote_id` = '".$quote_id."' AND job_type_id = 11 ");	
			
		   	$uarg1 = mysql_query("update  temp_quote set amount ='".$amount."'  cubic_meter='".$totalcubic_meter."' WHERE `id` = '".$quote_id."'"); 
			
	    }
    }
 */

    function getdistanceTime($lastid){
		
		     // For Calculate Distance &  time
			$getQuotedetails = mysql_fetch_array(mysql_query("SELECT name, moving_from ,moving_to ,lat_from ,long_from , lat_to, long_to FROM `temp_quote` WHERE `id` = ".$lastid.""));			
				
			$timedistance = GetDrivingDistance($getQuotedetails['lat_from'], $getQuotedetails['lat_to'], $getQuotedetails['long_from'], $getQuotedetails['long_to']);	
			//$travling_hr =  str_replace(' ', '', str_replace('godz','',$timedistance['time']));
			$travelling_hr =  $timedistance['time'];
			return $travelling_hr;
	 }
	
function save_quote($var){	

 
   $varx = explode("|",$var);
   
   
   //print_r($varx);  die;
   
   
   
	$suburb = $varx[0];
	$site_id = $varx[1];
	$booking_date = $varx[2];
	$name = $varx[3];
	$phone = $varx[4];
	$email = $varx[5];
	$job_ref= $varx[6];
	$address = str_replace("#39;","&",$varx[7]);
	$comments = str_replace("#39;","&",$varx[8]);
	$lat_long = explode('__',$varx[9]);
	
	$quote_for = $varx[10];
	$staff_id = $varx[11];
	$realstatename = $varx[12];
	$have_removal = $varx[13];
	$white_goods = $varx[14];
	$parking = $varx[15];
	$question_ids = $varx[16];
	
	//client_type agency_name  agent_name agent_number agent_email agent_landline_num agent_address
	
	
	$client_type = $varx[17];
	if($client_type == 2) {
		$agency_name = $varx[18];
		$agent_name = $varx[19];
		$agent_number = $varx[20];
		$agent_email = $varx[21];
		$agent_landline_num = $varx[22];
		$agent_address = $varx[23];
	}else {
		$agency_name = '';
		$agent_name = '';
		$agent_number = '';
		$agent_email = '';
		$agent_landline_num = '';
		$agent_address = '';
	}
	
		/* 	str+= $('#pets_property').val()+"|";
		str+= $('#lived_property').val()+"|";
		str+= $('#bond_amiming').val()+"|";
		str+= $('#best_time_contact').val()+"|"; */
	
	$pets_property = $varx[24];
	$lived_property = $varx[25];
	$bond_amiming = $varx[26];
	$best_time_contact = $varx[27];
	
/*	$lift_property = $varx[28];
	$quote_floor = $varx[29];
	$stains = $varx[30];*/
	

	
	
	//print_r($varx); die;
	
	$latitude = $lat_long[0];
	$longitude = $lat_long[1];
	
	$latitude = ($latitude != '') ? $latitude : 0;
	$longitude = ($longitude != '') ? $longitude : 0;
	
	
	$uarg = "update temp_quote set suburb='".mres($suburb)."',  site_id='".$site_id."',  booking_date='".$booking_date."', name='".mres($name)."', phone='".$phone."', email='".$email."', job_ref='".$job_ref."',referral_staff_name = '".$staff_id."',quote_for='".$quote_for."', ";
	
	$uarg.=" address='".mres($address)."',login_id = '".$_SESSION['admin']."', comments='".mres($comments)."' where id=".$_SESSION['temp_quote_id']."";	
	//echo $uarg."<br>";	
	$bool = mysql_query($uarg);
	if($bool){ 
		// move all the info to Quote  discount
		$getPostCode = mysql_fetch_array(mysql_query("SELECT postcode  FROM `postcodes` WHERE `suburb` = '".$suburb."' AND `site_id` = ".$site_id.""));
		
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		
		if(!empty($getPostCode)) {
		   $postcode = $getPostCode['postcode'];
		}else {
			$postcode = 0;
		}
		$temp_quote = mysql_fetch_array(mysql_query("select * from temp_quote where id = ".$_SESSION['temp_quote_id']));
		
		//admin_id
		//$admin_id = $_SESSION['admin'];
		
		$agentdetails = '';
		if(!isset($_SESSION['quote_id']))
		{ 		
	
	
		    $ins_arg  = "insert into quote_new set suburb='".mres($suburb)."', stages = '2' , real_estate_id='".$realstatename."',site_id=".$site_id.", white_goods='".$white_goods."', parking='".$parking."', have_removal=".$have_removal.", step = '3', booking_date='".$booking_date."', name='".mres($name)."', 
			phone='".$phone."', email='".$email."', job_ref='".$job_ref."', question_id='".$question_ids."', client_type='".mres($client_type)."',";
				
		    $ins_arg.=" agency_name='".mres($agency_name)."' ,agent_name='".mres($agent_name)."', agent_number='".mres($agent_number)."' ,agent_email='".mres($agent_email)."', agent_landline_num='".mres($agent_landline_num)."' , agent_address='".mres($agent_address)."' , ";
			
			$ins_arg.=" pets_property='".mres($pets_property)."' ,lived_property='".mres($lived_property)."', bond_amiming='".mres($bond_amiming)."' ,best_time_contact='".mres($best_time_contact)."' , ";
			//$ins_arg.=" lift_property='".mres($lift_property)."' ,quote_floor='".mres($quote_floor)."', stains='".mres($stains)."',";
		   	$ins_arg.= " moving_from='".mysql_real_escape_string($temp_quote['moving_from'])."', moving_to='".mysql_real_escape_string($temp_quote['moving_to'])."',is_flour_from='".$temp_quote['is_flour_from']."', is_flour_to='".$temp_quote['is_flour_to']."',is_lift_from='".$temp_quote['is_lift_from']."', house_type_from='".$temp_quote['house_type_from']."',door_distance_from='".$temp_quote['door_distance_from']."', is_lift_to='".$temp_quote['is_lift_to']."',house_type_to='".$temp_quote['house_type_to']."', door_distance_to='".$temp_quote['door_distance_to']."',lat_from='".$temp_quote['lat_from']."', long_from='".$temp_quote['long_from']."',lat_to='".$temp_quote['lat_to']."', long_to='".$temp_quote['long_to']."', cubic_meter='".$temp_quote['cubic_meter']."', ";
			
			$ins_arg.=" address='".mres($address)."', comments='".mres($comments)."', date='".date("Y-m-d")."', amount='".$temp_quote['amount']."',login_id = '".$_SESSION['admin']."',ipaddress = '".$ipaddress."',postcode = '".$postcode."',latitude = '".$latitude."', longitude = '".$longitude."',quote_for = '".$quote_for."', depot_to_job_time = '".$temp_quote['depot_to_job_time']."' ,traveling = '".$temp_quote['traveling']."' ,travel_time = '".$temp_quote['travel_time']."' ,loading_time = '".$temp_quote['loading_time']."' , referral_staff_name = '".$staff_id."'";
			
			if($client_type == 2) {
			    $agentdetails .= '<strong> Agency Name :</strong> '.$agency_name.' - <strong>Agent name => </strong>'.$agent_name.'</br>'.'<br/>===================<br/>';
				$agentdetails .= '<strong> Agent Number :</strong> '.$agent_number.' - <strong>Agent email => </strong>'.$agent_email.'</br>'.'<br/>===================<br/>';
				$agentdetails .= '<strong> Agent landline num : </strong>'.$agent_landline_num.' - <strong>Agent address => </strong>'.$agent_address.'</br>'.'<br/>===================<br/>';
			}
			
		}
		 else
		{
			
			$ins_arg  = "update quote_new set suburb='".mres($suburb)."', stages = '2' , real_estate_id='".$realstatename."', real_estate_id='".$realstatename."', site_id=".$site_id.", white_goods='".$white_goods."', parking='".$parking."', have_removal=".$have_removal.", booking_date='".$booking_date."', name='".mres($name)."',postcode = '".$postcode."',phone='".$phone."', email='".$email."', job_ref='".$job_ref."' , latitude = '".$latitude."', longitude = '".$longitude."', quote_for = '".$quote_for."', referral_staff_name = '".$staff_id."', question_id='".$question_ids."',client_type= '".mres($client_type)."',  ";
			
			  $ins_arg.=" agency_name='".mres($agency_name)."' ,agent_name='".mres($agent_name)."', agent_number='".mres($agent_number)."' ,agent_email='".mres($agent_email)."', agent_landline_num='".mres($agent_landline_num)."' , agent_address='".mres($agent_address)."' , ";
			
		   $ins_arg.=" pets_property='".mres($pets_property)."' ,lived_property='".mres($lived_property)."', bond_amiming='".mres($bond_amiming)."' ,best_time_contact='".mres($best_time_contact)."' ,";	
		//	$ins_arg.=" lift_property='".mres($lift_property)."' ,quote_floor='".mres($quote_floor)."', stains='".mres($stains)."',";
			$ins_arg.= " moving_from='".mysql_real_escape_string($temp_quote['moving_from'])."', moving_to='".mysql_real_escape_string($temp_quote['moving_to'])."',is_flour_from='".$temp_quote['is_flour_from']."', is_flour_to='".$temp_quote['is_flour_to']."',is_lift_from='".$temp_quote['is_lift_from']."', house_type_from='".$temp_quote['house_type_from']."',door_distance_from='".$temp_quote['door_distance_from']."', is_lift_to='".$temp_quote['is_lift_to']."',house_type_to='".$temp_quote['house_type_to']."', door_distance_to='".$temp_quote['door_distance_to']."',lat_from='".$temp_quote['lat_from']."', long_from='".$temp_quote['long_from']."',lat_to='".$temp_quote['lat_to']."', long_to='".$temp_quote['long_to']."', cubic_meter='".$temp_quote['cubic_meter']."',  depot_to_job_time = '".$temp_quote['depot_to_job_time']."' ,traveling = '".$temp_quote['traveling']."' ,travel_time = '".$temp_quote['travel_time']."' ,loading_time = '".$temp_quote['loading_time']."', ";
			
		  	 $ins_arg.=" address='".mres($address)."', comments='".mres($comments)."', date='".date("Y-m-d")."', amount='".$temp_quote['amount']."' where id=".$_SESSION['quote_id'];
			 
			 /* if($client_type == 2) {
				$agentdetails .= '<strong> Agency Name :</strong> '.$agency_name.' - <strong>Agent name => </strong>'.$agent_name.'</br>'.'<br/>===================<br/>';
				$agentdetails .= '<strong> Agent Number :</strong> '.$agent_number.' - <strong>Agent email => </strong>'.$agent_email.'</br>'.'<br/>===================<br/>';
				$agentdetails .= '<strong> Agent landline num : </strong>'.$agent_landline_num.' - <strong>Agent address => </strong>'.$agent_address.'</br>'.'<br/>===================<br/>';
			 } */
		}
		
		$p_comment = '';
		if($pets_property !='') {
			  $pets_propertydata =  dd_value(29);
		  $p_comment .= 'Pets on Property => '.$pets_propertydata[$pets_property].'<br/>';
		}
		if($lived_property !='') {
			 $lived_propertydata =  dd_value(120);
		 $p_comment .= 'How long you have lived in the property? => '.$lived_propertydata[$lived_property].'<br/>';
		}
		if($bond_amiming !='') {
			 $bond_amimingdata =  dd_value(118);
		  $p_comment .= 'How much Bond are we aiming to secure? => '.$bond_amimingdata[$bond_amiming].'<br/>';
		}
		if($best_time_contact !='') {
			 //$gettrackdata =  dd_value(112);
		  $p_comment .= 'Best time to contact => '.$best_time_contact.'<br/>';
		}
		
	/*
		if($lift_property !='') {
			 //$gettrackdata =  dd_value(112);
		  $p_comment .= 'List Property => '.$best_time_contact.'<br/>';
		}
		if($quote_floor !='') {
			 //$gettrackdata =  dd_value(112);
		  $p_comment .= 'Quote Floor => '.$best_time_contact.'<br/>';
		}
		if($quote_floor !='') {
			 //$gettrackdata =  dd_value(112);
		  $p_comment .= 'Stains => '.$best_time_contact.'<br/>';
		}*/
	
    //echo $ins_arg;
		
		$ins = mysql_query($ins_arg);	
		//$quote_id = mysql_insert_id();
		if($ins){ 
			// quote_new is inserted 						
			//echo "Quote Session ".$_SESSION['quote_id'];
			if(isset($_SESSION['quote_id'])){
				
				$bool = mysql_query("delete from quote_details where quote_id=".$_SESSION['quote_id']);
				
				/* $sql = mysql_query("SELECT  id FROM `quote_details_inventory` where quote_id = ".$_SESSION['quote_id']."");
				if(mysql_num_rows($sql) > 0) {
					$bool1 = mysql_query("delete from quote_details_inventory where quote_id=".$_SESSION['quote_id']."");
				} */
				
				$quote_id = $_SESSION['quote_id'];
				
			}else{
				$quote_id = mysql_insert_id();
				$bool = mysql_query("update temp_quote set quote_id='".$quote_id."' where id=".$_SESSION['temp_quote_id']);	
				$_SESSION['quote_id'] = $quote_id;
				 
					$admin_name = get_rs_value("admin","name",$_SESSION['admin']);

					//$currenttime = date('i');
					if(date('i') <= '30') {
						$schedule_time_value_from = date('H').':00';
						$schedule_time_value_to = date('H').':30';
					}else{
						$schedule_time_value_from = date('H').':30';
						$schedule_time_value_to = date('H' ,strtotime('+1 hour')).':00';

					}

					$schedule_time_value = $schedule_time_value_from.'-'.$schedule_time_value_to;

					$slot_from = $schedule_time_value_from;
					$slot_to = $schedule_time_value_to;

					$schedule_date_time = date('Y-m-d').' '.$schedule_time_value_from.':00';
					
					$call_she  = mysql_query("insert into call_schedule_report set quote_id='".mres($quote_id)."', staff_name='".$admin_name."', login_id='".$_SESSION['admin']."',site_id=".$site_id.",time_type=2, schedule_time='0', slot_from='".$slot_from."', slot_to='".$slot_to."',schedule_time_value='".$schedule_time_value."',schedule_date_time='".$schedule_date_time."', status=1, call_step = 2 ,  schedule_date='".date('Y-m-d')."', org_created_date='".date('Y-m-d H:i:s')."' , createdOn='".date('Y-m-d H:i:s')."'"); 
					
					
					/* $call_she  = mysql_query("insert into sales_system set quote_id='".mres($quote_id)."', staff_name='".$admin_name."', admin_id='".$_SESSION['admin']."',site_id=".$site_id.",stages=3, status=1, fallow_date='".date('Y-m-d H:i:s')."' ,fallow_created_date='".date('Y-m-d')."' ,task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  fallow_time='".$schedule_time_value."' , createOn='".date('Y-m-d H:i:s')."'"); 
					
					$fallow_time = date('Y-m-d H:i:s' , strtotime("+15 minutes"));
					
					$saleid = mysql_insert_id();
					add_sales_follow($saleid , $quote_id , $fallow_time); */
			}
			
			if($agentdetails != '') {
			  $reheading = 'RealEstate Agent Details';
		    	add_quote_notes($quote_id,$reheading,$agentdetails);
			}
			
			$brtoken = md5($quote_id);
			$bool = mysql_query("update quote_new set brtoken='".$brtoken."' where id=".$quote_id);	
			
			$qdetails = mysql_query("select * from temp_quote_details where temp_quote_id=".$_SESSION['temp_quote_id']."");
			$comment = '';
			$heading = '';
			$button_show = false;
			$step = false;
			while($r = mysql_fetch_assoc($qdetails)){
				
				
/*				$lift_property = $varx[28];
	$quote_floor = $varx[29];
	$stains = $varx[30];*/	
				
				$ins_arg  = "insert into quote_details set quote_id='".$quote_id."',discount='".$r['discount']."',truck_type_id='".$r['truck_type_id']."',amount='".$r['amount']."',blinds_numbers='".$r['blinds_numbers']."', hours='".$r['hours']."',rate='".$r['rate']."',
				job_type_id='".$r['job_type_id']."', job_type='".$r['job_type']."',booking_date='".$r['booking_date']."', bed='".$r['bed']."', study='".$r['study']."', bath='".$r['bath']."',
				lounge_hall=".$r['lounge_hall'].", kitchen_dining='".$r['kitchen_dining']."', kitchen='".$r['kitchen']."', office='".$r['office']."', garage='".$r['garage']."',			
				origanl_total_time='".$r['origanl_total_time']."', origanl_cubic='".$r['origanl_cubic']."', origanl_total_amount='".$r['origanl_total_amount']."', 
				
				lift_property='".$r['lift_property']."', quote_floor='".$r['quote_floor']."', stains='".$r['stains']."',
				
				depot_to_job_time='".$r['depot_to_job_time']."', travel_time='".$r['travel_time']."', traveling='".$r['traveling']."', loading_time='".$r['loading_time']."', truck_id='".$r['truck_id']."', 
				
				laundry=".$r['laundry'].", box_bags='".$r['box_bags']."', dining_room='".$r['dining_room']."', travelling_hr='".$r['travelling_hr']."', cubic_meter='".$r['cubic_meter']."', working_hr='".$r['working_hr']."',
				toilet='".$r['toilet']."', living='".$r['living']."', furnished='".$r['furnished']."', property_type='".$r['property_type']."', blinds_type='".$r['blinds_type']."',quote_auto_custom=".$r['quote_auto_custom'].",
				carpet_stairs='".$r['carpet_stairs']."', pest_inside='".$r['pest_inside']."', pest_outside='".$r['pest_outside']."', pest_flee='".$r['pest_flee']."', description='".$r['description']."'"; 
				
				//echo $ins_arg;
				
				$ins = mysql_query($ins_arg);
				
				$comment .= '<strong>'.$r['job_type'].' - </strong> $'.$r['amount'].'</br>'.$r['description'].'<br/>===================<br/>';
				
				if($r['job_type_id'] == 11) {
					$button_show = true;
					$step = true;
				}
				
			}
			
			if($step == true) {
			  $update  = mysql_query("update quote_new set step = '3' where id = ".$quote_id.""); 
			}
			
		       /* $teqdetails = mysql_query("select * from temp_quote_details_inventory where temp_quote_id=".$_SESSION['temp_quote_id']."");
				
				 if(mysql_num_rows($teqdetails) > 0) {
						while($tquotedetails = mysql_fetch_assoc($teqdetails)){ 
						
						 //print_r($tquotedetails);
						       
							$ins_arg1  = ("insert into quote_details_inventory set quote_id='".$quote_id."', 
		                   type= '".$tquotedetails['type']."', inventory_type_id='".$tquotedetails['inventory_type_id']."', inventory_item_name='".$tquotedetails['inventory_item_name']."',item_pos='".$tquotedetails['item_pos']."',qty='".$tquotedetails['qty']."' , inventory_item_id=".$tquotedetails['inventory_item_id']."");						     
						  $ins1= mysql_query($ins_arg1); 
						
						}
				}  */
			
			
			//echo $p_comment; die;	

			if($p_comment != '') {
				$p_heading = 'Property Description ';
				add_quote_notes($quote_id,$p_heading,$p_comment);
			}
			
			
			//die;
			$heading = 'Job type Description ';
			add_quote_notes($quote_id,$heading,$comment);
			
			
			
			/* if($button_show == true) {
				//send_inventory_email
				echo '<span id="inventory_email_message"></span>';
				echo '<div class="btn_bok_now_email" style="float: left;" id="inventory_email"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'503\',\'inventory_email_message\')" style="color: #fff;">Inventory Email </a></div>';
				echo '</div>';	
				
				echo '<div class="btn_bok_now_email" id="inventory_sms"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'504\',\'inventory_email_message\')" style="color: #fff;">Inventory SMS</a></div>';
				echo '</div>';	
			} */
			
			echo '<div class="btn_get_quot" style="margin-left:196px;"><a href="javascript:void(0)" onClick="getQuoteQuestions(\''.$_SESSION['quote_id'].'\',\'530\',\'quote_div3\');">Quote Questions</a></div>';
			
			echo '<div class="buttons" style=" width: 66%;">';
			echo '<div class="btn_get_quot"><a href="javascript:scrollWindow(\'email_quote.php?quote_id='.$_SESSION['quote_id'].'\',\'1200\',\'850\')" >View Quote</a></div>';
			
			echo '<div class="btn_bok_now" id="quote_approved"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'27\',\'quote_approved\')">Email Quote</a></div>';
			echo '</div>';	
	      
		     $trackid = get_sql("sales_task_track","quote_id","where quote_id=".$_SESSION['quote_id']);
		   if($trackid != '') {	
		   
		         $quotedetails['login_id'] = get_rs_value("quote_new","login_id",$_SESSION['quote_id']);
				 
		        echo '<div class="btn_get_quot" id="login_followup"><span >'.create_dd("login_id","admin","id","name","is_call_allow = 1 AND status = 1","class=\"heading_drop\" onchange=\"javascript:edit_field(this,'quote_new.login_id',".$_SESSION['quote_id'].");\"",$quotedetails).'</span></div>';
			}
			
		
           //$salesid = get_rs_value("quote_new","booking_id",$id);	
		 //$auto_role = get_rs_value("admin","auto_role",$_SESSION['admin']); 
		// if($auto_role == 1) {
		   echo '<div class="btn_get_quot" id="auto_follow"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'572\',\'auto_follow\')" >Auto Follow up</a></div>';
		   
		   echo '<div class="btn_get_quot" id="lost_quote"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'573\',\'lost_quote\')" >Lost Quote</a></div>';
		// }
			
			echo '<div class="buttons" id="book_now_div">';			
			echo '<div class="btn_get_quot"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',9,\'book_now_div\');">Book Now</a></div>';
			echo '</div>';	
			
		//get_rs_value("quote_new","m",$_SESSION['quote_id']);	
		
		$quoteDetails = mysql_fetch_array(mysql_query("select id, moving_from, removal_enquiry_date , moving_to from quote_new where id=".mysql_real_escape_string($_SESSION['quote_id']).""));
			
			
		if($quoteDetails['moving_from'] != '' && $quoteDetails['moving_to'] !='' && $quoteDetails['removal_enquiry_date'] == '0000-00-00 00:00:00') {
			
			echo '<div class="buttons" id="send_enquiry_cbd">';			
			echo '<div class="btn_get_quot"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',540,\'send_enquiry_cbd\');">Send enquiry </a></div>';
			echo '</div>';	
		}
			
		}else{
				echo "Couldnt Insert into Quote Pls Check function save_quote() ajax";	
		}		
	}else{
		echo "Couldnt Save Temp Quote Pls Check function save_quote() ajax";	
	}
}

	function send_inventory_email($id){
			$job_id = get_rs_value("quote_new","booking_id",$id);	
			//$ssecret = get_rs_value("quote_new","ssecret",$quote_id);	
			 if($job_id == "0"){ 
			  add_quote_notes($id,"Inventory Link Emailed ",'');
			}else {
			  add_job_notes($job_id,"Inventory Link Emailed",''); 
			}
			echo inventory_email($id);
			
			echo '<span style="color: green; margin-left: 106px;">Inventory Email Send successfully</span>';
	}
	
	function send_inventory_sms($id){
			
			//echo inventory_sms($id);
			    $quote_id = $id;
				$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));
					
			/* $jobDetails = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".mysql_real_escape_string($quote_id)." AND job_type_id = 11"));
				
			$quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=".$quote['quote_for']."")); */	
				
				$siteUrl1  = Site_url;
                $qu_id = base64_encode($quote['id']);
				$url = $siteUrl1."/members/".$qu_id."/inventory"; 
				
			    $getURL = get_short_url($url);
				
				$url1 = '<a href='.$getURL.' target="_blank">'.$getURL.'</a>';
				
					$eol = "<br/>";
					$str = '';
				
				
				$comment_note = "Hi ".ucfirst($quote['name']).", Thanks for contacting us for Removal Quote,  Click hear to view or change your Inventory ".$url1."  Kind Regards - BCIC - 1300 599 644 ";
				
				$comment_sms = "Hi ".$quote['name'].", Thanks for contacting us for Removal Quote,  Click hear to view or change your Inventory ".$getURL." Kind Regards - BCIC - 1300 599 644 ";
					
				$sms_code = send_sms(str_replace(" ","",$quote['phone']),$comment_sms);
				$heading = "Send Inventory Link SMS to ".$quote['name']; 
				if($sms_code=="1"){ $flag = 1; $heading.=" (Delivered)";} else{ $flag = 2; $heading.=" <span style=\"color:red;\">(Failed)</span>";  }

	        if($flag == 1) {		 
			
			     echo '<span style="color: green; margin-left: 106px;">Inventory SMS Send successfully</span>'; 
				 $bool = mysql_query("update quote_new set inv_sms_date='".date('Y-m-d H:i:s')."' where id=".$id);	
				 
			}else{
				 echo '<span style="color: red; margin-left: 106px;">Inventory SMS Send Failed</span>'; 
			}
			 
				// $job_id = get_rs_value("quote_new","booking_id",$id);	
				add_quote_notes($quote_id,$heading,$comment_note);
			//echo '<span style="color: green; margin-left: 106px;">Inventory SMS Send successfully</span>';
	}


function delete_quote_temp($id){
	// delete the field man
	$bool = mysql_query("delete from temp_quote_details where id=".mres($id)."");
	
	$sql = mysql_query("SELECT  id FROM `temp_quote_details_inventory` where temp_quote_id = ".$_SESSION['temp_quote_id']."");
		if(mysql_num_rows($sql) > 0) {
			updatedeletedbrquote('temp_quote',$_SESSION['temp_quote_id']);
			$bool = mysql_query("delete from temp_quote_details_inventory where temp_quote_id=".$_SESSION['temp_quote_id']."");
		}
	
	echo create_quote_str($_SESSION['temp_quote_id']);
}

function edit_field_quote($var){
	
	$varx = explode("|",$var);
	$value = $varx[0];
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	
	
    $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
    $qdetails = mysql_fetch_array(mysql_query("select * from temp_quote_details where id=".$id.""));
   
    if($qdetails['job_type_id'] == 11) {
		
        /*
		if($table=="temp_quote_details" && ($field=="hours" || $field=="cubic_meter" || $field=="depot_to_job_time" || $field=="travelling_hr" ||  $field=="loading_time")){ 
		   update_br_amount($id , $table , $field);
		}
		*/
		
		
		 if($table=="temp_quote_details" && ($field=="hours" || $field=="truck_type_id")){ 
		    
    			if($field=="truck_type_id") {
					
					 $truckamount = get_rs_value("truck_list","amount",$value);
					 $totalamount = ($qdetails['hours'] * $truckamount);
					 $hours = $qdetails['hours'];
					 
				}elseif($field=="hours"){
					
					 $amount = get_rs_value("truck_list","amount",$qdetails['truck_type_id']);
					$totalamount = $amount * $value;
					$hours = $value;
				}
			$bool = mysql_query("update temp_quote_details set amount ='".$totalamount."' , hours = ".$hours." where id=".$id."");	
		}

    }else{	
	
		if($table=="temp_quote_details" && ($field=="hours" || $field=="rate" || $field=="discount")){ 
		
			$temp_quote_details = mysql_fetch_array(mysql_query("select * from $table where id=".$id));
			$amount = ($temp_quote_details['hours']*$temp_quote_details['rate']);	
			
				if($field == 'discount') {
				      $amount = $amount - $value;
				}
			
			$bool = mysql_query("update ".$table." set amount='".$amount."' where id=".$id."");
		}	
	}
	echo create_quote_str($_SESSION['temp_quote_id']);		 
}



function recalc_quote_temp($temp_id){
	$qdetails = mysql_query("select * from temp_quote_details where temp_quote_id=".$_SESSION['temp_quote_id']."");
	$total_amount = 0;
	while($r = mysql_fetch_assoc($qdetails)){ 	
		$total_amount = ($total_amount+$r['amount']); 
	}	
	return $total_amount;	
}

function add_quote_comments($var){
	
	//print_r($var); die;
	
	$varx = explode("|",$var);
	$comment = $varx[0];
	$quote_id= $varx[1];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	if($comment!=""){ 
		add_quote_notes($quote_id,"Note Added By ".mysql_real_escape_string($staff_name),$comment);
	}
	include("quote_notes.php"); 
	
}


function referesh_quote_comments($var){
	$quote_id= $var;
	include("quote_notes.php");	
}

function getSmsNotifcation($var){
	$exclude_ntfn = $var;
	include $_SERVER['DOCUMENT_ROOT']. '/newsms/vpb_incoming_messages.php';
}

function view_quote_side($quote_id){
//	echo "this is Quote_id".$quote_id;
	include("quote_side.php");
}


function edit_quote_edit_field($var){
	
	$varx = explode("|",$var);
	
	$value = $varx[0];
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	
	$get_job_type = get_rs_value("quote_details","job_type_id",$id);	
	
	/* print_r($get_job_type);
	print_r($varx); */
	
	if(($table=="quote_details") && ($field=="amount")){
	       $getdetails1 = mysql_fetch_assoc(mysql_query("select quote_id,amount,job_type,job_type_id , quote_auto_custom from quote_details where id=".$id.""));
		 
		       $qstep = get_rs_value("quote_new","step",$getdetails1['quote_id']);
				
				if($qstep == 1) {
				   $bool = mysql_query("update quote_new  set step ='2' where id=".$getdetails1['quote_id'].""); 	
				}
		 
	}
	 
        $quote_auto_custom = get_rs_value("quote_details","quote_auto_custom",$id);	
		
		
	    if($table=="quote_details" && $field =="quote_auto_custom") {
	         $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
	    }	
	
	if($table =="quote_details" && $field == 'description') {
		
		//echo ("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
		$job_type_id = get_rs_value("quote_details","job_type_id",$id);	
		  
		    if($quote_auto_custom == 2){
			   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
			}
			if($job_type_id != 1 && $job_type_id != 2 && $job_type_id != 3 && $job_type_id != 11){
				$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
			}
			 
	}elseif($table=="quote_details" && ($get_job_type != 11) && ($field=="hours" || $field=="rate" || $field=="discount")){ 
	 // echo "22222222222"; die;
			$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id));
			
			$amount = ($quote_details['hours']*$quote_details['rate']);		
			if($quote_details['quote_auto_custom'] == 2){
			   $bool1 = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 	
               			   
				if($field=="discount") {
					 $amount = $amount - $value;
				}	
				
			   $bool = mysql_query("update ".$table." set amount='".$amount."' where id=".$id."");	
			   fix_job_details_amounts($id);	
			}
		
	}elseif($table=="quote_details" && ($get_job_type == 11)  && ($field == 'truck_type_id' || $field=="hours")){ 
	    
		    $quote_details = mysql_fetch_array(mysql_query("select id ,quote_id ,quote_auto_custom ,  truck_type_id ,hours, amount from quote_details where id=".$id));
			
			if($quote_details['quote_auto_custom'] == 2){
				
					$bool1 = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 	
						
					$truck_type_name = get_rs_value("truck_list","truck_type_name",$quote_details['truck_type_id']);
					$truckname = get_rs_value("truck_list","truck_type_name",$value);
					
					if($field == 'truck_type_id') {
						
						$truckamount = get_rs_value("truck_list","amount",$value);
						$totalamount = $truckamount * $quote_details['hours'];
						$hours = $quote_details['hours'];
						$heading = 'Truck type Change '.$truck_type_name.'('.$quote_details['amount'].')'. ' to '.$truckname.'('.$totalamount.')';
						
					}elseif($field=="hours"){
						
						$amount = get_rs_value("truck_list","amount",$quote_details['truck_type_id']);
						$totalamount = $amount * $value;
						$hours = $value;
						$heading = 'Truck type Change '.$truck_type_name.'('.$quote_details['amount'].')'. ' to '.$truckname.'('.$totalamount.')';
					}
				
					
					$bool = mysql_query("update quote_details set amount ='".$totalamount."' , hours = ".$hours." where id=".$id."");
					add_quote_notes($quote_details['quote_id'],$heading,"");
			}
		
	}elseif(($table=="quote_details") && ($get_job_type == 11) && ($field=="bed" || $field=="study" || $field=="lounge_hall" || $field=="kitchen" || $field=="dining_room")){ 
	
	    //echo 'ssd';
	
			$quote_details = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id));
		
			if($quote_details['quote_auto_custom'] == 1){
				
			    $bool1 = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
				$r = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id.""));
				$desc = create_quote_desc_str($r);
				$bool = mysql_query("update ".$table." set description='".$desc."' where id=".$id."");
			}
		
	}else if (($table=="quote_details") && ($get_job_type != 11) && ($field=="bed" || $field=="bath" || $field=="study" || $field=="toilet" || $field=="living" || $field=="furnished" || $field=="property_type" || $field=="blinds_type" || $field=="carpet_stairs"  ||  $field=="lift_property"  ||  $field=="quote_floor"  ||  $field=="stains"  || $field=="blinds_numbers" )){  
		
		//echo $field; die;
		  $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id));
			
			if($quote_details['quote_auto_custom'] == 1){
				
				//echo 'ok'; die;
				
				$qstep = get_rs_value("quote_new","step",$quote_details['quote_id']);
				
				if($qstep == 1) {
				   $bool = mysql_query("update quote_new  set step ='2' where id=".$quote_details['quote_id'].""); 	
				}
			
			 if($field=="quote_floor" && $value != 1) {
			     	$bool = mysql_query("update ".$table." set quote_floor ='".$value."' , lift_property ='0' , stains ='0'  where id=".$id.""); 		
			 }else {
			    $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 	
			 }
				$r = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id.""));
				$desc = create_quote_desc_str($r);
		  
				  recalc_rates($id);
				  $bool = mysql_query("update ".$table." set description='".$desc."' where id=".$id."");
				  fix_job_details_amounts($id); 
				  // update_edit_desc($quote_details['quote_id']);
				  //comment date 04-03-2019
			}
		
		
	}else if (($table=="quote_new") &&  ($field=="is_flour_from" ||  $field=="is_lift_from" || $field=="house_type_from" || $field=="door_distance_from" || $field=="door_distance_to" || $field=="is_flour_to" || $field=="is_lift_to" || $field=="house_type_to"  || $field=="depot_to_job_time"  || $field=="travel_time"  || $field=="traveling"  || $field=="loading_time" )){
		
		//echo "update ".$table." set ".$field."='".$value."' where id=".$id."";  die;
		
		 $quote_details = mysql_fetch_array(mysql_query("select quote_auto_custom from quote_details where quote_id = '".$id."'  AND  job_type_id= '11'"));
			
			if($quote_details['quote_auto_custom'] == 1){
		
		      // echo  "update ".$table." set ".$field."='".$value."' where id=".$id."";
		
		        $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 	
				
			    //$r = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$id." AND job_type_id = 11"));
				//update_cubic_by_job('', $r); 
				// fix_job_details_amounts($id);
			}
				
	}else if (($table=="quote_details") && ($field=="pest_inside" || $field=="pest_outside" || $field=="pest_flee")){ 
	
	    $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id));
			
			if($quote_details['quote_auto_custom'] == 1){
				$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
				 $r = mysql_fetch_array(mysql_query("select * from quote_details where id=".$id.""));
				
				  $desc = create_quote_desc_str($r);
				 // echo $desc;
				  recalc_rates($id);
				  $bool = mysql_query("update ".$table." set description='".$desc."' where id=".$id."");
				  fix_job_details_amounts($id);
			}
			
		   //quote_details.quote_auto_custom
	}else if (($table=="quote_new") && ($field=="pets_property" || $field=="lived_property"  || $field=="best_time_contact" || $field=="bond_amiming")){ 
	
		   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
		   if($field=="best_time_contact" && $value != 0) {
			  $booking_id = get_rs_value("quote_new","booking_id",$id);
			   $heading = "Best time to contact   ".$value;
			   add_job_notes($booking_id,$heading ,$heading);
		   }
	     
			
		   //quote_details.quote_auto_custom
	}else if (($table=="quote_details") && ($field=="quote_auto_custom")){ 
		  $getdetails = mysql_fetch_array(mysql_query("select quote_id from quote_details where id=".$id.""));
		/*  print_r($getdetails);
		 die;  */
		 	$job_id = get_sql("quote_new","booking_id","where id=".$getdetails['quote_id']." And deleted != 1");
			$fieldvalue = getSystemvalueByID($value,'49');
			if($job_id > 0) {
		       add_job_notes($job_id,"Edit Quote Change ".$fieldvalue."","");
			  
			}else{
				 add_quote_notes($getdetails['quote_id'],"Quote Change ".$fieldvalue."","");
			} 
	}else if (($table=="quote_details") && ($field=="amount")){
		
		//print_r($getdetails1);
		$heading = "Amount Change in (".$getdetails1['job_type'].")  $".$getdetails1['amount']." to $".$value;
	    $job_type_id = $getdetails1['job_type_id'];
		
		if($getdetails1['quote_auto_custom'] == 2){
			$bool1 = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 	
			add_quote_notes($getdetails1['quote_id'],$heading,$heading);
		}
		
		if($job_type_id != 1 && $job_type_id != 2 && $job_type_id != 3){
		   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id.""); 
		   add_quote_notes($getdetails1['quote_id'],$heading,$heading); 
		}
	  
        fix_job_details_amounts($id);			
	}
	echo edit_quote_str($_SESSION['edit_quote_id']);	
}

function edit_quote_details($type){
	
	//echo  $type; die;
	
	
	if($type!="0"){ 		
		
		$qdetails = mysql_query("select * from quote_details where quote_id=".mres($_SESSION['edit_quote_id'])." and job_type_id=".$type."");
		$total_amount = 0;
		
		if(mysql_num_rows($qdetails)>0){ 
			while($r = mysql_fetch_assoc($qdetails)){ 
				$type=$r['job_type_id'];							
				if($type=="1"){ 
					$cleaning_html = '<ul class="bci_creat_first_quote">
										<li>
											<label>Bed</label>
											<div class="br_plus">
												<div class="input-group">
												  <input type="text" id="bed" name="bed" class="form-control input-number" max="10" value="'.$r['bed'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.bed\',\''.$r['id'].'\');">
												</div>
											</div>
										</li>						
										<li>
											<label>Bath</label>
											<div class="br_plus">
												<div class="input-group">
												  <input type="text" id="bath"  name="bath" class="form-control input-number" max="10" value="'.$r['bath'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.bath\',\''.$r['id'].'\');">
												</div>
											</div>
										</li>
										<li>
											<label>Study</label>
											<div class="br_plus">
												<div class="input-group">
												  <input type="text" id="study" name="study" class="form-control input-number" max="10" value="'.$r['study'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.study\',\''.$r['id'].'\');">
												</div>
											</div>
										</li>
										<li>
											<label>Toilet</label>
											<div class="br_plus">
												<div class="input-group">
												  <input type="text" id="toilet" name="toilet" class="form-control input-number" max="10" value="'.$r['toilet'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.toilet\',\''.$r['id'].'\');">
												</div>
											</div>
										</li>
										<li>
											<label>Living Area</label>
											<div class="br_plus">
												<div class="input-group">                              
												  <input type="text" id="living" name="living" class="form-control input-number"  max="10" value="'.$r['living'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.living\',\''.$r['id'].'\');">                             
												</div>
											</div>
										</li>
										<li>
										<label>Furnished</label>';
								   $cleaning_html.= create_dd("furnished","system_dd","name","name","type=18","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.furnished','".$r['id']."');\"",$r); 
				
								   $cleaning_html.='</li><li><label>House Type</label>';
								   $cleaning_html.= create_dd("property_type","dd_property_type","name","name","","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.property_type','".$r['id']."');\"",$r);
										
								   $cleaning_html.='</li><li><label>Blinds</label>';
									
								   $cleaning_html.= create_dd("blinds_type","dd_blinds","name","name","","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.blinds_type','".$r['id']."');get_blinds_type(this.value)\"",$r);
								   
								    if($r['blinds_type'] == 'Venetians' || $r['blinds_type'] == 'Shutters') {
										$style = 'display:;block';
									}else{
										$style = 'display:none;';
									}
								   
								  // echo $r['blinds_type'];
								   
								    $cleaning_html.= '<li id="blinds_number_value" style="'.$style.'"><label>Blinds value</label> <input type="text" id="blinds_numbers" value="'.$r['blinds_numbers'].'" placeholder="" onblur="javascript:edit_quote_edit_field(this,\'quote_details.blinds_numbers\',\''.$r['id'].'\');"  name="blinds_numbers" class="form-control input-number"  max="10"></li>';
								   
								   $cleaning_html.= '</ul>';
								   //$cleaning_html.='<div class="bb_add"><input type="button" class="frm_btn" value="Add" onclick="javascript:dd_quote_item('.$type.');"></div>';
								echo $cleaning_html;				
				}elseif($type=="11"){ 
				
	                $cleaning_html = '<ul class="bci_creat_first_quote bci_creat_first_quote_new">
						<li>
							<label>Bed</label>
								<div class="br_plus">
									<div class="input-group">
									  <input type="text" id="bed" value="'.$r['bed'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.bed\',\''.$r['id'].'\');" name="bed" class="form-control input-number" max="10">
									</div>
								</div>
						</li>		
						
                        <li>
							<label>Study</label>
							<div class="br_plus">
								<div class="input-group">                              
								  <input type="text" id="study" value="'.$r['study'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.study\',\''.$r['id'].'\');"  name="study" class="form-control input-number"  max="10">                             
								</div>
							</div>
						</li>
						
						<li>
							<label>Living Area</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="lounge_hall" value="'.$r['lounge_hall'].'"  onblur="javascript:edit_quote_edit_field(this,\'quote_details.lounge_hall\',\''.$r['id'].'\');"  name="lounge_hall" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						
						<li>
							<label>Kitchen</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="kitchen" value="'.$r['kitchen'].'"   onblur="javascript:edit_quote_edit_field(this,\'quote_details.kitchen\',\''.$r['id'].'\');" name="kitchen" class="form-control input-number" max="10">
								</div>
							</div>
						</li>
						
						<li>
							<label>Dining</label>
							<div class="br_plus">
								<div class="input-group">
								  <input type="text" id="dining_room" value="'.$r['dining_room'].'"  onblur="javascript:edit_quote_edit_field(this,\'quote_details.dining_room\',\''.$r['id'].'\');" name="dining_room" class="form-control input-number" max="10">
								</div>
							</div>
						</li>';
					
                   $cleaning_html.= '</ul>';
				   
				echo $cleaning_html;				
            }else if ($type=="2"){
                
                  if($r['quote_floor'] == 1) {
                      $dis = '';
                  }else{
                      $dis = 'none';
                  }
                
					echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">
									<li>
										<label>Bedroom</label>
									   <input type="text" id="bed" name="bed" class="form-control input-number" max="10" value="'.$r['bed'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.bed\',\''.$r['id'].'\');">                          
									</li>
									<li>
										<label>Living Area & Dining</label>
										 <input type="text" id="living" name="living" class="form-control input-number" max="10" value="'.$r['living'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.living\',\''.$r['id'].'\');">
									</li>
									<li>
										<label>Stairs</label>
										 <input type="text" id="carpet_stairs" name="carpet_stairs" class="form-control input-number" value="'.$r['carpet_stairs'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.carpet_stairs\',\''.$r['id'].'\');">
									</li>  
									
								<li>
                                    <label>Stains</label>
                                    <span>'.create_dd("stains","system_dd","id","name","type = 29","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.stains','".$r['id']."');\"",$r).'</span> 
                                </li>   	
									
                                <li>
                                    <label>Floor</label>
                                    <span>'.create_dd("quote_floor","system_dd","id","name","type = 156","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.quote_floor','".$r['id']."');floorcheck(this.value);\"" ,$r).'</span> 
                                </li>   
                                
                                <li style="display:'.$dis.';" class="showinfo">
                                    <label>lift at property </label>
                                    <span>'.create_dd("lift_property","system_dd","id","name","type = 29","onchange=\"javascript:edit_quote_edit_field(this,'quote_details.lift_property','".$r['id']."');\"",$r).'</span> 
                                </li>   
                                
                                
                                

									
								</ul>
								';								
				}else if($type=="3"){
					
					 $checkboxinside = ($r['pest_inside']==1 ? 'checked' : '');
					 $checkboxioutside = ($r['pest_outside']==1 ? 'checked' : '');
					 $checkboxiflee = ($r['pest_flee']==1 ? 'checked' : '');
					
				   echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">                	
							<li>
								<label>Inside</label>					
								<input type="checkbox" name="pest_inside" onchange="javascript:pestquote(\'quote_details.pest_inside\',\''.$r['id'].'\');" id="pest_inside" value="'.$r['pest_inside'].'" '.$checkboxinside.'>
							</li> 
							<li>
								<label>Outside</label>
								<input type="checkbox" onchange="javascript:pestquote(\'quote_details.pest_outside\',\''.$r['id'].'\');" name="pest_outside" id="pest_outside" value="'.$r['pest_outside'].'" '.$checkboxioutside.'>
							</li>
							<li>
								<label>Flea and Tick</label>
							   <input type="checkbox" onchange="javascript:pestquote(\'quote_details.pest_flee\',\''.$r['id'].'\');" name="pest_flee" id="pest_flee" value="'.$r['pest_flee'].'" '.$checkboxiflee.'>
							</li>
						</ul>
						';
				
			    }else if($type=="8"){
					
					echo '<ul class="bci_creat_first_quote" style="margin:25px 0 0">                	
						<li style="width:45%!important">
							<label style="width:15%!important">Desc</label>
							<input type="text" id="desc" name="desc" onblur="javascript:edit_quote_edit_field(this,\'quote_details.description\',\''.$r['id'].'\');" value="'.$r['description'].'" class="form-control input-number" style="width:70%!important; text-align:left!important;">					
						</li>
						<li style="width:25%!important">
							<label style="width:20%!important">Amount</label>
						   <input type="text" id="amount" onblur="javascript:edit_quote_edit_field(this,\'quote_details.amount\',\''.$r['id'].'\');"  value="'.$r['amount'].'" name="amount" class="form-control input-number">
						</li>
					</ul>
					';
				}else{
					echo "<br>";
					echo error(" Come on Guys, Edit in the Quote Section >> "); 	
				}
							
			}
		}else{
			include("edit_quote_object.php"); 	
		}
		
		
	}
}


function recalc_rates($quote_details_id){
	
	$qd = mysql_fetch_array(mysql_query("select * from quote_details where id=".$quote_details_id));
	$site_id = get_rs_value("quote_new","site_id",$qd['quote_id']);
	
	//echo "<pre>"; print_r($qd); die;
	
	if($qd['job_type_id']=="1"){ 
		
		$bed= $qd['bed'];
		$study= $qd['study'];
		$bath= $qd['bath'];
		$toilet= $qd['toilet'];
		$living= $qd['living'];
		$furnished= $qd['furnished'];
		$property_type= ($qd['property_type']);
		$blinds = $qd['blinds_type'];
		// die;
		$job_type = get_rs_value("job_type","name",$type);
		$hours = 0;
		// find the quote for this 
		$cleaning_amt = 0;
		$rates_sql_site = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=".$site_id; 
		$rates_data  = mysql_query($rates_sql_site);
		if(mysql_num_rows($rates_data)==0){
			$rates_sql = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=0"; 
			$rates_data  = mysql_query($rates_sql);			
		}		
		
		$rates = mysql_fetch_array($rates_data);
		
	 //echo '<pre>';	print_r($rates); 
		
		$calc = "";
		$hours = $rates['hours'];
		// if property is furnished or not furnished decided the first charge 	
		if($furnished=="No"){ 
			$cleaning_amt = $rates['unfurnished']; $calc.= "unfurnished:".$rates['unfurnished']."+"; 
			$hours = $rates['hours'];
		}else{ 
			$cleaning_amt = $rates['furnished']; $calc.= "furnished:".$rates['furnished']."+";
			$hours = ($rates['hours']+$rates['f_extra_hours']);
		} 
		
		// if blinds are venetians then it get the extra price as mentioned in rates_clening.blinds fields
		if($blinds=="Venetians" || $blinds=="Shutters"){  $cleaning_amt+=$rates['blinds']; $calc.= "blinds:".$rates['blinds']."+"; $hours = ($hours+1); } 
		
		// number of living area are included in the price are here, if there is extra living spaces, each extra living space will stract $40
		
		if($living>$rates['living_inc']) { 
			$extra_livings = ($living-$rates['living_inc']);  
			$cleaning_amt+=(40*$extra_livings);  
			$hours = ($hours+$extra_livings); 
			$calc.= "etc living:".$extra_livings."+"; 
		}
		
		//echo $hours.'==='.$cleaning_amt;
		// if property type is two stories or multi story the price inceases according to dd_property_type.amount
		
		//echo '======='.$property_type;
		//echo '<br/>';
		$property_amount  = get_sql("dd_property_type","amount","where name='".$property_type."'");
		
		//echo $cleaning_amt;
		//echo $property_amount;
		
		if($property_amount>0){ $cleaning_amt+=$property_amount; $calc.= "p_amt:".$property_amount."+";} 
		
		$ins_arg  = "update quote_details set amount=".$cleaning_amt.", hours='".$hours."' where id=".$quote_details_id; 
		//$ins_arg.=", description='".$calc."'";
		
		$ins = mysql_query($ins_arg);
		//echo $ins_arg."<br>"; 
		//echo create_quote_str($_SESSION['temp_quote_id']); 
		
	}else if ($qd['job_type_id']=="2"){ 
		// carpet 
		$bed= $qd['bed'];
		$living= $qd['living'];
		$stairs = $qd['carpet_stairs'];
		
		
		$carpet_amt = 0;
		if($stairs==0){ 
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=".$site_id; 
		}else{
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=".$site_id; 
		}
		$rates_data  = mysql_query($rates_sql_site);
		if(mysql_num_rows($rates_data)==0){
			if($stairs==0){ 
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=0"; 
			}else{
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=0"; 
			}
			//echo $rates_sql; die;
			$rates_data  = mysql_query($rates_sql);	
		}		
		
		$rates = mysql_fetch_array($rates_data);	
     
          // print_r($rates); die;	 
				
		$ins_arg  = "update quote_details set amount=".$rates['price']." where id=".$quote_details_id; 				
		$ins = mysql_query($ins_arg);
		//echo $ins_arg."<br>"; 
		//echo create_quote_str($_SESSION['temp_quote_id']); 
		
	}else if ($qd['job_type_id']=="3"){ 
		// pest 
		$inside= $qd['pest_inside']; 
		$outside= $qd['pest_outside']; 
		$flee = $qd['pest_flee'];		
		
		$pest_amt = 0;		
		$rates_sql_site = "select * from rates_pest where site_id=".$site_id; 		
		$rates_data  = mysql_query($rates_sql_site);
		
		if(mysql_num_rows($rates_data)==0){
			$rates_sql = "select * from rates_pest where site_id=0"; 	
			$rates_data  = mysql_query($rates_sql);	
		}				
		$rates = mysql_fetch_array($rates_data);
		//print_r($rates);	
		
		if($outside == "1" && $inside == "1"){
			$pest_amt = $rates['inside_outside'];
		}else {
		
			if($flee=="1"){ $pest_amt = $rates['flea']; }
			if($outside=="1"){ $pest_amt+= $rates['outside']; }
			if($inside=="1"){ $pest_amt+= $rates['inside']; }
		}
				
		$job_type = get_rs_value("job_type","name",$type);
		
		$ins_arg  = "update quote_details set amount=".$pest_amt." where id=".$quote_details_id; 					
		$ins = mysql_query($ins_arg);
		
	}
	
}



function add_edit_quote_item($var){
	
	$varx = explode("|",$var);
	$type = $varx[0];
	$site_id = $varx[1];
		
	
	if($type=="1"){ 
		$bed= $varx[2]; 
		$study= $varx[3];
		$bath= $varx[4];
		$toilet= $varx[5];
		$living= $varx[6]; 
		$furnished= $varx[7];
		$property_type= $varx[8];
		$blinds = $varx[9];
		
		$job_type = get_rs_value("job_type","name",$type);
		$hours = 0;
		// find the quote for this 
		$cleaning_amt = 0;
		$rates_sql_site = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=".$site_id; 
		$rates_data  = mysql_query($rates_sql_site);
		if(mysql_num_rows($rates_data)==0){
			$rates_sql = "select * from rates_cleaning where bed=".($bed+$study)." and bath=".$bath." and site_id=0"; 
			$rates_data  = mysql_query($rates_sql);			
		}		
		
		$rates = mysql_fetch_array($rates_data);
		$calc = "";
		$hours = $rates['hours'];
		// if property is furnished or not furnished decided the first charge 	
		if($furnished=="0"){ 
			$cleaning_amt = $rates['unfurnished']; $calc.= "unfurnished:".$rates['unfurnished']."+"; 
			$hours = $rates['hours'];
		}else{ 
			$cleaning_amt = $rates['furnished']; $calc.= "furnished:".$rates['furnished']."+";
			$hours = ($rates['hours']+$rates['f_extra_hours']);
		} 
		
		// if blinds are venetians then it get the extra price as mentioned in rates_clening.blinds fields
		if($blinds=="Venetians" || $blinds=="Shutters"){  $cleaning_amt+=$rates['blinds']; $calc.= "blinds:".$rates['blinds']."+"; $hours = ($hours+1); } 
		
		// number of living area are included in the price are here, if there is extra living spaces, each extra living space will stract $40
		
		if($living>$rates['living_inc']) { 
			$extra_livings = ($living-$rates['living_inc']);  
			$cleaning_amt+=(40*$extra_livings);  
			$hours = ($hours+$extra_livings); 
			$calc.= "etc living:".$extra_livings."+"; 
		}
		
		// if property type is two stories or multi story the price inceases according to dd_property_type.amount
		$property_amount  = get_sql("dd_property_type","amount","where name='".$property_type."'");
		if($property_amount>0){ $cleaning_amt+=$property_amount; $calc.= "p_amt:".$property_amount."+";} 
		
		$ins_arg  = "insert into quote_details set quote_id='".$_SESSION['edit_quote_id']."',amount=".$cleaning_amt.", 
		job_type_id=".$type.", job_type='".$job_type."', bed=".$bed.", study=".$study.", bath='".$bath."',
		toilet='".$toilet."', living='".$living."', furnished='".$furnished."', property_type='".$house_type."', 
		blinds_type='".$blinds."', hours='".$hours."',rate='40' "; 
		//$ins_arg.=", description='".$calc."'";
		$ins = mysql_query($ins_arg);
		$quotedetailsID_cl = mysql_insert_id();
		
		$job_id = get_sql("quote_new","booking_id","where id='".$_SESSION['edit_quote_id']."'");
		$job_date = get_sql("quote_new","booking_date","where id='".$_SESSION['edit_quote_id']."'");
		
		if($job_id != 0) {
			$ins_arg = "insert into job_details set 
			job_id=".$job_id.",
			quote_id='".$_SESSION['edit_quote_id']."',
			site_id='".$site_id."',
			job_type_id='".$type."',
			job_type='".$job_type."',
			staff_id='0',
			job_date='".$job_date."',
			job_time='8:00 AM',
			quote_details_id='".$quotedetailsID_cl."',
			amount_total='".$cleaning_amt."'";
			$bool = mysql_query($ins_arg);		
			recalc_job_total($job_id);
			
               
		}
		
		//echo $ins_arg."<br>"; 
		echo edit_quote_str($_SESSION['edit_quote_id']); 
		
	}elseif($type=="11"){
		
		
		$bed= $varx[2];
		$study= $varx[3];
		$lounge_hall= $varx[4];
		$kitchen= $varx[5];
		$dining_room= $varx[6]; 	
		
		$moving_from= $varx[7]; 
		$moving_to= $varx[8];
		$is_flour_from= $varx[9];
		$is_flour_to= $varx[10];
		$is_lift_from= $varx[11]; 	
		$is_lift_to= $varx[12]; 	
		$house_type_from= $varx[13];
		$house_type_to= $varx[14];
		$door_distance_from = $varx[15];
		$door_distance_to = $varx[16];
		$moving_from_lat_long = explode('__',$varx[17]);
		$moving_to_lat_long = explode('__',$varx[18]);
		$booking_date= $varx[19];
		
		
		
		$job_type = get_rs_value("job_type","name",$type);
		
		$update  = "update quote_new set moving_from='".mres($moving_from)."', moving_to='".mres($moving_to)."' , is_flour_from='".$is_flour_from."',is_flour_to = '".$is_flour_to."',is_lift_from = '".$is_lift_from."',is_lift_to = '".$is_lift_to."',house_type_from = '".$house_type_from."', house_type_to = '".$house_type_to."',door_distance_from = '".$door_distance_from."',door_distance_to = '".$door_distance_to."' ,lat_from = '".$moving_from_lat_long[0]."',long_from = '".$moving_from_lat_long[1]."',lat_to = '".$moving_to_lat_long[0]."',long_to = '".$moving_to_lat_long[1]."' where id=".$_SESSION['edit_quote_id'];		
		$boolu = mysql_query($update);
		
		
		$ins_arg  = "insert into quote_details set quote_id='".$_SESSION['edit_quote_id']."' , 
		job_type_id=".$type.", job_type='".$job_type."',booking_date='".$booking_date."', bed=".$bed.", study=".$study.", lounge_hall='".$lounge_hall."',kitchen='".$kitchen."', dining_room='".$dining_room."'"; 
		$boolI = mysql_query($ins_arg);
		$quotedetailsID_cl = mysql_insert_id();
		
		$cal =  add_edit_claculate_br_cubic($_SESSION['edit_quote_id']);
			
		 $job_id = get_sql("quote_new","booking_id","where id='".$_SESSION['edit_quote_id']."'");
			
		$quote_amount = get_sql("quote_details","amount","where id=".$quotedetailsID_cl."");
		
		 if($job_id != 0) {
			$ins_arg = "insert into job_details set 
			job_id=".$job_id.",
			quote_id='".$_SESSION['edit_quote_id']."',
			site_id='".$site_id."',
			job_type_id='".$type."',
			job_type='".$job_type."',
			staff_id='0',
			job_date='".$booking_date."',
			job_time='8:00 AM',
			quote_details_id='".$quotedetailsID_cl."',
			amount_total='".$quote_amount."'";
			$bool = mysql_query($ins_arg);		
			recalc_job_total($job_id);
		} 
		
		//echo $ins_arg."<br>"; 
		echo edit_quote_str($_SESSION['edit_quote_id']); 
		
	
    }else if ($type=="2"){ 
		// carpet 
		$bed= $varx[2]; 
		$living= $varx[3]; 
		$stairs = $varx[4];
		
		
		$carpet_amt = 0;
		if($stairs==0){ 
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=".$site_id; 
		}else{
			$rates_sql_site = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=".$site_id; 
		}
		$rates_data  = mysql_query($rates_sql_site);
		if(mysql_num_rows($rates_data)==0){
			if($stairs==0){ 
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs=0 and site_id=0"; 
			}else{
				$rates_sql = "select * from rates_carpet where bed=".($bed)." and living=".$living." and stairs>0 and site_id=0"; 
			}
			//echo $rates_sql;
			$rates_data  = mysql_query($rates_sql);	
		}		
		
		$rates = mysql_fetch_array($rates_data);				
				
		$job_type = get_rs_value("job_type","name",$type);
		$ins_arg  = "insert into quote_details set quote_id='".$_SESSION['edit_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', bed=".$bed.", living='".$living."', carpet_stairs='".$stairs."', amount='".$rates['price']."' "; 
		$ins = mysql_query($ins_arg);
		
		$quotedetailsID_c = mysql_insert_id();
		
		$job_id = get_sql("quote_new","booking_id","where id='".$_SESSION['edit_quote_id']."'");
		$job_date = get_sql("quote_new","booking_date","where id='".$_SESSION['edit_quote_id']."'");
		if($job_id != 0) {
			$ins_arg = "insert into job_details set 
			job_id=".$job_id.",
			quote_id='".$_SESSION['edit_quote_id']."',
			site_id='".$site_id."',
			job_type_id='".$type."',
			job_type='".$job_type."',
			staff_id='0',
			job_date='".$job_date."',
			job_time='8:00 AM',
			quote_details_id='".$quotedetailsID_c."',
			amount_total='".$rates['price']."'";
			$bool = mysql_query($ins_arg);	

            recalc_job_total($job_id);			
		}
		
		//echo $ins_arg."<br>"; 
		echo edit_quote_str($_SESSION['edit_quote_id']); 
		
	}else if ($type=="3"){ 
	
		// pest 
		$inside= $varx[2]; 
		$outside= $varx[3]; 
		$flee = $varx[4];		
		
		$pest_amt = 0;		
		$rates_sql_site = "select * from rates_pest where site_id=".$site_id; 		
		$rates_data  = mysql_query($rates_sql_site);
		
		if(mysql_num_rows($rates_data)==0){
			$rates_sql = "select * from rates_pest where site_id=0"; 	
			$rates_data  = mysql_query($rates_sql);	
		}				
		$rates = mysql_fetch_array($rates_data);
		//print_r($rates);				
		
		if($outside == "1" && $inside == "1"){
			$pest_amt = $rates['inside_outside'];
		}else {
		
			if($flee=="1"){ $pest_amt = $rates['flea']; }
			if($outside=="1"){ $pest_amt+= $rates['outside']; }
			if($inside=="1"){ $pest_amt+= $rates['inside']; }
		}
				
		$job_type = get_rs_value("job_type","name",$type);
		 $ins_arg  = "insert into quote_details set quote_id='".$_SESSION['edit_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', pest_inside='".$inside."', pest_outside='".$outside."', pest_flee='".$flee."', amount='".$pest_amt."' "; 
 // die;
		$ins = mysql_query($ins_arg);
		
		$quotedetailsID_p = mysql_insert_id();
		
		$job_id = get_sql("quote_new","booking_id","where id='".$_SESSION['edit_quote_id']."'");
		$job_date = get_sql("quote_new","booking_date","where id='".$_SESSION['edit_quote_id']."'");
		if($job_id != 0) {
			$ins_arg = "insert into job_details set 
			job_id=".$job_id.",
			quote_id='".$_SESSION['edit_quote_id']."',
			site_id='".$site_id."',
			job_type_id='".$type."',
			job_type='".$job_type."',
			staff_id='0',
			job_date='".$job_date."',
			job_time='8:00 AM',
			quote_details_id='".$quotedetailsID_p."',
			amount_total='".$pest_amt."'";
			$bool = mysql_query($ins_arg);	
            recalc_job_total($job_id);			
		}
		
		//echo $ins_arg."<br>"; 
		echo edit_quote_str($_SESSION['edit_quote_id']); 
		
	}else{
		
		$desc= $varx[2]; 
		$amount= $varx[3]; 		
						
		$job_type = get_rs_value("job_type","name",$type);
		$ins_arg  = "insert into quote_details set quote_id='".$_SESSION['edit_quote_id']."',
		job_type_id=".$type.", job_type='".$job_type."', description='".$desc."', amount='".$amount."' "; 

		$ins = mysql_query($ins_arg);
		$quotedetailsID_oth = mysql_insert_id();
		
		//$jobID = get_rs_value();
		$job_id = get_sql("quote_new","booking_id","where id='".$_SESSION['edit_quote_id']."'");
		$job_date = get_sql("quote_new","booking_date","where id='".$_SESSION['edit_quote_id']."'");
		if($job_id != 0) {
			$ins_arg = "insert into job_details set 
			job_id=".$job_id.",
			quote_id='".$_SESSION['edit_quote_id']."',
			site_id='".$site_id."',
			job_type_id='".$type."',
			job_type='".$job_type."',
			staff_id='0',
			job_date='".$job_date."',
			job_time='8:00 AM',
			quote_details_id='".$quotedetailsID_oth."',
			amount_total='".$amount."'";
			$bool = mysql_query($ins_arg);	
            recalc_job_total($job_id);			
		}
		
		//echo $ins_arg."<br>"; 
		
		echo edit_quote_str($_SESSION['edit_quote_id']);
	}
	    $job_type = get_rs_value("job_type","name",$type);
	   	$description = get_sql("quote_details","description","where quote_id ='".$_SESSION['edit_quote_id']."' AND job_type_id  = ".$type."");
	   	$comment = $job_type.'='.$description;
		if($job_id != 0) {
             $heading = 'Add Job type and Description ';
             
             add_job_notes($job_id,$heading,$comment);
		}else{
		     $heading = 'Add Job type and Description ';
            add_quote_notes($_SESSION['edit_quote_id'],$heading,$comment);
		}
}

function delete_quote_details($id){
	
	$booking_id = get_rs_value("quote_new","booking_id",$_SESSION['edit_quote_id']);
	//echo $booking_id; die;
	if($booking_id=="0"){ 
	    $getQuoteDetails = mysql_fetch_array(mysql_query("select job_type , amount , description from quote_details where id=".mres($id)." and quote_id=".$_SESSION['edit_quote_id'].""));
		$bool = mysql_query("delete from quote_details where id=".mres($id)." and quote_id=".$_SESSION['edit_quote_id']."");
		
		$sql = mysql_query("SELECT  id FROM `quote_details_inventory` where quote_id = ".$_SESSION['edit_quote_id']."");
		if(mysql_num_rows($sql) > 0) {
			updatedeletedbrquote('quote_new',$_SESSION['edit_quote_id']);
			$bool1 = mysql_query("delete from quote_details_inventory where quote_id=".$_SESSION['edit_quote_id']."");
		}
		
		
		echo edit_quote_str($_SESSION['edit_quote_id']);
		
		$heading = "Deleted ".$getQuoteDetails['job_type']." Description";
		$comment = '';
		$comment .= '<strong>'.$getQuoteDetails['job_type'] .'</strong> - $'.$getQuoteDetails['amount'].'<br/>';
		$comment .= $getQuoteDetails['description'];
		add_quote_notes($_SESSION['edit_quote_id'],$heading,$comment);
		
	}else{
		echo error("Quote is Approved, cannot delete the Quote Item");
		echo edit_quote_str($_SESSION['edit_quote_id']);
	}
} 




function refresh_edit_quote_str($id){
	echo edit_quote_str($_SESSION['edit_quote_id']);	
}

function remove_job_token($job_id){
	$bool = mysql_query("update jobs set eway_token='' where id=".$job_id."");
	echo " Removed ";
}

function quote_approved($quotestr){
	$quotestrdetails = explode('|',$quotestr);
	if($quotestrdetails[1] == '2') {
		
	    $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quotestrdetails[0]).""));
	    
		 $quoteupdate = mysql_query("update quote_new set step='3',login_id =".$_SESSION['admin'].",emailed_client='".date("Y-m-d h:i:s")."' where id=".mres($quotestrdetails[0]));
		
		    $comment = "Quote admin approved success";
		    add_quote_notes($quotestrdetails[0],"Quote admin approved",$comment);
		    // Pass one para for sms msg 
                $job_id = get_rs_value("quote_new","booking_id",$quotestrdetails[0]);	
                if($job_id == "0"){ 
                  add_quote_notes($quotestrdetails[0],"Emailed Quote",'');
                }else {
                  add_job_notes($job_id,"Emailed Quote",''); 
                } 
                // echo quote_email($quotestrdetails[0],true);
			     echo $msg = '<font size="2" color="green" face="Verdana"><b> Quote Approved success </b></font>';
				 echo "<br/>";
				 email_quote($quotestrdetails[0]);
	       //echo "Quote Approved success"; 
		}else{
			echo "Quote already approved"; 
		}
    }

	
	function get_short_url($shorturl){
	  //$s_url = get_sql("short_url","short_url"," where url='".$shorturl."'");
	    $getshort_url = mysql_fetch_array(mysql_query("SELECT short_url  FROM `short_url` WHERE `url` = '".mysql_real_escape_string(trim($shorturl))."'"));
	    if($getshort_url['short_url']==""){		  
			$s_url = make_bitly_url($shorturl,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json');
			$date = date('Y-m-d');
			$ins_arg = mysql_query("INSERT INTO `short_url` (`url`, `short_url`, `createdOn`) VALUES ('".$shorturl."', '".$s_url."', '".$date."')");
			//echome($ins_arg);
			$ins = mysql_query($ins_arg);
	    }else{
			$s_url = $getshort_url['short_url'];
		}      
	  return $s_url;      
	} 

	
	function make_bitly_url($url, $login, $appkey, $format='json', $history=1, $version='2.0.1')
		{
			//create the URL
			$bitly = 'http://api.bit.ly/shorten';
			$param = 'version='.$version.'&longUrl='.urlencode($url).'&login='
				.$login.'&apiKey='.$appkey.'&format='.$format.'&history='.$history;

			//get the url
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $bitly . "?" . $param);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);

			//parse depending on desired format
			if(strtolower($format) == 'json') {
				$json = @json_decode($response,true);
				return $json['results'][$url]['shortUrl'];
			} else {
				$xml = simplexml_load_string($response);
				return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
			}
		} 
	

	function quote_incomplete($var){

	        $vars = explode('|', $var);
	
            	$quote_id = $vars[0];
				$type = $vars[1];
	   
	
		if(($quote_id!="") || ($quote_id!="0")){ 
			$quote = mysql_fetch_array(mysql_query("select * from quote_new where id=".mysql_real_escape_string($quote_id).""));
			
			if($quote['phone']!=""){
				
				if($quote['ssecret']==""){ 
					$secret = str_makerand ("15","25",true,false,true); 
					$bool = mysql_query("update quote_new set ssecret='".mres($secret)."' where id=".mres($quote_id)."");
				}else{ 
					$secret = $quote['ssecret'];
				}
				
			   $bool12 = mysql_query("update quote_new set check_sms_initial='1' where id=".mres($quote_id)."");
				$quoteid = base64_encode(base64_encode($quote_id));
				
				
				
				
				$Protocol = ($_SERVER['HTTPS'] == 'on') ? "https://" : "http://" ;
				
				/* Make short URL */
				
				$sitesphone = get_rs_value("sites","site_phone_number",$quote['site_id']);
				$siteUrl = get_rs_value("siteprefs","site_url",1);	
				$url = $siteUrl."/members/quote/index.php?action=checkkey&secret=".$secret;
				
						
				 $getQuoteUrl = mysql_fetch_array(mysql_query("select quote_id,short_url from short_url where quote_id=".mysql_real_escape_string($quote_id).""));
				
				$getURL = get_short_url($url);
				//echo 'The short URL is:  '.$short;   
			
				$link = '<a href='.$getURL.'>'.$getURL.'</a>';
	 
				$comment_msg = "Hello ".$quote['name'].", we require some more info to finish your quote, please call us on $sitesphone with Quote id $quote_id or click here to complete your quote $getURL";
				
				$comment_note = "Hello ".$quote['name'].", we require some more info to finish your quote, please call us on $sitesphone with Quote id $quote_id or click here to complete your quote  ".$link." ";
				
				if($type == 'sms') {
					$heading = "Send Incomplete SMS ".$quote['name']; 
					$sms_code = send_sms(str_replace(" ","",$quote['phone']),$comment_msg);
					if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";}
					
				}else{
					$elo = '<br/>';
					$comment_data = "Hello ".$quote['name'].$elo." We require some more info to finish your quote. ".$elo." Please call us on $sitesphone with Quote id $quote_id or click here to complete your quote $getURL";
					
					$heading = "Send Incomplete Email ".$quote['name']; 
					sendmail($quote['name'],$quote['email'],$heading,$comment_data,'bookings@bcic.com.au',$quote['site_id']);
				}
				add_quote_notes($quote_id,$heading,$comment_note);
			    echo  $heading;			
			   
			   
			}else{
				echo error("Quote Mobile number is Empty");			
			}
		}else{
			echo error("Quote If Is Missing");	
		}	
	}


    function view_quote_status_change($var) {	
	//echo $var; die;
 
    $strvalue = explode('|',$var);
	//$stepid = get_sql("quote_new","step","where id=".$strvalue[1]);
	$quotedetails = mysql_fetch_assoc(mysql_query("Select step , login_id from quote_new where id=".$strvalue[1]));
	
	//print_r($quotedetails); die;	
	
		$stepid = $quotedetails['step'];
		$getid = $strvalue[0];
		
		$name = getSystemvalueByID($getid,31);
		$stepname = getSystemvalueByID($stepid,31);
		$heading = "Quote Step change ".$stepname." to ".$name."";
		add_quote_notes($strvalue[1],$heading,$heading);
		
		 if($getid == 6 || $getid == 5 || $getid == 7)
		{
			$bool = mysql_query("update quote_new set step='".$strvalue[0]."'  , denied_id = 0 where id=".mres($strvalue[1])."");
		}
		else
		{
			$bool = mysql_query("update quote_new set step='".$strvalue[0]."', denied_id = 0  where id=".mres($strvalue[1])."");
		} 
		
		/*  if($stepid == 6)
		{
			$bool = mysql_query("update quote_new set step='".$strvalue[0]."' , deleted = 0  where id=".mres($strvalue[1])."");
		} */
		
			if($quotedetails['login_id'] == 0) {
				
				$bool = mysql_query("update quote_new set login_id='".$_SESSION['admin']."' where id=".mres($strvalue[1])."");
			}
			
			
		
	// echo '1_0';
	  //echo $strvalue[0];
	    if($strvalue[2] == 2) {
	      include('view_slot_list.php');	
	    }elseif($strvalue[2] == 3) {
	      include('view_sales_system.php');	
	    }else{
			include('view_quote.php');
		 
		}
	// exit;
	
    }

	function view_quote_response($var) {
	   
		 $strvalue = explode('|',$var); 
		
		$getResponse = mysql_fetch_assoc(mysql_query('SELECT name FROM `system_dd` where type = 33 AND  id ='.mysql_real_escape_string($strvalue[0])));
		
		 $quoteName = get_rs_value("quote_new","name",$strvalue[1]);
		 
			if($getResponse['name'] != '') {
			    $type = $getResponse['name'];
			}else {
				$type = 'Defult';
			}
			
		$heading = "Quote response type ".$type;
		$comment = "Quote of ".$quoteName." response type ".$type;
		add_quote_notes($strvalue[1],$heading,$comment);
		$bool = mysql_query("update quote_new set response='".$strvalue[0]."' where id=".mres($strvalue[1])."");
	    echo $strvalue[0];
		 
	}

	function view_quote_pending($var) {
	   $strvalue = explode('|',$var); 
		  $getpending = mysql_fetch_assoc(mysql_query('SELECT name FROM `system_dd` where type = 34 AND  id ='.mysql_real_escape_string($strvalue[0])));
		 
		  $quoteName = get_rs_value("quote_new","name",$strvalue[1]);
			if($getpending['name'] != '') {
			   $type = $getpending['name'];
			   $heading = "Quote is pending due to ".$type;
			   $comment = "Quote is pending due to ".$type;
			}else {
			  $type = 'Defult';
			  $heading = "Quote  pending status set to defult";
			  $comment = "Quote  pending status set to defult";
			}
			 
			  add_quote_notes($strvalue[1],$heading,$comment);
			 $bool = mysql_query("update quote_new set pending='".$strvalue[0]."' where id=".mres($strvalue[1])."");
			 echo $strvalue[0];
	}

function delete_journal($str){
	     ;
	$getjournalDetails = mysql_fetch_assoc(mysql_query('SELECT * FROM `staff_journal_new` where id ='.mysql_real_escape_string($str)));
	
	if(!empty($getjournalDetails)) {
		
        $insert = mysql_query("INSERT INTO`staff_journal_new_delete`(`id`,`staff_id`,`job_id`,`client_name`,`job_date`,`journal_date`,`total_amount`, `bcic_rec`, `staff_rec`, `bcic_share`, `staff_share`, `comments`, `job_details_id`) VALUES ('".$getjournalDetails['id']."', '".$getjournalDetails['staff_id']."', '".$getjournalDetails['job_id']."', '".$getjournalDetails['client_name']."', '".$getjournalDetails['job_date']."', '".$getjournalDetails['journal_date']."', '".$getjournalDetails['total_amount']."', '".$getjournalDetails['bcic_rec']."', '".$getjournalDetails['staff_rec']."', '".$getjournalDetails['bcic_share']."', '".$getjournalDetails['staff_share']."', '".$getjournalDetails['comments']."', '".$getjournalDetails['job_details_id']."')");  
		 
		$delete =  mysql_query("DELETE FROM `staff_journal_new` WHERE `staff_journal_new`.`id` =".mysql_real_escape_string($str));
		 
		if( mysql_num_rows(mysql_query('SELECT * FROM `staff_journal_new` where id ='.mysql_real_escape_string($str))) > 0 )
		{
			//issue
			echo "1";
			exit;
		}
		else
		{
			//success
			echo "0";
			exit;
		}
	}
}

function notification_data($str)
{  
   // include('../includes/header.php');
    include('notification.php');
}

function urgent_notification_data($str)
{  
   // include('../includes/header.php');
    include('urgent_staff_notification.php');
}

function quote_details_show($str)
{
    $strvar = explode('|',$str);
	
	$notification_read_user = get_sql("site_notifications","notification_read_user","where id=".$strvar[0]);
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$r_msg = '';
	
	$currentDate = date('Y-m-d H:i:s');
	//Nitish_(2017-07-07 18:48:00)_(2017-07-07 18:48:04),Nitish_(2017-07-07 18:48:04)
	if($notification_read_user != '') { $r_msg = $notification_read_user.','; }
    $messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
    
    $qryBool = mysql_query( "UPDATE site_notifications SET notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = {$strvar[0]}" );
	
	$updateData = mysql_fetch_array(mysql_query( "select notifications_status from site_notifications WHERE id = {$strvar[0]}" ));
	
	echo $updateData['notifications_status']; exit;	
}

function memberdetailsShow($str)
{
   
	$notification_read_user = get_sql("site_notifications","notification_read_user","where id=".$str);
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$r_msg = '';
	
	$currentDate = date('Y-m-d H:i:s');
	//Nitish_(2017-07-07 18:48:00)_(2017-07-07 18:48:04),Nitish_(2017-07-07 18:48:04)
	if($notification_read_user != '') { $r_msg = $notification_read_user.','; }
    $messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
    
    $qryBool = mysql_query( "UPDATE site_notifications SET notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = {$str}" );
	
	$updateData = mysql_fetch_array(mysql_query( "select notifications_status from site_notifications WHERE id = {$str}" ));
	
	echo $updateData['notifications_status']; exit;	
}


function refress_notification($str){
       include('notification.php');
} 

function refress_urgent_notification($str){
       include('urgent_staff_notification.php');
} 

/*
	
	@params : @notification_id | @staff_id (who sent the notification
	@return : include the file in whiich we will get all urgent notification where didn't marked 1.

*/
function refreshNotificationAfterDeleteMarked($str)
{
			
	$getnotidata = mysql_fetch_array(mysql_query( "select * from site_notifications WHERE id = {$str}" ));	
	
	$notification_read_user = $getnotidata['notification_read_user'];
	$job_id = $getnotidata['job_id'];
	$comment = $getnotidata['heading'];
	
	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	$r_msg = '';
	
	$currentDate = date('Y-m-d H:i:s');
	//Nitish_(2017-07-07 18:48:00)_(2017-07-07 18:48:04),Nitish_(2017-07-07 18:48:04)
	
	if($notification_read_user != '') { $r_msg = $notification_read_user.','; }
    $messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
    
    $qryBool = mysql_query( "UPDATE site_notifications SET 
	notifications_status = 1,notification_read_user = '".$messageRead."' , task_complete_date = '".$currentDate."' WHERE id = {$str}" );
	
	if($job_id != 0) {
		$heading_data = 'Read notification by '.$staff_name;
	    add_job_notes($job_id,$heading_data,$comment);
	}	
	
	$getdatainf=  GetAlownotification();

    $str1 = '5,6 ';
	if(in_array($_SESSION['admin'] , $getdatainf)) {
     $str1 = '5,6,7 ,8';
    }
	$staff_notification= "select id from site_notifications where notifications_status = '0'  AND notifications_type IN (".$str1.") ORDER BY id desc "; 
	

	$staff_notificationText = mysql_query($staff_notification);

	$staffcountnotef = mysql_num_rows($staff_notificationText);
	
	echo $staffcountnotef;
    //include('urgent_staff_notification.php');
} 


function refress_main_headr(){
    
    $notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (0,2,3,4) "); 
    $getnotification = mysql_query($notification);
    
                 $countnotef = mysql_num_rows($getnotification);
				 
					if($countnotef > 0){
						 $n_count = $countnotef;
						 $flag = 1;
					}else{
						 $n_count = '';
					}
                   
        $str =  ' <a href="#"><img class="bd_notifi" src="../admin/images/noti.png" alt="Notification">';
		
            if($flag == 1) {
                $str .=   "<span class='bd_notification'>".$countnotef."</span>";
            }
   
    $str .= 'Notification </a>';
    echo $str;
} 

function urgentNotirefress(){
	   
				$str1 = '5,6';
				if(in_array($_SESSION['admin'] , array(1,3))) {
				 $str1 = '5,6,7';
				}
	
                $notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (".$str1.") "); 
      $getnotification = mysql_query($notification);
    
                 $countnotef = mysql_num_rows($getnotification);
                 if($countnotef > 0){
                     $n_count = $countnotef;
                     $flag = 1;
                 }else{
                     $n_count = '';
                 }
                   
        $str =  ' <a href="#"><img class="bd_notifi" src="../admin/images/noti.png" alt="Notification">';
                 if($flag == 1) {
        $str .=   "<span class='bd_notification' style='background:#f54040;' >".$countnotef."</span>";
   }
    $str .= 'Urgent Notification </a>';
   echo $str;
} 

function refress_notification_icone(){
     $notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (0,2,3,4)"); 
	 
    $notificationText = mysql_query($notification);
    
      $countnotef = mysql_num_rows($notificationText);
      echo $countnotef;
}

function asc_order_notification($str){    
    $_SESSION['order_by'] = $str;
    include('notification.php');
}

    //Dispatch Report date Searching
	function dispatch_report_from_date($str){
		
		$var = explode('|',$str);
		 
		if($var[0] != 0 && $var[0] != '') {
			$_SESSION['daily_dispatch']['quote_type']=$var[0];
		}else{
			unset($_SESSION['daily_dispatch']['quote_type']);
		}
		
		if($var[1] != 0 && $var[1] != '') {
			$_SESSION['daily_dispatch']['report_from_date']=$var[1];
		}else{
			unset($_SESSION['daily_dispatch']['report_from_date']);
		}
		
		if($var[2] != 0 && $var[2] != '') {
			$_SESSION['daily_dispatch']['to_date']=$var[2];
		}else{
			unset($_SESSION['daily_dispatch']['to_date']);
		}
		
		if($var[3] != 0 && $var[3] != '') {
			$_SESSION['daily_dispatch']['called_type']=$var[3];
		}else{
			unset($_SESSION['daily_dispatch']['called_type']);
		}
		
		if($var[4] != 0 && $var[4] != '') {
			$_SESSION['daily_dispatch']['status']=$var[4];
		}else{
			unset($_SESSION['daily_dispatch']['status']);
		}
		
		if($var[5] != 0 && $var[5] != '') {
			$_SESSION['daily_dispatch']['site_id']=$var[5];
		}else{
			unset($_SESSION['daily_dispatch']['site_id']);
		}
		
		if($var[6] != 0 && $var[6] != '') {
			$_SESSION['daily_dispatch']['team_id']=$var[6];
		}else{
			unset($_SESSION['daily_dispatch']['team_id']);
		}
		 
		 include("dispatch_report.php");
		
	}

//Dispatch Report date Searching
function dispatch_report_to_date($to_date){
	$_SESSION['dispatch']['to_date']=$to_date;
        include("dispatch_report.php");
}

//Dispatch Report date Searching
function dispatch_report_team_id($teamid){
	$_SESSION['dispatch']['team_id']=$teamid;
        include("dispatch_report.php");
}



function dispatch_report_quote_type($quote_type){
	$_SESSION['dispatch_1']['quote_type']=$quote_type;
        include("dispatch_report.php");
}

//Dispatch Report date Searching
function called_type_report($called_type){
	unset($_SESSION['dispatch']['called_type']);
	$_SESSION['dispatch']['called_type']=$called_type;
        include("dispatch_report.php");
}
// Call Records
function get_call_records($var){
	 $_SESSION['call']['admin']= $var;
	include("view_import.php");
}

function get_call_records_by_fromdate($var){
	 $_SESSION['call']['from_date']= $var;
	include("view_import.php");
}
function get_call_records_by_todate($var){
	  $_SESSION['call']['to_date']= $var; 
	include("view_import.php");
}

function get_call_records_by_Quote_job($var){
	  $_SESSION['call']['quote_job_id']= $var; 
	include("view_import.php");
}
function get_call_records_reset($var){
	//echo $var; die;
	  unset($_SESSION['call']['admin']); 
	  unset($_SESSION['call']['from_date']); 
	  unset($_SESSION['call']['to_date']); 
	  unset($_SESSION['call']['quote_job_id']); 
	include("view_import.php");
}

function dispatch_report_by_location($var){
    if($var != 0) {
      $_SESSION['dispatch_1']['site_id'] = $var; 
    }else {
        $_SESSION['dispatch_1']['site_id'] = ''; 
    }
	include("dispatch_report.php");
}



function jobStatuscheck_dispatchReport($var){
    if($var != '') {
      $_SESSION['dispatch']['status'] = $var; 
    }else {
        unset($_SESSION['dispatch']['status']); 
    }
	include("dispatch_report.php");
}

 

function reset_dispatchreport($var){
	//echo $var; die; 
	  $_SESSION['daily_dispatch']['report_from_date'] = date('Y-m-d',strtotime('yesterday'));
	  $_SESSION['daily_dispatch']['to_date'] = date('Y-m-d',strtotime('yesterday'));
	  unset($_SESSION['daily_dispatch']['site_id']); 
	  unset($_SESSION['daily_dispatch']['quote_type']); 
	  unset($_SESSION['daily_dispatch']['status']); 
	  unset($_SESSION['daily_dispatch']['called_type']); 
	  unset($_SESSION['daily_dispatch']['team_id']); 
	  include("dispatch_report.php");
}


 function check_dispatch_report_sms($str){
    //echo $str; die;
	$var = explode('|',$str);
	   
			/* job_notification_status
			job_notification_date
			address_sms
			address_sms_date */
	   
	     if($var[2] == 1){
		   $checkSms = 'UnChecked';
		   $checkvalue = 0;
		   $checkdate = '0000-00-00 00:00:00';
	   }else{
		   $checkSms = 'Checked';
		   $checkvalue = 1;
		   $checkdate = date('Y-m-d h:i:s');
	   }
	   
	   $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		if($var[0] == 'job'){
			$sms_type = 'job_sms';
			$sms_type_date = 'job_sms_date';
			
			$notification_date = 'job_notification_date';
			$notification_status = 'job_notification_status';
			$heading = $checkSms.' Job SMS By '.$staff_name;
		}else {
			$sms_type = 'address_sms';
			$sms_type_date = 'address_sms_date';
			
			$notification_date = 'add_notification_date';
			$notification_status = 'add_notification_status';
			
			$heading = $checkSms.' Address SMS By '.$staff_name;
		}
            
	$job_details = mysql_fetch_array(mysql_query("select * from job_details where id=".$var[1]));

	if($job_details['staff_id']!="0"){	
	   	// echo "<pre>"; print_r($job_details); die;
	     $jobID = $job_details['job_id'];
	   //die;
	    add_job_notes($jobID,$heading,"");
	    mysql_query("update job_details set $sms_type ='".$checkvalue."' , $sms_type_date ='".$checkdate."' , $notification_date ='".$checkdate."' , $notification_status ='".$checkvalue."'   where id=".$var[1]."");
       
	}else{
	    echo "Please select staff";
	}
	 include('dispatch_report.php');
} 


 function check_reclean_report_sms($str){
    //echo $str; die;
	$var = explode('|',$str);
	   
	     if($var[2] == 1){
		   $checkSms = 'UnChecked';
		   $checkvalue = 0;
		   $checkdate = '0000-00-00 00:00:00';
	   }else{
		   $checkSms = 'Checked';
		   $checkvalue = 1;
		   $checkdate = date('Y-m-d h:i:s');
	   }
	   
	   $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		if($var[0] == 'job'){
			$sms_type = 'job_sms';
			$sms_type_date = 'job_sms_date';
			$heading = $checkSms.' Job SMS By '.$staff_name;
		}else {
			$sms_type = 'address_sms';
			$sms_type_date = 'address_sms_date';
			$heading = $checkSms.' Address SMS By '.$staff_name;
		}
            
	$job_reclean = mysql_fetch_array(mysql_query("select * from job_reclean where id=".$var[1]));

	if($job_reclean['staff_id']!="0"){	
	   	// echo "<pre>"; print_r($job_details); die;
	     $jobID = $job_reclean['job_id'];
	   //die;
	    add_job_notes($jobID,$heading,"");
	    mysql_query("update job_reclean set $sms_type ='".$checkvalue."' ,$sms_type_date ='".$checkdate."' where id=".$var[1]."");
       
	}else{
	    echo "Please select staff";
	}
	 include('reclean_report.php');
} 

function import_edit_quote($str){
    //echo $str; die;
	//4111|2|quote_id
	$var  = explode('|', $str);
    //print_r($var); die;
	if($var[2] == 'quote_id'){
	  $status_col = 'quote_status';
	}elseif($var[2] == 'job_id'){
	  $status_col = 'job_status';
	}elseif($var[2] == 'comments'){
	  $status_col = 'comment_status';
	}
 	mysql_query("UPDATE c3cx_calls SET $var[2] = '".$var[0]."', $status_col = '1'  WHERE id = {$var[1]}" ); 
	echo $var[0];
   
}
function delete_call_import($str){
	$getrecord = mysql_fetch_assoc(mysql_query( "select phone_id,approved_status from c3cx_calls WHERE id = {$str}" ));
	//print_r($getrecord); die;
	$approved_status = $getrecord['approved_status'];
	 if($approved_status == 0) {
		$status = 1;
	}else {
		$status = 0;
	}
	 $done = mysql_query("update  `c3cx_calls` set approved_status = ".$status." where id = ".$str);
	// die;
	echo $status; 
	
}

    function delete_call_allimportfiles($str){	
		$filename = get_rs_value("c3cx_imports","org_file_name",$str);
	    $delete_quote_notes = mysql_query("delete from `quote_notes` where 3cx_upload_id = ".$str);
	    $delete_job_notes = mysql_query("delete from `job_notes` where 3cx_upload_id = ".$str);
	    $delete_calls_details = mysql_query("delete from `c3cx_calls_details` where import_id = ".$str);
		$delete_c3cx_phone = mysql_query("delete from `c3cx_phone` where import_id = ".$str);
		$delete_c3cx_phone = mysql_query("delete from `c3cx_calls` where import_id = ".$str);
		$delete_c3cx_imports = mysql_query("delete from `c3cx_imports` where id = ".$str);
		echo "<p style='text-align:center;color: #f92626;margin: 7px;font-size: 17px;'>".$filename." file has been deleted successfully </p>";
	    include('delete_import.php');
    } 
	
	function delete_call_allimportfilesByid($str){	
		 $filename = get_rs_value("c3cx_imports","org_file_name",$str);
	    $delete_quote_notes = mysql_query("delete from `quote_notes` where 3cx_upload_id = ".$str);
	    $delete_job_notes = mysql_query("delete from `job_notes` where 3cx_upload_id = ".$str);
	    $delete_calls_details = mysql_query("delete from `c3cx_calls_details` where import_id = ".$str);
		$delete_c3cx_phone = mysql_query("delete from `c3cx_phone` where import_id = ".$str);
		$delete_c3cx_phone = mysql_query("delete from `c3cx_calls` where import_id = ".$str);
		$delete_c3cx_imports = mysql_query("delete from `c3cx_imports` where id = ".$str); 
		
    } 

	
	function get_call_recordsByID($str){
		 if($str == 0){
			  $_SESSION['call']['import_id'] = ''; 
		 }else{
			 $_SESSION['call']['import_id'] = $str; 
		 }
		  include("delete_import.php");
		 //echo $str;
	} 
	
	function get_staff_joblist($var){
		//echo $var;
		$_SESSION['staff']['staff_job_date'] = $var;
		include("../../staff/xjax/_job_list.php");
	}
	
	
	function get_staff_name($var){
	    
	    $string = explode('|',$var);
	    
	    $str = $string[0];
	    $str1 = $string[1];
	    
        	$data = mysql_query("select * from staff where name like '%".mysql_real_escape_string($str)."%' or id like '%".mysql_real_escape_string($str)."%'");
        	$strx = "<ul class=\"post_list\">";
        	while($r=mysql_fetch_assoc($data)){
        		$strx.="<li><a href=\"javascript:select_staffname('".$r['id']."','".$r['name']."','".$str1."')\">".$r['name']."</a></li>";
        	}	
        	$strx.="</ul>";
        	echo $strx;
	}
	
	function update_staffname($str){
	    
	    $var = explode('|',$str);
	     mysql_query("update c3cx_calls set staff_id ='".$var[0]."' where id=".$var[1]."");
	}
	
	function address_save($str){
	    	$varx = explode("|",$str);
	$value = $varx[0];
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	//print_r($varx); die;
	
	 $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
	 $details_data =mysql_query("select * from quote_new where id=".mysql_real_escape_string($id)."");
		$details =  mysql_fetch_array($details_data);
	   echo  $details['name']."<br>".$details['address']."<br>".$details['phone'];
	   // echo $str; die;
	}
	
	
	function job_read_notification($str){
	   // echo  $str; die;
	    $var = explode('|',$str);
	    $jobid = $var[0];
	    $staffid = $var[1];
	    $result = mysql_query("update job_details set staff_assign_notification='1'  where job_id='".$jobid."' AND staff_id = '".$staffid."'");
	    
	    $getNotificationdetails =   mysql_query("SELECT * from `job_details` WHERE `staff_id` = '".$_SESSION['staff']['staff_id']."' AND job_date >= '".date('Y-m-d')."' AND status != '2' and staff_assign_notification = '0' and job_acc_deny in (0,1) GROUP By job_id ORDER BY staff_assign_date desc "); 
		$counterresult = mysql_num_rows($getNotificationdetails); 
		echo $counterresult;
		exit();
	    
	}
	
	function recheckimportFile($str) {
	    $importID = $str;
	    $getallnotIdentify = mysql_query("SELECT * FROM `c3cx_calls` WHERE import_id = '".$importID."' AND ( job_id = '' AND quote_id = '' ) AND (staff_id = 0 OR staff_id = '') AND approved_status = 0");
	   // echo  $str; die;
	   while($getResult = mysql_fetch_array($getallnotIdentify)) {
	          $VoipCall = new VoipCall();
	         echo  $VoipCall->recheckListOfUnidentifyNum($getResult);
	   }
	   //die;
	   $chkStatus = 1;
	   include('delete_import.php');
	}
	
	function adminrecheckimportFile($str) {
	    $admiimportID = $str;
	    $getalladmin = mysql_query("SELECT * FROM `c3cx_calls` WHERE import_id = '".$admiimportID."' And  admin_id = 0");
	  //  echo  $str; die;
	   //echo mysql_num_rows($getalladmin); die;
	   while($getResult = mysql_fetch_array($getalladmin)) {
	          $VoipCall = new VoipCall();
	          $VoipCall->recheckListOfUnidentifyNumadmin($getResult);
	   }
	  // die;
	   $adminchkStatus = 1;
	   include('delete_import.php');
	}
	
	
	
	// Quote Report System 
	
	function quote_report_by_location($var){
		if($var != 0) {
		  $_SESSION['quote']['site_id'] = $var; 
		}else {
			unset($_SESSION['quote']['site_id']); 
		}
		include("view_daily_report_quote.php");
    }
	
	function quote_report_by_date($var){
		if($var != 0) {
		  $_SESSION['quote']['date'] = $var; 
		}else {
			unset($_SESSION['dispatch']['date']); 
		}
		include("view_daily_report_quote.php");
    }
	
	function quote_report_status($var){
		if($var != '') {
			  if($var == '0') {	
			   $_SESSION['quote']['status'] = $var; 
			  }elseif($var == '1') {	{
				$_SESSION['quote']['status'] = $var;
			  }
			}else {
				unset($_SESSION['quote']['status']); 
			}
		}
		include("view_daily_report_quote.php");
    }
	
	function quote_report_reset($var){
		unset($_SESSION['quote']['date']);
		unset($_SESSION['quote']['site_id']);
		include("view_daily_report_quote.php");
    }
	
	function booking_report_by_location($var){
		if($var != 0) {
		  $_SESSION['booking']['site_id'] = $var; 
		}else {
			unset($_SESSION['booking']['site_id']); 
		}
		include("view_daily_quote_booking.php");
    }

	function booking_report_by_date($var){
		if($var != 0) {
		  $_SESSION['booking']['date'] = $var; 
		}else {
			unset($_SESSION['booking']['date']); 
		}
		include("view_daily_quote_booking.php");
    }
	
	function booking_report_reset($var){
		unset($_SESSION['booking']['date']);
		unset($_SESSION['booking']['site_id']);
		include("view_daily_quote_booking.php");
    }
	
	
	function call_report_by_date($var){
		//echo $var; die;
		if($var != '') {
		  $_SESSION['call_report']['date'] = $var; 
		}else {
			unset($_SESSION['call_report']['date']); 
		}
		include("view_call_report_system.php");
    }

	function call_report_by_admin($var){
	   //echo $var; die;
		if($var != 0) {
		  $_SESSION['call_report']['admin_id'] = $var; 
		}else {
			unset($_SESSION['call_report']['admin_id']); 
		}
		include("view_call_report_system.php");
    }
	function get_from_to_callreport($var){
	   unset($_SESSION['call_report']['from_to']); 
		if($var != 0) {	
		  $_SESSION['call_report']['from_to'] = $var; 

		}else {
			unset($_SESSION['call_report']['from_to']); 
		}
		include("view_call_report_system.php");
    }
	
	
	function reset_callreportsystem($var){
	     unset($_SESSION['call_report']['date']);
		unset($_SESSION['call_report']['from_to']);
		unset($_SESSION['call_report']['admin_id']);
		include("view_call_report_system.php");
    }
	
	function call_report_dashboard($var){
		
		$varx = explode("|",$var);
		$type = $varx[0];
		$value= $varx[1];
		$_SESSION['call_report_dashboard'][$type] = $value; 
		include("call_report_dashboard.php");
    }
	function reset_report_dashboard($var){
		//echo $var; die;
		$varx = explode("|",$var);
		$type1 = $varx[0];
		$value= $varx[1];
	     unset($_SESSION['call_report_dashboard']);
		include("call_report_dashboard.php");
    }
	
	function quote_report_dashboard($var){
		$varx = explode("|",$var);
		$type = $varx[0];
		$value= $varx[1];
		$_SESSION['quote_report_dashboard'][$type] = $value; 
		include("quote_dashboard.php");
    } 
	
	
	
	function reset_quote_report_dashboard($var){
		//echo $var; die;
		$varx = explode("|",$var);
		$type1 = $varx[0];
		$value= $varx[1];
	     unset($_SESSION['quote_report_dashboard']);
		include("quote_dashboard.php");
    }
	
	//Update description in quote note
	function update_edit_desc($var){
		
		$vars = explode('|',$var);
		
		//print_r($vars); die;
		$quote_id = $vars[0];
		
		$qdetails = mysql_query("select * from quote_details where quote_id=".$quote_id." AND status != 2");
		while($r = mysql_fetch_assoc($qdetails)){ 
			
			$bool = mysql_query("update quote_details set description ='".$r['description']."' where id=".$r['id']);
			
		$comment .= '<strong>'.$r['job_type'].' - </strong> $'.$r['amount'].'</br>'.$r['description'].'<br/>===================<br/>';
		}
		
		$heading = 'Job type Description ';
		add_quote_notes($quote_id,$heading,$comment);
		echo  "<p style='font-size: 14px;padding: 8px;color: green;'>Description update successfully</p>";	
	}
	
	function quote_with_status($var){
		$varx = explode("|",$var);
		$type = $varx[0];
		$value= $varx[1];
		$_SESSION['quote_with_status'][$type] = $value; 
		include("quote_with_status.php");
	}
	function reset_quote_with_status($var){
		//echo $var; die;
		unset($_SESSION['quote_with_status']);
		include("quote_with_status.php");
    }
	
	function send_reclen_email($var){
      
        $varStr = explode('|',$var);	  
 	    $job_id = $varStr[0];
 	    $reCleanID = $varStr[1];
 	    $action = $varStr[2];
		
		$recleanString = "re_clean|".$reCleanID."";
		
		if ($action=="reclean_email_client"){ 
			 add_job_notes($job_id,"Sent Booking Confirmation Email For Re-clean","");
			send_email_conf($job_id,$recleanString);
			$bool = mysql_query("update reclean_date set email_date='".date("Y-m-d h:i:s")."', email = 1 where id=".$reCleanID."");
			echo date("d M Y h:i:s"); 
		}
	}
	
	function reclean_reportby_date($var){
		$_SESSION['reclean']['reclean_from_date'] = $var; 
		include("reclean_report.php");
    }
	
	function reclean_reportby_Site($var){
		if($var != '0') {
		  $_SESSION['reclean']['site_id'] = $var; 
		}else{
		 unset($_SESSION['reclean']['site_id']); 
		}
		include("reclean_report.php");
    }
	
	function reclean_reportby_to($var){
		$_SESSION['reclean']['to_date'] = $var; 
		include("reclean_report.php");
    }
    
   	function reclean_reportby_status($var){
		$_SESSION['reclean']['status'] = $var; 
		include("reclean_report.php");
    }
	
	function reclean_reset($var){
		unset($_SESSION['reclean']); 
		include("reclean_report.php");
    }
	
	function clearSessionOnDemand( $var = null )
	{
		session_destroy();
	}
	function gethourlyreportbydate($var){
	    $_SESSION['hourly_quote']['quote_date'] = $var; 
		include("quote_hourly_report.php");
	}
	function gethourlyreportBySite($var){
	    $_SESSION['hourly_quote']['site_id'] = $var; 
		include("quote_hourly_report.php");
	}
	
    function gethourlyreporttodate($var){
	    $_SESSION['hourly_quote']['to_date'] = $var; 
		include("quote_hourly_report.php");
	}
	
	
	function reset_hourlyreport($var){
	    unset($_SESSION['hourly_quote']); 
		include("quote_hourly_report.php");
	}
	
	
	 function edit_app_status($var){
	    
	    $varx = explode("__",$var);
	    $id = $varx[0];
	    $comm = $varx[1];
	    
	   // echo "update staff_applications set step_status =6 , denied_res = '".$comm."' where id=".$id.""; 
	    
	    $bool = mysql_query("update staff_applications set step_status =6 , denied_res = '".$comm."' where id=".$id."");
	    $heading = 'App Status Denied or Reason ( '.$comm.')';
	    add_application_notes($id, $heading,$heading ,'','','', 0);
	    echo '6';
	 }
	
	
	
	
	function edit_fields_applications($var){
	
		//echo $var; die;
		//dfdfdfdf|staff_applications.suitable_unsuitable_reason|18
		
		$varx = explode("|",$var);
		$value = $varx[0];
		$fieldx= explode(".",$varx[1]);
		$table = $fieldx[0];
		$field = $fieldx[1];
		$id=$varx[2];
		$siteid=$varx[3];
		
		//echo $id;
		
		if($id != '') {
			   $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
			
		    	$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		      	//echo $field; 
            	  if($varx[1] == 'staff_applications.application_reference')	{
            	        $astatus =  getSystemvalueByID($value, 56);
            			$heading = $staff_name.'  Change Reference in '.$astatus;
            	  }else if($varx[1] == 'staff_applications.step_status')	{
            	        $astatusstatus =  getSystemvalueByID($value, 55);
            			$heading = $staff_name.' Change App Status in '.$astatusstatus;
            	  }else if($varx[1] == 'staff_applications.response_status')	{
            	        $astatus_re_status =  getSystemvalueByID($value, 71);
            			$heading = $staff_name.' Change Resp Status in '.$astatus_re_status;
            	  }else if($varx[1] == 'staff_applications.sutab_unsutab')	{
            	        $astatus_re_status =  getSystemvalueByID($value, 38);
            			$heading = $staff_name.' Change S/US Status in '.$astatus_re_status;
            	  }else if($varx[1] == 'staff_applications.admin_id')	{
            	      
            	        // $adminname = get_rs_value("admin","name",$_SESSION['admin']);
            	         $assignto = get_rs_value("admin","name",$value);
            	         
            	        //$astatus_re_status =  getSystemvalueByID($value, 38);
            			$heading = $staff_name.' Assign to  '.$assignto;
            	  }
            	// echo  'rererererere ' .$heading;   die;
            	  
            		add_application_notes($id, $heading,$heading ,'','','', 0);
		
		}
			
		 echo trim($value);
    }
	
	function theme_change($var){
		$vars = explode('|',$var);
		$bool = mysql_query("update admin set theme_id ='".$vars[0]."' where id=".$vars[1]."");
		echo $vars[0];
	}
	
	function gethourlyReport($var){
		$vars = explode('|',$var);
		$type = $vars[0];
		$value = $vars[1];
		
	    $_SESSION['call_hourly_report'][$type] = $value; 
		include("call_hourly_reports.php");
    }
	
	function reset_call_hourly_report($str){
		//echo $str; die;
		unset($_SESSION['call_hourly_report']);
		include("call_hourly_reports.php");
	}
	
	function view_quote_advance_searching($var){
		 
		unset($_SESSION['view_quote_field']); 
		$vars = explode('|',$var);
		
		//print_r($vars);  die;
		
		foreach($vars as $key=>$value) {
			 $allvar = explode('__',$value);
			//print_r($allvar);
			if($allvar[0] != '' && $allvar[0] != '0') {
			  $_SESSION['view_quote_aSearching'][$allvar[1]] = $allvar[0]; 
			}else {
				unset($_SESSION['view_quote_aSearching'][$allvar[1]]);
			} 
		} 
		//print_r($_SESSION['view_quote_aSearching']);
		
			 if($vars[16] == 1) {
				include("view_quote.php");
			 }elseif($vars[16] == 2){
				 include("staff_view_quote.php");
			 }
	}
	
	function search_job_reports($var){
		 
		unset($_SESSION['job_report']); 
		$vars = explode('|',$var);
		foreach($vars as $key=>$value) {
			 $allvar = explode('__',$value);
			//print_r($allvar);
			if($allvar[0] != '' && $allvar[0] != '0') {
			  $_SESSION['job_report'][$allvar[1]] = $allvar[0]; 
			}else {
				unset($_SESSION['job_report'][$allvar[1]]);
			} 
		} 
		include("view_job_reports.php");
	}
	
	function advance_searching_reset($var){
		
	    unset($_SESSION['view_quote_aSearching']);
		
		//echo $var; die;
		
		if($var == 1) {
	      include("view_quote.php");
		}elseif($var == 2){
		  include("staff_view_quote.php");	
		}
	}
	
	function staff_reatting_update($str){
		 $vars = explode('|',$str); 
		 $sql = mysql_query("UPDATE `staff` SET `staff_member_rating` = '".$vars[0]."' WHERE `staff`.`id` = ".$vars[1]);
		 include("dispatch.php");
	}
	
	function checkquoteBookStatus($str){
		// Type 1=> For Red 2=> Green
		//parameter ** SiteID|date|type
     //echo $str; die;
		$vars = explode('|',$str);
		$date = date('Y-m-d',$vars[1]);
		
			if($vars[2] == 2) {
				$strSql = ("Delete from quote_checkBy_site_date where site_id = '".$vars[0]."' AND date = '".$date."'");
				$str = 'green';
			}else if($vars[2] == 1) {
				$strSql =  ("INSERT INTO `quote_checkBy_site_date` (`site_id`, `date`) VALUES ('".$vars[0]."', '".$date."')");
				$str = 'red';
			}
			mysql_query($strSql);
			//echo $vars[1]; die;
			//$gettool = getQuoteBookedByDate($vars[1]);
			//echo $gettool['tool_outer'];
			if($vars[3] == 'dispatch') {
			  include("dispatch.php");
			}else{
				$site_id = $vars[0];
				$booking_date = date('Y-m-d',$vars[1]);
			   include("check_avail.php");	
			}
	}
	
	
	function checkquotebooked($str){
		$vars = explode('|',$str);
		$checkStatus = mysql_fetch_array(mysql_query("Select count(id) as countResult from quote_checkBy_site_date where site_id = '".$vars[0]."' AND date = '".$vars[1]."'"));
		
		if($checkStatus['countResult'] > 0) {
			echo "1";
		}else{
			echo "0";
		}
	}
	
	function editcheckbooked($str){
		$vars = explode('|',$str);
		$checkStatus = mysql_fetch_array(mysql_query("Select count(id) as countResult from quote_checkBy_site_date where site_id = '".$vars[0]."' AND date = '".$vars[1]."'"));
		
		if($checkStatus['countResult'] > 0) {
			echo "1";
		}else{
			echo "0";
		}
		
	}
	
	function searching_job_unassigned($var){
		 
		unset($_SESSION['view_unassigned']); 
		$vars = explode('|',$var);
		foreach($vars as $key=>$value) {
			 $allvar = explode('__',$value);
			//print_r($allvar);
			if($allvar[0] != '' && $allvar[0] != '0') {
			  $_SESSION['view_unassigned'][$allvar[1]] = $allvar[0]; 
			}else {
				unset($_SESSION['view_unassigned'][$allvar[1]]);
			} 
		} 
		//print_r($_SESSION['view_quote_aSearching']);
		include("job_unassinged.php");
	}
	 
	function unassigned_reset($var){
	    unset($_SESSION['view_unassigned']);
	    include("job_unassinged.php");
	}
	
	function advance_search_payment_report($var){
		
		//echo  $str;
		//$vars = explode('__',$str);
		unset($_SESSION['payment_report']); 
		$vars = explode('|',$var);
		
		//print_r($vars);
		
		foreach($vars as $key=>$value) {
			 $allvar = explode('__',$value);
			//print_r($allvar);
			if($allvar[0] != '' && $allvar[0] != '0') {
			  $_SESSION['payment_report'][$allvar[1]] = $allvar[0]; 
			}else {
				unset($_SESSION['payment_report'][$allvar[1]]);
			} 
		}
		
		if($vars[8] == '2') {
		    include("view_payment_page.php");
		}else {
			include("view_payment.php");
		}
		
	}
	
	function reset_payment_report($str){
		$_SESSION['payment_report'] = ''; 
		unset($_SESSION['payment_report']); 
		
		if($str == 2) {
		  include("view_payment_page.php");
		}else{
			include("view_payment.php");
		}
	}
	
	function advance_search_payment_report_all($var){
		
		//echo  $str;
		//$vars = explode('__',$str);
		unset($_SESSION['payment_report_all']); 
		$vars = explode('|',$var);
		foreach($vars as $key=>$value) {
			 $allvar = explode('__',$value);
			//print_r($allvar);
			if($allvar[0] != '' && $allvar[0] != '0') {
			  $_SESSION['payment_report_all'][$allvar[1]] = $allvar[0]; 
			}else {
				unset($_SESSION['payment_report_all'][$allvar[1]]);
			} 
		} 
		include("view_payment_all.php");
	}
	function reset_payment_report_all($str){
		$_SESSION['payment_report_all'] = ''; 
		unset($_SESSION['payment_report_all']); 
		include("view_payment_all.php");
	}
	
	function sms_for_staff($data){
		
		//echo  $data;
			 $datar = explode('|', $data);
			 
			$job_id = $datar[0]; 
			$contact = $datar[1]; 
			//$contact = '8373956021'; 
			$message = base64_decode($datar[2]); 
			$heading = base64_decode($datar[3]);  
			$page = $datar[4];  
			
			//echo $message .'====='.$heading; die;
			
				if($message != '') {

						if(is_numeric($contact) && strlen($contact) == 10){

								
								$comment_msg = strip_tags($message);
								$comment_note = strip_tags($message);

								  $sms_for_notify = get_rs_value("siteprefs","sms_for_notify",1);
								  
									$getstaffid = mysql_fetch_assoc(mysql_query("SELECT staff_id FROM `job_details` WHERE job_id = ".$job_id." and status != 2 and job_type_id = 1"));		
											
									$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$getstaffid['staff_id']."'"));

									$result['user_to'] = get_rs_value("staff","name",$getstaffid['staff_id']);	
									$result['chatter'] = $getstaffid['staff_id'];
									$result['admin_id'] = $_SESSION['admin'];
									$result['admin'] = 'admin';
									$result['job_id'] = $job_id;
								  
								  
								if($getlogin_device['deviceid'] != '') {

									$heading.=" (Notification Delivered)"; 
									$flag = 1; 
									$result['deviceid'] = $getlogin_device['deviceid'];
									sendNotiMessage($comment_msg , $result);
								}else{
									$sms_code = send_sms(str_replace(" ","",$contact),$comment_msg);
									if($sms_code=="1"){ $heading.=" (SMS delivered because device not found)"; }else{ $heading.=" <span style=\"color:red;\">(SMS Failed)</span>";  }
									
									//if($sms_code=="1"){ $heading.=" (Delivered)"; $flag = 1; } else{ $heading.=" <span style=\"color:red;\">(Failed)</span>"; $flag = 2; }
								}
								
								   if($page == 'reclean') {
										add_job_notes($job_id,$heading,$comment_note);
										add_reclean_notes($job_id,$heading,$comment_note);
									}else {
										 add_job_notes($job_id,$heading,$comment_note);
									}
											
						   echo $heading;		
								
								
								/* $sms_code = send_sms(str_replace(" ","",$contact),$comment_msg);

								if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
									 if($page == 'reclean') {
										add_job_notes($job_id,$heading,$comment_note);
										add_reclean_notes($job_id,$heading,$comment_note);
									 }else {
										 add_job_notes($job_id,$heading,$comment_note);
									 }

								echo $heading; */
						}else{
							echo error("User Mobile number is invalid");			
						}
				}else {
					echo error("Message is Empty");	
				}
	}
	
	function check_job_available($str){
		//echo $str;
		 $vars = explode('|', $str);
		 $site_id = $vars[0];
		 $date = $vars[1];
		 $status = $vars[2];
		 
		 $sql = mysql_query("Select * from quote_checkBy_site_date where site_id = ".$site_id." AND date = '".$date."'");
		 $totalRecord  = mysql_num_rows($sql);
		 
		if($totalRecord > 0) {
            mysql_query("delete from quote_checkBy_site_date where site_id = ".$site_id." AND date = '".$date."'");
			echo '1';
		}else{
			mysql_query("INSERT INTO `quote_checkBy_site_date` (`site_id`, `date`) VALUES (".$site_id.", '".$date."')");
			echo '2';
		}
		//include('view_job_available.php');
	}
	
	function search_quote_dashboard($str){
		
		$vars = explode('|',$str);
		unset($_SESSION['quote_report_dashboard']);
		$_SESSION['quote_report_dashboard']['from_date'] = $vars[0];
		$_SESSION['quote_report_dashboard']['to_date'] = $vars[1];
		include('quote_dashboard.php');
	}
	function search_quote_status_report($str){
		
		$vars = explode('|',$str);
		unset($_SESSION['quote_with_status']);
		$_SESSION['quote_with_status']['from_date'] = $vars[0];
		$_SESSION['quote_with_status']['to_date'] = $vars[1];
		$_SESSION['quote_with_status']['site_id'] = $vars[2];
		include('quote_with_status.php');
	}
	
	function quote_dashboard_hourly_report($str){
		$vars = explode('|',$str);
		 unset($_SESSION['hourly_quote']);
		$_SESSION['hourly_quote']['quote_date'] = $vars[0];
		$_SESSION['hourly_quote']['to_date'] = $vars[1];
		include('quote_hourly_report.php'); 
	}
	
	function quote_dashboard_daily_report_1($str){
		
		$vars = explode('|',$str);
		 unset($_SESSION['quote']);
		$_SESSION['quote']['status'] = $vars[0];
		$_SESSION['quote']['date'] = $vars[1];
		$_SESSION['quote']['site_id'] = $vars[2];
		include('view_daily_report_quote.php'); 
	}
	
	function send_email_agent($job_id){
	 	send_email_agent_msg($job_id);
		$sql = mysql_query("UPDATE `job_details` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2"); 
		echo changeDateFormate(date('Y-m-d h:i:s'), 'datetime');
	}
	
	function send_email_reclean_agent($job_id) {
		send_email_reclean_agent_msg($job_id);
		$bool =  mysql_query("UPDATE `job_reclean` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2");
		echo changeDateFormate(date('Y-m-d h:i:s'), 'datetime');
	}
	
	function add_client_info($str){
		
		//q_id|jid|name|email|mobile
		//16748|4491|fdfdfdf|fdfdfdfdf|323232323
		//echo $str;
		$vars = explode('|',$str);
		
		$qid = $vars['0'];
		$j_id = $vars['1'];
		$name = $vars['2'];
		$email = $vars['3'];
		$mobile = $vars['4'];
		
		if($j_id != 0) {
     		mysql_query("INSERT INTO `job_client_other_info` (`quote_id`, `job_id`, `secondary_name`, `secondary_email`, `secondary_number`, `createdOn`) VALUES (".$qid.", ".$j_id.", '".$name."', '".$email."', '".$mobile."', '".date('Y-m-d H:i:s')."');");
			
			$heading = "Add New Secondary Client  (".$mobile.")  info";
			add_job_notes($j_id,$heading,$heading);
		}
		
		include('job_client_other_info.php');
	}
	
	
	function delete_client_info($str){
	    $vars = explode('|',$str);
		$id = $vars['0'];
		$j_id = $vars['1'];
		
		if($id != '' && $id != 0) {
		  mysql_query("delete from job_client_other_info where id = ".$id."");
		  
		    $heading = "Delete Secondary Client Info ";
			add_job_notes($j_id,$heading,$heading);
		}
       include('job_client_other_info.php');	
	}
	
	function get_agent_message_message($var){
	
	// Jobid|type
	// 1=> Agent , 2=> Client
	$vars = explode('|', $var);
	$job_id = $vars[0];
	$type = $vars[1];
	
	if($type != 0 ){ 
		$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
		$jobDetails = mysql_fetch_array(mysql_query("select * from job_details where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		$getJob_date = mysql_fetch_array(mysql_query("select reclean_date from job_reclean where job_id=".mysql_real_escape_string($job_id)." AND status != 2 order by job_type_id asc limit 0, 1")); 
		
		if($type == 1) {
			$name = $jobDetails['agent_name'];
		}elseif($type == 2) {
			$name = $quote['name'];
		}
		
		  $eol = '<br>';
		
		$message = $eol.'Hello '.$name.','.$eol.$eol.' We had conducted the bond clean at  '.$quote['address'].' and will like to confirm that the reclean was completed by our cleaner on  '.changeDateFormate($getJob_date['reclean_date'], 'datetime').'.'.$eol.' Please confirm if the property has passed your inspection in order for us to close off this job. '.$eol.' Should we not hear back from you in the next 24 hours we will consider this job as closed.'; 
		
		return ($message);
	}else{
		return '';
	}
    }
	
	function send_agent_email($str){
		
		$vars = explode('|',$str);
		
		$job_id  = trim($vars[0]);
		$toemailid  = trim($vars[1]);
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		$subject  = trim(base64_decode($vars[2]));
		$message  = trim(base64_decode($vars[3]));
		//$message  = trim(($vars[3]));
		$type  = $vars[4];
		$email_type  = $vars[5];
		
		sendmailbcic('BCIC',$toemailid,$subject,$message,"reclean@bcic.com.au","0");
		
			if($email_type == '1') {
				$emailType = 'Agent';
				//echo '===111==='.$email_type;
				if($type == 'job') {
				     $sql = ("UPDATE `job_details` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2"); 
				}else {
					 $sql =  ("UPDATE `job_reclean` SET `agent_email_sent_date` = '".date('Y-m-d H:i:s')."' where job_id=".mysql_real_escape_string($job_id)." AND status != 2");
				}
			//echo $sql;	
			     mysql_query($sql);	
				 
			}elseif($email_type == '2'){
				$emailType = 'Client';
				$bool =  mysql_query("UPDATE `quote_new` SET `agent_email_date` = '".date('Y-m-d h:i:s')."' WHERE `booking_id` = ".$job_id."");
			}
		add_job_notes($job_id,"Email ".$emailType." Send on ".$toemailid."",$message);
		echo "<p style='color:green'>Email Send to ".$toemailid.' Successfully </p>'; 
		
	}
	
	function send_invoice_attach($var){
		
		//echo 'ddfd'; die;
		
		$varx = explode("|",$var);
		$quote_id = $varx[0];
		$staff_id= $varx[1];

		$job_id = get_rs_value("quote_new","booking_id",$quote_id);
		
		//BOF added to generate pdf after click button 
        $jobinv = 1;		
		$q_details =  mysql_fetch_assoc(mysql_query("SELECT id , ssecret FROM quote_new WHERE booking_id=".mres($job_id).""));
		//$pdf_path = invoiceGenerationInPdf($q_details['ssecret'],$quote_id);
		
		$pdf_path = invoiceGenerationInPdf($q_details['ssecret'],$quote_id, "", $staff_id, $jobinv);
		//EOF added to generate pdf after click button
	
		if($job_id!="")
		{ 
		   //$staff_name = get_rs_value("staff","name",$staff_id);
			$email = get_rs_value("quote_new","email",$quote_id);
			$heading = "Invoice Sent on ".$email;
			add_job_notes($job_id,$heading,'');
			$bool = mysql_query("update jobs set email_client_invoice='".date("Y-m-d h:i:s")."' where id=".$job_id."");
		}
		//echo $quote_id."-".$staff_id."-".$sendmail."<br>";
		//echo invoice_email($quote_id,$staff_id,$sendmail,$type);	
		//echo invoice_email($quote_id,$staff_id,$sendmail,$type, "", $job_type, $jobinv);	
		echo invoice_email($quote_id,'',"true","members","",$staff_id, $jobinv);
	}
	
	function delete_application($str){
		
		if($str != '') {
			$bool = mysql_query("update staff_applications set delete_status='2' where id=".$str.""); 
			echo 1;
		}else{
			echo 2;
		}
	}
	
	function application_emails($str){
		
		//echo $str; die;
		
		$vars = explode('|',$str);
		
		
	
	
	   //   print_r($vars); die;
		
		$appid  = trim($vars[0]);
		$toemailid  = trim($vars[1]);
		
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		$subject  = trim(($vars[2]));
		$message  = (trim(($vars[3]))); 
		
		//echo base64_decode($vars[3]); die;    
		
		$type  = $vars[4];
		
     			$flag = 0;		
		
		if($type == 'first_email'){
			$field_1 = 'first_email';
			$field_2 = 'first_email_date';
			
		}elseif($type == 'docs_required'){
			
			$field_1 = 'email_doc_required';
			$field_2 = 'email_doc_required_date';
			
		}elseif($type == 'sop_email'){
			$flag = 1;
		  	$field_2 = 'sop_email_date';
			
		}elseif($type == 'welcome_email'){
			
		$play_an = 'https://play.google.com/store/apps/details?id=com.netvision.bcic&hl=en';
		$ios = 'https://itunes.apple.com/us/app/bcic/id1436939778?ls=1&mt=8';
		
		$str_from = array('andr' , 'ios');
		$str_to = array($play_an , $ios); 
		
		$message = str_replace($str_from , $str_to , $message);
		
		
			$field_1 = 'welcome_email';
			$field_2 = 'welcome_email_date';
		}
		
		
		if($flag == 1) {
             // sop_manual_email_attchment_info($appid);
             
                $folderpath = $_SERVER['DOCUMENT_ROOT'] . '/application/manual/';
                
               // $sendto_email = 'pankaj.business2sell@gmail.com';
                $subject_ = 'A#'.$appid.' '. $subject;
                add_application_notes($appid,$subject_,$subject_ ,'','','', 0);        
                sendmailwithattach_application($name, $toemailid, $subject_, $message, 'hr@bcic.com.au', $folderpath);
             
             
		     $sql = mysql_query("UPDATE `staff_applications` SET  $field_2 = '".date('Y-m-d H:i:s')."' where id=".mysql_real_escape_string($appid).""); 
             
             
		}else{
		    	sendmailbcic('BCIC',$toemailid,$subject,$message,"hr@bcic.com.au","0");	
             	
             	$apnotes = 'Send Email For '.$subject;
             	
        	 	add_application_notes($appid, $apnotes,$apnotes ,'','','', 0);
        	 	
        		 if($appid !='') {
        		    $sql = mysql_query("UPDATE `staff_applications` SET $field_1 = '1'  , $field_2 = '".date('Y-m-d H:i:s')."' where id=".mysql_real_escape_string($appid).""); 
        		 } 
		}
		 
		echo "<p style='color:green'>Email  ".ucwords(str_replace('_',' ', ($type)))." to ".$toemailid.' Successfully </p>'; 
	}
	
	function application_search($str) {
		
		$vars = explode('|',$str);
		$site_id = $vars[0];
		$search_value = trim($vars[1]);
		$response_status = trim($vars[2]);
		$application_reference = trim($vars[3]);
		$sutab_unsutab = trim($vars[4]);
         
		if($site_id != 0) {  
		  $_SESSION['application']['site_id'] = $site_id;
		}else{
		   unset($_SESSION['application']['site_id']);	
		}
		  
		if($search_value != '') {  
		  $_SESSION['application']['search_value'] = $search_value;
		}else{
			unset($_SESSION['application']['search_value']);
		}
		
		if($response_status != '' && $response_status != 0) {  
		  $_SESSION['application']['response_status'] = $response_status;
		}else{
			unset($_SESSION['application']['response_status']);
		}
		
		if($application_reference != '' && $application_reference != 0) {  
		  $_SESSION['application']['application_reference'] = $application_reference;
		}else{
			unset($_SESSION['application']['application_reference']);
		}
		
		if($sutab_unsutab != '' && $sutab_unsutab != 0) {  
		  $_SESSION['application']['sutab_unsutab'] = $sutab_unsutab;
		}else{
			unset($_SESSION['application']['sutab_unsutab']);
		}
		
	
       include('application_report.php');	
	}
	
	function application_add_comment($str){
		
			$varx = explode("|",$str);
			$comment = $varx[0];
			$appl_id= $varx[1];
			$type= $varx[2];
			
			
			//print_r($varx);
			$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
			
			if($type == 1) {
				$notes = 'Application Note';
				$applicationID = $appl_id;
			}elseif($type == 2) {
				$notes = 'Cleaner Note';
				$applicationID = $appl_id;
			}
			
			 //echo $applicationID;  die;
			
				if($comment!=""){
					 if($type == 1) {
					   add_application_notes($appl_id," $notes Added by ".mysql_real_escape_string($staff_name),$comment ,'','','', 0);
					 }elseif($type == 2) {
						   $application_id = get_rs_value("staff","application_id",$applicationID);
						   add_application_notes($application_id," $notes Added by ".mysql_real_escape_string($staff_name),$comment ,'','','', $applicationID);
					 }
				}
			 if($type == 1) {
		    	include("application_notes.php");
			 }else{
			  include("view_staff_notes.php");	 
			 }
	}
	
	function search_view_call_report($var){
		$vars =   explode('|', $var); 
		
		if($vars[0] != '0' && $vars[0] != '') {
		  $_SESSION['view_report_list']['admin'] = $vars[0];
		}else{
			
			unset($_SESSION['view_report_list']['admin']);
			$_SESSION['view_report_list']['admin'] = '0';
		}
		if($vars[1] != '') {
		  $_SESSION['view_report_list']['quote_job_id'] = $vars[1];
		}else{
			unset($_SESSION['view_report_list']['quote_job_id']);
			$_SESSION['view_report_list']['quote_job_id'] = '';
		}
		$_SESSION['view_report_list']['import_id'] = $vars[2];
		include('view_import_list.php');
		
	}
	
	function get_job_avail_by_job_id($var){
		//echo $var; die;
		 if($var != '') {
		    $_SESSION['job_avail']['job_type_id'] = $var;
   		}else{
			$_SESSION['job_avail']['job_type_id'] = 1;
		}
		include('view_job_available.php');
	}
	
	function review_client_email($str){
		
		
		//echo $str; die;
		
		$vars = explode('|',$str);
		
		//print_r($vars); die;
		
		$job_id  = trim($vars[0]);
		$toemailid  = trim($vars[1]);
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		//$toemailid  = 'manish@bcic.com.au';
		$subject  = trim(base64_decode($vars[2]));
		$message  = trim(($vars[3]));
		$type  = $vars[4];
		$email_type  = $vars[5];
		
		 $quotedetails = mysql_fetch_assoc(mysql_query("select name , id ,quote_for ,site_id  from quote_new where booking_id ='".mysql_real_escape_string($job_id)."'"));
		
		//sendmail($sendto_name,$sendto_email,$sendto_subject,$sendto_message,$replyto,$site_id , $quotefor = null)
		sendmail($quotedetails['name'],$quotedetails['email'],$subject,$message,'bookings@bcic.com.au',$quotedetails['site_id'],$quotedetails['quote_for']);
		sendmail($quotedetails['name'],'pankaj.business2sell@gmail.com',$subject,$message,'bookings@bcic.com.au',$quotedetails['site_id'],$quotedetails['quote_for']);
		//sendmailbcic('BCIC',$toemailid,$subject,$message,"reviews@bcic.com.au","0",1);
		//sendmailbcic('BCIC','manish@bcic.com.au',$subject,$message,"reviews@bcic.com.au","0" , 1);
		$bool = mysql_query("update jobs set review_email_time='".date("Y-m-d h:i:s")."' where id=".$job_id."");
		echo "<p style='color:green'>Email review  to ".$toemailid.' send Successfully </p>';  
	}
	
	function view_quote_oto_flag($var) {
	   
		 $strvalue = explode('|',$var); 
		
		
		
		$getResponse = mysql_fetch_assoc(mysql_query('SELECT name FROM `system_dd` where type = 58 AND  id ='.mysql_real_escape_string($strvalue[0])));
		
		
		// $quoteName = get_rs_value("quote_new","name",$strvalue[1]);
		 $quotedetails = mysql_fetch_assoc(mysql_query("select name , id ,oto_time ,oto_flag  from quote_new where id ='".mysql_real_escape_string($strvalue[1])."'"));
		 
		 
		// print_r($quotedetails); die;
		 
			if($getResponse['name'] != '') {
			    $type = $getResponse['name'];
			}else {
				$type = 'Defult';
			}
			
		admin_cehckOto_flag($quotedetails['oto_time'] ,$quotedetails['oto_flag'] , $quotedetails['id']);
			
			
		 $heading = "Quote OTO is ".$type;
		$comment = "Quote of ".$quoteName." OTO is ".$type;
		add_quote_notes($strvalue[1],$heading,$comment); 
		//$bool = mysql_query("update quote_new set oto_flag='".$strvalue[0]."' where id=".mres($strvalue[1])."");
		echo $strvalue[0];
	}
   	
	function admin_cehckOto_flag($oto_time , $oto_flag , $q_id){
		
		//echo $oto_time .'=='. $oto_flag  .'=='. $q_id; die;
		if($q_id != '' && $q_id != 0) {	
			$quotedetails = mysql_fetch_assoc(mysql_query("select original_price , amount , id from quote_new where id ='".mysql_real_escape_string($q_id)."'"));
			
			mysql_query("UPDATE quote_new SET amount= '".$quotedetails['original_price']."', oto_flag = '0' WHERE id= ".$q_id."");

            $cleaningdetails = mysql_fetch_assoc(mysql_query("select job_type_id , original_price from quote_details where quote_id ='".mysql_real_escape_string($q_id)."' AND job_type_id = 1"));		
			
		
            if(!empty($cleaningdetails)) {
			  
			   $cleaningAmt = mysql_query("UPDATE quote_details SET  quote_auto_custom='1',  amount='".$cleaningdetails['original_price']."'  WHERE quote_id= ".$q_id." AND job_type_id = '1'"); 
		    }	
		}
    }
	
	function delete_sub_staff($str){
		
		if($str != '') {
			$bool = mysql_query("update sub_staff set is_deleted='0' where id=".$str.""); 
			echo 1;
		}else{
			echo 2;
		}
	}
	
	function search_client_review($var){
		$vars = explode('|',$var);
		$_SESSION['client_review']['from_date']  =  $vars[0];
		$_SESSION['client_review']['to_date'] = $vars[1];
		if($vars[2] != '' && $vars[2] != 0) {
		  $_SESSION['client_review']['job_id'] = $vars[2];
		}else{
			unset($_SESSION['client_review']['job_id']);
		}
		
		include('view_client_review.php');
	}
	
	function search_sub_staff($var){
		
		$vars = explode('|',$var);
		
		if($vars[0] != '' && $vars[0] != 0) {
		 $_SESSION['search_sub_staff']['staff_id']  =  $vars[0];
		}else{
			unset($_SESSION['search_sub_staff']['staff_id']);
		}
		
		if($vars[1] != '') {
		   $_SESSION['search_sub_staff']['sub_staff_name']  =  $vars[1];
		}else{
			unset($_SESSION['search_sub_staff']['sub_staff_name']);
		}
		
		include('sub_staff_list.php');
	}
	
	function recheck_oto(){
		recheck_oto_quote();
		include('view_quote.php');
	}
	
	
	
	function reclean_send_email($str){
		$vars = explode('|',$str);
		
		$job_id  = trim($vars[0]);
		$toemailid  = trim($vars[1]);
		//$toemailid  = 'pankaj.business2sell@gmail.com';
		$subject  = trim(base64_decode($vars[2]));
		$message  = trim(($vars[3]));
		$type  = $vars[4];
		$email_type  = $vars[5];
		
		sendmailbcic('BCIC',$toemailid,$subject,$message,"reclean@bcic.com.au","0");
		
		$bool = mysql_query("update jobs set unassign_email_date='".date("Y-m-d H:i:s")."' where id=".$job_id.""); 
		
		add_job_notes($job_id,"Re-Clean Email  Send on ".$toemailid."",$message);
		echo "<p style='color:green'>Email Send to ".$toemailid.' Successfully </p>'; 
	}
	
	
	function search_sales_report($var){
		
		$vars =   explode('|', $var); 
		
		if($vars[0] != '0' && $vars[0] != '') {
		  $_SESSION['sales']['from_date'] = $vars[0];
		}else{
			
			unset($_SESSION['sales']['from_date']);
			$_SESSION['sales']['from_date'] = '0';
		}
		if($vars[1] != '') {
		  $_SESSION['sales']['to_date'] = $vars[1];
		}else{
			unset($_SESSION['sales']['to_date']);
			$_SESSION['sales']['to_date'] = '';
		}
		
		//print_r($vars);
		
		if($vars[2] == 1) {
		   include('view_sales_reports.php');
		}elseif($vars[2] == 2){
		   include('view_booked_sales_reports.php');
		}
	}
	
	function create_br_quote($var){
		
		$varx = explode("|",$var);
		$type = $varx[0];
		$quote_for = $varx[1];
		$site_id = $varx[2];
		$br_item_name = $varx[3];
		$qty = $varx[4];
	
		if(!isset($_SESSION['temp_quote_id'])){ 
		
			$ins_temp_quote	= "insert into temp_quote(session_id,site_id,date,quote_for) value('".session_id()."','".$site_id."','".date("Y-m-d")."','".$quote_for."');";
			
			$ins = mysql_query($ins_temp_quote);
			//$id = 6832;
			$id = mysql_insert_id();
			$_SESSION['temp_quote_id'] = $id; 
		}
		
		     $inventory_typename = get_rs_value("br_inventory_type","name",$type);			
			
			 $tempQuoteDetails	= mysql_query("insert into temp_quote_details(temp_quote_id , job_type_id ,job_type,qty,quote_type) value('".$_SESSION['temp_quote_id']."','".$type."','".$inventory_typename."',".$qty.",'2');");
			  $q_did = mysql_insert_id();
			
			$sql = mysql_query("SELECT *  FROM `removal_item_chart` WHERE `id` IN (".$br_item_name.")  AND item_type_id = ".$type."");
				if(mysql_num_rows($sql) > 0) {
					
					$desc = '';
					$cubic_m3 = '';
					
					while($getchartdata = mysql_fetch_assoc($sql)) {
						
					 $ins_arg  = mysql_query("insert into temp_quote_details_inventory set temp_quote_id='".$_SESSION['temp_quote_id']."', 
		                   type= 1, inventory_type_id='".$getchartdata['item_type_id']."', inventory_item_name='".$getchartdata['item_name']."',qty='".$qty."', m_3=".$getchartdata['m_3'].", inventory_item_id=".$getchartdata['id']."");
						   
						$desc  .= $getchartdata['item_name'].',';
						$cubic_m3  += $getchartdata['m_3'];
					}
				
				    $totalCubic = ($cubic_m3*$qty);
				
                    $bool = mysql_query("update temp_quote_details set description='".($desc)."',cubic_meter='".($totalCubic)."' where id=".$q_did."");	
			
				}
		
		
		echo create_br_quote_str($_SESSION['temp_quote_id']);
	}
	
	
	function create_br_quote_str($temp_quote_id){
	
		$str ='<span class="main_head">Quote Section</span><div class="br_table">';
		
		$qdetails = mysql_query("select * from temp_quote_details where temp_quote_id=".$_SESSION['temp_quote_id']."");
		$total_amount = 0;
		$totalCubic = 0;
		$totalqty = 0;
	    while($r = mysql_fetch_assoc($qdetails)){ 
		  
				$str.='<table class="table table-bordered"><thead><tr><th>'.$r['job_type'].'&nbsp;&nbsp;</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="qty_'.$r['id'].'">Qty: ';
				$str.='<input type="text" id="qty_'.$r['id'].'" name="qty_'.$r['id'].'" value="'.$r['qty'].'" onblur="javascript:edit_br_field_quote(this,\'temp_quote_details.qty\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
				
				$str.='<th style="width:10%; text-align:center;" id="cubic_meter_'.$r['id'].'">M3: ';
				$str.='<input type="text" id="cubic_meter_'.$r['id'].'" name="cubic_meter_'.$r['id'].'" value="'.$r['cubic_meter'].'" onblur="javascript:edit_br_field_quote(this,\'temp_quote_details.cubic_meter\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
				$str.='</th>';
			
				
				$str.='</tr></thead><tbody>';
				//$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
				$str.='<tr><td colspan="4" align="center">';
				$str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_br_field_quote(this,\'temp_quote_details.description\',\''.$r['id'].'\');">'.$r['description'].'</textarea>';
				
				$str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',50,\'quote_div\');"><img src="images/cross.png"></a></span>';
				$str.='</td></tr></tbody></table>';
				
				$totalCubic = ($totalCubic + $r['qty']);
				$totalqty = ($totalqty + $r['cubic_meter']);
				
			}
			
			$str.='</div><table class="table table-bordered"><tfoot>
			    <tr>
				  <td><b>Total M3</b></td>
				   <td id="total_amount_quote">'.$totalqty.'</td>
				</tr>
				<tr>
				 <td><b>Total Qty</b></td>
				 <td id="total_amount_quote">'.$totalCubic.'</td>
				 </tr>
				</tfoot></table>';
			
			
			$str.=' <a href="javascript:save_br_quote();" class="btn_quote">Save BR Quote</a>';
		
			return $str;	
	    }
		
		function save_br_quote_data($var){
			
			$varx = explode("|",$var);
			
			$bed = $varx[0];
			$lounge_hall = $varx[1];
			$kitchen = $varx[2];
			$dining_room = $varx[3];
			$office = $varx[4];
			$garage = $varx[5];
			$laundry = $varx[6];
			$box_bags = $varx[7];
			$study = $varx[8];
			$type = $varx[9];
			$quotefor = $varx[10];
			$suburb = $varx[11];
			$site_id = $varx[12];
			$booking_date = $varx[13];
			
			
			// Moving Details
			$moving_from = $varx[14];
			$moving_to = $varx[15];
			$is_flour_from = $varx[16];
			$is_flour_to = $varx[17];
			$is_lift_from = $varx[18];
			$is_lift_to = $varx[19];
			$house_type_from = $varx[20];
			$house_type_to = $varx[21];
			$door_distance_from = $varx[22];
			$door_distance_to = $varx[23];
			
			
			if(!isset($_SESSION['temp_quote_id'])){ 
						$ins_temp_quote	= "insert into temp_quote(session_id,site_id,date,quote_for) value('".session_id()."','".$site_id."','".date("Y-m-d")."','".$quotefor."');";
						//echo $ins_temp_quote."<br>";
						$ins = mysql_query($ins_temp_quote);
						$id = mysql_insert_id();
						$_SESSION['temp_quote_id'] = $id;
	        }
			
			
			$uarg = "update temp_quote set suburb='".mres($suburb)."', site_id=".$site_id.", booking_date='".$booking_date."', quote_for='".$quote_for."', ";
			
			 $uarg.=" login_id = '".$_SESSION['admin']."' where id=".$_SESSION['temp_quote_id']."";	
			echo $uarg."<br>";	
		}
		
		
		function save_br_quote($var){
			
	 		$varx = explode("|",$var);
			
			//echo "<pre>";  print_r($varx);
			
			
			$quote_for = $varx[0];
			$staff_id = $varx[1];
			$suburb = $varx[2];
			$site_id = $varx[3];
			$booking_date = $varx[4];
			$name = $varx[5];
			$phone = $varx[6];
			$email = $varx[7];
			$job_ref = $varx[8];
			$address = $varx[9];
			$comments = $varx[10];
			
			// Moving Details
			$moving_from = $varx[11];
			$moving_to = $varx[12];
			$is_flour_from = $varx[13];
			$is_flour_to = $varx[14];
			$is_lift_from = $varx[15];
			$is_lift_to = $varx[16];
			$house_type_from = $varx[17];
			$house_type_to = $varx[18];
			$door_distance_from = $varx[19];
			$door_distance_to = $varx[20];
			

	
			 $uarg = "update temp_quote set suburb='".mres($suburb)."', site_id=".$site_id.", booking_date='".$booking_date."', name='".mres($name)."', phone='".$phone."', email='".$email."', job_ref='".$job_ref."',referral_staff_name = '".$staff_id."',quote_for='".$quote_for."', ";
			
			 $uarg.=" address='".mres($address)."',login_id = '".$_SESSION['admin']."', comments='".mres($comments)."' where id=".$_SESSION['temp_quote_id']."";	
			//echo $uarg."<br>";	
			$bool = mysql_query($uarg); 
			
			
		if($bool){ 
		// move all the info to Quote 
					$getPostCode = mysql_fetch_array(mysql_query("SELECT postcode  FROM `postcodes` WHERE `suburb` = '".$suburb."' AND `site_id` = ".$site_id.""));
					
					$ipaddress = $_SERVER['REMOTE_ADDR'];
					
					if(!empty($getPostCode)) {
					   $postcode = $getPostCode['postcode'];
					}else {
						$postcode = 0;
					}
					$temp_quote = mysql_fetch_array(mysql_query("select * from temp_quote where id = ".$_SESSION['temp_quote_id']));
					//admin_id
					//$admin_id = $_SESSION['admin']; 
		
				if(!isset($_SESSION['quote_id'])){ 		
				
					$ins_arg  = "insert into quote_new set suburb='".mres($suburb)."', site_id=".$site_id.", br_step = '2',step = '3',  booking_date='".$booking_date."', name='".mres($name)."', phone='".$phone."', email='".$email."', job_ref='".$job_ref."', ";
					
					$ins_arg.=" address='".mres($address)."', comments='".mres($comments)."', date='".date("Y-m-d")."', amount='".$temp_quote['amount']."',login_id = '".$_SESSION['admin']."',ipaddress = '".$ipaddress."',postcode = '".$postcode."',quote_for = '".$quote_for."', referral_staff_name = '".$staff_id."' , ";
					
					$ins_arg.=" moving_from='".mres($moving_from)."', moving_to='".mres($moving_to)."', is_flour_from='".$is_flour_from."',is_flour_to = '".$is_flour_to."',is_lift_from = '".$is_lift_from."',is_lift_to = '".$is_lift_to."',house_type_from = '".$house_type_from."', house_type_to = '".$house_type_to."',door_distance_from = '".$door_distance_from."',door_distance_to = '".$door_distance_to."'";
					
				}else{
					
					$ins_arg  = "update quote_new set suburb='".mres($suburb)."', site_id=".$site_id.", br_step = '2', step = '3', booking_date='".$booking_date."', name='".mres($name)."', 
					phone='".$phone."', email='".$email."', job_ref='".$job_ref."', ";
					
					$ins_arg.=" address='".mres($address)."', comments='".mres($comments)."', date='".date("Y-m-d")."', amount='".$temp_quote['amount']."',login_id = '".$_SESSION['admin']."',ipaddress = '".$ipaddress."',postcode = '".$postcode."',quote_for = '".$quote_for."', referral_staff_name = '".$staff_id."' , ";
					
					$ins_arg.=" moving_from='".mres($moving_from)."', moving_to='".mres($moving_to)."' , is_flour_from='".$is_flour_from."',is_flour_to = '".$is_flour_to."',is_lift_from = '".$is_lift_from."',is_lift_to = '".$is_lift_to."',house_type_from = '".$house_type_from."', house_type_to = '".$house_type_to."',door_distance_from = '".$door_distance_from."',door_distance_to = '".$door_distance_to."' where id=".$_SESSION['quote_id'];
				}
				
				
			  $ins = mysql_query($ins_arg);		
			  
			   if($ins){ 
					// quote_new is inserted 						
					//echo "Quote Session ".$_SESSION['quote_id'];
					if(isset($_SESSION['quote_id'])){ 
						$bool = mysql_query(" delete from quote_details where quote_id=".$_SESSION['quote_id']);	
						$bool1 = mysql_query(" delete from quote_details_inventory where quote_id=".$_SESSION['quote_id']);	
						$quote_id = $_SESSION['quote_id'];
					}else{
						$quote_id = mysql_insert_id();
						$bool = mysql_query("update temp_quote set quote_id='".$quote_id."' where id=".$_SESSION['temp_quote_id']);	
						$_SESSION['quote_id'] = $quote_id;
					}
					
					$qdetails = mysql_query("select * from temp_quote_details where temp_quote_id=".$_SESSION['temp_quote_id']."");
					$comment = '';
					$heading = '';
			//quote_type
						while($r = mysql_fetch_assoc($qdetails)){ 
						
							$ins_arg  = "insert into quote_details set quote_id='".$quote_id."',amount='".$r['amount']."', hours='".$r['hours']."',rate='".$r['rate']."',quote_type='".$r['quote_type']."',
							job_type_id=".$r['job_type_id'].", job_type='".$r['job_type']."', booking_date='".$r['booking_date']."', bed='".$r['bed']."', study='".$r['study']."', bath='".$r['bath']."',
							toilet='".$r['toilet']."', living='".$r['living']."', furnished='".$r['furnished']."', property_type='".$r['property_type']."', blinds_type='".$r['blinds_type']."',quote_auto_custom='".$r['quote_auto_custom']."',
							carpet_stairs='".$r['carpet_stairs']."', pest_inside='".$r['pest_inside']."', pest_outside='".$r['pest_outside']."', pest_flee='".$r['pest_flee']."', description='".$r['description']."', qty='".$r['qty']."', cubic_meter='".$r['cubic_meter']."'"; 
							
							echo $ins_arg;
							
							//$ins = mysql_query($ins_arg);
							
							$comment .= '<strong>'.$r['job_type'].' - </strong> qty'.$r['qty'].' - M3'.$r['cubic_meter'].'</br>'.$r['description'].'<br/>===================<br/>';
						}
						
						
				die;		
					$heading = 'Job type Description ';
					add_quote_notes($quote_id,$heading,$comment);
				
				   $teqdetails = mysql_query("select * from temp_quote_details_inventory where temp_quote_id=".$_SESSION['temp_quote_id']."");
				
						while($tquotedetails = mysql_fetch_assoc($teqdetails)){ 
						       
							$ins_arg1  = ("insert into quote_details_inventory set quote_id='".$quote_id."', 
		                   type= 1, inventory_type_id='".$tquotedetails['inventory_type_id']."', inventory_item_name='".$tquotedetails['inventory_item_name']."',qty='".$qty."', m_3=".$tquotedetails['m_3'].", inventory_item_id=".$tquotedetails['inventory_item_id']."");
						      $ins1= mysql_query($ins_arg1);
						
						}
						
					echo '<div class="buttons">';
					echo '<div class="btn_get_quot"><a href="javascript:scrollWindow(\'email_quote.php?quote_id='.$_SESSION['quote_id'].'\',\'1200\',\'850\')" >View Quote</a></div>';
				
					
					echo '<div class="btn_bok_now" id="quote_approved"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',\'27\',\'quote_approved\')">Email Quote</a></div>';
					echo '</div>';	
				
					//$emailed_client = get_rs_value("quote_new","emailed_client",$_SESSION['quote_id']);
					
					
					echo '<div class="buttons" id="book_now_div">';			
					echo '<div class="btn_get_quot"><a href="javascript:send_data(\''.$_SESSION['quote_id'].'\',9,\'book_now_div\');">Book Now</a></div>';
					echo '</div>';	
				}else{
						echo "Couldnt Insert into Quote Pls Check function save_br_quote() ajax";	
				}		
			}else{
				echo "Couldnt Save Temp Quote Pls Check function save_br_quote() ajax";	
			}
	}
	
	
	function save_moving_address($var) {
		
			$vars = explode('|',$var);
			$latlog = explode('__',$vars[0]);
			$lat = $latlog[0];
			$long = $latlog[1];
			$quote_id = $vars[1];
			$type = $vars[2];
			
			if($type == 1) {
			   $sql  = ("update quote_new set lat_from = '".$lat."',long_from = '".$long."'  where id = ".$quote_id."");
			}else{
			   $sql  = ("update quote_new set lat_to = '".$lat."',long_to = '".$long."'  where id = ".$quote_id."");
			}
			$bool = mysql_query($sql);
			
			$gettotalDIstanceCount  = gettotalDIstanceCount($quote_id);
			
			//print_r($gettotalDIstanceCount); die;
			
			$travelling_hr = $gettotalDIstanceCount['travelling_hr'];
			
			$qupdate  = mysql_query("update quote_details set travelling_hr = '".$travelling_hr."'  where quote_id = ".$quote_id." AND  job_type_id = 11");
			
			$r = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=".$quote_id." AND job_type_id = 11"));
			
			echo edit_quote_str($r['quote_id']);	
	}
	
	
	function job_deny_by_admin($var){
		    JobDenyByAdmin($var);
			$varx = explode("|",$var);
			//$jd_id = $varx[0];
			$job_id= $varx[1];
			//$staff_id=$varx[2];
		include("view_job_details.php");  
	}

   function updateaddress($var){
	
	$varx = explode("|",$var);
	$value = mysql_real_escape_string($varx[0]);
	$fieldx= explode(".",$varx[1]);
	$table = $fieldx[0];
	$field = $fieldx[1];
	$id=$varx[2];
	$siteid=$varx[3];
	
	 $bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
    	 echo trim($value);
    }	 
	
    function staff_invoice_report($var){
	  
	  $vars =   explode('|', $var); 
		
		if($vars[0] != '0' && $vars[0] != '') {
		  $_SESSION['staff_invoice_1']['from_date'] = $vars[0];
		}else{
			
			unset($_SESSION['staff_invoice_1']['from_date']);
		}
		if($vars[1] != '') {
		  $_SESSION['staff_invoice_1']['to_date'] = $vars[1];
		}else{
			unset($_SESSION['staff_invoice_1']['to_date']);
		}
		$staff_id = $vars[2];
		include('staff_view_invoice.php');
	  
    }	
	
    function send_staff_invoice($str){
	  $vars =   explode('|', $str); 
	  $staff_ids = $vars[0];
	  $from_date = $vars[1];
	  $todate = $vars[2];
	  //show_all_invoice($staff_ids ,$from_date, $todate);
	  invoiceGenerationInPdf_forStaff($staff_ids ,$from_date, $todate );
	  
    }  
	
	function search_all_invoice_report($var){
		
		$vars =   explode('|', $var); 
		if($vars[0] != '0' && $vars[0] != '') {
		  $_SESSION['all_invoice_data']['from_date'] = $vars[0];
		}else{
			unset($_SESSION['all_invoice_data']['from_date']);
		}
		if($vars[1] != '') {
		  $_SESSION['all_invoice_data']['to_date'] = $vars[1];
		}else{
			unset($_SESSION['all_invoice_data']['to_date']);
		}
		
		if($vars[2] != '') {
		    $_SESSION['all_invoice_data']['staff_id'] = $vars[2];
		}else{
			unset($_SESSION['all_invoice_data']['staff_id']);
		}
		
		include('view_invoice.php');
	}
   
    function invoice_generate($var){
	     geerateInvoicePDF($var);
		include('view_invoice.php');	
    }
	
	
	function send_monthly_invoice($var){
		getStaffInvoice_message($var);
	}
	
	function get_dispatch_board($var){
		$_SESSION['dispatch']['quote_for'] = $var;
		include('dispatch.php');
	}
   
    function truck_assign($var){
		
		$varx = explode("|",$var);
		$jd_id = $varx[0];
		$job_id= $varx[1];
		$staff_truck_id=$varx[2];
	    $uarg = mysql_query("update job_details set staff_truck_id=".$staff_truck_id." , staff_truck_assign_date = '".date('Y-m-d H:i:s')."' where job_id=".$job_id." and id=".$jd_id.""); 
		
        $cubic_meters = get_rs_value("staff_trucks","cubic_meters",$staff_truck_id);	
        $staff_id = get_rs_value("staff_trucks","staff_id",$staff_truck_id);	
        $staff_name = get_rs_value("staff","name",$staff_id);	
		$heading = 'Assigned  ( '.$cubic_meters.' Cm3) trucks  to '.$staff_name;
		add_job_notes($job_id,$heading,$heading);
	}
	
	function application_job_type($str){
		$_SESSION['application']['job_type'] = $str;
		include('application_report.php');
		
	}
	
	function view_quote_job_type($str){
		$_SESSION['view_quote_aSearching_job_type']['job_type'] = $str;
		include('view_quote.php');
		
	}
	function job_unassign_job_type($str){
		$_SESSION['view_unassigned']['job_type_id'] = $str;
		include('job_unassinged.php');
		
	}
	
	function calculate_moving_depot_time($str){
		
		$vars =  explode('__' , $str);
		$quote_id = $vars[0];
		$depot_address = $vars[1];
		$get_makedata = $vars[2];
		$get_staff = $vars[3];
		$get_truck_id = $vars[4];
		$quote_type = $vars[5];
		
		if($quote_type = 1) {
		    $movingdetails =  mysql_fetch_assoc(mysql_query("SELECT *  FROM `temp_quote`  WHERE id = ".$quote_id.""));
		}else{
		   $movingdetails =  mysql_fetch_assoc(mysql_query("SELECT *  FROM `quote_new`  WHERE id = ".$quote_id.""));	
		}
				$depot_addresslatland = getLatLong($depot_address);
				
					$dept_latitude = $depot_addresslatland['latitude'];
					$dept_longitude = $depot_addresslatland['longitude'];

					$lat_from = $movingdetails['lat_from'];
					$long_from = $movingdetails['long_from'];
					
					$lat_to = $movingdetails['lat_to'];
					$long_to = $movingdetails['long_to'];
					
					
			    $d_to_f = GetDrivingDistance($dept_latitude, $lat_from, $dept_longitude, $long_from);	
			    $t_to_d = GetDrivingDistance($lat_to, $dept_latitude, $long_to, $dept_longitude);	
				
				$totaltime = $d_to_f['time'] + $t_to_d['time'];
				
				$get_string = $quote_id.'__'.$depot_address.'__'.$get_makedata.'__'.$get_staff.'__'.$get_truck_id.'__'.$quote_type;
				$div_id = 'show_travell_time_'.$get_makedata.'_'.$get_staff.'_'.$get_truck_id.'__'.$quote_type;
				
				$onclick_travel_time  = "onClick=\"javascript:send_data('".$get_string."','407','".$div_id."');\"";
				
				
				$str =  '<table border="1" >
					    <tr>
					 	  <td>D=>F</td>
						  <td>T=>D</td>
						  <td>Total</td>
					    </tr>
				        <tr>
						  <td>'.$d_to_f['time'].' h</td>
						  <td>'.$t_to_d['time'].' h</td>
						  <td>'.$totaltime.' h</td>
					    </tr>
				    </table>';
				$str.= '<a style="cursor: pointer;" '.$onclick_travel_time.'> Calculate</a>';
				echo $str;
				
	}
   
   
   function re_search_payment_report($var){
	   
	   $vars = explode('|',$var);
	   
	    if($vars[0] != '') {
		   $_SESSION['re_payment_report']['from_date'] = $vars[0];
	    }else{
		  unset($_SESSION['re_payment_report']['from_date']);   
	    }
	   
	    if($vars[1] != '') {
		   $_SESSION['re_payment_report']['to_date'] = $vars[1];
	    }else{
		  unset($_SESSION['re_payment_report']['to_date']);   
	    }
	   
	    if($vars[2] != '') {
		  $_SESSION['re_payment_report']['site_id'] = $vars[2];
	    }else{
		  unset($_SESSION['re_payment_report']['site_id']);   
	    }
	   
	    if($vars[3] != '') {
		    $_SESSION['re_payment_report']['real_estate_id'] = $vars[3];
	      }else{
		    unset($_SESSION['re_payment_report']['real_estate_id']);   
	   }
	   	  
		  include('view_real_estate_payment.php');
   }
	
	function search_real_agent_name($str){
		
			$data = mysql_query("select * from real_estate_agent where name like '%".mysql_real_escape_string($str)."%'");
		$strx = "<ul class=\"post_list\">";
		while($r=mysql_fetch_assoc($data)){
			$strx.="<li><a href=\"javascript:select_search_real_agent_name('".$r['name']."','".$r['id']."')\">".$r['name']."</a></li>";
		}	
		$strx.="</ul>";
		echo $strx;
	}
	
	function create_re_invoice($quote_id){
		
		if($quote_id != ''){
			invoiceGenerationInPdf( null, $quote_id , 'real_estate');
			
			$email = get_rs_value("quote_new","email",$quote_id);
			$job_id = get_rs_value("quote_new","booking_id",$quote_id);
			
			//echo  $job_id; die;
			
			$heading = "Invoice Sent on ".$email;
			add_job_notes($job_id,$heading,'');
			$bool = mysql_query("update jobs set email_client_invoice='".date("Y-m-d h:i:s")."' where id=".$job_id."");
			
			echo invoice_email($quote_id,null,true,'members' ,'real_estate');	
		}			
	}
	
	function save_clener_notes($var) {
		//echo $vars;
		$vars = explode('|' , $var);
		
		//print_r($vars);
		$issue_type1 = $vars[0];
		$issue_type = get_sql("system_dd","name"," where type='69' AND id='".$issue_type1."'");
		
		$issue_comment = $vars[1];
		$job_id = $vars[2];
		$get_staff_name = $vars[3];
		
		$staff_name = get_rs_value("staff","name", $get_staff_name);
		$heading = $issue_type.'  ('.$staff_name.')';
		
		add_clener_notes($job_id,$heading,$issue_comment ,$issue_type1 , $get_staff_name );
		include('view_clener_notes.php'); 
	}
	
	function get_cleaner_report($var){
		 
		$vars = explode('|',$var);
		//print_r($vars);
		 
		if($vars[0] != '') {
		   $_SESSION['cleaner_report']['from_date'] = $vars[0];
	    }else{
		  unset($_SESSION['cleaner_report']['from_date']);   
	    }
	   
	    if($vars[1] != '') {
		   $_SESSION['cleaner_report']['to_date'] = $vars[1];
	    }else{
		  unset($_SESSION['cleaner_report']['to_date']);   
	    }
		 
		 include('view_cleaner_report.php');
		 
	}
	
	function get_review_report($var){
		 
		$vars = explode('|',$var);
		//print_r($vars);
		 
		if($vars[0] != '') {
		   $_SESSION['review_report']['from_date'] = $vars[0];
	    }else{
		  unset($_SESSION['review_report']['from_date']);   
	    }
	   
	    if($vars[1] != '') {
		   $_SESSION['review_report']['to_date'] = $vars[1];
	    }else{
		  unset($_SESSION['review_report']['to_date']);   
	    }
		 
		 include('view_review_report.php');
		 
	}
	 
	function slot_booking_date($var){
		$vars =  explode('|' , $var); 
		
		// print_r($vars); die;
		 $date = $vars[0];
		 $time = $vars[1];
		 $id = $vars[2];
		
		//echo $time;
		
		/* $bool = mysql_query("update quote_new set schedule_date ='".$date."', schedule_time = '".$time."', last_schedule_admin_id = '".$_SESSION['admin_id']."'  where id=".$id.""); */
		
		//$time_name = get_rs_value("site_time_slot","schedule_time",$time);
		$time_name = $time;
		//echo $time_name;
		
		//die;
		
		$heading = 'Change Schedule time '.$date.' ('.$time_name.')';
		
		$msg = '<p style="color:green;">Slot booked on '.$date.' ('.$time_name.')</p>';
		
		$datas['message'] = $msg;
		$datas['class'] = 'success';
		$datas['status'] = 3;
        $datas['quote_id'] = $id;
        $datas['message_for'] = $datas['message'];
        $datas['type'] = "";
		callSchedulledByStatus($datas);
		
		$getcall_back_details = mysql_fetch_array(mysql_query("SELECT * FROM `call_schedule_report` WHERE quote_id = ".$id." AND status ='1'  ORDER by id desc limit 0 , 1"));
				
			if(!empty($getcall_back_details)) {
				
				$take_call = $getcall_back_details['take_call'];
				$call_done = $getcall_back_details['call_done'];
				$re_schedule = $getcall_back_details['re_schedule'];
				
			}else{
				
				$take_call = 0;
				$call_done = 0;
				$re_schedule = 2;
			}
				
			/* $call_step = 	$getcall_back_details['call_step'];	
			$urgent_call = 	$getcall_back_details['urgent_call'];	 */
		
		    $site_id = 	$getcall_back_details['site_id'];	
		    $org_created_date = 	$getcall_back_details['org_created_date'];	
			
		    $call_step = 	2;	
			$urgent_call = 	2;		
			
		add_quote_notes($id,$heading,$heading);	 
		$bool = mysql_query("update call_schedule_report set status ='0'  where quote_id=".$id."");
		add_call_schedule_report($id,$date , $time , $call_done, $take_call , 1 , $re_schedule , $call_step ,$urgent_call,$site_id ,$org_created_date,2); 
		
		echo $msg;
		
	}
	
	function call_take($var) {
      //echo  $var; 		
	  $vars = explode('|', $var);
	  $id = $vars[0];
	  $field_name = $vars[1];
	 
	// echo  "SELECT *  FROM `site_notifications` WHERE `notifications_type` = 1  and quote_id = ".$id." and notifications_status = 0";
	 
	 //echo  "SELECT *  FROM `site_notifications` WHERE `notifications_type` = 1  and quote_id = ".$id." and notifications_status = 0";
	 $query = mysql_query("SELECT *  FROM `site_notifications` WHERE `notifications_type` = 1  and quote_id = ".$id." and notifications_status = 0");
	 
	  $countnotistatus = mysql_num_rows($query);
	

	if($countnotistatus > 0) {
	           $notidata = mysql_fetch_assoc($query);
	 			
				$notification_read_user = $notidata['notification_read_user'];
				$notiid = $notidata['id'];
				
				$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
				$r_msg = '';

				$currentDate = date('Y-m-d H:i:s');
				
				if($notification_read_user != '') { $r_msg = $notification_read_user.','; }
				$messageRead = $r_msg.$staff_name.'_('.$currentDate.')';
           //echo "UPDATE site_notifications SET notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = ".$notiid."";
				
				$qryBool = mysql_query( "UPDATE site_notifications SET notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = ".$notiid."" );

				//$updateData = mysql_fetch_array(mysql_query( "select notifications_status from site_notifications WHERE id = ".$notiid."" ));
	}
	 
	 
	 //$notification_read_user = get_sql("site_notifications","notification_read_user","where id=".$strvar[0]);
	 
	    $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	    //$call_taken_by = get_rs_value("quote_new","call_taken_by",$id);
		
	   $call_done = 0;
	   $take_call = 0;
	   $call_status = 0;
	    if($field_name == 'take_call'){
			$msg =  '<p style="color:green;">Call taken</p>';
		    $heading = 'Call taken By '.$staff_name;
		    $status = 1;
			$take_call = 1;
			$call_status = 1;
	    }elseif($field_name == 'call_done'){
		    $msg = '<p style="color:green;">Call Done By '.$staff_name.'</p>';
		    $heading = 'Call Done By '.$staff_name;
		    $status = 2;
			$call_done = 1;
			$call_status = 0;
	    }
		
		$getcall_back_details = mysql_fetch_array(mysql_query("SELECT * FROM `call_schedule_report` WHERE quote_id = ".$id." AND status ='1'  ORDER by id desc limit 0 , 1"));
		
		//print_r($getcall_back_details); die;
				
			if(!empty($getcall_back_details)) {
				
				$schedule_date = $getcall_back_details['schedule_date'];
				$schedule_time = $getcall_back_details['schedule_time'];
				$re_schedule = $getcall_back_details['re_schedule'];
				
			}else{
				
				$schedule_date = '';
				$schedule_time = '';
				$re_schedule = '';
			}
				
			/* $call_step = $getcall_back_details['call_step'];	
			$urgent_call = $getcall_back_details['urgent_call']; */

			$site_id = 	$getcall_back_details['site_id'];	
			$org_created_date = $getcall_back_details['org_created_date'];	
			$time_type = $getcall_back_details['time_type'];	
			$call_step = 	1;	
			$urgent_call = 	1;				
		
		$bool = mysql_query("update call_schedule_report set status ='0'  where quote_id=".$id."");
		add_call_schedule_report($id, $schedule_date , $schedule_time, $call_done, $take_call , $call_status , $re_schedule , $call_step ,$urgent_call,$site_id , $org_created_date,1); 
		
		/*
		    SEND $EVENT TO NEXT PC
		*/
		
		$datas['message'] = $msg;
		$datas['class'] = 'success';
		$datas['status'] = $status;
		$datas['staff_name'] = $staff_name;
        $datas['quote_id'] = $id;
        $datas['message_for'] = $datas['message'];
        $datas['type'] = "";
		callSchedulledByStatus($datas);
		echo $msg;	
	    add_quote_notes($id,$heading,$heading);	 
	}
	
	
	function reshedule_call($var){
		
		$vars = explode('|', $var);
	    $id = $vars[0];
	    $field_name = $vars[1];
	 
	    $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
	    $site_id = get_rs_value("quote_new","site_id",$id);
	    
         $time = date('H'); 	
         //$time = '10'; 	
		
		 
		$checkcount = mysql_num_rows(mysql_query("SELECT id  FROM `site_time_slot` WHERE site_id = ".$site_id.""));
		
		if($checkcount > 0) {
		 
		  
		 
			$sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." and slot_from > ".$time." limit 0 , 1");
			    //echo mysql_num_rows($sql);
				if(mysql_num_rows($sql) > 0) {
					    $date = date('Y-m-d');
				
						$getdata = mysql_fetch_assoc($sql);
						$gettime = $getdata['id'];
						$schedule_time = $getdata['schedule_time'];
						
						//$time_name = get_rs_value("site_time_slot","schedule_time",$gettime);

						$heading = "Call Re-Schedule by $staff_name time ".$date." (".$schedule_time.")";
						$msg = '<p style="color:green;">Slot booked on '.$date.' ('.$schedule_time.')</p>';
						
				}else {
					
					$sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." limit 0 , 1");
					$todaydate = date('Y-m-d');
			        $date = date('Y-m-d',strtotime($todaydate . "+1 days"));
					
				    	$getdata = mysql_fetch_assoc($sql);
						$gettime = $getdata['id'];
						$schedule_time = $getdata['schedule_time'];
						
						//$time_name = get_rs_value("site_time_slot","schedule_time",$gettime);

						$heading = "Call Re-Schedule by $staff_name time ".$date." (".$schedule_time.")";

						$msg = '<p style="color:green;">Slot booked on '.$date.' ('.$schedule_time.')</p>';
					
					
				}
					
					$getcall_back_details = mysql_fetch_array(mysql_query("SELECT * FROM `call_schedule_report` WHERE quote_id = ".$id." AND status ='1' ORDER by id desc limit 0 , 1"));
					
					if(!empty($getcall_back_details)) {
						
						$take_call = $getcall_back_details['take_call'];
						$call_done = $getcall_back_details['call_done'];
						$re_schedule = $getcall_back_details['re_schedule'];
					}else{
						$take_call = 0;
						$call_done = 0;
						$re_schedule = 1;
					}
					
					/* $call_step = 	$getcall_back_details['call_step'];	
					$urgent_call = 	$getcall_back_details['urgent_call'];	 */
					
					$call_step = 	2;	
					$urgent_call = 	2;	
					$site_id = 	$getcall_back_details['site_id'];	
					$org_created_date = 	$getcall_back_details['org_created_date'];	
					$time_type = 	$getcall_back_details['time_type'];	
					add_quote_notes($id,$heading,$heading);	 
					
					$bool = mysql_query("update call_schedule_report set status ='0'  where quote_id=".$id."");
					add_call_schedule_report($id,$date , $gettime , $call_done, $take_call , 1 , $re_schedule  , $call_step ,$urgent_call,$site_id ,$org_created_date,1); 
					//echo $msg; 
					$datas['status'] = 4;
					
				
		}else{
			    $msg = '<p style="color:red;">Slot not booked </p>';
			  	$datas['status'] = 5;
		}
				$datas['message'] = $msg;
				$datas['class'] = 'success';
				//$datas['status'] = 4;
				$datas['quote_id'] = $id;
				$datas['message_for'] = $datas['message'];
				$datas['type'] = "";
				callSchedulledByStatus($datas);
				
	}
	
     function get_slot_page($var) {
		 
		$vars = explode('|',$var);
		
		
		
		$_SESSION['schedule']['from_date'] = $vars[0];
		$_SESSION['schedule']['to_date'] = $vars[1];
		$site_id = $vars[2];
		$quote_id = $vars[3];
		$job_date = $vars[4];
		$mobile = $vars[5];
		$response = $vars[6];
		$step = $vars[7];
		 
		if($site_id != 0) {
			 $_SESSION['schedule']['site_id'] = $site_id;
		}else{
			 $_SESSION['schedule']['site_id'] = 0;
		}
		
		if($quote_id != 0) {
			 $_SESSION['schedule']['quote_id'] = $quote_id;
		}else{
			 $_SESSION['schedule']['quote_id'] = '';
		}
        if($job_date != '' && $job_date != '0' ) {
			 $_SESSION['schedule']['job_date'] = $job_date;
		}else{
			 $_SESSION['schedule']['job_date'] = '';
		}	
		
		if($mobile != '' && $mobile != '0' ) {
			 $_SESSION['schedule']['mobile'] = $mobile;
		}else{
			 $_SESSION['schedule']['mobile'] = '';
		}	
		 
		if($response != '' && $response != '0' ) {
			$_SESSION['schedule']['response'] = $response;
		}else{
			$_SESSION['schedule']['response'] = '';
		}	
		
		if($step != '' && $step != '0' ) {
			$_SESSION['schedule']['step'] = $step;
		}else{
			$_SESSION['schedule']['step'] = '';
		}	
		
		 include('view_slot_list.php');
	 }


	function message_board_search($var){
		
		$vars = explode('|' , $var);
		
		$_SESSION['message_board']['from_date'] = $vars[0];
		$_SESSION['message_board']['to_date'] = $vars[1];
		
		if($vars[2] != '' && $vars[2] != 0) {
	    	$_SESSION['message_board']['job_id'] = $vars[2];
		}else{
			$_SESSION['message_board']['job_id'] = '';
		}
		
		 include('view_message_board.php');
	}	

   function call_reverse($var) {
	   
	 /*   echo 'dffffffffff'; die;
       echo  $var; 	 */
	  
	   $vars = explode('|', $var);
	  
	  // print_r($vars); die;
	  
	  $id = $vars[0];
	  $field_name = $vars[1];
	 
	    $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		
	   
	    $msg =  '<p style="color:green;">Call Reverse</p>';
		    $heading = 'Call Reverse By '.$staff_name;
		    $status = 2;
			$take_call = 1;
			$call_status = 1;
			$call_done = 0;
	   
		
		$getcall_back_details = mysql_fetch_array(mysql_query("SELECT * FROM `call_schedule_report` WHERE quote_id = ".$id."  ORDER by id desc limit 0 , 1"));
		
		
		             if(date('i') <= '30') {
						$schedule_time_value_from = date('H').':00';
						$schedule_time_value_to = date('H').':30';
					}else{
						$schedule_time_value_from = date('H').':30';
						$schedule_time_value_to = date('H' ,strtotime('+1 hour')).':00';

					}

			$schedule_time_value = $schedule_time_value_from.'-'.$schedule_time_value_to;

					
		
				
			    $schedule_date = date('Y-m-d');
				$schedule_time = $schedule_time_value;
				$re_schedule = '2';
				
		
			$site_id = 	$getcall_back_details['site_id'];	
			$org_created_date = $getcall_back_details['org_created_date'];	
			//$time_type = 2;	
			$call_step = 	1;	
			$urgent_call = 	1;				
		
		$bool = mysql_query("update call_schedule_report set status ='0' , call_done ='0'  where quote_id=".$id."");
		add_call_schedule_report($id, $schedule_date , $schedule_time, $call_done, $take_call , $call_status , $re_schedule , $call_step ,$urgent_call,$site_id , $org_created_date,2 ,2); 
		
		
		$datas['message'] = $msg;
		$datas['class'] = 'success';
		$datas['status'] = $status;
        $datas['quote_id'] = $id;
        $datas['message_for'] = $datas['message'];
        $datas['type'] = "";
		callSchedulledByStatus($datas);
		echo $msg;	
	    add_quote_notes($id,$heading,$heading);	  
	}
	
	function send_ng_email($var) {
	    
	    $job_id = $var;
	    $var_string = '3|'.$job_id.'|true'; 
	    
	    $tmpdata =   select_email_template_data($var_string);
	  	$quote = mysql_fetch_array(mysql_query("select name,site_id , email , quote_for  from quote_new where booking_id=".($job_id).""));
	  	
	  	
	    $heading = 'RE Job#'.$job_id.'- No Guarantee Areas';
		add_job_notes($job_id,$heading,$heading);	 
		add_job_emails($job_id,$heading,$tmpdata,$quote['email']);
		
		sendmail($quote['name'],$quote['email'],$heading,$tmpdata,'bookings@bcic.com.au',$quote['site_id'],$quote['quote_for']);
		echo 'email send';
	}
	
	
	function send_ng_email__($var) {
	
		$job_id  = $var;
		$eol = "<br/>";
		$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".($job_id).""));
		$quote = mysql_fetch_array(mysql_query("select name,site_id , email , quote_for  from quote_new where booking_id=".($job_id).""));
		
		if($jobs['work_guarantee_text'] != '') {
			$work_guarantee_text = $jobs['work_guarantee_text'];
		}else {
			$work_guarantee_text = '';
		}
		
		if($quote['quote_for'] == 2 || $quote['quote_for'] == 4) {
			$term_condition_link = get_rs_value("quote_for_option","term_condition_link",$quote['quote_for']);
		}else {
		   $term_condition_link = get_rs_value("sites","term_condition_link",$quote['site_id']);
		}
		
		$link = '<a href='.$term_condition_link.' target="_blank">Click Here</a>';
		
		$str = '';
		$str .=  'Dear '.$quote['name'].''.$eol.'
		No Guarantee – RE Job #'.$job_id.''.$eol.'
		We are writing in regards to your Bond clean booked with us. No guarantee will be offered on –'.$work_guarantee_text.''.$eol.' By booking our service you agree to our Terms & Conditions that are listed on our website '.$link;
		//echo $str;
		//$heading = 'Send NG Email';
		$heading = 'RE Job#'.$job_id.'- No Guarantee Areas';
		add_job_notes($job_id,$heading,$str);	 
		add_job_emails($job_id,$heading,$str,$quote['email']);
		//"bookings@bcic.com.au"
		sendmail($quote['name'],$quote['email'],$heading,$str,'bookings@bcic.com.au',$quote['site_id'],$quote['quote_for']);
		echo 'email send';
	}
	
	function quote_call_search($var) {
		
		$vars = explode('|' , $var);
		
		$_SESSION['quote_call']['from_date'] = $vars[0];
		$_SESSION['quote_call']['to_date'] = $vars[1];
		
		if($vars[2] != '' && $vars[2] != 0) {
	    	$_SESSION['quote_call']['site_id'] = $vars[2];
		}else{
			$_SESSION['quote_call']['site_id'] = '';
		}
		
		 include('view_quote_call_queue.php');
	}
	
	function update_notes_id($var){
		$vars = explode('|',$var);
		$id = $vars[0];
		$checked = $vars[1];
		$table = $vars[2];
		
		 if($id !='' && $id != 0) {
			$bool = mysql_query("update $table set check_status =".$checked."   where id=".$id."");
		} 
	}
	
	function send_full_info($var){
			$job_id = $var;
			makejobTimeLine($job_id);
	}
	
	function sms_accept_terms_agreement($var)
	{
		$quote_id = $var;
		$quote = mysql_fetch_array(mysql_query("select booking_id ,phone , tc_link from quote_new where id=".mysql_real_escape_string($quote_id).""));
		
		$siteUrl = get_rs_value("siteprefs","site_url",1);		
		//$job_id =  get_rs_value("quote_new","booking_id",$quote_id);	
		$job_id =  $quote['booking_id'];	
		$tc_link =  $quote['tc_link'];	
        $dec_quote_id = base64_encode(base64_encode($quote_id));
		$shorturl = $siteUrl.'/tc/accept_terms_condition.php?action=tc&token='.$dec_quote_id;
	 
		if($tc_link != '') 
		{
			
			 $s_url = $tc_link;
			
		}
		 else
		{
             $s_url = createbitLink($shorturl,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json');			
			// $s_url = get_tiny_url($shorturl);
			 $bool = mysql_query("update quote_new set tc_link ='".$s_url."'  where id=".$quote_id."");
		}
		
		$linkUrl = '<a href='.$s_url.'>'.$s_url.'</a>'; 
		$str = '';
		//$str.= $eol;
		$str.= "Please accept our terms and conditions by clicking on this link.";
		
		$str_sms = $str.' '.$s_url;
		$str_notes = $str.' '.$linkUrl;
		
		$phone = $quote['phone'];
		$sms_code = send_sms(str_replace(" ","","$phone"),$str_sms);
		
			//$sms_code = send_sms(str_replace(" ","",$quote['phone']),$str_sms);
		
	    //$sms_code = send_sms(str_replace(" ","",1111111111),$str_sms);
         $heading = 'Send T&C  SMS to '.$quote['phone'];
		if($sms_code=="1"){ $heading.=" (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
		add_job_notes($job_id,$heading,$str_notes);
		echo $heading;
		
	}
	function job_sms_change($str){
		
		//echo $str;
		$str = explode('|',$str);
		$id = $str[0];
		$job_id  = $str[1];
		$eol = " ";
		$jobs = mysql_fetch_array(mysql_query("select * from jobs where id=".($job_id).""));
		$quote = mysql_fetch_array(mysql_query("select name,site_id , email,address  from quote_new where booking_id=".($job_id).""));
		
		if($jobs['work_guarantee_text'] != '') {
			$work_guarantee_text = $jobs['work_guarantee_text'];
		}else {
			$work_guarantee_text = '';
		}
		
		if($jobs['imagelink'] != '') {
			$imagelink = $jobs['imagelink'];
		}else {
			$imagelink = '';
		}
		
		//imagelink
		
		$term_condition_link = get_rs_value("sites","term_condition_link",$quote['site_id']);
		$link = '<a href='.$term_condition_link.' target="_blank">Click Here</a>';
		
		$get_str = array('$name','$jobid','$bgtext','$url','$imglink','$address','$balance');
        $replace_str = array($quote['name'],'#'.$job_id ,$work_guarantee_text,$term_condition_link,$imagelink,$quote['address'] ,$jobs['customer_amount']);

		
		$term_condition_link = get_rs_value("work_guarantee","work_guarantee_text",$id);
		
		$str = str_replace($get_str , $replace_str,strip_tags($term_condition_link));
		
		echo trim($str);
	}
	
	function send_sms_for_job_accept($vars){
		  
		 // echo $vars; die;
		  
		  $var  = explode('|' , $vars);
		  $id = $var[0];
		  $job_id = $var[1];
		  
		  $jobdetails = mysql_fetch_array(mysql_query("select staff_id ,job_date   from job_details where id=".($id).""));
		  $mobile = get_rs_value("staff","mobile",$jobdetails['staff_id']);
		  
		   $str = '';
		   $str.= "Please accept Job ".$job_id." Your job date  on ".changeDateFormate($jobdetails['job_date'] , 'datetime');

           //smsdate_for_job_accept

			$sms_code = send_sms(str_replace(" ","",$mobile),$str);
			$heading = 'Send SMS For Job Accepted on '.$mobile;
			//$sms_code = send_sms(str_replace(" ","",'1111111111'),$str);
			if($sms_code=="1"){ $heading.=" (Delivered)"; 
			    $datetime = date("Y-m-d H:i:s");
			    	$bool = mysql_query("update job_details set smsdate_for_job_accept ='".$datetime."'  where id=".$id."");
			    
			}else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  }
			
			
			
			 add_job_notes($job_id,$heading,$str);
			echo $heading;
		 
	}
	
	function getReviewEmailDetails($vars)
	{
		
		$var  = explode('|' , $vars);
	    $job_id = $var[0];
	    $type = $var[1];
		
		if($job_id != '' && $job_id > 0) {
			
			$quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=".mysql_real_escape_string($job_id).""));
			
			$toemailid = $quote['email'];
			
			$checkreviewsql = (mysql_query("select * from send_review_email where send_date = '".date('Y-m-d')."' AND email_id = '".$toemailid."'"));
			
			if(mysql_num_rows($checkreviewsql) == 0) {
			
						$short_code = get_rs_value('jobs','review_short_code',$job_id);

						if($short_code == '') {
							$review_short_code = base64_encode($job_id."__".$type."__".str_makerand ("3","3",true,false,true)); 
							$bool = mysql_query("UPDATE `jobs` SET `review_short_code` = '".$review_short_code."' WHERE `id` = ".$job_id."");

						}else{
						   $review_short_code = $short_code;
						}
			
			
								$url = get_rs_value('siteprefs','site_url',1);
								$link = $url."/review/index.php?tokenid=".$review_short_code;

								$str_find = array('$name' , '$address' , '$link');
								$str_replace = array($quote['name'] , $quote['address'] , $link);
								$msg = get_rs_value('bcic_email_template','email_value',2);
								$msg = trim(str_replace($str_find , $str_replace ,$msg)); 
								$subject = "Job#".$job_id."  ".$quote['address'];

								$message = ($msg);
					
						$addnoteheading = "Send Email review  to ".$toemailid." from admin check Yes (Payment Page)";

						add_job_notes($job_id,$addnoteheading,''); 
						add_job_emails($job_id, $addnoteheading, $message,$toemailid);
						
					sendmailbcic('BCIC',$toemailid,$subject,$message,"reviews@bcic.com.au","0",1);
					sendmailbcic('BCIC','manish@bcic.com.au',$subject,$message,"reviews@bcic.com.au","0" , 1); 
					sendmailbcic('BCIC','pankaj.business2sell@gmail.com',$subject,$message,"reviews@bcic.com.au","0" , 1); 
					

						$bool = mysql_query("update jobs set review_email_time='".date("Y-m-d h:i:s")."' where id=".$job_id."");
						echo "<p style='color:green'>Email review  to ".$toemailid.' send Successfully </p>'; 

						$tempQuoteDetails = mysql_query("insert into send_review_email(job_id , heading ,body,email_id,send_date, createdOn) value('".$job_id."','".$subject."','".$message."','".$quote['email']."','".date('Y-m-d')."' , '".date('Y-m-d H:i:s')."');");
			}
			
		}
				
	}
	
	function getQuoteQuestionsList($var){
		$varx = explode("|",$var);
		$quote_id = $varx[0];
		include("quote_questions.php");
	}
	
	
	
	/* function saveQuoteQuestions($var)
	{
		
		$varx = explode("|",$var); 
		
		$quote_id = $varx[0];
		$question_id = $varx[1];
		$quote_type = $varx[2];
		
		$quote_idkey = $varx[3];
		$quote_ans = $varx[4];
		
		//$result=array_diff($a1,$a2);
		
		$question_ids = explode(',' , $question_id);
		
		$admin = get_rs_value('admin','name' , $_SESSION['admin']);
	
		if($quote_type == 3){
			
			$table_name = 'jobs';
			$id = get_rs_value('quote_new', 'booking_id', $quote_id);
			$update_quote_new = mysql_query("UPDATE $table_name SET question_id='".mysql_real_escape_string($question_id)."' WHERE id='".$id."'");
			
		}else{
			
			$table_name = 'quote_new';
			$id = $quote_id;
			$update_quote_new = mysql_query("UPDATE $table_name SET question_id='".mysql_real_escape_string($question_id)."' , qus_key_id='".mysql_real_escape_string($quote_idkey)."', qus_ans='".mysql_real_escape_string($quote_ans)."' WHERE id='".$id."'");
		}
		
		$save_quote_questions = mysql_query("SELECT * FROM save_quote_questions WHERE quote_id='".$quote_id."' AND status=1");
			
		if(mysql_num_rows($save_quote_questions) > 0){

			$update_quote_questions = mysql_query("UPDATE save_quote_questions SET status = 0 WHERE quote_id='".$quote_id."' AND quote_type='".$quote_type."'");			
		}
		
		foreach($question_ids as $q_id){
			
			$quote_questions = mysql_fetch_assoc(mysql_query("SELECT question, quote_type FROM quote_question WHERE id='".$q_id."'"));
			
			$insert_quote_questions = mysql_query("INSERT INTO save_quote_questions SET quote_id='".$quote_id."', quote_type='".$quote_questions['quote_type']."', quote_question='".$quote_questions['question']."', question_id='".$q_id."', date='".date('Y-m-d H:i:s')."', status=1, admin='".$admin."' ");
				
		}
		
		 $insert_quote_questions1 = mysql_query("INSERT INTO save_quote_questions SET quote_id='".$quote_id."', quote_type='".$quote_questions['quote_type']."',  ques_id='".$quote_idkey."', ques_ans='".$quote_ans."', date='".date('Y-m-d H:i:s')."', status=1, admin='".$admin."' ");
		
		
		if($insert_quote_questions){
			echo 'Quote question added successfully';
		}
		else{
			echo 'Adding quote question failed, try again';
		}
	} */
	
	function saveQuoteQuestions($var){
		
		$varx = explode("|",$var); 
		$quote_id = $varx[0];
		$question_id = $varx[1];
		$quote_type = $varx[2];
		
		$question_ids = explode(',' , $question_id);
		
		$admin = get_rs_value('admin','name' , $_SESSION['admin']);
	
		if($quote_type == 3){
			
			$table_name = 'jobs';
			$id = get_rs_value('quote_new', 'booking_id', $quote_id);
		}
		else{
			$table_name = 'quote_new';
			$id = $quote_id;
		}
		
		$update_quote_new = mysql_query("UPDATE $table_name SET question_id='".mysql_real_escape_string($question_id)."' WHERE id='".$id."'");
		
		$save_quote_questions = mysql_query("SELECT * FROM save_quote_questions WHERE quote_id='".$quote_id."' AND status=1");
			
		if(mysql_num_rows($save_quote_questions) > 0){
			
			//$delete_quote_questions = mysql_query("DELETE FROM save_quote_questions WHERE quote_id='".$quote_id."'");	
			$update_quote_questions = mysql_query("UPDATE save_quote_questions SET status = 0 WHERE quote_id='".$quote_id."' AND quote_type='".$quote_type."'");			
		}
		
		foreach($question_ids as $q_id){
			
			$quote_questions = mysql_fetch_assoc(mysql_query("SELECT question, quote_type FROM quote_question WHERE id='".$q_id."'"));
			
			$insert_quote_questions = mysql_query("INSERT INTO save_quote_questions SET quote_id='".$quote_id."', quote_type='".$quote_questions['quote_type']."', quote_question='".$quote_questions['question']."', question_id='".$q_id."', date='".date('Y-m-d H:i:s')."', status=1, admin='".$admin."' ");
				
		}
		
		if($insert_quote_questions){
			echo 'Quote question added successfully';
		}
		else{
			echo 'Adding quote question failed, try again';
		}
	}
	
	function search_cleaning_amt_report($var){
		
		$vars = explode('|' , $var);
		
		$site_id = $vars[0];
		$staff_id = $vars[1];
		$amt_report_from = $vars[2];
		$amt_report_to = $vars[3]; 
		$stafftype = $vars[4]; 
		
		if($site_id != '' && $site_id != 0) {
		  $_SESSION['amt_report']['site_id'] = $site_id;
		}else{
			unset($_SESSION['amt_report']['site_id']);
		}
		
		if($staff_id != '' && $staff_id != 0) {
		  $_SESSION['amt_report']['staff_id'] = $staff_id;
		}else{
			unset($_SESSION['amt_report']['staff_id']);
		}
		
		if($amt_report_from != '') {
		  $_SESSION['amt_report']['amt_report_from'] = $amt_report_from;
		}else{
			unset($_SESSION['amt_report']['amt_report_from']);
		}
		
		if($amt_report_to != '') {
		  $_SESSION['amt_report']['amt_report_to'] = $amt_report_to;
		}else{
			unset($_SESSION['amt_report']['amt_report_to']);
		}
		
		if($stafftype != '' && $stafftype != '0') {
		  $_SESSION['amt_report']['staff_type_all'] = $stafftype;
		}else{
			unset($_SESSION['amt_report']['staff_type_all']);
		}
		
		include('view_cleaning_amt_report.php');
		
	}
	
	function search_imagelink($var){
		$vars = explode('|' , $var);
		
		$site_id = $vars[0];
		$jobdate_from = $vars[1];
		$jobdate_to = $vars[2];
		
		if($site_id != '' && $site_id != 0) {
		  $_SESSION['imagelink']['site_id'] = $site_id;
		}else{
			unset($_SESSION['imagelink']['site_id']);
		}
		
		if($jobdate_from != '') {
		  $_SESSION['imagelink']['jobdate_from'] = $jobdate_from;
		}else{
			unset($_SESSION['imagelink']['jobdate_from']);
		}
		
		if($jobdate_to != '') {
		  $_SESSION['imagelink']['jobdate_to'] = $jobdate_to;
		}else{
			unset($_SESSION['imagelink']['jobdate_to']);
		}
		
		
		include('view_imagelink.php');
	}
	
		function get_staff_fixed_rates($var) {
			$site_id = $var;
			include('staff_fixed_rates.php');
		}
		
		
		function getInvoiceDetails($var){
			
			$vars = explode('|' , $var);
			/* print_r($vars);
			 die;
			  */
			$staff_id = $vars[0];
			$quote_id = $vars[1];
			//$staff_id = $vars[2];
			
			echo invoice_email($quote_id,'',"false", "", "", $staff_id);
				
		}
		
		
		function get_sale_sms_report($var){
		 
			$vars = explode('|',$var);
			//print_r($vars);
			 
			if($vars[0] != '') {
			   $_SESSION['sale_sms_report']['from_date'] = $vars[0];
			}else{
			  unset($_SESSION['sale_sms_report']['from_date']);   
			}
		   
			if($vars[1] != '') {
			   $_SESSION['sale_sms_report']['to_date'] = $vars[1];
			}else{
			  unset($_SESSION['sale_sms_report']['to_date']);   
			}
			
			if($vars[2] != '') {
			   $_SESSION['sale_sms_report']['call_id'] = $vars[2];
			}else{
			  unset($_SESSION['sale_sms_report']['call_id']);   
			}
			 
			 include('view_sale_sms_report.php');	 
	}
	
	function stop_sales_sms($var){
		
		$quid = $var;	
		$adminname = get_rs_value('admin','name' , $_SESSION['admin']);
		$heading = 'Sales SMS Stop by '.$adminname;
		add_quote_notes($quid,$heading,$heading);
		$bool1 = mysql_query("update quote_new set reply_status ='1' where id=".mres($quid));	
		echo '<p>Sales contact SMS stop</p>';		
		
	}
	
	function real_estate_report($var){
		
		$vars = explode('|', $var);
		
		//print_r($vars);
		
		$siteid = $vars[0];
		$search_val = $vars[1];
		$from_date = $vars[2];
		$todate = $vars[3];
		
		if($siteid != 0 && $siteid != '') {
			 $_SESSION['realestate']['siteid'] = $siteid;
		}else{
			$_SESSION['realestate']['siteid'] = '0';
		}
		
		if($search_val != '') {
			 $_SESSION['realestate']['search_val'] = $search_val;
		}else{
			$_SESSION['realestate']['search_val'] = '';
		}
		
		$_SESSION['realestate']['jobdate_from'] = $from_date;
		$_SESSION['realestate']['jobdate_to'] = $todate;
		
		include('view_real_estate_report.php');	 
		
	}
	
	function get_report_dashboard($var){
		$vars = explode('|', $var);
		
		$from_date = $vars[0];
		$todate = $vars[1];
		
		$_SESSION['dashboard_report']['from_date'] = $from_date;
		$_SESSION['dashboard_report']['to_date'] = $todate;
		//print_r($_SESSION['dashboard_report']);
		
		include('view_report_dashboard.php');	 
		//print_r($_SESSION['dashboard_report']);
		
	}
	
	function enquiry_send_to_cbd11111111($var){
		$id = $var;
		$details_data = mysql_fetch_assoc(mysql_query("select * from quote_new where id=".mysql_real_escape_string($id).""));
		
		if(!empty($details_data)) {
		//print_r($details_data);
		
				//API URL
				//$url = 'http://www.example.com/api';
				$url = 'http://crm.cbdmover.com.au/cbd-production/get-leads.php';
				//$url = 'https://www.bcic.com.au/admin/crons/get_api.php';

				//create a new cURL resource
				$ch = curl_init($url);
            //Format(DD/MM/YYYY)
				//setup request to send json via POST
				$data = array(
						'CustomerName' => $details_data['name'],
						'Email' => $details_data['email'],
						'Mobile' => $details_data['phone'],
						'PickupAddress' => $details_data['moving_from'],
						'DropoffAddress' => $details_data['moving_to'],
						'MoveDate' => date('d/m/Y' , strtotime($details_data['booking_date'])),
						'Message' => $details_data['comments'],
						'Token_key' => 'Procbd2019-7791-XqTp9-8qxR5-9C2rT'
				);
				$payload = json_encode(array("user" => $data));

				//attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

				//set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

				//return response instead of outputting
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				//execute the POST request
				$result = curl_exec($ch);

				//close cURL resource
				curl_close($ch);
				
				echo  date('Y-m-d H:i:s');
				//print_r($result);
				$bool1 = mysql_query("update quote_new set removal_enquiry_date ='".date('Y-m-d H:i:s')."' , enquiry_data ='".$payload."' where id=".mres($id));	
		}
		
	}
	
	
	function enquiry_send_to_cbd($var){
		
		$id = $var;
		$details_data = mysql_fetch_assoc(mysql_query("select * from quote_new where id=".mysql_real_escape_string($id).""));
		
		if(!empty($details_data)) {
		
		         $url = 'https://crm.cbdmover.com.au/cbd-production/get-leads.php';
				 $ch = curl_init($url);
					$payload = json_encode( array("CustomerName"=>$details_data['name'],
					"Email"=>$details_data['email'],
					"Mobile"=>$details_data['phone'],
					"PickupAddress"=>$details_data['moving_from'],
					"DropoffAddress"=>$details_data['moving_to'],
					"MoveDate"=> date('d/m/Y' , strtotime($details_data['booking_date'])),
					"Message"=>$details_data['comments'],
					"Token_key" => "Procbd2019-7791-XqTp9-8qxR5-9C2rT"));
					curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
					curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
					$result = curl_exec($ch);
					curl_close($ch);
					
					 $joson = json_decode($result, true);
					 
				 if($joson['Success'] == 'True' && $joson['ResponseID'] > 0)	{	 
					
                        $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
                        $heading = 'Removal Quote Lead Send to CBD By '.$staff_name;
                        add_quote_notes($id,$heading,$heading);
                        
                        $bool1 = mysql_query("update quote_new set removal_enquiry_date ='".date('Y-m-d H:i:s')."' ,  cbd_responseid ='".$joson['ResponseID']."', enquiry_data ='".$payload."' where id=".mres($id));	
                        echo  date('Y-m-d H:i:s');
				 }else{
				     echo 'Not Sent';
				 }
		}
		
	}
	
	function view_quote_admin_denied($var) {
	   
		 $strvalue = explode('|',$var); 
		
		  $step = get_rs_value("quote_new","step",$strvalue[1]);
		
		 if($step == 6) {
			 $typeid = 91;
		 }elseif($step == 5) {
		     $typeid = 93;
		 }elseif($step == 7) {
		     $typeid = 94;
		 }
		
		$getResponse = mysql_fetch_assoc(mysql_query("SELECT name FROM `system_dd` where type = $typeid AND  id =".mysql_real_escape_string($strvalue[0])));
		
		  $quoteName = get_rs_value("quote_new","name",$strvalue[1]);
		 
			if($getResponse['name'] != '') {
			    $type = $getResponse['name'];
			}else {
				$type = 'Defult';
			}
			
			$stepType = get_sql("system_dd","name"," where type='31' AND id='".$step."'");
			
		$heading = "Quote  ".$type." in $stepType response type";
		$comment = "Quote  ".$type." in $stepType response type";
		add_quote_notes($strvalue[1],$heading,$comment);
		$bool = mysql_query("update quote_new set denied_id='".$strvalue[0]."' where id=".mres($strvalue[1])."");
	    echo $strvalue[0];
		 
	}
	
	
	function send_frenchaie_report($var){
		
		//echo $var;
		sendFranchiseReport($var);
	}
	
	function franchise_report_gererate($var){
		  geerateInvoicefranchisePDF($var);
		include('view_franchise_report.php');	 
	}
	
	function getNotificationAll(){
				
			$count = 0;
			$notification= ("select * from site_notifications where notifications_status = '0'  AND notifications_type IN (0,2,3,4) "); 

			$notificationText = mysql_query($notification);

			$countnotef = mysql_num_rows($notificationText);
			if($countnotef > 0)	 {
			$count =  $countnotef;
			}
			echo $count;
	}
	
	function amount_refund($var){
		
		echo $var; 
		$vars = explode('|',$var);
		$amount = $vars[0];
		$comments = mysql_real_escape_string($vars[1]);
		$job_id = $vars[2];
		$fault_status = $vars[3];
		$transaction_id = $vars[4];
		$cleanername = $vars[5];
		
		$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$heading = $amount.'  Refund By '.$staff_name.' and transaction id ('.$transaction_id.')';
		add_refund_payment_notes($job_id,$heading,$comments, $amount , $fault_status , $transaction_id , $cleanername);
		add_job_notes($job_id,$heading,$comments);
		
		$admin_name = get_rs_value("admin","name",$_SESSION['admin']);
		$notificationArrayData = array(
			'notifications_type' => 5,
			'quote_id' => 0,
			'job_id' => mysql_real_escape_string($job_id),
			'staff_id' => 0,
			'all_chat_type'=>'8',
			'heading' => $heading,
			'comment' => $heading,
			'notifications_status' => 0,
			'login_id' => $_SESSION['admin'],
			'staff_name' => $admin_name,
			'date' => date("Y-m-d H:i:s")
		);
		
	   add_site_notifications($notificationArrayData);
		
		include('xjax/view_refund_amount.php');
	}
	
	function refund_status_changes($var) {
		
		$vars = explode('|',$var);
		$stepid = $vars[0];
		$id = $vars[1];
		$job_id = get_rs_value("refund_amount","job_id",$id);
		$status_name = getSystemvalueByID($stepid,96);
		$heading = 'Status changes '.$status_name;
		add_job_notes($job_id,$heading,$heading);
		$bool = mysql_query("update refund_amount set status='".$stepid."'  , payment_status_date='".date('Y-m-d H:i:s')."'  where id=".mres($id)."");
		echo  $stepid;
	}
	function delete_payment_refund($id){
		
		$job_id = get_rs_value("refund_amount","job_id",$id);
		//echo  "update refund_amount set is_deleted='0' where id=".mres($id)."";
		$bool = mysql_query("update refund_amount set is_deleted='0' where id=".mres($id)."");
		$heading = 'Refunded Amount and  Comment deleted';
		add_job_notes($job_id,$heading,$heading);
		include('xjax/view_refund_amount');
		
	}
	
	function payment_refund_job_status($vas){
		
		 $vars = explode('|', $vas);
		
		$statusid = $vars[0];
		$id = $vars[1];
		
		$job_id = get_rs_value("refund_amount","job_id",$id);
		$bool = mysql_query("update refund_amount set payment_job_status=".$statusid." where id=".mres($id)."");
		
		 $payment_job_status_name = getSystemvalueByID($statusid,98);
		 
		$heading = 'Refunded Amount and  Status Change '.$payment_job_status_name;
		add_job_notes($job_id,$heading,$heading);
		include('xjax/view_refund_amount');
	}
	
	function get_review_roport_notes($var){
		 
		$vars = explode('|',$var);
		
		//print_r($vars); die;
		 
		 if($vars[0] != '') {
		   $_SESSION['review_report_notes']['from_date'] = $vars[0];
	    }else{
		  unset($_SESSION['review_report_notes']['from_date']);   
	    }
	   
	    if($vars[1] != '') {
		   $_SESSION['review_report_notes']['to_date'] = $vars[1];
	    }else{
		  unset($_SESSION['review_report_notes']['to_date']);   
	    }
		
		if($vars[2] != '') {
		   $_SESSION['review_report_notes']['fault_type'] = $vars[2];
	    }else{
		  unset($_SESSION['review_report_notes']['fault_type']);   
	    }
		
		
		
		if($vars[3] != '' && $vars[3] != 0) {
		   $_SESSION['review_report_notes']['staff_type'] = $vars[3];
	    }else{
		  unset($_SESSION['review_report_notes']['staff_type']);   
	    }
		
		if($vars[4] != ''  && $vars[4] != 0) {
		   $_SESSION['review_report_notes']['staff_id'] = $vars[4];
	    }else{
		  unset($_SESSION['review_report_notes']['staff_id']);   
	    }
		
		if($vars[5] != '') {
		   $_SESSION['review_report_notes']['rating'] = $vars[5];
	    }else{
		  unset($_SESSION['review_report_notes']['rating']);   
	    }
	
         //  print_r($_SESSION['review_report_notes']);	
		 
		 include('view_review_reports_notes.php'); 
		 
	}
	
	
	function send_review_email_report($var) {
		
		    $vars = explode('|',$var);
			$datefrom = $vars[0];
			$fromto = $vars[1];
			$faluttype = $vars[2];
			$content = send_reviewform($datefrom , $fromto , $faluttype);
		//	$staff_emailid = "bookings@bcic.com.au";
			 $staff_emailid = "reviews@bcic.com.au";
			$subject = changeDateFormate($datefrom , 'datetime') . ' to '.changeDateFormate($fromto , 'datetime').' Review fault Report'; 	
			sendmailbcic("Review fault Report",'pankaj.business2sell@gmail.com',$subject,$content,$staff_emailid,"0"); 
			sendmailbcic("Review fault Report",'nadia@bcic.com.au',$subject,$content,$staff_emailid,"0"); 
		    echo '<p>Send Review Report</p>';		
	}
	
	function refund_payment($var)
	{
		
		  include($_SERVER['DOCUMENT_ROOT']."/admin/source/include_eway.php");
			 	$vars = explode('|',$var);
				$job_id = $vars[0];
				$refund_id = $vars[1];
				
			
				
			 $getrefunddata =  mysql_fetch_array(mysql_query("select amount ,refund_status ,  transaction_id from refund_amount where id=".mres($refund_id).""));
			
			
			if(!empty($getrefunddata)) {
				
				if($getrefunddata['amount'] > 0) {
				
						if($getrefunddata['refund_status'] == 0) {
					
								$apiKey = 'F9802AxK0ruzK2uUtcnSa7s7wJGrjG2WcOVXw0Pox5ATuMfqf+7lZrKlR01TCHROHYBAc1';
								$apiPassword = 'WKllXwKL'; 

								$apiEndpoint = \Eway\Rapid\Client::MODE_PRODUCTION;
								$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);
						
								 $refund = [
									'Refund' => [
									'TransactionID' => $getrefunddata['transaction_id'],
									'TotalAmount' => $getrefunddata['amount']*100,
									'InvoiceNumber' => $job_id,
									'InvoiceDescription' => 'Refund initiated',
									'InvoiceReference' => $job_id,
									'CurrencyCode' => 'AUD'
								   ],
								];

								 $response = $client->refund($refund);  
								 
							
								
								 $refumessage = explode(',' ,$response->ResponseMessage);
								
								 $responseMsg =  \Eway\Rapid::getMessage($refumessage[0]);
								 
								
								
								if(($response->ResponseCode=="00") || ($response->ResponseCode=="08")){
									
									$datetime = date('d_m_Y-H_i_s');
									$filename = 'Transaction-Details-Report-'.$job_id.'_'.$datetime.'.pdf';
									
									 $tpl_response =  getrefundtemplate($response , $filename);
									
									
									$totalamount = 0;
									$amtrefund = ($totalamount - $getrefunddata['amount']);
									
									$TransactionID = $response->TransactionID;
									
									
									
									$bool = mysql_query("update refund_amount set refund_payment_status = 'SUCCESS',  eway_data = '".$tpl_response."',  refund_status = 1,  reason_message = '".$responseMsg."', filename = '".$filename."', refund_payment_date = '".date('Y-m-d :H:i:s')."',  refund_response_code = '".$response->ResponseCode."' where id=".$refund_id." AND job_id = ".$job_id."");
									
									$flag = '<span style="color: #11b211;">success</span>';
									
									$bool11 = mysql_query("insert into job_payments set job_id=".$job_id.", transaction_type= 'refund', transaction_id='".$TransactionID."', payment_method='Credit Card', date='".date("Y-m-d")."',amount='".$amtrefund."', taken_by='BCIC'");
									
								
								}else {
									  $flag = '<span style="color: #ea1717;">failed</span>';
								}
								
								
								$heading = 	'Transaction Approved Amount ' .$getrefunddata['amount'].' is '.$flag.' <br/> ('.$responseMsg.')';
								
								add_job_notes($job_id,$heading,$heading);
								echo $responseMsg;
						}else {
							echo 'already refunded...';
						}
				}
			} 
	}
	
	//id	job_id	quote_id	date	heading	comment	login_id	staff_name	type
	
	function add_3pmcehck_notes($var){
		
		$vars = explode('|',$var);
		$id = $vars[0];
		$type = $vars[1];
		include('3pm_cehck_notes.php');
		
	}
	
	function add_quote_cehck_notes_comment($var){
		
		$vars = explode('|',$var);
		$comment = mysql_real_escape_string(addslashes($vars[0]));
		
		$jdetailsid = $vars[1];
		$jobid = $vars[2];
		$qid = $vars[3];
		$type = $vars[4];
		
		$id = $jdetailsid;
		
		$getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check FROM `job_details` where id = ".$jdetailsid.""));
		$heading = 'Add '.$getjobdetails['job_type'].' Job Notes';
		add_3pm_notes($jobid , $qid , $jdetailsid , $type , $comment, $heading);
		include('3pm_cehck_notes.php');
	}
	
	function cehck_3pm_report($var) {
		
		$_SESSION['cehck_report']['today'] = $var;
		include('view_check_report.php');
	}
	
	function cehck3pM($var){
		
		$vars = explode('|' , $var);
		
		/* print_r($vars);
		die; */
			$id = $vars[0];
			$type = $vars[1];
			
		if($type == 1) {	
			 $getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check ,next_day_admin_cehck FROM `job_details` where id = ".$id.""));
			
			if(!empty($getjobdetails)) {
				 
				if($getjobdetails['admin_check'] == 0) {
					  $admin_check = 1;
					  $check_val = 'Today job Check';
				}else {
					 $admin_check = 0;  
					  $check_val = 'Today job  UnCheck';
				}
				
				$bool = mysql_query("update job_details set admin_check=".$admin_check." where id=".mres($id)."");  
			}
			$adminname = get_rs_value("admin","name",$_SESSION['admin']);
			
			$comment = $check_val .' '.$getjobdetails['job_type'].' Job By '.$adminname;
			
			add_3pm_notes($getjobdetails['job_id'] , $getjobdetails['quote_id'] , $id , $type , $comment , $comment);
			
		}else if($type == 2) {
			
			$getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check ,next_day_admin_cehck FROM `job_details` where id = ".$id.""));
			
			if(!empty($getjobdetails)) {
				 
				if($getjobdetails['next_day_admin_cehck'] == 0) {
					  $admin_check = 1;
					  $check_val = 'Next day job Check';
				}else {
					 $admin_check = 0;  
					  $check_val = 'Next day job UnCheck';
				}
				
				$bool = mysql_query("update job_details set next_day_admin_cehck=".$admin_check." where id=".mres($id)."");  
			}
			$adminname = get_rs_value("admin","name",$_SESSION['admin']);
			
			$comment = $check_val .' '.$getjobdetails['job_type'].' Job By '.$adminname;
			
			add_3pm_notes($getjobdetails['job_id'] , $getjobdetails['quote_id'] , $id , $type , $comment , $comment);
		}else if($type == 3) {
			
			$getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , job_type , quote_id , admin_check  FROM `job_reclean` where id = ".$id.""));
			
			if(!empty($getjobdetails)) {
				 
				if($getjobdetails['admin_check'] == 0) {
					  $admin_check = 1;
					  $check_val = 'Re-Clean job Check';
				}else {
					 $admin_check = 0;  
					  $check_val = 'Re-Clean job UnCheck';
				}
				
				$bool = mysql_query("update job_reclean set admin_check=".$admin_check." where id=".mres($id)."");  
			}
			$adminname = get_rs_value("admin","name",$_SESSION['admin']);
			
			$comment = $check_val .' '.$getjobdetails['job_type'].' Job By '.$adminname;
			
			add_3pm_notes($getjobdetails['job_id'] , $getjobdetails['quote_id'] , $id , $type , $comment , $comment);
		}
			echo $admin_check; 
		
	}
	
	function sales_stages($vars){
			 $var = explode('|',$vars);
				$stage = $var[0];
				$id = $var[1];
				
				if($id != '' && $id != 0) {
					$bool = mysql_query("update  sales_task_track set stages =".$stage."   where id=".$id."");
					
							$getsales_follow = mysql_fetch_assoc(mysql_query("Select id ,quote_id , fallow_date ,fallow_time, task_manager_id from sales_task_track where id=".$id.""));

							$quote_id = $getsales_follow['quote_id'];
							$task_manager_id = $getsales_follow['task_manager_id'];
							$fallow_date = $getsales_follow['fallow_date'];
							$fallow_time = $getsales_follow['fallow_time'];
			               $response_type = 12;
			 //   $bool = mysql_query("update sales_task_track set $fname ='".date('Y-m-d H:i:s')."' , stages = ".$stage."   where id=".$id."");
			          add_task_manager($id , $quote_id  , 1 , $fallow_date , $fallow_time ,$response_type ,$task_manager_id ,  0);
				}
		echo $stage;		
	}
	 
	function set_message_type($var) {
		 $vars = explode('|' , $var);
		 $id = $vars[0];
		 $fname = $vars[1];
		 $bool = mysql_query("update sales_system set $fname ='".date('Y-m-d H:i:s')."'   where id=".$id."");
		 //echo '<p style="color: #ffff;">'.date('Y-m-d H:i:s').'</p>';
		 include('view_task_manager.php');
	}
	 
	 
	function check_adminlogin(){

		
		if($_SESSION['admin'] != '' && $_SESSION['logtime'] != '') {
		    
			mysql_query ("UPDATE `admin_logged` SET `out_time` = '".date("Y-m-d H:i:s")."' WHERE logtime  = ".$_SESSION['logtime']." AND admin_id = ".$_SESSION['admin']."");
		  
    		mysql_query("update admin set loggedin ='".date('Y-m-d H:i:s')."' , login_status = 1 where id=".$_SESSION['admin']."");
		}
	}
	 
		function get_notification($str)
		{  
			   include('hr_notification.php');
		}
		
	function send_refund_emails($var)
	{	
		$id = $var;
		$getrefunddetails = mysql_fetch_assoc(mysql_query("SELECT id, job_id , filename , eway_data FROM `refund_amount` where id = ".$id.""));
		
		//print_r($getrefunddetails); die;
		 if(!empty($getrefunddetails)) {
			 
			 $getjobdetails = mysql_fetch_assoc(mysql_query("SELECT id, booking_id , name , email FROM `quote_new` where booking_id = ".$getrefunddetails['job_id'].""));
			
			 
			 $subject = 'Refund Amount of (J#'.$getrefunddetails['job_id'].')';
			 
			$folder = $_SERVER['DOCUMENT_ROOT'].'/refund/';
		    $filePath = $folder.$getrefunddetails['filename'];
			$filename = $getrefunddetails['filename'];
			 
			//$message = base64_decode($getrefunddetails['eway_data']);
			$message = '';
			
			sendmailwithattach_staff_invoce1($getjobdetails['name'],$getjobdetails['email'],$subject,$message,'noreply@bcic.com.au',$filePath , $filename);
			$heading = 'Send Refund email with pdf';
			add_job_notes($getrefunddetails['job_id'],$heading,$heading); //email_date
			mysql_query("update refund_amount set email_date ='".date('Y-m-d H:i:s')."'  where id=".$id."");
			echo  date('Y-m-d H:i:s');
			 
		 }else{
			 echo 'No Record';
		 }
		
	}	
	
	function searchEmailreport($var){
		$vars = explode('|' , $var);
		
		$_SESSION['email_report_data']['from_date'] = $vars[0];
		
		if($vars[1] != 0) {
		   $_SESSION['email_report_data']['admin_id']= $vars[1];
		}else {
			unset($_SESSION['email_report_data']['admin_id']);
		}
		include('view_email_report.php');
	}
	
	function dailyemailreport($str){
		
		$_SESSION['daily_email_report_data']['from_date'] = $str;
		include('view_daily_send_email_report.php');
	}
	
	function search_tasklist($val) {
		//echo  $val;
		
		$vars =  explode('|' , $val);
		
		// print_r($vars);
		
		 $val = $vars[0];
		 $type = $vars[1]; 
		
		if($type == 1) {
			 if($val != '') {
				$_SESSION['task_manage']['value'] = $val;
			 }else{
				 $_SESSION['task_manage']['value'] = '';
				 unset($_SESSION['task_manage']['value']);
			 }
		   include('view_task_manager.php'); 
		}else{
			
			//echo 'sdsd'; die;
			
			if($val != '') {
				$_SESSION['task_sales']['value'] = $val;
			 }else{
				 $_SESSION['task_sales']['value'] = '';
				 unset($_SESSION['task_sales']['value']);
			 }
			 
			//print_r($_SESSION['task_sales']['value']);
			
		   include('view_sales_system.php'); 
		}
		   
		
	}
	
	function cehck_account_realestate($var) {
		//real_estate_agency_name agent_name agent_number agent_email agent_address agent_landline_num
		
		$vars = explode('|',$var);
		
		$id = $vars[0];
		$jobid = $vars[1];
		
		$sql = mysql_query("SELECT id , job_id , real_estate_agency_name, agent_name, agent_number ,agent_email ,agent_address, agent_landline_num FROM `job_details` WHERE job_id =  ".$jobid."  AND (agent_email != '' OR agent_landline_num !='' OR agent_number != '')  ORDER BY `id` DESC LIMIT  0 , 1");
		
		if(mysql_num_rows($sql) > 0) {
		  $count = mysql_num_rows($sql);
	  	  echo  $id;
		}else{
			echo 0;
		}
	}
	
	function paymentByToken($var) {
		//  echo  $var; die;
		  
		   include($_SERVER['DOCUMENT_ROOT']."/admin/source/include_eway.php");
		   
				$apiKey = 'F9802AxK0ruzK2uUtcnSa7s7wJGrjG2WcOVXw0Pox5ATuMfqf+7lZrKlR01TCHROHYBAc1';
				$apiPassword = 'WKllXwKL'; 

				
		   
			 	$vars = explode('|',$var);
				
				//print_r($vars); die;
				
				$checkeway_token = $vars[0];
				$amt = $vars[1];
				$jobid = $vars[2];
				
			
						$arg_ins = "insert into payment_gateway(job_id,date,amount,ip,cc_name,charge_type)";
						$arg_ins .=" values(".$jobid.",'".date("Y-m-d")."','".$amt."','".$_SERVER['REMOTE_ADDR']."','Token Charge',2)";
						$ins = mysql_query($arg_ins);
						$payment_gateway_id = mysql_insert_id();  
	
						     if($amt>0)
						    {

								//$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);
								$apiEndpoint = \Eway\Rapid\Client::MODE_PRODUCTION;
								$client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);
								
								//print_r($client); die;

								$transaction = [
									'Customer' => [
									'TokenCustomerID' => $checkeway_token,
									],
									'Payment' => [
										'TotalAmount' => $amt*100,
										'InvoiceReference' => " Job Id ".$jobid,
									],
									'TransactionType' => \Eway\Rapid\Enum\TransactionType::RECURRING,
								];

								$response1 = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::DIRECT, $transaction);
								
								//print_r($response1); die;
								
							    if(($response1->ResponseCode=="00") || ($response1->ResponseCode=="08")){	
								    
									  $TransactionID = $response1->TransactionID;
								
										$bool = mysql_query("update payment_gateway set status=1 where id=".$payment_gateway_id);


										$responseCode = $response1->ResponseCode;
										$responseMsg =  \Eway\Rapid::getMessage($response1->ResponseMessage);
										$responseresult = serialize(base64_encode($response1));
										$queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
										$queryresult .=" values(".$jobid.",'".$responseCode."','".$responseMsg."','Success')";
										mysql_query($queryresult);

										$uarg = "update jobs set customer_paid_amount='".$amt."', customer_paid=1, customer_paid_date='".date("Y-m-d")."', customer_payment_method='Credit Card' where id='".$jobid."'";  //die;
				                        $bool = mysql_query($uarg);
										 
										$bool = mysql_query("insert into job_payments set job_id=".$jobid.", transaction_type= 'Credit', transaction_id='".$TransactionID."', payment_method='Credit Card', date='".date("Y-m-d")."',amount='".$amt."', taken_by='BCIC'");
										add_job_notes($jobid,"Payment of ".$amt." take by Credit Card ",''); 
										
				                        $message = "Invoice has been charged and paid successfully"; 
										//$step=2;
							    }
								else
								{  

										//$step=1; 
										$errorData = array();
										foreach ($response1->getErrors() as $error) {
										$errorData[] =   \Eway\Rapid::getMessage($error);
										$_SESSION['query[txt]'] = \Eway\Rapid::getMessage($error);
										}
										$errorMsgData = implode(',',$errorData);
																				
										$bool = mysql_query("update payment_gateway set result_text='". $errorMsgData."' , status=0 where id=".$payment_gateway_id);
										//Insert data and response for  Payment failed in eway_responses
										$responseCode = $response1->ResponseCode;
										$responseMsg =  \Eway\Rapid::getMessage($response1->ResponseMessage);
										$responseresult = serialize(base64_encode($response1));
										$queryresult = "insert into eway_responses(job_id,response_code,response_code_message,status)";
										$queryresult .=" values(".$jobid.",'".$responseCode."','".$responseMsg."','failed')";
										mysql_query($queryresult);	
										
										$message = "Payment failed"; 


						        }  
							}else{
								$message = "Payment failed";
							}
							
					//echo  '<p style="font-weight: 600;font-size: 15px;color: #f15050;">'.$message.'</p>';
					echo  $message;
	}
	function cehck_avail_sms($var) {
		  $vars = explode('|',$var);
		 // print_r($vars);
		  $qid = $vars[0];
		  $sid = $vars[1];
		  $jdate = $vars[2];
		  $subrb = $vars[3];
		  //$sname = get_rs_value("staff","name",$sid);
		  
		  $sdata = mysql_fetch_assoc(mysql_query("select id, name , mobile  from staff where id = ".$sid.""));
		
		    $text = 'Q#'.$qid.', Hello '.$sdata['name'].', are you available to accept a job for '.changeDateFormate($jdate , 'datetime').' in '.$subrb.'? Please call office at your earliest to confirm. First Come First Serve';
			
			
			$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$sdata['id']."'"));
			
			
				$result['user_to'] = $sdata['name'];	
				$result['chatter'] = $sdata['id'];
				$result['admin_id'] = $_SESSION['admin'];
				$result['admin'] = 'admin';
				//$result['job_id'] = $job_id;
				
				
				if($getlogin_device['deviceid'] != '') {
					$datetime = date("Y-m-d H:i:s");
			    	$bool = mysql_query("update quote_new set send_cehck_avail_staff ='".$datetime."'  where id=".$qid."");
					
					$heading = 'Send Confirm availability notification to '.$sdata['name'];
					$heading.=" (Notification Delivered)"; 
					
					//$flag = 1; 
					$result['deviceid'] = $getlogin_device['deviceid'];
					sendNotiMessage($text , $result);
					add_quote_notes($qid,$heading,$text); 
					 echo $datetime; 
				}else{
					 echo 'Not Sent';
				}
			
			
		   //$sms_code = send_sms('1111111111',$text);	 
		  //$sms_code = send_sms(str_replace(" ","",$sdata['mobile']),$text);	 send_cehck_avail_staff
		  /* $heading = 'Send Confirm availability to '.$sdata['name'] .' On '.$sdata['mobile'];
		  if($sms_code=="1"){ $heading.=" (Delivered)"; 
			    $datetime = date("Y-m-d H:i:s");
			    	$bool = mysql_query("update quote_new set send_cehck_avail_staff ='".$datetime."'  where id=".$qid."");
			   echo $datetime; 
			}else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";  
			 echo 'Not Sent';
			}
			
			add_quote_notes($qid,$heading,$text); */ 
		  
	}
	
	function check_status($var) {
		
		$varx = explode("|",$var);
		$value = mysql_real_escape_string($varx[0]);
		$fieldx= explode(".",$varx[1]);
		$table = $fieldx[0];
		$field = $fieldx[1];
		$id=$varx[2];
		$type=$varx[3];
		
		//print_r($varx);
		
		//5|jobs.status|4746
		
		if($type == 1) {
			$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
			$getname11 = get_sql("system_dd","name"," where type='26' AND id='".$value."'");
			$heading1  =  'Status  Change '.$getname11.'. Select Yes';
		}else{
			$value = 1;
			$bool = mysql_query("update ".$table." set ".$field."='".$value."' where id=".$id."");
			$getname11 = get_sql("system_dd","name"," where type='26' AND id='".$value."'");
			$heading1  =  'Status  Not Change Still In Active. Select No';
		}
		
		add_job_notes($id,$heading1,$heading1);	
		echo trim($value); 
		
	}
	
	function download_job_invoice($var){
	
		$varx = explode("|",$var);
		$quote_id = $varx[0];
		$staff_id= $varx[1];
		$type= $varx[2];

		$job_id = get_rs_value("quote_new","booking_id",$quote_id);
		
		//BOF added to generate pdf after click button 
        $jobinv = 1;		
		$q_details =  mysql_fetch_assoc(mysql_query("SELECT id , ssecret FROM quote_new WHERE booking_id=".mres($job_id).""));
		//$pdf_path = invoiceGenerationInPdf($q_details['ssecret'],$quote_id);
		
		$pdf_path = invoiceGenerationInPdf($q_details['ssecret'],$quote_id, "", $staff_id, $jobinv ,$type);
		$bool = mysql_query("update jobs set invoice_create='1' where id=".$job_id."");
		echo error('Create Invoice without number');
		//error("Invoice Sent Successfuly")
		//EOF added to generate pdf after click button
	}
	
	function client_images_move($var) {
	
		$vars = explode('|' , $var);
		//print_r($vars);
		$ids = $vars[0];
		$imgtype = $vars[1];
		$job_id = $vars[2];
		$jobtype = $vars[3];
		if($ids != '') {	
		    //echo  "update bcic_email_attach set img_type ='".$imgtype."' , job_id ='".$job_id."', move_staff_img ='1' , job_type  =".$jobtype." , admin_id=".$_SESSION['admin'].", moved_date='".date('Y-m-d H:i:s')."'  where id in (".$ids.")";
			
	 		 $bool = mysql_query("update bcic_email_attach set img_type ='".$imgtype."' , job_id ='".$job_id."', move_staff_img ='1' , job_type  =".$jobtype." , admin_id=".$_SESSION['admin'].", moved_date='".date('Y-m-d H:i:s')."'  where id in (".$ids.")");
			if($bool) {
				echo 1;
			}  
		}
	}
	
	function admin_admin_fault($vars) {
		$var =   explode('|' ,$vars);
		
		$qid = $var[0];
		$b_id = $var[1];
		$fault_admin_id = $var[2];
		$comm = mysql_real_escape_string(base64_decode($var[3]));
		$type = $var[4];
		$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$heading = 'Notes Added By '.$staff_name;
		add_admin_fault_notes($qid , $b_id,$fault_admin_id , $heading,$comm);
		
		echo  error('Notes Added Successfully');
		if($type == 1) {
			$quote_id = $qid;
		   //include('view_fault_notes.php'); 
		}
	}
	
	function select_email_template_data($var){
		//echo $var;
		$varx = explode("|",$var);
		$job_id = $varx[1];
		$action= $varx[0];
		$flag = $varx[2];
		
		if($action=="1"){ 
			echo send_email_conf_template($job_id);
		}else if ($action=="2"){ 
			$str = send_cleaner_details_temp($job_id);
			$str = str_replace("<br>","\r",$str); 
			echo strip_tags($str);
			//echo str_replace("<br>","\r",);
		}else { 
		     
                $msg =   get_rs_value("email_tpl","message",$action);
                $guarantee_text ='';
              	$siteUrl = get_rs_value("siteprefs","site_url",1);
              	$guarantee_text = get_rs_value("jobs","work_guarantee_text",$job_id);
             
			 
			    $qdetails = mysql_fetch_assoc(mysql_query("select id, name , ssecret , booking_id  from quote_new where booking_id = ".$job_id.""));
			 
			 	$url = $siteUrl."/no_guarantee_images.php?action=imagecheck&token=".base64_encode(base64_encode($job_id));
				$getURL = get_short_url($url);
				$linkClick = "<a href=".$getURL." target='_blank'>".$getURL."</a>";
			 
			 $text = array('$name','$jobid' , '$imgLink' , '$bgtextarea'); 
			 $replace_value = array(mysql_real_escape_string($qdetails['name']),mysql_real_escape_string($qdetails['booking_id']) , $linkClick, $guarantee_text); 
			 
			 $afterreplace_text = str_replace($text , $replace_value, $msg);
			if($flag == true) {
			   return  strip_tags($afterreplace_text);
			} else{
			 echo strip_tags($afterreplace_text);
			}
			 
		}
    }
	function getpersnal_noti($var) {
		include('get_persnal_noti.php');
	}
	function read_notification($id){
		
		$currentDate = date('Y-m-d H:i:s');
		$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$messageRead = $staff_name.'_('.$currentDate.')';
		$qryBool = mysql_query( "UPDATE site_notifications SET 
		notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = {$id}" );	
		include('get_persnal_noti.php');
	}
	
	
	function sales_auto_fallow($quid) {
		
	    $sdata1 = mysql_query("select *  from sales_system where quote_id = ".$quid."");	
		
		if(mysql_num_rows($sdata1) == 0) {
		
			$sdata = mysql_fetch_assoc(mysql_query("select *  from quote_new where id = ".$quid.""));
			$time = date('H'); 	
			 
			$site_id = $sdata['site_id'];
			
			$sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." and slot_from > ".$time." limit 0 , 1");
			
			 $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
			 
					if(mysql_num_rows($sql) > 0) {
							$date = date('Y-m-d');
					
							$getdata = mysql_fetch_assoc($sql);
							//$gettime = $getdata['id'];
							$schedule_time1 = $getdata['schedule_time'];

							$heading = "Call Auto Re-Schedule by $staff_name time ".$date." (".$schedule_time1.")";
							
					}else {
						
						$sql = mysql_query("SELECT id , schedule_time FROM `site_time_slot` WHERE site_id = ".$site_id." limit 0 , 1");
						$todaydate = date('Y-m-d');
						$date = date('Y-m-d',strtotime($todaydate . "+1 days"));
						
							$getdata = mysql_fetch_assoc($sql);
							
							$schedule_time1 = $getdata['schedule_time'];
							
							$heading = "Call Auto Re-Schedule by $staff_name time ".$date." (".$schedule_time1.")";
						
					} 
				$next_action = 'Follow up auto';
				$task_result = 'Auto Follow up By Admin ';
				$timedate = explode('-',$schedule_time1);
				$time = date('H:i:s' , strtotime("+15 minutes", strtotime($timedate[0])));
				$fallow_date  = $date .' '.$time;		

				$call_she  = mysql_query("insert into sales_system set quote_id='".mres($quid)."', staff_name='".$staff_name."', admin_id='".$_SESSION['admin']."',site_id=".$site_id.", stages=3, status=1, task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  createOn='".date('Y-m-d H:i:s')."'");
				
				$saleid = mysql_insert_id();
				
				$call_she1  = mysql_query("insert into sales_task_track set quote_id='".mres($quid)."', staff_name='".$staff_name."', admin_id='".$_SESSION['admin']."',site_id=".$site_id.",stages=3, status=1, fallow_date='".$fallow_date."' ,fallow_created_date='".date('Y-m-d')."' ,task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  fallow_time='".$schedule_time1."' ,  task_status='1'  , sales_task_id = '".$saleid."' ,  createOn='".date('Y-m-d H:i:s')."'");
				
				
				$track_lastid = mysql_insert_id();


				$call_she11  = mysql_query("insert into task_manager set quote_id='".mres($quid)."', response_type='0', admin_id='".$_SESSION['admin']."', status=1, fallow_date='".$fallow_date."' ,fallow_time='".$schedule_time1."' , task_type='1' , task_id = '".$track_lastid."' , created_date='".date('Y-m-d H:i:s')."'"); 
				$task_mange_id = mysql_insert_id();

				$update11 = mysql_query("UPDATE sales_task_track SET task_manager_id = '".$task_mange_id."'   WHERE id = '".$track_lastid."'" );
				 
				// $call_she1  = mysql_query("insert into sales_task_track set quote_id='".mres($quote_id)."', staff_name='".$admin_name."', admin_id='".$_SESSION['admin']."',site_id=".$quote['site_id'].",stages=".$stage_id.", status=1, fallow_date='".$schedule_date_time."' ,fallow_created_date='".$schedule_date_time."' ,task_manage_id='".$_SESSION['admin']."' , task_type='admin' ,  fallow_time='".$schedule_time_value."' , task_status='1' , createOn='".date('Y-m-d H:i:s')."'"); 
				 
				add_sales_follow($saleid , $quid , $schedule_time1 ,'' , $task_result );
					
				 $heading = "Call Auto Schedule time ".$date." (".$time.")";
				 
				 
				 add_quote_notes($quid,$heading,$heading); 
				  $quotedetails['login_id'] = 0; 
				
				 echo $fallow_date.' <br/><div class="btn_get_quot" id="login_followup"><span >'.create_dd("login_id","admin","id","name","is_call_allow = 1 AND status = 1","class=\"heading_drop\" onchange=\"javascript:edit_field(this,'quote_new.login_id',".$quid.");\"",$quotedetails).'</span></div>';
		}else{
			echo 'Already Added';
		}
	}
	
	function lost_quote($qid) {
		
		 $bool = mysql_query("update quote_new set step='5' where id=".mres($qid)."");
         $heading = "Lost quote on create quote page";
		 add_quote_notes($qid,$heading,$heading);
		 echo 'Lost quote';
	}
	
	function search_fault_data($str) {
		
		$str =  explode('|' ,$str);
		
		$from_date = $str[0];
		$to_date = $str[1];
		$admin_id = $str[2];
		
		if($from_date != 0) {
		   $_SESSION['admin_fault_data']['from_date']= $from_date;
		}else {
			unset($_SESSION['admin_fault_data']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['admin_fault_data']['to_date']= $to_date;
		}else {
			unset($_SESSION['admin_fault_data']['to_date']);
		}
		
		if($admin_id != 0) {
		   $_SESSION['admin_fault_data']['admin_id']= $admin_id;
		}else {
			unset($_SESSION['admin_fault_data']['admin_id']);
		}
		
	   include('view_admin_fault.php');	
		
		
	}
	function search_task_report($var)
	{
		
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		
		if($from_date != 0) {
		   $_SESSION['task']['from_date']= $from_date;
		}else {
			unset($_SESSION['task']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['task']['to_date']= $to_date;
		}else {
			unset($_SESSION['task']['to_date']);
		}
		
		include('view_task_reports.php');
	}
	function search_admin_task($adminid){
		
		 if($adminid != 0) {
		   $_SESSION['adminid']['id']= $adminid;
		}else {
			unset($_SESSION['adminid']['id']);
		}
		include('view_task_manager.php');
	}
	
	function search_track_report($var)
	{
		
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		
		if($from_date != 0) {
		   $_SESSION['track']['from_date']= $from_date;
		}else {
			unset($_SESSION['track']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['track']['to_date']= $to_date;
		}else {
			unset($_SESSION['track']['to_date']);
		}
		
		include('view_sales_track_report.php');
	}
	
	function movequoteto_anotherlogin($var){
		$vars = explode('|',$var);
		//print_r($vars);  die;
		$qids = $vars[0];
		$movieid = $vars[1];

		// echo  $qids; die;
          if($movieid == 0) {
           quotesharetoeveryOne($qids , 0);
		   echo 'Quote Moved';

	    }else if($movieid != 0) {
			 quotesharetoeveryOne($qids , $movieid);
		      echo 'Quote Moved';
			
		}	  
	}
	
	function a_search_sales_search($vars){
		
		$var = explode('|',$vars);
		$type = $var[0];
		$fromdate = $var[1];
		$todate = $var[2];
		$response = $var[3];
		
		 if($type != 0) {
		   $_SESSION['sales_data']['type']= $type;
		}else {
			unset($_SESSION['sales_data']['type']);
		}
		
		if($fromdate != 0) {
		   $_SESSION['sales_data']['fromdate']= $fromdate;
		}else {
			unset($_SESSION['sales_data']['fromdate']);
		}
		
		if($todate != 0) {
		   $_SESSION['sales_data']['todate']= $todate;
		}else {
			unset($_SESSION['sales_data']['todate']);
		}
		
		if($response != 0) {
		   $_SESSION['sales_data']['response']= $response;
		}else {
			unset($_SESSION['sales_data']['response']);
		}
		
		include('view_task_manager.php');
	}
	function search_quote_lilstdata($vars){
		   $var = explode('|' ,$vars);
		
		 //print_r($var); 
		
			$statetype = $var[0];
			$fromdate = $var[1];
			$todate = $var[2];
			$adminid = $var[3];
			$quote_type = $var[4];
		  
		 
			if($statetype != 0) {
			   $_SESSION['quote_sales_list']['tasktype']= $statetype;
			}else {
			    unset($_SESSION['quote_sales_list']['tasktype']);
			}

			if($fromdate != '') {
			    $_SESSION['quote_sales_list']['from_date']= $fromdate;
			}else {
			    unset($_SESSION['quote_sales_list']['from_date']);
			}

			if($todate != '') {
			   $_SESSION['quote_sales_list']['to_date']= $todate;
			}else {
			   unset($_SESSION['quote_sales_list']['to_date']);
			}
			
			if($adminid != 0) {
			   $_SESSION['quote_sales_list']['adminid']= $adminid;
			}else {
			    unset($_SESSION['quote_sales_list']['adminid']);
			}
			if($quote_type > 0) {
			   $_SESSION['quote_sales_list']['quote_type']= $quote_type;
			}else {
			    unset($_SESSION['quote_sales_list']['quote_type']);
			}
			
		include('view_quote_list.php');
	}
	
	function send_voucher_emails($var)
	{
		$jobid = $var;
		 $qdata = mysql_fetch_array(mysql_query("select *  from quote_new where booking_id = ".$jobid.""));
		 $reviewLink = get_rs_value("sites","review_site_link",$qdata['site_id']);	
		    if($reviewLink != '') {
				 $RandomString = genRandomString();
				 $str =  send_voucher_emailsdata($qdata ,$RandomString , $reviewLink);
				// echo $str;  die;
				//print_r($var);
				$sendto_subject = 'J#'.$jobid.' Hi '.$qdata['name'].', $50 thank you gift Card for your time. ';
				$replyto = 'reviews@bcic.com.au';
				$site_id = $qdata['site_id'];
				$quotefor = $qdata['quote_for'];
				$sendto_email = $qdata['email'];
				
				$from_date = date('Y-m-d');
				//$from_to = date("Y-m-d", strtotime("+1 month", $from_date));
				//$date1 = strtotime(date("Y-m-d", strtotime($from_date)) . " +1 month");
				$from_to = date("Y-m-d", strtotime(date("Y-m-d", strtotime($from_date)) . " +1 month"));
				
			     sendmail($qdata['name'],$sendto_email,$sendto_subject,$str,$replyto,$site_id , $quotefor); 
				//sendmail($qdata['name'],'pankaj.business2sell@gmail.com', $sendto_subject,  $str,$replyto,$site_id , $quotefor); 
				sendmail($qdata['name'],'manish@bcic.com.au', $sendto_subject , $str,$replyto,$site_id , $quotefor); 
				$heading1 = 'Send voucher Email';
				add_job_notes($jobid,$heading1,$heading1);
				//sendmail($qdata['name'],'pankaj.business2sell@gmail.com',$sendto_subject,$str,$replyto,$site_id , $quotefor); 
				$qryBool = mysql_query( "UPDATE bcic_review SET send_voucher_date ='".date('Y-m-d H:i:s')."'  WHERE job_id = {$jobid}" );
				
				echo  date('Y-m-d H:i:s');
			}else{
			  echo 'Not Send because no review Link in admin';
			}
	   	
	}
	
	function admin_search_taskreport(){
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		
		if($from_date != 0) {
		   $_SESSION['task']['from_date']= $from_date;
		}else {
			unset($_SESSION['task']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['task']['to_date']= $to_date;
		}else {
			unset($_SESSION['task']['to_date']);
		}
		
		include('view_admin_task_reports.php');
	}
	
	function total_task_show($var)
	{
		
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		
		if($from_date != 0) {
		   $_SESSION['total_track']['from_date']= $from_date;
		}else {
			unset($_SESSION['total_track']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['total_track']['to_date']= $to_date;
		}else {
			unset($_SESSION['total_track']['to_date']);
		}
		
		include('view_total_task_list.php');
	}
	
	function add_cancelled_reason($str) {
		$vars = explode('__' ,$str);
		
		$jonid = $vars[0];
		$reasonid = $vars[1];
		$reason = $vars[2];
		//echo "UPDATE jobs SET cancelled_reason ='".$reason."'  WHERE id = {$jonid}"; die;
		//echo "UPDATE jobs SET cancelled_reason ='".$reasonid."',cancelled_other_reason = '".$reason."'  WHERE id = {$jonid}"; die;
		$qryBool = mysql_query("UPDATE jobs SET cancelled_reason ='".$reasonid."',cancelled_other_reason = '".$reason."'  WHERE id = {$jonid}" );
		$heading1 = 'Reason For Cancellation';
		$reasonid_head = '';
		if($reasonid > 0) {
		   $reasonid_head = getSystemDDname($reasonid, 154);
		}
		
		if($reason != '') {
		    $reasoncomment = ' (' .$reason.')';
		}
		$coments = mysql_real_escape_string($reasonid_head) . ''.$reasoncomment;
		add_job_notes($jonid,$heading1,$coments);
	}
	
	function payment_refund_page($str){
		
		 //var str = from_date +'|'+to_date+'|'+site_id; payment_refund_page
		 
		 $vars = explode('|' , $str);
		$from_date = $vars[0];
		$to_date = $vars[1];
		$site_id = $vars[2];
		
		if($from_date != 0) {
		   $_SESSION['payment_refund_page']['from_date']= $from_date;
		}else {
			unset($_SESSION['payment_refund_page']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['payment_refund_page']['to_date']= $to_date;
		}else {
			unset($_SESSION['payment_refund_page']['to_date']);
		}
		
		if($site_id != 0) {
		   $_SESSION['payment_refund_page']['site_id']= $site_id;
		}else {
			unset($_SESSION['payment_refund_page']['site_id']);
		}
		
		include('view_refund_page.php');
	} 
	
	function save_checklist_data($var)
	{
		 $vars = explode('|' , $var);
		// print_r($vars);
		$salesid = $vars[0];
		$trackid = $vars[1];
		$trackheadid = $vars[2];
		$question = explode(',' ,$vars[3]);
		
		
		
		 $trackdetails = mysql_fetch_assoc(mysql_query("SELECT id , quote_id , job_id   FROM `sales_task_track` WHERE `id` = ".$salesid.""));
		
		$jobid = $trackdetails['job_id'];
		
		$date = date('Y-m-d H:i:s');
		if($jobid > 0) {
			$qu_sql = '';
			//question_name
			 
			$arg = "INSERT INTO `operation_ans` (`sales_id`, `track_id`, `track_head_id`, `question_id`, `ans` , `job_id` , `admin_id`,`question_name` , `createdOn`) VALUES ";
			foreach($question as $key=>$qus) {
				
				
				$question_name = get_rs_value("operation_checklist","qus",$qus);
				$ansq = 0;
				$adminid = $_SESSION['admin'];
			 $qu_sql .= " ('{$salesid}', '{$trackid}', '{$trackheadid}', '{$qus}', 0 , '{$jobid}',  '{$adminid}' ,'{$question_name}' , '{$date}' ),";	
			}
			$qu_sql1 = rtrim($qu_sql , ',');
			
			$sql = $arg. ' '.$qu_sql1;
			//echo  $sql;
			$query = mysql_query($sql);
			
			$id = mysql_insert_id();
			
			 if(isset($id)) {
			   $qryBool = mysql_query( "UPDATE operation_ans set ans = 1   WHERE question_id in (".$vars[4].") and sales_id = ".$salesid."");
			 }
		}
		 
		$_POST['id'] = $salesid;
		$_POST['track_id']  = $trackid;
		$_POST['trackid_head'] = $trackheadid;
			
		include('ajax/call_operations_question_popup.php');
	}
	
	
	function save_checklist_ans_data($str){
		$vars = explode('|' , $str);
		$date = date('Y-m-d H:i:s');
		//echo  "UPDATE operation_ans set  ans = ".$vars[0]." where id = ".$vars[1]."";
		if($vars[1] != '') {
		 $qryBool = mysql_query( "UPDATE operation_ans set  ans = ".$vars[0]." ,updatedOn = '".$date."' where id = ".$vars[1]."");
		}
		 $trackdetails = mysql_fetch_assoc(mysql_query("SELECT sales_id , track_head_id , job_id , track_id   FROM `operation_ans` WHERE `id` = ".$vars[1]." limit 0 , 1"));
		 
		// print_r($trackdetails);
		 
		$_POST['id'] = $trackdetails['sales_id'];
		$_POST['track_id']  = $trackdetails['track_id'];
		$_POST['trackid_head'] = $trackdetails['track_head_id'];
			
			
		include('ajax/call_operations_question_popup.php');
	}
	
	function search_opration_admin_task($adminid){
		
		//task_manage_type op_adminid
		 if($adminid != '') {
		   $_SESSION['op_adminid']['task_manage_type']= $adminid;
		}else {
			unset($_SESSION['op_adminid']['task_manage_type']);
		}
		
	 //  print_r($_SESSION['op_adminid']);
		
		 include("view_operation_system.php"); 
		
	}
	
	function search_new_operation($var)
	{
		
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		$operation_type = $vars[2];
		
		if($from_date != 0) {
		   $_SESSION['operation_task']['from_date']= $from_date;
		}else {
			unset($_SESSION['operation_task']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['operation_task']['to_date']= $to_date;
		}else {
			unset($_SESSION['operation_task']['to_date']);
		}
		
		if($operation_type != 0) {
		   $_SESSION['operation_task']['operation_type']= $operation_type;
		}else {
			unset($_SESSION['operation_task']['operation_type']);
		}
		
		include('view_operation_report_task.php');
	}
	
	function call_cleaner_before_jobs($jobsid){
		
		 if($jobsid > 0) {
			// echo "UPDATE jobs set  call_cleaner_date = '".date('Y-m-d H:i:s')."' where id = ".$jobsid."";  die;
		   $qryBool = mysql_query("UPDATE jobs set  call_cleaner_date = '".date('Y-m-d H:i:s')."' where id = ".$jobsid."");
		   $heading1 = 'Call to Cleaner';
		    add_job_notes($jobsid,$heading1,$heading1);
		   echo date('Y-m-d H:i:s');
		 }else {
			 echo 'Not Called';
		 }
	}
	function call_review_date($var) {
		 
		$vars = explode('|' , $var);
		$job_id = $vars[0];
		$fields = $vars[1];
		
		
			if($job_id > 0) {
			  $qryBool = mysql_query("UPDATE jobs set  $fields = '".date('Y-m-d H:i:s')."' where id = ".$job_id."");
			}
			
		   $heading1 = ucwords(str_replace('_',' ',$fields)) . ' On after job page';
		   add_job_notes($job_id,$heading1,$heading1);
		 //  echo date('Y-m-d H:i:s');
		 $_POST['id'] = $vars[2].'|'.$vars[3].'|'.$vars[4];
		  include('ajax/call_operations_task_popup.php');
	}
	function send_awatting_sms($var){
	    
		$vars = explode('|', $var);
		$jobid = $vars[0];
		$typeid = $vars[1];
		
		if($typeid == 1) {
		    echo 'Send SMS Awaiting SMS Comming Soon  ';
		}else if($typeid == 2) {
		  $bool = mysql_query("update jobs set awaiting_exit_receive ='".date('Y-m-d H:i:s')."' , new_re_clean = 4 where id=".$jobid."");
		  $heading = 'Awaiting Exit Report Recived ';
		  add_job_notes($jobid,$heading,$heading); 
		  echo  date('Y-m-d H:i:s');
		}else if($typeid == 3) {
		     
		     $quote = mysql_fetch_assoc(mysql_query("SELECT id ,name , booking_id , email  FROM `quote_new`   WHERE  booking_id = ".$jobid.""));
		  
				$eol = '<br/>';
				$str =  'J#'.$jobid.', Hi '.$quote['name'].','.$eol.$eol.'
				We were informed of the failed inspection and requested you to forward the exit condition report to us. We followed this with you on two occasions however, as we have not heard back for 7 days, unfortunately, the guarantee period has expired. '.$eol.'
				We are still able to arrange the cleaners to return at a nominal cost of $88 for upto 90 mins of work. Should you wish to proceed with this arrangement, please send the exit report in next 24 hours on reclean@bcic.com.au ';
				// $heading = 'Awaiting Exit Report Recived ';
				$subject = 'J#'.$jobid.' Guarantee  period';

				$email_out_booking = 'reclean@bcic.com.au';
				sendmailbcic($quote['name'],$quote['email'],$subject,$str,$email_out_booking,"0"); 
				add_job_emails($quote['booking_id'],$subject,$str,$quote['email']);
				add_job_notes($jobid,$subject,$str);
				$bool = mysql_query("update jobs set guarantee_expired_email_date ='".date('Y-m-d H:i:s')."' where id=".$jobid."");
				echo  date('Y-m-d H:i:s'); 
		}else if($typeid == 4) {
		    
			$quote = mysql_fetch_assoc(mysql_query("SELECT id ,name , booking_id , email  FROM `quote_new`   WHERE  booking_id = ".$jobid.""));
			
			//print_r($quote);
			
			$job_recleanDetails = mysql_fetch_assoc(mysql_query("SELECT staff_id  FROM `job_reclean` WHERE job_id = ".$jobid." and  status = 0 and  staff_id != 0"));
			
			//print_r($job_recleanDetails);
			$staffname = get_rs_value("staff","name",$job_recleanDetails['staff_id']);	
			
			$comment = 'URGENT- Hi '.$staffname.', Reclean RJ#.'.$jobid.'., Please add the date and time which is arranged for the reclean., thank you';	
			
			// echo  $comment;
			
			//added to add reclean job notification
			$getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '".$job_recleanDetails['staff_id']."'"));
		
			
			 $result['user_to'] = $staffname;
			$result['chatter'] = $job_recleanDetails['staff_id'];
			$result['admin_id'] = $_SESSION['admin'];
			$result['admin'] = 'admin';
			$result['job_id'] = $job_recleanDetails['job_id'];
		   
		    $heading = 'Send Arrange Reclean Date Notification';
		   
			if($getlogin_device['deviceid'] != '') {

				   $heading.=" (Notification Delivered)"; 
				   $flag = 1; 
				   $result['deviceid'] = $getlogin_device['deviceid'];
				   sendNotiMessage($comment , $result);
				   
				    $bool = mysql_query("update jobs set arrange_reclean_date_noti ='".date('Y-m-d H:i:s')."' where id=".$jobid."");
			}
			else{
			  $heading.=" (Failed)"; 
			}
		
		   add_reclean_notes($job_id,$heading,$heading);
		   add_job_notes($jobid,$heading,$comment); 
		   echo  $heading . ' on ' .date('Y-m-d H:i:s'); 
		}
	}
	function get_bbc_weekly_job_report($var){
		//echo $var;
		$vars = explode('|' , $var);
		$from_date = $vars[0];
		$to_date = $vars[1];
		$better_franchisee = $vars[2];
		
		if($from_date != 0) {
		   $_SESSION['bbc_weekly_report']['from_date']= $from_date;
		}else {
			unset($_SESSION['bbc_weekly_report']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['bbc_weekly_report']['to_date']= $to_date;
		}else {
			unset($_SESSION['bbc_weekly_report']['to_date']);
		}
		
		if($better_franchisee != 0) {
		   $_SESSION['bbc_weekly_report']['better_franchisee']= $better_franchisee;
		}else {
			unset($_SESSION['bbc_weekly_report']['better_franchisee']);
		}
		
		include("view_bbc_weekly_job_reports.php"); 
	}
	function get_stafftypedata($var) {
		$stafftype = $var;
		echo create_dd("staff_id","staff","id","name","status = 1 AND better_franchisee = ".$stafftype."","", '' ,'');
	}
	
	function get_complaint_job($str){
		
		 $vars = explode('|' , $str);
		$from_date = $vars[0];
		$to_date = $vars[1];
		$site_id = $vars[2];
		$complaint_status = $vars[3];
		$complaint_type = $vars[4];
		
		if($from_date != 0) {
		   $_SESSION['complaint_page']['from_date']= $from_date;
		}else {
			unset($_SESSION['complaint_page']['from_date']);
		}
		
		if($to_date != 0) {
		   $_SESSION['complaint_page']['to_date']= $to_date;
		}else {
			unset($_SESSION['complaint_page']['to_date']);
		}
		
		if($site_id != 0) {
		   $_SESSION['complaint_page']['site_id']= $site_id;
		}else {
			unset($_SESSION['complaint_page']['site_id']);
		}
		
		if($complaint_status != 0) {
		   $_SESSION['complaint_page']['complaint_status']= $complaint_status;
		}else {
			unset($_SESSION['complaint_page']['complaint_status']);
		}
		
		if($complaint_type != 0) {
		   $_SESSION['complaint_page']['complaint_type']= $complaint_type;
		}else {
			unset($_SESSION['complaint_page']['complaint_type']);
		}
		
		include('view_complaint_job_list.php');
		
	}
	function get_complaint_notes($var) {
		$vars = explode('|',$var);
		$id = $vars[0];
		$jobid = $vars[1];
		include('get_complaint_notes.php');
		
	}
	function add_complaite_cehck_notes_comment($str) {
		
		$vars = explode('|',$str);
		
		
		$comment = $vars[0];
		$jobid = $vars[1];
		$id = $vars[2];
		$mail_type = $vars[3];
		if(trim($comment) != '') {
			$heading = 'Add Notes';
			$comment= $comment;
		  add_complaint_notes($jobid,$id, $heading, $comment, $mail_type);
		}
		
	 	include('get_complaint_notes.php');
	}
	
	function show_job_list_comp($str){
	 	//$data = mysql_query("SELECT id, (SELECT name FROM quote_new Q where Q.booking_id = J.id) as cname, (SELECT name from system_dd WHERE id = J.status and type = 26) as jstatus  FROM `jobs` J WHERE id not  in (SELECT job_id FROM `job_complaint` ) AND id  like '%".mysql_real_escape_string($str)."%'");
		
	 	$data = mysql_query("SELECT id, (SELECT name FROM quote_new Q where Q.booking_id = J.id) as cname, (SELECT name from system_dd WHERE id = J.status and type = 26) as jstatus  FROM `jobs` J WHERE id  like '%".mysql_real_escape_string($str)."%'");
		
		$strx = "<ul>";
	       
        if(mysql_num_rows($data) > 0) {		   
			while($r=mysql_fetch_assoc($data)){ 
				
				  
				
				// print_r($r);
				$strx.="<li><a href=\"javascript:get_job_details('".$r['cname']."','".$r['jstatus']."','".$r['id']."')\">".$r['id']."(".$r['cname'].")</a></li>";
			}	
		}else{
			$strx.="<li>No Found</li>";
		}
		$strx.="</ul>";
		echo $strx;
		
	}
	
	function save_job_id_in_com($str)
	{
		
		//echo $str;
		
		$jobdet = explode('(', $str);
		
		//print_r($jobdet);
		
		$job_id = $jobdet[0];
		$staffdetails__1 = explode('|',$jobdet[1])[1];
		
		//4718 (pankaj)|246__1Array ( [0] => 4718 [1] => pankaj)|246__1 ) 246__1
		
		  $staffdetails = explode('__' , $staffdetails__1); 
		  
		  //print_r($staffdetails); die;
		

		$id = $job_id;
		
		$staff_id = $staffdetails[0];
		$job_type_id = $staffdetails[1];
		
		 //echo "INSERT INTO `job_complaint` (`job_id`, `staff_id` , `admin_id`, `site_id`, `status`, `job_status`, `createdOn`) VALUES ('".$id."', '".$staff_id."'  , '".$_SESSION['admin']."', '".$site_id."', '1', '".$jobstatua."', '".date('Y-m-d H:i:s')."')"; die;
		
				$site_id =  get_rs_value("jobs","site_id",$id);	
				$jobstatua =  get_rs_value("jobs","status",$id);
				mysql_query("INSERT INTO `job_complaint` (`job_id`, `staff_id` , `job_type_id` , `admin_id`, `site_id`, `status`, `job_status`, `createdOn`) VALUES ('".$id."', '".$staff_id."', '".$job_type_id."'  , '".$_SESSION['admin']."', '".$site_id."', '1', '".$jobstatua."', '".date('Y-m-d H:i:s')."')");
				$idcomp = mysql_insert_id();
				
				$bool = mysql_query("update jobs set status = 4  where id=".$id."");
				
				mysql_query("UPDATE job_details SET complaint_status ='1'  WHERE job_id = {$id} AND staff_id = {$staff_id} AND job_type_id = {$job_type_id} AND status != 2" );
				
				$heading = 'Job Add In Complaint Status on Popup';
				add_complaint_notes($id,$idcomp, $heading, $heading);
				add_job_notes($id,$heading,$heading);
				
				include('view_complaint_job_list.php');
		
	}
	
	function bbc_leads_quote($var) {
		
		$todate = explode(',', $var);
		
		$todate = $todate[0];
		
		$_SESSION['bbc_leads']['from_date']= $todate;
		
		include('view_bbc_leads.php');
	}
	
	function search_team_payment($var){
		
		//echo $var .'uuuu';
		
		$vars = explode('|',$var);
		//print_r($vars);
		
		 if($vars[0] != '') {
		  $_SESSION['tpayment_report']['from_date'] = $vars[0];
		}else{
			 $_SESSION['tpayment_report']['from_date'] = date("Y-m-1");
		}
		
		if($vars[1] != '') {
		    $_SESSION['tpayment_report']['to_date'] = $vars[1];
		}else{
			 $_SESSION['tpayment_report']['to_date'] = date("Y-m-t");
		}
		
		$_SESSION['tpayment_report']['site_id'] = $vars[2];
		$_SESSION['tpayment_report']['staff_id'] = $vars[3];
		
		 if($vars[4] != '') {
		  $_SESSION['tpayment_report']['staff_type'] = $vars[4];
		}else{
			 unset($_SESSION['tpayment_report']['staff_type']);
		}
		
	    // print_r($_SESSION['tpayment_report']);	
		 
		include('view_team_payments.php'); 
	} 
	
	function get_business_qus($str) {
	     
		 $vars = explode('|', $str);
		 $trackid = $vars[0];
		 $business_type = $vars[1];
		 $getData1['business_type'] = '';
		 if($business_type != 0) {
		    $getData1['business_type'] = $business_type;
		 }
		 
		 echo create_dd("business_type","case_business_type_qus","id","name","track_id=".$trackid."","",$getData1);
	} 
	
	function getcompany_details($var){
	
	  // echo  'pankaj' .$var; 
	   
	      $vars = explode('|', $var);
		  $siteid = $vars[0];
		  $companyname = $vars[1];
		  $getData1 = '';
		  
		  //echo  "SELECT * FROM `re_company` WHERE  site_id= $siteid AND comapny_name like '%$companyname%' AND status = 1";
		  
		  $sql = mysql_query("SELECT * FROM `re_company` WHERE  site_id= $siteid AND comapny_name like '%$companyname%' AND status = 1");
		
		/*  echo '<span>'.create_dd("company_id","re_company","id","comapny_name","site_id= $siteid AND comapny_name like '%$companyname%' AND status = 1","Onchange=\"getrealestatedata(this.value);\"",$getData1).'</span>'; */
		
		 $strx = "<ul class=\"post_list\">";
		  $countResult = mysql_num_rows($sql);
		
		if($countResult >  0) {
			while($r=mysql_fetch_assoc($sql)){
				
				//print_r($r); 
				$strx.="<li><a href=\"javascript:getrealestatedata('".$r['id']."','".$r['comapny_name']."')\">".$r['comapny_name']."</a></li>";
			}	
		}else {
          $strx.="<li>No staff Found</li>";
		}
		$strx.="</ul>";
		echo $strx;
		 
	}
	
	function get_realestatelist($var) {
	
	  echo '<span>'.create_dd("re_company_agents_id","re_company_agents","id","name","company_id= $var AND status = 1","Onchange=\"getrealestateInfo(this.value);\"",$getData1).'</span>';
	 
	}
	function realestateinfo($var) {
	   
	   $sql = mysql_query("SELECT * FROM `re_company_agents` WHERE  id = ".$var."");
	   $count= mysql_num_rows($sql);
	   
	   if($count > 0) {
	    $data  = mysql_fetch_assoc($sql);
	   
	       
	      // $str = '<table><tr><td>Name</td>'.$data['name'].' <li>Phone</li>'.$data['phone'].'<li>Email</li>'.$data['email'].' <li>Address</li>'.$data['address'].'</table>';
	       $str = '<table border="1px solid" style="width: 90%;border: 0px  solid;margin-left: 650px;margin-top: -59px;text-align: center;margin: 14px;font-size: 18px;">
		            <tr>
				     <td>Name</td>
				     <td>Phone</td>
				     <td>Email</td>
				     <td>Address</td>
					</tr> 
					<tr>
				     <td>'.$data['name'].' </td>
				     <td>'.$data['phone'].' </td>
				     <td>'.$data['email'].' </td>
				     <td>'.$data['address'].' </td>
					</tr> 
			 </table>';
			echo $str;
		}
	}
	
	function email_image_upload($vars) {
	   echo  'Wait will checking';
	}
	
	function getclenerdata($jobid) {
		
		 $data = mysql_query("SELECT job_id , job_type_id , complaint_status ,  (SELECT name from staff where id = staff_id)  as sname  ,job_type , staff_id FROM `job_details` WHERE `job_id` = ".$jobid." AND staff_id> 0");
		 
		  //echo create_dd("status","system_dd","id","name","type=".$jobid." AND staff_id> 0","",$getData1);
		  
		 
        $strx = "<select name='staff_id_data' id='staff_id_data' style='width: 100%;margin-top: 11px;height: 31px;text-align: center;font-size: 16px;'>";
	       
		  $strx.="<option value='0'>Select staff</option>"; 
        if(mysql_num_rows($data) > 0) {		   
			while($r=mysql_fetch_assoc($data)){ 
			  
			    $select = '';
			    if($r['complaint_status'] == 1) { $select = 'disabled';}
				
			$strx.="<option  value=".$r['staff_id'].'__'.$r['job_type_id']."  $select >".$r['job_type']."(".$r['sname'].")</option>";
			}	
		}else{
			$strx.="<option value='0'>No Staff</option>";
		}
		$strx.="</select>";
		echo $strx; 
	}
	
	function complantsendtoclener($var) 
	{
		
		//echo $var;
		 $vars = explode('|',$var);
		 $id = $vars[0];
		 $fields = $vars[1];
		 
		 if($fields == 'move_bcic') {  
			$sql =  ("UPDATE job_complaint SET complaint_sent_to_cleaner = '0000-00-00 00:00:00' , job_handling = 0 , complaint_handling_date = '0000-00-00 00:00:00', email_send_to_cleaner = '0000-00-00 00:00:00' , info__received = '0000-00-00 00:00:00' , move_contact = '0000-00-00 00:00:00'  WHERE id = {$id}");
		 }elseif($fields == 'job_handling_by_clnr') {
		    
			$sql = ("UPDATE job_complaint SET job_handling_by_clnr ='1'  WHERE id = {$id}");
		 }else{
		    
			$sql = ("UPDATE job_complaint SET $fields ='".date('Y-m-d H:i:s')."'  WHERE id = {$id}");
		 }
		 
		//echo $sql;
		 
		 $query = mysql_query($sql);
		 
		  $fieldshed = str_replace('_',' ', $fields);
		  
		  //complaint_sent_to_cleaner// job_handling/complaint_handling_date/email_send_to_cleaner/info__received/move_contact
				
				$heading = ucfirst($fieldshed);
				$job_id =  get_rs_value("job_complaint","job_id",$id);
				add_complaint_notes($job_id,$id, $heading, $heading);
				add_job_notes($job_id,$heading,$heading);
				
				echo date('Y-m-d H:i:s');
	}
	
	
	
	function save_complaintinfo($var)
	{
		 $vars = explode('__',$var);
		 
		 $_POST['id'] = $vars[6];
		 $trackdata = $vars[6];
		 
		 $complaintdata = explode('_',explode('|',$trackdata)[2]);
		 $track_id = $complaintdata[0];
		 $complaint_id = $complaintdata[1];
		 
		 //who_fault  refund_given gift_voucher insurance_case payning_invoice other
		 
		 mysql_query("UPDATE job_complaint SET who_fault ='".$vars[0]."' , refund_given ='".$vars[1]."', gift_voucher ='".$vars[2]."', insurance_case ='".$vars[3]."', payning_invoice ='".$vars[4]."', other ='".$vars[5]."',  complaint_date ='".date('Y-m-d H:i:s')."'  WHERE id = {$complaint_id}");
		 
		 $fault_name = '';
		 if($vars[0]> 0) {
			    if($track_id == 6) {
		 	       $fault_name = get_sql("system_dd","name","where id=".$vars[0]." AND type=143");
				}else{
					$fault_name = get_sql("system_dd","name","where id=".$vars[0]." AND type=145");
				}
		 }
			
		    $heading = 'Info added By Admin In Complaint Tab';
		    $comment = '';
		    $comment .= 'Who was at Fault =>'.$fault_name.'<br/>';
		    $comment .= 'Refund Given  =>'.$vars[1].'<br/>';
		    $comment .= 'Gift Voucher =>'.$vars[2].'<br/>';
		    $comment .= 'Insurance Case =>'.$vars[3].'<br/>';
		    $comment .= 'Paying Invoice =>'.$vars[4].'<br/>';
		    $comment .= 'Others =>'.$vars[5].'<br/>';
		 
		    $job_id =  get_rs_value("job_complaint","job_id",$complaint_id);
			add_complaint_notes($job_id,$complaint_id, $heading, $comment);
			
			include('ajax/call_operations_task_popup.php');
			//include("../ajax/call_operations_task_popup.php");	
	}
	
	
	function quote_compare($str){
		$vars = explode('|',$str);
		unset($_SESSION['quote_compare']);
		$_SESSION['quote_compare']['from_date'] = $vars[0];
		$_SESSION['quote_compare']['to_date'] = $vars[1];
		include('view_quote_compare.php');
	}
	
	function reset_quote_compare($var){
		//echo $var; die;
		$varx = explode("|",$var);
		$type1 = $varx[0];
		$value= $varx[1];
	     unset($_SESSION['quote_compare']);
		include("view_quote_compare.php");
    }
	
	function send_sms_hr($var){
	       $datar = explode('|', $var);	
		  
		    $id = $datar[0]; 
			//$contact = $datar[1]; 
			$contact =  trim(get_rs_value("staff_applications","mobile",$id));	
			//$contact = '0421188972'; 
			//$message = base64_decode($datar[2]); 
			$message = ($datar[2]); 
			if($message != '') {

						if(is_numeric($contact) && strlen($contact) == 10){

								
								$comment_msg = strip_tags($message);
								$comment_note = strip_tags($message);
							   $sms_code = send_sms(str_replace(" ","",$contact),$comment_msg);
	
	 // echo $sms_code;
	            if($sms_code == 1) 
		        {
					$date = date('Y-m-d');
					$datetime = date('Y-m-d H:i:s a');
					$date = date('Y-m-d');
					$time = date('H:i:s a');
					$admin_id = $_SESSION['admin'];
				  
					$query = "INSERT INTO  bcic_hr_sms (
								admin_id,
								read_by,
								to_num,
								to_num_code,
								from_num,
								from_num_code,
								message,
								date_sent,
								date_time,
								only_date,
								only_time,
								sender,
								receiver,
								type,
								status
								) values(
								{$admin_id},
								0,
								'{$contact}',
								'+61',
								'0429504482',
								'+61',
								'{$comment_msg}',
								'{$date}',
								'{$datetime}',
								'{$date}',
								'{$time}',
								1,
								1,
								'admin',
								'SUCCESS'
						)";
						 $response = mysql_query($query);
			    }								
			}
						
	    }
    
	     $heading = 'SMS Send on '.$contact;
			if($sms_code=="1"){ $heading.=" (SMS delivered)"; }else{ $heading.=" <span style=\"color:red;\">(SMS Failed)</span>";  }	
				echo $heading;
	  
	}
	function refress_wall_board(){
		
		//echo'pankaj';
		include('xjax/view_wall_board.php'); 
	}
	function s_invoice($var){
		
		$vars = explode('|' , $var);
		
		$_SESSION['staff_invoice_1']['from_date'] = $vars[0];
		$_SESSION['staff_invoice_1']['to_date'] = $vars[1];
		
		include('view_staff_invoice_report.php');
	}
	
	
	function search_re_quote($str) {
		
		//echo $str;
		 $vars = explode('|' , $str);
		
		if($vars[0] != '' && $vars[0] > 0) {
		   $_SESSION['re_quote']['quote_type'] = $vars[0];
		}else{
		    $_SESSION['re_quote']['quote_type'] = 0;
		}
		
		$_SESSION['re_quote']['from_date'] = $vars[1];
		$_SESSION['re_quote']['to_date'] = $vars[2];
		
		if($vars[3] != '' && $vars[3] > 0) {
		   $_SESSION['re_quote']['re_quote_id'] = $vars[3];
		}else{
		  $_SESSION['re_quote']['re_quote_id'] = 0;	
		}
		
		if($vars[4] != '' && $vars[4] > 0) {
		   $_SESSION['re_quote']['re_quote_status'] = $vars[4];
		}else{
		  $_SESSION['re_quote']['re_quote_status'] = 0;	
		}
		
		//$_SESSION['re_quote']['re_quote_status'] = $vars[3];
		
		include('view_re_quote.php'); 
	}
	
	function getRequoteInfo($var) {
	    $requoteid =  $var;
	    include('re_quote_side.php');
	} 
	
	function addrequoteNotes($var) {
	  //  echo $var;
	    	$varx = explode("|",$var);
        	 $comment = $varx[0];
        	 $requoteid= $varx[1];
        	 $jobid= $varx[2];
	 
	  if($comment != '') {
	   $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);
	   add_re_quote_notes($jobid,$requoteid,"Note Added By ".mysql_real_escape_string($staff_name),$comment);
	  }
	  include("re_quote_notes.php"); 
	}
	
	function sendreQuotetext($vars) { 
	    // echo $id; die;
	    
	    $var = explode('|',$vars);
	    
	    $id = $var[0];
	    $jobid = $var[1];
	    $requoteid = $var[2];
	    
	     $sql = mysql_query("SELECT id , name, email, booking_date ,quote_for , suburb ,  phone , site_id , (SELECT site_phone_number FROM `sites` WHERE id = site_id) as  sitephone , (SELECT GROUP_CONCAT(CONCAT('<b>' ,job_type, '</b> => ', description,'<br/>')) as descrp from quote_details WHERE quote_details.quote_id = quote_new.id  GROUP by quote_id) as descrp ,booking_id  FROM `quote_new`  WHERE booking_id = '.$jobid.'");
	     
	     $count = mysql_num_rows($sql);
	    
	    if($count > 0) { 
	    
	          $infodata = mysql_fetch_array($sql);
	          
	         // print_r($infodata); die;
	         $notescommets = get_rs_value("re_quoteing", "commets", $requoteid);
	    
	        $str = array('$date', '$name', '$suburb','$ourphone' ,'$desc','$jobid','$notes');
	        $replacestr = array(changeDateFormate($infodata['booking_date'], 'datetime'), $infodata['name'], $infodata['suburb'],$infodata['sitephone'],$infodata['descrp'], $jobid,$notescommets);
	    
    		
    	
    	  // echo "SELECT message , subject  FROM `sales_template`  WHERE id = ".$id."";
    	
    		$tpldata = mysql_fetch_array(mysql_query("SELECT message , subject  FROM `sales_template`  WHERE id = ".$id.""));
    		
    	//	print_r($tpldata); die;
    		
    	    $messageText = str_replace($str,$replacestr, $tpldata['message'] );
    	    
    	    $subject = str_replace('$jobid' , '#J'.$jobid , $tpldata['subject']); 
    			
        		if($id == 8 || $id == 10) {
        			    sendmail($infodata['name'],$infodata['email'], $subject , $messageText, 'bookings@bcic.com.au' , $infodata['site_id'] , $infodata['quote_for']);
        			    sendmail($infodata['name'],'pankaj.business2sell@gmail.com', $subject , $messageText, 'bookings@bcic.com.au' , $infodata['site_id'] , $infodata['quote_for']);
        			    $heading  = $subject. ' On  '.$infodata['email']; 
        		}elseif($id == 9 || $id == 11) {
                       //$sms_code = send_sms(str_replace(" ","",11111111111),$messageText); //04-03-2019
                      $sms_code = send_sms(str_replace(" ","",$infodata['phone']),$messageText); //04-03-2019
                      $heading  = $subject. ' On  '.$infodata['phone']; 
                     if($sms_code=="1"){ $heading.="  (Delivered)"; }else{ $heading.=" <span style=\"color:red;\">(Failed)</span>";}
                    
        		}
    		
    		 add_job_notes($jobid,$heading,$heading);
    		 add_re_quote_notes($jobid,$requoteid,$heading,'');
	    }
		
		echo $heading;
		//echo $messageText;
	}  
	
	function removeNotification($id) {
		
		$currentDate = date('Y-m-d H:i:s');
		$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
		$messageRead = $staff_name.'_('.$currentDate.')';
		$qryBool = mysql_query( "UPDATE site_notifications SET 
		notifications_status = 1,notification_read_user = '".$messageRead."' WHERE id = {$id}" );	
		echo 1;
	}
	
	function search_monthly_admin_roster($str){
		$vars = explode('|',$str);
		
		$_SESSION['monthly_admin_roster']['from_date'] = $vars[0];
		$_SESSION['monthly_admin_roster']['to_date'] = $vars[1];
		
		if($vars[2] != '') {
		   $_SESSION['monthly_admin_roster']['permanent_role'] = $vars[2];
		}else{
		    unset($_SESSION['monthly_admin_roster']['permanent_role']);
		}
		
		 include("view_monthly_admin_roster.php"); 
	}
	
	function searchUrgentNoti($str){
		//echo $str;
		$vars = explode('|',$str);
		
		$_SESSION['urgent_notification']['login_id'] = $vars[0];
		$_SESSION['urgent_notification']['message_status'] = $vars[1];
		$_SESSION['urgent_notification']['p_order'] = $vars[2];
		
		 include("view_urgent_notification.php"); 
	}
	
	function changfeWallBoardDate($str){
	    
	    $_SESSION['wall_board']['calldate'] = $str;
		
		 include('view_wall_board.php'); 
	}
	
	function daily_call_get($str){
		
		 $vars = explode('|',$str);
		  
		 $_SESSION['calling_date']['date'] = $vars[0];
		 $_SESSION['calling_date']['admin_id'] = $vars[1];
		
		 include('view_daily_call_report.php'); 
	}
	
	function task_add($str){
		
		$vars = explode('|', $str);
		$sql = mysql_query("select * from message_chat_child  where id=".$vars[0]."");
		$count = mysql_num_rows($sql);
		
		$getdata = mysql_fetch_assoc($sql);
		
		 if($getdata['notification_id'] == 0) {
				  $adminname = get_rs_value("admin","name",$getdata['from_id']);
				  
				  $subject = 'Chat Task Added By  '.$adminname;
				  $notificationArrayData = 
								   array(
										'notifications_type' => 8,
										'quote_id' => $getdata['quote_id'],
										'job_id' => $getdata['job_id'],
										'staff_id' => 0,
										'task_type' => 2,
										'chat_id' => $getdata['id'],
										'task_from' => $getdata['from_id'],
										'heading' => $subject,
										'comment' => $getdata['message_text'],
										'notifications_status' => 0,
										'login_id' => $getdata['group_to'],
										'is_urgent' => 0,
										'staff_name' => $adminname,
										'date' => date("Y-m-d H:i:s")
								 );

										
			$getlastid = add_site_notifications($notificationArrayData ,1 ); 
			$qryBool = mysql_query( "UPDATE message_chat_child SET 
			task_add_date = '".date("Y-m-d H:i:s")."', notification_id = '".$getlastid."' WHERE id = {$getdata['id']}" );	
			
			echo 'Task added at '.date("dS M H:i:s");
		 }else{
			 echo 'Already added to '.date("dS M H:i:s" , strtotime($getdata['task_add_date']));
		 }
		
	}
	
	
	function check_noti_popup($login){
    	    
 	     $sql = mysql_query("SELECT id, heading, date,job_id ,p_order, Now() as ttime,   DATE_ADD(date, INTERVAL 15 MINUTE) as adddate , Now() as cime  FROM `site_notifications` WHERE notifications_status = 0  AND message_status =1 AND login_id =".$login." and p_order = 1 AND DATE_ADD(date, INTERVAL 15 MINUTE) <= Now()");
	     $count = mysql_num_rows($sql);
	     
	     echo  $count;
	    
	}
	function trackReivew($str){
	    
	     $vars = explode('|',$str);
		  
		 $_SESSION['review_data_track']['from_date'] = $vars[0];
		 $_SESSION['review_data_track']['to_date'] = $vars[1];
		
		 include('review_system.php'); 
	}
	
	function reshuffle($tasktypeid){
	    
	    //echo $tasktypeid;
	    if($tasktypeid != 0) {
	       movereshuffle($tasktypeid);
	    }else{
	        echo 'Please select task type ';
	    }
	    
	     include('view_task_reports.php'); 
	}
	
	function hr_side_panel($str){
	      $appid = $str;
	     getinSMS($appid);
	    
	    include('app_side_panel.php'); 
	}
	
	function add_comment_notes($str1) {
	      $vars = explode('|',$str1);
	      $str = $vars[0].'|'.$vars[1].'|1';
	      application_add_comment($str);
	}
	
	function search_application_track($str){
	    $vars = explode('|',$str);
		  
		 $_SESSION['application_track']['from_date'] = $vars[0];
		 $_SESSION['application_track']['to_date'] = $vars[1];
		 
		 //print_r($_SESSION['application_track']); die;
		
		 include('application_system.php'); 
	    
	}
	
	function application_status_track($vars){
            
            $var = explode('|',$vars);
            $stage = $var[0];
            $id = $var[1];
            if($id > 0) {
                $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
                $bool = mysql_query("update staff_applications set step_status ='".$stage."' where id=".$id."");
                $astatusstatus =  getSystemvalueByID($stage, 55);
                $heading = $staff_name.' Change App Status in '.$astatusstatus;
                add_application_notes($id, $heading,$heading ,'','','', 0);
            }
	     echo $stage;	
	}
	
    function review_side_panel($str){
        
        $review_id = $str;
         //echo $str;
         include('review_side_panel.php');
    }	
	
   function sendreviewSMS($str){
       
        $vars =   explode('|' ,$str); 
        $reviid = $vars[0];
        $typeid = $vars[1];
        
        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);
        // $applicatename = get_rs_value("bcic_review", "name", $reviid);
        $reviedata = mysql_fetch_assoc(mysql_query("SELECT * FROM `bcic_review` WHERE id = '".$reviid."'"));
        
        $tpldata = mysql_fetch_assoc(mysql_query("SELECT * FROM `tpl_application` where id=".$typeid.""));
        
        
        $heading = $tpldata['subject'].' Send SMS on '.$reviedata['phone'];
        $comment = $tpldata['message'];
        //$name, Its $sendername f
       $message = str_replace(array('$name','$sendername') , array($reviedata['name'] , $staff_name) ,$comment);
        
        $sms_code = send_sms(str_replace(" ","",$reviedata['phone']),$msg);
        
        // $sms_code = send_sms(str_replace(" ","",'0434158227'),$message);
        //echo $sms_code.'hih';
        if($sms_code=="1"){ $heading.=" (Delivered)"; $flag = 1; }else{  $flag = 2; $heading.=" <span style=\"color:red;\">(Failed)</span>";}
        //add_job_notes($job_id,$heading,$msg); 
        if($flag == 1) {
           $bool = mysql_query("update bcic_review set {$tpldata['field_name']} ='".date('Y-m-d H:i:s')."' where id=".$reviid."");  
        }
        add_review_notes($reviid, $heading, $message);
        echo $heading;
       
   }	
   
   function sop_manual_email($str)
    {
       
       $vars = explode('|', $str);
       $appid = $vars[0];
       $name = $vars[1];
       sop_manual_email_attchment($appid , $name);
         echo '<p style="color:red;">Send Email</p>';
       
    }
   
   function review_track($vars){
            
            $var = explode('|',$vars);
            $stage = $var[0];
            $id = $var[1];
            if($id > 0) {
               $staff_name = get_rs_value("admin","name",$_SESSION['admin']);
            //echo "update bcic_review set step ='".$stage."' where id=".$id."";
            
                $bool = mysql_query("update bcic_review set step ='".$stage."' where id=".$id."");
                $astatusstatus =  getSystemvalueByID($stage, 152);
                $heading = $staff_name.' Change track Status in '.$astatusstatus;
                add_review_notes($id, $heading,$heading);
            }
	    echo $stage;	
	}
	
	function search_bookedJobs($str){
	    
	     $vars = explode('|', $str);
	     
        $fromid = $vars[0];
        $toid = $vars[1];
        $adminid = $vars[2];
	    
        $_SESSION['job_booked_report']['from_date'] = $fromid;
        $_SESSION['job_booked_report']['to_date'] = $toid;
    
        if($adminid > 0) {
          $_SESSION['job_booked_report']['login_id'] = $adminid;
        } else{
            unset($_SESSION['job_booked_report']['login_id']);
        }
        
        
         
		 include('view_job_booked_report.php'); 
	}
	
	function cehck_call($str){
	     
	      $vars = explode('|',$str);
	      
	      $id = $vars[1];
	     
	      if($vars[0] == 0) {
	          $date = '0000-00-00 00:00:00';
	      }else{
	          $date = date('Y-m-d H:i:s');
	      }
	    
	   // echo "update bcic_review set call_check ='".$date."' where id=".$id."";
	      $bool = mysql_query("update quote_new set call_check ='".$date."' where id=".$id."");  
	}
	
	function update_job_type($str) {
	    
	   //  echo  $str; 
	    
	        $vars =   explode('|',$str); 
	    
            $val = $vars[0];
            $flag = $vars[1];
            $id = $vars[2];
            
            
            
	    
        $argx = "select id, job_types from staff_applications where id='".mysql_real_escape_string($id)."'"; 
        //echo $argx; echo $a;	
        $datax = mysql_query($argx);
        $getAppdata = mysql_fetch_assoc($datax); 
        
         // $getjobarr = explode(',' , $getAppdata['job_types']) ;
          
          
        if($flag == 1) {
			 if($getAppdata['job_types'] == ''){
				$getjobs = $val;
			}else {
				$ext_jobs = $getAppdata['job_types'];
				$getjobs = $ext_jobs.','.$val;
			}
		    $getjobs = implode(',',array_unique(explode(',', $getjobs)));
		}else {
			//array_search
			$jobsarr = explode(',', $getAppdata['job_types']);
			
			//print_r($jobsarr);
			
			$value =  array_search($val, $jobsarr);  
			unset($jobsarr[$value]);
			$getjobs = implode(',',array_unique($jobsarr));
		}  
          
         $update_contact = mysql_query("UPDATE staff_applications SET job_types = '".$getjobs."' WHERE id = '".$id."'" ); 
     
	}
	
	
	function search_bbc_invoive($var){
	    
	    $vars = explode('|', $var);
	    
        $fromid = $vars[0];
        $toid = $vars[1];
	    
        $_SESSION['bbc_invoice']['from_date'] = $fromid;
        $_SESSION['bbc_invoice']['to_date'] = $toid;
      
		 include('view_bbc_invoice.php'); 
	    
	}
	
	function paidlead($str){
	    
	        $vars = explode('|',$str);
	     
            $stffid = $vars[0];
            $quoteidsdata = $vars[1];
            $quoteamount = $vars[2];
            
            $quoteids =  explode('/',$quoteidsdata);
            
            $quoteid = implode("','",$quoteids);
            
         $comments = 'Quote Id '.$quoteidsdata;
        
        
       $update_contact = mysql_query("UPDATE quote_new SET lead_payment_status = '2', lead_pay_date = '".date('Y-m-d H:i:s')."' WHERE id in ( '".$quoteid."') AND bbcapp_staff_id = ".$stffid.""); 
   
        
        $ins = 	mysql_query("insert into staff_journal_new set staff_id=".$stffid.",  staff_rec = ".$quoteamount." ,  total_amount = ".$quoteamount." ,  journal_date='".date("Y-m-d")."',
		bcic_share='".$quoteamount."',   payment_type = 2, comments='".mysql_real_escape_string($comments)."'");
		
		echo  'Lead Pay Successfully Done';
	}
	
?>

