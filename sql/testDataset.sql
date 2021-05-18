INSERT INTO countries(country)
VALUES ('France'),
    ('UK'),
    ('USA');
INSERT INTO payment_method(name)
VALUES ('CB'),
    ('PayPal');
INSERT INTO categories(category)
VALUES ('Dessin'),
    ('Street art'),
    ('Peinture');
INSERT INTO users(
        lastname,
        firstname,
        mail,
        password,
        birth_date,
        username,
        crea_date,
        upd_date,
        is_verified,
        is_active,
        is_banned,
        profile_desc,
        type,
        job_function,
        open_to_work,
        country_id
    )
VALUES (
        'FICOT',
        'Paul',
        'paul.ficot@anyart.com',
        '123',
        '1999-03-10',
        'pfi',
        '2014-01-01 10:10:10+01:00',
        '2020-03-03 10:10:10+01:00',
        TRUE,
        TRUE,
        FALSE,
        'Desc PFI',
        'admin',
        'Job PFI',
        FALSE,
        1
    ),
    (
        'DUBUC',
        'Romain',
        'romain.dubuc@anyart.com',
        'root',
        '1999-01-14',
        'rdu',
        '2015-01-01 10:10:10+01:00',
        '2020-01-05 10:10:10+01:00',
        TRUE,
        TRUE,
        FALSE,
        'Desc RDU',
        'enduser',
        'Job RDU',
        TRUE,
        2
    ),
    (
        'Joy',
        'Camacho',
        'vel.nisl@vitaediamProin.ca',
        'Kadeem Cervantes',
        '1997-07-19',
        'JoyCamacho',
        '2018-07-17 10:26:32',
        '2021-03-06 14:55:20',
        TRUE,
        FALSE,
        FALSE,
        'placerat velit. Quisque varius. Nam porttitor scelerisque neque.',
        'enduser',
        'Commodo Institute',
        FALSE,
        3
    ),
    (
        'Hanna',
        'Mayer',
        'quam.vel@quis.org',
        'Guy Navarro',
        '1995-07-05',
        'HannaMayer',
        '2019-12-18 00:33:02',
        '2020-10-12 21:37:17',
        TRUE,
        FALSE,
        FALSE,
        'Aliquam fringilla cursus purus. Nullam scelerisque neque sed',
        'enduser',
        'Ornare Sagittis Felis Limited',
        FALSE,
        3
    ),
    (
        'Leo',
        'Jennings',
        'semper.et@Duis.edu',
        'Sage Richardson',
        '1007-01-19',
        'LeoJennings',
        '2019-10-13 05:17:35',
        '2020-06-15 19:32:30',
        TRUE,
        TRUE,
        FALSE,
        'ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem,',
        'enduser',
        'Eu Accumsan Corp.',
        TRUE,
        3
    ),
    (
        'Ella',
        'Benton',
        'metus.Vivamus.euismod@consequat.com',
        'Eden Bolton',
        '1986-01-29',
        'EllaBenton',
        '2019-06-07 16:16:01',
        '2020-11-30 03:56:27',
        TRUE,
        TRUE,
        FALSE,
        'lobortis augue scelerisque mollis. Phasellus libero',
        'enduser',
        'Eu Placerat Eget Corporation',
        TRUE,
        1
    ),
    (
        'Colin',
        'Wood',
        'dis.parturient@necquam.net',
        'August Le',
        '1992-04-23',
        'ColinWood',
        '2019-08-31 03:15:08',
        '2020-11-13 00:33:33',
        TRUE,
        FALSE,
        FALSE,
        'sagittis placerat. Cras dictum ultricies ligula.',
        'enduser',
        'Ut Odio Foundation',
        TRUE,
        1
    ),
    (
        'Desiree',
        'Kaufman',
        'ipsum.Curabitur.consequat@ante.org',
        'Iris Abbott',
        '1990-05-08',
        'DesireeKaufman',
        '2019-04-03 04:05:49',
        '2020-07-27 19:21:11',
        TRUE,
        FALSE,
        FALSE,
        'Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper',
        'enduser',
        'Vestibulum Associates',
        FALSE,
        1
    ),
    (
        'Dawn',
        'Rivers',
        'porttitor.eros@nuncsedpede.org',
        'Chastity Fitzpatrick',
        '2000-02-18',
        'DawnRivers',
        '2018-10-22 21:03:12',
        '2020-06-11 08:00:02',
        TRUE,
        TRUE,
        FALSE,
        'mi pede, nonummy ut, molestie in, tempus eu,',
        'enduser',
        'Dui Semper Industries',
        FALSE,
        3
    ),
    (
        'Scarlet',
        'Baker',
        'vitae.velit.egestas@cursusa.edu',
        'Knox Schmidt',
        '1975-08-11',
        'ScarletBaker',
        '2020-01-11 21:26:30',
        '2021-01-09 04:19:42',
        TRUE,
        TRUE,
        FALSE,
        'Nulla eu neque pellentesque massa',
        'enduser',
        'Lobortis Class Company',
        FALSE,
        1
    ),
    (
        'Dieter',
        'Riggs',
        'dolor.dolor.tempus@Loremipsum.org',
        'Colin Terry',
        '1980-06-07',
        'DieterRiggs',
        '2018-05-30 04:57:32',
        '2021-04-30 08:53:54',
        FALSE,
        FALSE,
        TRUE,
        'dui quis accumsan convallis, ante lectus convallis est, vitae',
        'enduser',
        'A Aliquet Vel Foundation',
        TRUE,
        3
    ),
    (
        'Mollie',
        'Lewis',
        'quam.vel@temporest.com',
        'Ulysses Conner',
        '1997-08-25',
        'MollieLewis',
        '2018-08-26 03:09:23',
        '2020-05-22 01:43:23',
        TRUE,
        FALSE,
        FALSE,
        'at arcu. Vestibulum ante ipsum primis in faucibus orci luctus',
        'enduser',
        'Vulputate Risus LLP',
        FALSE,
        2
    ),
    (
        'Preston',
        'Crosby',
        'sed@cursusluctus.net',
        'Glenna Barlow',
        '1973-05-01',
        'PrestonCrosby',
        '2019-11-17 18:01:09',
        '2021-04-09 20:06:04',
        TRUE,
        FALSE,
        FALSE,
        'rutrum urna, nec luctus felis purus ac tellus. Suspendisse',
        'enduser',
        'Odio Inc.',
        FALSE,
        1
    ),
    (
        'Fiona',
        'Barron',
        'ut.ipsum.ac@eleifendvitae.org',
        'Kylan Gill',
        '1999-12-18',
        'FionaBarron',
        '2018-07-16 04:05:20',
        '2020-09-05 11:39:09',
        TRUE,
        FALSE,
        FALSE,
        'Quisque varius. Nam porttitor scelerisque',
        'enduser',
        'Nec Ante Maecenas Corp.',
        TRUE,
        1
    ),
    (
        'Matthew',
        'Flowers',
        'risus.Nunc.ac@ipsum.org',
        'Ulla Sims',
        '1995-12-16',
        'MatthewFlowers',
        '2018-05-23 13:34:38',
        '2021-02-09 22:52:01',
        FALSE,
        FALSE,
        TRUE,
        'felis purus ac tellus. Suspendisse sed dolor. Fusce',
        'enduser',
        'Enim Suspendisse Corporation',
        FALSE,
        3
    ),
    (
        'Nolan',
        'Woodward',
        'Aliquam.ultrices.iaculis@Pellentesqueultriciesdignissim.co.uk',
        'Brenden Clemons',
        '1998-05-16',
        'NolanWoodward',
        '2018-08-09 22:57:16',
        '2020-10-11 02:40:19',
        TRUE,
        TRUE,
        FALSE,
        'ipsum ac mi eleifend egestas.',
        'enduser',
        'Tempus Non Foundation',
        TRUE,
        2
    ),
    (
        'Chandler',
        'Talley',
        'sodales@inaliquet.ca',
        'Hashim Payne',
        '1976-07-20',
        'ChandlerTalley',
        '2018-12-20 20:05:12',
        '2021-05-13 18:32:13',
        TRUE,
        FALSE,
        FALSE,
        'Suspendisse eleifend. Cras sed leo. Cras',
        'enduser',
        'Ante Iaculis Nec Consulting',
        FALSE,
        3
    ),
    (
        'Vestil',
        'Sacha',
        'Vivamus@Etiam.com',
        'Bad Vilts',
        '1997-01-21',
        'VestilSacha',
        '2020-08-05 05:16:44',
        '2021-10-05 11:38:15',
        TRUE,
        FALSE,
        FALSE,
        'sodales at, velit. Nam consequat dolor vitae dolor. Aliquam',
        'enduser',
        'Namoa Inc',
        FALSE,
        3
    ),
    (
        'Chase',
        'Martin',
        'Tan@arbre.com',
        'Tad Giles',
        '1994-01-21',
        'ChaseMartin',
        '2019-08-05 05:26:45',
        '2020-10-05 10:38:28',
        TRUE,
        TRUE,
        FALSE,
        'sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam',
        'enduser',
        'Magna Foundation',
        FALSE,
        3
    ),
    (
        'Jenette',
        'Dunn',
        'Donec@Morbi.com',
        'Lilah Barton',
        '1998-04-19',
        'JenetteDunn',
        '2019-01-28 19:33:59',
        '2020-07-30 06:24:48',
        TRUE,
        FALSE,
        FALSE,
        'ante. Vivamus non lorem vitae odio',
        'enduser',
        'Mauris Eu Turpis Inc.',
        TRUE,
        3
    );
INSERT INTO users_follower(crea_date, follower_user_id, followed_user_id)
VALUES ('2015-01-01 10:10:10+01:00', 1, 2),
    ('2016-01-01 10:10:10+01:00', 2, 1);
INSERT INTO users_message(message, is_deleted, sender_id, receiver_id)
VALUES ('Message1', FALSE, 1, 2),
    ('Message2', FALSE, 2, 1);
INSERT INTO users_donation(
        crea_date,
        message,
        donator_id,
        receiver_id,
        payment_method_id
    )
VALUES (
        '2018-01-01 10:10:10+01:00',
        'Donation1',
        1,
        2,
        1
    ),
    (
        '2019-01-01 10:10:10+01:00',
        'Donation2',
        1,
        2,
        2
    );
INSERT INTO posts(title, content, crea_date, upd_date, user_id)
VALUES (
        'post1',
        'content1',
        '2020-01-01 10:10:10+01:00',
        '2021-01-01 10:10:10+01:00',
        1
    ),
    (
        'post2',
        'content2',
        '2020-01-03 10:10:10+01:00',
        '2021-01-03 10:10:10+01:00',
        2
    ),
    (
        'feugiat',
        'non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum.',
        '2019-07-12 11:21:42',
        '2020-08-12 17:49:27',
        5
    ),
    (
        'leo.',
        'elit fermentum risus, at fringilla purus mauris',
        '2020-03-07 11:58:15',
        '2020-07-01 09:08:13',
        4
    ),
    (
        'Ut',
        'ornare. Fusce mollis. Duis sit amet diam eu',
        '2019-12-18 03:04:28',
        '2020-05-25 10:42:44',
        3
    ),
    (
        'malesuada',
        'Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique',
        '2020-06-04 03:29:54',
        '2020-09-24 05:11:51',
        6
    ),
    (
        'enim,',
        'tempor diam dictum sapien. Aenean massa. Integer',
        '2019-05-20 03:25:20',
        '2021-01-27 08:49:38',
        2
    ),
    (
        'pede.',
        'ullamcorper, nisl arcu iaculis enim, sit amet',
        '2019-06-14 02:46:24',
        '2020-09-13 03:37:36',
        4
    ),
    (
        'penatibus',
        'Morbi metus. Vivamus euismod urna. Nullam',
        '2020-10-15 22:34:00',
        '2020-11-10 03:54:00',
        5
    ),
    (
        'sem.',
        'neque et nunc. Quisque ornare',
        '2020-09-05 14:49:05',
        '2021-02-24 14:04:08',
        3
    ),
    (
        'placerat',
        'cursus et, magna. Praesent interdum ligula eu enim.',
        '2020-08-16 01:35:56',
        '2021-04-08 00:43:40',
        6
    ),
    (
        'nisi.',
        'luctus et ultrices posuere cubilia Curae; Phasellus',
        '2020-05-27 09:06:15',
        '2020-11-17 06:52:33',
        7
    ),
    (
        'eu,',
        'eget, venenatis a, magna. Lorem ipsum dolor',
        '2020-08-29 18:14:33',
        '2020-10-29 21:20:21',
        6
    ),
    (
        'mauris,',
        'arcu. Nunc mauris. Morbi non sapien molestie',
        '2019-07-10 11:30:24',
        '2020-10-31 09:26:50',
        4
    ),
    (
        'vulputate',
        'ornare. Fusce mollis. Duis sit',
        '2019-09-04 15:57:55',
        '2020-09-24 21:56:17',
        6
    ),
    (
        'orci,',
        'dui lectus rutrum urna, nec luctus felis purus ac tellus.',
        '2020-02-22 22:31:36',
        '2021-08-06 09:20:50',
        2
    ),
    (
        'Pellentesque',
        'mauris, aliquam eu, accumsan sed,',
        '2020-07-07 07:24:10',
        '2020-09-07 18:46:59',
        4
    ),
    (
        'Class',
        'eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec',
        '2020-04-04 02:16:57',
        '2021-10-20 01:07:21',
        2
    ),
    (
        'Vestibulum',
        'placerat eget, venenatis a, magna. Lorem ipsum',
        '2021-04-05 07:24:08',
        '2021-05-17 07:08:45',
        9
    ),
    (
        'consequat',
        'Curabitur egestas nunc sed libero. Proin sed',
        '2020-08-14 04:44:53',
        '2021-08-01 05:38:37',
        7
    );
INSERT INTO posts_comment(content, crea_date, reply_to, user_id, post_id)
VALUES (
        'comment1',
        '2021-01-01 10:10:10+01:00',
        NULL,
        1,
        2
    ),
    ('comment2', '2021-01-01 10:10:10+01:00', 1, 1, 2),
    (
        'comment3',
        '2021-01-01 10:10:10+01:00',
        NULL,
        2,
        1
    );
INSERT INTO posts_like(is_like, crea_date, user_id, post_id)
VALUES (TRUE, '2021-01-01 10:10:10+01:00', 1, 1),
    (TRUE, '2021-02-01 10:10:10+01:00', 2, 1),
    (TRUE, '2021-03-01 10:10:10+01:00', 2, 3),
    (TRUE, '2021-04-01 10:10:10+01:00', 2, 4),
    (TRUE, '2021-05-01 10:10:10+01:00', 2, 5),
    (TRUE, '2021-05-02 10:10:10+01:00', 2, 6),
    (TRUE, '2021-05-03 10:10:10+01:00', 2, 20),
    (FALSE, '2021-05-05 10:10:10+01:00', 1, 2);
INSERT INTO posts_tag(tag, post_id)
VALUES ('crayon', 1),
    ('feutre', 1),
    ('peinture a l\'huile', 2),
    ('crayon', 3),
    ('vector', 4),
    ('peinture a l\'huile', 5),
    ('crayon', 6),
    ('photoshop', 6),
    ('peinture a l\'huile', 7),
    ('dessin', 8),
    ('crayon de couleur', 9),
    ('peinture a l\'eau', 10),
    ('crayon', 11),
    ('feutre a souffler', 11),
    ('peinture a l\'eau', 12),
    ('fresque', 13),
    ('webdesign', 14),
    ('peinture a l\'eau', 15),
    ('aquarel', 16),
    ('gouache', 17),
    ('feutre', 17),
    ('fusain', 18),
    ('encre de chine', 19),
    ('bombe de peinture', 20),
    ('street art', 20);
INSERT INTO posts_view(view_count, post_id)
VALUES (256, 1),
    (313, 2),
    (9658, 3),
    (356, 4),
    (2747, 5),
    (27, 6),
    (921, 7),
    (123, 8),
    (164, 9),
    (178, 10),
    (578, 11),
    (7234, 12),
    (987, 13),
    (989, 14),
    (865, 15),
    (643, 16),
    (978, 17),
    (745, 18),
    (624, 19),
    (663, 20);
INSERT INTO picture(url, is_thumbnail, user_id, post_id)
VALUES  ('KfPwby-UisA', FALSE, 1, NULL),
    ('9giow4jXrzM', FALSE, 2, NULL),
    ('KGiQFgF7dkc', FALSE, 3, NULL),
    ('0p0lVOLdVmg', FALSE, 4, NULL),
    ('IFxjDdqK_0U', FALSE, 5, NULL),
    ('RCfi7vgJjUY', FALSE, 6, NULL),
    ('fZ8uf_L52wg', FALSE, 7, NULL),
    ('LEpfefQf4rU', FALSE, 8, NULL),
    ('FilM6ng7VGQ', FALSE, 9, NULL),
    ('1hBWrLIDSCc', FALSE, 10, NULL),
    ('g3B53PbBfwU', FALSE, 11, NULL),
    ('rplhB9mYF48', FALSE, 12, NULL),
    ('0TPAlZ87mzk', FALSE, 13, NULL),
    ('HN3-ehlNwsc', FALSE, 14, NULL),
    ('TKgOIwPVmkg', FALSE, 15, NULL),
    ('-vcg9-w_yMk', FALSE, 16, NULL),
    ('EOIL6hBE8tg', FALSE, 17, NULL),
    ('Ah_QC2v2alE', FALSE, 18, NULL),
    ('_AHEpAdR8Xo', FALSE, 19, NULL),
    ('o6RbK3y7mK4', FALSE, 20, NULL),
    ('GtwiBmtJvaU', TRUE, 1, 1),
    ('xadzcCQZ_Xc', TRUE, 2, 2),
    ('E9kVmtiqqGE', FALSE, 2, 2),
    ('gKXKBY-C-Dk', TRUE, 5, 3),
    ('_b020HIGZUE', FALSE, 5, 3),
    ('I-rgDPLKogs', FALSE, 5, 3),
    ('rW-I87aPY5Y', TRUE, 4, 4),
    ('CVS4kWJaYLs', FALSE, 4, 4),
    ('mJaD10XeD7w', TRUE, 3, 5),
    ('fVNyjet1CXY', FALSE, 3, 5),
    ('VwqecUsYKvs', FALSE, 3, 5),
    ('Tn8DLxwuDMA', TRUE, 6, 6),
    ('l5truYNKmm8', FALSE, 6, 6),
    ('7GX5aICb5i4', TRUE, 2, 7),
    ('YKCwVVF5PxM', FALSE, 2, 7),
    ('dB-uKPloTrg', FALSE, 2, 7),
    ('fEK4jvgnApg', FALSE, 2, 7),
    ('OzAeZPNsLXk', TRUE, 4, 8),
    ('vVaRqEeb_Ss', FALSE, 4, 8),
    ('etD6B-gRhWc', FALSE, 4, 8),
    ('9UUoGaaHtNE', TRUE, 5, 9),
    ('153_VPk1NZQ', FALSE, 5, 9),
    ('w2DsS-ZAP4U', TRUE, 3, 10),
    ('OU3mzYkIRJc', FALSE, 3, 10),
    ('2KZfAwi-0W4', FALSE, 3, 10),
    ('cWOzOnSoh6Q', TRUE, 6, 11),
    ('7E9qvMOsZEM', FALSE, 6, 11),
    ('nKC772R_qog', TRUE, 7, 12),
    ('lSXQOeWUb9E', FALSE, 7, 12),
    ('IuJc2qh2TcA', TRUE, 6, 13),
    ('fREiGY_l2Ok', FALSE, 6, 13),
    ('dQ5G0h7sLno', TRUE, 4, 14),
    ('5sGjkpNDmLI', FALSE, 4, 14),
    ('0wEiUkBqIdU', FALSE, 4, 14),
    ('13ky5Ycf0ts', TRUE, 6, 15),
    ('HW_6USwudbo', FALSE, 6, 15),
    ('so5nsYDOdxw', TRUE, 2, 16),
    ('NodtnCsLdTE', TRUE, 4, 17),
    ('uhnbTZC7N9k', FALSE, 4, 17),
    ('SAKLELG-pO8', FALSE, 4, 17),
    ('C0zDWAPFT9A', FALSE, 4, 17),
    ('ZsSmtgg1U8E', FALSE, 4, 17),
    ('EWsd0dlKsy0', FALSE, 4, 17),
    ('Hd7vwFzZpH0', TRUE, 2, 18),
    ('0apwACX-W2Y', FALSE, 2, 18),
    ('OE7H8Zp1mw8', FALSE, 2, 18),
    ('0F7GRXNOG7g', TRUE, 9, 19),
    ('J7rRzjba-kY', FALSE, 9, 19),
    ('GNVn_4bC2kk', FALSE, 9, 19),
    ('xulIYVIbYIc', TRUE, 7, 20),
    ('psPEo8Cgh7U', FALSE, 7, 20),
    ('EcsCeS6haJ8', FALSE, 7, 20),
    ('ppKcYi1CXcI', FALSE, 7, 20);
INSERT INTO posts_category_list(post_id, category_id)
VALUES (1, 1),
    (1, 2),
    (1, 3),
    (2, 2),
    (2, 3),
    (3, 2),
    (3, 3),
    (3, 1),
    (4, 2),
    (4, 3),
    (5, 2),
    (6, 2),
    (7, 3),
    (7, 2),
    (8, 2),
    (8, 3),
    (9, 2),
    (10, 1),
    (10, 2),
    (11, 1),
    (11, 2),
    (11, 3),
    (12, 2),
    (12, 3),
    (13, 2),
    (13, 3),
    (13, 1),
    (14, 2),
    (14, 3),
    (15, 2),
    (16, 2),
    (17, 3),
    (17, 2),
    (18, 2),
    (18, 3),
    (19, 2),
    (20, 1),
    (20, 2);