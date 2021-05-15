<?php

declare(strict_types=1);

namespace App;

use PDO;

class PostsDAO extends DbConnection {

	public function getPostAndUserByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				 posts.post_id
				,posts.title
				,posts.user_id
				,users.username
				,users.is_verified
				,users.job_function
				,users.open_to_work
				,picture.picture_id
				,picture.url
				,posts.content
				,views.view_count
				,(SELECT COUNT(like_id) FROM posts_like likes
					WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
				,(SELECT COUNT(like_id) FROM posts_like dislikes
					WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = FALSE) AS 'dislikes'

			FROM posts

			INNER JOIN users ON (posts.user_id = users.user_id)
			INNER JOIN posts_view views ON (posts.post_id = views.post_id)
			INNER JOIN picture ON (users.user_id = picture.user_id AND picture.post_id IS NULL)

			WHERE
				posts.post_id = 2
    	");

		$sth->execute(array(':id' => $id));

		return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
	}

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

	public function getCategoriesByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
			posts.post_id,
			categories.category_id,
			categories.category

			FROM posts

			INNER JOIN posts_category_list ON (posts.post_id = posts_category_list.post_id)
			INNER JOIN categories ON (posts_category_list.category_id = categories.category_id)

			WHERE posts.post_id = :id
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
	}

	public function getTagsByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				 posts.post_id,
				posts_tag.tag_id,
				posts_tag.tag

			FROM posts

			INNER JOIN posts_tag ON (posts.post_id = posts_tag.post_id)

			WHERE posts.post_id = :id
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getPicturesByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				 posts.post_id,
				 pictures.picture_id,
				 pictures.url
			FROM posts

			INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

			WHERE posts.post_id = :id
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	public function getCommentByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				 posts.post_id
				,posts_comment.comment_id
				,posts_comment.crea_date
				,posts_comment.user_id
				,users.username
				,picture.picture_id
				,picture.url
				,posts_comment.reply_to
				,posts_comment.content
			FROM posts

			INNER JOIN posts_comment ON (posts.post_id = posts_comment.post_id)
			INNER JOIN users ON (posts.user_id = users.user_id)
			INNER JOIN picture ON (users.user_id = picture.user_id AND picture.post_id IS NULL)

			WHERE posts.post_id = :id

			ORDER BY posts_comment.crea_date
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}
}
