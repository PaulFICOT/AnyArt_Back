<?php

declare(strict_types=1);

namespace App;

use PDO;

class DbConnection {
	public PDO $database;

	public function __construct() {
		$dbhost = $_ENV['DB_HOST'];
		$dbuser = $_ENV['DB_USER'];
		$dbpass = $_ENV['DB_PASS'];
		$dbname = $_ENV['DB_NAME'];
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->database = $dbh;
	}
}
