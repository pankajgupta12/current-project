<?php

/*!
* Idragons Interactive
* http://idragonsinteractive.com | http://github.com/idragons/mysms-api-php-wrapper
*/

class mysms {
	
	private $ApiKey = false;
	
	private $AuthToken = false;
	
	private $BaseUrl = 'https://api.mysms.com/';
	
	function __construct($apikey, $authtoken = false) {
		
		$this->ApiKey = $apikey;
		$this->AuthToken = $authtoken;
		
	}
	
	
	public function setAuthToken($authtoken)
	{
		  $this->AuthToken = $authtoken;
	}
	
	
	public function ApiCall($rest, $resource, $data)
	{
		  if($rest == '' && $rest != 'json' && $rest != 'xml') die('Please provide valid REST type: xml/json!'); //check if $rest is xml or json
		  
		  elseif(filter_var($this->BaseUrl.$rest.$resource, FILTER_VALIDATE_URL) == false) die('Provided Resource or MountUrl is not Valid!'); //check if https://api.mysms.com/$rest/$resource is valid url
		  
		  elseif(!is_array($data)) die('Provide data is not an Array!'); //check if provided $data is valid array
		  
		  else{
				  
				  //insert api key into $data
				  $data['apiKey'] = $this->ApiKey;
				  $result = $this->curlRequest($rest.$resource, $data);
				  
				  return $result;
		  }
		  
	}
	
	
	public function getMessagesBYOffset($resource, $data) {
        $result = $this->curlRequestNext($resource, $data);
        return $this->removeUnwantedString($result);
	}
	
	
	public function removeUnwantedString($str){
		
		 $afterCorrection = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
		 '|[\x00-\x7F][\x80-\xBF]+'.
		 '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
		 '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
		 '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
		 '', $str );	
         return $afterCorrection;	
	}
	
	private function curlRequest($resource, $data)
	{
		 $json_encoded_data = json_encode($data);
		 
		 
		  $curl = curl_init();
		  curl_setopt ($curl, CURLOPT_URL, $this->BaseUrl.$resource);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $json_encoded_data);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json;charset=utf-8',                                                                           
			'Content-Length: ' . strlen($json_encoded_data))                                                                       
			);   
			 
		  return curl_exec ($curl);
		  
	}
	
	private function curlRequestNext($resource, $data)
	{
		 $json_encoded_data = json_encode($data);
		  $curl = curl_init();
		  curl_setopt ($curl, CURLOPT_URL, $this->BaseUrl.$resource);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $json_encoded_data);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json;charset=utf-8',                                                                           
			'Content-Length: ' . strlen($json_encoded_data))                                                                       
			);   
		  $curlResponse = curl_exec ($curl);
		  return $curlResponse;
	 	  /* file_put_contents('recent_sms_data.xml', $curlResponse);
		  $afterCorrection = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
		 '|[\x00-\x7F][\x80-\xBF]+'.
		 '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
		 '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
		 '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
		 '', file_get_contents('recent_sms_data.xml') );		  
		  file_put_contents('recent_sms_data_after_correction.xml', $afterCorrection);
		  return 'recent_sms_data_after_correction.xml'; */
	}
	
	
}

?>