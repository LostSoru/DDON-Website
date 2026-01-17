<?php

# MySQL Database Connection Info #
//Your database host, usually localhost
$server_host = "localhost";
//Your database port
$server_port = "5432";
//Your Database Name
$database_name = "your_database_name";
//Your Database Username
$db_user_name = "your_database_username";
//Your Password
$db_user_password = "your_database_password";
//The Database Driver, postgresql or sqlite - default is sqlite since DDON defaults to sqlite
$db_type = "postgresql";
//The Path To Your sqlite.db file (Note) Sqlite requires the webserver have permission to read and write to it
$sqlite_db_path = "";


# Assign The Database Class To A Variable So That A Connection Can Bet Started #
$connect_database = new Database;
$connect_database->db_connect($server_host, $server_port, $database_name, $db_user_name, $db_user_password, $db_type, $sqlite_db_path);
$conn_db = $connect_database->conn_db;
