			<!-- Sidebar Menu -->
			<aside class="sidebar">
				<div class="logo">
					<img src="images/logo.png">
				</div>

				<nav class="nav">
					<a href="/"{if $page_active == "Home"} class="active"{/if}>Home</a>
					{if isset($IS_LOGGED_IN)}

					<a href="/?page=profile"{if $page_active == "Profile"} class="active"{/if}>Profile</a>
					{/if}

					<a href="/?page=leaderboard"{if $page_active == "Leaderboard"} class="active"{/if}>Leaderboard</a>
					<a href="/?page=download"{if $page_active == "Download"} class="active"{/if}>Download</a>
					{if isset($IS_LOGGED_IN)}

					<a href="/?page=account"{if $page_active == "Account"} class="active"{/if}>Account</a>
					<a href="/?page=account&id=logout">Logout</a>
					{else}

					<a href="/?page=account&id=login"{if $page_active == "Login"} class="active"{/if}>Log In</a>
					<a href="/?page=account&id=register"{if $page_active == "Register"} class="active"{/if}>Register</a>
					{/if}
				</nav>
			</aside>
