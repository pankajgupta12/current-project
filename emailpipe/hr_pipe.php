#!/usr/local/bin/php -q
<?php  
    /*********************************************************************
        HR_PIPE.PHP
    
        READING INCOMING EMAIL THROUGH PIPE AND STORE IT INTO DB!
    
        AUSTRALIA OFFICE <ASHISH@BUSINESS2SELL.COM.AU>
        Copyright (c)  2018 BCIC PTY LTD
        HTTPS://WWW.BCIC.COM.AU
    
        RELEASED UNDER THE GPU GENERAL PUBLIC LICENCE WITHOUT ANY  WARRANTY
    
    **********************************************************************/
    error_reporting(0);
    System("wget -O /dev/null https://www.bcic.com.au/admin/hr_mail_pipe.php > /dev/null 2>&1");
?>