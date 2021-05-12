<?php

declare(strict_types=1);

namespace App;

use PDO;
use DateTime;
use DateTimeZone;

class UsersDAO extends DbConnection {
    public function getUsers(): array {
        $sth = $this->database->prepare("SELECT * FROM users");
		$sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersById($id): array {
        $sth = $this->database->prepare("SELECT * FROM users WHERE user_id = :id");
		$sth->execute(array(':id' => $id));

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsersByEmail($email): array {
        $sth = $this->database->prepare("SELECT * FROM users WHERE mail = :email");
		$sth->execute(array(':email' => $email));

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

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
