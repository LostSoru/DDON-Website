<?php

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	
	try {
		if(preg_match("/[^[a-zA-Z0-9_]|[\s]]$/", $id)) {
				$logging_id = '0';
				throw new Exception("Invalid Action Name Used!");
		} else {
			switch ($id) {
				case "login":
					Login_Account();
					break;
				case "logout":
					Logout_Account();
					break;
				case "register":
					Register_Account();
					break;
				case "verify":
					Verify_Account();
					break;
				case "forgot":
					Forgot_Password();
					break;
				case "reset":
					Reset_Password();
					break;
				default:
					Account_Home();
					die();
			}
		}
	} catch(Exception $error) {
		$logging_id = '0';
		$site_logging->Load_Error_Display($logging_id, $error);
	}
} else {
	Account_Home();
}

function Login_Account() {
	global $site_logging, $datetime;
	
	//Require the file for Creating and Verify Hashed Data
	require_once('files/functions/hash_func.php');
	//Require the Account Class File
	require_once('files/classes/account.class.php');
	
	try{
		if(isset($_POST['login'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			$login_account = new Account;
			$login_account->Check_Account($username);
			
			if(!$username || !$password) {
				throw new Exception("Either Your Username Or Password Was Left Blank");
			}
			if(!$login_account->account_name) {
				throw new Exception("This Account Does Not Exist");
			}
			if(!verifyHash($password, $login_account->account_hash)) {
				throw new Exception("Your Password Was Incorrect");
			}
			
			session_regenerate_id(true);
			$_SESSION['account_ID'] = $login_account->account_id;
			session_start();
			
			$update_last_login = new Account;
			$update_last_login->Load_Account($login_account->account_id);
			$update_last_login->account_last_login = $datetime;
			$update_last_login->Update_Last_Login($update_last_login->account_id);
			
			exit(header('Location: /'));
			
		} else {//If No Data Has Been Submitted Then Show Login Page
			tassign("PAGE_TITLE", "Login");
			tdisplay('login');
		}
	} catch(Exception $error) {//If An Error Has Been Caught, Then Display The Error On Login Page
		//trigger_error($error->getMessage());
		tassign_array(["PAGE_TITLE" => "Login", "ERROR_MESSAGE" => $error->getMessage()]);
		tdisplay('login');
	}
	//tassign("PAGE_TITLE", "Login");
	//tdisplay('login');
}

function Logout_Account() {
	session_destroy();
	exit(header('Location: /'));
}

function Account_Home() {
	global $account, $server_address, $download_port;
	if(isset($_SESSION['account_ID'])) {
		
		if(isset($_POST['send_verify'])) {
			try {
				require_once('files/functions/hash_func.php');		
				require_once('files/functions/email_func.php');
				
				$random_code_characters = "0123456789abcdefghijklmnopqrstuvwxyz";
				$random_code = substr(str_shuffle($random_code_characters), 0, 10);
				
				$update_mail_token_sql = "UPDATE account SET mail_token = :mail_token WHERE name = :name";
				$update_mail_token_params = array("mail_token" => createHash($random_code), "name" => $account->account_name);
				$update_mail_token = new Database;
				$update_mail_token->query_data($update_mail_token_sql, $update_mail_token_params, "no", "update");
				
				Send_Email($account->account_name, $account->account_mail, $random_code, "resend_verify");
				tassign("EMAIL_SENT", true);
			} catch(Exception $error) {
				tassign("EMAIL_ERROR", $error->getMessage());
			}
		}
		if(isset($_POST['update_account'])) {
			try {
				$username = $_POST['username'];
				$lowername = strtolower($username);
				$email = $_POST['email'];
				
				$account->account_name = $username;
				$account->account_normal_name = $lowername;
				$account->account_mail = $email;
				$account->Account_Update($account->account_id);
				tassign("ACCOUNT_UPDATED", true);
			} catch(Exception $error) {
				tassign("ACCOUNT_ERROR", true);
			}
		}
		
		if(isset($_POST['update_password'])) {
			try {
				require_once('files/functions/hash_func.php');
				
				$password = $_POST['current_password'];
				$new_password = $_POST['new_password'];
				$confirm_password = $_POST['confirm_password'];
				
				if(!$password || !$new_password || !$confirm_password) {
					throw new Exception("You Left Something Blank");
				}
				if(!verifyHash($password, $account->account_hash)) {
					throw new Exception("Your Current Password Did Not Match");
				}
				if($new_password != $confirm_password) {
					throw new Exception("Your New Password Did Not Match");
				}
				
				$account->account_hash = createHash($new_password);
				$account->Account_Password_Update($account->account_id);
				tassign("PASSWORD_UPDATED", true);
			} catch(Exception $error) {
				tassign("PASSWORD_ERROR", $error->getMessage());
			}
		}
		
		require_once('files/functions/channel_online_func.php');
		
		$created_date = new DateTime($account->account_created);
		$created_date = $created_date->format('F j, Y');
		$last_login_date = new DateTime($account->account_last_login);
		$last_login_date = $last_login_date->format('F j, Y');
		
		tassign_array(["ACCOUNT_NAME" => $account->account_name,
						"ACCOUNT_MAIL" => $account->account_mail,
						"ACCOUNT_CREATED" => $created_date,
						"ACCOUNT_LAST_ON" => $last_login_date,
						"ACCOUNT_STATE" => $account->account_state,
						"ACCOUNT_VERIFIED" => $account->account_mail_verified]);
		tassign_array(["PAGE_TITLE" => "Account", "page_active" => "Account"]);
		tdisplay('account');
	} else {
		exit(header('Location: /?page=account&id=login'));
	}
}

function Verify_Account() {
	global $datetime, $site_logging;
	
	require_once('files/functions/hash_func.php');
	
	try {
		if(!isset($_GET['account']) || !isset($_GET['code'])) {
			throw new Exception("Something Is Missing");
		} else {
			$account_name = $_GET['account'];
			$mail_token = $_GET['code'];
			
			if(!$account_name || !$mail_token) {
				throw new Exception("Something is Missing");
			}
			
			$fetch_mail_token_sql = "SELECT mail_verified, mail_token FROM account WHERE name = :account_name";
			$fetch_mail_token_param = array("account_name" => $account_name);
			$fetch_mail_token = new Database;
			$fetch_mail_token->query_data($fetch_mail_token_sql, $fetch_mail_token_param, "no", "select_data");
			$fetched_token = $fetch_mail_token->fetch_row;
			
			if(!$fetched_token) {
				throw new Exception("Either The Account Does Not Exist Or Your Code Is Incorrect");
			}
			if(!$mail_token) {
				throw new Exception("Your Verify Code Was Left Blank");
			}
			if($fetched_token['mail_verified'] == TRUE) {
				throw new Exception("This Account Has Already Been Verified");
			}
			if(!verifyHash($mail_token, $fetched_token['mail_token'])) {
				throw new Exception("Either The Account Does Not Exist Or Your Code Is Incorrect");
			}
			
			$update_activated_sql = "UPDATE account SET mail_verified = 'TRUE', mail_verified_at = :date, mail_token = NULL WHERE name = :account_name AND mail_token = :mail_token";
			$update_activated_params = array("date" => $datetime, "account_name" => $account_name, "mail_token" => $fetched_token['mail_token']);
			$update_activated = new Database;
			$update_activated->query_data($update_activated_sql, $update_activated_params, "no", "update");
			
			exit(header('Location: /?page=account'));
		}
	} catch(Exception $error) {
		$logging_id = '0';
		$site_logging->Load_Error_Display($logging_id, $error);
	}
}

function Forgot_Password() {
	global $site_logging;
	
	require_once('files/classes/account.class.php');
	require_once('files/functions/hash_func.php');
	require_once('files/functions/email_func.php');
	
	$random_code_characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$random_code = substr(str_shuffle($random_code_characters), 0, 10);
	
	try {
		if(isset($_POST['forgot-pass'])) {
			$email = $_POST['email'];
			
			$check_email_sql = "SELECT name, mail FROM account WHERE mail = :account_mail";
			$check_email_params = array("account_mail" => $email);
			$check_email = new Database;
			$check_email->query_data($check_email_sql, $check_email_params, "no", "select_data");
			$row = $check_email->fetch_row;
			
			if($row) {
				$update_password_token_sql = "UPDATE account SET password_token = :password_token WHERE name = :account_name";
				$update_password_token_params = array("password_token" => createHash($random_code), "account_name" => $row['name']);
				$update_password_token = new Database;
				$update_password_token->query_data($update_password_token_sql, $update_password_token_params, "no", "update");
				Send_Email($row['name'], $row['mail'], $random_code, "forgot_password");
				//echo "Email Sent";
			}
			
			tassign("EMAIL_SENT", true);
		}
		tassign_array(["PAGE_TITLE" => "Forgot Password", "section" => "forgot-password"]);
		tdisplay('forgot-pass');
	} catch(Exception $error) {
		$logging_id = '0';
		$site_logging->Load_Error_Display($logging_id, $error);
	}
}

function Reset_Password() {
	global $site_logging;
	
	//Require the file for Creating and Verify Hashed Data
	require_once('files/functions/hash_func.php');
	//Require the Account Class File
	require_once('files/classes/account.class.php');
	tassign("ERROR_MESSAGE", NULL);
	
	try {
		if(!isset($_GET['account']) || !isset($_GET['code'])) {
			throw new Exception("Something Is Missing");
		} else {
			$account_name = $_GET['account'];
			$password_token = $_GET['code'];
			
			$password_token = strtolower($password_token);
			
			if(!$account_name || !$password_token) {
				throw new Exception("Something is Missing");
			}
			if($password_token == "null") {
				throw new Exception("Code Can Not Be Null");
			}
			
			if(isset($_POST['reset-pass'])) {
				$new_password = $_POST['new_password'];
				$confirm_password = $_POST['confirm_password'];
				
				if($new_password != $confirm_password) {
					throw new Exception("Your Passwords Did Not Match");
				}
				
				$update_password_sql = "UPDATE account SET hash = :new_password, password_token = NULL WHERE name = :account_name";
				$update_password_params = array("new_password" => createHash($new_password), "account_name" => $account_name);
				$update_password = new Database();
				$update_password->query_data($update_password_sql, $update_password_params, "no", "update");
				
				$load_account = new Account;
				$load_account->Check_Account($account_name);
				
				session_regenerate_id(true);
				$_SESSION['account_ID'] = $load_account->account_id;
				session_start();
				exit(header('Location: /?page=account'));
			} else {
			
				$fetch_password_token_sql = "SELECT name, password_token FROM account WHERE name = :account_name";
				$fetch_password_token_params = array("account_name" => $account_name);
				$fetch_password_token = new Database;
				$fetch_password_token->query_data($fetch_password_token_sql, $fetch_password_token_params, "no", "select_data");
				$fetched_token = $fetch_password_token->fetch_row;
				
				if(!$fetched_token) {
					throw new Exception("Either The Account Does Not Exist Or Your Code Is Incorrect");
				}
				if(!$password_token) {
					throw new Exception("Your Verify Code Was Left Blank");
				}
				if(!verifyHash($password_token, $fetched_token['password_token'])) {
					throw new Exception("Either The Account Does Not Exist Or Your Code Is Incorrect");
				}
				
				tassign_array(["PAGE_TITLE" => "Reset Password", "section" => "reset-password"]);
				tdisplay('forgot-pass');
			}
		}
	} catch(Exception $error) {
		tassign_array(["PAGE_TITLE" => "ERROR", "ERROR_MESSAGE" => $error->getMessage(), "section" => "reset-password"]);
		tdisplay('forgot-pass');
	}
}

function Register_Account() {
	global $register_closed;
	
	require_once('files/classes/account.class.php');
	require_once('files/functions/hash_func.php');
	require_once('files/functions/email_func.php');
	
	try {
		if($register_closed === true) {
			throw new Exception("Register Is Currently Closed");
		}
		
		if(isset($_POST['register'])) {
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			
			//Check If Account Exist
			$check_account = new Account;
			$check_account->Check_Account($username);
			
			//Check If Email Exist
			$check_email = new Account;
			$check_email->Check_Email($email);
			
			if(!$username || !$email || !$password || !$confirm_password) {
				throw new Exception("Something Was Left Blank");
			}
			if($check_account->account_name) {
				throw new Exception("This Username is Already In Use");
			}
			if($check_email->account_mail) {
				throw new Exception("This Email Is Already In Use");
			}
			if($password != $confirm_password) {
				throw new Exception("Your Passwords Did Not Match");
			}
			
			$register_account = new Account;
			$register_account->Account_Register($username, createHash($password), $email);
			
			$load_account = new Account;
			$load_account->Check_Account($username);
			
			$random_code_characters = "0123456789abcdefghijklmnopqrstuvwxyz";
			$random_code = substr(str_shuffle($random_code_characters), 0, 10);
				
			$update_mail_token_sql = "UPDATE account SET mail_token = :mail_token WHERE name = :name";
			$update_mail_token_param = array("mail_token" => createHash($random_code), "name" => $load_account->account_name);
			$update_mail_token = new Database;
			$update_mail_token->query_data($update_mail_token_sql, $update_mail_token_param, "no", "update");
			
			Send_Email($load_account->account_name, $email, $random_code, "register");
			
			session_regenerate_id(true);
			$_SESSION['account_ID'] = $load_account->account_id;
			session_start();
			exit(header('Location: /?page=account'));
		}
		tassign("PAGE_TITLE", "Register");
		tdisplay('register');
	} catch(Exception $error) {
		tassign_array(["PAGE_TITLE" => "ERROR", "ERROR_MESSAGE" => $error->getMessage()]);
		tdisplay('register');
	}
}

?>