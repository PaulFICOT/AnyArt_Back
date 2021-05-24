DELIMITER $$
CREATE TRIGGER new_post
    AFTER INSERT
    ON posts
    FOR EACH ROW
BEGIN
    INSERT INTO notifications(content, is_read, crea_date, target_id, follower_user_id, follower_id, post_id)
    SELECT CONCAT(users.username, ' has published new pictures'),
           false,
           NOW(),
           users_follower.follower_user_id,
           null,
           null,
           NEW.post_id
    FROM posts
             INNER JOIN users ON posts.user_id = users.user_id
             INNER JOIN users_follower ON users_follower.followed_user_id = NEW.user_id
    WHERE posts.post_id = NEW.post_id;
END $$
CREATE TRIGGER new_follow
    AFTER INSERT
    ON users_follower
    FOR EACH ROW
BEGIN
    INSERT INTO notifications(content, is_read, crea_date, target_id, follower_user_id, follower_id, post_id)
    SELECT CONCAT(users.username, ' is now following you !'),
           false,
           NOW(),
           NEW.followed_user_id,
           NEW.follower_user_id,
           NEW.follower_id,
           null
    FROM users_follower
             INNER JOIN users ON users_follower.follower_user_id = users.user_id
    WHERE users_follower.follower_id = NEW.follower_id;
END $$
CREATE TRIGGER new_comment
    AFTER INSERT
    ON posts_comment
    FOR EACH ROW
BEGIN
    IF NEW.reply_to IS NULL THEN
        INSERT INTO notifications(content, is_read, crea_date, target_id, follower_user_id, follower_id, post_id)
        SELECT CONCAT(users.username, ' commented on your post !'),
               false,
               NOW(),
               posts.user_id,
               null,
               null,
               NEW.post_id
        FROM posts_comment
                 INNER JOIN users ON posts_comment.user_id = users.user_id
                 INNER JOIN posts ON posts_comment.post_id = posts.post_id
        WHERE posts_comment.comment_id = NEW.comment_id;
    END IF;
END $$
CREATE TRIGGER reply_comment
    AFTER
        INSERT
    ON posts_comment
    FOR EACH ROW
BEGIN
    IF NEW.reply_to IS NOT NULL THEN
        INSERT INTO notifications(content,
                                  is_read,
                                  crea_date,
                                  target_id,
                                  follower_user_id,
                                  follower_id,
                                  post_id)
        SELECT CONCAT(
                       users.username,
                       ' replied to your comment.'
                   ),
               false,
               NOW(),
               reply_comment.user_id,
               null,
               null,
               NEW.post_id
        FROM posts_comment
                 INNER JOIN users ON posts_comment.user_id = users.user_id
                 INNER JOIN posts_comment reply_comment ON reply_comment.comment_id = NEW.reply_to
        WHERE posts_comment.comment_id = NEW.comment_id;
    END IF;
END $$
CREATE TRIGGER new_like
    AFTER
        INSERT
    ON posts_like
    FOR EACH ROW
BEGIN
    INSERT INTO notifications(content,
                              is_read,
                              crea_date,
                              target_id,
                              follower_user_id,
                              follower_id,
                              post_id)
    SELECT CONCAT(users.username, ' just liked your post !'),
           false,
           NOW(),
           posts.user_id,
           null,
           null,
           NEW.post_id
    FROM posts_like
             INNER JOIN users ON posts_like.user_id = users.user_id
             INNER JOIN posts ON posts_like.post_id = posts.post_id
    WHERE posts_like.like_id = NEW.like_id;
END $$ DELIMITER ;