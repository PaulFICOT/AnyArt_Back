--POST LIST QUERY
SELECT
     posts.post_id
    ,users.username
    ,posts.title
    ,posts.content AS 'description'
    ,pictures.url AS 'url_pic'

FROM posts

INNER JOIN picture pictures ON posts.post_id = pictures.post_id
INNER JOIN users ON pictures.user_id = users.user_id