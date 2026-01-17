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
			<h1>REGISTER</h1>
			<div class="subtitle">Begin Your Journey</div>
			<div class="divider"></div>
			{if isset($ERROR_MESSAGE)} <center><b><font color='#990000'>Error:</font><br />{$ERROR_MESSAGE}</b></center><br /> {/if}
			<form method="post" action="/?page=account&id=register">
				<label>Username</label>
				<input type="text" name="username" required>

				<label>Email</label>
				<input type="email" name="email" required>

				<label>Password</label>
				<input type="password" name="password" required>

				<label>Confirm Password</label>
				<input type="password" name="confirm_password" required>

				<button type="submit" name="register" value="register">FORGE YOUR FATE</button>
			</form>

			<div class="footer">
				Already registered? <a href="?page=account&id=login">Login</a><br /><br />
				<a href="/">Back Home</a><br />
			</div>
		</div>