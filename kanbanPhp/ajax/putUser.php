<?php
	if (isset($_POST["Username"]) && !empty($_POST["Username"])
		&& isset($_POST["Email"]) && !empty($_POST["Email"])
		&& isset($_POST["Password"]) && !empty($_POST["Password"])) {
		// modif
		if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
			$data = array("ID" => $_POST["ID"],
						"Username" => $_POST["Username"], 
						"Email" => $_POST["Email"], 
						"Password" => $_POST["Password"], 
						"Admin" => $_POST["Admin"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceUser.svc/users/update');                                                                      
		} else {
		// ajout
			$data = array("Username" => $_POST["Username"], 
						"Email" => $_POST["Email"], 
						"Password" => $_POST["Password"], 
						"Admin" => $_POST["Admin"]);
			$ch = curl_init('http://10.11.145.91:1342/ServiceUser.svc/users/create');                                                                      
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