<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * Class NotificationsDAO
 * @package App
 */
class NotificationsDAO extends DbConnection {
	/**
	 * @param $user_id int a user's id
	 * @return array an array of notifications
	 */
	public function getNotificationsByUserId($user_id): array {
        $sth = $this->database->prepare("
            SELECT
                id_notification,
                content,
                is_read,
                crea_date,
                target_id,
                follower_user_id,
                post_id
            FROM notifications
            WHERE target_id = :target_id
        ");

		$sth->execute([
            ':target_id' => $user_id,
        ]);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

	/**
	 * @param $notification_id int a notification's id
	 * @return bool true
	 */
	public function setReadNotificationById($notification_id): bool {
        $sth = $this->database->prepare("
            UPDATE notifications
            SET is_read = '1'
            WHERE id_notification = :id_notification
        ");

        $sth->execute([
            ':id_notification' => $notification_id,
        ]);

        return true;
    }
}
