<?php
	
	//print_r($_POST);
	
	$assignee = array ('ID'=>'11',
						'Username'=>'testeur', 
						'Email'=>'testeur@gmail.com', 
						'Password'=>'testeur', 
						'Admin'=>'true');
						
	$category = array ('ID'=>'2', 'Name'=>'category1');
	$state = array ('ID'=>'2', 'Label'=>'state1');
	
	$data = array('Name' => 'tache 2',
				'Assignee' => $assignee,
				'Author' => $assignee,
				'Content' => 'content tache 2',
				'Completion' => '25',
				'Estimated_time' => '1',
				'Priority' => '2',
				'Spend_time' => '0',
				'StepID' => '3',
				'Category' => $category,
				'State' => $state
			);
			
	echo "<pre>";print_r($data);echo "</pre>";
	$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/create');                                                                      
	
	$data_string = json_encode($data);                                                                                   
 echo "<pre>";print_r($data_string);echo "</pre>";
		/*
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
												'Content-Length: ' . strlen($data_string)));                                                                                                                   
	$retour = curl_exec($ch);
	print_r($retour);
	
	/*if (isset($_POST["Name"]) && !empty($_POST["Name"])
		&& isset($_POST["Order"]) && !empty($_POST["Order"])
		&& isset($_POST["ProjectID"]) && !empty($_POST["ProjectID"])) {
		
		// modif
		if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
		
			$data = array("ID" => $_POST["ID"],
						"Name" => $_POST["Name"],
						"Assignee"=> $_POST["Assignee"],
						"Author"=> $_POST["Author"],
						"Content" => $_POST["Content"],
						"Completed_at" => $_POST["Completed_at"],
						"Completion" => $_POST["Completion"],
						"Created_at" => $_POST["Created_at"],
						"Estimated_time" => $_POST["Estimated_time"],
						"Priority" => $_POST["Priority"],
						"Spend_time" => $_POST["Spend_time"],
						"StepID" => $_POST["StepID"],
						"Updated_at" => $_POST["Updated_at"],
						"Category" => $_POST["Category"],
						"State" => $_POST["State"]);
						
			$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/update');                                                                      
		} else {
		// ajout
			$data = array("Name" => $_POST["Name"],
						"Assignee"=> $_POST["Assignee"],
						"Author"=> $_POST["Author"],
						"Content" => $_POST["Content"],
						"Completed_at" => $_POST["Completed_at"],
						"Completion" => $_POST["Completion"],
						"Created_at" => $_POST["Created_at"],
						"Estimated_time" => $_POST["Estimated_time"],
						"Priority" => $_POST["Priority"],
						"Spend_time" => $_POST["Spend_time"],
						"StepID" => $_POST["StepID"],
						"Updated_at" => $_POST["Updated_at"],
						"Category" => $_POST["Category"],
						"State" => $_POST["State"]);	
						
			$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/create');                                                                      
		}
		
		$data_string = json_encode($data);                                                                                   
 
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
													'Content-Length: ' . strlen($data_string)));                                                                                                                   
		curl_exec($ch);
	//}*/
?>