<?php

# Load Logging Class #
$site_logging = new Logging;

# Start Session #
session_start();

# Set Global Variables #
//Used for the base site link on urls
$site_url = "https://www.example.com";
//Title to be displayed in the browser tab
$site_title = "Your Site Name";
//Date and Time
$datetime = date("Y-m-d H:i:s");
//Sets the Default Folder Nme For The Layout
$default_layout = "DDO";
//Sets The Register Page To Either Opened Or Closed
$register_closed = false;
//Sets the IP Or Domain Of The Game Server
$server_address = "localhost";
//Sets The Games Download Port
$download_port = "52099";
//Sets The Games Lobby Port
$lobby_port = "52100";

# Email Settings #
//SMTP Settings
$smtp_enabled = false; //true or false to enable or disbale SMTP
$smtp_host = ""; //e.g. smtp.gmail.com
$smtp_auth = false; // set this to true or false
$smtp_username = ""; //Your SMTP account name e.g. your_email@gmail.com
$smtp_password = ""; //Your Password Used To Login To the e.g. Email Listed Above
$smtp_secure = "PHPMailer::ENCRYPTION_STARTTLS"; // ENCRYPTION_STARTTLS For TLS And ENCRYPTION_SMTPS For SSL
$smtp_port = 587; //TCP Port To Connect To (typically 587 for TLS, 465 for SSL)
//From Settings
$from_email = "no-reply@example.com";
$from_name = "DDON Staff"; //e.g. Admin, No Reply, WebMaster, DDON
//Is Email HTML Or Not
$is_html_email = true; //true or false if email will send a html based email or not

# If Session Has Been Set And Started #
if(isset($_SESSION['account_ID'])) {
	$account_ID = $_SESSION['account_ID'];

	//Load Account Data
	$account = new Account;
	$account->Load_Account($account_ID);

	//Set The Name of The Account to a variable for the smarty temlate engine
	$account_NAME = $account->account_name;

	$template->assign("STATE", $account->account_state);

} else {
	$account_ID = NULL;
	$account_NAME = NULL;
}
//Assigns php variables to smarty template variables to be used in the template files
$template->assign(array("SITE_TITLE" => $site_title,
						"SITE_URL" => $site_url,
						"IS_LOGGED_IN" => $account_ID,
						"CONNECTED_USER" => $account_NAME,
						"SERVER_ADDRESS" => $server_address,
						"DOWNLOAD_PORT" => $download_port,
						"LOBBY_PORT" => $lobby_port));

?>
