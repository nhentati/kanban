<?php
	if (isset($_POST["Name"]) && !empty($_POST["Name"])
		&& isset($_POST["OwnerID"]) && !empty($_POST["OwnerID"])) {
		// modif
		if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
			$data = array("ID" => $_POST["ID"],
						"Name" => $_POST["Name"], 
						"OwnerID" => $_POST["OwnerID"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceProject.svc/projects/update');                                                                      
		} else {
		// ajout
			$data = array("Name" => $_POST["Name"], 
						"OwnerID" => $_POST["OwnerID"]);	
			$ch = curl_init('http://10.11.145.91:1342/ServiceProject.svc/projects/create');                                                                      
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