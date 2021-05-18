SELECT
     posts.post_id
    ,posts.title
    ,posts.user_id
    ,users.username
    ,users.is_verified
    ,users.job_function
    ,users.open_to_work
    ,picture.picture_id
    ,picture.url
    ,posts.content
    ,views.view_count
    ,(SELECT COUNT(like_id) FROM posts_like likes
        WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
    ,(SELECT COUNT(like_id) FROM posts_like dislikes
        WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = FALSE) AS 'dislikes'

FROM posts

INNER JOIN users ON (posts.user_id = users.user_id)
INNER JOIN posts_view views ON (posts.post_id = views.post_id)
INNER JOIN picture ON (users.user_id = picture.user_id AND picture.post_id IS NULL)

WHERE
    posts.post_id = 2