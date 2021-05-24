<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class CountriesDAO
 * @package App
 */
class CountriesDAO extends DbConnection {
	/**
	 * @return array all the countries
	 */
	public function getCountries(): array {
        $sth = $this->database->prepare("SELECT * FROM countries");
		$sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $id int a country id
	 * @return array the corresponding countries
	 */
	public function getCountriesById($id): array {
        $sth = $this->database->prepare("SELECT * FROM countries WHERE country_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
