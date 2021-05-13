SELECT
     posts.post_id
    ,posts.title
    ,posts.user_id
    ,users.username
    ,posts.content
    ,views.view_count
    ,(SELECT COUNT(like_id) FROM posts_like likes
        WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
    ,(SELECT COUNT(like_id) FROM posts_like dislikes
        WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = FALSE) AS 'dislikes'

FROM posts

INNER JOIN users ON (posts.user_id = users.user_id)
INNER JOIN posts_view views ON (posts.post_id = views.post_id)

WHERE
    posts.post_id = 2

GROUP BY
    posts.post_id