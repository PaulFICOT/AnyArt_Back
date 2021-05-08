INSERT INTO countries(country) VALUES
('France'),
('UK'),
('USA');

INSERT INTO users_chat(crea_date, upd_date) VALUES
('2020-01-01 10:10:10+05:30', '2021-01-01 10:10:10+01:00'),
('2020-01-01 10:10:10+05:30', '2021-01-01 10:10:10+02:00');

INSERT INTO payment_method(name) VALUES
('CB'),
('Espèce');

INSERT INTO posts(title, content, crea_date, upd_date) VALUES
('post1', 'content1', '2020-01-01 10:10:10+01:00', '2021-01-01 10:10:10+01:00'),
('post2', 'content2', '2020-01-03 10:10:10+01:00', '2021-01-03 10:10:10+01:00');

INSERT INTO categories(category) VALUES
('Dessin'),
('Street art'),
('Peinture');

INSERT INTO posts_tag(tag, post_id) VALUES
('crayon', 1),
('feutre', 1),
('peinture a l\huile', 2);

INSERT INTO posts_view(view_count, post_id) VALUES
(256, 1),
(313, 2);

INSERT INTO users(lastname, firstname, mail, password, birth_date,username, crea_date, upd_date, is_verified,
                  is_active, is_banned, profile_desc, type, job_function, open_to_work, country_id) VALUES
('FICOT', 'Paul', 'paul.ficot@anyart.com', '123', '1999-03-10', 'pfi', '2014-01-01 10:10:10+01:00', '2020-03-03 10:10:10+01:00',
 true, true, false, 'Desc PFI', 'admin', 'Job PFI', false, 1),
('DUBUC', 'Romain', 'romain.dubuc@anyart.com', 'root', '199-01-14', 'rdu', '2015-01-01 10:10:10+01:00', '2020-01-05 10:10:10+01:00',
 true, true, false, 'Desc RDU', 'enduser', 'Job RDU', true, 2);

INSERT INTO users_follower(crea_date, follower_user_id, followed_user_id) VALUES
('2015-01-01 10:10:10+01:00', 1, 2),
('2016-01-01 10:10:10+01:00', 2, 1);

INSERT INTO users_donation(crea_date, message, donator_id, receiver_id, payment_method_id) VALUES
('2018-01-01 10:10:10+01:00', 'Donation1', 1, 2, 1),
('2019-01-01 10:10:10+01:00', 'Donation2', 1, 2, 2);

INSERT INTO picture(url, user_id, post_id) VALUES
('bfkdthtte', 1, 1),
('qsok64ytj', 2, 2),
('5kykywug7', 2, 2);

INSERT INTO posts_comment(content, crea_date, user_id, post_id) VALUES
('comment1', '2021-01-01 10:10:10+01:00', 1, 1),
('comment2', '2021-01-01 10:10:10+01:00', 1, 2),
('comment3', '2021-01-01 10:10:10+01:00', 2, 1);

INSERT INTO posts_like(is_like, crea_date, user_id, post_id) VALUES
(true, '2021-01-01 10:10:10+01:00', 1, 1),
(true, '2021-01-01 10:10:10+01:00', 2, 1),
(false, '2021-01-01 10:10:10+01:00', 1, 2);

INSERT INTO posts_category_list(post_id, category_id) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 3);

INSERT INTO users_chat_list(user_id, chat_id) VALUES
(1, 1),
(2, 1);