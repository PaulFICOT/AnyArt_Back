SELECT
     posts.post_id
    ,users.username
    ,posts.title
    ,pictures.picture_id
    ,pictures.url
FROM posts

INNER JOIN users ON (posts.user_id = users.user_id)
INNER JOIN picture pictures ON (posts.post_id = pictures.post_id) AND (pictures.is_thumbnail = TRUE)