ambassador
==========

getambassador.com API wrapper

Example usage:

include_once(APPPATH.'libraries/ambassador.php');
$ambassador = new Ambassador("USERNAME","API_KEY");
$params = array('email' => 'testing@getambassador.com');
$result = $ambassador->call("ambassador/get",$params);
print_r($result);