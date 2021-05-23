<?php

declare(strict_types=1);

namespace App;

use PDO;

class PictureDAO extends DbConnection {
	public function getUrlById($id): string {
		$sth = $this->database->prepare("
			SELECT picture.url
			FROM picture
			WHERE picture_id = :picture_id
		");
		$sth->execute([':picture_id' => $id]);

		return $sth->fetch(PDO::FETCH_COLUMN) ?: '';
	}
	public function insertPicture($values): string {
		$sth = $this->database->prepare("
			INSERT INTO picture(url, is_thumbnail, thumb_of, user_id, post_id)
			VALUE (:url, :is_thumbnail, :thumb_of, :user_id, :post_id)
		");
		$sth->execute($values);

		return $this->database->lastInsertId();
	}
}
