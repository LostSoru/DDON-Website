<?php

class Character {
	
		# Character Table Data #
		public $no_data;
		public $character_data;
		public $character_id;
		public $character_common_id;
		public $character_account_id;
		public $character_version;
		public $character_first_anem;
		public $character_last_name;
		public $character_created;
		
		# Character Job Data #
		public $character_job;
		public $character_exp;
		public $character_job_point;
		public $character_lv;
		
		# Leaderboard #
		public $leaderboard_data;
	
	public function Load_Characters($account_id) {
		global $site_logging;
		
		$load_characters_sql = "SELECT c.first_name, c.last_name, cjob.job, cjob.lv, cjob.exp
								FROM ddon_character AS c
								LEFT JOIN ddon_character_job_data AS cjob
								ON c.character_common_id = cjob.character_common_id
								WHERE c.account_id = :account_id
								ORDER BY c.character_id";
		$load_characters_params = array("account_id" => $account_id);
		$load_characters = new Database;
		$load_characters->query_data($load_characters_sql, $load_characters_params, "no", "select_all_data");
		$row = $load_characters->fetch_row;
		
		if($row) {
			foreach($row as $row) {
				if($row['job'] == '0') {
					$vocation = "None";
				}
				else if($row['job'] == '1') {
					$vocation = "Fighter";
				}
				else if($row['job'] == '2') {
					$vocation = "Seeker";
				}
				else if($row['job'] == '3') {
					$vocation = "Hunter";
				}
				else if($row['job'] == '4') {
					$vocation = "Priest";
				}
				else if($row['job'] == '5') {
					$vocation = "Shield Sage";
				}
				else if($row['job'] == '6') {
					$vocation = "Sorcerer";
				}
				else if($row['job'] == '7') {
					$vocation = "Warrior";
				}
				else if($row['job'] == '8') {
					$vocation = "Element Archer";
				}
				else if($row['job'] == '9') {
					$vocation = "Alchemist";
				}
				else if($row['job'] == '10') {
					$vocation = "Spirit Lancer";
				}
				else if($row['job'] == '11') {
					$vocation = "High Scepter";
				}
				else {
					$vocation = "Unknown";
				}
				
				$this->character_data[] = array(
					$row['first_name'],
					$row['last_name'],
					$row['lv'],
					$row['exp'],
					$vocation);
			}
			$this->no_data = "No";
		} else {
			$this->no_data = "Yes";
		}
	}
	
	public function Load_Character() {
		
	}
	
	public function Leaderboard() {
		global $site_logging;
		
		$load_leaderboard_sql = "SELECT c.character_id, c.first_name, c.last_name, cjob.job, cjob.exp, cjob.lv FROM ddon_character AS c
								LEFT JOIN ddon_character_job_data AS cjob
								ON c.character_common_id = cjob.character_common_id
								WHERE version = 25
								ORDER BY cjob.lv DESC LIMIT 10";
		$load_leaderboard_params = NULL;
		$load_leaderboard = new Database;
		$load_leaderboard->query_data($load_leaderboard_sql, $load_leaderboard_params, "no", "select_all_data");
		$row = $load_leaderboard->fetch_row;
		
		$rank = '1';
		
		if($row) {
			foreach($row as $row) {
				if($row['job'] == '0') {
					$vocation = "None";
				}
				else if($row['job'] == '1') {
					$vocation = "Fighter";
				}
				else if($row['job'] == '2') {
					$vocation = "Seeker";
				}
				else if($row['job'] == '3') {
					$vocation = "Hunter";
				}
				else if($row['job'] == '4') {
					$vocation = "Priest";
				}
				else if($row['job'] == '5') {
					$vocation = "Shield Sage";
				}
				else if($row['job'] == '6') {
					$vocation = "Sorcerer";
				}
				else if($row['job'] == '7') {
					$vocation = "Warrior";
				}
				else if($row['job'] == '8') {
					$vocation = "Element Archer";
				}
				else if($row['job'] == '9') {
					$vocation = "Alchemist";
				}
				else if($row['job'] == '10') {
					$vocation = "Spirit Lancer";
				}
				else if($row['job'] == '11') {
					$vocation = "High Scepter";
				}
				else {
					$vocation = "Unknown";
				}
				
				$this->leaderboard_data[] = array(
					$rank++,
					$row['character_id'],
					$row['first_name'],
					$row['last_name'],
					$row['lv'],
					$row['exp'],
					$vocation);
			}
			$this->no_data = "No";
		} else {
			$this->no_data = "Yes";
		}
	}
}

?>