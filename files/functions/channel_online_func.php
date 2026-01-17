<?php

// Timeout in seconds
$timeout = 5;

// Attempt to connect to the server
$connection = fsockopen($server_address, $download_port, $errno, $errstr, $timeout);

if ($connection) {
    $channel_up = "<font color='#009900'>Online</font>";
	tassign("CHANNEL_UP", $channel_up);
    fclose($connection);  // Close the connection when done
} else {
    $channel_up = "<font color='#990000'>Offline</font>";
	tassign("CHANNEL_UP", $channel_up);
}
?>
