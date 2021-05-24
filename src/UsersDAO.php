<?php

declare(strict_types=1);

namespace App;

use PDO;
use DateTime;
use DateTimeZone;

/**
 * Class UsersDAO
 * @package App
 */
class UsersDAO extends DbConnection {
	/**
	 * @return array all the users
	 */
	public function getUsers(): array {
        $sth = $this->database->prepare("
            SELECT
                user_id,
                lastname,
                firstname,
                mail,
                birth_date,
                username,
                is_verified,
                is_active,
                is_banned,
                profile_desc,
                type,
                job_function,
                open_to_work,
                country_id,
                donation_link
            FROM users");
		$sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $id int a user id
	 * @return array the user password
	 */
	public function getUsersPasswordById($id): array {
        $sth = $this->database->prepare("
            SELECT
                password
            FROM users
            WHERE user_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $id int the user id
	 * @return array the user data
	 */
	public function getUsersById($id): array {
        $sth = $this->database->prepare("
            SELECT
                user_id,
                lastname,
                firstname,
                mail,
                birth_date,
                username,
                is_verified,
                is_active,
                is_banned,
                profile_desc,
                type,
                job_function,
                open_to_work,
                country_id,
                donation_link,
                (SELECT picture.picture_id FROM picture
                WHERE picture.user_id = users.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_pic,
                (SELECT picture.url FROM picture
                WHERE picture.user_id = users.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_url
            FROM users
            WHERE user_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $email string the user email
	 * @return array the user data
	 */
	public function getUsersByEmail($email): array {
        $sth = $this->database->prepare("
            SELECT
                user_id,
                lastname,
                firstname,
                mail,
                birth_date,
                username,
                is_verified,
                is_active,
                is_banned,
                profile_desc,
                type,
                job_function,
                open_to_work,
                country_id,
                donation_link,
                (SELECT picture.picture_id FROM picture
                WHERE picture.user_id = users.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_pic,
                (SELECT picture.url FROM picture
                WHERE picture.user_id = users.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_url
            FROM users
            WHERE mail = :email");
		$sth->execute(array(':email' => $email));

        return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $user_id int the user id
	 * @return array the user data
	 */
	public function getUserProfileByUserId($user_id): array {
        $sth = $this->database->prepare("
        SELECT
            users1.user_id
            ,users1.username
            ,users1.is_verified
            ,users1.is_active
            ,users1.is_banned
            ,users1.profile_desc
            ,users1.job_function
            ,users1.open_to_work
            ,users1.mail
            ,users1.donation_link
            ,(SELECT picture.picture_id FROM picture
                WHERE picture.user_id = users1.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_pic
            ,(SELECT picture.url FROM picture
                WHERE picture.user_id = users1.user_id AND picture.post_id IS NULL AND picture.thumb_of IS NULL) profile_url
            ,(SELECT COUNT(followed_user_id) FROM users_follower AS users_follower2
                WHERE users_follower2.followed_user_id = users1.user_id) AS 'Followers'
            ,(SELECT SUM(posts_view2.view_count) FROM posts AS posts2
                INNER JOIN posts_view AS posts_view2 ON (posts2.post_id = posts_view2.post_id)
                WHERE posts2.user_id = users1.user_id) AS 'Views'
            ,(SELECT COUNT(posts_like3.like_id) FROM posts AS posts3
                INNER JOIN posts_like AS posts_like3 ON (posts3.post_id = posts_like3.post_id)
                WHERE posts3.user_id = users1.user_id AND posts_like3.is_like = TRUE) AS 'Likes'
            FROM users users1

            WHERE users1.user_id = :user_id
        ");
		$sth->execute([':user_id' => $user_id]);

        return $sth->fetch(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $id int the user id
	 * @param $token string the token to set
	 * @return bool true
	 */
	public function setToken($id, $token): bool {
        $sth = $this->database->prepare("UPDATE users SET token = :token WHERE user_id = :id");
		$sth->execute([
            ':token' => $token,
            ':id' => $id,
        ]);

        return true;
    }

	/**
	 * @param $id int the user id
	 * @param $token string the token to check
	 * @return bool true if the token match
	 */
	public function verifToken($id, $token): bool {
        $sth = $this->database->prepare("SELECT 1 FROM users WHERE user_id = :id AND token = :token LIMIT 1");
        $sth->execute([
            ':id' => $id,
            ':token' => $token,
        ]);

        return $sth->rowCount() == 1;
    }

	/**
	 * @param $follower int the follower user id
	 * @param $followed int the followed user id
	 * @return bool true
	 */
	public function addFollower($follower, $followed): bool {
        $date = new DateTime("now", new DateTimeZone('Europe/Paris'));
        $sth = $this->database->prepare("
            INSERT INTO
                users_follower(crea_date, follower_user_id, followed_user_id)
            VALUE(
                :crea_date
                ,:follower
                ,:follwed
            )
        ");

        $sth->execute([
            ':crea_date' => strval($date->format('Y-m-d H:i:s')),
            ':follower' => $follower,
            ':follwed' => $followed,
        ]);

        return true;
    }

	/**
	 * @param $follower int the follower user id
	 * @param $followed int the followed user id
	 * @return bool true
	 */
	public function removeFollower($follower, $followed): bool {
        $sth = $this->database->prepare("
            DELETE FROM users_follower
            WHERE follower_user_id = :follower AND followed_user_id = :followed
        ");

        $sth->execute([
            ':follower' => $follower,
            ':followed' => $followed,
        ]);

        return true;
    }


	/**
	 * @param $follower int the follower user id
	 * @param $followed int the followed user id
	 * @return bool true if the user is following
	 */
	public function isFollowing($follower, $followed): bool {
        $sth = $this->database->prepare("
            SELECT
                COUNT(follower_id) AS 'is_followed'
            FROM users_follower

            WHERE follower_user_id = :follower
            AND followed_user_id = :followed
        ");

        $sth->execute([
            ':follower' => $follower,
            ':followed' => $followed,
        ]);

        return $sth->fetch(PDO::FETCH_ASSOC)['is_followed'] >= 1;
    }

	/**
	 * @param $user_id int the user id
	 * @param $password string the new password
	 * @return bool true
	 */
	public function modifyUserPassword($user_id, $password): bool {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sth = $this->database->prepare("UPDATE users SET
            `password` = :pwd
            WHERE user_id = :id"
        );

        $sth->execute([
            ':pwd' => $password_hash,
            ':id' => $user_id,
        ]);

        return true;
    }

	/**
	 * @param $user_id int the user id
	 * @param $data array the user data
	 * @return bool true
	 */
	public function modifyUser($user_id, $data): bool {
        $date = new DateTime("now", new DateTimeZone('Europe/Paris'));
        $sth = $this->database->prepare("UPDATE users SET
            lastname = :lastname,
            firstname = :firstname,
            mail = :mail,
            birth_date = :birth_date,
            username = :username,
            upd_date = :upd_date,
            profile_desc = :profile_desc,
            country_id = :country_id,
            donation_link = :donation_link
            WHERE user_id = :id"
        );

        $sth->execute(array(
            ':lastname' => $data['lastname'],
            ':firstname' => $data['firstname'],
            ':mail' => $data['email'],
            ':birth_date' => $data['birthdate'],
            ':username' => $data['username'],
            ':upd_date' => strval($date->format('Y-m-d H:i:s')),
            ':profile_desc' => $data['description'],
            ':country_id' => $data['country'],
            ':donation_link' => $data['donation_link'],
            ':id' => $user_id,
        ));

        return true;
    }

	/**
	 * @param $data array the user data
	 * @return bool true
	 */
	public function createUser($data): bool {
        $pwd = password_hash($data['password'], PASSWORD_DEFAULT);
        $date = new DateTime("now", new DateTimeZone('Europe/Paris'));

        $sth = $this->database->prepare("INSERT INTO users (
            `lastname`,
            `firstname`,
            `mail`,
            `password`,
            `birth_date`,
            `username`,
            `crea_date`,
            `upd_date`,
            `is_verified`,
            `is_active`,
            `is_banned`,
            `profile_desc`,
            `type`,
            `job_function`,
            `open_to_work`,
            `country_id`
            ) VALUES (
                :lastname,
                :firstname,
                :mail,
                :pwd,
                :birth_date,
                :username,
                :date_now,
                :date_now,
                :is_verified,
                :is_active,
                :is_banned,
                :profile_desc,
                :type,
                :job_function,
                :open_to_work,
                :country_id
            )");

        $sth->execute(array(
            ':lastname' => $data['lastName'],
            ':firstname' => $data['firstName'],
            ':mail' => $data['email'],
            ':pwd' => $pwd,
            ':birth_date' => $data['birthDate'],
            ':username' => $data['username'],
            ':date_now' => strval($date->format('Y-m-d H:i:s')),
            ':is_verified' => 0,
            ':is_active' => 1,
            ':is_banned' => 0,
            ':profile_desc' => $data['description'],
            ':type' => 'user',
            ':job_function' => null,
            ':open_to_work' => 0,
            ':country_id' => $data['country']
        ));

        return true;
    }
}
