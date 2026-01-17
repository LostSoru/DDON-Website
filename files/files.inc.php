<?php

# Load Vendor Autoload For Composer Installed Addons #
if(file_exists('vendor/autoload.php')) {
	require_once('vendor/autoload.php');
} else {
	echo "Autoload is missing, Please Use Composer To Installed The Required Files";
}

# Database Connection and Query Functions #
require_once('files/classes/database.class.php');

# Database Config Settings #
require_once('files/config/db_connect.php');

# Load Logging Class #
require_once('files/classes/logging.class.php');

# Load Template Config #
require_once('files/config/template_config.php');

# Load Account Class File #
require_once('files/classes/account.class.php');

# Load Glabal Config Data #
require_once('files/config/global_data.php');

# Load Layout Functions #
require_once('files/functions/layout_func.php');

?>