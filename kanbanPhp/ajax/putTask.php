<?php
	
	function getData($url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function getDetailsUser($idUser) {
		$json = getData('http://10.11.145.91:1342/ServiceUser.svc/users/'.$idUser);
		$obj =json_decode($json);
		$user = (array) $obj->{'Data'}[0];
		if ($user['Admin'] == 1) {
			$user['Admin'] = 'true';
		} else {
			$user['Admin'] = 'false';
		}
		return $user;
	}
	
	function getDetailsCategory($idCategory) {
		$json = getData('http://10.11.145.91:1342/ServiceCategory.svc/categories/'.$idCategory);
		$obj =json_decode($json);
		$category = (array) $obj->{'Data'}[0];
		return $category;
	}
	
	function getDetailsState($idState) {
		$json = getData('http://10.11.145.91:1342/ServiceState.svc/states/'.$idState);
		$obj =json_decode($json);
		$state = (array) $obj->{'Data'}[0];
		return $state;
	}
	
	$author = getDetailsUser($_POST["Author"]);
	
	$assignee = getDetailsUser($_POST["Assignee"]);
	
	$category = getDetailsCategory($_POST["Assignee"]);
	
	// $state = getDetailsState($_POST["Assignee"]);
	$state = getDetailsState(2);
	
	// modif
	if (isset($_POST["ID"]) && !empty($_POST["ID"])) {
		$data = array(	"ID" => $_POST["ID"],
						"Name" => $_POST["Name"],
						"Assignee"=> $assignee,
						"Author"=> $author,
						"Content" => $_POST["Content"],
						"Completion" => $_POST["Completion"],
						"Estimated_time" => $_POST["Estimated_time"],
						"Priority" => $_POST["Priority"],
						"Spend_time" => $_POST["Spend_time"],
						"StepID" => $_POST["StepID"],
						"Category" => $category,
						"State" => $state);
						
		$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/update');
		
	} else {
		// ajout
		$data = array(	"Name" => $_POST["Name"],
						"Assignee"=> $assignee,
						"Author"=> $author,
						"Content" => $_POST["Content"],
						"Completion" => $_POST["Completion"],
						"Estimated_time" => $_POST["Estimated_time"],
						"Priority" => $_POST["Priority"],
						"Spend_time" => $_POST["Spend_time"],
						"StepID" => $_POST["StepID"],
						"Category" => $category,
						"State" => $state);
						
		$ch = curl_init('http://10.11.145.91:1342/ServiceTask.svc/tasks/create');
	}
						
	echo "<pre>";print_r($data);echo "</pre>";
	$data_string = json_encode($data);                                                                                   
	echo "<pre>";print_r($data_string);echo "</pre>";
	
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
												'Content-Length: ' . strlen($data_string)));                                                                                                                   
	curl_exec($ch);
	
?>