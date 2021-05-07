--All posts with pictures
SELECT
     posts.post_id
    ,posts.title
    ,posts.content AS 'description'
    ,pictures.url AS 'url_pic'

FROM posts

INNER JOIN picture pictures ON posts.post_id = pictures.post_id