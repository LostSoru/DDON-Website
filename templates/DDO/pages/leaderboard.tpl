{include file="DDO/pages/header.tpl" assign="header"}
{include file="DDO/pages/sidenav.tpl" assign="sidenav"}
{$header}

			{$sidenav}
	
			<!-- Main Content -->
			<main class="content-main">
				<div class="title">Leaderboard</div>
				<div class="subtitle">Top 10 Arisen By Exp.</div>

				<div class="divider"></div>

				<section class="leaderboard">
					<div class="leaderboard-title">TOP 10 ARISEN</div>
					<div class="leaderboard-subtitle">The strongest heroes in the realm</div>

					<table class="leaderboard-table">
						<thead>
							<tr>
								<th>Rank</th>
								<th>Character</th>
								<th>Level</th>
								<th>Exp</td>
								<th>Vocation</th>
							</tr>
						</thead>
						<tbody>
							{foreach $get_leaderboard as $leaderboard}
							{if $leaderboard <= 0 }
							<tr>
								<td colspan="5" style="text-align:center;">No Characters Registered To Show On Leaderboard</td>
							</tr>
							{else}
							{if $leaderboard.character_rank == 1}
							
							<tr class="rank-1">
							{elseif $leaderboard.character_rank == 2}
							
							<tr class="rank-2">
							{elseif $leaderboard.character_rank == 3}
							
							<tr class="rank-3">
							{else}
							
							<tr>
							{/if}
							
								<td>#{$leaderboard.character_rank}</td>
								<td>{$leaderboard.character_first_name} {$leaderboard.character_last_name}</td>
								<td>{$leaderboard.character_level}</td>
								<td>{$leaderboard.character_exp}</td>
								<td>{$leaderboard.character_job}</td>
							</tr>
							{/if}
							{/foreach}
						</tbody>
					</table>
				</section>