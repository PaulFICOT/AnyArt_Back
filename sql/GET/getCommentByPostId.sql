SELECT
     posts.post_id
    ,posts_comment.comment_id
    ,posts_comment.crea_date
    ,posts_comment.user_id
    ,posts_comment.reply_to
    ,posts_comment.content
FROM posts

INNER JOIN posts_comment ON (posts.post_id = posts_comment.post_id)

WHERE posts.post_id = 2