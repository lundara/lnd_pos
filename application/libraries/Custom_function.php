<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_function{
	
	protected $_ci;

	private $crm_url = 'http://localhost/dev/vtiger/webservice.php';
	private $crm_username = 'admin';
	private $crm_password = 'admin';
	private $crm_user_access_key = 'S0XaW4zgI8ADJH';

	private $edonasi_url = 'http://localhost/dev/edonasi/example/';
	private $edonasi_username = 'admin';
	private $edonasi_password = 'admin';
	private $edonasi_user_access_key = 'S0XaW4zgI8ADJH';

	function __construct()
	{
		$this->_ci =& get_instance();
	}

	function call_crm($url, $params, $type = "GET")
	{
		$is_post = 0;
		if ($type == "POST") {
			$is_post = 1;
			$post_data = $params;
		} else {
			$url = $url . "?" . http_build_query($params);
		}
		$ch = curl_init($url);
		if (!$ch) {
			die("Cannot allocate a new PHP-CURL handle");
		}
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

		$return = null;
		if (curl_error($ch)) {
			$return = false;
		} else {
			$return = json_decode($data, true);
		}

		curl_close($ch);

		return $return;
	}

	function call_edonasi($url, $params, $type = "GET")
	{
		$is_post = 0;
		if ($type == "POST") {
			$is_post = 1;
			$post_data = $params;
		} else {
			$url = $url . "?" . http_build_query($params);
		}
		$ch = curl_init($url);
		if (!$ch) {
			die("Cannot allocate a new PHP-CURL handle");
		}
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

		$return = null;
		if (curl_error($ch)) {
			$return = false;
		} else {
			$return = json_decode($data, true);
		}

		curl_close($ch);

		return $return;
	}

	function add_contact_crm($params)
	{
		$endpointUrl = $this->crm_url;
		$userName = $this->crm_username;
		$password = $this->crm_password;
		$userAccessKey = $this->crm_user_access_key;

		$sessionData = $this->call_crm($endpointUrl, array("operation" => "getchallenge", "username" => $userName));
		$challengeToken = $sessionData['result']['token'];
		$generatedKey = md5($challengeToken . $userAccessKey);
		$dataDetails = $this->call_crm($endpointUrl, array("operation" => "login", "username" => $userName, "accessKey" => $generatedKey), "POST");

		$sessionid = $dataDetails['result']['sessionName'];

		if(!isset($params["assigned_user_id"]))$params["assigned_user_id"]=$userName;
		$data=json_encode($params);
		$add_contact = $this->call_crm($endpointUrl, array("operation" => "create", "sessionName" => $sessionid,"element"=>$data ,'elementType' => 'Contacts'),"POST");
		if (!empty($add_contact['result'])) {
		    return "1";
		} else {
		    return "0";
		}
	}

	function edonasi_service($api="",$data="")
	{
		$parameter=array("api" => $api);
		$parameter=array_merge($parameter,$data);
		$add_donatur = $this->call_edonasi($this->edonasi_url,$parameter,"POST");
		if (!empty($add_donatur['result'])) {
		    return $add_donatur;
		} else {
		    return $add_donatur;
		}
	}
}
