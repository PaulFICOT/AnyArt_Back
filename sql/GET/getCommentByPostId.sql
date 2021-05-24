SELECT
     posts.post_id
    ,posts_comment.comment_id
    ,posts_comment.crea_date
    ,posts_comment.user_id
    ,users.username
    ,picture.picture_id
    ,picture.url
    ,posts_comment.reply_to
    ,posts_comment.content
FROM posts

INNER JOIN posts_comment ON (posts.post_id = posts_comment.post_id)
INNER JOIN users ON (posts_comment.user_id = users.user_id)
INNER JOIN picture ON (users.user_id = picture.user_id AND picture.post_id IS NULL)

WHERE posts.post_id = 2