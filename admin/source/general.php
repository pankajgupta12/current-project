<?php 
if($_REQUEST['task']=="quote"){ include("source/quote.php"); 
}else if($_REQUEST['task']=="view_quote"){ include("source/view_quote.php");
}else if($_REQUEST['task']=="staff_invoice_report"){ include("source/staff_invoice_report.php");
}else if($_REQUEST['task']=="mysms"){ include("source/view_mysms.php");
}else if($_REQUEST['task']=="monthly_admin_roster"){ include("source/monthly_admin_roster.php");

}else if($_REQUEST['task']=="mysmsnew"){ include("source/mysms_new.php");
}else if($_REQUEST['task']=="daily_call_report"){ include("source/daily_call_report.php");

}else if($_REQUEST['task']=="staff_view_quote"){ include("source/staff_view_quote.php");
}else if($_REQUEST['task']=="sms_notify"){ include("source/sms_for_notify.php");
}else if($_REQUEST['task']=="tc_payment"){ include("source/tc_payment.php");
}else if($_REQUEST['task']=="view_report"){ include("source/view_report.php");
}else if($_REQUEST['task']=="imap"){ include("source/imap.php");
}else if($_REQUEST['task']=="dispatch"){ include("source/dispatch_board.php");
}else if($_REQUEST['task']=="dispatch_report"){ include("source/dispatch_report.php"); 
}else if($_REQUEST['task']=="view_jobs"){ include("source/view_jobs.php"); 
}else if($_REQUEST['task']=="edit_quote"){ include("source/edit_quote.php"); 
}else if($_REQUEST['task']=="payment_report"){ include("source/payment_report.php"); 
}else if($_REQUEST['task']=="payment_report_page"){ include("source/payment_report_page.php"); 
}else if($_REQUEST['task']=="importview"){ include("source/import_view_details.php"); 
}else if($_REQUEST['task']=="payment_report_all"){ include("source/payment_report_all.php"); 
}else if($_REQUEST['task']=="team_payments"){ include("source/team_payments.php"); 
}else if($_REQUEST['task']=="journal"){ include("source/journal.php"); 
}else if($_REQUEST['task']=="reclean_unassign"){ include("source/reclean_unassign.php"); 
}else if($_REQUEST['task']=="sales_reports"){ include("source/sales_reports.php"); 
}else if($_REQUEST['task']=="booked_sales_reports"){ include("source/booked_sales_reports.php"); 
}else if($_REQUEST['task']=="dashboard"){ include("source/dashboard.php"); 
}else if($_REQUEST['task']=="franchise_report"){ include("source/franchise_report.php"); 
}else if($_REQUEST['task']=="payment_refund_page"){ include("source/payment_refund_page.php"); 
}else if($_REQUEST['task']=="review_reports_notes"){ include("source/review_reports_notes.php"); 
}else if($_REQUEST['task']=="task_manager"){ include("source/task_manager.php"); 
}else if($_REQUEST['task']=="message_board"){ include("source/message_board.php"); 
}else if($_REQUEST['task']=="email_template_list"){ include("source/email_template_list.php"); 
}else if($_REQUEST['task']=="email_template"){ include("source/email_template.php"); 

}else if($_REQUEST['task']=="add_application"){ include("source/add_application.php"); 
}else if($_REQUEST['task']=="admin_fault"){ include("source/admin_fault.php"); 

}else if($_REQUEST['task']=="re_quote"){ include("source/re_quote.php"); 
}else if($_REQUEST['task']=="urgent_notification"){ include("source/urgent_notification.php"); 

}else if($_REQUEST['task']=="job_booked_report"){ include("source/job_booked_report.php"); 

    /* //include("source/daily_report.php"); 	
	  include("source/bcicdahbaord_page.php"); 	 */

}else if($_REQUEST['task']=="report_dashboard"){ include("source/report_dashboard.php"); 
}else if($_REQUEST['task']=="bcicdahbaord_page"){ include("source/bcicdahbaord_page.php"); 
}else if($_REQUEST['task']=="daily_report"){ include("source/daily_report.php"); 
}else if($_REQUEST['task']=="operation_report"){ include("source/operation_report.php"); 
}else if($_REQUEST['task']=="sales_system"){ include("source/sales_system.php"); 
}else if($_REQUEST['task']=="admin_logged"){ include("source/admin_logged.php"); 


// Reclean report
}else if($_REQUEST['task']=="reclean_report"){ include("source/reclean_report.php"); 
}else if($_REQUEST['task']=="email_imap"){ include("source/email_imap.php"); 

//call import
}else if($_REQUEST['task']=="import"){ include("source/3cx.php"); 
}else if($_REQUEST['task']=="delete_import"){ include("source/delete_import.php"); 
}else if($_REQUEST['task']=="cehck_report"){ include("source/cehck_report.php"); 


}else if($_REQUEST['task']=="crons_report"){ include("source/crons_report.php"); 
}else if($_REQUEST['task']=="list_crons_report"){ include("source/list_crons_report.php"); 


// Application & job Unassinged
}else if($_REQUEST['task']=="application_report"){ include("source/application_report.php");
}else if($_REQUEST['task']=="job_unassigned"){ include("source/job_unassinged.php"); 

// Quote Report System
}else if($_REQUEST['task']=="quote_dashboard"){ include("source/quote_dashboard.php"); 
}else if($_REQUEST['task']=="quote_status"){ include("source/quote_status.php"); 
}else if($_REQUEST['task']=="quote_hourly_report"){ include("source/quote_hourly_report.php"); 
}else if($_REQUEST['task']=="daily_report_quote"){ include("source/daily_report_quote.php"); 
}else if($_REQUEST['task']=="daily_quote_booking"){ include("source/daily_quote_booking.php");

//job report
}else if($_REQUEST['task']=="job_reports"){ include("source/job_reports.php");

//BBC Weekly report
}else if($_REQUEST['task']=="bbc_weekly_reports"){ include("source/bbc_weekly_report.php");


//BBC Weekly report
//}else if($_REQUEST['task']=="bbc_weekly_reports"){ include("source/bbc_weekly_report.php");

// Reports System
}else if($_REQUEST['task']=="call_report_dashboard"){ include("source/call_report_dashboard.php"); 
}else if($_REQUEST['task']=="call_hourly_reports"){ include("source/call_hourly_reports.php"); 
}else if($_REQUEST['task']=="call_report_system"){ include("source/call_report_system.php"); 

//Chat System
}else if($_REQUEST['task']=="chat"){ include("source/chat_system.php"); 
}else if($_REQUEST['task']=="sms"){ include("source/sms_system.php"); 
}else if($_REQUEST['task']=="newsms"){ include("source/sms_system.php"); 
}else if($_REQUEST['task']=="hr_sms"){ include("source/sms_system.php"); 
}else if($_REQUEST['task']=="email"){ include("source/email_system.php"); 
}else if($_REQUEST['task']=="job_available"){ include("source/job_available.php"); 
}else if($_REQUEST['task']=="quote_email_notes"){ include("source/quote_email_notes.php"); 
}else if($_REQUEST['task']=="quote_email_notes_list"){ include("source/quote_email_notes_list.php"); 
}else if($_REQUEST['task']=="term_condition_list"){ include("source/term_condition_list.php"); 
}else if($_REQUEST['task']=="term_condition"){ include("source/term_condition.php"); 
}else if($_REQUEST['task']=="inclusion"){ include("source/inclusion.php"); 
}else if($_REQUEST['task']=="terms_agreement"){ include("source/terms_agreement.php"); 
}else if($_REQUEST['task']=="terms_agreement_list"){ include("source/terms_agreement_list.php"); 

}else if($_REQUEST['task']=="complaint_job_list"){ include("source/complaint_job_list.php"); 

}else if($_REQUEST['task']=="invoice"){ include("source/invoice.php"); 
}else if($_REQUEST['task']=="quote_call_queue"){ include("source/quote_call_queue.php"); 

}else if($_REQUEST['task']=="emails"){ include("source/emails_system.php"); 

// My Account
}else if($_REQUEST['task']=="profile_setting"){ include("source/profile_setting.php"); 
}else if($_REQUEST['task']=="my_quote"){ include("source/my_quote.php"); 

// Quote Instant
}else if($_REQUEST['task']=="quote_instant"){ include("source/quote_instant.php"); 
}else if($_REQUEST['task']=="inclusion_exlusion_list"){ include("source/inclusion_exlusion_list.php"); 
}else if($_REQUEST['task']=="sms_setting"){ include("source/sms_setting.php"); 
}else if($_REQUEST['task']=="map_setting"){ include("source/map_setting.php"); 
}else if($_REQUEST['task']=="client_review"){ include("source/client_review.php"); 
}else if($_REQUEST['task']=="sub_staff"){ include("source/sub_staff.php"); 

}else if($_REQUEST['task']=="real_estate_payment"){ include("source/real_estate_payment.php"); 
}else if($_REQUEST['task']=="cleaner_report"){ include("source/cleaner_report.php"); 

}else if($_REQUEST['task']=="slot_list"){ include("source/slot_list.php"); 

}else if($_REQUEST['task']=="active_staff"){ include("source/active_staff.php"); 
}else if($_REQUEST['task']=="bbc_leads"){ include("source/bbc_leads.php"); 

}else if($_REQUEST['task']=="contact_sms_setting"){ include("source/contact_sms_setting.php"); 

}else if($_REQUEST['task']=="review_reports"){ include("source/review_report.php"); 
}else if($_REQUEST['task']=="cleaning_amt_report"){ include("source/cleaning_amt_report.php"); 
}else if($_REQUEST['task']=="sale_sms_report"){ include("source/sale_sms_report.php");
}else if($_REQUEST['task']=="imagelink"){ include("source/imagelink.php"); 
}else if($_REQUEST['task']=="realestate_report"){ include("source/realestate_report.php"); 
}else if($_REQUEST['task']=="daily_weekly_report"){ include("source/daily_weekly_report.php"); 
}else if($_REQUEST['task']=="email_report_activity"){ include("source/email_report_activity.php"); 
}else if($_REQUEST['task']=="daily_send_email_report"){ include("source/daily_send_email_report.php"); 
}else if($_REQUEST['task']=="download_daily_send_email"){ include("source/download_daily_send_email.php"); 
}else if($_REQUEST['task']=="download_view_quote"){ include("source/download_view_quote.php"); 
}else if($_REQUEST['task']=="task_reports"){ include("source/task_reports.php"); 
}else if($_REQUEST['task']=="admin_task_reports"){ include("source/admin_task_reports.php"); 

}else if($_REQUEST['task']=="sales_track_report"){ include("source/sales_track_report.php");
}else if($_REQUEST['task']=="total_task_list"){ include("source/total_task_list.php");
}else if($_REQUEST['task']=="operation_question"){ include("source/operation_question.php");
}else if($_REQUEST['task']=="operations_list"){ include("source/operations_list.php");

}else if($_REQUEST['task']=="email_report"){ include("source/email_report.php"); 
}else if($_REQUEST['task']=="franc_case_report"){ include("source/franc_case_report.php");
}else if($_REQUEST['task']=="operation_system"){ include("source/operation_system.php"); 
}else if($_REQUEST['task']=="refund_page_export"){ include("source/refund_page_export.php"); 

}else if($_REQUEST['task']=="operation_report_task"){ include("source/operation_report_task.php"); 
}else if($_REQUEST['task']=="product_review"){ include("source/product_review.php"); 

}else if($_REQUEST['task']=="quote_compare"){ include("source/quote_compare.php"); 
}else if($_REQUEST['task']=="wall_board"){ include("source/wall_board.php"); 

}else if($_REQUEST['task']=="chat_message_board"){ include("source/chat_message_board.php"); 

}else if($_REQUEST['task']=="bbc_weekly_payment"){ include("source/bbc_weekly_payment.php"); 

}else if($_REQUEST['task']=="bbc_weekly_invoice"){ include("source/bbc_weekly_invoice.php"); 

}else if($_REQUEST['task']=="bbc-weekly-report"){ include("source/bbc-weekly-report.php"); 

}else if(isset($_REQUEST['task']) && isset($_REQUEST['action'])){
		$argx = "select * from admin_module_details where module_id=".$t; 
		$datax = mysql_query($argx);
		if (mysql_num_rows($datax)>0){ 
			include("source/general_auto.php");
		}else{
			echo "Cant Find this Task";	
			//include("source/bcicdahbaord_page.php"); 	
		}
    
	}else{
	  //include("source/daily_report.php"); 	
	  include("source/bcicdahbaord_page.php"); 	
    }
?>