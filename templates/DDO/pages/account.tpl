{include file="DDO/pages/header.tpl" assign="header"}
{include file="DDO/pages/sidenav.tpl" assign="sidenav"}
{$header}

			{$sidenav}
			
			<!-- Main Content -->
			<main class="content-main">
				<div class="title">ACCOUNT</div>
				<div class="subtitle">Your identity within the realm</div>
				<div class="divider"></div>

				<section class="account-grid">

					<!-- Profile Overview -->
					<div class="card">
						<h3>Profile</h3>
						{if isset($EMAIL_SENT)}<font color="#009900"><b>Email Sent!</b></font>{/if}
						{if isset($EMAIL_ERROR)}<font color="#990000"><b>Email Error!</b></font>{/if}
						<div class="info">
							<p><strong>Name:</strong> {$ACCOUNT_NAME}</p>
							<p><strong>Joined:</strong> {$ACCOUNT_CREATED}</p>
							<p><strong>Last On:</strong> {$ACCOUNT_LAST_ON}</p>
							<p><strong>Status:</strong> {if $ACCOUNT_STATE == 1}Member{elseif $ACCOUNT_STATE == 50}Moderator{elseif $ACCOUNT_STATE == 100}Admin{else}Banned{/if}</p>
							<p><strong>Verified:</strong> {if $ACCOUNT_VERIFIED == TRUE}<font color="#009900">Email Verified</font>{else}<font color="#990000">Email Not Verified</font><br /><form action="" method="post"><button type="submit" name="send_verify">Resend Email</button></form>{/if}</p>
							<br />
							<br />
							<p><strong>Server Address:</strong> {$SERVER_ADDRESS}</p>
							<p><strong>Download Port:</strong> {$DOWNLOAD_PORT}</p>
							<p><strong>Lobby Port:</strong> {$LOBBY_PORT}</p>
							<p><strong>Server:</strong> {$CHANNEL_UP}</p>
						</div>
					</div>

					<!-- Account Details -->
					<div class="card">
						<h3>Account Details</h3>
						{if isset($ACCOUNT_UPDATED)}<font color="#009900"><b>Account Updated!</b></font>{/if}
						{if isset($ACCOUNT_ERROR)}<font color="#990000"><b>Account Updated!</b></font>{/if}
						<form action="" method="post">
							<label>Username</label>
							<input type="text" name="username" value="{$ACCOUNT_NAME}">

							<label>Email</label>
							<input type="email" name="email" value="{$ACCOUNT_MAIL}">

							<button type="submit" name="update_account">Save Changes</button>
						</form>
					</div>

					<!-- Password -->
					<div class="card">
						<h3>Change Password</h3>
						{if isset($PASSWORD_UPDATED)}<font color="#009900"><b>Password Updated!</b></font>{/if}
						{if isset($PASSWORD_ERROR)}<font color="#990000"><b>{$PASSWORD_ERROR}</b></font>{/if}
						<form action="" method="post">
							<label>Current Password</label>
							<input type="password" name="current_password">

							<label>New Password</label>
							<input type="password" name="new_password">

							<label>Confirm New Password</label>
							<input type="password" name="confirm_password">

							<button type="submit" name="update_password">Update Password</button>
						</form>
					</div>

				</section>