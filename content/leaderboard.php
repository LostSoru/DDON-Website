<?php

tassign("PAGE_TITLE", "Leaderboard");

require_once('files/classes/character.class.php');

$load_leaderboard = new Character;
$load_leaderboard->Leaderboard();

if($load_leaderboard->no_data == "Yes") {
	$empty = new stdClass();
	$empty->data = false;
	tassign('get_leaderboard', $empty);
} else {
	foreach($load_leaderboard->leaderboard_data as $leader_data) {
		$leaderboard[] = array('character_rank' => $leader_data[0],
								'character_id' => $leader_data[1],
								'character_first_name' => $leader_data[2],
								'character_last_name' => $leader_data[3],
								'character_level' => $leader_data[4],
								'character_exp' => number_format($leader_data[5]),
								'character_job' => $leader_data[6]);
		tassign('get_leaderboard', $leaderboard);
	}
}

tassign('page_active', "Leaderboard");
tdisplay('leaderboard');

?>