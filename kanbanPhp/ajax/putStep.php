<?php
	if (isset($_POST["Name"]) && !empty($_POST["Name"])
		&& isset($_POST["Order"]) && !empty($_POST["Order"])
		&& isset($_POST["ProjectID"]) && !empty($_POST["ProjectID"])) {
		
		// modif
		if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
			$data = array("ID" => $_POST["ID"],
						"Name" => $_POST["Name"], 
						"Order" => $_POST["Order"],
						"ProjectID" => $_POST["ProjectID"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceStep.svc/steps/update');                                                                      
		} else {
		// ajout
			$data = array("Name" => $_POST["Name"], 
						"Order" => $_POST["Order"],
						"ProjectID" => $_POST["ProjectID"]);	
			$ch = curl_init('http://10.11.145.91:1342/ServiceStep.svc/steps/create');                                                                      
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