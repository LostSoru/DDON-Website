<?php
ob_start();

//Require all global files needed to load/connect
require_once('files/files.inc.php');

/*Load Default Or User Layout Data*/
Load_Layout_Data();

require_once('page_loader.php');

/*Load Footer Data*/
End_Layout();

# Close Database Connection #
$connect_database = null;
ob_end_flush();
?>
