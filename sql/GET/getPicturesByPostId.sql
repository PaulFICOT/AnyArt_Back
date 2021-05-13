SELECT
     posts.post_id
    ,pictures.picture_id
    ,pictures.url
FROM posts

INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

WHERE posts.post_id = 2