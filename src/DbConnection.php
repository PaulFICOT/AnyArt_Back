<?php

declare(strict_types=1);

namespace App;

use PDO;

class DbConnection {
    public PDO $database;

    public function __construct() {
        $dbhost="localhost";
        $dbuser="root";
        $dbpass="root";
        $dbname="anyart";
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->database = $dbh;
	}
}
