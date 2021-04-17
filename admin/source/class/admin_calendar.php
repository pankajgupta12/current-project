<?php
/**
*@author  Xu Ding
*@email   thedilab@gmail.com
*@website http://www.StarTutorial.com
**/
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        //$this->naviHref = htmlentities($_SERVER['PHP_SELF']);
        $this->naviHref = 'admin_popup.php';
		date_default_timezone_set('Australia/Melbourne');
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  == null;
         
        $month == null;
        $checked == 1;
         
        if(null==$year && isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth = $this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content"><img src="source/popup/loading1.gif" id="calender-loading">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
								$outerFlag = false;
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j , $checked);
                                    }
									
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber , $checked = null){
        // $checked = '';
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){                 
                $this->currentDay=1;                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            
			 //echo $this->currentDate."<br>";
			 //$status = get_sql("admin_roster","status","where date='".$this->currentDate."' and admin_id=".$_REQUEST['id']."");
			/*  echo "SELECT (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau,  (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau FROM `admin_roster` as A  where date = '".$this->currentDate."' AND admin_id=".$_REQUEST['id'].""; */
			
			
			
			$sqlq = mysql_query("SELECT (SELECT start_time_au FROM `admin_time_shift` WHERE id = A.start_time_au ) as startau,  (SELECT end_time_au FROM `admin_time_shift` WHERE id = A.end_time_au ) as endau, status , id FROM `admin_roster` as A  where date = '".$this->currentDate."' AND admin_id=".$_REQUEST['id']."");
			$getdata = mysql_fetch_assoc($sqlq);
			//print_r($getdata);
			//echo $status."<br>";
			//echo $this->currentDay;
            $cellContent = "<span class='calenderdate'>".$this->currentDay."</span>";
			$staffID = $_REQUEST['id'];
			
			//$status1 = explode( "," , get_sql("staff_roster","status","where staff_id=".$_REQUEST['id'].""));
		    //echo ($cellNumber)."<br>";
			//day checked
			//$checked = getcheckbocUnderArray( date( "D" , strtotime($this->currentDate)) , $status );
			
			// if($status == '1') { $checked = "checked"; }else  {$checked = '';}
			
			//$cellContent.='<input type="checkbox" onChange="dateAdminMarked(\''.$staffID.'\',\''.$this->currentDate.'\',\''.$status.'\');" value="Available" '.$checked.'  class="marckedbox" title="'.$this->currentDate.'">';	
			
			if(!empty($getdata)) {
				if($getdata['startau'] != '') {
				  $checked = "checked";
				}
				$cellContent.='<span style="float: right;margin-top: 39px;margin-right: 14px;"><p style="font-size: 12px;white-space: nowrap;">'.$getdata['startau'].'</p>';					
				$cellContent.='<p style="font-size: 12px;white-space: nowrap;">'.$getdata['endau'].'</p></span>';	
			}	
			
			$cellContent.='<input type="checkbox"  onChange="dateAdminMarked(\''.$staffID.'\',\''.$this->currentDate.'\',\''.$getdata['status'].'\');" style="margin-top: -27px;margin-right: 30px;" value="Available" '.$checked.'  class="marckedbox" title="'.$this->currentDate.'">';					
					
			//$cellContent.= $status;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
         
		   /* if( $checked != '' )		
				{
					$classInput = " style=background-color:#d6e9c6; ";
				}
				else
				{
					$classInput = " style=background-color:#faebcc; ";
				} */
		 
		  if($this->currentDate != ''){
			
				if( $checked != '' )		
					{
						$classInput = " style=background-color:#d6e9c6; ";
					}
					else
					{
						$classInput = " style=background-color:#ebccd1; ";
					}
				
		 }else{
				
				 $classInput = " style=background-color:#faebcc; ";
		    } 
         
        $str='<li id="li-'.$this->currentDate . '" '. $classInput . ' class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
		
		return $str;
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
		
		$staffID = $_REQUEST['id'];
         
        return
             '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?task=admin_roster&id='.$_REQUEST['id'].'&month='.sprintf('%02d',$preMonth).'&year='.$preYear.'"   >Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
					
                '<a class="next"  onClick="DateMarckedAdminFornextMonth(\''.$staffID.'\',\''.sprintf("%02d", $nextMonth).'\',\''.$nextYear.'\');" >Next</a>'.
            '</div>'; 
			
			 /* '<div class="header">'.
                '<a class="prev" href="javascript:void(0);"   >Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
					
                '<a class="next" href="javascript:void(0);" >Next</a>'.
            '</div>'; */
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}

?>