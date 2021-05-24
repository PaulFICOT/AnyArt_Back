<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class PictureDAO
 * @package App
 */
class PictureDAO extends DbConnection {
	/**
	 * @param $id int a picture id
	 * @return string the url of the picture
	 */
	public function getUrlById($id): string {
		$sth = $this->database->prepare("
			SELECT picture.url
			FROM picture
			WHERE picture_id = :picture_id
		");
		$sth->execute([':picture_id' => $id]);

		return $sth->fetch(PDO::FETCH_COLUMN) ?: '';
	}

	/**
	 * @param $values array the pictures datas
	 * @return string the id of the freshly inserted picture
	 */
	public function insertPicture($values): string {
		$sth = $this->database->prepare("
			INSERT INTO picture(url, is_thumbnail, thumb_of, user_id, post_id)
			VALUE (:url, :is_thumbnail, :thumb_of, :user_id, :post_id)
		");
		$sth->execute($values);

		return $this->database->lastInsertId();
	}

	/**
	 * @param $url string the new url for the picture
	 * @param $user_id int the user's id
	 */
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

	/**
	 * @param $user_id int the user's id
	 * @return bool if the user have a profile picture
	 */
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
