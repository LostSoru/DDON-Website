<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function Send_Email($account_name, $account_email, $token, $email_type) {
	global $site_url, $site_title, $default_layout, $smtp_enable, $smtp_host, $smtp_auth, $smtp_username, $smtp_password, $smtp_secure, $smtp_port, $from_email, $from_name, $is_html_email;
	
	$mail = new PHPMailer(true);
	try {
		if($smtp_enable == true) {
			$mail->isSMTP();
			$mail->Host = $smpt_host;
			$mail->SMTPAuth = $smtp_auth;
			$mail->Username = $smtp_username;
			$mail->Password = $smpt_password;
			$mail->SMTPSecure = $smpt_secure;
			$mail->Port = $smpt_port;
		}
		
		$mail->setFrom($from_email, $from_name);
		$mail->addAddress($account_email, $account_name);
		
		if($email_type == "resend_verify") {
			$mail->Subject = "Welcome To $site_title! Your Adventure Awaits!";
		
			if($is_html_email = true) {
				$mail->isHTML(true);
				$message_body = file_get_contents("templates/" . $default_layout . "/pages/email/email.html");
				$build_email = str_replace(array("{{account_name}}", "{{site_url}}", "{{site_title}}", "{{mail_token}}"), array($account_name, $site_url, $site_title, $token), $message_body);
				$mail->Body = $build_email;
			} else {
				$build_email = "Hi $account_name,<br /><br />Thank you for registering to play Dragons Dogma Online! We’re thrilled to have you join the $site_title community and embark on an epic journey filled with fierce dragons, breathtaking landscapes, and unforgettable adventures.<br /><br />Verify Your Email To Start Playing! <a href='$site_url/?page=account&id=verify&account=$account_name&code=$token'>$site_url/?page=account&id=verify&account=$account_name&code=$mail_token</a>";
				$mail->Body = $build_email;
			}
		}
		if($email_type == "forgot_password") {
			$mail->Subject = "Reset Password";
			
			if($is_html_email = true) {
				$mail->isHTML(true);
				$message_body = file_get_contents("templates/" . $default_layout . "/pages/email/reset_email.html");
				$build_email = str_replace(array("{{account_name}}", "{{site_url}}", "{{site_title}}", "{{password_token}}"), array($account_name, $site_url, $site_title, $token), $message_body);
				$mail->Body = $build_email;
			} else {
				$build_email = "Hi $account_name,<br /><br />Someone requested a password change for $site_title<br /><br />Reset Your Password! <a href='$site_url/?page=account&id=reset&account=$account_name&code=$password_token'>$site_url/?page=account&id=verify&account=$account_name&code=$token</a>";
				$mail->Body = $build_email;
			}
		}
		if($email_type == "register") {
			$mail->Subject = "Welcome To $site_title! Your Adventure Awaits!";
			
			if($is_html_email = true) {
				$mail->isHTML(true);
				$message_body = file_get_contents("templates/" . $default_layout . "/pages/email/email.html");
				$build_email = str_replace(array("{{account_name}}", "{{site_url}}", "{{site_title}}", "{{mail_token}}"), array($account_name, $site_url, $site_title, $token), $message_body);
				$mail->Body = $build_email;
			} else {
				$build_email = "Hi $account_name,<br /><br />Thank you for registering to play Dragons Dogma Online! We’re thrilled to have you join the $site_title community and embark on an epic journey filled with fierce dragons, breathtaking landscapes, and unforgettable adventures.<br /><br />Verify Your Email To Start Playing! <a href='$site_url/?page=account&id=verify&account=$account_name&code=$token'>$site_url/?page=account&id=verify&account=$account_name&code=$mail_token</a>";
				$mail->Body = $build_email;
			}
		}
		
		$mail->send();
	} catch(Exception $error) {
		echo $error->getMessage();
	}
}

?>