<?php
	if (isset($_POST["Label"]) && !empty($_POST["Label"])) {
		// modif
		if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
			$data = array(	'ID'=>$_POST["ID"],
							'Label'=>$_POST["Label"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceState.svc/states/update');                                                                      
		} else {
		// ajout
			$data = array('Label'=>$_POST["Label"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceState.svc/states/create');                                                                      
		}
		
		$data_string = json_encode($data);                                                                                   
 
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
													'Content-Length: ' . strlen($data_string)));                                                                                                                   
		curl_exec($ch);
	}
?>