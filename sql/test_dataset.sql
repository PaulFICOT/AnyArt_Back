INSERT INTO countries(country) VALUES
('France'),
('UK'),
('USA');

INSERT INTO users_chat(crea_date, upd_date) VALUES
('20120618 10:34:09 AM', '20150618 10:34:09 PM'),
('20130618 10:34:09 AM', '20160618 10:34:09 PM'),
('20140618 10:34:09 AM', '20170618 10:34:09 PM');

INSERT INTO payment_method(name) VALUES
('CB'),
('Espèce');

INSERT INTO posts(title, content, crea_date, upd_date) VALUES
('post1', 'content1', '20140625 10:34:09 AM', '20170625 10:34:09 PM'),
('post2', 'content2', '20140625 10:34:09 AM', '201706125 10:34:09 PM');

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
('FICOT', 'Paul', 'paul.ficot@anyart.com', '123', '1999-03-10', 'pfi', '20000310 10:20:30 AM', '20200825 10:34:09 PM',
 true, true, false, 'Desc PFI', 'admin', 'Job PFI', false, 1),
('DUBUC', 'Romain', 'romain.dubuc@anyart.com', 'root', '199-01-14', 'rdu', '20000114 10:20:30 AM', '20200125 10:20:30 PM',
 true, true, false, 'Desc RDU', 'enduser', 'Job RDU', true, 2);


INSERT INTO users_follower(crea_date, follower_id, followed_user_id) VALUES
('20140625 10:34:09 AM', 1, 2),
('20160625 10:34:09 AM', 2, 1);


INSERT INTO users_donation(crea_date, message, donator_id, receiver_id, payment_method_id) VALUES
('20140625 10:34:09 AM', 'Donation1', 1, 2, 1),
('20140626 10:34:09 AM', 'Donation2', 1, 2, 2);

INSERT INTO picture(url, user_id, post_id) VALUES
('bfkdthtte', 1, 1),
('qsok64ytj', 2, 2),
('5kykywug7', 2, 2);