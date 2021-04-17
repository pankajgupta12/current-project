<?php

//include($_SERVER['DOCUMENT_ROOT'].'googleShortUrl.php');
//echo "<pre>";
//print_r($_SERVER);
require ($_SERVER['DOCUMENT_ROOT'] . "/phpmailer/class.phpmailer.php");

/* if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/googleShortUrl.php')) {

  include($_SERVER['DOCUMENT_ROOT'].'/admin/xjax/googleShortUrl.php');

} */

ini_set('memory_limit', '512M');

ini_set('max_execution_time', '13000000');

include ("geoip.inc");

include ("forms.php");

include ("email_functions.php");

//#### FILE INCLUDE TO INVOKE TWILIO SEND FUNCTION
require ($_SERVER['DOCUMENT_ROOT'] . '/newsms/config.php');

require ($_SERVER['DOCUMENT_ROOT'] . '/newsms/source/class/SendMessage.php');
 
require ($_SERVER['DOCUMENT_ROOT'] . '/admin/mysms/class.mysms.php');

function makeThumbnails($img, $thumbName, $thumbUrl, $MaxWe = 250, $MaxHe = 350)
{

    $arr_image_details = getimagesize($img);

    $width = $arr_image_details[0];

    $height = $arr_image_details[1];

    $percent = 100;

    if ($width > $MaxWe) $percent = floor(($MaxWe * 100) / $width);

    if (floor(($height * $percent) / 100) > $MaxHe)

    $percent = (($MaxHe * 100) / $height);

    if ($width > $height)
    {

        $newWidth = $MaxWe;

        $newHeight = round(($height * $percent) / 100);

    }
    else
    {

        $newWidth = round(($width * $percent) / 100);

        $newHeight = $MaxHe;

    }

    if ($arr_image_details[2] == 1)
    {

        $imgt = "ImageGIF";

        $imgcreatefrom = "ImageCreateFromGIF";

    }

    if ($arr_image_details[2] == 2)
    {

        $imgt = "ImageJPEG";

        $imgcreatefrom = "ImageCreateFromJPEG";

    }

    if ($arr_image_details[2] == 3)
    {

        $imgt = "ImagePNG";

        $imgcreatefrom = "ImageCreateFromPNG";

    }

    if ($imgt)
    {

        $old_image = $imgcreatefrom($img);

        $new_image = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $imgt($new_image, $_SERVER['DOCUMENT_ROOT'] . "/staff/workimages/thumbnails/" . $thumbName);

        return $thumbUrl;

    }

}

//include("listing_tracking.php");


function fix_job_details_amounts($id)
{

    // quote_details_id
    $job_details_id = "";

    $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where id=" . $id));

    $job_details_id = get_sql("job_details", "id", " where quote_details_id=" . $id . "");

    $quote_id = $quote_details['quote_id'];

    if ($job_details_id == "")
    {

        $job_details_id = get_sql("job_details", "id", " where quote_id=" . $quote_details['quote_id'] . " and job_type_id=" . $quote_details['job_type_id'] . " ");

    }

    if ($job_details_id != "")
    {

        $quote_id = get_rs_value("quote_details", "quote_id", $id);

        //echo "Quote Details Number ".mysql_num_rows($quote_details);
        

        $quote_details_rows = mysql_query("select * from quote_details where id=" . $id);

        while ($r = mysql_fetch_assoc($quote_details_rows))
        {

            $inv = get_rs_value("job_type", "inv", $r['job_type_id']);

            if ($inv == "1")
            {

                $amt_total = $r['amount'];

                $staff_amt = 0;

                $profit_amt = 0;

            }
            else
            {

                $amt_total = $r['amount'];

                $staff_amt = 0;

                $profit_amt = 0;

            }

            $bool = mysql_query("update job_details set amount_total='" . $amt_total . "',discount='" . $r['discount'] . "', amount_staff='" . $staff_amt . "',amount_profit='" . $profit_amt . "' where quote_details_id=" . $id);

        }

        $amt = 0;

    }
    else
    {

        $quote_details = mysql_query("select * from quote_details where id=" . $id);

        while ($r = mysql_fetch_assoc($quote_details))
        {

            $inv = get_rs_value("job_type", "inv", $r['job_type_id']);

            if ($inv == "1")
            {

                $amt_total = $r['amount'];

                $staff_amt = 0;

                $profit_amt = 0;

            }
            else
            {

                $amt_total = $r['amount'];

                $staff_amt = 0;

                $profit_amt = 0;

            }

            $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=" . $r['quote_id']));

            if ($quote['booking_id'] != 0)
            {

                $ins_arg2 = "insert into job_details set job_id=" . $quote['booking_id'] . ",";

                $ins_arg2 .= "quote_id=" . $quote['id'] . ",";

                $ins_arg2 .= "site_id=" . $quote['site_id'] . ",";

                $ins_arg2 .= "job_type_id=" . $r['job_type_id'] . ",";

                $ins_arg2 .= "job_type='" . $r['job_type'] . "',";

                $ins_arg2 .= "quote_details_id='" . $r['id'] . "',";

                $ins_arg2 .= "staff_id=0,";

                $ins_arg2 .= "amount_total='" . $r['amount'] . "',";

                $ins_arg2 .= "amount_staff='" . $staff_amt . "',";

                $ins_arg2 .= "amount_profit='" . $profit_amt . "',";

                $ins_arg2 .= "job_date='" . $quote['booking_date'] . "',";

                $ins_arg2 .= "job_time='8:00 AM'";

                //echo $ins_arg2."<br>";
                

                $bool2 = mysql_query($ins_arg2);

            }

        }

    }

    //echo "select * from job_details where quote_id=".$quote_id;
    $quote_details_n = mysql_query("select * from job_details where quote_id=" . $quote_id);

    while ($r = mysql_fetch_assoc($quote_details_n))
    {

        $amt = ($amt + $r['amount_total']);

    }

    //echo $amt;
    //echo "update jobs set customer_amount=".$amt." where quote_id=".$quote_id.""; die;
    $bool = mysql_query("update jobs set customer_amount=" . $amt . " where quote_id=" . $quote_id);

}

function edit_quote_str($quote_id)
{

    $str = '<span class="main_head">Quote Section</span><div class="br_table">';

    $qdetails = mysql_query("select * from quote_details where quote_id=" . $quote_id . "");

    $total_amount = 0;

    while ($r = mysql_fetch_assoc($qdetails))
    {

        //echo "<pre>"; print_r($r);
        

        if ($r['description'] == "")
        {

            $desc = "";

            if ($r['job_type_id'] == "1")
            {

                if ($r['bed'] > 0)
                {
                    $desc .= ' ' . $r['bed'] . ' Beds,';
                }

                if ($r['study'] > 0)
                {
                    $desc .= ' ' . $r['study'] . ' Study,';
                }

                if ($r['bath'] > 0)
                {
                    $desc .= ' ' . $r['bath'] . ' Bath,';
                }

                if ($r['toilet'] > 0)
                {
                    $desc .= ' ' . $r['toilet'] . ' Toilet,';
                }

                if ($r['living'] > 0)
                {
                    $desc .= ' ' . $r['living'] . ' Living Areas,';
                }

                if ($r['furnished'] == "Yes")
                {
                    $desc .= ' Furnished ,';
                }

                if ($r['blinds_type'] != "")
                {
                    $desc .= ' ' . ucwords(str_replace("_", " ", $r['blinds_type'])) . ', ';
                }

                if ($r['property_type'] != "")
                {
                    $desc .= $r['property_type'];
                }

            }
            else if ($r['job_type_id'] == "2")
            {

                if ($r['bed'] > 0)
                {
                    $desc .= ' ' . $r['bed'] . ' Beds,';
                }

                if ($r['living'] > 0)
                {
                    $desc .= ' ' . $r['living'] . ' Living Areas,';
                }

                if ($r['carpet_stairs'] > 0)
                {
                    $desc .= $r['carpet_stairs'] . ' stairs';
                }

            }
            else if ($r['job_type_id'] == "3")
            {

                if ($r['pest_inside'] > 0)
                {
                    $desc .= ' Inside';
                }

                if ($r['pest_outside'] > 0)
                {
                    $desc .= ' Outside';
                }

                if ($r['pest_flee'] > 0)
                {
                    $desc .= ' & Flea and Tick';
                }

            }
            elseif ($r['job_type_id'] == "11")
            {

                if ($r['bed'] > 0)
                {
                    $desc .= ' ' . $r['bed'] . ' Beds,';
                }

                if ($r['study'] > 0)
                {
                    $desc .= ' ' . $r['study'] . ' Study,';
                }

                if ($r['lounge_hall'] > 0)
                {
                    $desc .= ' ' . $r['lounge_hall'] . ' lounge hall,';
                }

                if ($r['kitchen'] > 0)
                {
                    $desc .= ' ' . $r['kitchen'] . ' kitchen,';
                }

                if ($r['dining_room'] > 0)
                {
                    $desc .= ' ' . $r['dining_room'] . ' dining room,';
                }

                if ($r['office'] > 0)
                {
                    $desc .= ' ' . $r['office'] . ' office ,';
                }

                if ($r['garage'] > 0)
                {
                    $desc .= ' ' . $r['garage'] . ' garage,';
                }

                if ($r['laundry'] > 0)
                {
                    $desc .= ' ' . $r['laundry'] . ' laundry,';
                }

            }

            //echo  "update quote_details set description ='".$desc."' where id=".$r['id'];
            $bool = mysql_query("update quote_details set description ='" . $desc . "' where id=" . $r['id']);

        }
        else
        {

            $desc = $r['description'];

            //$bool = mysql_query("update quote_details set description ='".$desc."' where id=".$r['id']);
            
        }

        if ($r['job_type_id'] == 1)
        {

            // print_r($r);
            

            if ($r['quote_auto_custom'] == 2)
            {

                $style = 'background: #ecf1e9';

            }
            else
            {

                $style = '';

            }

            $str .= '<table class="table table-bordered" style="' . $style . '"><thead><tr><th>' . $r['job_type'] . '&nbsp;&nbsp;' . create_dd("quote_auto_custom", "system_dd", "id", "name", "type=49", "onChange=\"javascript:edit_quote_edit_field(this,'quote_details.quote_auto_custom','" . $r['id'] . "');\"", $r) . '</th>';

            //$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'"><a href="javascript:send_data('.$r['id'].'|amount_'.$r['id'].',49,\'amount_'.$r['id'].'\');">$'.$r['amount'].'</a></th>';
            

            $str .= '<th style="width:10%; text-align:center;" id="Hours_' . $r['id'] . '">Hours: ';

            $str .= '<input type="text" id="hours_' . $r['id'] . '" name="hours_' . $r['id'] . '" value="' . $r['hours'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.hours\',\'' . $r['id'] . '\');" calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '<th style="width:10%; text-align:center;" id="discount_' . $r['id'] . '">Discount: ';

            $str .= '<input type="text" id="discount_' . $r['id'] . '" name="discount_' . $r['id'] . '" value="' . $r['discount'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.discount\',\'' . $r['id'] . '\');" calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '<th style="width:10%; text-align:center;" id="rate_' . $r['id'] . '">Rate: ';

            $str .= '<input type="text" id="rate_' . $r['id'] . '" name="rate_' . $r['id'] . '" value="' . $r['rate'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.rate\',\'' . $r['id'] . '\');" calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '<th style="width:10%; text-align:right;" id="amount_' . $r['id'] . '">';

            $str .= '<input type="text" id="amt_' . $r['id'] . '" name="amt_' . $r['id'] . '" value="' . $r['amount'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.amount\',\'' . $r['id'] . '\');" calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '</tr></thead><tbody>';

            //$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
            

            $str .= '<tr><td colspan="4" align="center">';

            $str .= '<textarea rows="4" cols="60" name="desc_' . $r['id'] . '" id="desc_' . $r['id'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.description\',\'' . $r['id'] . '\');">' . $desc . '</textarea>';

            $str .= '<span class="right_cross"><a href="javascript:send_data(' . $r['id'] . ',57,\'quote_div\');"><img src="images/cross.png"></a></span>';

            $str .= '</td></tr></tbody></table>';

        }
        elseif ($r['job_type_id'] == 11)
        {

            $quotesql = mysql_query("select * from quote_new where id=" . $r['quote_id'] . "");

            $quote = mysql_fetch_array($quotesql);

            //$step = getSystemvalueByID($quote['step'],31);
            

            if ($quote['step'] == '8' || $quote['step'] == '3' || $quote['step'] == '4')
            {

                $stepstatus = 'Aprv';

                $stylestatus = 'background: #c9e6b6;';

            }
            else
            {

                $stepstatus = 'Watig';

                $stylestatus = 'background: #eacfcf;';

            }

            $button_show = true;

            if ($r['quote_auto_custom'] == 2)
            {

                $style = 'background: #ecf1e9';

            }
            else
            {

                $style = '';

            }

            $str1 = $quote['suburb'] . '|' . $quote['site_id'] . '|' . $quote['booking_date'] . '|' . $quote['quote_for'] . '|11|' . $quote['id'] . '|0';

            $onclick_loading_time = "onClick=\"javascript:check_reclean_avail('" . $str1 . "','45','quote_div3');\"";

            /*
            
                    if($_SESSION['truck']['truck_type'] != '' && $_SESSION['truck']['truck_type'] != 0) {
            
            
            
            $truck_type = create_dd("truck_type_list","staff_trucks","id","cubic_meters","truck_type=".$_SESSION['truck']['truck_type']."","",$_SESSION['truck']);
            
            
            
            }else{
            
            
            
            $truck_type = '';
            
            }	 */

            $truckamount = '';

            if ($r['truck_type_id'] != '' && $r['truck_type_id'] != 0)
            {

                $truckamount = '$ ' . get_rs_value("truck_list", "amount", $r['truck_type_id']) . ' /hr';

            }

            $str .= '<table class="table table-bordered" style="' . $style . '"><thead>';

            $str .= '<tr><th>' . $r['job_type'] . ' <br>' . create_dd("quote_auto_custom", "system_dd", "id", "name", "type=49", "onChange=\"javascript:edit_quote_edit_field(this,'quote_details.quote_auto_custom','" . $r['id'] . "');\"", $r) . '

				<br>	

                    <input type="button" style="cursor: pointer;background-color: #1562a9;color:  #fff;padding: 2px;width: 90px;margin-top: 9px;" ' . $onclick_loading_time . ' value="Check Avail"> <br/> Travel Time :  ' . $r['travelling_hr'] . ' Hr</th>';

            $str .= '<th style="width:10%; text-align:center;" id="truck_type_' . $r['id'] . '">Truck List:';

            $str .= create_dd("truck_type_id", "truck_list", "id", "truck_type_name", "", "onChange=\"javascript:edit_quote_edit_field(this,'quote_details.truck_type_id','" . $r['id'] . "');\"", $r) . '<br>';

            $str .= $truckamount;

            $str .= '</th>';

            $str .= '<th style="width:10%; text-align:center;" id="Hours_' . $r['id'] . '">Total Hr: ';

            $str .= '<input type="text" id="hours_' . $r['id'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.hours\',\'' . $r['id'] . '\');"  name="hours" value="' . $r['hours'] . '"  calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '<th style="width:10%; text-align:right;" id="amount_' . $r['id'] . '"> Amount';

            $str .= '<input type="text" id="amt_' . $r['id'] . '" name="amt_' . $r['id'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.amount\',\'' . $r['id'] . '\');"  value="' . $r['amount'] . '"  calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '</tr></thead><tbody>';

            //$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
            

            $str .= '<tr><td colspan="5" align="center">';

            $str .= '<textarea rows="4" cols="60" name="desc_' . $r['id'] . '" id="desc_' . $r['id'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.description\',\'' . $r['id'] . '\');">' . $desc . '</textarea>';

            $str .= '<span class="right_cross"><a href="javascript:send_data(' . $r['id'] . ',57,\'quote_div\');"><img src="images/cross.png"></a></span>';

            $str .= '</td></tr></tbody></table>';

            /* 		 $quotesql = mysql_query("select * from quote_new where id=".$r['quote_id']."");
            
            $quote  = mysql_fetch_array($quotesql);
            
            
            
            if($quote['step'] == '8' || $quote['step'] == '3' || $quote['step'] == '4' ) {
            
            $stepstatus = 'Aprv';
            
            $stylestatus = 'background: #c9e6b6;';
            
            }else{
            
            $stepstatus = 'Watig';
            
            $stylestatus = 'background: #eacfcf;';
            
            }
            
            
            
            $button_show = true;
            
            
            
            if($r['quote_auto_custom'] == 2){
            
            $style = 'background: #ecf1e9';
            
            }else{
            
            $style = '';
            
            }
            
            
            
            $str.='<table class="table table-bordered" style="'.$style.'"><thead>';
            
            
            
            
            
            $str1 = $quote['suburb'].'|'.$quote['site_id'].'|'.$quote['booking_date'].'|'.$quote['quote_for'].'|11|'.$quote['id'].'|0';
            
            $onclick_loading_time  = "onClick=\"javascript:check_reclean_avail('".$str1."','45','quote_div3');\"";
            
            
            
            
            
            $str.='<tr><th>'.$r['job_type'].'<br/>'.create_dd("quote_auto_custom","system_dd","id","name","type=49","onChange=\"javascript:edit_quote_edit_field(this,'quote_details.quote_auto_custom','".$r['id']."');\"",$r).' '.create_dd("truck_id","truck","id","cubic_meter","","onChange=\"javascript:edit_quote_edit_field(this,'quote_details.truck_id','".$r['id']."');\"",$r).'</th>';
            
            
            
            $str.='<th style="width:10%; text-align:center;"> ';
            
            
            
            $str.=$quote['booking_date'].'<br>'.create_dd("travel_time","system_dd_br","id","name","type=5","onChange=\"javascript:edit_quote_edit_field(this,'quote_details.travel_time','".$r['id']."');\"",$r);
            
            $str.='</th>';
            
            
            
            $str.='<th style="width:10%; text-align:center;">Total Hr: ';
            
            $str.=$r['origanl_total_time'];
            
            $str.='</th>';
            
            
            
            
            
            
            
            $str.='<th style="width:10%; text-align:center; '.$stylestatus.'">'.$stepstatus.' M3: <br>';
            
            $str.=$r['origanl_cubic'];
            
            $str.='</th>';
            
            
            
            $str.='<th style="width:10%; text-align:right;" >Amount<br>';
            
            $str.=$r['origanl_total_amount'];
            
            
            
            
            
            $quote_detailsdata = mysql_fetch_array(mysql_query("select staff_id , staff_truck_id from job_details where quote_id=".mysql_real_escape_string($r['quote_id'])." AND job_type_id = 11"));
            
            
            
            
            
            $str.='<tr><th class="td_back"> DJT : <input type="text" id="depot_to_job_time_'.$r['id'].'" name="depot_to_job_time_'.$r['id'].'" value="'.$r['depot_to_job_time'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.depot_to_job_time\',\''.$r['id'].'\');" calss="input_search" style="width: 34px;"><br/>
            
            Tvl: <input type="text" id="travelling_hr_'.$r['id'].'" name="travelling_hr_'.$r['id'].'" value="'.$r['travelling_hr'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.travelling_hr\',\''.$r['id'].'\');" calss="input_search" style="width:34px;"><br/>
            
            Ldig : <input type="text" id="loading_time_'.$r['id'].'" name="loading_time_'.$r['id'].'" value="'.$r['loading_time'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.loading_time\',\''.$r['id'].'\');" calss="input_search" style="width: 34px;"><br>
            
                  
            
                    <input type="button" style="cursor: pointer;background-color: #1562a9;color:  #fff;padding: 2px;width: 90px;margin-top: 9px;" '.$onclick_loading_time.' value="Check Avail">                   
            
            
            
            </th>';
            
            
            
            
            
            $str.='<th style="width:10%; text-align:center;" id="travelling_hr_'.$r['id'].'">Travel Time: ';
            
            $str.='<input type="text" id="traveling_'.$r['id'].'" name="traveling_'.$r['id'].'" value="'.$r['traveling'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.traveling\',\''.$r['id'].'\');" calss="input_search" style="width: 50px;">';
            
            $str.='</th>';
            
            
            
            $str.='<th style="width:10%; text-align:center;" id="Hours_'.$r['id'].'">Total Hr: ';
            
            $str.='<input type="text" id="hours_'.$r['id'].'" name="hours_'.$r['id'].'" value="'.$r['hours'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.hours\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
            
            $str.='</th>';
            
            
            
            $str.='<th style="width:10%; text-align:center;" id="cubic_meter_'.$r['id'].'">M3: ';
            
            $str.='<input type="text" id="cubic_meter_'.$r['id'].'" name="cubic_meter_'.$r['id'].'" value="'.$r['cubic_meter'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.cubic_meter\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
            
            $str.='</th>';
            
            
            
            $str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'">';
            
            $str.='<input type="text" id="amt_'.$r['id'].'" name="amt_'.$r['id'].'" value="'.$r['amount'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.amount\',\''.$r['id'].'\');" calss="input_search" style="width:50px;">';
            
            $str.='</th>';
            
            
            
            $str.='</tr></thead><tbody>';
            
            
            
            $str.='<tr><td colspan="5" align="center">';
            
            $str.='<textarea rows="4" cols="60" name="desc_'.$r['id'].'" id="desc_'.$r['id'].'" onblur="javascript:edit_quote_edit_field(this,\'quote_details.description\',\''.$r['id'].'\');">'.$desc.'</textarea>';
            
            $str.='<span class="right_cross"><a href="javascript:send_data('.$r['id'].',57,\'quote_div\');"><img src="images/cross.png"></a></span>';
            
            $str.='</td></tr></tbody></table>'; */

        }
        else
        {

            if ($r['job_type_id'] == 2 || $r['job_type_id'] == 3)
            {

                $system_type = '&nbsp;&nbsp;' . create_dd("quote_auto_custom", "system_dd", "id", "name", "type=49", "onChange=\"javascript:edit_quote_edit_field(this,'quote_details.quote_auto_custom','" . $r['id'] . "');\"", $r);

                if ($r['quote_auto_custom'] == 2 && $r['job_type_id'] == 2)
                {

                    $style = 'background: #ecf1e9';

                }
                elseif ($r['quote_auto_custom'] == 2 && $r['job_type_id'] == 3)
                {

                    $style = 'background: #ecf1e9';

                }
                else
                {

                    $style = '';

                }

            }
            else
            {

                $system_type = '';

                $style = '';

            }

            $str .= '<table class="table table-bordered"  style="' . $style . '"><thead><tr><th colspan="2">' . $r['job_type'] . $system_type . '</th>';

            //$str.='<th style="width:10%; text-align:right;" id="amount_'.$r['id'].'"><a href="javascript:send_data('.$r['id'].'|amount_'.$r['id'].',49,\'amount_'.$r['id'].'\');">$'.$r['amount'].'</a></th>';
            $str .= '<th style="width:10%; text-align:right;" id="amount_' . $r['id'] . '">';

            $str .= '<input type="text" id="amt_' . $r['id'] . '" name="amt_' . $r['id'] . '" value="' . $r['amount'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.amount\',\'' . $r['id'] . '\');" calss="input_search" style="width:50px;">';

            $str .= '</th>';

            $str .= '</tr></thead><tbody>';

            //$str.='<tr><td colspan="3">'.$desc.' <span style="float:right;"><input type="button" value=".." onclick="javascript:send_data('.$r['id'].',51,\'amount_'.$r['id'].'"></span>';
            $str .= '<tr><td colspan="3" align="center">';

            $str .= '<textarea rows="4" cols="60" name="desc_' . $r['id'] . '" id="desc_' . $r['id'] . '" onblur="javascript:edit_quote_edit_field(this,\'quote_details.description\',\'' . $r['id'] . '\');">' . $desc . '</textarea>';

            $str .= '<span class="right_cross"><a href="javascript:send_data(' . $r['id'] . ',57,\'quote_div\');"><img src="images/cross.png"></a></span>';

            $str .= '</td></tr></tbody></table>';

        }

        $total_amount = ($total_amount + $r['amount']);

    }

    $str .= '</div>';

    $str .= getQuoteQuestion($quote_id);

    //$str.='<div class="btn_get_quot" style="margin-left:155px;"><a href="javascript:void(0)" onClick="getQuoteQuestions();">Quote Questions</a></div>';
    

    $str .= '<div class="btn_get_quot" style="margin-left:155px;"><a href="javascript:void(0)" onClick="getQuoteQuestions(\'' . $quote_id . '\',\'530\',\'quote_div3\');">Quote Questions</a></div>';

    $str .= '<table class="table table-bordered"><tfoot><tr><td><b>Total</b></td><td id="total_amount_quote">$' . $total_amount . '</td></tr></tfoot></table>';

    $booking_id = get_rs_value("quote_new", "booking_id", $quote_id);

    if ($booking_id == 0)
    {

        $str .= '<div class="buttons" id="update_job_desc">';

        $str .= '<div class="btn_get_quot"><a href="javascript:update_desc(\'' . $quote_id . '\',166,\'update_job_desc\');">Update description</a></div>';

        $str .= '</div>';

    }

    $str .= '<div class="buttons">';

    $str .= '<div class="btn_get_quot"><a href="javascript:scrollWindow(\'email_quote.php?quote_id=' . $quote_id . '\',\'1200\',\'850\')" >View Quote</a></div>';

    $str .= '<div class="btn_bok_now" id="email_quote_div"><a href="javascript:send_data(\'' . $quote_id . '\',\'27\',\'email_quote_div\')">Email Quote</a></div>';

    $str .= '</div>';


    $bbcapp_staff_id = get_rs_value("quote_new", "bbcapp_staff_id", $quote_id);
    $auto_role = get_rs_value("admin", "auto_role", $_SESSION['admin']);
    
    
    if($bbcapp_staff_id > 0 && $auto_role == 15) {

        $str .= '<div class="buttons" id="book_now_div">';
    
        $str .= '<div class="btn_get_quot"><a href="javascript:send_data(\'' . $quote_id . '\',9,\'book_now_div\');">Book Now</a></div>';
    
        $str .= '</div>';
        
    }else if($bbcapp_staff_id ==  0 ){
         $str .= '<div class="buttons" id="book_now_div">';
    
        $str .= '<div class="btn_get_quot"><a href="javascript:send_data(\'' . $quote_id . '\',9,\'book_now_div\');">Book Now</a></div>';
    
        $str .= '</div>';
    }

    $stepcheck = get_rs_value("quote_new", "step", $quote_id);

    /* if($button_show == true){
    
    
    
         echo '<span id="inventory_email_message"></span>';
    
    		echo '<div class="btn_bok_now_email" id="inventory_email"><a href="javascript:send_data(\''.$quote_id.'\',\'503\',\'inventory_email_message\')" style="color: #fff;">inventory Email </a></div>';
    
    		echo '</div>';	
    
    
    
    		echo '<div class="btn_bok_now_email" id="inventory_sms"><a href="javascript:send_data(\''.$quote_id.'\',\'504\',\'inventory_email_message\')" style="color: #fff;">inventory SMS</a></div>';
    
    		echo '</div>';	
    
     } */

    if ($stepcheck == 2)
    {

        $str .= '<div class="buttons" >';

        $str .= '<div  id="quote_approved">';

        if ($total_amount == 0)
        {

            $str .= '<a class="quote_approved_btn" onClick="alert(\'Please enter amount of quote\');" style="cursor: pointer;">Approve and Email Quote</a>';

        }
        else
        {

            $str .= '<a class="quote_approved_btn" href="javascript:send_data(\'' . $quote_id . '|' . $stepcheck . '\',446,\'quote_approved\');" style="cursor: pointer;">Approve and Email Quote</a>';

        }

        $str .= '</div>';

        $str .= '</div>';

    }

    $bool = mysql_query("update quote_new set amount='" . $total_amount . "' where id=" . $quote_id);

    return $str;

}

function getFileCount($dirPath = null)

{

    $directory = $dirPath;

    $files = scandir($directory);

    for ($i = 0;$i < count($files);$i++)
    {

        if ($files[$i] != '.' && $files[$i] != '..')

        { //echo $files[$i]; echo "<br>";
            $file_new[] = $files[$i];

        }

    }

    $num_files = count($file_new);

    return $num_files;

}

//   add_job_emails($booking_id,$heading,$comment,$quote_email,$createdOn,$login_id,$staff_name);
function add_job_emails($job_id, $heading, $comment, $email, $createdOn = null, $login_id = null, $staff_name = null)
{

    if ($createdOn == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $createdOn;

    }

    if ($login_id == '')

    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        $admin_id = $_SESSION['admin'];

    }

    else

    {

        $staff_name = $staff_name;

        $admin_id = $login_id;

    }

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $ins_arg = "insert into job_emails set job_id=" . $job_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " email='" . mysql_real_escape_string($email) . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //	echo $ins_arg; die;
    $ins = mysql_query($ins_arg);

}

function add_message_board($to, $subject, $message, $priority = null)
{

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $createdOn = date("Y-m-d h:i:s");

    $ins_arg = "insert into message_board set message_to='" . $to . "',";

    $ins_arg .= " message_from='" . $_SESSION['admin'] . "',";

    $ins_arg .= " subject='" . $subject . "',";

    $ins_arg .= " message='" . mysql_real_escape_string($message) . "',";

    $ins_arg .= " login_id='" . $_SESSION['admin'] . "',";

    $ins_arg .= " createdOn='" . $createdOn . "',";

    $ins_arg .= " priority='" . $priority . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg; die;
    $ins = mysql_query($ins_arg);

}

function add_call_schedule_report($quote_id, $slot_date = null, $slot_time = null, $call_done = null, $take_call = null, $status = null, $re_schedule, $call_step = null, $urgent_call = null, $site_id = null, $org_created_date = null, $time_type = null, $call_reverse = null)
{

    // var_dump($quote_id,$slot_date = null , $slot_time = null , $call_done = null , $take_call = null ,$status = null , $re_schedule ,  $call_step = null ,$urgent_call = null ,$site_id = null ,$org_created_date = null , $time_type); die;
    

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    if ($time_type == '1')
    {

        $slot_name = get_sql("site_time_slot", "schedule_time", " where id =" . $slot_time . "");

    }
    else
    {

        $slot_name = $slot_time;

        $slot_time = 0;

    }

    if ($slot_name != '')
    {

        $slot_details = explode('-', $slot_name);

        $slot_from = $slot_details[0];

        $slot_to = $slot_details[1];

    }
    else
    {

        $slot_from = '';

        $slot_to = '';

    }

    //echo $slot_from; die;
    

    $countresult = mysql_num_rows(mysql_query("SELECT id  FROM `call_schedule_report` WHERE `quote_id` = " . $quote_id . ""));

    if ($countresult == 1)
    {

        $login_id = 0;

    }
    else
    {

        $login_id = $_SESSION['admin'];

    }

    if ($slot_from != '')
    {

        $schedule_date_time = $slot_date . ' ' . $slot_from . ':00';

    }

    $createdOn = date("Y-m-d h:i:s");

    $ins_arg = "insert into call_schedule_report set quote_id='" . $quote_id . "',";

    $ins_arg .= " schedule_date='" . $slot_date . "',";

    $ins_arg .= " schedule_time='" . $slot_time . "',";

    $ins_arg .= " schedule_time_value='" . $slot_name . "',";

    $ins_arg .= " slot_from='" . $slot_from . "',";

    $ins_arg .= " slot_to='" . $slot_to . "',";

    $ins_arg .= " call_done='" . $call_done . "',";

    $ins_arg .= " site_id='" . $site_id . "',";

    $ins_arg .= " status='" . $status . "',";

    $ins_arg .= " take_call='" . $take_call . "',";

    $ins_arg .= " re_schedule='" . $re_schedule . "',";

    $ins_arg .= " login_id='" . $login_id . "',";

    $ins_arg .= " call_step='" . $call_step . "',";

    $ins_arg .= " time_type='" . $time_type . "',";

    $ins_arg .= " call_reverse='" . $call_reverse . "',";

    $ins_arg .= " urgent_call='" . $urgent_call . "',";

    $ins_arg .= " createdOn='" . $createdOn . "',";

    $ins_arg .= " schedule_date_time='" . $schedule_date_time . "',";

    $ins_arg .= " org_created_date='" . $org_created_date . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg; die;
    $ins = mysql_query($ins_arg);

}

function add_quote_emails($quoteid, $heading, $comment, $email)
{

    $job_id = get_rs_value("quote_new", "booking_id", $quoteid);

    if ($job_id != 0)
    {

        add_job_emails($job_id, $heading, $comment, $email);

    }

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $ins_arg = "insert into quote_emails set quote_id=" . $quoteid . ",";

    $ins_arg .= " quote_email='" . mysql_real_escape_string($email) . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " createdOn='" . date("Y-m-d h:i:s") . "',";

    $ins_arg .= " login_id='" . $_SESSION['admin'] . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg;
    $ins = mysql_query($ins_arg);

}

function add_staff_notes($staff_id, $jobid, $heading, $comment, $customDate = null, $customNameForcx = null, $adminId = null, $importId = null)
{

    if ($customDate == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $customDate;

    }

    if ($customNameForcx != '' && $adminId > 0)

    {

        $staff_name = $customNameForcx;

        $admin_id = $adminId;

    }
    else
    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        $admin_id = $_SESSION['admin'];

    }

    //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
    $ins_arg = "insert into staff_notes set staff_id=" . $staff_id . ",";

    $ins_arg .= " job_id='" . $jobid . "',";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    if ($importId != '')
    {

        $ins_arg .= " 3cx_upload_id='" . $importId . "',";

    }

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //	echo $ins_arg;
    $ins = mysql_query($ins_arg);

}

function add_application_notes($appl_id, $heading, $comment, $customDate = null, $customNameForcx = null, $adminId = null, $staff_id = null , $messageid = 0)
{

    if ($customDate == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $customDate;

    }

    if ($customNameForcx != '')

    {

        $staff_name = $customNameForcx;

        $admin_id = $adminId;

    }
    else
    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        $admin_id = $_SESSION['admin'];

    }

    //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
    $ins_arg = "insert into application_notes set application_id=" . $appl_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " staff_id='" . $staff_id . "',";
    
    $ins_arg .= " messageid='" . $messageid . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

   // echo $ins_arg; 
    $ins = mysql_query($ins_arg);

}


function add_review_notes($reviewid, $heading, $comment)
{

    $customDate = date("Y-m-d H:i:s");
    
    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);
    
    $admin_id = $_SESSION['admin'];
    $ins_arg = "insert into review_notes set review_id=" . $reviewid . ",";

    $ins_arg .= " createdOn='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

   // echo $ins_arg; 
    $ins = mysql_query($ins_arg);

}

function add_quote_notes($quote_id, $heading, $comment, $customDate = null, $customNameForcx = null, $adminId = null, $importId = null)
{

    $job_id = get_rs_value("quote_new", "booking_id", $quote_id);

    //var_dump($quote_id,$heading,$comment , $customDate, $customNameForcx , $adminId,$importId); die;
    

    if ($job_id != 0)
    {

        add_job_notes($job_id, $heading, $comment, $customDate, $customNameForcx, $adminId, $importId, $quote_id);

    }

    if ($customDate == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $customDate;

    }

    if ($customNameForcx != '')

    {

        $staff_name = $customNameForcx;

        //$admin_id = $adminId;
        

        
    }
    else
    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        //$admin_id = $_SESSION['admin'];
        
    }

    if ($adminId > 0)

    {

        //$staff_name = $customNameForcx;
        $admin_id = $adminId;

    }
    else
    {

        //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
        $admin_id = $_SESSION['admin'];

    }

    //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
    

    $ins_arg = "insert into quote_notes set quote_id=" . $quote_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    if ($importId != '')
    {

        $ins_arg .= " 3cx_upload_id='" . $importId . "',";

    }

    $ins_arg .= " staff_name='" . $staff_name . "'";

    $ins = mysql_query($ins_arg);

}

function add_re_quote_notes($job_id, $requoteid, $heading, $comment)
{

    $customDate = date("Y-m-d H:i:s");
    $admin_id = $_SESSION['admin'];
    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);
    
    $ins_arg = "insert into re_quote_notes set job_id=" . $job_id . ", re_quote_id=" . $requoteid . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    $ins = mysql_query($ins_arg);

}


function add_complaint_notes($job_id,$complaint_id, $heading, $comment,$notes_type = 0)
{
			$customDate = date("Y-m-d H:i:s");
			$staff_name = get_rs_value("admin", "name", $_SESSION['admin']);
			$admin_id = $_SESSION['admin'];
    

    $ins_arg = "insert into complaint_notes set job_id=" . $job_id . ",";
    $ins_arg .= " complaint_id='" . $complaint_id . "',";
    $ins_arg .= " createOn='" . $customDate . "',";
	if($notes_type > 0) {
     $ins_arg .= " notes_type='" . $notes_type . "',";
	}

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";
    $ins_arg .= " comments='" . mysql_real_escape_string($comment) . "',";
    $ins_arg .= " login_id='" . $admin_id . "',";
    $ins_arg .= " admin_name='" . $staff_name . "'";

	// echo $ins_arg;
	
    $ins = mysql_query($ins_arg);

}

function add_reclean_notes($job_id, $heading, $comment, $customDate = null, $customNameForcx = null, $adminId = null, $importId = null, $quote_id = null, $specific_re_notes_staff = null)
{

    if ($customDate == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $customDate;

    }

    if ($customNameForcx != '')
    {

        $staff_name = $customNameForcx;

    }
    else
    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    }

    if ($adminId > 0)

    {

        //$staff_name = $customNameForcx;
        $admin_id = $adminId;

    }
    else
    {

        //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
        $admin_id = $_SESSION['admin'];

    }

    if ($quote_id != '')
    {

        $quote_id = $quote_id;

    }
    else
    {

        $quote_id = get_rs_value("jobs", "quote_id", $job_id);

    }

    $ins_arg = "insert into reclean_notes set job_id=" . $job_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    if ($importId != '')
    {

        $ins_arg .= " 3cx_upload_id='" . $importId . "',";

    }

    if ($specific_re_notes_staff != '')
    {

        $ins_arg .= " specific_re_notes_staff='" . $specific_re_notes_staff . "',";

    }

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';
    $ins = mysql_query($ins_arg);

}

function add_job_notes($job_id, $heading, $comment, $customDate = null, $customNameForcx = null, $adminId = null, $importId = null, $quote_id = null)
{

    if ($customDate == '')

    {

        $customDate = date("Y-m-d H:i:s");

    }

    else

    {

        $customDate = $customDate;

    }

    if ($customNameForcx != '')
    {

        $staff_name = $customNameForcx;

    }
    else
    {

        if ($_SESSION['admin'] != '')
        {

            $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        }
        else
        {

            $staff_name = 'Automated';

        }

    }

    if ($adminId > 0)

    {

        //$staff_name = $customNameForcx;
        $admin_id = $adminId;

    }
    else
    {

        //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
        if ($_SESSION['admin'] != '')
        {

            $admin_id = $_SESSION['admin'];

        }
        else
        {

            $admin_id = 0;

        }

    }

    if ($quote_id != '')
    {

        $quote_id = $quote_id;

    }
    else
    {

        $quote_id = get_rs_value("jobs", "quote_id", $job_id);

    }

    $ins_arg = "insert into job_notes set job_id=" . $job_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    if ($importId != '')
    {

        $ins_arg .= " 3cx_upload_id='" . $importId . "',";

    }

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_3pm_notes($jobid, $quote_id, $jdetailsid, $type, $comment, $heading)
{

    $customDate = date("Y-m-d H:i:s");

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    //$heading = 'Add Notes By '.$staff_name;
    

    $admin_id = $_SESSION['admin'];

    $ins_arg = "insert into 3pm_notes set j_id=" . $jdetailsid . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " job_id='" . $jobid . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " type='" . $type . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_sales_follow($sales_id, $quote_id, $follow_date_time, $next_action = null, $task_result = null, $ans_date, $left_sms_date, $task_type = 1)
{

    $customDate = date("Y-m-d H:i:s");

    //$staff_name = get_rs_value("admin","name",$_SESSION['admin']);
    //$heading = 'Add Notes By '.$staff_name;
    

    $admin_id = $_SESSION['admin'];

    $ins_arg = "insert into sales_follow set sales_id=" . $sales_id . ",";

    $ins_arg .= " created_date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " admin_id='" . $admin_id . "',";

    $ins_arg .= " next_action='" . $next_action . "',";

    $ins_arg .= " task_result='" . $task_result . "',";

    $ins_arg .= " ans_date='" . $ans_date . "',";

    $ins_arg .= " task_type='" . $task_type . "',";

    $ins_arg .= " left_sms_date='" . $left_sms_date . "',";

    $ins_arg .= " follow_date_time='" . $follow_date_time . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_task_manager($task_id, $quote_id, $task_type, $fallow_date, $fallow_time, $response_type, $taskmanagerid, $job_id = 0,  $admin_id = 0)
{

    //echo  "update task_manager set completed_date ='".date('Y-m-d H:i:s')."' , status = '0'   where id=".$taskmanagerid.""; die;
    /* echo "update task_manager set completed_date ='".date('Y-m-d H:i:s')."' , status = '0' ,  next_response = '".$response_type."'   where id=".$taskmanagerid."";die; */

	// echo  "update task_manager set completed_date ='" . date('Y-m-d H:i:s') . "' , status = '0' ,  next_response = '" . $response_type . "'   where id=" . $taskmanagerid . "";  die;
	 
    $bool = mysql_query("update task_manager set completed_date ='" . date('Y-m-d H:i:s') . "' , status = '0' ,  next_response = '" . $response_type . "'   where id=" . $taskmanagerid . "");

    $completed_date = date("Y-m-d H:i:s");

    $created_date = date("Y-m-d H:i:s");

	 if($admin_id > 0) {
	   $admin_id = $admin_id;
	  }else{
        $admin_id = $_SESSION['admin'];
      }
	  
    $ins_arg = "insert into task_manager set quote_id=" . $quote_id . ",";

    $ins_arg .= " task_id='" . $task_id . "',";

    $ins_arg .= " job_id='" . $job_id . "',";

    $ins_arg .= " task_type='" . $task_type . "',";

    $ins_arg .= " status='1',";

    //$ins_arg.=" completed_date='".$completed_date."',";
    $ins_arg .= " created_date='" . $created_date . "',";

    $ins_arg .= " admin_id='" . $admin_id . "',";

    $ins_arg .= " response_type='" . $response_type . "',";

    $ins_arg .= " fallow_date='" . $fallow_date . "',";

    $ins_arg .= " fallow_time='" . $fallow_time . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

    $lastid = mysql_insert_id();

    $bool = mysql_query("update sales_task_track set task_manager_id ='" . $lastid . "'  where id=" . $task_id . "");

}

function CreateNewsalesTask($id, $adminid)
{

    $qdata = mysql_fetch_assoc(mysql_query("select *  from sales_task_track where id = " . $id . ""));

    $bool = mysql_query("UPDATE `sales_task_track` SET task_status = '0'  WHERE id = " . $id . "");

    if ($bool)
    {

        $staff_name = get_rs_value("admin", "name", $adminid);

        $ins_arg = "insert into sales_task_track set quote_id=" . $qdata['quote_id'] . ",";

        $ins_arg .= " sales_task_id='" . $qdata['sales_task_id'] . "',";

        $ins_arg .= " job_id='" . $qdata['job_id'] . "',";

        $ins_arg .= " heading='" . $qdata['heading'] . "',";

        $ins_arg .= " comment='" . $qdata['comment'] . "',";

        $ins_arg .= " staff_name='" . $staff_name . "',";

        $ins_arg .= " createOn='" . date("Y-m-d H:i:s") . "',";

        $ins_arg .= " admin_id='" . $qdata['admin_id'] . "',";

        $ins_arg .= " site_id='" . $qdata['site_id'] . "',";

        $ins_arg .= " stages='" . $qdata['stages'] . "',";

        $ins_arg .= " is_deleted='" . $qdata['is_deleted'] . "',";

        $ins_arg .= " task_stages='" . $qdata['task_stages'] . "',";

        $ins_arg .= " ans_date='" . $qdata['ans_date'] . "',";

        $ins_arg .= " left_sms_date='" . $qdata['left_sms_date'] . "',";

        $ins_arg .= " check_complete='" . $qdata['check_complete'] . "',";

        $ins_arg .= " fallow_date='" . $qdata['fallow_date'] . "',";

        $ins_arg .= " fallow_created_date='" . $qdata['fallow_created_date'] . "',";

        $ins_arg .= " fallow_time='" . $qdata['fallow_time'] . "',";

        $ins_arg .= " first_sms='" . $qdata['first_sms'] . "',";

        $ins_arg .= " second_sms='" . $qdata['second_sms'] . "',";

        $ins_arg .= " threed_sms='" . $qdata['threed_sms'] . "',";

        $ins_arg .= " first_email='" . $qdata['first_email'] . "',";

        $ins_arg .= " second_email='" . $qdata['second_email'] . "',";

        $ins_arg .= " threed_email='" . $qdata['threed_email'] . "',";

        $ins_arg .= " task_manage_id='" . $adminid . "',";

        $ins_arg .= " task_type='" . $qdata['task_type'] . "',";

        $ins_arg .= " task_status='1'";

        $ins = mysql_query($ins_arg);

        $lastid = mysql_insert_id();

        $task_result = 'Create New Task For ' . $staff_name;

        add_sales_follow($lastid, $qdata['quote_id'], '', '', $task_result);

        return $lastid;

    }
    else
    {

        return $id;

    }

}

function CreateSalesTask($id)
{

    $qdata = mysql_fetch_assoc(mysql_query("select *  from sales_task_track where id = " . $id . ""));

    //echo  "UPDATE `sales_task_track` SET task_status = '0'  WHERE id = ".$id."";
    $bool = mysql_query("UPDATE `sales_task_track` SET task_status = '0'  WHERE id = " . $id . "");

    if ($bool)
    {

        $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

        //print_r($qdata);
        $ins_arg = "insert into sales_task_track set quote_id=" . $qdata['quote_id'] . ",";

        $ins_arg .= " sales_task_id='" . $qdata['sales_task_id'] . "',";

        $ins_arg .= " job_id='" . $qdata['job_id'] . "',";

        $ins_arg .= " heading='" . $qdata['heading'] . "',";

        $ins_arg .= " comment='" . $qdata['comment'] . "',";

        $ins_arg .= " staff_name='" . $staff_name . "',";

        $ins_arg .= " createOn='" . date("Y-m-d H:i:s") . "',";

        $ins_arg .= " admin_id='" . $_SESSION['admin'] . "',";

        $ins_arg .= " site_id='" . $qdata['site_id'] . "',";

        $ins_arg .= " stages='" . $qdata['stages'] . "',";

        $ins_arg .= " is_deleted='" . $qdata['is_deleted'] . "',";

        $ins_arg .= " task_stages='" . $qdata['task_stages'] . "',";

        $ins_arg .= " ans_date='" . $qdata['ans_date'] . "',";

        $ins_arg .= " left_sms_date='" . $qdata['left_sms_date'] . "',";

        $ins_arg .= " check_complete='" . $qdata['check_complete'] . "',";

        $ins_arg .= " fallow_date='" . $qdata['fallow_date'] . "',";

        $ins_arg .= " fallow_created_date='" . $qdata['fallow_created_date'] . "',";

        $ins_arg .= " fallow_time='" . $qdata['fallow_time'] . "',";

        $ins_arg .= " first_sms='" . $qdata['first_sms'] . "',";

        $ins_arg .= " second_sms='" . $qdata['second_sms'] . "',";

        $ins_arg .= " threed_sms='" . $qdata['threed_sms'] . "',";

        $ins_arg .= " first_email='" . $qdata['first_email'] . "',";

        $ins_arg .= " second_email='" . $qdata['second_email'] . "',";

        $ins_arg .= " threed_email='" . $qdata['threed_email'] . "',";

        $ins_arg .= " task_manage_id='" . $qdata['task_manage_id'] . "',";

        $ins_arg .= " task_type='" . $qdata['task_type'] . "',";

        $ins_arg .= " task_status='1'";

        $ins = mysql_query($ins_arg);

        $lastid = mysql_insert_id();

        return $lastid;

    }
    else
    {

        return $id;

    }

}

function add_clener_notes($job_id, $heading, $comment, $issue_type, $get_staff_name)
{

    $customDate = date("Y-m-d H:i:s");

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $admin_id = $_SESSION['admin'];

    if ($quote_id != '')
    {

        $quote_id = $quote_id;

    }
    else
    {

        $quote_id = get_rs_value("jobs", "quote_id", $job_id);

    }

    $ins_arg = "insert into clener_notes set job_id=" . $job_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " staff_id='" . $get_staff_name . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " issue_type='" . $issue_type . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_admin_fault_notes($quote_id, $job_id, $fault_admin_id, $heading, $comment)
{

    $customDate = date("Y-m-d H:i:s");

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $admin_id = $_SESSION['admin'];

    $ins_arg = "insert into admin_fault set job_id=" . $job_id . ",";

    $ins_arg .= " date='" . $customDate . "',";

    $ins_arg .= " quote_id='" . $quote_id . "',";

    $ins_arg .= " fault_admin_id='" . $fault_admin_id . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_refund_payment_notes($job_id, $heading, $comment, $amount, $fault_status, $transaction_id, $cleanerid = 0)
{

    $customDate = date("Y-m-d H:i:s");

    $staff_name = get_rs_value("admin", "name", $_SESSION['admin']);

    $admin_id = $_SESSION['admin'];

    $ins_arg = "insert into refund_amount set job_id=" . $job_id . ",";

    $ins_arg .= " created_date='" . $customDate . "',";

    $ins_arg .= " heading='" . mysql_real_escape_string($heading) . "',";

    $ins_arg .= " comment='" . mysql_real_escape_string($comment) . "',";

    $ins_arg .= " login_id='" . $admin_id . "',";

    $ins_arg .= " amount='" . $amount . "',";

    $ins_arg .= " transaction_id='" . $transaction_id . "',";

    $ins_arg .= " fault_status='" . $fault_status . "',";

    $ins_arg .= " cleaner_name='" . $cleanerid . "',";

    $ins_arg .= " staff_name='" . $staff_name . "'";

    //echo $ins_arg.'<br/>';   die;
    $ins = mysql_query($ins_arg);

}

function add_site_notifications($notificationArrayData, $getid = 0)

{

    // retrieve the keys of the array (column titles)
    $fields = array_keys($notificationArrayData);

    // build the query
    $sql = "INSERT INTO site_notifications

    (`" . implode('`,`', $fields) . "`) VALUES('" . implode("','", $notificationArrayData) . "')";

    // run and return the query result resource
    mysql_query($sql);
	
	if($getid == 1) {
	  return mysql_insert_id(); 
	}

}

function add_inventory_status_notifications($notificationArrayData)

{

    // retrieve the keys of the array (column titles)
    $fields = array_keys($notificationArrayData);

    // build the query
    $sql = "INSERT INTO inventory_status_notifications

    (`" . implode('`,`', $fields) . "`) VALUES('" . implode("','", $notificationArrayData) . "')";

    // run and return the query result resource
    mysql_query($sql);

}

function makeCheckAboutTheNumber($incomingToNum = null)
{

    $with = '0' . substr($incomingToNum, 3);

    $without = substr($incomingToNum, 3);

    $forJobs = mysql_num_rows(mysql_query(

    "

				SELECT 

					phone , id , booking_id

				from 

					quote_new 

				WHERE

					(phone like '%{$with}%'

				OR

					phone like '%{$without}%')

				AND

					booking_id > 0

			"
));

    //#### IF FOUND INTO JOBS
    if ($forJobs > 0)
    {

        return "jobs";

    }

    $forQuote = mysql_num_rows(mysql_query(

    "

				SELECT 

					phone , id , booking_id

				from 

					quote_new 

				WHERE

					(phone like '%{$with}%'

				OR

					phone like '%{$without}%')

				AND

					booking_id = 0

			"
));

    //#### IF FOUND INTO QUOTE
    if ($forQuote > 0)
    {

        return "quote";

    }

    $forStaff = mysql_num_rows(mysql_query(

    "

				SELECT 

					mobile

				from 

					staff 

				WHERE

					(mobile like '%{$with}%'

				OR

					mobile like '%{$without}%')

			"
));

    //#### IF FOUND INTO QUOTE
    if ($forStaff > 0)
    {

        return "staff";

    }
	
	

    $forhr = mysql_num_rows(mysql_query(

    "

				SELECT 

					mobile

				from 

					staff_applications 

				WHERE

					(mobile like '%{$with}%'

				OR

					mobile like '%{$without}%')

			"
));
   // HR Application
   if ($forhr > 0)
    {

        return "hr";

    }

    return "nothing";

}

function send_mysms($mobile, $msg)
{
    
       $destination = $mobile; // receiver ( anyone ) To
       $text = $msg;
        
    //echo  $msg; die;    
        
        //if(strlen($destination) == 10)
        
         if (substr($destination, 0, 1) == 0)
        {

           $destination = substr($destination, 1);

        }
        
        
        $mobilenumber =  strlen($destination);
        //echo $destination . ' =  ' .$mobilenumber;  die;
        if($mobilenumber == '9') {
            
                $smstype = makeCheckAboutTheNumber($destination);
        
        
                if ($_SESSION['admin'] != '')
                {
        
                    $adminid = $_SESSION['admin'];
        
                }
                else
                {
        
                    $adminid = 0;
        
                }
                
                $text =  str_replace('rn', '',$text);
                
                $_POST['chatMessage'] = trim($text);
        
                $_POST['adminNum'] = str_replace(" ", "", trim(substr($source, 1)));
        
                $_POST['staffNum'] = str_replace(" ", "", trim($destination));
        
                $_POST['adminId'] = $adminid;
        
                $_POST['smstype'] = $smstype;
        
                // twilio function will call here
        		
        		//print_r($_POST); die;
        		
                return sendMySMSNew($_POST);
        }else{
            return 0;	
        }
        


}

function send_sms($mobile, $msg)
{

    $getSendType = mysql_fetch_assoc(mysql_query("SELECT sms_setting FROM `siteprefs` WHERE id = 1"));

    /*
    
    This is simply check onto ( Is smsBroadcast allow or twilio etc )
    
    */

    $smsBroadcast = $getSendType['sms_setting'];

    //echo $smsBroadcast; die;
   // $smsBroadcast = 3;

    if ($smsBroadcast == 1)

    {

        /*$username = "manish.khanna";
        
        $password = "466934";
        
        $destination = $mobile;
        
        $message = $msg;
        
        $fromNumber = "0452229882";
        
        $content = 'Username='.rawurlencode($username).
        
        '&Pwd='.rawurlencode($password).
        
        '&PhoneNumber='.rawurlencode($destination).
        
        '&PhoneMessage='.rawurlencode($message).
        
        '&ReplyType=HEADER'.
        
        '&ReplyPath='.rawurlencode($fromNumber);
        
        ;
        
        
        
        $ch = curl_init('http://api.messagenet.com.au/lodge.asmx/LodgeSMSMessageWithReply2');
        
        curl_setopt($ch, CURLOPT_POST, true);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        
        $output = curl_exec ($ch);
        
        curl_close ($ch);
        
        //return $output;
        
        return 1;*/

        $username = 'manishkhanna';

        $password = 'pcardin644';

        //$destination = '0421188972'; //Multiple numbers can be entered, separated by a comma
        $destination = $mobile;

        $source = '0452229882';

        $text = $msg;

        $ref = 'abc123';

        $content = 'username=' . rawurlencode($username) .

        '&password=' . rawurlencode($password) .

        '&to=' . rawurlencode($destination) .

        '&from=' . rawurlencode($source) .

        '&message=' . rawurlencode($text) .

        '&maxsplit=3' .

        '&ref=' . rawurlencode($ref);

        //$smsbroadcast_response = sendSMS($content);
        $ch = curl_init('https://api.smsbroadcast.com.au/api-adv.php');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);

        $smsbroadcast_response = $output;

        $response_lines = explode("\n", $smsbroadcast_response);

        foreach ($response_lines as $data_line)
        {

            $message_data = "";

            $message_data = explode(':', $data_line);

            if ($message_data[0] == "OK")
            {

                //echo "The message to ".$message_data[1]." was successful, with reference ".$message_data[2]."\n";
                return 1;

            }
            elseif ($message_data[0] == "BAD")
            {

                //echo "The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2]."\n";
                return 0;

            }
            elseif ($message_data[0] == "ERROR")
            {

                //echo "There was an error with this request. Reason: ".$message_data[1]."\n";
                return 0;

            }

        }

    }

    else if($smsBroadcast == 2)

    {

        //set parameters according to twilio
         $destination = $mobile; // receiver ( anyone ) To
        //$source    = '0488840644'; //sender ( Bcic ) FROM
        

        $source = '0429504482'; //sender ( Bcic ) FROM Dedicated
        $text = trim($msg);

        if (substr($destination, 0, 1) == 0)
        {

            $destination = substr($destination, 1);

        }
        else
        {

            $destination = '0' . $destination;

        }


   

        $smstype = makeCheckAboutTheNumber($destination);

        /* if(substr($common,0,1) == 0){
        
        $common = '0' . substr($common, 1);
        
        } else {
        
        $common = '0' . $common;
        
        } */

        if ($_SESSION['admin'] != '')
        {

            $adminid = $_SESSION['admin'];

        }
        else
        {

            $adminid = 0;

        }

        //#### SET PARAMETERS FOR TWILIO TO USE INTO API
        $_POST['chatMessage'] = base64_encode($text);

        $_POST['adminNum'] = str_replace(" ", "", trim(substr($source, 1)));

        $_POST['staffNum'] = str_replace(" ", "", trim($destination));

        $_POST['adminId'] = $adminid;

        $_POST['smstype'] = $smstype;

        // twilio function will call here
        return smsByClickSend();

    }else if($smsBroadcast == 3) {
        
         //set parameters according to twilio
         $destination = $mobile; // receiver ( anyone ) To
        //$source    = '0488840644'; //sender ( Bcic ) FROM
		 
        $text = $msg;
        
        //if(strlen($destination) == 10)
        
         if (substr($destination, 0, 1) == 0)
        {

           $destination = substr($destination, 1);

        }
        

       /*   if (substr($destination, 0, 1) == 0)
        {

           $destination = substr($destination, 1);

        }
         else
        {

             $destination = '0' . $destination;

        } */
        
        $mobilenumber =  strlen($destination);
        //echo $destination . ' =  ' .$mobilenumber;  die;
        if($mobilenumber == '9') {
            
                $smstype = makeCheckAboutTheNumber($destination);
        
        
                if ($_SESSION['admin'] != '')
                {
        
                    $adminid = $_SESSION['admin'];
        
                }
                else
                {
        
                    $adminid = 0;
        
                }
                
                $text =  str_replace('rn', '',$text);
                
                $_POST['chatMessage'] = trim($text);
        
                $_POST['adminNum'] = str_replace(" ", "", trim(substr($source, 1)));
        
                $_POST['staffNum'] = str_replace(" ", "", trim($destination));
        
                $_POST['adminId'] = $adminid;
        
                $_POST['smstype'] = $smstype;
        
                // twilio function will call here
        		
        		//print_r($_POST); die;
        		
                return sendMySMSNew($_POST);
        }else{
            return 0;	
        }
        
    }

}

	function sendMySMSNew($data)
	{
		
		   // print_r($data);  die;
		
			//$source = '918750749955'; //sender ( Bcic ) FROM Dedicated
			$source = '61452229882'; //sender ( Bcic ) FROM Dedicated
			$account_source = '+61452229882'; //sender ( Bcic ) FROM Dedicated
			
			/* $password = 'pcardin644@1';
			$api_key = 'MAztoEiztAtNKN09BXliyg'; */
			
			$password = 'pcardin644';
			$api_key = 'qDknmjs9qoFxydKzVBhEiQ';
			
			$message1 = strip_tags(($data['chatMessage']));
			$message = preg_replace( "/(\r|\n)/", "", $message1);
			$message = preg_replace('/\\\\/', '', $message);
			$destination = '+61'.str_replace("", "" ,trim($data['staffNum']));   //'+61' . str_replace("", "" ,trim($_POST['adminNum']));
			
		     //echo $message;    die;
		     
		     $message  = str_replace('$lb',PHP_EOL, $message);
		      
		   
			//initialize class with apiKey and AuthToken(if available)
			$mysms = new mysms($api_key);
			
			
			//lets login user to get AuthToken
			$login_data = array('msisdn' => $source, 'password' => $password);
			
			$login = $mysms->ApiCall('json', '/user/login', $login_data);  //providing REST type(json/xml), resource from http://api.mysms.com/index.html and POST data
			
		   // print_r($login); die;
			
			$user_info = json_decode($login); //decode json string to get AuthToken
			
			$_SESSION['AuthToken'] = $user_info->authToken; //saving auth Token in session for more calls
			
			$mysms->setAuthToken($user_info->authToken); //setting up auth Token in class (optional)
			
			$req_data = array('recipients' => array($destination), 'message' => $message, 'encoding' => 0, 'smsConnectorId' => 0, 'store' => true, 'authToken' => $_SESSION['AuthToken'],); //providing AuthToken as per mysms developer doc
			//  remote call
			$info = $mysms->ApiCall('json', '/remote/sms/send', $req_data); //calling method ->ApiCall
			$smsarray = json_decode($info, true);
			
			//print_r($smsarray); die;
			
			if($smsarray["errorCode"] == 0) {
				
				$checkNumber = getTotalMessageId($destination);
				$totalcount = $checkNumber['totalcount'];
				$total_message = $checkNumber['total_message'];
				$data_1['smstype'] = $data['smstype'];
				
						if($totalcount == 0) {
								$data_1['to_address'] = $source;
								$data_1['from_address'] = $destination;
								$data_1['snippet'] = $message;
								$data_1['messages'] = 1;
								$data_1['maxMessageId'] = $smsarray['remoteSmsSendAcks'][0]['messageId'];
								$data_1['messagesUnread'] = 0;
								$data_1['messagesUnsent'] = 0;
								$data_1['dateSent'] = date('Y-m-d H:i:s');
								$data_1['dateLastMessage'] = date('Y-m-d H:i:s');
								
								$datainsertType = 1;
								
						}
						  else
						{
								$data_1['to_address'] = $source;
								$data_1['from_address'] = $destination;
								$data_1['snippet'] = $message;
								$data_1['messages'] = $total_message;
								$data_1['maxMessageId'] = $smsarray['remoteSmsSendAcks'][0]['messageId'];
								$data_1['messagesUnread'] = 0;
								$data_1['messagesUnsent'] = 0;
								$data_1['dateSent'] = date('Y-m-d H:i:s');
								$data_1['dateLastMessage'] = date('Y-m-d H:i:s');
								
								$datainsertType = 2;
						}
						  
						$result = InsertParentsMySMS($data_1, $datainsertType);
						
						if($result) {
							$data_child['to_address'] = $source;
							$data_child['from_address'] = $destination;
							$data_child['p_id'] = $destination;
							$data_child['message'] = $message;
							$data_child['locked'] = 'false';
							$data_child['origin'] = 0;
							$data_child['read'] = 'true';
							$data_child['status'] = 0;
							$data_child['incoming'] = 'false';
							$data_child['dateSent'] = date('Y-m-d H:i:s');
							$data_child['messageId'] = $smsarray['remoteSmsSendAcks'][0]['messageId'];
						   
						   $checkInsert1 = checkMessageID($data_child['messageId'] , $destination);
						   if($checkInsert1 == 0) {
							InsertMySMS_data($data_child);
						   }
						}
				
			   return 1;	
			}else{
				return 0;	
			}
		
	}
	



    function getTotalMessageId($fromNumber){
          $fromnumber = MobileCodeReplace($fromNumber);
          $sql = mysql_query("SELECT id , total_message FROM `mysms_parents_conversation`   WHERE from_address = '".mysql_real_escape_string($fromnumber)."'");
         
          $count =  mysql_num_rows($sql);
          
            $data = mysql_fetch_assoc($sql);
            $total_message =  $data['total_message'];
            return array('totalcount'=>$count,'total_message'=>$total_message);
    }

function getConverstionData( $dadta  ) {
    $restPath = 'rest/user/message/get/by/conversation';
    $mysms = new mysms($dadta['api_key']);
     
    $login_data = array(
                "apiKey"=> "{$dadta['api_key']}",
                "authToken"=> "{$dadta['token_id']}",
                "address"=> $dadta['recipient']
    	);
     
     return  $mysms->getMessagesBYOffset($restPath, $login_data);    
}

function smsByClickSend()
{

    //#### CHECK IF SEND OR NOT
    if ((new SendMessage())->checkSendPost() == 1)
    {

        return 1;

    }
    else
    {

        return 0;

    }

}


   /*  function saveSMSInsertion($datadetails)
    {
        
        
        
        $result->admin_id 		= $datadetails['adminId'];
		$result->read_by 		= 0;
		$result->to_num 		= '0'.substr($datadetails['to'], 3);
		$result->to_num_code	= substr($datadetails['to'],0,3);
		$result->from_num 		= '0'.substr($datadetails['from'], 3);
		$result->from_num_code	= substr($datadetails['from'], 0, 3);
		$result->message 		= $datadetails['body'];
		$result->account_id 	= '';
		$result->msg_id 		= '';
		$result->date_sent 		= date('Y-m-d');
		$result->date_time 		= date('Y-m-d H:i:s a');
		$result->only_date 		= date('Y-m-d');
		$result->only_time 		= date('H:i:s a');
		$result->sender 		= 1;
		$result->receiver 		= 1;
		$result->type 			= 'admin';  
		$result->status 		= 0;
		$result->is_deleted 	= 1;
		$result->apiVersion 	= 'none';
		$result->media 			= 'none';
		$result->uri 			= 'none';
        $result->baseUrl		= ''; 
        $result->_tbl 			= 'bcic_sms';
        
         insertInto_sms_table( $result->_tbl , $result );
        
        
    }

   function insertInto_sms_table( $table = null , $result = null )
	{		
		$query = "INSERT INTO {$table} (
			admin_id,
			read_by,
			to_num,
			to_num_code,
			from_num,
			from_num_code,
			message,
			account_id,
			msg_id,
			date_sent,
			date_time,
			only_date,
			only_time,
			sender,
			receiver,
			type,
			status,
			is_deleted,
			apiVersion,
			media,
			uri,
			baseUrl
			) values(
			{$result->admin_id},
			{$result->read_by},
			'{$result->to_num}',
			'{$result->to_num_code}',
			'{$result->from_num}',
			'{$result->from_num_code}',
			'{$result->message}',
			'{$result->account_id}',
			'{$result->msg_id}',
			'{$result->date_sent}',
			'{$result->date_time}',
			'{$result->only_date}',
			'{$result->only_time}',
			{$result->sender},
			{$result->receiver},
			'{$result->type}',
			'{$result->status}',
			{$result->is_deleted},
			'{$result->apiVersion}',
			'{$result->media}',
			'{$result->uri}',
			'{$result->baseUrl}'
		)";
		
		$response = mysql_query($query);
		mysql_affected_rows();	
	} 
 */


function send_sms_messagenet($mobile, $msg)
{

    $username = "manish.khanna";

    $password = "466934";

    $destination = $mobile;

    $message = $msg;

    $fromNumber = "0452229882";

    $content = 'Username=' . rawurlencode($username) .

    '&Pwd=' . rawurlencode($password) .

    '&PhoneNumber=' . rawurlencode($destination) .

    '&PhoneMessage=' . rawurlencode($message) .

    '&ReplyType=HEADER' .

    '&ReplyPath=' . rawurlencode($fromNumber);
;

    $ch = curl_init('http://api.messagenet.com.au/lodge.asmx/LodgeSMSMessageWithReply2');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

    $output = curl_exec($ch);

    curl_close($ch);

    //return $output;
    

    //send_sms_new("0421188972",$msg);
    return 1;

}

function disp_mysql_error()
{

    echo "Error in entring Property data Please consult Administrators<br>";

    echo ("can be  " . mysql_error());

}

function ready_desc_text($txt)
{

    $phone_array = array(
        "04",
        "02",
        " 03",
        " 07",
        " 08",
        " +61",
        " 1300",
        "55"
    );

    $txt = str_replace($phone_array, "***", $txt);

    $email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';

    $txt = preg_replace("/\<a(.*)\>(.*)\<\/a\>/iU", "$2", $txt);

    $txt = preg_replace($email_pattern, "****@****.com.au", $txt);

    return $txt;

}

function fdate($num, $dd, $mm, $yy, $start_year, $end_year)
{

    $mm_arr = array(
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "July",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
    );

    //echo $dd."-".$mm."-".$yy."<br>";
    $str = "

									<select class='date_select' name=\"dd_$num\">";

    for ($i = 1;$i <= 31;$i++)
    {

        if ($dd == $i)
        {
            $sel_dd = "Selected";
        }
        else
        {
            $sel_dd = "";
        }

        $str .= "<option $sel_dd value=\"$i\">$i</option>";

    }

    $str .= "</select>\n";

    $str .= "<select class='month_select' name=\"mm_$num\">";

    for ($i = 0;$i < 12;$i++)
    {

        if ($mm == $i + 1)
        {
            $mm_sel = "Selected";
        }
        else
        {
            $mm_sel = "";
        }

        $ii = $i + 1;

        $str .= "<option " . $mm_sel . " value=\"" . $ii . "\">" . $mm_arr[$i] . "</option>";

    }

    $str .= "</select>\n ";

    $str .= "<select class='year_select' name=\"yy_$num\">";

    $addyears = ($start_year + $end_year);

    $from_year = date("Y") - $start_year; // 2001
    $to_year = date("Y") + $end_year; // 2021
    while ($from_year < $to_year)
    {

        //$mkyear  = mktime(0, 0, 0, date("m"),  date("d"),  date("Y")+$i);
        if ($yy == $from_year)
        {
            $yy_sel = "Selected";
        }
        else
        {
            $yy_sel = "";
        }

        $str .= "<option $yy_sel value=\"$from_year\">$from_year</option>";

        $from_year++;

    }

    $str .= "</select>\n";

    /*$i=$date_start;
    
    						while($i<5){ 
    
    							$mkyear  = mktime(0, 0, 0, date("m"),  date("d"),  date("Y")+$i);
    
    							$nyear = date("Y",$mkyear);
    
    							if ($yy==$nyear){$yy_sel="Selected"; }else{ $yy_sel=""; }
    
    							$str.="<option $yy_sel value=\"$nyear\">$nyear</option>";
    
    							$i++;
    
    						}
    
    						$str.="</select>\n";
    
    */

    return $str;

}

function whatisthiskeyword($kw)
{

    // state
    // abv - name ( inc country_id)
    $kw = mres($kw);

    $state_check = get_sql("state", "abv", " where abv = '" . $kw . "'  and country_id=" . $_SESSION['cid'] . "");

    if ($state_check != "")
    {

        return " state='" . $kw . "' and ";

    }

    $state2_check = get_sql("state", "abv", " where state ='" . $kw . "' and country_id=" . $_SESSION['cid'] . "");

    if ($state2_check != "")
    {

        return " state='" . $state2_check . "' and ";

    }

    $city_check = get_sql("region", "region", " where region ='" . $kw . "' and country_id=" . $_SESSION['cid'] . "");

    if ($city_check != "")
    {

        return " new_region='" . $kw . "' and ";

        //return "city";
        
    }

    // city name
    $city_check = get_sql("city", "city", " where city ='" . $kw . "' and country_id=" . $_SESSION['cid'] . "");

    if ($city_check != "")
    {

        return " city='" . $kw . "' and ";

        //return "city";
        
    }

    // category name like
    $cat_check = get_sql("category", "name", " where name like '%" . $kw . "%' ");

    if ($cat_check != "")
    {

        return " category_name like '%" . $kw . "%' and ";

        //return "category";
        
    }

    $listing_id = get_sql("listings", "id", " where id ='" . $kw . "' and country_id=" . $_SESSION['cid'] . " and status=1 and advert_status!=2");

    if ($listing_id != "")
    {

        return "id like '%" . $listing_id . "%' or ";

        //return "listing_id";
        
    }

    $user_id = get_sql("users", "id", " where company_name like '%" . $kw . "%' and country_id=" . $_SESSION['cid'] . " and status=1 ");

    if ($user_id != "")
    {

        return " user_id like '%" . $user_id . "%' or ";

    }
    else
    {

        return " heading like '%" . $kw . "%' or ";

    }

}

function whatisthiskeyword_try1($kw)
{

    // state
    // abv - name ( inc country_id)
    $kw = mres($kw);

    $state_check = get_sql("state", "abv", " where abv = '" . $kw . "'  and country_id=" . $_SESSION['cid'] . "");

    if ($state_check != "")
    {

        return "State|state='" . $kw . "' ";

    }

    $state2_check = get_sql("state", "abv", " where state ='" . $kw . "' and country_id=" . $_SESSION['cid'] . "");

    if ($state2_check != "")
    {

        return "State|state='" . $state2_check . "' ";

    }

    // city name
    $city_check = get_sql("city", "city", " where city ='" . $kw . "' and country_id=" . $_SESSION['cid'] . "");

    if ($city_check != "")
    {

        return "City|city='" . $kw . "' ";

        //return "city";
        
    }

    // category name like
    $cat_check = get_sql("category", "name", " where name like '%" . $kw . "%' ");

    if ($cat_check != "")
    {

        return "Category|category_name like '%" . $kw . "%' ";

        //return "category";
        
    }

    $listing_id = get_sql("listings", "id", " where id ='" . $kw . "' and country_id=" . $_SESSION['cid'] . " and status=1 and advert_status!=2");

    if ($listing_id != "")
    {

        return "Keyword|id like '%" . $listing_id . "%' ";

        //return "listing_id";
        
    }

    $user_id = get_sql("users", "id", " where company_name like '%" . $kw . "%' and country_id=" . $_SESSION['cid'] . " and status=1 ");

    if ($user_id != "")
    {

        return "Keyword|user_id like '%" . $user_id . "%' ";

    }
    else
    {

        return "Keyword|heading like '%" . $kw . "%' ";

    }

}

function compress_image_new($source_url, $destination_url)
{

    $source_url = $_SERVER['DOCUMENT_ROOT'] . $source_url;

    $destination_url = $_SERVER['DOCUMENT_ROOT'] . $destination_url;

    $img = new Imagick();

    $img->readImage($source_url);

    //$img->resizeImage($width,$height,Imagick::FILTER_LANCZOS,1);
    $img->setImageCompression(imagick::COMPRESSION_JPEG);

    $img->setImageCompressionQuality(70);

    $img->stripImage();

    $img->writeImage($destination_url);

    //return destination file
    return $destination_url;

}

function get_sql($table, $field, $cond)
{

    $tr_desc_sql = "SELECT $field FROM $table " . $cond;

    //echome($tr_desc_sql);
    //die('test');
    

    try
    {

        $tr_data = mysql_query($tr_desc_sql);

        if ($tr_data === false)

        {

            throw new Exception('SQL error' . $tr_desc_sql);

        }

        if (mysql_num_rows($tr_data) > 0)
        {

            $cat_name = mysql_result($tr_data, 0, $field);

        }
        else
        {

            $cat_name = "";

        }

        return $cat_name;

    }
    catch(Exception $e)
    {

        if ($_SERVER['REMOTE_ADDR'] == $myipaddress)
        {

            echo "e <a href=\"javascript:show_div('" . time() . "')\">.</a><div id=\"" . time() . "\" style=\"display:none;\">" . $tr_desc_sql . "</div>";

        }

        $strx_err = $tr_desc_sql . "<br>" . print_r($_SERVER, true);

        //sendmail("manish","manish@business2sell.com.au","Error : b2s function line 2891 get_sql ",$strx_err,"support@business2sell.com.au");
        
    }

}

function get_rs($table, $field, $wherecond)
{

    $tr_desc_sql = "SELECT $field FROM $table where id=" . mysql_real_escape_string($wherecond);

    //echo $tr_desc_sql;
    $tr_data = mysql_query($tr_desc_sql);

    if (mysql_num_rows($tr_data) > 0)
    {

        $cat_name = mysql_result($tr_data, 0, $field);

    }
    else
    {

        $cat_name = "";

    }

    return $cat_name;

}

function get_rs_value($table, $field, $wherecond)
{

    $tr_desc_sql = "SELECT $field FROM $table where id=" . mysql_real_escape_string($wherecond);

    //echo ($tr_desc_sql); die;
    $tr_data = mysql_query($tr_desc_sql);

    if (mysql_num_rows($tr_data) > 0)
    {

        $cat_name = mysql_result($tr_data, 0, $field);

    }
    else
    {

        $cat_name = "";

    }

    return $cat_name;

}

function mres($txt)
{

    return mysql_real_escape_string($txt);

}

// used in homepage to create price range
function create_dropdown4($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $bydefaultvalue, $select)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . mysql_real_escape_string($cond);

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echome($arg);
    $datax = mysql_query($arg);

    $rx = 0;

    $str = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\" class=\"custom-dropdown__select custom-dropdown__select--white\">";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $str .= " > <option value=\"0\">$select</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx < (mysql_num_rows($datax)))
        {

            $idx = mysql_result($datax, $rx, $id_field);

            $namex = mysql_result($datax, $rx, $name_field);

            //$str .="<option value=\"".$idx."\">".$namex."</option>";
            if (($idx == $_POST[$field_name]) || ($idx == $bydefaultvalue))
            {

                $str .= "<option value=\"" . $idx . "\" selected=\"yes\">" . $namex . "</option>";

            }
            else
            {

                $str .= "<option value=\"" . $idx . "\">" . $namex . "</option>";

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

//Get checkbox under in_array comparison
function getcheckbocUnderArray($currentDayName = null, $inArrayWeekUser = null)

{

    if (in_array($currentDayName, $inArrayWeekUser) == true)

    {

        $checked = "checked";

    }

    else

    {

        $checked = "";

    }

    return $checked;

}

function check_view_ip()
{

    if ($_SESSION['country_sys'] == "")
    {

        $blocked = get_sql("blocked_ip", "id", " where ip='" . $_SERVER['REMOTE_ADDR'] . "'");

        if ($blocked != "")
        {

            return false;

        }
        else
        {

            $_SESSION['country_sys'] = get_ip2country($_SERVER['REMOTE_ADDR']);

            $_SESSION['country_id'] = 17;

            $_SESSION['country_name'] = "Not Set";

            if ($_SESSION['country_sys'] == "0")
            {

                $_SESSION['country_sys'] = "Not Found";

            }
            else
            {

                $country_id = get_sql("country_ip_abv", "id", " where abv='" . $_SESSION['country_sys'] . "'");

                if ($country_id != "")
                {

                    $_SESSION['country_id'] = $country_id;

                    $_SESSION['country_name'] = get_sql("country_ip_abv", "country", " where id='" . $_SESSION['country_id'] . "'");

                }

            }

            if ($_SESSION['country_id'] != 0)
            {

                $status = get_sql("country_ip_abv", "status", " where id='" . $_SESSION['country_id'] . "'");

                if ($status == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            else
            {

                return true;

            }

        } // check blocked
        
    }
    else
    {

        return true;

    }

}

function get_ip2country($ipaddress)
{

    if ($_SERVER['SERVER_PORT'] != "443")
    {

        $gi = geoip_open($_SERVER['DOCUMENT_ROOT'] . "/lib/ipcheck/GeoIP.dat", GEOIP_STANDARD);

        $country = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);

        geoip_close($gi);

        //echome($country);
        

        /*if($country==""){
        
        $country= strtoupper(get_geo_ip_code($SERVER['REMOTE_ADDR']));
        
        }*/

        if ($country == "")
        {

            return "0";

        }
        else
        {

            return $country;

        }

        /*if($country==""){
        
        $license_key="ZMOdRzEBaByX";
        
        $query = "http://geoip1.maxmind.com/a?l=" . $license_key . "&i=" . $ipaddress;
        
        $url = parse_url($query);
        
        $host = $url["host"];
        
        $path = $url["path"] . "?" . $url["query"];
        
        $timeout = 1;
        
        //echo $host;
        
        $fp = fsockopen ($host, 80, $errno, $errstr, $timeout);
        
        if ($fp) {
        
        fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
        
        while (!feof($fp)) {
        
        $buf .= fgets($fp, 128);
        
        }
        
        $lines = split("\n", $buf);
        
        //sendmail("Manish","manish@netvisionsoft.com","Maxmind IP",print_r($lines));
        
        $country = $lines[count($lines)-1];
        
        fclose($fp);
        
        } else {
        
        # enter error handing code here
        
        //sendmail("Manish","manish@netvisionsoft.com","Maxmind IP didnt work","$ipaddress");
        
        }
        
        
        
        //echo $country;
        
        if ($country!=""){
        
        // update the country_ip for this users
        
        return $country;
        
        }else{
        
        return "0";
        
        }
        
        }else{
        
        return $country	;
        
        }*/

    }
    else
    {

        return "0";

    }

}

function html2txt($value)
{

    //$value = str_replace("<br>","\n",$value);
    $value = str_replace("\r\n", "", $value);

    $value_arr = str_split($value);

    $new_value = "";

    $adding = true;

    foreach ($value_arr as $chr)
    {

        if ($chr == "<")
        {
            $adding = false;

        }
        elseif ($chr == ">")
        {
            $adding = true;

        }
        else
        {

            if ($adding)
            {

                $new_value = $new_value . $chr;

            }

        }

    }

    return $new_value;

}

function echome($str)
{

    if (($_SERVER['REMOTE_ADDR'] == "110.142.231.92") || ($_SERVER['REMOTE_ADDR'] == "120.29.10.38"))
    {

        echo $str;

    }

}

function rw($var)
{

    if ($$var == "")
    {

        if (isset($_POST[$var]))
        {
            return $_POST[$var];

        }
        else if (isset($_GET[$var]))
        {
            return $_GET[$var];

        }

    }
    else
    {

        return $$var;

    }

}

function get_calc()
{

    $numbers = "123456789";

    $tags[0] = "+";

    $tags[1] = "-";

    //$tags[2] = "x";
    

    //$alpha_arr = str_split($numbers);
    $num1 = createCode_new();

    $num2 = createCode_new();

    $i = rand(0, 1);

    if ($num2 > $num1)
    {

        $num3 = $num2;

        $num2 = $num1;

        $num1 = $num3;

    }

    if ($i == 0)
    {

        $answer = $num1 + $num2;

    }
    else if ($i == 1)
    {

        $answer = $num1 - $num2;

    }
    else if ($i == 2)
    {

        $answer = $num1 * $num2;

    }

    $_SESSION['captcha_phrase'] = $answer;

    echo $num1 . " " . $tags[$i] . " " . $num2;

    //echo "<div id=\"div_".rand()."\" class=\"param\">Security Code : <span class=\"text11_red\">".$num1." ".$tags[$i]." ".$num2." </span></div> ";
    //echo '<div class="text11">Code is answer of the small calculation: </div>';
    
}

function createCode_new()

{

    $code = "";

    // define allowed characters
    $allowed = "123456789";

    $i = 0;

    // add random characters to $code until $length is reached
    while ($i < 1)
    {

        // pick a random character from the allowed characters
        $char = substr($allowed, mt_rand(0, strlen($allowed) - 1) , 1);

        //add char when it is not in code
        if (!strstr($code, $char))
        {

            $code .= $char;

            $i++;

        }

    }

    return $code;

}

function sendmailtext($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto)
{

    //global $siteinfo;
    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    $email_message = $sendto_message . "\r\n \r\n Senders ip address is : " . $_SERVER['REMOTE_ADDR'] . " - Country : " . $_SESSION['country_name'] . "</span></font><font size=\"1\"><br>Users Browser Details :" . $_SERVER['HTTP_USER_AGENT'] . "";

    //echo $site['site_contact_email']."<br>";
    

    $headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From:' . $replyto . "\r\n";

    $headers .= 'Reply-To:' . $replyto . "\r\n";

    // not working
    ini_set('sendmail_from', 'support@business2sell.com.au');

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@business2sell.com.au",$sendto_subject,$email_message,$headers);
    
}

function rotatedate($date)

{

    /*if($date!=""){
    
    $rotdate = explode("-", $date);
    
    //$dispdate = $rotdate[2].'-'.$rotdate[1].'-'.$rotdate[0];
    
    //return $dispdate;
    
    
    
    $mkndate = mktime(0,0,0,$rotdate[1],$rotdate[2],$rotdate[0]);
    
    if($_SESSION['csettings']['date_format']!=""){
    
    return date($_SESSION['csettings']['date_format'],$mkndate);
    
    }else{
    
    $dispdate = $rotdate[2].'-'.$rotdate[1].'-'.$rotdate[0];
    
    return $dispdate;
    
    }
    
    }*/

    if ($date != "")
    {

        $mkndate = strtotime($date);

        if ($_SESSION['csettings']['date_format'] != "")
        {

            return date($_SESSION['csettings']['date_format'], $mkndate);

        }
        else
        {

            return date("d-m-Y", $mkndate);

        }

    }

}

function create_dd_staff($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $staff_id)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echo ($arg);
    $datax = mysql_query($arg);

    $rx = 0;

    $str = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\" ";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $str .= " > <option value=0>Select</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx = mysql_fetch_assoc($datax))
        {

            $idx = $rx[$id_field];

            if ($field_name == 'reclean_staff_id')
            {

                $namex = get_rs_value("staff", "name", $rx[$name_field]);

            }
            else
            {

                $namex = $rx[$name_field];

            }

            if (isset($staff_id))
            {

                if (($idx == $staff_id))
                {

                    $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

                }

            }
            else
            {

                $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

function create_dd($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $details, $field_id = null, $all_d = null)
{

    //echo ($details['id']);
    
  //echo $details[$field_name];
	 /*  if(!empty($details)) {
		$field_name = str_replace('[]','', $field_name);
	  } */
	  
	//$field_name = str_replace('[]','', $field_name);
  
    if (strpos($cond, 'better_franchisee=3') !== false && $table == 'staff')
    {

        $cond = str_replace('better_franchisee=3', "find_in_set('removal' , job_types)", $cond);

    }

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echo ($arg); die;
    

    $datax = mysql_query($arg);

    $rx = 0;

    /* $str ="<select name=\"".$field_name."\" id=\"".$field_name."\" class=\"formfields\"";
    
    if ($onchng!=""){ $str .=" ". $onchng . " "; } */

    $str = "<select name=\"" . $field_name . "\"  class=\"formfields\"";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $typeID = explode("=", $cond) [1];

    if ($field_id == 'field_id_time')
    {

        $str .= "id=" . $field_name . "_" . $details['quote_id'];

    }
    else if ($field_id == 'field_id')
    {

        $str .= "id=" . $field_name . "_" . $details['id'];

    }
    else
    {

        if ($typeID == 31)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 96)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 33)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 59)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 60)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 58)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 34)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        elseif ($typeID == 91)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
		elseif ($typeID == 124 || $typeID == 125)
        {
            $str .= "id=" . $field_name . "_" . $details['id'] . " ";
        }
        else
        {
            $str .= "id = " . $field_name;
        }

    }

    //staff_type_all
    

    /* if (explode("=",$cond)[1] != 32 && explode("=",$cond)[1] != 41 && explode("=",$cond)[1] != 48 && explode("=",$cond)[1] != 49 && explode("=",$cond)[1] != 51 && explode("=",$cond)[1] != 53 && explode("=",$cond)[1] != 54 && ($table!="quote_for_option" )  ) { */

    if (explode("=", $cond) [1] != 32 && explode("=", $cond) [1] != 41 && explode("=", $cond) [1] != 48  && explode("=", $cond) [1] != 49 && explode("=", $cond) [1] != 51 && explode("=", $cond) [1] != 53 && explode("=", $cond) [1] != 54 && ($table != "quote_for_option"))
    {

        if (explode("=", $cond) [1] == 21 || ($field_name == 'message_status') || ($field_name == 'online_payment_status'))
        {

            $str .= " > <option value=''>Select</option>";

        }
        else
        {

            $str .= " > <option value=0>Select</option>";

        }

    }
    else
    {

        if ($field_name == 'staff_type_all' || $field_id == 'quote_a')
        {

            $str .= " > <option value='0'>Select</option>";

        }
        else
        {

            $str .= " >";

        }

    }

    if ($all_d == 'all')
    {

        $str .= " <option value='all'>ALL</option>";

    }

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx < (mysql_num_rows($datax)))
        {
          $idx = mysql_result($datax, $rx, $id_field);

		    $field_name = str_replace('[]','', $field_name);
		    if ($field_name == 'get_staff_name')
            {

                $namex = get_rs_value("staff", "name", $idx);

            }
            else
            {

                $namex = mysql_result($datax, $rx, $name_field);

            }

     
			// print_r($field_name); 
			// print_r($details[$field_name]); 
			 
            if (isset($_POST[$field_name]))
            {
             //echo  $_POST[$field_name]; die;
                if (($idx == $_POST[$field_name]))
                {

                    $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

                }

            }
            else if (isset($details[$field_name]))
            {
                
		       //echo  'yy '.$details[$field_name].'===2'.$all_d.'<br/>'; 
			    //if (strpos($a, '[]') !== false) {
			     if (($idx == $details[$field_name]))
                {
					$str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

                }

            }
            else
            {

                if ($field_name == 'furnished' && $namex == 'No' || $field_name == 'blinds' && $namex == 'No Blinds' || $field_name == 'property_type' && $namex == 'Unit')
                {

                    $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    if (($idx == 'step' && $_GET['task'] == 'view_quote') && $_GET['action'] != '')
                    {

                        // return false;
                        
                    }
                    else
                    {

                        $str .= "<option value=\"" . $idx . "\">" . str_replace('_', ' ', ucwords(strtolower($namex))) . "</option>";

                    }

                }

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

function create_dd_select($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $details, $select_para = null)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echo ($arg);
    $datax = mysql_query($arg);

    $rx = 0;

    $str = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\" class=\"formfields\"";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $str .= " > <option value=0> " . ucfirst($select_para) . "</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx < (mysql_num_rows($datax)))
        {

            $idx = mysql_result($datax, $rx, $id_field);

            $namex = mysql_result($datax, $rx, $name_field);

            //$str .="<option value=\"".$idx."\">".$namex."</option>";
            if (isset($_POST[$field_name]))
            {

                if (($idx == $_POST[$field_name]))
                {

                    $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

                }

            }
            else if (isset($details[$field_name]))
            {

                if (($idx == $details[$field_name]))
                {

                    $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

                }
                else
                {

                    $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

                }

            }
            else
            {

                $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

function create_dd_value($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $sel_value)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echo ($arg);
    $datax = mysql_query($arg);

    $rx = 0;

    $str = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\" class=\"formfields\"";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $str .= " > <option value=\"\">Select</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx < (mysql_num_rows($datax)))
        {

            $idx = mysql_result($datax, $rx, $id_field);

            $namex = mysql_result($datax, $rx, $name_field);

            //$str .="<option value=\"".$idx."\">".$namex."</option>";
            if (($idx == $sel_value))
            {

                $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

            }
            else
            {

                $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

function create_dd_state($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng, $details)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . "";

    }

    //echo ($arg);
    $datax = mysql_query($arg);

    $rx = 0;

    $str = "<select name=\"" . $field_name . "\" id=\"" . $field_name . "\" class=\"form-right-input_select\"";

    if ($onchng != "")
    {
        $str .= " " . $onchng . " ";
    }

    $str .= " > <option value=0>Select</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx < (mysql_num_rows($datax)))
        {

            $idx = mysql_result($datax, $rx, $id_field);

            $namex = mysql_result($datax, $rx, $name_field);

            //$str .="<option value=\"".$idx."\">".$namex."</option>";
            if (($idx == $_POST[$field_name]) || ($idx == $details[$field_name]))
            {

                $str .= "<option value=\"" . $idx . "\" Selected>" . ucwords(strtolower($namex)) . "</option>";

            }
            else
            {

                $str .= "<option value=\"" . $idx . "\">" . ucwords(strtolower($namex)) . "</option>";

            }

            $rx++;

        }

    }

    $str .= "</select>";

    return $str;

}

function get_field_value_nonhtml($details, $field)
{

    //echo $field;
    if ($_POST[$field] != "")
    {

        return htmlspecialchars($_POST[$field]);
        return false;

    }
    else if ($_GET[$field] != "")
    {

        return $_GET[$field];
        return false;

    }
    else
    {

        return htmlspecialchars($details[$field]);
        return false;

    }

}

function m_activity_log($listing_id, $comment)
{

    $user_id = get_rs_value("listings", "user_id", $listing_id);

    $ex_id = get_rs_value("listings", "ex_id", $listing_id);

    $current_comments = get_sql("activity_log", "comment", "where user_id=" . $user_id . " and listing_id='" . $listing_id . "' and date='" . date("Y-m-d") . "'");

    if ($current_comments == "")
    {

        $insx_comment = $comment;

        $insx_arg = "insert into activity_log(user_id,listing_id,date,comment,ipaddress,ex_id) values(" . $user_id . "," . $listing_id . ",'" . date("Y-m-d") . "','" . $insx_comment . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $ex_id . "')";

        //echo $current_comments."<br>".$insx_arg;
        $insx = mysql_query($insx_arg);

    }
    else
    {

        //$current_comments = get_rs_value("activity_log","comments",$id);
        

        $insx_comment = $current_comments . "<br>" . $comment;

        $insx_arg = "update activity_log set comment='" . $insx_comment . "' where  user_id=" . $user_id . " and listing_id='" . $listing_id . "' and date='" . date("Y-m-d") . "'";

        //echo $current_comments."<br>".$insx_arg;
        $insx = mysql_query($insx_arg);

    }

}

function letscheckproxy()
{

    /*if($_SESSION['proxyscore']==""){
    
    $score=check_proxy($_SERVER['REMOTE_ADDR']);
    
    $_SESSION['proxyscore'] = $score;
    
    //echome($_SERVER['REMOTE_ADDR']."-score:".$score);
    
    if($score>1){
    
    $ins = mysql_query("insert into blocked_ip(ip) values('".$_SERVER['REMOTE_ADDR']."')");
    
    sendmail(Site_name,Site_email,"Proxy Detected ".Site_name,$_SERVER['REMOTE_ADDR'],Site_email);
    
    header("Location: $site_name/error.php");
    
    }
    
    }*/

    $_SESSION['proxyscore'] = 0;

}

function sendmail($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $site_id, $quotefor = null, $staffemail = '', $staffphone = '')
{

    //global $siteinfo;
    //$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
    
// var_dump($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $site_id, $quotefor = null);  die;

    $sql_email = "SELECT * FROM sites where id=" . mres($site_id);

    $site = mysql_fetch_array(mysql_query($sql_email));

    $siteUrl1 = Site_url;

    if ($quotefor != '')
    {

        $quoteforsql = "SELECT * FROM quote_for_option where id=" . mres($quotefor);

        $quotetypedetails = mysql_fetch_array(mysql_query($quoteforsql));

        if ($quotefor == 1)
        {

            $domain = $site['domain'];

            $logo = $site['logo'];

            //  $phonenum = $quotetypedetails['phone'];
            $teamType = 'BCIC';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }
        elseif ($quotefor == 2 || $quotefor == 4)
        {

            $domain = $quote_for_option['site_url'];

            $logo = $quotetypedetails['company_logo'];

            $site_logo = $siteUrl1 . '/' . $quotetypedetails['logo_name'];

            if ($quotefor == 2)
            {

                $teamType = 'BBC';

                //  $site_logo =   $quotetypedetails['company_logo'];
                
            }
            else
            {

                $teamType = 'B Hub';

                //$site_logo =   $siteUrl1.'/'.$quotetypedetails['logo_name'];
                
            }

        }
        elseif ($quotefor == 3)
        {

            $domain = $site['br_domain'];

            $logo = $site['br_logo'];

            $teamType = 'BR';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }
        else
        {

            $domain = $site['domain'];

            $logo = $site['logo'];

            $teamType = 'BCIC';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }

        //$phonenum = $quotetypedetails['phone'];
        $email = $quotetypedetails['email_out_booking'];

        $phone = $quotetypedetails['phone'];

        $hr_emails = $quotetypedetails['hr_emails'];

    }
    else
    {

        $domain = $site['domain'];

        $logo = $site['logo'];

        $email = $site['email'];

        $phone = $site['phone'];

        $hr_emails = 'hr@bcic.com.au';

        $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

        $site_logo = $siteUrl1 . '/' . $newlogo;

    }


    if($staffemail != '') {
        $email = $staffemail;
        $hr_emails = $email;
    }
    
     if($staffphone != '') {
        $phone = $staffphone;
    }

    $siteUrl1 = Site_url;

    //	$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
    //$site_logo =   $siteUrl1.'/'.$newlogo;
    

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<HTML><HEAD><TITLE>" . $domain . "</TITLE>

<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

</HEAD>

<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

  <p>

<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $hr_emails . "<br><br>

Kind Regards</font>

</p>

  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

   " . $teamType . " Team<br>

  <img src=\"" . $site_logo . "\" /><br>

	p: " . $phone . "<br>

	e: " . $email . "<br>

   

";

    // w: ".$domain."</font></P>
    

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

This email and any attachments may contain information that is confidential and subject to legal privilege. 

If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, " . $teamType . " is not liable (including in respect of negligence) for viruses or other defects or 

for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

The information contained in this document is confidential to the addressee and is not the view nor the official policy of " . $teamType . " unless otherwise stated.

  </font> </P>

  </td>

  </tr>

  </table>

</BODY></HTML>

";

    $headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From:' . $email . "\r\n";

    $headers .= 'Reply-To:' . $email . "\r\n";

    // echo  $sendto_subject . ' === '.$sendto_email . ' ===='.$email_message; die;
    

    //echo $sendto_subject.$sendto_email;  die;
    ini_set('sendmail_from', $email);

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    /* if(mail($sendto_email,$sendto_subject,$email_message,$headers)){
    
    echo 'Yes';
    
    }	else{
    
      echo 'No'; 
    
    } */

}

function sendmailwithattachinvoce($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $site_id, $quote_id, $quotefor = null, $real_estate = null, $jobinv = null, $bbcemail = '',$bbcmobile = '')
{

    //global $siteinfo;
    //$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
    

    $sql_email = "SELECT * FROM sites where id=" . mres($site_id);

    $site = mysql_fetch_array(mysql_query($sql_email));

    $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=" . mysql_real_escape_string($quote_id) . " AND job_type_id = 11"));

    if ($quotefor != '')
    {

        $quoteforsql = "SELECT * FROM quote_for_option where id=" . mres($quotefor);

        $quotetypedetails = mysql_fetch_array(mysql_query($quoteforsql));

        $siteUrl1 = Site_url;

        if ($quotefor == 1)
        {

            $domain = $site['domain'];

            $logo = $site['logo'];

            //  $phonenum = $quotetypedetails['phone'];
            $teamType = 'BCIC';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }
        elseif ($quotefor == 2 || $quotefor == 4)
        {

            $domain = $quote_for_option['site_url'];

            $logo = $quotetypedetails['company_logo'];

            $site_logo = $siteUrl1 . '/' . $quotetypedetails['logo_name'];

            if ($quotefor == 2)
            {

                $teamType = 'BBC';

                //  $site_logo =   $quotetypedetails['company_logo'];
                
            }
            else
            {

                $teamType = 'B Hub';

                //$site_logo =   $siteUrl1.'/'.$quotetypedetails['logo_name'];
                
            }

        }
        elseif ($quotefor == 3)
        {

            $domain = $site['br_domain'];

            $logo = $site['br_logo'];

            $teamType = 'BR';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }
        else
        {

            $domain = $site['domain'];

            $logo = $site['logo'];

            $teamType = 'BCIC';

            $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

            $site_logo = $siteUrl1 . '/' . $newlogo;

        }

        //$phonenum = $quotetypedetails['phone'];
        $email = $quotetypedetails['email_out_booking'];

        $phone = $quotetypedetails['phone'];

        $hr_emails = $quotetypedetails['hr_emails'];

    }
    else
    {

        $domain = $site['domain'];

        $logo = $site['logo'];

        $email = $site['email'];

        $phone = $site['phone'];

        $hr_emails = 'hr@bcic.com.au';

        $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

        $site_logo = $siteUrl1 . '/' . $newlogo;

    }

    if($bbcemail  != '') {
        $email = $bbcemail;
        $hr_emails = $bbcemail;
    }else {
	   $email = 'team@bcic.com.au';
    }
    
    if($bbcmobile != '') {
        $phone = $bbcmobile;
    }
	 
    $siteUrl1 = Site_url;

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<HTML><HEAD><TITLE>" . $domain . "</TITLE>

<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

</HEAD>

<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

  <p>

<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $hr_emails . "<br><br>

Kind Regards</font>

</p>

  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

   " . $teamType . " Team<br>

  <img src=\"" . $site_logo . "\" /><br>

	p: " . $phone . "<br>

	e: " . $email . "<br>

   

";

    // w: ".$domain."</font></P>
    

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

This email and any attachments may contain information that is confidential and subject to legal privilege. 

If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, " . $teamType . " is not liable (including in respect of negligence) for viruses or other defects or 

for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

The information contained in this document is confidential to the addressee and is not the view nor the official policy of " . $teamType . " unless otherwise stated.

  </font> </P>

  </td>

  </tr>

  </table>

</BODY></HTML>

";

    $filename = 'invoice_Q' . $quote_id . '.pdf';

    //$fileatt = "../../../admin/invoice/".$filename;
    

    if ($jobinv == 1)
    {

        if ($real_estate == 'real_estate')
        {

            $fileatt = $_SERVER['DOCUMENT_ROOT'] . "/admin/re_invoice/re_jinvoice/" . $filename;

        }
        else
        {

            $fileatt = $_SERVER['DOCUMENT_ROOT'] . "/admin/invoice/jinvoice/" . $filename;

        }

    }

    else
    {

        if ($real_estate == 'real_estate')
        {

            $fileatt = $_SERVER['DOCUMENT_ROOT'] . "/admin/re_invoice/" . $filename;

        }
        else
        {

            $fileatt = $_SERVER['DOCUMENT_ROOT'] . "/admin/invoice/" . $filename;

        }

    }

    //$fileatt = $_SERVER['DOCUMENT_ROOT']."/admin/invoice/".$filename;
    $fileatt_type = "application/pdf";

    //$fileatt_name = "../../../admin/invoice/".$filename;
     $email_from = $email;
    //$email_from = 'team@bcic.com.au';

    $email_to = $sendto_email; //$e;
    $headers = "From: <" . $email_from . "> \r\n";

    $headers .= "Reply-To: " . $email_from;

    $file = fopen($fileatt, 'rb');

    $data = fread($file, filesize($fileatt));

    fclose($file);

    $semi_rand = md5(time());

    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .

    "Content-Type: multipart/mixed;\n" .

    " boundary=\"{$mime_boundary}\"";

    $email_message .= "This is a multi-part message in MIME format.\n\n" .

    "--{$mime_boundary}\n" .

    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .

    "Content-Transfer-Encoding: 7bit\n\n" .

    $email_message .= "\n\n";

    $data = chunk_split(base64_encode($data));

    $email_message .= "--{$mime_boundary}\n" .

    "Content-Type: {$fileatt_type};\n" .

    " name=\"{$filename}\"\n" .

    //"Content-Disposition: attachment;\n" .
    //" filename=\"{$fileatt_name}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .

    $data .= "\n\n" . "--{$mime_boundary}--\n";

    //echo $email_message;  die;
    ini_set('sendmail_from', $email_from);

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
}

function Staffsendmailwithattachinvoce($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $staff_id , $type = '', $filename ='')
{
    if($type == 'inv') {
        
        
    }else{

       $staff_name = get_rs_value("staff", "name", $staff_id);
    }

    $eol = "<br>";

    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>

<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

</HEAD>

<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

  <p>

<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $site['site_contact_email'] . "<br><br>

Kind Regards</font>

</p>

   <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

  BCIC Team<br>

  <a href=\"" . $site['site_domain'] . "\"><img src=\"" . $site['site_url'] . $site['logo'] . "\" /></a><br>

	p: " . $site['site_contact_phone'] . "<br>

	e: " . $site['site_contact_email'] . "<br>

  w: " . $site['site_domain'] . "</font></P>

";

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

This email and any attachments may contain information that is confidential and subject to legal privilege. 

If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 

for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.

  </font> </P>

  </td>

  </tr>

  </table>

</BODY></HTML>

";
  
   if($staff_id > 0) {
        $filename = strtolower(str_replace(' ', '_', $staff_name)) . '.pdf';
        
        $fileatt = $_SERVER['DOCUMENT_ROOT'] . "/admin/staff_agreement/" . $filename;
         
   }elseif($type == 'inv') {
       $fileatt = $_SERVER['DOCUMENT_ROOT'] . '/monthly_staff_invoice/'.$filename;
   }
   
 
   

    $fileatt_type = "application/pdf";

    $email_from = $site['site_contact_email'];

    $semi_rand = md5(time());

    $file = fopen($fileatt, 'rb');

    $data = fread($file, filesize($fileatt));

    fclose($file);

    $data = chunk_split(base64_encode($data));

    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // set header ........................
    $headers = "From: " . $replyto;

    $headers .= "\nMIME-Version: 1.0\n" .

    "Content-Type: multipart/mixed;\n" .

    " boundary=\"{$mime_boundary}\"";

    // set email message......................
    $email_message .= "This is a multi-part message in MIME format.\n\n" .

    "--{$mime_boundary}\n" .

    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .

    "Content-Transfer-Encoding: 7bit\n\n" .

    $email_message .= "\n\n";

    $email_message .= "--{$mime_boundary}\n" .

    "Content-Type: {$fileatt_type};\n" .

    " name=\"{$fileatt}\"\n" .

    "Content-Disposition: attachment;\n" .

    " filename=\"{$filename}\"\n" .

    "Content-Transfer-Encoding: base64\n\n" .

    $data .= "\n\n" .

    "--{$mime_boundary}--\n";

    ini_set('sendmail_from', $replyto);

    mail($sendto_email, $sendto_subject, $email_message, $headers);

}

function sendmailbcic($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $type, $footerStatus = null)
{

    //global $siteinfo;
    //	echo "Ok"; die;
    //$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
    

    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    
    if($footerStatus == 1 && $replyto == 'reviews@bcic.com.au') {
         $contact_email = 'team@bcic.com.au';
    }else{
        $contact_email = $site['site_contact_email'];
    }
    
	
	if($footerStatus == 1 && $replyto == 'reviews@bcic.com.au') {
	   $footertext = '';
	}else if ($footerStatus == 1 && $replyto != 'reviews@bcic.com.au')
    {
        $footertext = "Should you have any further enquiries, please do not hesitate to email us at " . $replyto . " and one of our team members will be in contact with you as soon as possible.";

    }
    else
    {

        $footertext = "Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $site['site_contact_email'] . "";

    }

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    //$sendto = "BCIC Application<hr@bcic.com.au>";
    

    //	echo $sendto; die;
    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>

<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

</HEAD>

<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

  <p>

<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">" . $footertext . "<br><br>

Kind Regards</font>

</p>

  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

  BCIC Team</P>

  

  <P><a href=\"" . $site['site_domain'] . "\"><img src=\"" . $site['site_url'] . '/' . $site['bcic_new_logo'] . "\" /></a><br>

	p: " . $site['site_contact_phone'] . "<br>

	e: " . $contact_email . "<br>

  w: " . $site['site_domain'] . "</font></P>

";

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

This email and any attachments may contain information that is confidential and subject to legal privilege. 

If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 

for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.

  </font> </P>

  </td>

  </tr>

  </table>

</BODY></HTML>

";

    $headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From:' . $replyto . "\r\n";

    $headers .= 'Reply-To:' . $replyto . "\r\n";

    ini_set('sendmail_from', $replyto);

    // echo $site['site_url'].$site['logo']; die;
    

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
}

function add_new_inv($payment_gateway_id)
{

    if ($payment_gateway_id != "")
    {

        $r = mysql_fetch_array(mysql_query("SELECT * FROM `payment_gateway` where id=" . $payment_gateway_id . ""));

        $users = mysql_fetch_array(mysql_query("select * from users where id=" . $r['user_id'] . ""));

        $eol = "<br>";

        $to = "";

        if ($users['company_name'] != "")
        {
            $to = $users['company_name'] . "," . $eol;
        }

        $to .= $users['name'] . $eol;

        $to .= $users['street'] . " " . $users['suburb'] . "," . $eol;

        $to .= $users['state'] . " " . $users['postcode'] . $eol;

        $to .= $users['phone'] . $eol . $users['email'];

        //$max_id=get_sql("invoice","max(invoice_number) as max_id"," where 1");
        $max_data = mysql_query("select max(invoice_number) as max_id from invoice where 1 ");

        $max_row = mysql_fetch_array($max_data);

        $max_id = $max_row['max_id'] + 1;

        if ($_SESSION['cid'] == "1")
        {

            $gst = ($r['amount'] / 11);

            $gst_text = "GST";

        }
        else
        {

            $gst = "0";

            $gst_text = "";

        }

        $ins_arg = "INSERT INTO `invoice` (`invoice_number`,`issue_date`,`due_date`,`amount`,`to`,`user_id`,`email` ,`status` ,`country_id`,`total` ,`gst` ,`gst_text` ,`discount`,currency,aus_amount,currency_rate)



		  VALUES ('" . $max_id . "',  '" . $r['date'] . "',  '" . $r['date'] . "',  '" . $r['amount'] . "',  '" . mysql_real_escape_string($to) . "',  '" . $r['user_id'] . "',  '" . $user['email'] . "',  '1',  '" . $_SESSION['cid'] . "',  '" . $r['amount'] . "',  '" . $gst . "',  '" . $gst_text . "',  '0','" . $_SESSION['csettings']['cur_abv'] . " " . $_SESSION['csettings']['currency'] . "','" . $r['aus_amt'] . "','" . $r['cur_rate'] . "');";

        //echome($ins_arg."<br>");
        $ins = mysql_query($ins_arg);

        if ($ins)
        {

            $invoice_id = mysql_insert_id();

            //$license_type_name = get_rs_value("license_type","name",$r['license_type_id']);
            //echo "select * from license_type where id=".$r['license_type_id']."<br><br>";
            $license_type = mysql_fetch_array(mysql_query("select * from license_type where id=" . $r['license_type'] . ""));

            $add_months = $license_type['months'];

            //$no_category = get_rs_value("license_type","no_category",$_POST['license_type']);
            $fdate_arr = explode("-", $r['date']);

            $edatets = mktime(0, 0, 0, $fdate_arr[1] + $add_months, $fdate_arr[2], $fdate_arr[0]);

            //$edatets = mktime(0,0,0,date("m"),date("d"),date("Y")+1);
            $edate = date("Y-m-d", $edatets);

            $ins_arg2 = " insert into invoice_details(invoice_id,license_type_id,description,fdate,tdate,amount,quantity) ";

            $ins_arg2 .= " value(" . $invoice_id . ",'" . $r['license_type'] . "','" . $license_type['name'] . "','" . $r['date'] . "','" . $edate . "','" . $r['amount'] . "',1)";

            //echome($ins_arg2."<br>");
            $bool = mysql_query($ins_arg2);

        }

        return $max_id;

    }

}

function create_invoice_website($inv_id)
{

    if ($inv_id != "")
    {

        $details_data = mysql_query("select * from invoice where invoice_number=" . $inv_id . "");

        if (mysql_num_rows($details_data) > 0)
        {

            $details = mysql_fetch_array($details_data);

            $inv_det = mysql_query("select * from invoice_details where invoice_id=" . $details['id'] . "");

            $invoice_details = "";

            $details['method'] = "";

            $payment_type = get_sql("invoice_occ", "payment_type", " where user_id=" . $details['user_id']);

            if ($payment_type == "eway")
            {

                $details['method'] = "By Credit Card On file";

            }
            else if ($payment_type == "By Invoice")
            {

                $details['method'] = "By Invoice Issued";

            }
            else if ($payment_type == "Credit Card")
            {

                $details['method'] = "By Credit Card Online";

            }
            else if ($payment_type == "Direct Debit")
            {

                $details['method'] = "By Direct Transfer";

            }
            else
            {

                $details['method'] = "By Invoice Issued";

            }

            $details['site_url'] = $_SESSION['csettings']['home_url'];

            $details['site_email'] = $_SESSION['csettings']['email'];

            while ($r = mysql_fetch_assoc($inv_det))
            {

                if ($r['quantity'] == "0")
                {
                    $r['quantity'] = 1;
                }

                $invoice_details .= '<li class="invoice_col_content">

          <div class="large_invoice_col">' . $r['description'] . '</div>

          <div class="small_invoice_col">' . rotatedate($r['fdate']) . '</div>

          <div class="small_invoice_col">' . rotatedate($r['tdate']) . '</div>

          <div class="small_invoice_col">' . $r['quantity'] . '</div>

          <div class="small_invoice_col">' . $details['currency'] . " " . $r['amount'] . '</div>

        </li>';

                /*$invoice_details.='<tr class="text12">
                
                <td valign="top" bgcolor="#ebebeb">'.$r['description'].'</td>
                
                <td align="center" valign="top" bgcolor="#ebebeb">'.rotatedate($r['fdate']).'</td>
                
                <td align="center" valign="top" bgcolor="#ebebeb">'.rotatedate($r['tdate']).'</td>
                
                <td align="center" valign="top" bgcolor="#ebebeb">'.$r['quantity'].'</td>
                
                <td align="center" valign="top" bgcolor="#ebebeb">'.$details['currency']." ".$r['amount'].'</td>
                
                </tr>';  */

            }

            $file = "invoice_temp_website.php";

            ob_start(); // start buffer
            

            include ($_SERVER['DOCUMENT_ROOT'] . "/lib/email_template/" . $file);

            $content = ob_get_contents(); // assign buffer contents to variable
            ob_end_clean(); // end buffer and remove buffer contents
            return $content;

        }
        else
        {

            return error("Found issue while creating this invoice please contact support@business2sell.com.au " . $inv_id);

        }

    }
    else
    {

        return error("Found issue while creating this invoice please contact support@business2sell.com.au " . $inv_id);

    }

}

function create_invoice_email($inv_id)
{

    if ($inv_id != "")
    {

        $details_data = mysql_query("select * from invoice where invoice_number=" . $inv_id . "");

        if (mysql_num_rows($details_data) > 0)
        {

            $details = mysql_fetch_array($details_data);

            $inv_det = mysql_query("select * from invoice_details where invoice_id=" . $details['id'] . "");

            $invoice_details = "";

            $details['method'] = "";

            $payment_type = get_sql("invoice_occ", "payment_type", " where user_id=" . $details['user_id']);

            if ($payment_type == "eway")
            {

                $details['method'] = "By Credit Card On file";

            }
            else if ($payment_type == "By Invoice")
            {

                $details['method'] = "By Invoice Issued";

            }
            else if ($payment_type == "Credit Card")
            {

                $details['method'] = "By Credit Card Online";

            }
            else if ($payment_type == "Direct Debit")
            {

                $details['method'] = "By Direct Transfer";

            }
            else
            {

                $details['method'] = "By Invoice Issued";

            }

            $details['site_url'] = $_SESSION['csettings']['home_url'];

            $details['site_email'] = $_SESSION['csettings']['email'];

            while ($r = mysql_fetch_assoc($inv_det))
            {

                if ($r['quantity'] == "0")
                {
                    $r['quantity'] = 1;
                }

                /*$invoice_details.='<li class="invoice_col_content">
                
                <div class="large_invoice_col">'.$r['description'].'</div>
                
                <div class="small_invoice_col">'.rotatedate($r['fdate']).'</div>
                
                <div class="small_invoice_col">'.rotatedate($r['tdate']).'</div>
                
                <div class="small_invoice_col">'.$r['quantity'].'</div>
                
                <div class="small_invoice_col">'.$details['currency']." ".$r['amount'].'</div>
                
                </li>';*/

                $invoice_details .= '<tr class="text12">

              <td valign="top" bgcolor="#ebebeb">' . $r['description'] . '</td>

              <td align="center" valign="top" bgcolor="#ebebeb">' . rotatedate($r['fdate']) . '</td>

              <td align="center" valign="top" bgcolor="#ebebeb">' . rotatedate($r['tdate']) . '</td>

			   <td align="center" valign="top" bgcolor="#ebebeb">' . $r['quantity'] . '</td>

              <td align="center" valign="top" bgcolor="#ebebeb">' . $details['currency'] . " " . $r['amount'] . '</td>

            </tr>';

            }

            $file = "invoice_temp_new.php";

            ob_start(); // start buffer
            

            include ($_SERVER['DOCUMENT_ROOT'] . "/email_template/" . $file);

            $content = ob_get_contents(); // assign buffer contents to variable
            ob_end_clean(); // end buffer and remove buffer contents
            return $content;

        }
        else
        {

            return error("Found issue while creating this invoice please contact support@business2sell.com.au " . $inv_id);

        }

    }
    else
    {

        return error("Found issue while creating this invoice please contact support@business2sell.com.au " . $inv_id);

    }

}

function str_makerand($minlength, $maxlength, $useupper, $usespecial, $usenumbers)
{

    /*
    
    Author: Peter Mugane Kionga-Kamau
    
    http://www.pmkmedia.com
    
    
    
    Description: string str_makerand(int $minlength, int $maxlength, bool $useupper, bool $usespecial, bool $usenumbers)
    
    returns a randomly generated string of length between $minlength and $maxlength inclusively.
    
    
    
    Notes:
    
    - If $useupper is true uppercase characters will be used; if false they will be excluded.
    
    - If $usespecial is true special characters will be used; if false they will be excluded.
    
    - If $usenumbers is true numerical characters will be used; if false they will be excluded.
    
    - If $minlength is equal to $maxlength a string of length $maxlength will be returned.
    
    - Not all special characters are included since they could cause parse errors with queries.
    
    
    
    Modify at will.
    
    */

    $charset = "abcdefghijklmnopqrstuvwxyz";

    if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    if ($usenumbers) $charset .= "0123456789";

    if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
    if ($minlength > $maxlength) $length = mt_rand($maxlength, $minlength);

    else $length = mt_rand($minlength, $maxlength);

    for ($i = 0;$i < $length;$i++) $key .= $charset[(mt_rand(0, (strlen($charset) - 1))) ];

    return $key;

}

function get_device()
{

    $br = getBrowser();

    if ($br['platform'] == 'ipad')
    {

        return "ipad";

    }
    else if ($br['platform'] == 'iphone')
    {

        return "iphone";

    }
    else if ($br['platform'] == 'ipod')
    {

        return "iphone";

    }
    else if ($br['platform'] == 'ipad')
    {

        return "ipad";

    }
    else if ($br['platform'] == 'android Mobile')
    {

        return "iphone";

    }
    else
    {

        return "desktop";

    }

}

function getBrowser()
{

    $u_agent = $_SERVER['HTTP_USER_AGENT'];

    $bname = 'Unknown';

    $platform = 'Unknown';

    $version = "";

    //First get the platform?
    //if (preg_match('/iphone|ipod/i', $u_agent)) {
    if ((preg_match('/android/i', $u_agent)) && (!preg_match('/mobile/i', $u_agent)))
    {

        $platform = 'android tablet';

        //}else if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|iphone|ipod|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
        
    }
    else if (preg_match('/iphone|ipod/i', $u_agent))
    {

        $platform = 'iphone';

    }
    elseif (preg_match('/ipad/i', $u_agent))
    {

        $platform = 'ipad';

    }
    elseif (preg_match('/android|mobile/i', $u_agent))
    {

        $platform = 'android Mobile';

    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent))
    {

        $platform = 'mac';

    }
    else if (preg_match('/linux/i', $u_agent))
    {

        $platform = 'linux';

    }
    elseif (preg_match('/windows|win32/i', $u_agent))
    {

        $platform = 'windows';

    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent))

    {

        $bname = 'Internet Explorer';

        $ub = "MSIE";

    }

    elseif (preg_match('/Firefox/i', $u_agent))

    {

        $bname = 'Mozilla Firefox';

        $ub = "Firefox";

    }

    elseif (preg_match('/Chrome/i', $u_agent))

    {

        $bname = 'Google Chrome';

        $ub = "Chrome";

    }

    elseif (preg_match('/Safari/i', $u_agent))

    {

        $bname = 'Apple Safari';

        $ub = "Safari";

    }

    elseif (preg_match('/Opera/i', $u_agent))

    {

        $bname = 'Opera';

        $ub = "Opera";

    }

    elseif (preg_match('/Netscape/i', $u_agent))

    {

        $bname = 'Netscape';

        $ub = "Netscape";

    }

    // finally get the correct version number
    $known = array(
        'Version',
        $ub,
        'other'
    );

    $pattern = '#(?<browser>' . join('|', $known) .

    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

    if (!preg_match_all($pattern, $u_agent, $matches))
    {

        // we have no matching number just continue
        
    }

    // see how many we have
    $i = count($matches['browser']);

    if ($i != 1)
    {

        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub))
        {

            $version = $matches['version'][0];

        }

        else
        {

            $version = $matches['version'][1];

        }

    }

    else
    {

        $version = $matches['version'][0];

    }

    // check if we have a number
    if ($version == null || $version == "")
    {
        $version = "?";
    }

    return array(

        'userAgent' => $u_agent,

        'name' => $bname,

        'version' => $version,

        'platform' => $platform,

        'pattern' => $pattern,

        'ub' => $ub

    );

}

function get_field_value($details, $field)
{ //echo $field;
    if ($_POST[$field] != "")
    {

        return $_POST[$field];
        return false;

    }
    else if ($_GET[$field] != "")
    {

        return $_GET[$field];
        return false;

    }
    else
    {

        return $details[$field];
        return false;

    }

}

function checkphonenumber($arg)
{

    $arg = str_replace("-", "", $arg);

    $arg = str_replace(" ", "", $arg);

    $alpha = "+1234567890";

    $alpha_arr = str_split($alpha);

    $arg_arr = str_split(strtolower($arg));

    $arglen = count($arg_arr);

    //print_r($header_arr);
    for ($i = 0;$i < $arglen;$i++)
    {

        // echo $header_arr[$i];
        if (!in_array($arg_arr[$i], $alpha_arr))
        {

            // special character should not be there
            return false;

        }

    }

    $bad = array(
        "1234",
        "123456",
        "123"
    );

    if (in_array($arg, $bad))
    {

        return false;

    }

    return true;

}

function timeago($date)
{

    $timestamp = strtotime($date);

    //$strTime = array("second", "minute", "hour", "day", "month", "year");
    $strTime = array(
        "sec",
        "min",
        "hr",
        "d",
        "m",
        "y"
    );

    $length = array(
        "60",
        "60",
        "24",
        "30",
        "12",
        "10"
    );

    $currentTime = time();

    if ($currentTime >= $timestamp)
    {

        $diff = time() - $timestamp;

        for ($i = 0;$diff >= $length[$i] && $i < count($length) - 1;$i++)
        {

            $diff = $diff / $length[$i];

        }

        $diff = round($diff);

        return $diff . " " . $strTime[$i] . "(s) ago ";

    }

}

//This Code  of Pankaj Gupta Business2sell For Multipule Image upload
function uploadMultipulimage()
{

    /**
     * upload.php
     *
     * Copyright 2013, Moxiecode Systems AB
     * Released under GPL License.
     *
     * License: http://www.plupload.com/license
     * Contributing: http://www.plupload.com/contributing
     */

    #!! IMPORTANT:
    #!! this file is just an example, it doesn't incorporate any security checks and
    #!! is not recommended to be used in production environment as it is. Be sure to
    #!! revise it and customize to your needs.
    /*  Define ('DB_name',"betabcic_db");
    
    Define ('DB_user',"root");
    
    Define ('DB_pass',"");
    
    
    
    $link = mysql_connect($hostname,DB_user,DB_pass) or die("Could not connect");
    
    mysql_select_db(DB_name,$link) or die("Could not select database");  */

    // Make sure file is not cached (as it happens for example on iOS devices)
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    header("Cache-Control: no-store, no-cache, must-revalidate");

    header("Cache-Control: post-check=0, pre-check=0", false);

    header("Pragma: no-cache");

    /*
    
    // Support CORS
    
    header("Access-Control-Allow-Origin: *");
    
    // other CORS headers if any...
    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
    	exit; // finish preflight CORS requests here
    
    }
    
    */

    // 5 minutes execution time
    @set_time_limit(5 * 60);

    // Uncomment this one to fake upload time
    // usleep(5000);
    

    // Settings
    $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";

    //$targetDir = 'uploads';
    $cleanupTargetDir = true; // Remove old files
    $maxFileAge = 5 * 3600; // Temp file age in seconds
    //echo $targetDir; die;
    //require_once
    // Create target dir
    if (!file_exists($targetDir))
    {

        @mkdir($targetDir);

    }

    /* $confipath = (dirname(__FILE__).'/functions/config.php');
    
       include($confipath); */

    //echo ( dirname( __ FILE __ )."/functions/config.php");
    //echo "<pre>";print_r($_FILES); die;
    //die;
    // printf( "%s", SS_TT_prefix );
    

    // Get a file name
    if (isset($_REQUEST["name"]))
    {

        $filename = $_REQUEST["name"];

    }
    elseif (!empty($_FILES))
    {

        $filename = $_FILES["file"]["name"];

    }
    else
    {

        $filename = uniqid("file_");

    }

    //$filename=$_FILES["file"]["name"];
    $extension = end(explode(".", $filename));

    $newfilename = str_replace(' ', '_', $filename);

    //$newfilename= $new_files.".".$extension;
    /* print_r($newfilename);
    
    print_r($_FILES); die; */

    $job_id = $_REQUEST['job_id'];

    $page = $_REQUEST['page'];

    //$jobIDdata = explode('_',$jobstr);
    $createdOn = date('Y-m-d H:i:s');

    $path = getcwd();

    //print_r($jobIDdata);
    //$dynamicPath = $jobIDdata[0];
    //$jfoldername =$folder.'_'.$dynamicPath;
    if ($page == 'stafffile')
    {

        mkdir('../img/staff_file/' . $job_id, 0777, true);

        $path1 = '../img/staff_file/' . $job_id . '/' . $newfilename;

        move_uploaded_file($_FILES["file"]["tmp_name"], $path1);

    }
    else if ($page == 'dispatch')
    {

        mkdir('../img/job_file/' . $job_id, 0777, true);

        $path1 = '../img/job_file/' . $job_id . '/' . $newfilename;

        move_uploaded_file($_FILES["file"]["tmp_name"], $path1);

    }

    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;

    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

    if ($filename != "")
    {

        if ($page == 'stafffile')
        {

            $insertImage = mysql_query("INSERT INTO `staff_files` (`staff_id`, `image`, `createdOn`) VALUES ('" . $job_id . "', '" . $newfilename . "', '" . $createdOn . "')");

        }
        else if ($page == 'dispatch')
        {

            $insertImage = mysql_query("INSERT INTO `job_images` (`job_id`, `image`, `createdOn`) VALUES ('" . $job_id . "', '" . $newfilename . "', '" . $createdOn . "')");

        }

        //die;
        
    }

}

//This Code  of Pankaj Gupta Business2sell For Multipule Image upload For Application
function uploadMultipulimageForapplication()
{

    // Make sure file is not cached (as it happens for example on iOS devices)
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

    header("Cache-Control: no-store, no-cache, must-revalidate");

    header("Cache-Control: post-check=0, pre-check=0", false);

    header("Pragma: no-cache");

    // 5 minutes execution time
    @set_time_limit(5 * 60);

    // Uncomment this one to fake upload time
    // usleep(5000);
    

    // Settings
    $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";

    //$targetDir = 'uploads';
    $cleanupTargetDir = true; // Remove old files
    $maxFileAge = 5 * 3600; // Temp file age in seconds
    //echo $targetDir; die;
    //require_once
    // Create target dir
    if (!file_exists($targetDir))
    {

        @mkdir($targetDir);

    }

    /* $confipath = (dirname(__FILE__).'/functions/config.php');
    
       include($confipath); */

    //echo ( dirname( __ FILE __ )."/functions/config.php");
    //echo "<pre>";print_r($_FILES); die;
    //die;
    // printf( "%s", SS_TT_prefix );
    

    // Get a file name
    if (isset($_REQUEST["name"]))
    {

        $filename = $_REQUEST["name"];

    }
    elseif (!empty($_FILES))
    {

        $filename = $_FILES["file"]["name"];

    }
    else
    {

        $filename = uniqid("file_");

    }

    //$filename=$_FILES["file"]["name"];
    $extension = end(explode(".", $filename));

    $newfilename = str_replace(' ', '_', $filename);

    //$newfilename= $new_files.".".$extension;
    /* print_r($newfilename);
    
    print_r($_FILES); die; */

    $job_id = $_REQUEST['job_id'];

    $page = $_REQUEST['page'];

    //$jobIDdata = explode('_',$jobstr);
    $createdOn = date('Y-m-d H:i:s');

    $path = getcwd();

    //print_r($jobIDdata);
    //$dynamicPath = $jobIDdata[0];
    //$jfoldername =$folder.'_'.$dynamicPath;
    if ($page == 'stafffile')
    {

        mkdir('../img/staff_file/' . $job_id, 0777, true);

        $path1 = '../img/staff_file/' . $job_id . '/' . $newfilename;

        move_uploaded_file($_FILES["file"]["tmp_name"], $path1);

    }
    else if ($page == 'dispatch')
    {

        mkdir('../img/job_file/' . $job_id, 0777, true);

        $path1 = '../img/job_file/' . $job_id . '/' . $newfilename;

        move_uploaded_file($_FILES["file"]["tmp_name"], $path1);

    }

    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;

    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

    if ($filename != "")
    {

        if ($page == 'stafffile')
        {

            $insertImage = mysql_query("INSERT INTO `staff_files` (`staff_id`, `image`, `createdOn`) VALUES ('" . $job_id . "', '" . $newfilename . "', '" . $createdOn . "')");

        }
        else if ($page == 'dispatch')
        {

            $insertImage = mysql_query("INSERT INTO `job_images` (`job_id`, `image`, `createdOn`) VALUES ('" . $job_id . "', '" . $newfilename . "', '" . $createdOn . "')");

        }

        //die;
        
    }

}

function sendmember_quotemail($quote_id, $sendemail)
{

    if ($quote_id != "")
    {

        $details_data = mysql_query("select * from quote_new where id=" . mysql_real_escape_string($quote_id) . "");

        if (mysql_num_rows($details_data) > 0)
        {

            $details = mysql_fetch_array($details_data);

            $quote = $details;

            $site_data = mysql_query("select * from sites where id=" . $details['site_id'] . "");

            $sites = mysql_fetch_array($site_data);

            $details['site_logo'] = $sites['logo'];

            $details['site_url'] = $sites['domain'];

            $details['site_email'] = $sites['email'];

            $details['site_phone'] = $sites['phone'];

            $details['to'] = $quote['name'] . "<br>" . $quote['address'] . "<br>" . $quote['phone'];

            $quote_details = mysql_query("Select * from quote_details where quote_id=" . $quote['id']);

            while ($r = mysql_fetch_assoc($quote_details))
            {

                //if($details[strtolower($r['name']).'_amount']!=""){
                $descx = "";

                $invoice_details .= '<tr class="text12">

								  <td valign="top" bgcolor="#ebebeb">' . $r['job_type'] . ':' . $r['description'] . '</td>				   							  

								  <td align="center" valign="top" bgcolor="#ebebeb">' . $r['amount'] . '</td>

								</tr>';

                //}
                
            }

            //print_r($details);
            $file = "quote.php";

            ob_start(); // start buffer
            include ($_SERVER['DOCUMENT_ROOT'] . "/email_template/" . $file);

            $content = ob_get_contents(); // assign buffer contents to variable
            ob_end_clean(); // end buffer and remove buffer contents
            

            if ($sendemail == true)
            {

                //sendmail($details['name'],'pankaj.business2sell@gmail.com',"Bond Cleaning Quote from ".$site['domain'],$content,$sites['email'],$details['site_id']);
                sendmail($details['name'], "quotes@bcic.com", "Bond Cleaning Quote from " . $sites['domain'], $content, $sites['email'], $details['site_id']);

                //add_job_emails($quote['booking_id'],"Bond Cleaning Quote from ".$sites['domain'],$content,$details['email']);
                return error("Quote Sent Successfuly");

            }
            else
            {

                return $content;

            }

        }
        else
        {

            return error("Found issue while creating this Quote Please contact ADMIN" . $quote_id);

        }

    }
    else
    {

        return error("Found issue while creating this Quote Please contact ADMIN" . $quote_id);

    }

}

function create_memberquote_desc_str($r)
{

    $desc = "";

    if ($r['job_type_id'] == "1")
    {

        if ($r['bed'] > 0)
        {
            $desc .= ' ' . $r['bed'] . ' Beds,';
        }

        if ($r['study'] > 0)
        {
            $desc .= ' ' . $r['study'] . ' Study,';
        }

        if ($r['bath'] > 0)
        {
            $desc .= ' ' . $r['bath'] . ' Bath,';
        }

        if ($r['toilet'] > 0)
        {
            $desc .= ' ' . $r['toilet'] . ' Toilet,';
        }

        if ($r['living'] > 0)
        {
            $desc .= ' ' . $r['living'] . ' Living Areas,';
        }

        if ($r['furnished'] == "Yes")
        {
            $desc .= ' Furnished ,';
        }

        if ($r['blinds_type'] != "")
        {
            $desc .= ' ' . ucwords(str_replace("_", " ", $r['blinds_type'])) . ' ';
        }

        if ($r['property_type'] == "1")
        {
            $desc .= $r['property_type'];
        }

    }
    else if ($r['job_type_id'] == "2")
    {

        if ($r['bed'] > 0)
        {
            $desc .= ' ' . $r['bed'] . ' Beds,';
        }

        if ($r['living'] > 0)
        {
            $desc .= ' ' . $r['living'] . ' Living Areas,';
        }

        if ($r['carpet_stairs'] > 0)
        {
            $desc .= $r['carpet_stairs'] . ' stairs';
        }

    }
    else if ($r['job_type_id'] == "3")
    {

        if ($r['pest_inside'] > 0)
        {
            $desc .= ' Inside';
        }

        if ($r['pest_outside'] > 0)
        {
            $desc .= ' Outside';
        }

        if ($r['pest_flee'] > 0)
        {
            $desc .= ' & Flea and Tick ';
        }

    }

    return $desc;

}

function convert_member_quote_to_job($quote_id)
{

    //	echo "select * from quote_new where id=".$quote_id.""; die;
    $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=" . $quote_id . ""));

    if ($quote['booking_id'] != "0")
    {

        echo "Job Is already Booked";

        return false;

    }

    /* print_r($quote);
    
    echo $quote_id; die; */
	
	$getadminid = array(12,57,34);
	$random_adminid=array_rand($getadminid);
	$taskmanager_adminid = $getadminid[$random_adminid];

    $ins_arg = "insert into jobs set ";

    $ins_arg .= "site_id='" . $quote['site_id'] . "',";

    $ins_arg .= "quote_id='" . $quote['id'] . "',";

    $ins_arg .= "job_date='" . $quote['booking_date'] . "',";

    $ins_arg .= "date='" . date("Y-m-d") . "',";

    $ins_arg .= "status=1,";
	$ins_arg.= "task_manage_id=".$taskmanager_adminid.",";

    $ins_arg .= "customer_amount='" . $quote['amount'] . "'";

    //echo $ins_arg;
    

    $ins = mysql_query($ins_arg);

	 $getadminid = array(3,12,57,34);
	$random_adminid=array_rand($getadminid);
	$taskmanager_adminid = $getadminid[$random_adminid];
	
    //echo $ins."<br>";
    if ($ins)
    {

        $booking_id = mysql_insert_id();

        //$bool = mysql_query("update quote_new set booking_id=".$booking_id.",status=1 where id=".$quote_id."");
        $bool = mysql_query("update quote_new set booking_id=" . $booking_id . ",quote_to_job_date ='" . date("Y-m-d") . "' ,  status=1 where id=" . $quote_id . "");

        //echo "update quote set booking_id=".$booking_id.",status=1 where id=".$quote_id."<br>";
        $quote_details = mysql_query("Select * from quote_details where quote_id=" . $quote_id);

        while ($r = mysql_fetch_assoc($quote_details))
        {

            $inv = get_rs_value("job_type", "inv", $r['job_type_id']);

            $staff_amt = 0;

            $profit_amt = 0;

            $ins_arg2 = "insert into job_details set job_id=" . $booking_id . ",";

            $ins_arg2 .= "quote_id=" . $quote_id . ",";

            $ins_arg2 .= "site_id=" . $quote['site_id'] . ",";

            $ins_arg2 .= "job_type_id=" . $r['job_type_id'] . ",";

            $ins_arg2 .= "job_type='" . $r['job_type'] . "',";

            $ins_arg2 .= "quote_details_id='" . $r['id'] . "',";

            $ins_arg2 .= "staff_id=0,";

            $ins_arg2 .= "amount_total='" . $r['amount'] . "',";

            $ins_arg2 .= "amount_staff='" . $staff_amt . "',";

            $ins_arg2 .= "amount_profit='" . $profit_amt . "',";

            $ins_arg2 .= "job_date='" . $quote['booking_date'] . "',";

            $ins_arg2 .= "job_time='8:00 AM'";

            //echo $ins_arg2."<br>";
            

            $bool2 = mysql_query($ins_arg2);

        }

        $getquoteemail = mysql_query("SELECT * FROM `quote_emails` where quote_id =" . $quote_id . "");

        if (mysql_num_rows($getquoteemail) > 0)
        {

            while ($details = mysql_fetch_assoc($getquoteemail))
            {

                $heading = $details['heading'];

                $comment = $details['comment'];

                $quote_email = $details['quote_email'];

                $createdOn = $details['createdOn'];

                $login_id = $details['login_id'];

                $staff_name = $details['heading'];

                add_job_emails($booking_id, $heading, $comment, $quote_email, $createdOn, $login_id, $staff_name);

            }

        }

		$re_quoteing  = mysql_query("INSERT INTO `re_quoteing` (`job_id`, `quote_id`,   `site_id`, `admin_id`, `createdOn`) VALUES ('".$booking_id."', '".$quote_id."',  '".$quote['site_id']."', '".$_SESSION['admin']."', '".date('Y-m-d H:i:s')."')");
		 
        $staffname = $quote['name'];

        $sql = mysql_query("SELECT id , quote_id FROM `sales_system` WHERE quote_id = " . $quote_id . "");

        $countre = mysql_num_rows($sql);

        if ($countre > 0)
        {

            $sadetails = mysql_fetch_assoc($sql);

            $sid = $sadetails['id'];

            mysql_query("update sales_system set job_id= " . $booking_id . " where id=" . mysql_real_escape_string($sid) . "");

        }
        else
        {

            $call_she = mysql_query("insert into sales_system set quote_id='" . ($quote_id) . "', job_id = " . $booking_id . " ,  staff_name='" . $staffname . "', site_id=" . $quote['site_id'] . ", task_manage_id='".$taskmanager_adminid."'  , status=1,  task_type='Client' ,  createOn='" . date('Y-m-d H:i:s') . "'");

            $sid = mysql_insert_id();

        }

        if (date('i') <= '30')
        {

            $schedule_from = date('H') . ':00';

            $schedule_to = date('H') . ':30';

        }
        else
        {

            $schedule_from = date('H') . ':30';

            $schedule_to = date('H', strtotime('+1 hour')) . ':00';

        }

        $fallow_time = $schedule_from . '-' . $schedule_to;

        $fallow_date = date('Y-m-d H:i:s');

        $call_she1 = mysql_query("insert into sales_task_track set quote_id='" . ($quote_id) . "', job_id = " . $booking_id . " , staff_name='" . $staffname . "', admin_id='0',site_id=" . $quote['site_id'] . ",stages=3, status=1, fallow_date='" . date('Y-m-d H:i:s') . "' ,fallow_created_date='" . date('Y-m-d') . "' ,task_manage_id='".$taskmanager_adminid."' , task_type='Client' ,  fallow_time='" . $fallow_time . "' ,  task_status='2' , track_type = '2' , sales_task_id = '" . $sid . "' ,  createOn='" . date('Y-m-d H:i:s') . "'");

        $sid1 = mysql_insert_id();

        if (isset($sid1))
        {

            mysql_query("update jobs set track_id= " . $sid1 . " where id=" . mysql_real_escape_string($booking_id) . "");

        }

        mysql_query("INSERT INTO `task_manager` (`fallow_date`, `fallow_time`, `completed_date`, `admin_id`, `job_id` , `task_type`, `quote_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('" . $fallow_date . "', '" . $fallow_time . "','" . date('Y-m-d H:i:s') . "', '".$taskmanager_adminid."', " . $booking_id . " ,  '2', '" . $quote_id . "',  '15', '" . $sid1 . "', '" . date('Y-m-d H:i:s') . "', '0');");

        $tasksid1 = mysql_insert_id();

        if (isset($tasksid1))
        {

            mysql_query("update sales_task_track set task_manager_id= " . $tasksid1 . " where id=" . mysql_real_escape_string($sid1) . "");

        }

        $getquotenotes = mysql_query("SELECT * FROM `quote_notes` where quote_id =" . $quote_id . "");

        if (mysql_num_rows($getquotenotes) > 0)
        {

            while ($qdetails = mysql_fetch_assoc($getquotenotes))
            {

                $heading = $qdetails['heading'];

                $comment = $qdetails['comment'];

                $createdOn = $qdetails['date'];

                $login_id = $qdetails['login_id'];

                $staff_name = $qdetails['staff_name'];

                $cx_upload_id = $qdetails['3cx_upload_id'];

                add_job_notes($booking_id, $heading, $comment, $createdOn, $staff_name, $login_id, $cx_upload_id);

            }

        }

        return $booking_id;

    }

}

//function invoiceGenerationInPdf( $secretid = null,$quoteid1= null , $realestatetype = null, $j_type = null, $jobinv = null )
function invoiceGenerationInPdf($secretid = null, $quoteid1 = null, $realestatetype = null, $staff_id = null, $jobinv = null, $type = null)

{

    require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

    $dompdf = new Dompdf();

    if ($quoteid1 != '')
    {

        if ($secretid != '')
        {

            $secretid = $secretid;

        }
        else
        {

            $secretid = $_GET['secret'];

        }

        if ($quoteid1 != '')
        {

            $quotedetails = mysql_fetch_assoc(mysql_query("select * from quote_new where id =" . mysql_real_escape_string($quoteid1) . ""));

        }
        else
        {

            $quotedetails = mysql_fetch_assoc(mysql_query("select * from quote_new where ssecret ='" . mysql_real_escape_string($secretid) . "' AND deleted != 1"));

        }

        if (!empty($quotedetails) > 0)
        {

            $job_id = $quotedetails['booking_id'];

            $quoteid = $quotedetails['id'];

            $logoimage = $quotedetails['site_id'];

            $sitedetails = mysql_fetch_array(mysql_query("select * from sites where id ='" . $logoimage . "'"));

            $quote_for  = $quotedetails['quote_for'];
            $re = 1;
            
           	$bbcapp_staff_id = $quotedetails['bbcapp_staff_id'];	

            /* if ($quotedetails['client_type'] == 2)
            {

                $quote_for = 2;

                $re = 2;

            }
            else
            {

                $quote_for = $quotedetails['quote_for'];

            } */

            $quote_for_option = mysql_fetch_array(mysql_query("select * from quote_for_option where id=" . $quote_for . ""));

            $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=" . mysql_real_escape_string($quoteid) . " AND job_type_id = 11"));

            $siteUrl1 = Site_url;

            if ($quote_for == '3')
            {

                $site_url = $sitedetails['br_domain'];

                $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

                $site_logo = $siteUrl1 . '/' . $newlogo;

            }
            elseif ($quote_for == '2' || $quote_for == '4')
            {

                $site_url = $quote_for_option['site_url'];

                //$site_logo =   $siteUrl1.'/'.$quote_for_option['company_logo'];
                

                if ($quote_for == '2')
                {

                    $site_logo = $quote_for_option['company_logo'];

                }
                else
                {

                    //$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
                    $site_logo = $siteUrl1 . '/' . $quote_for_option['logo_name'];

                }

                /* if($details['quote_for'] == '2') {
                
                $details['site_logo'] =   $getQuotetype['company_logo'];
                
                }else{
                
                //$newlogo = get_rs_value("siteprefs","bcic_new_logo",1);
                
                $details['site_logo'] =   $siteUrl1.'/'.$getQuotetype['logo_name'];
                
                } */

                //$site_logo =   $siteUrl1.'/'.$newlogo;
                
            }
            else
            {

                $site_url = $sitedetails['domain'];

                $newlogo = get_rs_value("siteprefs", "bcic_new_logo", 1);

                $site_logo = $siteUrl1 . '/' . $newlogo;

            }

            if ($type == 1)
            {

                $cphone = '';

            }
            else
            {

                $cphone = '<span style="font-weight:bold;"> ' . $quotedetails['phone'] . '</span></td>';

            }

            //$staff_data = mysql_query("select * from staff where id in (Select staff_id from job_details where job_id=".$job_id." and job_type_id in (select id from job_type where inv=1))");
            $staff_data = mysql_query("select * from staff where id = " . $staff_id . "");

            $staff = mysql_fetch_array($staff_data);

            //print_r($staff);
            

            $desc = '';

            $totalamount = 0;

            //$other_types = mysql_query("Select * from job_details where job_id=".$job_id." AND status != 2 and job_type_id in (select id from job_type where inv=1)");
            // $other_types = mysql_query("Select * from job_details where job_id=".$job_id." AND status != 2 AND  staff_id ='".$staff_id."'");
            

            $other_types = mysql_query("Select * from job_details where job_id=" . $job_id . " and status != 2 AND staff_id='" . $staff_id . "'  AND  job_type_id in (select id from job_type where inv=1)");

            $countRecords = mysql_num_rows($other_types);

            while ($r = mysql_fetch_assoc($other_types))
            {

                $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=" . $r['quote_id'] . " and job_type_id=" . $r['job_type_id'] . ""));

                if ($quote_details['job_type_id'] == 11)
                {

                    if ($countRecords > 1)
                    {

                        $jobdate = '<strong> Job date </strong>  (' . changeDateFormate($r['job_date'], 'datetime') . ')<br>';

                    }
                    else
                    {

                        $jobdate = '';

                    }

                    $siteUrl1 = Site_url;

                    $qu_id = base64_encode($quoteid);

                    $url = $siteUrl1 . "/members/" . $qu_id . "/inventory";

                    //$bcic_amount = check_cubic_meter_amount($quote_details['cubic_meter']);
                    

                    $truckList = mysql_fetch_array(mysql_query("select * from truck_list where id =" . $quote_details['truck_type_id']));

                    $bcic_amount = $truckList['amount'];

                    $truck_type_name = $truckList['truck_name'];

                    $cubic_meter = $truckList['cubic_meter'];

                    $c_str = '<br/><strong>Moving From :</strong> ' . $quotedetails['moving_from'] . ' , <strong><br>Moving To :</strong> ' . $quotedetails['moving_to'] . ' <br>

								Job Booked for ' . $r['hours'] . ' Hours x $' . $bcic_amount . ' / hour for ' . $truck_type_name . ' ' . $cubic_meter . 'cm3 <br>';

                    // <br>'.$jobdate.'Please <a href='.$url.'> Click </a> here to View your Inventory
                    

                    $getemailNotes1 = mysql_fetch_assoc(mysql_query("SELECT * FROM `quote_email_notes` WHERE emal_type = 'invoice_notes' AND quote_for_type_id = 3"));

                    $br_in_bcic = 1;

                    $site_url = $sitedetails['br_domain'];

                    $br_term_condition_link = $sitedetails['br_term_condition_link'];

                    $br_inclusion_link = $sitedetails['br_inclusion_link'];

                }
                else
                {

                    $c_str = '';

                    $getemailNotes = mysql_fetch_assoc(mysql_query("SELECT notes FROM `quote_email_notes` WHERE  quote_for_type_id = " . $quote_for . "  AND  emal_type = 'invoice_notes'"));

                    if ($quote_for == 2 || $quote_for == 4)
                    {

                        $urlLink = $quote_for_option['term_condition_link'];

                    }
                    else
                    {

                        $urlLink = $sitedetails['term_condition_link'];

                    }

                }

                $desc .= '<tr>  <td  style="background: #f1f1f1;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;">' . $r['job_type'] . ': ' . $quote_details['description'] . $c_str . '</td>

											<td  style="background: #f1f1f1;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;"></td>

											<td  style="padding: 10px 5px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">$' . number_format(($r['amount_total']) , 2) . '</td>

								</tr>';

                $totalamount = ($totalamount + $r['amount_total']);

            }

            $invoice_status = get_rs_value("jobs", "invoice_status", $job_id);

            if ($invoice_status == "1")
            {
                $invoice_status = "<strong>Paid</strong>";
            }
            else
            {
                $invoice_status = "<strong>Pending</strong>";
            }

            if ($realestatetype == 'real_estate' && $quotedetails['real_estate_id'] != 0)
            {

                $agent_name = '<br><span class="font-red" style="fpadding-bottom:10px;font-weight:bold;">Agent Name :' . ucfirst(get_rs_value("real_estate_agent", "name", $quotedetails['real_estate_id'])) . '</span><br>';

            }
            else
            {

                $agent_name = '';

            }

            $dompdf->set_paper(array(
                0,
                0,
                794,
                1123
            ) , 'portrait');

            if ($staff['staff_gst'] == 1)
            {

                $gst = '<tr>

				  <td style="background:#FFF;padding:10px;"></td>

				  <td style="background:#FFF;padding:10px;"> GST(inc)</td>

				  <td class="font-red"  style="padding: 10px 5px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">$' . number_format((($totalamount) / 11) , 2) . '</td>

				</tr>';

            }
            else
            {

                $gst = '';

            }
            
            
           //$email =  $quote_for_option['booking_email'];
        if($bbcapp_staff_id > 0) { 
            $email_ee =   $staff['email']; 
            $company_name_member_sites = '';
            
        } else {  
             $email_ee =  $quote_for_option['booking_email'];  
             $company_name_member_sites = $quote_for_option['company_name_member_sites'];
            
        }
            $html2 = '<body><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px; color:#354046; font-weight:normal;font-family: sans-serif;">

			  <tbody>

				<tr>

				  <td align="center"  height="80"><img src= "' . $_SERVER['DOCUMENT_ROOT'] . '/members/quote/images/invoice.png" align="center" width="160" height="50" alt="" /></td>

				  

				</tr>

				<tr>

				  <td align="right"><table width="285" border="0" cellspacing="0" cellpadding="0">

			  <tbody>



			  </tbody>

			</table>

			</td>

				</tr>

				 <tr>

				  <td valign="top" style="border: 1px solid #DDD;background: #FFFF;padding:0 5px;"><table width="286" border="0" cellspacing="0" cellpadding="0">

			  <tbody>

				<tr>

				  <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">

			  <tbody>

				<tr>

				  <td><img src=' . $site_logo . ' width="223" height="75" alt="Site Logo"/></td>

				</tr>

				<tr>

				  <td>' . $company_name_member_sites . '

				  

				  ' . $agent_name . '

				  

				  <span class="font-red" style="fpadding-bottom:10px;font-weight:bold;">' . $staff['name'] . '</span><br>



			<span style="font-weight:bold;padding-bottom:10px;">ABN:' . $staff['abn'] . '</span> <br>



			<span style="color:#00b8d4;font-weight:300;padding-bottom:10px;"> ' . $email_ee . ' </span><br>



			<span style="color:#00b8d4;font-weight:bold;padding-bottom:10px;">' . $site_url . '</span></span></td>

				</tr>

			  </tbody>

			</table>

			</td>

				  

				  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

			  <tbody>

				<tr>

				  <td><table width="429" border="0" cellspacing="0" cellpadding="0" >

			  <tbody>

				<tr>

				  <td colspan="2" class="font-bold" height="10" style="font-size:18px; font-weight:bold;"></td>

				  

				</tr>

				<tr>

				  <td style="padding: 10px;background: #00b8d4;width:50%;color: #FFF;border-bottom:1px solid #FFF;">Invoice Number</td>

				  <td style="padding: 10px;background: #FFF;;width:140px;border:1px solid #DDD;">Q' . $quoteid . '</td>

				</tr>

				<tr>

				  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:50%;border-bottom:1px solid #FFF;">Issue Date</td>

				  <td style="padding: 10px;background: #FFF;width:140px;border:1px solid #DDD;">' . changeDateFormate($quotedetails['date'], 'datetime') . '</td>

				</tr>

				<tr>

				  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:50%;border-bottom:1px solid #FFF;">Job Date</td>

				  <td style="padding: 10px;background: #FFF;width:140px;border:1px solid #DDD;">' . changeDateFormate($quotedetails['booking_date'], 'datetime') . '</td>

				</tr>

				<tr>

				  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:50%;border-bottom:1px solid #FFF;">Invoice Status</td>

				  <td style="padding: 10px;background: #FFF;width:140px;border:1px solid #DDD;">' . $invoice_status . '</td>

				</tr>

				<tr>

				  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:50%;border-bottom:1px solid #FFF;">Amount</td>

				  <td style="padding: 10px;background: #FFF;width:140px;border:1px solid #DDD;">$' . number_format(($totalamount) , 2) . '</td>

				</tr>

			  </tbody>

			</table></td>

				</tr>  

				

			  	<tr>

				    <td class="font" align="left" style="padding: 10px;padding-left:40px; font-weight:bold;" height="">To<br>

					<span style="font-weight:bold;"> ' . $quotedetails['name'] . ' </span><br>

					<span style="font-weight:bold;"> ' . $quotedetails['address'] . '</span><br>

					' . $cphone . '

				</tr>

			

			  </tbody>

			</table>



			</td>

				</tr>

			  </tbody>

			</table>

			</td>

				</tr>

				 <tr>

				  <td Style="padding-top:20px; " ><table width="100%" border="0"  cellspacing="0" cellpadding="0"  style="background-color:#f5f5f3; ">

			  <tbody>

				<tr>

				  <td colspan="3" height="20" class="font-bold" align="left" style="padding:10px 0;color:#00b8d4;font-weight:bold;text-transform:uppercase;background:#FFF;">Invoice Item Details</td>

				

				</tr>



				<tr>

				  <td class="font-med" style="background:#FFF;padding:10px;">Description</td>

				  <td  style="background:#FFF;padding:10px;">&nbsp;</td>

				  <td  style="padding: 10px 5px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">Amount</td>

				</tr>

				 ' . $desc . '

				 ' . $gst . '

				<tr>

				  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"></td>

				  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;">Total</td>

				  <td class="font-red"  style="padding: 10px 5px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">$' . number_format(($totalamount) , 2) . '</td>

				</tr>

				<tr>

				  <td></td>

				  <td></td>

				  <td></td>

				</tr>

			  </tbody>

			</table>

			</td>

				</tr>

				 

				<tr>

				 <td colspan="3" height="20" class="font-bold" align="center" style="   font-size:18px;  font-weight:bold; "></td>

				</tr>

				<tr>

				 <td colspan="3" height="20" class="font-bold" align="left"  style="padding:10px 0;color:#00b8d4;font-weight:bold;text-transform:uppercase;">Please Note</td>

				</tr>

				 <tr><td class="listing" style="list-style="none;"><style>.listing ul li { list-style:none;padding:5px 0;font-size:16px;position:relative;right:20px;}</style>';

            $emailnotes = str_replace('$tc', '<a href=' . $urlLink . ' target="_blank">Terms & Conditions</a>', $getemailNotes['notes']);
            
             if($bbcapp_staff_id > 0) {
                        $staffemai = $staff['email'];
                        $emailnotes =  str_replace('reclean@bcic.com.au' ,$staffemai,  $emailnotes);
                 }

            if ($re == 2)
            {

                $enotes = str_replace('reclean@bcic.com.au', 'reclean@betterbondcleaning.com.au', $emailnotes);

            }
            else
            {

                $enotes = $emailnotes;

            }

            $html2 .= $enotes;

            $html2 .= '</td></tr>';

            if ($br_in_bcic == 1)
            {

                $qu_id = base64_encode($quoteid);

                $url = $siteUrl1 . "/members/" . $qu_id . "/inventory";

                $html2 .= '<tr><td class="listing1" style="list-style="none;"><style>.listing1 ul li { list-style:none;padding:5px 0;font-size:16px;position:relative;right:20px;}</style>';

                $inclusion_link = "<a href='" . $br_inclusion_link . "' target='_blank' > Here </a>";

                $r_tc = '<a href=' . $br_term_condition_link . ' target="_blank">Terms & Conditions</a>';

                $url1 = '<a href=' . $url . ' target="_blank"> Click </a>';

                $newString1 = $getemailNotes1['notes'];

                $search1 = array(
                    '$inclusion',
                    '$tc',
                    '$inventory'
                );

                $replace1 = array(
                    $inclusion_link,
                    $r_tc,
                    $url1
                );

                $html2 .= str_replace($search1, $replace1, $newString1);

                $html2 .= '</td></tr>';

            }

            /*   quote_for_option['company_name'];
            
            quote_for_option['bsb'];
            
            quote_for_option['phone']; */
            
            
        if($quote_for == 1) 
        { 
            $html2 .= '<tr>

						<td colspan="2" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="2" cellpadding="5">

							  <tr>

								<td colspan="2" align="left" valign="top"><strong class="text12">Payment Options</strong></td>

							  </tr>

							  <tr>

								<td width="50%" align="left" valign="top" bgcolor="#ebebeb" class="text12"><p><strong>Direct Debit Details </strong><br />

								  <br />

								  Account Name: <br>

								  <strong>' . $quote_for_option['company_name'] . '</strong><br />

								  <br>

								  BSB: <strong>' . $quote_for_option['bsb'] . '</strong>              <br>

								  <br>

								  Account number: <strong>2956 83522</strong><br>

								  <br>

								  Please Note : Please make sure that you send us the paid receipt of bank transfer 2 days prior to your Booking Date.<br />

								</p></td>

								<td width="50%" align="left" valign="top" bgcolor="#ebebeb" class="text12"><strong>Credit Card: </strong><br />

								  <br />

								  <p>To Pay by Card, Please call on our  Office Number before the Job Starts </p>

								  <p><strong>Office number</strong>: ' . $quote_for_option['phone'] . '</p><p class="text12">&nbsp;</p></td>

								</tr>

							 

							</table>

						</td>

                    </tr>';
        }

            $html2 .= '</tbody></table></body>';

            //echo $html2; die;
            

            $dompdf->load_html($html2);

            $dompdf->load_html(utf8_decode($html2) , 'UTF-8');

            $dompdf->render();

            if ($type == 1)
            {

                $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/jobinvoice/';

            }
            else
            {

                if ($jobinv == 1)

                {

                    if ($realestatetype == 'real_estate')
                    {

                        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/re_invoice/re_jinvoice/';

                    }
                    else
                    {

                        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/invoice/jinvoice/';

                    }

                }

                else

                {

                    if ($realestatetype == 'real_estate')
                    {

                        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/re_invoice/';

                    }
                    else
                    {

                        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/invoice/';

                    }

                }

            }

            $name = 'invoice_Q' . $quoteid1 . '.pdf';

            file_put_contents($imgPath . $name, $dompdf->output());

        }
        else
        {

            return error("Found issue while creating this Quote Please contact ADMIN");

        }

    }
    else
    {

        return error("Found issue while creating this Quote Please contact ADMIN");

    }

    //echo "Hello ji done"; exit;
    
}

function StaffTermsofAgreeMent($staff_id)
{

    $result = mysql_fetch_assoc(mysql_query("Select *  from staff where id = " . $staff_id . ""));

    //	$SqltermsC = (mysql_query("SELECT * FROM `admin_terms_agreement` WHERE status  = 1"));
    $SqltermsC = (mysql_query("SELECT * FROM `terms_agreement` WHERE status  = 1 and quote_type = " . $result['better_franchisee'] . " LIMIT 0 , 1"));

    $countrecords = mysql_num_rows($SqltermsC);

    if ($countrecords > 0)
    {

        $gettermsCond = mysql_fetch_array($SqltermsC);

        if ($result['company_name'] != '')
        {
            $s_company_name = $result['company_name'];
        }
        else
        {
            $s_company_name = $result['name'];
        };

        if ($result['name'] != '')
        {
            $s_name = trim($result['name']);
        }
        else
        {
            $s_name = trim($result['nick_name']);
        };

        $s_abn = $result['abn'];

        $s_bsb = $result['bsb'];

        $s_account_number = $result['account_number'];

        //$gst = $result['staff_gst']; // 1=> Yes 2=>No
        if ($result['staff_gst'] == '1')
        {
            $s_staff_gst = "(Yes)";
        }
        else
        {
            $s_staff_gst = "(No)";
        }

        $s_job_types = explode(',', $result['job_types']);

        $s_table = staff_getalljobtypeTable($s_job_types);

        $s_job_types = implode('<br/>', $s_job_types);

        $s_avaibility = explode(',', $result['avaibility']);

        $s_avaibility = implode('<br/>', $s_avaibility);

        $incExpDate = date('d-M-Y', strtotime($result['created_date']));

        if ($result['address'] != '')
        {
            $s_address = $result['address'];
        }
        else
        {
            $s_address = '';
        };

        $signature = StaffpdfSignature($result['name']);

        $search = array(
            '$name',
            '$company_name',
            '$abn',
            '$bsb',
            '$gst',
            '$job_type',
            '$day_avail',
            '$account_number',
            '$date',
            '$address',
            '$table',
            '$signature'
        );

        $replace = array(
            $s_name,
            $s_company_name,
            $s_abn,
            $s_bsb,
            $s_staff_gst . $gst,
            $s_job_types,
            $s_avaibility,
            $s_account_number,
            $incExpDate,
            $s_address,
            $s_table,
            $signature
        );

        $newString = str_replace($search, $replace, $gettermsCond['terms_agreement']);

        return $newString;

    }
    else
    {

        return 'Please contact to bcic admin';

    }

}

// get terms of agreement Table of Staff Acctoding To Job type
function staff_getalljobtypeTable($s_job_types)
{

    $table = '<table border="0" width="">

			<thead>

				<tr>

				<th style="width: 5%; background-color: #d9edf7 !important; color: #333 !important; text-align: center; font-size: 15px; padding: 6px; border: 1px solid #DDD;">Service</th>

				<th style="width: 5%; background-color: #d9edf7 !important; color: #333 !important; text-align: center; font-size: 15px; padding: 6px; border: 1px solid #DDD;">BCIC Charge</th>

				<th style="width: 5%; background-color: #d9edf7 !important; color: #333 !important; text-align: center; font-size: 15px; padding: 6px; border: 1px solid #DDD;">Contractor Charge</th>

				</tr>

			</thead>

		    <tbody>';

    if (in_array('Cleaning', $s_job_types))
    {

        $table .= '<tr>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">Bond Cleaning / Cleaning / General</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">40% of total job amount</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">60% of total job amount</td>

				</tr>';

    }

    if (in_array('Carpet', $s_job_types))
    {

        $table .= '<tr>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">Carpet Cleaning</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">$10 Booking Fee Only</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">&nbsp;</td>

				</tr>';

    }

    if (in_array('Pest', $s_job_types))
    {

        $table .= '<tr>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">Pest Control</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">$10 Booking Fee Only</td>

				<td style="border: 1px solid #DDD; padding: 10px; margin: 0px;">&nbsp;</td>

				</tr>';

    }

    $table .= '</tbody>

       </table>';

    return $table;

}

function StaffpdfSignature($name)
{

    $IpAddress = $_SERVER['REMOTE_ADDR'];

    $url = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=2b3d7d0ad1a285279139487ce77f3f58d980eea9546b5ccc5d08f5ee62ce7471&ip=" . $_SERVER['REMOTE_ADDR'] . "&format=json"));

    $lat = $url->latitude;

    $lon = $url->longitude;

    $str = '';

    $eol = "<br>";

    $str .= $name . ' Agreed on these terms -' . $eol . $eol;

    $str .= "IP : " . $IpAddress . $eol;

    $str .= "Location  : " . $lat . ' | ' . $lon . $eol;

    $str .= "Date : " . date('dS M Y') . $eol;

    $str .= "Time of acceptance : " . date('h:i:s A') . $eol;

    return $str;

}

function StaffAgreementInPdf($staff_id)

{

    require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

    $dompdf = new Dompdf();

    if ($staff_id != '')
    {

        $html2 = StaffTermsofAgreeMent($staff_id);

        $staff_name = get_rs_value("staff", "name", $staff_id);

        //  echo $html2;  die;
        $dompdf->load_html($html2);

        $dompdf->load_html(utf8_decode($html2) , 'UTF-8');

        $dompdf->render();

        $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/admin/staff_agreement/';

        $date = new DateTime();

        $timestamp = $date->getTimestamp();

        $name = strtolower(str_replace(' ', '_', $staff_name)) . '.pdf';

        file_put_contents($imgPath . $name, $dompdf->output());

    }
    else
    {

        return error("Found issue while creating this Staff_id Please contact ADMIN");

    }

}

function checkNotificationType($notifyType = null)

{

    /*switch( $notifyType )
    
        case 0:
    
            include( "other.php" );
    
        case 1:
    
            include( "quote.php" );
    
        case 2:
    
            include( "job.php" );*/

}

//get job accoutn status
function getJob_accountStatus($id = null)

{

    //return get_sql("job_details","count(acc_payment_check) as pytStatus"," where payment_completed = 0 AND job_id=".$id."");
    // job_details.acc_payment_check
    $paymentStatus = mysql_fetch_object(mysql_query("SELECT count(acc_payment_check) as pytStatus FROM `job_details` where job_id = {$id} AND status !=2 and acc_payment_check = 0"));

    return $paymentStatus->pytStatus;

}

function getJob_Status($id = null)

{

    $jobsStatus = mysql_fetch_object(mysql_query("SELECT status FROM `jobs` where id = {$id}"));

    return $jobsStatus->status;

}

function getpay_staffStatus($id = null)

{

    /*  echo  "SELECT count(pay_staff) as PayStaff FROM `job_details` where job_id = {$id} and ( pay_staff = 1  OR  payment_completed = 1 ) and  status=0";  die; */

    $paymentPayStaff = mysql_fetch_object(mysql_query("SELECT count(pay_staff) as PayStaff, count(payment_completed) as paymentCompleted FROM `job_details` where job_id = {$id} and ( pay_staff = 1  OR  payment_completed = 1 ) and  status=0"));

    //	print_r($paymentPayStaff); die;
    return array(
        'pay_staff' => $paymentPayStaff->PayStaff,
        'acc_completed' => $paymentPayStaff->paymentCompleted
    );

}

// Member Email Send
function sendmembermail($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto)
{

    //global $siteinfo;
    //$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
    

    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    $imgUrl = $site['site_url'] . '/application/' . $site['logo'];

    "<a href=\"" . $site['domain'] . "\"><img src=\"" . $site['site_url'] . '/application' . $site['logo'] . "\" /></a><br>";

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

            <HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>

            <META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

            </HEAD>

            <link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

            <link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

            <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

            <p>

            <font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $site['site_contact_email'] . "<br><br>

            Kind Regards</font>

            </p>

            <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

            BCIC Team<br>

            <a href=\"" . $site['domain'] . "\"><img src=\"" . $site['site_url'] . $site['logo'] . "\" /></a><br>

            p: " . $site['site_contact_phone'] . "<br>

            e: " . $site['site_contact_email'] . "<br>

            w: " . $site['site_domain'] . "</font></P>

            ";

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

            This email and any attachments may contain information that is confidential and subject to legal privilege. 

            If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

            If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

            <strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 

            for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

            The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.

            </font> </P>

            </td>

            </tr>

            </table>

            </BODY></HTML>

            ";

    $headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From:' . $sendto . "\r\n";

    $headers .= 'Reply-To:' . $sendto . "\r\n";

    ini_set('sendmail_from', $sendto);

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
}

function checkJstatusCdetails($jbStatus, $staffdetails = null, $flag)
{

    if ($jbStatus == 1)

    {

        //active
        if ($flag == 2)
        {

            $str = '';

            echo "<h1>Cleaner Details </h1><span><img src='images/title-icon.png' alt=''></span>";

            foreach ($staffdetails as $key => $value)
            {

                $staffdetails = explode('|', $value);

                $str .= '<span><strong>' . $staffdetails[0] . ' </strong> <br/><i><b>' . $staffdetails[1] . '</b></i>  has been assigned for ' . $staffdetails[0] . '. <br/> You can contact him on <a href="tel:' . $staffdetails[2] . '"> ' . $staffdetails[2] . '.</a></span><img src="images/title-icon.png" alt="">';

            }

        }

        elseif ($flag == 3)

        {

            $str = "<img src='images/tick-mark.png' alt=''><span class='job-book-details'>You Job has been finished. Thank you for choosing BCIC</span>";

        }

    }

    else if ($jbStatus == 2)

    {

        //cancelled
        $str = "<img src='images/cancel-icon.png' alt=''><span  class='job-book-details'>You Job has been cancelled. Thank you for choosing BCIC</span>";

    }

    else if ($jbStatus == 3)

    {

        //complete
        $str = "<img src='images/tick-mark.png' alt=''><span  class='job-book-details'>You Job has been complete. Thank you for choosing BCIC</span>";

    }

    else if ($jbStatus == 4)

    {

        //4 complaint
        $str = "<img src='images/complait-icon.png' alt=''><span>One of our staff is looking into your job issue. We will get back to you soon as soon as possible!.<br/><br/>Thank you for choosing BCIC and please call us on 0452229882 for your enquiry status </span>";

    }

    return $str;

}

function checkJobStatus($jobid = null, $quoteid = null)

{

    // echo "Pankaj"; die;
    //echo "SELECT status FROM `jobs` where id = {$jobid} and quote_id = {$quoteid}"; die;
    $jobStatus = mysql_fetch_object(mysql_query("SELECT status FROM `jobs` where id = {$jobid} and quote_id = {$quoteid} "));

    // print_r($jobStatus);
    return $jobStatus->status;

}

function callPaytype($job_id = null, $amnt = null)

{

    $arg = "SELECT payment_method, date, amount  

				FROM job_payments

				WHERE job_id = '" . $job_id . "'

				ORDER BY date DESC

				";

    //$fullAmount = 0; // job amount
    //$amnt = 50; // job receive amount
    //echo "SELECT  sum(amount) as totalpayment FROM `job_payments` WHERE `job_id` = '".$job_id."'";  
    

    $TotalAmount = mysql_fetch_array(mysql_query("SELECT  sum(amount_total) as totalAmount FROM `job_details` WHERE `job_id` = '" . $job_id . "' AND status != 2"));

    $totalpayment = mysql_fetch_array(mysql_query("SELECT  sum(amount) as totalpayment FROM `job_payments` WHERE `job_id` = '" . $job_id . "'"));

    $data = mysql_query($arg);

    $countResult = mysql_num_rows($data);

    if ($countResult > 0)

    {

        $content = "<table style='width: 100%;margin:0px auto;' bgcolor='' cellpadding=2 cellspacing=2>

			 <tr class='header_td'>

			  <td class='table_cells'>Date</td>

			  <td class='table_cells'> Method</td>

			  <td class='table_cells'>Amount</td>";

        $totalAmt = $TotalAmount['totalAmount'];

        $totalpayment = $totalpayment['totalpayment'];

        if ($totalpayment < $totalAmt)
        {

            $flag = 1;

        }
        else
        {

            // echo "No";
            $color = '';

        }

        while ($row = mysql_fetch_assoc($data))

        {

            // echo $totalpayment;
            $amountPer = (($row['amount'] / $totalAmt) * 100);

            if ($flag == 1)
            {

                if ($amountPer >= 80)
                {

                    // echo "No";
                    $color = '';

                }
                else if ($amountPer <= 50)
                {

                    $color = 'alert_danger_tr';

                }
                else
                {

                    $color = 'alert_orange_tr';

                }

                //	$content .= "<tr class=".$color."><td>".round($amountPer,2).'% =='.$row['payment_method']."</td><td>".$row['date']."</td><td>".$row['amount']."</td></tr>";
                
            }
					$payment_method = explode(" ", $row['payment_method']);
					$getpname = "";

					foreach ($payment_method as $paymentname) {
					  $getpname .= $paymentname[0];
					}
			//$pmethod = explode(' ' ,$row['payment_method']);

            $content .= "<tr class='table_cells " . $color . "'>

                            <td class='table_cells' title='".changeDateFormate($row['date'], 'datetime')."'>" . changeDateFormate($row['date'], 'dm') . "</td>

                            <td class='table_cells' title='".$row['payment_method']."'>" . $getpname . "</td>	

                            <td class='table_cells'>" . $row['amount'] . "</td>	

                        </tr>";

        }
         unset($getpname);
        $content .= "<tr class='table_cells " . $color . "'><td colspan='2'><b>Total</b></td><td  class='table_cells'><b> " . $totalpayment . "</b></td><td></td></tr>";

        $content .= "</table>";

    }

    else

    {

        $content = "No Payment Found!";

    }

    //str_replace for coluring
    /*if( (($amnt / $fullAmount) * 100) )
    
    {
    
    
    
    }*/

    return $content;

}

function check_staff($quoteID)
{

    $postcode = get_rs_value("quote_new", "postcode", $quoteID);

    $getJobDetails = mysql_query("SELECT * FROM `job_details` WHERE `quote_id` = '" . $quoteID . "' AND status != 2 AND job_type_id = 1 order by job_type_id asc ");

    $content = "<table style='margin:0px auto;' bgcolor='' cellpadding=2 cellspacing=2>

			  <tr class='header_td'>

			  <td class='table_cells'>job Type</td>

			  <td class='table_cells'>Staff Type</td>

			  <tr>";

    if (mysql_num_rows($getJobDetails) > 0)
    {

        while ($getData = mysql_fetch_array($getJobDetails))
        {

            $checkbfgStaff = mysql_fetch_assoc(mysql_query("Select id, name , primary_post_code FROM `staff` WHERE (site_id=" . $getData['site_id'] . " or site_id2=" . $getData['site_id'] . ") and job_types like '%" . $getData['job_type'] . "%' and status=1 AND FIND_IN_SET  ('" . $postcode . "',primary_post_code) AND FIND_IN_SET  ('Cleaning',job_types) AND better_franchisee = 2"));

            //echo "SELECT * FROM `staff_roster` WHERE staff_id = ".$checkbfgStaff['id']." AND date = '".$getData['job_date']."'";
            

            $checkRoster = mysql_fetch_assoc(mysql_query("SELECT * FROM `staff_roster` WHERE staff_id = " . $checkbfgStaff['id'] . " AND date = '" . $getData['job_date'] . "'"));

            //print_r($checkRoster);
            if (!empty($getData))
            {

                $status = $checkRoster['status'];

            }

            if (!empty($checkbfgStaff) && $status == 1)
            {

                $avail = 'BFG';

            }
            else
            {

                $avail = 'BCIC';

            }

            $content .= '<tr>

						  <td  class="text12">' . $getData['job_type'] . '</td>

						  <td  class="text12">' . $avail . '</td>

				           <tr>';

        }

        $content .= "</table>";

        return $avail;

    }

}

function getJobType($quoteID)
{

    $quote = mysql_fetch_array(mysql_query("SELECT * FROM `quote_new` WHERE `id` = '" . $quoteID . "'"));

    $getJobDetails = mysql_query("SELECT * FROM `job_details` WHERE `quote_id` = '" . $quoteID . "' AND status != 2 order by job_type_id asc ");

    $content = "<table style='margin:0px auto;' bgcolor='' cellpadding=2 cellspacing=2>

			  <tr class='header_td'>

			  <td class='table_cells'>job Type</td>

			  <td class='table_cells'>Amount</td>

			  <td class='table_cells'>Cleaner</td>

			  <td class='table_cells'>Check Staff</td>

			  <td class='table_cells'>Removal truck</td>

			  <tr>";

    while ($getData = mysql_fetch_array($getJobDetails))
    {

        // $cond = " (site_id=".$getData['site_id']." or site_id2=".$getData['site_id'].") and job_types like '%".$getData['job_type']."%' and status=1";
        $cond = " (site_id=" . $getData['site_id'] . " or site_id2=" . $getData['site_id'] . "  OR find_in_set( " . $getData['site_id'] . " , all_site_id)) and status=1 and find_in_set('" . $getData['job_type'] . "' , job_types)";

        //primary_post_code
        

        //$onchange = "onchange=\"javascript:send_data('staff_id_".$jdetails['id']."','','div_staff_id_".$jdetails['id']."');\"";
        $onchng = "onchange=\"javascript:assing_jobs('" . $getData['id'] . "','" . $getData['job_id'] . "','staff_id_" . $getData['id'] . "');\" style=\"font-size: 12px;\"";

        $staff = create_dd_staff("staff_id_" . $getData['id'], "staff", "id", "name", $cond, $onchng, $getData['staff_id']);

        if ($getData['staff_id'] != 0 && $getData['job_type_id'] == 11)
        {

            $truck_assign = "onchange=\"javascript:truck_assign('" . $getData['id'] . "','" . $getData['job_id'] . "','staff_truck_" . $getData['id'] . "');\" ";

            $staff_truck = "staff_id = " . $getData['staff_id'] . "";

            $truck_staff = '<br/>' . create_dd_staff("staff_truck_" . $getData['id'], "staff_trucks", "id", "cubic_meters", $staff_truck, $truck_assign, $getData['staff_truck_id']);

        }

        $str1 = $quote['suburb'] . '|' . $quote['site_id'] . '|' . $quote['booking_date'] . '|' . $quote['quote_for'] . '|' . $getData['job_type_id'] . '|' . $quote['id'] . '|0';

        $onclick_loading_time = "onClick=\"javascript:check_reclean_avail('" . $str1 . "','45','quote_div3');\"";

        $content .= '<tr>

						  <td  class="text12">' . $getData['job_type'] . '</td>

						  <td  class="text12">' . $getData['amount_total'] . '</td>

						  <td  class="text12" id="div_staff_id_' . $getData['id'] . '">' . $staff . '</td>

						  <td  class="text12_cehck_staff" ' . $onclick_loading_time . '>Check Staff</td>

						  <td  class="text12" id="div_truck_staff_' . $getData['id'] . '">' . $truck_staff . '</td>

				           <tr>';

    }

    //die;
    $content .= "</table>";

    return $content;

}

function getJobTypewaiting($quoteID, $job_type_data)
{

    if (isset($_SESSION['status_action']) && $_SESSION['status_action'] == 1)

    {

        //$act = 'job_type_id =  '.$job_type_data.' AND  job_acc_deny = 0 AND  ';
        $act = '  job_acc_deny = 0 AND  ';

    }
    else if (isset($_SESSION['status_action']) && $_SESSION['status_action'] == 2)

    {

        //$act = 'job_type_id =  '.$job_type_data.' AND  job_acc_deny = 1 AND  ';
        $act = '  job_acc_deny = 1 AND  ';

    }

    else
    {

        $act = '';

    }

    $arg = ("SELECT * FROM `job_details` WHERE {$act} `quote_id` = '" . $quoteID . "' AND status != 2 AND staff_id != 0 order by job_type_id asc ");

    // $arg = ("SELECT * FROM `job_details` WHERE `quote_id` = '".$quoteID."' AND status != 2 AND staff_id != 0 order by job_type_id asc ");
    

    $getJobDetails = mysql_query($arg);

    $content = "<table  bgcolor='' cellpadding=2 cellspacing=2>

			  <tr class='header_td'>

			  <td class='table_cells'>job Type</td>

			  <td class='table_cells'>Amount</td>

			  <td class='table_cells'>Cleaner</td>

			  <td class='table_cells'>Assign Time</td>

			  <td class='table_cells'>Status</td>

			  <td class='table_cells'>Staff Assign to</td>

			  <tr>";

    while ($getData = mysql_fetch_array($getJobDetails))
    {

        //$cond = " (site_id=".$getData['site_id']." or site_id2=".$getData['site_id'].") and job_types like '%".$getData['job_type']."%' and status=1";
        

        $cond = " (site_id=" . $getData['site_id'] . " or site_id2=" . $getData['site_id'] . " OR find_in_set( " . $getData['site_id'] . " , all_site_id))  and status=1 and find_in_set('" . $getData['job_type'] . "' , job_types)";

        $substaff_name = get_rs_value("sub_staff", "name", $getData['sub_staff_id']);

        $substaff_mobile = get_rs_value("sub_staff", "mobile", $getData['sub_staff_id']);

        if ($substaff_name != '')
        {

            $substaff_name = '<strong>' . $substaff_name . ' / <a href="tel:' . $substaff_mobile . '">' . $substaff_mobile . '</a></strong>';

        }
        else
        {

            $substaff_name = "N/A";

        }

        $smsonClick = "onClick=\"javascript:send_data('" . $getData['id'] . "|" . $getData['job_id'] . "','527','accep_sms_" . $getData['id'] . "');\" style=\"font-size: 12px;\"";

        if ($_SESSION['status_action'] == 1 && ($getData['job_date'] > date('Y-m-d')))
        {

            $accep_sms = '<br/><br/><a id="accep_sms_' . $getData['id'] . '" href="javascript:void(0);"  ' . $smsonClick . '>Accept SMS </a>';

        }
        else
        {

            $accep_sms = '';

        }

        $onchng = "onchange=\"javascript:assing_jobs('" . $getData['id'] . "','" . $getData['job_id'] . "','staff_id_" . $getData['id'] . "');\" style=\"font-size: 12px;\"";

        if ($getData['job_type_id'] == 11)
        {

            $truck_assign = "onchange=\"javascript:truck_assign('" . $getData['id'] . "','" . $getData['job_id'] . "','staff_truck_" . $getData['id'] . "');\" ";

            $staff_truck = "staff_id = " . $getData['staff_id'] . "";

            $showdetails = create_dd_staff("staff_id_" . $getData['id'], "staff", "id", "name", $cond, $onchng, $getData['staff_id']) . '<br/>' . create_dd_staff("staff_truck_" . $getData['id'], "staff_trucks", "id", "cubic_meters", $staff_truck, $truck_assign, $getData['staff_truck_id']);

        }
        else
        {

            $showdetails = create_dd_staff("staff_id_" . $getData['id'], "staff", "id", "name", $cond, $onchng, $getData['staff_id']);

        }

        $staff_assign_date = date('Y-m-d H:i:s', strtotime($getData['staff_assign_date'] . '-4 hour'));

        if ($staff_assign_date <= date('Y-m-d H:i:s'))
        {
            $style = 'alert_danger_tr';
        }

        $content .= '<tr class="' . $style . '">

						  <td  class="text12">' . $getData['job_type'] . '</td>

						  <td  class="text12">' . $getData['amount_total'] . '</td>

						  <td  class="text12" id="div_staff_id_' . $getData['id'] . '">' . $showdetails . '</td>

						  <td  class="text12">' . changeDateFormate($getData['staff_assign_date'], 'timestamp') . '</td>

						   <td  class="text12"><strong>' . getSystemvalueByID($getData['job_acc_deny'], 47) . $accep_sms . '</strong></td>

						   <td  class="text12">' . $substaff_name . '</td>

						   <tr>';

    }

    //die;
    $content .= "</table>";

    return $content;

}

function getRecleandetails($jobid)
{

    $arg = ("SELECT * FROM `job_reclean` WHERE `job_id` = '" . $jobid . "' AND status != 2 AND staff_id != 0 order by job_type_id asc ");

    $getJobDetails = mysql_query($arg);

    $content = "<table  bgcolor='' cellpadding=2 cellspacing=2>

			  <tr class='header_td'>

			  <td class='table_cells'>job Type</td>

			  <td class='table_cells'>Cleaner</td>

			  <td class='table_cells'>Status</td>

			  <td class='table_cells'>Staff Assign to</td>

			  <tr>";

    while ($getData = mysql_fetch_array($getJobDetails))
    {

        // print_r($getData)
        

        //  $cond = " (site_id=".$getData['site_id']." or site_id2=".$getData['site_id'].") and job_types like '%".$getData['job_type']."%' and status=1";
        $cond = " (site_id=" . $getData['site_id'] . " or site_id2=" . $getData['site_id'] . ") and status=1 and find_in_set('" . $getData['job_type'] . "' , job_types)";

        //if($getData['job_acc_deny'] == Null) { $status  "N/A";  } else { $status =  getSystemvalueByID($getData['job_acc_deny'],47); }
        //$onchange = "onchange=\"javascript:send_data('staff_id_".$jdetails['id']."','','div_staff_id_".$jdetails['id']."');\"";
        $onchng = "onchange=\"javascript:assing_jobs('" . $getData['id'] . "','" . $getData['job_id'] . "','staff_id_" . $getData['id'] . "');\" style=\"font-size: 12px;\"";

        $substaff_name = get_rs_value("sub_staff", "name", $getData['sub_staff_id']);

        $substaff_mobile = get_rs_value("sub_staff", "mobile", $getData['sub_staff_id']);

        if ($substaff_name != '')
        {

            // $substaff_name =  $substaff_name;
            $substaff_name = '<strong>' . $substaff_name . ' / <a href="tel:' . $substaff_mobile . '">' . $substaff_mobile . '</a></strong>';

        }
        else
        {

            $substaff_name = "N/A";

        }

        $content .= '<tr>

						  <td  class="text12">' . $getData['job_type'] . '</td>

						  <td  class="text12">' . get_rs_value("staff", "name", $getData['staff_id']) . '</td>

						   <td  class="text12"><strong>' . getSystemvalueByID($getData['reclean_status'], 37) . '</strong></td>

						   <td  class="text12">' . $substaff_name . '</td>

						   <tr>';

    }

    //die;
    $content .= "</table>";

    return $content;

}

function gettotalamount($jobid)
{

    $gettotalamount1 = mysql_fetch_array(mysql_query("SELECT sum(amount_total) as tamount

					FROM job_details

					WHERE job_id = '" . $jobid . "' AND status != 2"));

    echo ($gettotalamount1['tamount']);

}

function getApplicationStatus($statusId)
{

    $getstatus = array(
        1 => 'Logged',
        2 => 'App',
        3 => 'Doc',
        4 => 'Submitted'
    );

    return $getstatus[$statusId];

}

function sendAddressSMS($job_id)
{

    $job_details = mysql_query("select * from job_details where job_id=" . $job_id . " and status!=2");

    while ($jdetails = mysql_fetch_assoc($job_details))
    {

        if ($jdetails['staff_id'] != '0')
        {

            if ($jdetails['job_sms_date'] == '0000-00-00 00:00:00')
            {

                $str .= '<a href="javascript:send_data(\'job|' . $jdetails['id'] . '\',25,\'send_job_sms_' . $jdetails['id'] . '\');" id="send_job_sms_' . $jdetails['id'] . '">Job SMS</a><br/>';

            }
            else
            {

                $str .= $jdetails['job_sms_date'] . '<br/>';

            }

            if ($jdetails['address_sms_date'] == '0000-00-00 00:00:00')
            {

                $str .= '<a href="javascript:send_data(\'address|' . $jdetails['id'] . '\',25,\'send_address_sms_' . $jdetails['id'] . '\');" id="send_address_sms_' . $jdetails['id'] . '">Add SMS</a>';

            }
            else
            {

                $str .= $jdetails['address_sms_date'];

            }

        }
        else
        {

            $str = "No staff assigned";

        }

    }

    return $str;

}

function GetImport_Start_endDate($importID)
{

    $data = array();

    $totalR = mysql_query("SELECT count(id) as counter  FROM `c3cx_calls`  where import_id =" . $importID);

    $getimport = mysql_fetch_array($totalR);

    $data['totalCount'] = $getimport['counter'];

    $getDate = mysql_query("SELECT call_date,call_time  FROM `c3cx_calls`  where import_id =" . $importID . " ORDER BY call_date asc");

    while ($get = mysql_fetch_array($getDate))
    {

        //print_r($get); die;
        $getallData[] = $get['call_date'];

        $getallcall_time[] = $get['call_time'];

    }

    $countAll = count($getallData);

    $data['startDate'] = $getallData[0];

    $data['endDate'] = $getallData[$countAll - 1];

    //$getallIdentify = mysql_query("SELECT count(id) as identifycall  FROM `c3cx_calls` WHERE `import_id` = '".$importID."' AND ( `job_id` != '' AND quote_id != '' )  OR staff_id > 0");
    

    $getallIdentify = mysql_query("SELECT count(id) as identifycall FROM `c3cx_calls` WHERE  `import_id` = '" . $importID . "'  AND approved_status = 1");

    $getTotalofCallidentify = mysql_fetch_array($getallIdentify);

    $data['getTotalofCallidentify'] = $getTotalofCallidentify['identifycall'];

    /* $getallnotIdentify = mysql_query("SELECT count(id) as nonidentifycall FROM `c3cx_calls` WHERE import_id = '".$importID."' AND ( job_id = '' AND quote_id = '' ) AND (staff_id = 0 OR staff_id = '')"); */

    $getallnotIdentify = mysql_query("SELECT count(id) as nonidentifycall FROM `c3cx_calls` WHERE import_id = '" . $importID . "' AND approved_status = 0");

    $getTotalofCallnotidentify = mysql_fetch_array($getallnotIdentify);

    $data['nonidentifycall'] = $getTotalofCallnotidentify['nonidentifycall'];

    return $data;

}

function get3cxdetailsBydate($call_date)
{

    $data = array();

    // Total Calls
    $TotalRecordsSql = mysql_query("SELECT count(id) as getTotalRecords FROM `c3cx_calls`  where call_date = '" . $call_date . "'");

    $TotalRecords = mysql_fetch_array($TotalRecordsSql);

    $data['getTotalRecords'] = $TotalRecords['getTotalRecords'];

    //total call recive by admin
    $totalrecive = mysql_query("SELECT count(id) as totalrecive FROM `c3cx_calls` where to_type in (SELECT 3cx_user_name FROM `c3cx_users`) AND admin_id in (SELECT id FROM `c3cx_users`) AND call_date = '" . $call_date . "'");

    $TotalRecords1 = mysql_fetch_array($totalrecive);

    $data['totalrecive'] = $TotalRecords1['totalrecive'];

    // Total call by admin
    $totalcallbyadmin = mysql_query("SELECT count(id) as totalcallbyadmin FROM `c3cx_calls` where from_type in (SELECT 3cx_user_name FROM `c3cx_users`) AND admin_id in (SELECT id FROM `c3cx_users`) AND call_date = '" . $call_date . "'");

    $Totalcallbyadmin = mysql_fetch_array($totalcallbyadmin);

    $data['totalcallbyadmin'] = $Totalcallbyadmin['totalcallbyadmin'];

    //total call client to client
    $totalcallstaff = mysql_query("SELECT count(id) as totalcallstaff FROM `c3cx_calls` where admin_id not in (SELECT id FROM `c3cx_users`) AND call_date = '" . $call_date . "'");

    $totalcallstaff = mysql_fetch_array($totalcallstaff);

    $data['totalcallstaff'] = $totalcallstaff['totalcallstaff'];

    return $data;

}

function getQuoteDetailsdata($date)
{

    $data = array();

    //echo "SELECT count(id) as TotalQuote FROM `quote_new` where 1 = 1 AND  date = '".$date."'";
    $TotalReco = mysql_fetch_array(mysql_query("SELECT count(id) as TotalQuote FROM `quote_new` where 1 = 1  AND date = '" . $date . "' AND step not in (10) "));

    $data['TotalQuote'] = $TotalReco['TotalQuote'];

    $TotalbookReco = mysql_fetch_array(mysql_query("SELECT count(id) as TotalbookingQuote FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND date = '" . $date . "' AND booking_id in (select id from jobs where status != 2) "));

    $data['Totalbookquote'] = $TotalbookReco['TotalbookingQuote'];
    
    $TotalcancReco = mysql_fetch_array(mysql_query("SELECT count(id) as Totalbookingcanc FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND date = '" . $date . "' AND booking_id in (select id from jobs where status = 2) "));

    $data['Totalbookingcanc'] = $TotalcancReco['Totalbookingcanc'];

    $TotaldeletedR = mysql_fetch_array(mysql_query("SELECT count(id) as deletedquote FROM `quote_new` where 1 = 1 AND  deleted = 1 AND date = '" . $date . "' AND step not in (10) "));

    $data['deletequote'] = $TotaldeletedR['deletedquote'];

    //print_r($data);
    return $data;

}

function getQuoteDetailsStatusdata($date, $siteID)
{

    $data = array();

    //echo "SELECT count(id) as TotalQuote FROM `quote_new` where 1 = 1 AND  date = '".$date."'";
    $Totalquote = "SELECT count(id) as TotalQuote FROM `quote_new` where 1 = 1  AND date = '" . $date . "' AND step not in (10) ";

    if ($siteID != '')
    {

        $Totalquote .= " AND site_id = " . $siteID . "";

    }

    $TotalReco = mysql_fetch_array(mysql_query($Totalquote));

    $data['TotalQuote'] = $TotalReco['TotalQuote'];

    // Booking Quote Data
    $bookingSql = "SELECT count(id) as Totalbookquote FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND date = '" . $date . "' AND step not in (10)  AND booking_id in (select id from jobs where status != 2) ";

    if ($siteID != '')
    {

        $bookingSql .= " AND site_id = " . $siteID . "";

    }

    $TotalbookingQuote = mysql_fetch_array(mysql_query($bookingSql));

    $data['Totalbookquote'] = $TotalbookingQuote['Totalbookquote'];
    
    
     $bookingSql = "SELECT count(id) as Totalbookcanquote FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND date = '" . $date . "' AND step not in (10)  AND booking_id in (select id from jobs where status = 2) ";

    if ($siteID != '')
    {

        $bookingSql .= " AND site_id = " . $siteID . "";

    }

    $TotalbookingQuote = mysql_fetch_array(mysql_query($bookingSql));

    $data['Totalbookcanquote'] = $TotalbookingQuote['Totalbookcanquote'];

    // DeleteQuorte With Status
    $deletequote = "SELECT count(id) as totaldeletequote FROM `quote_new` where 1 = 1 AND   deleted = 1 AND date = '" . $date . "'";

    if ($siteID != '')
    {

        $deletequote .= " AND site_id = " . $siteID . "";

    }

    $TotaldeleteQ = mysql_fetch_array(mysql_query($deletequote));

    $data['totaldeletequote'] = $TotaldeleteQ['totaldeletequote'];

    // OTO BOOKING
    //SELECT * FROM `quote_new` WHERE booking_id != 0 AND oto_flag = 1 AND  oto_time != '0000-00-00 00:00:00'   ORDER BY `id` DESC
    $deletequote1 = "SELECT count(id) as totalotobooked FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND oto_flag = 1 AND  oto_time != '0000-00-00 00:00:00' AND date = '" . $date . "'";

    if ($siteID != '')
    {

        $deletequote1 .= " AND site_id = " . $siteID . "";

    }

    $Totalotobook = mysql_fetch_array(mysql_query($deletequote1));

    $data['totalotobooked'] = $Totalotobook['totalotobooked'];

    return $data;

}

function getQuoteByrefrence($date = null, $ref = null, $type = null, $con = null)
{

    $Sql = "SELECT count(id) as TotalrefRecord FROM `quote_new` where 1 = 1  AND date = '" . $date . "' AND step not in (10)";

    if ($con == 'ref')
    {

        if ($ref == 'others')
        {

            $Sql .= " AND job_ref = '0'";

        }
        else
        {

            $Sql .= " AND job_ref = '" . $ref . "'";

        }

    }
    else if ($con == 'site')
    {

        $Sql .= " AND site_id = '" . $ref . "'";

    }

    if ($type == 'quote')
    {

        //$Sql .= " AND booking_id = 0";
        
    }
    else if ($type == 'booking')
    {

        $Sql .= " AND booking_id > 0";

    }

    //echo $Sql;
    $TotalReco = mysql_query($Sql);

    $getTotalRec = mysql_fetch_array($TotalReco);

    return $getTotalRec['TotalrefRecord'];

}

function getQuoteByStatusRef($date = null, $ref = null, $type = null, $con = null, $siteID = null)
{

    $Sql = "SELECT count(id) as TotalrefRecord FROM `quote_new` where 1 = 1  AND date = '" . $date . "' AND step not in (10)";

    if ($con == 'ref')
    {

        if ($ref == 'others')
        {

            $Sql .= " AND job_ref = '0'";

        }
        else
        {

            $Sql .= " AND job_ref = '" . $ref . "'";

        }

    }

    if ($siteID != '')
    {

        $Sql .= " AND site_id = " . $siteID . "";

    }

    if ($type == 'quote')
    {

        //$Sql .= " AND booking_id = 0";
        
    }
    else if ($type == 'booking')
    {

        $Sql .= " AND booking_id > 0";

    }

    //echo $Sql;
    $TotalReco = mysql_query($Sql);

    $getTotalRec = mysql_fetch_array($TotalReco);

    return $getTotalRec['TotalrefRecord'];

}

function getQuoteBystatus($date = null, $status = null, $type = null, $con = null, $siteID = null)
{

    $Sql = "SELECT count(id) as TotalrefRecord FROM `quote_new` where 1 = 1  AND date = '" . $date . "' AND step not in (10) ";

    if ($con == 'status')
    {

        $Sql .= " AND step = " . $status . "";

    }

    if ($siteID != '')
    {

        $Sql .= " AND site_id = " . $siteID . "";

    }

    if ($type == 'quote')
    {

        //$Sql .= " AND booking_id = 0";
        
    }
    else if ($type == 'booking')
    {

        $Sql .= " AND booking_id > 0";

    }

    //echo $Sql;
    $TotalReco = mysql_query($Sql);

    $getTotalRec = mysql_fetch_array($TotalReco);

    return $getTotalRec['TotalrefRecord'];

}

function get3cxdetailsByname($getadminName, $call_date, $type)
{

    $userName = get_rs_value("c3cx_users", "3cx_user_name", $getadminName);

    $getAdmin = ("SELECT *  FROM `c3cx_calls` WHERE `call_date` =  '" . $call_date . "' and admin_id = '" . $getadminName . "'");

    if ($type == 1)
    {

        /* $userName =  get_rs_value("c3cx_users","3cx_extension_number",$getadminName);
        
        $userNumber = str_replace('(',' (',$userName); */

        $getAdmin .= " AND from_type = '" . $userName . "'";

    }
    else if ($type == 2)
    {

        $getAdmin .= " AND to_type = '" . $userName . "'";

    }

    //echo $getAdmin;
    $getTotal = mysql_query($getAdmin);

    $counterResult = mysql_num_rows($getTotal);

    return $counterResult;

}

function getTotalRecords($table = null, $condition = null)
{

    $arg = "SELECT * FROM $table where 1 = 1";

    if ($condition != '')
    {

        $arg .= $condition;

    }

    //echo $arg;
    

    $getSql = mysql_query($arg);

    echo $counterResult = mysql_num_rows($getSql);

}

function getSystemDDname($stepID = null, $type = null)
{

    $stepArray = mysql_fetch_array(mysql_query("SELECT name  FROM `system_dd` WHERE `type` = " . $type . " AND id = " . $stepID . ""));

    if (!empty($stepArray))
    {

        $name = $stepArray['name'];

    }
    else
    {

        $name = "N/A";

    }

    return $name;

}

function getBRSystemDDname($stepID = null, $type = null)
{

    $stepArray = mysql_fetch_array(mysql_query("SELECT name  FROM `system_dd_br` WHERE `type` = " . $type . " AND id = " . $stepID . ""));

    if (!empty($stepArray))
    {

        $name = $stepArray['name'];

    }
    else
    {

        $name = "N/A";

    }

    return $name;

}

function getRefIcons($jobref)
{

    if ($jobref == 'Chat')
    {

        $jobrefIc = 'chat.png';

    }
    elseif ($jobref == 'Email')
    {

        $jobrefIc = 'email.png';

    }
    elseif ($jobref == 'Phone')
    {

        $jobrefIc = 'mobile.png';

    }
    elseif ($jobref == 'Site')
    {

        $jobrefIc = 'site.png';

    }
    elseif ($jobref == 'Staff')
    {

        $jobrefIc = 'staff.png';

    }
    elseif ($jobref == 'Realestate')
    {

        $jobrefIc = 'realestate.png';

    }
    elseif ($jobref == 'Crm')
    {

        $jobrefIc = 'crm.png';

    }
    else
    {

        $jobrefIc = 'others_icon.png';

    }

    return $jobrefIc;

}

function checkReferrel()
{

    if (isset($_SERVER['HTTP_REFERER']))

    {

        if (!strstr($_SERVER['HTTP_REFERER'], "https://beta.bcic.com.au"))

        {

            echo "Sorry you cannot access this page directly!";

            die();

        }

    }

}

function getTotalRecordHourly($date, $date_to, $h)
{

    $h = str_pad($h, 2, "0", STR_PAD_LEFT);

    $date1 = $date . ' ' . $h . ':00:00';

    $date2 = $date . ' ' . ($h + 1) . ':00:00';

    $result = array();

    $countSqtotalQuote = mysql_fetch_array(mysql_query("SELECT count(id) as totalQuote FROM `quote_new` where ( HOUR(createdOn) BETWEEN $h AND $h ) AND date BETWEEN '" . $date . "' AND '" . $date_to . "' AND step not in (10)"));

    if ($countSqtotalQuote['totalQuote'] != 0)
    {

        $result['totalQuote1'] = $countSqtotalQuote['totalQuote'];

    }
    else
    {

        $result['totalQuote1'] = '-';

    }

    $counttotalBook = mysql_fetch_array(mysql_query("SELECT count(id) as totalbook FROM `quote_new` where ( HOUR(createdOn) BETWEEN $h AND $h ) AND date BETWEEN '" . $date . "' AND '" . $date_to . "'  AND booking_id != 0 AND step not in (7)"));

    //$result['totalbook']  = $counttotalBook['totalbook'];
    

    if ($counttotalBook['totalbook'] != 0)
    {

        $result['totalbook'] = $counttotalBook['totalbook'];

    }
    else
    {

        $result['totalbook'] = '-';

    }

    return $result;

}

function gethourlyref($date, $date_to, $h, $ref, $type)
{

    $h = str_pad($h, 2, "0", STR_PAD_LEFT);

    $date1 = $date . ' ' . $h . ':00:00';

    $date2 = $date . ' ' . ($h + 1) . ':00:00';

    //$sql = "SELECT count(id) as totalRecord  FROM `quote_new` WHERE `date` = '".$date."' AND createdOn >= '".$date1."' AND createdOn <= '".$date2."'";
    $sql = "SELECT count(id) as totalRecord FROM `quote_new` where ( HOUR(createdOn) BETWEEN $h AND $h ) AND date BETWEEN '" . $date . "' AND '" . $date_to . "'";

    if ($type == 'quote')

    {

        $sql .= " AND booking_id = 0  AND job_ref = '" . $ref . "'";

    }
    elseif ($type == 'booking')

    {

        $sql .= " AND booking_id !=0 AND job_ref = '" . $ref . "'";

    }

    $sql .= " AND step not in (10)";

    //echo $sql;
    $getRecord = mysql_fetch_array(mysql_query($sql));

    return $getRecord['totalRecord'];

    /* if($getRecord['totalRecord'] != 0) {
    
     return  $getRecord['totalRecord']; 
    
    }else{
    
     return  ' -- '; 
    
    } */

}

/* function gethourlysite($date,$h,$siteid,$type)

	{

		$h = str_pad($h, 2, "0", STR_PAD_LEFT);

		$date1 = $date.' '.$h.':00:00';		

		$date2 = $date.' '.($h+1).':00:00';	

		

		$sql = "SELECT count(id) as totalRecord  FROM `quote_new` WHERE `date` = '".$date."' AND createdOn >= '".$date1."' AND createdOn <= '".$date2."'";

		

		if($type == 'quote')

	    { 

		   $sql .= " AND booking_id = 0 AND site_id = '".$siteid."'"; 

		   

	    }elseif($type == 'booking')

	    {

		   $sql .= " AND booking_id !=0 AND site_id = '".$siteid."'"; 

	    } 

		$getRecord = mysql_fetch_array(mysql_query($sql));

		return   $getRecord['totalRecord']; 

	}

*/

function gethourlysite($date, $date_to, $h, $siteid, $type)

{

    $h = str_pad($h, 2, "0", STR_PAD_LEFT);

    $date1 = $date . ' ' . $h . ':00:00';

    $date2 = $date . ' ' . ($h + 1) . ':00:00';

    $sql = "SELECT count(id) as totalRecord FROM `quote_new` where ( HOUR(createdOn) BETWEEN $h AND $h ) AND date BETWEEN '" . $date . "' AND '" . $date_to . "'";

    if ($type == 'quote')

    {

        $sql .= " AND booking_id = 0 AND site_id = '" . $siteid . "'";

    }
    elseif ($type == 'booking')

    {

        $sql .= " AND booking_id !=0 AND site_id = '" . $siteid . "'";

    }

    $getRecord = mysql_fetch_array(mysql_query($sql));

    /* if($getRecord['totalRecord'] != 0) {
    
    return   $getRecord['totalRecord']; 
    
    }else{
    
    return ' -- ';
    
    } */

    return $getRecord['totalRecord'];

}

function get2cxhourlyreport($call_date, $todate, $h)
{

    $calltile1 = $h . ':00:00';

    $calltile2 = ($h + 1) . ':00:00';

    $TotalS = ("SELECT count(id) as getTotalRecords FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date BETWEEN '" . $call_date . "' AND '" . $todate . "'");

    $TotalRecordsSql = mysql_query($TotalS);

    $TotalRecords = mysql_fetch_array($TotalRecordsSql);

    return $TotalRecords['getTotalRecords'];

}

function get2cxHourlyReportReciveByAdmin($call_date, $todate, $h)
{

    $totaladmincall = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date BETWEEN '" . $call_date . "' AND '" . $todate . "' AND to_type in (SELECT 3cx_user_name FROM `c3cx_users`) AND admin_id in (SELECT id FROM `c3cx_users`)");

    $sql = mysql_query($totaladmincall);

    $TotalRecords = mysql_fetch_array($sql);

    return $TotalRecords['admincall'];

}

function get2cxHourlyReportCallByAdmin($call_date, $todate, $h)
{

    $totaladmincall = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date BETWEEN '" . $call_date . "' AND '" . $todate . "' AND from_type in (SELECT 3cx_user_name FROM `c3cx_users`) AND admin_id in (SELECT id FROM `c3cx_users`)");

    $sql = mysql_query($totaladmincall);

    $TotalRecords = mysql_fetch_array($sql);

    return $TotalRecords['admincall'];

}

function get2cxHourlyReportStaffToClient($call_date, $todate, $h)
{

    $totaladmincall = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date BETWEEN '" . $call_date . "' AND '" . $todate . "' AND admin_id not in (SELECT id FROM `c3cx_users`)");

    $sql = mysql_query($totaladmincall);

    $TotalRecords = mysql_fetch_array($sql);

    return $TotalRecords['admincall'];

}

function get3cxHourlyByname($getadminName, $call_date, $todate, $h, $type)
{

    $userName = get_rs_value("c3cx_users", "3cx_user_name", $getadminName);

    $getAdmin = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date BETWEEN '" . $call_date . "' AND '" . $todate . "' and admin_id = '" . $getadminName . "'");

    if ($type == 1)
    {

        /* $userName =  get_rs_value("c3cx_users","3cx_extension_number",$getadminName);
        
        $userNumber = str_replace('(',' (',$userName); */

        $getAdmin .= " AND from_type = '" . $userName . "'";

    }
    else if ($type == 2)
    {

        $getAdmin .= " AND to_type = '" . $userName . "'";

    }

    //echo $getAdmin;
    $getTotal = mysql_query($getAdmin);

    //$counterResult = mysql_num_rows($getTotal);
    $TotalRecords = mysql_fetch_array($getTotal);

    return $TotalRecords['admincall'];

    //echo  $counterResult;
    
}

function changeDateFormate($data, $type)
{

    if ($data != '0000-00-00 00:00:00' || $data != '0000-00-00')
    {

        if ($type == 'timestamp')
        {

            return date('dS M Y h:i:s A', strtotime($data));

        }
        else if ($type == 'datetime')
        {

            return date('dS M Y', strtotime($data));

        }
        else if ($type == 'dm')
        {

            return date('dS M', strtotime($data));

        }
        else if ($type == 'dt')
        {

            return date('d/m H:i', strtotime($data));

        }
        else if ($type == 'hi')
        {

            return date('h:i A', strtotime($data));

        }else if ($type == 'ts')
        {

            return date('dS M h:i:s A', strtotime($data));

        }

    }
    else
    {

        return 'N/A';

    }

}

/* function searchFieldBorder($value) {

		if($value == 'booking_date'){

		    return  ' 1_search_field_value';

		}elseif($value == 'id'){

		   return  ' 2_search_field_value';

		}elseif($value == 'name'){

		  return  ' 3_search_field_value';

		}elseif($value == 'email'){

		  return   ' 4_search_field_value';

		}elseif($value == 'phone'){

	       return  ' 5_search_field_value';

		}else {

		   return '';

		}

	} */

function getContactType($id)
{

    $getcaontactType = mysql_fetch_array(mysql_query("Select name from system_dd where type = 42 And id =" . $id));

    return $getcaontactType['name'];

}

function getmodeOFContact($id)
{

    $id = explode(',', $id);

    foreach ($id as $key => $val)

    {

        $getModeCaontact = mysql_fetch_array(mysql_query("Select * from system_dd where type = 43 And id = " . $val));

        $str[] = $getModeCaontact['name'];

    }

    return implode(',', $str);

}

function getSystemvalueByID($id, $type)
{

    $getValueData = mysql_fetch_array(mysql_query("Select name from system_dd where type = " . $type . " And id =" . $id));

    // print_r($getValueData);
    return trim($getValueData['name']);

}

function checkBeforeImageUpload($jobid, $staff_id, $type)
{

    if ($type == 1)
    {

        $getbeforeImage = mysql_fetch_array(mysql_query("SELECT count(id) as befoteImage FROM `job_befor_after_image` where job_id ='" . $jobid . "' and image_status = 1 AND staff_id = " . $staff_id . " AND reclean_id != 0 AND job_type_status = 2"));

        return $getbeforeImage['befoteImage'];

    }
    else
    {

        $getafterImage = mysql_fetch_array(mysql_query("SELECT count(id) as afterimageCount FROM `job_befor_after_image` where job_id ='" . $jobid . "' and image_status = 2  AND staff_id = " . $staff_id . " AND reclean_id != 0 AND job_type_status = 2"));

        /* if($getafterImage['afterimageCount'] > 0) {
        
        $status = "Yes";
        
        }else {
        
        $status =  "No";
        
        } */

        return $getafterImage['afterimageCount'];

    }

}

function getQuoteBookedByDate($date, $type, $get_site_id = null)
{

    // $type=>check_avail,dispatch
    

    $result_array = '';

    $start_date_ts_h = $date;

    $flagOn = false;

    $type = "'" . $type . "'";

    unset($result_array);

    $result_array = '';

    //get all sites with green dot if didnt found into {quote_checkBy_site_date} table.
    //Otherwise It will be marked with next RED dot that means Its fully booked the region with date.
    // 1=> For green 2=> For Red
    $region_chk = '';

    $region_chk .= "SELECT 

				chk_site.site_id, chk_site.date , org_site.id, org_site.name, org_site.abv  

			FROM 

				`quote_checkBy_site_date` as chk_site 								

				RIGHT OUTER JOIN 

					sites as org_site 

				ON chk_site.site_id = org_site.id

			WHERE

				(chk_site.date = '" . date('Y-m-d', $start_date_ts_h) . "') ";

    if ($get_site_id != 0 && $get_site_id != '')
    {

        $region_chk .= " AND chk_site.site_id = " . $get_site_id . "";

    }

    $region_chk .= " ORDER BY org_site.id ASC";

    $getRegionData = mysql_query($region_chk);

    $countRgData = mysql_num_rows($getRegionData);

    if ($countRgData > 0)

    {

        $flagOn = true;

    }

    if ($flagOn == false)

    {

        $dotColor = 1; //'<span class="greennew"></span>';
        
    }

    else

    {

        $dotColor = 2; //'<span class="rednew"></span>';
        
    }

    $change_date = date('Y-m-d', $start_date_ts_h);

    if ($countRgData > 0)

    {

        //$flagOn = true;
        

        $toolOuter = '<div id="check_status_' . $start_date_ts_h . '">';

        $toolOuter .= '<span class="tool">';

        while ($rgData = mysql_fetch_assoc($getRegionData))

        {

            $bookeSite[$rgData['abv']] = $rgData['abv'];

        }

        $defaultSites = mysql_query("SELECT name, abv, id from sites");

        while ($rgSitesData = mysql_fetch_assoc($defaultSites))

        {

            if (in_array($rgSitesData['abv'], $bookeSite))

            {

                $toolOuter .= '<span onClick="checkquoteBookStatus(' . $rgSitesData['id'] . ',' . $start_date_ts_h . ',2,' . $type . ');" class="dataList">' . $rgSitesData['abv'] . ' - <span  class="red" id="check_status_2_' . $rgSitesData['id'] . '_' . $start_date_ts_h . '"></span></span>';

            }

            else

            {

                $toolOuter .= '<span onClick="checkquoteBookStatus(' . $rgSitesData['id'] . ',' . $start_date_ts_h . ',1,' . $type . ');"  class="dataList" >' . $rgSitesData['abv'] . ' - <span  class="green" id="check_status_1_' . $rgSitesData['id'] . '_' . $start_date_ts_h . '"></span></span>';

            }

        }

        $toolOuter .= '</span>';

        $toolOuter .= '</div>';

    }

    else

    {

        //$flagOn = false;
        //make default with green dot
        $defaultSites = mysql_query("SELECT name, abv, id from sites");

        $countDefaultSites = mysql_num_rows($defaultSites);

        if ($countDefaultSites > 0)

        {

            $toolOuter = '<span class="tool">';

            while ($rgSitesData = mysql_fetch_assoc($defaultSites))

            {

                $toolOuter .= '<span onClick="checkquoteBookStatus(' . $rgSitesData['id'] . ',' . $start_date_ts_h . ',1,' . $type . ');"  class="dataList">' . $rgSitesData['abv'] . ' - <span  class="green" id="check_status_1_' . $rgSitesData['id'] . '_' . $start_date_ts_h . '"></span></span>';

            }

            $toolOuter .= '</span>';

        }

    }

    $result_array = array(

        'tool_outer' => $toolOuter,

        'dot_color' => $dotColor

    );

    //flush the variable for next loop.
    $flagOn = false;

    $toolOuter = '';

    $dotColor = '';

    unset($bookeSite);

    $bookeSite = '';

    return $result_array;

}

//pusher to send
function sendNotification($datas = null)

{

    include ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    $options = array(

        'cluster' => 'us2',

        'encrypted' => true

    );

    $pusher = new Pusher\Pusher(

    '724a1d2b3deb2c640bdc',

    'a5e4097dae77ed110cf4',

    '440657',

    $options
);

    $data['message'] = $datas['message'];

    $data['class'] = $datas['class'];

    $pusher->trigger('my-channel', 'my-event', $data);

}

/*



    1 => Take Call => Message Flashed

    2 => ReScheduled => Message Flashed and Hide instantly

    3 => Custom Call ReScheduled => Message Flashed and Hide instantly

    4 => Call Done => INSTANT HIDE => FINISHED

    $datas['status'] = 1, 2, 3, 4

    $datas['quote_id'] = 1xxxxx

    $datas['message_for'] = "Demo Message Print"

    $datas['type'] = ""

    



*/

function callSchedulledByStatus($datas = null)

{

    include ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    $options = array(

        'cluster' => 'us2',

        'encrypted' => true

    );

    $pusher = new Pusher\Pusher(

    '724a1d2b3deb2c640bdc',

    'a5e4097dae77ed110cf4',

    '440657',

    $options
);

    $pusher->trigger('my-channel', 'call-schedule', $datas);

}

function AddTaskNotification($datas = null)

{
   $to = $datas['to'];

    include ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    $options = array(

        'cluster' => 'us2',

        'encrypted' => true

    );

    $pusher = new Pusher\Pusher(

    '724a1d2b3deb2c640bdc',

    'a5e4097dae77ed110cf4',

    '440657',

    $options
);


    $pusher->trigger('my-channel', 'task_add_notification_'.$to, $datas);

}

function getJobReportsDetails($staff_id, $status, $fromdate, $toDate)
{

    // Status => 0=>Re-assign 1=> Accept 2=> Deny 3=> Re-Clean 4=> Complete
    //echo $staff_id.$status.$fromdate.$toDate;
    

    if ($status == 4)
    {

        $query = "SELECT  COUNT(id) as CounteStatus FROM `job_details` WHERE  staff_id = '" . $staff_id . "' and job_date >= '" . $fromdate . "' and job_date<='" . $toDate . "' and status != 2 and job_id in (SELECT id from jobs WHERE status = 1) group by job_id ";

        // echo  $query;
        

        $sql = mysql_query($query);

        return mysql_num_rows($sql);

    }
    else
    {

        $query = ("SELECT COUNT(status) as CounteStatus FROM `staff_jobs_status` WHERE `staff_id` = '" . $staff_id . "' AND created_at >= '" . $fromdate . "' AND created_at <= '" . $toDate . "'   AND status =" . $status . "");

        $sql = mysql_query($query);

        //$countAll = mysql_num_rows($sql);
        $ResultCount = mysql_fetch_assoc($sql);

        if ($ResultCount['CounteStatus'] > 0)
        {

            return $ResultCount['CounteStatus'];

        }
        else
        {

            return 0;

        }

    }

}

function totalofferedjob($staff_id, $fromdate, $toDate, $type, $site_id)
{

    if ($type == 1)
    {

        $query = ("SELECT COUNT(id) as totalofferedjob FROM `job_details` WHERE `staff_id` = '" . $staff_id . "'  AND job_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND job_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2 ");

    }
    else if ($type == 2)
    {

        $query = ("SELECT COUNT(id) as totalofferedjob FROM `job_reclean` WHERE `staff_id` = '" . $staff_id . "'  AND reclean_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND reclean_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2 ");

    }
    else if ($type == 3)
    {

        $query = ("SELECT COUNT(id) as totalofferedjob FROM `job_reclean` WHERE `staff_id` = '" . $staff_id . "'  AND reclean_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND reclean_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2 AND job_id in (SELECT id from jobs WHERE status = 3) ");

    }
    else if ($type == 4)
    {

        $query = ("SELECT COUNT(id) as totalofferedjob FROM `job_reclean` WHERE `staff_id` = '" . $staff_id . "'  AND reclean_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND reclean_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2  AND reclean_status = 4");

    }
    else if ($type == 5)
    {

        $query = ("SELECT COUNT(id) as totalofferedjob FROM `job_reclean` WHERE `staff_id` = '" . $staff_id . "'  AND reclean_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND reclean_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2 AND reclean_work = 2");

    }

    if ($site_id != 0)
    {

        $query .= " AND site_id =" . $site_id . "";

    }

    $query .= " GROUP by job_id";

    /*  if($type == 2) {
    
    echo $query;
    
    } */

    $sql = mysql_query($query);

    if (mysql_num_rows($sql) > 0)
    {

        return mysql_num_rows($sql);

    }
    else
    {

        return '-';

    }

}

function totalofferedreCleanjob($staff_id, $fromdate, $toDate)
{

    $Sql = mysql_query("SELECT group_concat(job_id) as jobids FROM `job_reclean` WHERE `staff_id` = '" . $staff_id . "'  AND reclean_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND reclean_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2 ");

    $data = mysql_fetch_array($Sql);

    if (!empty($data['jobids']))
    {

        return $jobs = implode(',', array_unique(explode(',', $data['jobids'])));

    }
    else
    {

        return 'N/A';

    }

}

function totalAmountofJob($job_id)
{

    $sql = mysql_query("select sum(amount) as totalAmount from job_payments where job_id=" . $job_id . "");

    $getAmount = mysql_fetch_array($sql);

    if ($getAmount['totalAmount'] > 0)
    {

        return $getAmount['totalAmount'];

    }
    else
    {

        return 0;

    }

}

function checkPayStaff($job_id)
{

    $sql = mysql_query("SELECT COUNT(id) as staffPayCount FROM `job_details` WHERE `job_id` = " . $job_id . " AND pay_staff = 1 AND status != 2");

    $Counte = mysql_num_rows($sql);

    $getPayStaff = mysql_fetch_array($sql);

    if ($getPayStaff['staffPayCount'] > 0)
    {

        return $getPayStaff['staffPayCount'];

    }
    else
    {

        return 0;

    }

}

function TotalJobOffer($staff_id, $from_date, $to_date, $type)
{

    //echo "SELECT * FROM `staff_jobs_status` WHERE `staff_id` = '".$staff_id."'  AND created_at >= '".$from_date."' AND created_at <= '".$to_date."'  And status = ".$type." GROUP by job_id";
    

    $from_date = $from_date . ' 00:00:00';

    $to_date = $to_date . ' 23:59:00';

    $Sql = mysql_query("SELECT * FROM `staff_jobs_status` WHERE `staff_id` = '" . $staff_id . "'  AND created_at >= '" . $from_date . "' AND created_at <= '" . $to_date . "'  And status = " . $type . " GROUP by job_id");

    if (mysql_num_rows($Sql) > 0)
    {

        return mysql_num_rows($Sql);

    }
    else
    {

        return '-';

    }

}

function gettotalReCleanJobs($staff_id, $from_date, $to_date, $type)
{

    $from_date = $from_date . ' 00:00:00';

    $to_date = $to_date . ' 23:59:00';

    //SELECT GROUP_CONCAT(job_id) as jobs FROM `staff_jobs_status` WHERE staff_id = 309 and status = 2 and created_at >= '2019-06-15 00:07:09' And created_at <= '2019-06-21 23:59:00'
    $Sql = mysql_query("SELECT  GROUP_CONCAT(job_id) as jobs FROM `staff_jobs_status` WHERE `staff_id` = '" . $staff_id . "'  AND created_at >= '" . $from_date . "' AND created_at <= '" . $to_date . "'  AND status = " . $type . "");

    $data = mysql_fetch_array($Sql);

    if (!empty($data['jobs']))
    {

        //return $data['jobs'];
        

        // print_r(explode(','$data['jobs']));
        return $jobs = implode(',', array_unique(explode(',', $data['jobs'])));

    }
    else
    {

        return 'N/A';

    }

}

function get_reason_for_deny($staff_id, $from_date, $to_date, $reason_id)
{

    //SELECT * FROM `reason_for_deny` WHERE `staff_id` = '418'  AND createOn >= '2019-06-01 00:02:23' AND createOn <= '2019-06-30 18:02:23'  AND find_in_set(2 , reason_id) GROUP by job_id
    

    $Sql = mysql_query("SELECT * FROM `reason_for_deny` WHERE `staff_id` = '" . $staff_id . "'  AND createOn >= '" . $from_date . "' AND createOn <= '" . $to_date . "'  AND find_in_set(" . $reason_id . " , reason_id) GROUP by job_id");

    if (mysql_num_rows($Sql) > 0)
    {

        return mysql_num_rows($Sql);

    }
    else
    {

        return 0;

    }

}

function getdeniedJob($staff_id, $from_date, $to_date, $type)
{

    if ($type == 2)
    {

        $sql = mysql_query("SELECT  GROUP_CONCAT(job_id) as jobID FROM `staff_jobs_status` WHERE `staff_id` = '" . $staff_id . "'  AND created_at >= '" . $from_date . "' AND created_at <= '" . $to_date . "'  And status = " . $type . "");

        $get = mysql_fetch_assoc($sql);

        if (!empty($get['jobID']) && $get['jobID'] != '')
        {

            $getResult = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(postcode) as postcode from quote_new where booking_id in (" . $get['jobID'] . ")"));

            $getprimery = mysql_fetch_array(mysql_query("SELECT primary_post_code, name  FROM `staff` WHERE `better_franchisee` = 2 AND id = " . $staff_id . ""));

            $getdata = array_intersect(explode(',', $getResult['postcode']) , explode(',', $getprimery['primary_post_code']));

            return count($getdata);

        }

    }

}

function TotalCompleteJob($staff_id, $from_date, $to_date, $type)
{

    $query = mysql_query("SELECT  COUNT(id) as CounteStatus FROM `job_details` WHERE  staff_id = '" . $staff_id . "' AND job_date >= '" . $from_date . "' AND job_date<='" . $to_date . "' AND job_id in (SELECT id from jobs WHERE status = 3) AND status != 2  group by job_id ");

    $totalComp = mysql_num_rows($query);

    if ($totalComp > 0)
    {

        return $totalComp;

    }
    else
    {

        return 0;

    }

}

function JobStatusName()
{

    $arg = mysql_query("SELECT name, id  FROM `system_dd` WHERE `type` = 26");

    while ($StatusData = mysql_fetch_assoc($arg))
    {

        $getStatus[$StatusData['id']] = $StatusData['name'];

    }

    return $getStatus;

}

function getJobStatus($staff_id, $from_date, $to_date, $jobStatusid)
{

    $query = mysql_query("SELECT  COUNT(id) as CounteStatus FROM `job_details` WHERE  staff_id = '" . $staff_id . "' AND job_date >= '" . $from_date . "' AND job_date<='" . $to_date . "' AND job_id in (SELECT id from jobs WHERE status = " . $jobStatusid . ") AND status != 2  group by job_id ");

    $totalComp = mysql_num_rows($query);

    if ($totalComp > 0)
    {

        return $totalComp;

    }
    else
    {

        return 0;

    }

}

function getnameByID($id, $type)
{

    //echo $id .'==='. $type;
    if ($type == 'admin')
    {

        return get_rs_value("admin", "name", $id);

    }
    if ($type == 'staff')
    {

        return get_rs_value("staff", "name", $id);

    }

}

function get_totalResultStatus($staff_id, $status)
{

    if ($staff_id != 0)
    {

        /* echo "select * from job_details where status != 2 AND staff_id = ".$staff_id." AND job_date  BETWEEN '".date('Y-m-d', strtotime('-7 days'))."' AND  '".date('Y-m-d', strtotime('-1 days'))."' AND job_id in (Select id from jobs where status = ".$status.") GROUP BY job_id"; */

        $sql = mysql_query("select id from job_details where status != 2 AND staff_id = " . $staff_id . " AND job_date  BETWEEN '" . date('Y-m-d', strtotime('-7 days')) . "' AND  '" . date('Y-m-d', strtotime('-1 days')) . "' AND job_id in (Select id from jobs where status = " . $status . ") GROUP BY job_id");

        return $totalrecord = mysql_num_rows($sql);

    }
    else
    {

        return 0;

    }

}

function get_total_job_assign($staff_id)
{

    $arg = mysql_query("select * from job_details where status != 2 AND staff_id = " . $staff_id . " AND job_date >= '" . date('Y-m-d') . "' AND job_date <= '" . date('Y-m-d', strtotime('+7 days')) . "' GROUP BY job_id");

    return $totalrecord = mysql_num_rows($arg);

}

function checkRecleanJob($job_id)
{

    $arg = mysql_query("select count(id) as recleanid from job_details where status != 2 AND job_id = " . $job_id . " AND reclean_job = 2");

    $getdetails = mysql_fetch_assoc($arg);

    return $getdetails['recleanid'];

}

function getPaymentDetails($job_id)
{

    $pgateway_details = mysql_query("select * from job_payments where job_id=" . $job_id . "");

    if (mysql_num_rows($pgateway_details))
    {

        $total_amount_1 = 0;

        $sum_amount = 0;

        $str = '<table width="100%" border="0" cellspacing="3" cellpadding="3" class="table_bg"> 

					<tr class="header_td">

					  <td class="table_cells">Date</td>

					  <td class="table_cells">Amount</td>

					  <td class="table_cells">Payment Method</td>

					  <td class="table_cells">Taken By</td>

					</tr>';

        while ($pgateway = mysql_fetch_assoc($pgateway_details))
        {

            $total_amount_1 += $pgateway['amounr'];

            $sum_amount = $sum_amount + $pgateway['amount'];

            //$staff_name  = get_rs_value("staff","name",$jdetails['staff_id']);
            $str .= '<tr class="table_cells">

						  <td class="table_cells">' . changeDateFormate($pgateway['date'], 'datetime') . '</td>

						  <td class="table_cells">' . $pgateway['amount'] . '</td>

						  <td class="table_cells">' . $pgateway['payment_method'] . '</td>

						  <td class="table_cells">' . $pgateway['taken_by'] . '</td>				  

						</tr>';

        }

        $str .= '<tr><td colspan="5"><strong> Total Amount : ' . $sum_amount . '</strong></td></tr>';

        $str .= '</table>';

    }
    else
    {

        $str .= "No Payment Received";

    }

    return $str;

}

function getMyQuoteDetails($date, $login_id, $type)
{

    // // '1'=> ALl quote , 2=> quote , 3=>  booking , 4=>deleted
    if ($type == 1)
    {

        $arg = ("SELECT count(id) as totalQUote FROM `quote_new` where 1 = 1 AND login_id = " . $login_id . " AND booking_id = 0 AND date = '" . $date . "' ");

    }
    elseif ($type == 2)
    {

        $arg = ("SELECT count(id) as totalQUote FROM `quote_new` where 1 = 1 AND login_id = " . $login_id . "  AND booking_id > 0 AND date = '" . $date . "'");

    }

    $sql = mysql_query($arg);

    $getQuote = mysql_fetch_assoc($sql);

    if ($getQuote['totalQUote'] > 0)
    {

        return $getQuote['totalQUote'];

    }
    else
    {

        return 0;

    }

}

function checkStaffUploadImage($job_id, $staff_id, $type)
{

    // type 1=> Before 2=> After
    

    /*   echo  "SELECT count(id) as befoteImage FROM `job_befor_after_image` where job_id ='".$job_id."' and staff_id ='".$staff_id."' and image_status = ".$type." AND reclean_id = 0 AND job_type_status = 1";  */

    $getafterImage = mysql_fetch_array(mysql_query("SELECT count(id) as imageCount FROM `job_befor_after_image` where job_id ='" . $job_id . "' and staff_id ='" . $staff_id . "' and image_status = " . $type . " AND reclean_id = 0 AND job_type_status = 1"));

    return $getafterImage['imageCount'];

}

function checkStaffUploadImageInDialy($job_id, $staff_id)
{

    // type 1=> Before 2=> After
    

    /*   echo  "SELECT count(id) as befoteImage FROM `job_befor_after_image` where job_id ='".$job_id."' and staff_id ='".$staff_id."' and image_status = ".$type." AND reclean_id = 0 AND job_type_status = 1";  */

    //$getafterImage = mysql_query("SELECT id FROM `job_befor_after_image` where job_id ='" . $job_id . "' and staff_id ='" . $staff_id . "' AND reclean_id = 0 AND job_type_status = 1");
	//SELECT COUNT(id) as id , staff_id, image_status  FROM `job_befor_after_image` WHERE job_id = 17397  GROUP by image_status
    $getafterImage = mysql_query("SELECT COUNT(id) as id , staff_id, image_status  FROM `job_befor_after_image` where job_id ='" . $job_id . "' and staff_id ='" . $staff_id . "' AND reclean_id = 0 AND job_type_status = 1 GROUP by image_status");

	 if(mysql_num_rows($getafterImage) > 0) {
		 while($data = mysql_fetch_assoc($getafterImage)) {
			 $getdata[$data['image_status']][] = $data['id'];
		 }
		 
	 }
    return $getdata;

}

function checkJobAvailable($site_id, $date)
{

    $sql = mysql_query("SELECT * FROM `quote_checkBy_site_date` WHERE site_id = " . $site_id . " AND date = '" . $date . "'");

    return mysql_num_rows($sql);

}

function checkStaffUploadedImage($job_id)
{

    $sql = mysql_query("SELECT COUNT(id) as countImage  FROM `job_befor_after_image` WHERE `job_id` = " . $job_id . "");

    $getdata = mysql_fetch_assoc($sql);

    if (!empty($getdata))
    {

        return $getdata['countImage'];

    }
    else
    {

        return 0;

    }

}

function checkRosterNext($staff_id, $month)
{

    $year = date('Y');

    $sql = mysql_query("SELECT * FROM staff_roster   WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND staff_id = " . $staff_id);

    $numCount = mysql_num_rows($sql);

    if (mysql_num_rows($sql) == 0)

    {

        //SELECT * FROM `staff` where id = 75
        $avaibilityQuery = mysql_query("SELECT avaibility FROM `staff` where id = " . $staff_id);

        $getdata = mysql_fetch_array($avaibilityQuery);

        //$avaibility = get_sql("staff","avaibility","where id ='".$staff_id);
        //echo $getdata['avaibility']; die;
        $getdateInarray = explode(',', ($getdata['avaibility']));

        $getdate = array();

        foreach ($getdateInarray as $value)
        {

            $getdate[] = substr($value, 0, 3);

        }

        //print_r($getdate); die;
        $numberday = cal_days_in_month(CAL_GREGORIAN, date($month) , date($year));

        for ($d = 1;$d <= $numberday;$d++)

        {

            $time = mktime(12, 0, 0, date($month) , $d, date($year));

            if (date($month, $time) == date($month))

            $date = date('Y-m-d', $time);

            $checkday1 = date('D', $time);

            $day = date('D', $time);

            //$checkday = '0';
            if (in_array($checkday1, $getdate))
            {
                $checkday = "1";
            }
            else
            {
                $checkday = '0';
            }

            $staffRoster = mysql_query("INSERT INTO `staff_roster` (`staff_id`, `date`, `status`) VALUES ('" . $staff_id . "', '" . $date . "','" . $checkday . "')");

        }

    }
    else
    {

        $avaibilityQuery = mysql_query("SELECT avaibility FROM `staff` where id = " . $staff_id);

        $getdata = mysql_fetch_array($avaibilityQuery);

        //$avaibility = get_sql("staff","avaibility","where id ='".$staff_id);
        //echo $getdata['avaibility']; die;
        $getdateInarray = explode(',', ($getdata['avaibility']));

        $getdate = array();

        if (count($getdateInarray) > 0):

            foreach ($getdateInarray as $value)
            {

                $getdate[] = substr($value, 0, 3);

            }

            $numberday = cal_days_in_month(CAL_GREGORIAN, date($month) , date($year));

            for ($d = 1;$d <= $numberday;$d++)

            {

                $statuscheck = 0;

                $time = mktime(12, 0, 0, date($month) , $d, date($year));

                if (date($month, $time) == date($month))

                $date = date('Y-m-d', $time);

                $checkday1 = date('D', $time);

                $day = date('D', $time);

                //$checkday = '0';
                if (in_array($checkday1, $getdate))
                {
                    $checkday = "1";
                }
                else
                {
                    $checkday = '0';
                }

                $getsql = mysql_query("SELECT * FROM staff_roster   WHERE date = '" . $date . "' AND staff_id = '" . $staff_id . "' And status = '1'");

                if (mysql_num_rows($getsql) == 0)
                {

                    $staffRoster = mysql_query("update `staff_roster` SET status ='0'  WHERE date = '" . $date . "' AND staff_id = " . $staff_id);

                }

            }

        endif;

    }

}



     function checkAdminRosterNext($admin_id, $month)
    {

         $year = date('Y');  
         $sql  = mysql_query("SELECT * FROM admin_roster   WHERE MONTH(date) = '".$month."' AND YEAR(date) = '".$year."' AND admin_id = ".$admin_id);
		$numCount = mysql_num_rows($sql);
		
		       $getdateInarray = WEEK_DAYS_ARRAY;
				$rosterdata = getdefualRoster($admin_id, $getdateInarray);
				$createdOn = date('Y-m-d H:i:s');
		
		if(mysql_num_rows($sql) == 0) 
			{
				
				//$getdateInarray = explode(',' , ($getdata['avaibility']));
				$getdate = array();

				foreach($getdateInarray as $value) {
				  $getdate[] =  substr($value,0,3);
				}  	
			  //print_r($getdate); die;	
				$numberday=cal_days_in_month(CAL_GREGORIAN,date($month),date($year));
				
				for($d=1; $d<=$numberday; $d++)
					{
						
						
							$time=mktime(12, 0, 0, date($month), $d, date($year));
							if (date($month, $time)==date($month))
							$date = date('Y-m-d', $time);
							$checkday1= date('D', $time);
							$day = date('D', $time);
							$checkday= date('l', $time);
						

					/*	$status = 0;
						if($rosterdata[$checkday]['start_time_au'] != 0) {
						  $status = 1;
						}*/
				
				       $status    =  $rosterdata[$checkday]['start_time_au'];
				      $sql = mysql_query("INSERT INTO `admin_roster`  (`admin_id`, `date`, `status` , `start_time_au`, `end_time_au`, `lunch_time_au`, `lunch_end_time_au`, `createdOn`)  VALUES   (".$admin_id.",  '".$date."',".$status." , ".$rosterdata[$checkday]['start_time_au'].", ".$rosterdata[$checkday]['end_time_au'].", ".$rosterdata[$checkday]['lunch_time_au'].", ".$rosterdata[$checkday]['lunch_end_time_au'].",'".$createdOn."')"); 
					  
						/* $staffRoster = mysql_query("INSERT INTO `admin_roster` (`admin_id`, `date`, `status`) VALUES ('".$admin_id."', '".$date."','".$checkday."')"); */
				
					}
					
			}else{
				
			
				$getdate = array();
								
				if( count( $getdateInarray ) > 0 ) {
					
					foreach($getdateInarray as $value) {
					  $getdate[] =  substr($value,0,3);
					}  	
					
					$numberday=cal_days_in_month(CAL_GREGORIAN,date($month),date($year));
					
					for($d=1; $d<=$numberday; $d++)
					{
						
						$statuscheck = 0;
						
							$time=mktime(12, 0, 0, date($month), $d, date($year));
							if (date($month, $time)==date($month))
							$date = date('Y-m-d', $time);
							$checkday1= date('D', $time);
							$day = date('D', $time);
							$checkday= date('l', $time);
							//$checkday = '0';
						/*	$status = 0;
							if($rosterdata[$checkday]['start_time_au'] != 0) {
							   $status = 1;
							}	*/
					 
					     $status    =  $rosterdata[$checkday]['start_time_au'];
					 			
	                     $sql = mysql_query("UPDATE `admin_roster` SET `start_time_au` = '".$rosterdata[$checkday]['start_time_au']."' , `status`=".$status." , `end_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_end_time_au` = '".$rosterdata[$checkday]['lunch_time_au']."'  WHERE `date` = '".$date."' AND admin_id = {$admin_id}");
					
     					      /*  if(mysql_num_rows($checkStaffRosterID) == 0){
						
	                                    $sql = mysql_query("UPDATE `admin_roster` SET `start_time_au` = '".$rosterdata[$checkday]['start_time_au']."' , `status`=".$status." , `end_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_end_time_au` = '".$rosterdata[$checkday]['lunch_time_au']."'  WHERE `date` = '".$date."' AND admin_id = {$admin_id}");
						
                                }*/
						
					}
					
				}
				
			} 

    }

// File Copy One Folder to another Folder For Application to Staff
function allpFiletransfer($application_id, $laststaffid)
{

    $app_file = mysql_query("SELECT * FROM `applications_doc`  WHERE applications_id  = " . $application_id . "");

    $countResult = mysql_num_rows($app_file);

    if ($countResult > 0)
    {

        //$laststaffid = 250;
        while ($getFile = mysql_fetch_assoc($app_file))
        {

            //echo  "<pre>";  print_r($getFile);
            $filename = $getFile['doc_file'];

            $createdOn = date('Y-m-d H:i:s');

            if (!file_exists('img/staff_file/' . $laststaffid))
            {

                mkdir('img/staff_file/' . $laststaffid, 0777, true);

            }

            $copypath1 = $_SERVER['DOCUMENT_ROOT'] . '/admin/img/staff_file/' . $laststaffid . '/';

            $applicationpath = $_SERVER['DOCUMENT_ROOT'] . "/application/files/" . $getFile['applications_id'] . "/";

            if (!@copy($applicationpath . $filename, $copypath1 . $filename))
            {

                //echo "Wrong";
                
            }
            else
            {

                $insertImage = mysql_query("INSERT INTO `staff_files` (`staff_id`, `image`, `createdOn`) VALUES ('" . $laststaffid . "', '" . $filename . "', '" . $createdOn . "')");

            }

        }

    }

}

function UpdateSearAmount($insertId)
{

    $getAmt = mysql_fetch_assoc(mysql_query("Select amt_share_type from staff where  id =" . $insertId . ""));

    if (!empty($getAmt))
    {

        $aga_value = $getAmt['amt_share_type'];

        $aga1 = explode(',', $aga_value);

        $date = date('Y-m-d h:i:s');

        $adminID = $_SESSION['admin'];

        foreach ($aga1 as $key => $value)
        {

            /* $amt_share_type =  get_rs_value("job_type","amt_share_type",$value);
            
            $sharevalue =  get_rs_value("job_type","value",$value); */

            $jobDetails = mysql_fetch_assoc(mysql_query("Select * from job_type where  id =" . $value . ""));

            mysql_query("INSERT INTO `staff_share_amount` (`staff_id`, `job_type_id`, `amount_share_type`, `value`, `admin_id`, `createdOn`) VALUES ('" . $insertId . "', '" . $value . "', '" . $jobDetails['amt_share_type'] . "', '" . $jobDetails['value'] . "', '" . $adminID . "', '" . $date . "')");

        }

    }

}

function delete_fields($table)

{

    $r = 0;

    $arg = "select * from $table";

    $data = mysql_query($arg);

    while ($r < (mysql_num_rows($data)))
    {

        $id = mysql_result($data, $r, "id");

        if ($_POST['c' . $id] != "")
        {

            $arg1 = "Delete from $table where id=$id";

            //echo "$arg1<br>";
            $insert1 = mysql_query($arg1);

            //include("source/task.php");
            
        }

        $r++;

    }

    return true;

}

function recheck_oto_quote()
{

    $arg = mysql_query("SELECT id , oto_flag ,oto_time,original_price , discount_amt , amount  FROM `quote_new` WHERE oto_flag = 1 AND oto_time != '0000-00-00 00:00:00' AND booking_id = 0 Order by id desc");

    $count = mysql_num_rows($arg);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($arg))
        {

            $oto_time = $data['oto_time'];

            $currentTime = date('Y-m-d H:i:s');

            $expirytime = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($oto_time)));

            $minute = round(abs(strtotime($oto_time) - strtotime($currentTime)) / 60, 2);

            $show_minute = $minute - 30;

            if ($show_minute > 0 && $data['id'] > 0)
            {

                mysql_query("UPDATE quote_new SET amount= '" . $data['original_price'] . "', oto_flag = '0' WHERE id= " . $data['id'] . "");

                //echo "<br/>";
                

                $cleaningdetails = mysql_fetch_assoc(mysql_query("select job_type_id , original_price from quote_details where quote_id ='" . mysql_real_escape_string($data['id']) . "' AND job_type_id = 1"));

                if (!empty($cleaningdetails))
                {

                    mysql_query("UPDATE quote_details SET  quote_auto_custom='1',  amount='" . $cleaningdetails['original_price'] . "'  WHERE quote_id= " . $q_id . " AND job_type_id = '1'");

                    //echo "<br/>===============================================<br/>";
                    
                }

            }

        }

    }

}

function getjobstaff($jobid)
{

    $arg = "SELECT * FROM `job_details` WHERE status != 2 and job_id = " . $jobid . ";

				";

    $data = mysql_query($arg);

    $countResult = mysql_num_rows($data);

    if ($countResult > 0)

    {

        $content = "<table style='width: 100%;margin:0px auto;' bgcolor='' cellpadding=2 cellspacing=2>

			 <tr class='header_td'>

			  <td class='table_cells'>Staff name</td>

			  <td class='table_cells'> job type</td>

			  <td class='table_cells'>Amount</td>";

        while ($row = mysql_fetch_assoc($data))

        {

            if ($row['staff_id'] != 0)
            {

                $staffname = get_rs_value("staff", "name", $row['staff_id']);

            }
            else
            {

                $staffname = 'N/A';

            }

            $content .= "<tr class=''>

                            <td class='table_cells'>" . $staffname . "</td>

                            <td class='table_cells'>" . $row['job_type'] . "</td>	

                            <td class='table_cells'>" . $row['amount_total'] . "</td>	

                        </tr>";

        }

        $content .= "</table>";

    }

    return $content;

}

function getquotebyloginID($login_id, $date, $type)
{

    // for type 1= > Quote , 2=> Booking
    

    if ($type == 1)
    {

        $sql = "SELECT id  FROM `quote_new` WHERE 1= 1 AND `login_id` = " . $login_id . " AND date = '" . $date . "'";

    }
    elseif ($type == 2)
    {

        $sql = "SELECT id  FROM `quote_new` WHERE 1= 1 AND `login_id` = " . $login_id . " AND date = '" . $date . "' AND booking_id != '0' AND booking_id in (select id from jobs where status != 2)";

    }

    $sql .= " AND step not in (10) ";

    //echo $sql;
    $query = mysql_query($sql);

    $count = mysql_num_rows($query);

    return $count;

}

function getquoteConverttobyloginID($login_id, $date, $type)
{

    // for type 1= > Quote , 2=> Booking 
    

    if ($type == 1)
    {

        $sql = "SELECT id  FROM `quote_new` WHERE 1= 1 AND `login_id` = " . $login_id . " AND date = '" . $date . "'";

    }
    elseif ($type == 2)
    {

        $sql = "SELECT id FROM `quote_new` WHERE 1= 1 AND `login_id` = " . $login_id . " AND quote_to_job_date = '" . $date . "' AND booking_id != '0' AND booking_id in (select id from jobs where status != 2)";

    }

    $sql .= " AND step not in (10) ";

    //echo $sql;
    $query = mysql_query($sql);

    $count = mysql_num_rows($query);

    return $count;

}

function GetDrivingDistance($lat1, $lat2, $long1, $long2)

{

    //$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&departure_time=now&traffic_model=optimistic&key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

    curl_close($ch);

    $response_a = json_decode($response, true);

    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];

    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    $timechange = convertDistanceTime($time);

    return array(
        'distance' => $dist,
        'time' => $timechange
    );

}

function getLatLong($address)
{
    //echo $address;
    if ($address != '')
    {
        //Formatted address
        $formattedAddr = str_replace(' ', '+', $address);
        //Send request and receive json data by address

        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo&address=' . $formattedAddr . '&sensor=true');

        $output = json_decode($geocodeFromAddr);

        //echo "<pre>";  print_r($output);
        

        //Get latitude and longitute from json data
        $data['latitude'] = $output->results[0]
            ->geometry
            ->location->lat;

        $data['longitude'] = $output->results[0]
            ->geometry
            ->location->lng;

        $data['suber'] = $output->results[0]
            ->address_components[1]->long_name;

        $data['postcode'] = $output->results[0]
            ->address_components[5]->long_name;

        //print_r($data);
        //Return latitude and longitude of the given address
        if (!empty($data))
        {

            return $data;

        }
        else
        {

            return false;

        }

    }
    else
    {

        return false;

    }

}

function Calculategetdisctance($from_address, $toaddress)

{

    //echo  "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$from_address."&destinations=".$toaddress."&key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo";
    

    $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $from_address . "&destinations=" . $toaddress . "&key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo");

    $data = json_decode($api, true);

    $dist = ((int)$data->rows[0]
        ->elements[0]
        ->distance->value / 1000) . ' Km';

    $timechange = $data->rows[0]
        ->elements[0]
        ->duration->text;

    return array(
        'distance' => $dist,
        'time' => $timechange
    );

}

function updatedeletedbrquote($table_name, $quid)
{

    $update = mysql_query("update $table_name set  moving_from='', moving_to='',is_flour_from='0', is_flour_to='0',is_lift_from='0', house_type_from='0',door_distance_from='0', is_lift_to='0',house_type_to='0', door_distance_to='',lat_from='', long_from='',lat_to='', long_to='', cubic_meter='' where id = " . $quid . "");

    return true;

}

function update_cubic_by_job($field = null, $r)
{

    if ($field != '')
    {

        $quote_id = $r['quote_id'];

        if ($field == 'kitchen')
        {

            //echo  "update  `quote_details_inventory` set qty = '".mysql_real_escape_string($r['kitchen'])."'  WHERE quote_id = '".$quote_id."' and type ='2' AND inventory_type_id = '3'"; die;
            

            $sql = mysql_query("update  `quote_details_inventory` set qty = '" . mysql_real_escape_string($r['kitchen']) . "'  WHERE quote_id = '" . $quote_id . "' and type ='2' AND inventory_type_id = '3'");

            $getjob_type = mysql_query("SELECT DISTINCT(inventory_type_id) as typeid , type ,qty FROM `quote_details_inventory`  WHERE quote_id = " . $quote_id . " and type ='2'");

        }
        else
        {

            $getbrjovtypeid = mysql_fetch_array(mysql_query("SELECT id  FROM `br_inventory_type` WHERE `fields_name` = '" . $field . "'"));

            $sql = mysql_query("update  `quote_details_inventory` set qty = '" . $r[$field] . "'  WHERE quote_id = '" . $quote_id . "' and type ='1' AND inventory_type_id = '" . $getbrjovtypeid['id'] . "'");

            $getjob_type = mysql_query("SELECT DISTINCT(inventory_type_id) as typeid , type ,qty FROM `quote_details_inventory`  WHERE quote_id = " . $quote_id . " and type ='1'");

        }

        //$bool = mysql_query($sql);
        

        $totalcubic = 0;

        while ($result = mysql_fetch_assoc($getjob_type))
        {

            $inventory_type_id = $result['typeid'];

            $type = $result['type'];

            $getcubic = getCubicmeter($quote_id, $inventory_type_id, $type);

            $totalcubic = $totalcubic + $getcubic;

        }

        //echo  $totalcubic;
        $totalcubic_meter = $totalcubic;

    }
    else
    {

        $totalcubic_meter = $r['cubic_meter'];

        $quote_id = $r['quote_id'];

    }

    $totalcubic_meter = ($totalcubic_meter);

    $loadingtime = ($totalcubic_meter / 4);

    $gettotalDIstanceCount = gettotalDIstanceCount($quote_id);

    // print_r($gettotalDIstanceCount);
    

    $travelling_hr = $gettotalDIstanceCount['travelling_hr'];

    // ground Flour include and if Extra floor 1 hr Add
    if ($gettotalDIstanceCount['is_flour_from'] == 1)
    {

        $flourhr_from = 0;

    }
    else
    {

        $flourhr_from = ($gettotalDIstanceCount['is_flour_from']) - 1;

    }

    // ground Flour include and if Extra floor 1 hr Add
    if ($gettotalDIstanceCount['is_flour_to'] == 1)
    {

        $flourhr_to = 0;

    }
    else
    {

        $flourhr_to = ($gettotalDIstanceCount['is_flour_to']) - 1;

    }

    // Door Distance 20 mter Includes and if Extra 1 hr Add
    if ($gettotalDIstanceCount['door_distance_from'] == 1)
    {

        $door_distance_from = 0;

    }
    else
    {

        $door_distance_from = 1;

    }

    // Door Distance 20 mter Includes and if Extra 1 hr Add
    if ($gettotalDIstanceCount['door_distance_to'] == 1)
    {

        $door_distance_to = 0;

    }
    else
    {

        $door_distance_to = 1;

    }

    $depot_to_job_time = $r['depot_to_job_time'];

    $totaltrvl = $travelling_hr * $r['traveling'];

    $loading_time = ($flourhr_from + $flourhr_to + $door_distance_from + $door_distance_to + $loadingtime); // loading Time
    

    $total_traval_workTIme = ($depot_to_job_time + $totaltrvl + $loading_time); //  (dtp+ (trv*tvlround) +ldg)
    $bcic_amount = check_cubic_meter_amount($totalcubic_meter);

    $amount = $total_traval_workTIme * $bcic_amount;

    $uarg = mysql_query("update  quote_details set amount ='" . $amount . "', travelling_hr ='" . $travelling_hr . "' , hours ='" . $total_traval_workTIme . "' , origanl_total_time ='" . $total_traval_workTIme . "' , origanl_cubic ='" . $totalcubic_meter . "' , origanl_total_amount ='" . $amount . "' , loading_time='" . $loading_time . "', cubic_meter='" . $totalcubic_meter . "',working_hr ='" . $loading_time . "' WHERE `quote_id` = '" . $quote_id . "' AND job_type_id = 11 ");

    $uarg1 = mysql_query("update  quote_new set amount ='" . $amount . "', cubic_meter='" . $totalcubic_meter . "' WHERE `id` = '" . $quote_id . "'");

}

function getCubicmeter($quote_id, $inventory_type_id, $type)
{

    $getSystemvalue = mysql_fetch_assoc(mysql_query("SELECT  GROUP_CONCAT(inventory_item_id) as cubicmeterid , qty  FROM `quote_details_inventory` WHERE quote_id = " . $quote_id . " AND inventory_type_id = " . $inventory_type_id . " AND type = " . $type . ""));

    $totalcubic = mysql_fetch_assoc(mysql_query("SELECT  sum(m_3) as cubic  FROM `removal_item_chart` WHERE id in (" . $getSystemvalue['cubicmeterid'] . ")"));

    //print_r($getSystemvalue);
    

    // die;
    $totalCubicdata = round(($totalcubic['cubic'] * $getSystemvalue['qty']) , 2);

    return $totalCubicdata;

}

function gettotalDIstanceCount($quote_id)
{

    // For Calculate Distance &  time
    $getQuotedetails = mysql_fetch_array(mysql_query("SELECT * FROM `quote_new` WHERE `id` = " . $quote_id . ""));

    $timedistance = GetDrivingDistance($getQuotedetails['lat_from'], $getQuotedetails['lat_to'], $getQuotedetails['long_from'], $getQuotedetails['long_to']);

    //$travling_hr =  str_replace(' ', '', str_replace('godz','',$timedistance['time']));
    $travelling_hr = $timedistance['time'];

    $depot_to_job_time = 1;

    return array(
        'travelling_hr' => $travelling_hr,
        'is_flour_from' => $getQuotedetails['is_flour_from'],
        'door_distance_from' => $getQuotedetails['door_distance_from'],
        'is_flour_to' => $getQuotedetails['is_flour_to'],
        'door_distance_to' => $getQuotedetails['door_distance_to'],
        'depot_to_job_time' => $depot_to_job_time
    );

}

function add_edit_claculate_br_cubic($quote_id)
{

    //$quote = mysql_fetch_array(mysql_query("SELECT *  FROM `quote_new` WHERE `id` = '".$quote_id."'"));
    $quotedetails = mysql_fetch_array(mysql_query("SELECT *  FROM `quote_details` WHERE `quote_id` = '" . $quote_id . "' AND job_type_id = 11"));

    if (!empty($quotedetails))
    {

        if ($quotedetails['bed'] > 0)
        {
            $bed = $quotedetails['bed'];
        }
        else
        {
            $bed = 0;
        }

        if ($quotedetails['study'] > 0)
        {
            $study = $quotedetails['study'];
        }
        else
        {
            $study = 0;
        }

        if ($quotedetails['lounge_hall'] > 0)
        {
            $lounge_hall = $quotedetails['lounge_hall'];
        }
        else
        {
            $lounge_hall = 0;
        }

        if ($quotedetails['kitchen_dining'] > 0)
        {
            $kitchen_dining = $quotedetails['kitchen_dining'];
        }
        else
        {
            $kitchen_dining = 0;
        }

        if ($quotedetails['kitchen'] > 0)
        {
            $kitchen = $quotedetails['kitchen'];
        }
        else
        {
            $kitchen = 0;
        }

        if ($quotedetails['dining_room'] > 0)
        {
            $dining_room = $quotedetails['dining_room'];
        }
        else
        {
            $dining_room = 0;
        }

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

        // For bed
        if ($bed != 0)
        {

            $total_bed_type_cubciMeter = 0;

            for ($bed_item = 1;$bed_item <= $bed;$bed_item++)
            {

                $bedroomsCubicMeter = CubicmeterInsertion_byclient($quote_id, 1, 1, $bed_item);

                $gettotalbed_cubic = getitemcubicmeter($quote_id, 1, 1, $bed_item);

                $total_bed_type_cubciMeter = $total_bed_type_cubciMeter + $gettotalbed_cubic;

            }

        }

        // For study
        if ($study != 0)
        {

            $total_study_type_cubciMeter = 0;

            for ($study_item = 1;$study_item <= $study;$study_item++)
            {

                $bedroomsCubicMeter = CubicmeterInsertion_byclient($quote_id, 8, 1, $study_item);

                $total_study_cubciMeter = getitemcubicmeter($quote_id, 8, 1, $study_item);

                $total_study_type_cubciMeter = $total_study_type_cubciMeter + $total_study_cubciMeter;

            }

        }

        if ($lounge_hall != 0)
        {

            $total_living_type_cubciMeter = 0;

            for ($lounge_hall_item = 1;$lounge_hall_item <= $lounge_hall;$lounge_hall_item++)
            {

                $bedroomsCubicMeter = CubicmeterInsertion_byclient($quote_id, 2, 1, $lounge_hall_item);

                $living_type_cubciMeter = getitemcubicmeter($quote_id, 2, 1, $lounge_hall_item);

                $total_living_type_cubciMeter = $total_living_type_cubciMeter + $living_type_cubciMeter;

            }

        }

        if ($dining_room != 0)
        {

            $total_dining_room_cubciMeter = 0;

            for ($dining_room_item = 1;$dining_room_item <= $dining_room;$dining_room_item++)
            {

                $bedroomsCubicMeter = CubicmeterInsertion_byclient($quote_id, 3, 1, $dining_room_item);

                $dining_room_cubciMeter = getitemcubicmeter($quote_id, 3, 1, $dining_room_item);

                $total_dining_room_cubciMeter = $total_dining_room_cubciMeter + $dining_room_cubciMeter;

            }

        }

        if ($kitchen != 0)
        {

            $total_kitchen_cubciMeter = 0;

            for ($kitchen_item = 1;$kitchen_item <= $kitchen;$kitchen_item++)
            {

                $bedroomsCubicMeter = CubicmeterInsertion_byclient($quote_id, 3, 2, $kitchen_item);

                $kitchen_cubciMeter = getitemcubicmeter($quote_id, 3, 2, $kitchen_item);

                $total_kitchen_cubciMeter = $total_kitchen_cubciMeter + $kitchen_cubciMeter;

            }

        }

        $totalcubic_meter = ceil($total_bed_type_cubciMeter + $total_study_type_cubciMeter + $total_living_type_cubciMeter + $total_dining_room_cubciMeter + $total_kitchen_cubciMeter);

        $loadingtime = ($totalcubic_meter / 4);

        $gettotalDIstanceCount = gettotalDIstanceCount($quote_id);

        $travelling_hr = ceil($gettotalDIstanceCount['travelling_hr']);

        // ground Flour include and if Extra floor 1 hr Add
        if ($gettotalDIstanceCount['is_flour_from'] == 1)
        {

            $flourhr_from = 0;

        }
        else
        {

            $flourhr_from = ($gettotalDIstanceCount['is_flour_from']) - 1;

        }

        // ground Flour include and if Extra floor 1 hr Add
        if ($gettotalDIstanceCount['is_flour_to'] == 1)
        {

            $flourhr_to = 0;

        }
        else
        {

            $flourhr_to = ($gettotalDIstanceCount['is_flour_to']) - 1;

        }

        // Door Distance 20 mter Includes and if Extra 1 hr Add
        if ($gettotalDIstanceCount['door_distance_from'] == 1)
        {

            $door_distance_from = 0;

        }
        else
        {

            $door_distance_from = 1;

        }

        // Door Distance 20 mter Includes and if Extra 1 hr Add
        if ($gettotalDIstanceCount['door_distance_to'] == 1)
        {

            $door_distance_to = 0;

        }
        else
        {

            $door_distance_to = 1;

        }

        $total_hours = ceil($flourhr_from + $flourhr_to + $door_distance_from + $door_distance_to + $loadingtime);

        //$total_hours = ($door_distance_from) + ($flourhr) + $loadingtime;
        

        $total_traval_workTIme = ($total_hours + $travelling_hr);

        $bcic_amount = check_cubic_meter_amount($totalcubic_meter);

        $amount = $total_traval_workTIme * $bcic_amount;

        $uarg = mysql_query("update  quote_details set amount ='" . $amount . "', travelling_hr ='" . $travelling_hr . "' , hours ='" . $total_traval_workTIme . "' , origanl_total_time ='" . $total_traval_workTIme . "' , origanl_cubic ='" . $totalcubic_meter . "' , origanl_total_amount ='" . $amount . "' , cubic_meter='" . $totalcubic_meter . "',working_hr ='" . $total_hours . "' WHERE `quote_id` = '" . $quote_id . "' AND job_type_id = 11 ");

    }

}

function add_edit_CubicmeterInsertion($quote_id, $qty, $item, $item_type_id, $type)
{

    $getSql = mysql_query("SELECT *  FROM `removal_item_chart` WHERE `item_name` IN (" . $item . ") AND item_type_id = " . $item_type_id . "");

    while ($getdata = mysql_fetch_array($getSql))
    {

        mysql_query("insert into 	quote_details_inventory (quote_id  , type, inventory_type_id , inventory_item_id ,inventory_item_name ,qty) value('" . $quote_id . "' , '" . $type . "' , '" . $item_type_id . "' , '" . $getdata['id'] . "' , '" . $getdata['item_name'] . "' , '" . $qty . "')");

    }

}

function add_edit_getitemcubicmeter($quote_id, $inventory_type_id, $type)
{

    $getSystemvalue = mysql_fetch_assoc(mysql_query("SELECT  GROUP_CONCAT(inventory_item_id) as cubicmeterid , qty  FROM `quote_details_inventory` WHERE quote_id = " . $quote_id . " AND inventory_type_id = " . $inventory_type_id . " AND type = " . $type . ""));

    //print_r($getSystemvalue);
    

    $totalcubic = mysql_fetch_assoc(mysql_query("SELECT  sum(m_3) as cubic  FROM `removal_item_chart` WHERE id in (" . $getSystemvalue['cubicmeterid'] . ")"));

    //print_r($getSystemvalue);
    

    // die;
    $totalCubicdata = round(($totalcubic['cubic'] * $getSystemvalue['qty']) , 2);

    return $totalCubicdata;

}

function update_br_amount($details_id, $table, $field)
{

    //echo $details_id; die;
    $temp_quote_details = mysql_fetch_array(mysql_query("select * from $table where id=" . $details_id));

    if ($table == 'temp_quote_details')
    {

        $quotetable = 'temp_quote';

        $quote_id = $temp_quote_details['temp_quote_id'];

    }
    else
    {

        $quotetable = 'quote_new';

        $quote_id = $temp_quote_details['quote_id'];

    }

    //echo  $quotetable;
    $quote = mysql_fetch_array(mysql_query("SELECT *  FROM  $quotetable WHERE `id` = '" . $quote_id . "'"));

    //print_r($quote);
    

    if ($field == 'cubic_meter')
    {

        $loadingtime = ($temp_quote_details['cubic_meter'] / 4);

        if ($quote['is_flour_from'] == 1)
        {

            $flourhr_from = 0;

        }
        else
        {

            $flourhr_from = ($quote['is_flour_from'] - 1) * 1;

        }

        // ground Flour include and if Extra floor 1 hr Add
        if ($quote['is_flour_to'] == 1)
        {

            $flourhr_to = 0;

        }
        else
        {

            $flourhr_to = ($quote['is_flour_to'] - 1) * 1;

        }

        // Door Distance 20 mter Includes and if Extra 1 hr Add
        if ($quote['door_distance_from'] == 1)
        {

            $door_distance_from = 0;

        }
        else
        {

            $door_distance_from = 1;

        }

        // Door Distance 20 mter Includes and if Extra 1 hr Add
        if ($quote['door_distance_to'] == 1)
        {

            $door_distance_to = 0;

        }
        else
        {

            $door_distance_to = 1;

        }

        $travelling_hr = ($temp_quote_details['travelling_hr']);

        $depot_to_job_time = $temp_quote_details['depot_to_job_time'];

        $traveling = $temp_quote_details['traveling'];

        $totaltraveltime = ($travelling_hr * $traveling);

        $total_hours = ($door_distance_from + $flourhr_from + $door_distance_to + $flourhr_to + $loadingtime);

        $total_traval_workTIme = ($depot_to_job_time + $total_hours + ($totaltraveltime));

        $bcic_amount = check_cubic_meter_amount($temp_quote_details['cubic_meter']); // Amount
        

        $amount = $total_traval_workTIme * $bcic_amount;

        $hours = $total_traval_workTIme;

    }
    elseif ($field == "depot_to_job_time" || $field == "travelling_hr" || $field == "loading_time" || $field == 'traveling')
    {

        $depot_to_job_time = ($temp_quote_details['depot_to_job_time']);

        $loading_time = ($temp_quote_details['loading_time']);

        $travelling_hr = ($temp_quote_details['travelling_hr']);

        $traveling = ($temp_quote_details['traveling']);

        $totaltraveltime = ($travelling_hr * $traveling);

        $total_traval_workTIme = ($depot_to_job_time + $totaltraveltime + $loading_time);

        $bcic_amount = check_cubic_meter_amount($temp_quote_details['cubic_meter']);

        $amount = $total_traval_workTIme * $bcic_amount;

        $hours = $total_traval_workTIme;

    }
    else
    {

        $bcic_amount = check_cubic_meter_amount($temp_quote_details['cubic_meter']);

        $amount = ($temp_quote_details['hours'] * $bcic_amount);

        $hours = $temp_quote_details['hours'];

        $totaltraveltime = $temp_quote_details['travelling_hr'];

    }

    $bool = mysql_query("update " . $table . " set amount='" . $amount . "', hours = '" . $hours . "' where id=" . $details_id . "");

}

function convertDistanceTime($time)
{

    $str = str_replace(' ', '', $time);

    $str = str_replace('hours', 'hour', $time);

    $str = str_replace('mins', 'min', $time);

    $pos = strpos($str, 'hour');

    $min = 0;

    $hour = 0;

    if ($pos === false)
    {

        $minutes = explode('min', $str);

        $min = $minutes[0];

    }
    else
    {

        $hours = explode('hour', $str);

        $hour = $hours[0];

        $exp1 = explode('min', $hours[1]);

        $min = $exp1[0];

    }

    return $tra = (float)($hour . '.' . $min);

}

function CubicmeterInsertion($quote_id, $item_type_id, $type, $item_pos)
{

    if ($type == '2')
    {

        $default_item = get_rs_value("br_inventory_type", "kitchen", $item_type_id);

    }
    else
    {

        $default_item = get_rs_value("br_inventory_type", "default_item", $item_type_id);

    }

    //print_r($default_item);
    

    if ($default_item != '')
    {

        $items = explode(',', $default_item);

        if (!empty($items))
        {

            foreach ($items as $value)
            {

                $itemname = mysql_fetch_assoc(mysql_query("SELECT id ,item_name  FROM `removal_item_chart` WHERE `id` = " . trim($value) . ""));

                mysql_query("insert into 	temp_quote_details_inventory (temp_quote_id  , type, inventory_type_id , inventory_item_id ,inventory_item_name ,qty , item_pos) value('" . $quote_id . "' , '" . $type . "' , '" . $item_type_id . "' , '" . $itemname['id'] . "' , '" . $itemname['item_name'] . "' , '1' , '" . $item_pos . "')");

            }

        }

    }

}

function CubicmeterInsertion_byclient($quote_id, $item_type_id, $type, $item_pos)
{

    if ($type == '2')
    {

        $default_item = get_rs_value("br_inventory_type", "kitchen", $item_type_id);

    }
    else
    {

        $default_item = get_rs_value("br_inventory_type", "default_item", $item_type_id);

    }

    //print_r($default_item);
    

    if ($default_item != '')
    {

        $items = explode(',', $default_item);

        if (!empty($items))
        {

            foreach ($items as $value)
            {

                $itemname = mysql_fetch_assoc(mysql_query("SELECT id ,item_name  FROM `removal_item_chart` WHERE `id` = " . trim($value) . ""));

                mysql_query("insert into quote_details_inventory (quote_id  , type, inventory_type_id , inventory_item_id ,inventory_item_name ,qty , item_pos) value('" . $quote_id . "' , '" . $type . "' , '" . $item_type_id . "' , '" . $itemname['id'] . "' , '" . $itemname['item_name'] . "' , '1' , '" . $item_pos . "')");

            }

        }

        return 1;

    }
    else
    {

        return 0;

    }

}

function getitemcubicmeter($quote_id, $item_type_id, $type, $item_pos)
{

    if ($type == '2')
    {

        $default_item = get_rs_value("br_inventory_type", "kitchen", $item_type_id);

    }
    else
    {

        $default_item = get_rs_value("br_inventory_type", "default_item", $item_type_id);

    }

    $totalcubic = 0;

    if ($default_item != '')
    {

        $items = explode(',', $default_item);

        if (!empty($items))
        {

            foreach ($items as $value)
            {

                $getcubic = mysql_fetch_assoc(mysql_query("SELECT m_3  FROM `removal_item_chart` WHERE `id` = " . trim($value) . ""));

                $totalcubic = $totalcubic + $getcubic['m_3'];

            }

        }

    }

    return $totalcubic;

}

function get_item_name_byid($default_item)
{

    $items = explode(',', $default_item);

    //print_r($items); die;
    

    $item_name = array();

    foreach ($items as $value)
    {

        $itemname = mysql_fetch_assoc(mysql_query("SELECT item_name  FROM `removal_item_chart` WHERE `id` = " . trim($value) . ""));

        $item_name[] = $itemname['item_name'];

    }

    return implode(',', $item_name);

    //return rtrim($item_name , ',');
    

    
}

function create_inventory_dd($field_name, $table, $id_field, $name_field, $cond = " 1 ", $onchng = null, $details = null)
{

    if ($cond != "")
    {

        $arg = "SELECT * FROM " . $table . " where status = 1 AND " . $cond;

    }
    else
    {

        $arg = "SELECT * FROM " . $table . " where status = 1 ";

    }

    //$arg= ' AND status = 1';
    //echo ($arg);
    //$str = '';
    $datax = mysql_query($arg);

    $str = "> <option value='0'>Select</option>";

    if (mysql_num_rows($datax) > 0)
    {

        while ($rx = mysql_fetch_assoc($datax))
        {

            $str .= "<option value=\"" . $rx[$id_field] . "\">" . ucwords(strtolower($rx[$name_field])) . "</option>";

        }

    }

    return $str;

}

function ordinal_suffix($num)
{

    $num = $num % 100; // protect against large numbers
    if ($num < 11 || $num > 13)
    {

        switch ($num % 10)
        {

            case 1:
                return 'st';

            case 2:
                return 'nd';

            case 3:
                return 'rd';

        }

    }

    return 'th';

}

function get_cubic_meter_by_position($inventory_type_id, $type, $quote_id, $item_pos)
{

    /* echo  "SELECT  GROUP_CONCAT(inventory_item_id) as id   FROM `quote_details_inventory` WHERE inventory_type_id = ".$inventory_type_id." AND type = ".$type." AND quote_id = ".$quote_id." AND item_pos = ".$item_pos.""; */

    $sql1 = mysql_query("SELECT  inventory_item_id   FROM `quote_details_inventory` WHERE inventory_type_id = " . $inventory_type_id . " AND type = " . $type . " AND quote_id = " . $quote_id . " AND item_pos = " . $item_pos . "");

    if (mysql_num_rows($sql1) > 0)
    {

        $total_cubic = 0;

        while ($data = mysql_fetch_assoc($sql1))
        {

            $itemname = mysql_fetch_assoc(mysql_query("SELECT m_3  FROM `removal_item_chart` WHERE `id` = " . trim($data['inventory_item_id']) . ""));

            $total_cubic = $total_cubic + $itemname['m_3'];

        }

        return ($total_cubic);

    }
    else
    {

        return 0;

    }

}

function showotalCubicmeter($quote_id)
{

    //echo $quote_id;
    $sql1 = mysql_query("SELECT  inventory_item_id  FROM `quote_details_inventory` WHERE  quote_id = " . $quote_id . "");

    if (mysql_num_rows($sql1) > 0)
    {

        $totalcubic = 0;

        while ($data = mysql_fetch_assoc($sql1))
        {

            $getcubcic = mysql_fetch_array(mysql_query("SELECT m_3  FROM `removal_item_chart` WHERE `id` = " . $data['inventory_item_id'] . ""));

            $totalcubic = $totalcubic + $getcubcic['m_3']; //print_r($getcubcic);
            
        }

        //return  $totalcubic;
        

        $quote = mysql_fetch_array(mysql_query("SELECT *  FROM `quote_new` WHERE `id` = '" . $quote_id . "'"));

        $quoteSql = mysql_query("SELECT *  FROM `quote_details` WHERE `quote_id` = '" . $quote_id . "'");

        $total_amount = 0;

        while ($quotedetails = mysql_fetch_array($quoteSql))
        {

            //print_r($quotedetails);
            

            if ($quotedetails['job_type_id'] == '11')
            {

                $totalcubic_meter = ($totalcubic);

                $loadingtime = ($totalcubic_meter / 4);

                $travelling_hr = ($quotedetails['travelling_hr']);

                if ($quote['is_flour_from'] == 1)
                {

                    $flourhr_from = 0;

                }
                else
                {

                    $flourhr_from = ($quote['is_flour_from'] - 1) * 1;

                }

                // ground Flour include and if Extra floor 1 hr Add
                if ($quote['is_flour_to'] == 1)
                {

                    $flourhr_to = 0;

                }
                else
                {

                    $flourhr_to = ($quote['is_flour_to'] - 1) * 1;

                }

                // Door Distance 20 mter Includes and if Extra 1 hr Add
                if ($quote['door_distance_from'] == 1)
                {

                    $door_distance_from = 0;

                }
                else
                {

                    $door_distance_from = 1;

                }

                // Door Distance 20 mter Includes and if Extra 1 hr Add
                if ($quote['door_distance_to'] == 1)
                {

                    $door_distance_to = 0;

                }
                else
                {

                    $door_distance_to = 1;

                }

                $depot_to_job_time = $quotedetails['depot_to_job_time'];

                $traveling = $quotedetails['traveling'];

                $loading_hr = ($door_distance_from + $flourhr_from + $door_distance_to + $flourhr_to + $loadingtime);

                $total_traval_workTIme = ($depot_to_job_time + ($travelling_hr * $traveling) + $loading_hr);

                $bcic_amount = check_cubic_meter_amount($totalcubic_meter);

                $amount = $total_traval_workTIme * $bcic_amount;

                $desc = br_description($quotedetails);

                $uarg = mysql_query("update  quote_details set amount ='" . $amount . "',  description='" . $desc . "' , hours ='" . $total_traval_workTIme . "' , cubic_meter='" . $totalcubic_meter . "', origanl_total_time ='" . $total_traval_workTIme . "' , origanl_cubic='" . $totalcubic_meter . "', origanl_total_amount ='" . $amount . "' , loading_time = '" . $loading_hr . "' , working_hr ='" . $loading_hr . "'  WHERE `quote_id` = '" . $quote_id . "' AND job_type_id = 11");

                $quotedetails['amount'] = $amount;

                fix_job_details_amounts($quotedetails['id']);

            }

            $total_amount = $quotedetails['amount'] + $total_amount;

        }

        $uarg1 = mysql_query("update  quote_new set amount ='" . $total_amount . "', cubic_meter='" . $totalcubic_meter . "' WHERE `id` = '" . $quote_id . "'");

        return $totalcubic_meter;

    }

}

function getfieldtypevalue($field_name, $qid)
{

    $getdata = mysql_fetch_assoc(mysql_query("select $field_name from `quote_details`  WHERE quote_id = " . $qid . " AND job_type_id = 11"));

    if (!empty($getdata))
    {

        return $getdata[$field_name];

    }
    else
    {

        return 0;

    }

}

function br_description($r)
{

    $desc = '';

    if ($r['bed'] > 0)
    {
        $desc .= ' ' . $r['bed'] . ' Beds,';
    }

    if ($r['study'] > 0)
    {
        $desc .= ' ' . $r['study'] . ' Study,';
    }

    if ($r['lounge_hall'] > 0)
    {
        $desc .= ' ' . $r['lounge_hall'] . ' Living Areas,';
    }

    if ($r['kitchen'] > 0)
    {
        $desc .= ' ' . $r['kitchen'] . ' kitchen,';
    }

    if ($r['dining_room'] > 0)
    {
        $desc .= ' ' . $r['dining_room'] . ' Dining room,';
    }

    if ($r['office'] > 0)
    {
        $desc .= ' ' . $r['office'] . ' Office ,';
    }

    if ($r['garage'] > 0)
    {
        $desc .= ' ' . $r['garage'] . ' Garage,';
    }

    if ($r['laundry'] > 0)
    {
        $desc .= ' ' . $r['laundry'] . ' Laundry,';
    }

    return $desc;

}

function getbrSystemvalueByID($id, $type)
{

    $getValueData = mysql_fetch_array(mysql_query("Select name from system_dd_br where type = " . $type . " And id =" . $id));

    return trim($getValueData['name']);

}

function show_all_invoice($staff_ids, $from_date, $todate)
{

    $staffid = explode(',', $staff_ids);

    $eol = "<br/>";

    $content = '';

    foreach ($staffid as $staff_id)
    {

        $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $staff_id . ""));

        $content .= 'Hello ' . $getstaffdetails['name'] . '' . $eol;

        $content .= " Your Invoice report From " . changeDateFormate($from_date, 'datetime') . " To " . changeDateFormate($todate, 'datetime') . "";

        $file = "staff_invoice_tpl.php";

        ob_start(); // start buffer
        include ($_SERVER['DOCUMENT_ROOT'] . "/email_template/" . $file);

        $content .= ob_get_contents(); // assign buffer contents to variable
        ob_end_clean(); // end buffer and remove buffer contents
        

        $bcicteam = "manish@bcic.com.au";

        //$bcicteam = "pankaj.business2sell@gmail.com";
        $subject = $getstaffdetails['name'] . " Invoice From " . changeDateFormate($from_date, 'datetime') . " To " . changeDateFormate($todate, 'datetime') . "";

        sendmailbcic($subject, $bcicteam, $subject, $content, 'hr@bcic.com.au', "0");

        unset($content);

        unset($staff_id);

    }

    echo 'Invoive email send successfully';

}

function send_invoice_email($id)
{

    $getbcicinvoice = mysql_fetch_array(mysql_query("SELECT * FROM `bcic_invoice` WHERE id = " . $id . ""));

    $staff_id = $getbcicinvoice['staff_id'];

    $from_date = $getbcicinvoice['invoice_from_date'];

    $todate = $getbcicinvoice['invoice_to_date'];

    $invoice_number = $getbcicinvoice['invoice_number'];

    $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $staff_id . ""));

    // print_r($getstaffdetails); die;
    

    if ($getstaffdetails != '')
    {

        $desc = '';

        $thead = '';

        $totalamount = 0;

        $totalamount_profit = 0;

        $totalamount_staff_share = 0;

        $totalamount_bbcreyal = 0;

        $totalamount_bbcmagan = 0;

        $totalamount_refferalfee = 0;

        $stafftype = $getstaffdetails['better_franchisee'];

        $other_types = mysql_query("SELECT * FROM `staff_journal_new` WHERE staff_id=" . $staff_id . " and journal_date>='" . $from_date . "' and journal_date<='" . $todate . "' and job_id != 0 and staff_share > 0 order by job_date");

        //echo $other_types;
        $flag = false;

        if (mysql_num_rows($other_types) > 0)
        {

            $flag = true;

            $i = 1;

            while ($r = mysql_fetch_assoc($other_types))
            {

                //echo '<pre>'; print_r($r);
                

                if ($i % 2 == 0)
                {
                    $color = 'background:#f1f1f1 ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;';
                }
                else
                {
                    $color = 'background:#FFF ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;';
                }

                $i++;

                if ($stafftype == 2)
                {

                    $bbcreyal = $r['bcic_share'] / 10;

                    $bbcmagan = ($r['bcic_share'] - $bbcreyal) * 60 / 100;

                    $refferalfee = ($r['bcic_share'] - ($bbcmagan + $bbcreyal));

                    $desc .= '<tr>

										   <td  style="' . $color . '">' . $r['job_id'] . '</td>

										   

										   <td  style="' . $color . '">' . $r['comments'] . '</td>

										   

										   <td  style="' . $color . '">$' . number_format(($r['total_amount']) , 2) . '</td>

										   

										   <td  style="' . $color . '">$' . number_format($r['staff_share'], 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($bbcreyal, 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($bbcmagan, 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($refferalfee, 2) . '</td>

										   

										</tr>';

                    $totalamount = ($totalamount + $r['total_amount']);

                    $totalamount_staff_share = ($totalamount_staff_share + $r['staff_share']);

                    $totalamount_bbcreyal = ($totalamount_bbcreyal + $bbcreyal);

                    $totalamount_bbcmagan = ($totalamount_bbcmagan + $bbcmagan);

                    $totalamount_refferalfee = ($totalamount_refferalfee + $refferalfee);

                    $totalamount_profit = ($totalamount_profit + $r['bcic_share']);

                }
                else
                {

                    $desc .= '<tr>

										   <td  style="' . $color . '">' . $r['job_id'] . '</td>

										   

										   <td  style="' . $color . '">' . $r['comments'] . '</td>

										   

										   <td  style="' . $color . '">$' . number_format(($r['total_amount']) , 2) . '</td>

										   

										   <td  style="' . $color . '">$' . number_format($r['staff_share'], 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($r['bcic_share'], 2) . '</td>

										   

										</tr>';

                    $totalamount = ($totalamount + $r['total_amount']);

                    $totalamount_staff_share = ($totalamount_staff_share + $r['staff_share']);

                    $totalamount_profit = ($totalamount_profit + $r['bcic_share']);

                }

            }

        }
        else
        {

            $flag = false;

            $desc .= '<tr>

										   <td colspan="4" style="background:#f1f1f1 ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;">No Records Found</td>

							</tr>';

        }

        //$quotetypedetails = mysql_fetch_array(mysql_query("select * from quote_for_option where type ='1'"));
        $quotetypedetails = mysql_fetch_array(mysql_query("select * from quote_for_option where id =" . $stafftype . ""));

        $invoice_status = "<strong>Paid</strong>";

        $site_url = get_rs_value("siteprefs", "site_url", 1);

        // $company_logo = $site_url.$quotetypedetails['logo_name'];
        

        $company_logo = $site_url . $quotetypedetails['logo_name'];

        $company_name = $quotetypedetails['company_name_member_sites'];

        $abn_number = $quotetypedetails['abn_number'];

        $qu_phone = $quotetypedetails['phone'];

        $html2 = '<body><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px; color:#354046; font-weight:normal;font-family: sans-serif;border: 1px solid #e0d1d1;">

						  <tbody>

							<tr>

							  

							    <td align="left" style="padding: 13px;" height="80">

									 <table>

									  <tr>

									  <td style="width:70%">

									

									<div style="text-align: left;">

									 

									

									

									<span class="font-red" style="font-weight:bold;">' . $company_name . '</span><br>



									<span class="font-red" style="font-weight:bold;">ABN:' . $abn_number . '</span>

									<br>

									<span class="font-red" style="font-weight:bold;">' . $qu_phone . '</span><br>

									</div></td>

							  

							  

							   <td align="right" style="width:30%"><img  src=' . $company_logo . ' width="223" alt="Site Logo" ></td>

							  </tr></table></td>

							</tr>

							<tr>

							  <td align="right"><table width="285" border="0" cellspacing="0" cellpadding="0">

						  <tbody>



						  </tbody>

						</table>

						</td>

							</tr>

							 <tr>

								  <td valign="top" style="border:1px solid #dcd9d9;background: #f7f7f5;"><table style="padding-left: 15px;" width="100%" border="0" cellspacing="0" cellpadding="0">

							  <tbody>

								<tr>

								  <td><table width="300" border="0" cellspacing="0" cellpadding="0">

							  <tbody>

								<tr>

								  <td></td>

								</tr>

								<tr>

								  <td>

									<span style="font-weight:bold;">To </span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['name'] . ' </span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['mobile'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ABN ' . $getstaffdetails['abn'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['company_name'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['address'] . '</span><br>

							

							</td>

								</tr>

							  </tbody>

							</table>

							</td>

							  

							  <td valign="top"><table  border="0" cellspacing="0" cellpadding="0">

						  <tbody>

							<tr>

							  <td>

							  <table width="500" border="0" cellspacing="0" cellpadding="0" >

						  <tbody>

							<tr>

							   <td colspan="2" class="font-bold" height="10" style="font-size: 16px;background: #f1f1f1;font-weight:bold;padding: 7px;">Invoice Details</td>

							  

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">Invoice Number</td>

							  <td style="padding: 10px;background: #FFF;border:1px solid #DDD;">' . $invoice_number . '</td>

							</tr>

							<tr> 

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:140px;border-bottom:1px solid #FFF;">From Date</td>

							  <td style="padding: 10px;background: #FFF;border:1px solid #DDD;">' . changeDateFormate($from_date, 'datetime') . '</td>

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:140px;border-bottom:1px solid #FFF;">To Date</td>

							  <td style="padding: 10px;background: #FFF;border:1px solid #DDD; ">' . changeDateFormate($todate, 'datetime') . '</td>

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:140px;border-bottom:1px solid #FFF;">Invoice Status</td>

							  <td style="padding: 10px;background: #FFF;border:1px solid #DDD;">' . $invoice_status . '</td>

							</tr>

							

						  </tbody>

						</table></td>

							</tr>

							

						  </tbody>

						</table>



						</td>

							</tr>

						  </tbody>

						</table>

						</td>

							</tr>

							 <tr>

							  <td Style="padding-top:20px; " ><table width="100%" border="0"  cellspacing="0" cellpadding="0"  style="background-color:#f5f5f3; ">

						  <tbody>

							<tr>

							  <td colspan="5" height="20" class="font-bold" align="left" style="color:#00b8d4;font-weight:bold;text-transform:uppercase;background:#FFF;">Job Details</td>

							 

							

							</tr>';

        if ($stafftype == 2)
        {

            $html2 .= '<tr>

										  <td  style="background:#FFF;padding:8px;"><strong>Job ID</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Job Type</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Total Amount</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Franchisee Share</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BBC Royalty</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Managment Fee</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Referral Fee</strong></td>

							            </tr>';

        }
        else
        {

            $html2 .= '<tr>

										  <td  style="background:#FFF;padding:8px;"><strong>Job ID</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Job Type</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Total Amount</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Staff Share</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Share</strong></td>

							            </tr>';

        }

        $html2 .= $desc;

        if ($flag == true)
        {

            if ($stafftype == 2)
            {

                $html2 .= '<tr>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"></td>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>Total</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount) , 2) . '</strong></td>

									   <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_staff_share) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_bbcreyal) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_bbcmagan) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_refferalfee) , 2) . '</strong></td>

									</tr>';

            }
            else
            {

                $html2 .= '<tr>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"></td>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>Total</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_staff_share) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_profit) , 2) . '</strong></td>

									</tr>';

            }

        }

        $html2 .= '<tr>

							  <td></td>

							  <td></td>

							  <td></td>

							</tr>

						  </tbody>

						</table>

						</td>

							</tr>

						</table></body>';

    }

    //echo $html2; die;
    return $html2;

}

function getStaffInvoice_message($var)

{

    $getbcicinvoice = mysql_fetch_array(mysql_query("SELECT * FROM `bcic_invoice` WHERE id = " . $var . ""));

    //print_r($getbcicinvoice);
    

    require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

    //echo 'dsdsdsd'; die;
    

    $dompdf = new Dompdf();

    $dompdf->set_paper(array(
        0,
        0,
        794,
        1123
    ) , 'portrait');

    $html2 = base64_decode($getbcicinvoice['email']);

    $dompdf->load_html($html2);

    $dompdf->load_html(utf8_decode($html2) , 'UTF-8');

    $dompdf->render();

    $folder = $_SERVER['DOCUMENT_ROOT'] . '/bcic_staff_invoice/';

    $foldername = $folder . $getbcicinvoice['staff_id'];

    $filename = $getbcicinvoice['date_name'] . '_' . $getbcicinvoice['year'] . '_invoice';

    $name = $filename . '.pdf';

    $filePath = $foldername . '/' . $name;

    //echo  $filePath; die;
    

    file_put_contents($filePath, $dompdf->output());

    $message = send_invoice_email($var);

    $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $getbcicinvoice['staff_id'] . ""));

    //$sendto_email = 'pankaj@business2sell.com.au';
    //$sendto_email = 'ashish@business2sell.com.au';
    $sendto_email = $getstaffdetails['email'];

    // $sendto_email = 'manish@bcic.com.au';
    // $sendto_email = 'pankaj.business2sell@gmail.com';
    $subject = $getstaffdetails['name'] . ' Invoice From ' . changeDateFormate($getbcicinvoice['invoice_from_date'], 'datetime') . ' To ' . changeDateFormate($getbcicinvoice['invoice_to_date'], 'datetime');

    mysql_query("UPDATE `bcic_invoice` SET `invoice_send_date` = '" . date('Y-m-d H:i:s') . "' , `is_send` = '1'   WHERE `bcic_invoice`.`id` = " . $var . "");

    sendmailwithattach_staff_invoce1($getstaffdetails['name'], $sendto_email, $subject, $message, 'noreply@bcic.com.au', $filePath, $filename);

    echo 'Invoice send successfully';

}

function franchiseGenerationInPdf_forStaff($staff_ids, $from_date, $todate, $datefolder)

{

    /*  error_reporting(E_ALL);
    
    ini_set('display_errors', TRUE); */

    $totalinvoice = 1000;

    $getinvoice = mysql_fetch_assoc(mysql_query("SELECT invoice_number FROM `franchise_report` ORDER by id DESC LIMIT 0 ,1"));

    if ($getinvoice['invoice_number'] != '')
    {

        $totalinvoice = $getinvoice['invoice_number'] + 1;

    }
    else
    {

        $totalinvoice = $totalinvoice + 1;

    }

    // $staffid = explode(',' ,$staff_ids);
    $eol = "<br/>";

    $content = '';

    $staff_id = $staff_ids;

    //foreach($staffid as $staff_id) {
    

    //$dompdf = new Dompdf();
    $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $staff_id . " AND status = 1"));

    $html2 = '';

    if ($getstaffdetails != '')
    {

        $totaloffered = getTotalBBCDetails($staff_id, $from_date, $todate, 5);

        $totaldeny = getTotalBBCDetails($staff_id, $from_date, $todate, 2);

        $totalofferedamount = getTotalBBCAmountDetails($staff_id, $from_date, $todate, 5);

        $totaldenyamount = getTotalBBCAmountDetails($staff_id, $from_date, $todate, 2);

        $notAvil = getStaffRosterDetails($from_date, $staff_id, 0);

        $staffshareamt = getTotaljobshareAmount($staff_id, $from_date, $todate);

        $checkAvail = CheckAvailORnNOT($from_date, $todate, $staff_id);

        $recleanJob = getrecleanRecords($staff_id, $from_date, $todate, 0);

        $reviewdetails = getReviewRecords($staff_id, $from_date, $todate);

        //return array('jobreclean'=>$jobreclean, 'pecentrecl'=>$pecentrecl);
        

        //https://www.beta.bcic.com.au/admin/images/bbc_logo.png
        $site_url = get_rs_value("siteprefs", "site_url", 1);

        $sitelogo = $site_url . '/admin/images/bbc_logo.png';

        $file = "franchise_report.php";

        ob_start(); // start buffer
        include ($_SERVER['DOCUMENT_ROOT'] . "/admin/report/" . $file);
        $content = ob_get_contents(); // assign buffer contents to variable
        ob_end_clean(); // end buffer and remove buffer contents
        
/*         ob_start(); // start buffer
		$filename = "franchise_data.php";
        include ($_SERVER['DOCUMENT_ROOT'] . "/admin/report/" . $filename);
        $content_1 = ob_get_contents(); // assign buffer contents to variable
		ob_end_clean(); // end buffer and remove buffer contents */
		
		$content_1 = $totaloffered.'__'.$recleanJob['totaljobdone'].'__'.number_format($staffshareamt , 2).'__'.$totaldeny.'__'.number_format($totaldenyamount['totalamount'] ,2).'__'.$notAvil.'__'.$checkAvail['notavail'].'__'.$recleanJob['jobreclean'].'__'.$recleanJob['pecentrecl'].'__'.$recleanJob['tofailed_re'].'__'.$recleanJob['tillrecleantilldate'];
		
        
        require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

        $html2 = ($content);

        $dompdf = new Dompdf();

        $dompdf->set_paper(array(
            0,
            0,
            794,
            1123
        ) , 'portrait');

        $dompdf->load_html($html2);

        $dompdf->load_html(utf8_decode($html2) , 'UTF-8');

        $dompdf->render();

        //print_r($html2);  die;
        

        $folder = $_SERVER['DOCUMENT_ROOT'] . '/franchise_report/';

        $foldername = $folder . $staff_id;

        $filename = strtolower(date('F', strtotime($from_date))) . '_' . date('Y', strtotime($from_date)) . '_bbc_report';

        $name = $filename . '.pdf';

        $filePath = $foldername . '/' . $name; 

        file_put_contents($filePath, $dompdf->output());

        $checkInvoice = mysql_query("SELECT * FROM `franchise_report` WHERE staff_id = " . $staff_id . " AND date_name='" . strtolower(date('F', strtotime($from_date))) . "' AND year='" . date('Y', strtotime($from_date)) . "'");

        if (mysql_num_rows($checkInvoice) == 0)
        {

            mysql_query("INSERT INTO `franchise_report` (`email`, `staff_id`, `invoice_number`,  `invoice_from_date`, `invoice_to_date` , `date_name` , `year`,  `report_details`) VALUES ('" . base64_encode($content) . "', '" . $staff_id . "','" . $totalinvoice . "', '" . $from_date . "' , '" . $todate . "' , '" . strtolower(date('F', strtotime($from_date))) . "' , '" . date('Y', strtotime($from_date)) . "',  '" . base64_encode($content_1) . "');");

        }
      
	    // echo $content_1;
	  
    }

}

function getTotalBBCDetails($staff_id, $from_date, $todate, $type)

{

    $Sql = mysql_query("SELECT id FROM `job_details` WHERE status != 2 AND job_date >= '" . $from_date . "' AND job_date <= '" . $todate . "' AND job_id in (SELECT job_id FROM `staff_jobs_status` WHERE `staff_id` = " . $staff_id . " AND status = " . $type . ") GROUP by job_id ");

    if (mysql_num_rows($Sql) > 0)
    {

        return mysql_num_rows($Sql);

    }
    else
    {

        return 0;

    }

}

function getTotaljobshareAmount($staff_id, $from_date, $todate)
{

    $totaltilljob = mysql_query("SELECT sum(amount_staff) as amountstaff FROM `job_details` WHERE job_date >= '" . $from_date . "' AND job_date <= '" . $todate . "' and staff_id = " . $staff_id . " and (end_time != '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status = 3))");

    $data = mysql_fetch_assoc($totaltilljob);

    return $data['amountstaff'];

}

function getReviewRecords($staff_id, $from_date, $todate)

{

    $totaltilljob = mysql_query("SELECT  GROUP_CONCAT(job_id) as jobids  FROM `job_details` WHERE  staff_id = " . $staff_id . "  and job_id in (SELECT job_id FROM `bcic_review` WHERE review_date >=  '" . $from_date . "' and review_date <= '" . $todate . "')");

    /* $totaltilljob = mysql_query("SELECT GROUP_CONCAT(job_id) as jobids FROM `job_details` WHERE job_date >= '".$from_date."' AND job_date <= '".$todate."' and staff_id = ".$staff_id." and (end_time != '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status = 3))"); */

    $data = mysql_fetch_assoc($totaltilljob);

    $jobids = $data['jobids'];

    $alldata = array();

    if ($jobids != '')
    {

        //echo  "SELECT * FROM `bcic_review`  WHERE job_id in  (".$jobids.")";
        

        $sql2 = mysql_query("SELECT * FROM `bcic_review`  WHERE job_id in (" . $jobids . ")");

        // return  'sdsds'. mysql_num_rows($sql2);
        

        while ($getdata = mysql_fetch_array($sql2))
        {

            $alldata[] = array(

                'job_id' => $getdata['job_id'],

                'positive_comment' => $getdata['positive_comment'],

                'negative_comment' => $getdata['negative_comment'],

                'overall_experience' => $getdata['overall_experience'],

                'review_date' => $getdata['review_date']

            );

        }

    }

    return $alldata;

}

function getrecleanRecords($staff_id, $from_date, $todate, $type)

{

    $tofailed_re = 0;

    $jobreclean = 0;

    $pecentrecl = 0;

    $totaltilljob = 0;

    $tillrecleantilldate = 0;

    $totaljobs = 0;

    $totaltillrecleanjob = 0;

    $totaljobstill = 0;

    /* ===================================================== */

    $Sql = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = " . $staff_id . " and reclean_date>='" . $from_date . "' AND reclean_date <='" . $todate . "'  and status != 2 group by job_id");

    // $Sql = mysql_query("SELECT * FROM `job_details` WHERE job_date >= '".$from_date."' and job_date <= '".$todate."' AND staff_id = ".$staff_id." and status != 2  and reclean_job = 2 and job_id in (SELECT job_id FROM job_reclean WHERE staff_id = ".$staff_id.") GROUP by job_id");
    

    if (mysql_num_rows($Sql) > 0)
    {

        $jobreclean = mysql_num_rows($Sql);

    }

    $Sql1 = mysql_query(" SELECT * FROM `job_details` WHERE job_date >= '" . $from_date . "' AND job_date <= '" . $todate . "' and staff_id = " . $staff_id . " and (end_time != '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status = 3)) GROUP by job_id ");

    if (mysql_num_rows($Sql1) > 0)
    {

        $totaljobs = mysql_num_rows($Sql1);

        $pecentrecl = ($jobreclean / $totaljobs) * 100;

    }

    /* ========================================================== */

    $failed_re = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = " . $staff_id . " and reclean_date>='" . $from_date . "' AND reclean_date <='" . $todate . "'  and status != 2 AND reclean_work = 2 group by job_id");

    // $failed_re = mysql_query("SELECT * FROM `job_details` WHERE job_date >= '".$from_date."' and job_date <= '".$todate."' AND staff_id = ".$staff_id." and status != 2  and reclean_job = 2 and job_id in (SELECT job_id FROM job_reclean WHERE reclean_work = 2 AND staff_id = ".$staff_id.") GROUP by job_id");
    

    if (mysql_num_rows($failed_re) > 0)
    {

        $tofailed_re = mysql_num_rows($failed_re);

    }

    /* =================================================================== */

    $totaltilljob = mysql_query("SELECT * FROM `job_details` WHERE job_date >= '" . date('Y-01-01') . "'  AND status != 2  AND job_date <= '" . $todate . "' AND staff_id = " . $staff_id . " AND (end_time != '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status = 3)) GROUP by job_id");

    if (mysql_num_rows($totaltilljob) > 0)
    {

        $totaljobstill = mysql_num_rows($totaltilljob);

    }

    $ytd_reclean = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = " . $staff_id . " and reclean_date>='" . date('Y-01-01') . "' AND reclean_date <='" . $todate . "'  and status != 2 group by job_id");

    //$ytd_reclean = mysql_query("SELECT * FROM `job_details` WHERE job_date >= '".date('Y-01-01')."' and job_date <= '".$todate."' AND staff_id = ".$staff_id." and status != 2  and reclean_job = 2 and job_id in (SELECT job_id FROM job_reclean WHERE staff_id = ".$staff_id.") GROUP by job_id");
    

    if (mysql_num_rows($ytd_reclean) > 0)
    {

        $totaltillrecleanjob = mysql_num_rows($ytd_reclean);

        $tillrecleantilldate = ($totaltillrecleanjob / $totaljobstill) * 100;

    }

    /* ========================================================================== */

    return array(
        'jobreclean' => $jobreclean,
        'pecentrecl' => number_format($pecentrecl, 2) ,
        'tofailed_re' => $tofailed_re,
        'tillrecleantilldate' => number_format($tillrecleantilldate, 2) ,
        'totaljobdone' => $totaljobs
    );

}

function getStaffRosterDetails($getdate, $staffid, $status, $todate = null)

{

    $formdate = date('Y-m-01', strtotime($getdate));

    if ($todate == '' && $todate == null)
    {

        $todate = date('Y-m-31', strtotime($getdate));

    }

    $sql = mysql_query("SELECT count(id) as totalid FROM `staff_roster` WHERE  staff_id = " . $staffid . " AND status = " . $status . " AND date >= '" . $formdate . "' AND date <= '" . $todate . "'");

    $data = mysql_fetch_assoc($sql);

    return $data['totalid'];

}

function CheckAvailORnNOT($from_date, $todate, $staffid)
{

    $formdate = date('Y-01-01');

    $todate1 = date('Y-m-31', strtotime($todate));

    $sql = mysql_query("SELECT id ,status  FROM `staff_roster` WHERE  staff_id = " . $staffid . " AND  date >= '" . $formdate . "' AND date <= '" . $todate1 . "'");

    $avail = 0;

    $notavail = 0;

    while ($data = mysql_fetch_assoc($sql))
    {

        if ($data['status'] > 0 && $data['status'] == 1)
        {

            $avail++;

        }

        if ($data['status'] == 0)
        {

            $notavail++;

        }

    }

    return array(
        'avail' => $avail,
        'notavail' => $notavail
    );

}

function getTotalBBCAmountDetails($staff_id, $from_date, $todate, $type)
{

    //SELECT SUM(amount_total) as at , sum(amount_staff) as ast FROM `job_details` WHERE status != 2 AND job_date >= '2019-06-01' AND job_date <= '2019-06-31' AND job_id in (SELECT job_id FROM `staff_jobs_status` WHERE `staff_id` = 249 AND status = 2)
    

    $Sql = mysql_query("SELECT SUM(amount_total) as totalamount , sum(amount_staff) as totalstaff FROM `job_details` WHERE status != 2 AND job_date >= '" . $from_date . "' AND job_date <= '" . $todate . "' AND job_id in (SELECT job_id FROM `staff_jobs_status` WHERE `staff_id` = " . $staff_id . " AND status = " . $type . ") ");

    if (mysql_num_rows($Sql) > 0)
    {

        $getdata['totalamount'] = 0;

        $getdata['totalstaff'] = 0;

        $getdata = mysql_fetch_array($Sql);

    }

    return array(
        'totalamount' => $getdata['totalamount'],
        'totalstaff' => $getdata['totalstaff']
    );

}

function invoiceGenerationInPdf_forStaff($staff_ids, $from_date, $todate, $datefolder)

{

    $totalinvoice = 1000;

    $getinvoice = mysql_fetch_assoc(mysql_query("SELECT invoice_number FROM `bcic_invoice` ORDER by id DESC LIMIT 0 ,1"));

    if ($getinvoice['invoice_number'] != '')
    {

        $totalinvoice = $getinvoice['invoice_number'] + 1;

    }
    else
    {

        $totalinvoice = $totalinvoice + 1;

    }

    // $staffid = explode(',' ,$staff_ids);
    $eol = "<br/>";

    $content = '';

    $staff_id = $staff_ids;

    //foreach($staffid as $staff_id) {
    

    require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

    $dompdf = new Dompdf();

    $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $staff_id . " AND status = 1"));

    if ($getstaffdetails != '')
    {

        $desc = '';

        $thead = '';

        $totalamount = 0;

        $totalamount_profit = 0;

        $totalamount_staff_share = 0;

        $totalamount_bbcreyal = 0;

        $totalamount_bbcmagan = 0;

        $totalamount_refferalfee = 0;

        $stafftype = $getstaffdetails['better_franchisee'];

        /*  echo "SELECT * FROM `staff_journal_new` WHERE staff_id=".$staff_id." and journal_date>='".$from_date."' and journal_date<='".$todate."' and job_id != 0 and staff_share > 0 order by job_date";
        
        
        
        echo "<br/><br/><br/>";  */

        $other_types = mysql_query("SELECT * FROM `staff_journal_new` WHERE staff_id=" . $staff_id . " and journal_date>='" . $from_date . "' and journal_date<='" . $todate . "' and job_id != 0 and staff_share > 0 order by job_date");

        //echo $other_types;
        $flag = false;

        if (mysql_num_rows($other_types) > 0)
        {

            $flag = true;

            $i = 1;

            while ($r = mysql_fetch_assoc($other_types))
            {

                if ($i % 2 == 0)
                {
                    $color = 'background:#f1f1f1 ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;';
                }
                else
                {
                    $color = 'background:#FFF ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;';
                }

                $i++;

                if ($stafftype == 2)
                {

                    $bbcreyal = $r['total_amount'] / 10;

                    $bbcmagan = ($r['bcic_share'] - $bbcreyal) * 60 / 100;

                    $refferalfee = ($r['bcic_share'] - ($bbcmagan + $bbcreyal));

                    $desc .= '<tr>

										   <td  style="' . $color . '">' . $r['job_id'] . '</td>

										   

										   <td  style="' . $color . '">' . $r['comments'] . '</td>

										   

										   <td  style="' . $color . '">$' . number_format(($r['total_amount']) , 2) . '</td>

										   

										   <td  style="' . $color . '">$' . number_format($r['staff_share'], 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($bbcreyal, 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($bbcmagan, 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($refferalfee, 2) . '</td>

										   

										</tr>';

                    $totalamount = ($totalamount + $r['total_amount']);

                    $totalamount_staff_share = ($totalamount_staff_share + $r['staff_share']);

                    $totalamount_bbcreyal = ($totalamount_bbcreyal + $bbcreyal);

                    $totalamount_bbcmagan = ($totalamount_bbcmagan + $bbcmagan);

                    $totalamount_refferalfee = ($totalamount_refferalfee + $refferalfee);

                    $totalamount_profit = ($totalamount_profit + $r['bcic_share']);

                }
                else
                {

                    $desc .= '<tr>

										   <td  style="' . $color . '">' . $r['job_id'] . '</td>

										   

										   <td  style="' . $color . '">' . $r['comments'] . '</td>

										   

										   <td  style="' . $color . '">$' . number_format(($r['total_amount']) , 2) . '</td>

										   

										   <td  style="' . $color . '">$' . number_format($r['staff_share'], 2) . '</td>

										   <td  style="' . $color . '">$' . number_format($r['bcic_share'], 2) . '</td>

										   

										</tr>';

                    $totalamount = ($totalamount + $r['total_amount']);

                    $totalamount_staff_share = ($totalamount_staff_share + $r['staff_share']);

                    $totalamount_profit = ($totalamount_profit + $r['bcic_share']);

                }

            }

        }
        else
        {

            $flag = false;

            $desc .= '<tr>

										   <td colspan="5" style="background:#f1f1f1 ;padding-top: 5px;padding-bottom: 5px;padding-left:10px; font-weight:300;font-size: 16px;">No Records Found</td>

							</tr>';

        }

        /* echo  $desc;
        
        echo "<br/><br/><br/>"; */

        $quotetypedetails = mysql_fetch_array(mysql_query("select * from quote_for_option where id =" . $stafftype . ""));

        $invoice_status = "<strong>Paid</strong>";

        //$company_logo = $_SERVER['DOCUMENT_ROOT'] .$quotetypedetails['logo_name'];
        

        $dompdf->set_paper(array(
            0,
            0,
            794,
            1123
        ) , 'portrait');

        $site_url = get_rs_value("siteprefs", "site_url", 1);

        $company_logo = $site_url . $quotetypedetails['logo_name'];

        $company_name = $quotetypedetails['company_name_member_sites'];

        $abn_number = $quotetypedetails['abn_number'];

        $qu_phone = $quotetypedetails['phone'];

        $html2 = '<body>

					<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px; color:#354046; font-weight:normal;font-family: sans-serif;border: 1px solid #e0d1d1;">

						  <tbody>

							<tr>

							  

							    <td align="left" style="padding: 13px;" height="80">

									 <table>

									  <tr>

									  <td style="width:600px"  width="600">

									

									<div style="text-align: left;">

									 

									

									

									<span class="font-red" style="font-weight:bold;">' . $company_name . '</span><br>



									<span class="font-red" style="font-weight:bold;">ABN:' . $abn_number . '</span>

									<br>

									<span class="font-red" style="font-weight:bold;">' . $qu_phone . '</span><br>

									</div></td>

							  

							  

							    <td align="center" width="200" style="width:200px;"><img align="right" style="text-align:right;" src=' . $company_logo . ' width="200" alt="Site Logo" ></td>

							  </tr></table></td>

							</tr>

							<tr>

							  <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">

						  <tbody>



						  </tbody>

						</table>

						</td>

							</tr>

							 <tr>

								 <td valign="top" style="border:1px solid #dcd9d9;background: #f7f7f5;">

								  <table style="padding-left: 15px;" width="100%" border="0" cellspacing="0" cellpadding="0">

							  <tbody>

								<tr>

								  <td><table width="200" style="width:200px;" border="0" cellspacing="0" cellpadding="0">

							  <tbody>

								<tr>

								  <td></td>

								</tr>

								<tr>

								  <td>

									<span style="font-weight:bold;">To </span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['name'] . ' </span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['mobile'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ABN ' . $getstaffdetails['abn'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['company_name'] . '</span><br>

									<span style="font-weight:bold;white-space: pre-line;"> ' . $getstaffdetails['address'] . '</span><br>

							

							</td>

								</tr>

							  </tbody>

							</table>

							</td>

							  

							  <td valign="top" width="400" style="width:400px;"><table  border="0" cellspacing="0" cellpadding="0">

						  <tbody>

							<tr>

							  <td>

							  <table  border="0" cellspacing="0" cellpadding="0" >

						  <tbody>

							<tr>

							   <td colspan="2" class="font-bold" height="10" style="font-size: 16px;background: #f1f1f1;font-weight:bold;padding: 7px;">Invoice Details</td>

							  

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">Invoice Number</td>

							  <td style="padding: 10px;background: #FFF;width:260px;border:1px solid #DDD;">' . $totalinvoice . '</td>

							</tr>

							<tr> 

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;border-bottom:1px solid #FFF;">From Date</td>

							  <td style="padding: 10px;background: #FFF;width:260px;border:1px solid #DDD;">' . changeDateFormate($from_date, 'datetime') . '</td>

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:140px;border-bottom:1px solid #FFF;">To Date</td>

							  <td style="padding: 10px;background: #FFF;width:260px;border:1px solid #DDD; ">' . changeDateFormate($todate, 'datetime') . '</td>

							</tr>

							<tr>

							  <td style="padding: 10px;background: #00b8d4;color: #FFF;width:140px;border-bottom:1px solid #FFF;">Invoice Status</td>

							  <td style="padding: 10px;background: #FFF;width:260px;border:1px solid #DDD;">' . $invoice_status . '</td>

							</tr>

							

						  </tbody>

						</table></td>

							</tr>

							

						  </tbody>

						</table>



						</td>

							</tr>

						  </tbody>

						</table>

						</td>

							</tr>

							 <tr>

							  <td Style="padding-top:20px; " ><table width="100%" border="0"  cellspacing="0" cellpadding="0"  style="background-color:#f5f5f3; ">

						  <tbody>

							<tr>

							  <td colspan="5" height="20" class="font-bold" align="left" style="color:#00b8d4;font-weight:bold;text-transform:uppercase;background:#FFF;">Job Details</td>

							 

							

							</tr>';

        if ($stafftype == 2)
        {

            $html2 .= '<tr>

										  <td  style="background:#FFF;padding:8px;"><strong>Job ID</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Job Type</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Total Amount</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Franchisee Share</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BBC Royalty</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Managment Fee</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Referral Fee</strong></td>

							            </tr>';

        }
        else
        {

            $html2 .= '<tr>

										  <td  style="background:#FFF;padding:8px;"><strong>Job ID</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Job Type</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Total Amount</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>Staff Share</strong></td>

										  <td  style="background:#FFF;padding:8px;"><strong>BCIC Share</strong></td>

							            </tr>';

        }

        $html2 .= $desc;

        if ($flag == true)
        {

            if ($stafftype == 2)
            {

                $html2 .= '<tr>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"></td>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>Total</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount) , 2) . '</strong></td>

									   <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_staff_share) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_bbcreyal) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_bbcmagan) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_refferalfee) , 2) . '</strong></td>

									</tr>';

            }
            else
            {

                $html2 .= '<tr>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"></td>

									  <td  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>Total</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_staff_share) , 2) . '</strong></td>

									  <td class="font-red"  style="background:#FFF;padding:10px;border-top:1px solid #DDD;"><strong>$' . number_format(($totalamount_profit) , 2) . '</strong></td>

									</tr>';

            }

        }

        $html2 .= '<tr>

							  <td></td>

							  <td></td>

							  <td></td>

							</tr>

						  </tbody>

						</table>

						</td>

							</tr>

						</table></body>';

        /* echo $staff_id;
        
        echo $html2;
        
        echo "<br/><br/><br/>"; */

        if ($totalamount > 0)
        {

            $checkInvoice = mysql_query("SELECT * FROM `bcic_invoice` WHERE staff_id = " . $staff_id . " AND date_name='" . strtolower(date('F', strtotime($from_date))) . "' AND year='" . date('Y', strtotime($from_date)) . "'");

            if (mysql_num_rows($checkInvoice) == 0)
            {

                mysql_query("INSERT INTO `bcic_invoice` (`email`, `staff_id`, `invoice_number`,  `invoice_from_date`, `invoice_to_date` , `date_name` , `year`) VALUES ('" . base64_encode($html2) . "', '" . $staff_id . "','" . $totalinvoice . "', '" . $from_date . "' , '" . $todate . "' , '" . strtolower(date('F', strtotime($from_date))) . "' , '" . date('Y', strtotime($from_date)) . "');");

            }

        }

        unset($html2);

        unset($staff_id);

    }
    else
    {

        return error("Found issue while creating this Quote Please contact ADMIN");

    }

    //}
    //echo 'Invoive email send successfully';
    //echo "Hello ji done"; exit;
    
}

function sendmailwithattach_staff_invoce1($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $filepath, $filename)

{

    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    //	echo $sendto; die;
    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

	<HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>

	<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

	</HEAD>

	<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

	<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

	  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

	  <p>

	<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at team@bcic.com.au <br><br>

	Kind Regards</font>

	</p>

	  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

	  BCIC Team<br>

	  <a href=\"" . $site['site_domain'] . "\"><img src=\"" . $site['site_url'] . $site['logo'] . "\" /></a><br>

		p: 1300 599 644<br>

		e: team@bcic.com.au<br>

	  w: " . $site['site_domain'] . "</font></P>

	";

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

	This email and any attachments may contain information that is confidential and subject to legal privilege. 

	If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

	If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

	<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 

	for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

	The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.

	  </font> </P>

	  </td>

	  </tr>

	  </table>

	</BODY></HTML>

	";

    //$filename = 'invoice_Q'.$quote_id.'.pdf';
    //$fileatt = $_SERVER['DOCUMENT_ROOT']."/admin/invoice/".$filename;
    $fileatt = $filepath;

    $fileatt_type = "application/pdf";

    $email_from = $replyto;

    $email_to = $sendto_email; //$e;
    $headers = "From: <" . $email_from . "> \r\n";

    $headers .= "Reply-To: " . $email_from;

    $file = fopen($fileatt, 'rb');

    $data = fread($file, filesize($fileatt));

    fclose($file);

    $semi_rand = md5(time());

    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .

    "Content-Type: multipart/mixed;\n" .

    " boundary=\"{$mime_boundary}\"";

    $email_message .= "This is a multi-part message in MIME format.\n\n" .

    "--{$mime_boundary}\n" .

    "Content-Type:text/html; charset=\"iso-8859-1\"\n" .

    "Content-Transfer-Encoding: 7bit\n\n" .

    $email_message .= "\n\n";

    $data = chunk_split(base64_encode($data));

    $email_message .= "--{$mime_boundary}\n" .

    "Content-Type: {$fileatt_type};\n" .

    " name=\"{$filename}\"\n" .

    "Content-Transfer-Encoding: base64\n\n" .

    $data .= "\n\n" . "--{$mime_boundary}--\n";

    //echo $mime_boundary; die;
    

    //echo $email_message;  die;
    ini_set('sendmail_from', $replyto);

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
}

function geerateInvoicePDF($var)
{

    $vars = explode('|', $var);

    $fromdate = explode('-', $vars[0]);

    $to_date = explode('-', $vars[1]);

    //echo $fromdate[1].'<'.$to_date[1]; die;
    

    $sql = mysql_query("SELECT DISTINCT(staff_id) as staffid FROM `staff_journal_new` WHERE  job_id > 0");

    if (mysql_num_rows($sql) > 0)

    {

        while ($data = mysql_fetch_assoc($sql))

        {

            $folder = $_SERVER['DOCUMENT_ROOT'] . '/bcic_staff_invoice/';

            $foldername = $folder . $data['staffid'];

            if (!file_exists($foldername))
            {

                mkdir($foldername, 0777, true);

            }

            for ($i = $fromdate[1];$i <= $to_date[1];$i++)

            {

                $dateformatestart = date('Y-m-01', strtotime(date($fromdate[0] . '-' . $i)));

                $dateformateto = date('Y-m-t', strtotime(date($fromdate[0] . '-' . $i)));

                // echo '<br/>';
                $datefolder = $foldername;

                // echo $dateformatestart .''.$dateformateto;
                

                invoiceGenerationInPdf_forStaff($data['staffid'], $dateformatestart, $dateformateto, $datefolder);

            }

        }

        echo 'Invoice generated successfully';

    }

}

function geerateInvoicefranchisePDF($var)
{

    $vars = explode('|', $var);

    $fromdate = explode('-', $vars[0]);

    $to_date = explode('-', $vars[1]);

    $sql = mysql_query("SELECT * FROM `staff`  WHERE better_franchisee = 2 and status = 1");

    if (mysql_num_rows($sql) > 0)

    {

        while ($data = mysql_fetch_assoc($sql))

        {

            $folder = $_SERVER['DOCUMENT_ROOT'] . '/franchise_report/';

            $foldername = $folder . $data['id'];

            if (!file_exists($foldername))
            {

                mkdir($foldername, 0777, true);

            }

            for ($i = $fromdate[1];$i <= $to_date[1];$i++)

            {

                $dateformatestart = date('Y-m-01', strtotime(date($fromdate[0] . '-' . $i)));

                $dateformateto = date('Y-m-t', strtotime(date($fromdate[0] . '-' . $i)));

                // echo '<br/>';
                $datefolder = $foldername;

                // echo $dateformatestart .''.$dateformateto;
                

                franchiseGenerationInPdf_forStaff($data['id'], $dateformatestart, $dateformateto, $datefolder);

            }

        }

        echo 'Invoice generated successfully';

    }

}

function sendNotiMessage($str, $result)
{

   // print_r($result); die;
	
	  if($result['chatter'] > 0) {
	  
    	$accounttype = get_rs_value("staff","account_notification_type",$result['chatter']);
	
	    
	    $accountdetails = mysql_fetch_assoc(mysql_query("SELECT id, app_id , authorization_api_key , app_url FROM `account_notification_type` WHERE id = ".$accounttype.""));
		
		$app_id = $accountdetails['app_id'];
		$app_url = $accountdetails['app_url'];
		$authorization_api_key = $accountdetails['authorization_api_key'];
		
	}else{
	
		$app_id = app_id;
		$app_url = app_url;
		$authorization_api_key = authorization_api_key;
	
	}
	
	

    if ($result['deviceid'] != '')
    {

        $deviceid = $result['deviceid'];

        $app_id = $app_id;

        $app_url = $app_url;

        $authorization_api_key = $authorization_api_key;

        $content = array(

            "en" => $str

        );
		
		
		/*   echo ($app_id);
		   echo '<br/>';
		 echo($app_url);
		   echo '<br/>';
		 print_r($authorization_api_key);

		 die;  */

        $sql = mysql_query("SELECT id FROM `chat`  WHERE to_id = '" . $result['chatter'] . "' AND chat_type = 'admin' AND receiver_read = 'no'");

        $count = mysql_num_rows($sql);

        if ($count == 0)
        {

            $count = $count + 1;

        }

        $fields = array(

            'app_id' => $app_id,

            'include_player_ids' => explode(',', $deviceid) ,

            'ios_badgeType' => 'Increase',

            'ios_badgeCount' => $count,

            'data' => array(
                "data" => "chat"
            ) ,

            'contents' => $content

        );

        	
        

        $fields = json_encode($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $app_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',

            "Authorization: Basic $authorization_api_key"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

    }
    else
    {

        $response = '';

    }

    $user_to = $result['user_to'];

    $chatter_name = $result['chatter'];

    $user_from = $result['admin_id'];

    $chat_owner = $result['admin'];

    //$getchatresponse = $response;
    

    mysql_query("insert into `chat` (`to`, `to_id`, `from`, `message`, `chat_type`, `time`, `sender_read`, `receiver_read`, `sender_deleted`, `receiver_deleted`, `response`) values ('" . ($user_to) . "', '" . ($chatter_name) . "', '" . ($user_from) . "', '" . (($str)) . "', '" . ($chat_owner) . "' , '" . (time()) . "', '" . ("yes") . "', '" . ("no") . "', '" . ("no") . "', '" . ("no") . "' , '" . $response . "')");

}

function getcleaner_value()
{

    $sql = mysql_query("SELECT *  FROM `system_dd` WHERE `type` = 69");

    if (mysql_num_rows($sql) > 0)
    {

        $getdata = array();

        while ($data = mysql_fetch_assoc($sql))
        {

            $getdata[$data['id']] = $data['name'];

        }

        //print_r($getdata);
        return $getdata;

    }
    else
    {

        return 0;

    }

}

function get_total_job($fromdate, $todate, $staff_id, $cl_id = null, $type = null)
{

    $sql = mysql_query("SELECT * FROM `job_details` WHERE staff_id = " . $staff_id . " and job_date >= '" . $fromdate . "' AND job_date <= '" . $todate . "' group by job_id");

    $totalcount = mysql_num_rows($sql);

    if ($totalcount > 0)
    {

        while ($getjob = mysql_fetch_assoc($sql))
        {

            // echo  $
            //$getjob1[] = '<a href="javascript:scrollWindow(\'popup.php?task=cleaner_notes&job_id='.$getjob['job_id'].'\',\'1200\',\'850\')" >'.$getjob['job_id'].'</a>';
            $getjob1[] = $getjob['job_id'];

        }

        return array(
            'total_job' => $totalcount,
            'jobs' => $getjob1
        );

    }
    else
    {

        return array(
            'total_job' => 0,
            'jobs' => 'No Job Found'
        );

    }

}

function get_issue_type_job($fromdate, $todate, $staff_id, $cl_id = null)
{

    $sql = mysql_query("SELECT group_concat(job_id) as jobid FROM `job_details` WHERE staff_id = " . $staff_id . " and job_date >= '" . $fromdate . "' AND job_date <= '" . $todate . "'");

    if (mysql_num_rows($sql) > 0)
    {

        $data = mysql_fetch_assoc($sql);

        $job_id = implode(' , ', array_unique(explode(',', $data['jobid'])));

        $cl_id = mysql_query("SELECT * FROM `clener_notes` where job_id in (" . $job_id . ") AND issue_type = " . $cl_id . " AND staff_id = " . $staff_id . "");

        $countresult = mysql_num_rows($cl_id);

        if ($countresult > 0)
        {

            while ($getdata = mysql_fetch_assoc($cl_id))
            {

                //$getjob1[] = '<a href="javascript:scrollWindow(\'popup.php?task=cleaner_notes&job_id='.$getdata['job_id'].'\',\'1200\',\'850\')" >'.$getdata['job_id'].'</a>';
                $getjob1[] = $getdata['job_id'];

            }

            return array(
                'jobtotal' => $countresult,
                'jobs' => $getjob1
            );

        }

    }
    else
    {

        return array(
            'jobtotal' => $countresult,
            'jobs' => 'not'
        );

    }

}

function check_cubic_meter_amount($cubic)
{

    if ($cubic <= 55)
    {

        $get_sql = ("SELECT cubic_meter  ,bcic_price FROM `truck` WHERE cubic_meter >= " . $cubic . " ORDER by cubic_meter ASC LIMIT 0 , 1");

    }
    else
    {

        $get_sql = ("SELECT cubic_meter  , bcic_price FROM `truck`   ORDER by cubic_meter desc LIMIT 0 , 1");

    }

    $get_amount = mysql_fetch_assoc(mysql_query($get_sql));

    $amount = $get_amount['bcic_price'];

    return $amount;

}

function get_issue_type($job_id, $staff_id)
{

    $cl_id = mysql_query("SELECT * FROM `clener_notes` where job_id =" . $job_id . "  AND staff_id = " . $staff_id . "");

    if (mysql_num_rows($cl_id) > 0)
    {

        while ($getdata = mysql_fetch_array($cl_id))
        {

            $data['comment'] = $getdata['comment'];

            $data['heading'] = $getdata['heading'];

        }

        return $data;

    }
    else
    {

        return 'Not Found';

    }

}

function get_job_type_name($job_id, $staff_id)
{

    $cl_id = mysql_query("SELECT * FROM `job_details` where job_id =" . $job_id . "  AND staff_id = " . $staff_id . "  AND status != 2");

    $getdata = mysql_fetch_array($cl_id);

    echo $getdata['job_type'];

}

function get_job_type_name_byID($job_id, $staff_id)
{

    $cl_id = mysql_query("SELECT * FROM `job_details` where job_id =" . $job_id . "  AND staff_id = " . $staff_id . "  AND status != 2");

    $getdata = mysql_fetch_array($cl_id);

    return $getdata['job_type'];

}

function cheChekjobdate($jobid)
{

    $jobdetails = mysql_query("SELECT job_type_id FROM `job_details` WHERE  job_id=" . $jobid . " and job_type_id =11");

    $countresu = mysql_num_rows($jobdetails);

    //$count_job_payment = 0;
    if ($countresu > 0)
    {

        $job_payment_data = mysql_query("SELECT id FROM `job_payments` WHERE job_id=" . $jobid . " and deleted=0");

        $count_job_payment = mysql_num_rows($job_payment_data);

    }

    $cl_id = mysql_query("SELECT booking_date FROM `quote_new` where booking_id =" . $jobid . "");

    $getdata = mysql_fetch_array($cl_id);

    if ($getdata['booking_date'] <= date('Y-m-d') || $count_job_payment > 0)

    {

        return 1;

    }
    else
    {

        return 0;

    }

}

function get_minutes($start, $end)
{

    while (strtotime($start) <= strtotime($end))
    {

        $minutes[] = date("H:i", strtotime("$start")) . '-' . date("H:i", strtotime("$start + 30 mins"));

        $start = date("H:i", strtotime("$start + 30 mins"));

    }

    return $minutes;

}

function gettotalCall($date, $type, $login_id = null)
{

    $arg = "select id from call_schedule_report where 1 = 1  AND schedule_date = '" . $date . "' AND   quote_id in 	(select id from quote_new where booking_id = 0 AND step not in (5,6,7,8,9,10))";

    if ($type == 1)
    {

        $arg .= "  AND take_call = 1  ";

    }

    if ($type == 2)
    {

        $arg .= "  ";

    }

    if ($type == 3)
    {

        //$arg .="  AND take_call = 0  ";
        $datetime = $date . ' 23:59:59';

        $arg .= " AND status = 1 AND schedule_date_time != '0000-00-00 00:00:00' AND schedule_date_time <= '" . $datetime . "'";

    }

    if ($type == 4)
    {

        $arg .= "  AND call_done = 1 ";

    }

    if ($type == 5)
    {

        //$datetime =  $date.' 23:59:59';
        $arg .= " AND schedule_date = '" . $date . "' AND login_id = " . $login_id . "";

    }

    //$arg .=" group by quote_id";
    

    //return $arg;
    $sql = mysql_query($arg);

    return mysql_num_rows($sql);

    //return mysql_num_rows($sql);
    //$getdata = mysql_fetch_assoc($sql);
    // return $getdata['totalcount'];
    

    
}

function checkImageLink($jobid)
{

    $staffsql = mysql_query("SELECT id FROM `job_befor_after_image` where job_id ='" . $jobid . "'");

    $countresult = mysql_num_rows($staffsql);

    return $countresult;

}

function CreateImageLink($jobid)
{

    $imagelink = get_rs_value("jobs", "imagelink", $jobid);

    if ($imagelink != '')
    {

        return $s_url = $imagelink;

        // echo 'f';
        
    }
    else
    {

        //	 echo 'f22';
        $siteUrl = get_rs_value("siteprefs", "site_url", 1);

        $jobid1 = base64_encode(base64_encode($jobid));

        $shorturl = $siteUrl . '/client_image.php?action=imagecheck&token=' . $jobid1;

        $s_url = createbitLink($shorturl, 'business2sell', 'R_3e3af56c36834837ba96e7fab0f4361a', 'json');

        // $s_url = createbitLink($shorturl,'o_6ue80tjbo6','R_380b883337714e64a2c9cb6cd5f7a649','json');	   // Pankaj gupta
        

        // print_r($s_url); die;
        //$s_url = createbitLink($shorturl,'business2sell','R_3e3af56c36834837ba96e7fab0f4361a','json');
        $uarg1 = mysql_query("update  jobs set imagelink ='" . $s_url . "'  WHERE `id` = '" . $jobid . "'");

        return $s_url;

    }

}

function getTotalImage($jobid, $image_type)
{

    $staffsql = mysql_query("SELECT count(id) as totalimage FROM `job_befor_after_image` where job_id ='" . $jobid . "' AND image_status != 0 AND image_status = " . $image_type . "");

    $countresult = mysql_num_rows($staffsql);

    if ($countresult > 0)
    {

        $getimagedata = mysql_fetch_assoc($staffsql);

        $totalimage = $getimagedata['totalimage'];

        if ($image_type == 1)
        {

            $field = 'total_before_img';

        }
        elseif ($image_type == 2)
        {

            $field = 'total_after_img';

        }

        $uarg1 = mysql_query("update  jobs set $field ='" . $totalimage . "'   WHERE `id` = '" . $jobid . "'");

    }
    else
    {

        $totalimage = 0;

    }

    return $totalimage;

}

function get_tiny_url($url)
{

    $ch = curl_init();

    $timeout = 5;

    curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    $data = curl_exec($ch);

    curl_close($ch);

    return $data;

}

function createbitLink($url, $login, $appkey, $format = 'json', $history = 1, $version = '2.0.1')

{

    //create the URL
    $bitly = 'http://api.bit.ly/shorten';

    $param = 'version=' . $version . '&longUrl=' . urlencode($url) . '&login='
 . $login . '&apiKey=' . $appkey . '&format=' . $format . '&history=' . $history;

    //get the url
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $bitly . "?" . $param);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    curl_close($ch);

    //parse depending on desired format
    if (strtolower($format) == 'json')
    {

        $json = @json_decode($response, true);

        //print_r($json); die;
        return $json['results'][$url]['shortUrl'];

    }
    else
    {

        $xml = simplexml_load_string($response);

        return 'http://bit.ly/' . $xml
            ->results
            ->nodeKeyVal->hash;

    }

}

function getAdminname($roleid = 0)
{
   //echo  $roleid;
    if($roleid > 0) {
        $arg = mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0 AND permanent_role = ".$roleid."");
    }else{
       $arg = mysql_query("SELECT name , id  FROM `admin` WHERE `is_call_allow` = 1 AND status != 0");
    }

    $getadmin = array();

    $countAdmin = mysql_num_rows($arg);

    while ($adminname = mysql_fetch_assoc($arg))
    {

        $getadmin[$adminname['id']] = $adminname['name'];

    }

    return $getadmin;

}

function date_compare($a = null, $b = null)

{

    $t1 = strtotime($a['date']);

    $t2 = strtotime($b['date']);

    return $t1 - $t2;

}

function makejobTimeLine($job_id)
{

    
    //require_once ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");
    include ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
    
    // use Dompdf\Dompdf;
    
    // $options = new Dompdf\Options();
    // $options->setIsHtml5ParserEnabled(true);
    $dompdf = new Dompdf\Dompdf();
    
    $sql_n = mysql_query("SELECT *  FROM `job_notes` WHERE `job_id` = " . $job_id . " AND check_status = 1 order by date asc");

    $sql_e = mysql_query("SELECT *  FROM `job_emails` WHERE `job_id` = " . $job_id . " AND check_status = 1  order by date asc");

    $count_n = mysql_num_rows($sql_n);

    $count_e = mysql_num_rows($sql_e);

    if ($count_n > 0 || $count_e > 0)
    {

        $fullgetdata_n = array();

        while ($getdata_n = mysql_fetch_array($sql_n))
        {

            // print_r($getdata_n);
            $fullgetdata_n[] = array

            (

                'type' => 'notes',

                'table' => 'job_notes',

                'id' => $getdata_n['id'],

                'quote_id' => $getdata_n['quote_id'],

                'date' => $getdata_n['date'],

                'heading' => $getdata_n['heading'],

                'comment' => $getdata_n['comment'],

                'check_status' => $getdata_n['check_status'],

                'staff_name' => $getdata_n['staff_name']

            );

        }

        $fullgetdata_e = array();

        while ($getdata_e = mysql_fetch_array($sql_e))
        {

            $fullgetdata_e[] = array

            (

                'type' => 'email',

                'table' => 'job_emails',

                'id' => $getdata_e['id'],

                'email' => $getdata_e['email'],

                'date' => $getdata_e['date'],

                'heading' => $getdata_e['heading'],

                'comment' => $getdata_e['comment'],

                'check_status' => $getdata_e['check_status'],

                'staff_name' => $getdata_e['staff_name']

            );

        }

        $fullgetdata = array_merge($fullgetdata_n, $fullgetdata_e);

        usort($fullgetdata, date_compare($a, $b));

        $str = '<html><body>';

        $str .= '<h2>Job  Communication Time Line  J#'.$job_id.' </h2>';

        $str .= '<div class="container mt-5 mb-5">

						<div class="row">

						 <div class="col-md-10" >';

        $str .= '<ul style="list-style-type: none;position: relative;padding-left: 30px;">';

        foreach ($fullgetdata as $key => $value)
        {

            //if($value['type'] == 'email') { $style = 'background: #fbf4f4c9;'; }else { $style = '' ; }
            if ($value['comment'] != $value['heading'])
            {
                if ($value['comment'] != '')
                {
                    $commentdata = $value['comment'];
                }
                else
                {
                    $commentdata = $value['heading'];
                }
            }

           // $site_url = get_rs_value("siteprefs", "site_url", 1);

            $icon = $_SERVER['DOCUMENT_ROOT']. '/admin/images/li_icon.png';

          $sendemailon = '';
            if ($value['type'] == 'email')
            {
                $sendemailon = '<span style="font-size:14px; padding-left: 5px;" >(' . $value['email'] . ')</span>';
            }

            $str .= '<li style="border-left: solid 1px #bdbdbd;margin-left:0px;padding-left:20px;">

									 <img src="' . $icon . '" alt="ICon" style="position:relative;left:-30px;margin-left:-30px;margin-right:20px;max-width:90%">	

										<div style="font-size: 18px;color: #1e8c9c;display: inline-block;font-weight: 600;width:60% !important;">' . $value['heading'] . $sendemailon . '</div>

										<span style="margin-left: 200px !important;width:40% !important;display: inline-block;">' . changeDateFormate($value['date'], 'timestamp') . '</span>

										<p style="" >' . $commentdata . '</p>

									</li>';

        }

        $str .= '<ul>';

        $str .= '<div><div><div>';

        $str .= '</body></html>';
        
       // $str .=  str_replace('https://www.bcic.com.au' ,$_SERVER['DOCUMENT_ROOT'] , $str);

        // $str = preg_replace('/ style=("|\')(.*?)("|\')/','',$str);
        // $str = remove_specil_char($str);
        // echo $str;  die;
        // $str = 'hello';
        
        $dompdf->set_paper(array(
            0,
            0,
            794,
            1123
        ) , 'portrait');

        // $dompdf->load_html($str);

        $dompdf->load_html(utf8_decode($str) , 'UTF-8');

        $dompdf->render();

        $folder = $_SERVER['DOCUMENT_ROOT'] . '/jobtimeline';

        $foldername = $folder;

        $filename = 'job_timeline_' . $job_id;

        $name = $filename . '.pdf';

        $filePath = $foldername . '/' . $name;

        $message = 'Full Communication Job Time Line';

        file_put_contents($filePath, $dompdf->output());

        $quoteid = mysql_fetch_array(mysql_query("SELECT id , quote_for  FROM `quote_new` WHERE booking_id = '" . $job_id . "'"));

        //$send_emailto = "pankaj.business2sell@gmail.com";
        $send_emailfrom = "booking@bcic.com.au";

        //	$send_emailto = "payal@bcic.com.au";
        //$send_emailto = "pankaj.business2sell@gmail.com";
        
         $send_emailto = "nadia@bcic.com.au";
         
        //(nadia@bcic.com.au

        $subject = "Job Full Communication TimeLine #J$job_id";
        $bool = mysql_query("update quote_new set full_time_date = '".date('Y-m-d H:i:s')."'   where id=".$quoteid['id']."");

        send_job_timeline_invoice("Full Communication Time line", $send_emailto, $subject, $message, $send_emailfrom, $filePath, $filename, $quoteid['quote_for']);
        send_job_timeline_invoice("Full Communication Time line", 'pankaj.business2sell@gmail.com', $subject, $message, $send_emailfrom, $filePath, $filename, $quoteid['quote_for']);
        send_job_timeline_invoice("Full Communication Time line", 'manish@bcic.com.au', $subject, $message, $send_emailfrom, $filePath, $filename, $quoteid['quote_for']);

        add_job_notes($job_id, "Full Communication Time line send email on $send_emailto", "");

        echo '<p style="color: #067706;float: right;margin-right: 137px;">Send Email Successfully</p>';

    }

}

function remove_specil_char($content)
{

    $content = preg_replace('#<p.*?>(.*?)</p>#i', '<p>\1</p>', $content);

    $content = preg_replace('#<span.*?>(.*?)</span>#i', '<span>\1</span>', $content);

    $content = preg_replace('#<ol.*?>(.*?)</ol>#i', '<ol>\1</ol>', $content);

    $content = preg_replace('#<ul.*?>(.*?)</ul>#i', '<ul>\1</ul>', $content);

    $content = preg_replace('#<li.*?>(.*?)</li>#i', '<li>\1</li>', $content);

    return $content;

}

function send_job_timeline_invoice($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $filepath, $filename, $quotefor = 1)

{

    if ($quotefor != '')

    {

        $quoteforsql = "SELECT * FROM quote_for_option where id=" . mres($quotefor);

        $quotetypedetails = mysql_fetch_array(mysql_query($quoteforsql));

        $site_logo = $quotetypedetails['company_logo'];

        $email = $quotetypedetails['email_out_booking'];

        $phone = $quotetypedetails['phone'];

        $hr_emails = $quotetypedetails['hr_emails'];

        $teamType = $quotetypedetails['name'];

        $sendto = $sendto_name . "<" . $sendto_email . ">";

        $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

			<HTML><HEAD><TITLE>" . $domain . "</TITLE>

			<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

			</HEAD>

			<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

			<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

			<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

			  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

			  <p>

			<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at " . $hr_emails . "<br><br>

			Kind Regards</font>

			</p>

			  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

			   " . $teamType . " Team<br>

			  <img src=\"" . $site_logo . "\" /><br>

				p: " . $phone . "<br>

				e: " . $email . "<br>

			   

			";

        // w: ".$domain."</font></P>
        

        $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

			This email and any attachments may contain information that is confidential and subject to legal privilege. 

			If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

			If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

			<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, " . $teamType . " is not liable (including in respect of negligence) for viruses or other defects or 

			for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

			The information contained in this document is confidential to the addressee and is not the view nor the official policy of " . $teamType . " unless otherwise stated.

			  </font> </P>

			  </td>

			  </tr>

			  </table>

			</BODY></HTML>

			";

        $fileatt = $filepath;

        $fileatt_type = "application/pdf";

        $email_from = $replyto;

        $email_to = $sendto_email; //$e;
        $headers = "From: <" . $email_from . "> \r\n";

        $headers .= "Reply-To: " . $email_from;

        $file = fopen($fileatt, 'rb');

        $data = fread($file, filesize($fileatt));

        fclose($file);

        $semi_rand = md5(time());

        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        $headers .= "\nMIME-Version: 1.0\n" .

        "Content-Type: multipart/mixed;\n" .

        " boundary=\"{$mime_boundary}\"";

        $email_message .= "This is a multi-part message in MIME format.\n\n" .

        "--{$mime_boundary}\n" .

        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .

        "Content-Transfer-Encoding: 7bit\n\n" .

        $email_message .= "\n\n";

        $data = chunk_split(base64_encode($data));

        $email_message .= "--{$mime_boundary}\n" .

        "Content-Type: {$fileatt_type};\n" .

        " name=\"{$filename}\"\n" .

        "Content-Transfer-Encoding: base64\n\n" .

        $data .= "\n\n" . "--{$mime_boundary}--\n";

        //echo $email_message;  die;
        ini_set('sendmail_from', $replyto);

        mail($sendto_email, $sendto_subject, $email_message, $headers);

    }
    else
    {

        return error("Found issue while creating this mail Please contact ADMIN");

    }

}

function GenerateTCPDF($quote)
{

    //print_r($quote);
    

    $checkQUotetype = mysql_fetch_assoc(mysql_query("select job_type_id from quote_details where quote_id=" . mysql_real_escape_string($quote['id']) . " AND job_type_id = 11"));

    $booking_id = base64_encode(base64_encode($quote['booking_id']));

    $qfor = $quote['quote_for'];

    /* if($qfor == 2 || $qfor == 4) {
    
    	$quoteforsql = "SELECT * FROM quote_for_option where id=".mres($quotefor);
    
    	$quotetypedetails = mysql_fetch_array(mysql_query($quoteforsql));
    
    	$term_condition = $quotetypedetails['term_condition_link'];
    
    	
    
    }   */

    $CheckUrl = mysql_query("SELECT * FROM sites  where id ='" . $quote['site_id'] . "'");

    $Siteresult = mysql_fetch_object($CheckUrl);

    /* $host = ($_SERVER['HTTP_HOST']);
    
    	$host = explode(".", $host);
    
    	$host1 = $host[1]; */

    if ($checkQUotetype['job_type_id'] == 11)
    {

        $check_quote_type = 3;

        $check_quote = 1;

    }
    else
    {

        $check_quote_type = 1;

        $check_quote = 0;

    }

    $siteprefs = mysql_query("SELECT * FROM `sites_term_condition` where quote_type = " . $check_quote_type . "");

    $result = mysql_fetch_object($siteprefs);

    if ($check_quote == 1)
    {

        // $Siteurl = $Siteresult->br_domain;
        $termc = $Siteresult->br_term_condition_link;

        $logoname = $Siteresult->br_logo;

        $sitetext = ucwords($Siteresult->domain_text);

    }
    else
    {

        $sitetext = ucwords($Siteresult->domain_text);

        if ($qfor == 2 || $qfor == 4)
        {

            $quoteforsql = "SELECT * FROM quote_for_option where id=" . mres($qfor);

            $quotetypedetails = mysql_fetch_array(mysql_query($quoteforsql));

            $termc = $quotetypedetails['term_condition_link'];

            $logoname = get_rs_value("quote_for_option", "company_logo", $qfor);

            if ($qfor == 2)
            {

                $sitetext = 'BetterBondCleaning';

            }
            else if ($qfor == 4)
            {

                $sitetext = 'BetterHub';

            }

            //$sitetext = ucwords($Siteresult->domain_text);
            

            
        }
        else
        {

            $logoname = $Siteresult->logo;

            $termc = $Siteresult->term_condition_link;

        }

    }

    //echo  $logoname;
    $anchor = "<a href='" . $termc . "'>HERE</a>";

    $str = '';

    $str .= "<img src=" . $logoname . " alt='logo'>";

    $str .= '<h3>Terms & Condition</h3>';

    if (!empty($siteprefs))
    {

        $str .= str_replace('$inclusion', $anchor, str_replace('$domain', $sitetext, $result->term_condition));

    }
    else
    {

        $str .= str_replace('$domain', $sitetext, $result[0]->term_condition);

    }

    return $str;

}

function getTotalJobsassigned($staff_id, $fromdate, $toDate, $type, $site_id)
{

    //if($type == 1) {
    //   $query = mysql_query("SELECT id FROM `job_details` WHERE `staff_id` = '".$staff_id."'  AND job_date >= '".date('Y-m-d', strtotime($fromdate))."' AND job_date <= '".date('Y-m-d',strtotime($toDate))."' and status != 2 AND job_id in (SELECT id FROM jobs WHERE status in (1,3)) GROUP by job_id");
    

    $query = mysql_query("SELECT id FROM `job_details` WHERE `staff_id` = '" . $staff_id . "'  AND job_date >= '" . date('Y-m-d', strtotime($fromdate)) . "' AND job_date <= '" . date('Y-m-d', strtotime($toDate)) . "' and status != 2  GROUP by job_id");

    $count = mysql_num_rows($query);

    return $count;

}

function getaddress($lat, $lng)

{

    if (!empty($lat) && !empty($lng))
    {

        //https://maps.googleapis.com/maps/api/geocode/json?address=COMPLETE+ADDRESS&sensor=true&key=YOUR_GOOGLE_MAP_API_KEY
        

        //Send request and receive latitude and longitude
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';

        $json = @file_get_contents($url);

        $data = json_decode($json);

        //print_r($data); die;
        

        $status = $data->status;

        if ($status == "OK")
        {

            $location = $data->results[0]->formatted_address;

        }
        else
        {

            $location = 'No location found.';

        }

        echo $location;

    }

}

function checkavailbilty($staff_id, $from_date, $todate)
{

    $avail = mysql_num_rows(mysql_query("SELECT  id  FROM `staff_roster` WHERE `staff_id` = " . $staff_id . " and date >= '" . $from_date . "' and date <= '" . $todate . "' AND status = 1"));

    $notavail = mysql_num_rows(mysql_query("SELECT id  FROM `staff_roster` WHERE `staff_id` = " . $staff_id . " and date >= '" . $from_date . "' and date <= '" . $todate . "' AND status = 0"));

    return ($avail) . ' day avail <br/> ' . ($notavail) . ' day not avail';

}

function checkavailbilty_bydate($staff_id, $from_date, $todate)
{

    /* $get = "SELECT  id  FROM `staff_roster` WHERE `staff_id` = ".$staff_id." and date >= '".$from_date."' and date <= '".$todate."' AND status = 1";
    
    $get1 = "SELECT  id  FROM `staff_roster` WHERE `staff_id` = ".$staff_id." and date >= '".$from_date."' and date <= '".$todate."' AND status = 0";  */

    $avail = mysql_num_rows(mysql_query("SELECT  id  FROM `staff_roster` WHERE `staff_id` = " . $staff_id . " and date >= '" . $from_date . "' and date <= '" . $todate . "' AND status = 1"));

    $notavail = mysql_num_rows(mysql_query("SELECT id  FROM `staff_roster` WHERE `staff_id` = " . $staff_id . " and date >= '" . $from_date . "' and date <= '" . $todate . "' AND status = 0"));

    return array(
        'avail' => $avail,
        'notavail' => $notavail
    );

}

function get_total_work_hr($job_id, $q_hr)
{

    $job_details = mysql_fetch_array(mysql_query("SELECT quote_id,start_time, end_time,team_size FROM job_details WHERE job_id =" . $job_id . " AND status!=2 AND job_type_id=1"));

    $team_size = $job_details['team_size'];

    $extra_hr = 0;

    if ($job_details['end_time'] != '0000-00-00 00:00:00' && $job_details['start_time'] != '0000-00-00 00:00:00')
    {

        $date1 = new DateTime($job_details['end_time']);

        $date2 = $date1->diff(new DateTime($job_details['start_time']));

        $work_hr = $date2->h . '.' . $date2->i;

        if ($team_size > 0)
        {

            $total_work = $team_size * $work_hr;

        }
        else
        {

            $total_work = $date2->h . '.' . $date2->i;

        }

        if ($total_work > $q_hr)
        {

            $extra_hr = $total_work - $q_hr;

        }

    }
    else
    {

        $total_work = 0;

        $work_hr = 0;

    }

    return array(
        'work_hr' => $work_hr,
        'total_work' => $total_work,
        'team_size' => $team_size,
        'extra_hr' => $extra_hr
    );

}

function getPaymentWorkReport($job_id, $hours)
{

    $quote_details = get_total_work_hr($job_id, $hours);

    $str = '<table width="100%" border="0" cellspacing="3" cellpadding="3" class="table_bg"> 

				<tbody>

					<tr class="header_td">

						<td class="table_cells">Q hr</td>

						<td class="table_cells">W hr</td>

						<td class="table_cells">Tm Size</td>

						<td></td>

						<td class="table_cells">T hr</td>

						<td class="table_cells">Ex hr</td>

					</tr>';

    $str .= '<tr class="table_cells">

						<td class="table_cells">' . $hours . ' hr</td>

						<td class="table_cells">' . $quote_details['work_hr'] . ' hr</td>

						<td class="table_cells">' . $quote_details['team_size'] . '</td>

						<td></td>

						<td class="table_cells">' . $quote_details['total_work'] . ' hr</td>	

						<td class="table_cells">' . $quote_details['extra_hr'] . ' hr</td>			  

					</tr>';

    $str .= '</tbody>

			</table>';

    return $str;

}

function checkImageStatus($job_id, $reclean, $imgtype = null)
{

    $arg = "SELECT count(id) as imageCount FROM `job_befor_after_image` where job_id ='" . $job_id . "' AND  job_type_status = " . $reclean . "";

    if ($imgtype == 3)
    {

        $arg .= " AND image_status = " . $imgtype . "";

    }

    else
    {

        $arg .= " AND image_status != 3";

    }

    $getafterImage = mysql_fetch_array(mysql_query($arg));

    return $getafterImage['imageCount'];

}


function checkImageStatusPayment($job_id, $imgtype = null)
{
	
    $arg_1 = mysql_query("SELECT id  ,  image_status, job_type_status FROM `job_befor_after_image` where job_id ='" . $job_id . "' AND  job_type_status in ( 1,2 )");

	$checklist = 0;
	 while($getafterImage = mysql_fetch_assoc($arg_1)){
		  $data[$getafterImage['job_type_status']][] =  $getafterImage['id'];
		  if ($getafterImage['image_status'] == $imgtype) {
					 $checklist++;
				 }
		 
	 }
			 $toaldata = array('job_type'=>$data , 'checklist'=>$checklist);
			 
			return $toaldata; 
}


function getLasteekReClean(){
	
	//$recl_sql = mysql_query("SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND staff_id = ".$jdetails['staff_id']." And job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id");
	
	//echo "SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND   job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id";
	
	$recl_sql = mysql_query("SELECT count(staff_id) as staffresult, staff_id ,  job_id  FROM `job_details` WHERE  job_date >= '".date('Y-m-d', strtotime('-7 days'))."' AND   job_date <= '".date('Y-m-d')."' and status != 2 AND job_id in (SELECT id  from jobs WHERE status = 5 ) GROUP by job_id");
	
	
	while($data = mysql_fetch_array($recl_sql)){
		$totalJob[$data['staff_id']][] = $data;
	}
	
	return $totalJob;
	
}




function getQuoteQuestion($quote_id = null)
{

    $question_ids = explode(',', get_rs_value('quote_new', 'question_id', $quote_id));

    $str = '';

    $qry_quote_questions = mysql_query("SELECT * FROM quote_question WHERE status=1");

    $str .= '<table border="1px" class="quote_que" id="quote_quest_div" style="display:none;width: 100%">';

    while ($quote_quest_list = mysql_fetch_assoc($qry_quote_questions))
    {

        if (!empty(question_ids))
        {

            if (in_array($quote_quest_list['id'], $question_ids))
            {

                $status = 'checked';

            }

            else
            {

                $status = '';

            }

        }

        $str .= '<tr style="height:50px;">

				<td width="10%;"><input type="checkbox" name="quote_quest[]" value="' . $quote_quest_list['id'] . '" ' . $status . '></td><td>' . $quote_quest_list['question'] . '</td>

			 </tr>';

    }

    $str .= '</table>';

    return $str;

}

function sendNotificationMsg($str, $result)
{

    if ($result['deviceid'] != '')
    {

        $deviceid = $result['deviceid'];

        $app_id = app_id;

        $app_url = app_url;

        $authorization_api_key = authorization_api_key;

        $content = array(

            "en" => $str

        );

        $sql = mysql_query("SELECT id FROM `chat`  WHERE to_id = '" . $result['chatter'] . "' AND chat_type = 'admin' AND receiver_read = 'no'");

        $count = mysql_num_rows($sql);

        if ($count == 0)
        {

            $count = $count + 1;

        }

        $fields = array(

            'app_id' => $app_id,

            'include_player_ids' => explode(',', $deviceid) ,

            'ios_badgeType' => 'Increase',

            'ios_badgeCount' => $count,

            'data' => array(
                "data" => "chat"
            ) ,

            'contents' => $content

        );

        $fields = json_encode($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $app_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',

            "Authorization: Basic $authorization_api_key"
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

    }
    else
    {

        $response = '';

    }

}

function StaffDetailsUpdateByadmin($oldDetails, $newDetails)

{

    /* echo '<pre>';
    
    print_r($oldDetails);
    
    echo '<br/>';echo '<br/>';
    
    print_r($newDetails);
    
    die;  */

    $result1 = array_diff($oldDetails, $newDetails);

    if (!empty($result1))

    {

        $getkey = array_keys($result1);

        $new = '';

        foreach ($getkey as $key => $value)
        {

            $new .= "<label><strong>" . ucfirst($value) . "</strong></label> : " . $newDetails[$value];

            $new .= '<br/>';

        }

        $str = '';

        $eol = "<br>";

        $str .= 'Hi BCIC Team, ' . $eol . $eol;

        $str .= $oldDetails['name'] . ' (Staff) has been updated the details from staff app. Please update the details below';

        $str .= $eol;

        $str .= "<h3>Old Details</h3>";

        foreach ($result1 as $key => $value)
        {

            $str .= "<label><strong>" . ucfirst($key) . "</strong></label> : " . $value;

            $str .= $eol;

        }

        $str .= $eol;

        $str .= "<h3>New Details</h3>";

        $str .= $new;

        //$adminnmae = $_SESSION['admin']
        $adminnmae = get_rs_value("admin", "name", $_SESSION['admin']);

        $subject = "BCIC Staff (" . $oldDetails['name'] . ") Updated Details By (" . $adminnmae . ")";

        $body = $str;

        //sendmailbcic("BCIC Staff Details changes", 'pankaj.business2sell@gmail.com', $subject, $body, 'hr@bcic.com.au', "0");

         sendmailbcic("BCIC Staff Details changes",'hr@bcic.com.au',$subject,$body,'hr@bcic.com.au',"0");
        
        sendmailbcic("BCIC Staff Details changes",'accounts@bcic.com.au',$subject,$body,'hr@bcic.com.au',"0");
        
        sendmailbcic("BCIC Staff Details changes",'pankaj.business2sell@gmail.com',$subject,$body,'hr@bcic.com.au',"0"); 

    }

}


function sendInfo($getInfo){
    
        $adminnmae = get_rs_value("admin", "name", $_SESSION['admin']);

        $subject = "BCIC Staff (" . $getInfo['fullname'] . ") a new staff added  By (" . $adminnmae . ")";
    
        $str = '';

        $eol = "<br>";

        $str .= 'Hi BCIC Team, ' . $eol . $eol;

        $str .= $getInfo['fullname'] . ' a new staff add in BCIC';

        $str .= $eol;

        $str .= "<h3>Info Details</h3>";

        foreach ($getInfo as $key => $value)
        {

            $str .= "<label><strong>" . ucfirst($key) . "</strong></label> : " . $value;

            $str .= $eol;

        }

        $str .= $eol;
     sendmailbcic("BCIC Staff Details changes",'pankaj.business2sell@gmail.com',$subject,$str,'hr@bcic.com.au',"0"); 
}


function reviewClientSendMailBcic($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto)
{

    //global $siteinfo;
    //	echo "Ok"; die;
    //$sql_email = "SELECT * FROM country_settings where id=".$_SESSION['cid'];
    

    $sql_email = "SELECT * FROM siteprefs where id=1";

    $site = mysql_fetch_array(mysql_query($sql_email));

    //echo "$site[siteurl]";
    

    $sendto = $sendto_name . "<" . $sendto_email . ">";

    //$sendto = "BCIC Application<hr@bcic.com.au>";
    

    //	echo $sendto; die;
    $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>

<META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>

</HEAD>

<link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">

<link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">

  <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>

  <p>

<font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at team@bcic.com.au <br><br>

Kind Regards</font>

</p>

  <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">

  BCIC Team</P>

  

  <P><a href=\"" . $site['site_domain'] . "\"><img src=\"" . $site['site_url'] . '/' . $site['bcic_new_logo'] . "\" /></a><br>

	p: 1300599644 <br>

	e: team@bcic.com.au <br>

  w: " . $site['site_domain'] . "</font></P>

";

    $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 

This email and any attachments may contain information that is confidential and subject to legal privilege. 

If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 

If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>

<strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 

for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 

The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.

  </font> </P>

  </td>

  </tr>

  </table>

</BODY></HTML>

";

    $headers = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From:' . $replyto . "\r\n";

    $headers .= 'Reply-To:' . $replyto . "\r\n";

    ini_set('sendmail_from', $replyto);

    // echo $site['site_url'].$site['logo']; die;
    

    mail($sendto_email, $sendto_subject, $email_message, $headers);

    //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
}

function getTotalrecord($arg)
{

    $query = mysql_query($arg);

    $datajob = array();

    $k = 0;

    while ($data = mysql_fetch_assoc($query))
    {

        //$datajob[] = $data['job_id'];
        $argSql = mysql_query("select id from job_reclean where job_id  = " . $data['job_id'] . " and status!=2");

        $count = mysql_num_rows($argSql);

        if ($count == 0)
        {

            $k++;

        }

    }

    echo $k;

}

function getTotalRecleanByAgent($agentname)
{

    //$sql1 = "SELECT   job_id  FROM `job_details`  WHERE real_estate_agency_name = '".$agentname."'";
    $sql = mysql_query("SELECT    DISTINCT(job_id) as jobs FROM `job_details`  WHERE real_estate_agency_name = '" . $agentname . "' AND real_estate_agency_name != '' AND job_id != ''");

    $data = array();

    if (mysql_num_rows($sql) > 0)
    {

        //return mysql_num_rows($sql);
        while ($data1 = mysql_fetch_assoc($sql))
        {

            //$data[] = $data1['jobs'];
            //$data[] = "<a href='javascript:scrollWindow('popup.php?task=jobs&job_id=".$data1['jobs']."','1200','850')'>".$data1['jobs']."</a>";
            $data[] = '<a href="javascript:scrollWindow(\'popup.php?task=jobs&job_id=' . $data1['jobs'] . '\',\'1200\',\'850\')" >' . $data1['jobs'] . '</a>';

            //$data[] = '<a href="javascript:scrollWindow("popup.php?task=jobs&job_id=".$data1['jobs']."','1200','850')'>".$data1['jobs']."</a>';
            
        }

        return implode(',', (array_unique($data)));

        unset($data);

    }

}

function checkReviewEmails($jobid)
{

    $sql = mysql_query("SELECT * FROM `bcic_review` WHERE job_id = " . $jobid . "");

    $count = mysql_num_rows($sql);

    return $count;

}

function checkQuoteType($jobid)
{

    $sql = mysql_query("SELECT    id FROM `job_details`  WHERE job_id = '" . $jobid . "' AND status != 2 AND job_type_id = 11 Limit 0 , 1");

    $countresult = mysql_num_rows($sql);

    if ($countresult > 0)
    {

        return 1;

    }
    else
    {

        return 0;

    }

}

function checkSignatureImg($jobid)
{

    $sql = mysql_query("SELECT id FROM `signature_image`  WHERE job_id = '" . $jobid . "'");

    $countresult = mysql_num_rows($sql);

    if ($countresult > 0)
    {

        return 1;

    }
    else
    {

        return 0;

    }

}

function getTotalQuoteInfo($fromdate, $todate, $site_id = null)
{

    $sql = "SELECT * FROM `quote_new` WHERE date >= '" . $fromdate . "' AND date <= '" . $todate . "' AND step != 10";

    if ($site_id != '' && $site_id != null)
    {

        $sql .= " AND  site_id = '" . $site_id . "'";

    }

    $query = mysql_query($sql);

    $count = mysql_num_rows($query);

    $booked = 0;

    $site = 0;

    $phone = 0;

    $adminquote = 0;

    $is_deleted = 0;

    $quote_to_job_date = 0;

    $totalc_denied = 0;

    $totala_denied = 0;

    $totala_other = 0;

    while ($data = mysql_fetch_array($query))
    {

        if ($data['step'] == '5')
        {

            $totalc_denied++;

        }

        if ($data['step'] == '7')
        {

            $totala_other++;

        }

        if ($data['step'] == '6')
        {

            $totala_denied++;

        }

        if ($data['job_ref'] == 'Site')
        {

            $site++;

        }

        if ($data['job_ref'] == 'Phone')
        {

            $phone++;

        }

        if ($data['job_ref'] != 'Site')
        {

            $adminquote++;

        }

        if ($data['booking_id'] != 0)
        {

            $booked++;

        }

        if ($data['is_deleted'] == 1)
        {

            $is_deleted++;

        }

    }

    return array(
        'totalquote' => $count,
        'booked' => $booked,
        'site' => $site,
        'adminquote' => $adminquote,
        'is_deleted' => $is_deleted,
        'phone' => $phone,
        'totalc_denied' => $totalc_denied,
        'totala_denied' => $totala_denied,
        'totala_other' => $totala_other
    );

}

function getTotalQuoteInfoADenied($fromdate, $todate, $site_id = null, $deniedid, $step_status = 6)
{

    $sql = "SELECT * FROM `quote_new` WHERE date >= '" . $fromdate . "' AND date <= '" . $todate . "' AND step != 10 ";

    if ($site_id != '' && $site_id != null)
    {

        $sql .= " AND  site_id = '" . $site_id . "'";

    }

    $query = mysql_query($sql);

    $count = mysql_num_rows($query);

    $totala_denied = 0;

    while ($data = mysql_fetch_array($query))
    {

        if ($data['step'] == $step_status && $data['denied_id'] == $deniedid)
        {

            $totala_denied++;

        }

    }

    return $totala_denied;

}

function getTotalOTOBooked($fromdate, $todate)
{

    $deletequote1 = "SELECT count(id) as totalotobooked FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND oto_flag = 1 AND  oto_time != '0000-00-00 00:00:00' AND date >= '" . $fromdate . "' AND date <= '" . $todate . "'";

    $Totalotobook = mysql_fetch_array(mysql_query($deletequote1));

    $data['totalotobooked'] = $Totalotobook['totalotobooked'];

    $quote_to_job_datesql = "SELECT count(id) as QuoteconvertBOoked FROM `quote_new` where 1 = 1 AND   booking_id != 0 AND quote_to_job_date >= '" . $fromdate . "' AND quote_to_job_date <= '" . $todate . "'";

    $quote_to_job_date = mysql_fetch_array(mysql_query($quote_to_job_datesql));

    $data['QuoteconvertBOoked'] = $quote_to_job_date['QuoteconvertBOoked'];

    $totalotosql = "SELECT count(id) as totalotoquote FROM `quote_new` WHERE  1 = 1 AND  date >= '" . $fromdate . "' AND date <= '" . $todate . "' and oto_time != '0000-00-00 00:00:00'";

    $totalotoQuote = mysql_fetch_array(mysql_query($totalotosql));

    $data['totalotoquote'] = $totalotoQuote['totalotoquote'];

    return $data;

}

function quoteBySite($fromdate, $todate, $typeid, $type)
{

    $sql1 = "SELECT id , booking_id FROM `quote_new` WHERE date >= '" . $fromdate . "' AND date <= '" . $todate . "'  AND  step != 10";

    if ($type == 1)
    {

        $sql1 .= "  AND site_id = " . $typeid . "";

    }
    else if ($type == 2)
    {

        $sql1 .= "  AND login_id = " . $typeid . "";

    }

    $sql = mysql_query($sql1);

    $count = mysql_num_rows($sql);

    $totalbooing = 0;

    while ($getdata = mysql_fetch_array($sql))
    {

        if ($getdata['booking_id'] > 0)
        {

            $totalbooing++;

        }

    }

    return array(
        'totalquote' => $count,
        'totalbooking' => $totalbooing
    );

}

function getmonthlyQuote($month, $type)
{

    $fromdate = date('Y-m-d', strtotime(date('Y') . '-' . $month . '-01'));

    $todate = date('Y-m-d', strtotime(date('Y') . '-' . $month . '-31'));

    $sql = "SELECT id FROM `quote_new` WHERE  date >='" . $fromdate . "'  AND date <= '" . $todate . "'  AND step != 10 ";

    if ($type == 1)
    {

        $sql .= " AND booking_id  != 0";

    }

    $query = mysql_query($sql);

    return mysql_num_rows($query);

}

function gettotalAmountData($fromdata, $todata, $jobtypeid)
{

    $sql = mysql_query("SELECT sum(amount_total) as totalamt , sum(amount_staff) as staffamt ,  sum(amount_profit) as profitamt ,  job_type_id  FROM `job_details` WHERE job_type_id = " . $jobtypeid . " AND job_date >= '" . $fromdata . "' AND job_date <= '" . $todata . "' and status != 2  and job_id in (SELECT id from jobs WHERE status = 3)");

    $data = mysql_fetch_array($sql);

    return array(
        'totalamt' => round($data['totalamt'], 0) ,
        'staffamt' => round($data['staffamt'], 0) ,
        'profitamt' => round($data['profitamt'], 0)
    );

}

function getjobStatusData($fromdata, $todata, $statusid, $site_id = null)
{

    $sql = "SELECT id FROM `quote_new` WHERE booking_id != 0 and booking_date >= '" . $fromdata . "' and booking_date <= '" . $todata . "'";

    if ($site_id != 0 && $site_id != null)
    {

        $sql .= "  AND site_id = " . $site_id . "";

    }

    $sql .= "  AND booking_id in (SELECT id from jobs WHERE status = " . $statusid . ")";

    // return $sql;
    $query = mysql_query($sql);

    return mysql_num_rows($query);

}

function getTotalJobsDetails($fromdate, $todate, $siteid)
{

    $total_jobs_data_sql = "SELECT count(*) as total_jobs FROM `jobs` WHERE date>='" . date('Y-m-d', strtotime($fromdate)) . "' and date<='" . $todate . "' and site_id=" . $siteid . "";

    $total_jobs_data = mysql_query($total_jobs_data_sql);

    $total_jobs_row = mysql_fetch_array($total_jobs_data);

    $total_jobs = $total_jobs_row['total_jobs'];

    // AND job_ref = ".$ref."
    

    // Job Cancelled
    $jobs_cancelled_data_sql = "SELECT count(*) as jobs_cancelled FROM `jobs` WHERE status=2 and date>='" . date('Y-m-d', strtotime($fromdate)) . "' and date<='" . $todate . "' and site_id=" . $siteid . "";

    $jobs_cancelled_data = mysql_query($jobs_cancelled_data_sql);

    $jobs_cancelled_row = mysql_fetch_array($jobs_cancelled_data);

    $jobs_cancelled = $jobs_cancelled_row['jobs_cancelled'];

    // Booked Job Accodrding to ref
    $jobs_booked_data_sql = "SELECT job_ref FROM `quote_new` WHERE booking_id!=0  AND  date>='" . date('Y-m-d', strtotime($fromdate)) . "' and date<='" . $todate . "' and site_id=" . $siteid . " AND step != 10";

    $jobs_Phone = 0;

    $jobs_Site = 0;

    $booked_dataSql = mysql_query($jobs_booked_data_sql);

    while ($booked_data = mysql_fetch_array($booked_dataSql))
    {

        if ($booked_data['job_ref'] == 'Phone')
        {

            $jobs_Phone++;

        }

        if ($booked_data['job_ref'] == 'Site')
        {

            $jobs_Site++;

        }

    }

    return array(
        'jobs_phone' => $jobs_Phone,
        'jobs_site' => $jobs_Site,
        'total_jobs' => $total_jobs,
        'jobs_cancelled' => $jobs_cancelled
    );

}

function checkCountFailedreclean($arg)
{

    $data = mysql_query($arg);

    if (mysql_num_rows($data) > 0)
    {

        $i = 0;

        while ($row = mysql_fetch_assoc($data))

        {

            // echo "select * from job_reclean where job_id=".$row['job_id']." and status!=2 AND reclean_work = 2";
            

            $argSql = mysql_query("select id from job_reclean where job_id=" . $row['job_id'] . " and status!=2 AND reclean_work = 2");

            if (mysql_num_rows($argSql) > 0)
            {

                $i++;

            }

        }

        return $i;

    }

}

function JobDenyByAdmin($var)
{

    $varx = explode("|", $var);

    $jd_id = $varx[0];

    $job_id = $varx[1];

    $staff_id = $varx[2];

    $action = $varx[3];

    $jdetails = mysql_fetch_array(mysql_query("select job_type , amount_total , amount_profit, amount_staff , amt_share_type, job_type_id from job_details where id=" . $jd_id . ""));

    $staff_assign_date = '0000-00-00 00:00:00';

    $staff_truck_assign_date = '0000-00-00 00:00:00';

    $staff_assign_notification = '';

    $job_acc_deny = 'Null';

    $staff_truck_id = 0;

    $amount_staff = 0;

    $amount_profit = 0;

    $amt_share_type = '';

    $staff_work_status = '';

    $checklist_field = '';

    $sub_staff_id = 0;

    $sub_staff_assign_date = '0000-00-00 00:00:00';

    $job_notification_date = '0000-00-00 00:00:00';

    $add_notification_date = '0000-00-00 00:00:00';

    if ($jd_id != 0)
    {

        $uarg = "update job_details set staff_id=0 , job_sms = '', address_sms = '', job_sms_date='0000-00-00 00:00:00', end_time='0000-00-00 00:00:00', start_time='0000-00-00 00:00:00', job_notification_status = '0',job_notification_date = '" . $job_notification_date . "', address_sms_date = '0000-00-00 00:00:00',staff_truck_assign_date = '" . $staff_truck_assign_date . "' , exact_work_time = '', total_hr_staff_work = '', staff_truck_id = '" . $staff_truck_id . "' ,staff_assign_date = '" . $staff_assign_date . "',staff_assign_notification = '" . $staff_assign_notification . "',job_acc_deny = " . $job_acc_deny . ",sub_staff_id = '" . $sub_staff_id . "',sub_staff_assign_date = '" . $sub_staff_assign_date . "',amount_staff = '" . $amount_staff . "',staff_work_status = '" . $staff_work_status . "',checklist_field = '" . $checklist_field . "',amount_profit = '" . $amount_profit . "',amt_share_type ='" . $amt_share_type . "' where job_id=" . $job_id . " and id=" . $jd_id . "";

        mysql_query($uarg);

        //$staffwork = mysql_query("INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`,`created_at`) VALUES ('".$staff_id."', '".$job_id."', 2, '".date("Y-m-d H:i:s")."')");
        //$staffwork = mysql_query("INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`, `job_type_id`, `created_at`) VALUES ('".$staff_id."', '".$job_id."', 2, ".$jdetails['job_type_id'].", '".date("Y-m-d H:i:s")."')");
        

        //amount_total , amount_profit, amount_staff , amt_share_type
        if ($action == 'auto')
        {

            $typeassi = 2;

        }
        else
        {

            $typeassi = 1;

        }

        $staffwork = mysql_query("INSERT INTO `staff_jobs_status` (`staff_id`, `job_id`, `status`, `job_type_id`, `created_at`,`total_amount`, `total_staff_amt`, `total_bcic_amt`, `current_rate_for_day`,`assign_type`) VALUES ('" . $staff_id . "', '" . $job_id . "', 2, " . $jdetails['job_type_id'] . ", '" . date("Y-m-d H:i:s") . "' , '" . $jdetails['amount_total'] . "', " . $jdetails['amount_staff'] . ", '" . $jdetails['amount_profit'] . "', '" . $jdetails['amt_share_type'] . "','" . $typeassi . "')");

        mysql_query("INSERT INTO `reason_for_deny` (`job_id`, `staff_id`, `createOn`, `job_type_id` , `reason_id`, `deny_type`) VALUES ('" . $job_id . "', '" . $staff_id . "', '" . date("Y-m-d H:i:s") . "', " . $jdetails['job_type_id'] . ", '5', '3')");

        if ($action == 'auto')
        {

            $heading = $jdetails['job_type'] . ' Job Deny By Automated after 2 Hours';

        }
        else
        {

            $admin = get_rs_value("admin", "name", $_SESSION['admin']);

            $heading = $jdetails['job_type'] . ' Job Deny By ' . $admin . ' (admin)';

        }

        add_job_notes($job_id, $heading, $heading);

    }

}

function send_cleaner_details_to_clients($job_id)
{

    $heading = "";

    $str = "";

    //$comment =  sms_send_cleaner_details($job_id);
    $eol = " ";

    $quote = mysql_fetch_array(mysql_query("select * from quote_new where booking_id=" . mysql_real_escape_string($job_id) . ""));

    $job_details = mysql_query("select * from job_details where job_id=" . mysql_real_escape_string($job_id) . " AND status != 2 ");

    $c_str = "";

    while ($jd = mysql_fetch_assoc($job_details))
    {

        if ($jd['job_type_id'] == 11)
        {

            $check_quote = 1;

            $heading .= "Send Removal Details to Client SMS";

            $text = 'Removal (s)';

        }
        else
        {

            if ($quote['quote_for'] == 2)
            {

                $sitetext = 'BBC';

            }
            else
            {

                $sitetext = 'BCIC';

            }

            $check_quote = 0;

            $heading .= "Send Cleaner Details to Client SMS";

            $text = 'Cleaner (s)';

        }

        $staff = mysql_fetch_array(mysql_query("select * from staff where id=" . mysql_real_escape_string($jd['staff_id']) . " "));

        $c_str .= $jd['job_type'] . ': ' . $staff['name'] . " " . $staff['mobile'] . '' . $eol;

    }

    //$eol = "<br>";
    $str = 'Hello (#' . $job_id . ') ' . mysql_real_escape_string($quote['name']) . $eol . 'We are all set for your job on ' . changeDateFormate($quote['booking_date'], 'datetime') . '' . $eol;

    $str .= 'Your ' . $text . ' details are ' . $c_str . $eol;

    $str .= 'Thank You' . $eol;

    $str .= $sitetext . ' Team';

    $sms_code = send_sms(str_replace(" ", "", $quote['phone']) , mysql_real_escape_string(trim($str)));

    if ($sms_code == "1")
    {
        $heading .= "  (Delivered)";
        $flag = 1;
    }
    else
    {
        $heading .= " <span style=\"color:red;\">(Failed)</span>";
        $flag = 2;
    }

    add_job_notes($job_id, $heading, $str);

    if ($flag == '1')
    {

        $bool = mysql_query("update jobs set sms_client_cleaner_details='" . date("Y-m-d h:i:s") . "' where id=" . $job_id . "");

        echo date("d M Y h:i:s");

    }
    else
    {

        echo "Not sent";

    }

}

function send_Job_add_sms($var)
{

    $varx = explode("|", $var);

    $action = $varx[0];

    $job_details_id = $varx[1];

    $pagetype = $varx[2];

    $smstype = $varx[3];

    $eol = "";

    $job_details = mysql_fetch_array(mysql_query("select * from job_details where id=" . $job_details_id . " AND status != 2"));

    if ($job_details['staff_id'] != "0")

    {

        $jobs = mysql_fetch_array(mysql_query("select * from jobs where id=" . mysql_real_escape_string($job_details['job_id']) . ""));

        $quote = mysql_fetch_array(mysql_query("select * from quote_new where id=" . mysql_real_escape_string($job_details['quote_id']) . ""));

        $staff = mysql_fetch_array(mysql_query("select * from staff where id=" . mysql_real_escape_string($job_details['staff_id']) . ""));

        $quote_details = mysql_fetch_array(mysql_query("select * from quote_details where quote_id=" . mysql_real_escape_string($quote['id']) . " and job_type_id=" . mysql_real_escape_string($job_details['job_type_id'])));

        $heading = "";

        $comment = "";

        if ($action == "job")
        {

            // Update job SMS
            if ($smstype == 'smstype')
            {

                $sms_type = 'job_notification_status';

                $sms_type_date = 'job_notification_date';

            }
            else
            {

                $sms_type = 'job_sms';

                $sms_type_date = 'job_sms_date';

            }

            $heading = "Send " . $job_details['job_type'] . " Job SMS " . $staff['name'] . " on " . $staff['mobile'];

            //$comment = "Hi ".$staff['name'].", ".$job_details['job_type']." job assigned to you on ".date("d M",strtotime($job_details['job_date'])).". (#".$job_details['job_id'].")";
            //Hi Name jobtype (j#12) Size in superb for date is awaiting your review ,please accept within 4 hrs of this notification to secure the work
            

            $comment = "Hi " . $staff['name'] . ", " . $job_details['job_type'] . " (#" . $job_details['job_id'] . ") ";

            if ($job_details['job_type_id'] == "1")
            {

                //Job Furnished or not
                $getFurnished = mysql_fetch_array(mysql_query("select furnished from quote_details where quote_id=" . mysql_real_escape_string($job_details['quote_id']) . ""));

                if (strtolower($getFurnished['furnished']) == 'yes')

                {

                    $furnished = ',furnished';

                }

                else
                {

                    $furnished = '';

                }

                //$comment.= " ".$quote_details['bed']." bed ".$quote_details['bath']." bath..{$furnished} for Amount of $".$job_details['amount_total']." ";
                $comment .= " " . $quote_details['bed'] . " bed " . $quote_details['bath'] . " bath..{$furnished}";

            }

            if ($quote['suburb'] != "")
            {
                //$comment .= " in " . $quote['suburb'];
                  $comment .= " in " . $quote['suburb']. ' ('.$quote['postcode'].') ';
            }

            $comment .= " for " . date("d M", strtotime($job_details['job_date']));

            /* else{
            
            $comment.= " for Amount of $".$job_details['amount_total']." ";
            
            } */
            
           

            if ($job_details['job_type_id'] != "11")
            {

                if ($staff['better_franchisee'] != 2 && $staff['payment_type'] != 1)
                {

                    //$comment.= "  for Amount of $".$job_details['amount_total']." ";
                    $comment .= " Amount of $" . $job_details['amount_staff'] . " ";

                }
                else
                {

                    $comment .= '';

                }

            }

            if ($job_details['job_type_id'] == "11")
            {

                $cubic_meters = get_rs_value("staff_trucks", "cubic_meters", $job_details['staff_truck_id']);

                $comment .= " This job is estimated at " . $cubic_meters . " Cubic Metres.";

            }
            else
            {
                        if ($job_details['job_type_id'] == "13")
                        {
                            $comment .= "  has been approved ";
                        }else {

                            $comment .= " is awaiting your review. Please accept within 2 hrs of this notification to secure the work.";
                        }

            }

            $comment .= ' Thank you';

            //$comment.= " Will text you further details on the eve of the job. ";
            

            //echo  $comment; die;
            

            
        }
        else
        {

            // Update Address SMS
            if ($smstype == 'smstype')
            {

                $sms_type = 'add_notification_status';

                $sms_type_date = 'add_notification_date';

            }
            else
            {

                $sms_type = 'address_sms';

                $sms_type_date = 'address_sms_date';

            }

            $emailids = '';

            if ($job_details['job_type_id'] == "3")
            {

                $emailids = " (" . $quote['email'] . ")";

            }

            $heading = "Send " . $job_details['job_type'] . " Address SMS to " . $staff['name'] . " on " . $staff['mobile'];

            $comment = "Hi " . $staff['name'] . ", " . $eol . $job_details['job_type'] . " (#" . $job_details['job_id'] . ") Job for " . $eol . " " . mysql_real_escape_string($quote['name']) . " " . $eol . " " . $quote['phone'] . $emailids . " " . $eol;

            if ($job_details['job_type_id'] == "11")
            {

                $comment .= " from " . mysql_real_escape_string($quote['moving_from']) . " to " . mysql_real_escape_string($quote['moving_to']) . " , Job details are ";

            }
            else
            {

                $comment .= " at " . mysql_real_escape_string($quote['address']) . ", Job details are ";

            }

            $comment .= $eol . " " . $quote_details['description'];

            if ($staff['better_franchisee'] != 2 && $staff['payment_type'] != 1)
            {

                //$comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
                $comment .= " $" . $job_details['amount_staff'];

            }

            $comment .= " " . $eol . " (" . date("d M", strtotime($job_details['job_date'])) . " @ " . $job_details['job_time'] . ") ";

            if ($job_details['job_type_id'] == "2" || $job_details['job_type_id'] == "3")
            {

                $carpet_pending = '';

                //$comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
                

                $cleaning_staff_id = get_sql("job_details", "staff_id", " where job_id=" . mysql_real_escape_string($job_details['job_id']) . " and (job_type_id=1 OR job_type_id= 8) and status!=2");

                if ($cleaning_staff_id != "" && $cleaning_staff_id != 0 && $job_details['staff_id'] != $cleaning_staff_id)
                {

                    $cleaning_staff = mysql_fetch_array(mysql_query("select name , mobile from staff where id=" . mysql_real_escape_string($cleaning_staff_id) . ""));

                    $comment .= ". Please contact Cleaner " . $cleaning_staff['name'] . " on " . $cleaning_staff['mobile'] . " for the job timings. ";

                }

                //$comment.=$eol."Please invoice to ".$quote['email'].".";
                

                
            }
            elseif ($job_details['job_type_id'] == "1")
            {

                $carpet_pending = '';

                $allstaffid = (mysql_query("select staff_id , job_type  from job_details where job_id=" . mysql_real_escape_string($job_details['job_id']) . "  AND staff_id != 0 AND job_type_id != 1 and status!=2 group by staff_id"));

                // $comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
                

                if (mysql_num_rows($allstaffid) > 0)
                {

                    $comment .= " Please contact ";

                    $comment1 = '';

                    while ($getstaff = mysql_fetch_array($allstaffid))
                    {

                        if ($getstaff['staff_id'] != $job_details['staff_id'])
                        {

                            $staffdetails = mysql_fetch_assoc(mysql_query("select id, name , mobile from staff where id =" . mysql_real_escape_string($getstaff['staff_id']) . ""));

                            $comment1 .= $getstaff['job_type'] . " Cleaner " . $staffdetails['name'] . " on " . $staffdetails['mobile'] . " & ";

                        }

                    }

                    $comment .= rtrim($comment1, ' & ');

                    $comment .= " for the job timings. ";

                }

            }
            else
            {

                //$comment.=" $".$job_details['amount_total']." ".$eol." (".date("d M",strtotime($job_details['job_date']))." @ ".$job_details['job_time'].") ";
                
            }

            $comment .= $eol . "Thanks .";

            if ($job_details['job_type_id'] == "11")
            {

                $comment .= " Please call client to confirm arrangement ";

            }

        }

        //echo  $comment; die;
        

        $comment = str_replace('\'', '', addslashes(trim($comment)));

        $sms_for_notify = get_rs_value("siteprefs", "sms_for_notify", 1);

        if ($sms_for_notify == 1)
        {

            if ($smstype == 'smstype')
            {

                $getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '" . $job_details['staff_id'] . "'"));

                $result['user_to'] = get_rs_value("staff", "name", $job_details['staff_id']);

                $result['chatter'] = $job_details['staff_id'];

                $result['admin_id'] = $_SESSION['admin'];

                $result['admin'] = 'admin';

                $result['job_id'] = $job_details['job_id'];

                if (!empty($getlogin_device['deviceid']))
                {

                    if ($getlogin_device['deviceid'] != '')
                    {

                        $heading .= " (Notification Delivered)";

                        $flag = 1;

                        $result['deviceid'] = $getlogin_device['deviceid'];

                    }
                    else
                    {

                        $heading .= "  <span style=\"color:red;\">(Notification Failed)</span>";

                        $flag = 2;

                        $result['deviceid'] = $getlogin_device['deviceid'];

                    }
					
					
					

                    sendNotiMessage($comment, $result);

                }
                else
                {

                    $flag = 3;

                    $heading .= "  <span style=\"color:red;\">(Notification failed because is not using the app)</span>";

                }

            }
            else
            {

                $sms_code = send_sms(str_replace(" ", "", $staff['mobile']) , $comment);

                if ($sms_code == "1")
                {
                    $heading .= " (Delivered)";
                    $flag = 1;
                }
                else
                {
                    $heading .= " <span style=\"color:red;\">(Failed)</span>";
                    $flag = 2;
                }

            }

        }
        else
        {

            $getlogin_device = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(device_id) as deviceid  FROM `login_device` WHERE is_logged_in = 1 AND device_id != '' AND login_id = '" . $job_details['staff_id'] . "'"));

            // print_r($getlogin_device); die;
            

            $result['user_to'] = get_rs_value("staff", "name", $job_details['staff_id']);

            $result['chatter'] = $job_details['staff_id'];

            $result['admin_id'] = $_SESSION['admin'];

            $result['admin'] = 'admin';

            $result['job_id'] = $job_details['job_id'];

            if ($getlogin_device['deviceid'] != '')
            {

                $heading .= " (Notification Delivered)";

                $flag = 1;

                $result['deviceid'] = $getlogin_device['deviceid'];
				
				//print_r($result); die;    

                sendNotiMessage($comment, $result);

            }
            else
            {

                $sms_code = send_sms(str_replace(" ", "", $staff['mobile']) , $comment);

                if ($sms_code == "1")
                {
                    $heading .= " (Delivered)";
                    $flag = 1;
                }
                else
                {
                    $heading .= " <span style=\"color:red;\">(Failed)</span>";
                    $flag = 2;
                }

            }

        }

        add_job_notes($job_details['job_id'], $heading, $comment);

        if ($flag == '1')
        {

            mysql_query("update job_details set $sms_type ='1',$sms_type_date ='" . date('Y-m-d h:i:s') . "' where id=" . $job_details_id . "");

            if ($pagetype == 'report')
            {

                include ('dispatch_report.php');

            }
            else
            {

                echo date('Y-m-d h:i:s');

            }

        }
        elseif ($flag == 3)
        {

            $staff_name = get_rs_value("staff", "name", $job_details['staff_id']);

            echo $staff_name . " is not installed the app";

        }
        else
        {

            if ($pagetype == 'report')
            {

                include ('dispatch_report.php');

            }
            else
            {

                echo "Not sent";

            }

        }

    }
    else
    {

        echo " Pls Select Staff ";

    }

}

function sendFranchiseReport($vars)

{

    $var = explode('|', $vars);

    $id = $var[0];

    $staffid = $var[0];

    $getbcicinvoice = mysql_fetch_array(mysql_query("SELECT * FROM `franchise_report` WHERE id = " . $id . ""));

    /*  require_once($_SERVER["DOCUMENT_ROOT"]."/dompdf/dompdf_config.inc.php");
    
    
    
    $dompdf = new Dompdf();
    
    $dompdf->set_paper(array(0, 0, 794, 1123), 'portrait');
    
    
    
    $html2 = base64_decode($getbcicinvoice['email']);
    
    
    
    $dompdf->load_html($html2);
    
    $dompdf->load_html(utf8_decode($html2), 'UTF-8');
    
    $dompdf->render();  */

    $folder = $_SERVER['DOCUMENT_ROOT'] . '/franchise_report/';

    $foldername = $folder . $getbcicinvoice['staff_id'];

    $filename = $getbcicinvoice['date_name'] . '_' . $getbcicinvoice['year'] . '_bbc_report';

    $name = $filename . '.pdf';

    $filePath = $foldername . '/' . $name;

    //	file_put_contents($filePath, $dompdf->output());
    

    //$message = send_invoice_email($var);
    

    $message = '';

    $getstaffdetails = mysql_fetch_assoc(mysql_query("select * from staff where id = " . $getbcicinvoice['staff_id'] . ""));

    // $sendto_email = 'pankaj@business2sell.com.au';
    //$sendto_email = 'ashish@business2sell.com.au';
    $sendto_email = $getstaffdetails['email'];

    // $sendto_email = 'manish@bcic.com.au';
    //$sendto_email = 'pankaj.business2sell@gmail.com';
    $subject = $getstaffdetails['name'] . ' BBC Report From ' . changeDateFormate($getbcicinvoice['invoice_from_date'], 'datetime') . ' To ' . changeDateFormate($getbcicinvoice['invoice_to_date'], 'datetime');

    //mysql_query("UPDATE `bcic_invoice` SET `invoice_send_date` = '".date('Y-m-d H:i:s')."' , `is_send` = '1'   WHERE `bcic_invoice`.`id` = ".$var."");
    

    sendmailwithattach_staff_invoce1($getstaffdetails['name'], $sendto_email, $subject, $message, 'noreply@bcic.com.au', $filePath, $filename);

    echo 'BBC Report send successfully';

}

function getDeniedPercentage($fromdate, $todate, $staffid)

{

    $countofferJobs = 0;

    $countdeny = 0;

    $offerjobsql = mysql_query("SELECT * FROM `staff_jobs_status` WHERE staff_id = " . $staffid . " and created_at >= '" . $fromdate . "' AND created_at <= '" . $todate . "' and status = 5 GROUP by job_id");

    $countofferJobs = mysql_num_rows($offerjobsql);

    $denySql = mysql_query("SELECT * FROM `staff_jobs_status` WHERE staff_id = " . $staffid . "  and created_at >= '" . $fromdate . "' AND created_at <= '" . $todate . "' and status in (2 , 3) GROUP by job_id");

    $countdeny = mysql_num_rows($denySql);

    $totaldenie_per = ($countdeny / $countofferJobs) * 100;

    return number_format($totaldenie_per, 2);

}

function getWeekenRoster($fromdate, $todate, $staffid)

{

    $totalroster = 0;

    //echo "SELECT * FROM `staff_roster` WHERE staff_id = ".$staffid." and date >= '".$fromdate."' and date <= '".$todate." and status = 1";
    

    $activerosterSql = mysql_query("SELECT * FROM `staff_roster` WHERE staff_id = " . $staffid . " and date >= '" . $fromdate . "' and date <= '" . $todate . "' and status = 1");

    $rostercount = mysql_num_rows($activerosterSql);

    $totalroster = ($rostercount / 7) * 100;

    return number_format($totalroster, 2);

}

function getRecleanInWeek($fromdate, $todate, $staffid)
{

    //echo  "SELECT id FROM `job_reclean` WHERE staff_id = ".$staffid." and reclean_date>='".$fromdate."' AND reclean_date <='".$todate."'  and status != 2  group by job_id";
    

    $failed_re = mysql_query("SELECT id FROM `job_reclean` WHERE staff_id = " . $staffid . " and reclean_date>='" . $fromdate . "' AND reclean_date <='" . $todate . "'  and status != 2  group by job_id");

    return mysql_num_rows($failed_re);

}

function staffjobdetailsinfo($date, $staffid)
{

    $sql = mysql_query("SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = " . $staffid . " and job_date = '" . $date . "'  AND job_type_id = 1  AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC");

    if (mysql_num_rows($sql) > 0)
    {

        while ($getdata = mysql_fetch_assoc($sql))
        {

            $data1[] = array(

                'job_id' => $getdata['job_id'],

                'amount_total' => $getdata['amount_total'],

                'amount_profit' => $getdata['amount_profit'],

                'amount_staff' => $getdata['amount_staff'],

                'quote_id' => $getdata['quote_id'],

                'upsell' => $getdata['upsell']

            );

        }

    }

    return $data1;

}

function checkupsell($job_date, $sid)
{

    $sql = mysql_query("SELECT id,upsell_denied from jobs WHERE  status in (1 , 3)  AND id in (SELECT job_id   FROM `job_details` WHERE staff_id = " . $sid . "  and job_date = '" . $job_date . "'   AND  status != 2 )");

    if (mysql_num_rows($sql) > 0)
    {

        while ($getdata = mysql_fetch_assoc($sql))
        {

            $data12 = array(

                'job_id' => $getdata['id'],

                'upsell_denied' => $getdata['upsell_denied']

            );

        }

    }

    return $data12;

}

function checkextraamount($date, $staffid)
{

    $sql = mysql_query("SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = " . $staffid . " and job_date = '" . $date . "'  AND job_type_id = 13  AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC");

    if (mysql_num_rows($sql) > 0)
    {

        return 1;

    }
    else
    {

        return 0;

    }

}

//     function checkextraamount($date , $staffid) {


// 		$sql = mysql_query("SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = ".$staffid." and job_date = '".$date."'   AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC");


// 		 if(mysql_num_rows($sql) > 0) {
// 		    return 1;
// 		 }else {
// 		 return 0;
// 		 }
//     }


function checkstaffavail($fromdate, $todate, $staffid)
{

    /*  $sql =  "SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = ".$staffid." and job_date >= '".$fromdate."' AND job_date <= '".$todate."'  AND job_type_id = 13  AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC";  */

    $sql1 = mysql_query("SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = " . $staffid . " and job_date >= '" . $fromdate . "' AND job_date <= '" . $todate . "'  AND job_type_id = 13  AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC");

    //return $sql;
    

    if (mysql_num_rows($sql1) > 0)
    {

        // return $sql;
        return mysql_num_rows($sql1);

    }
    else
    {

        return 0;

    }

}

// 		function checkstaffavail($fromdate ,$todate , $staffid) {


// 	 	$sql1 = mysql_query("SELECT amount_total , job_id , quote_id , start_time , end_time,   amount_staff , amount_profit , upsell   FROM `job_details` WHERE staff_id = ".$staffid." and job_date >= '".$fromdate."' AND job_date <= '".$todate."'   AND  status != 2 AND (end_time = '0000-00-00 00:00:00' OR job_id in (SELECT id from jobs WHERE status in (1,3))) GROUP by job_id  ORDER by job_date DESC");
// 		  //return $sql;


// 		  if(mysql_num_rows($sql1) > 0) {
// 		   // return $sql;
// 		   return mysql_num_rows($sql1);
// 		 }else {
// 		     return 0;
// 		 }
//     }


function checkExtraJob($jobid)
{

    $sql = mysql_query("SELECT id ,amount_total    FROM `job_details` WHERE job_id = " . $jobid . " and status != 2  AND job_type_id = 13");

    if (mysql_num_rows($sql) > 0)
    {

        $checkf = 1;

        $data = mysql_fetch_assoc($sql);

        $extraamount = $data['amount_total'];

    }
    else
    {

        $checkf = 0;

        $extraamount = 0;

    }

    return array(
        'checkf' => $checkf,
        'extraamount' => $extraamount
    );

}

function send_reviewform($datefrom, $fromto, $faluttype = 3)

{

    $arg = "SELECT * FROM `bcic_review` where 1=1 ";

    $arg .= " AND review_date>= '" . $datefrom . "' and review_date <='" . $fromto . "'";

    if ($faluttype != 0)
    {

        $arg .= " AND  fault_type ='" . $faluttype . "'";

    }

    $arg .= " order by id desc";

    $sql = mysql_query($arg);

    $countResult = mysql_num_rows($sql);

    while ($data = mysql_fetch_assoc($sql))
    {

        $staffdetails = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(staff_id) as staffid ,  GROUP_CONCAT(job_type) as jobtype , job_date from job_details where job_id=" . $data['job_id'] . "  and status!=2 order by job_type_id asc"));

        $staffdetailsname = mysql_fetch_assoc(mysql_query("select GROUP_CONCAT(name) as sname from staff where id in  (" . $staffdetails['staffid'] . ") order by id asc"));

        $fault_type = getSystemvalueByID($data['fault_type'], 97);

        $data['sname'] = $staffdetailsname['sname'];

        $data['fault_type'] = $fault_type;

        $getdatalist[] = $data;

    }

    $file = "review_tpl.php";

    ob_start(); // start buffer
    include ($_SERVER['DOCUMENT_ROOT'] . "/email_template/" . $file);

    $content = ob_get_contents(); // assign buffer contents to variable
    ob_end_clean(); // end buffer and remove buffer contents
    return $content;

}

function SMSnotificationAdd($mobile, $text, $staffid)

{

    $source = '0429504482'; //sender ( Bcic ) FROM Dedicated
    

    //$admin = get_rs_value("admin","name",$_SESSION['admin']);
    $staffname = get_rs_value("staff", "name", $staffid);

    /* $sql = mysql_query("INSERT INTO `bcic_sms` ( `read_by`, `admin_id`, `to_num`, `to_num_code`, `from_num`, `from_num_code`, `message`, `account_id`, `msg_id`, `date_sent`, `date_time`, `only_date`, `only_time`, `sender`, `receiver`, `type`, `incoming_msg_type`, `status`, `is_deleted`, `apiVersion`, `media`, `uri`, `baseUrl`, `from_where`) VALUES ('0', '".$_SESSION['admin']."', '".$mobile."', '+61', '".$source."', '+61', '".$text."', '', '', '".date('Y-m-d')."', '".date('Y-m-d H:i:s  A')."', '".date('Y-m-d')."', '".date('Y-m-d H:i:s  A')."', '', '', 'staff', NULL, 'SUCCESS', '1', 'none', 'none', 'none', '', NULL)"); */

    $date = strtotime(date('Y-m-d'));

    /* echo  "INSERT INTO `chat` (`to`, `from`, `message`, `time`, `sender_read`, `receiver_read`, `sender_deleted`, `receiver_deleted`, `to_id`, `chat_type`, `chat_exact_time`, `admin_id`, `is_chat_job_id`, `response`) VALUES ('".$staffname."', '".$_SESSION['admin']."', '".$text."', '".$date."', 'no', 'no', 'no', 'no', '".$staffid."', 'admin', '".date('Y-m-d H:i:s  A')."', NULL, '0', NULL);"; */

    mysql_query("INSERT INTO `chat` (`to`, `from`, `message`, `time`, `sender_read`, `receiver_read`, `sender_deleted`, `receiver_deleted`, `to_id`, `chat_type`, `chat_exact_time`, `admin_id`, `is_chat_job_id`, `response`) VALUES ('" . $staffname . "', '" . $_SESSION['admin'] . "', '" . mysql_real_escape_string($text) . "', '" . $date . "', 'no', 'no', 'no', 'no', '" . $staffid . "', 'admin', '" . date('Y-m-d H:i:s  A') . "', NULL, '0', NULL);");

}

function getAllStaffname()
{

    $sql = mysql_query("select id , name, mobile from staff  where status = 1");

    while ($data = mysql_fetch_assoc($sql))
    {

        //$staffdetails[$data['id']] = array($data['name'] ,$data['mobile']) ;
        $staffdetails[$data['id']] = $data['name'];

    }

    // print_r($staffdetails);
    return $staffdetails;

}

function getSite($type = 1)
{

    $sql = mysql_query("select id , name , abv from sites");

    while ($data = mysql_fetch_assoc($sql))
    {

        if ($type == 1)
        {

            $sitedetails[$data['id']] = $data['name'];

        }
        elseif ($type == 2)
        {

            $sitedetails[$data['id']] = $data['abv'];

        }
        else
        {

            $sitedetails[$data['id']] = $data['name'];

        }

    }

    return $sitedetails;

}

function system_dd_type($typeid , $order = 'id')
{

   if($typeid == 123) {
           $sql = mysql_query("select id , name from system_dd where type = " . $typeid . "  AND id != 3  Order by $order asc");
   }else{
      $sql = mysql_query("select id , name from system_dd where type = " . $typeid . " Order by $order asc");
   }

    while ($data = mysql_fetch_assoc($sql))
    {

        $stepsdata[$data['id']] = $data['name'];

    }

    return $stepsdata;

}

function jobIcone()
{

    $sql = mysql_query("select id , name , job_icon  from job_type ");

    while ($data = mysql_fetch_assoc($sql))
    {

        $getjobicone[$data['id']] = $data['job_icon'];

    }

    return $getjobicone;

}

function getadminnamedata()
{

    $sql = mysql_query("select id , name   from admin where is_call_allow = 1 and status = 1 ");

    while ($data = mysql_fetch_assoc($sql))
    {

        $getadminname[$data['id']] = $data['name'];

    }

    return $getadminname;

}

function CountStaffImage($job_id, $staffid, $job_type)
{

    $sql = mysql_query("SELECT COUNT(image_status) as imgs , image_status FROM `job_befor_after_image` WHERE job_id = " . $job_id . " and staff_id = " . $staffid . " AND job_type_status = " . $job_type . " GROUP by image_status");

    if (mysql_num_rows($sql) > 0)
    {

        while ($getdata = mysql_fetch_assoc($sql))
        {

            $getimg[$getdata['image_status']] = $getdata['imgs'];

        }

    }

    return $getimg;

}

function updateloggedinTime($id, $type)
{

    if ($type == 1)
    {

        mysql_query("update admin set loggedin ='" . date('Y-m-d H:i:s') . "' , loggedtime = '" . time() . "' , login_status = 1 where id=" . $id . "");

    }
    else if ($type == 2)
    {

        mysql_query("update admin set login_status = 0 where id=" . $id . "");

    }

}

function getadminLoggIn($sname, $cid)
{

    $createdOn = date("Y-m-d H:i:s");

    $ins_arg = "insert into admin_logged set admin_id='" . $_SESSION['admin'] . "',";

    $ins_arg .= " country_id='" . $cid . "',";

    $ins_arg .= " in_time='" . date("Y-m-d H:i:s") . "',";

    //$ins_arg.=" out_time='".date("Y-m-d h:i:s")."',";
    $ins_arg .= " createdOn='" . $createdOn . "',";

    $ins_arg .= " logtime='" . $_SESSION['logtime'] . "',";

    $ins_arg .= " admin_name='" . $sname . "',";

    $ins_arg .= " ip_address='" . $_SERVER['REMOTE_ADDR'] . "'";
    
    //echo $ins_arg; 

    $ins = mysql_query($ins_arg);
    
   

}

function getadminLoggOut()
{

    if ($_SESSION['logtime'] != '')
    {

        mysql_query("UPDATE `admin_logged` SET `out_time` = '" . date("Y-m-d H:i:s") . "' WHERE logtime  = " . $_SESSION['logtime'] . " AND admin_id = " . $_SESSION['admin'] . "");

    }

}

function getEmailsRecord($fromdate, $todate, $emailid, $adminid)
{

    //$arg = "SELECT * FROM `email_activity`   WHERE date_time >=  '".$fromdate."' and date_time <=  '".$todate."' AND  email_id = '".$emailid."'";
    

    $arg = "SELECT * FROM `email_activity`   WHERE date_time >=  '" . $fromdate . "' and date_time <=  '" . $todate . "' AND  ( p_id = '" . $emailid . "' OR email_id = '" . $emailid . "')";

    if ($adminid != 0)
    {

        $arg .= " AND staff_id = " . $adminid . "";

    }

    $arg .= " Order by id asc";

    //echo $sql1;
    $sql1 = mysql_query($arg);

    $countsubrec = mysql_num_rows($sql1);

    $opendata = array();

    if ($countsubrec > 0)
    {

        while ($getdata = mysql_fetch_assoc($sql1))
        {

            $opendata[] = ($getdata);

        }

    }

    return $opendata;

    //echo '<pre>'; print_r($opendata);
    

    
}

function CalculateTime($starttime, $endtime)
{

    $date1 = new DateTime($starttime);

    $date2 = $date1->diff(new DateTime($endtime));

   //print_r($date2);

    $h = $date2->h;

    $m = $date2->i;

    $s = $date2->s;

    return $h . ':' . $m . ':' . $s;

}

function getaemaildailySend($date, $adminid, $type = null)
{

    $fromdate = date('Y-m-d 00:00:00', strtotime($date));

    $todate = date('Y-m-d 23:59:00', strtotime($date));

    $sql = mysql_query("SELECT  COUNT(mail_flag) as totalemails , mail_flag FROM `bcic_email` WHERE createdOn >= '" . $fromdate . "' and createdOn <= '" . $todate . "' AND email_send_admin_id =  " . $adminid . "  GROUP by mail_flag");

    while ($data = mysql_fetch_array($sql))
    {

        //return $data['totalemails'];
        $getdata[$data['mail_flag']] = $data['totalemails'];

    }

    return $getdata;

}

function getrefundtemplate($res, $filename)
{

    ini_set('display_errors', 1);

    ini_set('display_startup_errors', 1);

    error_reporting(E_ALL);

    $response = $res;

    //print_r($res);
    $file = "refund.php";

    ob_start(); // start buffer
    include ($_SERVER['DOCUMENT_ROOT'] . "/email_template/" . $file);

    $content = ob_get_contents(); // assign buffer contents to variable
    ob_end_clean(); // end buffer and remove buffer contents
    

    //echo  $content;
    

    //$content = 'hello';
    //echo  '<style>.views-row {display: block;}</style>';
    

    include ($_SERVER["DOCUMENT_ROOT"] . "/dompdf/dompdf_config.inc.php");

    $dompdf = new Dompdf();

    $dompdf->set_paper(array(
        0,
        0,
        794,
        1123
    ) , 'portrait');

    $dompdf->load_html($content);

    $dompdf->load_html(utf8_decode($content) , 'UTF-8');

    $dompdf->render();

    $imgPath = $_SERVER['DOCUMENT_ROOT'] . '/refund/';

    file_put_contents($imgPath . $filename, $dompdf->output());

    // print_r($dompdf);
    return base64_encode($content);

}

function dd_value($type)
{

    $sql = mysql_query("select id , name   from system_dd where type = " . $type . " AND status = 1");

    while ($data = mysql_fetch_assoc($sql))
    {

        $getvalue[$data['id']] = $data['name'];

    }

    return $getvalue;

}

function getDistancedata_forstaff($addressFrom, $addressTo, $unit = 'K' )

{
     if($unit == 463) {
       $addressTo = '3 Rima Place, Hassall Grove, NSW 2761, Australia';
     }
     
    /* if($unit == 647) {
       $addressTo = '179 MAIN ST THOMASTOWN VIC 3074, Australia';
     }
     */
    /* echo $unit. '<br/>';
    if($unit == 647) {
    echo '<pre>';
    print_r($response_all);
    //echo $unit;
    }*/
     
	// Google API key
    //	$apiKey = 'AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo';
    $apiKey = 'AIzaSyDXKY-R3HUK8sMa72JEeJdl9dok9XcB1ko';

    // Change address format
    $formattedAddrFrom = str_replace(' ', '+', $addressFrom);

    $formattedAddrTo = str_replace(' ', '+', $addressTo);

    // Geocoding API request with start address
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . strtolower($formattedAddrFrom) . "&destination=" . strtolower($formattedAddrTo) . "&key=" . $apiKey . "&sensor=false";

	 //echo $url.'<br/>';
	 
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

    curl_close($ch);

    $response_all = json_decode($response);
    
	
	$distance = $response_all->routes[0]
        ->legs[0]
        ->distance->text;

    $time = $response_all->routes[0]
        ->legs[0]
        ->duration->text;

		
		
    return array(
        'distance' => $distance,
        'time' => $time
    );

}

function getcronsReport()
{

    $bool = mysql_query("SELECT * FROM `bcic_reports`");

    if (mysql_num_rows($bool) > 0)
    {

        while ($getdata = mysql_fetch_assoc($bool))
        {

            $data[] = $getdata;

        }

        //print_r($data)	;
        

        return $data;

    }
    else
    {

        return array();

    }

}


function getTaskReCord($loginid, $stageskey, $fromdate, $todate, $type, $data = null, $type11 = 0)
{

    // echo  $loginid . ' == '.$stageskey. ' == '.$fromdate. ' == '. $todate; die;
    

    $today = date('Y-m-d');

    $fromtoday = date('Y-m-d H:i:s', strtotime('-30 minutes'));

    $lasttoday = date('Y-m-d H:i:s', strtotime("+90 minutes"));

    if ($data == 1)
    {

        $argsql1 = "select id ,quote_id from sales_task_track  where 1 = 1 AND task_status = 1  AND admin_id = " . $loginid . "";

    }
    else
    {

        $argsql1 = "select id ,quote_id from sales_task_track  where 1 = 1 AND task_status = 1  AND task_manage_id = " . $loginid . "";

    }

    $argsql1 .= " AND track_type = 1 AND   quote_id in ( ";

    $argsql1 .= " select id  from quote_new where 1 = 1 AND ( booking_date >= '" . $today . "'  OR booking_date = '0000:00:00' ) AND removal_enquiry_date = '00:00:00 00:00:00'";

	if($type11 == 0) {
	
	}elseif($type11 == 1) {
       // Cleaning	
      $argsql1 .= " AND moving_from = '' AND is_flour_from = 0 "; 
	}elseif($type11 == 2) {
	 // Removal
	   $argsql1 .= " AND moving_from != '' AND is_flour_from > 0 "; 
	}
	
    $argsql1 .= " AND booking_id = 0 AND bbcapp_staff_id = 0 AND step not in (8,9,10) AND  denied_id = 0";

    $argsql1 .= " AND date >= '" . $fromdate . "' AND date <= '" . $todate . "'";

    $argsql1 .= " )";

    //if($type == 1) {
    if ($stageskey == 1)
    {

        //$argsql1 .= " AND  fallow_date < '" . $fromtoday . "' ";
		$argsql1 .=  " AND  fallow_date < '".$fromtoday."' AND (ans_date != '0000-00-00 00:00:00' OR left_sms_date != '0000-00-00 00:00:00')";
			$argsql1 .=  "  ORDER BY  fallow_date DESC";

    }
    elseif ($stageskey == 2)
    {

        //$argsql1 .= " AND  fallow_date >= '" . $fromtoday . "' AND fallow_date <= '" . $lasttoday . "'";
		$argsql1 .=  " AND  ((fallow_date >= '".$fromtoday."' AND fallow_date <= '".$lasttoday."') OR (ans_date = '0000-00-00 00:00:00' AND left_sms_date = '0000-00-00 00:00:00'))";
			$argsql1 .=  "  ORDER BY  left_sms_date ,ans_date ASC";

    }
    elseif ($stageskey == 3)
    {

        $argsql1 .= " AND  fallow_date >= '" . $lasttoday . "'";

    }

    //}
    

    //echo  $argsql1;
    // return   $argsql1;
    $sql = mysql_query($argsql1);

    $countre = mysql_num_rows($sql);

    if ($type == 1)
    {

        return $countre;

    }
    else
    {

        while ($data = mysql_fetch_assoc($sql))
        {

            $qdata[$data['id']] = $data['quote_id'];

        }

        return $qdata;

    }

}

function getTodayOverDueTaskReCord($loginid , $fromdate , $todate ,$type , $currenttype = 0){
		
		    $today = date('Y-m-d');
			
			//$lasttoday = date('Y-m-d H:i:s' , strtotime("+90 minutes")); 
			/* $fromtoday = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
			$lasttoday = date('Y-m-d H:i:s' , strtotime("+90 minutes"));  */
			
			$fromtoday = date('Y-m-d H:i:s' , strtotime('-30 minutes'));
			
			$argsql1 = "select id ,quote_id from sales_task_track  where 1 = 1 AND task_status = 1 AND track_type = 1 AND task_manage_id = ".$loginid."";
			$argsql1 .= " AND   quote_id in ( "; 
			$argsql1 .= " select id  from quote_new where 1 = 1 AND ( booking_date >= '".$today."'  OR booking_date = '0000:00:00' ) ";

			$argsql1 .=  " AND booking_id = 0 AND bbcapp_staff_id = 0 AND step not in (8,9,10) AND  denied_id = 0";
			//$argsql1 .=  " AND date >= '".$fromdate."' AND date <= '".$todate."'";

			$argsql1 .= " )"; 
			
    		if($currenttype == 1) {
    		    	$argsql1 .=  " AND DATE(fallow_date) = '".date('Y-m-d')."' AND   fallow_date <= '".$fromtoday."'";
    		    
    		} else {
    			$argsql1 .=  " AND DATE(fallow_date) = '".date('Y-m-d')."' AND   fallow_date >= '".$fromdate."' AND fallow_date <= '".$todate."' ";
    		}
		 
		   
		 // echo  $argsql1;  
		 // return   $argsql1;
		   $sql  = mysql_query($argsql1);
		  
		 $countre = mysql_num_rows($sql);
		  if($type == 1) {
		     return $countre; 
		  }else {
			    while($data = mysql_fetch_assoc($sql))  {
				   $qdata[$data['id']] = $data['quote_id'];
			    }  
				
				 return $qdata;
		  }
	}

function getTotalTaskReCord($loginid, $stageskey, $fromdate, $todate, $type, $data)
{

    // echo  $loginid . ' == '.$stageskey. ' == '.$fromdate. ' == '. $todate; die;
    

    $today = date('Y-m-d');

    $fromtoday = date('Y-m-d H:i:s', strtotime('-30 minutes'));

    $lasttoday = date('Y-m-d H:i:s', strtotime("+90 minutes"));

    $argsql1 = "select id ,quote_id from sales_task_track  where 1 = 1 AND task_status = 1 AND track_type = 1   AND task_manage_id = " . $loginid . "";

    $argsql1 .= " AND   quote_id in ( ";

    $argsql1 .= " select id  from quote_new where 1 = 1 AND ( booking_date >= '" . $today . "'  OR booking_date = '0000:00:00' ) ";

    $argsql1 .= " AND booking_id = 0 AND step not in (8,9,10) AND  denied_id = 0";

    $argsql1 .= " AND date >= '" . $fromdate . "' AND date <= '" . $todate . "'";

    $argsql1 .= " )";

    //if($type == 1) {
    if ($stageskey == 1)
    {

        $argsql1 .= " AND  fallow_date < '" . $fromtoday . "' ";

    }
    elseif ($stageskey == 2)
    {

        $argsql1 .= " AND  fallow_date >= '" . $fromtoday . "' AND fallow_date <= '" . $lasttoday . "'";

    }
    elseif ($stageskey == 3)
    {

        $argsql1 .= " AND  fallow_date >= '" . $lasttoday . "'";

    }

    //}
    

    //echo  $argsql1;  die;
    // return   $argsql1;
    $sql = mysql_query($argsql1);

    $countre = mysql_num_rows($sql);

    if ($type == 1)
    {

        return $countre;

    }
    else
    {

        while ($data = mysql_fetch_assoc($sql))
        {

            $qdata[$data['id']] = $data['quote_id'];

        }

        return $qdata;

    }

}

function getsalestrackReCord($loginid, $stageskey, $fromdate, $todate)

{

    $today = date('Y-m-d');

    $sql = "select * from sales_task_track  where 1 = 1 AND task_status = 1 AND track_type = 1  AND task_manage_id = " . $loginid . "  AND quote_id in (select id  from quote_new where 1 = 1 ";

    $sql .= " AND ( booking_date >= '" . $today . "'  OR booking_date = '0000:00:00' )  AND step not in (8,9,10)  ";

    $sql .= " AND date >= '" . $fromdate . "' AND date <= '" . $todate . "'";

    if (in_array($stageskey, array(
        1,
        2,
        3,
        4,
        5
    )))
    {

        $sql .= " AND   step   in (1,2,3,4) AND denied_id = 0 AND  booking_id = 0";

    }
    elseif ($stageskey == 6)
    {

        $sql .= " AND date = '" . date('Y-m-d') . "' AND booking_id != 0 ";

    }
    else if ($stageskey == 7)
    {

        $sql .= " AND date = '" . date('Y-m-d') . "' AND booking_id = 0 AND step  in (5,6,7)";

    }
    else
    {

        $sql .= " AND  booking_id = 0";

    }

    $sql .= " )";

    if (!in_array($stageskey, array(
        6,
        7
    )))
    {

        $sql .= " AND stages = '" . $stageskey . "'";

    }

    $argsql1 = mysql_query($sql);

    $countre = mysql_num_rows($argsql1);

    return $countre;

}

function cehckForeverLogin($user, $pass)
{

    $user_data_c = mysql_query("select id , login_forever  from admin where username='" . mysql_real_escape_string($user) . "' and pwd='" . mysql_real_escape_string($pass) . "' AND  find_in_set('1', admin_type) AND status = 1");

    if (mysql_num_rows($user_data_c) > 0)
    {

        $admin = mysql_fetch_array($user_data_c);

        return $admin['login_forever'];

    }
    else
    {

        return 0;

    }

}

function AutoAssignTask()
{

    $fromdate = date("Y-m-d H:i:s", strtotime('-2 day'));

    $todate = date("Y-m-d 12:00:00");

    //
    $getadminDetails = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids   FROM `admin` WHERE status = 1 and is_call_allow = 1 AND login_status = 1  and auto_role in (1) order by id"));

    if ($getadminDetails['ids'] != '')
    {

        //print_r($getadminDetails);
        $adminid = explode(',', $getadminDetails['ids']);

        // print_r($adminid);   die;
        

        if (count($adminid) > 1)
        {

            $sql = mysql_query("SELECT * FROM `sales_system`   WHERE  task_manage_id = 0 ORDER BY `id` DESC");

            $countrec = mysql_num_rows($sql);

            // echo $countrec; die;
            

            $i = 0;

            while ($data = mysql_fetch_assoc($sql))
            {

                if ($adminid[$i] != '')
                {

                    $task_manage_id = $adminid[$i];

                    $i++;

                }
                else
                {

                    $task_manage_id = $adminid[0];

                    $i = 0;

                    $i++;

                }

                if ($task_manage_id != '')
                {

                    mysql_query("UPDATE `sales_system` SET `task_manage_id` = " . $task_manage_id . " WHERE id  = " . $data['id'] . "");

                    $login_id = get_rs_value("quote_new", "login_id", $data['quote_id']);

                    if ($login_id != 0)
                    {

                        mysql_query("UPDATE `quote_new` SET `login_id` = " . $task_manage_id . " WHERE id  = " . $data['quote_id'] . "");

                    }

                }

            }

        }

    }

}

function quotesharetoeveryOne($quotdid, $type, $autocurrent = null)
{

    if ($type == 0)
    {

        $getadminDetails = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids   FROM `admin` WHERE status = 1 and is_call_allow = 1 AND login_status = 1  and auto_role in (1) order by id"));

    }
    else
    {

        $getadminDetails['ids'] = $type;

    }

    if ($getadminDetails['ids'] != '')
    {

        //print_r($getadminDetails);
        

        $adminid = explode(',', $getadminDetails['ids']);

        // print_r($adminid);
        

        if (count($adminid) > 0)
        {

            //echo $quotdid . '<br/>';

            // $sql = mysql_query("SELECT * FROM `sales_system`   WHERE  quote_id in (".$quotdid.")");
            $sql = mysql_query("SELECT * FROM `sales_task_track` WHERE quote_id in (" . $quotdid . ") and task_status = 1 AND track_type = 1");

            $countrec = mysql_num_rows($sql);

            // echo $countrec; die;
            

            $i = 0;

            while ($data = mysql_fetch_assoc($sql))
            {

                if ($adminid[$i] != '')
                {

                    $task_manage_id = $adminid[$i];

                    $i++;

                }
                else
                {

                    $task_manage_id = $adminid[0];

                    $i = 0;

                    $i++;

                }

                //print_r($data);
                if ($task_manage_id != '')
                {

                    if ($autocurrent == 1)
                    {

                        if (date('i') <= '30')
                        {

                            $schedule_from = date('H') . ':00';

                            $schedule_to = date('H') . ':30';

                        }
                        else
                        {

                            $schedule_from = date('H') . ':30';

                            $schedule_to = date('H', strtotime('+1 hour')) . ':00';

                        }

                        $fallow_time = $schedule_from . '-' . $schedule_to;

                        $fallow_date = date('Y-m-d H:i:s');

                        $bool = mysql_query("update sales_task_track set task_manage_id ='" . $task_manage_id . "' , fallow_date ='" . $fallow_date . "'  , fallow_created_date ='" . $fallow_date . "'  , fallow_time ='" . $fallow_time . "'  where id=" . $data['id'] . " AND track_type = 1");

                        mysql_query("INSERT INTO `task_manager` (`fallow_date`, `fallow_time`, `completed_date`, `admin_id`, `task_type`, `quote_id`, `job_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('" . $fallow_date . "', '" . $fallow_time . "', '" . date('Y-m-d H:i:s') . "', '" . $task_manage_id . "', '1', '" . $data['quote_id'] . "', '0', '12', '" . $data['id'] . "', '" . date('Y-m-d H:i:s') . "', '0');");
						
					    $lastid = mysql_insert_id();
						
					mysql_query("INSERT INTO `task_sales_assign` (`admin_id`, `created_date`, `task_id`) VALUES ('".$task_manage_id."', '".date('Y-m-d H:i:s')."', ".$lastid.");");

                        $adminname = get_rs_value("admin", "name", $task_manage_id);

                        $fromadminname = get_rs_value("admin", "name", $data['task_manage_id']);

                        $heading = 'Automated Moved ' . $fromadminname . ' to ' . $adminname;

                        add_quote_notes($data['quote_id'], $heading, $heading, '', 'Automated');

                        /* $adminname = get_rs_value("admin","name",$task_manage_id);
                        
                        $fromadminname = get_rs_value("admin","name",$data['task_manage_id']);
                        
                        echo $heading = 'Automated Moved '.$fromadminname.' to '.$adminname; */

                    }
                    else
                    {
					   
					    if($task_manage_id > 0) {
						
							 mysql_query("INSERT INTO `task_manager` (`completed_date`, `admin_id`, `task_type`, `quote_id`, `job_id`, `response_type`, `task_id`, `created_date`, `status`) VALUES ('" . date('Y-m-d H:i:s') . "', '" . $task_manage_id . "', '1', '" . $data['quote_id'] . "', '0', '12', '" . $data['id'] . "', '" . date('Y-m-d H:i:s') . "', '0');");
							
							$lastid = mysql_insert_id();
							
							  mysql_query("INSERT INTO `task_sales_assign` (`admin_id`, `created_date`, `task_id`) VALUES ('".$task_manage_id."', '".date('Y-m-d H:i:s')."', ".$lastid.");");

							$adminname = get_rs_value("admin", "name", $task_manage_id);

							$fromadminname = get_rs_value("admin", "name", $data['task_manage_id']);
						   
						 
							$heading1 = 'Automated Moved  ' . $fromadminname . ' to ' . $adminname;
							

							add_quote_notes($data['quote_id'], $heading1, $heading1, '', 'Automated');

							$bool = mysql_query("update sales_task_track set task_manage_id ='" . $task_manage_id . "'  where id=" . $data['id'] . " AND track_type = 1");
						}

                    }

                }

            }

        }
        else
        {

            echo 'Sales Staff  not available';

        }

    }

}

function send_voucher_emailsdata($qdata, $RandomString, $reviewl_link ='https://www.productreview.com.au/listings/bcic')
{

    if (!empty($qdata))
    {

        $qdata = mysql_fetch_array(mysql_query("select *  from bcic_review where job_id = " . $qdata['booking_id'] . ""));

        $eol = '<br/>';
		
		$reviewlink = '<a  target="_blank" href='.$reviewl_link.'> Click </a>';
		
		//echo  $reviewlink; die;
		
		$reviewurl = 'https://www.productreview.com.au/listings/bcic/write-review';
		$str = 'Hi ' . $qdata['name'] . ',' . $eol . '' . $eol . '

         Thank you so much for your recent feedback! ' . $eol . '

<h4>We will send you a <span style="color: red;"> $50 Thank your Spring Clean Voucher </span> -as our Token of appreciation for your FEEDBACK. </h4>' . $eol .'
We hope that your move went well, and you are settling into your new home.' . $eol . $eol . '

<h4>We have a Huge Favour to ask and we need you HELP.</h4>  ' . $eol .  $eol . '

We cannot emphasize how important is it for us to get your feedback.  .' . $eol . ' 

AS ever evolving world, ONLINE BUSINESSES SOLELY DEPEND ON ONLINE REVIEWS   .' . $eol . '
Good work hardly gets appreciated, but 1 small mistake out of 100 jobs we do every week gets highlighted on social media
We just want people to know that we do good work too.   ' . $eol . '

It takes less than 5 minutes to leave a 5 Star Review ON Product Review,   ' . $eol . '  . ' . $eol . '

'.$reviewurl.'   ' . $eol   . $eol . '

These Reviews are so important for the survival of a local business.  ' . $eol . '
Please, we cannot thank you enough for your time and appreciation.   ' . $eol . '

Thank you again for your time,   ' . $eol . '

BCIC Team ';

        return $str;

    }

}

function getCouponCode()
{

    $im = imagecreate(300, 32);

    // White background and blue text
    $bg = imagecolorallocate($im, 255, 255, 255);

    $textcolor = imagecolorallocate($im, 0, 0, 0);

    $codedata = genRandomString();

    // Write the string at the top left
    imagestring($im, 5, 0, 0, 'Coupon code: ' . $codedata . '', $textcolor);

    // Output the image
    header('Content-type: image/png');

    imagepng($im);

    imagedestroy($im);

    return $im;

}

function genRandomString()
{

    $length = 10;

    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

    $string = '';

    for ($p = 0;$p < $length;$p++)
    {

        $string .= $characters[mt_rand(0, strlen($characters)) ];

    }

    return ucwords($string);

}

function get_sales_activity($qid, $tasktype = 1, $box_type = 1)
{
    $arg = '';
    if($box_type == 1) {
		$arg = ' AND response_type != 12';
	}elseif($box_type == 2){
		$arg = ' AND response_type = 12';
	}

    $sql = mysql_query("SELECT * FROM `task_manager`  WHERE quote_id = " . $qid . " AND task_type = " . $tasktype . " AND admin_id != 0  ".$arg." ORDER BY `id` DESC");

    $arrdata = array();

    if (mysql_num_rows($sql))
    {

        while ($data = mysql_fetch_assoc($sql))
        {

            $arrdata[] = $data;

        }

    }

    //print_r($arrdata);
    return $arrdata;

}

function getClientImages($job_id, $type, $job_type)
{

    $sql = mysql_query("SELECT * FROM `client_image_befor_after` WHERE job_id = " . $job_id . " and img_type = " . $type . " AND job_type = '" . $job_type . "'");

    $allimges = array();

    if (mysql_num_rows($sql) > 0)
    {

        while ($getimg = mysql_fetch_assoc($sql))
        {

            $allimges[] = array(

                'id' => $getimg['id'],

                'img' => $getimg['image_url'],

                'createdOn' => $getimg['createdOn'],

                'img_type' => $getimg['img_type']

            );

        }

    }

    return $allimges;

}

function getOpr_Payment($stageskey, $adminid)
{

    $todate = date("Y-m-d", strtotime("+1 day"));

    $arg = "SELECT job_details.job_date as jobDate,jobs.id as jid,  jobs.status as jobStatus, jobs.sms_client_cleaner_details as csms  , quote_new.name as cx_name, quote_new.id as qid, quote_new.phone as cphone , quote_new.site_id as siteid , quote_new.date as qdate, quote_new.booking_date as jdate, jobs.customer_amount as job_amt, jobs.eway_token as ewaytoken , sites.name as sname, jobs.payment_agree_check as jagreePay  FROM jobs LEFT JOIN sites ON jobs.site_id = sites.id LEFT JOIN quote_new ON jobs.quote_id = quote_new.id LEFT JOIN job_details on job_details.quote_id = quote_new.id WHERE 1=1 AND job_details.status != 2 AND job_details.job_date = '" . $todate . "'   AND jobs.status = 1";

    if ($adminid == 'all')
    {

    }
    else if ($adminid > 0)
    {

        $arg .= " AND jobs.task_manage_id = " . $adminid . "";

    }

    $arg .= " group by job_details.job_id  ORDER BY job_details.staff_id ASC";

    //echo $arg;
    $sql = mysql_query($arg);

    $count = mysql_num_rows($sql);

    if ($count > 0)
    {

        while ($tjdata = mysql_fetch_assoc($sql))
        {

            $jid1 = totalAmountofJob($tjdata['jid']);

            $tjdata['paid_amt'] = $jid1;

/*             if ($jid1 < $tjdata['job_amt'] && $stageskey == '5')
            {

                $jobnotDone[$stageskey][] = $tjdata;

            }
            elseif ($jid1 == $tjdata['job_amt'] && $stageskey == 6)
            {

                $jobnotDone[$stageskey][] = $tjdata;

            } */
			
			$jobnotDone[$stageskey][] = $tjdata;

        }

    }

    return $jobnotDone;

}

function OndayJobs($stageskey, $today, $jobtypeid = 1, $adminid)

{

    $argsql1 = "SELECT quote_new.id as qid ,job_details.job_time as jtime ,  job_details.job_date as jobDate,job_details.job_acc_deny as WorkStatus,job_details.start_time as start,job_details.end_time as end,jobs.id as id, sites.name as site_name ,sites.abv as site_abv, jobs.status as jobStatus, jobs.accept_terms_status as accepterms_status,jobs.team_id as teamname,jobs.team_name as team_name, quote_new.name as cx_name, quote_new.date as job_date, quote_new.booking_date as jdate, jobs.customer_amount as job_amt,jobs.upsell_denied as upselldenied, jobs.upsell_admin as upselladmin,jobs.upsell_required as upsellrequired, jobs.email_client_booking_conf as email_client_booking_conf, jobs.email_client_cleaner_details as email_client_cleaner_details ,jobs.review_email_time as review_email_time , jobs.sms_client_cleaner_details as sms_client_cleaner_details FROM jobs LEFT JOIN sites ON jobs.site_id = sites.id LEFT JOIN quote_new ON jobs.quote_id = quote_new.id LEFT JOIN job_details on job_details.quote_id = quote_new.id WHERE 1=1 AND job_details.status != 2 AND jobs.status = 1  ";

    //1=>before , 2=> after , 3 => checklist , 4=>guarantee , 5 => upsell
    

    $argsql1 .= "  AND job_details.job_date = '" . $today . "'";

    if ($adminid == 'all')
    {

    }
    else
    {

        $argsql1 .= "  AND jobs.task_manage_id = " . $adminid . "";

    }

    if ($jobtypeid != 0)
    {

        $argsql1 .= " AND job_details.job_type_id = " . $jobtypeid . "";

    }

    if ($stageskey == 0)
    {

        // Total
        

        
    }
    else if ($stageskey == 1)
    {

        // Not Started
        $argsql1 .= " AND job_details.start_time = '0000-00-00 00:00:00' AND job_details.end_time = '0000-00-00 00:00:00'";

    }
    elseif ($stageskey == 2)
    {

        $argsql1 .= " AND job_details.start_time != '0000-00-00 00:00:00' AND job_details.end_time = '0000-00-00 00:00:00'  AND job_details.job_id NOT IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (1) AND job_type_status = 1) ";

        //"AND job_details.job_id NOT IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (1) AND job_type_status = 1) ";
        

        
    }
    elseif ($stageskey == 3)
    {

        //Before ==> (uploaded and Work in progress ): When before photos uploaded
        $argsql1 .= " AND job_details.start_time != '0000-00-00 00:00:00' AND job_details.end_time = '0000-00-00 00:00:00'  AND job_details.job_id IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (1) AND job_type_status = 1) ";

    }
    elseif ($stageskey == 4)
    {

        //After => When After Image are NOT Uploaded and Job is completed
        $argsql1 .= " AND job_details.end_time != '0000-00-00 00:00:00' AND job_details.job_id NOT IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (2) AND job_type_status = 1) ";

    }
    elseif ($stageskey == 5)
    {

        //Upsell => If Up sell Images are uploaded show here ( doesn’t matter what job status is ) .
        $argsql1 .= " AND ( job_details.job_id  IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (5) AND job_type_status = 1) OR havily_soiled = 1 )";

    }
    elseif ($stageskey == 6)
    {

        //No Guarantee => : If No G Images are uploaded show here
        $argsql1 .= "  AND job_details.job_id  IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (4) AND job_type_status = 1) ";

    }
    elseif ($stageskey == 7)
    {

        //CheckList => If job is completed and NO Checklist is uploaded
        $argsql1 .= " AND job_details.end_time != '0000-00-00 00:00:00'  AND job_details.job_id NOT IN (SELECT DISTINCT(job_id) as jobid FROM `job_befor_after_image` WHERE  image_status IN (3) AND job_type_status = 1) ";

    }
    elseif ($stageskey == 8)
    {

        //Complete
        $argsql1 .= " AND job_details.start_time != '0000-00-00 00:00:00' AND job_details.end_time != '0000-00-00 00:00:00' ";

    }

    $argsql1 .= " group by job_details.job_id ORDER BY job_details.job_type_id ASC";

    //$argsql1 .= " ORDER BY job_details.job_type_id ASC";
    

   // echo $argsql1;
    

    $argsql = mysql_query($argsql1);

    $count = mysql_num_rows($argsql);

    if ($count > 0)

    {

        while ($data = mysql_fetch_assoc($argsql))
        {

            $getdata[$stageskey][] = $data;

        }

    }

    return $getdata;

}

function getBefor_jobDay($stageskey, $adminid, $fromdate = '', $todate = '')
{

    $argsql1 = "SELECT * FROM `jobs` WHERE  1 = 1  ";

    $argsql1 .= " AND status = 1 AND job_date > '" . date('Y-m-d') . "'";
	
	
	 if ($stageskey == 1)
    {
       $argsql1 .= "  AND  id IN (SELECT DISTINCT(job_id) as jobid FROM `job_details` WHERE  1 = 1 AND status != 2 AND staff_id = 0  AND job_date > '" . date('Y-m-d') . "'  ORDER BY `id` DESC) ";
    }
	
    $argsql1 .= " AND id IN  ( ";

    $argsql1 .= " select job_id from sales_task_track  where 1 = 1 AND track_type = 2 ";

    if ($adminid == 'all')
    {

    }
    elseif ($adminid > 0)
    {

        $argsql1 .= " AND task_manage_id = " . $adminid . "";

    }

    if ($stageskey == 1)
    {
	

       
       // $argsql1 .= " AND   left_sms_date = '0000-00-00 00:00:00' AND ans_date = '0000-00-00 00:00:00'  AND check_question = '0000-00-00 00:00:00' AND  job_date > '" . date('Y-m-d' , strtotime('+1 day')) . "'  AND id not in ( SELECT DISTINCT(job_id) as jobid FROM `client_image_befor_after` ) ";
	   
        $argsql1 .= " AND check_question = '0000-00-00 00:00:00' AND  left_sms_date = '0000-00-00 00:00:00' AND ans_date = '0000-00-00 00:00:00' AND  bfr_img_ans_date = '0000-00-00 00:00:00' AND bfr_img_not_ans_date = '0000-00-00 00:00:00'  AND  job_date > '" . date('Y-m-d' , strtotime('+1 day')) . "'  AND id NOT IN ( SELECT DISTINCT(job_id) as jobid FROM `client_image_befor_after` ) ";
		
       // $argsql1 .= " AND   left_sms_date = '0000-00-00 00:00:00' AND check_question = '0000-00-00 00:00:00' AND  ans_date = '0000-00-00 00:00:00' AND date >= '" . date('Y-m-d' , strtotime('-4 day')) . "' AND date <= '".date('Y-m-d')."'  AND id not in ( SELECT DISTINCT(job_id) as jobid FROM `client_image_befor_after` )";
		

    }
    elseif ($stageskey == 2)
    {

        $argsql1 .= " AND  (left_sms_date != '0000-00-00 00:00:00' OR bfr_img_not_ans_date != '0000-00-00 00:00:00')";

    }
    elseif ($stageskey == 3)
    {

        $argsql1 .= " AND  ( ans_date != '0000-00-00 00:00:00'  OR bfr_img_ans_date  != '0000-00-00 00:00:00'  OR bfr_img_checked_date != '0000-00-00 00:00:00' OR check_question != '0000-00-00 00:00:00') ";

    }
    if ($stageskey == 5)
    {

       $argsql1 .= " AND (job_date = '" . date('Y-m-d' , strtotime('+1 day')) . "' OR job_date = '" . date('Y-m-d' , strtotime('+2 day')) . "' ) ";
        
    }

    if ($fromdate != '' && $todate != '')
    {

        $argsql1 .= " AND DATE(createOn) >= '" . $fromdate . "' AND DATE(createOn) <= '" . $todate . "'";

    }
    if ($stageskey != 8)
    {
      $argsql1 .= " ) ";
	}
	
	if ($stageskey == 7)
    {

       $argsql1 .= " AND  id in (SELECT DISTINCT(job_id) as jobid  FROM `job_details` WHERE  job_date = '".date('Y-m-d', strtotime('+1 day'))."'   and status != 2  ORDER BY `id` DESC  ) ";
        
    }
	if ($stageskey == 8)
    {

       $argsql1 .= " AND  bfr_img_checked_date = '0000-00-00 00:00:00' ) AND   id in ( SELECT DISTINCT(job_id) as jobid FROM `client_image_befor_after` ) ";
        
    }
	
    if ($stageskey == 4)
    {

        /*  $argsql1 .=  " AND  id in (SELECT DISTINCT(job_id) as jobid FROM `job_details` WHERE  1 = 1 AND status != 2  AND job_date > '".date('Y-m-d')."'  ORDER BY `id` DESC)"; */

        $argsql1 .= " AND job_date > '" . date('Y-m-d' , strtotime('+1 day')) . "' AND id in (SELECT DISTINCT(job_id) as jobid FROM `job_details` WHERE  1 = 1 AND status != 2 AND staff_id != 0  AND job_date > '" . date('Y-m-d') . "'  ORDER BY `id` DESC)";

    }

    $argsql1 .= " ORDER by job_date ASC";

    //echo $argsql1;
    

    $argsql = mysql_query($argsql1);

    $count = mysql_num_rows($argsql);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($argsql))
        {

            $getdata[$stageskey][] = $data;

        }

    }

    return $getdata;

}

/*  function getBefor_jobDay($stageskey, $adminid , $fromdate = '', $todate= '' ){

		

		$argsql1 = "select * from sales_task_track  where 1 = 1 AND track_type = 2";

		

		//if($adminid != 0) {

		    $argsql1 .= " AND task_manage_id = ".$adminid."";

		//}

			$argsql1 .= " AND   job_id in ( "; 

			$argsql1 .= " SELECT id FROM `jobs` WHERE  1 = 1  ";

			$argsql1 .=  " AND status = 1 AND job_date > '".date('Y-m-d')."' ORDER by job_date asc";

			$argsql1 .= " ) "; 

		 	

		if($stageskey == 1) {

			  $argsql1 .=  " AND   left_sms_date = '0000-00-00 00:00:00' AND   ans_date = '0000-00-00 00:00:00' ";

		}elseif($stageskey == 2) {

			   $argsql1 .=  " AND  left_sms_date != '0000-00-00 00:00:00'";

		}elseif($stageskey == 3) {

			   $argsql1 .=  " AND  ans_date != '0000-00-00 00:00:00'";

		}elseif($stageskey == 4) {

			  $argsql1 .=  " AND  job_id in (SELECT DISTINCT(job_id) as jobid FROM `job_details` WHERE  1 = 1 AND status != 2 AND staff_id != 0  AND job_date > '".date('Y-m-d')."'  ORDER BY `id` DESC)";

		}elseif($stageskey == 7) {

			//$argsql1 .=  " 1 AND 11 1ans_date != '0000-00-00 00:00:00'";

		}

		if($fromdate !='' && $todate != '') {

		  $argsql1 .=  " AND DATE(createOn) >= '".$fromdate."' AND DATE(createOn) <= '".$todate."'";

		}

		

		//echo $argsql1;

		  $argsql1 .=  " ORDER by id desc";

		 $argsql = mysql_query($argsql1);

		 $count = mysql_num_rows($argsql);

		 //echo $count;

		  if($count > 0) {

			 while($data = mysql_fetch_assoc($argsql)) {

				 

				  $getdata[$stageskey][] = $data;

			 }

		 } 

		return $getdata; 

	}  */

function getsubheading($id)
{

    // echo $id;
    if ($id == 1)
    {

        $gettrackdata = dd_value(113);

    }
    elseif ($id == 2)
    {

        $gettrackdata = dd_value(116);

    }
    elseif ($id == 3)
    {

        $gettrackdata = dd_value(117);

    }
    elseif ($id == 4)
    {

        $gettrackdata = dd_value(123);

    }   
	elseif ($id == 5)
    {

        $gettrackdata = dd_value(131);

    }   
	elseif ($id == 6)
    {

        $gettrackdata = dd_value(137);

    }elseif ($id == 7)
    {

        $gettrackdata = dd_value(138);

    }

    return $gettrackdata;

}

function getQuestiondata($trackids)
{

    $argsql1 = "SELECT * FROM `operation_checklist` WHERE id in (" . $trackids . ")";

    $argsql = mysql_query($argsql1);

    $count = mysql_num_rows($argsql);

    if ($count > 0)

    {

        while ($data = mysql_fetch_assoc($argsql))
        {

            $getdata[] = $data;

        }

    }

    return $getdata;

}

function check_question_is_cehcked($salestrackid, $track_id, $stageskey)
{

    $argsql1 = "SELECT id , ans FROM `operation_ans` WHERE sales_id = " . $salestrackid . " AND track_id = " . $track_id . " and track_head_id = " . $stageskey . "";

    $argsql = mysql_query($argsql1);

    $count = mysql_num_rows($argsql);

    if ($count > 0)
    {

        $ans_no = 0;

        $ans_yes = 0;

        while ($getdata = mysql_fetch_array($argsql))
        {

            if ($getdata['ans'] == '0')
            {

                $ans_no++;

            }
            if ($getdata['ans'] == '1')
            {

                $ans_yes++;

            }

        }

        if ($count == $ans_yes)
        {

            return 1;

        }
        else
        {

            return 2;

        }

    }
    else
    {

        return 0;

    }

}

function getAfterJobs_data($stageskey, $adminid = 0, $pagetype = 0)

{

    $date = date('Y-m-d');

    $arg = "SELECT id, review_call_done  FROM `jobs` WHERE 1 = 1 ";

    if ($adminid == 'all')
    {

    }
    elseif ($adminid > 0)
    {

        $arg .= " AND task_manage_id = " . $adminid . "";

    }

    /* if($pagetype == 1) {
    
    $arg .=  " AND task_manage_id = ".$adminid."";
    
    }
    
    */

    if ($stageskey == 1)
    {

        //•	Job Finished: All Jobs that are completed and not paid will; be in here and status is active
        // $arg .=" AND status = 1 AND job_date <= '".$date."' AND id in (SELECT job_id FROM `job_details` where pay_staff = 0 AND   status != 2 AND ( end_time != '0000-00-00 00:00:00' OR start_time != '0000-00-00 00:00:00' )) ";
        $arg .= " AND status = 1 AND job_date < '" . $date . "' AND id in (SELECT job_id FROM `job_details` where payment_completed = 0 AND   status != 2 ) ";

    }
    elseif ($stageskey == 2)
    {

        //•	After Job Images Received: If client uploads after images job will show here
        $arg .= " AND status = 1 AND job_date < '" . $date . "' AND id in (SELECT  DISTINCT(job_id) as jobid FROM `client_image_befor_after` WHERE job_type = 1 and img_type = 2)";

    }
    elseif ($stageskey == 3)
    {

        //•	Re-cleans: Show all jobs sitting in re-clean latest on top by date
        $arg .= " AND status = 5 AND id in (SELECT DISTINCT(job_id) as jid from job_reclean WHERE status != 2 and reclean_date <= '" . $date . "' and end_time != '0000-00-00 00:00:00') AND id in (SELECT job_id FROM `job_details` where payment_completed = 0 AND   status != 2 )";

    }
    elseif ($stageskey == 4)
    {

        //•	Complaint: Show all jobs in complaint
        $arg .= " AND status = 4 AND id in (SELECT job_id FROM `job_details` where payment_completed = 0 AND   status != 2 )";

    }
    elseif ($stageskey == 5)
    {

        //•	Job Completed: All jobs completed and review email that are out, and have not been called  for Review
        $arg .= " AND status = 3 and review_email_time != '0000-00-00 00:00:00' AND review_call_done = '0000-00-00 00:00:00' AND job_date <= '" . $date . "'  AND id in (SELECT job_id FROM `job_details` where payment_completed = 0 AND   status != 2 ) ";

    }
    elseif ($stageskey == 6)
    {

        //•	Review Call Not Answered – LM, will try calling one more time or SMS in this time.
        $arg .= " AND status = 3 AND job_date <= '" . $date . "' AND left_message != '0000-00-00 00:00:00' AND review_call_done = '0000-00-00 00:00:00'";

    }
    elseif ($stageskey == 7)
    {

        //•	Review Call & SMS Done – Once call is done, they come here for 7 days
        $pretday = date('Y-m-d', strtotime('-7 day'));

        // review_call_done
        $arg .= " AND status = 3  AND DATE(review_call_done) >= '" . $pretday . "' AND DATE(review_call_done) <= '" . $date . "'";

    }
    elseif ($stageskey == 8)
    {

        //•	Review Received - Reviews Received (Negative or Positive)
        $arg .= " AND status = 3 AND review_email_time != '0000-00-00 00:00:00' AND id in ( SELECT DISTINCT(job_id) as jibs FROM `bcic_review` where  review_date >= '" . date('Y-m-01') . "' AND review_date <= '" . date('Y-m-d') . "')";

    }

    //echo $arg;
    

    $argsql = mysql_query($arg);

    $count = mysql_num_rows($argsql);

    //echo $count;
    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($argsql))
        {

            $getdata1[$stageskey][] = $data;

        }

    }

    return $getdata1;

}

function reclean_data($stageskey, $adminid = 0, $pagetype = 0)
{
    $date = date('Y-m-d');

    $arg = "SELECT id, review_call_done , new_re_clean,reclean_received  , reclean_region_notes, job_date , arrange_reclean_date_noti,  awaiting_exit_report , exit_awating_admin FROM `jobs` WHERE 1 = 1 ";

    if ($adminid == 'all')
    {

    }
    elseif ($adminid > 0)
    {
        $arg .= " AND task_manage_id = " . $adminid . "";

    }

    if ($stageskey == 1)
    {
        //New Email
		$fromdate = date('Y-m-d' ,  strtotime('-45 day'));
       
	   //$arg .= " and status in (1,3) AND acc_payment_check != 1 AND new_re_clean = 1 AND id NOT  IN ( SELECT DISTINCT(job_id) FROM `job_reclean` WHERE   status = 0 ) AND id in (SELECT DISTINCT(job_id)  FROM job_details WHERE status = 0 and acc_payment_check = 0)  AND id IN ( SELECT DISTINCT(job_id) FROM `bcic_email` WHERE mail_type = 'reclean' AND folder_type = 'INBOX' ) ";
		
	   // $arg .= " and status in (1,3) AND acc_payment_check != 1 AND new_re_clean = 1 AND id NOT  IN ( SELECT DISTINCT(job_id) FROM `job_reclean` WHERE   status = 0 ) AND id in (SELECT DISTINCT(job_id)  FROM job_details WHERE status = 0 and acc_payment_check = 0)  AND id IN ( SELECT DISTINCT(job_id) FROM `bcic_email` WHERE email_category = '4' AND folder_type = 'INBOX' AND email_assign in (1 , 2) ) ";
		
	   $arg .= " and status in (1,3) AND acc_payment_check != 1 AND new_re_clean = 1  AND id IN ( SELECT DISTINCT(job_id) FROM `bcic_email` WHERE email_category = '4' AND folder_type = 'INBOX' AND email_assign in (1 , 2) AND DATE(createdOn) >= '".$fromdate."') ";
    
    }
    elseif ($stageskey == 2)
    {

         //•Awaiting Exit Report
         $arg .= " AND status = 9  AND ( awaiting_exit_report = '0000-00-00 00:00:00' OR awaiting_exit_receive = '0000-00-00 00:00:00')  ";

    }
    elseif ($stageskey == 3)
    {
        //•	Exit Report Receive
		$arg .= " AND status = 9 AND  awaiting_exit_receive != '0000-00-00 00:00:00'";
		//$arg .= " AND status = 9 AND ( awaiting_exit_report != '0000-00-00 00:00:00' OR awaiting_exit_receive != '0000-00-00 00:00:00') ";
        //$arg .= " AND status = 5 AND id in (SELECT DISTINCT(job_id) as jid from job_reclean WHERE status != 2 AND reclean_status = 1)";
    }
    elseif ($stageskey == 4)
    {
      //•Admin Assigned 
      //  $arg .= " AND exit_awating_admin != 0";
      $arg .= " AND exit_awating_admin != 0   AND status != 3";

    }
    elseif ($stageskey == 5)
    {
        // Cleaner Assigned
     $arg .= " AND status = 5 AND id  in (SELECT DISTINCT(job_id) FROM `job_reclean`WHERE reclean_status = 1  AND reclean_updated_date = '0000-00-00 00:00:00')  AND id in (SELECT job_id FROM `job_details` where payment_completed = 0 AND   status != 2 )";

    }
    elseif ($stageskey == 6)
    {
        //•	Cleaner Accepted
        $arg .= " AND status = 5 AND id  in (SELECT DISTINCT(job_id) FROM `job_reclean`WHERE reclean_updated_date != '0000-00-00 00:00:00' ) ";
    }
    /* elseif ($stageskey == 7)
    {

        //•	ReClean Images
        $arg .= " AND status = 5 AND  id in (SELECT job_id FROM `job_reclean` WHERE DATE(reclean_date) = '" . date('Y-m-d') . "')";

    }
    elseif ($stageskey == 8)
    {

        //•	Review Received - Reviews Received (Negative or Positive)
        $arg .= " AND status = 5 AND id in (SELECT DISTINCT(job_id) as jid from job_reclean WHERE status != 2 AND reclean_status = 4)";

    } */

    // echo $arg;
    $argsql = mysql_query($arg);

    $count = mysql_num_rows($argsql);

   // echo $count;
	
    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($argsql))
        {
                  
		    if($stageskey == 1) {		  
			
				 $getemaildate = mysql_fetch_assoc(mysql_query("SELECT email_date, email_assign    FROM `bcic_email` WHERE `job_id` = ".$data['id']."  ORDER BY `id` desc LIMIT 0 ,1"));
			     if(!empty($getemaildate)) {
					  
				       $getemailtime = changeDateFormate($getemaildate['email_date'] , 'timestamp');
					   
					   $data['email_date'] = $getemailtime;
					   $data['email_assign'] = $getemaildate['email_assign'];
					   
					  
				    }
             			
            
			}
			  $getdata1[$stageskey][] = $data;

        }

    }
	  
		 
      return $getdata1;
}


function reclean_job_data($stageskey, $adminid = 0, $pagetype = 0)
{

    $date = date('Y-m-d');

    $arg = "SELECT id, review_call_done  FROM `jobs` WHERE 1 = 1  AND status = 5";

    if ($adminid == 'all')
    {

    }
    elseif ($adminid > 0)
    {

        $arg .= " AND task_manage_id = " . $adminid . "";

    }
	
/* 	if($stageskey == 0){
	
	  
	} */
	

    if ($stageskey == 1)
    {

        //•	No Date Time Select
        $arg .= "   AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2 AND reclean_updated_date = '0000-00-00 00:00:00' AND reclean_date = '".date('Y-m-d')."')";

    }
    elseif ($stageskey == 2)
    {

        //• Not Started
        $arg .= "   AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2 AND start_time = '0000-00-00 00:00:00'  AND reclean_date = '".date('Y-m-d')."')";

    }
    elseif ($stageskey == 3)
    {

        //•	Started
        $arg .= "  AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2 AND start_time != '0000-00-00 00:00:00'  AND reclean_date = '".date('Y-m-d')."')";

    }
    elseif ($stageskey == 4)
    {

        //•	Before
         $arg .= " AND id in (SELECT DISTINCT(job_id) FROM `job_befor_after_image` WHERE image_status = 1 AND job_type_status = 2) AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2  AND reclean_date = '".date('Y-m-d')."')";
		  

    }
    elseif ($stageskey == 5)
    {

        //•	After
        $arg .= "   AND id in (SELECT DISTINCT(job_id) FROM `job_befor_after_image` WHERE image_status = 2 AND job_type_status = 2) AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2  AND reclean_date = '".date('Y-m-d')."')";

    }
    elseif ($stageskey == 6)
    {

        //•	Checklist
       $arg .= "   AND id in (SELECT DISTINCT(job_id) FROM `job_befor_after_image` WHERE image_status = 3 AND job_type_status = 2) AND id in (SELECT DISTINCT(job_id) as job_id FROM `job_reclean`  WHERE status != 2  AND reclean_date = '".date('Y-m-d')."')";

    }
    elseif ($stageskey == 7)
    {
        //•Complited
        $arg .= "  AND id in (SELECT DISTINCT(job_id) as jid from job_reclean WHERE status != 2 AND reclean_status = 4 AND reclean_date = '".date('Y-m-d')."')";

    }
    

   // echo $arg;
    $argsql = mysql_query($arg);

    $count = mysql_num_rows($argsql);

    //echo $count;
    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($argsql))
        {

            $getdata1[$stageskey][] = $data;

        }

    }
   return $getdata1;

}

function getOverallReview($jobid)
{

    $getdata = mysql_fetch_assoc(mysql_query("SELECT overall_experience , review_date FROM `bcic_review` where 1=1 AND job_id = " . $jobid . " AND job_type = 1"));

    $yellow_star = $getdata['overall_experience'];

    $review_date = $getdata['review_date'];

    return array(
        'yellow_star' => $yellow_star,
        'review_date' => $review_date
    );

}


function getReCleanJobsOntheDay($stageskey, $qid)

{

   $sql_icone = ("select job_type_id ,job_id ,  start_time , end_time , reclean_date, staff_id ,  job_type from job_reclean where  status != 2 AND quote_id=" . $qid . " order by job_type_id asc ");

    $quote_details = mysql_query($sql_icone);

    $count = mysql_num_rows($quote_details);

    if ($count > 0)
    {

        while ($qd = mysql_fetch_assoc($quote_details))
        {

            $getdata[] = $qd;

        }

    }

    return $getdata;

}

function getReCleanJobs($stageskey, $qid)

{

    if ($stageskey == 1 || $stageskey == 2 || $stageskey == 3)
    {

        $sql_icone = ("select job_type_id , job_id , start_time , end_time , job_date,  staff_id ,  job_type from job_details where  status != 2 AND quote_id=" . $qid . " order by job_type_id asc ");

    }
    else
    {

        $sql_icone = ("select job_type_id ,job_id ,  start_time , end_time , reclean_date, staff_id ,  job_type from job_reclean where  status != 2 AND quote_id=" . $qid . " order by job_type_id asc ");

    }

    $quote_details = mysql_query($sql_icone);

    $count = mysql_num_rows($quote_details);

    if ($count > 0)
    {

        while ($qd = mysql_fetch_assoc($quote_details))
        {

            $getdata[] = $qd;

        }

    }

    return $getdata;

}

function getStaff($type = 0)
{

    $arg = "select id , name, mobile, bbc_leads, primary_post_code,better_franchisee from staff  where 1 = 1 AND status = 1";

    if ($type > 0)
    {

        $arg .= " AND better_franchisee = '" . $type . "'";

    }

    $sql = mysql_query($arg);

    while ($data = mysql_fetch_assoc($sql))
    {

        //$staffdetails[$data['id']] = array($data['name'] ,$data['mobile']) ;
        $staffdetails[] = $data;

    }

    return $staffdetails;

}

function GetLeadStaff($type = 0)
{

    $arg = "SELECT `id`, `name`, `email`, `mobile`,`bbc_leads`, `maxleadcnt`, `typeoflead`, `leadradius`, `leaddays`, `noofjobsaday` FROM `staff` WHERE 1";

    if ($type > 0)
    {

        $arg .= " AND better_franchisee = '" . $type . "'";

    }

    $sql = mysql_query($arg);

    while ($data = mysql_fetch_assoc($sql))
    {

        //$staffdetails[$data['id']] = array($data['name'] ,$data['mobile']) ;
        $staffdetails[] = $data;

    }

    return $staffdetails;

}


function getReviewData($year, $month, $staffid)

{

    $arg = "SELECT COUNT(id) as totalCount,  sum(overall_experience) as experienceReview FROM `bcic_review`  WHERE YEAR(review_date) = " . $year . " AND MONTH(review_date) = " . $month . " and job_id in (SELECT DISTINCT(job_id) as jobid FROM `job_details` WHERE staff_id = " . $staffid . "  AND  status != 2)";

    $sql = mysql_query($arg);

    $data = mysql_fetch_array($sql);

    return array(
        'count' => $data['totalCount'],
        'experienceReview' => $data['experienceReview']
    );

}

function WeeklyviewData($siteid)

{

    $lastmoday = date('Y-m-d', strtotime("last week monday"));

    $lastsunday = date('Y-m-d', strtotime("last week sunday"));

    $arg = "SELECT COUNT(id) as totalCount,  sum(overall_experience) as experienceReview FROM `bcic_review`  WHERE review_date >= '" . $lastmoday . "' AND review_date <= '" . $lastsunday . "' AND  job_id in (SELECT DISTINCT(job_id) as jobid FROM `job_details` where site_id = " . $siteid . " AND status != 2)";

    $sql = mysql_query($arg);

    $data = mysql_fetch_array($sql);

    return array(
        'count' => $data['totalCount'],
        'experienceReview' => $data['experienceReview']
    );

}

function GetQuoteDetailsIconData($booking_id, $qid)
{

    if ($booking_id == '0')
    {

        $sql_icone = ("select job_type_id , job_type from quote_details where  status != 2 AND quote_id=" . $qid);

    }
    else
    {

        $sql_icone = ("select job_type_id , job_type from job_details where  status != 2 AND quote_id=" . $qid);

    }

    // echo  $sql_icone;
    $quote_details = mysql_query($sql_icone);

    $quotedetails = mysql_num_rows($quote_details);

    $tr_removal = 0;

    if ($quotedetails > 0)
    {

        while ($data = mysql_fetch_assoc($quote_details))
        {

            if ($data['job_type_id'] == 11)
            {

                $tr_removal = 1;

                $getdata[] = $data;

            }
            else
            {

                $getdata[] = $data;

            }

        }

    }

    //print_r($getdata);
    

    return array(
        'tr_removal' => $tr_removal,
        'icondetais' => $getdata
    );

}

function getAllSiteData()
{

    $sql = mysql_query("select id , name ,br_area_code ,area_code , abv  from sites");

    while ($data = mysql_fetch_assoc($sql))
    {

        $sitedetails[$data['id']] = $data;

    }

    return $sitedetails;

}

function getBBCWeeklyReport($fromdate, $todate, $staffid)
{

    $arg = "SELECT id, status FROM `staff_roster` WHERE date >= '" . $fromdate . "' and date <= '" . $todate . "' and staff_id = " . $staffid . "";

    //echo $arg;
    $sql = mysql_query($arg);

    $count = mysql_num_rows($sql);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($sql))
        {

            //$staffdetails[$data['id']] = array($data['name'] ,$data['mobile']) ;
            $staffdetails[$data['status']][] = $data['status'];

        }

        return $staffdetails;

    }

    // print_r($staffdetails);
    
}

function getBBCWeeklyJobReport($fromdate, $todate, $staffid)
{

    $arg = "SELECT id,  (SELECT count('id') FROM `staff_jobs_status` WHERE date >= '" . $fromdate . "' and date <= '" . $todate . "' and status = 5) as job_offered, (SELECT count('id') FROM `staff_jobs_status` WHERE date >= '" . $fromdate . "' and date <= '" . $todate . "' and status = 2) as job_denied FROM `staff_roster`  and staff_id = " . $staffid . "";

    //echo $arg;
    $sql = mysql_query($arg);

    $count = mysql_num_rows($sql);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($sql))
        {

            //$staffdetails[$data['id']] = array($data['name'] ,$data['mobile']) ;
            $staffdetails[$data['status']][] = $data['status'];

        }

        return $staffdetails;

    }

}

function BBCgetTotalAmountOffered($jobid, $jobtypeid)

{

    if (is_array($jobtypeid))
    {

        $job_types = implode(',', $jobtypeid);

    }
    else
    {

        $job_types = $jobtypeid;

    }

    if ($jobtypeid == 0)
    {

        $totaljobs = "SELECT sum(amount_total) as totalamt , sum(amount_staff) as totalamtstaff  FROM `job_details`   WHERE status != 2 AND  job_id = " . $jobid . "";

    }
    else
    {

        $totaljobs = "SELECT sum(amount_total) as totalamt , sum(amount_staff) as totalamtstaff  FROM `job_details`   WHERE status != 2 AND  job_id = " . $jobid . " AND job_type_id IN(" . $job_types . ")";

    }

    $quetotaljobs = mysql_query($totaljobs);

    $totaldata = mysql_fetch_assoc($quetotaljobs);

    $totalamount = $totaldata['totalamt'];

    $totalstaffamt = $totaldata['totalamtstaff'];

    return array(
        'jobamt' => $totalamount,
        'staffamot' => $totalstaffamt
    );

}

function BBCOfferedJobAmount($staff_id, $fromdate, $todate, $action, $stafftype)

{

    $sql1 = "SELECT job_id ,job_type_id,	total_amount,total_staff_amt,total_bcic_amt   FROM `staff_jobs_status` WHERE staff_id = " . $staff_id . "  and status = {$action}  and DATE(created_at) >= '" . $fromdate . "' AND DATE(created_at) <= '" . $todate . "'";

    //$totalamount = array();
    $querydata1 = mysql_query($sql1);

    $count = mysql_num_rows($querydata1);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($querydata1))
        {

            $getjobid[] = $data['job_id'];

            $getJobtypeID[$data['job_id']][] = array(
                'jobtype_id' => $data['job_type_id'],
                'total_amount' => $data['total_amount'],
                'total_staff_amt' => $data['total_staff_amt']
            );

        }

       

        foreach ($getJobtypeID as $jobid1 => $jobtypeid)
        {

            $jobidty = array_unique($jobtypeid);

            if (!empty($jobidty))
            {

			   foreach($jobidty as $jobtypeidkey=>$jobtypeid) 
			    {
					if ($action == 2 && $stafftype == 2)
					{

						$totalamt['totaljobamt'][] = $jobtypeid['total_amount'];
						$totalamt['totalstaffamt'][] = $jobtypeid['total_staff_amt'];

						//$totalamount = $getJobtypeID[$jobid1]['total_staff_amt'];

					}
					else
					{

						$arr = BBCgetTotalAmountOffered($jobid1, $jobidty['jobtype_id']);

						$totalamt['totaljobamt'][] = $arr['jobamt'];

						$totalamt['totalstaffamt'][] = $arr['staffamot'];

					}
			    }
                  unset($jobidty);
            }

            unset($jobid1);

        }
		

        $jobid = array_unique($getjobid);
        $totalamout = array_sum($totalamt['totaljobamt']);
        $staffamotamout = array_sum($totalamt['totalstaffamt']);

        

        return array(
            'jobid' => $jobid,
            'totalamout' => number_format($totalamout, 2) ,
            'staffamotamout' => number_format($staffamotamout, 2)
        );
        unset($arr); 

    }

    unset($getJobtypeID);

}

function BBCJobsByPostCode($staff_id, $fromdate, $todate, $action, $postcode, $stafftype)

{

    $staff_postcode_arr = explode(',', $postcode);

    $sql1 = "SELECT job_id ,job_type_id, total_amount, total_staff_amt, total_bcic_amt  FROM `staff_jobs_status` WHERE staff_id = " . $staff_id . "  and status = {$action}  and DATE(created_at) >= '" . $fromdate . "' AND DATE(created_at) <= '" . $todate . "'";

    $querydata1 = mysql_query($sql1);

    $count = mysql_num_rows($querydata1);

    if ($count > 0)
    {

        while ($data = mysql_fetch_assoc($querydata1))
        {

            if (!in_array($data['job_type_id'], $getjobid[$data['job_id']]))
            {

                //$getjobid[$data['job_id']][] = $data['job_type_id'];
				 $getjobid[$data['job_id']][] = array(
                        'jobtype_id' => $data['job_type_id'],
                        'total_amount' => $data['total_amount'],
                        'total_staff_amt' => $data['total_staff_amt']
                    );

            }

        }

        $getjobid11 = array_keys($getjobid);

        $jobid = array_unique($getjobid11);

        $job_ids = implode(',', $jobid);

        $sql_job_postcodes = mysql_query("SELECT postcode ,  booking_id  FROM `quote_new` where booking_id != 0  and booking_id in (" . $job_ids . ")");
	
        while ($row_job_postcodes = mysql_fetch_assoc($sql_job_postcodes))
        {

            if (in_array($row_job_postcodes['postcode'], $staff_postcode_arr))
            {

                $postcodejob[] = $row_job_postcodes['booking_id'];

            }

        }
		
		
        $totaldeniedInpostcode = count($postcodejob);

        if ($totaldeniedInpostcode > 0)
        {

            foreach ($getjobid as $jobid => $val)
            {

                if (!empty($val))
                {

                    if (in_array($jobid, $postcodejob))
                    {

                        foreach ($val as $key1 => $jobtypeid)
                        {

							 if ($action == 2 && $stafftype == 2)
							{

								$totalamt1['totaljobamt'][] = $jobtypeid['total_amount'];
								$totalamt1['totalstaffamt'][] = $jobtypeid['total_staff_amt'];

								//$totalamount = $getJobtypeID[$jobid1]['total_staff_amt'];

							}
							else
							{
								$arr1 = BBCgetTotalAmountOffered($jobid, $jobtypeid['jobtype_id']);

								$totalamt1['totaljobamt'][] = $arr1['jobamt'];

								$totalamt1['totalstaffamt'][] = $arr1['staffamot'];
							}
                        }

                        $totaldeniedamt['totaljobamt'][] = array_sum($totalamt1['totaljobamt']);

                        $totaldeniedamt['totalstaffamt'][] = array_sum($totalamt1['totalstaffamt']);

                        unset($totalamt1);

                    }

                }

            }

        }

        return array(
            'total_job' => $totaldeniedInpostcode,
            'totalamout' => number_format(array_sum($totaldeniedamt['totaljobamt']) , 2) ,
            'staffamout' => number_format(array_sum($totaldeniedamt['totalstaffamt']) , 2)
        );

        unset($totaldeniedamt);

    }

}

      function getSubStaff() {
			    $arg = "SELECT id, mobile,name FROM `sub_staff` where  status = 1";
			    $sql = mysql_query($arg);
	   
				   while($data = mysql_fetch_assoc($sql)) {
					  $substaffdetails[] = $data;
				   }
				   return $Substaffdetails;
		}

		function cehckcomplaint($jobid){
			  $JcomplaintDetails = mysql_fetch_assoc(mysql_query("select job_id, complaint_status ,complaint_type from job_complaint where job_id=".$jobid.""));
			  
			 if($JcomplaintDetails['complaint_status'] > 0) { 
			   return $JcomplaintDetails['complaint_status']; 
			 }else{
				 return 0;
			 }
		}
		
		function getJobDetailsData($jobid){
			 $sql = mysql_query("select job_type_id , job_id , start_time ,amount_total ,  end_time , job_date,  staff_id ,  job_type from job_details where  status != 2 AND job_id=" . $jobid . " order by job_type_id asc ");
			 
			 while($data = mysql_fetch_array($sql)) {
				 $getdata[$jobid][] = $data;
			 }
			 return $getdata;
		}
		
		function getAdminDetailsData()
		{
			$sql = mysql_query("select id , name, auto_role  from admin where  status = 1 and auto_role in (2,3,4,5,6,7)");
			while ($data = mysql_fetch_assoc($sql))
			{
			   $getadminname[$data['id']] = $data['name'];
			}
			return $getadminname;
		}
		
	function CheckDoublephoneNumber($date){
		$sql = mysql_query("SELECT id, phone , date FROM `quote_new` WHERE date = '".$date."' GROUP by phone HAVING (count(phone) > 1 )");
		
		if(mysql_num_rows($sql) > 0) {
			while($data =  mysql_fetch_assoc($sql)) {
				$Getphone[] = $data['phone'];
			}
		}

		$sql1 = mysql_query("SELECT id, phone , email , date FROM `quote_new` WHERE booking_date = '".$date."' GROUP by email HAVING (count(email) > 1 )");
		
		if(mysql_num_rows($sql1) > 0) {
			while($data1 =  mysql_fetch_assoc($sql1)) {
				$Getemail[] = $data1['email'];
			}
		}
		
		$phonearr = $Getphone;
		$emailarr = $Getemail;
		
		$arr = array_merge($phonearr , $emailarr);
		//print_r($arr);
		return $arr;
		 //return $Getemail;
		
	}	
	
	function getQuoteCnt($staffid, $todat) {
		
		$sql = mysql_query("SELECT id FROM `quote_new` where   date = '".$todat."'  AND  bbcapp_staff_id = ".$staffid."");
		
		$count = mysql_num_rows($sql);
		
		return $count;
	} 
	
	function JobDeniedStaff($jobid,  $job_type_id){
	
	   $query =   mysql_query("SELECT DISTINCT(SELECT name from  staff WHERE id = staff_id) as sname, created_at FROM `staff_jobs_status` WHERE `status` IN (0,2)  AND job_id = '".$jobid."' AND job_type_id = ".$job_type_id." ORDER BY `id` DESC");
	   
	    if(mysql_num_rows($query) > 0) {
	                while($data = mysql_fetch_array($query)) {
				       $staffdata[] = $data['sname'];
				    }
	    }
		return $staffdata;
	}
	
	function CheckAVailStaffdata($site_id, $job_type_id, $jobdate)
	{
	   // "SELECT id, name FROM `staff` WHERE status = 1 and (site_id=".$site_id." or site_id2=".$site_id." OR find_in_set( ".$site_id." , all_site_id))  AND  find_in_set ( ".$job_type_id." , amt_share_type ) ";
           
			
				$sql=  mysql_query("SELECT id, name FROM `staff` WHERE status = 1 AND no_work = 1 AND (site_id=".$site_id." or site_id2=".$site_id." OR find_in_set( ".$site_id." , all_site_id))  AND  find_in_set ( ".$job_type_id." , amt_share_type ) ");
			
			while($data = mysql_fetch_assoc($sql)) {
			    $getdataids[] = $data['id'];
			  
			}
			
			

		    $sql = mysql_query("SELECT GROUP_CONCAT(DISTINCT(SELECT name from  staff WHERE id = staff_id)) as staffid FROM `staff_roster` WHERE staff_id  in  (".implode(',', $getdataids).") AND date = '".$jobdate."' AND  status = 1");
			
			$staffdata = mysql_fetch_assoc($sql);
			
			//print_r($staffdata);
			//unset($getdataids);
			//$fetdata =  explode(',',$staffdata);
			return $staffdata;
	}
	
	
	function getHaveJob($site_id, $job_type_id, $jobdate){

			
			$sql = mysql_query("SELECT GROUP_CONCAT(DISTINCT(SELECT name from  staff WHERE id = staff_id)) as staffid FROM `job_details` WHERE  status != 2 and job_type_id = ".$job_type_id." and job_date = '".$jobdate."' and site_id = ".$site_id."");
			
			$staffdata1 = mysql_fetch_assoc($sql);
			
			//print_r($staffdata1);
			
			return $staffdata1;
	
	}
	
	
	function GetBeforeJobIcon($quid , $jobicon, $staffdetails){
	
	    $sql_icone = ("select job_type_id , staff_id ,job_acc_deny , job_time_change_date,   job_type from job_details where  status != 2 AND quote_id=".$quid." ORDER BY job_type_id asc");  
		$quote_details = mysql_query($sql_icone);

		
		$i = 1;
		    while($qd = mysql_fetch_assoc($quote_details)){
							
					if($qd['job_time_change_date'] == '0000-00-00 00:00:00' && $qd['job_type_id'] == 1 &&  $qd['job_type_id'] != 11) {			 
						$data['job_time_change_date'] = $qd['job_time_change_date'];
					}

					 
					if(($qd['job_acc_deny'] = 1 || $qd['job_acc_deny'] = 2) && $qd['job_type_id'] == 1 &&  $qd['job_type_id'] != 11) {			 
                        $data['job_acc_deny'] = $qd['job_acc_deny'];
					}					
					
					
				
					
					 if($qd['staff_id'] != 0) {
						 $iconfol = 'job_type32';
						 $job_type = $qd['job_type'];
						 $smobile =  get_rs_value("staff","mobile",$qd['staff_id']);
						 $staff_name = $staffdetails[$qd['staff_id']];
						 
						 $job_icon =  $jobicon[$qd['job_type_id']];
						 $data[] = array('iconfol'=> $iconfol , 'smobile'=> $smobile, 'staff_name'=> $staff_name, 'job_icon'=> $job_icon);
						 
					 }else{
						 $iconfol = 'job_type_red';
						 $job_type = $qd['job_type'];
						 $smobile = 'N/A';
						 $staff_name = 'N/A';
						 $job_icon =  $jobicon[$qd['job_type_id']];
						 
						  $data[] = array('iconfol'=> $iconfol , 'smobile'=> $smobile, 'staff_name'=> $staff_name, 'job_type'=> $job_type , 'job_icon'=> $job_icon);
					 }
			}
			
		return $data;		
	}
	
 function getsalesAllInfoData($fromdate , $todate , $adminid)
	{ 
	  
	$sql =  mysql_query("SELECT * FROM `task_manager`  WHERE task_type = 1 AND status = 0 and admin_id = ".$adminid." and DATE(created_date) >= '".$fromdate."' AND DATE(created_date) <= '".$todate."'");

	$count = mysql_num_rows($sql);
	  
	$taskattend  = 0;
	$totalreceved  = 0;
	$totalleftmessage  = 0;
	$totalshedule  = 0;
	$ontime = 0;
	  
	$beetween30 = 0;
	$beetween60 = 0;
	$beetween120 = 0;
	$totalqdone = 0;
	
	$lessthenone = 0;
	$lessthenthree = 0;
	$lessthenfive = 0;
	$totalnewtask = 0;
	$totalattend = 0;
	
	$lessminstwo = 0;
	$betweentwotofive = 0;
	$betweenfivetoten = 0;
	$morethenten = 0;
	
	   // echo  'wertyuiop'.$count;
	  
	    if($count > 0) {
            while($data = mysql_fetch_assoc($sql)) {
		 
		            if($data['response_type'] == 0 &&  ($data['next_response'] == 1 || $data['next_response'] == 2)) {
				        $taskattend++;
				    } 
					
					if($data['response_type'] == 0 &&   $data['next_response'] == 1) {
				        $totalreceved++;
				    }

					if($data['response_type'] == 0 &&  $data['next_response'] == 2) {
					   $totalleftmessage++;
					}	

                    if($data['response_type'] == 16) {
					   $totalqdone++;
					   
					  // echo 'pankaj';
					}	
                    
					$respData = array(12);
					if(in_array($data['response_type'] , $respData)) {
					   $totalnewtask++;
					}						
					
					//$respData = array(12,14,16);
					if(in_array($data['response_type'] , $respData) && ($data['next_response'] == 1 || $data['next_response'] == 2)) {
					   $totalattend++;
					}	
					
					if(($data['response_type'] == 1 || $data['response_type'] == 2) && ($data['next_response'] == 9 || $data['next_response'] == 10)) {
				        $totalshedule++;
				    } 
					
					/* if(($data['response_type'] == 1 || $data['response_type'] == 2) && ($data['next_response'] == 0) {
				        $noshedule++;
				    }  */
					
					if($data['response_type'] == 0 && $data['next_response'] == 1) {
						$calculatetime =  CalculateTime($data['created_date'] , $data['completed_date']);     
					   
						 
						 $Time = explode(':' , $calculatetime);
						 
						 //echo '<pre>'; print_r($Time);
						 
						  if($Time[0] == '0'   && $Time[1] < '10') {
							  $ontime++;
						  }
						  
						  if($Time[0] == '0'   && $Time[1] > '10' && $Time[1] < '30') {
							  $beetween30++;
						  }
						  
						  if($Time[0] == '0'   && $Time[1] > '30' && $Time[1] < '60') {
							  $beetween60++;
						  }
						  
						  if($Time[0] == '1'   && $Time[1] < '60') {
							  $beetween120++;
						  }
						  
					}
					
					if($data['response_type'] == 0 && $data['next_response'] == 1) {
						$calculatetime1 =  CalculateTime($data['created_date'] , $data['completed_date']);     
					   
						 
						 $Time = explode(':' , $calculatetime1);
						 
						 //echo '<pre>'; print_r($Time);
						 
						  if($Time[0] == '0'  && $Time[1] < '1') {
							  $lessthenone++;
						  }
						  
						  if($Time[0] == '0'   && ($Time[1] > '1' && $Time[1] < '3')) {
							  $lessthenthree++;
						  }
						  
						  if($Time[0] >= '0'  &&  $Time[1] > '5') {
							  $lessthenfive++;
						  }
						
						  
						  if($Time[0] == '0'  && $Time[1] < '2') {
							  $lessminstwo++;
						  }
						  
						  if($Time[0] == '0'   && ($Time[1] > '2' && $Time[1] < '5')) {
							  $betweentwotofive++;
						  }
						  
						  if($Time[0] >= '0'   && ($Time[1] > '5' && $Time[1] < '10')) {
							  $betweenfivetoten++;
						  }
						  
						  if($Time[1] > '10') {
							  $morethenten++;
						  }
						  
					}
		    }
			
			
          $data11 = array('taskattend'=>$taskattend , 'totalreceved'=>$totalreceved , 'totalleftmessage'=>$totalleftmessage , 'totalshedule'=>$totalshedule , 'ontime'=>$ontime , 'beetween30'=>$beetween30 , 'beetween60'=>$beetween60 , 'beetween120'=>$beetween120 , 'totalqdone'=>$totalqdone ,'lessthenone'=>$lessthenone ,'lessthenthree'=>$lessthenthree ,'lessthenfive'=>$lessthenfive, 'totalnewtask'=>$totalnewtask, 'totalattend'=>$totalattend , 'lessminstwo'=>$lessminstwo , 'betweentwotofive'=>$betweentwotofive ,'betweenfivetoten'=>$betweenfivetoten , 'morethenten'=>$morethenten);	
	   
	      return $data11;
	   
	    }

	}	
 
    function CheckClientimg($jobid){
	
	   //return "SELECT count(id) as   ids FROM `client_image_befor_after` WHERE job_id = ".$jobid."   ORDER BY `id` DESC";
	   $sql =  mysql_query("SELECT count(id) as   ids   FROM `client_image_befor_after` WHERE job_id = ".$jobid."   ORDER BY `id` DESC");
	   
	   $count = mysql_num_rows($sql);
	   
	   $countimg = mysql_fetch_array($sql);
	   
	   return  $countimg['ids'];
	   
	}
	
    function getComplaintsData($stageskey,  $adminid)
	{
		
		$arg = "SELECT * FROM `job_complaint` WHERE 1 = 1 AND ( complaint_date = '0000-00-00 00:00:00' OR DATE(complaint_date) = '".date('Y-m-d')."' OR DATE(complaint_date) = '".date("Y-m-d", strtotime("-1 day"))."' ) AND job_id in (select booking_id from quote_new where bbcapp_staff_id = 0 AND booking_id > 0) ";
		
		$date = date('Y-m-d');

			if ($adminid == 'all')
			{

			}
			elseif ($adminid > 0)
			{

				//$arg .= " AND task_manage_id = " . $adminid . "";

			}
			
			if ($stageskey == 1)
			{
				//•	No Date Time Select
				$arg .= " AND complaint_sent_to_cleaner = '0000-00-00 00:00:00' ";
			}
			elseif ($stageskey == 2)
			{
				//• Not Started
				$arg .= " AND complaint_sent_to_cleaner != '0000-00-00 00:00:00' AND job_handling = 0 ";

			}elseif ($stageskey == 3)
			{
				//• Not Started
				$arg .= " AND job_handling = 1 AND job_handling_by_clnr = 0";

			}elseif ($stageskey == 4)
			{
				//• Not Started
				$arg .= "  AND (job_handling = 2 OR  job_handling_by_clnr = 1)  AND (complaint_status in (1, 0) OR admin_id = 0 ) AND complaint_process_status != 3";

			}elseif ($stageskey == 5)
			{
				//• Not Started
				$arg .= "   AND (job_handling = 2 OR  job_handling_by_clnr = 1) AND complaint_status = 3 AND admin_id != 0 AND complaint_process_status != 3 ";

			}elseif ($stageskey == 6)
			{
				//• Not Started
				$arg .= "  AND (job_handling = 2 OR  job_handling_by_clnr = 1) AND  complaint_status = 2 AND admin_id != 0 AND complaint_process_status != 3  ";

			}elseif ($stageskey == 7)
			{
				//• Not Started
				$arg .= " AND complaint_process_status != 3 AND complaint_status = 4 AND  (job_handling = 2 OR  job_handling_by_clnr = 1)  AND admin_id != 0 ";

			}elseif ($stageskey == 8)
			{
				//• Not Started
				$arg .= " AND complaint_process_status = 3  AND  (job_handling = 2 OR  job_handling_by_clnr = 1) AND admin_id != 0 ";

			}
	 
             //echo $arg;
		   
				$argsql = mysql_query($arg);

				$count = mysql_num_rows($argsql);

			//echo $count;
				if ($count > 0)
				{

					while ($data = mysql_fetch_assoc($argsql))
					{

						$getdata1[$stageskey][] = $data;

					}

				}
				
			//print_r($getdata1);	
					unset($stageskey);	
			   return $getdata1;
     	   
	}	
	
    function getComplaintsEmail($id){
	   
	    $q_notes_data = mysql_query("select * from complaint_notes where complaint_id=".$id." order by createOn  desc");
        
		
		$getcompdata = array();
		$getcompdata1 = array();
		
		$counnotes= mysql_num_rows($q_notes_data);
		
		if($counnotes > 0) {
			
				while($qnotes = mysql_fetch_assoc($q_notes_data)){ 		
					
					
					//$qnotes['createOn'] = date("h:i a dS M Y",strtotime($qnotes['createOn']));
					$coplainttype = 1;
					//$getcompdata[] = $qnotes;
					array_push($qnotes, $notes_type, $coplainttype);
					
					
				   $getcompdata[] = $qnotes;
				   $job_id = 	$qnotes['job_id'];
				   
				}
		}
		
		   $arg = mysql_query("SELECT id, job_id,createdOn as createOn,  folder_type, email_subject as heading, email_send_admin_id FROM `bcic_email` WHERE `job_id` = ".$job_id."");   	
		   
		  $countemailotes= mysql_num_rows($arg); 
		 if($countemailotes > 0) { 
		 
			while($edata = mysql_fetch_assoc($arg))
			{	
		
		      //$edata['createOn'] = date("h:i a dS M Y",strtotime($edata['createOn']));
		       $admintype = 'Automated';
			   $coplainttype = 2;
			   $edata['notes_type'] = 0;
				 array_push($edata, $admintype, $coplainttype);
				 $getcompdata1[] = $edata;
			}
		}
		
		if($counnotes > 0 && $countemailotes > 0) {
		 
	         $result =  array_merge($getcompdata,$getcompdata1);
		
		   
		    $columns = array_column($result, 'createOn');
		    array_multisort($columns, SORT_DESC, $result); 
			$allresult =  $result;
		}else{
			$allresult =  $getcompdata;
			
		}
		
		return $allresult;
    }	
	
	
	function getComplaintsCleanerHandling($stageskey,  $adminid)
	{
		
		$arg = "SELECT * FROM `job_complaint` WHERE  job_handling = 1 AND ( complaint_date = '0000-00-00 00:00:00' OR DATE(complaint_date) = '".date('Y-m-d')."' OR DATE(complaint_date) = '".date("Y-m-d", strtotime("-1 day"))."' ) AND job_id in (select booking_id from quote_new where bbcapp_staff_id = 0 AND booking_id > 0) ";
		
		$date = date('Y-m-d');

			if ($adminid == 'all')
			{

			}
			elseif ($adminid > 0)
			{

				//$arg .= " AND task_manage_id = " . $adminid . "";

			}
			
			if ($stageskey == 1)
			{
				//•	No Date Time Select
				//$comdate= date('Y-m-d H:i:s' , strtotime('- 5 day'));
				$arg .= " AND complaint_handling_date != '0000-00-00 00:00:00' AND  move_contact = '0000-00-00 00:00:00'  ";
			}
			elseif ($stageskey == 2)
			{	
			    //• Not Started
				//$comdate= date('Y-m-d H:i:s' , strtotime('- 5 day'));
				
				//$arg .= " AND  move_contact != '0000-00-00 00:00:00' AND move_resolved = '0000-00-00 00:00:00' AND move_bcic = '0000-00-00 00:00:00'  AND move_in_overdue = '0000-00-00 00:00:00' AND complaint_handling_date != '0000-00-00 00:00:00' AND ( email_send_to_cleaner = '0000-00-00 00:00:00' OR info__received = '0000-00-00 00:00:00')";
				
				//$arg .= " AND  move_contact != '0000-00-00 00:00:00' AND ( move_from_contract = 0 OR  email_send_to_cleaner = '0000-00-00 00:00:00' OR info__received = '0000-00-00 00:00:00')";
				$comdate_1= date('Y-m-d' , strtotime(' + 1 day'));
				$comdate= date('Y-m-d' , strtotime('- 1 day'));
				//$arg .= " AND  move_contact != '0000-00-00 00:00:00' AND  move_from_contract = 0 AND complaint_handling_date <='".$comdate."'";
				//$arg .= " AND  move_contact != '0000-00-00 00:00:00' AND  move_from_contract = 0 AND complaint_handling_date <='".$comdate."'";
				//SELECT * FROM `job_complaint` WHERE job_id in (SELECT id from jobs WHERE status = 4) AND job_handling = 1  AND  move_contact != '0000-00-00 00:00:00' AND complaint_handling_date  >= '2020-07-21 19:08:14' AND complaint_handling_date  <= '2020-07-22 19:08:14' AND  move_from_contract = 0
				
				$arg .= " AND  move_contact != '0000-00-00 00:00:00' AND DATE(complaint_handling_date) >= '".$comdate."' AND DATE(complaint_handling_date) < '".$comdate_1."' AND  move_from_contract = 0";
			}
			 elseif ($stageskey == 3)
			{
				//• Not Started
				//email_send_to_cleaner info__received move_in_overdue
				$comdate_1= date('Y-m-d' , strtotime(' - 1 day'));
				$comdate= date('Y-m-d' , strtotime('- 2 day'));
				//$arg .= "   AND  move_contact != '0000-00-00 00:00:00' AND job_handling_by_clnr = 0 AND   move_from_contract = 0 AND DATE(complaint_handling_date) >= '".$comdate."' AND DATE(complaint_handling_date) < '".$comdate_1."' AND complaint_resolve = 1 ";
				$arg .= "   AND  move_contact != '0000-00-00 00:00:00' AND job_handling_by_clnr = 0 AND   move_from_contract = 0 AND DATE(complaint_handling_date) < '".$comdate_1."' AND complaint_resolve = 1 ";

			}elseif ($stageskey == 4)
			{
				//• Not Started
				$arg .= "  AND complaint_resolve = 1  AND move_from_contract = 2 AND  (admin_id != 0 OR admin_id = 0) ";

			}elseif ($stageskey == 5)
			{
				//• Not Started
			$arg .= "  AND admin_id != 0   AND complaint_resolve = 3 ";

			}elseif ($stageskey == 6)
			{
				//• Not Started
				$arg .= "  AND admin_id != 0 AND complaint_resolve = 2 ";

			}elseif ($stageskey == 7)
			{
				//• Not Started
				$arg .= " AND  admin_id != 0 AND complaint_resolve = 4 ";

			}
	 
           // echo $arg;
		   
				$argsql = mysql_query($arg);

				$count = mysql_num_rows($argsql);

			//echo $count;
				if ($count > 0)
				{

					while ($data = mysql_fetch_assoc($argsql))
					{

						$getdata1[$stageskey][] = $data;

					}

				}
				
			//print_r($getdata1);	
				
			   return $getdata1;
     	   
	}	
	
	function GetAlownotification(){
		
		$sql = mysql_query("SELECT id  FROM `admin` WHERE status = 1  and allow_urgent_noti = 1 ");
		
		$cunt = mysql_num_rows($sql);
		
				if($cunt > 0) {
				    while($getinfdata = mysql_fetch_assoc($sql)) {
						
						$getdata[] = $getinfdata['id'];
					}
		        }
		return $getdata;
	}
	
    function checkSuberb($lat, $lng)

{

    if (!empty($lat) && !empty($lng))
    {
$geolocation = $lat.','.$lng;
       
       $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false&key=AIzaSyAQ3Adlxq9qEPYsKQ2cIjyuIeu04GviYGo'; 

$ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = curl_exec($ch);

		curl_close($ch);

		$json_decode = json_decode($response, true);
		//echo '<pre>'; print_r($json_decode); die;
        

         $status = $data->status;

        if ($status == "OK")
        {

            $location = $data->results[0]->formatted_address;

        }
        else
        {

            $location = 'No location found.';

        }

        echo  $location; 

    }

}		
function getAdmindata(){
    
	$sql = mysql_query("Select id , name , auto_role ,phone , email , login_status , is_call_allow , loggedin, country_name  from admin where status = 1  AND is_call_allow = 1 Order by name  desc");
	
	 while($data = mysql_fetch_assoc($sql)) {
		  $getdata[$data['auto_role']][] = $data;
	 }
	
	return  $getdata;
	
}

function getAdminidsdata(){
    
	$sql = mysql_query("Select id , name , auto_role ,phone , email , login_status , is_call_allow , loggedin, country_name  from admin where status = 1  AND is_call_allow = 1 Order by name  desc");
	
	 while($data = mysql_fetch_assoc($sql)) {
		  $getdata[] = $data;
	 }
	
	return  $getdata;
	
}



function get3cxUserName($calldate){
	
	$sql= mysql_query("SELECT id, 3cx_user_name, adminid , (SELECT GROUP_CONCAT(in_time) as in_time FROM `admin_logged` WHERE admin_logged.admin_id = c3cx_users.adminid AND DATE(createdOn) = '".$calldate."'   GROUP by admin_id ) as intime   FROM `c3cx_users` WHERE is_active = 1 and calling_type = 1");
	
	 while($data = mysql_fetch_assoc($sql)) {
		 $getdata[$data['adminid']] = $data;
	 }
	 
	 return $getdata;
}

function get3cxUserCallInout($id, $date ,  $type, $username){

    $sql = " SELECT count(from_type) as fromtype , 
    SEC_TO_TIME( SUM(time_to_sec(duration))) As timeSum , from_type , to_type , admin_id   FROM `c3cx_calls` where   admin_id = ".$id." AND call_date = '".$date."' GROUP by from_type";
    $query = mysql_query($sql);
  
    $fromtype =0 ;
            while( $data = mysql_fetch_assoc($query) ) {
                if($data['from_type'] == $username) {
                    $fromtype = $data['fromtype'];
                    $outtotaltime = $data['timeSum'];
                }else{
                 
                  $totype[] = $data['fromtype'];
                  $totaltime = $data['timeSum'];
                  $intotaltime[] = $data['timeSum'];
                }
            }
            
        $intotaltime =  getArrayTime($intotaltime);
      return array('outcall'=>$fromtype,'incall'=>array_sum($totype),'outtotaltime'=>$outtotaltime,'intotaltime'=>$intotaltime);
 }
 
 
   function getArrayTime($arr){
	    
	    
	         $total = 0; 
                        // Loop the data items 
                        foreach( $arr as $element): 
                        
                        // Explode by seperator : 
                        $temp = explode(":", $element); 
                        
                        // Convert the hours into seconds 
                        // and add to total 
                        $total+= (int) $temp[0] * 3600; 
                        
                        // Convert the minutes to seconds 
                        // and add to total 
                        $total+= (int) $temp[1] * 60;  
                        
                        // Add the seconds to total 
                        $total+= (int) $temp[2]; 
                        endforeach; 
                        
                        // Format the seconds back into HH:MM:SS 
                        $formatted = sprintf('%02d:%02d:%02d',  
                                ($total / 3600), 
                                ($total / 60 % 60), 
                                $total % 60); 
                        
                        return  $formatted;  
	}
 
   function Hourlyget2cxReportInout_data($adminid , $call_date,  $h, $type)
{
      if($type == 1) {
         $totaladmincall = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date = '" . $call_date . "'  AND from_type in (SELECT 3cx_user_name FROM `c3cx_users`  WHERE id= ".$adminid.") AND admin_id in (SELECT id FROM `c3cx_users`  WHERE id= ".$adminid.")");
	}else if($type == 2){
		 $totaladmincall = ("SELECT count(id) as admincall FROM `c3cx_calls` where ( HOUR(call_date_time) BETWEEN $h AND $h ) AND call_date = '" . $call_date . "' AND to_type in (SELECT 3cx_user_name FROM `c3cx_users`  WHERE id= ".$adminid.") AND admin_id in (SELECT id FROM `c3cx_users`  WHERE id= ".$adminid.")");
	}

     $sql = mysql_query($totaladmincall);

    $TotalRecords = mysql_fetch_array($sql);

    return $TotalRecords['admincall']; 

} 

function getbOOkingquOte($date){

   $sql = "SELECT  COUNT(id) as totalbookingid,  (SELECT name FROM admin WHERE admin.id = quote_new.login_id) as adminname , login_id   FROM `quote_new` WHERE quote_to_job_date = '".$date."' GROUP by login_id";

   //echo $sql;   
	 $query = mysql_query($sql);
 
     while($data = mysql_fetch_assoc($query)) {
		 
		 $getdata[$data['login_id']] = $data;
	 }
	 
	 return $getdata;
 }
 
 
 function GetBookingQuoteData__1(){
     
        $month = date('m');
        $year = date('Y');
       $arg = "SELECT   count(booking_id) as totalbooking , booking_id , date , DAY(quote_to_job_date) as day , quote_to_job_date 
	    	FROM `quote_new` 
		    WHERE MONTH(quote_to_job_date)= '".$month."' 
		     AND YEAR(quote_to_job_date) = '".$year."'
		     AND step not in (10)
		     AND booking_id > 0 
		     AND quote_to_job_date != '0000-00-00' 
		     GROUP by quote_to_job_date ";
		   //  echo $arg;
     	$sql1_1 = mysql_query($arg);
		
	   //	echo 'pankaj __  ' .mysql_num_rows($sql1_1);
		
		if(mysql_num_rows($sql1_1) > 0) {
			while($data1 =  mysql_fetch_assoc($sql1_1)) {
				$totalbooked[$data1['day']] = $data1['totalbooking'];
			}
		}
		
	 return $totalbooked;	
 }
 
 function GetQuoteData__1(){
   
        $month = date('m');
        $year = date('Y');
        
      
     
		$sql = mysql_query("SELECT  id , count(id) as totalquote , booking_id , date , DAY(date) as day   FROM `quote_new` 
		    WHERE MONTH(date)= '".$month."' AND YEAR(date) = '".$year."' 
		       AND step not in (10) GROUP by date");
		
		if(mysql_num_rows($sql) > 0) {
			while($data =  mysql_fetch_assoc($sql)) {
				$totalquote[$data['day']] = $data['totalquote'];
			}
		}
		return $totalquote;
		
	}	
 
     function checkMessageID($messageid , $p_id)
    {
        
        $p_id = MobileCodeReplace($p_id);
        $sql = mysql_query("SELECT id FROM `mysms_child_conversation`   WHERE messageId = '".$messageid."'");
         
        $count =  mysql_num_rows($sql);
          
        if($count > 0) 
        {
              return 1;
        }
         else
        {
              return 0;
        }
    }
     
	 

    function InsertMySMS_data($data)
    {            
		$to_address = MobileCodeReplace($data['to_address']);
		$from_address = MobileCodeReplace($data['from_address']);
		$p_id = MobileCodeReplace($data['p_id']);
		$adminid = 0;
		
	   $dateSent = date('Y-m-d H:i:s' , strtotime($data['dateSent']));
		
			if($_SESSION['admin'] != '') {
				$adminid = $_SESSION['admin'];
			}
	
                $arg = "INSERT INTO `mysms_child_conversation` 
                    (
                      `p_id`, `from_address`, `to_address`, `messageId`, `message`, `locked`, `origin`, `read`, `status`, `incoming`, `dateSent`, `createdDate` , `admin_id`, `sendTimeDate`
                    )
                    
                    VALUES 
                    
                    (
                     '".$p_id."', '".$from_address."',  '".$to_address."',  '".$data['messageId']."', '".mysql_real_escape_string($data['message'])."',
                     '".$data['locked']."', '".$data['origin']."', '".$data['read']."', '".$data['status']."', 
                     '".$data['incoming']."', '".$dateSent."', '".date('Y-m-d H:i:s')."' , '".$adminid."', '".$data['dateSent']."'
                    )";
                
			
            $sql =   mysql_query($arg);
    }  
    
	
	function InsertParentsMySMS($Parentsdata, $type)
    {  
		  $from_address =  MobileCodeReplace($Parentsdata['from_address']);
		  $c_code_from = substr($Parentsdata['from_address'] ,0 ,3);
		  $smstype = '';
		  
		  
		  
			  if(substr($Parentsdata['to_address'] ,0 ,1) == '+') {
				  $substrCount = 3;
			  }else{
				  $substrCount = 2;
			  }
		  
		  $to_address =  MobileCodeReplace($Parentsdata['to_address']);
		  $c_code_to = substr($Parentsdata['to_address'] ,0 ,$substrCount);
		  
		  $Lastmessagedate = date('Y-m-d H:i:s', strtotime($Parentsdata['dateLastMessage']));
		   if($Parentsdata['smstype'] != '') {
		      $smstype = $Parentsdata['smstype'];
		   }
		  
		  
                if($type == 1) {
                         $arg = "INSERT INTO `mysms_parents_conversation` 
                            (
                              `from_address`, `c_code_to`, `c_code_from`, `to_address`, `dateLastMessage`, `last_message_id`, `total_message`, `messagesUnread`, `messagesUnsent`, `snippet`, `createdOn`, `updatedOn` ,`message_type`
                            )
                            
                            VALUES 
                            
                            (
                             '".$from_address."', '".$c_code_to."', '".$c_code_from."', '".$to_address."', '".$Lastmessagedate."', '".$Parentsdata['maxMessageId']."',
                             '".$Parentsdata['messages']."', '".$Parentsdata['messagesUnread']."', '".$Parentsdata['messagesUnsent']."', '".mysql_real_escape_string($Parentsdata['snippet'])."', 
                             '".date('Y-m-d H:i:s')."' ,'".date('Y-m-d H:i:s')."' ,'".$smstype."' 
                             
                            )";
                }elseif($type == 2) {
                     
                     $arg = "UPDATE `mysms_parents_conversation`    SET 
                     
                           `dateLastMessage` = '".$Lastmessagedate."', last_message_id = '".$Parentsdata['maxMessageId']."' ,  
                             total_message = '".$Parentsdata['messages']."' , messagesUnread = '".$Parentsdata['messagesUnread']."' , 
                             messagesUnsent = '".$Parentsdata['messagesUnsent']."' ,  snippet = '".mysql_real_escape_string($Parentsdata['snippet'])."' ,  
                             updatedOn = '".date('Y-m-d H:i:s')."', message_type = '".$smstype."'
							 
                        WHERE from_address = '".$from_address."'";
						
                }
				 
				//echo $arg; 
                 $sql =   mysql_query($arg);
				return $sql; 
            
    }  
      
	
    
	
	function MobileCodeReplace($mobilenumber){
		
          		
		
		if(substr($mobilenumber ,0 ,1) == '+') {
			$removearr = array('+91','+61');
			$str = str_replace($removearr,'0', $mobilenumber);
		}elseif(substr($mobilenumber ,0 ,2) == '00') {
			$str = str_replace('00','0', $mobilenumber);
		}elseif(substr($mobilenumber ,0 ,1) == '0') {
			$str = $mobilenumber;
		}elseif(substr($mobilenumber ,0 ,2) == '91'){
			$str = str_replace('91','0', $mobilenumber);
		}elseif(substr($mobilenumber ,0 ,2) == '61'){
			$str = str_replace('61','0', $mobilenumber);
		}
		
		return $str;
	}
   
   function getStaffInvoice($year ,$staff_id){
	   
	    $arg = "SELECT job_date , job_id , YEAR(job_date) as Year, MONTHNAME(job_date) as month, amount_staff , staff_id,  job_type,amount_total , amount_profit  FROM `job_details` WHERE  status != 2  AND job_id in (SELECT id from jobs WHERE status = 3 AND customer_paid = 1)";
	  
	    $arg .= "  AND YEAR(job_date) >= '".$year."' AND staff_id = '".$staff_id."'  "; 
		$arg .= " ORDER BY job_date asc";
		
		
	    $query1 = mysql_query($arg);
	  
	      if(mysql_num_rows($query1) > 0) { 
		    
			    while($data = mysql_fetch_assoc($query1)) {
		
		           $getdata[$data['month']][] = $data;
		
			    }
		
		}
		 return $getdata ;
   }   
   
    function getStaffInvoiceAutoGenerat($month ,$staff_id){
	   
	    $arg = "SELECT job_date , job_id , YEAR(job_date) as Year, MONTHNAME(job_date) as month, amount_staff , staff_id,  job_type,amount_total , amount_profit  FROM `job_details` WHERE  status != 2  AND job_id in (SELECT id from jobs WHERE status = 3 AND customer_paid = 1)";
	  
	    $arg .= "  AND YEAR(job_date) >= '".date('Y')."' AND MONTH(job_date) = '".$month."' AND staff_id = '".$staff_id."'  "; 
		$arg .= " ORDER BY job_date asc";
		
		
	    $query1 = mysql_query($arg);
	  
	      if(mysql_num_rows($query1) > 0) { 
		    
			    while($data = mysql_fetch_assoc($query1)) {
		
		           $getdata[$data['staff_id']][] = $data;
		
			    }
		
		}
		 return $getdata ;
   }   
   
   function getUnreadMessage(){
	   
	   //$sql =  mysql_query("SELECT id , message_type ,  SUM(messagesUnread) as unreadmessage FROM `mysms_parents_conversation` WHERE messagesUnread > 0 GROUP by message_type");
	   $sql =  mysql_query("SELECT id , message_type, messagesUnread  FROM `mysms_parents_conversation` WHERE messagesUnread > 0 AND message_type != ''");
	   
	   $count = mysql_num_rows($sql);
	   
	   
	   while($data = mysql_fetch_assoc($sql)) 
	    {
    
          $getdata[$data['message_type']][] = 	$data['messagesUnread'];
			
	    }
	    
	   // print_r($getdata);
	    
	    foreach($getdata as $key=>$val) {
	      
	         $getMessage[$key] = array('message_type'=>$key , 'unreadmessage'=>array_sum($getdata[$key]));
	          
	        
	    }
	    
	   // print_r($getMessage);
	    
	 return $getMessage;	
   } 
   
   function quoteStatusInfoData(){
	   
	 $sql =   "SELECT id, step, (SELECT name from system_dd WHERE type = 31 and system_dd.id = quote_new.step) as stepname , COUNT(step) as totalquote FROM `quote_new` WHERE MONTH(date)= '".date('m')."' AND YEAR(date) = '".date('Y')."' AND step > 0 GROUP by step ORDER by totalquote asc";
	 
	 $query = mysql_query($sql);
	 
	  while($data = mysql_fetch_array($query)) {
		  
		  $infodata[] = $data;
	  }
	  return $infodata;
   }
   
   
   function getOfferedInfo($stafid){
		//$stafid = $_GET['id'];
		$sql = "SELECT id, job_id ,staff_id , GROUP_CONCAT(DISTINCT(job_type_id)) as job_type_id ,  (SELECT CONCAT(name, ' ==== ', postcode, ' ==== ', suburb, ' ==== ', id, ' ==== ', booking_date) as cdetails  FROM quote_new WHERE booking_id = staff_jobs_status.job_id AND booking_id > 0) as cname,  SUM(total_amount) as jobamount  ,  SUM(total_bcic_amt) as bcicamount , SUM(total_staff_amt) as samount , created_at    FROM `staff_jobs_status` WHERE staff_id = ".$stafid." AND status = 5 GROUP by job_id ";

		//echo $sql;

		$query = mysql_query($sql);

		$cnt = mysql_num_rows($query);
		
		            if($cnt > 0) 
					{
						$i = 0;
						$j = 0;
						
						while($data = mysql_fetch_array($query)) { 
						
						 
						  
						  $job_acc_deny = get_sql("job_details","job_acc_deny","where job_id=".$data['job_id']." AND staff_id = ".$data['staff_id']."  AND status != 2 AND job_type_id = 1 AND job_acc_deny in (1,3) GROUP by job_id");
						  
						   //$job_acc_deny = 0;
						  if($job_acc_deny > 0) {
							  $i++;
							  $data['job_acc_deny'] = 1;
						  }else{
							  $j++;
							  $data['job_acc_deny'] = 0;
						  }
						  
						   $InfoData[] = $data;
						
						}
					}
					
				return array('acc'=>$i,'InfoData'=>$InfoData);	
						
						
   }
   
   
  // add_p_chat_notes($to_type ,$from_type, $message,  $admintype);
   function add_p_chat_notes($to_type, $from_type, $message, $admintype, $toname ,  $qids =null , $jobids = null )
{
        // echo "SELECT id FROM `message_chat_parent` WHERE from_id = ".$from_type." AND to_id = ".$to_type." AND admin_type = ".$admintype."";
 
             $sql = mysql_query("SELECT id FROM `message_chat_parent` WHERE from_id = ".$from_type." AND to_id = ".$to_type." AND admin_type = ".$admintype."");
             
             $count = mysql_num_rows($sql);
             
            if($count == 0) {

                    $staff_name = get_rs_value("admin", "name", $from_type);
                
                    $createdOn = date("Y-m-d h:i:s");
                
                    $ins_arg = "insert into message_chat_parent set from_id='" . $from_type . "',";
                
                    $ins_arg .= " to_id='" . $to_type. "',";
                
                    $ins_arg .= " message_text='" . $message . "',";
                
                    $ins_arg .= " createdOn='" . ($createdOn) . "',";
                
                    $ins_arg .= " admin_type='" . $admintype . "',";
                
                    $ins_arg .= " from_name='" . $staff_name . "',";
                
                    $ins_arg .= " to_name='" . $toname . "'";
                    
            }
			 else
			{
                 
                    $staff_name = get_rs_value("admin", "name", $from_type);
                
                    $createdOn = date("Y-m-d h:i:s");
                
                    $ins_arg = "update  message_chat_parent set ";
                
                    $ins_arg .= " message_text='" . $message . "',";
                
                    $ins_arg .= " createdOn='" . ($createdOn) . "'";
                    $ins_arg .= " where from_id ='" . ($from_type) . "' AND to_id = ".$to_type." AND admin_type = ".$admintype."";
            }
             
          
      $ins = mysql_query($ins_arg);
      
    add_chaild_chat_notes( $to_type, $from_type, $message, $admintype, $staff_name , $toname , $qids , $jobids);
  

}


function add_chaild_chat_notes( $to_type, $from_type, $message, $admintype, $staff_name , $toname, $qids =null , $jobids = null )
{
 
                
                    $createdOn = date("Y-m-d h:i:s");
                
                    $ins_arg = "insert into message_chat_child set ";
                
                    $ins_arg .= " from_id='" . $from_type. "',";
                    
                      $ins_arg .= " to_id='" . $to_type. "',";
                
                    $ins_arg .= " message_text='" . $message . "',";
                
                    $ins_arg .= " createdOn='" . ($createdOn) . "',";
                    
                    $ins_arg .= " job_id='" . $jobids . "',";
                    $ins_arg .= " quote_id='" . $qids . "',";
                
                    $ins_arg .= " admin_type='" . $admintype . "',";
                
                    $ins_arg .= " from_name='" . $staff_name . "',";
                
                    $ins_arg .= " to_name='" . $toname . "'";
                    
               // echo $ins_arg;        
   
                $ins = mysql_query($ins_arg);

}


function getquotejob($jstr){
    
    
            if(!empty($jstr)) {
                      foreach($jstr as $key=>$jval)
                       {
                          $jvalue = explode(' ', $jval)[0];
                          if(is_numeric($jvalue)) {
                             $jdata[] = ($jvalue);
                          }
                       }
           
             $jobids= implode(',', $jdata);
        
             return  $jobids;
        }
}



function add_group_chaild_chat_notes( $from_type,  $message, $admintype )
{
			$jobid = 0;
			$qid = 0;
			
			$message = str_replace(array('q#','j#'), array('Q#','J#'), $message);
			
            $getmessage =    explode('@' ,$message);
            $getjobids =    explode('J#' ,$message);
            $getquoteids =    explode('Q#' ,$message);
            
               $jobids1 =  getquotejob($getjobids);
               $qids1 =  getquotejob($getquoteids);
            
            
			  $jobs = explode(',', $jobids1);
			  $qids = explode(',', $qids1);
			  
			   $jobid = $jobs[0];
			   $qid = $qids[0];
           
            if(!empty($getmessage)) {
                 
                  foreach($getmessage as $key=>$val) {
                      $getarrayVal[] =  explode(' ' ,$val)[0];
                  }
                  
                 $getarrayVal =  array_unique($getarrayVal);
                
            }  
            
            
            //print_r($getarrayVal);
            
            
            if(!empty($getarrayVal)) { 
           
                    foreach($getarrayVal as $key=>$val) {
                        
                        $val = strtolower($val);
                        
                           if(strpos($val, '_(s)') == true) {
                                
                                $admintype = 1;
                                
                                $strreplce = str_replace( '_' ,' ', $val);
                                
                                $adminvalues[1][] = trim(str_replace( '(s)' , '', $strreplce));
                                
                           } else if (strpos($val, '_(a)') == true){
                                 $admintype = 2;
                                 $strreplce1 = str_replace( '_' ,' ', $val);
                                 $adminvalues[2][] = trim(str_replace( '(a)' ,'', $strreplce1));
                           }
                    } 
                     
						
					 
                     
                   // print_r($adminvalues); 
                     
                     if(!empty($adminvalues[1])) {
                         $staffvalue =  implode("' , '" , $adminvalues[1]); 
                         
                        // echo "SELECT GROUP_CONCAT(id) as ids , GROUP_CONCAT(name) as names   FROM `staff` WHERE   status = 1 AND  `name` IN ('".$staffvalue."')";
                         
                         $sql = mysql_query("SELECT GROUP_CONCAT(id) as ids , GROUP_CONCAT(name) as names   FROM `staff` WHERE   status = 1 AND  `name` IN ('".$staffvalue."')");
                         
                         $gettoids = mysql_fetch_assoc($sql);  
                         
                         // print_r($gettoids);
                           if(!empty($gettoids) && $gettoids['ids'] != '') {
                          
                                  $getids = explode(',', $gettoids['ids'] );
                                  $names = explode(',', $gettoids['names'] );
                                  
                                  
                                 // print_r($getids); die;
                                  
                                  if(!empty($getids)) {
                                      
                                      foreach($getids as $adminkys => $adminids) {
                                          
                                          add_p_chat_notes($adminids, $from_type, $message, 1, $names[$adminkys], $qid , $jobid);
                                      }
                                   }
                          
                            }
                         
                         
                     }
                     
                     if(!empty($adminvalues[2])){
                         
						 
                         $staffvalue1 =  implode("' , '" , $adminvalues[2]); 
                         
                        // echo  "SELECT GROUP_CONCAT(id) as ids , GROUP_CONCAT(name) as names   FROM `admin` WHERE   status = 1 AND  `name` IN ('".$staffvalue1."')";
                         $sql = mysql_query("SELECT GROUP_CONCAT(id) as ids , GROUP_CONCAT(name) as names   FROM `admin` WHERE   status = 1 AND  `name` IN ('".$staffvalue1."')");
                         
                         $gettoids = mysql_fetch_assoc($sql); 
                         
                         
                        // print_r($gettoids);
                         
                          if(!empty($gettoids) && $gettoids['ids'] != '') {
                          
                                  $getids = explode(',', $gettoids['ids'] );
                                  $names = explode(',', $gettoids['names'] );
								
								/* $datas['message'] = ucfirst($toadminname) . ' You have received a new notification from '.$adminname;
								$datas['class'] = 'info';  
								$datas['message_type'] = 'Notification';  
								$datas['class_name'] = 'task_add_notification';  
								$datas['to'] = $getids[0];  

								AddTaskNotification($datas); */
								  
                                 // print_r($getids);
								 
								 $getids = array_unique($getids);
                                  
                                  if(!empty($getids)) {
                                      
                                      foreach($getids as $adminkys => $adminids) {
                                          
                                          add_p_chat_notes($adminids, $from_type, $message, 2, $names[$adminkys] , $qid , $jobid);
                                      }
                                   }
                          
                            }
                         
                     }
             
             
            }
			
			      
            
 

                    $staff_name = get_rs_value("admin", "name", $from_type);
                
                    $createdOn = date("Y-m-d h:i:s");
                
                    $ins_arg = "insert into message_chat_child set ";
                
                    $ins_arg .= " from_id='" . $from_type. "',";
                    
                    $ins_arg .= " group_to='".$getids[0]. "',";
                
                    $ins_arg .= " message_text='" . $message . "',";
                    $ins_arg .= " job_id='" . $jobid . "',";
                    $ins_arg .= " quote_id='" . $qid . "',";
                
                    $ins_arg .= " createdOn='" . ($createdOn) . "',";
                
                    $ins_arg .= " admin_type='3',";
                
                    $ins_arg .= " from_name='" . $staff_name . "'";
                
                  /*if($getids[0] > 0) {
						$datas['message'] = ' your task is reshuffle please refresh page';
						$datas['class'] = 'info';  
						$datas['message_type'] = 'Notification';  
						$datas['class_name'] = 'task_add_notification';  
						$datas['to'] = $getids[0];  
						

						AddTaskNotification($datas);
				  }
				 */
   
                $ins = mysql_query($ins_arg);

}


function chatListOnline($type, $searchname){
    $alias = '';
   if($type == 1) {    
    
     $sql = "SELECT  S.id as sid ,P.from_id  as fromid, P.to_id  as toid ,  S.name as name ,  P.message_text as message , P.createdOn as createddate from staff as S left JOIN message_chat_parent as P on ( (S.id = P.to_id) OR (S.id = P.from_id ))  AND P.admin_type = 1 AND (P.to_id = ".$_SESSION['admin']." OR P.from_id = ".$_SESSION['admin'].")   where  S.status = 1 AND S.id != 17";
     $alias = 'S';
    
  }elseif($type == 2) {
    
    $sql = "SELECT  A.id as sid ,P.from_id  as fromid, P.to_id  as toid ,  A.name as name ,  P.message_text as message , P.createdOn as createddate FROM  admin as A LEFT JOIN `message_chat_parent`  as P on ( (A.id = P.to_id) OR (A.id = P.from_id ))     AND (P.to_id = ".$_SESSION['admin']." OR P.from_id = ".$_SESSION['admin'].")  AND  P.admin_type = 2 where  A.status = 1  AND A.id != ".$_SESSION['admin']." ";
   $alias = 'A';
      
  }else{
      
       $sql = '';
       
  }
   
   if($searchname != '') {
       $sql .= " AND ".$alias.".name LIKE '%".$searchname."%'";
   }
  
   $sql .= "   ORDER by P.id desc ";   // ORDER by P.id desc
  // echo $sql;
  
    $query = mysql_query($sql);
   
     $count = mysql_num_rows($query);
     
    $allData = array();
   
    if($count > 0) {
     
     $bgcolor =array('#bf9e9e','#bb51b3','#2196f3','#2d6af3','#4f8412','#2196f3','#2196f345','#24b3c5');
		 	    
		 	    $i = 1; while($getdata = mysql_fetch_assoc($query)) 
		 	    { 
		 	    
        		 	    $namestr = explode(' ' ,$getdata['name']);
        		 	    $name ='';
        		 	    
        		 	     $countNa = count($namestr);
        		 	    
                                    foreach($namestr as $val) {
                                        
                                           $name .=  strtoupper($val[0]);
                                    }
        		 	    
        		 	     $randkey = array_rand($bgcolor);
        		 	     
        		 	     
        		 	    $getdata['name_radius'] = $name;
        		 	    $getdata['bg_color'] = $bgcolor[$randkey];
        		 	    $getAlldata[$getdata['sid']][] = $getdata;  
        		 	     
        		 	     //unset($_SESSION['bgcolor'][$getdata['sid']]); $i++; 
		 	        
		 	    }
		 	    
	    //	 echo '<pre>'; print_r($getAlldata);	
		 	
		 	
		 	  foreach($getAlldata as $key=>$admininfo) {
		 	      
		 	        $allData[$key] = $admininfo[0];
		 	  }
         }
    
		 	return $allData;     
   
}

function getLoginTIme($adminid, $calldate){
    
   // echo  "SELECT GROUP_CONCAT(in_time) as intime  FROM `admin_logged`  WHERE DATE(createdOn) = '".date('Y-m-d')."' AND admin_id = ".$adminid."";
    
    $sql = mysql_query("SELECT GROUP_CONCAT(in_time) as intime  FROM `admin_logged`  WHERE DATE(createdOn) = '".$calldate."' AND admin_id = ".$adminid."");
    
    $data =  mysql_fetch_assoc($sql);
    
    return $data['intime'];
}

function getsetddValue($typeid){
 $sql = mysql_query("SELECT id, name , type  FROM `system_dd` WHERE `type` IN (".$typeid.") and status = 1 ORDER by ordering , name asc");
 
  while($data = mysql_fetch_assoc($sql)) {
      
      $getdata[$data['type']][] = $data;
  }
    return $getdata;
}


function getAssinedNotification($calldate){
    
 $sql =  mysql_query("select id, notifications_type, job_id ,p_order , login_id , notifications_status  from site_notifications where  notifications_type in (5,6,7,8) AND DATE(date) = '".$calldate."'");
    while($data = mysql_fetch_assoc($sql)) {
      
      $getdata[$data['login_id']][$data['notifications_status']][] = $data;
  }
    
    return $getdata;
}   
   
  function getOrderpriorty($data) {
      
       foreach($data as $key=>$val) {
           $getdata[$val['p_order']][]  = $val;
       }
      return $getdata; 
  } 
 
 function getCallAllInfo($adminid, $adminname, $loggadminid, $calldate, $checklist = '2,3,4,5,6,7'){
        
        //echo $adminid .' == '.$loggadminid;
        
        $getNotesdata = array();
        $allDataInforamtion = array();
        $loggdetails = array();
        $roleinfo = array();
        $getdata1 = array();
        $smsinfo = [];
        $chatnotes = [];
        $caldate = $calldate;
        $emailsdate = [];
       
        
                $sql =  "SELECT id,  from_type , to_type , admin_id , duration , call_time , job_id , quote_id, (SELECT 3cx_user_name from c3cx_users WHERE c3cx_users.id = c3cx_calls.admin_id) as cname    FROM `c3cx_calls` where   admin_id = ".$adminid." AND call_date = '".$caldate."'";
                $query = mysql_query($sql);
                $count = mysql_num_rows($query);
          
                $callin = 0;
                $callout = 0;
                
               
                
                
                while($data = mysql_fetch_assoc($query)) {
                    
                    
                    if($data['from_type'] == $data['cname']) {
                            $comment = 'Call Out from '.$data['from_type'] .' to '.$data['to_type'];  
                            $callout++;
                            $action = 'Call Out';
                    } else  { 
                          $comment = 'Call In from '.$data['from_type'] .' to '.$data['to_type']; 
                          $callin++; 
                          $action = 'Call In';
                    } 
                        
                     $data['date'] =    $caldate .' '. $data['call_time'];  
                     $data['comments'] =    $comment;
                     $data['role'] =    '';
                     $data['type'] =    2;
                    // $data['call_time'] =    $data['call_time'];
                     $data['action'] =    $action;
                     $getdata[] = $data;  
                     $getTotalTIme[] = $data['duration'];
                }
        
        
       
       
        
        $callduration =  getArrayTime($getTotalTIme);
        
        $checklist = explode(',', $checklist);
        
        //print_r($checklist);
        
        $loggdetails =  roleLoggeddetails($loggadminid, $calldate);
        
        if(in_array(2, $checklist)) {
           $roleinfo = $loggdetails['callroledetails'];
        }
        
         if(in_array(3, $checklist)) {
           $getdata1 = $getdata;
         }
        
      //print_r($checklist) ;   
        
       if(in_array(5, $checklist)) {
          $smsinfo = SMSMessage($loggadminid);
          // $roleinfo = $loggdetails['callroledetails'];
        }
        
      if(in_array(6, $checklist)) {
          $chatnotes = ChatNotes($loggadminid);
          // $roleinfo = $loggdetails['callroledetails'];
        }
        
     if(in_array(7, $checklist)) {    
         $emailsdate =  getEmailsInfo($calldate , $loggadminid);    
     }
        
        
     
        
          $allDataInforamtion = array_merge($getdata1 , $roleinfo , $emailsdate );
            usort($allDataInforamtion, 'date_compare');
            $flag = 0;
            if(in_array(4, $checklist)) { $flag = 1;}
            
          $getNotesdata = NotesMerge($loggadminid, $calldate, $flag);
          
            //echo '<pre>'; print_r($allDataInforamtion);
          //  echo '<pre>';  print_r($emailsdate);   die;
          $allInfoData = array_merge($allDataInforamtion , $getNotesdata , $smsinfo, $chatnotes);
          
        //  echo '<pre>'; print_r($allInfoData);
          
          usort($allInfoData, 'date_compare');
        
        $emailtime =  getEmailsdata($loggadminid , $calldate);
        $infodata = array('callin'=>$callin,'callout'=>$callout, 'callduration'=>$callduration, 'callinfo'=>$allInfoData,'emailtime'=>$emailtime);
       
       $addinfodata = array_merge($infodata , $loggdetails );
     
       return $addinfodata;
     
 }
 
    function SMSMessage($loggadminid) 
    {
     
         $sql1 = "SELECT * FROM `bcic_sms`  WHERE date_sent = '".date('Y-m-d')."' and type_sms_info = 1 and admin_id = ".$loggadminid."  ORDER BY `id` DESC";
        
        $query1 = mysql_query($sql1);
         $count1 = mysql_num_rows($query1);
        $getsmsinfo = [];
        while($data1 = mysql_fetch_assoc($query1)) {
             
              $texttime =  str_replace(array('pm','am') ,array('',''), $data1['date_time']);
             
                    $action = 'SMS Out on '.$data1['to_num']; 
                    //$time =    date('Y-m-d H:i:s' , strtotime($data1['date_time']));
             
                    $data['type'] = '';
                    $data['role'] = 'SMS';
                    $data['comments'] = $data1['message'];
                    //$data['quote_id'] = 0;
                    $data['action'] =    $action;
                    //$data['call_time111'] = $texttime; 
                    $data['call_time'] = date("H:i:s", strtotime($texttime)); 
                    $data['date'] = date('Y-m-d H:i:s' , strtotime($texttime));
                   // $data['call_time'] = $data1['date_time'];
                   $getsmsinfo[] = $data;
        }
        
     return $getsmsinfo;   
   }
   
  
 function ChatNotes($loggadminid){
     
     $sql1 = "SELECT * FROM  chat   WHERE date(chat_exact_time) = '".date('Y-m-d')."' and chat_type = 'admin' and type_sms_info = 2 AND  chat.from = ".$loggadminid."  ORDER BY `id` DESC";
        
        $query1 = mysql_query($sql1);
         $count1 = mysql_num_rows($query1);
        $getchatinfo = [];
        while($data1 = mysql_fetch_assoc($query1)) {
             
             // $texttime =  str_replace(array('pm','am') ,array('',''), $data1['date_time']);
             
                    $action = 'Chat to '.$data1['to']; 
                    //$time =    date('Y-m-d H:i:s' , strtotime($data1['date_time']));
             
                    $data['type'] = '';
                    $data['role'] = 'Chat';
                    $data['comments'] = $data1['message'];
                    $data['action'] =    $action;
                    $data['call_time'] = date("H:i:s", strtotime($data1['chat_exact_time'])); 
                    $data['date'] = date('Y-m-d H:i:s' , strtotime($data1['chat_exact_time']));
                   $getchatinfo[] = $data;
        }
        
     return $getchatinfo;   
 }
 
 function getEmailsdata($staffid , $date, $todate = 0, $type = 0){
	    
		if($type == 0 ) {
		
	        $sql1="SELECT id, email_id , open_time,staff_id ,  activity , closed_time FROM `email_activity` WHERE `staff_id` = '".$staffid."' AND DATE(`date_time`) = '".$date."' order by date_time Asc";
			
		}else if($type == 1 ) {
		
		   $sql1="SELECT id, email_id , open_time,staff_id ,  activity , closed_time FROM `email_activity` WHERE `staff_id` = '".$staffid."' AND DATE(`date_time`) >= '".$date."'  AND DATE(`date_time`) <= '".$todate."'  order by date_time Asc";
		   
		}
		
        $query1 = mysql_query($sql1);
        $count1 = mysql_num_rows($query1);
          
         if($count1 > 0) { 
            $getdata1 = array();
            $flag = 0;
              while($data1 = mysql_fetch_assoc($query1)) {
                  
                            if($data1['activity'] == 'Open Email' && $flag == 0) {
                                $opentime= $data1['open_time'];
                                $flag = 3;
                            }
                            
                            if($data1['activity'] == 'Closed Email' && $flag == 3) {
                               $closed_time = $data1['closed_time'];
                               $flag = 2;
                            }
                  
                  if($flag == 2) {
                        $totaltime = CalculateTime($opentime , $closed_time);   
                        
                      
                         $getdata1[$data1['email_id']][] = array(
                                 'emailsid'=> $data1['email_id'] ,
                                 'fotime' =>$opentime,
                                 'lclo' =>$closed_time,
                                 'totaltime' =>$totaltime
                            );
                      $flag = 0; 
                  }
              
            } 
	    
	      //  echo '<pre>';  print_r($getdata1);
	          return  getTotalTime($getdata1);   
         }
	}
	
	function getTotalTime($getdata1)
	{
	    
            foreach($getdata1 as $key=>$valuetime) {
                
                  foreach($valuetime as $kk => $data11) {
                       $arr[] = $data11['totaltime'];
                  }
            }
           
                           $total = 0; 
                        // Loop the data items 
                        foreach( $arr as $element): 
                        
                        // Explode by seperator : 
                        $temp = explode(":", $element); 
                        
                        // Convert the hours into seconds 
                        // and add to total 
                        $total+= (int) $temp[0] * 3600; 
                        
                        // Convert the minutes to seconds 
                        // and add to total 
                        $total+= (int) $temp[1] * 60; 
                        
                        // Add the seconds to total 
                        $total+= (int) $temp[2]; 
                        endforeach; 
                        
                        // Format the seconds back into HH:MM:SS 
                        $formatted = sprintf('%02d:%02d:%02d',  
                                ($total / 3600), 
                                ($total / 60 % 60), 
                                $total % 60); 
                        
                        return  $formatted;  
	}
 
 function roleLoggeddetails($adminid, $calldate){
      $sql = "SELECT id , login_id , admin_role, (SELECT name from system_dd WHERE id = admin_role.admin_role and type = 102) as rolename,   
     TIMEDIFF(updatedOn, createdOn) as roletime,   createdOn  FROM `admin_role`    WHERE DATE(createdOn) = '".$calldate."' and login_id = ".$adminid."  AND updatedOn != '0000-00-00 00:00:00' ORDER by id ASC";
      $query = mysql_query($sql);
      $count = mysql_num_rows($query);
      $callinfo = array();
        if($count > 0) 
        {
           while($data = mysql_fetch_assoc($query)) 
            {
                 $gettime[] = $data['roletime'];
                 
                 if($data['admin_role'] == 26){
                     $gettimeafk[] = $data['roletime'];
                 }
                 if($data['admin_role'] == 27){
                     $gettimelunch[] = $data['roletime'];
                 }
                 
                 if($i == 0) {
                     $logintime = $data['createdOn'];
                    
                       $action = 'LoggedIn';
                       $loggtime = 'Started '.date('h:i:A' , strtotime($data['createdOn']));
                 }else{
                       $action = $data['rolename'];
                       $loggtime = 'Select  '.$action . ' In Task' ;
                       
                 }
                 
                 $type =    1;
                 $date = $data['createdOn'];
                 $calltime = date('H:i:s' , strtotime($data['createdOn']));
                
                $callroledetails[] = array('call_time'=>$calltime , 'role'=> '<b>'.$action.'</b>' , 'date'=> $date , 'comments'=>'<b>'.$loggtime.'</b>','type'=>$type);
                 
                 $i++;
            }
       
         
           // echo '<pre>'; print_r($callroledetails); 
            $totalworktime =  getArrayTime($gettime);
            $totalafktime =  getArrayTime($gettimeafk);
            $totallunchtime =  getArrayTime($gettimelunch);
            
             $callinfo = array('totalworktime'=>$totalworktime,'totalafktime'=>$totalafktime,'totallunchtime'=>$totallunchtime,'logintime'=>$logintime,'callroledetails'=>$callroledetails);
        }else{
            $callroledetails = array();
             $callinfo = array('totalworktime'=>'','totalafktime'=>'','totallunchtime'=>'','logintime'=>'','callroledetails'=>$callroledetails);
        }
        
       // echo '<pre>'; print_r($callinfo); 
        
      return $callinfo;
      
 }
 
 function NotesMerge($adminid, $calldate, $flag){
     $qnotes = array();
      $jobnotes = array();
      
      if($flag == 1) {
            $qnotes =  gettodayQUoteNotes($adminid, $calldate);
            $jobnotes =  gettodayjobsNotes($adminid, $calldate);
            
             // echo '<pre>'; print_r($qnotes); 
            $allDataInforamtion = array_merge($qnotes , $jobnotes );
                 
                //echo '<pre>'; print_r($allDataInforamtion); 
                  usort($allDataInforamtion, 'date_compare');
            
            return $allDataInforamtion;
      }else{
          return array();
      }
 }
 
 
   function gettodayQUoteNotes($adminid, $calldate)
    {
        
        $sql =   "SELECT id, quote_id ,  heading , date  FROM `quote_notes` WHERE DATE(date) = '".$calldate."'  AND  staff_name != 'Automated' AND staff_name != 'site' AND login_id = ".$adminid." 
        and quote_id NOT in (SELECT quote_id FROM job_notes WHERE DATE(date) = '".$calldate."' AND staff_name != 'Automated' AND login_id = ".$adminid.")";
   
       $query = mysql_query($sql);
       $count = mysql_num_rows($query);
       $getquoteNotes = array();
       
           if($count > 0) {
                while($data = mysql_fetch_assoc($query)) {
                    $data['type'] = 3;
                    $data['role'] = '';
                    $data['comments'] = $data['heading'];
                    $data['quote_id'] = $data['quote_id'];
                    $data['call_time'] = date('H:i:s' , strtotime($data['date']));
                    $getquoteNotes[] = $data;
                }
           }
           
        return $getquoteNotes;   
   }
   
 
 function gettodayjobsNotes($adminid, $calldate){
     
    $sql =   "SELECT id, heading , quote_id , job_id , date  FROM `job_notes`  WHERE DATE(date) = '".$calldate."' AND staff_name != 'Automated' AND staff_name != 'site'   AND login_id = ".$adminid."";
   
   $query = mysql_query($sql);
        $count = mysql_num_rows($query);
  
  $getquoteNotes = array();
   if($count > 0) {
        while($data = mysql_fetch_assoc($query)) {
            $data['type'] = 4;
            $data['role'] = '';
            $data['comments'] = $data['heading'];
            $data['quote_id'] = $data['quote_id'];
            $data['job_id'] = $data['job_id'];
            $data['call_time'] = date('H:i:s' , strtotime($data['date']));
            $getquoteNotes[] = $data;
        }
    }
        
    return $getquoteNotes;    
          
 }
 
   
 function loggintime($adminid){
     $sql = "SELECT TIMEDIFF(out_time, in_time) as caltime, admin_id ,  createdOn  FROM `admin_logged` WHERE DATE(createdOn) = '".date('Y-m-d')."' AND admin_id=".$adminid." ORDER by id ASC";
     $query = mysql_query($sql);
        $count = mysql_num_rows($query);
        $i = 0;
         while($data = mysql_fetch_assoc($query)) {
             $gettime[] = $data['caltime'];
             if($i == 0) {
                 $logintime = $data['createdOn'];
             }
             $i++;
         }
     $loggintime =  getArrayTime($gettime);
     return array('totalloggtime'=>$loggintime,'logintime'=>$logintime);
 }
 
  function getEmailInfodetails($date , $staff_id){
     $sql =  "SELECT *    FROM `email_activity` where  DATE(date_time) = '".$date."' AND staff_id = ".$staff_id."";
     $query = mysql_query($sql);
     $count = mysql_num_rows($query);
     $sent = 0;
     $openemail = 0;
     $closedemail = 0;
     while($data = mysql_fetch_assoc($query)) {
          
          //$getdata[$data['staff_id']][] = $data['staff'];
         
         
         if($data['is_sent'] == 1) {
              $sent++;
            
         }else if($data['is_sent'] == 0) {
             
             if($data['closed_time'] == '0000-00-00 00:00:00') {
                $openemail++;
             }else if($data['closed_time'] != '0000-00-00 00:00:00') {
                $closedemail++;
             }
        }
       
     }
     return $getdata  = array('send'=>$sent,'openemail'=>$openemail , 'closedemail'=>$closedemail);
     
    } 
  
  
    function getChatDetails($date, $adminid)
    {
      
     $sql =  "SELECT *  FROM `chat` WHERE DATE(chat_exact_time) = '".$date."' and ( chat.from = ".$adminid." or to_id = ".$adminid.")";
     $query = mysql_query($sql);
     $count = mysql_num_rows($query);
     $sent = 0;
     $recived = 0;
      while($data = mysql_fetch_assoc($query)) {
          
           if($data['chat_type'] == 'admin') {
               $sent++;
           }else if($data['chat_type'] == 'staff') {
               $recived++;
           }
      }
      
     return array('sent'=>$sent, 'recived'=>$recived); 
     
    }
   
    function getlAdminoginTime($date, $adminid, $type) {
		  
		   if($type == 1) {
			   $order = 'ASC';
		   }else if($type == 2){
			   $order = 'DESC';
		   }
		
		 $sql = mysql_query("SELECT in_time , out_time FROM `admin_logged` WHERE admin_id = ".$adminid." and DATE(createdOn) = '".$date."' ORDER by id  $order LIMIT 1");
		$count = mysql_num_rows($sql);
		$data = mysql_fetch_array($sql);
		 if($type == 1) {
		   return $data['in_time']; 
		 }else if($type == 2){
			return $data['out_time']; 
		  }
	}
   
   function getlunchTime($date, $adminid, $type) {
		  
		  
		 $sql = mysql_query("SELECT createdOn , updatedOn FROM `admin_role` WHERE  login_id = ".$adminid." AND admin_role = 27 and  DATE(createdOn) = '".$date."'");
		 
		$count = mysql_num_rows($sql);
		$data = mysql_fetch_array($sql);
		 if($type == 1) {
		   return $data['createdOn']; 
		 }else if($type == 2){
			return $data['updatedOn']; 
		  }
	}
   
    function getAdminRoster($adminid, $date) {
		
		// echo "SELECT status, date  FROM `admin_roster` WHERE admin_id = ".$adminid." and MONTH(date) = '".date('m', strtotime($date))."' AND YEAR(date) = '".date('Y', strtotime($date))."'";
		
	      $sql = 	mysql_query("SELECT id, admin_id, roster_type, leave_type  ,start_time_au,  end_time_au ,lunch_time_au , lunch_end_time_au,   (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau, (SELECT lunch_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchstart, (SELECT lunch_end_time_au FROM `admin_time_shift` WHERE id = A.lunch_time_au ) as lunchend, date  FROM `admin_roster` as A WHERE admin_id = ".$adminid." and MONTH(date) = '".date('m', strtotime($date))."' AND YEAR(date) = '".date('Y', strtotime($date))."'");
		  $count = mysql_num_rows($sql);
             
                    while($data = mysql_fetch_assoc($sql)) { 
					    $getinfo[$data['date']] = $data;
					}
                

            return $getinfo;    
	}
   
   function review_system_info($stage, $adminid, $fromdate, $todate)
    {
       
       $sql =  "SELECT id, job_id ,  review_date, overall_experience , name, email , phone  FROM `bcic_review` WHERE review_date BETWEEN  '".date('Y-m-01' ,  strtotime($fromdate))."' AND '".date('Y-m-d', strtotime($todate))."' and overall_experience in (4, 5)";       
   
       $sql .=   ' AND step = '.$stage.'';
       
       /* if($stage == 1) {  
          $sql .=   ' AND step = 1';
          
        }else if($stage == 2) {  
           $sql .=   ' AND step = 2'; 
        }else if($stage == 3) {  
           $sql .=   ' AND step = 3'; 
        }else if($stage == 1) {  
           $sql .=   ' AND step = 4'; 
        }else if($stage == 1) {  
           $sql .=   ' AND step = 5'; 
        }else if($stage == 1) {  
           $sql .=   ' AND step = 6'; 
        }*/
           
           
          $query = mysql_query($sql);
                $count = mysql_num_rows($query);
                 
                    while($data = mysql_fetch_assoc($query)) {
                          
                          $getinfo[$stage][] = $data;
                    }
                    
                return $getinfo;      
           
    }
    
    
    function application_system_info($stage, $adminid, $fromdate, $todate)
    {
       
      
           //if($stage == 1) {  
               
                $sql =  "SELECT id , given_name , first_name, date_started , last_name , first_name , email, mobile , phone , step_status  
                  FROM 
                  `staff_applications`  where date_started BETWEEN  '".date('Y-m-01' ,  strtotime($fromdate))."' AND '".date('Y-m-d', strtotime($todate))."' ORDER by id DESC ";       
                $query = mysql_query($sql);
                $count = mysql_num_rows($query);
                 
                    while($data = mysql_fetch_assoc($query)) {
                          
                          $getinfo[$data['step_status']][] = $data;
                    }
                    
                return $getinfo;    
          
    }
	
	function getdefualRoster($adminid,$getDate){
			$dates = implode("','", $getDate);
			$sqlq =   mysql_query("SELECT * FROM `admin_roster_default`  WHERE admin_id = ".$adminid." AND day in ('".$dates."')");

			$count = mysql_num_rows($sqlq);

			if($count > 0) {
				while($gettimedata = mysql_fetch_assoc($sqlq)) {
				   $getdata[$gettimedata['day']] = $gettimedata;
				}
			   //$buttontype = 'Update';
			}
	    return $getdata;		
	}

   
    function checkadminRosterUpdate($id= null )
	{
	
		$getdateInarray = WEEK_DAYS_ARRAY;
		//print_r($alldata); die;
		//$getdateInarray = explode("','" , ($alldata));
		$getdate = array();
	 
	    foreach($getdateInarray as $value) {
	      $getdate[] =  substr($value,0,3);
	    } 
		
		//print_r($getdate); die;
		
		$numberday=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		
		$rosterdata = getdefualRoster($id, $getdateInarray);
		
		/*  echo date('l');
		echo '<pre>'; print_r($rosterdata); die; */
		
		for($d=1; $d<=$numberday; $d++)
		{
				$time=mktime(12, 0, 0, date('m'), $d, date('Y'));
				if (date('m', $time)==date('m'))
				$date = date('Y-m-d', $time);
				$checkday1= date('D', $time);
				$checkday= date('l', $time);
				$day = date('D', $time);
				
			
			  $checkStaffRosterID = mysql_query("Select id  from admin_roster where  date ='" . $date ."' AND admin_id = {$id}"); 
			 
/*			 $status = 0;
			 if($rosterdata[$checkday]['start_time_au'] != 0) {
				 $status = 1;
			 }*/
			 
			 $status = $rosterdata[$checkday]['start_time_au'];
			 
			  $countRecord = 	mysql_num_rows($checkStaffRosterID); 
		   
			  if($countRecord > 0)
			{
				$sql = "UPDATE `admin_roster` SET `start_time_au` = '".$rosterdata[$checkday]['start_time_au']."' , `status`=".$status." , `end_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_time_au` = '".$rosterdata[$checkday]['end_time_au']."' , `lunch_end_time_au` = '".$rosterdata[$checkday]['lunch_time_au']."'  WHERE `date` = '".$date."' AND admin_id = {$id}";
			 }
			 
			else
			{	 				
			
			   $sql = "INSERT INTO `admin_roster`  (`admin_id`, `date`, `status` , `start_time_au`, `end_time_au`, `lunch_time_au`, `lunch_end_time_au`, `createdOn`)  VALUES   (".$id.",  '".$date."',".$status." , ".$rosterdata[$checkday]['start_time_au'].", ".$rosterdata[$checkday]['end_time_au'].", ".$rosterdata[$checkday]['lunch_time_au'].", ".$rosterdata[$checkday]['lunch_end_time_au'].",'".$createdOn."')"; 
			   
			} 
			
             mysql_query($sql);	
           
	    } 
	}
   

    function getRequoteAssign1($adminid, $fromdate, $re_status)
	    {		
	
			  $sql = "SELECT id, re_quote_status FROM `re_quoteing` WHERE re_quote_admin_id = ".$adminid." AND DATE(createdOn) ='".$fromdate."' AND re_quote_status = ".$re_status."";
			$query = mysql_query($sql);		
			$count = mysql_num_rows($query);	
			$getData = array();			
			if($count > 0) {				
    			while($data = mysql_fetch_assoc($query)) {		
    		  	 $getData[] = $data;		
    			}	
			}		
			return $getData;		
		}	
	
	function getrosterdefault($adminid) {
	    
	       // return   "select  day , (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau  FROM `admin_roster_default` as A WHERE admin_id = ".$adminid."";
        	$query = mysql_query("select  day , (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau, (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau  FROM `admin_roster_default` as A WHERE admin_id = ".$adminid."  ORDER by id asc");
	
	       // $query = mysql_query($sql);		
			$count = mysql_num_rows($query);
			$str = '';
			
			$str = '<table style="width: 100%;">
			    <tr>
                    <th style="text-align: center;">Day</th>
                    <th style="text-align: center;">Start</th>
                    <th style="text-align: center;">End</th>
                  </tr>';
			
			 if($count > 0) {			
			     
    			while($data = mysql_fetch_assoc($query)) {		
    			    
    			    $str .= '
                      <tr>
                        <td>'.$data['day'].'</td>
                        <td>'.$data['startau'].'</td>
                        <td>'.$data['endau'].'</td>
                      </tr>';
    		  	 //$getData[] = $data;		
    			}	
			}else { 
			 	$str .= '<tr><td colspan="3">No Records</td></tr>';   
			}
		$str .= '</table>';
			return $str;	
	    
	}
	
	
	function getQuoteInfo($fromdate, $todate){
	    
	    $sql = "SELECT
                    
                    COUNT(id ) as totalorder, 
                    count(case 
                      when  booking_id != 0 then booking_id
                    end)  as bookingid ,
                    
                    count(case 
                      when  job_ref = 'Site' then job_ref
                    end)  as totalsites 
                    ,
                    
                    count(case 
                      when  job_ref != 'Site' then job_ref
                      end)  as adminquote 
                    ,
                    
                    count(case 
                      when  (oto_flag = 1 AND  oto_time != '0000-00-00 00:00:00' AND booking_id != 0) then booking_id
                    end)  as totalotobooking_id 
                     ,
                     
                    count(case 
                      when  (date >= '".$fromdate."' AND date <= '".$todate."') then id
                    end)  as currentquote
                    ,  
                    
                    count(case 
                     when  (quote_to_job_date >= '".$fromdate."'  AND quote_to_job_date <= '".$todate."' AND booking_id != 0) then booking_id
                    end)  as currentctodbooking 
                    ,
                    
                    count(case 
                      when  (date >= '".$fromdate."' AND date <= '".$todate."' AND booking_id != 0) then booking_id
                    end)  as currentbooking_id	
                	,
                	
                    count(case 
                      when  (date >= '".$fromdate."' AND date <= '".$todate."'  AND job_ref != 'Site' ) then job_ref
                      end)  as currentadminquote 
                    ,
                     
                     
                   count(case 
                      when  (date >= '".$fromdate."' AND date <= '".$todate."' AND job_ref = 'Site') then job_ref
                    end)  as currentsites 

            FROM `quote_new` WHERE step != 10 ";
              
            $query = mysql_query($sql);  
            $count = mysql_num_rows($query);
            $data = mysql_fetch_assoc($query); 	
              
            return $data;  
	    
	}
	
	
	 function number_format_short($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));
        // is this a number?
        if (!is_numeric($n)) return false;
         // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).'T';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).'B';
        elseif ($n > 1000000) return round(($n/1000000), 2).'M';
        elseif ($n > 1000) return round(($n/1000), 2).'K';
 
        return number_format($n);
    }


   function getTaskNotification(){
         $str = '5,6,7 ,8';
           	$staff_notification= "select id, notifications_type, job_id ,p_order , login_id , heading, comment , date , (SELECT name from admin WHERE id = site_notifications.login_id) as adminid , staff_name, message_status ,  (SELECT name  FROM `system_dd` WHERE `type` = '135' AND site_notifications.message_status = id ) as messageStatus from site_notifications where notifications_status = '0' AND message_status != 3 AND notifications_type IN (".$str.")  "; 
    	
    	
    	$staff_notification .= "  ORDER BY p_order ASC";
    	
    	$sqlquery = mysql_query($staff_notification);
    	
    	$count = mysql_num_rows($sqlquery);
    	
    	  	while($getdata = mysql_fetch_assoc($sqlquery)) {
					$i++;
								if($getdata['login_id'] > 0 ) {
									  //$auto_role = get_rs_value('admin','auto_role',$getdata['login_id']);
									  $auto_role = get_rs_value("admin","auto_role",$getdata['login_id']);
								      $infoUser[$auto_role][$getdata['login_id']][$getdata['p_order']][] = $getdata['login_id'];
								      
								 }else{
								      $infoUser[0][0][$getdata['p_order']][] = $getdata['login_id'];
								 }
    	  	}
    	 return array('total'=>$count ,'infonoti'=>$infoUser); 	
   }
	
  function allgetQUoteInfo(){
      
     $sql =  "SELECT count(id) as quoteid , 
          count(case 
              when  booking_id != 0 then booking_id
            end)  as totalbooked 
            , date, MONTH(date) as monthnumber, YEAR(date) as yearnumber , MONTHNAME(date) as monthname,  SUBSTRING( MONTHNAME(date), 1, 3) AS firstmonthname  FROM `quote_new` WHERE step != 10 GROUP BY MONTH(date),  YEAR(date) ORDER by date asc";
            
    $query = mysql_query($sql);
    	while($getdata = mysql_fetch_assoc($query)) {
    	    $getallinfo[] = $getdata;
    	}
    		
    return $getallinfo;	
  }	
	
	
	function getSalesInfo($stageskey)
	{
	    
	     $today = date('Y-m-d');
        $fromtoday = date('Y-m-d H:i:s', strtotime('-30 minutes'));
        $lasttoday = date('Y-m-d H:i:s', strtotime("+90 minutes")); 
         
         $argsql1 =  "select id ,quote_id , task_manage_id from sales_task_track where 1 = 1 AND task_status = 1  AND track_type = 1 AND quote_id in ( select id from quote_new where 1 = 1 AND ( booking_date >= '".date('Y-m-d')."' OR booking_date = '0000:00:00' ) AND 
         removal_enquiry_date = '00:00:00 00:00:00' AND booking_id = 0 AND step not in (8,9,10) AND denied_id = 0 AND date >= '".date('Y-m-01', strtotime('-2 month'))."' AND date <= '".date('Y-m-t')."' )";
           
           
                  if ($stageskey == 1)
            {
        
                $argsql1 .= " AND  fallow_date < '" . $fromtoday . "' ";
        
            }
            elseif ($stageskey == 2)
            {
        
                $argsql1 .= " AND  fallow_date >= '" . $fromtoday . "' AND fallow_date <= '" . $lasttoday . "'";
        
            }
            elseif ($stageskey == 3)
            {
        
                $argsql1 .= " AND  fallow_date >= '" . $lasttoday . "'";
        
            } 
            
          $query = mysql_query($argsql1);
          $quotecount = mysql_num_rows($query);      
          
                if($quotecount > 0) {
                       while($data = mysql_fetch_assoc($query)) {
                           
                           $login_status = get_rs_value("admin","login_status",$data['task_manage_id']);
                           if($login_status == 1) {
                               $getInfo[1][$data['task_manage_id']][]   = $data;
                           }else{
                                if($data['task_manage_id']  > 0) {
                                   $getInfo[0][$data['task_manage_id']][]   = $data;
                                }else{
                                  $getInfo[0][0][]   = $data;  
                                }
                           }
                           
                           unset($login_status);
                        }
                }
        
        return array('totalq'=>$quotecount , 'quoteinfo'=>$getInfo);    
          
	}
	

    function movereshuffle($stageskey) {
         
         $getadminDetails = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids   FROM `admin` WHERE status = 1 and is_call_allow = 1 AND login_status = 1  and auto_role in (1) order by id")); 
        // $getadminDetails['ids']  = '31,52,78';
         $adminida = explode(',', $getadminDetails['ids']);
         
        // print_r($adminida);
       
            $today = date('Y-m-d');
            $fromtoday = date('Y-m-d H:i:s', strtotime('-30 minutes'));
            $lasttoday = date('Y-m-d H:i:s', strtotime("+90 minutes")); 
        
          $totaladmin = count($adminida);
          $quoteInfo =  getSalesInfo($stageskey);
          
          //print_r($quoteInfo); die; 
          
            $totalcount  = $quoteInfo['totalq'];
           $quoteinfo  = $quoteInfo['quoteinfo'];
           
            //echo '<pre>'; print_r($quoteinfo);
           
           //echo $totalcount;
           
            if($totalcount > $totaladmin) {
                
                    $totaldiv = round($totalcount/$totaladmin);
                    
                 
                    $loggedoutadmin = $quoteinfo[0];
                    
                    foreach($loggedoutadmin as $key=>$val) {
                         
                         $getallrestQUote[$key] =  (0 - count($val));
                    }
                    
              
                 
                    foreach($adminida as $adminidkey=>$adminv) 
                    {
                        $adminquote = count($quoteinfo[1][$adminv]);
                        $getallrestQUote[$adminv] = ($totaldiv -  $adminquote);
                        
                        unset($adminquote);
                        //unset($totaldiv);
                    }
                    
                    
                  /*  print_r($getallrestQUote);
                    echo '<br/>';*/
                   
                    
                   foreach($getallrestQUote as $key1=>$val1) {
                       
                       //echo  count($val1); 
                       
                       if($val1 < 0) {
                                $limit = str_replace('-', '', $val1);
                                //  echo  $key1 . '== '.$val1;
                                $getkeyids[] = $val1;
                                //                  $limit = str_replace('-', '', $val1);
                                
                                $argsql1 =  "UPDATE  sales_task_track set task_manage_id = 0, chek_id = '".$key1."' where 1 = 1 AND task_status = 1 AND task_manage_id = ".$key1."  AND track_type = 1 AND quote_id in ( select id from quote_new where 1 = 1 AND ( booking_date >= '".date('Y-m-d')."' OR booking_date = '0000:00:00' ) AND 
                                removal_enquiry_date = '00:00:00 00:00:00' AND booking_id = 0 AND step not in (8,9,10) AND denied_id = 0 ) ";
                                
                                if ($stageskey == 1)
                                {
                                
                                $argsql1 .= " AND  fallow_date < '" . $fromtoday . "' ";
                                
                                }
                                elseif ($stageskey == 2)
                                {
                                
                                $argsql1 .= " AND  fallow_date >= '" . $fromtoday . "' AND fallow_date <= '" . $lasttoday . "'";
                                
                                }
                                elseif ($stageskey == 3)
                                {
                                
                                $argsql1 .= " AND  fallow_date >= '" . $lasttoday . "'";
                                
                                } 
                                $argsql1 .= "  limit  $limit";
                               
                            
                       }
                       
                     if($val1 > 0) {
                         
                              $limit = $val1;
                        $argsql1 =  "UPDATE  sales_task_track set task_manage_id = ".$key1." , chek_id = '22'  where 1 = 1 AND task_status = 1 AND task_manage_id  = 0 AND track_type = 1 AND quote_id in ( select id from quote_new where 1 = 1 AND ( booking_date >= '".date('Y-m-d')."' OR booking_date = '0000:00:00' ) AND 
                        removal_enquiry_date = '00:00:00 00:00:00' AND booking_id = 0 AND step not in (8,9,10) AND denied_id = 0 )"; 
                        
                        if ($stageskey == 1)
                        {
                        
                        $argsql1 .= " AND  fallow_date < '" . $fromtoday . "' ";
                        
                        }
                        elseif ($stageskey == 2)
                        {
                        
                        $argsql1 .= " AND  fallow_date >= '" . $fromtoday . "' AND fallow_date <= '" . $lasttoday . "'";
                        
                        }
                        elseif ($stageskey == 3)
                        {
                        
                        $argsql1 .= " AND  fallow_date >= '" . $lasttoday . "'";
                        
                        } 
                        $argsql1 .= "  limit  $limit";
                        
                      
                     }
           
                          if($key1 > 0) {
        						$datas['message'] = ' Your task is reshuffle please refresh page';
        						$datas['class'] = 'info';  
        						$datas['message_type'] = 'Notification';  
        						$datas['class_name'] = 'task_add_notification';  
        						$datas['to'] = $key1;  
        						
        
        						AddTaskNotification($datas);
        				  }
                              
                            mysql_query($argsql1);         
                   }
                  echo 'reshuffle successfully done'; 
            }
         
    }
    
    function getRole($role){
         $data = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids FROM `admin` where status = 1 and ( auto_role = ".$role." OR ( id = 17 OR id = 1 ) )"));
         return $data['ids'];
    }
  
  
   function getEmailsInfo($todate , $adminid){
       
        $date = $todate;
        $fromdate = date('Y-m-d 00:00:00' , strtotime($date));
        $todate = date('Y-m-d 23:59:00' , strtotime($date));
        
        $sql = "SELECT  DISTINCT(email_id) as email_id , id , activity , emailids , date_time , open_time , closed_time ,is_sent ,  staff_name FROM `email_activity`   WHERE date_time >=  '".$fromdate."' and date_time <=  '".$todate."' AND p_id  = 0";
        
        if($_SESSION['email_report_data']['admin_id'] != '0') {
              $sql .= " AND staff_id = ".$adminid."";
        }
        
          $sql .= ' group by email_id Order by id desc';
          
        // echo $sql; 
            $query = mysql_query($sql);
            
            $count = mysql_num_rows($query); 
          $getsmsinfo = [];
           if($count > 0)  { 
            	    while($data1 = mysql_fetch_assoc($query)) {
            	        
            	        
            	         $getallrecords =  getEmailsRecord($fromdate , $todate , $data1['email_id'], $adminid);
            	        
                            $start_time = date('h:i:s A' , strtotime($data1['open_time']));
                            if($data['closed_time'] != '0000-00-00 00:00:00') { $end_time =  date('h:i:s A' , strtotime($data1['closed_time'])); }
                            if($data['is_sent'] == 1) {$is_sent =  'Yes'; }else {$is_sent =  'No'; }
                            
            	          //if($data['is_sent'] == 1) { $activity =  'Yes'; }else {$activity =  'No'; }
            	        
                           $action = 'Email'; 
                       // $data2
                        $data['type'] = '';
                        $data['role'] = 'Email';
                        $data['comments'] = $data1['activity'];
                        //$data['quote_id'] = 0;
                        $data['action'] =    'Open & Closed ( '. count($getallrecords).' )';
                        //$data['call_time111'] = $texttime; 
                        $data['call_time'] = ''; 
                        $data['date'] = date('Y-m-d H:i:s' , strtotime($data1['open_time']));
                        $data['call_time'] = date('H:i:s' , strtotime($data1['open_time']));
                        $getsmsinfo[] = $data;
            	        
            	        unset($getallrecords);
            	        
            	        
            	    }
            	    
           }
          
         
        // print_r($getsmsinfo); 
          
          return $getsmsinfo;
          
           
        }
        
        
    function sendmailwithattach_application($sendto_name, $sendto_email, $sendto_subject, $sendto_message, $replyto, $filepath)
    {
        
            $sql_email = "SELECT * FROM siteprefs where id=1";
            
            $site = mysql_fetch_array(mysql_query($sql_email));
            
            //echo "$site[siteurl]";
            
            
            $sendto = $sendto_name . "<" . $sendto_email . ">";
            
            //	echo $sendto; die;
            $email_message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
            
            <HTML><HEAD><TITLE>" . $site['site_domain'] . "</TITLE>
            
            <META content=\"text/html; charset=windows-1252\" http-equiv=Content-Type>
            
            </HEAD>
            
            <link rel=\"stylesheet\" href=\"http://www.bcic.com.au/admin/css/style.css\" type=\"text/css\">
            
            <link href=\"http://www.bcic.com.au/admin/css/general.css\" rel=\"stylesheet\" type=\"text/css\">
            
            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
            
            <tr><td class=\"text12\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><p>" . $sendto_message . "</p></font>
            
            <p>
            
            <font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Should you have any enquiries in relation to this matter please do not hesitate to email us at hr@bcic.com.au <br><br>
            
            Kind Regards</font>
            
            </p>
            
            <P><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">
            
            BCIC HR Team<br>
            
            <a href=\"" . $site['site_domain'] . "\"><img src=\"" . $site['site_url'] . $site['logo'] . "\" /></a><br>
            
            p: 1300 599 644<br>
            
            e: hr@bcic.com.au<br>
            
            w: " . $site['site_domain'] . "</font></P>
            
            ";
            
            $email_message .= "<P><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><strong>CAUTION</strong>: 
            
            This email and any attachments may contain information that is confidential and subject to legal privilege. 
            
            If you are not the intended recipient, you must not read, use, disseminate, distribute or copy this email or any attachments. 
            
            If you have received this email in error, please notify us immediately and erase this email and any attachments. Thank you. <br>
            
            <strong>DISCLAIMER</strong>: To the maximum extent permitted by law, BCIC is not liable (including in respect of negligence) for viruses or other defects or 
            
            for changes made to this email or to any attachments. Before opening or using attachments, check them for viruses and other defects. 
            
            The information contained in this document is confidential to the addressee and is not the view nor the official policy of BCIC unless otherwise stated.
            
            </font> </P>
            
            </td>
            
            </tr>
            
            </table>
            
            </BODY></HTML>
            
            ";
            
            
            // Attachment files 
                $files = array( 
                   $filepath.'bcic_sop_manual.pdf', 
                   $filepath.'checklist_bcic.pdf' 
                ); 
            
            //$filename = 'invoice_Q'.$quote_id.'.pdf';
            //$fileatt = $_SERVER['DOCUMENT_ROOT']."/admin/invoice/".$filename;
            // $fileatt = $filepath;
            
           //  $message  = '';
             //$message.= $email_message; 
             
             
            
            $fileatt_type = "application/pdf";
            
            $email_from = $replyto;
            
            $email_to = $sendto_email; //$e;
            $headers = "From: <" . $email_from . "> \r\n";
            
            $headers .= "Reply-To: " . $email_from;
            
                       
                          // Boundary  
                $semi_rand = md5(time());  
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
             
                // Headers for attachment  
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";  
             
                // Multipart boundary  
                
                $email_message .= "This is a multi-part message in MIME format.\n\n" .
                
                "--{$mime_boundary}\n" .
                
                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
                
                "Content-Transfer-Encoding: 7bit\n\n" .
                
                $email_message .= "\n\n";
                
                // $email_message .= "--{$mime_boundary}\n" . "Content-Type: text/pdf; charset=\"UTF-8\"\n" . 
                // "Content-Transfer-Encoding: 7bit\n\n" . $email_message . "\n\n";  
             
              
                //echo $message; die; 
              
             
                // Preparing attachment 
                if(!empty($files)){
                    
                    for($i=0;$i<count($files);$i++){ 
                        if(is_file($files[$i])){ 
                            $file_name = basename($files[$i]); 
                            $file_size = filesize($files[$i]); 
                             
                            $email_message .= "--{$mime_boundary}\n"; 
                            $fp =    fopen($files[$i], "rb"); 
                            $data =  fread($fp, $file_size); 
                            fclose($fp); 
                            $data = chunk_split(base64_encode($data)); 
                            $email_message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .  
                            "Content-Description: ".$file_name."\n" . 
                            "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .  
                            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
                        } 
                    } 
                } 
                 
        $email_message .= "--{$mime_boundary}--"; 
            
        ini_set('sendmail_from', $replyto);
        mail($sendto_email, $sendto_subject, $email_message, $headers);
        
            //add_application_notes($appl_id, $heading, $comment);
            //mail("manish@bcic.com.au","CC:".$sendto_subject,$email_message,$headers);
    
    }
   
    function getCancelledJobs($from, $to, $type){
        
         if($type == 1) {
           $sql = mysql_query("SELECT count(id) as cancelledjobs  FROM `jobs` WHERE status = 2");
           
           $data = mysql_fetch_assoc($sql);
           
           return $data['cancelledjobs'];
         }else{
            // echo  "SELECT count(id) as cancelledjobs  FROM `jobs` WHERE status = 2 AND job_date >= '".$from."' AND job_date <= '".$to."'";
            $sql = mysql_query("SELECT count(id) as cancelledjobs_mo  FROM `jobs` WHERE status = 2 AND job_date >= '".$from."' AND job_date <= '".$to."'");
           
           $data1 = mysql_fetch_assoc($sql);
           return $data1['cancelledjobs_mo'];
         }
    }   
    
    
    function getBookedJobs($date, $todate, $loginid) {
        //quote_to_job_date BETWEEN '2021-03-07' AND  '2021-03-08'
          $arg = "SELECT id, booking_id, booking_date, date , call_check,  login_id , (SELECT status from jobs WHERE id = quote_new.booking_id) as boostatus  , 
       (SELECT name from admin WHERE id = quote_new.login_id) as loginname  
            FROM `quote_new` 
             WHERE quote_to_job_date  BETWEEN '".$date."'  AND '".$todate."' AND bbcapp_staff_id = 0 ";
             
        if($loginid > 0) {
            $arg .= " AND login_id = $loginid ";
        }     
        $arg .= ' Order by date asc ';
        
    //echo  $arg;     
        
        $sql = mysql_query($arg);
        
         $count = mysql_num_rows($sql); 
          $getsmsinfo = [];
           if($count > 0)  { 
            	    while($data1 = mysql_fetch_assoc($sql)) {
            	        
            	        $getJobsids[] = $data1;
            	        
            	    }
           }
           
           return $getJobsids;
        
    }
    
    function getCallDetails($quoteid ,  $calldate){
        
        $sql =  mysql_query("SELECT id, quote_id, job_id ,  admin_id ,  call_date , duration, (SELECT adminid from c3cx_users WHERE id =  c3cx_calls.admin_id) as adminid  FROM `c3cx_calls` WHERE quote_id in (SELECT id FROM `quote_new` WHERE id = '".$quoteid."') AND call_date <= '".$calldate."'");
         $count = mysql_num_rows($sql); 
         
          if($count > 0)  { 
            	    while($data1 = mysql_fetch_assoc($sql)) {
            	        
            	        $getJobsids[$data1['quote_id']][$data1['adminid']][] = $data1;
            	        
            	    }
           }
           
          return $getJobsids; 
        
    }
    
    
    function getCallInfo($date){
         $sql = mysql_query("SELECT id, quote_id, job_id ,  admin_id , duration, (SELECT adminid from c3cx_users WHERE id =  c3cx_calls.admin_id) as adminid  FROM `c3cx_calls` WHERE quote_id in (SELECT id FROM `quote_new` WHERE quote_to_job_date = '".$date."')");
         $count = mysql_num_rows($sql); 
          //$getsmsinfo = [];
           if($count > 0)  { 
            	    while($data1 = mysql_fetch_assoc($sql)) {
            	        
            	        $getJobsids[$data1['quote_id']][$data1['adminid']][] = $data1;
            	        
            	    }
           }
           
          return $getJobsids; 
         
    }
    
    
    function getDIspatchReport($job_type , $staffid, $sdate_staff)
    {
        
       //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
        
        // $staffid = 505;
        //select job_id,quote_id , job_date ,  reclean_job from job_details where status!=2 
        //and staff_id=505 and job_date BETWEEN '2021-03-05' AND  '2021-03-11'  and 
        //job_id in (select id from jobs where status in(1,3,4,5)) OR job_id in (select job_id from 
        //job_reclean where status!=2 and staff_id=15 and reclean_date BETWEEN  '2021-03-05' AND '2021-03-11') GROUP by job_id    
        
        $startdate = date("Y-m-d", $sdate_staff);
        $enddate =  date('Y-m-d', strtotime($startdate. ' + 6 days'));
       
      	$jd_arg = "select job_id,quote_id , job_date , (SELECT reclean_date from job_reclean WHERE  job_type_id = job_details.job_type_id and job_id = job_details.job_id AND status = 0 AND staff_id=".$staffid." ) as recleandate , reclean_job  from job_details where status!=2 ";
				
				if($job_type !="0" && $job_type != ''){
					
				     $jd_arg.= " and job_type='".$job_type."'"; 
					 
				}
				
				$jd_arg.= " and staff_id=".$staffid." and job_date BETWEEN '".$startdate."' AND '".$enddate."'";
				$jd_arg.= " and job_id in (select id from jobs where status in(1,3,4,5)) OR job_id in (select job_id from job_reclean where status!=2 and staff_id=".$staffid."";
				$jd_arg.= " and reclean_date BETWEEN '".$startdate."' AND '".$enddate."' )"; 
				
			 	$jd_arg.= "  GROUP by job_id";
			 	
			 	$sql = mysql_query($jd_arg);
			 	$count = mysql_num_rows($sql); 
			 	
			 /*	if($staffid == 224) {
	      	       echo $jd_arg.'<br/>';	
			 	}
			*/
				
				
				
				
			//	echo $count. ' === ' . $staffid.'<br/>';
			/*	if($staffid == 224) {
				    echo $count;
				}*/
				
				 if($count > 0)  { 
            	    while($data1 = mysql_fetch_assoc($sql)) {
            	        
            	        if($data1['recleandate'] != '') {
            	            $getJobsids[$staffid][$data1['recleandate']][] = $data1;
            	        }else{
            	             $getJobsids[$staffid][$data1['job_date']][] = $data1;
            	        }
            	        
            	    }
           }
           
           return $getJobsids;
        
    }
    
    function getApplicationMobile(){
        
        $sql = mysql_query("SELECT id, mobile FROM `staff_applications`  WHERE YEAR(date_started) = '2021' AND MONTH(date_started) = '01' AND mobile = '0410595336'");
        
        while($data = mysql_fetch_assoc($sql)) {
            
            if(strlen($data['mobile']) == 10 && $data['mobile'][0] == 0) {
                
                $mobile = $data['mobile'];
                $mobile =  '+61'.substr($mobile,1, strlen($mobile)) ;
                $getdata[$data['id']] =  $mobile;
                
            }
        }
        
        return $getdata;
        
    }
    
    
    function getinSMS($appid){
        
        
    //         [errorCode] => 0
    // [authToken] => aYQV5t-apDeuy0rm0_Q6rHg4ieVMkWIgSKyVaJ0-Z30qqzb3x-5WFUEpqYopfrcgUWFZGLj_rvA
    // [info] => 
    // [dateVerified] => 1592461356000
    // [countryCode] => AU
    // [dialPrefix] => 61
    // [currencyCode] => USD
        
         $address = get_rs_value("staff_applications", "mobile", $appid);
         
        if(strlen($address) == 10 && $address[0] == 0) {
	         
            $source = '61452229882'; //sender ( Bcic ) FROM Dedicated
          //  $address = '0481104175';
            $api_key = 'qDknmjs9qoFxydKzVBhEiQ'; // Aus
            $password = 'pcardin644';
            $mysms = new mysms($api_key);
            
            // print_r($mysms); die; 
            
           	//lets login user to get AuthToken
			$login_data = array('msisdn' => $source, 'password' => $password);
			
			$login = $mysms->ApiCall('json', '/user/login', $login_data);     //providing REST type(json/xml), resource from http://api.mysms.com/index.html and POST data
            
            $token = json_decode($login); 
           // print_r($token); die; 
            
            
               // $mobile = $data['mobile'];
                $mobile =  '+61'.substr($address,1, strlen($address)) ;
                //$getdata[$data['id']] =  $mobile;
            
            $gettoken = $token->authToken;
            
              $login_data = array(
                "apiKey"=> "{$api_key}",
                "authToken"=> "{$gettoken}",
                "address"=> $mobile
    	    );
    	    
    	     $restapi = '/rest/user/message/get/by/conversation';
            
            $result1 = $mysms->getMessagesBYOffset($restapi, $login_data);    
             
                $stringobject1 = simplexml_load_string($result1);
                
                $dataencode1 = json_encode($stringobject1);
                
                $dataencode_data = json_decode($dataencode1, true);
                
                $messagelist = $dataencode_data['messages'];
                
               // $last_names = array_column($a, 'last_name', 'id');
                
                foreach($messagelist as $key=>$smsvalue) {
                    
                    if($smsvalue['incoming'] == 'true') {
                        
                       //  print_r($smsvalue); 
                         $messageid[$smsvalue['messageId']] = array('date'=>$smsvalue['dateSent'] , 'message'=>$smsvalue['message']);
                    }
                    
                }
                
                $messageids = implode(',' , (array_keys($messageid))); 
                
                $getdata = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(messageid) as getmessageids FROM `application_notes` where  messageid > 0    AND application_id = ".$appid.""));
                
                 $getmessid = explode(',', $getdata['getmessageids']);
                
                //echo '<br/>'; 
                
                 $msgid = explode(',' , $messageids);
                
                $result = array_diff($msgid, $getmessid);
                
               // print_r($result);
               
                foreach($result as $key1=>$val) {  
                   
                             //print_r($messageid[$val]);
                            
                            $messagedata = $messageid[$val];
                             $dateSent = date('Y-m-d H:i:s' , strtotime($messagedata['date']));
                             $messges = $messagedata['message'];
                             $appid = $appid;
                             
                             $heading = 'Message  incoming from '.$mobile;
                             add_application_notes($appid, $heading,$messges ,$dateSent,'incoming','0', 0,$val);
                   
                   
                }
                
                
                    
        }
                
                
              //  echo '<pre>';  print_r($dataencode_data); die; 
        
    }
    
    
    function getleadsBooking( $fromdate, $todate){
        
          $job_details_arg =  "SELECT id, 
           
             CASE  
           WHEN booking_id > 0  THEN (SELECT payment_completed from job_details WHERE job_id = quote_new.booking_id AND status != 2 AND staff_id = quote_new.bbcapp_staff_id limit 1 ) end  as payment_completed , booking_id , 
          amount,  lead_status, lead_fee , lead_payment_status, bbcapp_staff_id ,   booking_id, booking_date, booking_lead_payment
         
                 FROM 
                        `quote_new`  
                WHERE bbcapp_staff_id > 0  and (date>='".$fromdate."' and date<='".$todate."')  and  step != 10 AND  (step != 7 AND denied_id != 3) ";
        
		 $query  = mysql_query($job_details_arg);
		 $count = mysql_num_rows($job_details_arg);
		 
			 while($data1 = mysql_fetch_assoc($query)) {
			     
    		     if($data1['booking_id'] > 0 ) {
    		         $getData[1][$data1['bbcapp_staff_id']][] = $data1;
    		         
    		        // if($data1['booking_lead_payment'] == 2) {
    		             if($data1['bbc_staff_paid_date'] != '0000:00:00') {
    		               $getData['paid'][$data1['bbcapp_staff_id']][] = $data1;
    		          } 
    		          
    		     }
    		     /*else if($data1['booking_id'] == 0){
    		          
    		          $getData[0][$data1['bbcapp_staff_id']][] = $data1;
    		         
    		          if($data1['lead_payment_status'] == 2) {
    		               $getData['unpaid'][$data1['bbcapp_staff_id']][] = $data1;
    		          } 
    		     }*/
    		     
    		         $getData[0][$data1['bbcapp_staff_id']][] = $data1;
    		         
    		          if($data1['lead_payment_status'] == 2) {
    		               $getData['unpaid'][$data1['bbcapp_staff_id']][] = $data1;
    		          } 
    		     
    		 }
		 
		  return $getData;
    }
    
    
       function no_magic_quotesinfo($clean_description) 
        {
          $vpb_data = explode("\\",$clean_description);
          $vpb_cleaned = implode("",$vpb_data);
          return $vpb_cleaned;
        }
    
            function add_n_smilies_info($vasplus_programming_blog_post_text) {
                  $vasplus_programming_blog_codesToConvert = array(
                    ':)'    =>  '<img src="chat/smileys/smilea.png" title="Smile" align="absmiddle">',
                    ':-)'   =>  '<img src="chat/smileys/smileb.png" title="Smile" align="absmiddle">',
                    ':D'    =>  '<img src="chat/smileys/laughc.png" title="Laugh" align="absmiddle">',
                    ':-D'    =>  '<img src="chat/smileys/laughc.png" title="Laugh" align="absmiddle">',
                    ':d'    =>  '<img src="chat/smileys/laughd.png" title="Laugh" align="absmiddle">',
                    ';)'    =>  '<img src="chat/smileys/winke.png" title="Wink" align="absmiddle">',
                    ';-)'    =>  '<img src="chat/smileys/winke.png" title="Wink" align="absmiddle">',
                    ':P'    =>  '<img src="chat/smileys/toungef.png" title="Tongue" align="absmiddle">',
                    ':-P'   =>  '<img src="chat/smileys/toungeg.png" title="Tongue" align="absmiddle">',
                    ':-p'   =>  '<img src="chat/smileys/toungeh.png" title="Tongue" align="absmiddle">',
                    ':p'    =>  '<img src="chat/smileys/toungei.png" title="Tongue" align="absmiddle">',
                    ':('    =>  '<img src="chat/smileys/sadj.png" title="Sad" align="absmiddle">',
                    ':-('    =>  '<img src="chat/smileys/sadj.png" title="Sad" align="absmiddle">',
                    ':o'    =>  '<img src="chat/smileys/shockk.png" title="Shock" align="absmiddle">',
                    ':-o'    =>  '<img src="chat/smileys/shockk.png" title="Shock" align="absmiddle">',
                    ':O'    =>  '<img src="chat/smileys/shockL.png" title="Shock" align="absmiddle">',
                    ':-0'    =>  '<img src="chat/smileys/shockm.png" title="Shock" align="absmiddle">',
                    ':|'    =>  '<img src="chat/smileys/straightn.png" title="Straight" align="absmiddle">',
                    'lol'    =>  '<img src="chat/smileys/smilea.png" title="Smile" align="absmiddle">',
                    ':-*'    =>  '<img src="chat/smileys/kiss.png" title="Kiss" align="absmiddle">',
                    ':*'    =>  '<img src="chat/smileys/kiss.png" title="Kiss" align="absmiddle">',
                    ":'("    =>  '<img src="chat/smileys/cry.png" title="Cry" align="absmiddle">',
                    '<3'    =>  '<img src="chat/smileys/heart.png" title="Heart" align="absmiddle">',
                    '^_^'    =>  '<img src="chat/smileys/kiki.png" title="Kiki" align="absmiddle">',
                    '<(")'    =>  '<img src="chat/smileys/penguin.gif" title="Penguin" align="absmiddle">',
                    'O:)'    =>  '<img src="chat/smileys/angel.png" title="Angel" align="absmiddle">',
                    'O:-)'    =>  '<img src="chat/smileys/angel.png" title="Angel" align="absmiddle">',
                    '(^^^)'    =>  '<img src="chat/smileys/shark.gif" title="Shark" align="absmiddle">',
                    '3:)'    =>  '<img src="chat/smileys/devil.png" title="Devil" align="absmiddle">',
                    '3:-)'    =>  '<img src="chat/smileys/devil.png" title="Devil" align="absmiddle">',
                    ':42:'    =>  '<img src="chat/smileys/42.gif" title="42" align="absmiddle">',
                    ':putnam:'    =>  '<img src="chat/smileys/putnam.gif" title="Chris Putnam (Face)" align="absmiddle">',
                    ':v'    =>  '<img src="chat/smileys/pacman.png" title="Pacman" align="absmiddle">',
                    'o.O'    =>  '<img src="chat/smileys/confused.png" title="Confused" align="absmiddle">',
                    'O.o'    =>  '<img src="chat/smileys/confused.png" title="Confused" align="absmiddle">',
                    ':['    =>  '<img src="chat/smileys/frown.png" title="Frown" align="absmiddle">',
                    '=('    =>  '<img src="chat/smileys/frown.png" title="Frown" align="absmiddle">',
                    '>:O' =>  '<img src="chat/smileys/upset.png" title="Upset" align="absmiddle">',
                    '>:-O' =>  '<img src="chat/smileys/upset.png" title="Upset" align="absmiddle">',
                    '>:o' =>  '<img src="chat/smileys/upset.png" title="Upset" align="absmiddle">',
                    '>:-o' =>  '<img src="chat/smileys/upset.png" title="Upset" align="absmiddle">',
                    ':3'    =>  '<img src="chat/smileys/curlylips.png" title="Curlylips" align="absmiddle">',
                    '^_^'    =>  '<img src="chat/smileys/happy.gif" title="Happy" align="absmiddle">',
                    '8-|'    =>  '<img src="chat/smileys/cool.gif" title="Cool" align="absmiddle">',
                    '8-|' =>  '<img src="chat/smileys/sunglasses.png" title="Sunglasses" align="absmiddle">',
                    '8|' =>  '<img src="chat/smileys/sunglasses.png" title="Sunglasses" align="absmiddle">',
                    'B-|' =>  '<img src="chat/smileys/sunglasses.png" title="Sunglasses" align="absmiddle">',
                    'B|' =>  '<img src="chat/smileys/sunglasses.png" title="Sunglasses" align="absmiddle">',
                    '>:(' =>  '<img src="chat/smileys/grumpy.png" title="Grumpy" align="absmiddle">',
                    '>:-(' =>  '<img src="chat/smileys/grumpy.png" title="Grumpy" align="absmiddle">',
                    //':/' =>  '<img src="chat/smileys/unsure.png" title="Unsure" align="absmiddle">',
                    ':-/' =>  '<img src="chat/smileys/unsure.png" title="Unsure" align="absmiddle">',
                    '=D' =>  '<img src="chat/smileys/grin.gif" title="Grin" align="absmiddle">',
                    ']' =>  '<img src="chat/smileys/robot.gif" title="Robot" align="absmiddle">',
                    ':-|'   =>  '<img src="chat/smileys/straighto.png" title="Straight" align="absmiddle">'
                    
                     );
                  return (strtr($vasplus_programming_blog_post_text, $vasplus_programming_blog_codesToConvert));
        }
 	
 ?>
