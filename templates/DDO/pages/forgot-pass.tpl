<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>{$SITE_TITLE} - {$PAGE_TITLE}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="/templates/DDO/login_style.css">

	</head>

	<body>
	
		<div class="panel">
			{if $section == "forgot-password"}
			
			<h1>Password Recovery</h1>
			<div class="subtitle">forgot your password?</div>
			<div class="divider"></div>
			{if isset($EMAIL_SENT)} <center><b><font color='#009900'>Email Sent!</font><br />If this Email Exist, You Should Recieve It Shortly.<br /></b></center><br /> {/if}
			<form method="post" action="/?page=account&id=forgot">
				<label>E-Mail</label>
				<input type="email" name="email" required>

				<button type="submit" name="forgot-pass">Send Email</button>
			</form>

			<div class="footer">
				Back to <a href="?page=account&id=login">Login</a><br />
				<br />
				<a href="/">Back Home</a><br />
			</div>
			{elseif $section == "reset-password"}
			
			<h1>Reset Password</h1>
			<div class="subtitle">Reset Your Password</div>
			<div class="divider"></div>
			{if $ERROR_MESSAGE != NULL} <center><b><font color='#990000'>Error:</font><br />{$ERROR_MESSAGE}</b></center><br />{/if}
			{if $ERROR_MESSAGE == NULL OR $ERROR_MESSAGE == "Your Passwords Did Not Match"}
			<form method="post" action="">
				<label>New Password</label>
				<input type="password" name="new_password" required>
				
				<label>Confirm Password</label>
				<input type="password" name="confirm_password" required>

				<button type="submit" name="reset-pass">Reset Password</button>
			</form>

			<div class="footer">
				Back to <a href="?page=account&id=login">Login</a><br />
				<br />
				<a href="/">Back Home</a><br />
			</div>
			{/if}
			{/if}
		</div>