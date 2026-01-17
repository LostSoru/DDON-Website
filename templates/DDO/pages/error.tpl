{include file="DDO/pages/header.tpl" assign="header"}
{include file="DDO/pages/sidenav.tpl" assign="sidenav"}
{$header}

			{$sidenav}
	
			<!-- Main Content -->
			<main class="content-main">
				<div class="title">ERROR</div>
				<div class="subtitle">You encountered an error.</div>

				<div class="divider"></div>

				<section class="panels">
					<div class="panel">
						<h3>Error:</h3>
						<p>
							{$ERROR_MESSAGE}
							<br />
							<br />
							{$ERROR_TIME}
						</p>
					</div>
				</section>