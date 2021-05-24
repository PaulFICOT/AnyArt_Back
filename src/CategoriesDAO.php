<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class CategoriesDAO
 * @package App
 */
class CategoriesDAO extends DbConnection {

	/**
	 * @return array all the categories
	 */
	public function getAll() {
		$sth = $this->database->prepare("
		SELECT
			category_id,
			category

		FROM categories
		");
		$sth->execute();

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

}
