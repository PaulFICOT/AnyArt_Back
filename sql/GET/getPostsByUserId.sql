SELECT
     posts.post_id
    ,posts.title
    ,pictures.url
    ,(SELECT COUNT(like_id) FROM posts_like likes
        WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
    ,views.view_count AS 'views'
    ,posts.crea_date

FROM posts

INNER JOIN posts_view AS views ON (posts.post_id = views.post_id)
INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id AND pictures.is_thumbnail = TRUE)

WHERE posts.user_id = 2;