INSERT INTO posts(title, content, crea_date, upd_date, user_id)
VALUE ('new title', 'new content', '', '', 1);
--Use mysqli_insert_id to get the post id for next queries

INSERT INTO picture(url, is_thumbnail, user_id, post_id)
VALUE ('new url', FALSE, 1, 1);

INSERT INTO posts_view(view_count, post_id)
VALUE (0, 1);

INSERT INTO posts_category_list(post_id, category_id)
VALUE (1, 1);

INSERT INTO posts_tag(tag, post_id)
VALUE ('new tag', 1);