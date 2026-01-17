<?php

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	
	try {
		if(preg_match("/[^[a-zA-Z0-9_]|[\s]]$/", $id)) {
				$logging_id = '0';
				throw new Exception("Invalid Action Name Used!");
		} else {
			switch ($id) {
				case "view-character":
					View_Character();
					break;
				case "view-pawn":
					View_Pawn();
					break;
				default:
					Profile_Home();
					die();
			}
		}
	} catch(Exception $error) {
		$logging_id = '0';
		$site_logging->Load_Error_Display($logging_id, $error);
	}
} else {
	Profile_Home();
}

function Profile_Home() {
	global $site_logging, $account;
	
	if(isset($_SESSION['account_ID'])) {
		//Required The Account Class File
		require_once('files/classes/account.class.php');
		//Require The Character Class File
		require_once('files/classes/character.class.php');
		//Require The Pawn Class File
		require_once('files/classes/pawn.class.php');

		$load_account = new Account;
		$load_account->Load_Account($account->account_id);
		
		$load_characters = new Character;
		$load_characters->Load_Characters($account->account_id);
		
		$load_pawns = new Pawn;
		$load_pawns->Load_Pawns($account->account_id);
		
		try {
			## Account Overview ##
			tassign_array(["ACCOUNT_NAME" => $account->account_name,
							"ACCOUNT_STATE" => $account->account_state]);
							
			## Characters Overview ##
			if($load_characters->no_data == "Yes") {
				$empty = new stdClass();
				$empty->data = false;
				tassign('get_characters', $empty);
			} else {
				foreach($load_characters->character_data as $character_data) {
					$characters[] = array(
						"character_first_name" => $character_data[0],
						"character_last_name" => $character_data[1],
						"character_level" => $character_data[2],
						"character_exp" => number_format($character_data[3]),
						"character_vocation" => $character_data[4]);
					tassign('get_characters', $characters);
				}
			}
			## Pawns Overview ##
			if($load_pawns->no_data == "Yes") {
				$empty = new stdClass();
				$empty->data = false;
				tassign('get_pawns', $empty);
			} else {
				foreach($load_pawns->pawn_data as $pawn_data) {
					$pawns[] = array(
						"pawn_name" => $pawn_data[0],
						"pawn_level" => $pawn_data[1],
						"pawn_exp" => number_format($pawn_data[2]),
						"pawn_vocation" => $pawn_data[3]);
					tassign('get_pawns', $pawns);
				}
			}
			
			tassign_array(["PAGE_TITLE" => "Profile", "page_active" => "Profile"]);
			tdisplay('profile/profile');
		} catch(Exception $error) {
			$logging_id = '0';
			$site_logging->Load_Error_Display($logging_id, $error);
		}
	} else {
		exit(header('Location: /?page=account&id=login'));
	}
}