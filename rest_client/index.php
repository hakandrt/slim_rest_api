<?php 


class RequestClient
{
	private $server_url;

	function __construct($server_url){

		$this->server_url=$server_url;

	}

	// GET İŞLEMİ İLE TEK VERİ ÇEKME
	function single_request($id){

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $this->server_url.'rest_server/api/user/'.$id,
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);

		return json_decode($response);

	}

	// GET İŞLEMİ İLE TÜM VERİLERİ ÇEKME
	function multi_request(){

		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $this->server_url.'rest_server/api/users/',
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$response = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);

		return json_decode($response);

	}

	// POST İŞLEMİ İLE VERİ EKLEME
	function insert_request($name,$surname,$phone){

	   $service_url = $this->server_url.'rest_server/api/user/add';
	   $curl = curl_init($service_url);
	   $curl_post_data = array(
	        "name" 		=> $name,
	        "surname" 	=> $surname,
	        "phone" 	=> $phone,
	        );
	   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($curl, CURLOPT_POST, true);
	   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
	   $response = curl_exec($curl);
	   curl_close($curl);

	   return json_decode($response);

	}

	// PUT İŞLEMİ İLE VERİ GÜNCELLEME
	function update_request($id,$name,$surname,$phone){

		$data = array
		(
		  'name' 		=> $name,
		  'surname' 	=> $surname,
		  'phone' 		=> $phone,
	  	);

		$curl = curl_init($this->server_url."rest_server/api/user/update/$id");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));

		$response = curl_exec($curl);
		return $response;

	}

	// DELETE İŞLEMİ İLE VERİ SİLME
	function delete_request($id){

		$curl = curl_init($this->server_url."rest_server/api/user/delete/$id");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($curl);
		return $response;

	}

} 

?>