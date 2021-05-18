INSERT INTO users(lastname, firstname, mail, password, birth_date, username, crea_date, upd_date, is_verified,
                  is_active, is_banned, profile_desc, type, job_function, open_to_work, country_id)
VALUE('lastname', 'firstname', 'mail', 'password', '', 'username', '', '', TRUE,
      TRUE, FALSE, 'profile_desc', 'type', 'job_function', FALSE, 1);