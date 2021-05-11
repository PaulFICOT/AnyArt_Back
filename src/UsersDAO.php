<?php

declare(strict_types=1);

namespace App;

class UsersDAO extends DbConnection {

    public function getUsers() {
        $sth = $this->database->prepare("SELECT lastname FROM users");
		$sth->execute();

        return $sth->fetchAll();
    }

    public function getUsersById($id) {
        $sth = $this->database->prepare("SELECT lastname FROM users WHERE user_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetchAll();
    }
}
