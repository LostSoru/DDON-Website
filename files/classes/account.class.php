<?php

class Account {

	public $no_data;
	public $account_id;
	public $account_name;
	public $account_normal_name;
	public $account_hash;
	public $account_mail;
	public $account_mail_verified;
	public $account_mail_verified_at;
	public $account_state;
	public $account_last_login;
	public $account_created;
	
	public function Load_Account($account_id) {
		
		try {
			$load_account_sql = "SELECT id, name, hash, normal_name, mail, mail_verified, mail_verified_at, state, last_login, created FROM account WHERE id = :account_id";
			$load_account_params = array("account_id" => $account_id);
			$load_account = new Database;
			$load_account->query_data($load_account_sql, $load_account_params, "no", "select_data");
			$row = $load_account->fetch_row;
			
			if($row) {
				$this->account_id = $row['id'];
				$this->account_name = $row['name'];
				$this->account_normal_name = $row['normal_name'];
				$this->account_hash = $row['hash'];
				$this->account_mail = $row['mail'];
				$this->account_mail_verified = $row['mail_verified'];
				$this->account_state = $row['state'];
				$this->account_last_login = $row['last_login'];
				$this->account_created = $row['created'];
				$this->no_data = "No";
			} else {
				$this->no_data = "Yes";
			}
			
		} catch(PDOException $e) {
			die("Failed To Load Account Data");
		}
	}
	
	public function Account_Update($account_id) {
		global $site_logging;
		
		try {
			$update_account_sql = "UPDATE account SET name = :account_name, normal_name = :account_normal_name, mail = :account_mail, last_login = :account_last_login WHERE id = :account_id";
			$update_account_params = array("account_name" => $this->account_name, "account_normal_name" => $this->account_normal_name, "account_mail" => $this->account_mail, "account_last_login" => $this->account_last_login, "account_id" => $this->account_id);
			$update_account = new Database;
			$update_account->query_data($update_account_sql, $update_account_params, "no", NULL);
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die();
		}
		
	}
	
	public function Update_Last_Login($account_id) {
		global $site_logging;
		
		try {
			$update_account_sql = "UPDATE account SET last_login = :account_last_login WHERE id = :account_id";
			$update_account_params = array("account_last_login" => $this->account_last_login, "account_id" => $this->account_id);
			$update_account = new Database;
			$update_account->query_data($update_account_sql, $update_account_params, "no", NULL);
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die();
		}
		
	}
	
	public function Account_Password_Update($account_id) {
		global $site_logging;
		
		try {
			$update_account_sql = "UPDATE account SET hash = :account_hash WHERE id = :account_id";
			$update_account_params = array("account_hash" => $this->account_hash, "account_id" => $this->account_id);
			$update_account = new Database;
			$update_account->query_data($update_account_sql, $update_account_params, "no", NULL);
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die();
		}
		
	}
	
	public function Check_Account($account_name) {
		global $site_logging;
		
		try {
			$check_login_sql = "SELECT id, name, hash FROM account WHERE name = :account_name";
			$check_login_params = array("account_name" => $account_name);
			$check_login = new Database;
			$check_login->query_data($check_login_sql, $check_login_params, "no", "select_data");
			$row = $check_login->fetch_row;
			
			if($row) {
				$this->account_id = $row['id'];
				$this->account_name = $row['name'];
				$this->account_hash = $row['hash'];
			}
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die();
		}
		
	}
	
	public function Check_Email($account_mail) {
		global $site_logging;
		
		try {
			$check_email_sql = "SELECT id, mail FROM account WHERE mail = :account_mail";
			$check_email_params = array("account_mail" => $account_mail);
			$check_email = new Database;
			$check_email->query_data($check_email_sql, $check_email_params, "no", "select_data");
			$row = $check_email->fetch_row;
			
			if($row) {
				$this->account_id = $row['id'];
				$this->account_mail = $row['mail'];
			}
		} catch(PDOException $e) {
			trigger_error($e->getMessage());
			die();
		}
		
	}
	
	public function Account_Register($account_name, $account_password, $account_mail) {
		global $conn_db, $datetime;
		
		//try {
			//Begin Database Transaction
			$register_account_transaction = $conn_db;
			$register_account_transaction->beginTransaction();
			
			//Set Username To Lowercase
			$account_name_lower = strtolower($account_name);
			
			//Register Account Into Database
			$register_account_sql = "INSERT INTO account (name, normal_name, hash, mail, mail_verified, mail_verified_at, state, last_login, created) VALUES (:account_name, :account_normal_name, :account_password, :account_mail, FALSE, :account_verified_at, 1, :account_last_login, :account_created)";
			$register_account_params = array("account_name" => $account_name, "account_normal_name" => $account_name_lower, "account_password" => $account_password, "account_mail" => $account_mail, "account_verified_at" => $datetime, "account_last_login" => $datetime, "account_created" => $datetime);
			$register_account = new Database;
			$register_account->query_data($register_account_sql, $register_account_params, "no", NULL);
			
			$register_account_transaction->commit();
		/*} catch(PDOException $e) {
			$register_account_transaction->rollBack();
			if (str_contains($e->getMessage(), 'invalid input syntax for type integer')) {
				// ignore it
			} else {
				trigger_error($e->getMessage());
				//die();
			}
		}*/
		
	}
	
	public function Account_Delete() {
		
		
	}
	
}

?>