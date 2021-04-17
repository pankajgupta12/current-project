<?php
class Autoloader 
{
    static public function loaderMail($className)
	{	
	  //echo $className; die;
		$classBaseName = basename($className);
		//echo $classBaseName; die; Bcic\Outlook\Email\Sys\EmailReader
		class_alias($classBaseName , 'Bcic/Outlook/Email/Sys/'.$classBaseName.'.php');
           $filename = "classes/mails/" . str_replace("\\", '/', $className) . ".php"; 
		  // echo $filename; die;
		  //echo $filename; die;
		  
		  $file = $_SERVER['DOCUMENT_ROOT'].'/mail/classes/mails/EmailReader.php';
		  ///public_html/mail/classes/mails
        if (file_exists($file)) {
			
            include($file);
            if (class_exists($className)) {
                return TRUE;
            }
        }		
    return FALSE;
    }
}
spl_autoload_register('Autoloader::loaderMail');

