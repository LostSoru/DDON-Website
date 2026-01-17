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
			<h1>LOGIN</h1>
			<div class="subtitle">Return, Arisen</div>
			<div class="divider"></div>
			{if isset($ERROR_MESSAGE)} <center><b><font color='#990000'>Error:</font><br />{$ERROR_MESSAGE}</b></center><br /> {/if}
			<form method="post" action="/?page=account&id=login">
				<label>Username</label>
				<input type="text" name="username" required>

				<label>Password</label>
				<input type="password" name="password" required>

				<button type="submit" name="login">ENTER THE WORLD</button>
			</form>

			<div class="footer">
				No account? <a href="?page=account&id=register">Register</a><br />
				Forgot Your Password? <a href="/?page=account&id=forgot">Reset</a><br />
				<br />
				<a href="/">Back Home</a><br />
			</div>
		</div>