DELIMITER $$ CREATE TRIGGER new_post
AFTER
INSERT ON posts FOR EACH ROW BEGIN
INSERT INTO notifications(
        content,
        is_read,
        crea_date,
        target_id,
        follower_id,
        post_id
    )
SELECT CONCAT(users.username, ' a posté de nouvelles photos.'),
    false,
    NOW(),
    users_follower.follower_user_id,
    null,
    NEW.post_id
FROM posts
    INNER JOIN users ON posts.user_id = users.user_id
    INNER JOIN users_follower ON users_follower.followed_user_id = NEW.user_id
WHERE posts.post_id = NEW.post_id;
END $$ CREATE TRIGGER new_follow
AFTER
INSERT ON users_follower FOR EACH ROW BEGIN
INSERT INTO notifications(
        content,
        is_read,
        crea_date,
        target_id,
        follower_id,
        post_id
    )
SELECT CONCAT(users.username, ' vous suit !'),
    false,
    NOW(),
    NEW.follower_user_id,
    NEW.followed_user_id,
    null
FROM users_follower
    INNER JOIN users ON users_follower.followed_user_id = users.user_id
WHERE users_follower.follower_id = NEW.follower_id;
END $$ CREATE TRIGGER new_comment
AFTER
INSERT ON posts_comment FOR EACH ROW BEGIN IF NEW.reply_to IS NULL THEN
INSERT INTO notifications(
        content,
        is_read,
        crea_date,
        target_id,
        follower_id,
        post_id
    )
SELECT CONCAT(
        users.username,
        ' a commenté votre publication !'
    ),
    false,
    NOW(),
    posts.user_id,
    null,
    NEW.post_id
FROM posts_comment
    INNER JOIN users ON posts_comment.user_id = users.user_id
    INNER JOIN posts ON posts_comment.post_id = posts.post_id
WHERE posts_comment.comment_id = NEW.comment_id;
END IF;
END $$ CREATE TRIGGER reply_comment
AFTER
INSERT ON posts_comment FOR EACH ROW BEGIN IF NEW.reply_to IS NOT NULL THEN
INSERT INTO notifications(
        content,
        is_read,
        crea_date,
        target_id,
        follower_id,
        post_id
    )
SELECT CONCAT(
        users.username,
        ' a répondu à votre commentaire !'
    ),
    false,
    NOW(),
    reply_comment.user_id,
    null,
    NEW.post_id
FROM posts_comment
    INNER JOIN users ON posts_comment.user_id = users.user_id
    INNER JOIN posts_comment reply_comment ON reply_comment.comment_id = NEW.reply_to
WHERE posts_comment.comment_id = NEW.comment_id;
END IF;
END $$ CREATE TRIGGER new_like
AFTER
INSERT ON posts_like FOR EACH ROW BEGIN
INSERT INTO notifications(
        content,
        is_read,
        crea_date,
        target_id,
        follower_id,
        post_id
    )
SELECT CONCAT(users.username, ' a liké votre publication !'),
    false,
    NOW(),
    posts.user_id,
    null,
    NEW.post_id
FROM posts_like
    INNER JOIN users ON posts_like.user_id = users.user_id
    INNER JOIN posts ON posts_like.post_id = posts.post_id
WHERE posts_like.like_id = NEW.like_id;
END $$ DELIMITER ;