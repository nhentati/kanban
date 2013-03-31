<?php
	if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
		$data = array('ID'=>$_POST["ID"]);
		$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/delete');
		
		$data_string = json_encode($data);                                                                                   
 
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
													'Content-Length: ' . strlen($data_string)));                                                                     
		curl_exec($ch);
	}
?>