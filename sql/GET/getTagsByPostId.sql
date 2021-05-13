SELECT
     posts.post_id
    ,posts_tag.tag_id
    ,posts_tag.tag

FROM posts

INNER JOIN posts_tag ON (posts.post_id = posts_tag.post_id)

WHERE posts.post_id = 2