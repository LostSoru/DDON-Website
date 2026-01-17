<?php


class Pawn {
	
	public $no_data;
	public $pawn_data;
	public $pawn_id;
	public $pawn_name;
	
	public function Load_Pawns($account_id) {
		global $site_logging;
		
		$load_pawns_sql = "SELECT p.name, cjob.job, cjob.lv, cjob.exp
								FROM ddon_pawn AS p
								LEFT JOIN ddon_character_job_data AS cjob
								ON p.character_common_id = cjob.character_common_id
								WHERE p.character_id = :account_id
								ORDER BY p.pawn_id";
		$load_pawns_params = array("account_id" => $account_id);
		$load_pawns = new Database;
		$load_pawns->query_data($load_pawns_sql, $load_pawns_params, "no", "select_all_data");
		$row = $load_pawns->fetch_row;
		
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
				
				$this->pawn_data[] = array(
					$row['name'],
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