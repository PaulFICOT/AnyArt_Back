<?php

declare(strict_types=1);

namespace App;

use PDO;

class NotificationsDAO extends DbConnection {
    public function getNotificationsByUserId($user_id): array {
        $sth = $this->database->prepare("
            SELECT
                id_notification,
                content,
                is_read,
                crea_date,
                user_id,
                follower_id,
                post_id
            FROM notifications
            WHERE user_id = :user_id
        ");

		$sth->execute([
            ':user_id' => $user_id,
        ]);

        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

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
