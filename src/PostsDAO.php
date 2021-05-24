<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class PostsDAO
 * @package App
 */
class PostsDAO extends DbConnection {

	/**
	 * @param $values array an array containing the post and the user id
	 * @return array the post datas
	 */
	public function getPostAndUserByPostId($values): array {
		$sth = $this->database->prepare("
			SELECT
			 posts.post_id
			,posts.title
			,posts.user_id
			,users.username
			,users.is_verified
			,users.job_function
			,users.open_to_work
			,(SELECT picture.picture_id FROM picture
				WHERE picture.user_id = users.user_id AND picture.post_id IS NULL) 'picture_id'
			,posts.content
			,views.view_count
			,(SELECT COUNT(like_id) FROM posts_like isliked
			WHERE isliked.user_id = :user_id AND isliked.post_id = posts.post_id AND isliked.is_like = TRUE) AS 'isLiked'
			,(SELECT COUNT(like_id) FROM posts_like isdisliked
			WHERE isdisliked.user_id = :user_id AND isdisliked.post_id = posts.post_id AND isdisliked.is_like = FALSE) AS 'isDisliked'
			,(SELECT COUNT(like_id) FROM posts_like likes
				WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
			,(SELECT COUNT(like_id) FROM posts_like dislikes
				WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = FALSE) AS 'dislikes'

			FROM posts

			INNER JOIN users ON (posts.user_id = users.user_id)
			INNER JOIN posts_view views ON (posts.post_id = views.post_id)

			WHERE posts.post_id = :post_id
    	");

		$sth->execute($values);

		return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * @param $keywords string the keywords of the search query
	 * @return array the posts id and their thumbnail
	 */
	public function getThumbnailsResearch($keywords): array {
        $sth = $this->database->prepare("
        SELECT
             p.post_id
            ,p2.picture_id
            FROM users u

        INNER JOIN posts p ON (u.user_id = p.user_id)
        INNER JOIN picture p2 ON (p.post_id = p2.post_id AND p2.is_thumbnail = TRUE)
        INNER JOIN posts_view pv ON (p.post_id = pv.post_id)
        INNER JOIN posts_category_list l on p.post_id = l.post_id
        INNER JOIN categories c3 on l.category_id = c3.category_id
        LEFT JOIN posts_tag t on p.post_id = t.post_id

        GROUP BY p.post_id, u.username, p.title, p2.picture_id, p2.url
        ORDER BY (
            SELECT
                MAX(MATCH(u2.username, u2.job_function) AGAINST(:keywords) +
                    MATCH(p3.title, p3.content) AGAINST (:keywords) +
                    MATCH(c.category) AGAINST(:keywords) +
                    MATCH(pt.tag) AGAINST(:keywords) +
                    MATCH(c2.country) AGAINST(:keywords)
                )
            FROM users u2
            INNER JOIN posts p3 on u2.user_id = p3.user_id
            INNER JOIN posts_category_list pcl on p3.post_id = pcl.post_id
            INNER JOIN categories c on pcl.category_id = c.category_id
            LEFT JOIN posts_tag pt on p3.post_id = pt.post_id
            INNER JOIN countries c2 on u2.country_id = c2.country_id
            WHERE p.post_id = p3.post_id
        ) DESC
        ");

		$sth->execute(array(
            ':keywords' => $keywords));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $filters
	 * @return array
	 */
	public function getThumbnailsUnlogged($filters): array {
		$in  = (!empty($filters) ? str_repeat('?,', count($filters) - 1) . '?' : '');
		$sth = $this->database->prepare("
            SELECT
        		posts.post_id,
                pictures.picture_id
            FROM posts

            INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

            WHERE pictures.is_thumbnail = '1'" .
				(!empty($filters) ? "AND posts.post_id IN (
					SELECT posts_category_list.post_id
					FROM posts_category_list
					WHERE category_id IN ($in)) " : " ")
			. "#ORDER BY RAND()
        ");

		$sth->execute($filters);

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * @param $user_id int a user's id
	 * @return array the thumbnails of a user
	 */
	public function getThumbnailsByUserId($user_id): array {
		$sth = $this->database->prepare("
            SELECT
                posts.post_id,
                pictures.picture_id
            FROM posts

            INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

            WHERE pictures.is_thumbnail = '1' AND posts.user_id = :user_id
        ");
		$sth->execute([':user_id' => $user_id]);

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * @param $id int a user id
	 * @param  array the filters
	 * @return array the thumbnails
	 */
	public function getThumbnailsDiscover($id, $filters): array {
		$in  = (!empty($filters) ? str_repeat('?,', count($filters) - 1) . '?' : '');
        $sth = $this->database->prepare("
        SELECT
				CONCAT_WS(' ', GROUP_CONCAT(DISTINCT c.category SEPARATOR ' '),
				GROUP_CONCAT(DISTINCT pt.tag  SEPARATOR  ' ')) FROM users u
		INNER JOIN posts_like pl on u.user_id = pl.user_id
		INNER JOIN posts_category_list pcl on pl.post_id = pcl.post_id
		INNER JOIN categories c on pcl.category_id = c.category_id
		LEFT JOIN posts_tag pt on pl.post_id = pt.post_id
		WHERE u.user_id = :user
		GROUP BY u.username");
        $sth->execute(array(':user' => $id));
        $keywords = $sth->fetchColumn(0) ?: "";

        $sth = $this->database->prepare("
		SELECT
			p.post_id
			,u.username
			,p.title
			,p2.picture_id
			,p2.url
			,(SELECT MAX(MATCH(u2.username, u2.job_function) AGAINST(?) +
				MATCH(p3.title, p3.content) AGAINST (?) +
				MATCH(c.category) AGAINST(?) +
				MATCH(pt.tag) AGAINST(?) +
				MATCH(c2.country) AGAINST(?))
				FROM users u2
				INNER JOIN posts p3 on u2.user_id = p3.user_id
				INNER JOIN posts_category_list pcl on p3.post_id = pcl.post_id
				INNER JOIN categories c on pcl.category_id = c.category_id
				LEFT JOIN posts_tag pt on p3.post_id = pt.post_id
				INNER JOIN countries c2 on u2.country_id = c2.country_id
				WHERE p.post_id = p3.post_id ) AS RELEVANCE
		FROM users u

		INNER JOIN posts p ON (u.user_id = p.user_id)
		INNER JOIN picture p2 ON (p.post_id = p2.post_id AND p2.is_thumbnail = TRUE)
		INNER JOIN posts_view pv ON (p.post_id = pv.post_id)
		INNER JOIN posts_category_list l on p.post_id = l.post_id
		INNER JOIN categories c3 on l.category_id = c3.category_id
		LEFT JOIN posts_tag t on p.post_id = t.post_id

		WHERE u.user_id <> ?" .
			(!empty($filters) ? "AND p.post_id IN (
				SELECT ll.post_id
				FROM posts_category_list ll
				WHERE category_id IN ($in)) " : " ")
		. "GROUP BY p.post_id, u.username, p.title, p2.picture_id, p2.url

		ORDER BY RELEVANCE DESC;
        ");

		$data = [$keywords, $keywords, $keywords, $keywords, $keywords, $id];
		$sth->execute(array_merge($data, $filters));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $filters array the filters
	 * @return array the thumbnails
	 */
	public function getThumbnailsNewPosts($filters): array {
		$in  = (!empty($filters) ? str_repeat('?,', count($filters) - 1) . '?' : '');
        $sth = $this->database->prepare("
			SELECT
				posts.post_id
				,pictures.picture_id
			FROM posts
				INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

			WHERE
				pictures.is_thumbnail = '1'
			" .
				(!empty($filters) ? "AND posts.post_id IN (
					SELECT posts_category_list.post_id
					FROM posts_category_list
					WHERE category_id IN ($in)) " : " ")
        	. "ORDER BY posts.crea_date
        ");

        $sth->execute($filters);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $filters array the filters
	 * @return array the thumbnails
	 */
	public function getThumbnailsHottests($filters): array {
		$in  = (!empty($filters) ? str_repeat('?,', count($filters) - 1) . '?' : '');
        $sth = $this->database->prepare("
        SELECT
            posts.post_id,
            pictures.picture_id
        FROM posts
            INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

        WHERE pictures.is_thumbnail = '1' " .
			(!empty($filters) ? "AND posts.post_id IN (
				SELECT posts_category_list.post_id
				FROM posts_category_list
				WHERE category_id IN ($in)) " : " ")
        . "ORDER BY (SELECT COUNT(posts_like.like_id) FROM posts_like
            WHERE posts_like.post_id = posts.post_id
            AND DATEDIFF(CURRENT_DATE(), posts_like.crea_date) < 30) DESC
        ");

        $sth->execute($filters);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $filters array the filters
	 * @return array the thumbnail
	 */
	public function getThumbnailsRaising($filters): array {
		$in  = (!empty($filters) ? str_repeat('?,', count($filters) - 1) . '?' : '');
        $sth = $this->database->prepare("
        SELECT
            posts.post_id,
            pictures.picture_id
        FROM posts
        INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)
        INNER JOIN posts_view pv on posts.post_id = pv.post_id

        WHERE pictures.is_thumbnail = '1'" .
			(!empty($filters) ? "AND posts.post_id IN (
				SELECT posts_category_list.post_id
				FROM posts_category_list
				WHERE category_id IN ($in)) " : " ")
        . "ORDER BY IF(DATEDIFF(CURRENT_DATE(), posts.crea_date) < 500, 1, 0) DESC
                ,pv.view_count DESC
        ");

        $sth->execute($filters);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $id int the post id
	 * @return array the category of the post
	 */
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

	/**
	 * @param $id int the post id
	 * @return array the post tags
	 */
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

	/**
	 * @param $id int the post id
	 * @return array the pictures
	 */
	public function getPicturesByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				picture.picture_id,
			   	picture.thumb_of
			FROM picture

			WHERE picture.post_id = :id
			AND thumb_of IS NOT NULL
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * @param $id int the post id
	 * @return array the comments of the post
	 */
	public function getCommentByPostId($id): array {
		$sth = $this->database->prepare("
			SELECT
				 posts.post_id
				,posts_comment.comment_id
				,posts_comment.crea_date
				,posts_comment.user_id
				,users.username
				,(SELECT picture.picture_id FROM picture
				WHERE picture.user_id = users.user_id AND picture.post_id IS NULL) 'picture_id'
				,posts_comment.reply_to
				,posts_comment.content
			FROM posts

			INNER JOIN posts_comment ON (posts.post_id = posts_comment.post_id)
			INNER JOIN users ON (posts_comment.user_id = users.user_id)

			WHERE posts.post_id = :id

			ORDER BY posts_comment.crea_date
		");

		$sth->execute(array(':id' => $id));

		return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}

	/**
	 * @param $values array the comment datas
	 * @return bool true
	 */
	public function newComment($values): bool {
		$sth = $this->database->prepare("
			INSERT INTO posts_comment (content, crea_date, reply_to, user_id, post_id)
 			VALUES (:content, :crea_date, :reply_to, :user_id, :post_id)
		");

		$sth->execute($values);

		return true;
	}

	/**
	 * @param $values array the post id and the user id
	 */
	public function rmOpinion($values) {
		$sth = $this->database->prepare("
			DELETE FROM posts_like
			WHERE user_id = :user_id
			  AND post_id = :post_id
		");

		$sth->execute($values);
	}

	/**
	 * @param $post_id int add a view to a post
	 */
	public function view($post_id) {
		$sth = $this->database->prepare("
			UPDATE posts_view pv
			SET pv.view_count = pv.view_count +1
			WHERE pv.post_id = :post_id
		");

		$sth->execute([':post_id' => $post_id]);
	}

	/**
	 * @param $values array the post_like data
	 */
	public function setOpinion($values) {
		$sth = $this->database->prepare("
			INSERT INTO posts_like(is_like, crea_date, user_id, post_id)
			VALUE (:is_like, :crea_date, :user_id, :post_id)
		");

		$sth->execute($values);
	}

	/**
	 * @param $post_id int the post id
	 * @return array the number of likes and dislikes
	 */
	public function getOpinion($post_id) {
		$sth = $this->database->prepare("
			SELECT is_like, COUNT(*)
			FROM posts_like
			WHERE post_id = :post_id
			GROUP BY is_like;
		");

		$sth->execute([':post_id' => $post_id]);

		return $sth->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
	}

	/**
	 * @param $values array the post id and the user id
	 */
	public function switchOpinion($values) {
		$sth = $this->database->prepare("
			UPDATE posts_like
			SET is_like = NOT is_like
			WHERE post_id = :post_id
			  AND user_id = :user_id
		");

		$sth->execute($values);
	}

	/**
	 * @param $values array the post data
	 * @return string the freshly inserted post id
	 */
	public function createPost($values) {
		$sth = $this->database->prepare("
			INSERT INTO posts(title, content, crea_date, upd_date, user_id)
			VALUE (:title, :desc, :crea_date, :upt_date, :user_id);
		");

		$sth->execute($values);

		return $this->database->lastInsertId();
	}

	/**
	 * @param $post_id int the post id
	 */
	public function initView($post_id) {
		$sth = $this->database->prepare("
			INSERT INTO posts_view(view_count, post_id)
			VALUE (0, :post_id);
		");

		$sth->execute([':post_id' => $post_id]);
	}

	/**
	 * @param $values array the category data
	 */
	public function setCategory($values) {
		$sth = $this->database->prepare("
			INSERT INTO posts_category_list(post_id, category_id)
			VALUE (:post_id, :category_id);
		");

		$sth->execute($values);
	}

	/**
	 * @param $values array the tag data
	 */
	public function setTag($values) {
		$sth = $this->database->prepare("
			INSERT INTO posts_tag(tag, post_id)
			VALUE (:tag, :post_id);
		");

		$sth->execute($values);
	}

	/**
	 * @param $post_id int the post id
	 */
	public function rmPost($post_id) {
		$sth = $this->database->prepare("
			DELETE FROM posts
			WHERE post_id = :post_id
		");

		$sth->execute([':post_id' => $post_id]);
	}
}
