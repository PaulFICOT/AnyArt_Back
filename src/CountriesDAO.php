<?php

declare(strict_types=1);

namespace App;

use PDO;

class CountriesDAO extends DbConnection {
    public function getCountries(): array {
        $sth = $this->database->prepare("SELECT * FROM countries");
		$sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountriesById($id): array {
        $sth = $this->database->prepare("SELECT * FROM countries WHERE country_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
