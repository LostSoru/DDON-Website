<?php

if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$logging_id = '0';
	
	try {
		if(preg_match("/[^[0-9a-zA-Z_\/]|[\s]]$/", $page)) {
			throw new Exception("Invalid Page Name Used!");
		} else {
			$filename = $page;
		}
		
		if(file_exists('content/' . $filename . '.php')) {
			require_once('content/' . $filename . '.php');
		} else {
			throw new Exception("This Page Does Not Exist");
		}
	} catch(Exception $error) {
		//trigger_error($error->getMessage());
		//echo $error->getMessage();
		$site_logging->Load_Error_Display($logging_id, $error);
	}
} else {
	//exit(header('Location: index.html'));
	//require_once('dev_templates/home1.html');
	require_once('content/home.php');
}

?>