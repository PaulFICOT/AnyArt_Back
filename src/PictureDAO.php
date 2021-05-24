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

	public function updatePicture($url, $user_id) {
		$sth = $this->database->prepare("
			UPDATE
				picture
			SET
				url = :url
			WHERE
				is_thumbnail = 0
            	AND thumb_of IS NULL
				AND user_id = :user_id
				AND post_id IS NULL
		");

		$sth->execute([
			':url' => $url,
			':user_id' => $user_id,
		]);
	}

	public function hasProfilPicture($user_id): bool {
        $sth = $this->database->prepare("
            SELECT
                COUNT(picture_id) AS 'picture_id'
            FROM picture

            WHERE
				is_thumbnail = 0
            	AND thumb_of IS NULL
				AND user_id = :user_id
				AND post_id IS NULL
        ");

        $sth->execute([
			':user_id' => $user_id,
		]);

        return $sth->fetch(PDO::FETCH_ASSOC)['picture_id'] >= 1;
    }
}
