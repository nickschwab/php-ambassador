<?php 

/**
 * Ambassador v2 API PHP Wrapper
 *
 * @version 		0.1
 * @author_name		Nick Schwab
 * @author_email	me@nickschwab.com
 * @author_url		http://nickschwab.com
 * @date			June 26, 2012
 * 
 * Example use:
 
		include_once(APPPATH.'libraries/ambassador.php');
		$ambassador = new Ambassador("USERNAME","API_KEY");
		$params = array('email' => 'testing@getambassador.com');
		$result = $ambassador->call("ambassador/get",$params);
		print_r($result);
		
 */

class Ambassador {
	
	protected $api_root 		= "https://getambassador.com/api/v2/";
	protected $api_username 	= "none";
	protected $api_key 			= "none";
	public $http_code			= 500;
	public $result_raw			= NULL;
	public $result_array		= array();
	
	function __construct($username = NULL, $key = NULL){
		if(!empty($username) && !empty($key))
			$this->set_auth($username, $key);
	}
	
	function set_auth($username = NULL, $key = NULL){
		if(!empty($username))
			$this->api_username = $username;
		
		if(!empty($key))
			$this->api_key = $key;
	}

	function call($call_path = "", $param_array = array()){
		$full_path = $this->api_root.$this->api_username."/".$this->api_key."/json/".$call_path;
		$raw = $this->curl_request($full_path, $param_array);
		
		if(!empty($raw)){
			$this->result_array = json_decode($this->result_raw, TRUE);
		}else{
			$this->result_array = array();
		}
		
		return $this->result_array;
	}
	
	function curl_request($url, $params = array()){
		$curl = curl_init();
	
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_FAILONERROR, FALSE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		if(!empty($params)){
			$params = http_build_query($params);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		}else{
			curl_setopt($curl, CURLOPT_POST, FALSE);
		}
		
		$this->result_raw 		= curl_exec($curl);
		$this->http_code 		= curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		curl_close($curl);
		
		return $this->result_raw;
	}
	
}   