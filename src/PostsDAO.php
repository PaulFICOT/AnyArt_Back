<?php

declare(strict_types=1);

namespace App;

use PDO;

class PostsDAO extends DbConnection {
    public function getThumbnails(): array {
        $sth = $this->database->prepare("
            SELECT
                 posts.post_id,
                 pictures.url
            FROM posts

            INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

            WHERE pictures.is_thumbnail = '1'
        ");
		$sth->execute();

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
