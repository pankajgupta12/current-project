
<hr>
<?php 
//$_SESSION['wall_board']['calldate'] = date('Y-m-d');
 
if(!isset($_SESSION['wall_board']['calldate'])){ $_SESSION['wall_board']['calldate'] = date('Y-m-d'); }

// $_SESSION['wall_board']['calldate'];

$calldate =  $_SESSION['wall_board']['calldate'];
?>
        <div>
           <span  style="float:left;width: 100%;margin-top: -22px;">
                     <ul class="dispatch_top_ul dispatch_top_ul2" style="margin-top: 32px">
					  <li>
						<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer;">
						  <input class="date_class" autocomplete="off" type="text" name="calldate" id="calldate" value="<?php echo $calldate; ?>">
						</div>
					  </li>	

					  <li>
						<div id="reportrange"  style="background: #fff; cursor: pointer;">
						 <input type="button" style="cursor:  pointer;" name="" value="Search" class="offsetZero btnSent a_search_box" onclick="changfeWallBoardDate();">
						</div>
					 </li>	
				    </ul>
            </span>
        </div>
        
<script>
  
   function changfeWallBoardDate(){
       var calldate = $('#calldate').val();
       send_data(calldate, 622, 'daily_view');
   }
  
 function closedpopup(){
      $('#popup1').hide();
 }

   /* function showrolelist(adminid ,adminname, role) {
          var page = 'log';
          var params = 'adminid='+adminid+'&adminname='+adminname+'&page='+page
      
    }*/


   function showpopupDetails(admin3cxid ,adminname, role ,type, loggadminid) {
       
        /*$('#heading_show').text('');
        $('#popup1').hide();
        $('.content').html('');*/
        var calldate = $('#datepicker').val();
        //console.log(admin3cxid ,adminname, role ,type, loggadminid, calldate);
        //var head = 'Call Details ( ' + calldate +' ) of ' +adminname+' ('+role +')';
        showCallList(admin3cxid ,adminname, role ,type, loggadminid, calldate);
           
   }
   
       function getTypeData(){
            var favorite = [];
            $.each($("input[name='chekilistvalue']:checked"), function(){
                favorite.push($(this).val());
            });
           //alert("My favourite sports are: " + favorite.join(", "));
           
           return favorite.join(", ");
        }

 
   function showCallList(admin3cxid ,adminname, role ,type, loggadminid, calldate) {
           
            $('#loaderimage_1').show();
            $('.full_loader').attr('id','bodydisabled_1'); 
           
             checkListType =  getTypeData();
             
             if(checkListType != '') {
                 checkListType = checkListType;
             }else{
                 checkListType = ' 1,2,3,4,5,6,7 ';
             }
           
             if(type == 1) {
                  var page = 'call';
                  var head = 'Call Details ( ' + calldate +' ) of ' +adminname+' ('+role +')';
             }else{
                  var page = 'logg';
                   var head = 'Role Details  ( ' + calldate +' )  Info of ' +adminname;
             }
                 
                        $('#loaderimage_1_check').show();
                        $('.full_loader_1').attr('id','bodydisabled_1');
                 
                var params = 'adminid='+admin3cxid+'&adminname='+adminname+'&page='+page+'&loggadminid='+loggadminid+'&calldate='+calldate+'&role='+role+'&checkListType='+checkListType;
                
                     $.ajax({ //Process the form using $.ajax()
                            type      : 'POST', //Method type
                             url       : 'source/showcalllist.php', //Your form processing file URL
                            data      : params, //Forms name
                            dataType  : 'html',
                        success   : function(data) 
                          {
                              $('#loaderimage_1').hide();
		                      $('.full_loader').attr('id','');
		  
                              $('#heading_show').text(head);
                              $('#popup1').show();
                              $('.content').html(data);
                             // $('#calldate').val(calldate);
                                $(function(){
                                   $("#datepicker").datepicker({
                                    dateFormat: "yy-mm-dd",
                                     maxDate: "0"
                                    //minDate: "0"
                                   });
                                   
                                });
                                   
                          }
                    });
    }
</script>
<style>

.checklist_data {
   list-style-type: none;
   
}

.checklist_data li {
    float: left;
    text-align: center;
    padding: 0px 6px;
    text-decoration: none;
    font-size: 20px;
    margin: 7px;
}


table, th, td {
      border: double;
    text-align: center;
} 

.overlay {
    position: fixed;
    top: 51px;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    visibility: hidden;
    opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}

.popup {
    margin: 76px auto;
    padding: 23px;
    background: #fff;
    border-radius: 5px;
    width: 80%;
    position: relative;
    transition: all 5s ease-in-out;
    height: 800px;
    overflow: auto;
}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;
}
.popup .close:hover {
  color: #06D85F;
}
.popup .content {
 
  overflow: auto;
}

</style>
<br/>
<br/>
<div id="daily_view">
<?php   include('xjax/view_wall_board.php');  ?>
</div>
  
  
		