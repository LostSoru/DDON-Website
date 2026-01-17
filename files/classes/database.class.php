<?php

class Database {

    public $conn_db;
    public $count_num_rows = 0;
    public $fetch_row;

    public function db_connect($server_host, $server_port, $database_name, $db_user_name, $db_user_password, $db_type, $sqlite_db_path) {
        try {
			if($db_type === 'sqlite') {
				if(!$sqlite_db_path) {
					throw new PDOException("SQLite database path is required");
				}
				$dsn = "sqlite:" . $sqlite_db_path;
				$db_user_name = NULL;
				$db_user_password = NULL;
			} else {
				$dsn = "pgsql:host=$server_host;port=$server_port;dbname=$database_name";
			}
			
			$this->conn_db = new PDO(
				$dsn,
				$db_user_name,
				$db_user_password,
				[
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_EMULATE_PREPARES => true,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				]
			);

        } catch (PDOException $e) {
            echo "<b>Failed To Connect To The Database!</b><br>";
            echo $e->getMessage();
            die();
        }
    }

    public function query_data($sql, $params, $count_rows = "no", $query_type) {
		global $conn_db;
		$this->db = $conn_db;
		
        try {
            $query = $this->db->prepare($sql);
			//$query = $this->conn_db->$sql;

            if ($params) {
                $query->execute($params);
            } else {
                $query->execute();
            }

            // Fetch logic
            if ($query_type === "select_data") {
                $this->fetch_row = $query->fetch();

                if ($count_rows === "yes" && $this->fetch_row) {
                    $this->count_num_rows = 1;
                }

            } elseif ($query_type === "select_all_data") {
                $this->fetch_row = $query->fetchAll();

                if ($count_rows === "yes") {
                    $this->count_num_rows = count($this->fetch_row);
                }

            } elseif ($query_type === "count") {
                $this->fetch_row = $query->fetchColumn();
                $this->count_num_rows = (int)$this->fetch_row;
            }

            $query = null;

        } catch (PDOException $e) {
			if (str_contains($e->getMessage(), 'invalid input syntax for type integer')) {
				// ignore it
			} else {
				echo $e->getMessage();
				//die();
			}
        }
    }
}

?>