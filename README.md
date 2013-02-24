ambassador
==========

PHP wrapper for v2 of the [Ambassador](https://getambassador.com/) API.
Ambassador is maintaining an official fork of my wrapper [here](https://github.com/GetAmbassador/ambassador).

Example usage:

include_once(APPPATH.'libraries/ambassador.php');
$ambassador = new Ambassador("USERNAME","API_KEY");
$params = array('email' => 'testing@getambassador.com');
$result = $ambassador->call("ambassador/get",$params);
print_r($result);