// Title: Tigra Calendar
// Description: See the demo at url
// URL: http://www.softcomplex.com/products/tigra_calendar/
// Date: 03-22-2001 (mm-dd-yyyy)
// Author: Denis Gritcyuk <denis@softcomplex.com>

var calendars = [];

// --------------------------------------------------------------------------------
// --- tigra calendar object constructor
function calendar() {

	// set default values.
	this.prev_icon = '<img src="/jscript/b_prev.gif" width="11" height="11" border="0" alt="Previous Month">';
	this.next_icon = '<img src="/jscript/b_next.gif" width="11" height="11" border="0" alt="Next Month">';
	this.empty_icon = '<img src="/jscript/pixel.gif" width="11" height="11" border="0">';
	this.calendar_icon = '<img src="/jscript/cal.gif" width="20" height="20" border="0">';
	this.arr_months = ["Jan", "Feb", "Mar", "Apl", "May",
		"Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	this.week_days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
	this.n_weekstart = 1;

	// assign methods
	this.get_cl_code   = cal_get_cl_code;
	this.get_lb_code   = cal_get_lb_code;
	this.cl_refresh    = cal_cl_refresh;
	this.lb_refresh    = cal_lb_refresh;
	this.lb_refresh_ex = cal_lb_refresh_ex;
	this.lb_init       = cal_lb_init;
	this.lb_reinit     = cal_lb_reinit;
	this.popup         = cal_popup;
	this.parse_listbox = cal_parse_listbox;
	this.set_date      = cal_set_date;
	this.get_element = (document.all ? cal_ie_get_element :
		(document.layers ? cal_nn4_get_element : cal_nn6_get_element));

	// register in global collection	
	this.id = calendars.length;
	calendars[this.id] = this;
}

// --------------------------------------------------------------------------------
// outputs listboxes html code to the target page
function cal_lb_init() {
	document.write(
		'<div id="cal' + this.id + '_lbcont">' + this.get_lb_code() + '</div>');
	this.el_lbcont = this.get_element('cal' + this.id + '_lbcont');
	this.el_date   = this.get_element('cal' + this.id + '_day');
	this.el_month  = this.get_element('cal' + this.id + '_month');
}

// --------------------------------------------------------------------------------
// updates listboxes html code in the target page
function cal_lb_reinit (dt_datetime) {
	this.el_lbcont.innerHTML = this.get_lb_code(dt_datetime);
	this.el_date   = this.get_element('cal' + this.id + '_day');
	this.el_month  = this.get_element('cal' + this.id + '_month');
}

// --------------------------------------------------------------------------------
// onclick handler for date and months links in popup calendar
function cal_cl_refresh(n_value, b_close) {
	var dt_datetime = time_reset(n_value ? new Date(n_value) : new Date());
	this.lb_reinit(dt_datetime);
	if (b_close || !this.parse_listbox(this.el_month, this.el_date))
		this.cal_window.close();
	else
		this.popup(n_value);
}

// --------------------------------------------------------------------------------
// onchange handler for listboxes on the page
function cal_lb_refresh() {
	return this.parse_listbox(this.el_month, this.el_date);
}
// --------------------------------------------------------------------------------
// onchange handler for listbox in popup calendar
function cal_lb_refresh_ex(obj_source) {
	var dt_datetime = this.parse_listbox(obj_source, this.el_date);
	if (!dt_datetime) {
		this.cal_window.close();
		return false;
	}
	this.lb_reinit(dt_datetime);
	this.popup(dt_datetime.valueOf());
}

// --------------------------------------------------------------------------------
// onclick handler calendar image on the page
function cal_popup (n_value) {
	var dt_datetime = (n_value ?
		new Date(n_value) :
		this.parse_listbox(this.el_month, this.el_date)
	);
	
	this.cal_window = window.open("", "Calendar", 
		"width=200,height=250,status=no,resizable=no,top=200,left=200");
	this.cal_window.opener = self;
	var obj_cal_document = this.cal_window.document;
	obj_cal_document.write (this.get_cl_code(dt_datetime));
	obj_cal_document.close();
	this.cal_window.focus();
}

// --------------------------------------------------------------------------------
// generates calendar code with current date specified
function cal_get_cl_code (dt_datetime) {

	dt_datetime = time_reset(dt_datetime ? dt_datetime : new Date());

	// get same date in previous month	
	var dt_prev_month = new Date(dt_datetime);
	dt_prev_month.setMonth(dt_datetime.getMonth() - 1);
	if (dt_datetime.getMonth() % 12 != (dt_prev_month.getMonth()+1) % 12) {
		dt_prev_month.setMonth(dt_datetime.getMonth());
		dt_prev_month.setDate(0);
	}
	
	// get same date in next month	
	var dt_next_month = new Date(dt_datetime);
	dt_next_month.setMonth(dt_datetime.getMonth() + 1);
	if ((dt_datetime.getMonth() + 1) % 12 != dt_next_month.getMonth() % 12)
		dt_next_month.setDate(0);
	
	// get the first day to be shown
	var dt_firstday = new Date(dt_datetime);
	dt_firstday.setDate(1);
	dt_firstday.setDate(1 - (7 + dt_firstday.getDay() - this.n_weekstart) % 7);

	// get the last day to be shown
	var dt_lastday = new Date(dt_next_month);
	dt_lastday.setDate(0);


	var dt_now = time_reset();

	var n_months = 12; // number of months to display in lisboxes
	var n_pastmonths = 3; // number of path months in the list
	
	// print more options in the listbox if date selected is out of range available
	var dt_now_verif = new Date (dt_now);
	dt_now_verif.setDate(1);
	dt_now_verif.setMonth(dt_now_verif.getMonth() - n_pastmonths);
	
	while (dt_now_verif.valueOf() > dt_datetime.valueOf()) {
		n_months++;
		dt_now_verif.setMonth(dt_now_verif.getMonth() - 1);
	}
	var dt_start_from = new Date(dt_now_verif);
	dt_now_verif.setMonth(dt_now_verif.getMonth() + n_months - 1);

	while (dt_now_verif < dt_datetime) {
		n_months++;
		dt_now_verif.setMonth(dt_now_verif.getMonth() + 1);
	}
	
	// prepare calendar header
	var str_buffer = new String (
		'<html>'+
		'<head>'+
		'	<title>Calendar</title>'+
		'	<link rel="stylesheet" href="/jscript/calendar.css">'+
		'</head>'+
		'<body bgcolor=\"White\">'+
		'<table class="calTable" cellspacing="0" cellpadding="3">' +
		'<tr>' +
		'	<td class="calMonth"><a href="javascript:window.opener.calendars[' + this.id + '].cl_refresh(' + dt_prev_month.valueOf() + ');">' + this.prev_icon + '</a></td>' +
		'	<td colspan="5" class="calHeader">' + this.arr_months[dt_datetime.getMonth()] + " " + dt_datetime.getFullYear() + '</td>' +
		'	<td class="calMonth"><a href="javascript:window.opener.calendars[' + this.id + '].cl_refresh(' + dt_next_month.valueOf() + ');">' + this.next_icon + '</a></td>' +
		'</tr>'
	);

	// print weekdays titles
	var dt_current_day = new Date(dt_firstday);
	str_buffer += '<tr>';
	for (var n = 0; n < 7; n++)
		str_buffer += '	<td class="calWeekday">'+ this.week_days[(this.n_weekstart + n) % 7] + '</td>';
	str_buffer += '</tr>';

	// print calendar body
	while (dt_current_day.getMonth() == dt_datetime.getMonth() ||
		dt_current_day.getMonth() == dt_firstday.getMonth()) {
		// print row heder
		str_buffer += '<tr>';
		for (var n_current_wday = 0; n_current_wday < 7; n_current_wday++) {
				
				if (dt_current_day.getDate() == dt_datetime.getDate() &&
					dt_current_day.getMonth() == dt_datetime.getMonth())
					// print current date
					str_buffer += '<td class="calCurrent">';
				else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
					// weekend days
					str_buffer += '<td class="calWeekend">';
				else
					// print working days of current month
					str_buffer += '<td class="calWorkday">';

				str_buffer += '<a class="calFuture' +
					(dt_current_day.getMonth() != dt_datetime.getMonth() ? 'Other' : '') +
					'" href="javascript:window.opener.calendars[' + this.id + '].cl_refresh(' +
					dt_current_day.valueOf() + ', true);">' + dt_current_day.getDate() + '</a>';

				str_buffer += '</td>';
				dt_current_day.setDate(dt_current_day.getDate() + 1);
		}
		// print row footer
		str_buffer += '</tr>';
	}
	// print month selector
	str_buffer +=
		'<tr><form class="form">' +
		'<td colspan="7" class="calMSelect" >' +
		'	<select class="calPListbox" id="cal' + this.id + '_month" name="cal' + this.id
		+ '_month" onchange="window.opener.calendars[' + this.id + '].lb_refresh_ex(this)">';
	for (var i = 0; i < n_months ; i++) {
		str_buffer += '<option value="' +
			// returned month and year format is generated here (MM/YYYY)
			(dt_start_from.getMonth() < 9 ? '0' + (dt_start_from.getMonth() + 1) : (dt_start_from.getMonth() + 1)) +
			'-' + dt_start_from.getFullYear() + '"' +
			(dt_start_from.getFullYear() == dt_datetime.getFullYear()
				&& dt_start_from.getMonth() == dt_datetime.getMonth() ? ' selected' : '') +
			'>' + this.arr_months[dt_start_from.getMonth()] + ' ' + dt_start_from.getFullYear() +
			'</option>';
		dt_start_from.setMonth(dt_start_from.getMonth() + 1);
	}
	str_buffer +=
		'	</select>' +
		'</td>' +
		'</form></tr>' +
		'</table>' +
		'</body>' +
		'</html>';
	return str_buffer;
}

// --------------------------------------------------------------------------------
// generates listboxes code with current date specified
function cal_get_lb_code(dt_datetime) {

	dt_datetime = time_reset(dt_datetime ? dt_datetime : new Date());
	var dt_now = time_reset();

	var n_months = 12; // number of months to display in lisboxes
	var n_pastmonths = 3; // number of path months in the list
	
	// print more options in the listbox if date selected is out of range available
	var dt_now_verif = new Date (dt_now);
	dt_now_verif.setDate(1);
	dt_now_verif.setMonth(dt_now_verif.getMonth() - n_pastmonths);
	
	while (dt_now_verif.valueOf() > dt_datetime.valueOf()) {
		n_months++;
		dt_now_verif.setMonth(dt_now_verif.getMonth() - 1);
	}
	var dt_start_from = new Date(dt_now_verif);
	dt_now_verif.setMonth(dt_now_verif.getMonth() + n_months - 1);

	while (dt_now_verif < dt_datetime) {
		n_months++;
		dt_now_verif.setMonth(dt_now_verif.getMonth() + 1);
	}

	// listboxes named cal<zero-based-calendar-number>_day and cal<zero-based-calendar-number>_month
	var str_buffer = 
		'<table cellpadding="2" cellspacing="0" border="0">' +
		'<tr>' +
		'<td>' +
		'	<select class="calListbox" id="cal' + this.id + '_day" name="cal' + this.id
		+ '_day" onchange="calendars[' + this.id + '].lb_refresh()">';
	for (var i = 1; i <= 31 ; i++) {
		str_buffer += '<option value="' + (i < 10 ? '0' + i : i) +
			'"' + (i == dt_datetime.getDate() ? ' selected' : '') + '>' + i + '</option>';
	}
	str_buffer +=
		'	</select>' +
		'</td>' +
		'<td>' +
		'	<select class="calListbox" id="cal' + this.id + '_month" name="cal' + this.id
		+ '_month" onchange="calendars[' + this.id + '].lb_refresh()">';

	for (var i = 0; i < n_months ; i++) {
		str_buffer += '<option value="' +
			// returned month and year format is generated here (MM/YYYY)
			(dt_start_from.getMonth() < 9 ? '0' + (dt_start_from.getMonth() + 1) : (dt_start_from.getMonth() + 1)) +
			'/' + dt_start_from.getFullYear() + '"' +
			(dt_start_from.getFullYear() == dt_datetime.getFullYear()
				&& dt_start_from.getMonth() == dt_datetime.getMonth() ? ' selected' : '') +
			'>' + this.arr_months[dt_start_from.getMonth()] + ' ' + dt_start_from.getFullYear() +
			'</option>';
		dt_start_from.setMonth(dt_start_from.getMonth() + 1);
	}
	str_buffer +=
		'	</select>' +
		'</td>' +
		(document.body == null || document.body.innerHTML == null ? '' :
			'<td><a href="javascript:calendars[' + this.id + '].popup();">' + this.calendar_icon + '</a></td>')+
		'</tr>' +
		'</table>';

	return str_buffer;
}

// --------------------------------------------------------------------------------
// browser dependent element access functions
function cal_ie_get_element(str_id)  { return document.all[str_id] }
function cal_nn6_get_element(str_id) { return document.getElementById(str_id) }
function cal_nn4_get_element(str_id) { 
	for (var i = 0; i < document.forms.length; i++)
		for (var j = 0; j < document.forms[i].elements.length; j++)
			if (document.forms[i].elements[j].name == str_id)
				return document.forms[i].elements[j];
}


// --------------------------------------------------------------------------------
// removes time component from date object to allow valid date comparison
function time_reset(dt_datetime) {
	if (!dt_datetime) dt_datetime = new Date();
	dt_datetime.setHours(0);
	dt_datetime.setMinutes(0);
	dt_datetime.setSeconds(0);
	dt_datetime.setMilliseconds(0);
	return dt_datetime;
}

// --------------------------------------------------------------------------------
// returns date object from parsing month and date listboxes
function cal_parse_listbox (obj_lbmonth, obj_lbday) {
	var re_date = /^(\d+)\/(\d+)$/;
	
	if (!re_date.exec(obj_lbmonth[obj_lbmonth.selectedIndex].value)) return;
	var dt_datetime = new Date(RegExp.$2, RegExp.$1 - 1, obj_lbday[obj_lbday.selectedIndex].value);
	
	var dt_verif_date = new Date(RegExp.$2, RegExp.$1 - 1, 1);
	
	if (dt_datetime.getMonth() != dt_verif_date.getMonth()) {
		dt_datetime.setDate(0);
		alert(this.arr_months[dt_datetime.getMonth()] + ' has only ' +
			dt_datetime.getDate() + ' days.');
		this.set_date(dt_datetime.getDate());
	}
	
	return (dt_datetime);
}

// --------------------------------------------------------------------------------
function cal_set_date (int_day) {
	for (var i = 0; i < this.el_date.length; i++) {
		if (this.el_date[i].text == int_day) {
			this.el_date[i].selected = true;
			break;
		}
	}
}

// --------------------------------------------------------------------------------

