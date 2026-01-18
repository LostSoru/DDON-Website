{include file="DDO/pages/header.tpl" assign="header"}
{include file="DDO/pages/sidenav.tpl" assign="sidenav"}
{$header}

			{$sidenav}
			
			<!-- Main Content -->
			<main class="content-main">
			
				<!-- Profile -->
				<div class="title">ARISEN PROFILE</div>
				<div class="subtitle">Your legacy within the White Dragon’s realm</div>
				<div class="divider"></div>
				
				<div class="grid">
					<div class="card">
						<h3>Account Overview</h3>
						<p><strong>Name:</strong> {$ACCOUNT_NAME}</p>
						<p><strong>Rank:</strong> {if $ACCOUNT_STATE == 1}Member{elseif $ACCOUNT_STATE == 50}Moderator{elseif $ACCOUNT_STATE == 100}Admin{else}Banned{/if}</p></p>
					</div>
				</div>
				
				<!-- Characters -->
				<div class="section-title">CHARACTERS</div>
				<div class="grid">
					{foreach $get_characters as $characters}
					{if $characters <= 0}
					
					<div class="card">
						<h3>You Have No Characters</h3>
					</div>
					{else}
					
					<div class="card">
						<h3>{$characters.character_first_name} {$characters.character_last_name}</h3>
						<p><strong>Level:</strong> {$characters.character_level}</p>
						<p><strong>EXP:</strong> {$characters.character_exp}</p>
						<span class="badge">{$characters.character_vocation}</span>
					</div>
					{/if}
					{/foreach}
				</div>
				
				<!-- Pawns -->
				<div class="section-title">PAWNS</div>
				<div class="grid">
					{foreach $get_pawns as $pawns}
					{if $pawns <= 0}
					
					<div class="card">
						<h3>You Have No Pawns</h3>
					</div>
					{else}
					
					<div class="card">
						<h3>{$pawns.pawn_name}</h3>
						<p><strong>Level:</strong> {$pawns.pawn_level}</p>
						<p><strong>EXP:</strong> {$pawns.pawn_exp}</p>
						<span class="badge">{$pawns.pawn_vocation}</span>
					</div>
					{/if}
					{/foreach}
				</div>