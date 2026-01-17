<?php

# Layout Function to fetch layout data
function Load_Layout_Data() {
	global $template, $site_config, $folder, $default_layout, $user;

	$folder = $default_layout . "/pages/";
	
	$template->assign("LOAD_TIME", round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4));
}

# Load Footer Function
function End_Layout() {
	global $template, $folder, $num_sql_queries;

	/*$template->assign(array('LOAD_TIME' => round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4),
					'TOTAL_QUERIES' => $num_sql_queries,
					'MEM_USAGE' => round(memory_get_usage()/1048576, 2) . " MB's"));*/
	$template->display($folder . 'footer.tpl');
}

# Display The Template File Being Called
function tdisplay($pagetpl) {
	global $template, $folder, $datetime, $site_logging;

	try {
		$template->display($folder . $pagetpl . ".tpl");
	} catch(Exception $error) {
		$log_type = '0';
		//$site_logging->Send_Logging_Data($log_type, $error->getMessage());
		$template->assign(array("ERROR_MESSAGE" => $error->getMessage(),
                             	"PAGE_TITLE" => "Error",
								"ERROR_TIME" => $datetime));
		$template->display($folder . 'error.tpl');
	}
}

# Assign A Single Variable To The Template
function tassign($tplvar, $data) {
	global $template;

	$template->assign($tplvar, $data);
}

# Assign An Array Of Variable To A Template
function tassign_array($array_data) {
	global $template;

	$template->assign($array_data);
}
