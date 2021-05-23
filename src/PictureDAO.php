<?php

declare(strict_types=1);

namespace App;

use PDO;

class PictureDAO extends DbConnection {
	public function getCountries(): array {
		$sth = $this->database->prepare("SELECT * FROM countries");
		$sth->execute();

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}
	public function insertPicture($values) {
		$sth = $this->database->prepare("
			INSERT INTO picture(url, is_thumbnail, user_id, post_id)
			VALUE (:url, :is_thumbnail, :user_id, :post_id)
		");
		$sth->execute($values);
	}
}
